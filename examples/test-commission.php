<?php

/**
 * Sample PHP Code for Testing Commission Generation
 *
 * This script demonstrates how to:
 * 1. Track affiliate clicks
 * 2. Record conversions (sales/leads)
 * 3. Generate commissions automatically
 *
 * Usage:
 *   php examples/test-commission.php
 *
 * Requirements:
 *   - Valid tracking code from an affiliate's tracking link
 *   - Active affiliate program
 *   - Approved affiliate enrollment
 */

// =============================================================================
// CONFIGURATION
// =============================================================================

$config = [
    'base_url' => 'http://sistemaffiliate.test', // Change to your domain
    'tracking_code' => 'YOUR_TRACKING_CODE',     // Replace with actual tracking code
];

// =============================================================================
// HELPER FUNCTIONS
// =============================================================================

/**
 * Make HTTP request using cURL
 */
function makeRequest(string $method, string $url, array $data = [], array $headers = []): array
{
    $ch = curl_init();

    $defaultHeaders = [
        'Content-Type: application/json',
        'Accept: application/json',
    ];

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false, // Don't follow redirects for tracking
        CURLOPT_HTTPHEADER => array_merge($defaultHeaders, $headers),
        CURLOPT_TIMEOUT => 30,
    ]);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    curl_close($ch);

    return [
        'success' => $httpCode >= 200 && $httpCode < 400,
        'http_code' => $httpCode,
        'response' => json_decode($response, true) ?? $response,
        'error' => $error,
    ];
}

/**
 * Print formatted output
 */
function printResult(string $title, array $result): void
{
    echo "\n" . str_repeat('=', 60) . "\n";
    echo "  {$title}\n";
    echo str_repeat('=', 60) . "\n";
    echo "HTTP Code: {$result['http_code']}\n";
    echo "Success: " . ($result['success'] ? 'Yes' : 'No') . "\n";

    if ($result['error']) {
        echo "Error: {$result['error']}\n";
    }

    echo "Response:\n";
    if (is_array($result['response'])) {
        echo json_encode($result['response'], JSON_PRETTY_PRINT) . "\n";
    } else {
        echo $result['response'] . "\n";
    }
}

// =============================================================================
// TEST 1: TRACK CLICK (via API with JSON response)
// =============================================================================

echo "\n";
echo "╔══════════════════════════════════════════════════════════╗\n";
echo "║     AFFILIATE COMMISSION GENERATION TEST SCRIPT          ║\n";
echo "╚══════════════════════════════════════════════════════════╝\n";

echo "\nConfiguration:\n";
echo "  Base URL: {$config['base_url']}\n";
echo "  Tracking Code: {$config['tracking_code']}\n";

// Track click via API (JSON response)
$clickUrl = "{$config['base_url']}/api/track/{$config['tracking_code']}";
echo "\n[TEST 1] Tracking Click...\n";
echo "URL: {$clickUrl}\n";

$clickResult = makeRequest('GET', $clickUrl);
printResult('CLICK TRACKING RESULT', $clickResult);

// =============================================================================
// TEST 2: RECORD CONVERSION (SALE)
// =============================================================================

echo "\n[TEST 2] Recording Sale Conversion...\n";

$conversionUrl = "{$config['base_url']}/api/track/conversion";
$saleData = [
    'tracking_code' => $config['tracking_code'],
    'order_id' => 'TEST-ORDER-' . time(), // Unique order ID
    'amount' => 150.00,                    // Order amount in dollars
    'type' => 'sale',
    'metadata' => [
        'customer_email' => 'test@example.com',
        'products' => [
            ['name' => 'Product A', 'price' => 100.00],
            ['name' => 'Product B', 'price' => 50.00],
        ],
    ],
];

echo "URL: {$conversionUrl}\n";
echo "Payload:\n" . json_encode($saleData, JSON_PRETTY_PRINT) . "\n";

$saleResult = makeRequest('POST', $conversionUrl, $saleData);
printResult('SALE CONVERSION RESULT', $saleResult);

// =============================================================================
// TEST 3: RECORD CONVERSION (LEAD)
// =============================================================================

echo "\n[TEST 3] Recording Lead Conversion...\n";

$leadData = [
    'tracking_code' => $config['tracking_code'],
    'order_id' => 'TEST-LEAD-' . time(),
    'amount' => 0,       // Leads typically don't have monetary value
    'type' => 'lead',
    'metadata' => [
        'form_name' => 'Newsletter Signup',
        'email' => 'lead@example.com',
    ],
];

echo "URL: {$conversionUrl}\n";
echo "Payload:\n" . json_encode($leadData, JSON_PRETTY_PRINT) . "\n";

$leadResult = makeRequest('POST', $conversionUrl, $leadData);
printResult('LEAD CONVERSION RESULT', $leadResult);

// =============================================================================
// TEST 4: DUPLICATE ORDER PREVENTION
// =============================================================================

echo "\n[TEST 4] Testing Duplicate Order Prevention...\n";

$duplicateData = [
    'tracking_code' => $config['tracking_code'],
    'order_id' => $saleData['order_id'], // Same order ID as before
    'amount' => 150.00,
    'type' => 'sale',
];

echo "URL: {$conversionUrl}\n";
echo "Payload (same order_id):\n" . json_encode($duplicateData, JSON_PRETTY_PRINT) . "\n";

$duplicateResult = makeRequest('POST', $conversionUrl, $duplicateData);
printResult('DUPLICATE ORDER RESULT (should be rejected)', $duplicateResult);

// =============================================================================
// SUMMARY
// =============================================================================

echo "\n" . str_repeat('=', 60) . "\n";
echo "  TEST SUMMARY\n";
echo str_repeat('=', 60) . "\n";
echo "1. Click Tracking: " . ($clickResult['success'] ? 'PASSED' : 'FAILED') . "\n";
echo "2. Sale Conversion: " . ($saleResult['success'] ? 'PASSED' : 'FAILED') . "\n";
echo "3. Lead Conversion: " . ($leadResult['success'] ? 'PASSED' : 'FAILED') . "\n";
echo "4. Duplicate Prevention: " . ($duplicateResult['http_code'] === 409 ? 'PASSED' : 'FAILED') . "\n";

echo "\n";
echo "╔══════════════════════════════════════════════════════════╗\n";
echo "║  INTEGRATION CODE EXAMPLES                               ║\n";
echo "╚══════════════════════════════════════════════════════════╝\n";

// =============================================================================
// EXAMPLE: SIMPLE PHP INTEGRATION
// =============================================================================

echo <<<'EXAMPLE'

[EXAMPLE 1: Simple PHP Integration for E-commerce]
--------------------------------------------------

// After successful order completion:
function trackAffiliateConversion($orderId, $totalAmount) {
    $trackingCode = $_COOKIE['ref'] ?? null;

    if (!$trackingCode) {
        return false; // No affiliate tracking
    }

    $data = [
        'tracking_code' => $trackingCode,
        'order_id' => $orderId,
        'amount' => $totalAmount,
        'type' => 'sale',
    ];

    $ch = curl_init('http://your-domain.com/api/track/conversion');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Usage:
// trackAffiliateConversion('ORDER-12345', 299.99);


[EXAMPLE 2: WordPress/WooCommerce Hook]
---------------------------------------

add_action('woocommerce_thankyou', function($order_id) {
    $order = wc_get_order($order_id);
    $tracking_code = $_COOKIE['ref'] ?? null;

    if (!$tracking_code || !$order) {
        return;
    }

    wp_remote_post('http://your-domain.com/api/track/conversion', [
        'headers' => ['Content-Type' => 'application/json'],
        'body' => json_encode([
            'tracking_code' => $tracking_code,
            'order_id' => (string) $order_id,
            'amount' => $order->get_total(),
            'type' => 'sale',
        ]),
    ]);
});


[EXAMPLE 3: JavaScript Cookie Reading]
--------------------------------------

// Read affiliate tracking code from cookie
function getAffiliateCode() {
    const match = document.cookie.match(/ref=([^;]+)/);
    return match ? match[1] : null;
}

// Send conversion via AJAX
async function trackConversion(orderId, amount) {
    const trackingCode = getAffiliateCode();
    if (!trackingCode) return;

    await fetch('http://your-domain.com/api/track/conversion', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            tracking_code: trackingCode,
            order_id: orderId,
            amount: amount,
            type: 'sale'
        })
    });
}


[EXAMPLE 4: Laravel Integration]
--------------------------------

// In your OrderController after successful payment:
use Illuminate\Support\Facades\Http;

public function completeOrder(Request $request)
{
    // ... process order ...

    $trackingCode = $request->cookie('ref');

    if ($trackingCode) {
        Http::post(config('services.affiliate.url') . '/api/track/conversion', [
            'tracking_code' => $trackingCode,
            'order_id' => $order->id,
            'amount' => $order->total,
            'type' => 'sale',
            'metadata' => [
                'customer_id' => $order->customer_id,
                'products' => $order->items->pluck('name')->toArray(),
            ],
        ]);
    }

    return redirect()->route('order.success', $order);
}

EXAMPLE;

echo "\n\n";
echo "For more integration examples, see: Admin Panel > Integration Guide\n";
echo "Documentation: docs/integration-guide.md\n\n";
