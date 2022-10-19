<?php
if ( ! isset( $content_width ) ) $content_width = 1080;

if ( is_admin() ) {
	require get_template_directory() . '/app/metabox.php';
}

function mh_setup_theme() {
	global $themename, $mh_store_options_in_one_row;
	$themename = 'mharty';
	$mh_store_options_in_one_row = true;

	$template_directory = get_template_directory();
	$theme_version = mh_get_theme_version();
	
	define( 'MHARTY_THEME', true );
	define( 'MHARTY_APP_VERSION', $theme_version );
	
	if ( is_admin() ) {
	require_once( $template_directory . '/app/app.php' );
	mh_app_setup( get_template_directory_uri() );
	}
	
	require_once( $template_directory . '/includes/functions/mh_functions.php' );
	require_once( $template_directory . '/includes/mh_menu/mh_menu.php' );
	require_once( $template_directory . '/includes/functions/mh_sidebars.php' );
	require_once( $template_directory . '/includes/mh_menu/wp-nav-custom-walker.php');
	require_once( $template_directory . '/includes/mh_panel/mh_panel.php' );
	require_once( $template_directory . '/includes/functions/mh_thumbnails.php' );
	include_once( $template_directory . '/includes/mh_customizer/mh_customizer.php' );
	include_once( $template_directory . '/includes/mh_customizer/customizer.php' );
	include_once( $template_directory . '/includes/mh_menu/mh_menu_icons.php' );
	require_once( $template_directory . '/includes/functions/mh_shortcodes.php' );
	
	if (is_admin()) {
		include_once( $template_directory . '/includes/mh_menu/mega-menu.php');
	}
	if (!is_admin()) {
		require_once($template_directory . '/includes/mh_menu/breadcrumb.php');
	}
	if ( is_admin() ) {
	require get_template_directory() . '/includes/metabox.php';
	}
	
	include( $template_directory . '/includes/widgets.php' );
	load_theme_textdomain( 'mharty', $template_directory . '/lang' );
	register_nav_menus( array(
		'primary-menu'	=> esc_html__( 'Primary Menu', 'mharty' ),
		'secondary-menu'  => esc_html__( 'Secondary Menu', 'mharty' ),
		'footer-menu'	 => esc_html__( 'Footer Menu', 'mharty' ),
		'app-menu'		=> esc_html__( 'App Menu', 'mharty' ),
	) );

	// don't display the empty title bar if the widget title is not set
	remove_filter( 'widget_title', 'mh_widget_force_title' );
	
	remove_filter( 'body_class', 'mh_add_fullwidth_body_class' );
	//Theme supports
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-formats', array(
		'video', 'audio', 'quote', 'gallery', 'link'
	) );
	
	//Third party plugins
	add_theme_support( 'bbpress' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	

	//bbPress compatibility
	if ( class_exists( 'bbPress', false ) ) {
		require_once( $template_directory . '/includes/plugins/mh_bbpress.php' );
	}

	add_filter( 'tiny_mce_before_init', 'mh_tinymce_fix_rtl' );
}
add_action( 'after_setup_theme', 'mh_setup_theme' );


//Woocommerce Support
if ( class_exists( 'WooCommerce', false ) ) {
	require_once( get_template_directory() . '/includes/plugins/mh_woocommerce.php' );
}
if ( ! function_exists( 'mh_tinymce_fix_rtl' ) ) {
	function mh_tinymce_fix_rtl( $settings ) {
		// This fix has to be applied to all editor instances for RTL Admin areas
		if ( is_rtl() && isset( $settings['plugins'] ) && ',directionality' == $settings['plugins'] ) {
			unset( $settings['plugins'] );
		}
		return $settings;
}
}
if ( ! function_exists( 'mh_tinymce_fontsize' ) ) {
	function mh_tinymce_fontsize( $buttons ) {
        array_shift( $buttons );
        array_unshift( $buttons, 'fontsizeselect');
        array_unshift( $buttons, 'formatselect');
        return $buttons;
	}
}
add_filter('mce_buttons_2', 'mh_tinymce_fontsize');
// Customize mce editor font sizes
if ( ! function_exists( 'mh_mce_text_sizes' ) ) {
	function mh_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "12px 14px 16px 18px 20px 22px 24px 26px 28px 30px 34px 38px 42px 52px 62px 72px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'mh_mce_text_sizes' );

function mh_add_home_link( $args ) {
	// add Home link to the custom menu WP-Admin page
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'mh_add_home_link' );

// which language for fonts
function mh_get_language_fonts() {
	$fonts_per_locale = array(
		'ar' => array(
			'language_name'   => 'Arabic',
			'google_font_url' => '//fonts.googleapis.com/earlyaccess/droidarabickufi.css',
			'h'     => "'Droid Arabic Kufi', Tahoma, Geneva, sans-serif",
			'body'  => "Tahoma, Geneva, sans-serif"
		),
	);

	return $fonts_per_locale;
}

function mh_get_default_fonts() {
	$default_fonts = array(
		'h' => array(
			'font_name'	   => 'Raleway',
			'google_font_url' => '//fonts.googleapis.com/css?family=Raleway:400,700',
			'font_family'     => "'Raleway', Helvetica, Arial, sans-serif"
		),
		'body' => array(
			'font_name'   => 'Open Sans',
			'google_font_url' => '//fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic',
			'font_family'     => "'Open Sans', Helvetica, Arial, sans-serif"
		),
	);

	return $default_fonts;
}


function mh_mharty_load_scripts_styles(){
	global $wp_styles;
	$getwplocal = get_bloginfo( 'language');
	$ar = $getwplocal == 'ar' ? '-ar' : '';
	$ltr = is_rtl() ? "" : "-ltr";
	$template_dir = get_template_directory_uri();
	$theme_version = mh_get_theme_version();
	$dependencies = array( 'jquery', 'mharty-touch-mobile' );

	// load 'jquery-effects-core' if app_menu is enabled
	if ( true === get_theme_mod( 'app_menu', false )) {
		$dependencies[] = 'jquery-effects-core';
	}
	//register script
	wp_register_script( 'mharty-fitvids', $template_dir . '/js/fitvids.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'waypoints', $template_dir . '/js/waypoints.min.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'magnific-popup', $template_dir . '/js/magnific-popup.min.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'hashchange', $template_dir . '/js/hashchange.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'imagesloaded', $template_dir . '/js/imagesloaded.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'jquery-masonry-3', $template_dir . '/js/masonry.js', array( 'jquery', 'imagesloaded' ), $theme_version, true );
	wp_register_script( 'easypiechart', $template_dir . '/js/easypiechart.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'jquery-nicescroll', $template_dir . '/js/nicescroll.min.js', array( 'jquery'), $theme_version, true );
	wp_register_script( 'flickity', $template_dir . '/js/flickity.min.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'js-cookie', $template_dir . '/js/js.cookie.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'mharty-maps', $template_dir . '/js/gmaps' . $ar .'.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'mharty-touch-mobile', $template_dir . '/js/jquery.mobile.custom.min.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'mharty-script', $template_dir . '/js/theme.min.js', $dependencies, $theme_version, true );
	
	// enqueue scripts
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script( 'mharty-fitvids');
	wp_enqueue_script( 'waypoints');
	wp_enqueue_script( 'magnific-popup');
	if ( true === get_theme_mod( 'enable_nicescroll', false )) {
		wp_enqueue_script( 'jquery-nicescroll');
	}
	wp_enqueue_script( 'mharty-touch-mobile');
	wp_enqueue_script( 'mharty-script');
	
	wp_localize_script( 'mharty-script', 'mh_theme', array(
		'ajaxurl'             => admin_url( 'admin-ajax.php' ),
		'images_uri'          => get_template_directory_uri() . '/images',
		'mh_script_nonce'     => wp_create_nonce( 'mh_script_nonce' ),
		'subscription_failed' => esc_html__( 'Please check the fields below to make sure you entered the correct information.', 'mharty' ),
		'fill'                => esc_html__( 'Fill', 'mharty' ),
		'field'               => esc_html__( 'field', 'mharty' ),
		'invalid'             => esc_html__( 'Invalid email', 'mharty' ),
		'captcha'             => esc_html__( 'Captcha', 'mharty' ),
		'prev'				=> esc_html__( 'Prev', 'mharty' ),
		'previous'            => esc_html__( 'Previous', 'mharty' ),
		'next'				=> esc_html__( 'Next', 'mharty' ),
		'fill_message'        => esc_html__( 'Please fill in the following fields:', 'mharty' ),
		'contact_error'  	   => esc_html__( 'Please fix the following errors:', 'mharty' ),
		'wrong_captcha'       => esc_html__( 'You entered the wrong number in captcha.', 'mharty' ),
		//magnificPopup translation
		'mp_close' => esc_html__( 'Close (Esc)', 'mharty' ),
		'mp_loading' => esc_html__( 'Loading...', 'mharty' ),
		'mp_prev' => esc_html__( 'Previous (Left arrow key)', 'mharty' ),
		'mp_next' => esc_html__( 'Next (Right arrow key)', 'mharty' ),
		'mp_counter' => esc_html__( '%curr% of %total%', 'mharty' ),
		'mp_error_image' => esc_html__( '<a href="%url%">The image</a> could not be loaded.', 'mharty' ),
		'mp_error_ajax' => esc_html__( '<a href="%url%">The content</a> could not be loaded.', 'mharty' ),
	) );
	
	wp_localize_script( 'mharty-maps', 'mh_theme_map', array(
	'google_api_key' => mh_get_google_api_key(),
	) );

	if ( 'on' === mh_get_option( 'mharty_smooth_scroll', false ) ) {
		wp_enqueue_script( 'smooth-scroll', $template_dir . '/js/smoothscroll.js', array( 'jquery' ), $theme_version, true );
	}
	if ('1' === get_theme_mod( 'show_promo_bar', '0') ){
		wp_enqueue_script( 'js-cookie');
	}

	$mh_gf_enqueue_fonts = array();
	$mh_gf_heading_font = sanitize_text_field( get_theme_mod( 'heading_font', 'none' ) );
	$mh_gf_body_font = sanitize_text_field( get_theme_mod( 'body_font', 'none' ) );
	$mh_language_fonts = mh_get_language_fonts();
	$mh_default_fonts = mh_get_default_fonts();
	$site_locale = get_locale();
	$protocol = is_ssl() ? 'https:' : 'http:';
	if ( 'none' != $mh_gf_heading_font ) $mh_gf_enqueue_fonts[] = $mh_gf_heading_font;
	if ( 'none' != $mh_gf_body_font ) $mh_gf_enqueue_fonts[] = $mh_gf_body_font;
	
	if ( 'none' == $mh_gf_heading_font){
		if ( isset( $mh_language_fonts[$site_locale] )) {
			$mh_gf_font_name_slug = strtolower( str_replace( ' ', '-', $mh_language_fonts[$site_locale]['language_name'] ) );
			wp_enqueue_style( 'mh-gf-' . $mh_gf_font_name_slug, esc_url_raw($protocol . $mh_language_fonts[$site_locale]['google_font_url']), array(), null );
		}else{
			$mh_gf_font_name_slug = strtolower( str_replace( ' ', '-', $mh_default_fonts['h']['font_name'] ) );
			wp_enqueue_style( 'mh-gf-' . $mh_gf_font_name_slug, esc_url_raw($protocol . $mh_default_fonts['h']['google_font_url']), array(), null );
		}	
	}
	if ( 'none' == $mh_gf_body_font){
		if ( !isset( $mh_language_fonts[$site_locale] )) {	
			$mh_gf_font_name_slug = strtolower( str_replace( ' ', '-', $mh_default_fonts['body']['font_name'] ) );
			wp_enqueue_style( 'mh-gf-' . $mh_gf_font_name_slug, esc_url_raw($protocol . $mh_default_fonts['body']['google_font_url']), array(), null );
		}	
	}

	if ( ! empty( $mh_gf_enqueue_fonts ) ) mh_gf_enqueue_fonts( $mh_gf_enqueue_fonts );

	/*
	 * Loads the main stylesheet.
	 */
		wp_register_style( 'mharty-maps', $template_dir . '/css/gmaps.min.css', array(), $theme_version );
		wp_enqueue_style( 'mharty-style', $template_dir . '/css/style'. $ltr . '.min.css', array(), $theme_version );
		wp_enqueue_style( 'mharty-header', $template_dir . '/css/header'. $ltr . '.min.css', array(), $theme_version );
		//decalre child theme style
		if (is_child_theme()) {
			wp_enqueue_style( 'mharty-child', get_stylesheet_directory_uri() . '/style.css', array(), $theme_version );
		}
		// hook extra styles to this if needed
		do_action('mh_load_extra_styles');
}
add_action( 'wp_enqueue_scripts', 'mh_mharty_load_scripts_styles' );
                    
function mh_add_viewport_meta(){
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />';
}
add_action( 'wp_head', 'mh_add_viewport_meta' );

/**
 * For backward compatibility we manually add <title> tag in head
 * Title tag is automatically added for WordPress 4.1 & above via theme support
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) :
	function mh_add_title_tag_before_4_4_compat() { ?>
		<title><?php wp_title(); ?></title>
<?php }
	add_action( 'wp_head', 'mh_add_title_tag_before_4_4_compat' );
endif;

if ( ! function_exists( 'mh_list_pings' ) ) :
function mh_list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
<?php }
endif;

if ( ! function_exists( 'mh_get_theme_version' ) ) :
function mh_get_theme_version() {
	$theme_info = wp_get_theme();

	if ( is_child_theme() ) {
		$theme_info = wp_get_theme( $theme_info->parent_theme );
	}

	$theme_version = $theme_info->display( 'Version' );

	return $theme_version;
}
endif;

if ( ! function_exists( 'mh_composer_is_active' ) ) :
function mh_composer_is_active( $page_id ) {
	return ( 'on' === get_post_meta( $page_id, '_mhc_use_composer', true ) );
}
endif;

if ( ! function_exists( 'mh_get_the_author_avatar' ) ) :
function mh_get_the_author_avatar($size = false){
	global $authordata;

	$link = sprintf(
		'<a class="mh_author_avatar_40" href="%1$s">%2$s</a>',
		esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
		get_avatar( get_the_author_meta('email'), $size )
	);
	return apply_filters( 'the_author_posts_link', $link );
}
endif;

if ( ! function_exists( 'mh_get_the_author_posts_link' ) ) :
function mh_get_the_author_posts_link(){
	global $authordata;

	$link = sprintf(
		'<a class="mh_author_link" href="%1$s" title="%2$s" rel="author">%3$s</a>',
		esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
		esc_attr( sprintf( __( 'Posts by %s', 'mharty' ), get_the_author() ) ),
		get_the_author()
	);
	return apply_filters( 'the_author_posts_link', $link );
}
endif;

if ( ! function_exists( 'mh_get_comments_popup_link' ) ) :
function mh_get_comments_popup_link( $zero = false, $one = false, $more = false ){

	$id = get_the_ID();
	$number = get_comments_number( $id );

	if ( 0 == $number && !comments_open() && !pings_open() ) return;

	if ( $number > 1 )
		$output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', 'mharty') : $more);
	elseif ( $number == 0 )
		$output = ( false === $zero ) ? __('0 Comments', 'mharty') : $zero;
	else // must be one
		$output = ( false === $one ) ? __('1 Comment', 'mharty') : $one;

	return '<span class="comments-number">' . '<a href="' . esc_url( get_permalink() . '#respond' ) . '">' . apply_filters('comments_number', esc_html( $output ), esc_html( $number ) ) . '</a>' . '</span>';
}
endif;

if ( ! function_exists( 'mh_get_post_info_sep' ) ) :
function mh_get_post_info_sep(){
		$postinfosep =  esc_html( mh_get_option( 'mharty_postinfo_sep', ' | ' ) );
        return $postinfosep;
}
endif;

if ( ! function_exists( 'mh_get_post_author_pre' ) ) :
function mh_get_post_author_pre(){
		$postinfopre =  esc_html( mh_get_option( 'mharty_postinfo_pre' ) );
        return $postinfopre;
}
endif;

if ( ! function_exists( 'mh_after_post_title' ) ) :
function mh_after_post_title(){
	do_action('mh_add_after_post_title');
}
endif;

if ( ! function_exists( 'mh_postinfo_meta' ) ) :
function mh_postinfo_meta( $postinfo, $date_format, $comment_zero, $comment_one, $comment_more){
	$postinfostyle = mh_get_option('mharty_postinfo1_style' );
	$postinfo_meta = '';

	if ( in_array( 'avatar', $postinfo ) )
		$postinfo_meta .=  mh_get_the_author_avatar('40');
		
	if ('on' === $postinfostyle){
		$postinfo_meta .= '<div class="post-meta-inline">';
	}
	if ( in_array( 'author', $postinfo ) )
		$postinfo_meta .= ' ' . mh_get_post_author_pre() . ' ' . mh_get_the_author_posts_link();
	if ('on' === $postinfostyle){
		$postinfo_meta .= '<p>';
	}
	if ( in_array( 'date', $postinfo ) ) {
if ( in_array( 'author', $postinfo ) && 'on' !== $postinfostyle){
		$postinfo_meta .= mh_get_post_info_sep();
}
		$postinfo_meta .= esc_html( get_the_time( wp_unslash( $date_format ) ) );
	}
	if ( in_array( 'categories', $postinfo ) && is_singular( 'post' ) ){
		$categories_list = sprintf( '%1$s', is_rtl() ? get_the_category_list('، ') : get_the_category_list(', ') );
		// do not output anything if no categories retrieved
		if ( '' !== $categories_list ) {
			if ( (in_array( 'author', $postinfo ) && 'on' !== $postinfostyle) || in_array( 'date', $postinfo ) ) 
			$postinfo_meta .= mh_get_post_info_sep();
			
			$postinfo_meta .= $categories_list;
		}
	}

	if ( in_array( 'comments', $postinfo ) ){
		if ( in_array( 'author', $postinfo ) || in_array( 'date', $postinfo ) || in_array( 'categories', $postinfo ) ) 			
		$postinfo_meta .= mh_get_post_info_sep();
		$postinfo_meta .= mh_get_comments_popup_link( $comment_zero, $comment_one, $comment_more );
	}
	
	if (function_exists('the_views')){
		if ( in_array( 'author', $postinfo ) || in_array( 'date', $postinfo ) || in_array( 'categories', $postinfo ) || in_array( 'comments', $postinfo ) ) $postinfo_meta .= mh_get_post_info_sep();
		$postinfo_meta .= '<span class="mhc_the_views">' . do_shortcode('[views]') . '</span>';
	}
	
	if ('on' === $postinfostyle){
			$postinfo_meta .= '</p></div>';
		}
	return $postinfo_meta;
}
endif;

if ( ! function_exists( 'mh_mharty_post_meta' ) ) :
function mh_mharty_post_meta() {
	$postinfo = is_single() ? mh_get_option( 'mharty_postinfo2' ) : mh_get_option( 'mharty_postinfo1' );
	$postinfostyle =  mh_get_option('mharty_postinfo1_style' );
	$date = '' !== mh_get_option( 'mharty_date_format') ? mh_get_option( 'mharty_date_format', 'd/m/Y' ): 'd/m/Y';
	if ( $postinfo ) :
		$output = sprintf( '<div class="post-meta%2$s">%1$s</div>',
			mh_postinfo_meta( $postinfo, $date , esc_html__( '0 comments', 'mharty' ), esc_html__( '1 comment', 'mharty' ), '% ' . esc_html__( 'comments', 'mharty' ) ),
			('on' === $postinfostyle ? ' post-meta-alt' : '')
			
		);
		echo $output;
	endif;
}
endif;

if ( ! function_exists( 'mhc_portfolio_meta_box' ) ) :
function mhc_portfolio_meta_box() { ?>
	<div class="mh_project_meta">
  		<?php if(function_exists('mh_loveit') && 'on' === mh_get_option( 'mharty_project_show_loveit', 'on' )) mh_loveit(); ?>
		
		<?php 
		$mh_project_tag_title = ( '' !== mh_get_option('mharty_project_tag_title', '') ? esc_html( mh_get_option('mharty_project_tag_title') ) : esc_html__('Skills', 'mharty' ));
		echo get_the_term_list( get_the_ID(), 'project_tag', '<p><strong class="mh_project_meta_title">' . $mh_project_tag_title .'</strong>', mh_wp_kses( _x( ' ,', 'This is a comma preceded by a space.', 'mharty') ), '</p>'); ?>

		<strong class="mh_project_meta_title"><?php echo esc_html__( 'Posted on', 'mharty' ); ?></strong>
		<p><?php echo get_the_date(); ?></p>
	</div>
<?php }
endif;

/**
 * Extract and return the first blockquote from content.
 */
if ( ! function_exists( 'mh_get_blockquote_in_content' ) ) :
function mh_get_blockquote_in_content() {
	global $more;
	$more_default = $more;
	$more = 1;

	remove_filter( 'the_content', 'mh_remove_blockquote_from_content' );

	$content = apply_filters( 'the_content', get_the_content() );

	add_filter( 'the_content', 'mh_remove_blockquote_from_content' );

	$more = $more_default;

	if ( preg_match( '/<blockquote>(.+?)<\/blockquote>/is', $content, $matches ) ) {
		return $matches[0];
	} else {
		return false;
	}
		if ( preg_match( '/<blockquote>(.+?)<\/blockquote>/is', $content, $matches ) ) {
		return $matches[0];
	} else {
		return false;
	}
}
endif;

function mh_remove_blockquote_from_content( $content ) {
	if ( 'quote' !== get_post_format() ) {
		return $content;
	}

	$content = preg_replace( '/<blockquote>(.+?)<\/blockquote>/is', '', $content, 1 );

	return $content;
}
add_filter( 'the_content', 'mh_remove_blockquote_from_content' );

if ( ! function_exists( 'mh_get_link_url' ) ) :
function mh_get_link_url() {
	if ( '' !== ( $link_url = get_post_meta( get_the_ID(), '_format_link_title', true ) ) ) {
		return $link_url;
	}

	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}
endif;

if ( ! function_exists( 'mh_get_first_video' ) ) :
function mh_get_first_video( $content = '' ) {
	$content = ! empty( $content ) ? $content : get_the_content();
	$first_url    = '';
	$first_video  = '';
	$video_width  = (int) apply_filters( 'mh_blog_video_width', 1080 );
	$video_height = (int) apply_filters( 'mh_blog_video_height', 630 );

	$i = 0;

	preg_match_all( '|^\s*https?://[^\s"]+\s*$|im', $content, $urls );

	foreach ( $urls[0] as $url ) {
		$i++;

		if ( 1 === $i ) {
			$first_url = trim( $url );
		}

		$oembed = wp_oembed_get( esc_url( $url ) );

		if ( !$oembed ) {
			continue;
		}

		$first_video = $oembed;
		$first_video = preg_replace( '/<embed /', '<embed wmode="transparent" ', $first_video );
		$first_video = preg_replace( '/<\/object>/','<param name="wmode" value="transparent" /></object>', $first_video );

		break;
	}

	if ( '' === $first_video ) {

		if ( ! has_shortcode( $content, 'video' ) && ! empty( $first_url ) ) {
			$video_shortcode = sprintf( '[video src="%1$s" /]', esc_attr( $first_url ) );
			$content = str_replace( $first_url, $video_shortcode, $content );
		}

		if ( has_shortcode( $content, 'video' ) ) {
			$regex = get_shortcode_regex();
			preg_match( "/{$regex}/s", $content, $match );

			$first_video = preg_replace( "/width=\"[0-9]*\"/", "width=\"{$video_width}\"", $match[0] );
			$first_video = preg_replace( "/height=\"[0-9]*\"/", "height=\"{$video_height}\"", $first_video );

			add_filter( 'the_content', 'mh_delete_post_video' );

			$first_video = do_shortcode( mhc_fix_shortcodes( $first_video ) );
		}
	}

	return ( '' !== $first_video ) ? $first_video : false;
}
endif;

if ( ! function_exists( 'mh_delete_post_video' ) ) :
function mh_delete_post_video( $content ) {
	if ( has_post_format( 'video' ) ) :
		$regex = get_shortcode_regex();
		preg_match_all( "/{$regex}/s", $content, $matches );

		// $matches[2] holds an array of shortcodes names in the post
		foreach ( $matches[2] as $key => $shortcode_match ) {
			if ( 'video' === $shortcode_match ) {
				$content = str_replace( $matches[0][$key], '', $content );
				if ( is_single() && is_main_query() ) {
					break;
				}
			}
		}
	endif;

	return $content;
}
endif;

if ( ! function_exists( 'mh_delete_post_first_video' ) ) :
function mh_delete_post_first_video( $content ) {
	if ( 'video' === mh_post_format() && false !== ( $first_video = mh_get_first_video() ) ) {
		preg_match_all( '|^\s*https?:\/\/[^\s"]+\s*|im', $content, $urls );

		if ( ! empty( $urls[0] ) ) {
			$content = str_replace( $urls[0], '', $content );
		}
	}

	return $content;
}
endif;


function mh_video_embed_html( $video ) {
	if ( is_single() && 'video' === mh_post_format() ) {
		static $post_video_num = 0;

		$post_video_num++;

		// Hide first video in the post content on single video post page
		if ( 1 === $post_video_num ) {
			return '';
		}
	}

	return "<div class='mh_post_video'>{$video}</div>";
}

function mh_do_video_embed_html(){
	add_filter( 'embed_oembed_html', 'mh_video_embed_html' );
}
add_action( 'mh_before_post_content', 'mh_do_video_embed_html' );

/**
 * Do not dublicate galleries shortcode on single pages.
 */
function mh_delete_post_gallery( $content ) {
	if ( is_single() && is_main_query() && has_post_format( 'gallery' ) ) :
		$regex = get_shortcode_regex();
		preg_match_all( "/{$regex}/s", $content, $matches );

		// $matches[2] holds an array of shortcodes names in the post
		foreach ( $matches[2] as $key => $shortcode_match ) {
			if ( 'gallery' === $shortcode_match )
				$content = str_replace( $matches[0][$key], '', $content );
		}
	endif;

	return $content;
}
add_filter( 'the_content', 'mh_delete_post_gallery' );

if ( ! function_exists( 'mh_gallery_images' ) ) :
function mh_gallery_images() {
	$output = $images_ids = '';

	if ( function_exists( 'get_post_galleries' ) ) {
		$galleries = get_post_galleries( get_the_ID(), false );

		if ( empty( $galleries ) ) return false;

		foreach ( $galleries as $gallery ) {
			// Grabs all attachments ids from one or multiple galleries in the post
			$images_ids .= ( '' !== $images_ids ? ',' : '' ) . $gallery['ids'];
		}

		$attachments_ids = explode( ',', $images_ids );
		// Removes duplicate attachments ids
		$attachments_ids = array_unique( $attachments_ids );
	} else {
		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", get_the_content(), $match );
		$atts = shortcode_parse_atts( $match[3] );

		if ( isset( $atts['ids'] ) )
			$attachments_ids = explode( ',', $atts['ids'] );
		else
			return false;
	}

	$slides = '';

	foreach ( $attachments_ids as $attachment_id ) {
		$attachment_attributes = wp_get_attachment_image_src( $attachment_id, 'mhc-post-main-image-fullwidth' );
		$attachment_image = ! is_single() ? $attachment_attributes[0] : wp_get_attachment_image( $attachment_id, 'mhc-portfolio-image' );

		if ( ! is_single() ) {
			$slides .= sprintf(
				'<div class="mhc_slide" style="background: url(%1$s);"></div>',
				esc_attr( $attachment_image )
			);
		} else {
			$full_image = wp_get_attachment_image_src( $attachment_id, 'full' );
			$full_image_url = $full_image[0];
			$attachment = get_post( $attachment_id );

			$slides .= sprintf(
				'<li class="mh_gallery_item mhc_gallery_image">
					<a href="%1$s" title="%3$s">
						<span class="mh_portfolio_image">
							%2$s
							<span class="mh_overlay"></span>
						</span>
					</a>
				</li>',
				esc_url( $full_image_url ),
				$attachment_image,
				esc_attr( $attachment->post_title )
			);
		}
	}

	if ( ! is_single() ) {
		$output =
			'<div class="mhc_slider mhc_slider_fullwidth_off">
				<div class="mhc_slides">
					%1$s
				</div>
			</div>';
	} else {
		$output =
			'<ul class="mh_post_gallery clearfix">
				%1$s
			</ul>';
	}

	printf( $output, $slides );
}
endif;

if ( !( defined( 'MHARTY_COMPOSER' ) && MHARTY_COMPOSER ) && ! function_exists( 'mhc_fix_shortcodes' )){
	function mhc_fix_shortcodes( $content ){
		$replace_tags_from_to = array (
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']',
			"<br />\n[" => '[',
		);

		return strtr( $content, $replace_tags_from_to );
	}
}

function mh_mharty_post_admin_scripts_styles( $hook ) {
	global $typenow;
	
	$theme_version = mh_get_theme_version();

	if ( ! in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) return;

	if ( ! isset( $typenow ) ) return;

	if ( in_array( $typenow, array( 'post' ) ) ) {
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'mh-admin-post-script', get_template_directory_uri() . '/js/admin_post_settings.js', array( 'jquery', 'wp-color-picker' ), $theme_version, true  );
	}
	if ( in_array( $typenow, array( 'page' ) ) ) {
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'mh-admin-post-script', get_template_directory_uri() . '/js/admin_page_settings.js', array( 'jquery', 'wp-color-picker' ), $theme_version, true );
	}
	wp_localize_script( 'mh-admin-post-script', 'mh_admin_settigs', array(
		'default_color_scheme'                    => implode( '|', mh_default_color_scheme() ),
	));
}
add_action( 'admin_enqueue_scripts', 'mh_mharty_post_admin_scripts_styles' );

function mh_password_form() {
	$pwbox_id = rand();

	$form_output = sprintf(
		'<div class="mh_password_protected_form">
			<h1>%1$s</h1>
			<p>%2$s:</p>
			<form action="%3$s" method="post">
				<p><label for="%4$s">%5$s: </label><input name="post_password" id="%4$s" type="password" size="20" maxlength="20" /></p>
				<p><button type="submit" class="mh_submit_button">%6$s</button></p>
			</form
		</div>',
		esc_html__( 'Password Protected', 'mharty' ),
		esc_html__( 'To view this protected post, enter the password below', 'mharty' ),
		esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ),
		esc_attr( 'pwbox-' . $pwbox_id ),
		esc_html__( 'Password', 'mharty' ),
		esc_html__( 'Submit', 'mharty' )
	);

	$output = sprintf(
		'<div class="mhc_section mh_section_regular">
			<div class="mhc_row">
				<div class="mhc_column mhc_column_4_4">
					%1$s
				</div>
			</div>
		</div>',
		$form_output
	);

	return $output;
}
add_filter( 'the_password_form', 'mh_password_form' );

function mh_add_wp_version( $classes ) {
	global $wp_version;

	// add 'mh-wp-pre-3_8' class if the current WordPress version is less than 3.8
	if ( version_compare( $wp_version, '3.7.2', '<=' ) ) {
		if ( 'body_class' === current_filter() )
			$classes[] = 'mh-wp-pre-3_8';
		else
			$classes = 'mh-wp-pre-3_8';
	} else {
		if ( 'admin_body_class' === current_filter() )
			$classes = 'mh-wp-after-3_8';
	}

	return $classes;
}
add_filter( 'body_class', 'mh_add_wp_version' );
add_filter( 'admin_body_class', 'mh_add_wp_version' );

function mh_layout_body_class( $classes ) {
	if ( true === get_theme_mod( 'enable_nicescroll', false )) {
		$classes[] = 'mh_nicescroll';
	}
	if ( '1' === get_theme_mod( 'vertical_nav', '0' )) {
		$classes[] = 'mh_vertical_nav';
	} else if (true === get_theme_mod( 'fixed_nav', true ) &&  !is_page_template( 'page-template-trans.php' )) {
		$classes[] = 'mh_fixed_nav';
	}
	if ( '0' === get_theme_mod( 'vertical_nav', '0' )) {
		$classes[] = 'mh_horizontal_nav';
	}

	if ( '1' === get_theme_mod( 'boxed_layout', '0') ) {
		$classes[] = 'mh_boxed_layout';
	}

	if ( '1' === get_theme_mod( 'site_width', '0') ) {
		$classes[] = 'mh_w7_9_5';
	}
	if ('1' === get_theme_mod( 'secondary_nav_position', '0') || is_page_template( 'page-template-trans.php' )){
		$classes[] = 'mh_secondary_nav_above';
	}
	
	if ( true === get_theme_mod( 'hide_nav_menu', false )) {
		$classes[] = 'mh_hide_menu';
	}
	if ( true === get_theme_mod( 'app_menu', false )) {
		
		if ('side' === get_theme_mod( 'app_style', 'side')) {
			$classes[] = 'mh_app_menu mh_app_nav_left';
		}elseif('overlay' === get_theme_mod( 'app_style', 'side')){
			$classes[] = 'mh_app_menu mh_app_nav_overlay';
		}
	}
	
	if ( true === get_theme_mod( 'cover_background', true ) ) {
		$classes[] = 'mh_cover_background';
	}

	$mh_secondary_nav_items = mh_mharty_get_top_nav_items();

	if ( $mh_secondary_nav_items->top_info_defined ) {
		$classes[] = 'mh_secondary_nav_enabled';
	}

	if ( $mh_secondary_nav_items->two_info_panels ) {
		$classes[] = 'mh_secondary_nav_two_panels';
	}

	if ( $mh_secondary_nav_items->secondary_nav && ! ( $mh_secondary_nav_items->contact_info_defined || $mh_secondary_nav_items->show_header_social_icons )) {
		$classes[] = 'mh_secondary_nav_only_menu';
	}
	if ( 'right' !== ( $header_style = get_theme_mod( 'header_style', 'right' ) ) ) {
		$classes[] = esc_attr( "mh_header_style_{$header_style}" );
	}
	if ( 'right' !== ( $footer_style = get_theme_mod( 'footer_style', 'right' ) ) ) {
		$classes[] = esc_attr( "mh_footer_style_{$footer_style}" );
	}
	if ( 'only' !== ( $icons_style = get_theme_mod( 'icons_style', 'only' ) ) ) {
		$classes[] = esc_attr( "mh_icons_{$icons_style}" );
	}
	if ( 'square' !== ( $round_style = get_theme_mod( 'round_style', 'square' ) ) ) {
		$classes[] = esc_attr( "mh_{$round_style}_corners" );
	}
	if ( 'none' !== ( $sidebar_titles = get_theme_mod( 'sidebar_titles', 'none' ) ) ) {
		$classes[] = esc_attr( "mh_widget_title_style_{$sidebar_titles}" );
	}

	if ( stristr( $_SERVER['HTTP_USER_AGENT'],"mac") ) {
		$classes[] = 'osx';
	} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"linux") ) {
		$classes[] = 'linux';
	} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"windows") ) {
		$classes[] = 'windows';
	}
	
	if ( 'on' === mh_get_option( 'mharty_show_quick_contact', 'off')) {
		$classes[] = 'mh_quick_form_active';
	}
	if(is_page_template( 'page-template-trans.php' )){
		$classes[] = 'mh_transparent_header';
	}
	if ( false === get_theme_mod( 'header_padding', false )) {
		$classes[] = 'mh_header_padding';
	}else{
		$classes[] = 'mh_no_header_padding';
	}

	return $classes;
}
add_filter( 'body_class', 'mh_layout_body_class' );

function missing_mh_composer_notice() {
	if ( !( defined( 'MHARTY_COMPOSER' ) && MHARTY_COMPOSER )) echo '<div class="update-nag mhc-update-nag"><p>'. esc_html__( 'This theme works better with MH Page Composer plugin. Please activate it now.', 'mharty' ) . '</p></div>';

}
add_action( 'admin_notices', 'missing_mh_composer_notice' );

function mh_mharty_sidebar_class( $classes ) {
	
	if ( is_single() || is_page() || ( class_exists( 'woocommerce', false ) && is_product() ) )
	if (is_rtl()){
		$page_layout = '' !== ( $layout = get_post_meta( get_the_ID(), '_mhc_page_layout', true ) )
			? $layout
			: 'mh_left_sidebar';
	}else{
		$page_layout = '' !== ( $layout = get_post_meta( get_the_ID(), '_mhc_page_layout', true ) )
			? $layout
			: 'mh_right_sidebar';
	}

	if ( class_exists( 'woocommerce', false ) && ( is_shop() || is_product() || is_product_category() || is_product_tag() ) ) {
		if ( is_shop() || is_tax() )
				$classes[] = mh_get_option( 'mharty_shop_page_sidebar', is_rtl() ? 'mh_left_sidebar' :  'mh_right_sidebar' );
		if ( is_product() )
			$classes[] = $page_layout;
	}

	else if ( is_home() ) {
			$classes[] =  mh_get_option( 'mharty_index_page_sidebar', is_rtl() ? 'mh_left_sidebar' :  'mh_right_sidebar');
	}
	else if (is_archive() || is_search() || is_404()) {
			$classes[] = mh_get_option( 'mharty_archive_page_sidebar', is_rtl() ? 'mh_left_sidebar' :  'mh_right_sidebar' );
	}
	else if ( is_singular( 'project' ) ) {
		if ( 'mh_full_width_page' === $page_layout ){
			$page_layout = is_rtl() ? 'mh_left_sidebar mh_full_width_portfolio_page' : 'mh_right_sidebar mh_full_width_portfolio_page';
		}
		$classes[] = $page_layout;
	}
	else if ( is_single() || is_page() ) {
		$classes[] = $page_layout;
	}
	return $classes;
}
add_filter( 'body_class', 'mh_mharty_sidebar_class' );

if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
	function woocommerce_template_loop_product_thumbnail() {
		printf( '<span class="mh_shop_image">%1$s<span class="mh_overlay"></span></span>',
			woocommerce_get_product_thumbnail()
		);
	}
}

global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
	// Prevent Cache Warning From Being Displayed On First Install
	$current_theme_version[ mh_get_theme_version() ] = 'ignore' ;
	update_option( 'mhc_cache_notice', $current_theme_version );
}

if ( ! function_exists( 'mhc_get_audio_player' ) ){
	function mhc_get_audio_player(){
		$output = sprintf(
			'<div class="mh_audio_container">
				%1$s
			</div> <!-- .mh_audio_container -->',
			do_shortcode( '[audio]' )
		);

		return $output;
	}
}

if ( ! function_exists( 'mh_mharty_get_post_text_color' ) ) {
	function mh_mharty_get_post_text_color() {
		$text_color_class = '';

		$post_format = get_post_format();

		if ( in_array( $post_format, array( 'audio', 'link', 'quote' ) ) ) {
			$text_color_class = ( $text_color = get_post_meta( get_the_ID(), '_mh_post_bg_layout', true ) ) ? $text_color : 'light';
			$text_color_class = ' mhc_text_color_' . $text_color_class;
		}

		return $text_color_class;
	}
}

if ( ! function_exists( 'mh_mharty_get_post_quote_author' ) ) {
	function mh_mharty_get_post_quote_author() {
		$post_quote_author = '';

		$post_format = get_post_format();

		if ( in_array( $post_format, array( 'quote' ) ) ) {
			$post_quote_author = ( $quote_author = get_post_meta( get_the_ID(), '_mh_post_quote_author', true ) ) ? $quote_author : '';
			$post_quote_author = '<span class="quote-author">' . $post_quote_author .'</span>';
		}

		return $post_quote_author;
	}
}

if ( ! function_exists( 'mh_mharty_get_post_bg_inline_style' ) ) {
	function mh_mharty_get_post_bg_inline_style() {
		$inline_style = '';

		$post_id = get_the_ID();

		$post_use_bg_color = get_post_meta( $post_id, '_mh_post_use_bg_color', true )
			? true
			: false;
		$post_use_thumb_bg = get_post_meta( $post_id, '_mh_post_use_thumb_bg', true )
			? true
			: false;
		$post_bg_color  = ( $bg_color = get_post_meta( $post_id, '_mh_post_bg_color', true ) ) && '' !== $bg_color
			? $bg_color
			: '#ffffff';

	if ( has_post_thumbnail($post_id) ) {
 $post_bg_src = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'mhc-portfolio-image-single' );
	$post_bg_src_img =  $post_bg_src[0];
	}
		if ( $post_use_bg_color || $post_use_thumb_bg) {
			$inline_style = sprintf( ' style="%1$s%2$s"', 
			($post_use_bg_color ? sprintf('background-color: %1$s;', esc_html( $post_bg_color )) : ''),
			(has_post_thumbnail($post_id) && $post_use_thumb_bg ? sprintf('background-image:url(%1$s)',
			$post_bg_src_img) : '')
			
			 );
		}

		return $inline_style;
	}
}

if ( ! function_exists( 'mh_mharty_get_post_bg_inline_style' ) ) {
	function mh_mharty_get_post_bg_inline_style() {
		$inline_style = '';
		$post_id = get_the_ID();
		$post_use_bg_color = get_post_meta( $post_id, '_mh_post_use_bg_color', true )
			? true
			: false;
			$post_use_thumb_bg = get_post_meta( $post_id, '_mh_post_use_thumb_bg', true )
			? true
			: false;
		$post_bg_color  = ( $bg_color = get_post_meta( $post_id, '_mh_post_bg_color', true ) ) && '' !== $bg_color
			? $bg_color
			: '#ffffff';
	if ( has_post_thumbnail($post_id) ) {
 $post_bg_src = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'mhc-portfolio-image-single' );
	$post_bg_src_img =  $post_bg_src[0];
	}
		if ( $post_use_bg_color || $post_use_thumb_bg) {
			$inline_style = sprintf( ' style="%1$s%2$s"', 
			($post_use_bg_color ? sprintf('background-color: %1$s;', esc_html( $post_bg_color )) : ''),
			(has_post_thumbnail($post_id) && $post_use_thumb_bg ? sprintf('background-image:url(%1$s)',
			$post_bg_src_img) : '')
			
			 );
		}

		return $inline_style;
	}
}

/*
 * Displays post audio, quote and link post formats content
 */
if ( ! function_exists( 'mh_mharty_post_format_content' ) ){
	function mh_mharty_post_format_content(){
		$post_format = get_post_format();

		$text_color_class = mh_mharty_get_post_text_color();

		$inline_style = mh_mharty_get_post_bg_inline_style();

		switch ( $post_format ) {
			case 'audio' :
				printf(
					'<div class="mh_audio_content%4$s"%5$s>
						<h2><a href="%3$s">%1$s</a></h2>
						%2$s
					</div> <!-- .mh_audio_content -->',
					esc_html( get_the_title() ),
					mhc_get_audio_player(),
					esc_url( get_permalink() ),
					esc_attr( $text_color_class ),
					$inline_style
				);

				break;
			case 'quote' :
				printf(
					'<div class="mh_quote_content%4$s"%5$s>
						%1$s
						%6$s
						<a href="%2$s" class="mh_quote_main_link">%3$s</a>
					</div> <!-- .mh_quote_content -->',
					mh_get_blockquote_in_content(),
					esc_url( get_permalink() ),
					apply_filters( 'mh_read_more_text_filter', esc_html__( 'Read more', 'mharty' )),
					esc_attr( $text_color_class ),
					$inline_style,
					mh_mharty_get_post_quote_author()
				);

				break;
			case 'link' :
				printf(
					'<div class="mh_link_content%5$s"%6$s>
						<h2><a href="%2$s">%1$s</a></h2>
						<a href="%3$s" class="mh_link_main_url">%4$s</a>
					</div> <!-- .mh_link_content -->',
					esc_html( get_the_title() ),
					esc_url( get_permalink() ),
					esc_url( mh_get_link_url() ),
					esc_html( mh_get_link_url() ),
					esc_attr( $text_color_class ),
					$inline_style
				);

				break;
		}
	}
}

if ( ! function_exists( 'mhc_check_oembed_provider' ) ) {
	function mhc_check_oembed_provider( $url ) {
		require_once( ABSPATH . WPINC . '/class-oembed.php' );
		$oembed = _wp_oembed_get_object();
		return $oembed->get_provider( esc_url( $url ), array( 'discover' => false ) );
	}
}

/**
 * Add ltr class to admin body as we might need it to style some elements
 */
add_filter('admin_body_class', 'mh_add_admin_body_class');
function mh_add_admin_body_class($classes) {
	if(! is_rtl()){
        $classes = 'ltr';
	}
        return $classes;
}

/**
 * Fix to allow pagination in some components to work in non-hierarchical singular page.
 * WP_Query based components wouldn't work in non-hierarchical single post type page
 * due to canonical redirect to prevent page duplication which could lead to SEO penalty.
 * @todo Check applicable shortcodes
 */
function mh_modify_canonical_redirect( $redirect_url, $requested_url ) {
	global $post;
	$allowed_shortcodes              = array( 'mhc_blog', 'mhc_portfolio' );
	$is_overwrite_canonical_redirect = false;

	// Look for $allowed_shortcodes in content. Once detected, set $is_overwrite_canonical_redirect to true
	foreach ( $allowed_shortcodes as $shortcode ) {
		if ( !empty( $post ) && has_shortcode( $post->post_content, $shortcode ) ) {
			$is_overwrite_canonical_redirect = true;
			break;
		}
	}

	// Only alter canonical redirect if current page is singular, has paged and $allowed_shortcodes or current page is front_page, has page and $allowed_shortcodes
	if ( ( is_singular() & ! is_home() && get_query_var( 'paged' ) && $is_overwrite_canonical_redirect ) || ( is_front_page() && get_query_var( 'page' ) && $is_overwrite_canonical_redirect ) ) {
		return $requested_url;
	}

	return $redirect_url;
}
add_filter( 'redirect_canonical', 'mh_modify_canonical_redirect', 10, 2 );

//add open graph
if (!function_exists('add_opengraph')) {
	function add_opengraph() {
		global $post; // Ensures we can use post variables outside the loop
		$user_logo = '' !== get_theme_mod( 'mharty_og_logo' ) ? get_theme_mod( 'mharty_og_logo' ) : get_theme_mod( 'mharty_logo' );
		// Start with some values that don't change.
		echo "<meta property='og:site_name' content='". get_bloginfo('name') ."'/>"; // Sets the site name to the one in your WordPress settings
		echo "<meta property='og:url' content='" . get_permalink() . "'/>"; // Gets the permalink to the post/page

		if (is_singular()) { // If we are on a blog post/page
	        echo "<meta property='og:title' content='" . get_the_title() . "'/>"; // Gets the page title
	        echo "<meta property='og:type' content='article'/>"; // Sets the content type to be article.
	    } elseif(is_front_page() or is_home()) { // If it is the front page or home page
	    	echo "<meta property='og:title' content='" . get_bloginfo("name") . "'/>"; // Get the site title
	    	echo "<meta property='og:type' content='website'/>"; // Sets the content type to be website.
	    }

		if(has_post_thumbnail( $post->ID )) { // If the post has a featured image.
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
			echo "<meta property='og:image' content='" . esc_attr( $thumbnail[0] ) . "'/>"; // If it has a featured image, then display this for Facebook
		//if post doesn't have a featured image use the logo
		}elseif ('' != $user_logo){
			echo "<meta property='og:image' content='" . esc_url( $user_logo ) . "'/>";
		}

	}
}

$using_jetpack_publicize = ( class_exists( 'Jetpack' ) && in_array( 'publicize', Jetpack::get_active_modules()) ) ? true : false;

if ( !defined('WPSEO_VERSION') && !class_exists('NY_OG_Admin') && !class_exists('Wpsso') && $using_jetpack_publicize == false) {
	add_action( 'wp_head', 'add_opengraph', 5 );
}



//hook the updater!
add_action( 'after_setup_theme', 'mharty_theme_updates' );
function mharty_theme_updates(){
	$updater_args = array(
		'repo_uri'    => 'https://mharty.com/',
		'repo_slug'   => 'mhmharty',
		'key'       => esc_attr( mh_get_option( 'mharty_activate_email', '' ) ),
		'username'    => esc_attr( mh_get_option( 'mharty_activate_id', '' ) ),
	);
	add_theme_support( 'mharty-theme-updater', $updater_args );
}
//load last file.
require_once( trailingslashit( get_template_directory() ) . 'includes/mharty-updater.php' );
new Mharty_Theme_Updater;