<?php
/**
 * Fallback template.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

get_header();
?>
<main id="main-content" class="oh-section">
    <div class="oh-container">
        <div class="oh-section-heading">
            <span class="oh-eyebrow"><?php esc_html_e('OnlyHUB', 'onlyhub'); ?></span>
            <h1><?php single_post_title(); ?></h1>
        </div>

        <div class="oh-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article <?php post_class('oh-card'); ?>>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 35)); ?></p>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <article class="oh-card">
                    <h2><?php esc_html_e('No content found', 'onlyhub'); ?></h2>
                    <p><?php esc_html_e('Published materials will appear here.', 'onlyhub'); ?></p>
                </article>
            <?php endif; ?>
        </div>

        <?php the_posts_pagination(); ?>
    </div>
</main>
<?php
get_footer();
