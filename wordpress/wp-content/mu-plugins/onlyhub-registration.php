<?php
/**
 * Controlled public registration for OnlyHUB.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

add_action('admin_post_nopriv_onlyhub_register', static function (): void {
    if (! isset($_POST['onlyhub_register_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['onlyhub_register_nonce'])), 'onlyhub_register')) {
        wp_die(esc_html__('Security check failed.', 'onlyhub'), 403);
    }

    if (! empty($_POST['website'])) {
        wp_safe_redirect(add_query_arg('registration', 'ok', home_url('/register/')));
        exit;
    }

    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $name  = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $role  = isset($_POST['role']) ? sanitize_key(wp_unslash($_POST['role'])) : 'onlyhub_donor';
    $agree = isset($_POST['privacy']) && '1' === $_POST['privacy'];

    $allowed_roles = ['onlyhub_donor', 'onlyhub_volunteer', 'onlyhub_partner'];
    if (! in_array($role, $allowed_roles, true)) {
        $role = 'onlyhub_donor';
    }

    if (! is_email($email) || '' === $name || ! $agree) {
        wp_safe_redirect(add_query_arg('registration', 'invalid', home_url('/register/')));
        exit;
    }

    if (email_exists($email)) {
        wp_safe_redirect(add_query_arg('registration', 'exists', home_url('/register/')));
        exit;
    }

    $base = sanitize_user(strstr($email, '@', true), true) ?: 'member';
    $login = $base;
    $suffix = 1;
    while (username_exists($login)) {
        $login = $base . $suffix;
        ++$suffix;
    }

    $password = wp_generate_password(24, true, true);
    $user_id = wp_create_user($login, $password, $email);

    if (is_wp_error($user_id)) {
        wp_safe_redirect(add_query_arg('registration', 'error', home_url('/register/')));
        exit;
    }

    $user = new WP_User($user_id);
    $user->set_role($role);
    wp_update_user(['ID' => $user_id, 'display_name' => $name, 'first_name' => $name]);

    update_user_meta($user_id, 'onlyhub_email_verified', 0);
    update_user_meta($user_id, 'onlyhub_registration_ip_hash', hash_hmac('sha256', sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'] ?? '')), wp_salt('auth')));

    wp_new_user_notification($user_id, null, 'user');

    wp_safe_redirect(add_query_arg('registration', 'ok', home_url('/register/')));
    exit;
});
