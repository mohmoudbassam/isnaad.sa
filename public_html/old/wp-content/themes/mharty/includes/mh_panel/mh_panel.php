<?php
// Prevent file from being loaded directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/* Admin scripts + ajax jquery code */
if ( ! function_exists( 'mharty_mh_panel_admin_js' ) ) {

	function mharty_mh_panel_admin_js(){
		global $typenow, $post, $wp_version;
	
		// Get WP major version
		$wp_major_version = substr( $wp_version, 0, 3 );
		
		$mh_panel_jsfolder = get_template_directory_uri() . '/includes/mh_panel/js';

		wp_register_script( 'mh_panel_colorpicker', $mh_panel_jsfolder . '/colorpicker.js', array(), mh_get_theme_version() );
		wp_register_script( 'mh_panel_eye', $mh_panel_jsfolder . '/eye.js', array(), mh_get_theme_version() );
		wp_register_script( 'mh_panel_checkbox', $mh_panel_jsfolder . '/checkbox.js', array(), mh_get_theme_version() );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker-alpha', get_template_directory_uri() . '/js/wp-color-picker-alpha.min.js', array( 'jquery', 'wp-color-picker' ), mh_get_theme_version(), true );
		
		if ( version_compare( $wp_major_version, '4.9', '>=' ) ) {
			wp_enqueue_script( 'wp-color-picker-alpha', get_template_directory_uri() . '/js/wp-color-picker-alpha.min.js', array( 'jquery', 'wp-color-picker' ), mh_get_theme_version(), true );
			wp_localize_script( 'wp-color-picker-alpha', 'mh_color_picker_strings', apply_filters( 'mh_color_picker_strings_filter', array(
				'legacy_pick'    => esc_html__( 'Select', 'mharty' ),
				'legacy_current' => esc_html__( 'Current Colour', 'mharty' ),
			) ) );
		} else {
			wp_enqueue_script( 'wp-color-picker-alpha', get_template_directory_uri() . '/js/wp-color-picker-alpha-legacy.min.js', array( 'jquery', 'wp-color-picker' ), mh_get_theme_version(), true );
		}

		wp_enqueue_script( 'mh_panel_script', $mh_panel_jsfolder . '/panel.js', array( 'jquery', 'jquery-ui-tabs', 'jquery-form', 'mh_panel_colorpicker', 'mh_panel_eye', 'mh_panel_checkbox', 'wp-color-picker-alpha' ), mh_get_theme_version() );
		wp_localize_script( 'mh_panel_script', 'mhPanelSettings', array(
			'clearpath'    => get_template_directory_uri() . '/includes/mh_panel/images/empty.png',
			'mh_panel_nonce' => wp_create_nonce( 'mh_panel_nonce' ),
		));
	}

}
/* --------------------------------------------- */

/* Adds additional MH_Panel css */
if ( ! function_exists( 'mharty_mh_panel_css_admin' ) ) {

	function mharty_mh_panel_css_admin() {
		?>

		<?php do_action( 'mharty_mh_panel_css_admin_enqueue' ); ?>

		<!--[if IE 7]>
		<style type="text/css">
			#mh-panel-save, #mh-panel-reset { font-size: 0px; display:block; line-height: 0px; bottom: 18px;}
			.box-desc { width: 414px; }
			.box-desc-content { width: 340px; }
			.box-desc-bottom { height: 26px; }
			#mh-panel-content .mh-panel-box input, #mh-panel-content .mh-panel-box select, .mh-panel-box textarea {  width: 395px; }
			#mh-panel-content .mh-panel-box select { width:434px !important;}
			#mh-panel-content .mh-panel-box .box-content { padding: 8px 17px 15px 16px; }
		</style>
		<![endif]-->
		<!--[if IE 8]>
		<style type="text/css">
			#mh-panel-save, #mh-panel-reset { font-size: 0px; display:block; line-height: 0px; bottom: 18px;}
		</style>
		<![endif]-->
	<?php }

}

if ( ! function_exists( 'mharty_mh_panel_css_admin_style' ) ) {
	function mharty_mh_panel_css_admin_style() {
		wp_add_inline_style( 'mh_panel_style', '.lightboxclose { background: url("' . esc_url( get_template_directory_uri() ) . '/includes/mh_panel/images/description-close.png") no-repeat; width: 19px; height: 20px; }' );
	}
	add_action( 'mharty_mh_panel_css_admin_enqueue', 'mharty_mh_panel_css_admin_style' );
}

if ( ! function_exists( 'mharty_mh_panel_admin_scripts' ) ) {
	function mharty_mh_panel_admin_scripts( $hook ) {
		$ltr = is_rtl() ? "" : "-ltr";
		
		if ( ! wp_style_is( 'mh-app-admin', 'enqueued' ) ) {
			wp_enqueue_style( 'mh-app-admin-mh-panel', get_template_directory_uri() . '/app/admin/css/app.css', array(), mh_get_theme_version() );
		}
		wp_enqueue_style( 'mh_panel_style', get_template_directory_uri() . '/includes/mh_panel/css/panel'. $ltr .'.css', array(), mh_get_theme_version() );
	}
}

if ( ! function_exists( 'mharty_mh_panel_hook_scripts' ) ) {
	function mharty_mh_panel_hook_scripts() {
		add_action( 'admin_enqueue_scripts', 'mharty_mh_panel_admin_scripts' );
	}
}

//add Mharty menu to WP-MENU
function mh_add_mharty_menu() {
	$core_page = add_menu_page( esc_html__( 'Theme Panel', 'mharty' ), esc_html__( 'Theme Panel', 'mharty' ), 'switch_themes', 'mh_panel', 'mh_build_mh_panel' );
	$customize_url = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );

	if ( isset( $_GET['page'] ) && 'mh_panel' === $_GET['page'] && isset( $_POST['action'] ) ) {
		if ( ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'mh_panel_nonce' ) ) || ( 'reset' === $_POST['action'] && isset( $_POST['_wpnonce_reset'] ) && wp_verify_nonce( $_POST['_wpnonce_reset'], 'mh-nojs-reset_mh_panel' ) ) ) {
			mh_panel_save_data( 'js_disabled' ); //saves data when javascript is disabled
		}
	}
	add_submenu_page( 'mh_panel', esc_html__( 'Theme Panel', 'mharty' ), esc_html__( 'Theme Panel', 'mharty' ), 'switch_themes', 'mh_panel', 'mh_build_mh_panel' );
	add_submenu_page( 'mh_panel', esc_html__( 'Theme Customizer', 'mharty' ), esc_html__( 'Theme Customizer', 'mharty' ), 'switch_themes', esc_url( $customize_url ) );
	$mh_theme_icons = add_submenu_page( null, esc_html__( 'Mharty Theme Icons', 'mharty' ), esc_html__( 'Mharty Theme Icons', 'mharty' ), 'switch_themes', 'mh_theme_icons', 'mh_theme_icons_page'  );
	
	do_action('mh_add_to_mharty_menu');
	add_action( "load-{$core_page}", 'mharty_mh_panel_hook_scripts' );
	add_action( "admin_print_scripts-{$core_page}", 'mharty_mh_panel_admin_js' );
	add_action( "admin_head-{$core_page}", 'mharty_mh_panel_css_admin');
	add_action( "load-{$mh_theme_icons}", 'mharty_mh_theme_icons_hook_scripts' );
}
add_action('admin_menu', 'mh_add_mharty_menu');

function mh_admin_scripts_styles( $hook ) {
	//load css file for mharty menu icon & admin area style
	$ltr = is_rtl() ? "" : "-ltr";
	wp_enqueue_style( 'mh-admin-style', get_template_directory_uri() . '/includes/mh_panel/css/admin'. $ltr .'.css', array() );
}
add_action( 'admin_enqueue_scripts', 'mh_admin_scripts_styles' );

// Displays MH_Panel
if ( ! function_exists( 'mh_build_mh_panel' ) ) {

	function mh_build_mh_panel() {
		global $options, $mh_disabled_jquery;

		// load theme settings array
		mh_load_panel_options();

		if ( isset($_GET['saved']) ) {
			if ( $_GET['saved'] ) echo '<div id="message" class="updated fade"><p><strong>' . esc_html__( 'Mharty settings saved.', 'mharty' ) . '</strong></p></div>';
		}
		if ( isset($_GET['reset']) ) {
			if ( $_GET['reset'] ) echo '<div id="message" class="updated fade"><p><strong>' . esc_html__( 'Mharty settings reset.', 'mharty' ) . '</strong></p></div>';
		}
	?>

		<div id="wrapper">
		  <div id="panel-wrap">


			<div id="mh-panel-top">
				<button class="save-button" id="mh-panel-save-top"><?php esc_html_e( 'Save Changes', 'mharty' ); ?></button>
			</div>

			<form method="post" id="main_options_form" enctype="multipart/form-data">
				<div id="mh-panel-wrapper">
					<div id="mh-panel" class="onload">
						<div id="mh-panel-content-wrap">
							<div id="mh-panel-content">
								<div id="mh-panel-header">
									<h1 id="mh-panel-title"><?php esc_html_e( 'Theme Panel', 'mharty' ); ?></h1>

									<?php
										global $mh_panelMainTabs;
										$mh_panelMainTabs = apply_filters( 'mh_panel_page_maintabs', $mh_panelMainTabs ); ?>
										<?php do_action('mh_them_panel_header'); ?>
								</div>
								<ul id="mh-panel-mainmenu">
									<?php if ( in_array( 'general', $mh_panelMainTabs ) ) { ?>
										<li id="mh-nav-general"><a href="#wrap-general"><?php esc_html_e( 'General Settings', 'mharty' ); ?></a></li>
									<?php } ?>
									<?php if ( in_array( 'layout', $mh_panelMainTabs ) ) { ?>
										<li id="mh-nav-layout"><a href="#wrap-layout"><?php esc_html_e( 'Layouts', 'mharty' ); ?></a></li>
									<?php } ?>
                                    <?php if ( in_array( 'social', $mh_panelMainTabs ) ) { ?>
										<li id="mh-nav-social"><a href="#wrap-social"><?php esc_html_e( 'Social', 'mharty' ); ?></a></li>
									<?php } ?>
                                    <?php if ( in_array( 'navigation', $mh_panelMainTabs ) ) { ?>
										<li id="mh-nav-navigation"><a href="#wrap-navigation"><?php esc_html_e( 'Navigation', 'mharty' ); ?></a></li>
									<?php } ?>
									<?php if ( in_array( 'ad', $mh_panelMainTabs ) ) { ?>
										<li id="mh-nav-advertisements"><a href="#wrap-advertisements"><?php esc_html_e( 'Ads', 'mharty' ); ?></a></li>
									<?php } ?>
									<?php if ( in_array( 'seo', $mh_panelMainTabs ) ) { ?>
										<li id="mh-nav-seo"><a href="#wrap-seo"><?php esc_html_e( 'SEO', 'mharty' ); ?></a></li>
									<?php } ?>
									<?php if ( in_array( 'advanced', $mh_panelMainTabs ) ) { ?>
										<li id="mh-nav-advanced"><a href="#wrap-advanced"><?php esc_html_e( 'Advanced', 'mharty' ); ?></a></li>
									<?php } ?>
                                    
									<?php do_action( 'mh_panel_render_maintabs', $mh_panelMainTabs ); ?>
								</ul><!-- end mh-panel mainmenu -->
                                <div class="mh-panel-mainmenu-placeholder"></div>

								<?php
								foreach ($options as $value) {
									if ( ! empty( $value[ 'depends_on' ] ) ) {
										// function defined in 'depends on' key returns false, if a setting shouldn't be displayed
										if ( ! call_user_func( $value[ 'depends_on' ] ) ) {
											continue;
										}
									}

									if ( in_array( $value['type'], array( 'text', 'textlimit', 'textarea', 'select', 'checkboxes', 'different_checkboxes', 'callback_function', 'mh_color_scheme' ) ) ) { ?>
											<div class="mh-panel-box">
												<div class="box-title">
													<h3 class="box-description"><?php echo esc_html( $value['name'] ); ?></h3>
													<div class="box-descr">
														<p><?php
														echo wp_kses( $value['desc'],
															array(
																'a' => array(
																	'href'   => array(),
																	'title'  => array(),
																	'target' => array(),
																),
															)
														);
														?></p>
													</div> <!-- end box-desc-content div -->
												</div> <!-- end div box-title -->

												<div class="box-content">

													<?php if ( 'text' == $value['type'] ) { ?>

														<?php
															$mh_input_value = '';
															$mh_input_value = ( '' != mh_get_option( $value['id'] ) ) ? mh_get_option( $value['id'] ) : $value['std'];
															$mh_input_value = stripslashes( $mh_input_value );
														?>

														<input name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>" type="<?php echo esc_attr( $value['type'] ); ?>" value="<?php echo esc_attr( $mh_input_value ); ?>" />

													<?php } elseif ( 'textlimit' == $value['type'] ) { ?>

														<?php
															$mh_input_value = '';
															$mh_input_value = ( '' != mh_get_option( $value['id'] ) ) ? mh_get_option( $value['id'] ) : $value['std'];
															$mh_input_value = stripslashes( $mh_input_value );
														?>

														<input name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>" type="text" maxlength="<?php echo esc_attr( $value['max'] ); ?>" size="<?php echo esc_attr( $value['max'] ); ?>" value="<?php echo esc_attr( $mh_input_value ); ?>" />

													<?php } elseif ( 'textarea' == $value['type'] ) { ?>

														<?php
															$mh_textarea_value = '';
															$mh_textarea_value = ( '' != mh_get_option( $value['id'] ) ) ? mh_get_option( $value['id'] ) : $value['std'];
															$mh_textarea_value = stripslashes( $mh_textarea_value );
														?>

														<textarea name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_textarea( $mh_textarea_value ); ?></textarea>

													<?php } elseif ( 'select' == $value['type'] ) { ?>

														<select name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>">
															<?php foreach ( $value['options'] as $option_key => $option ) { ?>
																<?php
																	$mh_select_active = '';
																	$mh_use_option_values = ( isset( $value['mh_array_for'] ) && in_array( $value['mh_array_for'], array( 'pages', 'categories' ) ) ) ||
																	( isset( $value['mh_save_values'] ) && $value['mh_save_values'] ) ? true : false;

																	$mh_option_db_value = mh_get_option( $value['id'] );

																	if ( ( $mh_use_option_values && ( $mh_option_db_value == $option_key ) ) || ( stripslashes( $mh_option_db_value ) == trim( stripslashes( $option ) ) ) || ( ! $mh_option_db_value && isset( $value['std'] ) && stripslashes( $option ) == stripslashes( $value['std'] ) ) )
																		$mh_select_active = ' selected="selected"';
																?>
																<option<?php if ( $mh_use_option_values ) echo ' value="' . esc_attr( $option_key ) . '"'; ?> <?php echo $mh_select_active; ?>><?php echo esc_html( trim( $option ) ); ?></option>
															<?php } ?>
														</select>

													<?php } elseif ( 'checkboxes' == $value['type'] ) { ?>

														<?php
														if ( empty( $value['options'] ) ) {
															esc_html_e( "You don't have pages", 'mharty' );
														} else {
															$i = 1;
															$className = 'inputs';
															if ( isset( $value['excludeDefault'] ) && $value['excludeDefault'] == 'true' ) $className .= ' different';

															foreach ( $value['options'] as $option ) {
																$checked = "";
																$class_name_last = 0 == $i % 3 ? ' last' : '';

																if ( mh_get_option( $value['id'] ) ) {
																	if ( in_array( $option, mh_get_option( $value['id'] ) ) ) {
																		$checked = "checked=\"checked\"";
																	}
																}

																$mh_checkboxes_label = $value['id'] . '-' . $option;
																if ( 'custom' == $value['usefor'] ) {
																	$mh_helper = (array) $value['helper'];
																	$mh_checkboxes_value = $mh_helper[$option];
																} else {
																	if ( 'taxonomy_terms' == $value['usefor'] && isset( $value['taxonomy_name'] ) ) {
																		$mh_checkboxes_term = get_term_by( 'id', $option, $value['taxonomy_name'] );
																		$mh_checkboxes_value = sanitize_text_field( $mh_checkboxes_term->name );
																	} else {
																		$mh_checkboxes_value = ( 'pages' == $value['usefor'] ) ? get_pagename( $option ) : get_categname( $option );
																	}
																}
																?>

																<p class="<?php echo esc_attr( $className . $class_name_last ); ?>">
																	<input type="checkbox" class="usual-checkbox" name="<?php echo esc_attr( $value['id'] ); ?>[]" id="<?php echo esc_attr( $mh_checkboxes_label ); ?>" value="<?php echo esc_attr( $option ); ?>" <?php echo esc_html( $checked ); ?> />
																	<label for="<?php echo esc_attr( $mh_checkboxes_label ); ?>"><?php echo esc_html( $mh_checkboxes_value ); ?></label>
																</p>

																<?php $i++;
															}
														}
														?>
														<br class="clearfix"/>

													<?php } elseif ( 'different_checkboxes' == $value['type'] ) { ?>

														<?php
														foreach ( $value['options'] as $option ) {
															$checked = '';
															if ( mh_get_option( $value['id'] ) !== false ) {
																if ( in_array( $option, mh_get_option( $value['id'] ) ) ) $checked = "checked=\"checked\"";
															} elseif ( isset( $value['std'] ) ) {
																if ( in_array( $option, $value['std'] ) ) {
																	$checked = "checked=\"checked\"";
																}
															} ?>

															<p class="postinfo <?php echo esc_attr( 'postinfo-' . $option ); ?>">
																<input type="checkbox" class="usual-checkbox" name="<?php echo esc_attr( $value['id'] ); ?>[]" id="<?php echo esc_attr( $value['id'] . '-' . $option ); ?>" value="<?php echo esc_attr( $option ); ?>" <?php echo esc_html( $checked ); ?> />
															</p>
														<?php } ?>
														<br class="clearfix"/>

													<?php } elseif ( 'callback_function' == $value['type'] ) {

														call_user_func( $value['function_name'] ); ?>
                                                        
													<?php } elseif ( 'mh_color_scheme' == $value['type'] ) {
															$items_amount = isset( $value['items_amount'] ) ? $value['items_amount'] : 1;
															$mh_input_value = '' !== str_replace( '|', '', mh_get_option( $value['id'] ) ) ? mh_get_option( $value['id'] ) : $value['std'];
														?>
															<div class="mhc_colorscheme_overview" dir="ltr">
														<?php
															for ( $colorscheme_index = 1; $colorscheme_index <= $items_amount; $colorscheme_index++ ) { ?>
																<span class="colorscheme-item colorscheme-item-<?php echo esc_attr( $colorscheme_index ); ?>" data-index="<?php echo esc_attr( $colorscheme_index ); ?>"></span>
														<?php } ?>

															</div>

														<?php for ( $colorpicker_index = 1; $colorpicker_index <= $items_amount; $colorpicker_index++ ) { ?>
																<div class="colorscheme-colorpicker" data-index="<?php echo esc_attr( $colorpicker_index ); ?>">
																	<input data-index="<?php echo esc_attr( $colorpicker_index ); ?>" type="text" class="input-colorscheme-colorpicker" data-alpha="true" />
																</div>
														<?php } ?>

														<input name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>" class="mh_color_scheme_main_input" type="hidden" value="<?php echo esc_attr( $mh_input_value ); ?>" />

													<?php } ?>

												</div> <!-- end box-content div -->
											</div> <!-- end mh-panel-box div -->

									<?php } elseif ( 'checkbox' == $value['type'] || 'checkbox2' == $value['type'] ) { ?>
										<?php
											$mh_box_class = 'checkbox' == $value['type'] ? 'mh-panel-box-small-1' : 'mh-panel-box-small-2';
										?>
										<div class="<?php echo esc_attr( 'mh-panel-box ' . $mh_box_class ); ?>">
											<div class="box-title"><h3 class="box-description"><?php echo esc_html( $value['name'] ); ?></h3>
												<div class="box-descr">
													<p><?php
													echo wp_kses( $value['desc'],  array(
														'a' => array(
															'href'   => array(),
															'title'  => array(),
															'target' => array(),
														),
													) );
													?></p>
												</div> <!-- end box-desc-content div -->
											</div> <!-- end div box-title -->
											<div class="box-content">
												<?php
													$checked = '';
												if ( '' != mh_get_option( $value['id'] ) ) {
													if ( 'on' == mh_get_option( $value['id'] ) ) {
														$checked = 'checked="checked"';
													} else {
														$checked = '';
													}
												} else if ( 'on' == $value['std'] ) {
													$checked = 'checked="checked"';
												}
												?>
												<input type="checkbox" class="checkbox switch_button" name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] );?>" <?php echo $checked; ?> />

											</div> <!-- end box-content div -->
										</div> <!-- end mh-panel-box-small div -->
                                        
                                   
                                   <?php } elseif ( 'iconpreview' == $value['type'] ) { ?>
											<div class="box-content">
												<div class="iconpreview">
													<div class="mh-panel-section-title">
														<h2><?php echo esc_html( $value['desc'] ); ?></h2>
													</div>
											  		<ul class="mhc-icon <?php echo esc_attr( $value['name'] ); ?>">
														<?php  
														$font_icons = call_user_func( $value['function_name'] );
														echo $font_icons; 
														?>
													</ul>
												</div>
											</div>                 
									<?php } elseif ( 'header' == $value['type'] ) { ?>
                                                <div class="mh-panel-section-title">
                                                	<h2><?php echo esc_html( $value['title'] ); ?></h2>
                                               	</div>
									<?php } elseif ( 'contenttab-wrapstart' == $value['type'] || 'subcontent-start' == $value['type'] ) { ?>
										<?php $mh_contenttab_class = 'contenttab-wrapstart' == $value['type'] ? 'content-div' : 'tab-content'; ?>
                                        
                                        <div id="<?php echo esc_attr( $value['name'] ); ?>" class="<?php echo esc_attr( $mh_contenttab_class ); ?>">

									<?php } elseif ( 'contenttab-wrapend' == $value['type'] || 'subcontent-end' == $value['type'] ) { ?>

										</div> <!-- end <?php echo esc_html( $value['name'] ); ?> div -->

									<?php } elseif ( 'subnavtab-start' == $value['type'] ) { ?>

										<ul class="idTabs">

									<?php } elseif ( 'subnavtab-end' == $value['type'] ) { ?>

										</ul>

									<?php } elseif ( 'subnav-tab' == $value['type'] ) { ?>

										<li><a href="#<?php echo esc_attr( $value['name'] ); ?>"><span class="pngfix"><?php echo esc_html( $value['desc'] ); ?></span></a></li>

									<?php } elseif ($value['type'] == "clearfix") { ?>

										<div class="clearfix"></div>

									<?php } ?>

								<?php } //end foreach ($options as $value) ?>

							</div> <!-- end mh-panel-content div -->
						</div> <!-- end mh-panel-content-wrap div -->
					</div> <!-- end mh-panel div -->
				</div> <!-- end mh-panel-wrapper div -->

				<div id="mh-panel-bottom">
					<?php wp_nonce_field( 'mh_panel_nonce' ); ?>
					<button class="save-button" name="save" id="mh-panel-save"><?php esc_html_e( 'Save Changes', 'mharty' ); ?></button>

					<input type="hidden" name="action" value="save_mh_panel" />
				</div><!-- end mh-panel-bottom div -->

			</form>

			<div class="reset-popup-overlay">
				<div class="defaults-hover">
					<div class="reset-popup-header"><?php esc_html_e( 'Reset Theme Panel Options', 'mharty' ); ?><span class="no"></span></div>
					<?php _e( mh_wp_kses( 'This will return all of the settings throughout the options page to their default values. <strong>Are you sure you want to do this?</strong>' ), 'mharty' ); ?>
					<div class="clearfix"></div>
                    <div class="mhc_prompt_buttons">
                        <form method="post">
                            <?php wp_nonce_field( 'mh-nojs-reset_mh_panel', '_wpnonce_reset' ); ?>
                            <input name="reset" type="submit" value="<?php esc_attr_e( 'Yes', 'mharty' ); ?>" id="mh-panel-reset" />
                            <input type="hidden" name="action" value="reset" />
                        </form>
                        <span class="no"><?php esc_html_e( 'No', 'mharty' ); ?></span>
                    </div>
				</div>
			</div>

			</div> <!-- end panel-wrap div -->
		</div> <!-- end wrapper div -->

		<div id="mh-panel-ajax-saving">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/includes/mh_panel/images/ajax-loader.gif' ); ?>" alt="loading" id="loading" />
		</div>

		<script type="text/template" id="mh-panel-yes-no-button-template">
		<div class="mhc_switch_button_wrapper">
			<div class="mhc_switch_button">
				<span class="mhc_value_text mhc_on_value"><?php esc_html_e( 'Enabled', 'mharty' ); ?></span>
				<span class="mhc_button_slider"></span>
				<span class="mhc_value_text mhc_off_value"><?php esc_html_e( 'Disabled', 'mharty' ); ?></span>
			</div>
		</div>
		</script>

		<style type="text/css">
			#mh-panel p.postinfo-avatar .mark:after {
				content: '<?php esc_html_e( "Avatar", 'mharty' ); ?>';
			}
			#mh-panel p.postinfo-author .mark:after {
				content: '<?php esc_html_e( "Author", 'mharty' ); ?>';
			}

			#mh-panel p.postinfo-date .mark:after {
				content: '<?php esc_html_e( "Date", 'mharty' ); ?>';
			}

			#mh-panel p.postinfo-categories .mark:after {
				content: '<?php esc_html_e( "Categories", 'mharty' ); ?>';
			}

			#mh-panel p.postinfo-comments .mark:after {
				content: '<?php esc_html_e( "Comments", 'mharty' ); ?>';
			}
		</style>

	<?php
	}

}
/* --------------------------------------------- */

add_action( 'wp_ajax_save_mh_panel', 'mharty_mh_panel_save_callback' );

function mharty_mh_panel_save_callback() {
	check_ajax_referer( 'mh_panel_nonce' );
	mh_panel_save_data( 'ajax' );

	die();
}

if ( ! function_exists( 'mh_panel_save_data' ) ) {

	function mh_panel_save_data( $source ){
		global $options;

		if ( ! current_user_can( 'switch_themes' ) ) {
			die('-1');
		}

		// load theme settings array
		mh_load_panel_options();

		if ( isset($_POST['action']) ) {
			do_action( 'mharty_mh_panel_changing_options' );

			$mh_panel = isset( $_GET['page'] ) ? $_GET['page'] : 'mh_panel';
			$redirect_url = esc_url_raw( add_query_arg( 'page', $mh_panel, admin_url( 'themes.php' ) ) );

			if ( 'save_mh_panel' == $_POST['action'] ) {
				if ( 'ajax' != $source ) check_admin_referer( 'mh_panel_nonce' );

				foreach ( $options as $value ) {
					if ( isset( $value['id'] ) ) {
						if ( isset( $_POST[ $value['id'] ] ) ) {
							if ( in_array( $value['type'], array( 'text', 'textlimit' ) ) ) {

								if ( isset( $value['validation_type'] ) ) {
									// saves the value as integer
									if ( 'number' == $value['validation_type'] )
										mh_update_option( $value['id'], intval( stripslashes( $_POST[$value['id']] ) ) );

									// makes sure the option is a url
									if ( 'url' == $value['validation_type'] )
										mh_update_option( $value['id'], esc_url_raw( stripslashes( $_POST[$value['id']] ) ) );

									// option is a date format
									if ( 'date_format' == $value['validation_type'] )
										mh_update_option( $value['id'], sanitize_option( 'date_format', $_POST[$value['id']] ) );
									
									// option is a time format
									if ( 'time_format' == $value['validation_type'] )
										mh_update_option( $value['id'], sanitize_option( 'time_format', $_POST[$value['id']] )  );

									/*
									 * html is not allowed
									 * wp_strip_all_tags can't be used here, because it returns trimmed text, some options need spaces ( e.g 'character to separate BlogName and Post title' option )
									 */
									if ( 'nohtml' == $value['validation_type'] ) {
										mh_update_option( $value['id'], stripslashes( wp_filter_nohtml_kses( $_POST[$value['id']] ) ) );
									}
								} else {
									// use html allowed for posts if the validation type isn't provided
									mh_update_option( $value['id'], wp_kses_post( stripslashes( $_POST[$value['id']] ) ) );
								}

							} elseif ( 'select' == $value['type'] ) {

								// select boxes that list pages / categories should save page/category ID ( as integer )
								if ( isset( $value['mh_array_for'] ) && in_array( $value['mh_array_for'], array( 'pages', 'categories' ) ) ) {
									mh_update_option( $value['id'], intval( stripslashes( $_POST[$value['id']] ) ) );
								} else { // html is not allowed in select boxes
									mh_update_option( $value['id'], sanitize_text_field( stripslashes( $_POST[$value['id']] ) ) );
								}

							} elseif ( in_array( $value['type'], array( 'checkbox', 'checkbox2' ) ) ) {

								// saves 'on' value to the database, if the option is enabled
								mh_update_option( $value['id'], 'on' );

							} elseif ( in_array( $value['type'], array( 'mh_color_scheme' ) ) ) {

								// the color value
								mh_update_option( $value['id'], sanitize_text_field( stripslashes( $_POST[$value['id']] ) ) );

							} elseif ( 'textarea' == $value['type'] ) {

								if ( isset( $value['validation_type'] ) ) {
									// html is not allowed
									if ( 'nohtml' == $value['validation_type'] ) {
										if ( $value['id'] === ( 'mharty_custom_css' ) ) {
											// don't strip slashes from custom css, it should be possible to use \ for icon fonts
											mh_update_option( $value['id'], wp_strip_all_tags( $_POST[$value['id']] ) );
										} else {
											mh_update_option( $value['id'], wp_strip_all_tags( stripslashes( $_POST[$value['id']] ) ) );
										}
									}
								} else {
									if ( current_user_can( 'unfiltered_html' ) ) {
										mh_update_option( $value['id'], stripslashes( $_POST[$value['id']] ) );
									} else {
										mh_update_option( $value['id'], stripslashes( wp_filter_post_kses( addslashes( $_POST[$value['id']] ) ) ) ); // wp_filter_post_kses() expects slashed
									}
								}

							} elseif ( 'checkboxes' == $value['type'] ) {

								if ( 'sanitize_text_field' == $value['value_sanitize_function'] ) {
									// strings
									mh_update_option( $value['id'], array_map( 'sanitize_text_field', stripslashes_deep( $_POST[ $value['id'] ] ) ) );
								} else {
									// saves categories / pages IDs,
									mh_update_option( $value['id'], array_map( 'intval', stripslashes_deep( $_POST[ $value['id'] ] ) ) );
								}
							
							

							} elseif ( 'different_checkboxes' == $value['type'] ) {

								// saves 'author/date/categories/comments' options
								mh_update_option( $value['id'], array_map( 'wp_strip_all_tags', stripslashes_deep( $_POST[$value['id']] ) ) );

							}
						} else {
							if ( in_array( $value['type'], array( 'checkbox', 'checkbox2' ) ) ) {
								mh_update_option( $value['id'], 'false' );
							} else if ( 'different_checkboxes' == $value['type'] ) {
								mh_update_option( $value['id'], array() );
							} else {
								mh_delete_option( $value['id'] );
							}
						}
					}
				}

				$redirect_url = add_query_arg( 'saved', 'true', $redirect_url );

				if ( 'js_disabled' == $source ) {
					header( "Location: " . $redirect_url );
				}
				
				die('1');

			}
		}
	}

}