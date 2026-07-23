<?php
/**
 * Plugin Name: OnlyHUB Audit Log
 * Description: Records high-value administrative events as private immutable records.
 * Version: 0.1.0
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

add_action('init', static function (): void {
    register_post_type('oh_audit_event', [
        'labels' => [
            'name'          => __('Audit log', 'onlyhub'),
            'singular_name' => __('Audit event', 'onlyhub'),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => 'tools.php',
        'exclude_from_search' => true,
        'menu_icon'           => 'dashicons-shield-alt',
        'supports'            => ['title'],
        'capabilities'        => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap'        => true,
    ]);
});

function onlyhub_write_audit_event(string $event, array $context = [], int $actor_id = 0): int
{
    $actor_id = $actor_id > 0 ? $actor_id : get_current_user_id();
    $safe_context = [];

    foreach ($context as $key => $value) {
        $safe_key = sanitize_key((string) $key);
        if ($safe_key === '' || str_contains($safe_key, 'password') || str_contains($safe_key, 'secret') || str_contains($safe_key, 'token')) {
            continue;
        }
        $safe_context[$safe_key] = is_scalar($value) || $value === null ? $value : wp_json_encode($value);
    }

    $event_id = wp_insert_post([
        'post_type'   => 'oh_audit_event',
        'post_status' => 'private',
        'post_title'  => sprintf('%s — %s', sanitize_text_field($event), current_time('mysql', true)),
        'meta_input'  => [
            '_onlyhub_event'       => sanitize_key($event),
            '_onlyhub_actor_id'    => $actor_id,
            '_onlyhub_occurred_at' => current_time('mysql', true),
            '_onlyhub_context'     => wp_json_encode($safe_context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            '_onlyhub_ip_hash'     => hash('sha256', (string) ($_SERVER['REMOTE_ADDR'] ?? '') . wp_salt('auth')),
        ],
    ], true);

    return is_wp_error($event_id) ? 0 : (int) $event_id;
}

add_action('onlyhub_application_status_changed', static function (int $application_id, string $old_status, string $new_status, int $actor_id): void {
    onlyhub_write_audit_event('application_status_changed', [
        'application_id' => $application_id,
        'old_status'     => $old_status,
        'new_status'     => $new_status,
    ], $actor_id);
}, 10, 4);

add_action('set_user_role', static function (int $user_id, string $role, array $old_roles): void {
    onlyhub_write_audit_event('user_role_changed', [
        'user_id'   => $user_id,
        'new_role'  => $role,
        'old_roles' => $old_roles,
    ]);
}, 10, 3);

add_action('wp_login', static function (string $user_login, WP_User $user): void {
    if (array_intersect(['administrator', 'editor', 'onlyhub_coordinator'], $user->roles)) {
        onlyhub_write_audit_event('privileged_login', [
            'user_id'    => $user->ID,
            'user_login' => $user_login,
        ], $user->ID);
    }
}, 10, 2);

add_filter('user_has_cap', static function (array $allcaps, array $caps, array $args, WP_User $user): array {
    if (($args[0] ?? '') !== 'delete_post' || empty($args[2])) {
        return $allcaps;
    }
    $post = get_post((int) $args[2]);
    if ($post && $post->post_type === 'oh_audit_event') {
        $allcaps['delete_post'] = false;
    }
    return $allcaps;
}, 10, 4);

add_filter('manage_oh_audit_event_posts_columns', static function (array $columns): array {
    return [
        'title'      => __('Event', 'onlyhub'),
        'oh_actor'   => __('Actor', 'onlyhub'),
        'oh_context' => __('Context', 'onlyhub'),
        'date'       => __('Recorded', 'onlyhub'),
    ];
});

add_action('manage_oh_audit_event_posts_custom_column', static function (string $column, int $post_id): void {
    if ($column === 'oh_actor') {
        $user = get_userdata((int) get_post_meta($post_id, '_onlyhub_actor_id', true));
        echo esc_html($user ? $user->user_login : __('System', 'onlyhub'));
    }
    if ($column === 'oh_context') {
        $context = (string) get_post_meta($post_id, '_onlyhub_context', true);
        echo '<code>' . esc_html(mb_strimwidth($context, 0, 180, '…')) . '</code>';
    }
}, 10, 2);

add_action('admin_head-edit.php', static function (): void {
    $screen = get_current_screen();
    if ($screen && $screen->post_type === 'oh_audit_event') {
        echo '<style>.post-type-oh_audit_event .page-title-action,.post-type-oh_audit_event .row-actions .trash{display:none}</style>';
    }
});
