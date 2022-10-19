<?php
/**
 * Defines which App parts to load.
 *
 * It can be different on a per page bases to keep it as performant and lightweight as possible
 * by only loading what is needed.
 */

/**
 * Load App parts.
 *
 * This function loads App parts which are only loaded once, even if they are called many times.
 * Admin parts/functions are automatically wrapped in an is_admin() check.
 *
 * @param string|array $parts Name of the App part(s) to include as and indexed array.
 *
 * @return bool Always return true.
 */
if ( ! function_exists( 'mh_app_load_parts' ) ) :
function mh_app_load_parts( $parts ) {
	static $loaded = array();

	// Load in front end and backend.
	$common = array();

	// Only load admin parts if is_admin() is true.
	$admin = is_admin() ? array(
		'impoexpo' => MHARTY_APP_PATH . 'admin/includes/impoexpo.php',
		'cache'       => array(
			MHARTY_APP_PATH . 'admin/includes/cache.php',
			MHARTY_APP_PATH . 'admin/includes/class-cache.php'
		),
	) : array();

	// Set dependencies.
	$dependencies = array(
		'impoexpo' => 'cache',
	);

	foreach ( (array) $parts as $part ) {
		// Stop here if the part is already loaded or doesn't exists.
		if ( in_array( $part, $loaded ) || ( ! isset( $common[$part] ) && ! isset( $admin[$part] ) ) ) {
			continue;
		}

		// Cache loaded part before calling dependencies.
		$loaded[] = $part;

		// Load dependencies.
		if ( array_key_exists( $part, $dependencies ) ) {
			mh_app_load_parts( $dependencies[$part] );
		}

		$_parts = array();

		if ( isset( $common[$part] ) ) {
			$_parts = (array) $common[$part];
		}

		if ( isset( $admin[$part] ) ) {
			$_parts = array_merge( (array) $_parts, (array) $admin[$part] );
		}

		foreach ( $_parts as $part_path ) {
			require_once( $part_path );
		}

		/**
		 * Fires when an App part is loaded.
		 *
		 * The dynamic portion of the hook name, $part, refers to the name of the App part loaded.
		 */
		do_action( 'mh_app_loaded_part_' . $part );
	}
}
endif;