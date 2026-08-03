<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MessageNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $senderId;

    /**
     * Controller'dan keladigan ma'lumotlar
     */
    public function __construct($title, $message, $senderId)
    {
        $this->title    = $title;
        $this->message = $message;
        $this->senderId = $senderId;
    }

    /**
     * Qaysi kanal orqali yuboriladi
     */
    public function via(object $notifiable): array
    {
        return ['database']; 
    }

    /**
     * DATABASE ga yoziladigan data
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title'     => $this->title, 
            'message'   => $this->message,
            'sender_id' => $this->senderId,
        ];
    }
}
