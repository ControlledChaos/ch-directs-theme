<?php
/**
 * The sidebar containing the main widget area
 *
 * @package CH_Directs_Theme
 */

?>

<aside id="secondary" class="widget-area">
	<?php
		if ( is_active_sidebar( 'sidebar-1' ) ) :

		dynamic_sidebar( 'sidebar-1' );

		else : ?>

    	<?php get_search_form(); ?>

    	<h3><?php _e( 'Archives', 'ip-theme' ); ?></h3>
    	<ul>
    		<?php wp_get_archives( 'type=monthly' ); ?>
		</ul>

		<?php the_widget(
			'WP_Widget_Categories',
			null,
			[
				'before_title' => '<h3>',
				'after_title' => '</h3>'
			]
		); ?>

    	<h3><?php _e( 'Meta', 'ip-theme' ); ?></h3>
    	<ul>
			<?php wp_register(); ?>
			<?php if ( is_user_logged_in() ) : ?>
			<li>
				<a href="<?php echo get_edit_user_link(); ?>"><?php _e( 'Your Profile', 'ip-theme' ); ?></a>
			</li>
			<?php endif; ?>
    		<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
    	</ul>

    	<h3><?php _e( 'Subscribe', 'ip-theme' ); ?></h3>
    	<ul>
    		<li><a href="<?php bloginfo( 'rss2_url' ); ?>"><?php _e( 'Entries RSS', 'ip-theme' ); ?></a></li>
    		<li><a href="<?php bloginfo( 'comments_rss2_url' ); ?>"><?php _e( 'Comments RSS', 'ip-theme' ); ?></a></li>
    	</ul>

	<?php endif; ?>
</aside>