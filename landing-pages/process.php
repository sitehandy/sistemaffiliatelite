<?php
/**
 * Opt-in Form Processor
 *
 * This file processes the opt-in form submission:
 * 1. Verifies Cloudflare Turnstile captcha
 * 2. Verifies email using Verimail API
 * 3. Creates subscriber in MailWizz email marketing service
 */

// ============================================
// LOAD CONFIGURATION
// ============================================
$config = require __DIR__ . '/config.php';

// Define constants from config
define('TURNSTILE_SECRET_KEY', $config['turnstile']['secret_key']);
define('VERIMAIL_API_KEY', $config['verimail']['api_key']);
define('VERIMAIL_API_URL', $config['verimail']['api_url']);

define('MAILWIZZ_API_URL', $config['mailwizz']['api_url']);
define('MAILWIZZ_API_KEY', $config['mailwizz']['api_key']);
define('MAILWIZZ_LIST_UID', $config['mailwizz']['list_uid']);

define('DEBUG_MODE', $config['general']['debug'] ?? false);

// ============================================
// HELPER FUNCTIONS
// ============================================

/**
 * Send JSON response and exit
 */
function jsonResponse($success, $message, $data = []) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge([
        'success' => $success,
        'message' => $message
    ], $data));
    exit;
}

/**
 * Verify Cloudflare Turnstile token
 */
function verifyTurnstile($token, $remoteIp) {
    $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    $data = [
        'secret' => TURNSTILE_SECRET_KEY,
        'response' => $token,
        'remoteip' => $remoteIp
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return ['success' => false, 'error' => 'Turnstile verification failed'];
    }

    $result = json_decode($response, true);
    return $result;
}

/**
 * Verify email using Verimail API
 */
function verifyEmail($email) {
    $ch = curl_init(VERIMAIL_API_URL);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'X-API-Key: ' . VERIMAIL_API_KEY
        ],
        CURLOPT_POSTFIELDS => json_encode(['email' => $email]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return [
            'success' => false,
            'error' => 'Email verification service unavailable',
            'deliverable' => null
        ];
    }

    if ($httpCode !== 200) {
        $result = json_decode($response, true);
        return [
            'success' => false,
            'error' => $result['error']['message'] ?? 'Email verification failed',
            'deliverable' => false
        ];
    }

    $result = json_decode($response, true);

    return [
        'success' => $result['success'] ?? false,
        'deliverable' => $result['data']['deliverable'] ?? false,
        'is_disposable' => $result['data']['is_disposable'] ?? false,
        'status' => $result['data']['status'] ?? 'unknown',
        'suggestion' => $result['data']['suggestion'] ?? null,
        'reject_reason' => $result['data']['reject_reason'] ?? null,
        'reject_message' => $result['data']['reject_message'] ?? null
    ];
}

/**
 * Create subscriber in MailWizz
 */
function createMailWizzSubscriber($email, $name, $phone, $countryCode) {
    $apiUrl = rtrim(MAILWIZZ_API_URL, '/') . '/lists/' . MAILWIZZ_LIST_UID . '/subscribers';

    // Prepare subscriber data
    // Adjust field names according to your MailWizz list configuration
    // Remove "+" from country code - send digits only (e.g., 60123456789)
    $cleanCountryCode = ltrim($countryCode, '+');
    $fullPhone = $cleanCountryCode . $phone;

    // Build form data - MailWizz API expects direct field names (not wrapped in data[])
    $postData = http_build_query([
        'EMAIL' => $email,
        'FNAME' => $name,
        'PHONE' => $fullPhone
    ]);

    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'X-Api-Key: ' . MAILWIZZ_API_KEY
        ],
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        error_log("MailWizz cURL Error: " . $error);
        return [
            'success' => false,
            'error' => 'Failed to connect to email marketing service'
        ];
    }

    $result = json_decode($response, true);

    // MailWizz returns status: success on successful creation
    if (isset($result['status']) && $result['status'] === 'success') {
        return [
            'success' => true,
            'subscriber_uid' => $result['data']['record']['subscriber_uid'] ?? null
        ];
    }

    // Handle duplicate subscriber (usually HTTP 409 or error message)
    if (isset($result['error']) && stripos($result['error'], 'already exists') !== false) {
        return [
            'success' => true, // Consider duplicate as success
            'duplicate' => true
        ];
    }

    return [
        'success' => false,
        'error' => $result['error'] ?? 'Failed to create subscriber'
    ];
}

/**
 * Sanitize input string
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email format
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number
 */
function isValidPhone($phone) {
    // Remove spaces and dashes
    $cleanPhone = preg_replace('/[\s\-]/', '', $phone);
    // Check if it's 7-15 digits
    return preg_match('/^[0-9]{7,15}$/', $cleanPhone);
}

// ============================================
// MAIN PROCESSING
// ============================================

// Set headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Kaedah permintaan tidak sah.');
}

// Get JSON input
$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);

if (!$input) {
    jsonResponse(false, 'Data tidak sah.');
}

// Extract and sanitize input
$name = sanitizeInput($input['name'] ?? '');
$email = sanitizeInput($input['email'] ?? '');
$phone = sanitizeInput($input['phone'] ?? '');
$countryCode = sanitizeInput($input['country_code'] ?? '+60');
$turnstileToken = $input['cf_turnstile_response'] ?? '';

// ============================================
// VALIDATION
// ============================================

// Validate email
if (empty($email)) {
    jsonResponse(false, 'Sila masukkan alamat emel.');
}

if (!isValidEmail($email)) {
    jsonResponse(false, 'Format emel tidak sah.');
}

// Validate phone
if (empty($phone)) {
    jsonResponse(false, 'Sila masukkan nombor telefon.');
}

if (!isValidPhone($phone)) {
    jsonResponse(false, 'Format nombor telefon tidak sah.');
}

// Validate Turnstile token
if (empty($turnstileToken)) {
    jsonResponse(false, 'Sila lengkapkan pengesahan CAPTCHA.');
}

// ============================================
// STEP 1: Verify Cloudflare Turnstile
// ============================================

$remoteIp = $_SERVER['REMOTE_ADDR'] ?? '';
$turnstileResult = verifyTurnstile($turnstileToken, $remoteIp);

if (!$turnstileResult['success']) {
    jsonResponse(false, 'Pengesahan CAPTCHA gagal. Sila cuba lagi.');
}

// ============================================
// STEP 2: Verify Email using Verimail API
// ============================================

$emailVerification = verifyEmail($email);

// Check if email is disposable/fake
if ($emailVerification['is_disposable']) {
    $message = 'Sila gunakan alamat emel sebenar, bukan emel sementara.';
    if ($emailVerification['reject_reason']) {
        // Log for debugging (optional)
        error_log("Disposable email rejected: $email - Reason: {$emailVerification['reject_reason']}");
    }
    jsonResponse(false, $message);
}

// Check if email is deliverable
if (!$emailVerification['deliverable']) {
    $message = 'Alamat emel tidak sah atau tidak boleh dikirim.';

    // If there's a suggestion, include it
    if ($emailVerification['suggestion']) {
        $message .= ' Adakah anda maksudkan: ' . $emailVerification['suggestion'] . '?';
    }

    jsonResponse(false, $message);
}

// ============================================
// STEP 3: Create Subscriber in MailWizz
// ============================================

$subscriberResult = createMailWizzSubscriber($email, $name, $phone, $countryCode);

if (!$subscriberResult['success']) {
    // Log error for debugging
    error_log("MailWizz subscriber creation failed for $email: " . ($subscriberResult['error'] ?? 'Unknown error'));

    // Still return success to user - email was verified
    // You may want to handle this differently based on your requirements
    jsonResponse(true, 'Terima kasih! Butiran muat turun akan dihantar ke emel dan WhatsApp anda.', [
        'note' => 'Email verified successfully'
    ]);
}

// ============================================
// SUCCESS RESPONSE
// ============================================

jsonResponse(true, 'Terima kasih! Butiran muat turun akan dihantar ke emel dan WhatsApp anda.', [
    'subscriber_uid' => $subscriberResult['subscriber_uid'] ?? null
]);
