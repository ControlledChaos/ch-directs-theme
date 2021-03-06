<?php
/**
 * Template part for displaying results in search pages
 *
 * @package    WordPress
 * @subpackage CH_Directs_Theme\Frontend
 * @since      1.0.0
 */

namespace CH_Directs_Theme\Frontend;

// Get template tags from the Template_Tags class.
use CH_Directs_Theme\Functions\Template_Tags;

// Use the class as a variable.
$tags = new Template_Tags;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			$tags->posted_on();
			$tags->posted_by();
			?>
		</div>
		<?php endif; ?>
	</header>

	<?php $tags->post_thumbnail(); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-footer">
		<?php $tags->entry_footer(); ?>
	</footer><
</article>
