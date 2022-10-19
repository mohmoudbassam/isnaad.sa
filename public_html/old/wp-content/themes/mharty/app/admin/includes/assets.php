<?php
/**
 * App Assets.
 */

/**
 * Register App admin assets.
 */
if ( ! function_exists( 'mh_app_register_admin_assets' ) ) :
function mh_app_register_admin_assets() {
	$ltr = is_rtl() ? "" : "-ltr";
	wp_register_style( 'mh-app-admin', MHARTY_APP_URL . 'admin/css/app' . $ltr . '.css', array(), MHARTY_APP_VERSION );
	wp_register_script( 'mh-app-admin', MHARTY_APP_URL . 'admin/js/app.js', array(), MHARTY_APP_VERSION );
	wp_localize_script( 'mh-app-admin', 'mhApp', array(
		'ajaxurl'  => admin_url( 'admin-ajax.php' ),
		'text'     => array(
			'modalTempContentCheck' => esc_html__( 'Ok, thanks!', MHARTY_APP_TEXTDOMAIN ),
		),
	) );
}
endif;
add_action( 'admin_enqueue_scripts', 'mh_app_register_admin_assets' );
add_action( 'customize_controls_enqueue_scripts', 'mh_app_register_admin_assets' );