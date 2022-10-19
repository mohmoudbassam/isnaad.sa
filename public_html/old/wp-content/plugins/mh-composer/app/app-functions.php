<?php
if ( ! function_exists( 'mh_composer_maybe_load_app' ) ) :
function mh_composer_maybe_load_app() {
	global $pagenow;

	$is_admin = is_admin();
	$action_hook = $is_admin ? 'wp_loaded' : 'wp';
	$required_admin_pages = array( 'edit.php', 'post.php', 'post-new.php', 'admin.php', 'customize.php', 'edit-tags.php', 'admin-ajax.php', 'export.php' ); // list of admin pages where we need to load composer files
	$specific_filter_pages = array( 'edit.php', 'admin.php', 'edit-tags.php' ); // list of admin pages where we need more specific filtering
	$is_edit_vault_page = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'mhc_layout' === $_GET['post_type'];
	$is_roles_manager_page = 'admin.php' === $pagenow && isset( $_GET['page'] ) && apply_filters('mh_mharty_roles_manager_page', 'mh_mharty_roles_manager') === $_GET['page'];
	$is_import_page = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import']; // Page Composer files should be loaded on import page as well to register the mhc_layout post type properly
	$is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];
	

	if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_vault_page || $is_roles_manager_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
		return true;
	} else {
		return false;
	}

}
endif;


function mh_composer_register_layouts(){
	$labels = array(
		'name'               => esc_html_x( 'Layouts', 'Layout type general name', 'mh-composer' ),
		'singular_name'      => esc_html_x( 'Layout', 'Layout type singular name', 'mh-composer' ),
		'add_new'            => esc_html_x( 'Add New', 'Layout item', 'mh-composer' ),
		'add_new_item'       => esc_html__( 'Add New Layout', 'mh-composer' ),
		'edit_item'          => esc_html__( 'Edit Layout', 'mh-composer' ),
		'new_item'           => esc_html__( 'New Layout', 'mh-composer' ),
		'all_items'          => esc_html__( 'All Layouts', 'mh-composer' ),
		'view_item'          => esc_html__( 'View Layout', 'mh-composer' ),
		'search_items'       => esc_html__( 'Search Layouts', 'mh-composer' ),
		'not_found'          => esc_html__( 'Nothing found', 'mh-composer' ),
		'not_found_in_trash' => esc_html__( 'Nothing found in Pin', 'mh-composer' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => false,
		'can_export'         => true,
		'query_var'          => false,
		'has_archive'        => false,
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'revisions' ),
	);
	
	// Cannot use is_mhc_preview() because it's too early
	if ( isset( $_GET['mhc_preview'] ) && ( isset( $_GET['mhc_preview_nonce'] ) && wp_verify_nonce( $_GET['mhc_preview_nonce'], 'mhc_preview_nonce' ) ) ) {
		$args['publicly_queryable'] = true;
		//echo '<span style="display:none;">&nbsp;</span>';
	}

	if ( ! defined( 'MH_COMPOSER_LAYOUT_POST_TYPE' ) ) {
		define( 'MH_COMPOSER_LAYOUT_POST_TYPE', 'mhc_layout' );
	}

	register_post_type( MH_COMPOSER_LAYOUT_POST_TYPE, apply_filters( 'mhc_layout_args', $args ) );

	$labels = array(
		'name'              => esc_html__( 'Scope', 'mh-composer' )
	);

	register_taxonomy( 'scope', array( 'mhc_layout' ), array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_admin_column' => false,
		'query_var'         => true,
		'show_in_nav_menus' => false,
	) );

	$labels = array(
		'name'              => esc_html__( 'Layout Type', 'mh-composer' )
	);

	register_taxonomy( 'layout_type', array( 'mhc_layout' ), array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_nav_menus' => false,
	) );

	$labels = array(
		'name'              => esc_html__( 'Component Width', 'mh-composer' )
	);

	register_taxonomy( 'module_width', array( 'mhc_layout' ), array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_admin_column' => false,
		'query_var'         => true,
		'show_in_nav_menus' => false,
	) );

	$labels = array(
		'name'              => esc_html__( 'Category', 'mh-composer' )
	);

	register_taxonomy( 'layout_category', array( 'mhc_layout' ), array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_nav_menus' => false,
	) );
}

if ( mh_composer_maybe_load_app() ) {
	mh_composer_register_layouts();
}

function mhc_video_get_oembed_thumbnail() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) {
		die( -1 );
	}
	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}
	$video_url = esc_url( $_POST['mh_video_url'] );
	if ( false !== wp_oembed_get( $video_url ) ) {
		// Get image thumbnail
		add_filter( 'oembed_dataparse', 'mhc_video_oembed_data_parse', 10, 3 );
		// Save thumbnail
		$image_src = wp_oembed_get( $video_url );
		// Set back to normal
		remove_filter( 'oembed_dataparse', 'mhc_video_oembed_data_parse', 10, 3 );
		if ( '' === $image_src ) {
			die( -1 );
		}
		echo esc_url( $image_src );
	} else {
		die( -1 );
	}
	die();
}
add_action( 'wp_ajax_mhc_video_get_oembed_thumbnail', 'mhc_video_get_oembed_thumbnail' );

if ( ! function_exists( 'mhc_video_oembed_data_parse' ) ) :
function mhc_video_oembed_data_parse( $return, $data, $url ) {
	if ( isset( $data->thumbnail_url ) ) {
		return esc_url( str_replace( array('https://', 'http://'), '//', $data->thumbnail_url ), array('http') );
	} else {
		return false;
	}
}
endif;

function mhc_add_widget_area(){
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die(-1);
	if ( ! current_user_can( 'manage_options' ) ) {
		die( -1 );
	}

	$mhc_widgets = get_theme_mod( 'mhc_widgets' );

	$number = $mhc_widgets ? intval( $mhc_widgets['number'] ) + 1 : 1;
	
 	$mh_widget_area_name = sanitize_text_field( $_POST['mh_widget_area_name'] );
	$mhc_widgets['areas']['mhc_widget_area_' . $number] = $mh_widget_area_name;
	$mhc_widgets['number'] = $number;

	set_theme_mod( 'mhc_widgets', $mhc_widgets );

	printf( mh_wp_kses( __( '<strong>%1$s</strong> widget area has been created. You can create more areas, once you finish update the page to see all the areas.', 'mh-composer' ) ),
		esc_html( $mh_widget_area_name )
	);

	die();
}
add_action( 'wp_ajax_mhc_add_widget_area', 'mhc_add_widget_area' );

function mhc_remove_widget_area(){
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die(-1);
	
	if ( ! current_user_can( 'manage_options' ) ) {
		die(-1);
	}

	$mhc_widgets = get_theme_mod( 'mhc_widgets' );
	
	$mh_widget_area_name = sanitize_text_field( $_POST['mh_widget_area_name'] );
	unset( $mhc_widgets['areas'][$_POST['mh_widget_area_name']] );

	set_theme_mod( 'mhc_widgets', $mhc_widgets );
	
	die( esc_html( $mh_widget_area_name ) );
}
add_action( 'wp_ajax_mhc_remove_widget_area', 'mhc_remove_widget_area' );

function mhc_current_user_can_lock() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die( -1 );
	
	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

	$permission = mhc_permitted( 'lock_module' );
	$permission = json_encode( $permission );

	die( $permission );
}
add_action( 'wp_ajax_mhc_current_user_can_lock', 'mhc_current_user_can_lock' );


function mh_composer_get_composer_post_types() {
	return apply_filters( 'mh_composer_post_types', array(
		'page',
		'post',
		'project',
		'mhc_layout',
	) );
}

function mhc_permitted( $capabilities, $role = '' ) {
	$saved_capabilities = mhc_get_role_settings();
	$role = '' === $role ? mhc_get_current_user_role() : $role;
	
	foreach ( (array) $capabilities as $capability ) {
		if ( ! empty( $saved_capabilities[ $role ][ $capability ] ) && 'off' === $saved_capabilities[ $role ][ $capability ] ) {
			return false;
		}
	}

	return true;
}

/**
 * Gets the array of role settings
 * @return string
 */
function mhc_get_role_settings() {
	global $mhc_role_settings;

	// if we don't have saved global variable, then get the value from WPDB
	$mhc_role_settings = isset( $mhc_role_settings ) ? $mhc_role_settings : get_option( 'mhc_role_settings', array() );

	return $mhc_role_settings;
}

/**
 * Determines the current user role
 * @return string
 */
function mhc_get_current_user_role() {
	$current_user = wp_get_current_user();
	$user_roles = $current_user->roles;

	$role = ! empty( $user_roles ) ? $user_roles[0] : '';

	return $role;
}

function mhc_show_all_layouts_built_for_post_type( $post_type ) {
	$similar_post_types = array(
		'post',
		'page',
		'project',
	);

	if ( in_array( $post_type, $similar_post_types ) ) {
		return $similar_post_types;
	}

	return $post_type;
}
add_filter( 'mhc_show_all_layouts_built_for_post_type', 'mhc_show_all_layouts_built_for_post_type' );

function mhc_show_all_layouts() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die( -1 );
	
	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

	printf( '
		<label for="mhc_load_layout_replace">
			<input name="mhc_load_layout_replace" type="checkbox" id="mhc_load_layout_replace" %2$s/>
			%1$s
		</label>',
		esc_html__( 'Replace the existing content with loaded layout', 'mh-composer' ),
		checked( get_theme_mod( 'mhc_replace_content', 'on' ), 'on', false )
	);

	$post_type = ! empty( $_POST['mh_layouts_built_for_post_type'] ) ? sanitize_text_field( $_POST['mh_layouts_built_for_post_type'] ) : 'post';
	$layouts_type = ! empty( $_POST['mh_load_layouts_type'] ) ? sanitize_text_field( $_POST['mh_load_layouts_type'] ) : 'preset';

	$preset_operator = 'preset' === $layouts_type ? 'EXISTS' : 'NOT EXISTS';
	
	$post_type = apply_filters( 'mhc_show_all_layouts_built_for_post_type', $post_type, $layouts_type );
	
	$query_args = array(
		'meta_query'      => array(
			'relation' => 'AND',
			array(
				'key'     => '_mhc_preset_layout',
				'value'   => 'on',
				'compare' => $preset_operator,
			),
			array(
				'key'     => '_mhc_built_for_post_type',
				'value'   => $post_type,
				'compare' => 'IN',
			),
		),
		'tax_query' => array(
			array(
				'taxonomy' => 'layout_type',
				'field'    => 'slug',
				'terms'    => array( 'section', 'row', 'module', 'fullwidth_section', 'specialty_section', 'fullwidth_module' ),
				'operator' => 'NOT IN',
			),
		),
		'post_type'       => MH_COMPOSER_LAYOUT_POST_TYPE,
		'posts_per_page'  => '-1',
		'suppress_filters' => 'preset' === $layouts_type,
	);
	
	$query = new WP_Query( $query_args );
	   
	if ( $query->have_posts() ) :

		echo '<ul class="mhc-all-modules mhc-load-layouts">';

		while ( $query->have_posts() ) : $query->the_post();

			printf( '<li class="mhc_text" data-layout_id="%2$s">%1$s<span class="mhc_layout_buttons"><a href="#" class="button mhc_layout_button_load">%3$s</a>%4$s</span></li>',
				esc_html( get_the_title() ),
				esc_attr( get_the_ID() ),
				esc_html__( 'Apply', 'mh-composer' ),
				'preset' !== $layouts_type ?
					sprintf( '<a href="#" class="button mhc_layout_button_delete">%1$s</a>',
						esc_html__( 'Delete', 'mh-composer' )
					)
					: ''
			);

		endwhile;

		echo '</ul>';
	endif;

	wp_reset_postdata();

	die();
}
add_action( 'wp_ajax_mhc_show_all_layouts', 'mhc_show_all_layouts' );

function mhc_get_saved_templates() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die( -1 );
	
	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}
	
	$templates_data = array();

	$layout_type = ! empty( $_POST['mh_layout_type'] ) ? sanitize_text_field( $_POST['mh_layout_type'] ) : 'layout';
	$module_width = ! empty( $_POST['mh_module_width'] ) && 'module' === $layout_type ? sanitize_text_field( $_POST['mh_module_width'] ) : '';
	$additional_condition = '' !== $module_width ?
		array(
				'taxonomy' => 'module_width',
				'field'    => 'slug',
				'terms'    =>  $module_width,
			) : '';
	$is_shared = ! empty( $_POST['mh_is_shared'] ) ? sanitize_text_field( $_POST['mh_is_shared'] ) : 'false';
	$shared_operator = 'shared' === $is_shared ? 'IN' : 'NOT IN';

	$meta_query = array();
	$specialty_query = ! empty( $_POST['mh_specialty_columns'] ) && 'row' === $layout_type ? sanitize_text_field( $_POST['mh_specialty_columns'] ) : '0';

	if ( '0' !== $specialty_query ) {
		$columns_val = '3' === $specialty_query ? array( '4_4', '1_2,1_2', '1_3,1_3,1_3' ) : array( '4_4', '1_2,1_2' );
		$meta_query[] = array(
			'key'     => '_mhc_row_layout',
			'value'   => $columns_val,
			'compare' => 'IN',
		);
	}
	
	$post_type = ! empty( $_POST['mh_post_type'] ) ? sanitize_text_field( $_POST['mh_post_type'] ) : 'post';
	$post_type = apply_filters( 'mhc_show_all_layouts_built_for_post_type', $post_type, $layout_type );
	$meta_query[] = array(
		'key'     => '_mhc_built_for_post_type',
		'value'   => $post_type,
		'compare' => 'IN',
	);
	
	$query = new WP_Query( array(
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'layout_type',
				'field'    => 'slug',
				'terms'    =>  $layout_type,
			),
			array(
				'taxonomy' => 'scope',
				'field'    => 'slug',
				'terms'    => array( 'shared' ),
				'operator' => $shared_operator,
			),
			$additional_condition,
		),
		'post_type'       => MH_COMPOSER_LAYOUT_POST_TYPE,
		'posts_per_page'  => '-1',
		'meta_query'      => $meta_query,
	) );

	wp_reset_postdata();

	if ( ! empty ( $query->posts ) ) {
		foreach( $query->posts as $single_post ) {

			if ( 'module' === $layout_type ) {
				$module_type = get_post_meta( $single_post->ID, '_mhc_module_type', true );
			} else {
				$module_type = '';
			}

			// add only permitted components for this user
			if ( '' === $module_type || mhc_permitted( $module_type ) ) {
				$categories = wp_get_post_terms( $single_post->ID, 'layout_category' );
				$categories_processed = array();

				if ( ! empty( $categories ) ) {
					foreach( $categories as $category_data ) {
						$categories_processed[] = esc_html( $category_data->slug );
					}
				}

				$templates_data[] = array(
					'ID'          => $single_post->ID,
					'title'       => esc_html( $single_post->post_title ),
					'shortcode'   => $single_post->post_content,
					'is_shared'   => $is_shared,
					'layout_type' => $layout_type,
					'module_type' => $module_type,
					'categories'  => $categories_processed,
				);
			}
		}
	}
	if ( empty( $templates_data ) ) {
		//@todo check this: message appears even when there is saved elements unless one of each type of elements is saved, section, row, component, shared
		$templates_data = array( 'error' => esc_html__( 'You have not saved any items to your vault yet. All saved items will appear here for easy access.', 'mh-composer' ) );
	}

	$json_templates = json_encode( $templates_data );

	die( $json_templates );
}
add_action( 'wp_ajax_mhc_get_saved_templates', 'mhc_get_saved_templates' );

function mhc_add_template_meta() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die( -1 );
	
	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}
	
	$post_id = ! empty( $_POST['mh_post_id'] ) ? sanitize_text_field( $_POST['mh_post_id'] ) : '';
	$value = ! empty( $_POST['mh_meta_value'] ) ? sanitize_text_field( $_POST['mh_meta_value'] ) : '';
	$custom_field = ! empty( $_POST['mh_custom_field'] ) ? sanitize_text_field( $_POST['mh_custom_field'] ) : '';

	if ( '' !== $post_id ){
		update_post_meta( $post_id, $custom_field, $value );
	}
}
add_action( 'wp_ajax_mhc_add_template_meta', 'mhc_add_template_meta' );

if ( ! function_exists( 'mhc_add_new_layout' ) ) {
	function mhc_add_new_layout() {
		if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die( -1 );
	
		if ( ! current_user_can( 'edit_posts' ) ) {
			die( -1 );
		}

		$fields_data = isset( $_POST['mh_layout_options'] ) ? $_POST['mh_layout_options'] : '';

		if ( '' === $fields_data ) {
			die();
		}

		$fields_data_json = str_replace( '\\', '',  $fields_data );
		$fields_data_array = json_decode( $fields_data_json, true );
		$processed_data_array = array();

		// prepare array with fields data in convenient format
		if ( ! empty( $fields_data_array ) ) {
			foreach ( $fields_data_array as $index => $field_data ) {
				$processed_data_array[ $field_data['field_id'] ] = $field_data['field_val'];
			}
		}

		$processed_data_array = apply_filters( 'mhc_new_layout_data_from_form', $processed_data_array, $fields_data_array );

		if ( empty( $processed_data_array ) ) {
			die();
		}

		$args = array(
			'layout_type'          => ! empty( $processed_data_array['new_template_type'] ) ? sanitize_text_field( $processed_data_array['new_template_type'] ) : 'layout',
			'layout_selected_cats' => ! empty( $processed_data_array['selected_cats'] ) ? sanitize_text_field( $processed_data_array['selected_cats'] ) : '',
			'built_for_post_type'  => ! empty( $processed_data_array['mh_composer_layout_built_for_post_type'] ) ? sanitize_text_field( $processed_data_array['mh_composer_layout_built_for_post_type'] ) : 'page',
			'layout_new_cat'       => ! empty( $processed_data_array['mhc_new_cat_name'] ) ? sanitize_text_field( $processed_data_array['mhc_new_cat_name'] ) : '',
			'columns_layout'       => ! empty( $processed_data_array['mh_columns_layout'] ) ? sanitize_text_field( $processed_data_array['mh_columns_layout'] ) : '0',
			'module_type'          => ! empty( $processed_data_array['mh_module_type'] ) ? sanitize_text_field( $processed_data_array['mh_module_type'] ) : 'mhc_unknown',
			'layout_scope'         => ! empty( $processed_data_array['mhc_template_shared'] ) ? sanitize_text_field( $processed_data_array['mhc_template_shared'] ) : 'not_shared',
			'module_width'         => 'regular',
			'layout_content'       => ! empty( $processed_data_array['template_shortcode'] ) ? $processed_data_array['template_shortcode'] : '',
			'layout_name'          => ! empty( $processed_data_array['mhc_new_template_name'] ) ? sanitize_text_field( $processed_data_array['mhc_new_template_name'] ) : '',
		);

		// construct the initial shortcode for new layout
		switch ( $args['layout_type'] ) {
			case 'section' :
				$args['layout_content'] = '[mhc_section template_type="section"][mhc_row][/mhc_row][/mhc_section]';
				break;
			case 'row' :
				$args['layout_content'] = '[mhc_row template_type="row"][/mhc_row]';
				break;
			case 'module' :
				$args['layout_content'] = sprintf( '[mhc_module_placeholder selected_tabs="%1$s"]', ! empty( $processed_data_array['selected_tabs'] ) ? $processed_data_array['selected_tabs'] : 'all' );
				break;
			case 'fullwidth_module' :
				$args['layout_content'] = sprintf( '[mhc_fullwidth_module_placeholder selected_tabs="%1$s"]', ! empty( $processed_data_array['selected_tabs'] ) ? $processed_data_array['selected_tabs'] : 'all' );
				$args['module_width'] = 'fullwidth';
				$args['layout_type'] = 'module';
				break;
			case 'fullwidth_section' :
				$args['layout_content'] = '[mhc_section template_type="section" fullwidth="on"][/mhc_section]';
				$args['layout_type'] = 'section';
				break;
			case 'specialty_section' :
				$args['layout_content'] = '[mhc_section template_type="section" specialty="on" skip_module="true" specialty_placeholder="true"][/mhc_section]';
				$args['layout_type'] = 'section';
				break;
		}

		$new_layout_meta = mhc_submit_layout( apply_filters( 'mhc_new_layout_args', $args ) );
		die( $new_layout_meta );
	}
}
add_action( 'wp_ajax_mhc_add_new_layout', 'mhc_add_new_layout' );

if ( ! function_exists( 'mhc_submit_layout' ) ) {
	function mhc_submit_layout( $args ) {
		if ( empty( $args ) ) {
			return;
		}

		$layout_cats_processed = array();

		if ( '' !== $args['layout_selected_cats'] ) {
			$layout_cats_array = explode( ',', $args['layout_selected_cats'] );
			$layout_cats_processed = array_map( 'intval', $layout_cats_array );
		}

		$meta = array();

		if ( 'row' === $args['layout_type'] && '0' !== $args['columns_layout'] ) {
			$meta = array_merge( $meta, array( '_mhc_row_layout' => $args['columns_layout'] ) );
		}

		if ( 'module' === $args['layout_type'] ) {
			$meta = array_merge( $meta, array( '_mhc_module_type' => $args['module_type'] ) );
		}

		//mh_layouts_built_for_post_type
		$meta = array_merge( $meta, array( '_mhc_built_for_post_type' => $args['built_for_post_type'] ) );

		$tax_input = array(
			'scope'           => $args['layout_scope'],
			'layout_type'     => $args['layout_type'],
			'module_width'    => $args['module_width'],
			'layout_category' => $layout_cats_processed,
		);

		$new_layout_id = mhc_create_layout( $args['layout_name'], $args['layout_content'], $meta, $tax_input, $args['layout_new_cat'] );
		$new_post_data['post_id'] = $new_layout_id;

		$new_post_data['edit_link'] = htmlspecialchars_decode( get_edit_post_link( $new_layout_id ) );
		$json_post_data = json_encode( $new_post_data );

		return $json_post_data;
	}
}

if ( ! function_exists( 'mhc_create_layout' ) ) :
function mhc_create_layout( $name, $content, $meta = array(), $tax_input = array(), $new_category = '' ) {
	$layout = array(
		'post_title'   => sanitize_text_field( $name ),
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => MH_COMPOSER_LAYOUT_POST_TYPE,
	);

	$layout_id = wp_insert_post( $layout );

	if ( !empty( $meta ) ) {
		foreach ( $meta as $meta_key => $meta_value ) {
			add_post_meta( $layout_id, $meta_key, sanitize_text_field( $meta_value ) );
		}
	}
	if ( '' !== $new_category ) {
		$new_term_id = wp_insert_term( $new_category, 'layout_category' );
		$tax_input['layout_category'][] = (int) $new_term_id['term_id'];
	}

	if ( ! empty( $tax_input ) ) {
		foreach( $tax_input as $taxonomy => $terms ) {
			wp_set_post_terms( $layout_id, $terms, $taxonomy );
		}
	}

	return $layout_id;
}
endif;

function mhc_save_layout() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die( -1 );
	
	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

	if ( empty( $_POST['mh_layout_name'] ) ) {
		die();
	}

	$args = array(
		'layout_type'          => isset( $_POST['mh_layout_type'] ) ? sanitize_text_field( $_POST['mh_layout_type'] ) : 'layout',
		'layout_selected_cats' => isset( $_POST['mh_layout_cats'] ) ? sanitize_text_field( $_POST['mh_layout_cats'] ) : '',
		'built_for_post_type'  => isset( $_POST['mh_post_type'] ) ? sanitize_text_field( $_POST['mh_post_type'] ) : 'page',
		'layout_new_cat'       => isset( $_POST['mh_layout_new_cat'] ) ? sanitize_text_field( $_POST['mh_layout_new_cat'] ) : '',
		'columns_layout'       => isset( $_POST['mh_columns_layout'] ) ? sanitize_text_field( $_POST['mh_columns_layout'] ) : '0',
		'module_type'          => isset( $_POST['mh_module_type'] ) ? sanitize_text_field( $_POST['mh_module_type'] ) : 'mhc_unknown',
		'layout_scope'         => isset( $_POST['mh_layout_scope'] ) ? sanitize_text_field( $_POST['mh_layout_scope'] ) : 'not_shared',
		'module_width'         => isset( $_POST['mh_module_width'] ) ? sanitize_text_field( $_POST['mh_module_width'] ) : 'regular',
		'layout_content'       => isset( $_POST['mh_layout_content'] ) ? $_POST['mh_layout_content'] : '',
		'layout_name'          => isset( $_POST['mh_layout_name'] ) ? sanitize_text_field( $_POST['mh_layout_name'] ) : '',
	);

	$new_layout_meta = mhc_submit_layout( $args );
	die( $new_layout_meta );
}
add_action( 'wp_ajax_mhc_save_layout', 'mhc_save_layout' );

function mhc_get_shared_module() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die( -1 );

	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

	$post_id = isset( $_POST['mh_shared_id'] ) ? $_POST['mh_shared_id'] : '';

	if ( '' !== $post_id ) {
		$query = new WP_Query( array(
			'p'         => (int) $post_id,
			'post_type' => MH_COMPOSER_LAYOUT_POST_TYPE
		) );

		wp_reset_postdata();

		if ( !empty( $query->post ) ) {
			$shared_shortcode['shortcode'] = $query->post->post_content;
		}
	}

	if ( empty( $shared_shortcode ) ) {
		$shared_shortcode['error'] = 'nothing';
	}

	$json_post_data = json_encode( $shared_shortcode );

	die( $json_post_data );
}
add_action( 'wp_ajax_mhc_get_shared_module', 'mhc_get_shared_module' );

function mhc_update_layout() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die( -1 );

	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

	$post_id = isset( $_POST['mh_template_post_id'] ) ? $_POST['mh_template_post_id'] : '';
	$new_content = isset( $_POST['mh_layout_content'] ) ? mh_composer_post_content_capability_check( $_POST['mh_layout_content'] ) : '';

	if ( '' !== $post_id ) {
		$update = array(
			'ID'           => $post_id,
			'post_content' => $new_content,
		);

		wp_update_post( $update );
	}

	die();
}
add_action( 'wp_ajax_mhc_update_layout', 'mhc_update_layout' );

function _mhc_sanitize_code_module_content_regex( $matches ) {
	$sanitized_content = wp_kses_post( htmlspecialchars_decode( $matches[1] ) );
	$sanitized_shortcode = str_replace( $matches[1], $sanitized_content, $matches[0] );
	return $sanitized_shortcode;
}

function mh_composer_post_content_capability_check( $content) {
	if ( ! current_user_can( 'unfiltered_html' ) ) {
		$content = preg_replace_callback('/\[mhc_code .*\](.*)\[\/mhc_code\]/mis', '_mhc_sanitize_code_module_content_regex', $content );
		$content = preg_replace_callback('/\[mhc_fullwidth_code .*\](.*)\[\/mhc_fullwidth_code\]/mis', '_mhc_sanitize_code_module_content_regex', $content );
	}

	return $content;
}
add_filter( 'content_save_pre', 'mh_composer_post_content_capability_check' );

function mhc_load_layout() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) die( -1 );

	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

	$layout_id = (int) $_POST['mh_layout_id'];

	if ( '' === $layout_id ) die( -1 );

	$replace_content = isset( $_POST['mh_replace_content'] ) && 'on' === $_POST['mh_replace_content'] ? 'on' : 'off';

	set_theme_mod( 'mhc_replace_content', $replace_content );

	$layout = get_post( $layout_id );

	if ( $layout )
		echo $layout->post_content;

	die();
}
add_action( 'wp_ajax_mhc_load_layout', 'mhc_load_layout' );

function mhc_delete_layout() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) {
		die( -1 );
	}
	
	if ( ! current_user_can( 'edit_others_posts' ) ) {
		die( -1 );
	}

	$layout_id = (int) $_POST['mh_layout_id'];

	if ( '' === $layout_id ) die( -1 );

	wp_delete_post( $layout_id );

	die();
}
add_action( 'wp_ajax_mhc_delete_layout', 'mhc_delete_layout' );

function mhc_get_app_templates() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) {
		die( -1 );
	}
	
	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

	$post_type = sanitize_text_field( $_POST['mh_post_type'] );
	$start_from = isset( $_POST['mh_templates_start_from'] ) ? sanitize_text_field( $_POST['mh_templates_start_from'] ) : 0;
	$amount = MH_COMPOSER_AJAX_TEMPLATES_AMOUNT;

	// get the portion of templates
	$result = json_encode( MHComposer_Core::output_templates( $post_type, $start_from, $amount ) );

	die( $result );
}
add_action( 'wp_ajax_mhc_get_app_templates', 'mhc_get_app_templates' );

function mhc_submit_subscribe_form() {
	if ( ! wp_verify_nonce( $_POST['mh_script_nonce'], 'mh_script_nonce' ) ) die( json_encode( array( 'error' => esc_html__( 'Configuration error', 'mh-composer' ) ) ) );

	$service = sanitize_text_field( $_POST['mh_service'] );

	$list_id = sanitize_text_field( $_POST['mh_list_id'] );

	$email = sanitize_email( $_POST['mh_email'] );

	$firstname = sanitize_text_field( $_POST['mh_firstname'] );

	if ( '' === $firstname ) die( json_encode( array( 'error' => esc_html__( 'Please enter first name', 'mh-composer' ) ) ) );

	if ( ! is_email( $email ) ) die( json_encode( array( 'error' => esc_html__( 'Incorrect email', 'mh-composer' ) ) ) );

	if ( '' == $list_id ) die( json_encode( array( 'error' => esc_html__( 'Configuration error: List is not defined', 'mh-composer' ) ) ) );

	$success_message = sprintf( '<h2 class="mhc_subscribed">%s</h2>',
		esc_html__( 'You have subscribed - please look out for the confirmation email!', 'mh-composer' )
	);

	switch ( $service ) {
		case 'mailchimp' :
			$lastname = sanitize_text_field( $_POST['mh_lastname'] );
			$email = array( 'email' => $email );

			if ( ! class_exists( 'MailChimp_Mhc', false ) )
				require_once( MH_COMPOSER_DIR . 'subscription/mailchimp/mailchimp.php' );

			$mailchimp_api_key = mh_get_option( 'mharty_mailchimp_api_key' );

			if ( '' === $mailchimp_api_key ) die( json_encode( array( 'error' => esc_html__( 'Configuration error: api key is not defined', 'mh-composer' ) ) ) );

				$mailchimp = new MailChimp_Mhc( $mailchimp_api_key );

				$subscribe_args = array(
					'id'         => $list_id,
					'email'      => $email,
					'merge_vars' => array(
						'FNAME'  => $firstname,
						'LNAME'  => $lastname,
					),
				);

				$retval =  $mailchimp->call('lists/subscribe', $subscribe_args );

				if ( 200 !== wp_remote_retrieve_response_code( $retval ) ) {
					if ( '214' === wp_remote_retrieve_header( $retval, 'x-mailchimp-api-error-code' ) ) {
						$mailchimp_message = json_decode( wp_remote_retrieve_body( $retval ), true );
						$error_message = isset( $mailchimp_message['error'] ) ? $mailchimp_message['error'] : wp_remote_retrieve_body( $retval );
						$result = json_encode( array( 'success' => esc_html( $error_message ) ) );
					} else {
					$result = json_encode( array( 'success' => esc_html( wp_remote_retrieve_response_message( $retval ) ) ) );
					}
				} else {
					$result = json_encode( array( 'success' => $success_message ) );
				}

			die( $result );
			break;
	}

	die();
}
add_action( 'wp_ajax_mhc_submit_subscribe_form', 'mhc_submit_subscribe_form' );
add_action( 'wp_ajax_nopriv_mhc_submit_subscribe_form', 'mhc_submit_subscribe_form' );

/**
 * Saves the Role Settings into WP database
 * @return void
 */
function mhc_save_role_settings() {
	if ( ! wp_verify_nonce( $_POST['mhc_save_roles_nonce'] , 'mhc_roles_nonce' ) ) {
		 die( -1 );
	}
	
	if ( ! current_user_can( 'manage_options' ) ) {
		die( -1 );
	}

	// handle received data and convert json string to array
	$data_json = str_replace( '\\', '' ,  $_POST['mhc_options_all'] );
	$data = json_decode( $data_json, true );
	$processed_options = array();

	// convert settings string for each role into array and save it into mhc_role_settings option
	if ( ! empty( $data ) ) {
		foreach( $data as $role => $settings ) {
			parse_str( $data[ $role ], $processed_options[ $role ] );
		}
	}

	update_option( 'mhc_role_settings', $processed_options );

	die();
}
add_action( 'wp_ajax_mhc_save_role_settings', 'mhc_save_role_settings' );

function mhc_execute_content_shortcodes() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) {
		die( -1 );
	}
	
	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

	$unprocessed_data = str_replace( '\\', '', $_POST['mhc_unprocessed_data'] );

	echo do_shortcode( $unprocessed_data );
	
	die();
}
add_action( 'wp_ajax_mhc_execute_content_shortcodes', 'mhc_execute_content_shortcodes' );

if ( ! function_exists( 'mhc_register_posttypes' ) ) :
function mhc_register_posttypes() {
	$labels = array(
		'name'               => apply_filters( 'mh_project_post_type_title', esc_html__('Projects', 'mh-composer')),
		'singular_name'      => esc_html__( 'Item', 'mh-composer' ),
		'add_new'            => esc_html__( 'Add New', 'mh-composer' ),
		'add_new_item'       => esc_html__( 'Add New Item', 'mh-composer' ),
		'edit_item'          => esc_html__( 'Edit Item', 'mh-composer' ),
		'new_item'           => esc_html__( 'New Item', 'mh-composer' ),
		'all_items'          => esc_html__( 'All Items', 'mh-composer' ),
		'view_item'          => esc_html__( 'View Item', 'mh-composer' ),
		'search_items'       => esc_html__( 'Search Items', 'mh-composer' ),
		'not_found'          => esc_html__( 'Nothing found', 'mh-composer' ),
		'not_found_in_trash' => esc_html__( 'Nothing found in Bin', 'mh-composer' ),
		'parent_item_colon'  => '',
	);
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'menu_icon' 		 => 'dashicons-portfolio',
		'publicly_queryable' => true,
		'show_ui'            => true,
		'can_export'         => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'has_archive'        => true,
		'rewrite'            => apply_filters( 'mh_project_posttype_rewrite_args', array(
			'feeds'      => true,
			'slug'       => apply_filters( 'mh_project_post_type_slug', 'project'),
			'with_front' => false,
		) ),
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
	);

	register_post_type( 'project', apply_filters( 'mh_project_posttype_args', $args ) );

	$labels = array(
		'name'              => apply_filters( 'mh_project_post_type_category_title', esc_html__('Project Categories', 'mh-composer')),
		'singular_name'     => esc_html__( 'Category', 'mh-composer' ),
		'search_items'      => esc_html__( 'Search Categories', 'mh-composer' ),
		'all_items'         => esc_html__( 'All Categories', 'mh-composer' ),
		'parent_item'       => esc_html__( 'Parent Category', 'mh-composer' ),
		'parent_item_colon' => esc_html__( 'Parent Category:', 'mh-composer' ),
		'edit_item'         => esc_html__( 'Edit Category', 'mh-composer' ),
		'update_item'       => esc_html__( 'Update Category', 'mh-composer' ),
		'add_new_item'      => esc_html__( 'Add New Category', 'mh-composer' ),
		'new_item_name'     => esc_html__( 'New Category Name', 'mh-composer' ),
		'menu_name'         => esc_html__( 'Categories', 'mh-composer' ),
	);
	register_taxonomy( 'project_category', array( 'project' ), array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'            => array(
			'slug'       => apply_filters( 'mh_project_category_taxonomy_slug', 'works-category'),
		),
	) );
	
	$labels = array(
		'name'              => apply_filters( 'mh_project_post_type_tag_title', esc_html__('Project Tags', 'mh-composer')),
		'singular_name'     => esc_html__( 'Tag', 'mh-composer' ),
		'search_items'      => esc_html__( 'Search Tags', 'mh-composer' ),
		'all_items'         => esc_html__( 'All Tags', 'mh-composer' ),
		'parent_item'       => esc_html__( 'Parent Tag', 'mh-composer' ),
		'parent_item_colon' => esc_html__( 'Parent Tag:', 'mh-composer' ),
		'edit_item'         => esc_html__( 'Edit Tag', 'mh-composer' ),
		'update_item'       => esc_html__( 'Update Tag', 'mh-composer' ),
		'add_new_item'      => esc_html__( 'Add New Tag', 'mh-composer' ),
		'new_item_name'     => esc_html__( 'New Tag Name', 'mh-composer' ),
		'menu_name'         => esc_html__( 'Tags', 'mh-composer' ),
	);
	register_taxonomy( 'project_tag', array( 'project' ), array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'            => array(
			'slug'       => apply_filters( 'mh_project_tag_taxonomy_slug', 'works-tag'),
		),
	) );
}
endif;

/**
 * Detect the activated cache plugins and return the link to plugin options and return its page link or false
 * @return string or bool
 */
function mhc_detect_cache_plugins() {
	if ( function_exists( 'edd_w3edge_w3tc_activate_license' ) ) {
		return 'admin.php?page=w3tc_pgcache';
	}

	if ( function_exists( 'wpsupercache_activate' ) ) {
		return 'options-general.php?page=wpsupercache';
	}

	if ( class_exists( 'HyperCache' ) ) {
		return 'options-general.php?page=hyper-cache%2Foptions.php';
	}

	if ( class_exists( '\zencache\plugin' ) ) {
		return 'admin.php?page=zencache';
	}

	if ( class_exists( 'WpFastestCache' ) ) {
		return 'admin.php?page=WpFastestCacheOptions';
	}

	if ( '1' === get_option( 'wordfenceActivated' ) ) {
		return 'admin.php?page=WordfenceSitePerf';
	}

	if ( function_exists( 'cachify_autoload' ) ) {
		return 'options-general.php?page=cachify';
	}

	if ( class_exists( 'FlexiCache' ) ) {
		return 'options-general.php?page=flexicache';
	}

	if ( function_exists( 'rocket_init' ) ) {
		return 'options-general.php?page=wprocket';
	}

	if ( function_exists( 'cloudflare_init' ) ) {
		return 'options-general.php?page=cloudflare';
	}

	return false;
}


/**
 * Register MH Composer (impoexpo).
 */
function mhc_register_composer_impoexpo() {
	global $shortname;

	// Don't overwrite global.
	$_shortname = empty( $shortname ) ? 'mharty' : $shortname;

	// Make sure the (impoexpo) is loaded.
	mh_app_load_parts( 'impoexpo' );

	// Register MH Composer Layouts PT (impoexpo).
	mh_app_impoexpo_register( 'mh_composer_layouts', array(
		'name' => esc_html__( 'Composer Layouts', 'mh-composer' ),
		'type'   => 'post_type',
		'target' => MH_COMPOSER_LAYOUT_POST_TYPE,
		'view'   => ( isset( $_GET['post_type'] ) && $_GET['post_type'] === MH_COMPOSER_LAYOUT_POST_TYPE ),
	) );
}
add_action( 'admin_init', 'mhc_register_composer_impoexpo' );
/**
 * Modify the (impoexpo) export WP query.
 */
function mhc_modify_impoexpo_export_wp_query( $query ) {
	// Exclude preset layouts from the export.
	return array_merge( $query, array(
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key'     => '_mhc_preset_layout',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => '_mhc_preset_layout',
				'value'   => 'on',
				'compare' => 'NOT LIKE',
			),
		),
	) );
}
add_filter( 'mh_app_impoexpo_export_wp_query_mh_composer_layouts', 'mhc_modify_impoexpo_export_wp_query' );
/**
 * Check whether current page is composer preview page
 * @return bool
 */
function is_mhc_preview() {
	global $wp_query;
	return ( 'true' === $wp_query->get( 'mhc_preview' ) && isset( $_GET['mhc_preview_nonce'] ) );
}

if ( ! function_exists( 'mh_composer_is_active' ) ) :
function mh_composer_is_active( $page_id ) {
	return ( 'on' === get_post_meta( $page_id, '_mhc_use_composer', true ) );
}
endif;

if ( ! function_exists( 'mhc_get_mailchimp_lists' ) ) :
function mhc_get_mailchimp_lists( $regenerate_mailchimp_list = 'off' ) {
	$lists = array();
	$mailchimp_api_key = mh_get_option( 'mharty_mailchimp_api_key' );
	$regenerate_mailchimp_list = mh_get_option( 'mharty_regenerate_mailchimp_lists', 'false' );

	if ( empty( $mailchimp_api_key ) || false === strpos( $mailchimp_api_key, '-' ) ) {
		return false;
	}
	
	$mhc_mailchimp_lists = get_transient( 'mhc_mailchimp_lists' );

	if ( 'on' === $regenerate_mailchimp_list || false === $mhc_mailchimp_lists ) {
		if ( ! class_exists( 'MailChimp_Mhc', false ) ) {
			require_once( MH_COMPOSER_DIR . 'subscription/mailchimp/mailchimp.php' );
		}

		try {
			$mailchimp = new MailChimp_Mhc( $mailchimp_api_key );
			$retval = $mailchimp->call( 'lists/list', array( 'limit' => 100 ) );
			$retval_body = json_decode( wp_remote_retrieve_body( $retval ), true );
			$retrieved_lists = isset( $retval_body['data'] ) ? $retval_body['data'] : array();

			if ( 200 !== wp_remote_retrieve_response_code( $retval ) || empty( $retval_body['data'] ) || ! is_array( $retval_body['data'] ) ) {
				return $mhc_mailchimp_lists;
			}

			// if there is more than 100 lists in account, then perform additional calls to retrieve all the lists.
			if ( ! empty( $retval_body['total'] ) && 100 < $retval_body['total'] ) {
				// determine how many requests we need to retrieve all the lists
				$total_pages = ceil( $retval_body['total'] / 100 );

				for ( $i = 1; $i <= $total_pages; $i++ ) {
					$retval_additional = $mailchimp->call( 'lists/list', array(
							'limit' => 100,
							'start' => $i,
						)
					);

					if ( ! empty( $retval_additional ) && empty( $retval_additional['errors'] ) ) {
						if ( ! empty( $retval_additional['data'] ) ) {
							$retrieved_lists = array_merge( $retrieved_lists, $retval_additional['data'] );
						}
					}
				}
			}

			if ( ! empty( $retrieved_lists ) ) {
				foreach ( $retrieved_lists as $list ) {
					$lists[$list['id']] = $list['name'];
				}
			}

			set_transient( 'mhc_mailchimp_lists', $lists, 60*60*24 );
		} catch ( Exception $exc ) {
			$lists = $mhc_mailchimp_lists;
		}

		return $lists;
	} else {
		return $mhc_mailchimp_lists;
	}
}
endif;

if ( ! function_exists( 'mhc_register_admin_js' ) ) :
function mhc_register_admin_js() {
	wp_register_script( 'mhc_admin_js', MH_COMPOSER_URI . '/js/admin.js', array(), MH_COMPOSER_VER, true );
}
endif;
add_action( 'admin_enqueue_scripts', 'mhc_register_admin_js' );