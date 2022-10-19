<?php
/**
* The main MHCustomizer class
*/
if ( ! class_exists( 'MHCustomizer', false ) ) :
class MHCustomizer {

	function __construct() {
		$this->options = apply_filters( 'mh_customizer/config', array() );
		$options = $this->options;
		
		include_once( dirname( __FILE__ ) . '/includes/required.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls-init.php' );
		include_once( dirname( __FILE__ ) . '/includes/transport.php' );

		add_action( 'customize_register', array( $this, 'include_files' ), 1 );
		add_action( 'customize_controls_print_styles', array( $this, 'styles' ) );
		add_action( 'customize_controls_print_scripts', array( $this, 'scripts' ) );
		add_action( 'customize_controls_print_styles', array( $this, 'custom_css' ), 999 );
		add_action( 'customize_controls_print_scripts', array( $this, 'custom_js' ), 999 );
	}

	/**
	 * Include the necessary file for controls
	 */
	function include_files() {
		include_once( dirname( __FILE__ ) . '/includes/class-MHCustomizer_Control.php' );
	}

	/**
	 * Enqueue the stylesheets and scripts required.
	 */
	function styles() {

		$options = apply_filters( 'mh_customizer/config', array() );

		$mh_customizer_url = isset( $options['url_path'] ) ? $options['url_path'] : plugin_dir_url( __FILE__ );
		$theme_version = mh_get_theme_version();

		wp_enqueue_style( 'mh_customizer-customizer-css', $mh_customizer_url . 'css/customizer.min.css', NULL, $theme_version );
		wp_enqueue_style( 'mh_customizer-customizer-ui',  $mh_customizer_url . 'css/jquery-ui-1.10.0.custom.min.css', NULL, $theme_version );
	}


	/**
	 * Add custom CSS rules to the head, applying our custom styles
	 */
	function custom_css() {

		// Get the active admin theme
		global $_wp_admin_css_colors;

		// Get the user's admin colors
		$color = get_user_option( 'admin_color' );
		// If no theme is active set it to 'fresh'
		if ( empty( $color ) || ! isset( $_wp_admin_css_colors[$color] ) ) {
			$color = 'fresh';
		}

		$color = (array) $_wp_admin_css_colors[$color];

		$admin_theme = get_user_meta( get_current_user_id(), 'admin_color', true ); //Find out which theme the user has selected.

		$options = apply_filters( 'mh_customizer/config', array() );

		$color_font    = false;
		$color_active  = isset( $options['color_active'] )  ? $options['color_active']  : $color['colors'][3];
		$color_light   = isset( $options['color_light'] )   ? $options['color_light']   : $color['colors'][2];
		$color_select  = isset( $options['color_select'] )  ? $options['color_select']  : $color['colors'][3];
		$color_accent  = isset( $options['color_accent'] )  ? $options['color_accent']  : $color['icon_colors']['focus'];
		$color_back    = isset( $options['color_back'] )    ? $options['color_back']    : false;

		if ( $color_back ) {
			$color_font = '#222';
		}

		?>

		<style>
			.wp-core-ui .button.tooltip {
				background: <?php echo $color_select; ?>;
				color: #fff;
			}

			.image.ui-buttonset label.ui-button.ui-state-active {
				background: <?php echo $color_select; ?>;
			}

			<?php if ( $color_back ) : ?>

				.wp-full-overlay-sidebar,
				#customize-info .accordion-section-title,
				#customize-info .accordion-section-title:hover,
				#customize-theme-controls .accordion-section-title,
				#customize-theme-controls .control-section .accordion-section-title {
					background: <?php echo $color_back; ?>;
					<?php if ( $color_font ) : ?>color: <?php echo $color_font; ?>;<?php endif; ?>
				}
				#customize-theme-controls .control-section .accordion-section-title:focus,
				#customize-theme-controls .control-section .accordion-section-title:hover,
				#customize-theme-controls .control-section.open .accordion-section-title,
				#customize-theme-controls .control-section:hover .accordion-section-title {
					<?php if ( $color_font ) : ?>color: <?php echo $color_font; ?>;<?php endif; ?>
				}

			<?php endif; ?>

			.ui-state-default,
			.ui-widget-content .ui-state-default,
			.ui-widget-header .ui-state-default,
			.ui-state-active.ui-button.ui-widget.ui-state-default {
				background-color: <?php echo $color_active; ?>;
				border: 1px solid rgba(0,0,0,.05);
			}

			.ui-button.ui-widget.ui-state-default {
				background-color: #fcfcfc;
			}

			#customize-theme-controls .accordion-section-title {
				border-bottom: 1px solid rgba(0,0,0,.1);
			}

			#customize-theme-controls .control-section .accordion-section-title:focus,
			#customize-theme-controls .control-section .accordion-section-title:hover,
			#customize-theme-controls .control-section.open .accordion-section-title,
			#customize-theme-controls .control-section:hover .accordion-section-title {
				background: <?php echo $color_active; ?>;
			}
			#customize-theme-controls .control-section.control-panel.current-panel:hover .accordion-section-title{
				background: #fff;
			}

			#customize-theme-controls .control-section.control-panel.current-panel .accordion-section-title:hover{
				background: <?php echo $color_active; ?>;
			}

			.wp-core-ui .button-primary {
				background: <?php echo $color_active; ?>;
			}

			.wp-core-ui .button-primary.focus,
			.wp-core-ui .button-primary.hover,
			.wp-core-ui .button-primary:focus,
			.wp-core-ui .button-primary:hover {
				background: <?php echo $color_select; ?>;
			}

			.wp-core-ui .button-primary-disabled,
			.wp-core-ui .button-primary.disabled,
			.wp-core-ui .button-primary:disabled,
			.wp-core-ui .button-primary[disabled] {
				background: <?php echo $color_light; ?> !important;
				color: <?php echo $color_select; ?> !important;
			}

			<?php if ( isset( $options['logo_image'] ) ) : ?>
				div.mh_customizer-customizer {
					background: url("<?php echo $options['logo_image']; ?>") no-repeat center center;
				}
			<?php endif; ?>
		</style>
		<?php

	}

	/**
	 * If we've specified an image to be used as logo, replace the default theme description with a div that will have our logo as background.
	 */
	function custom_js() {

		$options = apply_filters( 'mh_customizer/config', array() ); ?>

		<?php if ( isset( $options['logo_image'] ) ) : ?>
			<script>
				jQuery(document).ready(function($) {
					"use strict";
					$( 'div#customize-info' ).replaceWith( '<div class="mh_customizer-customizer"></div>' );
				});
			</script>
		<?php endif;

	}
	
	function scripts() {
		
		$options = apply_filters( 'mh_customizer/config', array() );
		
		$mh_customizer_url = isset( $options['url_path'] ) ? $options['url_path'] : plugin_dir_url( __FILE__ );
		$theme_version = mh_get_theme_version();
		
		wp_enqueue_script( 'mh-customizer-controls-js', $mh_customizer_url . 'js/mh_customizer_controls.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'mh-customizer-js', $mh_customizer_url . 'js/mh_customizer.js', array( 'jquery' ), $theme_version);
		wp_localize_script( 'mh-customizer-js', 'mh_customizer_settigs', array(
			'default_color_scheme' => implode( '|', mh_default_color_scheme() )
	));

	}
}

$mh_customizer = new MHCustomizer();

endif;