<?php
/*
Plugin Name: Mharty - Page Composer
Plugin URI: http://mharty.com/
Description: Allows you to compose pages in a beautiful way.
Version: 4.2.0
Author: mharty.com
Author URI: http://mharty.com/
Text Domain: mh-composer
Domain Path: /lang/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
define( 'MHARTY_COMPOSER', true );
define( 'MH_COMPOSER_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'MH_COMPOSER_PLUGIN_URI', plugins_url('', __FILE__) );

if( ! class_exists( 'MHComposer', false ) ) {
	class MHComposer {
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
			$this->setup_mh_composer();
			add_filter( 'body_class', array( $this, 'add_body_class' ) );
		}
		
		/**
         * Body Classes
         */
		function add_body_class( $classes ) {
			$classes[] = 'mh_composer';
	
			if ( function_exists( 'mh_composer_is_active' ) ) :
				if ( ( is_page() ||  is_singular( 'post' ) || is_singular( 'project' ) ) && mh_composer_is_active( get_the_ID() ) ) $classes[] = 'mhc_is_active';
				//add side nav class if used
				if ( ( is_page() ||  is_singular( 'post' ) || is_singular( 'project' ) ) && 'on' == get_post_meta( get_the_ID(), '_mhc_side_nav', true ) && mh_composer_is_active( get_the_ID() ) ) $classes[] = 'mhc_side_nav_page';
				
				endif;
			
			return $classes;
		}
		
		/**
         * Setup
         */
		function setup_mh_composer() {
			define( 'MH_COMPOSER_VER', '4.2.0' );
			define( 'MH_COMPOSER_DIR', MH_COMPOSER_PLUGIN_DIR . 'app/' );
			define( 'MH_COMPOSER_URI', trailingslashit( plugins_url( '', __FILE__ ) ) . 'app' );
			define( 'MH_COMPOSER_LAYOUT_POST_TYPE', 'mhc_layout' );
			
			require MH_COMPOSER_PLUGIN_DIR . 'includes/functions.php';
			require MH_COMPOSER_DIR . 'app.php';
			
			if (!function_exists( 'mh_app_setup' ) ) {
				if ( is_admin() ) {
					require_once( MH_COMPOSER_PLUGIN_DIR . 'includes/compatibility/app/app.php' );		
					mh_app_setup( MH_COMPOSER_PLUGIN_URI . 'includes/compatibility' );
				}
			}
			
			mhc_register_posttypes();
	
			add_action( 'mh_add_to_mharty_menu', array( $this, 'add_mh_composer_menu' ));
		}
	
		/**
         * Menu
		 * 		- Add Composer Vault
		 * 	 	- Add Composer Roles Manager
         */
		function add_mh_composer_menu() {
			if (mhc_permitted('mharty_vault')){
				add_submenu_page( 'mh_panel', esc_html__( 'Composer Vault', 'mh-composer' ), esc_html__( 'Composer Vault', 'mh-composer' ), 'manage_options', 'edit.php?post_type=mhc_layout' );
			}
			add_submenu_page( 'mh_panel', esc_html__( 'Composer Roles', 'mh-composer' ), esc_html__( 'Composer Roles', 'mh-composer' ), 'manage_options', 'mh_mharty_roles_manager', 'mhc_display_roles_manager' );
		}
	
		/**
         * Internationalization
		 * 		- WP_LANG_DIR/mh-composer/mh-composer-$locale.mo
		 * 	 	- mh-composer/lang/mh-composer-$locale.mo
         */
        function load_textdomain() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'mh-composer' );
			load_textdomain( 'mh-composer', WP_LANG_DIR . '/mh-composer/mh-composer-' . $locale . '.mo' );
			load_plugin_textdomain( 'mh-composer', false, plugin_basename( dirname( __FILE__ ) ) . "/lang" );
        }
	}
}

/**
 * Init MHComposer when WordPress Initialises.
 */
function mh_composer_init_plugin() {
	new MHComposer();
}
add_action( 'init', 'mh_composer_init_plugin' );

/**
 * Hook the updater!
 */
function mh_composer_init_updater() {
	$mh_api_id = $mh_api_email = '';
	if (function_exists('mh_get_option') ):
		$mh_api_id = esc_attr( mh_get_option( 'mharty_activate_id', '' ) );
		$mh_api_email = esc_attr( mh_get_option( 'mharty_activate_email', '' ) );
	endif;
	require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/mharty-updater.php' );
	$config = array(
		'base'      => plugin_basename( __FILE__ ),
		'repo_uri'  => 'https://mharty.com/',
		'repo_slug' => 'mhcomposer',
		'username' => $mh_api_id,
		'key'       => $mh_api_email,
		'framework' => false,
	);
	new Mh_Composer_Updater( $config );
}
add_action( 'init', 'mh_composer_init_updater' );