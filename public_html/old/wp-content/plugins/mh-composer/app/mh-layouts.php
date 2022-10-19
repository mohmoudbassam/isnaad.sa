<?php
foreach( array( 'edit', 'post', 'post-new' ) as $hook ) {
	add_action( "admin_head-{$hook}.php", 'mh_composer_vault_custom_styles' );
}

//remove "edit" action from the bulk changes on mhc_layout editor screen
function composer_customize_bulk( $actions ) {
	unset( $actions['edit'] );

	return $actions;
}
add_filter( 'bulk_actions-edit-mhc_layout', 'composer_customize_bulk' );

function mhc_get_used_built_for_post_types() {
	global $wpdb;

	$built_for_post_types = $wpdb->get_col(
		"SELECT DISTINCT( meta_value )
		FROM $wpdb->postmeta
		WHERE meta_key = '_mhc_built_for_post_type'
		AND meta_value IS NOT NULL
		AND meta_value != ''
		"
	);

	return $built_for_post_types;
}

function mhc_layout_restrict_manage_posts() {
	global $pagenow;

	if ( ! is_admin() || 'edit.php' !== $pagenow || ! isset( $_GET['post_type'] ) || 'mhc_layout' !== $_GET['post_type'] ) {
		return;
	}

	$used_built_for_post_types = mhc_get_used_built_for_post_types();

	if ( count( $used_built_for_post_types ) <= 1 ) {
		return;
	}

	$built_for_post_type_request = isset( $_GET['built_for'] ) ? sanitize_text_field( $_GET['built_for'] ) : '';

	if ( ! in_array( $built_for_post_type_request, $used_built_for_post_types ) ) {
		$built_for_post_type_request = '';
	}
}
add_action( 'restrict_manage_posts', 'mhc_layout_restrict_manage_posts' );

function mhc_built_for_post_type_display( $post_type ) {
	$standard_post_types = mhc_get_standard_post_types();

	if ( in_array( $post_type, $standard_post_types ) ) {
		return esc_html__( 'Standard', 'mh-composer' );
	}

	return $post_type;
}

add_filter( 'mhc_layout_built_for_post_type_column', 'mhc_built_for_post_type_display' );
add_filter( 'mhc_built_for_post_type_display', 'mhc_built_for_post_type_display' );

function mhc_get_standard_post_types() {
	$standard_post_types = apply_filters( 'mhc_standard_post_types', array(
		'page',
		'post',
		'project',
	) );

	return $standard_post_types;
}

function mh_update_old_layouts_tax() {
	$layouts_updated = get_theme_mod( 'mhc_layouts_updated', 'no' );

	if ( 'yes' !== $layouts_updated ) {
		$query = new WP_Query( array(
			'meta_query'      => array(
				'relation' => 'AND',
				array(
					'key'     => '_mhc_preset_layout',
					'value'   => 'on',
					'compare' => 'NOT EXISTS',
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
		) );

		wp_reset_postdata();

		if ( ! empty ( $query->posts ) ) {
			foreach( $query->posts as $single_post ) {

				$defined_layout_type = wp_get_post_terms( $single_post->ID, 'layout_type' );

				if ( empty( $defined_layout_type ) ) {
					wp_set_post_terms( $single_post->ID, 'layout', 'layout_type' );
				}
			}
		}

		set_theme_mod( 'mhc_layouts_updated', 'yes' );
	}
}
add_action( 'admin_init', 'mh_update_old_layouts_tax' );

// update existing layouts to support _mhc_built_for_post_type
function mh_update_layouts_built_for_post_types() {
	$layouts_updated = get_theme_mod( 'mh_updated_layouts_built_for_post_types', 'no' );
	if ( 'yes' !== $layouts_updated ) {
		$query = new WP_Query( array(
			'meta_query'      => array(
				'relation' => 'AND',
				array(
					'key'     => '_mhc_built_for_post_type',
					'compare' => 'NOT EXISTS',
				),
			),
			'post_type'       => MH_COMPOSER_LAYOUT_POST_TYPE,
			'posts_per_page'  => '-1',
		) );

		wp_reset_postdata();

		if ( ! empty ( $query->posts ) ) {
			foreach( $query->posts as $single_post ) {
				update_post_meta( $single_post->ID, '_mhc_built_for_post_type', 'page' );
			}
		}

		set_theme_mod( 'mh_updated_layouts_built_for_post_types', 'yes' );
	}
}
add_action( 'admin_init', 'mh_update_layouts_built_for_post_types' );

function mh_composer_vault_custom_styles() {
	global $typenow;

	if ( 'mhc_layout' === $typenow) {
		$new_layout_modal = mhc_generate_new_layout_modal();

		$ltr = is_rtl() ? '' : '-ltr';
		wp_enqueue_style( 'vault-style', MH_COMPOSER_URI . '/css/vault'.$ltr.'.css' );
		
		wp_enqueue_script( 'vault-script', MH_COMPOSER_URI . '/js/vault.js', array( 'jquery', 'mhc_admin_js' ) );
		wp_localize_script( 'vault-script', 'mhc_vault_options', array(
				'ajaxurl'          => admin_url( 'admin-ajax.php' ),
				'mh_admin_load_nonce'    => wp_create_nonce( 'mh_admin_load_nonce' ),
				'modal_output'  => $new_layout_modal,
			)
		);
	}
}
// since v4.0 all embedded layouts were moved to be downloaded.
define( 'MH_COMPOSER_PRESET_LAYOUTS_VERSION', 'v4_0' );
function mhc_update_preset_layouts() {
	// don't do anything if layouts have been updated to latest version
	if ( 'on' === get_theme_mod( 'mhc_preset_layouts_updated_' . MH_COMPOSER_PRESET_LAYOUTS_VERSION ) && ( mhc_preset_layouts_exist() ) ) {
		return;
	}
	// delete default layouts
	mhc_delete_preset_layouts();
	//@todo check this
	mhc_delete_preset_layouts('page');

	set_theme_mod( 'mhc_preset_layouts_updated_' . MH_COMPOSER_PRESET_LAYOUTS_VERSION, 'on' );
}
add_action( 'admin_init', 'mhc_update_preset_layouts' );

// check whether at least 1 predefined layout exists in DB and return its ID
if ( ! function_exists( 'mhc_preset_layouts_exist' ) ) :
function mhc_preset_layouts_exist() {
	$args = array(
		'posts_per_page' => 1,
		'post_type'      => MH_COMPOSER_LAYOUT_POST_TYPE,
		'meta_query'      => array(
			'relation' => 'AND',
			array(
				'key'     => '_mhc_preset_layout',
				'value'   => 'on',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => '_mhc_built_for_post_type',
				'value'   => 'page',
				'compare' => 'IN',
			)
		),
	);

	$preset_layout = get_posts( $args );

	if ( ! $preset_layout ) {
		return false;
	}
	
	return $preset_layout[0]->ID;
}
endif;

if ( ! function_exists( 'mhc_delete_preset_layouts' ) ) :
function mhc_delete_preset_layouts( $built_for_post_type = '' ) {
	$args = array(
		'posts_per_page' => -1,
		'post_type'      => MH_COMPOSER_LAYOUT_POST_TYPE,
		'meta_query'      => array(
			'relation' => 'AND',
			array(
				'key'     => '_mhc_preset_layout',
				'value'   => 'on',
				'compare' => 'EXISTS',
			),
		),
	);
	if ( ! empty( $built_for_post_type ) ) {
		$args['meta_query'][] = array(
			'key'     => '_mhc_built_for_post_type',
			'value'   => $built_for_post_type,
			'compare' => 'IN',
		);
	} else {
		$args['meta_query'][] = array(
			'key'     => '_mhc_built_for_post_type',
			'compare' => 'NOT EXISTS',
		);
	}

	$preset_layouts = get_posts( $args );

	if ( $preset_layouts ) {
		foreach ( $preset_layouts as $preset_layout ) {
			if ( isset( $preset_layout->ID ) ) {
				wp_delete_post( $preset_layout->ID, true );
			}
		}
	}
}
endif;