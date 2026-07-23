<?php
/**
 * Template Name: Member Dashboard
 *
 * @package OnlyHUB
 */

declare(strict_types=1);

if (! is_user_logged_in()) {
    auth_redirect();
}

$user = wp_get_current_user();
$roles = array_map('sanitize_text_field', (array) $user->roles);
$roleLabel = $roles ? implode(', ', array_map(static fn (string $role): string => ucwords(str_replace('_', ' ', $role)), $roles)) : __('Member', 'onlyhub');

get_header();
?>
<main id="primary" class="site-main section-shell">
    <header class="page-header dashboard-header">
        <p class="eyebrow"><?php esc_html_e('OnlyHUB account', 'onlyhub'); ?></p>
        <h1><?php echo esc_html(sprintf(__('Welcome, %s', 'onlyhub'), $user->display_name ?: $user->user_login)); ?></h1>
        <p class="lead"><?php esc_html_e('This private area provides access to your profile, applications and relevant OnlyHUB resources.', 'onlyhub'); ?></p>
    </header>

    <section class="dashboard-grid" aria-label="<?php esc_attr_e('Account overview', 'onlyhub'); ?>">
        <article class="dashboard-card">
            <h2><?php esc_html_e('Account details', 'onlyhub'); ?></h2>
            <dl class="dashboard-list">
                <div><dt><?php esc_html_e('Name', 'onlyhub'); ?></dt><dd><?php echo esc_html($user->display_name ?: $user->user_login); ?></dd></div>
                <div><dt><?php esc_html_e('Email', 'onlyhub'); ?></dt><dd><?php echo esc_html($user->user_email); ?></dd></div>
                <div><dt><?php esc_html_e('Role', 'onlyhub'); ?></dt><dd><?php echo esc_html($roleLabel); ?></dd></div>
            </dl>
            <a class="button button--secondary" href="<?php echo esc_url(get_edit_profile_url($user->ID)); ?>"><?php esc_html_e('Edit profile', 'onlyhub'); ?></a>
        </article>

        <article class="dashboard-card">
            <h2><?php esc_html_e('Your next steps', 'onlyhub'); ?></h2>
            <p><?php esc_html_e('Submit a partnership, volunteer, donor or media request using the verified OnlyHUB application form.', 'onlyhub'); ?></p>
            <a class="button" href="<?php echo esc_url(home_url('/apply/')); ?>"><?php esc_html_e('Open application form', 'onlyhub'); ?></a>
        </article>

        <article class="dashboard-card">
            <h2><?php esc_html_e('Security', 'onlyhub'); ?></h2>
            <p><?php esc_html_e('OnlyHUB will never request your password or payment details through private messages.', 'onlyhub'); ?></p>
            <a class="text-link" href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"><?php esc_html_e('Sign out securely', 'onlyhub'); ?></a>
        </article>
    </section>
</main>
<?php get_footer();
