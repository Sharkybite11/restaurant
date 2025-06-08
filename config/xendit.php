<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Xendit API Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Xendit API settings. You can get your API keys
    | from the Xendit dashboard.
    |
    */

    'api_key' => env('XENDIT_API_KEY'),
    'callback_token' => env('XENDIT_CALLBACK_TOKEN'),
    'public_key' => env('XENDIT_PUBLIC_KEY'),
    
    /*
    |--------------------------------------------------------------------------
    | Xendit Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your Xendit integration is running
    | in. This may determine how you interact with the Xendit API.
    |
    */

    'environment' => env('XENDIT_ENVIRONMENT', 'production'),
]; 