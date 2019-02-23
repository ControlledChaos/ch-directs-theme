<?php
/**
 * Courtney Hoffman Directs functions
 *
 * Theme for the courtneyhoffmandirects.com website.
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

// Get plugins path to check for active plugins.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Define the companion plugin path: directory and core file name.
 *
 * This theme is designed to coordinate with a companion plugin.
 *
 * @link   https://github.com/ControlledChaos/ch-directs-plugin
 *
 * @since  1.0.0
 * @return string Returns the plugin path.
 */
if ( ! defined( 'CHD_PLUGIN' ) ) {
	define( 'CHD_PLUGIN', 'ch-directs-plugin/ch-directs-plugin.php' );
}

/**
 * Define the companion plugin prefix for filters and options.
 *
 * @since  1.0.0
 * @return string Returns the prefix without trailing character.
 */
if ( is_plugin_active( CHD_PLUGIN ) && ! defined( 'CHD_PLUGIN_PREFIX' ) ) {
	define( 'CHD_PLUGIN_PREFIX', 'chd' );
}

/**
 * Theme functions class
 *
 * @since  1.0.0
 * @access public
 */
final class Functions {

	/**
	 * Return the instance of the class
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {

			$instance = new self;

			// Theme dependencies.
			$instance->dependencies();

		}

		return $instance;
	}

	/**
	 * Constructor magic method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Swap html 'no-js' class with 'js'.
		add_action( 'wp_head', [ $this, 'js_detect' ], 0 );

		// Theme setup.
		add_action( 'after_setup_theme', [ $this, 'setup' ] );

		// Remove unpopular meta tags.
		add_action( 'init', [ $this, 'head_cleanup' ] );

		// Frontend scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );

		// Admin scripts.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );

		// Frontend styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_styles' ] );

		/**
		 * Admin styles.
		 *
		 * Call late to override plugin styles.
		 */
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ], 99 );

		// Login styles.
		add_action( 'login_enqueue_scripts', [ $this, 'login_styles' ] );

		// Custom media insert strings.
		add_filter( 'image_size_names_choose', [ $this, 'insert_custom_image_sizes' ] );

		// Remove the site Customizer.
		remove_action( 'plugins_loaded', '_wp_customize_include', 10 );
		remove_action( 'admin_enqueue_scripts', '_wp_customize_loader_settings', 11 );
		add_filter( 'map_meta_cap', [ $this, 'remove_customize_capability' ], 10, 4 );

	}

	/**
	 * JS detect
	 *
	 * Replace 'no-js' class with 'js' in the <html> element when JavaScript is detected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function js_detect() {

		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

	}

	/**
	 * Theme setup
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function setup() {

		/**
		 * Load domain for translation
		 *
		 * @since 1.0.0
		 */
		load_theme_textdomain( 'ch-directs-theme' );

		/**
		 * Add theme support
		 *
		 * @since 1.0.0
		 */

		// Browser title tag support.
		add_theme_support( 'title-tag' );

		// RSS feed links support.
		add_theme_support( 'automatic-feed-links' );

		// HTML 5 tags support.
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gscreenery',
			'caption'
		 ] );

		// Featured image support.
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add image sizes
		 *
		 * Three sizes per aspect ratio so that WordPress
		 * will use srcset for responsive images.
		 *
		 * @since 1.0.0
		 */

		// 1:1 Square.
		add_image_size( __( 'avatar', 'ch-directs-theme' ), 80, 80, true );
		add_image_size( __( 'large-thumb', 'ch-directs-theme' ), 240, 240, true );

		// 16:9 HD Video.
		add_image_size( __( 'video', 'ch-directs-theme' ), 1280, 720, true );
		add_image_size( __( 'video-md', 'ch-directs-theme' ), 960, 540, true );
		add_image_size( __( 'video-sm', 'ch-directs-theme' ), 640, 360, true );

		// 21:9 Cinemascope.
		add_image_size( __( 'banner', 'ch-directs-theme' ), 1280, 549, true );
		add_image_size( __( 'banner-md', 'ch-directs-theme' ), 960, 411, true );
		add_image_size( __( 'banner-sm', 'ch-directs-theme' ), 640, 274, true );

		// Add image size for meta tags if companion plugin is not activated.
		if ( ! CHD_PLUGIN ) {
			add_image_size( __( 'Meta Image', 'ch-directs-theme' ), 1200, 630, true );
		}

		/**
		 * Set content width
		 *
		 * @since 1.0.0
		 */

		if ( ! isset( $content_width ) ) {
			$content_width = 1280;
		}

		/**
		 * Register theme menus
		 *
		 * @since  1.0.0
		 */
		register_nav_menus( [
			'front'  => __( 'Front Page Menu', 'ch-directs-theme' ),
			'main'   => __( 'Main Menu', 'ch-directs-theme' ),
			'footer' => __( 'Footer Menu', 'ch-directs-theme' ),
			'social' => __( 'Social Menu', 'ch-directs-theme' )
		] );

		/**
		 * Add stylesheet for the content editor.
		 *
		 * @since 1.0.0
		 */
		add_editor_style( '/assets/css/editor.min.css', [ 'ch-directs-theme-admin' ], '', 'screen' );

	}

	/**
	 * Clean up meta tags from the <head>
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function head_cleanup() {

		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_site_icon', 99 );
	}

	/**
	 * Frontend scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {

		wp_enqueue_script( 'jquery' );

		// FullPageJS script on the front page.
		if ( is_front_page() ) {
			wp_enqueue_script( 'ch-directs-fullpage', get_parent_theme_file_uri( 'assets/js/fullpage.min.js' ), [ 'jquery' ], null, true );
		}

		// Comments scripts.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	/**
	 * Admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_scripts() {}

	/**
	 * Frontend styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_styles() {

		// The main theme stylesheet, minified.
		wp_enqueue_style( 'ch-directs-theme', get_parent_theme_file_uri( 'style.min.css' ), [], '', 'screen' );

		// Load fonts from Google.
		wp_enqueue_style( 'ch-directs-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Montserrat:400,700|Six+Caps', [], '', 'screen' );

		// Icon fons stylesheets, minified.
		wp_enqueue_style( 'ch-directs-theme-icons', get_theme_file_uri( '/assets/css/ch-directs.min.css' ), [], '', 'screen' );
		wp_enqueue_style( 'ch-directs-theme-icons-embedded', get_theme_file_uri( '/assets/css/ch-directs-embedded.min.css' ), [], '', 'screen' );

		// FullPageJS styles on the front page.
		if ( is_front_page() ) {
			wp_enqueue_style( 'ch-directs-fullpage', get_parent_theme_file_uri( 'assets/css/front-page.min.css' ), [ 'ch-directs-theme' ], '', 'screen' );
		}

	}

	/**
	 * Admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_styles() {

		// Load fonts from Google.
		wp_enqueue_style( 'ch-directs-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Montserrat:400,700|Six+Caps', [], '', 'screen' );

		// Icon fons stylesheets, minified.
		wp_enqueue_style( 'ch-directs-theme-icons', get_theme_file_uri( '/assets/css/ch-directs.min.css' ), [], '', 'screen' );
		wp_enqueue_style( 'ch-directs-theme-icons-embedded', get_theme_file_uri( '/assets/css/ch-directs-embedded.min.css' ), [], '', 'screen' );

		// The admin theme stylesheet, minified.
		wp_enqueue_style( 'ch-directs-theme', get_theme_file_uri( '/assets/css/admin.min.css' ), [], '', 'screen' );

	}

	/**
	 * Login styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function login_styles() {

		// Load fonts from Google.
		wp_enqueue_style( 'ch-directs-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Montserrat:400,700|Six+Caps', [], '', 'screen' );

		// Icon fons stylesheets, minified.
		wp_enqueue_style( 'ch-directs-theme-icons', get_theme_file_uri( '/assets/css/ch-directs.min.css' ), [], '', 'screen' );
		wp_enqueue_style( 'ch-directs-theme-icons-embedded', get_theme_file_uri( '/assets/css/ch-directs-embedded.min.css' ), [], '', 'screen' );

		// The login theme stylesheet, minified.
		wp_enqueue_style( 'ch-directs-theme-login', get_theme_file_uri( '/assets/css/login.min.css' ), [], '', 'screen' );

	}

	/**
	 * Custom media insert strings
	 *
	 * Removes any dashes from custom image sizes names and
	 * returns the names with uppercase first letters.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Returns image names with uppercase first letters
	 *               and no dashes between words.
	 */
	public function insert_custom_image_sizes( $sizes ) {

		// Access global variables.
		global $_wp_additional_image_sizes;

		// Return sizes as normal if no additional sizes.
		if ( empty( $_wp_additional_image_sizes ) ) {
			return $sizes;
		}

		// Make each additional image size read as desired.
		foreach ( $_wp_additional_image_sizes as $id => $data ) {
			if ( ! isset( $sizes[$id] ) ) {
				$sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
			}
		}

		// Return the modified image size names.
		return $sizes;

	}

	/**
	 * Remove customize capability
	 *
	 * Uses a non-existent user role for permission to access the Customizer,
	 * which effectively hides it from all logged-in users.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function remove_customize_capability( $caps = [], $cap = '', $user_id = 0, $args = [] ) {

		// Bogus user role of `none`.
		if ( $cap == 'customize' ) {
			return [ 'none' ];
		}

		// Return the new user capability.
		return $caps;

	}

	/**
	 * Theme dependencies.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		require_once get_theme_file_path( '/includes/class-template-tags.php' );

	}

}

/**
 * Gets the instance of the Functions class.
 *
 * This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function ch_directs() {

	$ch_directs = Functions::get_instance();

	return $ch_directs;

}

// Run the Functions class.
ch_directs();