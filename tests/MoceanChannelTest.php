<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 7/2/2019
 * Time: 5:27 PM.
 */

namespace Mocean\Notification\Tests;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;
use Mocean\Notification\Channels\SmsChannel;
use Mocean\Notification\Tests\Dummy\DummyNotifiable;
use Mocean\Notification\Tests\Dummy\DummyNotificationClass;
use Mocean\Notification\Tests\Dummy\DummyCustomNotificationClass;

class MoceanChannelTest extends TestCase
{
    public function testSmsSentViaMoceanChannel()
    {
        $notification = new DummyNotificationClass();
        $notifiable = new DummyNotifiable();

        $mockMocean = $this->prophesize('Mocean\Notification\Tests\Dummy\MockMoceanClient');
        $mockMessageClient = $this->prophesize('Mocean\Message\Client');

        $channel = new SmsChannel($mockMocean->reveal());

        $mockMessageClient->send(Argument::that(function ($params) {
            $this->assertEquals($params['mocean-from'], 'Mocean');
            $this->assertEquals($params['mocean-to'], '60123456789');
            $this->assertEquals($params['mocean-text'], 'testing message');

            return true;
        }))->shouldBeCalledTimes(1)->willReturn(null);
        $mockMocean->message()->shouldBeCalledTimes(1)->willReturn($mockMessageClient->reveal());

        $channel->send($notifiable, $notification);
    }

    public function testSmsSentViaMoceanChannelWithCustomConfiguration()
    {
        $notification = new DummyCustomNotificationClass();
        $notifiable = new DummyNotifiable();

        $mockMocean = $this->prophesize('Mocean\Notification\Tests\Dummy\MockMoceanClient');
        $mockMessageClient = $this->prophesize('Mocean\Message\Client');

        $channel = new SmsChannel($mockMocean->reveal());

        $mockMessageClient->send(Argument::that(function ($params) {
            $this->assertEquals($params['mocean-from'], 'Mocean');
            $this->assertEquals($params['mocean-to'], '60123456789');
            $this->assertEquals($params['mocean-text'], 'Hello World');
            $this->assertEquals($params['mocean-dlr-url'], 'http://test.com');

            return true;
        }))->shouldBeCalledTimes(1)->willReturn(null);
        $mockMocean->message()->shouldBeCalledTimes(1)->willReturn($mockMessageClient->reveal());

        $channel->send($notifiable, $notification);
    }
}
