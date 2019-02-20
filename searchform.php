<?php
/**
 * Search form output
 *
 * @package    WordPress
 * @subpackage CH_Directs_Theme\Frontend
 * @since      1.0.0
 */

namespace CH_Directs_Theme\Frontend;
?>
<h3><?php _e( 'Search','ip-theme' ); ?></h3>
<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search" class="screen-reader-text"><?php _e( 'Search for:','ip-theme' ); ?></label>
	<input type="search" class="search" id="search" name="s" value="" placeholder="<?php _e( 'Search','ip-theme' ); ?>" />
	<input type="submit" value="<?php _e( 'Search','ip-theme' ); ?>" class="search-submit" id="search-submit" />
</form>