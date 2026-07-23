<?php
/**
 * Template Name: OnlyHUB Ecosystem
 */

declare(strict_types=1);

get_header();

$directions = onlyhub_ecosystem_items();
?>
<main id="main-content" class="site-main section-shell">
    <header class="page-header">
        <p class="eyebrow"><?php esc_html_e('One ecosystem. Shared impact.', 'onlyhub'); ?></p>
        <h1><?php the_title(); ?></h1>
        <div class="single-entry__content"><?php the_content(); ?></div>
    </header>

    <section class="oh-section oh-section--nested" aria-labelledby="ecosystem-title">
        <h2 id="ecosystem-title"><?php esc_html_e('OnlyHUB directions', 'onlyhub'); ?></h2>
        <div class="oh-grid">
            <?php foreach ($directions as $direction) : ?>
                <article class="oh-card ecosystem-card ecosystem-card--<?php echo esc_attr($direction['slug']); ?>">
                    <div class="oh-card-icon" aria-hidden="true">O</div>
                    <h3><?php echo esc_html($direction['name']); ?></h3>
                    <p><?php echo esc_html($direction['description']); ?></p>
                    <a class="text-link" href="<?php echo esc_url(onlyhub_direction_url($direction['slug'])); ?>">
                        <?php esc_html_e('Explore direction', 'onlyhub'); ?>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?php get_footer();
