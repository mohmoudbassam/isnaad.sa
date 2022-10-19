<?php
/*
Plugin Name: Mharty - More Icons
Plugin URI: http://mharty.com/
Description: This extension offers more than 1200 icons to use in MH Page Composer.
Version: 1.3.0
Author: mharty.com
Author URI: http://mharty.com/
Text Domain: mh-more-icons
Domain Path: /lang/
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! class_exists( 'MHMoreIconsClass', false ) ) {
    class MHMoreIconsClass {
        private static $instance;
	
		function __construct() {
			//Only one activated instance of this cass
			if ( isset( self::$instance ) ) {
				wp_die( sprintf( '%s is a singleton class and you cannot create a second instance.',
					get_class( $this ) )
				);
			}
			if ( !( defined( 'MHARTY_THEME' ) && MHARTY_THEME ) || !function_exists( 'mh_get_language_fonts' ) ) {
				return; // Disable the plugin, if current theme is not mharty
			}
			
			$this->load_textdomain();
			$this->setup_mh_more_icons();
		}
		
		/**
         * Setup
         */
		function setup_mh_more_icons() {
			define( 'MH_MORE_ICONS_VER', '1.3.0' );
			define( 'MH_MORE_ICONS_URL', plugin_dir_url( __FILE__ ) );
			define( 'MH_MORE_ICONS_DIR', plugin_dir_path( __FILE__ ) );

			require_once MH_MORE_ICONS_DIR . 'includes/functions.php';
		}
		
		/**
         * Internationalization
		 * 		- WP_LANG_DIR/mh-more-icons/mh-more-icons-$locale.mo
		 * 	 	- mh-more-icons/lang/mh-more-icons-$locale.mo
         */
		function load_textdomain() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'mh-more-icons' );
			load_textdomain( 'mh-more-icons', WP_LANG_DIR . '/mh-more-icons/mh-more-icons-' . $locale . '.mo' );
			load_plugin_textdomain( 'mh-more-icons', false, plugin_basename( dirname( __FILE__ ) ) . "/lang" );
		}
	}
}

/**
 * Init MHMoreIconsClass when WordPress Initialises.
 */
function mh_more_icons_init_plugin() {
	new MHMoreIconsClass();
}
add_action( 'init', 'mh_more_icons_init_plugin' );

/**
 * Hook the updater!
 */
function mh_more_icons_init_updater() {
	$mh_api_id = $mh_api_email = '';
	if (function_exists('mh_get_option') ):
		$mh_api_id = esc_attr( mh_get_option( 'mharty_activate_id', '' ) );
		$mh_api_email = esc_attr( mh_get_option( 'mharty_activate_email', '' ) );
	endif;
	require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/mharty-updater.php' );
	$config = array(
		'base'      => plugin_basename( __FILE__ ),
		'repo_uri'  => 'http://mharty.com/',
		'repo_slug' => 'mhmoreicons',
		'username' => $mh_api_id,
		'key'       => $mh_api_email,
		'dashboard' => false,
	);
	new Mh_More_Icons_Updater( $config );
}
 add_action( 'init', 'mh_more_icons_init_updater' );