<?php
require_once( MH_COMPOSER_DIR . 'app-functions.php' );

function mh_composer_load_components_styles() {
	//piechart js
	wp_register_script( 'chart-appear-js', MH_COMPOSER_URI . '/js/appear-chart.min.js', array(), MH_COMPOSER_VER, true );
	/**
	 * Only load this during composer preview screen session
	 */
	if ( is_mhc_preview() ) {
		// Set fixed protocol for preview URL to prevent cross origin issue
		$preview_scheme = is_ssl() ? 'https' : 'http';

		// Get home url, then parse it
		$preview_origin_module = parse_url( home_url( '', $preview_scheme ) );

		// Rebuild origin URL, strip sub-directory address if there's any (postMessage e.origin doesn't pass sub-directory address)
		$preview_origin = "";

		// Perform check, prevent unnecessary error
		if ( isset( $preview_origin_module['scheme'] ) && isset( $preview_origin_module['host'] ) ) {
			$preview_origin = "{$preview_origin_module['scheme']}://{$preview_origin_module['host']}";

			// Append port number if different port number is being used
			if ( isset( $preview_origin_module['port'] ) ) {
				$preview_origin = "{$preview_origin}:{$preview_origin_module['port']}";
			}
		}

		// Enqueue theme's style if it hasn't been enqueued in case it is being hardcoded by the theme
		if ( !mh_composer_has_theme_style_enqueued()) {
			wp_enqueue_style( 'mhc-theme-stylesheet', get_stylesheet_uri(), array() );
		}

		wp_enqueue_style( 'mhc-preview-css', MH_COMPOSER_URI . '/css/preview.css', array(), MH_COMPOSER_VER );
		wp_enqueue_script( 'mhc-preview-js', MH_COMPOSER_URI . '/js/preview.js', array( 'jquery' ), MH_COMPOSER_VER, true );
		wp_localize_script( 'mhc-preview-js', 'mhc_preview_options', array(
			'preview_origin' => esc_url( $preview_origin ),
			'alert_origin_not_matched' => sprintf(
				esc_html__( 'Unauthorized access. Preview cannot be accessed outside %1$s.', 'mh-composer' ),
				esc_url( home_url( '', $preview_scheme ) )
			),
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'mh_composer_load_components_styles', 11 );

/**
 * Determine whether current page has enqueued theme's style.css or not
 * This is mainly used on preview screen to decide to enqueue theme's style nor not
 * @return bool
 */
function mh_composer_has_theme_style_enqueued() {
	global $wp_styles;

	if ( ! empty( $wp_styles->queue  ) ) {
		$theme_style_uri = get_stylesheet_uri();

		foreach ( $wp_styles->queue as $handle) {
			if ( isset( $wp_styles->registered[$handle]->src ) && $theme_style_uri === $wp_styles->registered[$handle]->src ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Added specific body classes for composer related situation
 * This enables theme to adjust its case independently
 * @return array
 */
function mh_composer_body_classes( $classes ) {
	if ( is_mhc_preview() ) {
		$classes[] = 'mhc-preview';
	}
	
	return $classes;
}
add_filter( 'body_class', 'mh_composer_body_classes' );

if ( ! function_exists( 'mh_composer_add_components' ) ) :
function mh_composer_add_components() {
	//list of all embedded components
	include MH_COMPOSER_DIR . 'components/section.php';
	include MH_COMPOSER_DIR . 'components/row.php';
	include MH_COMPOSER_DIR . 'components/column.php';
	include MH_COMPOSER_DIR . 'components/text.php';
	include MH_COMPOSER_DIR . 'components/image.php';
	include MH_COMPOSER_DIR . 'components/gallery.php';
	include MH_COMPOSER_DIR . 'components/slider.php';
	include MH_COMPOSER_DIR . 'components/video.php';
	include MH_COMPOSER_DIR . 'components/video-slider.php';
	include MH_COMPOSER_DIR . 'components/texton.php';
	include MH_COMPOSER_DIR . 'components/blurb.php';
	include MH_COMPOSER_DIR . 'components/cta.php';
	include MH_COMPOSER_DIR . 'components/pricing-tables.php';
	include MH_COMPOSER_DIR . 'components/pricing-menus.php';
	include MH_COMPOSER_DIR . 'components/blog.php';
	include MH_COMPOSER_DIR . 'components/portfolio.php';
	include MH_COMPOSER_DIR . 'components/filterable-portfolio.php';
	include MH_COMPOSER_DIR . 'components/sidebar.php';
	include MH_COMPOSER_DIR . 'components/tabs.php';
	include MH_COMPOSER_DIR . 'components/accordion.php';
	include MH_COMPOSER_DIR . 'components/toggle.php';
	include MH_COMPOSER_DIR . 'components/divider.php';
	include MH_COMPOSER_DIR . 'components/audio.php';
	include MH_COMPOSER_DIR . 'components/bar-counters.php';
	include MH_COMPOSER_DIR . 'components/circle-counter.php';
	include MH_COMPOSER_DIR . 'components/number-counter.php';
	include MH_COMPOSER_DIR . 'components/countdown-timer.php';
	include MH_COMPOSER_DIR . 'components/testimonial.php';
	include MH_COMPOSER_DIR . 'components/testimonials-slider.php';
	include MH_COMPOSER_DIR . 'components/team-member.php';
	include MH_COMPOSER_DIR . 'components/social-media-follow.php';
	include MH_COMPOSER_DIR . 'components/signup.php';
	include MH_COMPOSER_DIR . 'components/login.php';
	include MH_COMPOSER_DIR . 'components/map.php';
	include MH_COMPOSER_DIR . 'components/contact-form.php';
	include MH_COMPOSER_DIR . 'components/writer.php';
	include MH_COMPOSER_DIR . 'components/pie-chart.php';
	include MH_COMPOSER_DIR . 'components/button.php';
	include MH_COMPOSER_DIR . 'components/comments.php';
	include MH_COMPOSER_DIR . 'components/post-header.php';
	include MH_COMPOSER_DIR . 'components/code.php';
	include MH_COMPOSER_DIR . 'components/fullwidth-slider.php';
	include MH_COMPOSER_DIR . 'components/fullwidth-texton.php';
	include MH_COMPOSER_DIR . 'components/fullwidth-portfolio.php';
	include MH_COMPOSER_DIR . 'components/fullwidth-map.php';
	include MH_COMPOSER_DIR . 'components/fullwidth-post-header.php';
	include MH_COMPOSER_DIR . 'components/fullwidth-code.php';
	include MH_COMPOSER_DIR . 'components/fullwidth-header.php';
	include MH_COMPOSER_DIR . 'components/fullwidth-menu.php';
	include MH_COMPOSER_DIR . 'components/fullwidth-search-bar.php';
	include MH_COMPOSER_DIR . 'components/fullwidth-gallery.php';
	include MH_COMPOSER_DIR . 'components/plugin-components.php';
	
	//To keep components order, we will hook extra components via plugins
	do_action('mh_composer_add_extra_components');
}
endif;

if ( ! function_exists( 'mh_composer_load_app' ) ) :
function mh_composer_load_app() {

	require MH_COMPOSER_DIR . 'functions.php';
	require MH_COMPOSER_DIR . 'plugins/woocommerce.php';
	
	if ( mh_composer_maybe_load_app() ) {	
		$action_hook = is_admin() ? 'wp_loaded' : 'wp';
		// load composer files on front-end and on specific admin pages only.
		require MH_COMPOSER_DIR . 'mh-layouts.php';
		require MH_COMPOSER_DIR . 'core.php';
		
		do_action( 'mh_composer_app_loaded' );
		add_action( $action_hook, 'mh_composer_add_components' );
	}
}
endif;

mh_composer_load_app();