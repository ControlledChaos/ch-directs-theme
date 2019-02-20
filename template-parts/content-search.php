<?php
/**
 * Template part for displaying results in search pages
 *
 * @package    WordPress
 * @subpackage CH_Directs_Theme\Frontend
 * @since      1.0.0
 */

namespace CH_Directs_Theme\Frontend;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			chd_posted_on();
			chd_posted_by();
			?>
		</div>
		<?php endif; ?>
	</header>

	<?php chd_post_thumbnail(); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-footer">
		<?php chd_entry_footer(); ?>
	</footer><
</article>
