<?php
/**
 * Template Name: OnlyHUB Ecosystem
 */

declare(strict_types=1);

get_header();

$directions = [
    ['slug' => 'foundation', 'title' => 'OnlyHUB Foundation', 'description' => 'Humanitarian and charitable programmes.'],
    ['slug' => 'business', 'title' => 'OnlyHUB Business', 'description' => 'Responsible business and partnership programmes.'],
    ['slug' => 'news', 'title' => 'OnlyHUB News', 'description' => 'Verified updates, reports and announcements.'],
    ['slug' => 'media', 'title' => 'OnlyHUB Media', 'description' => 'Stories, campaigns and public communications.'],
    ['slug' => 'music', 'title' => 'OnlyHUB Music', 'description' => 'Cultural and charitable music initiatives.'],
    ['slug' => 'healthcare', 'title' => 'OnlyHUB Healthcare', 'description' => 'Health access and medical support.'],
    ['slug' => 'clinical-service', 'title' => 'OnlyHUB Clinical Service', 'description' => 'Clinical coordination and professional care services.'],
    ['slug' => 'defence-support', 'title' => 'OnlyHUB Defence Support', 'description' => 'Non-lethal humanitarian support for defenders and communities.'],
    ['slug' => 'stop-war', 'title' => 'OnlyHUB Stop War', 'description' => 'Peacebuilding, recovery and conflict-impact response.'],
    ['slug' => 'innovation', 'title' => 'OnlyHUB Innovation', 'description' => 'Technology and scalable social solutions.'],
    ['slug' => 'production', 'title' => 'OnlyHUB Production', 'description' => 'Creative, event and content production.'],
];
?>
<main id="main-content" class="site-main">
    <section class="section section--intro">
        <div class="container">
            <p class="eyebrow"><?php esc_html_e('One ecosystem. Shared impact.', 'onlyhub'); ?></p>
            <h1><?php the_title(); ?></h1>
            <div class="prose"><?php the_content(); ?></div>
        </div>
    </section>

    <section class="section" aria-labelledby="ecosystem-title">
        <div class="container">
            <h2 id="ecosystem-title"><?php esc_html_e('OnlyHUB directions', 'onlyhub'); ?></h2>
            <div class="card-grid">
                <?php foreach ($directions as $direction) :
                    $term = get_term_by('slug', $direction['slug'], 'onlyhub_direction');
                    $url = $term ? get_term_link($term) : home_url('/projects/');
                    if (is_wp_error($url)) {
                        $url = home_url('/projects/');
                    }
                ?>
                    <article class="card ecosystem-card ecosystem-card--<?php echo esc_attr($direction['slug']); ?>">
                        <h3><?php echo esc_html($direction['title']); ?></h3>
                        <p><?php echo esc_html($direction['description']); ?></p>
                        <a class="text-link" href="<?php echo esc_url($url); ?>">
                            <?php esc_html_e('Explore direction', 'onlyhub'); ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer();
