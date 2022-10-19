<?php
// Prevent file from being loaded directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

//bbpress support
if( ! is_admin() ) {
    add_action('bbp_enqueue_scripts', 'mh_ex_bbpress_register_style',15);
}

function mh_ex_bbpress_register_style()
{
	global $bbp;

	wp_dequeue_style( 'bbp-default-bbpress' );
	wp_dequeue_style( 'bbp-default' );
	wp_dequeue_style( 'bbp-default-rtl' );
	wp_enqueue_style( 'mh-bbpress', get_template_directory_uri().'/bbpress/css/bbpress.min.css');

    if ( is_rtl() ) {
        add_action('mh_load_extra_styles', 'mh_ex_bbp_rtl_style');
    }
}

function mh_ex_bbp_rtl_style() {
    wp_enqueue_style( 'mh-bbpress-rtl', get_template_directory_uri().'/bbpress/css/bbpress-rtl.min.css');
}


function mh_ex_bbp_no_breadcrumb ($param) {
    return true;
}
add_filter ('bbp_no_breadcrumb', 'mh_ex_bbp_no_breadcrumb');

/*
 * Search in a single forum page
 */
function mh_bbp_filter_search_results( $r ){

    //Get the submitted forum ID (from the hidden field added in step 2)
    $forum_id = isset( $_GET['bbp_search_forum_id'] ) ? sanitize_title_for_query( $_GET['bbp_search_forum_id'] ) : false;

    //If the forum ID exits, filter the query
    if( $forum_id && is_numeric( $forum_id ) ){

        $r['meta_query'] = array(
            array(
                'key' => '_bbp_forum_id',
                'value' => $forum_id,
                'compare' => '=',
            )
        );

    }

    return $r;
}
add_filter( 'bbp_after_has_search_results_parse_args' , 'mh_bbp_filter_search_results' );

function mh_bbp_search_form(){
	if (true == get_option( '_bbp_allow_search')){
    ?>
    <div class="bbp-search-form">

        <?php bbp_get_template_part( 'form', 'search' ); ?>

    </div>
<?php
	}
}
add_action( 'bbp_template_before_single_forum', 'mh_bbp_search_form' );

/* Add class for author role */
function mh_ex_bbp_add_role_class( $author_role, $r ) {

    $reply_id    = bbp_get_reply_id( $r['reply_id'] );
    $role        = strtolower( esc_attr( bbp_get_user_display_role( bbp_get_reply_author_id( $reply_id ) ) ) );

    $author_role = str_replace('class="','class="role-' . $role . ' ', $author_role);

    return $author_role;

}
add_filter( 'bbp_get_reply_author_role' , 'mh_ex_bbp_add_role_class', 10, 2 );

//for later: add option to MH Panel to choose sidebar position
function mh_bbpress_sidebar_class( $classes ) {
	if(is_bbpress() && !is_archive()){
		if (is_rtl()){
		$classes[] ='mh_left_sidebar';
		}else{
		$classes[] = 'mh_right_sidebar';
		}
	}
	
		return $classes;
}
add_filter( 'body_class', 'mh_bbpress_sidebar_class' );