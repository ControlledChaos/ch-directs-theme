<?php
/**
 * The template for displaying all pages
 *
 * @package    WordPress
 * @subpackage CH_Directs_Theme\Frontend
 * @since      1.0.0
 */

namespace CH_Directs_Theme\Frontend;

// Alias the WordPress query.
use WP_Query;

get_header( 'front' ); ?>

	<main id="front-page" class="site-main" itemscope itemprop="mainContentOfPage">
		<section class="fp-section active intro">
			<header class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/Organization">
				<div class="site-title-description">
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
					<p class="enter"><a class="enter" href="#projects" title="Scroll Down"><span class="screen-reader-text"><?php _e( 'Scroll down to view projects', 'ch-directs-theme' ); ?></span></a></p>
				</div>
			</header>
			<div class="nav-wrap screen-reader-text">
				<nav id="site-navigation" class="main-navigation" role="directory" itemscope itemtype="http://schema.org/SiteNavigationElement">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'ch-directs-theme' ); ?></button>
					<?php wp_nav_menu( [
						'theme_location' => 'front',
						'menu_id'        => 'front-page-menu',
						'menu_class'     => 'main-navigation-list',
						'container'      => false,
						'fallback_cb'    => false
					] ); ?>
				</nav>
			</div>
		</section>
		<section class="fp-section" id="projects">
			<h2><?php _e( 'Projects' ); ?></h2>
			<?php
			// Projects post type arguments.
			$args = [
				'post_type' => 'projects',
				'order'     => 'ASC',
				'orderby'   => 'menu_order',
			];

			// New projects query.
			$query = new WP_Query( $args );

			// The projects loop.
			if ( $query->have_posts() ) {
				$count = 0;
				while ( $query->have_posts() ) {
					$count++;
					if ( 1 == $count ) {
						$class = 'fp-slide active';
					} else {
						$class = 'fp-slide';
					}
					$query->the_post();

					// Access global variables.
					global $post;

					// Get the post ID as a variable.
					$ID = $post->ID;

					// Project image.
					$image  = get_field( 'project_image' );
					$url    = $image['url'];
					$title  = $image['title'];
					$alt    = $image['alt'];
					$size   = 'large';
					$src    = $image['sizes'][$size];
					$width  = $image['sizes'][$size . '-width'];
					$height = $image['sizes'][$size . '-height'];

					// Project role.
					$role = get_field( 'project_role' );
					if ( 'both' == $role ) {
						$role = sprintf(
							'<p>%1s</p>',
							__( 'Directed by Courtney Hoffman', 'ch-directs-theme' )
						);
						$role .= sprintf(
							'<p>%1s</p>',
							__( 'Written by Courtney Hoffman', 'ch-directs-theme' )
						);
					} elseif ( 'writer' == $role ) {
						$role = sprintf(
							'<p>%1s</p>',
							__( 'Written by Courtney Hoffman', 'ch-directs-theme' )
						);
					} else {
						$role = sprintf(
							'<p>%1s</p>',
							__( 'Directed by Courtney Hoffman', 'ch-directs-theme' )
						);
					}

					// Project video.
					$vimeo = get_field( 'project_vimeo' );
					if ( $vimeo ) {
						$video = sprintf(
							'<li><a data-fancybox id="video-link" href="%1s?title=0&byline=0&portrait=0&color=ffffff&autoplay=1">%2s</a></li>',
							esc_url( $vimeo ),
							__( 'Video', 'ch-directs-theme' )
						);
					} else {
						$video = null;
					}

					// Project gallery.
					$gallery_images = get_field( 'project_gallery' );
					if ( $gallery_images ) {
						$gallery_first = $gallery_images[0];
						$gallery_url   = $gallery_first['url'];
						$gallery = sprintf(
							'<li><a href="%1s" data-fancybox="gallery" data-fancybox-group="gallery-%2s" rel="gallery-%3s">%4s</a></li>',
							$gallery_url,
							$ID,
							$ID,
							__( 'Photos', 'ch-directs-theme' )
						);
					} else {
						$gallery = null;
					}
					?>
					<div class="<?php echo $class; ?>">
						<article class="fp-slide-inner">
							<div class="fp-slide-image"><img src="<?php echo $src; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="<?php echo $alt; ?>" /></div>
							<div class="fp-slide-info">
								<h3><?php the_title(); ?></h3>
								<div class="fp-slide-credits">
									<?php echo $role; ?>
								</div>
								<div class="fp-slide-description">
									<?php the_field( 'project_description' ); ?>
								</div>
								<div class="fp-slide-actions">
									<ul>
										<?php echo $video; ?>
										<?php echo $gallery; ?>
										<li><a href="<?php the_permalink(); ?>"><?php _e( 'More Info', 'ch-directs-theme' ); ?></a></li>
									</ul>
								</div>
								<div style="display: none" class="fp-slide-gallery">
									<?php
									if ( $gallery_images ) : $i = 0;
										foreach( $gallery_images as $gallery_image ) : $i++; if ( $i != 1 ) : ?>
											<a data-fancybox="gallery" data-fancybox-group="<?php echo 'gallery-' . $ID; ?>" rel="<?php echo 'gallery-' . $ID; ?>" href="<?php echo $gallery_image['url']; ?>">
												<img src="<?php echo $gallery_image['sizes']['avatar']; ?>" />
											</a>
										<?php endif; if ( ++$i == 12 ) { break; } endforeach;
										// Final gallery frame notice ?>
										<a data-fancybox="gallery" data-fancybox-group="<?php echo 'gallery-' . $ID; ?>" rel="<?php echo 'gallery-' . $ID; ?>" href="<?php echo '#fancybox-link-' . $ID; ?>"></a>
										<div id="<?php echo 'fancybox-link-' . $ID; ?>" class="fancybox-link">
											<h3><?php the_title(); ?></h3>
											<p><?php _e( 'More photos, video & info available on this project\'s page.', 'ch-directs-theme' ); ?></p>
											<p style="text-align: right;"><a href="<?php the_permalink(); ?>"><?php _e( 'Take me there', 'ch-directs-theme' ); ?></a> | <a href="javascript:jQuery.fancybox.close();"><?php _e( 'Close', 'ch-directs-theme' ); ?></a></p>
										</div>
										<?php endif; // End if gallery. ?>
								</div>
							</div>
						</article>
					</div>
				<?php }
			} else {
				echo sprintf(
					'<p>%1s</p>',
					__( 'No projects listed at this time.', 'ch-directs-theme' )
				);
			}

			// Restore original post data.
			wp_reset_postdata(); ?>
		</section>
		<section class="fp-section" id="press-resume">
			<article class="hentry entry-article" role="article">
				<header class="entry-header" itemprop="WPHeader">
					<h2><?php _e( 'Press + Resume', 'ch-directs-theme' ); ?></h2>
				</header>
				<div class="entry-content" itemprop="articleBody">
					<p>Officia aute ut pig cow leberkas turkey. Salami andouille cupim beef. Bresaola leberkas turducken, ut consectetur t-bone fugiat eu meatloaf biltong buffalo qui laborum aliquip. Et ad duis doner. Anim excepteur dolore laborum prosciutto alcatra beef ribs biltong drumstick turkey ground round tempor landjaeger boudin tri-tip.</p>
				</div>
			</article>
		</section>
		<section class="fp-section" id="contact">
			<article class="hentry entry-article" role="article">
				<header class="entry-header" itemprop="WPHeader">
					<h2><?php _e( 'Contact', 'ch-directs-theme' ); ?></h2>
				</header>
				<div class="entry-content" itemprop="articleBody">
					<p>Beef ribs burgdoggen officia short ribs, kevin pancetta salami tail bresaola nisi laborum exercitation drumstick. Proident leberkas in drumstick, kevin beef ribs mollit shank. Capicola sed hamburger corned beef jerky laborum ipsum chuck spare ribs. Tri-tip boudin eu sint, bacon ullamco id tongue fatback pork loin buffalo swine in ut labore. Excepteur biltong ham hock qui ullamco est. Sirloin fatback dolor tongue bresaola. Pork loin aliquip pariatur nulla sint, deserunt flank beef labore.</p>
				</div>
			</article>
		</section>
	</main>

<?php get_footer( 'front' );