<?php

return [

    // 'default' => env('PAYMENTS_TYPE', 'ngenius'),

    'types' => [
        'cash-in-hand' => [
            'driver' => 'offline',
            'authorized' => 'payment-offline',
        ],
        'card' => [
            'driver' => 'stripe',
            'released' => 'payment-received',
        ],
        'ngenius' => [
            'driver' => 'ngenius',
            'base_uri' => env('NGENIUS_BASE_URI'),
            'api_key' => env('NGENIUS_API_KEY'),
            'sdk_key' => env('NGENIUS_SDK_API_KEY'),
            'outlet_ref' => env('NGENIUS_OUTLET_REF'),
        ],
    ],

];
