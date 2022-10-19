<?php
/*
Plugin Name: Mharty - Love it
Plugin URI: http://mharty.com/
Description: Add likes and sharing icons to your posts and projects.
Version: 2.3.0
Author: mharty.com
Author URI: http://mharty.com/
Text Domain: mh-loveit
Domain Path: /lang/
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! class_exists( 'MHLoveitClass', false ) ) {
    class MHLoveitClass {
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
			$this->setup_mh_loveit();
		}
		
		/**
         * Setup
         */
		function setup_mh_loveit() {
			define( 'MH_LOVEIT_VER', '2.3.0' );
			define( 'MH_LOVEIT_URL', plugin_dir_url( __FILE__ ) );
			define( 'MH_LOVEIT_DIR', plugin_dir_path( __FILE__ ) );

			require_once MH_LOVEIT_DIR . 'includes/likes.php';
			require_once MH_LOVEIT_DIR . 'includes/functions.php';
			//hook components to the composer list
			add_action( 'mh_composer_add_extra_components', 'mh_loveit_add_elements' );
		}
		
		/**
         * Internationalization
		 * 		- WP_LANG_DIR/mh-loveit/mh-loveit-$locale.mo
		 * 	 	- mh-loveit/lang/mh-loveit-$locale.mo
         */
		function load_textdomain() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'mh-loveit' );
			load_textdomain( 'mh-loveit', WP_LANG_DIR . '/mh-loveit/mh-loveit-' . $locale . '.mo' );
			load_plugin_textdomain( 'mh-loveit', false, plugin_basename( dirname( __FILE__ ) ) . "/lang" );
		}
	}
}
/**
 * Init MHLoveitClass when WordPress Initialises.
 */
function mh_loveit_init_plugin() {
	new MHLoveitClass();
}
add_action( 'init', 'mh_loveit_init_plugin' );

/**
 * Hook the updater!
 */
function mh_loveit_init_updater() {
	$mh_api_id = $mh_api_email = '';
	if (function_exists('mh_get_option') ):
		$mh_api_id = esc_attr( mh_get_option( 'mharty_activate_id', '' ) );
		$mh_api_email = esc_attr( mh_get_option( 'mharty_activate_email', '' ) );
	endif;
	require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/mharty-updater.php' );
	$config = array(
		'base'      => plugin_basename( __FILE__ ),
		'repo_uri'  => 'http://mharty.com/',
		'repo_slug' => 'mhloveit',
		'username' => $mh_api_id,
		'key'       => $mh_api_email,
		'dashboard' => false,
	);
	new Mh_Loveit_Updater( $config );
}
add_action( 'init', 'mh_loveit_init_updater' );