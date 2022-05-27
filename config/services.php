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
        'scheme' => 'https',
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
        'client_id' => '389360993093111',
        'client_secret' => 'e8258dc6f5294434c14657b2d96d3c6a',
        'redirect' => 'http://127.0.0.1:8000/facebook/callback',
    ],

    'google' => [
        'client_id' => '699283675625-q2mbi8n26efnlgntkh7oblc50lou9ck0.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost:8000/google/callbackGG',
    ],



];
