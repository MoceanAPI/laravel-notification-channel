Mocean Laravel Notification
===========================
[![Latest Stable Version](https://img.shields.io/packagist/v/mocean/laravel-notification-channel.svg)](https://packagist.org/packages/mocean/laravel-notification-channel)
[![Build Status](https://img.shields.io/travis/com/MoceanAPI/laravel-notification-channel.svg)](https://travis-ci.com/MoceanAPI/laravel-notification-channel)
[![License](https://img.shields.io/packagist/l/mocean/laravel-notification-channel.svg)](https://packagist.org/packages/mocean/laravel-notification-channel)
[![Total Downloads](https://img.shields.io/packagist/dt/mocean/laravel-notification-channel.svg)](https://packagist.org/packages/mocean/laravel-notification-channel)

## Installation

To install the library, run this command in terminal:
```bash
composer require mocean/laravel-notification-channel
```

### Laravel 5.5

You don't have to do anything else, this package autoloads the Service Provider and create the Alias, using the new Auto-Discovery feature.

### Laravel 5.4 and below

Add the Service Provider and Facade alias to your `config/app.php`

```php
'providers' => [
    Mocean\Notification\MoceanChannelServiceProvider::class,
]
```

## Usage

You must publish the config file as this will use [Laravel Mocean](https://github.com/MoceanAPI/laravel-mocean) as a package.

```bash
php artisan vendor:publish --provider="Mocean\Laravel\MoceanServiceProvider"
```

Create a notification class, refer [laravel official docs](https://laravel.com/docs/notifications#creating-notifications)

```php
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    use Queueable;
    
    public function via($notifiable)
    {
        //define mocean-sms as notification channel
        return ['mocean-sms'];
    }
    
    public function toMoceanSms($notifiable)
    {
        //return the text message u want to send here
        return 'You have received an invoice';
        
        //you can also return an array for custom options, refer moceanapi docs
        return [
            'mocean-text' => 'You have received an invoice',
            'mocean-dlr-url' => 'http://test.com'
        ];
    }
}
```

to specify which attribute should be used to be a notifiable entity, create method `routeNotificationForMoceanSms`

```php

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    public function routeNotificationForMoceanSms($notification)
    {
        //make sure user model has this attribute, else the notification will not be sent
        return $this->phone;
    }
}
```

send the notification to a user

```php
$user->notify(new InvoicePaid());
```

you can also send the notification to a custom phone number without using user model

```php
use Notification;

Notification:route('mocean-sms', '60123456789')
    ->notify(new InvoicePaid());
```

## License

Mocean Laravel Notification is licensed under the [MIT License](LICENSE)
