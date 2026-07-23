<?php
/**
 * Template Name: OnlyHUB Application
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

get_header();
$status = isset($_GET['application']) ? sanitize_key(wp_unslash($_GET['application'])) : '';
?>
<main id="primary" class="site-main section-shell">
    <header class="page-header">
        <p class="eyebrow"><?php esc_html_e('Join OnlyHUB', 'onlyhub'); ?></p>
        <h1><?php the_title(); ?></h1>
        <p><?php esc_html_e('Submit a partnership, volunteer, donor or media enquiry. Applications are reviewed manually.', 'onlyhub'); ?></p>
    </header>

    <?php if ($status === 'received') : ?>
        <div class="notice notice--success" role="status"><?php esc_html_e('Thank you. Your application was received securely.', 'onlyhub'); ?></div>
    <?php elseif ($status === 'invalid') : ?>
        <div class="notice notice--error" role="alert"><?php esc_html_e('Please check all required fields and try again.', 'onlyhub'); ?></div>
    <?php elseif ($status === 'error') : ?>
        <div class="notice notice--error" role="alert"><?php esc_html_e('The application could not be stored. Please try again later.', 'onlyhub'); ?></div>
    <?php endif; ?>

    <form class="application-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="onlyhub_submit_application">
        <?php wp_nonce_field('onlyhub_application', 'onlyhub_application_nonce'); ?>

        <p class="form-field form-field--hidden" aria-hidden="true">
            <label for="company_website"><?php esc_html_e('Website', 'onlyhub'); ?></label>
            <input id="company_website" name="company_website" type="text" tabindex="-1" autocomplete="off">
        </p>

        <p class="form-field">
            <label for="application_type"><?php esc_html_e('Application type', 'onlyhub'); ?></label>
            <select id="application_type" name="application_type" required>
                <option value="partner"><?php esc_html_e('Partnership', 'onlyhub'); ?></option>
                <option value="volunteer"><?php esc_html_e('Volunteer', 'onlyhub'); ?></option>
                <option value="donor"><?php esc_html_e('Donor enquiry', 'onlyhub'); ?></option>
                <option value="media"><?php esc_html_e('Media cooperation', 'onlyhub'); ?></option>
                <option value="general"><?php esc_html_e('General enquiry', 'onlyhub'); ?></option>
            </select>
        </p>

        <p class="form-field">
            <label for="name"><?php esc_html_e('Name or organization', 'onlyhub'); ?></label>
            <input id="name" name="name" type="text" maxlength="160" autocomplete="name" required>
        </p>

        <p class="form-field">
            <label for="email"><?php esc_html_e('Email', 'onlyhub'); ?></label>
            <input id="email" name="email" type="email" maxlength="190" autocomplete="email" required>
        </p>

        <p class="form-field">
            <label for="message"><?php esc_html_e('Message', 'onlyhub'); ?></label>
            <textarea id="message" name="message" rows="8" minlength="20" maxlength="5000" required></textarea>
        </p>

        <p class="form-field form-field--check">
            <label><input type="checkbox" name="privacy_consent" value="1" required> <?php esc_html_e('I consent to the processing of this information for reviewing my application.', 'onlyhub'); ?></label>
        </p>

        <button class="button" type="submit"><?php esc_html_e('Submit application', 'onlyhub'); ?></button>
    </form>
</main>
<?php get_footer();
