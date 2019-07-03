<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 7/2/2019
 * Time: 4:42 PM.
 */

namespace Mocean\Notification\Channels;

use Illuminate\Notifications\Notification;
use Mocean\Laravel\Manager as MoceanClient;

class SmsChannel
{
    protected $mocean;

    public function __construct(MoceanClient $mocean)
    {
        $this->mocean = $mocean;
    }

    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('mocean-sms', $notification)) {
            return;
        }

        $message = $notification->toMoceanSms($notifiable);

        if (is_string($message)) {
            $message = [
                'mocean-from' => 'Mocean',
                'mocean-to' => $to,
                'mocean-text' => $message,
            ];
        }

        $message = array_merge($message, [
            'mocean-to' => $to,
        ]);

        if (! isset($message['mocean-from'])) {
            $message['mocean-from'] = 'Mocean';
        }

        return $this->mocean->message()->send($message);
    }
}
