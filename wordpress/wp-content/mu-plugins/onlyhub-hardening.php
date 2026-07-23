<?php
/**
 * Plugin Name: OnlyHUB Security Baseline
 * Description: Minimal production-safe WordPress defaults shared across environments.
 * Version: 0.1.0
 */

declared(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

add_filter('xmlrpc_enabled', '__return_false');
add_filter('the_generator', '__return_empty_string');
remove_action('wp_head', 'wp_generator');

add_action('send_headers', static function (): void {
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
});

add_filter('rest_authentication_errors', static function ($result) {
    if ($result !== null) {
        return $result;
    }

    return null;
});
