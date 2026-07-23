<?php
/**
 * Template Name: Registration
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

get_header();
$status = isset($_GET['registration']) ? sanitize_key(wp_unslash($_GET['registration'])) : '';
?>
<main id="main-content" class="site-main section-shell">
    <header class="page-header">
        <p class="eyebrow"><?php esc_html_e('OnlyHUB account', 'onlyhub'); ?></p>
        <h1><?php esc_html_e('Create your account', 'onlyhub'); ?></h1>
        <p><?php esc_html_e('Choose the role that best describes how you plan to participate.', 'onlyhub'); ?></p>
    </header>

    <?php if ('ok' === $status) : ?>
        <div class="notice notice--success"><p><?php esc_html_e('Registration completed. Check your email to set your password.', 'onlyhub'); ?></p></div>
    <?php elseif ('exists' === $status) : ?>
        <div class="notice notice--error"><p><?php esc_html_e('An account with this email already exists.', 'onlyhub'); ?></p></div>
    <?php elseif (in_array($status, ['invalid', 'error'], true)) : ?>
        <div class="notice notice--error"><p><?php esc_html_e('Registration could not be completed. Check the form and try again.', 'onlyhub'); ?></p></div>
    <?php endif; ?>

    <form class="application-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="onlyhub_register">
        <?php wp_nonce_field('onlyhub_register', 'onlyhub_register_nonce'); ?>
        <p class="form-field form-field--hidden" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
        <p class="form-field"><label for="reg-name"><?php esc_html_e('Full name', 'onlyhub'); ?></label><input id="reg-name" type="text" name="name" required maxlength="120" autocomplete="name"></p>
        <p class="form-field"><label for="reg-email"><?php esc_html_e('Email', 'onlyhub'); ?></label><input id="reg-email" type="email" name="email" required maxlength="190" autocomplete="email"></p>
        <p class="form-field"><label for="reg-role"><?php esc_html_e('Participation role', 'onlyhub'); ?></label><select id="reg-role" name="role"><option value="onlyhub_donor"><?php esc_html_e('Donor', 'onlyhub'); ?></option><option value="onlyhub_volunteer"><?php esc_html_e('Volunteer', 'onlyhub'); ?></option><option value="onlyhub_partner"><?php esc_html_e('Partner', 'onlyhub'); ?></option></select></p>
        <p class="form-field form-field--check"><label><input type="checkbox" name="privacy" value="1" required> <?php esc_html_e('I agree to the privacy policy and account processing rules.', 'onlyhub'); ?></label></p>
        <button class="button" type="submit"><?php esc_html_e('Create account', 'onlyhub'); ?></button>
    </form>
</main>
<?php get_footer();
