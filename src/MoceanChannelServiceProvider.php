<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 7/2/2019
 * Time: 4:35 PM.
 */

namespace Mocean\Notification;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Mocean\Notification\Channels\SmsChannel;

class MoceanChannelServiceProvider extends ServiceProvider
{
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('mocean-sms', function ($app) {
                return new SmsChannel($app['mocean']);
            });
        });
    }
}
