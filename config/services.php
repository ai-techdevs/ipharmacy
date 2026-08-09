<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // 'square' => [
    //     'environment'  => env('SQUARE_ENVIRONMENT', 'sandbox'),
    //     'app_id'       => env('SQUARE_APP_ID'),
    //     'access_token' => env('SQUARE_TOKEN'),
    //     'location_id'  => env('SQUARE_LOCATION_ID'),
    // ],

    'square' => [
        'token'       => env('SQUARE_TOKEN'),
        'app_id'       => env('SQUARE_APP_ID'),
        'environment' => env('SQUARE_ENV', 'sandbox'),
        'location_id'  => env('SQUARE_LOCATION_ID'),
    ],
    
    'recaptcha_v3' => [
    'site_key'    => env('RECAPTCHA_SITE_KEY'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY'),
],

];
