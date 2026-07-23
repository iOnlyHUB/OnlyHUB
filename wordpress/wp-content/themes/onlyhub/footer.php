<?php
/**
 * Site footer.
 *
 * @package OnlyHUB
 */

declare(strict_types=1);
?>
<footer class="oh-site-footer">
    <div class="oh-container oh-footer-inner">
        <div>
            <strong><?php bloginfo('name'); ?></strong><br>
            <span><?php esc_html_e('International charity ecosystem for sustainable social impact.', 'onlyhub'); ?></span>
        </div>
        <div>
            <span>&copy; <?php echo esc_html((string) wp_date('Y')); ?> OnlyHUB.</span>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
