<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 7/2/2019
 * Time: 5:35 PM.
 */

namespace Mocean\Notification\Tests\Dummy;

use Illuminate\Notifications\Notifiable;

class DummyNotifiable
{
    use Notifiable;

    public function routeNotificationForMoceanSms($notification = null)
    {
        return '60123456789';
    }
}
