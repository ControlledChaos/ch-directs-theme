<?php
/**
 * Courtney Hoffman Directs functions
 *
 * This file is necessary for functionality but only
 * gets the theme functions class which does the work.
 *
 * @package    WordPress
 * @subpackage CH_Directs_Theme\Functions
 * @author     Greg Sweet <greg@ccdzine.com>
 * @copyright  Copyright (c) 2019, Greg Sweet
 * @link       https://github.com/ControlledChaos/ch-directs-theme
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @since      1.0.0
 */

namespace CH_Directs_Theme\Functions;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the theme functions class.
require_once get_theme_file_path( '/includes/class-functions.php' );