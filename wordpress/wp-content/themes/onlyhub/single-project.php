<?php
/**
 * Single project template.
 */

declare(strict_types=1);

get_header();
?>
<main id="main-content" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class('project-detail'); ?>>
            <header class="project-hero section-shell">
                <p class="eyebrow"><?php esc_html_e('OnlyHUB Project', 'onlyhub'); ?></p>
                <h1><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="project-hero__lead"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="project-cover section-shell">
                    <?php the_post_thumbnail('full', ['loading' => 'eager']); ?>
                </div>
            <?php endif; ?>

            <div class="project-layout section-shell">
                <div class="project-content entry-content">
                    <?php the_content(); ?>
                </div>

                <aside class="project-sidebar" aria-label="<?php esc_attr_e('Project information', 'onlyhub'); ?>">
                    <h2><?php esc_html_e('Project transparency', 'onlyhub'); ?></h2>
                    <p><?php esc_html_e('Budget, implementation status and supporting reports will be published here after verification.', 'onlyhub'); ?></p>
                    <a class="button button--primary" href="<?php echo esc_url(home_url('/support/')); ?>">
                        <?php esc_html_e('Support this work', 'onlyhub'); ?>
                    </a>
                </aside>
            </div>
        </article>
    <?php endwhile; ?>
</main>
<?php
get_footer();
