<?php
// Prevent file from being loaded directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Load Mharty App.
 */

// Stop here if the App was already loaded.
if ( defined( 'MHARTY_APP' ) ) {
	return;
}

define( 'MHARTY_APP', true );

/**
 * Setup App.
 */
 if ( ! function_exists( 'mh_app_setup' ) ) :
function mh_app_setup( $url ) {
	if ( ! defined( 'MHARTY_APP_VERSION' ) ) {
		define( 'MHARTY_APP_VERSION', '1.0.0' );
	}

	define( 'MHARTY_APP_PATH', trailingslashit( dirname( __FILE__ ) ) );
	define( 'MHARTY_APP_URL', trailingslashit( $url ) . 'app/' );
	define( 'MHARTY_APP_TEXTDOMAIN', 'mharty' );

	require_once( MHARTY_APP_PATH . 'parts.php' );

	if ( is_admin() ) {
		require_once( MHARTY_APP_PATH . 'admin/includes/assets.php' );
		add_action( 'admin_enqueue_scripts', 'mh_app_load_main_styles' );
		add_action( 'customize_controls_enqueue_scripts', 'mh_app_load_main_styles_customizer' );
	}
}
endif;

if ( ! function_exists( 'mh_app_load_main_styles' ) ) :
function mh_app_load_main_styles( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		return;
	}

	wp_enqueue_style( 'mh-app-admin' );
}
endif;

if ( ! function_exists( 'mh_app_load_main_styles_customizer' ) ) :
function mh_app_load_main_styles_customizer( ) {
	wp_enqueue_style( 'mh-app-admin' );
}
endif;