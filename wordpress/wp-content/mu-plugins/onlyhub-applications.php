<?php
/**
 * Plugin Name: OnlyHUB Applications
 * Description: Stores validated partnership and volunteer applications as private records.
 * Version: 0.1.0
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

add_action('init', static function (): void {
    register_post_type('oh_application', [
        'labels' => [
            'name'          => __('Applications', 'onlyhub'),
            'singular_name' => __('Application', 'onlyhub'),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'exclude_from_search' => true,
        'menu_icon'           => 'dashicons-feedback',
        'supports'            => ['title', 'editor', 'custom-fields'],
        'capability_type'      => 'post',
        'map_meta_cap'         => true,
    ]);
});

add_action('admin_post_nopriv_onlyhub_submit_application', 'onlyhub_handle_application');
add_action('admin_post_onlyhub_submit_application', 'onlyhub_handle_application');

function onlyhub_handle_application(): void
{
    $redirect = wp_get_referer() ?: home_url('/');

    if (! isset($_POST['onlyhub_application_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['onlyhub_application_nonce'])), 'onlyhub_application')) {
        wp_safe_redirect(add_query_arg('application', 'invalid', $redirect));
        exit;
    }

    $honeypot = isset($_POST['company_website']) ? trim((string) wp_unslash($_POST['company_website'])) : '';
    if ($honeypot !== '') {
        wp_safe_redirect(add_query_arg('application', 'received', $redirect));
        exit;
    }

    $name    = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $type    = sanitize_key(wp_unslash($_POST['application_type'] ?? 'general'));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));
    $consent = isset($_POST['privacy_consent']);

    if ($name === '' || ! is_email($email) || mb_strlen($message) < 20 || ! $consent) {
        wp_safe_redirect(add_query_arg('application', 'invalid', $redirect));
        exit;
    }

    $allowed_types = ['partner', 'volunteer', 'donor', 'media', 'general'];
    if (! in_array($type, $allowed_types, true)) {
        $type = 'general';
    }

    $application_id = wp_insert_post([
        'post_type'    => 'oh_application',
        'post_status'  => 'private',
        'post_title'   => sprintf('%s — %s', $name, current_time('Y-m-d H:i')),
        'post_content' => $message,
        'meta_input'   => [
            '_onlyhub_email' => $email,
            '_onlyhub_type'  => $type,
            '_onlyhub_ip_hash' => hash('sha256', (string) ($_SERVER['REMOTE_ADDR'] ?? '') . wp_salt('auth')),
        ],
    ], true);

    $status = is_wp_error($application_id) ? 'error' : 'received';
    wp_safe_redirect(add_query_arg('application', $status, $redirect));
    exit;
}
