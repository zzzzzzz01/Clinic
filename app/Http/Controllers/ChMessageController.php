<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nurse;
use App\Models\ChMessage;
use Illuminate\Http\Request;

class ChMessageController extends Controller
{
    public function index()
    {
        $authId = auth()->id();

        // 🔹 1. Hamma userlar (o‘zimdan tashqari)
        $users = User::where('id', '!=', $authId)->get();

        // 🔹 2. Menga tegishli chat qilgan user ID lar
        $chatUserIds = ChMessage::where('from_id', $authId)
            ->orWhere('to_id', $authId)
            ->get()
            ->map(function ($message) use ($authId) {
                return $message->from_id == $authId
                    ? $message->to_id
                    : $message->from_id;
            })
            ->unique()
            ->values();

        // 🔹 3. Menga yozishgan userlar
        $myChats = User::whereIn('id', $chatUserIds)->get();

        return view('dashboard.chat.index', compact('users', 'myChats'));
    }

    // 🔹 Xabar yuborish
    public function send(Request $request)
    {
        $request->validate([
            'to_id'   => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        ChMessage::create([
            'from_id' => auth()->id(),
            'to_id'   => $request->to_id,
            'message' => $request->message,
        ]);

        return response()->json([
            'status' => true
        ]);
    }

    // 🔹 Ajax orqali chat message olish
    public function messages($userId)
    {
        $messages = ChMessage::where(function ($q) use ($userId) {
                $q->where('from_id', auth()->id())
                  ->where('to_id', $userId);
            })
            ->orWhere(function ($q) use ($userId) {
                $q->where('from_id', $userId)
                  ->where('to_id', auth()->id());
            })
            ->orderBy('created_at')
            ->get();

        // O‘qilmaganlarni o‘qilgan qilish
        ChMessage::where('from_id', $userId)
            ->where('to_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }
}
