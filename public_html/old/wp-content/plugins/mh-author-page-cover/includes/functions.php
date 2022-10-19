<?php
// Enqueue scripts and styles
add_action( 'admin_enqueue_scripts', 'mh_author_pc_enqueue_scripts_styles' );
function mh_author_pc_enqueue_scripts_styles($hook) {
	if ( in_array( $hook, array( 'profile.php', 'user-new.php', 'user-edit.php' ) ) ) {
    // Register
    wp_register_style( 'mh-author-pc-admin-style', plugins_url( 'mh-author-page-cover/assets/css/admin.css' ), false, '1.0.0', 'all' );
    wp_register_script( 'mh-author-pc-admin-script', plugins_url( 'mh-author-page-cover/assets/js/admin.js' ), array('jquery'), '1.0.0', true );
    
    // Enqueue
    wp_enqueue_style( 'mh-author-pc-admin-style' );
    wp_enqueue_script( 'mh-author-pc-admin-script' );
	}
}

function mh_author_pc_append_options($options) {
//add to mharty panel options
$append_options = array(
	array( "name" => "wrap-mhauthorpc",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "mhauthorpc-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Author's Page Cover", "mh-author-page-cover")
			),
      	array( "type" => "subnavtab-end",),

		array( "name" => "mhauthorpc-1",
			   "type" => "subcontent-start",),	
  
	array( "name" => esc_html__("Display Author's Cover", "mh-author-page-cover"),
				   "id" => "mharty_enable_authors_cover",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => esc_html__("Disabling this option will remove the covers from your site.", "mh-author-page-cover")
			),
		array( "type" => "clearfix",),
		array( "name" => esc_html__("Author's Cover Style", "mh-author-page-cover"),
				   "id" => "mharty_authors_cover_style",
				   "type" => "select",
				   	"options" => array(
						'right'    => esc_html__( 'Side', 'mh-author-page-cover' ),
				   		'center'   => esc_html__( 'Centre', 'mh-author-page-cover' ),
				   	),
									   "std" => "right",
				   "desc" => esc_html__("Here you can choose the look of your website author's cover.", "mh-author-page-cover"),
				   'mh_save_values' => true,
		),
		array( "type" => "clearfix",),
		array( "name" => esc_html__("Display Author's Box After Posts", "mh-author-page-cover"),
				   "id" => "mharty_enable_authors_box",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => esc_html__("Disabling this option will remove the authors box from your site.", "mh-author-page-cover")
			),
		array( "name" => esc_html__("Display Author's social links", "mh-author-page-cover"),
				   "id" => "mharty_enable_authors_social",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => esc_html__("Disabling this option will remove the social links/icons on the author's cover and the author's box.", "mh-author-page-cover")
			),
			
array( "type" => "clearfix",),

		array( "name" => "mhauthorpc-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-mhauthorpc",
		   "type" => "contenttab-wrapend",),
		);
 
	// combine the two arrays
	$options = array_merge($options, $append_options);
 
	return $options;
}
add_filter('mh_defined_options', 'mh_author_pc_append_options', 12);

function mh_author_pc_append_tab($mh_panelMainTabs){
	$append_tab = array('mhauthorpc');
	$mh_panelMainTabs = array_merge($mh_panelMainTabs, $append_tab);
	return $mh_panelMainTabs;
}
add_filter('mh_panel_page_maintabs', 'mh_author_pc_append_tab', 12);

function mh_author_pc_append_list(){ ?>
	<li id="mh-nav-mhauthorpc"><a href="#wrap-mhauthorpc"><i class="mh-panel-nav-icon"></i><?php esc_html_e( "Author's Cover", "mh-author-page-cover" ); ?></a></li>
<?php }
add_action('mh_panel_render_maintabs', 'mh_author_pc_append_list', 12);

// Show the new image field in the user profile page.
add_action( 'show_user_profile', 'mh_author_pc_profile_img_fields' );
add_action( 'edit_user_profile', 'mh_author_pc_profile_img_fields' );

function mh_author_pc_profile_img_fields( $user ) {
    if(!current_user_can('upload_files'))
        return false;
    // vars
    $mh_author_pc_url = get_the_author_meta( 'mh_author_pc_meta', $user->ID );
    $mh_author_pc_upload_url = get_the_author_meta( 'mh_author_pc_upload_meta', $user->ID );
    $mh_author_pc_upload_edit_url = get_the_author_meta( 'mh_author_pc_upload_edit_meta', $user->ID );

    if(!$mh_author_pc_upload_url){
        $btn_text = esc_html__( 'Upload New Image', 'mh-author-page-cover');
    } else {
        $mh_author_pc_upload_edit_url = get_home_url() . get_the_author_meta( 'mh_author_pc_upload_edit_meta', $user->ID );
        $btn_text = esc_html__( 'Change Image', 'mh-author-page-cover');
    }
    ?>
    
    <div id="mh_author_pc_container">
    <h3><?php esc_html_e( "Author's Page Cover", "mh-author-page-cover"); ?></h3>
 
    <table class="form-table">
 
        <tr>
            <th><label for="mh_author_pc_meta"><?php esc_html_e( 'Choose Photo', 'mh-author-page-cover' ); ?></label></th>
            <td>
                <!-- Outputs the image after save -->
                <div id="current_img">
                    <?php if($mh_author_pc_upload_url): ?>
                        <img src="<?php echo esc_url( $mh_author_pc_upload_url ); ?>" class="mhauthorpc-current-img">
                        <div class="edit_options uploaded">
                            <a class="remove_img"><span><?php esc_html_e( 'Remove', 'mh-author-page-cover' ); ?></span></a>
                            <a href="<?php echo esc_url( $mh_author_pc_upload_edit_url ); ?>" class="edit_img" target="_blank"><span><?php esc_html_e( 'Edit', 'mh-author-page-cover' ); ?></span></a>
                        </div>
                    <?php elseif($mh_author_pc_url) : ?>
                        <img src="<?php echo esc_url( $mh_author_pc_url ); ?>" class="mhauthorpc-current-img">
                        <div class="edit_options single">
                            <a class="remove_img"><span><?php esc_html_e( 'Remove', 'mh-author-page-cover' ); ?><?php esc_html_e( 'Choose Photo', 'mh-author-page-cover' ); ?></span></a>
                        </div>
                    <?php else : ?>
                        <img src="<?php echo plugins_url( 'mh-author-page-cover/assets/img/placeholder.gif' ); ?>" class="mhauthorpc-current-img placeholder">
                    <?php endif; ?>
                </div>

                <!-- Select an option: Upload to WPMU or External URL -->
                <div id="mh_author_pc_options">
                    <input type="radio" id="upload_option" name="img_option" value="upload" class="tog" checked> 
                    <label for="upload_option"><?php esc_html_e( 'Upload New Image', 'mh-author-page-cover' ); ?></label><br>
                    <input type="radio" id="external_option" name="img_option" value="external" class="tog">
                    <label for="external_option"><?php esc_html_e( 'Use External URL', 'mh-author-page-cover' ); ?></label><br>
                </div>

                <!-- Hold the value here if this is a WPMU image -->
                <div id="mh_author_pc_upload">
                    <input type="hidden" name="mh_author_pc_placeholder_meta" id="mh_author_pc_placeholder_meta" value="<?php echo plugins_url( 'mh-author-page-cover/assets/img/placeholder.gif' ); ?>" class="hidden" />
                    <input type="hidden" name="mh_author_pc_upload_meta" id="mh_author_pc_upload_meta" value="<?php echo esc_url_raw( $mh_author_pc_upload_url ); ?>" class="hidden" />
                    <input type="hidden" name="mh_author_pc_upload_edit_meta" id="mh_author_pc_upload_edit_meta" value="<?php echo esc_url_raw( $mh_author_pc_upload_edit_url ); ?>" class="hidden" />
                    <input type='button' class="mh_author_pc_wpmu_button button-primary" value="<?php esc_html_e( $btn_text, 'mh-author-page-cover' ); ?>" id="uploadimage"/><br />
                </div>  
                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <div id="mh_author_pc_external">
                    <input type="text" name="mh_author_pc_meta" id="mh_author_pc_meta" value="<?php echo esc_url_raw( $mh_author_pc_url ); ?>" class="regular-text" />
                </div>
                <!-- Outputs the save button -->
                <br />
                <span class="description"><?php esc_html_e( 'Upload a photo for your page or use a URL to a pre-existing photo.', 'mh-author-page-cover' ); ?></span>
                <p class="description"><?php esc_html_e('Please Update Profile to save your changes.', 'mh-author-page-cover'); ?></p>
            </td>
        </tr>
 
    </table><!-- end form-table -->
</div> <!-- end #mh_author_pc_container -->

    <?php wp_enqueue_media(); // Enqueue the WordPress MEdia Uploader ?>

<?php }

// Save the new user mhauthorpc url.
add_action( 'personal_options_update', 'mh_author_pc_save_img_meta' );
add_action( 'edit_user_profile_update', 'mh_author_pc_save_img_meta' );

function mh_author_pc_save_img_meta( $user_id ) {

    if ( !current_user_can( 'upload_files', $user_id ) )
        return false;

    // If the current user can edit Users, allow this.
    update_user_meta( $user_id, 'mh_author_pc_meta', $_POST['mh_author_pc_meta'] );
    update_user_meta( $user_id, 'mh_author_pc_upload_meta', $_POST['mh_author_pc_upload_meta'] );
    update_user_meta( $user_id, 'mh_author_pc_upload_edit_meta', $_POST['mh_author_pc_upload_edit_meta'] );
}

/**
 * Return an ID of an attachment by searching the database with the file URL.
 *
 * First checks to see if the $url is pointing to a file that exists in
 * the wp-content directory. If so, then we search the database for a
 * partial match consisting of the remaining path AFTER the wp-content
 * directory. Finally, if a match is found the attachment ID will be
 * returned.
 *
 * http://frankiejarrett.com/get-an-attachment-id-by-url-in-wordpress/
 *
 * @return {int} $attachment
 */
function get_attachment_image_by_url( $url ) {
 
    // Split the $url into two parts with the wp-content directory as the separator.
    $parse_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );
 
    // Get the host of the current site and the host of the $url, ignoring www.
    $this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
    $file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
 
    // Return nothing if there aren't any $url parts or if the current host and $url host do not match.
    if ( !isset( $parse_url[1] ) || empty( $parse_url[1] ) || ( $this_host != $file_host ) ) {
        return;
    }
 
    // Now we're going to quickly search the DB for any attachment GUID with a partial path match.
    // Example: /uploads/2013/05/test-image.jpg
    global $wpdb;
 
    $prefix     = $wpdb->prefix;
    $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $prefix . "posts WHERE guid RLIKE %s;", $parse_url[1] ) );
    
    // Returns null if no attachment is found.
    return $attachment[0];
}

/**
 * Retrieve the appropriate image size
 *
 * @param $user_id    Default: $post->post_author. Will accept any valid user ID passed into this parameter.
 * @param $size       Default: 'thumbnail'. Accepts all default WordPress sizes and any custom sizes made by the add_image_size() function.
 * @return {url}      Use this inside the src attribute of an image tag or where you need to call the image url.
 */
function get_mh_author_pc_meta( $user_id, $size ) {

    //allow the user to specify the image size
    if (!$size){
        $size = 'thumbnail'; // Default image size if not specified.
    }
	$post = ''; //check this/  to fix PHP Notice and to allow upload by admin instead of user
    if(!$user_id){
        $user_id = $post->post_author;
    }
    
    // get the custom uploaded image
    $attachment_upload_url = esc_url( get_the_author_meta( 'mh_author_pc_upload_meta', $user_id ) );
    
    // get the external image
    $attachment_ext_url = esc_url( get_the_author_meta( 'mh_author_pc_meta', $user_id ) );
    $attachment_url = '';
    $image_url = '';
    if($attachment_upload_url){
        $attachment_url = $attachment_upload_url;
        
        // grabs the id from the URL using Frankie Jarretts function
        $attachment_id = get_attachment_image_by_url( $attachment_url );
     
        // retrieve the thumbnail size of our image
        $image_thumb = wp_get_attachment_image_src( $attachment_id, $size );
        $image_url = $image_thumb[0];

    } elseif($attachment_ext_url) {
        $image_url = $attachment_ext_url;
    }

    if ( empty($image_url) )
        return;

    // return the image thumbnail
    return $image_url;
}
function mh_author_page_cover_scripts() {
		$ltr = is_rtl() ? "" : "-ltr";
        wp_enqueue_style( 'mh_author_page_cover', MH_AUTHOR_PC_URL . 'assets/css/style'. $ltr .'.css', array(), MH_AUTHOR_PC_VER );
    }
add_action( 'wp_enqueue_scripts', 'mh_author_page_cover_scripts' );

function mh_author_page_cover_author_profile(){ 
if ('on' === mh_get_option('mharty_enable_authors_cover', 'on')){
// Retrieve The Post's Author ID
    $user_id = get_the_author_meta('ID');
    // Set the image size. Accepts all registered images sizes and array(int, int)
    $size = 'full';

    // Get the image URL using the author ID and image size params
    $imgURL = get_mh_author_pc_meta($user_id, $size);
	$styleclass = ' mh-cover-'. mh_get_option('mharty_authors_cover_style', 'right');
?>

<section class="mh-author-page-cover <?php echo $styleclass; if (!'' == $imgURL ){echo ' mh-profile-img';}?>">
  <div class="author-header" 
  <?php if (!'' == $imgURL ){ echo'style="background-image:url(' . $imgURL . ');"';}?>>
    <div class="author-header-inner"></div>
      <?php if (' mh-cover-right' == $styleclass ) echo '<div class="container">'?>
    <div class="author-header-avatar">
    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
	<?php echo get_avatar( get_the_author_meta('email'), '110' ); ?> </a>
     </div> <!-- .author-header-avatar -->
    <div class="author-header-content">
      <h1 class="author-name">
	        <?php if( get_the_author_meta('user_url') ){
				echo '<a target="_blank" href="' . esc_url( get_the_author_meta('user_url') ) .'">' . get_the_author_meta('display_name') . '</a>';
			}else{
				echo get_the_author_meta('display_name');
			}?></h1>
            <?php if ('on' === mh_get_option('mharty_enable_authors_social', 'on')){ ?>
            <div class="author-social-icons">
     <?php if( get_the_author_meta('twitter') ){
$au_tw = '<a href="' . esc_url( get_the_author_meta('twitter') ) . '" class="mh-author-net twitter" title="Twitter" target="_blank"><i class="icon"></i></a>'; echo $au_tw;}?>
<?php if( get_the_author_meta('facebook') ){
$au_fc = '<a href="' .esc_url( get_the_author_meta('facebook') ) . '"class="mh-author-net facebook"  title="Facebook" target="_blank"><i class="icon"></i></a>'; echo $au_fc;}?>
<?php if( get_the_author_meta('googleplus') ){
$au_gp = '<a href="' . esc_url( get_the_author_meta('googleplus') ) . '"class="mh-author-net google-plus" title="Google+" target="_blank"><i class="icon"></i></a>'; echo $au_gp;}?>
<?php if( get_the_author_meta('youtube') ){
$au_yt = '<a href="' . esc_url( get_the_author_meta('youtube') ) . '"class="mh-author-net youtube" title="Youtube" target="_blank"><i class="icon"></i></a>'; echo $au_yt;}?>
<?php if( get_the_author_meta('instagram') ){
$au_ins = '<a href="' . esc_url( get_the_author_meta('instagram') ) . '" class="mh-author-net instagram" title="Instagram" target="_blank"><i class="icon"></i></a>'; echo $au_ins;}?>
<?php if( get_the_author_meta('snapchat') ){
$au_sc = '<a href="' . esc_url( get_the_author_meta('snapchat') ) . '" class="mh-author-net snapchat" title="Snapchat" target="_blank"><i class="icon"></i></a>'; echo $au_sc;}?>
<?php if( get_the_author_meta('pinterest') ){
$au_sc = '<a href="' . esc_url( get_the_author_meta('pinterest') ) . '" class="mh-author-net pinterest" title="Pinterest" target="_blank"><i class="icon"></i></a>'; echo $au_sc;}?>
<?php if( get_the_author_meta('dribbble') ){
$au_ins = '<a href="' . esc_url( get_the_author_meta('dribbble') ) . '" class="mh-author-net dribbble" title="dribbble" target="_blank"><i class="icon"></i></a>'; echo $au_ins;}?>
<?php if( get_the_author_meta('behance') ){
$au_ins = '<a href="' . esc_url( get_the_author_meta('behance') ) . '" class="mh-author-net behance" title="behance" target="_blank"><i class="icon"></i></a>'; echo $au_ins;}?>
<?php if( get_the_author_meta('linkedin') ){
$au_ld = '<a href="' . esc_url( get_the_author_meta('linkedin') ) . '"class="mh-author-net linkedin"  title="Linkedin" target="_blank"><i class="icon"></i></a>'; echo $au_ld;}?>
<?php if( get_the_author_meta('flickr') ){
$au_fl = '<a href="' . esc_url( get_the_author_meta('flickr') ) . '"class="mh-author-net flickr" title="Flickr" target="_blank"><i class="icon"></i></a>'; echo $au_fl;}?>   
        </div> <!--author-social-icons-->
        <?php } ?>
<div class="author-bio"><?php the_author_meta('description'); ?></div>
    </div> <!-- .author-header-content --> 
    <?php if (' mh-cover-right' == $styleclass ) echo '</div>'?>
  </div> <!-- .author-header -->
</section> <!--end .mh-author-page-cover-->

<?php
} 
}
add_action( 'mh_author_profile', 'mh_author_page_cover_author_profile' );

if ( ! function_exists( 'mh_author_page_cover_author_box' ) ) :
function mh_author_page_cover_author_box(){ 
	if ( is_attachment() ) return;
	if ('on' === mh_get_option('mharty_enable_authors_box', 'on')){
		?>
<div class="mh-author-box-cover clearfix">
  <div class="author-header">
    <div class="author-header-inner"></div>
    <div class="author-header-avatar">
    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
	<?php echo get_avatar( get_the_author_meta('email'), '80' ); ?> </a>
     </div> <!-- .author-header-avatar -->
    <div class="author-header-content">
    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
      <h4 class="author-name"><?php echo get_the_author_meta('display_name'); ?></h4></a>
<div class="author-bio"><?php the_author_meta('description'); ?></div>
            <?php if ('on' === mh_get_option('mharty_enable_authors_social', 'on')){ ?>
 <div class="author-social-icons">
     <?php if( get_the_author_meta('twitter') ){
$au_tw = '<a href="' . esc_url( get_the_author_meta('twitter') ) . '" class="mh-author-net twitter" title="Twitter" target="_blank"><i class="icon"></i></a>'; echo $au_tw;}?>
<?php if( get_the_author_meta('facebook') ){
$au_fc = '<a href="' . esc_url( get_the_author_meta('facebook') ) . '"class="mh-author-net facebook"  title="Facebook" target="_blank"><i class="icon"></i></a>'; echo $au_fc;}?>
<?php if( get_the_author_meta('googleplus') ){
$au_gp = '<a href="' . esc_url( get_the_author_meta('googleplus') ) . '"class="mh-author-net google-plus" title="Google+" target="_blank"><i class="icon"></i></a>'; echo $au_gp;}?>
<?php if( get_the_author_meta('youtube') ){
$au_yt = '<a href="' . esc_url( get_the_author_meta('youtube') ) . '"class="mh-author-net youtube" title="Youtube" target="_blank"><i class="icon"></i></a>'; echo $au_yt;}?>
<?php if( get_the_author_meta('instagram') ){
$au_ins = '<a href="' . get_the_author_meta('instagram') . '" class="mh-author-net instagram" title="Instagram" target="_blank"><i class="icon"></i></a>'; echo $au_ins;}?>
<?php if( get_the_author_meta('snapchat') ){
$au_sc = '<a href="' . esc_url( get_the_author_meta('snapchat') ) . '" class="mh-author-net snapchat" title="Snapchat" target="_blank"><i class="icon"></i></a>'; echo $au_sc;}?>
<?php if( get_the_author_meta('dribbble') ){
$au_ins = '<a href="' . esc_url( get_the_author_meta('dribbble') ) . '" class="mh-author-net dribbble" title="dribbble" target="_blank"><i class="icon"></i></a>'; echo $au_ins;}?>
<?php if( get_the_author_meta('behance') ){
$au_ins = '<a href="' . esc_url( get_the_author_meta('behance') ) . '" class="mh-author-net behance" title="behance" target="_blank"><i class="icon"></i></a>'; echo $au_ins;}?>
<?php if( get_the_author_meta('linkedin') ){
$au_ld = '<a href="' . esc_url( get_the_author_meta('linkedin') ) . '"class="mh-author-net linkedin"  title="Linkedin" target="_blank"><i class="icon"></i></a>'; echo $au_ld;}?>
<?php if( get_the_author_meta('flickr') ){
$au_fl = '<a href="' . esc_url( get_the_author_meta('flickr') ) . '"class="mh-author-net flickr" title="Flickr" target="_blank"><i class="icon"></i></a>'; echo $au_fl;}?>   
        </div> <!--author-social-icons-->
        <?php } ?>
    </div> <!-- .author-header-content --> 
  </div> <!-- .item-header -->
</div> <!--end .mh-author-box-cover-->
<?php
	}
}
endif;
add_action( 'mh_after_post', 'mh_author_page_cover_author_box', 10); 