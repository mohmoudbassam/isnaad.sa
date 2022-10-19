<?php
/**
 * App\Import & Export (impoexpo)
 */

/**
 * Register impoexpo.
 *
 * This function should be called in an 'admin_init' action callback.
 * @param string $context A unique ID used to register the impoexpo arguments.
 *
 * @param array  $args {
 *      Array of arguments used to register the impoexpo.
 *
 * 		@type string $name	  The name used in the various text string.
 * 		@type bool   $view	  Whether the assets and content should load or not.
 * 		      				  Example: `isset( $_GET['page'] ) && $_GET['page'] == 'example'`.
 * 		@type string $db	  The option_name from the wp_option table used to export and import data.
 * 		@type array  $include Optional. Array of all the options scritcly included. Options ids must be set
 *         					  as the array keys.
 *      @type array  $exclude Optional. Array of excluded options. Options ids must be set as the array keys.
 * }
 * @return bool.
 */
if ( ! function_exists( 'mh_app_impoexpo_register' ) ) :
function mh_app_impoexpo_register( $context, $args ) {
	$defaults = array(
		'context' => $context,
		'name'    => false,
		'view'    => false,
		'type'    => false,
		'target'  => false,
		'include' => array(),
		'exclude' => array(),
	);

	$data = apply_filters( "mh_app_impoexpo_args_{$context}", (object) array_merge( $defaults, (array) $args ) );

	mh_app_cache_set( $context, $data, 'mh_app_impoexpo' );

	// Stop here if not allowed.
	if ( function_exists( 'mhc_permitted' ) && ! mhc_permitted( array( 'impoexpo', "{$data->context}_impoexpo" ) ) ) {

		// Set view to false if not allowed.
		$data->view = false;
		mh_app_cache_set( $context, $data, 'mh_app_impoexpo' );

		return;
	}

	if ( $data->view ) {
		mh_app_impoexpo_load( $context );
	}
}
endif;
/**
 * Load Import & Export (impoexpo) class.
 * @param string $context A unique ID used to register the impoexpo arguments.
 * @return bool Always return true.
 */
if ( ! function_exists( 'mh_app_impoexpo_load' ) ) :
function mh_app_impoexpo_load( $context ) {
	require_once( MHARTY_APP_PATH . 'admin/includes/class-impoexpo.php' );
	return new MH_App_ImpoExpo( $context );
}
endif;
/**
 * HTML link to trigger the impoexpo modal.
 * @param string $context    The context used to register the impoexpo.
 * @param string $attributes Optional. Query string or array of attributes. Default empty.
 * @return bool Always return true.
 */
if ( ! function_exists( 'mh_app_impoexpo_link' ) ) :
function mh_app_impoexpo_link( $context, $attributes = array() ) {
	$instance = mh_app_cache_get( $context, 'mh_app_impoexpo' );

	if ( ! current_user_can( 'switch_themes' ) || ! ( isset( $instance->view ) && $instance->view ) ) {
		return;
	}

	$defaults = array(
		'title' => esc_attr__( 'Import & Export', MHARTY_APP_TEXTDOMAIN ),
	);
	$attributes = array_merge( $defaults, $attributes );

	// Forced attributes.
	$attributes['href'] = '#';
	$attributes['data-mh-app-modal'] = "[data-mh-app-impoexpo='{$context}']";

	$string = '';

	foreach ( $attributes as $attribute => $value ) {
		if ( null !== $value ){
			$string .= esc_attr( $attribute ) . '="' . esc_attr( $value ) . '" ';
		}
	}

	return sprintf(
		'<a %1$s><span>%2$s</span></a>',
		trim( $string ),
		esc_html( $attributes['title'] )
	);
}
endif;
/**
 * Ajax impoexpo Import.
 */
if ( ! function_exists( 'mh_app_impoexpo_ajax_import' ) ) :
function mh_app_impoexpo_ajax_import() {
	if ( ! isset( $_POST['context'] ) ) {
		wp_send_json_error();
	}

	if ( $impoexpo = mh_app_impoexpo_load( sanitize_text_field( $_POST['context'] ) ) ) {
		$impoexpo->import();
	}
}
endif;
add_action( 'wp_ajax_mh_app_impoexpo_import', 'mh_app_impoexpo_ajax_import' );
/**
 * Ajax impoexpo Export.
 */
if ( ! function_exists( 'mh_app_impoexpo_ajax_export' ) ) :
function mh_app_impoexpo_ajax_export() {
	if ( ! isset( $_POST['context'] ) ) {
		wp_send_json_error();
	}

	if ( $impoexpo = mh_app_impoexpo_load( sanitize_text_field( $_POST['context'] ) ) ) {
		$impoexpo->export();
	}
}
endif;
add_action( 'wp_ajax_mh_app_impoexpo_export', 'mh_app_impoexpo_ajax_export' );
/**
 * Cancel impoexpo action.
 */
if ( ! function_exists( 'mh_app_impoexpo_ajax_cancel' ) ) :
function mh_app_impoexpo_ajax_cancel() {
	if ( ! isset( $_POST['context'] ) || ( ! isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'mh_app_impoexpo_nonce' ) ) ) {
		wp_send_json_error();
	}

	if ( $impoexpo = mh_app_impoexpo_load( sanitize_text_field( $_POST['context'] ) ) ) {
		$impoexpo->delete_temp_files( true );
	}
}
endif;
add_action( 'wp_ajax_mh_app_impoexpo_cancel', 'mh_app_impoexpo_ajax_cancel' );
/**
 * Import & Export (impoexpo) export.
 */
if ( ! function_exists( 'mh_app_impoexpo_export' ) ) :
function mh_app_impoexpo_export() {
	if ( ! ( isset( $_GET['mh_app_impoexpo'] ) && isset( $_GET['timestamp'] ) ) ) {
		return;
	}

	if ( $impoexpo = mh_app_impoexpo_load( sanitize_text_field( $_GET['timestamp'] ) ) ) {
		$impoexpo->download_export();
	}
}
endif;
add_action( 'admin_init', 'mh_app_impoexpo_export', 20 );

