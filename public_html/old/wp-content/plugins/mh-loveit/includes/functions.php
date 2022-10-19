<?php
//enqueue scripts
add_action( 'wp_enqueue_scripts', 'mh_loveit_enqueue_scripts_styles' );
function mh_loveit_enqueue_scripts_styles() {
	$ltr = is_rtl() ? '' : '-ltr';
	wp_enqueue_style( 'mh-loveit-css', plugins_url( 'mh-loveit/assets/css/style'. $ltr .'.css' ), false, MH_LOVEIT_VER, 'all' );
}

function mh_loveit_enqueue_admin_inline_css() {
	echo '<style>.mhc-all-modules .mhc_display_social_media_share,.mhc_saved_layouts_list .mhc_display_social_media_share{background-color:transparent; opacity:1;}</style>';
}
add_action('admin_head', 'mh_loveit_enqueue_admin_inline_css');

//append option to mharty panel options
function mh_loveit_append_options($options) {
	if (is_rtl()):
		$position = array(
			'right'  => esc_html__( 'Right', 'mh-loveit' ),
			'left'   => esc_html__( 'Left', 'mh-loveit' )
		);
	else: 
		$position = array(
			'left'   => esc_html__( 'Left', 'mh-loveit' ),
			'right'    => esc_html__( 'Right', 'mh-loveit' )
		);
	endif;

	$append_options = array(
		array(  "name" => "wrap-mhloveit",
				"type" => "contenttab-wrapstart",),
		
		array( "type" => "subnavtab-start",),
		
		array( "name" => "mhloveit-1",
			   "type" => "subnav-tab",
			   "desc" => esc_html__("Options", "mh-loveit")
		),
		array( "name" => "mhloveit-2",
			   "type" => "subnav-tab",
			   "desc" => esc_html__("Networks", "mh-loveit")
		),
		array( "type" => "subnavtab-end",),
		
		array( "name" => "mhloveit-1",
			   "type" => "subcontent-start",),
			   
		array(  "title" => esc_html__("Like Icon", "mh-loveit" ),
				"type" => "header"),
		array( "name" => esc_html__("Show Likes on Archives", "mh-loveit"),
			   "id" => "mharty_archive_show_loveit",
			   "type" => "checkbox",
			   "std" => "off",
			   "desc" => esc_html__("Choose here if you want to show the icon for this type of pages.", "mh-loveit"),),			
		array( "name" => esc_html__("Show Likes on Posts", "mh-loveit"),
			   "id" => "mharty_show_loveit",
			   "type" => "checkbox",
			   "std" => "off",
			   "desc" => esc_html__("Choose here if you want to show the icon for this type of pages.", "mh-loveit"),),
		array( "name" => esc_html__("Show Likes on Projects", "mh-loveit"),
			   "id" => "mharty_project_show_loveit",
			   "type" => "checkbox",
			   "std" => "off",
			   "desc" => esc_html__("Choose here if you want to show the icon for this type of pages.", "mh-loveit"),),
			   
		array(  "title" => esc_html__("Floating Share Buttons", "mh-loveit" ),
				"type" => "header"),
		array(
			"name" => esc_html__("Floating Share Buttons on Homepage", "mh-loveit"),
			"id" => "mharty_float_share_home",
			"type" => "checkbox",
			"std" => "off",
			"desc" => esc_html__("Choose here if you want to show the floating share buttons on homepage.", "mh-loveit"),),
		array(
			"name" => esc_html__("Floating Share Buttons on Pages", "mh-loveit"),
			"id" => "mharty_float_share_page",
			"type" => "checkbox",
			"std" => "off",
			"desc" => esc_html__("Choose here if you want to show the floating share buttons on this type of pages.", "mh-loveit"),),
		array(
			"name" => esc_html__("Floating Share Buttons on Posts", "mh-loveit"),
			"id" => "mharty_float_share_post",
			"type" => "checkbox",
			"std" => "off",
			"desc" => esc_html__("Choose here if you want to show the floating share buttons on this type of pages.", "mh-loveit"),),
		array(
			"name" => esc_html__("Floating Share Buttons on Projects", "mh-loveit"),
			"id" => "mharty_float_share_projects",
			"type" => "checkbox",
			"std" => "off",
			"desc" => esc_html__("Choose here if you want to show the floating share buttons on this type of pages.", "mh-loveit"),),
		array(
			"name" => esc_html__("Floating Share Buttons on Products", "mh-loveit"),
			"id" => "mharty_float_share_products",
			"type" => "checkbox",
			"std" => "off",
			"desc" => esc_html__("Choose here if you want to show the floating share buttons on this type of pages.", "mh-loveit"),),
		array(
			"name" => esc_html__("Hide on Small Devices", "mh-loveit"),
			"id" => "mharty_float_share_mobile",
			"type" => "checkbox",
			"std" => "on",
			"desc" => esc_html__("This option hides the share buttons on small devices.", "mh-loveit"),),
		array( "type" => "clearfix",),
		array(  "title" => esc_html__("After Post Share Buttons", "mh-loveit" ),
				"type" => "header"),
		array(
			"name" => esc_html__("Share Buttons After Posts", "mh-loveit"),
			"id" => "mharty_show_share_post",
			"type" => "checkbox",
			"std" => "off",
			"desc" => esc_html__("Enable this option to display the share buttons after your posts.", "mh-loveit"),),
		array(
			"name" => esc_html__("Share Buttons After Projects", "mh-loveit"),
			"id" => "mharty_show_share_project",
			"type" => "checkbox",
			"std" => "off",
			"desc" => esc_html__("Enable this option to display the share buttons after your projects.", "mh-loveit"),),
		array( "type" => "clearfix",),
		array( 
			"name" => esc_html__("Share Buttons Type", "mh-loveit"),
			"id" => "mharty_show_share_type",
			"type" => "select",
			"options" => array(
				'title'    => esc_html__( 'Title and icon', 'mh-loveit' ),
				'icon_xl'   => esc_html__( 'Only icon - large', 'mh-loveit' ),
				'icon'   => esc_html__( 'Only icon - small', 'mh-loveit' ),
				'hover'    => esc_html__( 'Share icon', 'mh-loveit' ),),
			"std" => "title",
			"desc" => esc_html__("Here you can choose the type for your share buttons.", "mh-loveit"),
			'mh_save_values' => true,),
		array(
			"name" => esc_html__("Hide on Small Devices", "mh-loveit"),
			"id" => "mharty_show_share_mobile",
			"type" => "checkbox",
			"std" => "on",
			"desc" => esc_html__("This option hides the share buttons on small devices.", "mh-loveit"),),	
		array( "type" => "clearfix",),
		array(  "title" => esc_html__("Style and Colour", "mh-loveit" ),
				"type" => "header"),			
		array( "name" => esc_html__("Share Buttons Style", "mh-loveit"),
			"id" => "mharty_share_style",
			"type" => "select",
			"options" => array(
			'border'    => esc_html__( 'Bordered', 'mh-loveit' ),
			'solid'   => esc_html__( 'Solid', 'mh-loveit' ),),
			"std" => "border",
			"desc" => esc_html__("Here you can choose the style for your share buttons.", "mh-loveit"),
			'mh_save_values' => true,),
		array( "name" => esc_html__("Share Buttons Colour", "mh-loveit"),
			"id" => "mharty_share_color",
			"type" => "select",
			"options" => array(
			'accent'    => esc_html__( 'Accent colour', 'mh-loveit' ),
			'default'   => esc_html__( 'Default colours', 'mh-loveit' ),),
			"std" => "accent",
			"desc" => esc_html__("Here you can choose the colour for your share buttons.", "mh-loveit"),
			'mh_save_values' => true,),
        array( "name" => esc_html__("Share Buttons Columns", "mh-loveit"),
			"id" => "mharty_share_column",
			"type" => "select",
			"options" => array(
			'three'    => esc_html__( 'Three', 'mh-loveit' ),
			'four'   => esc_html__( 'Four', 'mh-loveit' ),),
			"std" => "three",
			"desc" => esc_html__("Here you can choose how many share buttons per row.", "mh-loveit"),
			'mh_save_values' => true,),
		array(  "title" => esc_html__("Select and Tweet", "mh-loveit" ),
				"type" => "header"),
		array(
			"name" => esc_html__("Show Select and Tweet", "mh-loveit"),
			"id" => "mharty_show_selecttweet",
			"type" => "checkbox",
			"std" => "off",
			"desc" => esc_html__("This option will enable Select and Tweet on your site.", "mh-loveit"),),

		array( "type" => "clearfix",),
		array( "name" => "mhloveit-1",
			   "type" => "subcontent-end",),
			   
		array( "name" => "mhloveit-2",
			   "type" => "subcontent-start",),
		array(  "title" => esc_html__("Choose the Networks", "mh-loveit" ),
				"type" => "header"),	   
		array( "name" => esc_html__("Share to Twitter", "mh-loveit" ),
                   "id" => "mharty_share_twitter",
                   "type" => "checkbox",
                   "std" => "on",
				   "desc" => esc_html__("Here you can choose to display this Share Icon on your website.", "mh-loveit"),),
		array( "name" => esc_html__("Share to Facebook", "mh-loveit" ),
                   "id" => "mharty_share_facebook",
                   "type" => "checkbox",
                   "std" => "on",
				   "desc" => esc_html__("Here you can choose to display this Share Icon on your website.", "mh-loveit"),),
		array( "name" => esc_html__("Share to Google+", "mh-loveit" ),
                   "id" => "mharty_share_googleplus",
                   "type" => "checkbox",
                   "std" => "on",
				   "desc" => esc_html__("Here you can choose to display this Share Icon on your website.", "mh-loveit"),),
		array( "name" => esc_html__("Share to Pinterest", "mh-loveit" ),
                   "id" => "mharty_share_pinterest",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display this Share Icon on your website.", "mh-loveit"),),
		array( "name" => esc_html__("Share to LinkedIn", "mh-loveit" ),
                   "id" => "mharty_share_linkedin",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display this Share Icon on your website.", "mh-loveit"),),
		array( "name" => esc_html__("Share to Gmail", "mh-loveit" ),
                   "id" => "mharty_share_gmail",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display this Share Icon on your website.", "mh-loveit"),),
		array( "name" => esc_html__("Share to Buffer", "mh-loveit" ),
                   "id" => "mharty_share_buffer",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display this Share Icon on your website.", "mh-loveit"),),
		array( "name" => esc_html__("Share to PrintFriendly", "mh-loveit" ),
                   "id" => "mharty_share_printfriendly",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display this Share Icon on your website.", "mh-loveit"),),
		array( "name" => esc_html__("Share to Yahoo Mail", "mh-loveit" ),
                   "id" => "mharty_share_yahoomail",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display this Share Icon on your website.", "mh-loveit"),),
		array( "name" => esc_html__("Share to Whatsapp", "mh-loveit" ),
                   "id" => "mharty_share_whatsapp",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("This button is only visable on small screens.", "mh-loveit"),),
		array( "name" => esc_html__("Share to Telegram", "mh-loveit" ),
                   "id" => "mharty_share_telegram",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("This button is only visable on small screens.", "mh-loveit"),),
		array( "type" => "clearfix",),
		array(  "title" => esc_html__("Change Network Text", "mh-loveit" ),
				"type" => "header"),	 
		array( "name" => esc_html__("Twitter Text", "mh-loveit"),
				   "id" => "mharty_share_twitter_t",
				   "type" => "text",
				   "std" => esc_html__("Twitter", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml"
			),
		array( "name" => esc_html__("Facebook Text", "mh-loveit"),
				   "id" => "mharty_share_facebook_t",
				   "type" => "text",
				   "std" => esc_html__("Facebook", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml",),
			array( "name" => esc_html__("Google+ Text", "mh-loveit"),
				   "id" => "mharty_share_googleplus_t",
				   "type" => "text",
				   "std" => esc_html__("Google+", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml",),
			array( "name" => esc_html__("Pinterest Text", "mh-loveit"),
				   "id" => "mharty_share_pinterest_t",
				   "type" => "text",
				   "std" => esc_html__("Pinterest", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml",),
			array( "name" => esc_html__("LinkedIn Text", "mh-loveit"),
				   "id" => "mharty_share_linkedin_t",
				   "type" => "text",
				   "std" => esc_html__("LinkedIn", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml",),
			array( "name" => esc_html__("Gmail Text", "mh-loveit"),
				   "id" => "mharty_share_gmail_t",
				   "type" => "text",
				   "std" => esc_html__("Gmail", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml",),
			array( "name" => esc_html__("Buffer Text", "mh-loveit"),
				   "id" => "mharty_share_buffer_t",
				   "type" => "text",
				   "std" => esc_html__("Buffer", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml",),
			array( "name" => esc_html__("PrintFriendly Text", "mh-loveit"),
				   "id" => "mharty_share_printfriendly_t",
				   "type" => "text",
				   "std" => esc_html__("PrintFriendly", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml",),
			array( "name" => esc_html__("Yahoo Mail Text", "mh-loveit"),
				   "id" => "mharty_share_yahoomail_t",
				   "type" => "text",
				   "std" => esc_html__("Yahoo Mail", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml",),
			array( "name" => esc_html__("Whatsapp Text", "mh-loveit"),
				   "id" => "mharty_share_whatsapp_t",
				   "type" => "text",
				   "std" => esc_html__("Whatsapp", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml",),
		array( "name" => esc_html__("Telegram Text", "mh-loveit"),
				   "id" => "mharty_share_telegram_t",
				   "type" => "text",
				   "std" => esc_html__("Telegram", "mh-loveit"),
				   "desc" => esc_html__("Here you can change the text appears on the share button for this network.", "mh-loveit"),
					"validation_type" => "nohtml",),
									 	   		   
			array( "name" => "mhloveit-2",
			   	"type" => "subcontent-end",),
			   
			array( "name" => "wrap-mhloveit",
		   		"type" => "contenttab-wrapend",),
	);
	// now merge the two arrays!
	$options = array_merge($options, $append_options);
 
	return $options;
}
add_filter('mh_defined_options', 'mh_loveit_append_options', 11);

// append tab to mharty panel
function mh_loveit_append_tab($mh_panelMainTabs){
	$append_tab = array('mhloveit');
	$mh_panelMainTabs = array_merge($mh_panelMainTabs, $append_tab);
	return $mh_panelMainTabs;
}
add_filter('mh_panel_page_maintabs', 'mh_loveit_append_tab', 11);

// append title to mharty panel
function mh_loveit_append_list(){?>
	<li id="mh-nav-mhloveit"><a href="#wrap-mhloveit"><i class="mh-panel-nav-icon"></i><?php esc_html_e( "Loveit", "mh-loveit" ); ?></a></li>
<?php }
add_action('mh_panel_render_maintabs', 'mh_loveit_append_list', 11);

add_action( 'mh_magazine_after_post', 'mh_post_loveit', 9); 
add_action( 'mh_archive_after_post', 'mh_post_loveit', 9); 
add_action( 'mh_author_after_post', 'mh_post_loveit', 9); 
add_action( 'mh_after_post_content', 'mh_post_loveit', 9);

// output like icon
if ( ! function_exists( 'mh_post_loveit' ) ) :
function mh_post_loveit() {
	if ( is_attachment() ) return;
	if((is_singular('post') && 'on' !== mh_get_option('mharty_show_loveit', 'off')) || ((is_archive() || is_home()) && 'on' !== mh_get_option('mharty_archive_show_loveit', 'off'))) return false;
	mh_loveit();
} 
endif;

add_shortcode( 'mhc_social_media_share', 'mhc_social_media_share' );
function mhc_social_media_share( $atts, $content = '' ) {
	extract( shortcode_atts( array(
			'module_class' => '',
			'style' => 'border',
			'type' => 'title',
			'color' => 'accent',
			'column' => '3'
			
		), $atts
	) );
	
	$title = (is_home() ? esc_attr( get_bloginfo( 'name' ) ) : esc_attr( get_the_title() ) );
	$url = (is_home() ? home_url( '/' ) :  esc_url( get_permalink() ) );
	$id = (is_home() ? 'homepage' : get_the_ID());
	$networks = '';
	$networks = sprintf('%s%s%s%s%s%s%s%s%s%s%s',
	
		('on' === mh_get_option('mharty_share_twitter', 'on') ? sprintf(
			'<li class="post_share_item twitter"><a data-post_id="%1$s" data-social_name="twitter" rel="nofollow" target="_blank" class="post_share_item_url" href="http://twitter.com/share?text=%3$s&amp;url=%2$s">
			<i class="network-icon mh-icon-before"></i>
			<span class="post_share_item_title">%4$s</span>
			</a></li>',
			$id,
			$url,
			$title,
			mh_get_option('mharty_share_twitter_t', esc_html__("Twitter", "mh-loveit"))			
		) : ''),
		
		('on' === mh_get_option('mharty_share_facebook', 'on') ? sprintf(
			'<li class="post_share_item facebook"><a data-post_id="%1$s" data-social_name="facebook" rel="nofollow" target="_blank" class="post_share_item_url" href="http://www.facebook.com/sharer.php?u=%2$s">
				<i class="network-icon mh-icon-before"></i>
				<span class="post_share_item_title">%3$s</span>
				</a></li>',
			$id,
			$url,
			mh_get_option('mharty_share_facebook_t', esc_html__("Facebook", "mh-loveit"))
		) : ''),
		
		('on' === mh_get_option('mharty_share_googleplus', 'on') ? sprintf(
			'<li class="post_share_item google google-plus"><a data-post_id="%1$s" data-social_name="googleplus" rel="nofollow" target="_blank" class="post_share_item_url" href="https://plus.google.com/share?url=%2$s">
					<i class="network-icon mh-icon-before"></i>
				<span class="post_share_item_title">%3$s</span>
			</a></li>',
			$id,
			$url,
			mh_get_option('mharty_share_googleplus_t', esc_html__("Google+", "mh-loveit"))
		) : ''),
		
		('on' === mh_get_option('mharty_share_pinterest', 'off') ? sprintf(
			'<li class="post_share_item pinterest"><a data-post_id="%1$s" data-social_name="pinterest" rel="nofollow" target="_blank" class="post_share_item_url" href="http://www.pinterest.com/pin/create/button/?url=%2$s&description=%3$s">
            <i class="network-icon mh-icon-before"></i>
        <span class="post_share_item_title">%4$s</span>
    </a></li>',
			$id,
			$url,
			$title,
			mh_get_option('mharty_share_pinterest_t', esc_html__("Pinterest", "mh-loveit"))
		) : ''),
		
		('on' === mh_get_option('mharty_share_linkedin', 'off') ? sprintf(
			'<li class="post_share_item linkedin"><a data-post_id="%1$s" data-social_name="linkedin" rel="nofollow" target="_blank" class="post_share_item_url" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=%2$s&amp;title=%3$s">
            <i class="network-icon mh-icon-before"></i>
        <span class="post_share_item_title">%4$s</span>
    </a></li>',
			$id,
			$url,
			$title,
			mh_get_option('mharty_share_linkedin_t', esc_html__("LinkedIn", "mh-loveit"))
		) : ''),
		
		('on' === mh_get_option('mharty_share_gmail', 'off') ? sprintf(
			'<li class="post_share_item google gmail"><a data-post_id="%1$s" data-social_name="gmail" rel="nofollow" target="_blank" class="post_share_item_url" href="https://mail.google.com/mail/u/0/?view=cm&amp;fs=1&amp;su=%3$s&amp;body=%2$s&amp;ui=2&amp;tf=1">
            <i class="network-icon mh-icon-before"></i>
        <span class="post_share_item_title">%4$s</span>
    </a></li>',
			$id,
			$url,
			$title,
			mh_get_option('mharty_share_gmail_t', esc_html__("Gmail", "mh-loveit"))
		) : ''),
		
		('on' === mh_get_option('mharty_share_buffer', 'off') ? sprintf(
			'<li class="post_share_item buffer"><a data-post_id="%1$s" data-social_name="buffer" rel="nofollow" target="_blank" class="post_share_item_url" href="https://bufferapp.com/add?url=%2$s&amp;title=%3$s">
            <i class="network-icon mh-icon-before"></i>
        <span class="post_share_item_title">%4$s</span>
    </a></li>',
			$id,
			$url,
			$title,
			mh_get_option('mharty_share_buffer_t', esc_html__("Buffer", "mh-loveit"))
		) : ''),
		
		('on' === mh_get_option('mharty_share_printfriendly', 'off') ? sprintf(
			'<li class="post_share_item printfriendly"><a data-post_id="%1$s" data-social_name="printfriendly" rel="nofollow" target="_blank" class="post_share_item_url" href="http://www.printfriendly.com/print?url=%2$s&title=%3$s">
            <i class="network-icon mh-icon-before"></i>
        <span class="post_share_item_title">%4$s</span>
    </a></li>',
			$id,
			$url,
			$title,
			mh_get_option('mharty_share_printfriendly_t', esc_html__("PrintFriendly", "mh-loveit"))
		) : ''),
		
		('on' === mh_get_option('mharty_share_yahoomail', 'off') ? sprintf(
			'<li class="post_share_item yahoomail"><a data-post_id="%1$s" data-social_name="yahoomail" rel="nofollow" target="_blank" class="post_share_item_url" href="http://compose.mail.yahoo.com/?body=%2$s">
            <i class="network-icon mh-icon-before"></i>
        <span class="post_share_item_title">%3$s</span>
    </a></li>',
			$id,
			$url,
			mh_get_option('mharty_share_yahoomail_t', esc_html__("Yahoo Mail", "mh-loveit"))
		) : ''),
		
		('on' === mh_get_option('mharty_share_whatsapp', 'off') ? sprintf(
			'<li class="post_share_item whatsapp"><a data-post_id="%1$s" data-social_name="whatsapp" rel="nofollow" target="_blank" class="post_share_item_url" href="whatsapp://send?text=%3$s - %2$s">
            <i class="network-icon mh-icon-before"></i>
        <span class="post_share_item_title">%4$s</span>
    </a></li>',
			$id,
			$url,
			$title,
			mh_get_option('mharty_share_whatsapp_t', esc_html__("Whatsapp", "mh-loveit"))
		) : ''),
						
		('on' === mh_get_option('mharty_share_telegram', 'off') ? sprintf(
			'<li class="post_share_item telegram"><a data-post_id="%1$s" data-social_name="telegram" rel="nofollow" target="_blank" class="post_share_item_url" href="https://t.me/share/url?url=%2$s">
            <i class="network-icon mh-icon-before"></i>
        <span class="post_share_item_title">%3$s</span>
    </a></li>',
			$id,
			$url,
			mh_get_option('mharty_share_telegram_t', esc_html__("Telegram", "mh-loveit"))
		) : '')
	
	);
	
    $class = " mh_share_type_{$type}";
	$output = sprintf(
		'<div class="mh_share"><ul class="%2$s%3$s%4$s%6$s%7$s">
		%5$s
		%1$s
		</ul></div>',
		$networks,
		('accent' === $color ? ' mh_share_accent' : ' mh_share_color'),
		('border' === $style ? ' mh_share_border': ' mh_share_solid'),
		('3' === $column ? ' post_share_3col' : ' post_share_4col'),
		('hover' === $type ? '<li class="post_share_btn mh_adjust_corners mh_adjust_bg"><i class="mhc-icon mhicons"></i></li>' : ''),
		( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
		$class
	);
	return $output;
}
// output float share icons
function mh_float_share(){
	$class = ('on' == mh_get_option('mharty_float_share_mobile', 'on') ? ' mh_share_mobile_hide' : '');
	$color = ('accent' === mh_get_option('mharty_share_color', 'accent') ? 'accent' : 'color');
	$style = ('border' === mh_get_option('mharty_share_style', 'border') ? 'border': 'solid');
		
	$output = printf('<div class="mh_share_float'.$class.'">%1$s</div>',
	do_shortcode('[mhc_social_media_share module_class="post_share_float" style="'.$style.'" type="hover" color="'.$color.'" column="3" /]')
	);
	return $output;
}

add_action('mh_before_end_container', 'mh_add_share_float', 10);
function mh_add_share_float() {
	if (is_singular('post') && 'on' == mh_get_option( 'mharty_float_share_post', 'off' )){
		mh_float_share();
	}elseif (is_singular('page') && 'on' == mh_get_option( 'mharty_float_share_page', 'off' )){
		mh_float_share();
	}elseif (is_singular('project') && 'on' == mh_get_option( 'mharty_float_share_projects', 'off' )){ 			
		mh_float_share();
	}elseif ( class_exists( 'woocommerce', false ) && is_product() && 'on' == mh_get_option( 'mharty_float_share_products', 'off' )){
		mh_float_share();
	}elseif ((is_home() || is_front_page()) && 'on' == mh_get_option( 'mharty_float_share_home', 'off' )) {
		mh_float_share();
	}
} 

// output footer share icons
function mh_post_share_footer() {
	$class = ('on' == mh_get_option('mharty_show_share_mobile', 'on') ? ' mh_share_mobile_hide' : '');
	$color = ('accent' === mh_get_option('mharty_share_color', 'accent') ? 'accent' : 'color');
	$style = ('border' === mh_get_option('mharty_share_style', 'border') ? 'border': 'solid');
	$column = ('three' === mh_get_option('mharty_share_column', 'three') ? '3' : '4');
	$type = mh_get_option('mharty_show_share_type', 'title');
		
	$icons = printf('<div class="mh_share_footer'.$class.'">%1$s</div>',
	do_shortcode('[mhc_social_media_share module_class="post_share_footer" style="'.$style.'" type="'.$type.'" color="'.$color.'" column="'.$column.'" /]')
	);
}


add_action( 'mh_after_post_content', 'mh_add_share_footer', 9);
add_action( 'mh_after_project_content', 'mh_add_share_footer', 9);
function mh_add_share_footer() {
	if ( is_attachment() ) return;
	if((is_singular('post') && 'on' !== mh_get_option( 'mharty_show_share_post', 'off' )) || (is_singular('project') && 'on' !== mh_get_option( 'mharty_show_share_project', 'off' ))) return;
	mh_post_share_footer();
}

function mh_loveit_body_class( $classes ) {
	if ('on' === mh_get_option( 'mharty_show_selecttweet', 'off' )){
		$classes[] = 'mh_selecttweet';
	}
	return $classes;
}
add_filter( 'body_class', 'mh_loveit_body_class' );

function mh_loveit_add_elements() {
	require dirname( __FILE__ ) . '/components.php';
}