<?php
/**
 * Plugin Name: OnlyHUB Applications
 * Description: Stores and manages validated partnership, donor, media and volunteer applications.
 * Version: 0.2.0
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

const ONLYHUB_APPLICATION_STATUSES = [
    'new'         => 'New',
    'in_review'   => 'In review',
    'approved'    => 'Approved',
    'rejected'    => 'Rejected',
    'archived'    => 'Archived',
];

add_action('init', static function (): void {
    register_post_type('oh_application', [
        'labels' => [
            'name'          => __('Applications', 'onlyhub'),
            'singular_name' => __('Application', 'onlyhub'),
            'menu_name'     => __('Applications', 'onlyhub'),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'exclude_from_search' => true,
        'menu_icon'           => 'dashicons-feedback',
        'supports'            => ['title', 'editor'],
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
            '_onlyhub_name'      => $name,
            '_onlyhub_email'     => $email,
            '_onlyhub_type'      => $type,
            '_onlyhub_status'    => 'new',
            '_onlyhub_ip_hash'   => hash('sha256', (string) ($_SERVER['REMOTE_ADDR'] ?? '') . wp_salt('auth')),
            '_onlyhub_consent_at'=> current_time('mysql', true),
        ],
    ], true);

    $status = is_wp_error($application_id) ? 'error' : 'received';
    wp_safe_redirect(add_query_arg('application', $status, $redirect));
    exit;
}

add_action('add_meta_boxes_oh_application', static function (): void {
    add_meta_box(
        'onlyhub_application_details',
        __('Application details', 'onlyhub'),
        'onlyhub_render_application_details',
        'oh_application',
        'normal',
        'high'
    );
});

function onlyhub_render_application_details(WP_Post $post): void
{
    wp_nonce_field('onlyhub_save_application', 'onlyhub_application_admin_nonce');
    $status = (string) get_post_meta($post->ID, '_onlyhub_status', true);
    $status = array_key_exists($status, ONLYHUB_APPLICATION_STATUSES) ? $status : 'new';
    ?>
    <p><strong><?php esc_html_e('Name:', 'onlyhub'); ?></strong> <?php echo esc_html((string) get_post_meta($post->ID, '_onlyhub_name', true)); ?></p>
    <p><strong><?php esc_html_e('Email:', 'onlyhub'); ?></strong> <a href="mailto:<?php echo esc_attr((string) get_post_meta($post->ID, '_onlyhub_email', true)); ?>"><?php echo esc_html((string) get_post_meta($post->ID, '_onlyhub_email', true)); ?></a></p>
    <p><strong><?php esc_html_e('Type:', 'onlyhub'); ?></strong> <?php echo esc_html((string) get_post_meta($post->ID, '_onlyhub_type', true)); ?></p>
    <p>
        <label for="onlyhub_application_status"><strong><?php esc_html_e('Workflow status', 'onlyhub'); ?></strong></label><br>
        <select id="onlyhub_application_status" name="onlyhub_application_status">
            <?php foreach (ONLYHUB_APPLICATION_STATUSES as $value => $label) : ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($status, $value); ?>><?php echo esc_html__($label, 'onlyhub'); ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <?php
}

add_action('save_post_oh_application', static function (int $post_id): void {
    if (wp_is_post_revision($post_id) || ! current_user_can('edit_post', $post_id)) {
        return;
    }
    if (! isset($_POST['onlyhub_application_admin_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['onlyhub_application_admin_nonce'])), 'onlyhub_save_application')) {
        return;
    }

    $new_status = sanitize_key(wp_unslash($_POST['onlyhub_application_status'] ?? 'new'));
    if (! array_key_exists($new_status, ONLYHUB_APPLICATION_STATUSES)) {
        return;
    }

    $old_status = (string) get_post_meta($post_id, '_onlyhub_status', true);
    update_post_meta($post_id, '_onlyhub_status', $new_status);
    update_post_meta($post_id, '_onlyhub_status_updated_at', current_time('mysql', true));
    update_post_meta($post_id, '_onlyhub_status_updated_by', get_current_user_id());

    if ($old_status !== $new_status) {
        do_action('onlyhub_application_status_changed', $post_id, $old_status, $new_status, get_current_user_id());
    }
});

add_filter('manage_oh_application_posts_columns', static function (array $columns): array {
    return [
        'cb'        => $columns['cb'] ?? '<input type="checkbox" />',
        'title'     => __('Applicant', 'onlyhub'),
        'oh_type'   => __('Type', 'onlyhub'),
        'oh_email'  => __('Email', 'onlyhub'),
        'oh_status' => __('Status', 'onlyhub'),
        'date'      => __('Received', 'onlyhub'),
    ];
});

add_action('manage_oh_application_posts_custom_column', static function (string $column, int $post_id): void {
    if ($column === 'oh_type') {
        echo esc_html((string) get_post_meta($post_id, '_onlyhub_type', true));
    }
    if ($column === 'oh_email') {
        $email = (string) get_post_meta($post_id, '_onlyhub_email', true);
        echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
    }
    if ($column === 'oh_status') {
        $status = (string) get_post_meta($post_id, '_onlyhub_status', true);
        echo esc_html(ONLYHUB_APPLICATION_STATUSES[$status] ?? __('New', 'onlyhub'));
    }
}, 10, 2);

add_action('restrict_manage_posts', static function (string $post_type): void {
    if ($post_type !== 'oh_application') {
        return;
    }
    $selected = sanitize_key(wp_unslash($_GET['onlyhub_status'] ?? ''));
    echo '<select name="onlyhub_status"><option value="">' . esc_html__('All workflow statuses', 'onlyhub') . '</option>';
    foreach (ONLYHUB_APPLICATION_STATUSES as $value => $label) {
        printf('<option value="%s" %s>%s</option>', esc_attr($value), selected($selected, $value, false), esc_html__($label, 'onlyhub'));
    }
    echo '</select>';
});

add_action('pre_get_posts', static function (WP_Query $query): void {
    if (! is_admin() || ! $query->is_main_query() || $query->get('post_type') !== 'oh_application') {
        return;
    }
    $status = sanitize_key(wp_unslash($_GET['onlyhub_status'] ?? ''));
    if (array_key_exists($status, ONLYHUB_APPLICATION_STATUSES)) {
        $query->set('meta_key', '_onlyhub_status');
        $query->set('meta_value', $status);
    }
});

add_action('admin_post_onlyhub_export_applications', static function (): void {
    if (! current_user_can('edit_others_posts')) {
        wp_die(esc_html__('You are not allowed to export applications.', 'onlyhub'), '', ['response' => 403]);
    }
    check_admin_referer('onlyhub_export_applications');

    nocache_headers();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=onlyhub-applications-' . gmdate('Y-m-d') . '.csv');

    $output = fopen('php://output', 'wb');
    if ($output === false) {
        wp_die(esc_html__('Unable to create export.', 'onlyhub'));
    }
    fwrite($output, "\xEF\xBB\xBF");
    fputcsv($output, ['ID', 'Received UTC', 'Name', 'Email', 'Type', 'Status', 'Message']);

    $query = new WP_Query([
        'post_type'      => 'oh_application',
        'post_status'    => 'private',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    ]);
    foreach ($query->posts as $application) {
        fputcsv($output, [
            $application->ID,
            get_post_time('c', true, $application),
            get_post_meta($application->ID, '_onlyhub_name', true),
            get_post_meta($application->ID, '_onlyhub_email', true),
            get_post_meta($application->ID, '_onlyhub_type', true),
            get_post_meta($application->ID, '_onlyhub_status', true),
            wp_strip_all_tags($application->post_content),
        ]);
    }
    fclose($output);
    exit;
});

add_action('admin_notices', static function (): void {
    $screen = get_current_screen();
    if (! $screen || $screen->post_type !== 'oh_application' || $screen->base !== 'edit' || ! current_user_can('edit_others_posts')) {
        return;
    }
    $url = wp_nonce_url(admin_url('admin-post.php?action=onlyhub_export_applications'), 'onlyhub_export_applications');
    echo '<div class="notice notice-info"><p><a class="button" href="' . esc_url($url) . '">' . esc_html__('Export applications as CSV', 'onlyhub') . '</a></p></div>';
});
