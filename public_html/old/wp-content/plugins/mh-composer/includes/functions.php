<?php
/**
 * Gets option value from the single theme option, stored as an array in the database
 * if all options stored in one row.
 * Stores the serialized array with theme options into the global variable on the first function run on the page.
 *
 * If options are stored as separate rows in database, it simply uses get_option() function.
 *
 * @param string $option_name Theme option name.
 * @param string $default_value Default value that should be set if the theme option isn't set.
 * @param string $used_for_object "Object" name that should be translated into corresponding "object" if WPML is activated.
 * @return mixed Theme option value or false if not found.
 */
if ( ! function_exists( 'mh_get_option' ) ) :
function mh_get_option( $option_name, $default_value = '', $used_for_object = '', $force_default_value = false ) {
	global $mh_composer_plugin_options;

	$shortname = 'page_composer_plugin';

	$mh_theme_options_name = 'mh_' . $shortname;

	if ( ! isset( $mh_composer_plugin_options ) ) {
		$mh_composer_plugin_options = get_option( $mh_theme_options_name );
	}
	$option_value = isset ( $mh_composer_plugin_options[$option_name] ) ? $mh_composer_plugin_options[$option_name] : false;

	// option value might be equal to false, so check if the option is not set in the database
	if ( ! isset( $mh_composer_plugin_options[ $option_name ] ) && ( '' != $default_value || $force_default_value ) ) {
		$option_value = $default_value;
	}

	if ( '' != $used_for_object && in_array( $used_for_object, array( 'page', 'category' ) ) && is_array( $option_value ) ) {
		$option_value = mh_generate_wpml_ids( $option_value, $used_for_object );
	}

	return $option_value;
}
endif;

if ( ! function_exists( 'mh_update_option' ) ) :
function mh_update_option( $option_name, $new_value ){
	global $mh_composer_plugin_options;

	$shortname = 'page_composer_plugin';

	$mh_theme_options_name = 'mh_' . $shortname;

	if ( ! isset( $mh_composer_plugin_options ) ) $mh_composer_plugin_options = get_option( $mh_theme_options_name );
	$mh_composer_plugin_options[$option_name] = $new_value;

	$option_name = $mh_theme_options_name;
	$new_value = $mh_composer_plugin_options;

	update_option( $option_name, $new_value );
}
endif;

if ( ! function_exists( 'mh_delete_option' ) ) :
function mh_delete_option( $option_name ){
	global $mh_composer_plugin_options;

	$shortname = 'page_composer_plugin';

	$mh_theme_options_name = 'mh_' . $shortname;

	if ( ! isset( $mh_composer_plugin_options ) ) $mh_composer_plugin_options = get_option( $mh_theme_options_name );

	unset( $mh_composer_plugin_options[$option_name] );
	update_option( $mh_theme_options_name, $mh_composer_plugin_options );
}
endif;

/* this function gets thumbnail from Post Thumbnail or Custom field or First post image */
if ( ! function_exists( 'get_thumbnail' ) ) :
function get_thumbnail($width=100, $height=100, $class='', $alttext='', $titletext='', $fullpath=false, $custom_field='', $post='') {
	if ( $post == '' ) global $post;
	global $shortname;

	$thumb_array['thumb'] = '';
	$thumb_array['use_timthumb'] = true;
	if ($fullpath) $thumb_array['fullpath'] = ''; //full image url for lightbox

	$new_method = true;

	if ( has_post_thumbnail( $post->ID ) ) {
		$thumb_array['use_timthumb'] = false;

		$mh_fullpath = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		$thumb_array['fullpath'] = $mh_fullpath[0];
		$thumb_array['thumb'] = $thumb_array['fullpath'];
	}

	if ($thumb_array['thumb'] == '') {
		if ($custom_field == '') $thumb_array['thumb'] = esc_attr( get_post_meta($post->ID, 'Thumbnail', $single = true) );
		else {
			$thumb_array['thumb'] = esc_attr( get_post_meta($post->ID, $custom_field, $single = true) );
			if ($thumb_array['thumb'] == '') $thumb_array['thumb'] = esc_attr( get_post_meta($post->ID, 'Thumbnail', $single = true) );
		}

		#if custom field used for small pre-cropped image, open Thumbnail custom field image in lightbox
		if ($fullpath) {
			$thumb_array['fullpath'] = $thumb_array['thumb'];
			if ($custom_field == '') $thumb_array['fullpath'] = apply_filters('mh_fullpath', mh_path_reltoabs(esc_attr($thumb_array['thumb'])));
			elseif ( $custom_field <> '' && get_post_meta($post->ID, 'Thumbnail', $single = true) ) $thumb_array['fullpath'] = apply_filters( 'mh_fullpath', mh_path_reltoabs(esc_attr(get_post_meta($post->ID, 'Thumbnail', $single = true))) );
		}
	}

	return $thumb_array;
}
endif;

/* this function prints thumbnail from Post Thumbnail or Custom field or First post image */
if ( ! function_exists( 'print_thumbnail' ) ) :
function print_thumbnail($thumbnail = '', $use_timthumb = true, $alttext = '', $width = 100, $height = 100, $class = '', $echoout = true, $forstyle = false, $resize = true, $post='', $mh_post_id = '' ) {
	if ( is_array( $thumbnail ) ){
		extract( $thumbnail );
	}

	if ( $post == '' ) global $post, $mh_theme_image_sizes;

	$output = '';

	$mh_post_id = '' != $mh_post_id ? (int) $mh_post_id : $post->ID;

	if ( has_post_thumbnail( $mh_post_id ) ) {
		$thumb_array['use_timthumb'] = false;

		$image_size_name = $width . 'x' . $height;
		$mh_size = isset( $mh_theme_image_sizes ) && array_key_exists( $image_size_name, $mh_theme_image_sizes ) ? $mh_theme_image_sizes[$image_size_name] : array( $width, $height );

		$mh_attachment_image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $mh_post_id ), $mh_size );
		$thumbnail = $mh_attachment_image_attributes[0];
	}

	if ( false === $forstyle ) {
		$output = '<img src="' . esc_url( $thumbnail ) . '"';

		if ($class <> '') $output .= " class='" . esc_attr( $class ) . "' ";

		$dimensions = apply_filters( 'mh_print_thumbnail_dimensions', " width='" . esc_attr( $width ) . "' height='" .esc_attr( $height ) . "'" );

		$output .= " alt='" . esc_attr( strip_tags( $alttext ) ) . "'{$dimensions} />";

		if ( ! $resize ) $output = $thumbnail;
	} else {
		$output = $thumbnail;
	}

	if ($echoout) echo $output;
	else return $output;
}
endif;

if ( ! function_exists( 'mh_path_reltoabs' ) ) :
function mh_path_reltoabs( $imageurl ){
	if ( strpos(strtolower($imageurl), 'http://') !== false || strpos(strtolower($imageurl), 'https://') !== false ) return $imageurl;

	if ( strpos( strtolower($imageurl), $_SERVER['HTTP_HOST'] ) !== false )
		return $imageurl;
	else {
		$imageurl = esc_url( apply_filters( 'mh_path_relative_image', site_url() . '/' ) . $imageurl );
	}

	return $imageurl;
}
endif;

/*this function allows for the auto-creation of post excerpts*/
if ( ! function_exists( 'truncate_post' ) ) {

	function truncate_post( $amount, $echo = true, $post = '', $strip_shortcodes = false ) {
		global $shortname;

		if ( '' == $post ) global $post;

		$post_excerpt = '';
		$post_excerpt = apply_filters( 'the_excerpt', $post->post_excerpt );

		if ( 'on' == mh_get_option( $shortname . '_use_excerpt' ) && '' != $post_excerpt ) {
			if ( $echo ) echo $post_excerpt;
			else return $post_excerpt;
		} else {
			// get the post content
			$truncate = $post->post_content;

			// remove caption shortcode from the post content
			$truncate = preg_replace( '@\[caption[^\]]*?\].*?\[\/caption]@si', '', $truncate );

			// remove audio shortcode from post content to prevent unwanted audio file on the excerpt
			// due to unparsed audio shortcode
			$truncate = preg_replace( '@\[audio[^\]]*?\].*?\[\/audio]@si', '', $truncate );

			// remove embed shortcode from post content
			$truncate = preg_replace( '@\[embed[^\]]*?\].*?\[\/embed]@si', '', $truncate );
			
			// remove breadcrumbs shortcode from the post content
			$truncate = preg_replace( '@\[mh_breadcrumbs[^\]]*?\].*?\[\/mh_breadcrumbs]@si', '', $truncate );

			if ( $strip_shortcodes ) {
				$truncate = mh_strip_shortcodes( $truncate );
			} else {
				// apply content filters
				$truncate = apply_filters( 'the_content', $truncate );
			}

			// decide if we need to append dots at the end of the string
			if ( strlen( $truncate ) <= $amount ) {
				$echo_out = '';
			} else {
				$echo_out = '...';
				// $amount = $amount - 3;
			}

			// trim text to a certain number of characters, also remove spaces from the end of a string ( space counts as a character )
			$truncate = rtrim( mh_wp_trim_words( $truncate, $amount, '' ) );

			// remove the last word to make sure we display all words correctly
			if ( '' != $echo_out ) {
				$new_words_array = (array) explode( ' ', $truncate );
				array_pop( $new_words_array );

				$truncate = implode( ' ', $new_words_array );

				// append dots to the end of the string
				$truncate .= $echo_out;
			}

			if ( $echo ) echo $truncate;
			else return $truncate;
		};
	}

}
if ( ! function_exists( 'mh_wp_trim_words' ) ){
	function mh_wp_trim_words( $text, $num_words = 55, $more = null ) {
		if ( null === $more )
		$more = esc_html__('&hellip;');
		$original_text = $text;
		$text = wp_strip_all_tags( $text );

		$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
		preg_match_all( '/./u', $text, $words_array );
		$words_array = array_slice( $words_array[0], 0, $num_words + 1 );
		$sep = '';

		if ( count( $words_array ) > $num_words ) {
			array_pop( $words_array );
			$text = implode( $sep, $words_array );
			$text = $text . $more;
		} else {
			$text = implode( $sep, $words_array );
		}

		//return apply_filters( 'wp_trim_words', $text, $num_words, $more, $original_text );
		return $text;
	}
}