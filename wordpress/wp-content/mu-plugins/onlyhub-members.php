<?php
/**
 * OnlyHUB member roles and access controls.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

add_action('init', static function (): void {
    add_role('onlyhub_donor', __('OnlyHUB Donor', 'onlyhub'), [
        'read' => true,
    ]);

    add_role('onlyhub_volunteer', __('OnlyHUB Volunteer', 'onlyhub'), [
        'read' => true,
        'upload_files' => true,
    ]);

    add_role('onlyhub_partner', __('OnlyHUB Partner', 'onlyhub'), [
        'read' => true,
        'upload_files' => true,
    ]);

    add_role('onlyhub_coordinator', __('OnlyHUB Coordinator', 'onlyhub'), [
        'read' => true,
        'edit_posts' => true,
        'edit_oh_projects' => true,
        'edit_oh_campaigns' => true,
        'edit_oh_partners' => true,
    ]);
});

add_filter('show_admin_bar', static function (bool $show): bool {
    if (! is_user_logged_in()) {
        return $show;
    }

    return current_user_can('edit_posts');
});

add_action('admin_init', static function (): void {
    if (! is_admin() || wp_doing_ajax()) {
        return;
    }

    if (! current_user_can('edit_posts')) {
        wp_safe_redirect(home_url('/dashboard/'));
        exit;
    }
});

add_filter('login_redirect', static function (string $redirectTo, string $requested, $user): string {
    if ($user instanceof WP_User && ! user_can($user, 'edit_posts')) {
        return home_url('/dashboard/');
    }

    return $redirectTo;
}, 10, 3);

add_action('wp_logout', static function (): void {
    wp_safe_redirect(home_url('/'));
    exit;
});
