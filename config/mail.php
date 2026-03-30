<?php
// portfolio-api/config/mail.php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    | Set to 'smtp' for Gmail / any SMTP server.
    | Set to 'log'  to write emails to storage/logs/laravel.log (no real send).
    */
    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    */
    'mailers' => [

        'smtp' => [
            'transport'  => 'smtp',
            'url'        => env('MAIL_URL'),
            'host'       => env('MAIL_HOST', 'smtp.gmail.com'),
            'port'       => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username'   => env('MAIL_USERNAME'),
            'password'   => env('MAIL_PASSWORD'),
            'timeout'    => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],

        'log' => [
            'transport' => 'log',
            'channel'   => env('MAIL_LOG_CHANNEL', 'stack'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers'   => ['smtp', 'log'],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    | The "from" address shown to people who receive Val's auto-reply.
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'noreply@val-portfolio.dev'),
        'name'    => env('MAIL_FROM_NAME', 'ValOS Portfolio'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Portfolio Recipient — Val's email
    |--------------------------------------------------------------------------
    | This is where contact form notifications are sent TO.
    | Defaults to Val's real email; override in .env if needed.
    */
    'portfolio_recipient' => env('MAIL_PORTFOLIO_RECIPIENT', 'abilovalkrystoper@gmail.com'),

];
