<?php
/**
 * Template Name: OnlyHUB Transparency Centre
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

get_header();

$reported_campaigns = new WP_Query([
    'post_type'      => 'oh_campaign',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
    'meta_query'     => [
        'relation' => 'AND',
        [
            'key'   => '_oh_verified',
            'value' => '1',
        ],
        [
            'key'     => '_oh_report_url',
            'value'   => '',
            'compare' => '!=',
        ],
    ],
]);
?>
<main id="main-content" class="site-main section-shell">
    <header class="page-header">
        <p class="eyebrow"><?php esc_html_e('Transparency centre', 'onlyhub'); ?></p>
        <h1><?php the_title(); ?></h1>
        <p class="lead"><?php esc_html_e('Verified campaign reports, publication rules and accountability materials in one public location.', 'onlyhub'); ?></p>
    </header>

    <section class="oh-section oh-section--nested" aria-labelledby="public-reports-title">
        <div class="oh-section-heading">
            <h2 id="public-reports-title"><?php esc_html_e('Public campaign reports', 'onlyhub'); ?></h2>
            <p><?php esc_html_e('A report appears here only when the campaign and its public report link have both passed editorial verification.', 'onlyhub'); ?></p>
        </div>

        <?php if ($reported_campaigns->have_posts()) : ?>
            <div class="card-grid">
                <?php while ($reported_campaigns->have_posts()) : $reported_campaigns->the_post(); ?>
                    <?php $report_url = (string) get_post_meta(get_the_ID(), '_oh_report_url', true); ?>
                    <article <?php post_class('content-card'); ?>>
                        <div class="content-card__body">
                            <p class="eyebrow"><?php esc_html_e('Campaign report', 'onlyhub'); ?></p>
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
                            <a class="button button--secondary" href="<?php echo esc_url($report_url); ?>" target="_blank" rel="noopener noreferrer">
                                <?php esc_html_e('Open verified report', 'onlyhub'); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="notice">
                <p><?php esc_html_e('Verified public reports have not been published yet. No unreviewed files or placeholder figures are shown.', 'onlyhub'); ?></p>
            </div>
        <?php endif; ?>
    </section>

    <section class="oh-section oh-section--nested" aria-labelledby="reporting-standard-title">
        <div class="oh-section-heading">
            <h2 id="reporting-standard-title"><?php esc_html_e('Publication standard', 'onlyhub'); ?></h2>
            <p><?php esc_html_e('OnlyHUB separates draft data from verified public information and records significant administrative changes in an audit log.', 'onlyhub'); ?></p>
        </div>
        <div class="oh-grid">
            <article class="oh-card">
                <h3><?php esc_html_e('Verified source', 'onlyhub'); ?></h3>
                <p><?php esc_html_e('Amounts, dates, partners and outcomes require an accountable internal source before publication.', 'onlyhub'); ?></p>
            </article>
            <article class="oh-card">
                <h3><?php esc_html_e('Protected workflow', 'onlyhub'); ?></h3>
                <p><?php esc_html_e('Applications and internal review records remain private and are available only to authorised roles.', 'onlyhub'); ?></p>
            </article>
            <article class="oh-card">
                <h3><?php esc_html_e('Correction history', 'onlyhub'); ?></h3>
                <p><?php esc_html_e('Material corrections and administrative status changes are traceable through controlled records.', 'onlyhub'); ?></p>
            </article>
        </div>
    </section>
</main>
<?php
get_footer();
