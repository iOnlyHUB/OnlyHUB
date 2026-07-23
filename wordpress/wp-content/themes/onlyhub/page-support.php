<?php
/**
 * Template Name: OnlyHUB Support
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

get_header();

$campaigns = new WP_Query([
    'post_type'      => 'oh_campaign',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'meta_key'       => '_oh_verified',
    'meta_value'     => '1',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
]);
?>
<main id="main-content" class="site-main section-shell">
    <header class="page-header">
        <p class="eyebrow"><?php esc_html_e('OnlyHUB Support', 'onlyhub'); ?></p>
        <h1><?php the_title(); ?></h1>
        <p class="lead"><?php esc_html_e('Choose a verified programme or contribute your expertise through a protected OnlyHUB application.', 'onlyhub'); ?></p>
    </header>

    <aside class="notice" aria-label="<?php esc_attr_e('Donation safety', 'onlyhub'); ?>">
        <h2><?php esc_html_e('Donation safety', 'onlyhub'); ?></h2>
        <p><?php esc_html_e('Online payments are not active yet. Payment details will appear only after legal, banking and provider verification. Never transfer funds using details received in unofficial messages.', 'onlyhub'); ?></p>
    </aside>

    <section class="oh-section oh-section--nested" aria-labelledby="support-campaigns-title">
        <div class="oh-section-heading">
            <h2 id="support-campaigns-title"><?php esc_html_e('Verified campaigns', 'onlyhub'); ?></h2>
            <p><?php esc_html_e('Only campaigns approved by an authorised OnlyHUB editor are displayed in this section.', 'onlyhub'); ?></p>
        </div>

        <?php if ($campaigns->have_posts()) : ?>
            <div class="card-grid">
                <?php while ($campaigns->have_posts()) : $campaigns->the_post(); ?>
                    <article <?php post_class('content-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="content-card__media" aria-hidden="true" tabindex="-1">
                                <?php the_post_thumbnail('medium_large', ['loading' => 'lazy']); ?>
                            </a>
                        <?php endif; ?>
                        <div class="content-card__body">
                            <p class="eyebrow"><?php esc_html_e('Verified campaign', 'onlyhub'); ?></p>
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
                            <a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e('View campaign', 'onlyhub'); ?></a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="notice">
                <p><?php esc_html_e('No campaign has completed publication verification yet. This page will update automatically after approval.', 'onlyhub'); ?></p>
            </div>
        <?php endif; ?>
    </section>

    <section class="oh-section oh-section--nested" aria-labelledby="other-support-title">
        <div class="oh-section-heading">
            <h2 id="other-support-title"><?php esc_html_e('Other ways to contribute', 'onlyhub'); ?></h2>
            <p><?php esc_html_e('OnlyHUB also works with volunteers, professional teams, companies, institutions and media partners.', 'onlyhub'); ?></p>
        </div>
        <div class="oh-actions">
            <a class="button" href="<?php echo esc_url(home_url('/apply/')); ?>"><?php esc_html_e('Submit an application', 'onlyhub'); ?></a>
            <a class="button button--secondary" href="<?php echo esc_url(get_post_type_archive_link('oh_partner')); ?>"><?php esc_html_e('View partners', 'onlyhub'); ?></a>
        </div>
    </section>
</main>
<?php
get_footer();
