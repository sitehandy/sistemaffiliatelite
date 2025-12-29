<?php
/**
 * Configuration File for Landing Pages (EXAMPLE)
 *
 * Copy this file to config.php and update with your actual API keys.
 * Command: cp config.example.php config.php
 *
 * IMPORTANT: Keep config.php secure and never commit it to version control.
 */

return [
    // ============================================
    // Cloudflare Turnstile Settings
    // Get your keys from: https://dash.cloudflare.com/turnstile
    // ============================================
    'turnstile' => [
        'site_key' => 'YOUR_TURNSTILE_SITE_KEY',     // Used in HTML (public)
        'secret_key' => 'YOUR_TURNSTILE_SECRET_KEY', // Used in PHP (private)
    ],

    // ============================================
    // Verimail API Settings
    // API for email verification
    // ============================================
    'verimail' => [
        'api_url' => 'https://verimail.sitehandy.com/api/verify.php',
        'api_key' => 'YOUR_VERIMAIL_API_KEY',
    ],

    // ============================================
    // MailWizz Email Marketing Settings
    // API for subscriber management
    // ============================================
    'mailwizz' => [
        'api_url' => 'https://your-mailwizz.com/api',    // Your MailWizz API URL
        'api_key' => 'YOUR_MAILWIZZ_API_KEY',
        'list_uid' => 'YOUR_MAILWIZZ_LIST_UID',          // Target list unique identifier

        // Field mapping - customize based on your MailWizz list custom fields
        'fields' => [
            'email' => 'EMAIL',  // Required
            'name' => 'FNAME',   // First name field
            'phone' => 'PHONE',  // Phone field (if configured in your list)
        ],
    ],

    // ============================================
    // General Settings
    // ============================================
    'general' => [
        'debug' => false, // Set to true to enable detailed error logging
    ],
];
