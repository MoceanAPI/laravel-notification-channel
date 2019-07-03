<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 7/2/2019
 * Time: 5:34 PM.
 */

namespace Mocean\Notification\Tests\Dummy;

use Illuminate\Notifications\Notification;

class DummyNotificationClass extends Notification
{
    public function toMoceanSms($notifiable)
    {
        return 'testing message';
    }
}
