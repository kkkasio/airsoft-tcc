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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        'client_id' => '723727471398-eoc52slskuj5hh9k38h3q5pudbih17bl.apps.googleusercontent.com',
        'client_secret' => 'BSNC2Qru-OFpb5m4P6kw_jFZ',
        'redirect' => 'http://127.0.0.1:8000/auth/google/callback',
    ],
    'github' => [
        'client_id' => 'a32176b32d0e05a466db',
        'client_secret' => '8f9ec3f14510539c5c1628dee09c2836a8575c82',
        'redirect' => 'http://127.0.0.1:8000/auth/github/callback',
    ]
];
