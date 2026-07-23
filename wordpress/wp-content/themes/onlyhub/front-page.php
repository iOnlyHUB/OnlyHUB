<?php
/**
 * Front page template.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

get_header();

$hero_image = get_theme_file_uri('/assets/images/home-hero-ecosystem.jpg');
$items      = onlyhub_ecosystem_items();
?>
<main id="main-content">
    <section class="oh-hero" style="--oh-hero-image: url('<?php echo esc_url($hero_image); ?>');">
        <div class="oh-container oh-hero-content">
            <span class="oh-eyebrow"><?php esc_html_e('International Charity Ecosystem', 'onlyhub'); ?></span>
            <h1><?php esc_html_e('One hub. Real impact.', 'onlyhub'); ?></h1>
            <p><?php esc_html_e('OnlyHUB connects people, companies and institutions to deliver transparent humanitarian support, sustainable recovery and long-term opportunities for Ukraine.', 'onlyhub'); ?></p>
            <div class="oh-actions">
                <a class="oh-button oh-button--primary" href="<?php echo esc_url(home_url('/support/')); ?>"><?php esc_html_e('Support a project', 'onlyhub'); ?></a>
                <a class="oh-button oh-button--ghost" href="<?php echo esc_url(home_url('/partners/')); ?>"><?php esc_html_e('Become a partner', 'onlyhub'); ?></a>
            </div>
        </div>
    </section>

    <section class="oh-section" aria-labelledby="impact-title">
        <div class="oh-container">
            <div class="oh-section-heading">
                <span class="oh-eyebrow"><?php esc_html_e('Transparent impact', 'onlyhub'); ?></span>
                <h2 id="impact-title"><?php esc_html_e('Help that can be measured.', 'onlyhub'); ?></h2>
                <p><?php esc_html_e('The figures below are placeholders until verified operational data is connected through the administration panel.', 'onlyhub'); ?></p>
            </div>
            <div class="oh-stats">
                <div class="oh-stat"><strong>—</strong><span><?php esc_html_e('Active projects', 'onlyhub'); ?></span></div>
                <div class="oh-stat"><strong>—</strong><span><?php esc_html_e('Communities supported', 'onlyhub'); ?></span></div>
                <div class="oh-stat"><strong>—</strong><span><?php esc_html_e('Partners', 'onlyhub'); ?></span></div>
                <div class="oh-stat"><strong>—</strong><span><?php esc_html_e('Verified reports', 'onlyhub'); ?></span></div>
            </div>
        </div>
    </section>

    <section class="oh-section" aria-labelledby="ecosystem-title">
        <div class="oh-container">
            <div class="oh-section-heading">
                <span class="oh-eyebrow"><?php esc_html_e('OnlyHUB ecosystem', 'onlyhub'); ?></span>
                <h2 id="ecosystem-title"><?php esc_html_e('Specialised teams. One shared mission.', 'onlyhub'); ?></h2>
                <p><?php esc_html_e('Each direction has its own identity, expertise and programmes while remaining part of one accountable platform.', 'onlyhub'); ?></p>
            </div>
            <div class="oh-grid">
                <?php foreach ($items as $item) : ?>
                    <article class="oh-card">
                        <div class="oh-card-icon" aria-hidden="true">O</div>
                        <h3><?php echo esc_html($item['name']); ?></h3>
                        <p><?php echo esc_html($item['description']); ?></p>
                        <a href="<?php echo esc_url(onlyhub_direction_url($item['slug'])); ?>">
                            <?php esc_html_e('Explore direction', 'onlyhub'); ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="oh-section" aria-labelledby="projects-title">
        <div class="oh-container">
            <div class="oh-section-heading">
                <span class="oh-eyebrow"><?php esc_html_e('Current work', 'onlyhub'); ?></span>
                <h2 id="projects-title"><?php esc_html_e('Projects built around real needs.', 'onlyhub'); ?></h2>
            </div>
            <div class="oh-grid">
                <?php
                $projects = new WP_Query([
                    'post_type'      => 'oh_project',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'no_found_rows'  => true,
                ]);
                ?>
                <?php if ($projects->have_posts()) : ?>
                    <?php while ($projects->have_posts()) : $projects->the_post(); ?>
                        <article <?php post_class('oh-card'); ?>>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
                        </article>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <article class="oh-card">
                        <h3><?php esc_html_e('Project publishing is being prepared', 'onlyhub'); ?></h3>
                        <p><?php esc_html_e('Verified projects will appear here after content review and approval.', 'onlyhub'); ?></p>
                    </article>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="oh-section" aria-labelledby="partner-title">
        <div class="oh-container">
            <div class="oh-card">
                <span class="oh-eyebrow"><?php esc_html_e('Partnership', 'onlyhub'); ?></span>
                <h2 id="partner-title"><?php esc_html_e('Build measurable impact with OnlyHUB.', 'onlyhub'); ?></h2>
                <p><?php esc_html_e('We are preparing structured cooperation packages for companies, institutions, foundations and international donors.', 'onlyhub'); ?></p>
                <div class="oh-actions">
                    <a class="oh-button oh-button--primary" href="<?php echo esc_url(home_url('/partners/')); ?>"><?php esc_html_e('Start a partnership', 'onlyhub'); ?></a>
                    <a class="oh-button oh-button--ghost" href="<?php echo esc_url(home_url('/reports/')); ?>"><?php esc_html_e('View transparency centre', 'onlyhub'); ?></a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
