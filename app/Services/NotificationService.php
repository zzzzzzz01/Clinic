<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class NotificationService
{
    private $cacheKey = 'notifications_user_';
    private $cacheTime = 3600; // 1 soat

    public function getNotificationsPage()
    {
        $user = Auth::user();
        $userId = $user->id;
        $cacheKey = $this->cacheKey . $userId;

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($user) {
            return $this->fetchNotificationsData($user);
        });
    }

    private function fetchNotificationsData($user)
    {
        $notifications = $user->notifications()->latest()->paginate(10);
        $totalCount = $user->notifications()->count();
        $unreadCount = $user->unreadNotifications()->count();
        $importantCount = $user->notifications()->where('data->priority', 'important')->count();
        $urgentCount = $user->notifications()->where('data->priority', 'urgent')->count();
        
        foreach ($notifications as $notification) {
            $data = $notification->data;
            $priority = $data['priority'] ?? 'info';
            
            $notification->bgColor = $this->getBgColor($priority);
            $notification->senderInitials = substr($data['sender'] ?? 'SYS', 0, 2);
            $notification->displayTitle = $data['title'] ?? 'Xabar';
            $notification->displayMessage = $data['message'] ?? '';
            $notification->timeAgo = $notification->created_at->diffForHumans();
            $notification->typeClass = $this->getTypeClass($priority);
            $notification->typeText = $this->getTypeText($priority);
        }
        
        return [
            'notifications' => $notifications,
            'totalCount' => $totalCount,
            'unreadCount' => $unreadCount,
            'importantCount' => $importantCount,
            'urgentCount' => $urgentCount,
        ];
    }

    private function clearCache($userId = null)
    {
        if ($userId) {
            Cache::forget($this->cacheKey . $userId);
        } else {
            $user = Auth::user();
            if ($user) {
                Cache::forget($this->cacheKey . $user->id);
            }
        }
    }

    private function getBgColor($priority)
    {
        $map = [
            'urgent' => '#e74c3c',
            'warning' => '#f39c12',
            'system' => '#17a2b8',
            'important' => '#8e44ad',
            'info' => '#00BFFF'
        ];
        return $map[$priority] ?? '#00BFFF';
    }

    private function getTypeClass($priority)
    {
        $map = [
            'urgent' => 'type-urgent',
            'warning' => 'type-warning',
            'system' => 'type-system',
            'important' => 'type-important',
            'info' => 'type-info'
        ];
        return $map[$priority] ?? 'type-info';
    }

    private function getTypeText($priority)
    {
        $map = [
            'urgent' => 'Shoshilinch',
            'warning' => 'Ogohlantirish',
            'system' => 'Tizim',
            'important' => 'Muhim',
            'info' => 'Ma\'lumot'
        ];
        return $map[$priority] ?? 'Ma\'lumot';
    }
}