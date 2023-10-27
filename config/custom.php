<?php

return [

    'mail' => [
        'exception_notification_mail' => env('EXCEPTION_NOTIFICATION_MAIL')
    ],

    'payment' => [
        'currency' => env('PAYMENT_CURRENCY'),
        'currency_symbol' => env('PAYMENT_CURRENCY_SYMBOL')
    ]

];
