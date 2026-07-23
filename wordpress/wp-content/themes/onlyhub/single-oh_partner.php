<?php
/**
 * Partner detail template.
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
                <p class="eyebrow"><?php esc_html_e('OnlyHUB Partner', 'onlyhub'); ?></p>
                <h1><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?><p class="lead"><?php echo esc_html(get_the_excerpt()); ?></p><?php endif; ?>
            </header>
            <?php if (has_post_thumbnail()) : ?><figure class="single-entry__media"><?php the_post_thumbnail('large'); ?></figure><?php endif; ?>
            <div class="single-entry__content"><?php the_content(); ?></div>
            <footer class="single-entry__footer">
                <a class="button button--secondary" href="<?php echo esc_url(get_post_type_archive_link('oh_partner')); ?>"><?php esc_html_e('All partners', 'onlyhub'); ?></a>
            </footer>
        </article>
    <?php endwhile; ?>
</main>
<?php get_footer();
