<?php
/**
 * Plugin Name: Affiliate Tracker
 * Plugin URI: https://your-domain.com
 * Description: Integrate affiliate tracking with your WordPress site
 * Version: 1.0.0
 * Author: Your Company
 * License: GPL v2 or later
 * Text Domain: affiliate-tracker
 */

if (!defined('ABSPATH')) {
    exit;
}

class AffiliateTrackerPlugin
{
    private static ?AffiliateTrackerPlugin $instance = null;
    private string $apiKey = '';
    private string $apiUrl = '';
    private int $cookieDuration = 30;
    private string $cookieName = 'aff_ref';

    public static function getInstance(): AffiliateTrackerPlugin
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->loadSettings();
        $this->initHooks();
    }

    private function loadSettings(): void
    {
        $this->apiKey = get_option('affiliate_tracker_api_key', '');
        $this->apiUrl = get_option('affiliate_tracker_api_url', '');
        $this->cookieDuration = (int) get_option('affiliate_tracker_cookie_duration', 30);
    }

    private function initHooks(): void
    {
        // Admin hooks
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('admin_init', [$this, 'registerSettings']);

        // Frontend hooks
        add_action('init', [$this, 'processReferral']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);

        // WooCommerce integration
        add_action('woocommerce_thankyou', [$this, 'trackWooCommerceConversion']);
    }

    public function addAdminMenu(): void
    {
        add_options_page(
            __('Affiliate Tracker Settings', 'affiliate-tracker'),
            __('Affiliate Tracker', 'affiliate-tracker'),
            'manage_options',
            'affiliate-tracker',
            [$this, 'renderSettingsPage']
        );
    }

    public function registerSettings(): void
    {
        register_setting('affiliate_tracker_settings', 'affiliate_tracker_api_key');
        register_setting('affiliate_tracker_settings', 'affiliate_tracker_api_url');
        register_setting('affiliate_tracker_settings', 'affiliate_tracker_cookie_duration');

        add_settings_section(
            'affiliate_tracker_main',
            __('API Configuration', 'affiliate-tracker'),
            null,
            'affiliate-tracker'
        );

        add_settings_field(
            'affiliate_tracker_api_url',
            __('API URL', 'affiliate-tracker'),
            [$this, 'renderApiUrlField'],
            'affiliate-tracker',
            'affiliate_tracker_main'
        );

        add_settings_field(
            'affiliate_tracker_api_key',
            __('API Key', 'affiliate-tracker'),
            [$this, 'renderApiKeyField'],
            'affiliate-tracker',
            'affiliate_tracker_main'
        );

        add_settings_field(
            'affiliate_tracker_cookie_duration',
            __('Cookie Duration (days)', 'affiliate-tracker'),
            [$this, 'renderCookieDurationField'],
            'affiliate-tracker',
            'affiliate_tracker_main'
        );
    }

    public function renderSettingsPage(): void
    {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('Affiliate Tracker Settings', 'affiliate-tracker'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('affiliate_tracker_settings');
                do_settings_sections('affiliate-tracker');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function renderApiUrlField(): void
    {
        $value = get_option('affiliate_tracker_api_url', '');
        echo '<input type="url" name="affiliate_tracker_api_url" value="' . esc_attr($value) . '" class="regular-text" placeholder="https://your-domain.com/api" />';
        echo '<p class="description">' . esc_html__('The base URL of your affiliate tracking API', 'affiliate-tracker') . '</p>';
    }

    public function renderApiKeyField(): void
    {
        $value = get_option('affiliate_tracker_api_key', '');
        echo '<input type="text" name="affiliate_tracker_api_key" value="' . esc_attr($value) . '" class="regular-text" />';
        echo '<p class="description">' . esc_html__('Your API key for authentication', 'affiliate-tracker') . '</p>';
    }

    public function renderCookieDurationField(): void
    {
        $value = get_option('affiliate_tracker_cookie_duration', 30);
        echo '<input type="number" name="affiliate_tracker_cookie_duration" value="' . esc_attr($value) . '" min="1" max="365" />';
        echo '<p class="description">' . esc_html__('How long the referral cookie should be stored', 'affiliate-tracker') . '</p>';
    }

    public function processReferral(): void
    {
        if (!isset($_GET['ref'])) {
            return;
        }

        $ref = sanitize_text_field($_GET['ref']);
        $this->setCookie($ref);
    }

    public function enqueueScripts(): void
    {
        if (empty($this->apiUrl)) {
            return;
        }

        // Enqueue inline script to initialize tracker
        wp_add_inline_script('jquery', $this->getInlineScript(), 'after');
    }

    private function getInlineScript(): string
    {
        $trackingCode = $this->getTrackingCode();

        return "
        window.AffiliateTrackerConfig = {
            apiUrl: '" . esc_js($this->apiUrl) . "',
            apiKey: '" . esc_js($this->apiKey) . "',
            trackingCode: '" . esc_js($trackingCode ?? '') . "'
        };
        ";
    }

    public function trackWooCommerceConversion(int $orderId): void
    {
        $trackingCode = $this->getTrackingCode();

        if (!$trackingCode || empty($this->apiUrl)) {
            return;
        }

        $order = wc_get_order($orderId);
        if (!$order) {
            return;
        }

        // Check if already tracked
        if ($order->get_meta('_affiliate_tracked')) {
            return;
        }

        $response = $this->trackConversion([
            'order_id' => (string) $orderId,
            'amount' => (float) $order->get_total(),
            'type' => 'sale',
            'metadata' => [
                'customer_email' => $order->get_billing_email(),
                'items' => $this->getOrderItems($order)
            ]
        ]);

        if (!empty($response['success'])) {
            $order->update_meta_data('_affiliate_tracked', true);
            $order->update_meta_data('_affiliate_code', $trackingCode);
            $order->save();
        }
    }

    private function getOrderItems($order): array
    {
        $items = [];
        foreach ($order->get_items() as $item) {
            $items[] = [
                'name' => $item->get_name(),
                'quantity' => $item->get_quantity(),
                'total' => $item->get_total()
            ];
        }
        return $items;
    }

    public function trackConversion(array $data): array
    {
        $trackingCode = $this->getTrackingCode();

        if (!$trackingCode) {
            return ['success' => false, 'message' => 'No tracking code'];
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
        $expires = time() + ($this->cookieDuration * DAY_IN_SECONDS);
        setcookie($this->cookieName, $value, $expires, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), false);
        $_COOKIE[$this->cookieName] = $value;
    }

    public function getTrackingCode(): ?string
    {
        return isset($_COOKIE[$this->cookieName]) ? sanitize_text_field($_COOKIE[$this->cookieName]) : null;
    }

    private function sendRequest(string $method, string $endpoint, array $data = []): array
    {
        $url = rtrim($this->apiUrl, '/') . $endpoint;

        $args = [
            'method' => $method,
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ];

        if ($this->apiKey) {
            $args['headers']['X-API-Key'] = $this->apiKey;
        }

        if ($method === 'POST' && !empty($data)) {
            $args['body'] = wp_json_encode($data);
        }

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message()
            ];
        }

        $body = wp_remote_retrieve_body($response);
        $decoded = json_decode($body, true) ?? [];
        $decoded['success'] = wp_remote_retrieve_response_code($response) >= 200
            && wp_remote_retrieve_response_code($response) < 300;

        return $decoded;
    }
}

// Initialize plugin
AffiliateTrackerPlugin::getInstance();

// Helper function for template use
function affiliate_tracker_track_conversion(array $data): array
{
    return AffiliateTrackerPlugin::getInstance()->trackConversion($data);
}

function affiliate_tracker_get_code(): ?string
{
    return AffiliateTrackerPlugin::getInstance()->getTrackingCode();
}
