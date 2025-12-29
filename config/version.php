<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | This value is the current version of your application. This value is
    | used when the application needs to display its version or when
    | checking for updates.
    |
    */
    'current' => '1.1.0',

    /*
    |--------------------------------------------------------------------------
    | Version History
    |--------------------------------------------------------------------------
    |
    | This array contains the version history with release dates and
    | descriptions of changes made in each version.
    |
    */
    'history' => [
        '1.0.0' => [
            'date' => '2025-12-12',
            'description' => 'Initial release',
            'changes' => [
                'Core affiliate management system',
                'Program management',
                'Commission tracking',
                'Payout system',
                'Web installer',
            ],
        ],
        '1.1.0' => [
            'date' => '2025-12-29',
            'description' => 'Database improvements and enrollment suspension',
            'changes' => [
                'Converted ENUM columns to VARCHAR for better compatibility',
                'Added enrollment suspension feature',
                'Added Spatie Permission support',
                'Improved database migration system',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Minimum PHP Version
    |--------------------------------------------------------------------------
    */
    'minimum_php' => '8.2.0',

    /*
    |--------------------------------------------------------------------------
    | Required Extensions
    |--------------------------------------------------------------------------
    */
    'required_extensions' => [
        'pdo',
        'pdo_mysql',
        'mbstring',
        'openssl',
        'tokenizer',
        'json',
        'curl',
    ],
];
