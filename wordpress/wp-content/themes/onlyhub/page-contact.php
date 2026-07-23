<?php
/**
 * Template Name: OnlyHUB Contact
 */

declare(strict_types=1);

get_header();
?>
<main id="main-content" class="site-main">
    <section class="section section--intro">
        <div class="container container--narrow">
            <p class="eyebrow"><?php esc_html_e('Contact OnlyHUB', 'onlyhub'); ?></p>
            <h1><?php the_title(); ?></h1>
            <div class="prose"><?php the_content(); ?></div>

            <div class="notice">
                <h2><?php esc_html_e('Safe communication', 'onlyhub'); ?></h2>
                <p><?php esc_html_e('Do not send passwords, bank card data, medical records or other sensitive information through public forms. Official contact channels must be verified before publication.', 'onlyhub'); ?></p>
            </div>

            <?php if (shortcode_exists('onlyhub_contact_form')) : ?>
                <?php echo do_shortcode('[onlyhub_contact_form]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php else : ?>
                <p><?php esc_html_e('The contact form will appear after the approved form module is enabled.', 'onlyhub'); ?></p>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php get_footer();
