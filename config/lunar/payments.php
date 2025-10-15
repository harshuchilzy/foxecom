<?php

return [

    // 'default' => env('PAYMENTS_TYPE', 'ngenius'),

    'types' => [
        'cash-in-hand' => [
            'driver' => 'offline',
            'authorized' => 'payment-offline',
        ],
        'pay-via-bank' => [
            'driver' => 'offline',
            'authorized' => 'payment-offline',
        ],
        'card' => [
            'driver' => 'stripe',
            'released' => 'payment-received',
        ],
        'worldpay' => [
            'driver' => 'worldpay',
            'base_url' => env('WORLDPAY_HPP_BASE_URL'),
            'api_key' => env('WORLDPAY_HPP_API_KEY'),
            'username' => env('WORLDPAY_HPP_USERNAME'),
            'password' => env('WORLDPAY_HPP_PASSWORD'),
            'accept_header' => env('WORLDPAY_HPP_ACCEPT_HEADER'),
            'content_type_header' => env('WORLDPAY_HPP_CONTENT_TYPE_HEADER'),
            'merchant_entity' => env('WORLDPAY_HPP_MERCHANT_ENTITY'),
            'webhook_secret' => env('WORLDPAY_HPP_WEBHOOK_SECRET'),
            'webhook_secrets' => env('WORLDPAY_HPP_WEBHOOK_SECRETS')
        ],
    ],

];
