<?php
/**
 * Affiliate Tracking SDK for PHP Sites
 *
 * Usage:
 * require_once 'AffiliateTracker.php';
 *
 * $tracker = new AffiliateTracker([
 *     'api_key' => 'YOUR_API_KEY',
 *     'api_url' => 'https://your-domain.com/api'
 * ]);
 *
 * // Process referral from URL
 * $tracker->processReferral();
 *
 * // Track conversion
 * $tracker->trackConversion([
 *     'order_id' => '12345',
 *     'amount' => 99.99,
 *     'type' => 'sale'
 * ]);
 */

class AffiliateTracker
{
    private string $apiKey;
    private string $apiUrl;
    private int $cookieDuration = 30; // days
    private string $cookieName = 'aff_ref';
    private bool $debug = false;

    public function __construct(array $config = [])
    {
        $this->apiKey = $config['api_key'] ?? '';
        $this->apiUrl = rtrim($config['api_url'] ?? '', '/');
        $this->cookieDuration = $config['cookie_duration'] ?? 30;
        $this->cookieName = $config['cookie_name'] ?? 'aff_ref';
        $this->debug = $config['debug'] ?? false;
    }

    public function processReferral(): ?string
    {
        $ref = $_GET['ref'] ?? null;

        if ($ref) {
            $this->setCookie($ref);
            $this->log("Referral processed: {$ref}");
            return $ref;
        }

        return null;
    }

    public function getTrackingCode(): ?string
    {
        return $_COOKIE[$this->cookieName] ?? null;
    }

    public function trackConversion(array $data): array
    {
        $trackingCode = $this->getTrackingCode();

        if (!$trackingCode) {
            $this->log('No tracking code found, skipping conversion');
            return [
                'success' => false,
                'message' => 'No tracking code found'
            ];
        }

        $payload = [
            'tracking_code' => $trackingCode,
            'order_id' => $data['order_id'] ?? null,
            'amount' => $data['amount'] ?? 0,
            'type' => $data['type'] ?? 'sale',
            'metadata' => $data['metadata'] ?? []
        ];

        $response = $this->sendRequest('POST', '/track/conversion', $payload);
        $this->log('Conversion tracked: ' . json_encode($response));

        return $response;
    }

    public function generateTrackingUrl(string $baseUrl, string $trackingCode): string
    {
        $separator = strpos($baseUrl, '?') !== false ? '&' : '?';
        return $baseUrl . $separator . 'ref=' . urlencode($trackingCode);
    }

    private function setCookie(string $value): void
    {
        $expires = time() + ($this->cookieDuration * 24 * 60 * 60);
        setcookie(
            $this->cookieName,
            $value,
            [
                'expires' => $expires,
                'path' => '/',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => false,
                'samesite' => 'Lax'
            ]
        );
        $_COOKIE[$this->cookieName] = $value;
    }

    private function sendRequest(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->apiUrl . $endpoint;

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        if ($this->apiKey) {
            $headers[] = 'X-API-Key: ' . $this->apiKey;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            $this->log('cURL error: ' . $error);
            return [
                'success' => false,
                'message' => 'Request failed: ' . $error
            ];
        }

        $decoded = json_decode($response, true) ?? [];
        $decoded['success'] = $httpCode >= 200 && $httpCode < 300;

        return $decoded;
    }

    private function log(string $message): void
    {
        if ($this->debug) {
            error_log('[AffiliateTracker] ' . $message);
        }
    }
}
