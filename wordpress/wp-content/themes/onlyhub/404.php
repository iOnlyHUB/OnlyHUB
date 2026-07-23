<?php
declare(strict_types=1);

get_header();
?>
<main id="main-content" class="site-main">
    <section class="section section--intro">
        <div class="container container--narrow">
            <p class="eyebrow">404</p>
            <h1><?php esc_html_e('Page not found', 'onlyhub'); ?></h1>
            <p><?php esc_html_e('The requested page may have moved or is temporarily unavailable.', 'onlyhub'); ?></p>
            <p><a class="button" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Return to homepage', 'onlyhub'); ?></a></p>
            <?php get_search_form(); ?>
        </div>
    </section>
</main>
<?php get_footer();
