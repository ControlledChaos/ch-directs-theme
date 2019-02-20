<?php
/**
 * The template for displaying all pages
 *
 * @package    WordPress
 * @subpackage CH_Directs_Theme\Frontend
 * @since      1.0.0
 */

namespace CH_Directs_Theme\Frontend;

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" itemscope itemprop="mainContentOfPage">

		<?php while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

		endwhile; // End of the loop.
		?>

		</main>
	</div>

<?php get_footer();