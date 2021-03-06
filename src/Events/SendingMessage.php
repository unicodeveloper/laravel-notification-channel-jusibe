<?php

namespace NotificationChannels\Jusibe\Events;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class SendingMessage
{
    /**
     * @var Notifiable
     */
    protected $notifiable;

    /**
     * @var Notification
     */
    protected $notification;

    /**
     * @param Notifiable $notifiable
     * @param Notification $notification
     */
    public function __construct($notifiable, Notification $notification)
    {
        $this->notifiable = $notifiable;

        $this->notification = $notification;
    }
}
