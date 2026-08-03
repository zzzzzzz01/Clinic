<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'post_id' => 'required|exists:posts,id',
                'message' => 'required|string|max:1000',
            ]);

            Comment::create($validated);

            return redirect()->back()->with('success', 'Izoh muvaffaqiyatli qo\'shildi.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Izoh qo\'shishda xatolik yuz berdi.');
        }
    }
}
