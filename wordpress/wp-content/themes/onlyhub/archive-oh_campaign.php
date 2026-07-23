<?php
/**
 * Campaign archive template.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

get_header();
?>
<main id="primary" class="site-main section-shell">
    <header class="archive-header">
        <p class="eyebrow"><?php esc_html_e('OnlyHUB Campaigns', 'onlyhub'); ?></p>
        <h1><?php post_type_archive_title(); ?></h1>
        <p><?php esc_html_e('Verified humanitarian and social-impact initiatives managed through OnlyHUB.', 'onlyhub'); ?></p>
    </header>

    <?php if (have_posts()) : ?>
        <div class="card-grid">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('content-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="content-card__media"><?php the_post_thumbnail('medium_large'); ?></a>
                    <?php endif; ?>
                    <div class="content-card__body">
                        <?php $terms = get_the_terms(get_the_ID(), 'oh_direction'); ?>
                        <?php if ($terms && ! is_wp_error($terms)) : ?><p class="eyebrow"><?php echo esc_html($terms[0]->name); ?></p><?php endif; ?>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
                        <a class="button" href="<?php the_permalink(); ?>"><?php esc_html_e('View campaign', 'onlyhub'); ?></a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e('Campaigns will appear here after verification and publication.', 'onlyhub'); ?></p>
    <?php endif; ?>
</main>
<?php get_footer();
