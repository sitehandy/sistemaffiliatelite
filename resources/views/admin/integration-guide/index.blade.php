@extends('layouts.app')

@section('title', 'Integration Guide')
@section('page-title', 'Integration Guide')

@section('content')
<div class="space-y-6">
    <!-- Current Settings -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-blue-800 mb-2">Current Configuration</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="text-blue-600 font-medium">Base URL:</span>
                <code class="ml-2 bg-blue-100 px-2 py-1 rounded">{{ $baseUrl }}</code>
            </div>
            <div>
                <span class="text-blue-600 font-medium">Cookie Duration:</span>
                <code class="ml-2 bg-blue-100 px-2 py-1 rounded">{{ $cookieDuration }} days</code>
            </div>
            <div>
                <span class="text-blue-600 font-medium">API Endpoint:</span>
                <code class="ml-2 bg-blue-100 px-2 py-1 rounded">/api/track/conversion</code>
            </div>
        </div>
        <p class="text-blue-700 text-xs mt-2">Cookie duration can be changed in <a href="{{ route('admin.settings.index') }}" class="underline">Settings</a>.</p>
    </div>

    <!-- Table of Contents -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Table of Contents</h2>
        <nav class="space-y-2">
            <a href="#how-it-works" class="block text-blue-600 hover:text-blue-800">1. How It Works</a>
            <a href="#quick-start" class="block text-blue-600 hover:text-blue-800">2. Quick Start</a>
            <a href="#step-by-step" class="block text-blue-600 hover:text-blue-800">3. Step-by-Step Integration</a>
            <a href="#platform-examples" class="block text-blue-600 hover:text-blue-800">4. Platform-Specific Examples</a>
            <a href="#api-reference" class="block text-blue-600 hover:text-blue-800">5. API Reference</a>
            <a href="#testing" class="block text-blue-600 hover:text-blue-800">6. Testing Your Integration</a>
            <a href="#troubleshooting" class="block text-blue-600 hover:text-blue-800">7. Troubleshooting</a>
        </nav>
    </div>

    <!-- How It Works -->
    <div id="how-it-works" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">1. How It Works</h2>
        <p class="text-gray-600 mb-4">The affiliate tracking system uses a simple 3-step process:</p>

        <div class="bg-gray-50 rounded-lg p-4 mb-6 overflow-x-auto">
            <pre class="text-sm text-gray-700">
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│  1. CLICK       │───>│  2. BROWSE      │───>│  3. CONVERT     │
│                 │    │                 │    │                 │
│ Affiliate link  │    │ Your website    │    │ API callback    │
│ is clicked      │    │ stores ref code │    │ records sale    │
└─────────────────┘    └─────────────────┘    └─────────────────┘</pre>
        </div>

        <h3 class="text-lg font-medium text-gray-700 mb-3">Flow Diagram</h3>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-medium">1</div>
                <div class="ml-4">
                    <h4 class="font-medium text-gray-800">Affiliate shares their tracking link</h4>
                    <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $baseUrl }}/track/ABC123</code>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-medium">2</div>
                <div class="ml-4">
                    <h4 class="font-medium text-gray-800">System records click and redirects to your product page</h4>
                    <code class="text-sm bg-gray-100 px-2 py-1 rounded">https://your-product-site.com/product?ref=ABC123</code>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-medium">3</div>
                <div class="ml-4">
                    <h4 class="font-medium text-gray-800">Your website captures and stores the <code class="bg-gray-100 px-1">ref</code> parameter</h4>
                    <p class="text-gray-600 text-sm">Store in cookie (current setting: <strong>{{ $cookieDuration }} days</strong>) or store in session/localStorage</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-medium">4</div>
                <div class="ml-4">
                    <h4 class="font-medium text-gray-800">When conversion happens, your site calls the API</h4>
                    <code class="text-sm bg-gray-100 px-2 py-1 rounded">POST {{ $baseUrl }}/api/track/conversion</code>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-medium">5</div>
                <div class="ml-4">
                    <h4 class="font-medium text-gray-800">Commission is automatically calculated and assigned to affiliate</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Start -->
    <div id="quick-start" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">2. Quick Start</h2>
        <p class="text-gray-600 mb-4">Minimum required code (PHP) - Add this to every page of your website:</p>

        <div class="bg-gray-900 rounded-lg p-4 mb-6 overflow-x-auto">
            <pre class="text-green-400 text-sm">&lt;?php
// Capture affiliate reference on any page
// Cookie duration: {{ $cookieDuration }} days (configured in admin settings)
if (isset($_GET['ref']) && !empty($_GET['ref'])) {
    setcookie('affiliate_ref', $_GET['ref'], time() + (86400 * {{ $cookieDuration }}), '/');
}</pre>
        </div>

        <p class="text-gray-600 mb-4">Add this after a successful purchase/conversion:</p>
        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
            <pre class="text-green-400 text-sm">&lt;?php
if (isset($_COOKIE['affiliate_ref'])) {
    $ch = curl_init('{{ $baseUrl }}/api/track/conversion');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'tracking_code' => $_COOKIE['affiliate_ref'],
            'amount' => $orderTotal,
            'order_id' => $orderId,
            'type' => 'sale'
        ]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true
    ]);
    curl_exec($ch);
    curl_close($ch);

    // Clear the cookie after conversion
    setcookie('affiliate_ref', '', time() - 3600, '/');
}</pre>
        </div>
    </div>

    <!-- Step-by-Step Integration -->
    <div id="step-by-step" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">3. Step-by-Step Integration</h2>

        <h3 class="text-lg font-medium text-gray-700 mb-3">Step 1: Configure Your Product URL</h3>
        <p class="text-gray-600 mb-4">In the affiliate system admin panel:</p>
        <ol class="list-decimal list-inside text-gray-600 mb-6 space-y-2">
            <li>Go to <strong>Products</strong> > <strong>Edit Product</strong></li>
            <li>Set the <strong>Website URL</strong> to your product/landing page</li>
        </ol>

        <h3 class="text-lg font-medium text-gray-700 mb-3">Step 2: Add Tracking Code to Your Website</h3>
        <p class="text-gray-600 mb-4">Add this JavaScript snippet to your website's header (on all pages):</p>
        <div class="bg-gray-900 rounded-lg p-4 mb-6 overflow-x-auto">
            <pre class="text-green-400 text-sm">&lt;script&gt;
(function() {
    // Capture ref parameter from URL
    const urlParams = new URLSearchParams(window.location.search);
    const ref = urlParams.get('ref');

    if (ref) {
        // Store in cookie for {{ $cookieDuration }} days (configured in admin settings)
        const expires = new Date(Date.now() + {{ $cookieDuration }} * 24 * 60 * 60 * 1000).toUTCString();
        document.cookie = `affiliate_ref=${ref}; expires=${expires}; path=/`;
    }
})();
&lt;/script&gt;</pre>
        </div>

        <h3 class="text-lg font-medium text-gray-700 mb-3">Step 3: Track Conversions</h3>
        <p class="text-gray-600 mb-4">When a sale or lead is completed, send data to the API.</p>

        <h4 class="font-medium text-gray-700 mb-2">Option A: Server-Side (Recommended)</h4>
        <div class="bg-gray-900 rounded-lg p-4 mb-4 overflow-x-auto">
            <pre class="text-green-400 text-sm">&lt;?php
function trackAffiliateConversion($amount, $orderId, $type = 'sale') {
    $affiliateRef = $_COOKIE['affiliate_ref'] ?? null;

    if (!$affiliateRef) {
        return false; // No affiliate to credit
    }

    $apiUrl = '{{ $baseUrl }}/api/track/conversion';

    $data = [
        'tracking_code' => $affiliateRef,
        'amount' => (float) $amount,
        'order_id' => (string) $orderId,
        'type' => $type, // 'sale' or 'lead'
        'metadata' => [
            'source' => 'website',
            'timestamp' => date('c')
        ]
    ];

    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json'
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 201) {
        // Clear the cookie after successful conversion
        setcookie('affiliate_ref', '', time() - 3600, '/');
        return true;
    }

    return false;
}

// Usage after successful order
trackAffiliateConversion(99.99, 'ORD-12345', 'sale');</pre>
        </div>

        <h4 class="font-medium text-gray-700 mb-2">Option B: Client-Side (JavaScript)</h4>
        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
            <pre class="text-green-400 text-sm">function trackAffiliateConversion(amount, orderId, type = 'sale') {
    // Get affiliate ref from cookie
    const cookies = document.cookie.split(';');
    let affiliateRef = null;

    for (let cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'affiliate_ref') {
            affiliateRef = value;
            break;
        }
    }

    if (!affiliateRef) {
        console.log('No affiliate reference found');
        return;
    }

    fetch('{{ $baseUrl }}/api/track/conversion', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            tracking_code: affiliateRef,
            amount: parseFloat(amount),
            order_id: String(orderId),
            type: type
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Conversion tracked:', data);
        // Clear the cookie
        document.cookie = 'affiliate_ref=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    })
    .catch(error => {
        console.error('Error tracking conversion:', error);
    });
}

// Usage on thank you page
trackAffiliateConversion(99.99, 'ORD-12345', 'sale');</pre>
        </div>
    </div>

    <!-- Platform-Specific Examples -->
    <div id="platform-examples" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">4. Platform-Specific Examples</h2>

        <!-- WooCommerce -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                </svg>
                WooCommerce (WordPress)
            </h3>
            <p class="text-gray-600 mb-4">Create a file <code class="bg-gray-100 px-2 py-1 rounded">affiliate-tracking.php</code> in your theme or as a plugin:</p>
            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                <pre class="text-green-400 text-sm">&lt;?php
/**
 * Plugin Name: Affiliate Tracking Integration
 * Description: Integrates with external affiliate system
 */

define('AFFILIATE_API_URL', '{{ $baseUrl }}/api/track/conversion');

// Capture affiliate ref on page load
add_action('init', function() {
    if (isset($_GET['ref']) && !empty($_GET['ref'])) {
        $ref = sanitize_text_field($_GET['ref']);
        // Cookie duration: {{ $cookieDuration }} days
        setcookie('affiliate_ref', $ref, time() + (86400 * {{ $cookieDuration }}), '/');

        // Also store in session for cart persistence
        if (!session_id()) session_start();
        $_SESSION['affiliate_ref'] = $ref;
    }
});

// Track conversion on order completion
add_action('woocommerce_thankyou', function($order_id) {
    // Prevent duplicate tracking
    if (get_post_meta($order_id, '_affiliate_tracked', true)) {
        return;
    }

    $affiliate_ref = $_COOKIE['affiliate_ref'] ?? ($_SESSION['affiliate_ref'] ?? null);

    if (!$affiliate_ref) {
        return;
    }

    $order = wc_get_order($order_id);

    if (!$order) {
        return;
    }

    $response = wp_remote_post(AFFILIATE_API_URL, [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ],
        'body' => json_encode([
            'tracking_code' => $affiliate_ref,
            'amount' => (float) $order->get_total(),
            'order_id' => (string) $order_id,
            'type' => 'sale',
            'metadata' => [
                'platform' => 'woocommerce',
                'customer_email' => $order->get_billing_email()
            ]
        ]),
        'timeout' => 10
    ]);

    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 201) {
        // Mark as tracked
        update_post_meta($order_id, '_affiliate_tracked', true);
        update_post_meta($order_id, '_affiliate_ref', $affiliate_ref);

        // Clear cookie
        setcookie('affiliate_ref', '', time() - 3600, '/');
    }
});

// Also track on payment complete (for delayed payments)
add_action('woocommerce_payment_complete', function($order_id) {
    do_action('woocommerce_thankyou', $order_id);
});</pre>
            </div>
        </div>

        <!-- Shopify -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15.337 3.415c-.184-.014-.369-.014-.553 0-.553.055-.922.369-1.107.645-.185.276-.369.645-.553 1.107-.092.184-.184.369-.276.553h-1.66c-.277 0-.553.092-.737.277-.185.184-.277.46-.277.737v1.107c-.462.185-.83.461-1.107.83-.276.369-.461.83-.461 1.383v8.842c0 .553.185 1.014.461 1.383.277.368.645.645 1.107.83v1.106c0 .277.092.553.277.737.184.185.46.277.737.277h7.749c.276 0 .553-.092.737-.277.185-.184.277-.46.277-.737v-1.106c.461-.185.83-.462 1.106-.83.277-.369.462-.83.462-1.383V7.107c0-.553-.185-1.014-.462-1.383-.276-.369-.645-.645-1.106-.83V3.786c0-.277-.092-.553-.277-.737-.184-.185-.46-.277-.737-.277h-3.599v.643z"/>
                </svg>
                Shopify
            </h3>
            <p class="text-gray-600 mb-4">Use Shopify's Additional Scripts (in Checkout settings):</p>
            <div class="bg-gray-900 rounded-lg p-4 mb-4 overflow-x-auto">
                <pre class="text-green-400 text-sm">{<span></span>% if first_time_accessed %}
&lt;script&gt;
(function() {
    // Get affiliate ref from cookie
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    const affiliateRef = getCookie('affiliate_ref');

    if (affiliateRef) {
        fetch('{{ $baseUrl }}/api/track/conversion', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                tracking_code: affiliateRef,
                amount: {<span></span>{ checkout.total_price | divided_by: 100.0 }},
                order_id: '{<span></span>{ order.order_number }}',
                type: 'sale',
                metadata: {
                    platform: 'shopify',
                    customer_email: '{<span></span>{ checkout.email }}'
                }
            })
        }).then(() => {
            document.cookie = 'affiliate_ref=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        });
    }
})();
&lt;/script&gt;
{<span></span>% endif %}</pre>
            </div>
            <p class="text-gray-600 mb-4">Also add this to your theme.liquid (in the <code class="bg-gray-100 px-1">&lt;head&gt;</code> section):</p>
            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                <pre class="text-green-400 text-sm">&lt;script&gt;
(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const ref = urlParams.get('ref');
    if (ref) {
        // Cookie duration: {{ $cookieDuration }} days
        const expires = new Date(Date.now() + {{ $cookieDuration }} * 24 * 60 * 60 * 1000).toUTCString();
        document.cookie = `affiliate_ref=${ref}; expires=${expires}; path=/`;
    }
})();
&lt;/script&gt;</pre>
            </div>
        </div>

        <!-- Laravel -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                Laravel Application
            </h3>
            <p class="text-gray-600 mb-4">Create middleware <code class="bg-gray-100 px-2 py-1 rounded">app/Http/Middleware/CaptureAffiliateRef.php</code>:</p>
            <div class="bg-gray-900 rounded-lg p-4 mb-4 overflow-x-auto">
                <pre class="text-green-400 text-sm">&lt;?php
// app/Http/Middleware/CaptureAffiliateRef.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaptureAffiliateRef
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('ref')) {
            // Cookie duration: {{ $cookieDuration }} days (configured in admin settings)
            cookie()->queue('affiliate_ref', $request->ref, 60 * 24 * {{ $cookieDuration }});
        }

        return $next($request);
    }
}

// Register in app/Http/Kernel.php under web middleware group</pre>
            </div>
            <p class="text-gray-600 mb-4">Create service <code class="bg-gray-100 px-2 py-1 rounded">app/Services/AffiliateTracker.php</code>:</p>
            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                <pre class="text-green-400 text-sm">&lt;?php
// app/Services/AffiliateTracker.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class AffiliateTracker
{
    protected string $apiUrl = '{{ $baseUrl }}';

    public function trackConversion(float $amount, string $orderId, string $type = 'sale'): bool
    {
        $affiliateRef = Cookie::get('affiliate_ref');

        if (!$affiliateRef) {
            return false;
        }

        $response = Http::post($this->apiUrl . '/api/track/conversion', [
            'tracking_code' => $affiliateRef,
            'amount' => $amount,
            'order_id' => $orderId,
            'type' => $type,
        ]);

        if ($response->successful()) {
            Cookie::queue(Cookie::forget('affiliate_ref'));
            return true;
        }

        return false;
    }
}

// Usage in controller:
// app(AffiliateTracker::class)->trackConversion(99.99, 'ORD-123');</pre>
            </div>
        </div>

        <!-- Custom HTML Form -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Custom HTML Form (Lead Generation)
            </h3>
            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                <pre class="text-green-400 text-sm">&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;Contact Form&lt;/title&gt;
    &lt;script&gt;
        // Capture ref on page load
        (function() {
            const urlParams = new URLSearchParams(window.location.search);
            const ref = urlParams.get('ref');
            if (ref) {
                // Cookie duration: {{ $cookieDuration }} days
                const expires = new Date(Date.now() + {{ $cookieDuration }}*24*60*60*1000).toUTCString();
                document.cookie = `affiliate_ref=${ref}; expires=${expires}; path=/`;
            }
        })();

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }
    &lt;/script&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;form id="leadForm"&gt;
        &lt;input type="text" name="name" placeholder="Your Name" required&gt;
        &lt;input type="email" name="email" placeholder="Your Email" required&gt;
        &lt;input type="tel" name="phone" placeholder="Your Phone"&gt;
        &lt;button type="submit"&gt;Submit&lt;/button&gt;
    &lt;/form&gt;

    &lt;script&gt;
        document.getElementById('leadForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Submit your form to your server first
            fetch('/submit-lead', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Track affiliate conversion
                const affiliateRef = getCookie('affiliate_ref');
                if (affiliateRef && data.lead_id) {
                    fetch('{{ $baseUrl }}/api/track/conversion', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            tracking_code: affiliateRef,
                            amount: 0,
                            order_id: data.lead_id,
                            type: 'lead'
                        })
                    }).then(() => {
                        document.cookie = 'affiliate_ref=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                    });
                }

                // Show success message
                alert('Thank you for your submission!');
            });
        });
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;</pre>
            </div>
        </div>

        <!-- Webhook Integration -->
        <div>
            <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Webhook Integration (Server-to-Server)
            </h3>
            <p class="text-gray-600 mb-4">For CRM systems or payment processors that support webhooks:</p>
            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                <pre class="text-green-400 text-sm">&lt;?php
// webhook-handler.php

// Verify webhook signature if applicable
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

// Extract order information
$orderId = $data['order_id'];
$amount = $data['amount'];
$customerEmail = $data['customer']['email'];

// Look up affiliate ref from your database
// (You should store it when the order was created)
$affiliateRef = getAffiliateRefFromOrder($orderId);

if ($affiliateRef) {
    $ch = curl_init('{{ $baseUrl }}/api/track/conversion');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'tracking_code' => $affiliateRef,
            'amount' => $amount,
            'order_id' => $orderId,
            'type' => 'sale'
        ]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true
    ]);
    curl_exec($ch);
    curl_close($ch);
}

http_response_code(200);
echo json_encode(['status' => 'ok']);</pre>
            </div>
        </div>
    </div>

    <!-- API Reference -->
    <div id="api-reference" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">5. API Reference</h2>

        <h3 class="text-lg font-medium text-gray-700 mb-3">Track Conversion</h3>
        <p class="text-gray-600 mb-4">Records a conversion (sale or lead) and creates commission for the affiliate.</p>

        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
            <p class="text-sm text-blue-700"><strong>Endpoint:</strong> <code class="bg-blue-100 px-2 py-1 rounded">POST {{ $baseUrl }}/api/track/conversion</code></p>
        </div>

        <h4 class="font-medium text-gray-700 mb-2">Headers</h4>
        <div class="bg-gray-900 rounded-lg p-4 mb-4 overflow-x-auto">
            <pre class="text-green-400 text-sm">Content-Type: application/json
Accept: application/json</pre>
        </div>

        <h4 class="font-medium text-gray-700 mb-2">Request Body</h4>
        <div class="overflow-x-auto mb-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Field</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Required</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    <tr>
                        <td class="px-4 py-3 font-mono">tracking_code</td>
                        <td class="px-4 py-3 text-gray-500">string</td>
                        <td class="px-4 py-3"><span class="text-green-600 font-medium">Yes</span></td>
                        <td class="px-4 py-3 text-gray-500">The affiliate's unique tracking code (from ref parameter)</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 font-mono">amount</td>
                        <td class="px-4 py-3 text-gray-500">number</td>
                        <td class="px-4 py-3"><span class="text-green-600 font-medium">Yes</span></td>
                        <td class="px-4 py-3 text-gray-500">Order/conversion value (use 0 for leads)</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 font-mono">order_id</td>
                        <td class="px-4 py-3 text-gray-500">string</td>
                        <td class="px-4 py-3"><span class="text-gray-400">No</span></td>
                        <td class="px-4 py-3 text-gray-500">Your unique order/lead ID (prevents duplicates)</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 font-mono">type</td>
                        <td class="px-4 py-3 text-gray-500">string</td>
                        <td class="px-4 py-3"><span class="text-gray-400">No</span></td>
                        <td class="px-4 py-3 text-gray-500">'sale' (default) or 'lead'</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 font-mono">metadata</td>
                        <td class="px-4 py-3 text-gray-500">object</td>
                        <td class="px-4 py-3"><span class="text-gray-400">No</span></td>
                        <td class="px-4 py-3 text-gray-500">Additional data (customer info, etc.)</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h4 class="font-medium text-gray-700 mb-2">Example Request</h4>
        <div class="bg-gray-900 rounded-lg p-4 mb-4 overflow-x-auto">
            <pre class="text-green-400 text-sm">{
    "tracking_code": "ABC123XYZ",
    "amount": 149.99,
    "order_id": "ORD-2024-001234",
    "type": "sale",
    "metadata": {
        "customer_email": "customer@example.com",
        "product_name": "Premium Plan",
        "platform": "woocommerce"
    }
}</pre>
        </div>

        <h4 class="font-medium text-gray-700 mb-2">Success Response (201 Created)</h4>
        <div class="bg-gray-900 rounded-lg p-4 mb-4 overflow-x-auto">
            <pre class="text-green-400 text-sm">{
    "message": "Conversion recorded successfully.",
    "conversion": {
        "id": 123,
        "tracking_event_id": 456,
        "conversion_value": 149.99,
        "order_id": "ORD-2024-001234",
        "created_at": "2024-01-15T10:30:00Z"
    }
}</pre>
        </div>

        <h4 class="font-medium text-gray-700 mb-2">Error Responses</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    <tr>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded">404</span></td>
                        <td class="px-4 py-3 text-gray-700">Invalid tracking code</td>
                        <td class="px-4 py-3 text-gray-500">The tracking code doesn't exist</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded">404</span></td>
                        <td class="px-4 py-3 text-gray-700">Program is not active</td>
                        <td class="px-4 py-3 text-gray-500">The affiliate program is disabled</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded">409</span></td>
                        <td class="px-4 py-3 text-gray-700">Conversion already recorded</td>
                        <td class="px-4 py-3 text-gray-500">Duplicate order_id</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded">422</span></td>
                        <td class="px-4 py-3 text-gray-700">Validation error</td>
                        <td class="px-4 py-3 text-gray-500">Missing or invalid fields</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Testing -->
    <div id="testing" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">6. Testing Your Integration</h2>

        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Step 1: Create a Test Tracking Link</h3>
                <ol class="list-decimal list-inside text-gray-600 space-y-1">
                    <li>Log in as an affiliate</li>
                    <li>Go to <strong>Tracking Links</strong> > <strong>Create New</strong></li>
                    <li>Select a program and product</li>
                    <li>Copy the tracking link</li>
                </ol>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Step 2: Test the Click Tracking</h3>
                <ol class="list-decimal list-inside text-gray-600 space-y-1">
                    <li>Open the tracking link in a browser</li>
                    <li>Verify you're redirected to the product page with <code class="bg-gray-100 px-1">?ref=CODE</code></li>
                    <li>Check that the cookie is set:
                        <ul class="list-disc list-inside ml-4 mt-1 text-sm">
                            <li>Open browser DevTools (F12)</li>
                            <li>Go to Application > Cookies</li>
                            <li>Look for <code class="bg-gray-100 px-1">affiliate_ref</code></li>
                        </ul>
                    </li>
                </ol>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Step 3: Test the Conversion API</h3>
                <p class="text-gray-600 mb-2">Using cURL:</p>
                <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                    <pre class="text-green-400 text-sm">curl -X POST {{ $baseUrl }}/api/track/conversion \
  -H "Content-Type: application/json" \
  -d '{
    "tracking_code": "YOUR_CODE_HERE",
    "amount": 99.99,
    "order_id": "TEST-001",
    "type": "sale"
  }'</pre>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Step 4: Verify in Admin Panel</h3>
                <ol class="list-decimal list-inside text-gray-600 space-y-1">
                    <li>Log in as admin</li>
                    <li>Go to <strong>Commissions</strong></li>
                    <li>Verify the new commission appears with status "Pending"</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Troubleshooting -->
    <div id="troubleshooting" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">7. Troubleshooting</h2>

        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-red-600 mb-2">Cookie Not Being Set</h3>
                <p class="text-gray-600 mb-2"><strong>Problem:</strong> The <code class="bg-gray-100 px-1">affiliate_ref</code> cookie is not being stored.</p>
                <p class="text-gray-600 mb-2"><strong>Solutions:</strong></p>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Ensure the redirect URL matches your domain</li>
                    <li>Check for cookie consent blockers</li>
                    <li>Verify HTTPS is used (some browsers block cookies on HTTP)</li>
                    <li>Check cookie path is set to <code class="bg-gray-100 px-1">/</code></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-medium text-red-600 mb-2">Conversion Not Recording</h3>
                <p class="text-gray-600 mb-2"><strong>Problem:</strong> API call succeeds but no commission appears.</p>
                <p class="text-gray-600 mb-2"><strong>Checklist:</strong></p>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Verify the tracking code exists in the system</li>
                    <li>Check the program is active</li>
                    <li>Ensure the affiliate's enrollment is approved</li>
                    <li>Check order_id isn't duplicated</li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-medium text-red-600 mb-2">CORS Errors (JavaScript)</h3>
                <p class="text-gray-600 mb-2"><strong>Problem:</strong> Browser blocks the API request.</p>
                <p class="text-gray-600 mb-2"><strong>Solution:</strong> The API allows cross-origin requests. If issues persist, use server-side proxy:</p>
                <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                    <pre class="text-green-400 text-sm">// Use server-side proxy instead
fetch('/your-server/track-conversion', {
    method: 'POST',
    body: JSON.stringify(data)
});</pre>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-red-600 mb-2">Commission Amount is Wrong</h3>
                <p class="text-gray-600 mb-2"><strong>Problem:</strong> Commission calculated incorrectly.</p>
                <p class="text-gray-600 mb-2"><strong>Check:</strong></p>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Program commission type (percentage vs flat)</li>
                    <li>Commission amount setting in program</li>
                    <li>The <code class="bg-gray-100 px-1">amount</code> sent in API matches order total</li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-medium text-red-600 mb-2">Duplicate Conversions</h3>
                <p class="text-gray-600 mb-2"><strong>Problem:</strong> Same order tracked multiple times.</p>
                <p class="text-gray-600 mb-2"><strong>Solution:</strong> Always send a unique <code class="bg-gray-100 px-1">order_id</code>:</p>
                <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                    <pre class="text-green-400 text-sm">'order_id' => 'ORD-' . $orderId  // Your unique order ID</pre>
                </div>
                <p class="text-gray-600 mt-2 text-sm">The system automatically rejects duplicate order_ids.</p>
            </div>
        </div>
    </div>

    <!-- Best Practices -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Best Practices</h2>
        <ul class="space-y-3">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-600"><strong>Always use server-side tracking</strong> for production (more reliable than JavaScript)</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-600"><strong>Store affiliate ref in database</strong> when order is created (not just cookies)</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-600"><strong>Use the configured cookie duration</strong> (currently set to {{ $cookieDuration }} days in <a href="{{ route('admin.settings.index') }}" class="text-blue-600 underline">Settings</a>)</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-600"><strong>Handle API failures gracefully</strong> - queue and retry if needed</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-600"><strong>Clear cookies after conversion</strong> to prevent duplicate tracking</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-600"><strong>Use unique order IDs</strong> to prevent duplicate commissions</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-600"><strong>Test thoroughly</strong> before going live</span>
            </li>
        </ul>
    </div>
</div>
@endsection
