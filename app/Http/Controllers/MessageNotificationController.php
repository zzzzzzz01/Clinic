<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nurse;
use App\Models\Doctor;
use Illuminate\Notifications\DatabaseNotification;
use App\Notifications\MessageNotification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class MessageNotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function send(Request $request, Nurse $nurse)
    {
        // dd($request, $nurse->id, $nurse->user->id);
        $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'send_time'   => 'required|date',
        ]);

        $user = $nurse->user;

        $user->notify(new MessageNotification(
            $request->title,
            $request->description,
            auth()->id()
        ));

        return back()->with('success', 'Xabar yuborildi');
    }

    public function sendDoctor(Request $request, Doctor $doctor)
    {
        $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'send_time'   => 'required|date',
        ]);

        $user = $doctor->user;

        $user->notify(new MessageNotification(
            $request->title,
            $request->description,
            auth()->id()
        ));

        return back()->with('success', 'Xabar yuborildi');
    }

    public function notificationPage()
    {
        $data = $this->notificationService->getNotificationsPage();
        return view('dashboard.notifications.index', $data);
    }

    public function destroy(DatabaseNotification $notification)
    {
        if ($notification->notifiable_id !== auth()->id()) {
            abort(403);
        }
            
        $notification->delete();
        
        return back()->with('success', 'Xabar muvaffaqiyatli o\'chirildi');
    }
    
    public function markAsRead(DatabaseNotification $notification)
    {
        if ($notification->notifiable_id !== auth()->id()) {
            abort(403);
        }
    
        $notification->markAsRead();
    
        return back()->with('success', 'Xabar o\'qildi deb belgilandi');
    }
    
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    
        return back()->with('success', 'Barcha xabarlar o\'qilgan deb belgilandi');
    }

    public function filterNotifications(Request $request)
    {
        try {
            $query = auth()->user()->notifications();
            
            // Holati bo'yicha filter
            if ($request->status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($request->status === 'read') {
                $query->whereNotNull('read_at');
            }
            
            // Turi bo'yicha filter
            if ($request->type && $request->type !== 'all') {
                $query->where('data->priority', $request->type);
            }
            
            // Sana bo'yicha filter
            if ($request->date === 'today') {
                $query->whereDate('created_at', today());
            } elseif ($request->date === 'week') {
                $query->whereDate('created_at', '>=', now()->subDays(7));
            } elseif ($request->date === 'month') {
                $query->whereDate('created_at', '>=', now()->subDays(30));
            }
            
            // Sana oralig'i bo'yicha filter
            if ($request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            // Qidiruv
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('data->title', 'like', '%' . $request->search . '%')
                      ->orWhere('data->message', 'like', '%' . $request->search . '%');
                });
            }
            
            $notifications = $query->latest()->paginate(10);
            
            // Statistikalar
            $totalCount = auth()->user()->notifications()->count();
            $unreadCount = auth()->user()->unreadNotifications()->count();
            $importantCount = auth()->user()->notifications()->where('data->priority', 'important')->count();
            $urgentCount = auth()->user()->notifications()->where('data->priority', 'urgent')->count();
            
            $html = view('notifications.partials.list', compact('notifications'))->render();
            $pagination = view('notifications.partials.pagination', compact('notifications'))->render();
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination,
                'totalCount' => $totalCount,
                'unreadCount' => $unreadCount,
                'importantCount' => $importantCount,
                'urgentCount' => $urgentCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ], 500);
        }
    }
}