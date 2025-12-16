# Examples

This folder contains sample code for testing and integrating with the affiliate system.

## Files

### test-commission.php

A comprehensive PHP script to test commission generation. It demonstrates:

1. **Click Tracking** - How affiliate clicks are tracked
2. **Sale Conversion** - Recording a sale and generating commission
3. **Lead Conversion** - Recording a lead (form submission, signup, etc.)
4. **Duplicate Prevention** - How the system prevents duplicate commission for same order

#### Usage

1. Get a valid tracking code from an affiliate's tracking link
2. Edit the configuration in the script:
   ```php
   $config = [
       'base_url' => 'http://sistemaffiliate.test',
       'tracking_code' => 'YOUR_TRACKING_CODE',
   ];
   ```
3. Run the script:
   ```bash
   php examples/test-commission.php
   ```

#### Prerequisites

- Valid tracking code from an existing tracking link
- Active affiliate program
- Approved affiliate enrollment
- cURL extension enabled in PHP

## API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/track/{code}` | GET | Track click and get redirect URL |
| `/track/{code}` | GET | Track click and redirect to landing page |
| `/api/track/conversion` | POST | Record conversion and generate commission |

## Conversion Payload

```json
{
    "tracking_code": "abc123",
    "order_id": "ORDER-12345",
    "amount": 150.00,
    "type": "sale",
    "metadata": {
        "customer_email": "customer@example.com",
        "products": ["Product A", "Product B"]
    }
}
```

### Fields

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `tracking_code` | string | Yes | Affiliate's unique tracking code |
| `order_id` | string | No | Your order/transaction ID (prevents duplicates) |
| `amount` | number | Yes | Total order amount |
| `type` | string | No | `sale` or `lead` (defaults based on program type) |
| `metadata` | object | No | Additional data (customer info, products, etc.) |

## Commission Calculation

Commission is calculated based on program settings:

- **Percentage**: `amount * (commission_rate / 100)`
- **Fixed**: Flat commission amount per conversion

Example:
- Order Amount: $150.00
- Commission Rate: 10% (percentage)
- Commission Generated: $15.00
