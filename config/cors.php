<?php
// portfolio-api/config/cors.php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    | Allows the React frontend (localhost:5173 in dev, Vercel in prod) to
    | call the Laravel API. Adjust 'allowed_origins' for each environment.
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Dev: Vite dev server  |  Prod: replace with your Vercel URL
    'allowed_origins' => [
        'http://localhost:5173',
        'https://YOUR-APP.vercel.app',   // ← update before deploying
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
