<?php
/**
 * Campaign detail template.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

get_header();
?>
<main id="main-content" class="site-main section-shell">
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $campaign_id = get_the_ID();
        $goal = max(0, (float) get_post_meta($campaign_id, '_oh_goal_amount', true));
        $raised = max(0, (float) get_post_meta($campaign_id, '_oh_raised_amount', true));
        $currency = strtoupper((string) get_post_meta($campaign_id, '_oh_currency', true));
        $status = (string) get_post_meta($campaign_id, '_oh_campaign_status', true);
        $start_date = (string) get_post_meta($campaign_id, '_oh_start_date', true);
        $end_date = (string) get_post_meta($campaign_id, '_oh_end_date', true);
        $verified = (bool) get_post_meta($campaign_id, '_oh_verified', true);
        $report_url = (string) get_post_meta($campaign_id, '_oh_report_url', true);
        $progress = $goal > 0 ? min(100, ($raised / $goal) * 100) : 0;
        ?>
        <article <?php post_class('single-entry'); ?>>
            <header class="single-entry__header">
                <?php $terms = get_the_terms($campaign_id, 'oh_direction'); ?>
                <p class="eyebrow"><?php echo esc_html(($terms && ! is_wp_error($terms)) ? $terms[0]->name : __('OnlyHUB Campaign', 'onlyhub')); ?></p>
                <h1><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?><p class="lead"><?php echo esc_html(get_the_excerpt()); ?></p><?php endif; ?>
            </header>

            <?php if (has_post_thumbnail()) : ?><figure class="single-entry__media"><?php the_post_thumbnail('large'); ?></figure><?php endif; ?>

            <section class="campaign-summary" aria-labelledby="campaign-progress-title">
                <div class="campaign-summary__topline">
                    <div>
                        <p class="eyebrow" id="campaign-progress-title"><?php esc_html_e('Campaign progress', 'onlyhub'); ?></p>
                        <strong><?php echo esc_html(number_format_i18n($raised, 2) . ' ' . $currency); ?></strong>
                        <?php if ($goal > 0) : ?>
                            <span><?php echo esc_html(sprintf(__('of %1$s %2$s', 'onlyhub'), number_format_i18n($goal, 2), $currency)); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($verified) : ?>
                        <span class="campaign-badge campaign-badge--verified"><?php esc_html_e('Verified campaign', 'onlyhub'); ?></span>
                    <?php else : ?>
                        <span class="campaign-badge"><?php esc_html_e('Verification pending', 'onlyhub'); ?></span>
                    <?php endif; ?>
                </div>

                <div class="campaign-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?php echo esc_attr((string) round($progress)); ?>">
                    <span style="width: <?php echo esc_attr((string) $progress); ?>%"></span>
                </div>

                <dl class="campaign-meta">
                    <?php if ($status !== '') : ?><div><dt><?php esc_html_e('Status', 'onlyhub'); ?></dt><dd><?php echo esc_html($status); ?></dd></div><?php endif; ?>
                    <?php if ($start_date !== '') : ?><div><dt><?php esc_html_e('Starts', 'onlyhub'); ?></dt><dd><?php echo esc_html($start_date); ?></dd></div><?php endif; ?>
                    <?php if ($end_date !== '') : ?><div><dt><?php esc_html_e('Ends', 'onlyhub'); ?></dt><dd><?php echo esc_html($end_date); ?></dd></div><?php endif; ?>
                </dl>
            </section>

            <div class="single-entry__content"><?php the_content(); ?></div>

            <?php if ($report_url !== '') : ?>
                <p><a class="button button--secondary" href="<?php echo esc_url($report_url); ?>" rel="noopener noreferrer"><?php esc_html_e('Open public campaign report', 'onlyhub'); ?></a></p>
            <?php endif; ?>

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
