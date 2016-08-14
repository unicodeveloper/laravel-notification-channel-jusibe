<?php

namespace NotificationChannels\Jusibe;

use Illuminate\Notifications\Notification;
use NotificationChannels\Jusibe\Events\SendingMessage;
use NotificationChannels\Jusibe\Events\MessageWasSent;
use NotificationChannels\Jusibe\Exceptions\CouldNotSendNotification;

class JusibeChannel
{

    public function __construct()
    {
        // Initialisation code here
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\:channel_namespace\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $shouldSendMessage = event(new SendingMessage($notifiable, $notification), [], true) !== false;

        if (! $shouldSendMessage) {
            return;
        }

        //$response = [a call to the api of your notification send]

//        if ($response->error) { // replace this by the code need to check for errors
//            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
//        }

        event(new MessageWasSent($notifiable, $notification));
    }
}
