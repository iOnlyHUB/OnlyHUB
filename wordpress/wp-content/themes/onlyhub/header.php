<?php
/**
 * Site header.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text" href="#main-content"><?php esc_html_e('Skip to content', 'onlyhub'); ?></a>
<header class="oh-site-header">
    <div class="oh-container oh-header-inner">
        <a class="oh-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('OnlyHUB home', 'onlyhub'); ?>">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span class="oh-brand-mark" aria-hidden="true">O</span>
                <span><?php bloginfo('name'); ?></span>
            <?php endif; ?>
        </a>

        <nav class="oh-nav" aria-label="<?php esc_attr_e('Primary navigation', 'onlyhub'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => false,
            ]);
            ?>
        </nav>

        <a class="oh-button oh-button--primary" href="<?php echo esc_url(home_url('/support/')); ?>">
            <?php esc_html_e('Support OnlyHUB', 'onlyhub'); ?>
        </a>
    </div>
</header>
