<?php
add_theme_support( 'post-thumbnails' );

global $mh_theme_image_sizes;

$mh_theme_image_sizes = array(
	'80x80'  	 => 'mhc-post-thumbnail',
	'400x250'   => 'mhc-post-main-image',
	'1080x675'  => 'mhc-post-main-image-fullwidth',
	'400x284'   => 'mhc-portfolio-image',
	'510x382'   => 'mhc-fullwidth-portfolio-image',
	'1080x9999' => 'mhc-portfolio-image-single',
);

$mh_theme_image_sizes = apply_filters( 'mh_theme_image_sizes', $mh_theme_image_sizes );
$crop = apply_filters( 'mh_post_thumbnails_crop', true );

if ( is_array( $mh_theme_image_sizes ) ){
	foreach ( $mh_theme_image_sizes as $image_size_dimensions => $image_size_name ){
		$dimensions = explode( 'x', $image_size_dimensions );

		if ( in_array( $image_size_name, array( 'mhc-portfolio-image-single' ) ) )
			$crop = false;

		add_image_size( $image_size_name, $dimensions[0], $dimensions[1], $crop );

		$crop = apply_filters( 'mh_post_thumbnails_crop', true );
	}
}