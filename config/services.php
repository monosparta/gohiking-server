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
    'facebook' => [
        'client_id' => '1398297947184863',
        'client_secret' => '035fb8f995284316ecba65faa5ae7025',
        'redirect' => 'http://localhost:8000/auth/facebook/callback',
    ],
    'google' => [
        'client_id' => '860071321822-g7pji1pajug2f78a3pmpq3gj3b1drfhe.apps.googleusercontent.com',
        'client_secret' => 'nSs1Y0EwFFa9X_RchmoZHwhR',
        'redirect' => 'http://localhost:8000/auth/google/callback',
    ],

];
