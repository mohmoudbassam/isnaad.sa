<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

//[mh_breadcrumbs]
function mh_breadcrumbs_shortcode( $atts ){
	return mh_breadcrumb( array(
		'show_browse' => false,
		'separator' => mh_wp_kses( _x(' / ', 'This is the breadcrumb separator.', 'mharty') ),
		'show_home'  => esc_html__( 'Home', 'mharty' ),
		'echo'       => false,
		'post_taxonomy' => array(
			'post'  => 'category',
        ),
	) );
}
add_shortcode( 'mh_breadcrumbs', 'mh_breadcrumbs_shortcode' );