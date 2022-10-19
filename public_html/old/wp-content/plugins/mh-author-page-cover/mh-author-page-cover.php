<?php
/*
Plugin Name: Mharty - Author's Page Cover
Plugin URI: http://mharty.com/
Description: This extension provides the ability to add covers to author's page, also adds an author box after posts.
Version: 1.3.2
Author: mharty.com
Author URI: http://mharty.com/
Text Domain: mh-author-page-cover
Domain Path: /lang/
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! class_exists( 'Mh_Author_Page_Cover', false ) ) {
    class Mh_Author_Page_Cover {
        private static $instance;
	
		function __construct() {
			//Only one activated instance of this cass
			if ( isset( self::$instance ) ) {
				wp_die( sprintf( '%s is a singleton class and you cannot create a second instance.',
					get_class( $this ) )
				);
			}
			if ( !( defined( 'MHARTY_THEME' ) && MHARTY_THEME ) || !function_exists( 'mh_get_language_fonts' ) ) {
				return; // Disable the plugin, if current theme is not mharty and MH Composer not active
			}
			
			$this->load_textdomain();
			$this->setup_mh_author_page_cover();
		}
		
		/**
         * Setup
         */
		function setup_mh_author_page_cover() {
			define( 'MH_AUTHOR_PC_VER', '1.3.2' );
			define( 'MH_AUTHOR_PC_URL', plugin_dir_url( __FILE__ ) );
			define( 'MH_AUTHOR_PC_DIR', plugin_dir_path( __FILE__ ) );
			
			require_once MH_AUTHOR_PC_DIR . 'includes/functions.php';
		}
		
		/**
         * Internationalization
		 * 		- WP_LANG_DIR/mh-author-page-cover/mh-author-page-cover-$locale.mo
		 * 	 	- mh-author-page-cover/lang/mh-author-page-cover-$locale.mo
         */
		function load_textdomain() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'mh-author-page-cover' );
			load_textdomain( 'mh-author-page-cover', WP_LANG_DIR . '/mh-author-page-cover/mh-author-page-cover-' . $locale . '.mo' );
			load_plugin_textdomain( 'mh-author-page-cover', false, plugin_basename( dirname( __FILE__ ) ) . "/lang" );
		}
	}
}
/**
 * Init Mh_Author_Page_Cover when WordPress Initialises.
 */
function mh_author_page_cover_init_plugin() {
	new Mh_Author_Page_Cover();
}
add_action( 'init', 'mh_author_page_cover_init_plugin' );

/**
 * Hook the updater!
 */
function mh_author_page_cover_init_updater() {
	$mh_api_id = $mh_api_email = '';
	if (function_exists('mh_get_option') ):
		$mh_api_id = esc_attr( mh_get_option( 'mharty_activate_id', '' ) );
		$mh_api_email = esc_attr( mh_get_option( 'mharty_activate_email', '' ) );
	endif;
	require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/mharty-updater.php' );
	$config = array(
		'base'      => plugin_basename( __FILE__ ),
		'repo_uri'  => 'http://mharty.com/',
		'repo_slug' => 'mhauthorpagecover',
		'username' => $mh_api_id,
		'key'       => $mh_api_email,
		'dashboard' => false,
	);
	new Mh_Author_Page_Cover_Updater( $config );
}
add_action( 'init', 'mh_author_page_cover_init_updater' );