<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 7/3/2019
 * Time: 9:27 AM.
 */

namespace Mocean\Notification\Tests\Dummy;


use Mocean\Laravel\Manager;

class MockMoceanClient extends Manager
{
    public function message()
    {
        return parent::message();
    }
}
