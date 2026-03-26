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


    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],


    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI'),
    ],

    'zegochat' => [
        'app_id' => env('ZEGO_CHAT_APP_ID'),
        'server_secret' => env('ZEGO_CHAT_SERVER_SECRET'),
    ],


    'zegocloud' => [
        'app_id' => env('ZEGO_APP_ID'),
        'server_secret' => env('ZEGO_SERVER_SECRET'),
        // AWS-S3:  
        'aws_key' => env('ZEGO_AWS_ACCESS_KEY'),
        'aws_secret' => env('ZEGO_AWS_SECRET_KEY'),
        's3_bucket' => env('ZEGO_AWS_S3_BUCKET'),
        's3_region' => env('ZEGO_AWS_S3_REGION'),
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'currency' => env('STRIPE_CURRENCY'),
    ],

    'keycloak' => [
        'base_url' => env('KEYCLOAK_URL'),
        'realm' => env('KEYCLOAK_REALM'),
        'client_id' => env('KEYCLOAK_CLIENT_ID'),
        'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
        'redirect' => env('KEYCLOAK_REDIRECT_URI'),
        'admin_client' => env('KEYCLOAK_ADMIN_CLIENT'),
        'admin_secret' => env('KEYCLOAK_ADMIN_SECRET'),              
    ],

];
