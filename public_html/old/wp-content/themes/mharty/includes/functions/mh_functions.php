<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! function_exists( 'get_custom_header' ) ) {
	// compatibility with versions of WordPress prior to 3.4.
	add_custom_background();
} else {
	add_theme_support( 'custom-background', apply_filters( 'mh_custom_background_args', array() ) );
}

if (function_exists('add_post_type_support')) add_post_type_support( 'page', 'excerpt' );

add_theme_support( 'automatic-feed-links' );

add_filter('widget_text', 'do_shortcode');
add_filter('the_excerpt', 'do_shortcode');

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
 
 if ( ! function_exists( 'mh_options_stored_in_one_row' ) ){
	function mh_options_stored_in_one_row(){
		global $mh_store_options_in_one_row;

		return isset( $mh_store_options_in_one_row ) ? (bool) $mh_store_options_in_one_row : false;
	}
}

if ( ! function_exists( 'mh_get_option' ) ){
	function mh_get_option( $option_name, $default_value = '', $used_for_object = '', $force_default_value = false ){
		global $mh_theme_options, $themename;
		
		if ( mh_options_stored_in_one_row() ){
			$mh_theme_options_name = 'mh_' . $themename;
			
			if ( ! isset( $mh_theme_options ) || isset( $_POST['wp_customize'] ) ) {
				$mh_theme_options = get_option( $mh_theme_options_name );
			}
			$option_value = isset( $mh_theme_options[$option_name] ) ? $mh_theme_options[$option_name] : false;
		} else {
			$option_value = get_option( $option_name );
		}

		// option value might be equal to false, so check if the option is not set in the database
		if ( mh_options_stored_in_one_row() && ! isset( $mh_theme_options[ $option_name ] ) && ( '' != $default_value || $force_default_value ) ) {
			$option_value = $default_value;
		}

		if ( '' != $used_for_object && in_array( $used_for_object, array( 'page', 'category' ) ) && is_array( $option_value ) )
			$option_value = mh_generate_wpml_ids( $option_value, $used_for_object );

		return $option_value;
	}
}

if ( ! function_exists( 'mh_update_option' ) ){
	function mh_update_option( $option_name, $new_value ){
		global $mh_theme_options, $themename;

		if ( mh_options_stored_in_one_row() ){
			$mh_theme_options_name = 'mh_' . $themename;

			if ( ! isset( $mh_theme_options ) ) $mh_theme_options = get_option( $mh_theme_options_name );
			$mh_theme_options[$option_name] = $new_value;

			$option_name = $mh_theme_options_name;
			$new_value = $mh_theme_options;
		}

		update_option( $option_name, $new_value );
	}
}

if ( ! function_exists( 'mh_delete_option' ) ){
	function mh_delete_option( $option_name ){
		global $mh_theme_options, $themename;

		if ( mh_options_stored_in_one_row() ){
			$mh_theme_options_name = 'mh_' . $themename;

			if ( ! isset( $mh_theme_options ) ) $mh_theme_options = get_option( $mh_theme_options_name );

			unset( $mh_theme_options[$option_name] );
			update_option( $mh_theme_options_name, $mh_theme_options );
		} else {
			delete_option( $option_name );
		}
	}
}

/**
 * Get post format with filterable output
 * @todo replace once WordPress provides filter for get_post_format() outpu see: get_post_format()
 * @return mixed string|bool string of post format or false for default
 */
function mh_post_format() {
	return apply_filters( 'mh_post_format', get_post_format(), get_the_ID() );
}

add_filter('body_class','mh_browser_body_class');
function mh_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}


if ( ! function_exists( 'mh_apply_edge_compatibility_meta' ) ) :
function mh_apply_edge_compatibility_meta() {
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
}
endif;
add_action( 'mh_head_meta', 'mh_apply_edge_compatibility_meta' );

if( !function_exists( 'get_cfield' ) ):
	function get_cfield($meta = NULL, $id = NULL) {
		if($meta === NULL) {
			return false;
		}
		if ($id === NULL) {
			$id = get_the_ID();
		}
		return get_post_meta( $id, '_mhartys_'.$meta, true );
	}
endif;

/*this function allows for the auto-creation of post excerpts*/
if ( ! function_exists( 'truncate_post' ) ) {

	function truncate_post( $amount, $echo = true, $post = '', $strip_shortcodes = false ) {

		if ( '' == $post ) global $post;

		$post_excerpt = '';
		$post_excerpt = apply_filters( 'the_excerpt', $post->post_excerpt );

		if ( 'on' == mh_get_option( 'mharty_use_excerpt' ) && '' != $post_excerpt ) {
			if ( $echo ) echo $post_excerpt;
			else return $post_excerpt;
		} else {
			// get the post content
			$truncate = $post->post_content;

			// remove caption shortcode from post content
			$truncate = preg_replace( '@\[caption[^\]]*?\].*?\[\/caption]@si', '', $truncate );

			// remove audio shortcode from post content to prevent unwanted audio file on the excerpt
			// due to unparsed audio shortcode
			$truncate = preg_replace( '@\[audio[^\]]*?\].*?\[\/audio]@si', '', $truncate );

			// remove embed shortcode from post content
			$truncate = preg_replace( '@\[embed[^\]]*?\].*?\[\/embed]@si', '', $truncate );
			
			// remove breadcrumbs shortcode from post content
			$truncate = preg_replace( '@\[mh_breadcrumbs[^\]]*?\].*?\[\/mh_breadcrumbs]@si', '', $truncate );
			
			// Remove script from post content
			$truncate = preg_replace( '@\<script(.*?)>(.*?)</script>@si', '', html_entity_decode( $truncate ) );

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

/*this function truncates titles to create preview excerpts*/
if ( ! function_exists( 'truncate_title' ) ){
	function truncate_title( $amount, $echo = true, $post = '' ) {
		if ( $post == '' ) $truncate = get_the_title();
		else $truncate = $post->post_title;

		if ( strlen( $truncate ) <= $amount ) $echo_out = '';
		else $echo_out = '...';

		//$truncate = wp_trim_words( $truncate, $amount, '' );
		$truncate = mh_wp_trim_words( $truncate, $amount, '' );

		if ( '' != $echo_out ) $truncate .= $echo_out;

		if ( $echo )
			echo $truncate;
		else
			return $truncate;
	}
}




/*this function allows users to use the first image in their post as their thumbnail*/
if ( ! function_exists( 'mh_first_image' ) ){
	function mh_first_image() {
		global $post;
		$img = '';
		
		if ( empty( $post->ID ) ) {
			return $img;
		}
		$unprocessed_content = $post->post_content;
		
		// truncate Post based shortcodes if Divi Builder enabled to avoid infinite loops
		if ( function_exists( 'mh_strip_shortcodes' ) ) {
			$unprocessed_content = mh_strip_shortcodes( $post->post_content, true );
		}
		
		// apply the_content filter to execute all shortcodes and get the correct image from the processed content
		$processed_content = apply_filters( 'the_content', $unprocessed_content );

		$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $processed_content, $matches );
		if ( isset( $matches[1][0] ) ) $img = $matches[1][0];

		return trim( $img );
	}
}


/* this function gets thumbnail from Post Thumbnail or Custom field or First post image */
if ( ! function_exists( 'get_thumbnail' ) ) {
	function get_thumbnail($width=100, $height=100, $class='', $alttext='', $titletext='', $fullpath=false, $custom_field='', $post='') {
		if ( $post == '' ) global $post;

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

			if ('' == $thumb_array['thumb'] && mh_grab_image_option()) {
				$thumb_array['thumb'] = esc_attr( mh_first_image() );
				if ( $fullpath ) $thumb_array['fullpath'] = $thumb_array['thumb'];
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
}

if ( ! function_exists( 'mh_grab_image_option' ) ) :
/**
 * Filterable "Grab the first post image" setting.
 * "Grab the first post image" needs to be filterable so it can be disabled forcefully.
 * It uses et_first_image() which uses apply_filters( 'the_content' ) which could cause
 * a conflict with third party plugin which extensively uses 'the_content' filter (ie. BuddyPress)
 * @return bool
 */
function mh_grab_image_option() {
	global $themename;
	// Force disable "Grab the first post image" in BuddyPress component page
	$is_buddypress_component = function_exists( 'bp_current_component' ) && bp_current_component();

	$setting = 'on' === mh_get_option( $themename . '_grab_image' ) && ! $is_buddypress_component;

	return apply_filters( 'mh_grab_image_option', $setting );
}
endif;

/* this function prints thumbnail from Post Thumbnail or Custom field or First post image */
if ( ! function_exists( 'print_thumbnail' ) ) {
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
		} else {
			$thumbnail_orig = $thumbnail;

			$thumbnail = mh_multisite_thumbnail( $thumbnail );

			$cropPosition = '';

			$allow_new_thumb_method = false;

			$new_method = true;
			$new_method_thumb = '';
			$external_source = false;

			$allow_new_thumb_method = !$external_source && $new_method && $cropPosition == '';

			if ( $allow_new_thumb_method && $thumbnail <> '' ){
				$mh_crop = get_post_meta( $post->ID, 'mh_nocrop', true ) == '' ? true : false;
				$new_method_thumb =  mh_resize_image( mh_path_reltoabs($thumbnail), $width, $height, $mh_crop );
				if ( is_wp_error( $new_method_thumb ) ) $new_method_thumb = '';
			}

			$thumbnail = $new_method_thumb;
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
}

if ( ! function_exists( 'mh_new_thumb_resize' ) ){
	function mh_new_thumb_resize( $thumbnail, $width, $height, $alt='', $forstyle = false ){
		global $themename;

		$new_method = true;
		$new_method_thumb = '';
		$external_source = false;

		$allow_new_thumb_method = !$external_source && $new_method;

		if ( $allow_new_thumb_method && $thumbnail <> '' ){
			$mh_crop = true;
			$new_method_thumb = mh_resize_image( $thumbnail, $width, $height, $mh_crop );
			if ( is_wp_error( $new_method_thumb ) ) $new_method_thumb = '';
		}

		$thumb = esc_attr( $new_method_thumb );

		$output = '<img src="' . esc_url( $thumb ) . '" alt="' . esc_attr( $alt ) . '" width =' . esc_attr( $width ) . ' height=' . esc_attr( $height ) . ' />';

		return ( !$forstyle ) ? $output : $thumb;
	}
}

if ( ! function_exists( 'mh_multisite_thumbnail' ) ){
	function mh_multisite_thumbnail( $thumbnail = '' ) {
		// do nothing if it's not a Multisite installation or current site is the main one
		if ( is_main_site() ) return $thumbnail;

		# get the real image url
		preg_match( '#([_0-9a-zA-Z-]+/)?files/(.+)#', $thumbnail, $matches );
		if ( isset( $matches[2] ) ){
			$file = rtrim( BLOGUPLOADDIR, '/' ) . '/' . str_replace( '..', '', $matches[2] );
			if ( is_file( $file ) ) $thumbnail = str_replace( ABSPATH, trailingslashit( get_site_url( 1 ) ), $file );
			else $thumbnail = '';
		}

		return $thumbnail;
	}
}

if ( ! function_exists( 'mh_is_portrait' ) ){
	function mh_is_portrait($imageurl, $post='', $ignore_cfields = false){
		if ( $post == '' ) global $post;

		if ( get_post_meta($post->ID,'mh_disable_portrait',true) == 1 ) return false;

		if ( !$ignore_cfields ) {
			if ( get_post_meta($post->ID,'mh_imagetype',true) == 'l' ) return false;
			if ( get_post_meta($post->ID,'mh_imagetype',true) == 'p' ) return true;
		}

		$imageurl = mh_path_reltoabs(mh_multisite_thumbnail($imageurl));

		$mh_thumb_size = @getimagesize($imageurl);
		if ( empty($mh_thumb_size) ) {
			$mh_thumb_size = @getimagesize( str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $imageurl ) );
			if ( empty($mh_thumb_size) ) return false;
		}
		$mh_thumb_width = $mh_thumb_size[0];
		$mh_thumb_height = $mh_thumb_size[1];

		$result = ($mh_thumb_width < $mh_thumb_height) ? true : false;

		return $result;
	}
}

if ( ! function_exists( 'mh_path_reltoabs' ) ){
	function mh_path_reltoabs( $imageurl ){
		if ( strpos(strtolower($imageurl), 'http://') !== false || strpos(strtolower($imageurl), 'https://') !== false ) return $imageurl;

		if ( strpos( strtolower($imageurl), $_SERVER['HTTP_HOST'] ) !== false )
			return $imageurl;
		else {
			$imageurl = esc_url( apply_filters( 'mh_path_relative_image', site_url() . '/' ) . $imageurl );
		}

		return $imageurl;
	}
}

if ( ! function_exists( 'in_subcat' ) ){
	function in_subcat($blogcat,$current_cat='') {
		$in_subcategory = false;

		if (cat_is_ancestor_of($blogcat,$current_cat) || $blogcat == $current_cat) $in_subcategory = true;

		return $in_subcategory;
	}
}

if ( ! function_exists( 'show_page_menu' ) ){
	function show_page_menu($customClass = 'nav clearfix', $addUlContainer = true, $addHomeLink = true){
		global $themename, $exclude_pages, $strdepth, $page_menu, $is_footer;

		//excluded pages
		if (mh_get_option($themename.'_menupages') <> '') $exclude_pages = implode(",", mh_get_option($themename.'_menupages'));

		//dropdown for pages
		$strdepth = '';
		if (mh_get_option($themename.'_enable_dropdowns') == 'on') $strdepth = "depth=".mh_get_option($themename.'_tiers_shown_pages');
		if ($strdepth == '') $strdepth = "depth=1";

		if ($is_footer) { $strdepth="depth=1"; $strdepth2 = $strdepth; }

		$page_menu = wp_list_pages("sort_column=".mh_get_option($themename.'_sort_pages')."&sort_order=".mh_get_option($themename.'_order_page')."&".$strdepth."&exclude=".$exclude_pages."&title_li=&echo=0");

		if ($addUlContainer) echo('<ul class="'.$customClass.'">');
			if (mh_get_option($themename . '_home_link') == 'on' && $addHomeLink) { ?>
				<li <?php if (is_front_page() || is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e('Home', 'mharty'); ?></a></li>
			<?php };

			echo $page_menu;
		if ($addUlContainer) echo('</ul>');
	}
}

if ( ! function_exists( 'show_categories_menu' ) ){
	function show_categories_menu($customClass = 'nav clearfix', $addUlContainer = true){
		global $themename, $category_menu, $exclude_cats, $hide, $strdepth2, $projects_cat;

		//excluded categories
		if (mh_get_option($themename.'_menucats') <> '') $exclude_cats = implode(",", mh_get_option($themename.'_menucats'));

		//hide empty categories
		if (mh_get_option($themename.'_categories_empty') == 'on') $hide = '1';
		else $hide = '0';

		//dropdown for categories
		$strdepth2 = '';
		if (mh_get_option($themename.'_enable_dropdowns_categories') == 'on') $strdepth2 = "depth=".mh_get_option($themename.'_tiers_shown_categories');
		if ($strdepth2 == '') $strdepth2 = "depth=1";

		$args = "orderby=".mh_get_option($themename.'_sort_cat')."&order=".mh_get_option($themename.'_order_cat')."&".$strdepth2."&exclude=".$exclude_cats."&hide_empty=".$hide."&title_li=&echo=0";

		$categories = get_categories( $args );

		if ( !empty($categories) ) {
			$category_menu = wp_list_categories($args);
			if ($addUlContainer) echo('<ul class="'.$customClass.'">');
				echo $category_menu;
			if ($addUlContainer) echo('</ul>');
		}
	}
}

function head_addons(){
	global $themename;

	//prints the theme name, version in meta tag
	if ( ! function_exists( 'get_custom_header' ) ){
		// compatibility with versions of WordPress prior to 3.4.
		$theme_info = get_theme_data( get_template_directory() . '/style.css');
		echo '<meta content="' . esc_attr( $theme_info['Name'] . ' v.' . $theme_info['Version'] ) . '" name="generator"/>';
	} else {
		$theme_info = wp_get_theme();
		echo '<meta content="' . esc_attr( $theme_info->display('Name') . ' v.' . $theme_info->display('Version') ) . '" name="generator"/>';
	}
};// end function head_addons()
add_action('wp_head','head_addons',7);


function integration_head(){
	global $themename;
	if (mh_get_option($themename.'_integration_head') <> '' && mh_get_option($themename.'_integrate_header_enable') == 'on') echo( mh_get_option($themename.'_integration_head') );
};
add_action('wp_head','integration_head',12);

function integration_body(){
	global $themename;
	if (mh_get_option($themename.'_integration_body') <> '' && mh_get_option($themename.'_integrate_body_enable') == 'on') echo( mh_get_option($themename.'_integration_body') );
};
add_action('wp_footer','integration_body',12);

/*this function gets page name by its id*/
if ( ! function_exists( 'get_pagename' ) ){
	function get_pagename( $page_id )
	{
		$page_object = get_page( $page_id );

		return apply_filters( 'the_title', $page_object->post_title, $page_id );
	}
}

/*this function gets category name by its id*/
if ( ! function_exists( 'get_categname' ) ){
	function get_categname( $cat_id )
	{
		return get_cat_name( $cat_id );
	}
}

/*this function gets category id by its name*/
if ( ! function_exists( 'get_catId' ) ) {
	function get_catId( $cat_name, $taxonomy = 'category' )
	{
		$cat_name_id = is_numeric( $cat_name ) ? (int) $cat_name : (int) get_cat_ID( html_entity_decode( $cat_name, ENT_QUOTES ) );

		// wpml compatibility
		if ( function_exists( 'icl_object_id' ) ) {
			$cat_name_id = (int) icl_object_id( $cat_name_id, $taxonomy, true );
		}

		return $cat_name_id;
	}
}

/*this function gets page id by its name*/
if ( ! function_exists( 'get_pageId' ) ){
	function get_pageId( $page_name )
	{
		if ( is_numeric( $page_name ) ) {
			$page_id = intval( $page_name );
		} else {
			$page_name = html_entity_decode( $page_name, ENT_QUOTES );
			$page = get_page_by_title( $page_name );
			$page_id = intval( $page->ID );
		}

		// wpml compatibility
		if ( function_exists( 'icl_object_id' ) )
			$page_id = (int) icl_object_id( $page_id, 'page', true );

		return $page_id;
	}
}

/**
 * Transforms an array of posts, pages, post_tags or categories ids
 * into corresponding "objects" ids, if WPML plugin is installed
 *
 * @param array $ids_array Posts, pages, post_tags or categories ids.
 * @param string $type "Object" type.
 * @return array IDs.
 */
if ( ! function_exists( 'mh_generate_wpml_ids' ) ){
	function mh_generate_wpml_ids( $ids_array, $type ) {
		if ( function_exists( 'icl_object_id' ) ){
			$wpml_ids = array();
			foreach ( $ids_array as $id ) {
				$translated_id = icl_object_id( $id, $type, false );
				if ( ! is_null( $translated_id ) ) $wpml_ids[] = $translated_id;
			}
			$ids_array = $wpml_ids;
		}

		return array_map( 'intval', $ids_array );
	}
}

if ( ! function_exists( 'mharty_is_blog_posts_page' ) ){
	function mharty_is_blog_posts_page() {
		/**
		 * Returns true if static page is set in WP-Admin / Settings / Reading
		 * and Posts page is displayed
		 */

		static $mh_is_blog_posts_cached = null;

		if ( null === $mh_is_blog_posts_cached ) {
			$mh_is_blog_posts_cached = (bool) is_home() && 0 !== intval( get_option( 'page_for_posts', '0' ) );
		}

		return $mh_is_blog_posts_cached;
	}
}

/*backwards compatibility*/
if ( ! function_exists( 'mharty_titles' ) ){
	function mharty_titles() {
		if ( ! function_exists( 'wp_get_document_title' ) ) {
			wp_title();
		} else {
			echo wp_get_document_title();
		}
	}
}

/*meta for titles*/
if ( ! function_exists( 'mharty_titles_filter' ) ){
	function mharty_titles_filter( $custom_title){
		global $themename;

		$custom_title = '';

		$sitename = get_bloginfo('name');
		$site_description = get_bloginfo('description');

		#if the title is being displayed on the homepage
		if ( ( is_home() || is_front_page() ) && ! mharty_is_blog_posts_page() ) {
			if ( 'on' === mh_get_option( $themename . '_seo_home_title' ) ) {
				$custom_title = mh_get_option( $themename . '_seo_home_titletext' );
			} else {
				$seo_home_type = mh_get_option( $themename . '_seo_home_type' );
				$seo_home_separate = mh_get_option( $themename . '_seo_home_separate' );

				if ( $seo_home_type == 'BlogName | Blog description' ) {
					$custom_title = $sitename . esc_html( $seo_home_separate ) . $site_description;
				}
				if ( $seo_home_type == 'Blog description | BlogName') {
					$custom_title = $site_description . esc_html( $seo_home_separate ) . $sitename;
				}
				if ( $seo_home_type == 'BlogName only') {
					$custom_title = $sitename;
				}
			}
		}

		#if the title is being displayed on single posts/pages
		if ( ( ( is_single() || is_page() ) && ! is_front_page() ) || mharty_is_blog_posts_page() ) {
			global $wp_query;
			$postid = mharty_is_blog_posts_page() ? intval( get_option( 'page_for_posts' ) ) : $wp_query->post->ID;
			$key = mh_get_option($themename.'_seo_single_field_title');
			$exists3 = get_post_meta($postid, ''.$key.'', true);

			if ( 'on' === mh_get_option( $themename . '_seo_single_title' ) && '' !== $exists3 ) {
				$custom_title = $exists3;
			} else {
				$seo_single_type = mh_get_option( $themename . '_seo_single_type' );
				$seo_single_separate = mh_get_option( $themename . '_seo_single_separate' );
				$page_title = single_post_title( '', false );

				if ( $seo_single_type == 'BlogName | Post title' ) {
					$custom_title = $sitename . esc_html( $seo_single_separate ) . $page_title;
				}

				if ( $seo_single_type == 'Post title | BlogName' ) {
					$custom_title = $page_title . esc_html( $seo_single_separate ) . $sitename;
				}

				if ( $seo_single_type == 'Post title only' ) {
					$custom_title = $page_title;
				}
			}
		}

		#if the title is being displayed on index pages (categories/archives/search results)
		if ( is_category() || is_archive() || is_search() || is_404() ) {
			$page_title = '';

			$seo_index_type = mh_get_option( $themename . '_seo_index_type' );
			$seo_index_separate = mh_get_option( $themename . '_seo_index_separate' );

			if ( is_category() || is_tag() || is_tax() ) {
				$page_title = single_term_title( '', false );
			} else if ( is_post_type_archive() ) {
				$page_title = post_type_archive_title( '', false );
			} else if ( is_author() ) {
				$page_title = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
			} else if ( is_date() ) {
				$page_title = esc_html__( 'Archives', 'mharty' );
			} else if ( is_search() ) {
				$page_title = sprintf( esc_html__( 'Search results for "%s"', 'mharty' ), esc_attr( get_search_query() ) );
			} else if ( is_404() ) {
				$page_title = esc_html__( '404 Not Found', 'mharty' );
			}

			if ( $seo_index_type == 'BlogName | Category name' ) {
				$custom_title = $sitename . esc_html( $seo_index_separate ) . $page_title;
			}

			if ( $seo_index_type == 'Category name | BlogName') {
				$custom_title = $page_title . esc_html( $seo_index_separate ) . $sitename;
			}

			if ( $seo_index_type == 'Category name only') {
				$custom_title = $page_title;
			}
		}

		// Improves compatibility with SEO plugins
		$custom_title = wp_strip_all_tags( $custom_title );
		return $custom_title;
	}
}
add_filter( 'pre_get_document_title', 'mharty_titles_filter');

/*this function controls the meta description display*/
if ( ! function_exists( 'mharty_description' ) ){
	function mharty_description() {
		// Don't use mhPanel SEO if WordPress SEO or All In One SEO Pack plugins are active
		if ( class_exists( 'WPSEO_Frontend', false ) || class_exists( 'All_in_One_SEO_Pack', false ) ) {
			return;
		}

		global $themename;

		#homepage descriptions
		if ( mh_get_option($themename.'_seo_home_description') == 'on' && ( ( is_home() || is_front_page() ) && ! mharty_is_blog_posts_page() ) ) {
			echo '<meta name="description" content="' . esc_attr( mh_get_option($themename.'_seo_home_descriptiontext') ) .'" />';
		}

		#single page descriptions
		if ( mh_get_option($themename.'_seo_single_description') == 'on' && ( is_single() || is_page() || mharty_is_blog_posts_page() ) ) {
			global $wp_query;

			if ( isset($wp_query->post->ID) || mharty_is_blog_posts_page() ) {
				$postid = mharty_is_blog_posts_page() ? intval( get_option( 'page_for_posts' ) ) : $wp_query->post->ID;
			}

			$key2 = mh_get_option($themename.'_seo_single_field_description');

			if ( isset($postid) ) $exists = get_post_meta($postid, ''.$key2.'', true);

			if ( $exists !== '' ) {
				echo '<meta name="description" content="' . esc_attr( $exists ) . '" />';
			}
		}

		#index descriptions
		$seo_index_description = mh_get_option($themename.'_seo_index_description');
		if ( $seo_index_description == 'on' ) {
			$title_before_4_4 = version_compare( $GLOBALS['wp_version'], '4.4', '<' );
			$description_added = false;

			if ( is_category() ) {
				remove_filter( 'term_description', 'wpautop' );
				$cat = get_query_var( 'cat' );
				$exists2 = category_description( $cat );

				if ( $exists2 !== '' ) {
					echo '<meta name="description" content="' . esc_attr( $exists2 ) . '" />';
					$description_added = true;
				}
			}

			if ( is_archive() && ! $description_added ) {
				$description = $title_before_4_4
					? sprintf( esc_html__( 'Currently viewing archives from %1$s', 'mharty' ),
						wp_title( '', false, '' )
					)
					: get_the_archive_title();
			
				printf( '<meta name="description" content="%1$s" />',
					esc_attr( $description )
				);
			
				$description_added = true;
			}
			
			if ( is_search() && ! $description_added ) {
				$description = $title_before_4_4
					? wp_title( '', false, '' )
					: sprintf(
						esc_html__( 'Search Results for: %s', 'mharty' ),
						get_search_query()
					);
			
				echo '<meta name="description" content="' . esc_attr( $description ) . '" />';
				$description_added = true;
			}
		}
	}
}

/*this function controls the meta keywords display*/
if ( ! function_exists( 'mharty_keywords' ) ){
	function mharty_keywords() {
		// Don't use mhPanel SEO if WordPress SEO or All In One SEO Pack plugins are active
		if ( class_exists( 'WPSEO_Frontend', false ) || class_exists( 'All_in_One_SEO_Pack', false ) ) {
			return;
		}

		global $themename;

		#homepage keywords
		if ( mh_get_option($themename.'_seo_home_keywords') == 'on' && ( ( is_home() || is_front_page() ) && ! mharty_is_blog_posts_page() ) ) {
			echo '<meta name="keywords" content="' . esc_attr( mh_get_option($themename.'_seo_home_keywordstext') ) . '" />';
		}

		#single page keywords
		if ( mh_get_option($themename.'_seo_single_keywords') == 'on' ) {
			global $wp_query;
			if ( isset( $wp_query->post->ID ) || mharty_is_blog_posts_page() ) {
				$postid = mharty_is_blog_posts_page() ? intval( get_option( 'page_for_posts' ) ) : $wp_query->post->ID;
			}

			$key3 = mh_get_option($themename.'_seo_single_field_keywords');

			if (isset($postid)) $exists4 = get_post_meta($postid, ''.$key3.'', true);

			if ( isset($exists4) && $exists4 !== '' ) {
				if ( is_single() || is_page() || mharty_is_blog_posts_page() ) echo '<meta name="keywords" content="' . esc_attr( $exists4 ) . '" />';
			}
		}
	}
}

/*this function controls canonical urls*/
if ( ! function_exists( 'mharty_canonical' ) ){
	function mharty_canonical() {
		// Don't use mhPanel SEO if WordPress SEO or All In One SEO Pack plugins are active
		if ( class_exists( 'WPSEO_Frontend', false ) || class_exists( 'All_in_One_SEO_Pack', false ) ) {
			return;
		}

		global $themename;

		#homepage urls
		if ( mh_get_option($themename.'_seo_home_canonical') == 'on' && is_home() && ! mharty_is_blog_posts_page() ) {
			echo '<link rel="canonical" href="'. esc_url( home_url() ).'" />';
		}

		#single page urls
		if ( mh_get_option($themename.'_seo_single_canonical') == 'on' ) {
			global $wp_query;
			if ( isset( $wp_query->post->ID ) || mharty_is_blog_posts_page() ) {
				$postid = mharty_is_blog_posts_page() ? intval( get_option( 'page_for_posts' ) ) : $wp_query->post->ID;
			}

			if ( ( is_single() || is_page() || mharty_is_blog_posts_page() ) && ! is_front_page() ) {
				echo '<link rel="canonical" href="' . esc_url( get_permalink( $postid ) ) . '" />';
			}
		}

		#index page urls
		if ( mh_get_option($themename.'_seo_index_canonical') == 'on' ) {
			$current_page_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			if ( is_archive() || is_category() || is_search() ) echo '<link rel="canonical" href="'. esc_url( $current_page_url ).'" />';
		}
	}
}

add_action( 'init', 'mh_create_images_temp_folder' );
function mh_create_images_temp_folder(){
	#clean mh_temp folder once per week
	if ( false !== $last_time = get_option( 'mh_schedule_clean_images_last_time'  ) ){
		$timeout = 86400 * 7;
		if ( ( $timeout < ( time() - $last_time ) ) && '' != get_option( 'mh_images_temp_folder' ) ) mh_clean_temp_images( get_option( 'mh_images_temp_folder' ) );
	}

	if ( false !== get_option( 'mh_images_temp_folder' ) ) return;

	$uploads_dir = wp_upload_dir();
	$destination_dir = ( false === $uploads_dir['error'] ) ? path_join( $uploads_dir['basedir'], 'mh_temp' ) : null;

	if ( ! wp_mkdir_p( $destination_dir ) ) update_option( 'mh_images_temp_folder', '' );
	else {
		update_option( 'mh_images_temp_folder', preg_replace( '#\/\/#', '/', $destination_dir ) );
		update_option( 'mh_schedule_clean_images_last_time', time() );
	}
}

if ( ! function_exists( 'mh_clean_temp_images' ) ){
	function mh_clean_temp_images( $directory ){
		$dir_to_clean = @ opendir( $directory );

		if ( $dir_to_clean ) {
			while (($file = readdir( $dir_to_clean ) ) !== false ) {
				if ( substr($file, 0, 1) == '.' )
					continue;
				if ( is_dir( $directory.'/'.$file ) )
					mh_clean_temp_images( path_join( $directory, $file ) );

				else
					@ unlink( path_join( $directory, $file ) );
			}
			closedir( $dir_to_clean );
		}

		#set last time cleaning was performed
		update_option( 'mh_schedule_clean_images_last_time', time() );
	}
}

add_filter( 'update_option_upload_path', 'mh_update_uploads_dir' );
function mh_update_uploads_dir( $upload_path ){
	#check if we have 'mh_temp' folder within $uploads_dir['basedir'] directory, if not - try creating it, if it's not possible $destination_dir = null

	$destination_dir = '';
	$uploads_dir = wp_upload_dir();
	$mh_temp_dir = path_join( $uploads_dir['basedir'], 'mh_temp' );

	if ( is_dir( $mh_temp_dir ) || ( false === $uploads_dir['error'] && wp_mkdir_p( $mh_temp_dir ) ) ){
		$destination_dir = $mh_temp_dir;
		update_option( 'mh_schedule_clean_images_last_time', time() );
	}

	update_option( 'mh_images_temp_folder', preg_replace( '#\/\/#', '/', $destination_dir ) );

	return $upload_path;
}

if ( ! function_exists( 'mh_resize_image' ) ){
	function mh_resize_image( $thumb, $new_width, $new_height, $crop ){
		/*
		 * Fixes the issue with x symbol between width and height values in the filename.
		 * For instance, sports-400x400.jpg file results in 'image not found' in getimagesize() function.
		 */
		$thumb = str_replace( '%26%23215%3B', 'x', rawurlencode( $thumb ) );
		$thumb = rawurldecode( $thumb );

		if ( is_ssl() ) $thumb = preg_replace( '#^http://#', 'https://', $thumb );
		$info = pathinfo($thumb);
		$ext = $info['extension'];
		$name = wp_basename($thumb, ".$ext");
		$is_jpeg = false;
		$site_uri = apply_filters( 'mh_resize_image_site_uri', site_url() );
		$site_dir = apply_filters( 'mh_resize_image_site_dir', ABSPATH );

		// If multisite, not the main site, WordPress version < 3.5 or ms-files rewriting is enabled ( not the fresh WordPress installation, updated from the 3.4 version )
		if ( is_multisite() && ! is_main_site() && ( ! function_exists( 'wp_get_mime_types' ) || get_site_option( 'ms_files_rewriting' ) ) ) {
			//Get main site url on multisite installation

			switch_to_blog( 1 );
			$site_uri = site_url();
			restore_current_blog();
		}

		/*
		 * If we're dealing with an external image ( might be the result of Grab the first image function ),
		 * return original image url
		 */
		if ( false === strpos( $thumb, $site_uri ) )
			return $thumb;

		if ( 'jpeg' == $ext ) {
			$ext = 'jpg';
			$name = preg_replace( '#.jpeg$#', '', $name );
			$is_jpeg = true;
		}

		$suffix = "{$new_width}x{$new_height}";

		$destination_dir = '' != get_option( 'mh_images_temp_folder' ) ? preg_replace( '#\/\/#', '/', get_option( 'mh_images_temp_folder' ) ) : null;

		$matches = apply_filters( 'mh_resize_image_site_dir', array(), $site_dir );
		if ( !empty($matches) ){
			preg_match( '#'.$matches[1].'$#', $site_uri, $site_uri_matches );
			if ( !empty($site_uri_matches) ){
				$site_uri = str_replace( $matches[1], '', $site_uri );
				$site_uri = preg_replace( '#/$#', '', $site_uri );
				$site_dir = str_replace( $matches[1], '', $site_dir );
				$site_dir = preg_replace( '#\\\/$#', '', $site_dir );
			}
		}

		#get local name for use in file_exists() and get_imagesize() functions
		$localfile = str_replace( apply_filters( 'mh_resize_image_localfile', $site_uri, $site_dir, mh_multisite_thumbnail($thumb) ), $site_dir, mh_multisite_thumbnail($thumb) );

		$add_to_suffix = '';
		if ( file_exists( $localfile ) ) $add_to_suffix = filesize( $localfile ) . '_';

		#prepend image filesize to be able to use images with the same filename
		$suffix = $add_to_suffix . $suffix;
		$destfilename_attributes = '-' . $suffix . '.' . strtolower( $ext );

		$checkfilename = ( '' != $destination_dir && null !== $destination_dir ) ? path_join( $destination_dir, $name ) : path_join( dirname( $localfile ), $name );
		$checkfilename .= $destfilename_attributes;

		if ( $is_jpeg ) $checkfilename = preg_replace( '#.jpg$#', '.jpeg', $checkfilename );

		$uploads_dir = wp_upload_dir();
		$uploads_dir['basedir'] = preg_replace( '#\/\/#', '/', $uploads_dir['basedir'] );

		if ( null !== $destination_dir && '' != $destination_dir && apply_filters('mh_enable_uploads_detection', true) ){
			$site_dir = trailingslashit( preg_replace( '#\/\/#', '/', $uploads_dir['basedir'] ) );
			$site_uri = trailingslashit( $uploads_dir['baseurl'] );
		}

		#check if we have an image with specified width and height

		if ( file_exists( $checkfilename ) ) return str_replace( $site_dir, trailingslashit( $site_uri ), $checkfilename );

		$size = @getimagesize( $localfile );
		if ( !$size ) return new WP_Error('invalid_image_path', esc_html__('Image doesn\'t exist'), $thumb);
		list($orig_width, $orig_height, $orig_type) = $size;

		#check if we're resizing the image to smaller dimensions
		if ( $orig_width > $new_width || $orig_height > $new_height ){
			if ( $orig_width < $new_width || $orig_height < $new_height ){
				#don't resize image if new dimensions > than its original ones
				if ( $orig_width < $new_width ) $new_width = $orig_width;
				if ( $orig_height < $new_height ) $new_height = $orig_height;

				#regenerate suffix and appended attributes in case we changed new width or new height dimensions
				$suffix = "{$add_to_suffix}{$new_width}x{$new_height}";
				$destfilename_attributes = '-' . $suffix . '.' . $ext;

				$checkfilename = ( '' != $destination_dir && null !== $destination_dir ) ? path_join( $destination_dir, $name ) : path_join( dirname( $localfile ), $name );
				$checkfilename .= $destfilename_attributes;

				#check if we have an image with new calculated width and height parameters
				if ( file_exists($checkfilename) ) return str_replace( $site_dir, trailingslashit( $site_uri ), $checkfilename );
			}

			#we didn't find the image in cache, resizing is done here
			if ( ! function_exists( 'wp_get_image_editor' ) ) {
				// compatibility with versions of WordPress prior to 3.5.
				$result = image_resize( $localfile, $new_width, $new_height, $crop, $suffix, $destination_dir );
			} else {
				$mh_image_editor = wp_get_image_editor( $localfile );

				if ( ! is_wp_error( $mh_image_editor ) ) {
					$mh_image_editor->resize( $new_width, $new_height, $crop );

					// generate correct file name/path
					$mh_new_image_name = $mh_image_editor->generate_filename( $suffix, $destination_dir );

					do_action( 'mh_resize_image_before_save', $mh_image_editor, $mh_new_image_name );

					$mh_image_editor->save( $mh_new_image_name );

					// assign new image path
					$result = $mh_new_image_name;
				} else {
					// assign a WP_ERROR ( WP_Image_Editor instance wasn't created properly )
					$result = $mh_image_editor;
				}
			}

			if ( ! is_wp_error( $result ) ) {
				// transform local image path into URI

				if ( $is_jpeg ) $thumb = preg_replace( '#.jpeg$#', '.jpg', $thumb);

				$site_dir = str_replace( '\\', '/', $site_dir );
				$result = str_replace( '\\', '/', $result );
				$result = str_replace( '//', '/', $result );
				$result = str_replace( $site_dir, trailingslashit( $site_uri ), $result );
			}

			#returns resized image path or WP_Error ( if something went wrong during resizing )
			return $result;
		}

		#returns unmodified image, for example in case if the user is trying to resize 800x600px to 1920x1080px image
		return $thumb;
	}
}

add_action( 'pre_get_posts', 'mh_custom_posts_per_page' );
function mh_custom_posts_per_page( $query = false ) {
	global $themename;

	if ( is_admin() ) return;

	if ( ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) return;

	if ( $query->is_category ) {
		$query->set( 'posts_per_page', (int) mh_get_option( $themename . '_catnum_posts', '10' ) );
	} elseif ( $query->is_tag ) {
		$query->set( 'posts_per_page', (int) mh_get_option( $themename . '_tagnum_posts', '10' ) );
	} elseif ( $query->is_search ) {
		if ( isset($_GET['mh_searchform_submit']) ) {
			$postTypes = array();
			if ( !isset($_GET['mh-inc-posts']) && !isset($_GET['mh-inc-pages']) ) $postTypes = array('post');
			if ( isset($_GET['mh-inc-pages']) ) $postTypes = array('page');
			if ( isset($_GET['mh-inc-posts']) ) $postTypes[] = 'post';
			$query->set( 'post_type', $postTypes );

			if ( isset( $_GET['mh-month-choice'] ) && $_GET['mh-month-choice'] != 'no-choice' ) {
				$mh_year = substr($_GET['mh-month-choice'],0,4);
				$mh_month = substr($_GET['mh-month-choice'], 4, strlen($_GET['mh-month-choice'])-4);

				$query->set( 'year', absint($mh_year) );
				$query->set( 'monthnum', absint($mh_month) );
			}

			if ( isset( $_GET['mh-cat'] ) && $_GET['mh-cat'] != 0 )
				$query->set( 'cat', absint($_GET['mh-cat']) );
		}
		$query->set( 'posts_per_page', (int) mh_get_option( $themename . '_searchnum_posts', '10' ) );
	} elseif ( $query->is_archive ) {
		$query->set( 'posts_per_page', (int) mh_get_option( $themename . '_archivenum_posts', '10' ) );
	}
}
//theme updates to be placed here

add_filter( 'default_hidden_meta_boxes', 'mh_show_hidden_metaboxes', 10, 2 );
function mh_show_hidden_metaboxes( $hidden, $screen ){
	# make custom fields and excerpt meta boxes show by default
	if ( 'post' == $screen->base || 'page' == $screen->base )
		$hidden = array('slugdiv', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv');

	return $hidden;
}

add_filter('widget_title','mh_widget_force_title');
function mh_widget_force_title( $title ){
	#add an empty title for widgets ( otherwise it might break the sidebar layout )
	if ( $title == '' ) $title = ' ';

	return $title;
}

//modify the comment counts to only reflect the number of comments minus pings
if( version_compare( phpversion(), '4.4', '>=' ) ) add_filter('get_comments_number', 'mh_comment_count', 0);
function mh_comment_count( $count ) {
	$is_ajax_active = defined( 'DOING_AJAX' ) && DOING_AJAX ? true : false;
	if ( ! is_admin() || $is_ajax_active) {
		global $id;
		$get_comments = get_comments( array('post_id' => $id, 'status' => 'approve') );
		$comments_by_type = separate_comments($get_comments);
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}

add_filter( 'body_class', 'mh_add_fullwidth_body_class' );
function mh_add_fullwidth_body_class( $classes ){
	$fullwidth_view = false;

	if ( is_page_template('page-full.php') ) $fullwidth_view = true;

	if ( is_page() || is_single() ){
		$mh_ptemplate_settings = get_post_meta( get_queried_object_id(),'mh_ptemplate_settings',true );
		$fullwidth = isset( $mh_ptemplate_settings['mh_fullwidthpage'] ) ? (bool) $mh_ptemplate_settings['mh_fullwidthpage'] : false;

		if ( $fullwidth ) $fullwidth_view = true;
	}

	if ( is_single() && 'on' == get_post_meta( get_queried_object_id(), '_mh_full_post', true ) ) $fullwidth_view = true;

	$classes[] = apply_filters( 'mh_fullwidth_view_body_class', $fullwidth_view ) ? 'mh_fullwidth_view' : 'mh_includes_sidebar';

	return $classes;
}


/**
 * Loads theme settings
 *
 */
if ( ! function_exists( 'mh_load_panel_options' ) ) {
	function mh_load_panel_options() {
		require_once( get_template_directory() . '/includes/mh_panel/mh_options.php');
		do_action('mh_load_ext_options');
	}
}

/**
 * Adds custom css option content to <head>
 *
 */
function mh_add_custom_css() {
	$custom_css = mh_get_option( "mharty_custom_css" );
	if ( false === $custom_css || '' == $custom_css ) return;

	/**
	 * The theme doesn't strip slashes from custom css, when saving to the database,
	 * so it does that before outputting the code on front-end
	 */
	echo '<style type="text/css" id="mh-custom-css">' . "\n" . stripslashes( $custom_css ) . "\n" . '</style>';
}
add_action( 'wp_head', 'mh_add_custom_css', 100 );

if ( ! function_exists( 'mh_get_google_fonts' ) ) :
//fonts list
function mh_get_google_fonts() {
	$google_fonts = array(

		'Stack' => array(
			'styles' 		=> '',
			'character_set' => 'separator',
			'type'			=> '',
		),
		'Palatino' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Palatino',
		),
		'Verdana' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Verdana',
		),
		'Tahoma' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Tahoma',
		),
		'Trebuchet MS' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Trebuchet MS',
		),
		'Georgia' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Georgia',
		),
		'Arial' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Arial',
		),
		'Arial Black' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Arial Black',
		),
		'Times New Roman' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Times New Roman',
		),
		'Baskerville' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Baskerville',
		),
		'Lucida Bright' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Lucida Bright',
		),
		'Courier' => array(
			'styles' 		=> '500',
			'character_set' => 'stack',
			'type'			=> 'Courier',
		),
		'End Stack' => array(
			'styles' 		=> '',
			'character_set' => 'separator',
			'type'			=> '',
		),
		'Arabic' => array(
			'styles' 		=> '',
			'character_set' => 'separator',
			'type'			=> '',
		),
		'Amiri' => array(
			'styles' 		=> '400,700',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Droid Arabic Kufi' => array(
			'styles' 		=> '400,700',
			'character_set' => 'earlyaccess',
			'type'			=> 'arabic-serif',
		),
		'Droid Arabic Naskh' => array(
			'styles' 		=> '400,700',
			'character_set' => 'earlyaccess',
			'type'			=> 'arabic-serif',
		),
		'Cairo' => array(
			'styles' 		=> '400,700',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'El Messiri' => array(
			'styles' 		=> '400,700',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Rakkas' => array(
			'styles' 		=> '400',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Mada' => array(
			'styles' 		=> '400,900',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Changa' => array(
			'styles' 		=> '400,700',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Lalezar' => array(
			'styles' 		=> '400',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Lemonada' => array(
			'styles' 		=> '400,700',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Harmattan' => array(
			'styles' 		=> '400',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Aref Ruqaa' => array(
			'styles' 		=> '400,700',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Mirza' => array(
			'styles' 		=> '400,700',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Jomhuria' => array(
			'styles' 		=> '400',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Reem Kufi' => array(
			'styles' 		=> '400',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Katibeh' => array(
			'styles' 		=> '400',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Dubai-Regular' => array(
			'styles' 		=> '400',
			'character_set' => 'embedded',
			'type'			=> 'arabic-sans',
		),
		'JF Flat' => array(
			'styles' 		=> '400',
			'character_set' => 'embedded',
			'type'			=> 'arabic-sans',
		),
		'AraJozoor-Regular' => array(
			'styles' 		=> '400',
			'character_set' => 'embedded',
			'type'			=> 'arabic-sans',
		),
		'RobotoCondensed' => array(
			'styles' 		=> '400',
			'character_set' => 'embedded',
			'type'			=> 'arabic-sans',
		),
		'Thabit' => array(
			'styles' 		=> '400',
			'character_set' => 'earlyaccess',
			'type'			=> 'arabic-serif',
		),
		'Lateef' => array(
			'styles' 		=> '400',
			'character_set' => 'arabic',
			'type'			=> 'arabic-serif',
		),
		'Noto Naskh Arabic UI'	=> array(
			'styles' 		=> '400',
			'character_set' => 'earlyaccess',
			'type'			=> 'arabic-serif',
		),
		'Noto Nastaliq Urdu Draft' => array(
			'styles' 		=> '400',
			'character_set' => 'earlyaccess',
			'type'			=> 'arabic-serif',
		),
		'kfc_naskh' => array(
			'styles' 		=> '400',
			'character_set' => 'embedded',
			'type'			=> 'arabic-serif',
		),
		'Simplified Arabic' => array(
			'styles' 		=> '400',
			'character_set' => 'stack',
			'type'			=> 'Simplified Arabic',
		),
		'End Arabic' => array(
			'styles' 		=> '',
			'character_set' => 'separator',
			'type'			=> '',
		),
		'Latin' => array(
			'styles' 		=> '',
			'character_set' => 'separator',
			'type'			=> '',
		),
		'Open Sans' => array(
			'styles' 		=> '300italic,400italic,600italic,700italic,800italic,400,300,600,700,800',
			'character_set' => 'latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic',
			'type'			=> 'sans-serif',
		),
		'Raleway' => array(
			'styles' 		=> '400,100,200,300,600,500,700,800,900',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Montserrat' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Merriweather' => array(
			'styles' 		=> '400,400italic,300,300italic,700,700italic',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Oswald' => array(
			'styles' 		=> '400,300,700',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Droid Sans' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Lato' => array(
			'styles' 		=> '400,100,100italic,300,300italic,400italic,700,700italic,900,900italic',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Open Sans Condensed' => array(
			'styles' 		=> '300,300italic,700',
			'character_set' => 'latin,cyrillic-ext,latin-ext,greek-ext,greek,vietnamese,cyrillic',
			'type'			=> 'sans-serif',
		),
		'PT Sans' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'sans-serif',
		),
		'Ubuntu' => array(
			'styles' 		=> '400,300,300italic,400italic,500,500italic,700,700italic',
			'character_set' => 'latin,cyrillic-ext,cyrillic,greek-ext,greek,latin-ext',
			'type'			=> 'sans-serif',
		),
		'PT Sans Narrow' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'sans-serif',
		),
		'Roboto Condensed' => array(
			'styles' 		=> '400,300,300italic,400italic,700,700italic',
			'character_set' => 'latin,cyrillic-ext,latin-ext,greek-ext,cyrillic,greek,vietnamese',
			'type'			=> 'sans-serif',
		),
		'Yanone Kaffeesatz' => array(
			'styles' 		=> '400,200,300,700',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Source Sans Pro' => array(
			'styles' 		=> '400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Nunito' => array(
			'styles' 		=> '400,300,700',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Francois One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Roboto' => array(
			'styles' 		=> '400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic',
			'character_set' => 'latin,cyrillic-ext,latin-ext,cyrillic,greek-ext,greek,vietnamese',
			'type'			=> 'sans-serif',
		),
		'Arimo' => array(
			'styles' 		=> '400,400italic,700italic,700',
			'character_set' => 'latin,cyrillic-ext,latin-ext,greek-ext,cyrillic,greek,vietnamese',
			'type'			=> 'sans-serif',
		),
		'Cuprum' => array(
			'styles' 		=> '400,400italic,700italic,700',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'sans-serif',
		),
		'Aclonica' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Tenor Sans' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'sans-serif',
		),
		'Play' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin,cyrillic-ext,cyrillic,greek-ext,greek,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Dosis' => array(
			'styles' 		=> '400,200,300,500,600,700,800',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'sans-serif',
		),
		'Abel' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'sans-serif',
		),
		'Droid Serif' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Arvo' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Lora' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Artifika' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Rokkitt' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'PT Serif' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin,cyrillic',
			'type'			=> 'serif',
		),
		'Bitter' => array(
			'styles' 		=> '400,400italic,700',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'serif',
		),
		'Merriweather' => array(
			'styles' 		=> '400,300,900,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Vollkorn' => array(
			'styles' 		=> '400,400italic,700italic,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Cantata One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'serif',
		),
		'Kreon' => array(
			'styles' 		=> '400,300,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Josefin Slab' => array(
			'styles' 		=> '400,100,100italic,300,300italic,400italic,600,700,700italic,600italic',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Playfair Display' => array(
			'styles' 		=> '400,400italic,700,700italic,900italic,900',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'serif',
		),
		'Bree Serif' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'serif',
		),
		'Crimson Text' => array(
			'styles' 		=> '400,400italic,600,600italic,700,700italic',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Old Standard TT' => array(
			'styles' 		=> '400,400italic,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Sanchez' => array(
			'styles' 		=> '400,400italic',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'serif',
		),
		'Crete Round' => array(
			'styles' 		=> '400,400italic',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'serif',
		),
		'Cardo' => array(
			'styles' 		=> '400,400italic,700',
			'character_set' => 'latin,greek-ext,greek,latin-ext',
			'type'			=> 'serif',
		),
		'Noticia Text' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin,vietnamese,latin-ext',
			'type'			=> 'serif',
		),
		'Judson' => array(
			'styles' 		=> '400,400italic,700',
			'character_set' => 'latin',
			'type'			=> 'serif',
		),
		'Gravitas One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Lobster' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,cyrillic-ext,latin-ext,cyrillic',
			'type'			=> 'cursive',
		),
		'Abril Fatface' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Unkempt' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Changa One' => array(
			'styles' 		=> '400,400italic',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Special Elite' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Chewy' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Comfortaa' => array(
			'styles' 		=> '400,300,700',
			'character_set' => 'latin,cyrillic-ext,greek,latin-ext,cyrillic',
			'type'			=> 'cursive',
		),
		'Boogaloo' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Fredoka One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Luckiest Guy' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Cherry Cream Soda' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Lobster Two' => array(
			'styles' 		=> '400,400italic,700,700italic',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Righteous' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Squada One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Black Ops One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Happy Monkey' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Passion One' => array(
			'styles' 		=> '400,700,900',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Nova Square' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Metamorphous' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext',
			'type'			=> 'cursive',
		),
		'Poiret One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,latin-ext,cyrillic',
			'type'			=> 'cursive',
		),
		'Bevan' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Shadows Into Light' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'The Girl Next Door' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Coming Soon' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Dancing Script' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Pacifico' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Crafty Girls' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Calligraffitti' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Rock Salt' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Amatic SC' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Leckerli One' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Tangerine' => array(
			'styles' 		=> '400,700',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Reenie Beanie' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Satisfy' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Gloria Hallelujah' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Permanent Marker' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Covered By Your Grace' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Walter Turncoat' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Patrick Hand' => array(
			'styles' 		=> '400',
			'character_set' => 'latin,vietnamese,latin-ext',
			'type'			=> 'cursive',
		),
		'Schoolbell' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Indie Flower' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'Fredericka the Great' => array(
			'styles' 		=> '400',
			'character_set' => 'latin',
			'type'			=> 'cursive',
		),
		'End Latin' => array(
			'styles' 		=> '',
			'character_set' => 'separator',
			'type'			=> '',
		),
	);

	return apply_filters( 'mh_google_fonts', $google_fonts );
}
endif;

if ( ! function_exists( 'mh_get_websafe_font_stack' ) ) :

//fonts stack
function mh_get_websafe_font_stack( $type = 'sans-serif' ) {
	$font_stack = '';

	switch ( $type ) {
	case 'sans-serif':
		$font_stack = 'Helvetica, Arial, Lucida, sans-serif';
		break;
	case 'serif':
		$font_stack = 'Georgia, "Times New Roman", serif';
		break;
	case 'cursive':
		$font_stack = 'cursive';
		break;
	case 'arabic-serif':
		$font_stack = 'Tahoma, Arial, "Times New Roman", serif';
		break;
	case 'arabic-sans':
		$font_stack = 'Tahoma, Arial, "Times New Roman", sans-serif';
		break;
	case 'Palatino':
		$font_stack = 'Palatino Linotype,Palatino LT STD,Book Antiqua,Georgia,serif;';
		break;
	case 'Verdana':
		$font_stack = 'Geneva,sans-serif;';
		break;
	case 'Tahoma':
		$font_stack = 'Verdana,Segoe,sans-serif;';
		break;
	case 'Trebuchet MS':
		$font_stack = 'Lucida Grande,Lucida Sans Unicode,Lucida Sans,Tahoma,sans-serif;';
		break;
	case 'Georgia':
		$font_stack = 'Times,Times New Roman,serif;';
		break;
	case 'Arial':
		$font_stack = 'Helvetica Neue,Helvetica,sans-serif;';
		break;
	case 'Arial Black':
		$font_stack = 'Arial Bold,Gadget,sans-serif;';
		break;
	case 'Times New Roman':
		$font_stack = 'TimesNewRoman,Times,Baskerville,Georgia,serif;';
		break;
	case 'Courier':
		$font_stack = 'Courier New,Lucida Sans Typewriter,Lucida Typewriter,monospace;';
		break;
	case 'Baskerville':
		$font_stack = 'Baskerville Old Face,Hoefler Text,Garamond,Times New Roman,serif;';
		break;
	case 'Lucida Bright':
		$font_stack = 'Georgia,serif;';
		break;
	case 'Simplified Arabic':
		$font_stack = ';';
	}

	return $font_stack;
}
endif;

if ( ! function_exists( 'mh_gf_attach_font' ) ) :
function mh_gf_attach_font( $mh_gf_font_name, $elements ) {
		$google_fonts = mh_get_google_fonts();

		printf( '%s { font-family: \'%s\', %s; }',
			esc_html( $elements ),
			esc_html( $mh_gf_font_name ),
			mh_get_websafe_font_stack( $google_fonts[$mh_gf_font_name]['type'] )
		);
}
endif;

if ( ! function_exists( 'mh_gf_enqueue_fonts' ) ) :
function mh_gf_enqueue_fonts( $mh_gf_font_names ) {
	
	if ( ! is_array( $mh_gf_font_names ) || empty( $mh_gf_font_names ) ) return;

	$google_fonts = mh_get_google_fonts();
	$protocol = is_ssl() ? 'https' : 'http';

	foreach ( $mh_gf_font_names as $mh_gf_font_name ) {
		$google_font_character_set = $google_fonts[$mh_gf_font_name]['character_set'];
		// By default, only latin and latin-ext subsets
		// All available subsets for some fonts can be enabled in Theme Panel
		// Also, do not subset for Arabic, embeded or system fonts
		if ( 'false' == mh_get_option( 'mharty_gf_enable_all_character_sets', 'false') && false !== strpos( $google_fonts[$mh_gf_font_name]['character_set'], 'latin' )) {
			$latin_ext = '';
			if ( false !== strpos( $google_fonts[$mh_gf_font_name]['character_set'], 'latin-ext' ) )
				$latin_ext = ',latin-ext';
			
			$google_font_character_set = "latin{$latin_ext}";
		}
		$query_args = array(
			'family' => sprintf( '%s:%s',
				str_replace( ' ', '+', $mh_gf_font_name ),
				apply_filters( 'mh_gf_set_styles', $google_fonts[$mh_gf_font_name]['styles'], $mh_gf_font_name )
			),
			'subset' => apply_filters( 'mh_gf_set_character_set', $google_font_character_set, $mh_gf_font_name ),
		);
		// if it is a google font
		if ( false !== strpos( $google_fonts[$mh_gf_font_name]['character_set'], 'latin' ) ){
		$mh_gf_font_name_slug = strtolower( str_replace( ' ', '-', $mh_gf_font_name ) );
		wp_enqueue_style( 'mh-gf-' . $mh_gf_font_name_slug, esc_url(add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" )), array(), null );
		//if it is an arabic google font	
		}elseif ( false !== strpos( $google_fonts[$mh_gf_font_name]['character_set'], 'arabic' ) ){
		$mh_gf_font_name_slug = strtolower( str_replace( ' ', '-', $mh_gf_font_name ) );
		wp_enqueue_style( 'mh-gf-' . $mh_gf_font_name_slug, esc_url(add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" )), array(), null );
		// if it is a earlyaccess font
		}elseif ( false !== strpos( $google_fonts[$mh_gf_font_name]['character_set'], 'earlyaccess' ) ){
			$mh_gf_font_name_slug = strtolower( str_replace( ' ', '', $mh_gf_font_name ) );
			wp_enqueue_style( 'mh-gf-' . $mh_gf_font_name_slug, "$protocol://fonts.googleapis.com/earlyaccess/$mh_gf_font_name_slug.css", array(), null );
		//if it is an embedded font
		}elseif ( false !== strpos( $google_fonts[$mh_gf_font_name]['character_set'], 'embedded' ) ){
$mh_gf_font_name_slug = strtolower( str_replace( ' ', '', $mh_gf_font_name ) );
$theme_uri = get_template_directory_uri();
			wp_enqueue_style( 'mh-gf-' . $mh_gf_font_name_slug, "$theme_uri/css/fonts/$mh_gf_font_name_slug.css", array(), null );
		
		}//if it is a stack font do nothing.
	}
}
endif;

//profile social
if ( ! function_exists( 'mh_modify_contact_methods' ) ) :
function mh_modify_contact_methods($user_contact) {

	// Add new fields
	$user_contact['twitter'] = esc_html__('Twitter URL', 'mharty');
	$user_contact['facebook'] = esc_html__('Facebook URL', 'mharty');
	$user_contact['instagram'] = esc_html__('Instagram URL', 'mharty');
	$user_contact['snapchat'] = esc_html__('Snapchat URL', 'mharty');
	$user_contact['googleplus'] = esc_html__('Google+ URL', 'mharty');
	$user_contact['youtube'] = esc_html__('YouTube URL', 'mharty');
	$user_contact['linkedin'] = esc_html__('LinkedIn URL', 'mharty');
	$user_contact['behance'] = esc_html__('Behance URL', 'mharty');
	$user_contact['dribbble'] = esc_html__('Dribbble URL', 'mharty');
	$user_contact['pinterest'] = esc_html__('Pinterest URL', 'mharty');
	$user_contact['flickr'] = esc_html__('Flickr URL', 'mharty');
	
	return $user_contact;
}
endif;
add_filter('user_contactmethods', 'mh_modify_contact_methods');

/**
 * Adds Next/Previous post navigations to single posts
 *
 */

if ( ! function_exists( 'mh_post_navigation' ) ) :
function mh_post_navigation( $same_category = false ) {
	// Don't print empty markup if there's nowhere to navigate.
$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( $same_category, '', true );
$next     = get_adjacent_post( $same_category, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
		<?php
		if ( is_attachment() ) :
			previous_post_link( '%link', mh_wp_kses( __( '<div class="mh-post-navigation">Go to article</div>', 'mharty' ) ) );
		else :
            if ($previous) {
				 $image = get_the_post_thumbnail($previous->ID, 'mhc-post-thumbnail');
				$class = $image ? "with-image" : "without-image";
				//$previous->post_title
                previous_post_link( '%link',  '<div class="mh-post-navigation mh-post-prev '.$class.'"><div class="postnav-wrapper"><div class="nav-info-container"><span class="postnav-top"><span class="postnav-title">' . $previous->post_title . '</span></span></div>
				<span class="postnav-bottom"><span class="mh-postnav-icon"><i class="mh-icon-arrow-right mh-icon-before"></i></span><span class="postnav-image">'.$image.'</span></span></div></div>', $same_category );
            } //<div class="mh-postnav-icon"><i class="mh-icon-arrow-right"></i></div>
            if ($next) {
				 $image = get_the_post_thumbnail($next->ID, 'mhc-post-thumbnail');
				$class = $image ? "with-image" : "without-image";
				//$next->post_title 
			    next_post_link( '%link', '<div class="mh-post-navigation mh-post-next '.$class.'"><div class="postnav-wrapper"><div class="nav-info-container"><span class="postnav-top"><span class="postnav-title">' . $next->post_title . '</span></span></div>
				<span class="postnav-bottom"><span class="mh-postnav-icon"><i class="mh-icon-arrow-left mh-icon-before"></i></span><span class="postnav-image">'.$image.'</span></span></div></div>', $same_category );
            }
        endif;
}
endif;


//related_posts
if ( ! function_exists( 'mh_related_posts' ) ) :
function mh_related_posts() {
global $post;
if ( is_attachment() ) return;
$current_post = get_the_ID();
$categories = is_singular('post') ? get_the_category() : get_the_terms($current_post, 'project_category');
$cat = $related_title = '';
foreach ($categories as $category) :
$cat = $category->term_id;
endforeach;
if (is_singular('post')){
	$related_title = mh_get_option( 'mharty_related_posts_title' );
	$args = array(
	'category__and' => $cat,
	'posts_per_page' => 3,
	'post__not_in' => array($post->ID),
	'ignore_sticky_posts' => 1,
	'post_status' => 'publish',
	);
}else{
	$related_title = mh_get_option( 'mharty_related_projects_title' );
	$args = array(
	'post_type'      => 'project',
	'posts_per_page' => 3,
	'post__not_in' => array($post->ID),
	'ignore_sticky_posts' => 1,
	'post_status' => 'publish',
	'tax_query' => array( 
		array(
			'taxonomy' => 'project_category',
			'field' => 'id',
			'terms' => explode( ',', $cat ),
			'operator' => 'IN',
		)
	),
	);
}
 $related = new WP_Query( $args );
 	if ( $related-> have_posts() ) :?>
    <div id="mh-related-posts" class="mh_list_posts">
   <?php  if ( '' !== $related_title ) {
				echo '<h2>' . $related_title . '</h2>';
   } ?>
 <ul>
  <?php
		while ( $related-> have_posts() ) : $related -> the_post(); ?> 
  <li class="list-post">
  
  <?php 
	
	//get the thumbnail
	$thumb = '';
	$width = 80;
	$width = (int) apply_filters( 'mhc-post-thumbnail', $width );
	$height = 80;
	$height = (int) apply_filters( 'mhc-post-thumbnail', $height );
	$classtext = '';
	$titletext = get_the_title();
	$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
	$thumb = $thumbnail["thumb"];
	$no_thumb_class = '';

	//thumbnail class
	if ( '' === $thumb ){
		$no_thumb_class = ' post-no-thumb';
	}
	
	if ( '' !== $thumb  ) : ?>
   <a class="list-post-thumb" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
   <?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
   </a>
	<?php endif; ?>
        <div class="list-post-info <?php echo $no_thumb_class; ?>">
        
		<h4 class="list-post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a><?php mh_after_post_title(); ?></h4>
        <div class="list-post-content"><?php truncate_post( 120 ); ?>
        <?php
		$readbutton = mh_get_option('mharty_readmore_button', 'off');
		$more = sprintf(
			'%5$s <a href="%1$s" title="%2$s"%4$s>%3$s</a>%6$s',
				esc_url( get_permalink() ),
				the_title_attribute(),
				apply_filters( 'mh_read_more_text_filter', esc_html__( 'Read more', 'mharty' )),
				'on' === $readbutton ? ' class="mhc_contact_submit"' : '',
				'on' === $readbutton ? '<div class="mhc_more_link">' : '',
				'on' === $readbutton ? '</div>' : ''
			);
			echo $more;
		?>
        </div>
     
       </div>
       </li>
<?php  endwhile;  ?>
</ul></div>
<?php endif; wp_reset_query(); } endif; // end

//Quick Contact Form
if ( ! function_exists( 'mh_quick_contact_exclude' ) ) :
function mh_quick_contact_exclude(){
	if ( ( defined( 'MHARTY_COMPOSER' ) && MHARTY_COMPOSER ) ){
		if ('on' === mh_get_option( 'mharty_show_quick_contact', 'off' ) ){
			$captcha = mh_get_option( 'mharty_quick_contact_captcha', 'off' );
			$email = mh_get_option( 'mharty_quick_contact_email', '');
			$title = mh_get_option( 'mharty_quick_contact_title', '');
			$blurb = mh_get_option( 'mharty_quick_contact_blurb', '');
			$message = mh_get_option( 'mharty_quick_contact_message', esc_html__( 'Thank you for contacting us.', 'mharty'));	
			$use_redirect = mh_get_option( 'mharty_quick_contact_use_redirect', 'off' );
			$redirect_url = mh_get_option( 'mharty_quick_contact_redirect_url', '');
			$class = ('' == $title && '' == $blurb ) ? ' mh_quick_form_no_header' : '';
			$output = '
		<div class="mh_quick_form' . $class . '">
		<div class="mh_quick_form_button mh_adjust_corners mh-icon-before"></div>
			<div class="mh_quick_form_inner"><span class="mh_quick_form_close"><i class="mh-icon-before"></i></span>'
			. do_shortcode('[mhc_contact_form  email="' . $email . '" captcha="' . $captcha .'" title="' .$title. '" blurb="' . $blurb . '" message="' . $message . '" use_redirect="' . $use_redirect . '" redirect_url="' . $redirect_url . '" message_pattern="(%%Name%% - %%Email%%) : %%Message%%" background_layout="light" button_style="solid" module_class="" /]') . '</div></div>';
			echo $output;
		}
	}
}
endif;
add_action('mh_before_end_container', 'mh_quick_contact_exclude');
 
// mh_custom_comments_display
if ( ! function_exists( 'mh_custom_comments_display' ) ) :
function mh_custom_comments_display($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
			<div class="comment_avatar">
                <?php echo get_avatar( $comment, $size = '80', 'mystery', esc_attr( get_comment_author() ) ); ?>
			</div>

			<div class="comment_postinfo">
				<?php printf( '<span class="fn">%s</span>', get_comment_author_link() ); ?>
				<span class="comment_date">
				<?php
					/* translators: 1: date, 2: time */
					printf( esc_html__( 'on %1$s at %2$s', 'mharty' ), get_comment_date(), get_comment_time() );
				?>
				</span>
				<?php edit_comment_link( '', ' ' ); ?>
			<?php
				$mh_comment_reply_link = get_comment_reply_link( array_merge( $args, array(
					'reply_text' => esc_attr__( 'Reply', 'mharty' ),
					'depth'      => (int) $depth,
					'max_depth'  => (int) $args['max_depth'],
				) ) );
			?>
			</div> <!-- .comment_postinfo -->

			<div class="comment_area">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<em class="moderation"><?php esc_html_e('Your comment is awaiting moderation.','mharty') ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-content clearfix">
				<?php
					comment_text();
					if ( $mh_comment_reply_link ) echo '<span class="reply-container">' . $mh_comment_reply_link . '</span>';
				?>
				</div> <!-- end comment-content-->
			</div> <!-- end comment_area-->
		</article> <!-- .comment-body -->
<?php }
endif;

//custom wpcf7 loader image
add_filter('wpcf7_ajax_loader', 'mh_wpcf7_ajax_loader');
function mh_wpcf7_ajax_loader() {
    return get_template_directory_uri() . '/images/subscribe-loader-dark.gif';
}
//change read more text
add_filter('mh_read_more_text_filter', 'mh_custom_read_more_text_filter');
    function mh_custom_read_more_text_filter() {
	if ( '' !== mh_get_option( 'mharty_readmore_text', esc_html__('Read more', 'mharty') ))
    return esc_attr( mh_get_option( 'mharty_readmore_text' ) );
}

if ( !function_exists( 'hex2rgb' ) ) :
function hex2rgb( $color ) {
	if ( substr( $color, 0, 1 ) == '#' ) {
		$color = substr( $color, 1 );
	}
	
	if ( strlen( $color ) == 6 ) {
		list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return false;
	}
	
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );
	
	return implode( ', ', array( $r, $g, $b ) );
}
endif;

if ( ! function_exists( 'mh_get_accent_color' ) ) :
function mh_get_accent_color() {
	$color = mh_get_option( 'accent_color', '#44cdcd' );
	if ( strpos( $color, "#" ) != false ) {
		$color = "#" . $color;
	}
	return $color;
}
endif;
/**
 * Sanitize short block html input
 * @return string
 */
function mh_sanitize_text_input( $string ) {
	return wp_kses( $string, mh_sanitize_text_input_allowed_html_elements() );
}

function mh_sanitize_text_input_allowed_html_elements() {
	$allowed_tags = array(
		'div' => array(
			'class' => array(),
			'id'    => array(),
		),
		'span' => array(
			'class' => array(),
			'id'    => array(),
		),
		'ol' => array(
			'class' => array(),
			'id'    => array(),
		),
		'ul' => array(
			'class' => array(),
			'id'    => array(),
		),
		'li' => array(
			'class' => array(),
			'id'    => array(),
		),
		'p' => array(
			'class' => array(),
			'id'    => array(),
		),
		'a' => array(
			'href'  	=> array(),
			'class' 	=> array(),
			'id'    	=> array(),
			'title' 	=> array(),
			'target'    => array(),
		),
		'br' => array(),
		'em' => array(),
		'strong' => array(),
	);

	return apply_filters( 'mh_sanitize_text_input_allowed_html_elements', $allowed_tags );
}



if ( ! function_exists( 'mh_wp_kses' ) ) :
function mh_wp_kses( $string ) {
	return apply_filters( 'mh_wp_kses', wp_kses( $string, mh_wp_kses_allowed_html_elements() ) );
}
endif;


if ( ! function_exists( 'mh_allow_ampersand' ) ) :
/**
 * Convert &amp; into &
 * Escaped ampersand by wp_kses() which is used by mh_wp_kses()
 * can be a troublesome in some cases, ie.: outputted string is sent as email
 * @param string  original string
 * @return string modified string
 */
function mh_allow_ampersand( $string ) {
	return str_replace('&amp;', '&', $string);
}
endif;


if ( ! function_exists( 'mh_wp_kses_allowed_html_elements' ) ) :
	function mh_wp_kses_allowed_html_elements() {
		$whitelisted_attributes = array(
			'id'    => array(),
			'class' => array(),
			'style' => array(),
		);
		
		$whitelisted_attributes = apply_filters( 'mh_wp_kses_allowed_html_attributes', $whitelisted_attributes );

		$elements = array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
				'target' => array(),
				'rel'    => array(),
			),
			'b'      => array(),
			'em'     => array(),
			'p'      => array(),
			'br'     => array(),
			'span'   => array(),
			'div'    => array(),
			'strong' => array(),
		);
		
		$elements = apply_filters( 'mh_wp_kses_allowed_html_elements', $elements );

		foreach ( $elements as $tag => $attributes ) {
			$elements[ $tag ] = array_merge( $attributes, $whitelisted_attributes );
		}

		return $elements;
	}
endif;

if ( ! function_exists( 'mh_default_color_scheme' ) ) :
function mh_default_color_scheme($post_id = 0) {
	$default_scheme = array(
		'#000000',
		'#FFFFFF',
		'#E02B20',
		'#E09900',
		'#EDF000',
		'#7CDA24',
		'#0C71C3',
		'#8300E9',
	);

	$saved_scheme = mh_get_option( 'mharty_color_scheme' );

	$scheme = $saved_scheme && '' !== str_replace( '|', '', $saved_scheme ) ? explode( '|', $saved_scheme ) : $default_scheme;
	
	return apply_filters( 'mh_default_color_scheme', $scheme, $post_id );
}
endif;

if ( ! function_exists( 'mh_get_google_api_key' ) ) :
function mh_get_google_api_key() {
	$google_api_option = mh_get_option( 'mharty_google_maps_api_key', '' );

	return $google_api_option;
}
endif;