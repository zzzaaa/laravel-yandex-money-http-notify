### Laravel Yandex Money Http Notification
This packages helps to validate yandexMoney http notification.
Laravel Middleware stay front of your API and allow yandex notification what you can trust.


##Install

``` bash
composer require zzzaaa/laravel-yandex-money-http-notify
```

##install Middleware

```php
// app/Http/Kernel.php
    protected $routeMiddleware = [
    ...
        'yandexmoney.hash' => \Zzzaaa\LaravelYandexMoneyHttpNotify\Middleware\YandexMoneyHash::class,
    ];
```

##Add secret key
```php
//config/services.php
...
    'yandex' => [
        'notification_secret' => env('YANDEX_SECRET','SECRET KEY')
    ],
```

## Add middleware to routes

```php

//routes/api.php
Route::post('/payment', 'Api\PaymentsController@store')->middleware('yandexmoney.hash');


```