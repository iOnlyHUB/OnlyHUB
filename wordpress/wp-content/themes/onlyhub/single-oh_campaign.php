<?php
/**
 * Campaign detail template.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

get_header();
?>
<main id="primary" class="site-main section-shell">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class('single-entry'); ?>>
            <header class="single-entry__header">
                <?php $terms = get_the_terms(get_the_ID(), 'oh_direction'); ?>
                <p class="eyebrow"><?php echo esc_html(($terms && ! is_wp_error($terms)) ? $terms[0]->name : __('OnlyHUB Campaign', 'onlyhub')); ?></p>
                <h1><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?><p class="lead"><?php echo esc_html(get_the_excerpt()); ?></p><?php endif; ?>
            </header>
            <?php if (has_post_thumbnail()) : ?><figure class="single-entry__media"><?php the_post_thumbnail('large'); ?></figure><?php endif; ?>
            <div class="single-entry__content"><?php the_content(); ?></div>
            <aside class="notice" aria-label="<?php esc_attr_e('Donation safety notice', 'onlyhub'); ?>">
                <strong><?php esc_html_e('Donation safety', 'onlyhub'); ?></strong>
                <p><?php esc_html_e('Payment buttons are enabled only after legal, banking and campaign verification. Never send funds using details copied from unofficial messages.', 'onlyhub'); ?></p>
            </aside>
            <footer class="single-entry__footer">
                <a class="button button--secondary" href="<?php echo esc_url(get_post_type_archive_link('oh_campaign')); ?>"><?php esc_html_e('All campaigns', 'onlyhub'); ?></a>
            </footer>
        </article>
    <?php endwhile; ?>
</main>
<?php get_footer();
