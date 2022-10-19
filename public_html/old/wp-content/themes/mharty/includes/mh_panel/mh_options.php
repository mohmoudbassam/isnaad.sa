<?php
global $mh_panelMainTabs, $themename, $options;

$mh_panelMainTabs = array('general','layout', 'social', 'navigation', 'ad','seo','advanced');

$cats_array = get_categories('hide_empty=0');
$pages_array = get_pages('hide_empty=0');
$pages_number = count($pages_array);

$site_pages = array();
$site_cats = array();
$pages_ids = array();
$cats_ids = array();

foreach ($pages_array as $pagg) {
	$site_pages[$pagg->ID] = htmlspecialchars($pagg->post_title);
	$pages_ids[] = $pagg->ID;
}

foreach ($cats_array as $categs) {
	$site_cats[$categs->cat_ID] = $categs->cat_name;
	$cats_ids[] = $categs->cat_ID;
}

$themename 	= esc_html( $themename );
$pages_ids 	= array_map( 'intval', $pages_ids );
$cats_ids 	= array_map( 'intval', $cats_ids );

//sidebar options
if (is_rtl()){
	$sidebar_options = array(
		'mh_left_sidebar'    => esc_html__( 'Left Sidebar', 'mharty' ),
		'mh_right_sidebar'   => esc_html__( 'Right Sidebar', 'mharty' ),
		'mh_full_width_page' => esc_html__( 'Full-width', 'mharty' ),
	);
}else{
	$sidebar_options = array(
		'mh_right_sidebar'   => esc_html__( 'Right Sidebar', 'mharty' ),
		'mh_left_sidebar'    => esc_html__( 'Left Sidebar', 'mharty' ),
		'mh_full_width_page' => esc_html__( 'Full-width', 'mharty' ),
	);
}

$options = array (

	array( "name" => "wrap-general",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "general-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("General", "mharty")),

		array( "type" => "subnavtab-end",),

		array( "name" => "general-1",
			   "type" => "subcontent-start",),
			   
		   array( "name" => esc_html__("Mharty Activation ID", "mharty"),
			   "id" => $themename."_activate_id",
			   "std" => "",
			   "type" => "text",
			   "validation_type" => "nohtml",
			   "desc" => mh_wp_kses( sprintf( __('Enter your ID here. You will find your ID in Your Profile section. <a href="%1$s" target="_blank">Click here</a>', 'mharty' ), 'https://mharty.com/member/login')),
				 ),
				 
			array( "name" => esc_html__("Mharty Activation Email", "mharty"),
			   "id" => $themename."_activate_email",
			   "std" => "",
			   "type" => "text",
			   "validation_type" => "nohtml",
			   "desc" => esc_html__("Enter your email. This should be the email registered at mharty.com", "mharty" )
			),
			
			array( "name"         => esc_html__( "Colour Scheme", "mharty" ),
				   "id"           => $themename . "_color_scheme",
				   "type"         => "mh_color_scheme",
				   "items_amount" => 8,
				   "std"          => '#000000|#CCCCCC|#E02B20|#E09900|#EDF000|#7CDA24|#0C71C3|#8300E9',
				   "desc"         => esc_html__( "Define the default colour scheme for colour pickers for easy access.", "mharty" ),
			),

			array( "type" => "clearfix",),
			
			array( "name" => esc_html__("Enable Breadcrumbs", "mharty"),
				   "id" => $themename."_enable_breadcrmbs",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("This option will show a breadcrumb in your site.", "mharty")
			),
			
			array( 	"name" => esc_html__( "Home Page Layout", "mharty" ),
				   	"id" => $themename . "_index_page_sidebar",
				   	"type" => "select",
				   	"options" => $sidebar_options,
				   	"std" => is_rtl() ? 'mh_left_sidebar' : 'mh_right_sidebar',
				   	"desc" => esc_html__( "Here you can choose Home Page Layout. This option will only work if you have the default homepage on your site.", "mharty" ),
				   	'mh_save_values' => true,
			),
				array( 	"name" => esc_html__( "Archive Pages Layout", "mharty" ),
				   	"id" => $themename . "_archive_page_sidebar",
				   	"type" => "select",
				   	"options" => $sidebar_options,
				   	"std" => is_rtl() ? 'mh_left_sidebar' : 'mh_right_sidebar',
				   	"desc" => esc_html__( "Here you can choose Archive Pages Layout such as Categories, tags, search pages etc", "mharty" ),
				   	'mh_save_values' => true,
			),
			array( 	"name" => esc_html__( "Archive Pages Style", "mharty" ),
				   	"id" => $themename . "_archive_page_style",
				   	"type" => "select",
				   	"options" => array(
					'fullwidth' 	=> esc_html__( 'Default', 'mharty' ),
					'grid'		 => esc_html__( 'Grid', 'mharty' ),
					'horizontal'   => esc_html__( 'Horizontal', 'mharty' ),
					),
				   	"std" => 'fullwidth',
				   	"desc" => esc_html__( "Here you can choose Archive Pages Style such as Categories, tags, search pages etc", "mharty" ),
				   	'mh_save_values' => true,
			),
			array( "name" => esc_html__("Number of Posts displayed on Category page", "mharty"),
				   "id" => $themename."_catnum_posts",
				   "std" => "6",
				   "type" => "text",
				   "desc" => esc_html__("Here you can designate how many recent articles are displayed on the Category page. This option works independently from the Settings > Reading options in wp-admin.", "mharty"),
				   "validation_type" => "number"
			),

			array( "name" => esc_html__("Number of Posts displayed on Archive pages", "mharty"),
				   "id" => $themename."_archivenum_posts",
				   "std" => "5",
				   "type" => "text",
				   "desc" => esc_html__("Here you can designate how many recent articles are displayed on the Archive pages. This option works independently from the Settings > Reading options in wp-admin.", "mharty"),
				   "validation_type" => "number"
			),

			array( "name" => esc_html__("Number of Posts displayed on Search pages", "mharty"),
				   "id" => $themename."_searchnum_posts",
				   "std" => "5",
				   "type" => "text",
				   "desc" => esc_html__("Here you can designate how many recent articles are displayed on the Search results pages. This option works independently from the Settings > Reading options in wp-admin.", "mharty"),
				   "validation_type" => "number"
			),

			array( "name" => esc_html__("Number of Posts displayed on Tag pages", "mharty"),
				   "id" => $themename."_tagnum_posts",
				   "std" => "5",
				   "type" => "text",
				   "desc" => esc_html__("Here you can designate how many recent articles are displayed on the Tag pages. This option works independently from the Settings > Reading options in wp-admin.", "mharty"),
				   "validation_type" => "number"
			),
			
			array( "name" => esc_html__("Date format", "mharty"),
				   "id" => $themename."_date_format",
				   "std" => "d/m/Y",
				   "type" => "text",
				   "desc" => mh_wp_kses( __('This option allows you to change how your dates are displayed. For more information please refer to the WordPress codex here:<a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Formatting Date and Time</a>', 'mharty') ),
				   "validation_type" => "date_format"
			),
			
			array( "name" => esc_html__("Header Date format", "mharty"),
				   "id" => $themename."_header_date_format",
				   "std" => "d/m/Y",
				   "type" => "text",
				   "desc" => mh_wp_kses( __('This option allows you to change how your dates are displayed. For more information please refer to the WordPress codex here:<a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Formatting Date and Time</a>', 'mharty') ),
				   "validation_type" => "date_format"
			),

			array( "name" => esc_html__("Blog Style Mode", "mharty"),
				   "id" => $themename."_blog_style",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => esc_html__("By default the theme truncates your posts on index/homepages automatically to create post previews. If you would rather show your posts in full on index pages, like a traditional blog, then you can activate this feature.", "mharty"),
			),

			array( "name" => esc_html__("Use excerpts when defined", "mharty"),
				   "id" => $themename."_use_excerpt",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("This will enable the use of excerpts in posts or pages.", "mharty")
			),
	
			array( "name" => esc_html__( "Smooth Scrolling", "mharty" ),
				   "id" => $themename . "_smooth_scroll",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => esc_html__( "Enable this option to to get a smooth scrolling effect with mouse wheel.", "mharty" )
			),

			array( "name" => esc_html__( "Custom CSS", "mharty" ),
				   "id" => $themename . "_custom_css",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__( "Here you can add custom css to override or extend default styles.", "mharty" ),
					"validation_type" => "nohtml"
			),
		array( "name" => "general-1",
			   "type" => "subcontent-end",),

	array(  "name" => "wrap-general",
			"type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-layout",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "layout-1",
				   "type" => "subnav-tab",
				   	"desc" => esc_html__("General", "mharty")
			),
			array( "name" => "layout-2",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Post Layout", "mharty")
			),
			array( "name" => "layout-3",
				   "type" => "subnav-tab",
				   	"desc" => esc_html__("Project Layout", "mharty")
			),
			array( "name" => "layout-4",
				   "type" => "subnav-tab",
					"desc" => esc_html__("Page Layout", "mharty")
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "layout-1",
			   "type" => "subcontent-start",),
			   
			array( "name" => esc_html__("Show Archive Titles", "mharty"),
				   "id" => $themename."_archive_title",
				   "type" => "checkbox",
				   "std" => "off",
				   "desc" => esc_html__("Enable this option to show Archive Pages title e.g category, tag, search results page.", "mharty")
			),
			array( "name" => esc_html__("Show Archive Description", "mharty"),
				   "id" => $themename."_archive_description",
				   "type" => "checkbox",
				   "std" => "off",
				   "desc" => esc_html__("Enable this option to show Archive Pages description e.g category, tag.", "mharty")
			),
			array(
				"name" => esc_html__("Post info separator", "mharty"),
				"id" => $themename."_postinfo_sep",
				"type" => "text",
				   "std" => " | ",
				   "desc" => esc_html__("Here you can change which character separates your post info. Default value is |", "mharty"),
					"validation_type" => "nohtml"
			),
			array(
				"name" => esc_html__("Pre post author", "mharty"),
				"id" => $themename."_postinfo_pre",
				"type" => "text",
				   "std" => esc_html__("By", "mharty"),
				   "desc" => esc_html__("Here you can change the word before the post author. Default is 'By'.", "mharty"),
					"validation_type" => "nohtml"
			),
			array(
				"name" => esc_html__("Post info alt style", "mharty"),
				"id" => $themename."_postinfo1_style",
  				"type" => "checkbox",
				   "std" => "off",
				"desc" => esc_html__("This option will change the look for your post info to be in a stylish two-line format.", "mharty")
			),
						array( "name" => esc_html__("Choose which items to display in the postinfo section in archive pages", "mharty"),
						
				   "id" => $themename."_postinfo1",
				   "type" => "different_checkboxes",
				   "std" => array("author","date","categories"),
				   "desc" => esc_html__("Here you can choose which items appear in the postinfo section on pages. This is area is usually below the post title and displays basic information about your post. The highlighted items shown below will appear.", "mharty"),
				  "options" => array("avatar","author","date","categories","comments")),
			
			
			array( "name" => esc_html__("Post info position", "mharty"),
				   "id" => $themename."_postinfo1_position",
				   "type" => "select",
				   	"options" => array(
						'above'    => esc_html__( 'Above title and media', 'mharty' ),
				   		'middle'   => esc_html__( 'Above title', 'mharty' ),
				   		'below' 	=> esc_html__( 'Below title', 'mharty' ),
				   	),
					"std" => "above",
				   "desc" => esc_html__("Here you can choose where you want the post info block.", "mharty"),
				   'mh_save_values' => true,
				   ),

			array( "name" => esc_html__("Show Thumbs on Index pages", "mharty"),
				   "id" => $themename."_thumbnails_index",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => esc_html__("Enable this option to show thumbnails on Index Pages.", "mharty")
			),
			array(
				"name" => esc_html__("Read more", "mharty"),
				"id" => $themename."_readmore_text",
				"type" => "text",
				   "std" => esc_html__("Read more", "mharty"),
				   "desc" => esc_html__("Here you can change the word 'Read more'.", "mharty"),
					"validation_type" => "nohtml"
			),
			array( "name" => esc_html__("Show Read More on Archive pages", "mharty"),
				   "id" => $themename."_readmore_index",
				   "type" => "checkbox",
				   "std" => "off",
				   "desc" => esc_html__("Enable this option to show Read More link on Archive Pages.", "mharty")
			),
			array( "name" => esc_html__("Read More Button Style", "mharty"),
				   "id" => $themename."_readmore_button",
				   "type" => "checkbox2",
				   "std" => "off",
				   "desc" => esc_html__('Here you can define whether to display "read more" link as a button.', 'mharty')
			),
		

		array( "name" => "layout-1",
			   "type" => "subcontent-end",),
			   
		array( "name" => "layout-2",
			   "type" => "subcontent-start",),
			array( "name" => esc_html__("Choose which items to display in the postinfo section", "mharty"),
				   "id" => $themename."_postinfo2",
				   "type" => "different_checkboxes",
				   "std" => array("author","date","categories","comments"),
				   "desc" => esc_html__("Here you can choose which items appear in the postinfo section on single pages. This is area is usually below the post title and displays basic information about your post. The highlighted items shown below will appear.", "mharty"),
				   "options" => array("avatar","author","date","categories","comments")
				   ),
			
			array( "name" => esc_html__("Post info position", "mharty"),
				   "id" => $themename."_postinfo2_position",
				   "type" => "select",
				   	"options" => array(
						'above'	 => esc_html__( 'Above title and media', 'mharty' ),
				   		'below'	 => esc_html__( 'Below title', 'mharty' ),
				   		'middle'	=> esc_html__( 'Below title and media', 'mharty' ),
				   	),
									   "std" => "above",
				   "desc" => esc_html__("Here you can choose where you want the post info block.", "mharty"),
				   'mh_save_values' => true,
				   ),
			array( "name" => esc_html__("Place Thumbs on Posts", "mharty"),
				   "id" => $themename."_thumbnails",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => esc_html__("By default thumbnails are placed at the beginning of your post on single post pages. If you would like to remove this initial thumbnail image to avoid repetition simply disable this option.", "mharty")
			),
			
			array( "name" => esc_html__("Grab the first post image", "mharty"),
				   "id" => $themename."_grab_image",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("By default thumbnail images are created using custom fields. However, if you would rather use the images that are already in your post for your thumbnail (and bypass using custom fields) you can activate this option. Once activcated thumbnail images will be generated automatically using the first image in your post. The image must be hosted on your own server.", "mharty")
			),
			
			array( "name" => esc_html__("Video Cover Style", "mharty"),
				   "id" => $themename."_video_cover",
				   "type" => "checkbox2",
				   "std" => "off",
				   "desc" => esc_html__("By default videos are placed at the beginning of your post on single post pages. If you would like to feature the video enable this option. This will work only on video post format.", "mharty")
			),
			array(
				"name" => esc_html__("Show related posts", "mharty"),
				"id" => $themename."_show_related_posts",
				"type" => "checkbox",
				"std" => "off",
				"desc" => esc_html__("You can enable this option if you want to display the related posts section on single post.", "mharty")
			),
			array( "name" => esc_html__("Related posts title (if enabled)", "mharty"),
				   "id" => $themename."_related_posts_title",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("If you have enabled related posts on your posts you can add your custom title here.", "mharty"),
					"validation_type" => "nohtml"
			),
			
			array(
				"name" => esc_html__("Show comments on posts", "mharty"),
				"id" => $themename."_show_postcomments",
				"type" => "checkbox",
				"std" => "on",
				"desc" => esc_html__("You can disable this option if you want to remove the comment form and the comments from all single post pages.", "mharty")
			),
		array( "name" => esc_html__("Show post Navigation", "mharty"),
				   "id" => $themename."_show_post_nav",
				   "type" => "checkbox",
				   "std" => "off",
				   "desc" => esc_html__("Enable this option If you want to display the post navigation.", "mharty")
			),

		array( "name" => "layout-2",
			   "type" => "subcontent-end",),
			   
			array( "name" => "layout-3",
			   "type" => "subcontent-start",),	
	
			array( "name" => esc_html__("Place Thumbs on Projects", "mharty"),
				   "id" => $themename."_thumbnails_project",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => esc_html__("By default thumbnails are placed at the beginning of your post on single project pages. If you would like to remove this initial thumbnail image to avoid repetition simply disable this option.", "mharty")
			),
			array(
				"name" => esc_html__("Show comments on projects", "mharty"),
				"id" => $themename."_show_projectcomments",
				"type" => "checkbox",
				"std" => "on",
				"desc" => esc_html__("You can disable this option if you want to remove the comment form and the comments from all single project pages.", "mharty")
			),
			array( "name" => esc_html__("Show project Navigation", "mharty"),
				   "id" => $themename."_show_project_nav",
				   "type" => "checkbox",
				   "std" => "off",
				   "desc" => esc_html__("Enable this option If you want to display the project navigation.", "mharty")
			),
			
			array( "name" => esc_html__("Project Tags Title", "mharty"),
				   "id" => $themename."_project_tag_title",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("Here you can change the title. Default value is: Skills", "mharty"),
					"validation_type" => "nohtml"
			),
			array(
				"name" => esc_html__("Show related projects", "mharty"),
				"id" => $themename."_show_related_projects",
				"type" => "checkbox",
				"std" => "off",
				"desc" => esc_html__("You can enable this option if you want to display the related projects section on single project.", "mharty")
			),
			array( "name" => esc_html__("Related projects title (if enabled)", "mharty"),
				   "id" => $themename."_related_projects_title",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("If you have enabled related projetcs, you can add your custom title here.", "mharty"),
					"validation_type" => "nohtml"
			),

		array( "name" => "layout-3",
			   "type" => "subcontent-end",),

		array( "name" => "layout-4",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("Place Thumbs on Pages", "mharty"),
				   "id" => $themename."_page_thumbnails",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("By default thumbnails are not placed on pages (they are only used on posts). However, if you want to use thumbnails on pages you can! Just enable this option.", "mharty")
			),

			array( "name" => esc_html__("Show comments on pages", "mharty"),
			"id" => $themename."_show_pagescomments",
			"type" => "checkbox2",
			"std" => "false",
			"desc" => esc_html__("By default comments are not placed on pages, however, if you would like to allow people to comment on your pages simply enable this option.", "mharty")
			),

		array( "name" => "layout-4",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-layout",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//
array( "name" => "wrap-social",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "social-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Social Icons", "mharty")
			),
			array( "name" => "social-2",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Quick Contact", "mharty")
			),
      		
			array( "type" => "subnavtab-end",),

			array( "name" => "social-1",
			   "type" => "subcontent-start",),	
  
  
  			array( "name" => esc_html__("Facebook Icon", "mharty" ),
                   "id" => $themename."_show_facebook_icon",
                   "type" => "checkbox",
                   "std" => "on",
				   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
			 ),

			array( "name" => esc_html__("Twitter Icon", "mharty" ),
                   "id" => $themename."_show_twitter_icon",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
									 ),

			array( "name" => esc_html__("Instagram Icon", "mharty" ),
                   "id" => $themename."_show_instagram_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
									),
									
			array( "name" => esc_html__("Google+ Icon", "mharty" ),
                   "id" => $themename."_show_google_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
									 ),
									
			array( "name" => esc_html__("YouTube Icon", "mharty" ),
                   "id" => $themename."_show_youtube_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
									),
									
			array( "name" => esc_html__("LinkedIn Icon", "mharty" ),
                   "id" => $themename."_show_linkedin_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
									),
									
			array( "name" => esc_html__("Behance Icon", "mharty" ),
                   "id" => $themename."_show_behance_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
									),
			
			array( "name" => esc_html__("Dribbble Icon", "mharty" ),
                   "id" => $themename."_show_dribbble_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
									),
									
			array( "name" => esc_html__("Flickr Icon", "mharty" ),
                   "id" => $themename."_show_flickr_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
									),

			array( "name" => esc_html__("SoundCloud Icon", "mharty" ),
                   "id" => $themename."_show_soundcloud_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
									),

			array( "name" => esc_html__("Skype Icon", "mharty" ),
                   "id" => $themename."_show_skype_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
					),
			
			array( "name" => esc_html__("Telegram Icon", "mharty" ),
                   "id" => $themename."_show_telegram_icon",
                   "type" => "checkbox",
                   "std" => "on",
				   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
					 ),
									
			array( "name" => esc_html__("Mixlr Icon", "mharty" ),
                   "id" => $themename."_show_mixlr_icon",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
					 ),
					 
			array( "name" => esc_html__("Periscope Icon", "mharty" ),
                   "id" => $themename."_show_periscope_icon",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
					 ),
					 
			array( "name" => esc_html__("YouNow Icon", "mharty" ),
                   "id" => $themename."_show_younow_icon",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
					 ),
	
			array( "name" => esc_html__("Snapchat Icon", "mharty" ),
                   "id" => $themename."_show_snapchat_icon",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
					 ),
	
			array( "name" => esc_html__("TripAdvisor Icon", "mharty" ),
                   "id" => $themename."_show_tripadvisor_icon",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
					 ),
	
			array( "name" => esc_html__("Pinterest Icon", "mharty" ),
                   "id" => $themename."_show_pinterest_icon",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display the Icon on your website. Add your URL in the field below.", "mharty" ),
					 ),
																										
			array( "name" => esc_html__("RSS Icon", "mharty" ),
                   "id" => $themename."_show_rss_icon",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => esc_html__("Here you can choose to display the Icon on your website.", "mharty" ),
				 ),

			array( "name" => esc_html__("Facebook URL", "mharty"),
                   "id" => $themename."_facebook_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Facebook Profile.", "mharty" ),
					 ),

			array( "name" => esc_html__("Twitter URL", "mharty" ),
                   "id" => $themename."_twitter_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Twitter Profile.", "mharty" ),
					 ),
					 
			array( "name" => esc_html__("instagram URL", "mharty" ),
                   "id" => $themename."_instagram_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your instagram Profile.", "mharty" ),
					 ),
					 
			array( "name" => esc_html__("Google+ URL", "mharty" ),
                   "id" => $themename."_google_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Google+ Profile.", "mharty" ),
					 ),
					 
			array( "name" => esc_html__("YouTube URL", "mharty" ),
                   "id" => $themename."_youtube_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your YouTube Channel.", "mharty" ),
					 ),
					 
		array( "name" => esc_html__("LinkedIn URL", "mharty" ),
                   "id" => $themename."_linkedin_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your LinkedIn Profile.", "mharty" ),
					 ),
					 
		array( "name" => esc_html__("Behance URL", "mharty" ),
                   "id" => $themename."_behance_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Behance Profile.", "mharty" ),
					 ),
					 
		array( "name" => esc_html__("Dribbble URL", "mharty" ),
                   "id" => $themename."_dribbble_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Dribbble Profile.", "mharty" ),
					 ),
					 
		array( "name" => esc_html__("Flickr URL", "mharty" ),
                   "id" => $themename."_flickr_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Flickr Profile.", "mharty" ),
					 ),

		array( "name" => esc_html__("SoundCloud URL", "mharty" ),
                   "id" => $themename."_soundcloud_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your SoundCloud Profile.", "mharty" ),
					 ),

		array( "name" => esc_html__("Skype Username", "mharty" ),
                   "id" => $themename."_skype_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Skype Username.", "mharty" ),
					 ),
					 
		array( "name" => esc_html__("Telegram URL", "mharty" ),
                   "id" => $themename."_telegram_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Telegram Broadcast.", "mharty" ),
					 ),
					 
		array( "name" => esc_html__("Mixlr URL", "mharty" ),
                   "id" => $themename."_mixlr_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Account.", "mharty" ),
					 ),
					 
			array( "name" => esc_html__("Periscope URL", "mharty" ),
                   "id" => $themename."_periscope_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Account.", "mharty" ),
					 ),
					 
			array( "name" => esc_html__("YouNow URL", "mharty" ),
                   "id" => $themename."_younow_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Account.", "mharty" ),
					 ),
	
			array( "name" => esc_html__("Snapchat URL", "mharty" ),
                   "id" => $themename."_snapchat_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Account.", "mharty" ),
					 ),
	
			array( "name" => esc_html__("TripAdvisor URL", "mharty" ),
                   "id" => $themename."_tripadvisor_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Account.", "mharty" ),
					 ),
	
			array( "name" => esc_html__("Pinterest URL", "mharty" ),
                   "id" => $themename."_pinterest_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your Account.", "mharty" ),
					 ),
					 					 					 
			array( "name" => esc_html__("RSS Url", "mharty" ),
                   "id" => $themename."_rss_url",
                   "std" => "",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => esc_html__("Enter the URL of your RSS feed.", "mharty" ),
					 ),
					 
			array( "name" => "social-1",
			   "type" => "subcontent-end",),

			array( "name" => "social-2",
			   "type" => "subcontent-start",),	
			   
			   array(  "title" => esc_html__("This feature requires MH Page Composer plugin. Please activate it now.", "mharty" ),
				"type" => "header"),
			   
			    array( "name" => esc_html__("Show Quick Contact Form", "mharty" ),
                   "id" => $themename."_show_quick_contact",
                   "type" => "checkbox",
                   "std" => "off",
				   "desc" => esc_html__("Here you can choose to display the Quick contact form on your website.", "mharty" ),
				),
				array( "name" => esc_html__("Enable Captcha", "mharty" ),
					"id" => $themename."_quick_contact_captcha",
					"type" => "checkbox",
					"std" => "off",
					"desc" => esc_html__("You can enable captcha for your contact form.", "mharty" ),
				),
			   	
									    	
		array( "name" => esc_html__("Quick Contact Form Email", "mharty"),
				   "id" => $themename."_quick_contact_email",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("Put the email to which messages will be sent.", "mharty"),
					"validation_type" => "nohtml"
			),
				array( "name" => esc_html__("Quick Contact Form Title", "mharty"),
				   "id" => $themename."_quick_contact_title",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("You could use this field to display a title for your quick contact form.", "mharty"),
					"validation_type" => "nohtml"
			),
			array( "name" => esc_html__("Quick Contact Form Excerpt", "mharty"),
				   "id" => $themename."_quick_contact_blurb",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("You could use this field to display an excerpt for your quick contact form.", "mharty"),
					"validation_type" => "nohtml"
			),
			array( "name" => esc_html__("Quick Contact Form Success Message", "mharty"),
				   "id" => $themename."_quick_contact_message",
				   "type" => "text",
				   "std" => esc_html__( 'Thank you for contacting us.', 'mharty'),
				   "desc" => esc_html__("Define a message to display after successful form submission. Leave empty to use the default message.", "mharty"),
					"validation_type" => "nohtml"
			),
			array( "name" => esc_html__("Quick Contact Form Use Redirect", "mharty" ),
					"id" => $themename."_quick_contact_use_redirect",
					"type" => "checkbox",
					"std" => "off",
					"desc" => esc_html__("Redirect visitors after successful form submission.", "mharty" ),
				),
			array( "name" => esc_html__("Quick Contact Form Redirect URL", "mharty"),
				   "id" => $themename."_quick_contact_redirect_url",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("Input the Redirect URL here, This will redirect visitors after successful form submission.", "mharty"),
					"validation_type" => "url"
			),
			
		array( "name" => "social-2",
			   "type" => "subcontent-end",),
			   
		array( "name" => "wrap-social",
		   "type" => "contenttab-wrapend",),
		   
//-------------------------------------------------------------------------------------//	   
		   
		array( "name" => "wrap-navigation",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "navigation-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Pages", "mharty")
			),

			array( "name" => "navigation-2",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Categories", "mharty")
			),

			array( "name" => "navigation-3",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("General", "mharty")
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "navigation-1",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("Show dropdown menus", "mharty"),
			"id" => $themename."_enable_dropdowns",
			"type" => "checkbox",
			"std" => "on",
			"desc" => esc_html__("If you would like to remove the dropdown menus from the pages navigation bar disable this feature.", "mharty")
			),

			array( "name" => esc_html__("Display Home link", "mharty"),
			"id" => $themename."_home_link",
			"type" => "checkbox2",
			"std" => "on",
			"desc" => esc_html__("By default the theme creates a Home link that, when clicked, leads back to your blog's homepage. If, however, you are using a static homepage and have already created a page called Home to use, this will result in a duplicate link. In this case you should disable this feature to remove the link.", "mharty")
			),

			array( "name" => esc_html__("Sort Pages Links", "mharty"),
				   "id" => $themename."_sort_pages",
				   "type" => "select",
				   "std" => "post_title",
				   "desc" => esc_html__("Here you can choose to sort your pages links.", "mharty"),
				   "options" => array("post_title", "menu_order","post_date","post_modified","ID","post_author","post_name")),

			array( "name" => esc_html__("Order Pages Links by Ascending/Descending", "mharty"),
				   "id" => $themename."_order_page",
				   "type" => "select",
				   "std" => "asc",
				   "desc" => esc_html__("Here you can choose to reverse the order that your pages links are displayed. You can choose between ascending and descending.", "mharty"),
				   "options" => array("asc", "desc")),

			array( "name" => esc_html__("Number of dropdown tiers shown", "mharty"),
					"id" => $themename."_tiers_shown_pages",
					"type" => "text",
					"std" => "3",
					"desc" => esc_html__("This options allows you to control how many teirs your pages dropdown menu has. Increasing the number allows for additional menu items to be shown.", "mharty"),
					"validation_type" => "number"
			),
			
	array( "name" => esc_html__("Exclude pages from the navigation bar", "mharty"),
				   "id" => $themename."_menupages",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => esc_html__("Here you can choose to remove certain pages from the navigation menu. All pages marked with an X will not appear in your navigation bar.", "mharty"),
				   "usefor" => "pages",
				   "options" => $pages_ids),
					 
			
		array( "name" => "navigation-1",
			   "type" => "subcontent-end",),

		array( "name" => "navigation-2",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("Show dropdown menus", "mharty"),
			"id" => $themename."_enable_dropdowns_categories",
			"type" => "checkbox",
			"std" => "on",
			"desc" => esc_html__("If you would like to remove the dropdown menus from the categories navigation bar disable this feature.", "mharty")
			),

			array( "name" => esc_html__("Hide empty categories", "mharty"),
			"id" => $themename."_categories_empty",
			"type" => "checkbox",
			"std" => "on",
			"desc" => esc_html__("If you would like categories to be displayed in your navigation bar that don't have any posts in them then disable this option. By default empty categories are hidden", "mharty")
			),

			array( "name" => esc_html__("Number of dropdown tiers shown", "mharty"),
					"id" => $themename."_tiers_shown_categories",
					"type" => "text",
					"std" => "3",
					"desc" => esc_html__("This options allows you to control how many teirs your pages dropdown menu has. Increasing the number allows for additional menu items to be shown.", "mharty"),
					"validation_type" => "number"
			),

			array( "name" => esc_html__("Sort Categories Links by Name/ID/Slug/Count/Term Group", "mharty"),
				   "id" => $themename."_sort_cat",
				   "type" => "select",
				   "std" => "name",
				   "desc" => esc_html__("By default pages are sorted by name. However, if you would rather have them sorted by ID you can adjust this setting.", "mharty"),
				   "options" => array("name", "ID", "slug", "count", "term_group")),

			array( "name" => esc_html__("Order Category Links by Ascending/Descending", "mharty"),
				   "id" => $themename."_order_cat",
				   "type" => "select",
				   "std" => "asc",
				   "desc" => esc_html__("Here you can choose to reverse the order that your categories links are displayed. You can choose between ascending and descending.", "mharty"),
				   "options" => array("asc", "desc")),
array( "name" => esc_html__("Exclude categories from the navigation bar", "mharty"),
				   "id" => $themename."_menucats",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => esc_html__("Here you can choose to remove certain categories from the navigation menu. All categories marked with an X will not appear in your navigation bar.", "mharty"),
				   "usefor" => "categories",
				   "options" => $cats_ids),
					 
					 
		array( "name" => "navigation-2",
			   "type" => "subcontent-end",),

		array( "name" => "navigation-3",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("Disable top tier dropdown menu links", "mharty"),
			"id" => $themename."_disable_toptier",
			"type" => "checkbox2",
			"std" => "false",
			"desc" => esc_html__("Sometimes users will want to create parent categories or links as placeholders to hold a list of child links or categories. In this case it is not desirable to have the parent links lead anywhere, but instead merely serve an organizational function. Enabling this options will remove the links from all parent pages/categories so that they don't lead anywhere when clicked.", "mharty")
			),

			

		array( "name" => "navigation-3",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-navigation",
		   "type" => "contenttab-wrapend",),
			 
//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-seo",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "seo-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Homepage SEO", "mharty")
			),

			array( "name" => "seo-2",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Single Post Page SEO", "mharty")
			),

			array( "name" => "seo-3",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Index Page SEO", "mharty")
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "seo-1",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__(" Enable custom title ", "mharty"),
				   "id" => $themename."_seo_home_title",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("By default the theme creates your homepage titles using a combination of your blog name and your blog description, as defined when you created your blog. However if you want to create a custom title then simply enable this option and fill in the custom title field below.", "mharty")
			),

			array( "name" => esc_html__(" Enable meta description", "mharty"),
				   "id" => $themename."_seo_home_description",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("By default the theme fills in the meta description field using your blog description, as defined when you created your blog. If you would like to use a different description then enable this option and fill in the custom description field below.", "mharty")
			),

			array( "name" => esc_html__(" Enable meta keywords", "mharty"),
				   "id" => $themename."_seo_home_keywords",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("By default the theme does not add keywords to your header. Most search engines don't use keywords to rank your site any more, but some people define them anyway just in case. If you want to add meta keywords to your header then enable this option and fill in the custom keywords field below.", "mharty")
			),

			

			array( "name" => esc_html__("Homepage custom title (if enabled)", "mharty"),
				   "id" => $themename."_seo_home_titletext",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("If you have enabled custom titles you can add your custom title here. Whatever you type here will be placed between the < title >< /title > tags in header.php", "mharty"),
					"validation_type" => "nohtml"
			),

			array( "name" => esc_html__("Homepage meta description (if enabled)", "mharty"),
				   "id" => $themename."_seo_home_descriptiontext",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("If you have enabled meta descriptions you can add your custom description here.", "mharty"),
					"validation_type" => "nohtml"
			),

			array( "name" => esc_html__("Homepage meta keywords (if enabled)", "mharty"),
				   "id" => $themename."_seo_home_keywordstext",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("If you have enabled meta keywords you can add your custom keywords here. Keywords should be separated by commas. For example: wordpress,themes,templates", "mharty"),
					"validation_type" => "nohtml"
			),

			array( "name" => esc_html__("If custom titles are disabled, choose autogeneration method", "mharty"),
				   "id" => $themename."_seo_home_type",
				   "type" => "select",
				   "std" => "BlogName | Blog description",
				   "options" => array("BlogName | Blog description", "Blog description | BlogName", "BlogName only"),
				   "desc" => esc_html__("If you are not using custom post titles you can still have control over how your titles are generated. Here you can choose which order you would like your post title and blog name to be displayed, or you can remove the blog name from the title completely.", "mharty")
			),

			array( "name" => esc_html__("Define a character to separate BlogName and Post title", "mharty"),
				   "id" => $themename."_seo_home_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => esc_html__("Here you can change which character separates your blog title and post name when using autogenerated post titles. Common values are | or -", "mharty"),
					"validation_type" => "nohtml"
			),
			array( "name" => esc_html__(" Enable canonical URL's", "mharty"),
				   "id" => $themename."_seo_home_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treated individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs on your permalinks and the domain name defined in the settings tab of wp-admin.", "mharty")
			),

			

		array( "name" => "seo-1",
			   "type" => "subcontent-end",),

		array( "name" => "seo-2",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("Enable custom titles", "mharty"),
				   "id" => $themename."_seo_single_title",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("By default the theme creates post titles based on the title of your post and your blog name. If you would like to make your meta title different than your actual post title you can define a custom title for each post using custom fields. This option must be enabled for custom titles to work, and you must choose a custom field name for your title below.", "mharty")
			),

			array( "name" => esc_html__("Enable custom description", "mharty"),
				   "id" => $themename."_seo_single_description",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => esc_html__("If you would like to add a meta description to your post you can do so using custom fields. This option must be enabled for descriptions to be displayed on post pages. You can add your meta description using custom fields based on the custom field name you define below.", "mharty")
			),

			

			array( "name" => esc_html__("Enable custom keywords", "mharty"),
				   "id" => $themename."_seo_single_keywords",
					"type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("If you would like to add meta keywords to your post you can do so using custom fields. This option must be enabled for keywords to be displayed on post pages. You can add your meta keywords using custom fields based on the custom field name you define below.", "mharty")
			),

			

			array( "name" => esc_html__("Custom field Name to be used for title", "mharty"),
				   "id" => $themename."_seo_single_field_title",
				   "type" => "text",
				   "std" => "seo_title",
				   "desc" => esc_html__("When you define your title using custom fields you should use this value for the custom field Name. The Value of your custom field should be the custom title you would like to use.", "mharty"),
					"validation_type" => "nohtml"
			),

			array( "name" => esc_html__("Custom field Name to be used for description", "mharty"),
				   "id" => $themename."_seo_single_field_description",
				   "type" => "text",
				   "std" => "seo_description",
				   "desc" => esc_html__("When you define your meta description using custom fields you should use this value for the custom field Name. The Value of your custom field should be the custom description you would like to use.", "mharty"),
					"validation_type" => "nohtml"
			),

			array( "name" => esc_html__("Custom field Name to be used for keywords", "mharty"),
				   "id" => $themename."_seo_single_field_keywords",
				   "type" => "text",
				   "std" => "seo_keywords",
				   "desc" => esc_html__("When you define your keywords using custom fields you should use this value for the custom field Name. The Value of your custom field should be the meta keywords you would like to use, separated by commas.", "mharty"),
					"validation_type" => "nohtml"
			),

			array( "name" => esc_html__("If custom titles are disabled, choose autogeneration method", "mharty"),
				   "id" => $themename."_seo_single_type",
				   "type" => "select",
				   "std" => "Post title | BlogName",
				   "options" => array("Post title | BlogName", "BlogName | Post title", "Post title only"),
				   "desc" => esc_html__("If you are not using custom post titles you can still have control over how your titles are generated. Here you can choose which order you would like your post title and blog name to be displayed, or you can remove the blog name from the title completely.", "mharty")
			),

			array( "name" => esc_html__("Define a character to separate BlogName and Post title", "mharty"),
				   "id" => $themename."_seo_single_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => esc_html__("Here you can change which character separates your blog title and post name when using autogenerated post titles. Common values are | or -", "mharty"),
					"validation_type" => "nohtml"
			),
			array( "name" => esc_html__("Enable canonical URL's", "mharty"),
				   "id" => $themename."_seo_single_canonical",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => esc_html__("Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treated individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs on your permalinks and the domain name defined in the settings tab of wp-admin.", "mharty")
			),

			

		array( "name" => "seo-2",
			   "type" => "subcontent-end",),

		array( "name" => "seo-3",
				   "type" => "subcontent-start",),

			array( "name" => esc_html__("Enable meta descriptions", "mharty"),
				   "id" => $themename."_seo_index_description",
					"type" => "checkbox2",
				   "std" => "false",
				   "desc" => esc_html__("Check this box if you want to display meta descriptions on category/archive pages. The description is based off the category description you choose when creating/edit your category in wp-admin.", "mharty")
			),

			

			array( "name" => esc_html__("Choose title autogeneration method", "mharty"),
				   "id" => $themename."_seo_index_type",
				   "type" => "select",
				   "std" => "Category name | BlogName",
				   "options" => array("Category name | BlogName", "BlogName | Category name", "Category name only"),
				   "desc" => esc_html__("Here you can choose how your titles on index pages are generated. You can change which order your blog name and index title are displayed, or you can remove the blog name from the title completely.", "mharty")
			),

			array( "name" => esc_html__("Define a character to separate BlogName and Post title", "mharty"),
				   "id" => $themename."_seo_index_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => esc_html__("Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -", "mharty"),
					"validation_type" => "nohtml"
			),
			array( "name" => esc_html__(" Enable canonical URL's", "mharty"),
				   "id" => $themename."_seo_index_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treated individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs on your permalinks and the domain name defined in the settings tab of wp-admin.", "mharty")
			),

			

		array( "name" => "seo-3",
				   "type" => "subcontent-end",),

	array(  "name" => "wrap-seo",
			"type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-advanced",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "advanced-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Advanced Options", "mharty")
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "advanced-1",
			   "type" => "subcontent-start",),
			array(
				"name" => esc_html__( "Google API Key", "mharty" ),
				"id" => $themename  . "_google_maps_api_key",
				"std" => "",
				"type" => "text",
				"validation_type" => "nohtml",
				"desc" => mh_wp_kses( sprintf( __( 'The Maps component uses the Google Maps API and requires a valid Google API Key to work. Before using the map component, please make sure you input your API key in the field. Learn more about how to create your Google API Key <a target="_blank" href="%1$s">here</a>.', "mharty" ), 'http://mharty.com/docs/maps' ) ),
				 ),


 			array( "name" => esc_html__( "MailChimp API Key", "mharty" ),
                   "id" => $themename . "_mailchimp_api_key",
                   "std" => "",
                   "type" => "text",
                   "validation_type" => "nohtml",
				   "desc" => mh_wp_kses( sprintf( __( 'Enter your MailChimp API key. You can create an api key <a target="_blank" href="%1$s">here</a>', 'mharty' ), 'https://us3.admin.mailchimp.com/account/api/' ) ) ),

			array( "name" => esc_html__( "Regenerate MailChimp Lists", "mharty" ),
                   "id" => $themename."_regenerate_mailchimp_lists",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => esc_html__("By default, MailChimp lists are cached for one day. If you added new list, but it doesn't appear within the SignUp module settings, activate this option. Don't forget to disable it once the list has been regenerated.", "mharty" ),
									 ),
			
			array( "name" => esc_html__("Google Fonts subsets", "mharty"),
				   "id" => $themename."_gf_enable_all_character_sets",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => esc_html__("For Non-Arabic websites only. This will enable Google Fonts languages like Latin and Cyrillic.",
					  $themename),
			),
			
			array( "name" => esc_html__("Code inside < head >", "mharty"),
				   "id" => $themename."_integrate_header_enable",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => esc_html__("Disabling this option will remove the header code below from your blog. This allows you to remove the code while saving it for later use.", "mharty")
			),

			array( "name" => esc_html__("Code inside body < body >", "mharty"),
				   "id" => $themename."_integrate_body_enable",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => esc_html__("Disabling this option will remove the body code below from your blog. This allows you to remove the code while saving it for later use.", "mharty")
			),

			

			array( "name" => esc_html__("Code inside single post (top)", "mharty"),
				   "id" => $themename."_integrate_singletop_enable",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => esc_html__("Disabling this option will remove the single top code below from your blog. This allows you to remove the code while saving it for later use.", "mharty")
			),

			array( "name" => esc_html__("Code inside single post (bottom)", "mharty"),
				   "id" => $themename."_integrate_singlebottom_enable",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => esc_html__("Disabling this option will remove the single bottom code below from your blog. This allows you to remove the code while saving it for later use.", "mharty")
			),

			

			array( "name" => esc_html__("Add code to the < head > of your blog", "mharty"),
				   "id" => $themename."_integration_head",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Any code you place here will appear in the head section of every page of your blog. This is useful when you need to add javascript or css to all pages.", "mharty")
			),

			array( "name" => esc_html__("Add code to the < body > (good for tracking codes such as google analytics)", "mharty"),
				   "id" => $themename."_integration_body",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Any code you place here will appear in body section of all pages of your blog. This is usefull if you need to input a tracking pixel for a state counter such as Google Analytics.", "mharty")
			),

			array( "name" => esc_html__("Add code to the top of your posts", "mharty"),
				   "id" => $themename."_integration_single_top",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Any code you place here will be placed at the top of all single posts.", "mharty")
			),

			array( "name" => esc_html__("Add code to the bottom of your posts, before the comments", "mharty"),
				   "id" => $themename."_integration_single_bottom",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Any code you place here will be placed at the bottom of all single posts.", "mharty")
			),
			
			array( "name" => esc_html__("Show Footer Notice", "mharty"),
				   "id" => $themename."_show_cr",
					"type" => "checkbox",
				   "std" => "on",
				   "desc" => esc_html__("Disabling this option will hide the footer copyright notice. Important note: to get support for your site you must leave this notice visible.", "mharty")
			),
			
			
		array( "name" => "advanced-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-advanced",
		   "type" => "contenttab-wrapend",),
	

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-advertisements",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "advertisements-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("Manage non-widget advertisements", "mharty")
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "advertisements-1",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__("Enable Single Post 468x60 banner", "mharty"),
				   "id" => $themename."_468_enable",
					"type" => "checkbox2",
				   "std" => "false",
				   "desc" => esc_html__("Enabling this option will display a 468x60 banner ad on the bottom of your post pages below the single post content. If enabled you must fill in the banner image and destination url below.", "mharty")
			),

			array( "name" => esc_html__("Input 468x60 advertisement banner image", "mharty"),
				   "id" => $themename."_468_image",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("Here you can provide 468x60 banner image url", "mharty"),
					"validation_type" => "url"
			),

			array( "name" => esc_html__("Input 468x60 advertisement destination url", "mharty"),
				   "id" => $themename."_468_url",
				   "type" => "text",
				   "std" => "",
				   "desc" => esc_html__("Here you can provide 468x60 banner destination url", "mharty"),
					"validation_type" => "url"
			),
			
			array( "name" => esc_html__("Input 468x60 Ad code", "mharty"),
				   "id" => $themename."_468_foursixeight",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => esc_html__("Place your Ad Javascript code here.", "mharty")
			),

		array( "name" => "advertisements-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-advertisements",
		   "type" => "contenttab-wrapend",),
);

if(has_filter('mh_defined_options')) {
$options = apply_filters( 'mh_defined_options', $options );
}