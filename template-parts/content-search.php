<?php
/**
 * Template part for displaying results in search pages
 *
 * @package ip_theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			ip_theme_posted_on();
			ip_theme_posted_by();
			?>
		</div>
		<?php endif; ?>
	</header>

	<?php ip_theme_post_thumbnail(); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-footer">
		<?php ip_theme_entry_footer(); ?>
	</footer><
</article>
