<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('SOS_MAILGUN_DOMAIN'),
        'secret' => env('SOS_MAILGUN_SECRET'),
        'endpoint' => env('SOS_MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('SOS_POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('SOS_AWS_ACCESS_KEY_ID'),
        'secret' => env('SOS_AWS_SECRET_ACCESS_KEY'),
        'region' => env('SOS_AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SOS_SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('SOS_STRIPE_KEY'),
        'secret' => env('SOS_STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('SOS_STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('SOS_STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

];
