<?php
/**
 * Campaign metadata and validation for OnlyHUB.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

const ONLYHUB_CAMPAIGN_META = [
    '_oh_goal_amount'      => 'number',
    '_oh_raised_amount'    => 'number',
    '_oh_currency'         => 'text',
    '_oh_campaign_status'  => 'text',
    '_oh_start_date'       => 'date',
    '_oh_end_date'         => 'date',
    '_oh_verified'         => 'boolean',
    '_oh_report_url'       => 'url',
];

add_action('init', static function (): void {
    foreach (ONLYHUB_CAMPAIGN_META as $key => $type) {
        register_post_meta('oh_campaign', $key, [
            'type'              => $type === 'number' ? 'number' : ($type === 'boolean' ? 'boolean' : 'string'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => static function ($value) use ($type) {
                return match ($type) {
                    'number'  => max(0, (float) $value),
                    'boolean' => (bool) $value,
                    'url'     => esc_url_raw((string) $value),
                    'date'    => preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $value) ? (string) $value : '',
                    default   => sanitize_text_field((string) $value),
                };
            },
            'auth_callback'     => static fn (): bool => current_user_can('edit_posts'),
        ]);
    }
});

add_action('add_meta_boxes_oh_campaign', static function (): void {
    add_meta_box(
        'onlyhub-campaign-details',
        __('Campaign details', 'onlyhub'),
        static function (WP_Post $post): void {
            wp_nonce_field('onlyhub_save_campaign', 'onlyhub_campaign_nonce');
            $fields = [
                '_oh_goal_amount'     => __('Goal amount', 'onlyhub'),
                '_oh_raised_amount'   => __('Raised amount', 'onlyhub'),
                '_oh_currency'        => __('Currency (ISO code)', 'onlyhub'),
                '_oh_campaign_status' => __('Status', 'onlyhub'),
                '_oh_start_date'      => __('Start date', 'onlyhub'),
                '_oh_end_date'        => __('End date', 'onlyhub'),
                '_oh_report_url'      => __('Public report URL', 'onlyhub'),
            ];

            foreach ($fields as $key => $label) {
                $value = (string) get_post_meta($post->ID, $key, true);
                $type = str_contains($key, 'date') ? 'date' : (str_contains($key, 'amount') ? 'number' : 'text');
                printf(
                    '<p><label for="%1$s"><strong>%2$s</strong></label><br><input class="widefat" id="%1$s" name="%1$s" type="%3$s" step="0.01" value="%4$s"></p>',
                    esc_attr($key),
                    esc_html($label),
                    esc_attr($type),
                    esc_attr($value)
                );
            }

            printf(
                '<p><label><input type="checkbox" name="_oh_verified" value="1" %s> %s</label></p>',
                checked((bool) get_post_meta($post->ID, '_oh_verified', true), true, false),
                esc_html__('Campaign has passed legal and financial verification', 'onlyhub')
            );
        },
        'oh_campaign',
        'normal',
        'high'
    );
});

add_action('save_post_oh_campaign', static function (int $post_id): void {
    if (! isset($_POST['onlyhub_campaign_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['onlyhub_campaign_nonce'])), 'onlyhub_save_campaign')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach (ONLYHUB_CAMPAIGN_META as $key => $type) {
        $raw = $_POST[$key] ?? ($type === 'boolean' ? false : '');
        $value = match ($type) {
            'number'  => max(0, (float) $raw),
            'boolean' => (bool) $raw,
            'url'     => esc_url_raw((string) $raw),
            'date'    => preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $raw) ? (string) $raw : '',
            default   => sanitize_text_field((string) $raw),
        };
        update_post_meta($post_id, $key, $value);
    }
});
