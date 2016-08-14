<?php

namespace NotificationChannels\Jusibe;

use DomainException;
use Unicodeveloper\Jusibe\Jusibe as JusibeClient;
use Illuminate\Notifications\Notification;
use NotificationChannels\Jusibe\Events\SendingMessage;
use NotificationChannels\Jusibe\Events\MessageWasSent;
use NotificationChannels\Jusibe\Exceptions\CouldNotSendNotification;

class JusibeChannel
{
    /**
     * The Jusibe client instance.
     *
     * @var \Jusibe\Jusibe
     */
    protected $jusibe;

    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * Create a new Jusibe channel instance.
     *
     * @param  \Jusibe\Jusibe  $jusibe
     * @param  string  $from
     * @return void
     */
    public function __construct(JusibeClient $jusibe)
    {
        $this->jusibe = $jusibe;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('jusibe')) {
            throw CouldNotSendNotification::missingTo();
        }

        $message = $notification->toJusibe($notifiable);

        if (is_string($message)) {
            $message = new JusibeMessage($message);
        }

        if (! $from = $message->from ?: config('services.jusibe.sms_from')) {
            throw CouldNotSendNotification::missingFrom();
        }

        try {
            $response = $this->jusibe->sendSMS([
                'to' => $to,
                'from' => $from,
                'message' => trim($message->content)
            ])->getResponse();

            return $response;
        } catch(DomainException $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}

