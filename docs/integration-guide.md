# Affiliate Tracking Integration Guide

This guide explains how to integrate the affiliate tracking system with your website, e-commerce platform, or third-party applications.

---

## Table of Contents

1. [How It Works](#how-it-works)
2. [Quick Start](#quick-start)
3. [Step-by-Step Integration](#step-by-step-integration)
4. [Platform-Specific Examples](#platform-specific-examples)
5. [API Reference](#api-reference)
6. [Testing Your Integration](#testing-your-integration)
7. [Troubleshooting](#troubleshooting)

---

## How It Works

The affiliate tracking system uses a simple 3-step process:

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│  1. CLICK       │───>│  2. BROWSE      │───>│  3. CONVERT     │
│                 │    │                 │    │                 │
│ Affiliate link  │    │ Your website    │    │ API callback    │
│ is clicked      │    │ stores ref code │    │ records sale    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

### Flow Diagram

1. **Affiliate shares their tracking link**
   ```
   https://your-affiliate-system.com/track/ABC123
   ```

2. **System records click and redirects to your product page**
   ```
   https://your-product-site.com/product?ref=ABC123
   ```

3. **Your website captures and stores the `ref` parameter**
   - Store in cookie (recommended: 30 days)
   - Or store in session/localStorage

4. **When conversion happens, your site calls the API**
   ```
   POST /api/track/conversion
   {
       "tracking_code": "ABC123",
       "amount": 99.99,
       "order_id": "ORD-12345"
   }
   ```

5. **Commission is automatically calculated and assigned to affiliate**

---

## Quick Start

### Minimum Required Code (PHP)

Add this to every page of your website:

```php
<?php
// Capture affiliate reference on any page
if (isset($_GET['ref']) && !empty($_GET['ref'])) {
    setcookie('affiliate_ref', $_GET['ref'], time() + (86400 * 30), '/');
}
```

Add this after a successful purchase/conversion:

```php
<?php
if (isset($_COOKIE['affiliate_ref'])) {
    $ch = curl_init('https://your-affiliate-system.com/api/track/conversion');
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
}
```

---

## Step-by-Step Integration

### Step 1: Configure Your Product URL

In the affiliate system admin panel:

1. Go to **Products** > **Edit Product**
2. Set the **Website URL** to your product/landing page
   ```
   https://your-site.com/product-page
   ```

### Step 2: Add Tracking Code to Your Website

Add this JavaScript snippet to your website's header (on all pages):

```html
<script>
(function() {
    // Capture ref parameter from URL
    const urlParams = new URLSearchParams(window.location.search);
    const ref = urlParams.get('ref');

    if (ref) {
        // Store in cookie for 30 days
        const expires = new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toUTCString();
        document.cookie = `affiliate_ref=${ref}; expires=${expires}; path=/`;
    }
})();
</script>
```

### Step 3: Track Conversions

When a sale or lead is completed, send data to the API:

#### Option A: Server-Side (Recommended)

```php
<?php
function trackAffiliateConversion($amount, $orderId, $type = 'sale') {
    $affiliateRef = $_COOKIE['affiliate_ref'] ?? null;

    if (!$affiliateRef) {
        return false; // No affiliate to credit
    }

    $apiUrl = 'https://your-affiliate-system.com/api/track/conversion';

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
trackAffiliateConversion(99.99, 'ORD-12345', 'sale');
```

#### Option B: Client-Side (JavaScript)

```javascript
function trackAffiliateConversion(amount, orderId, type = 'sale') {
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

    fetch('https://your-affiliate-system.com/api/track/conversion', {
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
trackAffiliateConversion(99.99, 'ORD-12345', 'sale');
```

---

## Platform-Specific Examples

### WooCommerce (WordPress)

Create a file `affiliate-tracking.php` in your theme or as a plugin:

```php
<?php
/**
 * Plugin Name: Affiliate Tracking Integration
 * Description: Integrates with external affiliate system
 */

define('AFFILIATE_API_URL', 'https://your-affiliate-system.com/api/track/conversion');

// Capture affiliate ref on page load
add_action('init', function() {
    if (isset($_GET['ref']) && !empty($_GET['ref'])) {
        $ref = sanitize_text_field($_GET['ref']);
        setcookie('affiliate_ref', $ref, time() + (86400 * 30), '/');

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
});
```

### Shopify

Use Shopify's Additional Scripts (in Checkout settings):

```liquid
{% if first_time_accessed %}
<script>
(function() {
    // Get affiliate ref from cookie
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    const affiliateRef = getCookie('affiliate_ref');

    if (affiliateRef) {
        fetch('https://your-affiliate-system.com/api/track/conversion', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                tracking_code: affiliateRef,
                amount: {{ checkout.total_price | divided_by: 100.0 }},
                order_id: '{{ order.order_number }}',
                type: 'sale',
                metadata: {
                    platform: 'shopify',
                    customer_email: '{{ checkout.email }}'
                }
            })
        }).then(() => {
            document.cookie = 'affiliate_ref=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        });
    }
})();
</script>
{% endif %}
```

Also add this to your theme.liquid (in the `<head>` section):

```liquid
<script>
(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const ref = urlParams.get('ref');
    if (ref) {
        const expires = new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toUTCString();
        document.cookie = `affiliate_ref=${ref}; expires=${expires}; path=/`;
    }
})();
</script>
```

### Laravel Application

```php
<?php
// app/Http/Middleware/CaptureAffiliateRef.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaptureAffiliateRef
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('ref')) {
            cookie()->queue('affiliate_ref', $request->ref, 60 * 24 * 30); // 30 days
        }

        return $next($request);
    }
}

// Register in app/Http/Kernel.php under web middleware group
```

```php
<?php
// app/Services/AffiliateTracker.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class AffiliateTracker
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.affiliate.api_url');
    }

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
// app(AffiliateTracker::class)->trackConversion(99.99, 'ORD-123');
```

### Custom HTML Form (Lead Generation)

```html
<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <script>
        // Capture ref on page load
        (function() {
            const urlParams = new URLSearchParams(window.location.search);
            const ref = urlParams.get('ref');
            if (ref) {
                const expires = new Date(Date.now() + 30*24*60*60*1000).toUTCString();
                document.cookie = `affiliate_ref=${ref}; expires=${expires}; path=/`;
            }
        })();

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }
    </script>
</head>
<body>
    <form id="leadForm">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="tel" name="phone" placeholder="Your Phone">
        <button type="submit">Submit</button>
    </form>

    <script>
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
                    fetch('https://your-affiliate-system.com/api/track/conversion', {
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
    </script>
</body>
</html>
```

### Webhook Integration (Server-to-Server)

For CRM systems or payment processors that support webhooks:

```php
<?php
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
    $ch = curl_init('https://your-affiliate-system.com/api/track/conversion');
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
echo json_encode(['status' => 'ok']);
```

---

## API Reference

### Track Conversion

Records a conversion (sale or lead) and creates commission for the affiliate.

**Endpoint:** `POST /api/track/conversion`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `tracking_code` | string | Yes | The affiliate's unique tracking code (from `ref` parameter) |
| `amount` | number | Yes | Order/conversion value (use 0 for leads) |
| `order_id` | string | No | Your unique order/lead ID (prevents duplicates) |
| `type` | string | No | `sale` (default) or `lead` |
| `metadata` | object | No | Additional data (customer info, etc.) |

**Example Request:**
```json
{
    "tracking_code": "ABC123XYZ",
    "amount": 149.99,
    "order_id": "ORD-2024-001234",
    "type": "sale",
    "metadata": {
        "customer_email": "customer@example.com",
        "product_name": "Premium Plan",
        "platform": "woocommerce"
    }
}
```

**Success Response (201 Created):**
```json
{
    "message": "Conversion recorded successfully.",
    "conversion": {
        "id": 123,
        "tracking_event_id": 456,
        "conversion_value": 149.99,
        "order_id": "ORD-2024-001234",
        "created_at": "2024-01-15T10:30:00Z"
    }
}
```

**Error Responses:**

| Code | Message | Description |
|------|---------|-------------|
| 404 | Invalid tracking code | The tracking code doesn't exist |
| 404 | Program is not active | The affiliate program is disabled |
| 409 | Conversion already recorded | Duplicate order_id |
| 422 | Validation error | Missing or invalid fields |

---

## Testing Your Integration

### Step 1: Create a Test Tracking Link

1. Log in as an affiliate
2. Go to **Tracking Links** > **Create New**
3. Select a program and product
4. Copy the tracking link

### Step 2: Test the Click Tracking

1. Open the tracking link in a browser
2. Verify you're redirected to the product page with `?ref=CODE`
3. Check that the cookie is set:
   - Open browser DevTools (F12)
   - Go to Application > Cookies
   - Look for `affiliate_ref`

### Step 3: Test the Conversion API

Using cURL:
```bash
curl -X POST https://your-affiliate-system.com/api/track/conversion \
  -H "Content-Type: application/json" \
  -d '{
    "tracking_code": "YOUR_CODE_HERE",
    "amount": 99.99,
    "order_id": "TEST-001",
    "type": "sale"
  }'
```

Expected response:
```json
{
    "message": "Conversion recorded successfully.",
    "conversion": { ... }
}
```

### Step 4: Verify in Admin Panel

1. Log in as admin
2. Go to **Commissions**
3. Verify the new commission appears with status "Pending"

---

## Troubleshooting

### Cookie Not Being Set

**Problem:** The `affiliate_ref` cookie is not being stored.

**Solutions:**
1. Ensure the redirect URL matches your domain
2. Check for cookie consent blockers
3. Verify HTTPS is used (some browsers block cookies on HTTP)
4. Check cookie path is set to `/`

### Conversion Not Recording

**Problem:** API call succeeds but no commission appears.

**Checklist:**
1. Verify the tracking code exists in the system
2. Check the program is active
3. Ensure the affiliate's enrollment is approved
4. Check order_id isn't duplicated

### CORS Errors (JavaScript)

**Problem:** Browser blocks the API request.

**Solution:** The API allows cross-origin requests. If issues persist:
```javascript
// Use server-side proxy instead
fetch('/your-server/track-conversion', {
    method: 'POST',
    body: JSON.stringify(data)
});
```

### Commission Amount is Wrong

**Problem:** Commission calculated incorrectly.

**Check:**
1. Program commission type (percentage vs flat)
2. Commission amount setting in program
3. The `amount` sent in API matches order total

### Duplicate Conversions

**Problem:** Same order tracked multiple times.

**Solution:** Always send a unique `order_id`:
```php
'order_id' => 'ORD-' . $orderId  // Your unique order ID
```

The system automatically rejects duplicate order_ids.

---

## Best Practices

1. **Always use server-side tracking** for production (more reliable than JavaScript)

2. **Store affiliate ref in database** when order is created (not just cookies)

3. **Set appropriate cookie duration** (30 days is standard)

4. **Handle API failures gracefully** - queue and retry if needed

5. **Clear cookies after conversion** to prevent duplicate tracking

6. **Use unique order IDs** to prevent duplicate commissions

7. **Test thoroughly** before going live

---

## Support

For technical support or questions about integration:

- Check the [API Documentation](./api.md)
- Review system logs in admin panel
- Contact system administrator

---

*Last updated: December 2024*
