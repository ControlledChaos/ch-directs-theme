<?php
/**
 * The template for displaying the footer
 *
 * @package    WordPress
 * @subpackage CH_Directs_Theme\Frontend
 * @since      1.0.0
 */

namespace CH_Directs_Theme\Frontend;

// Get the site name.
$site_name = esc_attr( get_bloginfo( 'name' ) );

// Copyright HTML.
$copyright = sprintf(
	'<p class="copyright-text" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">&copy; <span class="screen-reader-text">%1s</span><span itemprop="copyrightYear">%2s</span> <span itemprop="copyrightHolder">%3s.</span> %4s.</p>',
	esc_html__( 'Copyright ', 'ip-theme' ),
	get_the_time( 'Y' ),
	$site_name,
	esc_html__( 'All rights reserved', 'ip-theme' )
); ?>

	</div>

	<footer id="colophon" class="site-footer">
		<div class="footer-content global-wrapper footer-wrapper">
				<?php echo $copyright; ?>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>