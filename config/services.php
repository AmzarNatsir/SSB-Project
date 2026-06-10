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

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'workshop' => [
        'api_url' => env('API_WORKSHOP', 'http://localhost:8000/api/'),
        'api_token' => env('WORKSHOP_API_TOKEN'),
        'cache_ttl' => env('WORKSHOP_API_CACHE_TTL', 120), // seconds
    ],

    'employee' => [
        'api_url' => env('API_EMPLOYEE'),
        'api_token' => env('TOKEN_EMPLOYEE'),
        'cache_ttl' => env('EMPLOYEE_API_CACHE_TTL', 300), // seconds
        'timeout' => env('EMPLOYEE_API_TIMEOUT', 20),       // seconds
    ],

    // SSO Identity Provider (HRD / ssb-project via Laravel Passport)
    'ssb-idp' => [
        'client_id'     => env('SSB_CLIENT_ID'),
        'client_secret' => env('SSB_CLIENT_SECRET'),
        'redirect'      => env('SSB_REDIRECT_URI'),
        'base_url'      => env('SSB_BASE_URL'),
    ],

];
