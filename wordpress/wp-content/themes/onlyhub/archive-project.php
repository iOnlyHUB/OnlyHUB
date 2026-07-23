<?php
/**
 * Project archive template.
 */

declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main section-shell">
    <header class="archive-header">
        <p class="eyebrow"><?php esc_html_e('OnlyHUB Projects', 'onlyhub'); ?></p>
        <h1><?php post_type_archive_title(); ?></h1>
        <p><?php esc_html_e('Verified initiatives, humanitarian missions and long-term programmes delivered by the OnlyHUB ecosystem.', 'onlyhub'); ?></p>
    </header>

    <?php if (have_posts()) : ?>
        <div class="card-grid">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('content-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="content-card__media" aria-hidden="true" tabindex="-1">
                            <?php the_post_thumbnail('large', ['loading' => 'lazy']); ?>
                        </a>
                    <?php endif; ?>
                    <div class="content-card__body">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
                        <a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e('View project', 'onlyhub'); ?></a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e('Projects will appear here after publication.', 'onlyhub'); ?></p>
    <?php endif; ?>
</main>
<?php
get_footer();
