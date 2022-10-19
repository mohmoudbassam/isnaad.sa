<?php
// Prevent file from being loaded directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

function mh_shop_setup_theme() {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	add_action( 'woocommerce_before_main_content', 'mh_mharty_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_after_main_content', 'mh_mharty_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	add_filter( 'woocommerce_output_related_products_args', 'mh_mharty_woocommerce_output_related_products_args' );
	
	//disable first image in cart page
	add_filter( 'mh_grab_image_option', 'disable_mh_grab_image_option', 1 );
	
	//show add to cart button to products grid - only if MH Shop is active + option is enabled in theme panel
	if ( class_exists( 'MHShop', false ) ) {
		if ('on' === mh_get_option( 'mharty_show_add_to_cart', 'off' )){
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
		}
	}
}
add_action( 'after_setup_theme', 'mh_shop_setup_theme' );

//disable first image in cart page
function disable_mh_grab_image_option( $settings ) {
	return ( is_cart() || is_account_page() ) ? false : $settings;
}

//if ( class_exists( 'MHShop', false ) ) {
if ( ! function_exists( 'mh_show_cart_total_icon' ) ) {
	function mh_show_cart_total_icon() {
		global $woocommerce;

		printf('<a href="%1$s" class="mh-cart-info"><span class="mh-cart-count">%2$s</span><span class="mh-cart-icon mh-icon-after"></span></a>',
		esc_url( wc_get_cart_url()),
		intval( $woocommerce->cart->get_cart_contents_count())
		);
	}
}
if ( ! function_exists( 'mh_show_cart_total' ) ) {
	function mh_show_cart_total() {
		if ( 'on' === mh_get_option( 'mharty_show_header_cart', 'on') && class_exists( 'MHShop', false ) ) {
			mh_show_cart_total_icon();
			// Check for MH-Shop 3.0.0 and display the mini cart
			if ( version_compare( MH_SHOP_VER, "3.0.0" ) >= 0 ) {
				// Check for WooCommerce 2.0 and display the cart widget
				echo '<div class="mh-cart-container">';
				if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
					the_widget( 'WC_Widget_Cart' );
				} else {
					the_widget( 'WooCommerce_Widget_Cart', 'title= ' );
				}
				echo '</div>';
			}
		}
	}
}
add_action('mh_header_mini_cart','mh_show_cart_total');

if( $woocommerce && version_compare( $woocommerce->version, "3.0", ">=" ) ) {
	add_filter('woocommerce_add_to_cart_fragments', 'mh_add_to_cart_fragment');
} else {
	add_filter('add_to_cart_fragments', 'mh_add_to_cart_fragment');
}

// update the cart with ajax
function mh_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	mh_show_cart_total_icon();
	$fragments['a.mh-cart-info'] = ob_get_clean();
	return $fragments;
}

function mh_modify_shop_page_columns_num( $columns_num ) {
	if ( class_exists( 'woocommerce', false ) && is_shop() ) {
		$columns_num = 'mh_full_width_page' !== mh_get_option( 'mharty_shop_page_sidebar', 'mh_left_sidebar' )
			? 3
			: 4;
	}

	return $columns_num;
}
add_filter( 'loop_shop_columns', 'mh_modify_shop_page_columns_num' );

global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' )
	add_action( 'init', 'mh_mharty_woocommerce_image_dimensions', 1 );

/**
 * Default values for WooCommerce images changed in version 1.3
 * Checks if WooCommerce image dimensions have been updated already.
 */
function mh_mharty_check_woocommerce_images() {
	if ( 'checked' === mh_get_option( 'mharty_1_3_images' ) ) return;

	mh_mharty_woocommerce_image_dimensions();
	mh_update_option( 'mharty_1_3_images', 'checked' );
}
add_action( 'admin_init', 'mh_mharty_check_woocommerce_images' );

function mh_mharty_woocommerce_image_dimensions() {
		$catalog = array(
		'width' 	=> '400',
		'height'	=> '400',
		'crop'		=> 1,
	);

	$single = array(
		'width' 	=> '510',
		'height'	=> '9999',
		'crop'		=> 0,
	);

	$thumbnail = array(
		'width' 	=> '157',
		'height'	=> '157',
		'crop'		=> 1,
	);
	update_option( 'shop_catalog_image_size', $catalog );
	update_option( 'shop_single_image_size', $single );
	update_option( 'shop_thumbnail_image_size', $thumbnail );
}


function mh_review_gravatar_size( $size ) {
	return '80';
}
add_filter( 'woocommerce_review_gravatar_size', 'mh_review_gravatar_size' );

function mh_mharty_output_content_wrapper() {
	echo '
		<div id="main-content">
			<div class="container">
				<div id="content-area" class="clearfix">
					<div id="left-area">';
}

function mh_mharty_output_content_wrapper_end() {
	echo '</div> <!-- #left-area -->';
	if (
		( is_product() && 'mh_full_width_page' !== get_post_meta( get_the_ID(), '_mhc_page_layout', true ) )
		||
		( ( is_shop() || is_product_category() || is_product_tag() ) && 'mh_full_width_page' !== mh_get_option( 'mharty_shop_page_sidebar', 'mh_left_sidebar' ) )
	) {
		woocommerce_get_sidebar();
	}

	echo '</div> <!-- #content-area -->
		</div> <!-- .container -->
	</div> <!-- #main-content -->';
}

// Determines how many related products should be displayed on single product page
function mh_mharty_woocommerce_output_related_products_args( $args ) {
	$related_posts = 4; // 4 is default number
	if ( is_singular( 'product' ) ) {
			$page_layout = get_post_meta( get_the_ID(), '_mhc_page_layout', true );

			if ( 'mh_full_width_page' !== $page_layout ) {
				$related_posts = 3; // set to 3 if page has a sidebar
			}
		}

	$args['columns'] = $args['posts_per_page'] = $related_posts;

	return $args;
}