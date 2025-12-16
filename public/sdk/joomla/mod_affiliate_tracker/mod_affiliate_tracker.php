<?php
/**
 * @package     Joomla.Module
 * @subpackage  mod_affiliate_tracker
 * @copyright   Copyright (C) Your Company. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Uri\Uri;

class ModAffiliateTrackerHelper
{
    private static ?ModAffiliateTrackerHelper $instance = null;
    private string $apiKey;
    private string $apiUrl;
    private int $cookieDuration;
    private string $cookieName = 'aff_ref';

    public static function getInstance($params = null): ModAffiliateTrackerHelper
    {
        if (self::$instance === null) {
            self::$instance = new self($params);
        }
        return self::$instance;
    }

    public function __construct($params = null)
    {
        $this->apiKey = $params ? $params->get('api_key', '') : '';
        $this->apiUrl = $params ? rtrim($params->get('api_url', ''), '/') : '';
        $this->cookieDuration = $params ? (int) $params->get('cookie_duration', 30) : 30;
    }

    public function processReferral(): void
    {
        $app = Factory::getApplication();
        $ref = $app->input->get('ref', '', 'STRING');

        if (!empty($ref)) {
            $this->setCookie($ref);
        }
    }

    public function getTrackingCode(): ?string
    {
        return isset($_COOKIE[$this->cookieName]) ? filter_var($_COOKIE[$this->cookieName], FILTER_SANITIZE_STRING) : null;
    }

    public function trackConversion(array $data): array
    {
        $trackingCode = $this->getTrackingCode();

        if (!$trackingCode) {
            return ['success' => false, 'message' => 'No tracking code found'];
        }

        $payload = [
            'tracking_code' => $trackingCode,
            'order_id' => $data['order_id'] ?? null,
            'amount' => $data['amount'] ?? 0,
            'type' => $data['type'] ?? 'sale',
            'metadata' => $data['metadata'] ?? []
        ];

        return $this->sendRequest('POST', '/track/conversion', $payload);
    }

    private function setCookie(string $value): void
    {
        $expires = time() + ($this->cookieDuration * 24 * 60 * 60);
        $secure = Uri::getInstance()->getScheme() === 'https';

        setcookie(
            $this->cookieName,
            $value,
            [
                'expires' => $expires,
                'path' => '/',
                'secure' => $secure,
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
            return [
                'success' => false,
                'message' => 'Request failed: ' . $error
            ];
        }

        $decoded = json_decode($response, true) ?? [];
        $decoded['success'] = $httpCode >= 200 && $httpCode < 300;

        return $decoded;
    }

    public function getJsConfig(): string
    {
        $trackingCode = $this->getTrackingCode();

        return json_encode([
            'apiUrl' => $this->apiUrl,
            'apiKey' => $this->apiKey,
            'trackingCode' => $trackingCode ?? ''
        ]);
    }
}

// Initialize and process referral
$helper = ModAffiliateTrackerHelper::getInstance($params);
$helper->processReferral();

// Load template
require ModuleHelper::getLayoutPath('mod_affiliate_tracker', $params->get('layout', 'default'));
