# Affiliate Management System - API Documentation

## Overview

This document describes the REST API for the Affiliate Management System. The API uses JSON for request and response bodies, and requires authentication via Laravel Sanctum bearer tokens.

## Base URL

```
https://your-domain.com/api
```

## Authentication

All API endpoints (except public tracking endpoints) require authentication using Bearer tokens.

### Obtaining a Token

**POST** `/api/auth/login`

Request:
```json
{
    "email": "user@example.com",
    "password": "password123"
}
```

Response:
```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "user@example.com",
        "role": "affiliate"
    },
    "token": "1|abc123xyz..."
}
```

### Using the Token

Include the token in the Authorization header:
```
Authorization: Bearer 1|abc123xyz...
```

### Logout

**POST** `/api/auth/logout`

Response:
```json
{
    "message": "Logged out successfully"
}
```

---

## Programs

### List All Programs

**GET** `/api/programs`

Query Parameters:
- `page` (int): Page number for pagination
- `per_page` (int): Items per page (default: 15)
- `search` (string): Search by name or description
- `active_only` (boolean): Filter active programs only

Response:
```json
{
    "data": [
        {
            "id": 1,
            "name": "Premium Affiliate Program",
            "slug": "premium-affiliate",
            "description": "Earn commissions on premium products",
            "commission_type": "percentage",
            "commission_value": "15.00",
            "cookie_duration": 30,
            "min_payout": "50.00",
            "is_active": true,
            "requires_approval": true,
            "created_at": "2024-01-15T10:00:00Z",
            "products_count": 25
        }
    ],
    "links": {
        "first": "...",
        "last": "...",
        "prev": null,
        "next": "..."
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "per_page": 15,
        "to": 15,
        "total": 72
    }
}
```

### Get Program Details

**GET** `/api/programs/{id}`

Response:
```json
{
    "data": {
        "id": 1,
        "name": "Premium Affiliate Program",
        "slug": "premium-affiliate",
        "description": "Earn commissions on premium products",
        "commission_type": "percentage",
        "commission_value": "15.00",
        "cookie_duration": 30,
        "min_payout": "50.00",
        "terms": "Terms and conditions...",
        "is_active": true,
        "requires_approval": true,
        "created_at": "2024-01-15T10:00:00Z",
        "products": [...]
    }
}
```

### Enroll in Program

**POST** `/api/programs/{id}/enroll`

Request:
```json
{
    "notes": "Optional enrollment notes"
}
```

Response:
```json
{
    "message": "Enrollment request submitted successfully",
    "enrollment": {
        "id": 1,
        "program_id": 1,
        "user_id": 5,
        "status": "pending",
        "created_at": "2024-01-20T14:30:00Z"
    }
}
```

---

## Enrollments

### List My Enrollments

**GET** `/api/enrollments`

Query Parameters:
- `status` (string): Filter by status (pending, approved, rejected)

Response:
```json
{
    "data": [
        {
            "id": 1,
            "program": {
                "id": 1,
                "name": "Premium Affiliate Program"
            },
            "status": "approved",
            "custom_commission_type": null,
            "custom_commission_value": null,
            "approved_at": "2024-01-21T09:00:00Z",
            "created_at": "2024-01-20T14:30:00Z"
        }
    ]
}
```

---

## Tracking Links

### List My Links

**GET** `/api/links`

Query Parameters:
- `program_id` (int): Filter by program
- `page` (int): Page number

Response:
```json
{
    "data": [
        {
            "id": 1,
            "name": "Homepage Banner",
            "code": "abc123",
            "url": "https://your-domain.com/track/abc123",
            "program": {
                "id": 1,
                "name": "Premium Affiliate Program"
            },
            "product": null,
            "campaign": "summer-sale",
            "clicks_count": 1250,
            "conversions_count": 45,
            "created_at": "2024-01-22T11:00:00Z"
        }
    ]
}
```

### Create Tracking Link

**POST** `/api/links`

Request:
```json
{
    "program_id": 1,
    "product_id": null,
    "name": "New Campaign Link",
    "destination_url": "https://example.com/product",
    "campaign": "winter-promo"
}
```

Response:
```json
{
    "data": {
        "id": 2,
        "name": "New Campaign Link",
        "code": "xyz789",
        "url": "https://your-domain.com/track/xyz789",
        "program_id": 1,
        "product_id": null,
        "campaign": "winter-promo",
        "created_at": "2024-01-25T16:00:00Z"
    }
}
```

### Get Link Statistics

**GET** `/api/links/{id}/stats`

Query Parameters:
- `period` (string): today, week, month, year, all (default: month)

Response:
```json
{
    "data": {
        "link_id": 1,
        "period": "month",
        "clicks": 1250,
        "unique_clicks": 980,
        "conversions": 45,
        "conversion_rate": 4.59,
        "revenue": "2250.00",
        "commissions": "337.50",
        "daily_stats": [
            {
                "date": "2024-01-01",
                "clicks": 42,
                "conversions": 2,
                "revenue": "100.00"
            }
        ]
    }
}
```

### Delete Link

**DELETE** `/api/links/{id}`

Response:
```json
{
    "message": "Link deleted successfully"
}
```

---

## Commissions

### List My Commissions

**GET** `/api/commissions`

Query Parameters:
- `status` (string): pending, approved, paid, rejected
- `program_id` (int): Filter by program
- `from_date` (date): Start date (YYYY-MM-DD)
- `to_date` (date): End date (YYYY-MM-DD)
- `page` (int): Page number

Response:
```json
{
    "data": [
        {
            "id": 1,
            "conversion": {
                "id": 1,
                "order_id": "ORD-12345",
                "amount": "150.00"
            },
            "program": {
                "id": 1,
                "name": "Premium Affiliate Program"
            },
            "amount": "22.50",
            "status": "approved",
            "approved_at": "2024-01-26T10:00:00Z",
            "created_at": "2024-01-25T18:30:00Z"
        }
    ],
    "meta": {
        "total_pending": "150.00",
        "total_approved": "500.00",
        "total_paid": "2000.00"
    }
}
```

### Get Commission Details

**GET** `/api/commissions/{id}`

Response:
```json
{
    "data": {
        "id": 1,
        "conversion": {
            "id": 1,
            "order_id": "ORD-12345",
            "amount": "150.00",
            "customer_email": "customer@example.com",
            "product_name": "Premium Widget",
            "created_at": "2024-01-25T18:30:00Z"
        },
        "tracking_link": {
            "id": 1,
            "name": "Homepage Banner",
            "campaign": "summer-sale"
        },
        "program": {
            "id": 1,
            "name": "Premium Affiliate Program",
            "commission_type": "percentage",
            "commission_value": "15.00"
        },
        "amount": "22.50",
        "status": "approved",
        "approved_at": "2024-01-26T10:00:00Z",
        "created_at": "2024-01-25T18:30:00Z"
    }
}
```

---

## Payouts

### List My Payouts

**GET** `/api/payouts`

Query Parameters:
- `status` (string): pending, approved, processing, completed, failed
- `page` (int): Page number

Response:
```json
{
    "data": [
        {
            "id": 1,
            "amount": "500.00",
            "fee": "5.00",
            "total_amount": "495.00",
            "status": "completed",
            "payment_method": {
                "type": "paypal",
                "details": {
                    "email": "affiliate@example.com"
                }
            },
            "transaction_id": "TXN-123456",
            "processed_at": "2024-01-28T14:00:00Z",
            "created_at": "2024-01-27T09:00:00Z"
        }
    ]
}
```

### Request Payout

**POST** `/api/payouts`

Request:
```json
{
    "payment_method_id": 1,
    "amount": null
}
```

Note: If `amount` is null, all available balance will be requested.

Response:
```json
{
    "message": "Payout request submitted successfully",
    "data": {
        "id": 2,
        "amount": "350.00",
        "fee": "3.50",
        "total_amount": "346.50",
        "status": "pending",
        "created_at": "2024-01-30T11:00:00Z"
    }
}
```

### Get Available Balance

**GET** `/api/payouts/balance`

Response:
```json
{
    "data": {
        "available_balance": "350.00",
        "pending_commissions": "125.00",
        "pending_payouts": "0.00",
        "lifetime_earnings": "2500.00",
        "lifetime_payouts": "2000.00"
    }
}
```

---

## Payment Methods

### List My Payment Methods

**GET** `/api/payment-methods`

Response:
```json
{
    "data": [
        {
            "id": 1,
            "type": "paypal",
            "details": {
                "email": "affiliate@example.com"
            },
            "is_primary": true,
            "is_active": true,
            "created_at": "2024-01-15T10:00:00Z"
        }
    ]
}
```

### Add Payment Method

**POST** `/api/payment-methods`

Request (PayPal):
```json
{
    "type": "paypal",
    "details": {
        "email": "affiliate@example.com"
    },
    "is_primary": true
}
```

Request (Bank Transfer):
```json
{
    "type": "bank_transfer",
    "details": {
        "bank_name": "Bank of America",
        "account_name": "John Doe",
        "account_number": "123456789",
        "routing_number": "021000021",
        "swift_code": "BOFAUS3N"
    },
    "is_primary": false
}
```

Request (Crypto):
```json
{
    "type": "crypto",
    "details": {
        "wallet_address": "0x1234...",
        "crypto_network": "ethereum"
    },
    "is_primary": false
}
```

Response:
```json
{
    "data": {
        "id": 2,
        "type": "bank_transfer",
        "details": {
            "bank_name": "Bank of America",
            "account_name": "John Doe",
            "account_number": "****6789"
        },
        "is_primary": false,
        "is_active": true,
        "created_at": "2024-01-30T12:00:00Z"
    }
}
```

### Update Payment Method

**PUT** `/api/payment-methods/{id}`

Request:
```json
{
    "details": {
        "email": "new-email@example.com"
    },
    "is_primary": true
}
```

### Delete Payment Method

**DELETE** `/api/payment-methods/{id}`

Response:
```json
{
    "message": "Payment method deleted successfully"
}
```

---

## Statistics & Reports

### Get Dashboard Statistics

**GET** `/api/stats/dashboard`

Response:
```json
{
    "data": {
        "today": {
            "clicks": 125,
            "conversions": 5,
            "revenue": "250.00",
            "commissions": "37.50"
        },
        "this_month": {
            "clicks": 3250,
            "conversions": 145,
            "revenue": "7250.00",
            "commissions": "1087.50"
        },
        "available_balance": "587.50",
        "pending_commissions": "250.00",
        "top_programs": [
            {
                "program_id": 1,
                "program_name": "Premium Affiliate",
                "conversions": 85,
                "revenue": "4250.00",
                "commissions": "637.50"
            }
        ]
    }
}
```

### Get Performance Report

**GET** `/api/stats/performance`

Query Parameters:
- `period` (string): today, week, month, year (default: month)
- `program_id` (int): Filter by program (optional)

Response:
```json
{
    "data": {
        "summary": {
            "total_clicks": 3250,
            "unique_clicks": 2800,
            "total_conversions": 145,
            "conversion_rate": 5.18,
            "total_revenue": "7250.00",
            "total_commissions": "1087.50",
            "avg_order_value": "50.00"
        },
        "chart_data": [
            {
                "date": "2024-01-01",
                "clicks": 105,
                "conversions": 5,
                "revenue": "250.00",
                "commissions": "37.50"
            }
        ]
    }
}
```

---

## Tracking (Public Endpoints)

These endpoints do not require authentication and are used for tracking affiliate clicks and conversions.

### Track Click (Redirect)

**GET** `/track/{code}`

This endpoint redirects the visitor to the destination URL while recording the click.

Query Parameters:
- `sub1` to `sub5` (string): Custom tracking parameters (optional)

### Record Conversion (Webhook)

**POST** `/api/conversions`

Headers:
```
X-API-Key: your-api-key
Content-Type: application/json
```

Request:
```json
{
    "tracking_code": "abc123",
    "order_id": "ORD-12345",
    "amount": 150.00,
    "currency": "USD",
    "customer_email": "customer@example.com",
    "customer_id": "CUST-001",
    "product_name": "Premium Widget",
    "metadata": {
        "coupon_used": "SAVE10",
        "shipping_method": "express"
    }
}
```

Response:
```json
{
    "success": true,
    "message": "Conversion recorded successfully",
    "data": {
        "conversion_id": 1,
        "commission_id": 1,
        "commission_amount": "22.50"
    }
}
```

### Validate Tracking Code

**GET** `/api/track/validate/{code}`

Response:
```json
{
    "valid": true,
    "program": {
        "id": 1,
        "name": "Premium Affiliate Program"
    },
    "affiliate": {
        "id": 5,
        "name": "John Doe"
    }
}
```

---

## Error Responses

All error responses follow this format:

```json
{
    "message": "Error description",
    "errors": {
        "field_name": [
            "Validation error message"
        ]
    }
}
```

### HTTP Status Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 422 | Validation Error |
| 429 | Too Many Requests |
| 500 | Internal Server Error |

---

## Rate Limiting

API requests are limited to:
- **Authenticated users**: 60 requests per minute
- **Public tracking endpoints**: 1000 requests per minute

Rate limit headers:
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 58
X-RateLimit-Reset: 1706540400
```

---

## Webhooks

The system can send webhooks for various events. Configure webhook URLs in the admin settings.

### Events

- `enrollment.approved` - When an enrollment is approved
- `enrollment.rejected` - When an enrollment is rejected
- `commission.created` - When a new commission is created
- `commission.approved` - When a commission is approved
- `commission.paid` - When a commission is marked as paid
- `payout.completed` - When a payout is completed
- `payout.failed` - When a payout fails

### Webhook Payload

```json
{
    "event": "commission.approved",
    "timestamp": "2024-01-30T12:00:00Z",
    "data": {
        "commission_id": 1,
        "amount": "22.50",
        "affiliate_id": 5,
        "program_id": 1
    }
}
```

### Webhook Signature

All webhooks include a signature header for verification:
```
X-Webhook-Signature: sha256=abc123...
```

Verify using:
```php
$signature = hash_hmac('sha256', $payload, $webhookSecret);
```

---

## SDK Examples

### PHP (cURL)

```php
<?php
$token = 'your-api-token';
$baseUrl = 'https://your-domain.com/api';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/programs');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Accept: application/json',
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$programs = json_decode($response, true);
curl_close($ch);
```

### JavaScript (Fetch)

```javascript
const token = 'your-api-token';
const baseUrl = 'https://your-domain.com/api';

fetch(`${baseUrl}/programs`, {
    headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
    }
})
.then(response => response.json())
.then(data => console.log(data.data));
```

### Recording Conversions (Server-Side)

```php
<?php
// After order completion
$conversionData = [
    'tracking_code' => $_COOKIE['affiliate_code'] ?? null,
    'order_id' => $order->id,
    'amount' => $order->total,
    'customer_email' => $order->customer_email,
];

if ($conversionData['tracking_code']) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://your-domain.com/api/conversions');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-API-Key: your-api-key',
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($conversionData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
}
```
