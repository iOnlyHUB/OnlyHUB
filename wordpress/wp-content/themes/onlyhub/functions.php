<?php
/**
 * OnlyHUB theme functions.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

const ONLYHUB_THEME_VERSION = '0.1.0';

add_action('after_setup_theme', static function (): void {
    load_theme_textdomain('onlyhub', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 120,
        'width'       => 320,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary navigation', 'onlyhub'),
        'footer'  => __('Footer navigation', 'onlyhub'),
    ]);
});

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style(
        'onlyhub-style',
        get_stylesheet_uri(),
        [],
        ONLYHUB_THEME_VERSION
    );
});

add_action('init', static function (): void {
    register_post_type('oh_project', [
        'labels' => [
            'name'          => __('Projects', 'onlyhub'),
            'singular_name' => __('Project', 'onlyhub'),
            'add_new_item'  => __('Add project', 'onlyhub'),
            'edit_item'     => __('Edit project', 'onlyhub'),
        ],
        'public'             => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-portfolio',
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'projects'],
        'supports'           => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
    ]);

    register_post_type('oh_partner', [
        'labels' => [
            'name'          => __('Partners', 'onlyhub'),
            'singular_name' => __('Partner', 'onlyhub'),
            'add_new_item'  => __('Add partner', 'onlyhub'),
            'edit_item'     => __('Edit partner', 'onlyhub'),
        ],
        'public'             => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-groups',
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'partners'],
        'supports'           => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
    ]);

    register_post_type('oh_campaign', [
        'labels' => [
            'name'          => __('Campaigns', 'onlyhub'),
            'singular_name' => __('Campaign', 'onlyhub'),
            'add_new_item'  => __('Add campaign', 'onlyhub'),
            'edit_item'     => __('Edit campaign', 'onlyhub'),
        ],
        'public'             => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-heart',
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'campaigns'],
        'supports'           => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
    ]);

    register_taxonomy('oh_direction', ['oh_project', 'oh_campaign'], [
        'labels' => [
            'name'          => __('OnlyHUB directions', 'onlyhub'),
            'singular_name' => __('OnlyHUB direction', 'onlyhub'),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite'      => ['slug' => 'direction'],
    ]);
});

/**
 * Returns the official OnlyHUB ecosystem entries used on the homepage.
 *
 * @return array<int, array{slug:string,name:string,description:string}>
 */
function onlyhub_ecosystem_items(): array
{
    return [
        ['slug' => 'foundation', 'name' => 'OnlyHUB Foundation', 'description' => __('Coordination, charity programmes and institutional development.', 'onlyhub')],
        ['slug' => 'support', 'name' => 'OnlyHUB Support', 'description' => __('Humanitarian assistance, community support and urgent response.', 'onlyhub')],
        ['slug' => 'business', 'name' => 'OnlyHUB Business', 'description' => __('Corporate partnerships, grants and sustainable cooperation.', 'onlyhub')],
        ['slug' => 'news', 'name' => 'OnlyHUB News', 'description' => __('Verified news, reports and official announcements.', 'onlyhub')],
        ['slug' => 'media', 'name' => 'OnlyHUB Media', 'description' => __('Photo, video, live broadcasts and public communications.', 'onlyhub')],
        ['slug' => 'music', 'name' => 'OnlyHUB Music', 'description' => __('Charity concerts, cultural initiatives and artist partnerships.', 'onlyhub')],
        ['slug' => 'healthcare', 'name' => 'OnlyHUB Healthcare', 'description' => __('Healthcare programmes, rehabilitation and medical assistance.', 'onlyhub')],
        ['slug' => 'clinical-service', 'name' => 'OnlyHUB Clinical Service', 'description' => __('Specialised clinical support and access to essential services.', 'onlyhub')],
        ['slug' => 'defence-support', 'name' => 'OnlyHUB Defence Support', 'description' => __('Non-lethal assistance and resilience support for defenders and communities.', 'onlyhub')],
        ['slug' => 'stop-war', 'name' => 'OnlyHUB Stop War', 'description' => __('Humanitarian response, recovery and support for people affected by war.', 'onlyhub')],
        ['slug' => 'innovation', 'name' => 'OnlyHUB Innovation', 'description' => __('Technology, education and digital products for social impact.', 'onlyhub')],
        ['slug' => 'production', 'name' => 'OnlyHUB Production', 'description' => __('Production, printing and technical support for humanitarian programmes.', 'onlyhub')],
    ];
}
