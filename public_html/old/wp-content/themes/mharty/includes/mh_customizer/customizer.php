<?php
/**
* The configuration options for Mharty Customizer
*/
function mharty_customizer_config() {
$args = array(
'logo_image' => get_template_directory_uri() . '/includes/mh_customizer/images/logo.png',
//'color_back' => '#f1f1f1',
'url_path' => get_template_directory_uri() . '/includes/mh_customizer/',
);
return $args;
}
add_filter( 'mh_customizer/config', 'mharty_customizer_config' ); 

/**
* Create the section
*/
function mh_mharty_customize_register( $wp_customize ) {
	$wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'custom_css' );
	$wp_customize->remove_control( 'background-color' );
	$wp_customize->remove_setting( 'background-color' );
    
	$wp_customize->add_section( 'mh_mharty_settings' , array(
		'title'		=> esc_html__( 'Site Settings', 'mharty' ),
		'priority'	=> 20,
	) );
	$wp_customize->add_panel( 'mh_header_panel', array(
		'priority'    => 21,
		'title'       => esc_html__( 'Header Settings', 'mharty' ),
		'description' => esc_html__( 'Header Settings', 'mharty' ),
	) );
	$wp_customize->add_section( 'mh_primary_nav' , array(
		'title'		=> esc_html__( 'Primary Navigation', 'mharty' ),
		'priority'	=> 22,
		'panel'          => 'mh_header_panel',
	) );
	$wp_customize->add_section( 'mh_secondary_nav' , array(
		'title'		=> esc_html__( 'Secondary Navigation', 'mharty' ),
		'priority'	=> 23,
		'panel'          => 'mh_header_panel',
	) );
	$wp_customize->add_section( 'mh_app_nav' , array(
		'title'		=> esc_html__( 'App-like Menu', 'mharty' ),
		'priority'	=> 24,
		'panel'          => 'mh_header_panel',
	) );
	$wp_customize->add_section( 'mh_promo_bar' , array(
		'title'		=> esc_html__( 'Promo Bar', 'mharty' ),
		'priority'	=> 25,
		'panel'          => 'mh_header_panel',
	) );
	$wp_customize->add_section( 'mh_footer_settings' , array(
		'title'		=> esc_html__( 'Footer Settings', 'mharty' ),
		'priority'	=> 30,
	) );
	$wp_customize->add_panel( 'mh_colors', array(
		'priority'    => 40,
		'title'       => esc_html__( 'Colours', 'mharty' ),
		'description' => esc_html__( 'Header Settings', 'mharty' ),
	) );
	$wp_customize->add_section( 'colors' , array(
		'title'		=> esc_html__( 'Accent Colours', 'mharty' ),
		'priority'	=> 41,
		'panel'          => 'mh_colors',
	) );
	$wp_customize->add_section( 'mh_primary_colors' , array(
		'title'		=> esc_html__( 'Primary Navigation Colours', 'mharty' ),
		'priority'	=> 42,
		'panel'          => 'mh_colors',
	) );
	$wp_customize->add_section( 'mh_secondary_colors' , array(
		'title'		=> esc_html__( 'Secondary Navigation Colours', 'mharty' ),
		'priority'	=> 43,
		'panel'          => 'mh_colors',
	) );
	$wp_customize->add_section( 'mh_app_colors' , array(
		'title'		=> esc_html__( 'App Menu Colours', 'mharty' ),
		'priority'	=> 44,
		'panel'          => 'mh_colors',
	) );
	$wp_customize->add_section( 'mh_promo_colors' , array(
		'title'		=> esc_html__( 'Promo Bar Colours', 'mharty' ),
		'priority'	=> 45,
		'panel'          => 'mh_colors',
	) );
	$wp_customize->add_section( 'mh_footer_colors' , array(
		'title'		=> esc_html__( 'Footer Colours', 'mharty' ),
		'priority'	=> 46,
		'panel'          => 'mh_colors',
	) );
	$wp_customize->add_section( 'mh_google_fonts' , array(
		'title'		=> esc_html__( 'Fonts', 'mharty' ),
		'priority'	=> 50,
	) );
	$wp_customize->add_section( 'mh_advanced' , array(
		'title'		=> esc_html__( 'Advanced Settings', 'mharty' ),
		'priority'	=> 60,
	) );
}
add_action( 'customize_register', 'mh_mharty_customize_register' );
/**
* Create the setting
*/
function mh_mharty_customize_setting( $controls ) {
	$google_fonts = mh_get_google_fonts();

	$font_choices = array();
	$font_choices['none'] = 'Default Theme Font';
	foreach ( $google_fonts as $google_font_name => $google_font_properties ) {
		$font_choices[ $google_font_name ] = $google_font_name;
	}
$controls[] = array(
	'type'		=> 'select',
	'setting'  => 'heading_font',
	'label'    => esc_html__( 'Header Font', 'mharty' ),
	'section'  => 'mh_google_fonts',
	'default'  => 'none',
	'priority' => 1,
	'choices'	=> $font_choices,
);
$controls[] = array(
	'type'		=> 'select',
	'setting'  => 'body_font',
	'label'    => esc_html__( 'Body Font', 'mharty' ),
	'section'  => 'mh_google_fonts',
	'default'  => 'none',
	'priority' => 1,
	'choices'	=> $font_choices,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'menu_font',
	'label'    => esc_html__( 'Primary Navigation Font', 'mharty' ),
	'section'  => 'mh_google_fonts',
	'default'  => 'header',
	'priority' => 1.2,
	'choices'  => array(
		'header' => esc_html__( 'Header', 'mharty' ),
		'body' => esc_html__( 'Body', 'mharty' ),
	)
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'secondary_nav_font',
	'label'    => esc_html__( 'Secondary Navigation Font', 'mharty' ),
	'section'  => 'mh_google_fonts',
	'default'  => 'body',
	'priority' => 1.3,
	'choices'  => array(
		'header' => esc_html__( 'Header', 'mharty' ),
		'body' => esc_html__( 'Body', 'mharty' ),
	)
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'app_menu_font',
	'label'    => esc_html__( 'App Menu Font', 'mharty' ),
	'section'  => 'mh_google_fonts',
	'default'  => 'body',
	'priority' => 1.4,
	'choices'  => array(
		'header' => esc_html__( 'Header', 'mharty' ),
		'body' => esc_html__( 'Body', 'mharty' ),
	)
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'footer_font',
	'label'    => esc_html__( 'Footer Font', 'mharty' ),
	'section'  => 'mh_google_fonts',
	'default'  => 'body',
	'priority' => 1.5,
	'choices'  => array(
		'header' => esc_html__( 'Header', 'mharty' ),
		'body' => esc_html__( 'Body', 'mharty' ),
	)
);
$controls[] = array(
'type' => 'checkbox',
	'setting' => 'use_logo_text',
	'label' => esc_html__( 'Site Title as a Logo', 'mharty' ),
	'section' => 'title_tagline',
	'default'  => false,
	'priority' => 21,
	'subtitle' => esc_html__( 'If you want to use your site name and tagline instead of an image based logo enable this option.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'image',
	'setting'  => 'mharty_logo',
	'label'    => esc_html__( 'Logo Image', 'mharty' ),
	'section'  => 'title_tagline',
	'default'  => '',
	'priority' => 22,
	'subtitle' => esc_html__( 'Click the button to upload your logo.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'image',
	'setting'  => 'mharty_og_logo',
	'label'    => esc_html__( 'Open Graph Image', 'mharty' ),
	'section'  => 'title_tagline',
	'default'  => '',
	'priority' => 80,
	'description' => esc_html__( '‫Click the button to upload an image which will be used by default when sharing this website on social network.', 'mharty' ),
);

$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'image',
	'setting'  => 'boxed_layout',
	'label'    => esc_html__( 'Layout style', 'mharty' ),
	'section'  => 'mh_mharty_settings',
	'priority' => 1.5,
	'default'  => 0,
	'subtitle' => esc_html__( 'Choose between full-width or boxed.', 'mharty' ),
	'choices'  => array(
		0 => get_template_directory_uri() . '/includes/mh_customizer/images/full.png',
		1 => get_template_directory_uri() . '/includes/mh_customizer/images/boxed.png',
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'image',
	'setting'  => 'site_width',
	'label'    => esc_html__( 'Website width', 'mharty' ),
	'section'  => 'mh_mharty_settings',
	'priority' => 1.6,
	'default'  => 0,
	'subtitle' => esc_html__( 'Choose between wide or narrow.', 'mharty' ),
	'choices'  => array(
		0 => get_template_directory_uri() . '/includes/mh_customizer/images/wide.png',
		1 => get_template_directory_uri() . '/includes/mh_customizer/images/narrow.png',
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'image',
	'setting'  => 'round_style',
	'label'    => esc_html__( 'Corners Style', 'mharty' ),
	'section'  => 'mh_mharty_settings',
	'default'  => 'square',
	'priority' => 1.7,
	'subtitle' => esc_html__( 'This will affect buttons and icons.', 'mharty' ),
	'choices'  => array(
		'square' => get_template_directory_uri() . '/includes/mh_customizer/images/square.png',
		'rounded'  => get_template_directory_uri() . '/includes/mh_customizer/images/rounded.png',
		'capsule'  => get_template_directory_uri() . '/includes/mh_customizer/images/capsule.png',
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'image',
	'setting'  => 'icons_style',
	'label'    => esc_html__( 'Header and footer Icons Style', 'mharty' ),
	'section'  => 'mh_mharty_settings',
	'default'  => 'only',
	'priority' => 1.8,
	'subtitle' => esc_html__( 'Choose between simple or border.', 'mharty' ),
	'choices'  => array(
		'only' => get_template_directory_uri() . '/includes/mh_customizer/images/only.png',
		'bordered' => get_template_directory_uri() . '/includes/mh_customizer/images/bordered.png',
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'image',
	'setting'  => 'sidebar_titles',
	'label'    => esc_html__( 'Widgets Title Style', 'mharty' ),
	'section'  => 'mh_mharty_settings',
	'default'  => 'none',
	'priority' => 1.8,
	'subtitle' => esc_html__( 'Toggle between the various styles.', 'mharty' ),
	'choices'  => array(
		'none' => get_template_directory_uri() . '/includes/mh_customizer/images/w-none.png',
		'line' => get_template_directory_uri() . '/includes/mh_customizer/images/w-line.png',
		'box' => get_template_directory_uri() . '/includes/mh_customizer/images/w-box.png',
		'arrow' => get_template_directory_uri() . '/includes/mh_customizer/images/w-arrow.png',
		'border' => get_template_directory_uri() . '/includes/mh_customizer/images/w-border.png',
		'smallborder' => get_template_directory_uri() . '/includes/mh_customizer/images/w-smallborder.png',
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'back_to_top',
	'label'    => esc_html__( 'Back To Top Button', 'mharty' ),
	'section'  => 'mh_mharty_settings',
	'default'  => 0,
	'priority' => 2.0,
	'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
	'subtitle' => esc_html__( 'Enable this option to display Back To Top Button while scrolling', 'mharty' ),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'sidebar_border',
	'label'    => esc_html__( 'Sidebar Border', 'mharty' ),
	'section'  => 'mh_mharty_settings',
	'default'  => 1,
	'priority' => 2.1,
	'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
	'subtitle' => esc_html__( 'Use this option to hide the sidebar border.', 'mharty' ),
);
$controls[] = array(
	'type' => 'checkbox',
	'setting' => 'enable_nicescroll',
	'label' => esc_html__( 'Enable Nice Scrollbar', 'mharty' ),
	'section' => 'mh_mharty_settings',
	'default'  => false,
	'priority' => 2.2,
);
$controls[] = array(
'type' => 'checkbox',
	'setting' => 'fixed_nav',
	'label' => esc_html__( 'Fixed Navigation Bar', 'mharty' ),
	'section' => 'mh_primary_nav',
	'default'  => true,
	'priority' => 3.0,
	'subtitle' => esc_html__( 'If you want the navigation bar to stay on top of the screen at all times.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'mharty_logo_sticky_active',
	'label'    => esc_html__( 'Sticky Logo Icon', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => 0,
	'priority' => 3.1,
	'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
	'subtitle' => esc_html__( 'If you enable this option, use the option below to upload your sticky logo.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'image',
	'setting'  => 'mharty_logo_sticky',
	'label'    => esc_html__( 'Sticky Logo', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => '',
	'priority' => 3.2,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'vertical_nav',
	'label'    => esc_html__( 'Navigation Position', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => 0,
	'priority' => 3.3,
	'choices'  => array(
		0 => esc_html__( 'Horizontal', 'mharty' ),
		1 => esc_html__( 'Vertical', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'header_style',
	'label'    => esc_html__( 'Logo Position', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => 'right',
	'priority' => 3.4,
	'choices'  => array(
		'right' => esc_html__( 'Side', 'mharty' ),
		'centered' => esc_html__( 'Centre', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'xl_logo',
	'label'    => esc_html__( 'Logo Size', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'priority' => 3.5,
	'subtitle' => esc_html__( 'By default the logo height is around 40 pixels, but you can input your value here (Numeric value only).', 'mharty' ),
);
$controls[] = array(
	'type' => 'checkbox',
	'setting' => 'header_padding',
	'label' => esc_html__( 'Remove Logo Padding', 'mharty' ),
	'section' => 'mh_primary_nav',
	'default'  => false,
	'priority' => 3.6,
	'subtitle' => esc_html__( 'This option will remove the default padding around the logo and menu items.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'header_padding_top',
	'label'    => esc_html__( 'Add Top Padding', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'priority' => 3.7,
	'subtitle' => esc_html__( 'Add more padding space to top of you header. Use numbers only e.g. 50', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'header_padding_bottom',
	'label'    => esc_html__( 'Add Bottom Padding', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'priority' => 3.8,
	'subtitle' => esc_html__( 'Add more padding space to bottom of you header. Use numbers only e.g. 50', 'mharty' ),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'show_search_icon',
	'label'    => esc_html__( 'Show Search Icon', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => 'full',
	'priority' => 3.9,
	'choices'  => array(
		'hide' => esc_html__( 'Hide', 'mharty' ),
		'full' => esc_html__( 'Full-width', 'mharty' ),
		'default' => esc_html__( 'Default', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'full_search_text',
	'label'    => esc_html__( 'Full-width Search Text', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'priority' => 4.0,
	'subtitle' => esc_html__( 'Default is: Type and Press "Enter".', 'mharty' ),
);
$controls[] = array(
	'type'     => 'image',
	'setting'  => 'header_bg_img',
	'label'    => esc_html__( 'Header Background', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => '',
	'priority' => 4.1,
	'subtitle' => esc_html__( 'Upload or choose a background image for the header area.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'header_bg_position_x',
	'label'    => esc_html__( 'Align Header Background', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => 'center',
	'priority' => 4.2,
	'choices'  => array(
		'center' => esc_html__( 'Centre', 'mharty' ),
		'right' => esc_html__( 'Right', 'mharty' ),
		'left' => esc_html__( 'Left', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'header_bg_position_y',
	'label'    => esc_html__( 'Align Header Background', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => 'center',
	'priority' => 4.3,
	'choices'  => array(
		'center' => esc_html__( 'Centre', 'mharty' ),
		'top' => esc_html__( 'Top', 'mharty' ),
		'bottom' => esc_html__( 'Bottom', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'header_bg_size',
	'label'    => esc_html__( 'Background Size', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => 'auto',
	'priority' => 4.4,
	'choices'  => array(
		'auto' => esc_html__( 'Auto', 'mharty' ),
		'cover' => esc_html__( 'Cover', 'mharty' ),
		'contain' => esc_html__( 'Contain', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'header_bg_repeat',
	'label'    => esc_html__( 'Repeat Background', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => 'no-repeat',
	'priority' => 4.5,
	'choices'  => array(
		'no-repeat' => esc_html__( 'No Repeat', 'mharty' ),
		'repeat-x' => esc_html__( 'Repeat X', 'mharty' ),
		'repeat-y' => esc_html__( 'Repeat Y', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'header_shadow',
	'label'    => esc_html__( 'Header Shadow', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => 0,
	'priority' => 4.6,
	'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'menu_font_size',
	'label'    => esc_html__( 'Main Menu Links Font Size', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => '14px',
	'priority' => 4.7,
	'subtitle' => esc_html__( 'Default is 14px, You could change it to your desired size.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'subnav_font_size',
	'label'    => esc_html__( 'Sub Navigation Links Font Size', 'mharty' ),
	'section'  => 'mh_primary_nav',
	'default'  => '14px',
	'priority' => 4.8,
	'subtitle' => esc_html__( 'Default is 14px, You could change it to your desired size.', 'mharty' ),
);
$controls[] = array(
'type' => 'checkbox',
	'setting' => 'hide_nav_menu',
	'label' => esc_html__( 'Hide Navigation links?', 'mharty' ),
	'section' => 'mh_primary_nav',
	'default'  => false,
	'priority' => 4.9,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'secondary_nav_position',
	'label'    => esc_html__( 'Secondary Navigation Position', 'mharty' ),
	'section'  => 'mh_secondary_nav',
	'default'  => 0,
	'priority' => 5.1,
	'choices'  => array(
		0 => esc_html__( 'Below', 'mharty' ),
		1 => esc_html__( 'Above', 'mharty' ),
	),
	'subtitle' => esc_html__( 'Choose the Position of your Secondary Navigation. The Secondary Navigation appears when it has some contents filled.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'show_header_social_icons',
	'label'    => esc_html__( 'Social Icons in Header', 'mharty' ),
	'section'  => 'mh_secondary_nav',
	'default'  => 0,
	'priority' => 5.2,
	'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
	'subtitle' => esc_html__( 'You may need to activate the desired icons from the theme panel.', 'mharty' ),
);

$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting' => 'show_header_date',
	'label' => esc_html__( 'Show Date', 'mharty' ),
	'section' => 'mh_secondary_nav',
	'default'  => 0,
	'priority' => 5.3,
    'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
	'subtitle' => esc_html__( 'You could change how your dates are displayed from the theme panel "Header Date format".', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'header_phrase',
	'label'    => esc_html__( 'Custom Phrase', 'mharty' ),
	'section'  => 'mh_secondary_nav',
	'priority' => 5.3,
	'subtitle' => esc_html__( 'Use this field to show custom phrase. Keep it short for better results.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'phone_number',
	'label'    => esc_html__( 'Phone Number', 'mharty' ),
	'section'  => 'mh_secondary_nav',
	'priority' => 5.4,
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'header_email',
	'label'    => esc_html__( 'Email', 'mharty' ),
	'section'  => 'mh_secondary_nav',
	'priority' => 5.5,
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'secondary_nav_font_size',
	'label'    => esc_html__( 'Secondary Navigation Font Size', 'mharty' ),
	'section'  => 'mh_secondary_nav',
	'default'  => '13px',
	'priority' => 5.6,
	'subtitle' => esc_html__( 'Default is 13px, You could change it to your desired size.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'secondary_nav_phone_icon',
	'label'    => esc_html__( 'Phone Icon', 'mharty' ),
	'section'  => 'mh_secondary_nav',
	'default'  => '',
	'priority' => 5.7,
	'subtitle' => mh_wp_kses( sprintf( __('%1$sClick here%2$s to go to the icons index. (Paste the code for your desired icon here).', 'mharty' ), '<a href="' . esc_url( add_query_arg( array( 'page' => 'mh_theme_icons' ), admin_url( 'admin.php' ) ) ) . '" target="_blank">', '</a>' )),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'secondary_nav_email_icon',
	'label'    => esc_html__( 'Email Icon', 'mharty' ),
	'section'  => 'mh_secondary_nav',
	'default'  => '',
	'priority' => 5.8,
	'subtitle' => mh_wp_kses( sprintf( __('%1$sClick here%2$s to go to the icons index. (Paste the code for your desired icon here).', 'mharty' ), '<a href="' . esc_url( add_query_arg( array( 'page' => 'mh_theme_icons' ), admin_url( 'admin.php' ) ) ) . '" target="_blank">', '</a>' )),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'secondary_nav_date_icon',
	'label'    => esc_html__( 'Date Icon', 'mharty' ),
	'section'  => 'mh_secondary_nav',
	'default'  => '',
	'priority' => 5.9,
	'subtitle' => mh_wp_kses( sprintf( __('%1$sClick here%2$s to go to the icons index. (Paste the code for your desired icon here).', 'mharty' ), '<a href="' . esc_url( add_query_arg( array( 'page' => 'mh_theme_icons' ), admin_url( 'admin.php' ) ) ) . '" target="_blank">', '</a>' )),
);
$controls[] = array(
	'type' => 'checkbox',
	'setting' => 'always_show_nav_menu',
	'label' => esc_html__( 'Always Show Menu?', 'mharty' ),
	'section' => 'mh_secondary_nav',
	'default'  => false,
	'priority' => 6,
	'subtitle' => esc_html__( 'Enable this option to show the Menu on small screens.', 'mharty' ),
);
$controls[] = array(
	'type' => 'checkbox',
	'setting' => 'app_menu',
	'label' => esc_html__( 'Enable App Menu?', 'mharty' ),
	'section' => 'mh_app_nav',
	'default'  => false,
	'priority' => 6.1,
	'subtitle' => esc_html__( 'This will enable the App-like menu.To mangae its content go to > Menus', 'mharty' ),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting' => 'app_style',
	'label' => esc_html__( 'App Menu Style', 'mharty' ),
	'section' => 'mh_app_nav',
	'default'  => 'side',
	'priority' => 6.2,
    'choices'  => array(
		'side' => esc_html__( 'Side', 'mharty' ),
		'overlay' => esc_html__( 'Overlay', 'mharty' ),
	),
	'subtitle' => esc_html__( 'Choose the desired style for your App menu.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'image',
	'setting'  => 'app_logo',
	'label'    => esc_html__( 'App menu Logo ', 'mharty' ),
	'section'  => 'mh_app_nav',
	'default'  => '',
	'priority' => 6.3,
	'subtitle' => esc_html__( 'Click the Upload Image button to upload or choose your logo for the app menu.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting' => 'app_tagline',
	'label' => esc_html__( 'Show Tagline', 'mharty' ),
	'section' => 'mh_app_nav',
	'default'  => 'show',
	'priority' => 6.4,
    'choices'  => array(
		'show' => esc_html__( 'Show', 'mharty' ),
		'hide' => esc_html__( 'Hide', 'mharty' ),
	),
	'subtitle' => esc_html__( 'Show or hide your site tagline i the app menu area.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'app_tagline_alt',
	'label'    => esc_html__( 'Custom Tagline', 'mharty' ),
	'section'  => 'mh_app_nav',
	'priority' => 6.5,
	'subtitle' => esc_html__( 'Use this field, if you want to show a custom tagline.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'app_phone_number',
	'label'    => esc_html__( 'Phone Number in App menu', 'mharty' ),
	'section'  => 'mh_app_nav',
	'priority' => 6.6,
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'app_email',
	'label'    => esc_html__( 'Email in App menu', 'mharty' ),
	'section'  => 'mh_app_nav',
	'priority' => 6.7,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'show_app_social_icons',
	'label'    => esc_html__( 'Social Icons in App menu', 'mharty' ),
	'section'  => 'mh_app_nav',
	'default'  => 0,
	'priority' => 6.8,
	'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
);
$controls[] = array(
	'type' => 'checkbox',
	'setting' => 'alwyas_show_app_menu',
	'label' => esc_html__( 'Always Show?', 'mharty' ),
	'section' => 'mh_app_nav',
	'default'  => true,
	'priority' => 6.9,
	'subtitle' => esc_html__( 'Disable this option to show the App Menu on small screens only.', 'mharty' ),
);
//end App menu
//Promo Bar
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'show_promo_bar',
	'label'    => esc_html__( 'Promo Bar', 'mharty' ),
	'section'  => 'mh_promo_bar',
	'default'  => 0,
	'priority' => 7.0,
	'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
	'subtitle' => esc_html__( 'If you have the Secondary Menu shown on your website this bar will overlay its current content until dismissed. Note: to change the position of the bar please change the Secondary Menu position.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'promo_bar_text',
	'label'    => esc_html__( 'Promo Bar Text', 'mharty' ),
	'section'  => 'mh_promo_bar',
	'priority' => 7.1,
	'subtitle' => esc_html__( 'Use this field to display a message on the Promo Bar. This field must be filled for the bar to be shown. Keep it short!', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'promo_bar_button_text',
	'label'    => esc_html__( 'Promo Bar Button Text', 'mharty' ),
	'section'  => 'mh_promo_bar',
	'priority' => 7.2,
	'subtitle' => esc_html__( 'If you want to show a button, put your link in the field below.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'promo_bar_button_url',
	'label'    => esc_html__( 'Promo Bar Button URL', 'mharty' ),
	'section'  => 'mh_promo_bar',
	'priority' => 7.3,
);
$controls[] = array(
	'type'     => 'select',
	'setting'  => 'promo_bar_animation',
	'label'    => esc_html__( 'Promo Bar Animation', 'mharty' ),
	'section'  => 'mh_promo_bar',
	'default'  => 'top',
	'priority' => 7.4,
	'choices'  => array(
		'top' => esc_html__( 'Top', 'mharty' ),
		'bottom' => esc_html__( 'Bottom', 'mharty' ),
		'scaleup' => esc_html__( 'Scale Up', 'mharty' ),
		'bouncein' => esc_html__( 'Bouncing', 'mharty' ),
	),
);
$controls[] = array(
	'type' => 'checkbox',
	'setting'  => 'show_promo_bar_once',
	'label' => esc_html__( 'Show Promo Bar Once Per Session?', 'mharty' ),
	'section'  => 'mh_promo_bar',
	'default'  => false,
	'priority' => 7.4,
	'subtitle' => esc_html__( 'Enable this option to show the Promo Bar once per browser session.', 'mharty' ),
);

//end Promo Bar
$controls[] = array(
	'type'     => 'text',
	'setting'  => 'cr_notice',
	'label'    => esc_html__( 'Website Copyrights', 'mharty' ),
	'section'  => 'mh_footer_settings',
	'priority' => 8.0,
	'subtitle' => esc_html__( 'Optional- Add Copyright notice to the footer of your site.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'footer_style',
	'label'    => esc_html__( 'Footer Style', 'mharty' ),
	'section'  => 'mh_footer_settings',
	'default'  => 'right',
	'priority' => 8.1,
	'choices'  => array(
		'right' => esc_html__( 'Side', 'mharty' ),
		'centered' => esc_html__( 'Centre', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'show_footer_social_icons',
	'label'    => esc_html__( 'Social Icons in Footer', 'mharty' ),
	'section'  => 'mh_footer_settings',
	'default'  => 0,
	'priority' => 8.2,
	'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
	'subtitle' => esc_html__( 'You may need to activate the desired icons from the theme panel.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'image',
	'setting'  => 'footer_bg_img',
	'label'    => esc_html__( 'Footer Background', 'mharty' ),
	'section'  => 'mh_footer_settings',
	'default'  => '',
	'priority' => 8.3,
	'subtitle' => esc_html__( 'Upload or choose a background image for the footer area.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'footer_bg_position_x',
	'label'    => esc_html__( 'Align Footer Background', 'mharty' ),
	'section'  => 'mh_footer_settings',
	'default'  => 'center',
	'priority' => 8.4,
	'choices'  => array(
		'center' => esc_html__( 'Centre', 'mharty' ),
		'right' => esc_html__( 'Right', 'mharty' ),
		'left' => esc_html__( 'Left', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'footer_bg_position_y',
	'label'    => esc_html__( 'Align Footer Background', 'mharty' ),
	'section'  => 'mh_footer_settings',
	'default'  => 'center',
	'priority' => 8.5,
	'choices'  => array(
		'center' => esc_html__( 'Centre', 'mharty' ),
		'top' => esc_html__( 'Top', 'mharty' ),
		'bottom' => esc_html__( 'Bottom', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'footer_bg_size',
	'label'    => esc_html__( 'Background Size', 'mharty' ),
	'section'  => 'mh_footer_settings',
	'default'  => 'auto',
	'priority' => 8.6,
	'choices'  => array(
		'auto' => esc_html__( 'Auto', 'mharty' ),
		'cover' => esc_html__( 'Cover', 'mharty' ),
		'contain' => esc_html__( 'Contain', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'footer_bg_repeat',
	'label'    => esc_html__( 'Repeat Background', 'mharty' ),
	'section'  => 'mh_footer_settings',
	'default'  => 'no-repeat',
	'priority' => 8.7,
	'choices'  => array(
		'no-repeat' => esc_html__( 'No Repeat', 'mharty' ),
		'repeat-x' => esc_html__( 'Repeat X', 'mharty' ),
		'repeat-y' => esc_html__( 'Repeat Y', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'accent_color',
	'label'    => esc_html__( 'Accent Colour', 'mharty' ),
	'section'  => 'colors',
	'default'  => '#44cdcd',
	'priority' => 1,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'font_color',
	'label'    => esc_html__( 'Main Font Colour', 'mharty' ),
	'section'  => 'colors',
	'default'  => '#666666',
	'priority' => 1.1,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'heading_color',
	'label'    => esc_html__( 'Heading Colour', 'mharty' ),
	'section'  => 'colors',
	'default'  => '#444444',
	'priority' => 1.2,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'link_color',
	'label'    => esc_html__( 'Link Colour', 'mharty' ),
	'section'  => 'colors',
	'default'  => get_theme_mod( 'accent_color', '#44cdcd' ),
	'priority' => 1.3,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'sidebar_heading_color',
	'label'    => esc_html__( 'Sidebar Heading Colour', 'mharty' ),
	'section'  => 'colors',
	'default'  => get_theme_mod( 'accent_color', '#44cdcd' ),
	'priority' => 1.4,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'sidebar_heading_alt_color',
	'label'    => esc_html__( 'Sidebar Heading Background Colour', 'mharty' ),
	'section'  => 'colors',
	'default'  => '#444444',
	'priority' => 1.5,
	'description' => esc_html__( 'This colour works with some of the Widget Header Styles. You could choose a style in "Site Settings".', 'mharty' ),
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'sidebar_link_color',
	'label'    => esc_html__( 'Sidebar Link Colour', 'mharty' ),
	'section'  => 'colors',
	'default'  => '#666666',
	'priority' => 1.5,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'primary_nav_bg',
	'label'    => esc_html__( 'Primary Navigation Background', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => '#ffffff',
	'priority' => 2.1,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'primary_nav_bg_gradient',
	'label'    => esc_html__( 'Primary Navigation Gradient', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => '',
	'priority' => 2.2,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'primary_nav_bg_gradient_dir',
	'label'    => esc_html__( 'Gradient Direction', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => 'left',
	'priority' => 2.3,
	'choices'  => array(
		'left' => esc_html__( 'Horizontal', 'mharty' ),
		'top' => esc_html__( 'Vertical', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'primary_nav_text_color',
	'label'    => esc_html__( 'Primary Navigation Text Colour', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => 'dark',
	'priority' => 2.4,
	'choices'  => array(
		'dark' => esc_html__( 'Dark', 'mharty' ),
		'light' => esc_html__( 'Light', 'mharty' ),
	),
	'subtitle' => esc_html__( 'If you choose light option it will override "Menu Links Colour" option below.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'menu_link',
	'label'    => esc_html__( 'Menu Links Colour', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => '#666666',
	'priority' => 2.5,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'menu_icons',
	'label'    => esc_html__( 'Menu Icons Colour', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => 'rgba(0, 0, 0, 0.4)',
	'priority' => 2.6,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'menu_link_bg',
	'label'    => esc_html__( 'Menu Link Background', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => '',
	'priority' => 2.7,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'menu_link_active',
	'label'    => esc_html__( 'Active Menu Link Colour', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => get_theme_mod( 'accent_color', '#44cdcd' ),
	'priority' => 2.8,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'menu_link_active_bg',
	'label'    => esc_html__( 'Active Menu Link Background', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => '',
	'priority' => 2.9,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'enable_menu_link_sep_color',
	'label'    => esc_html__( 'Menu Link Separator', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => 0,
	'priority' => 3,
	'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'menu_link_sep_color',
	'label'    => esc_html__( 'Menu Link Separator Colour', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => '#e2e2e2',
	'priority' => 3.1,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'primary_subnav_bg',
	'label'    => esc_html__( 'Sub Navigation Background', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => '',
	'priority' => 3.2,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'primary_subnav_text_color',
	'label'    => esc_html__( 'Sub Navigation Text Colour', 'mharty' ),
	'section'  => 'mh_primary_colors',
	'default'  => 'dark',
	'priority' => 3.3,
	'choices'  => array(
		'dark' => esc_html__( 'Dark', 'mharty' ),
		'light' => esc_html__( 'Light', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'secondary_nav_bg',
	'label'    => esc_html__( 'Secondary Navigation Background', 'mharty' ),
	'section'  => 'mh_secondary_colors',
	'default'  => get_theme_mod( 'accent_color', '#44cdcd' ),
	'priority' => 4.1,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'secondary_nav_border_active',
	'label'    => esc_html__( 'Secondary Navigation Separator', 'mharty' ),
	'section'  => 'mh_secondary_colors',
	'default'  => 0,
	'priority' => 4.2,
	'choices'  => array(
		0 => esc_html__( 'Hide', 'mharty' ),
		1 => esc_html__( 'Show', 'mharty' ),
	),
	'subtitle' => esc_html__( 'Enable this option to display a separator line for the secondary navigation. Use the option below to choose your desired colour.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'secondary_nav_border',
	'label'    => esc_html__( 'Secondary Navigation Separator Colour', 'mharty' ),
	'section'  => 'mh_secondary_colors',
	'default'  => get_theme_mod( 'accent_color', '#44cdcd' ),
	'priority' => 4.3,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'secondary_nav_text_color',
	'label'    => esc_html__( 'Secondary Navigation Text Colour', 'mharty' ),
	'section'  => 'mh_secondary_colors',
	'default'  => 'light',
	'priority' => 4.4,
	'choices'  => array(
		'light' => esc_html__( 'Light', 'mharty' ),
		'dark' => esc_html__( 'Dark', 'mharty' ),
		'custom' => esc_html__( 'Custom', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'secondary_nav_text_color_custom',
	'label'    => esc_html__( 'Secondary Navigation Custom Text Colour', 'mharty' ),
	'section'  => 'mh_secondary_colors',
	'default'  => get_theme_mod( 'accent_color', '#44cdcd' ),
	'priority' => 4.5,
	'subtitle' => esc_html__( 'This option works if you choose "Custom" in the option above.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'app_menu_bg',
	'label'    => esc_html__( 'App Menu Background', 'mharty' ),
	'section'  => 'mh_app_colors',
	'default'  => '#f4f4f4',
	'priority' => 5.1,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'app_menu_text_color',
	'label'    => esc_html__( 'App Menu Text Colour', 'mharty' ),
	'section'  => 'mh_app_colors',
	'default'  => 'dark',
	'priority' => 5.1,
	'choices'  => array(
		'dark' => esc_html__( 'Dark', 'mharty' ),
		'light' => esc_html__( 'Light', 'mharty' ),
	),
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'promo_bar_bg',
	'label'    => esc_html__( 'Promo Bar Background Colour', 'mharty' ),
	'section'  => 'mh_promo_colors',
	'default'  => get_theme_mod( 'accent_color', '#44cdcd' ),
	'priority' => 6.1,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'promo_bar_text_color',
	'label'    => esc_html__( 'Promo Bar Text Colour', 'mharty' ),
	'section'  => 'mh_promo_colors',
	'default'  => '#ffffff',
	'priority' => 6.2,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'promo_bar_button_bg',
	'label'    => esc_html__( 'Promo Bar Button Colour', 'mharty' ),
	'section'  => 'mh_promo_colors',
	'default'  => '#ffffff',
	'priority' => 6.3,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'promo_bar_button_text_color',
	'label'    => esc_html__( 'Promo Bar Button Text Colour', 'mharty' ),
	'section'  => 'mh_promo_colors',
	'default'  => get_theme_mod( 'accent_color', '#44cdcd' ),
	'priority' => 6.4,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'footer_widgets_bg',
	'label'    => esc_html__( 'Footer Background Colour (Widgets)', 'mharty' ),
	'section'  => 'mh_footer_colors',
	'default'  => '#383838',
	'priority' => 7.1,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'footer_widget_heading_color',
	'label'    => esc_html__( 'Widgets Heading Colour', 'mharty' ),
	'section'  => 'mh_footer_colors',
	'default'  => get_theme_mod( 'accent_color', '#44cdcd' ),
	'priority' => 7.2,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'footer_widget_heading_alt_color',
	'label'    => esc_html__( 'Widgets Heading Background Colour', 'mharty' ),
	'section'  => 'mh_footer_colors',
	'default'  => '#ffffff',
	'priority' => 7.3,
	'description' => esc_html__( 'This colour works with some of the Widget Header Styles. You could choose a style in "Site Settings".', 'mharty' ),
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'footer_widgets_color',
	'label'    => esc_html__( 'Widgets Text Colour', 'mharty' ),
	'section'  => 'mh_footer_colors',
	'default'  => '#ffffff',
	'priority' => 7.4,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'footer_widgets_color_link',
	'label'    => esc_html__( 'Widgets Link Colour', 'mharty' ),
	'section'  => 'mh_footer_colors',
	'default'  => '#ffffff',
	'priority' => 7.5,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'footer_bg',
	'label'    => esc_html__( 'Footer Background Colour', 'mharty' ),
	'section'  => 'mh_footer_colors',
	'default'  => '#1b1b1b',
	'priority' => 7.6,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'footer_color',
	'label'    => esc_html__( 'Footer Text Colour', 'mharty' ),
	'section'  => 'mh_footer_colors',
	'default'  => '#5c5a5a',
	'priority' => 7.7,
);
$controls[] = array(
	'type'     => 'color',
	'setting'  => 'footer_color_link',
	'label'    => esc_html__( 'Footer Link Colour', 'mharty' ),
	'section'  => 'mh_footer_colors',
	'default'  => '#747474',
	'priority' => 7.8,
);
$controls[] = array(
	'type'     => 'radio',
	'mode'     => 'buttonset',
	'setting'  => 'footer_social_icons_color',
	'label'    => esc_html__( 'Footer Social Icons Colour', 'mharty' ),
	'section'  => 'mh_footer_colors',
	'default'  => 'dark',
	'priority' => 7.9,
	'choices'  => array(
		'dark' => esc_html__( 'Dark', 'mharty' ),
		'light' => esc_html__( 'Light', 'mharty' ),
		'color' => esc_html__( 'Colours', 'mharty' ),
	),
);
$controls[] = array(
'type' => 'color',
	'setting' => 'background_color',
	'label' => esc_html__( 'Background Colour', 'mharty' ),
	'section' => 'background_image',
	'priority' => 2.1,
);
$controls[] = array(
	'type' => 'checkbox',
	'setting' => 'cover_background',
	'label' => esc_html__( 'Stretch Background Image', 'mharty' ),
	'section' => 'background_image',
	'priority' => 22,
);
$controls[] = array(
	'type' => 'checkbox',
	'setting' => 'fix_transparent_bg',
	'label' => esc_html__( 'Fix Transparent', 'mharty' ),
	'section' => 'background_image',
	'default'  => false,
	'priority' => 23,
	'subtitle' => esc_html__( '(Optional) This is a fix for trnasparent background when custom background images is used.', 'mharty' ),
);
$controls[] = array(
	'type'     => 'textarea',
	'setting'  => 'customizer_custom_css',
	'label'    => esc_html__( 'Custom CSS', 'mharty' ),
	'section'  => 'mh_advanced',
	'priority' => 3.3,
	'subtitle' => esc_html__( 'Here you can add custom css to override or extend default styles.', 'mharty' ),
);
return $controls;
}
add_filter( 'mh_customizer/controls', 'mh_mharty_customize_setting' ); 

function mh_mharty_add_customizer_css(){ ?>
<style class="mh_custmoizer_css" type="text/css">
a, .nav-single a, .product_meta a, .wpcf7-form p span { color: <?php echo esc_html( get_theme_mod( 'link_color', get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?>; }
body { color: <?php echo esc_html( get_theme_mod( 'font_color', '#666666' ) ); ?>; }
h1, h2, h3, h4, h5, h6 { color: <?php echo esc_html( get_theme_mod( 'heading_color', '#444444' ) ); ?>; }
.mhc_blurb a .mhc_blurb_content p {color: <?php echo esc_html( get_theme_mod( 'font_color', '#666666' ) ); ?>;}
.mhc_widget a { color: <?php echo esc_html( get_theme_mod( 'sidebar_link_color', '#666666' ) ); ?>;}
.widgettitle { color: <?php echo esc_html( get_theme_mod( 'sidebar_heading_color', get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?>;}
.mh_widget_title_style_line .widgettitle, .mh_widget_title_style_border .widgettitle, .mh_widget_title_style_smallborder .widgettitle{ border-color: <?php echo esc_html( get_theme_mod( 'sidebar_heading_color', get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?>;}
.mh_widget_title_style_box .widgettitle, .mh_widget_title_style_arrow .widgettitle{ background-color: <?php echo esc_html( get_theme_mod( 'sidebar_heading_alt_color', '#444444' ) ); ?>;}
 .mh_widget_title_style_arrow .widgettitle:after{ border-top-color:<?php echo esc_html( get_theme_mod( 'sidebar_heading_alt_color', '#444444' ) ); ?>;}

<?php 
$post_id = get_the_ID();
$page_menu_color = ( $menu_color = esc_html( get_post_meta( $post_id, '_mhc_page_menu_color', true ) ) ) && '' !== $menu_color ? $menu_color
: '#ffffff';
$page_bg_color = ( $bg_color = esc_html( get_post_meta( $post_id, '_mh_page_bg_color', true ) ) ) && '' !== $bg_color ? $bg_color
: '#ffffff';
if ('#ffffff' !== $bg_color ){ ?>
body{background-color:<?php  echo $bg_color;?>}
<?php }
if ('1' !== get_theme_mod( 'use_logo_text', '0' ) && 'right' === get_theme_mod( 'header_style', 'right') ){
$logo_dir = is_rtl() ? 'right' : 'left'; ?>
.mh_logo{ float:<?php echo $logo_dir;?>;}
<?php }
if ( ('#ffffff' !== $page_menu_color ) && '1' !== get_theme_mod( 'vertical_nav', '0' ) ){?>
@media only screen and ( min-width: 981px ) {
.page-template-page-template-trans #main-header.transparent #top-menu .menu-item > a:first-child, .page-template-page-template-trans #main-header.transparent #mh-top-navigation .mh-cart-info, .page-template-page-template-trans #mh-top-navigation .mh_search_icon, .page-template-page-template-trans #mh-top-navigation .app-nav-trigger-icon {color:<?php  echo $page_menu_color;?>}
}
#main-header.transparent #top-menu .sub-menu .menu-item > a:first-child{color:inherit;}
<?php }?>

.mhc_counter_amount, .mhc_pricing_default .mhc_featured_table .mhc_pricing_heading, .mh_quote_content, .mh_link_content, .mh_audio_content{ background-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#44cdcd' ) ); ?>; }

<?php if ( '1' === get_theme_mod( 'header_shadow', '0' ) ) : ?>
#main-header{
box-shadow: 0 0 3px 0 rgba(0, 0, 0, 0.22); -moz-box-shadow: 0 0 3px 0 rgba(0, 0, 0, 0.22); -webkit-box-shadow: 0 0 3px 0 rgba(0, 0, 0, 0.22);}
.mh_vertical_nav #main-header{
-moz-box-shadow: 0 0 7px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 0 0 7px rgba(0, 0, 0, 0.1); box-shadow: 0 0 7px rgba(0, 0, 0, 0.1); }
<?php endif; ?>
<?php if ( '14px' !== get_theme_mod( 'menu_font_size', '14px' ) ) : ?>
#top-menu > li > a, .fullwidth-menu > li > a{font-size: <?php echo esc_attr( get_theme_mod( 'menu_font_size', '14px' ) );?>;}
<?php endif; ?>
<?php if ( '14px' !== get_theme_mod( 'subnav_font_size', '14px' ) ) : ?>
	 #top-menu li li a, .fullwidth-menu li li a{font-size: <?php echo esc_attr( get_theme_mod( 'subnav_font_size', '14px' ) );?>;}
<?php endif; ?>

<?php if ( '13px' !== get_theme_mod( 'secondary_nav_font_size', '13px' ) ) : ?>
#top-header, #mh-secondary-nav li li a{ font-size: <?php echo esc_attr( get_theme_mod( 'secondary_nav_font_size', '13px' ) );?>;}
<?php endif; ?>
#main-header, #main-header .nav li ul, .mh-search-form, #main-header .mh_mobile_menu{ background-color: <?php echo esc_html( get_theme_mod( 'primary_nav_bg', '#ffffff' ) ); ?>; }
@media only screen and ( max-width: 979px ) {
body.page-template-page-template-trans #main-header {
        background-color: <?php echo esc_html( get_theme_mod( 'primary_nav_bg', '#ffffff' ) ); ?>!important;
    }
}
body.page-template-page-template-trans #main-header.mh-fixed-header{background-color: <?php echo esc_html( get_theme_mod( 'primary_nav_bg', '#ffffff' ) ); ?> !important;}
<?php if ( '' !== get_theme_mod( 'primary_subnav_bg', '' ) ) : ?>
#main-header .nav li ul, .mh-search-form, #main-header .mh_mobile_menu { background-color: <?php echo esc_html( get_theme_mod( 'primary_subnav_bg', '#ffffff' ) ); ?>; }
<?php endif; ?>

<?php if ( '' !== get_theme_mod( 'primary_nav_bg_gradient', '' ) ) : 
$bg_color = esc_html( get_theme_mod( 'primary_nav_bg', '#ffffff' ) );
$gr_color =  esc_html( get_theme_mod( 'primary_nav_bg_gradient', '#ffffff' ) );
if ( 'left' === get_theme_mod( 'primary_nav_bg_gradient_dir', '#ffffff' ) ){ ?>
#main-header { 
background:<?php  echo $bg_color;?>;
background: -moz-linear-gradient(left, <?php  echo $bg_color;?> 0%, <?php  echo $gr_color;?> 100%);
background: -webkit-gradient(linear, left top, right top, color-stop(0%, <?php  echo $bg_color;?>), color-stop(100%, <?php  echo $gr_color;?>));
background: -webkit-linear-gradient(left, <?php  echo $bg_color;?> 0%, <?php  echo $gr_color;?> 100%);
background: -o-linear-gradient(left, <?php  echo $bg_color;?> 0%, <?php  echo $gr_color;?> 100%);
background: -ms-linear-gradient(left, <?php  echo $bg_color;?> 0%, <?php  echo $gr_color;?> 100%);
background: linear-gradient(to right, <?php  echo $bg_color;?> 0%, <?php  echo $gr_color;?> 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php  echo $bg_color;?>', endColorstr='<?php  echo $gr_color;?>',GradientType=1 );}
<?php }else{?>
#main-header { 
background:<?php  echo $bg_color;?>;
background: -moz-linear-gradient(top <?php  echo $bg_color;?> 0%, <?php  echo $gr_color;?> 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php  echo $bg_color;?>), color-stop(100%, <?php  echo $gr_color;?>));
background: -webkit-linear-gradient(top, <?php  echo $bg_color;?> 0%, <?php  echo $gr_color;?> 100%);
background: -o-linear-gradient(top, <?php  echo $bg_color;?> 0%, <?php  echo $gr_color;?> 100%);
background: -ms-linear-gradient(top, <?php  echo $bg_color;?> 0%, <?php  echo $gr_color;?> 100%);
background: linear-gradient(to bottom, <?php  echo $bg_color;?> 0%, <?php  echo $gr_color;?> 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php  echo $bg_color;?>', endColorstr='<?php  echo $gr_color;?>',GradientType=0 );}
<?php } endif; ?>
#top-header, #mh-secondary-nav li ul { background-color: <?php echo esc_html( get_theme_mod( 'secondary_nav_bg',  get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?>; }
#top-header .mh-cart-count { color:<?php echo esc_html( get_theme_mod( 'secondary_nav_bg',  get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?> !Important;}
<?php if ( 'custom' === get_theme_mod( 'secondary_nav_text_color', 'light' )) {?>
#mh-info a,
#mh-info span,
#mh-secondary-nav a,
#top-header .mh-social-icon a,
#mh-secondary-menu .mh-cart-icon{
    color:<?php echo esc_html( get_theme_mod( 'secondary_nav_text_color_custom', get_theme_mod( 'accent_color', '#44cdcd' )) ); ?> !important;
	border-color:<?php echo esc_html( get_theme_mod( 'secondary_nav_text_color_custom', get_theme_mod( 'accent_color', '#44cdcd' )) ); ?> !important;
}
#mh-secondary-menu .mh-cart-count{
	background-color:<?php echo esc_html( get_theme_mod( 'secondary_nav_text_color_custom', get_theme_mod( 'accent_color', '#44cdcd' )) ); ?> !important;
}
#mh-info a:hover,
#mh-secondary-nav a:hover,
#top-header .mh-social-icon a:hover,
#mh-secondary-menu .mh-cart-info:hover{
	opacity:0.85;
}
<?php } ?>
<?php if ( '1' === get_theme_mod( 'secondary_nav_border_active', '0' )) : 
if ( '1' === get_theme_mod( 'secondary_nav_position', '0' ) ){?>
#top-header{ border-bottom:2px solid <?php echo esc_html( get_theme_mod( 'secondary_nav_border', get_theme_mod( 'accent_color', '#44cdcd' )) ); ?>;}
<?php }else{ ?>
#top-header{ border-top:2px solid <?php echo esc_html( get_theme_mod( 'secondary_nav_border', get_theme_mod( 'accent_color', '#44cdcd' )) ); ?>;}
<?php } endif; ?>

.woocommerce a.button.alt, .woocommerce-page a.button.alt, .woocommerce button.button.alt, .woocommerce-page button.button.alt, .woocommerce input.button.alt, .woocommerce-page input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce-page #respond input#submit.alt, .woocommerce #content input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce a.button, .woocommerce-page a.button, .woocommerce button.button, .woocommerce-page button.button, .woocommerce input.button, .woocommerce-page input.button, .woocommerce #respond input#submit, .woocommerce-page #respond input#submit, .woocommerce #content input.button, .woocommerce-page #content input.button, .woocommerce-message, .woocommerce-error, .woocommerce-info ,.mhc_filterable_portfolio .mhc_portfolio_filters li a span,.mhc_button_solid, .mhc_wpcf7_solid .wpcf7-form input[type="submit"], .mh-tags .tag-links a, .bbp-topic-tags a, .nav li a em, .menu li a em, .mh_adjust_bg{ background: <?php echo esc_html( get_theme_mod( 'accent_color', '#44cdcd') ); ?> !important; }
.mh-social-accent-color.mh-social-solid-color li, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle{background-color:<?php echo esc_html( get_theme_mod( 'accent_color', '#44cdcd') ); ?>;}
.comment-reply-link, .form-submit input, .mhc_pricing_default .mhc_sum, .mhc_pricing li a, .mhc_pricing_default .mhc_pricing_table_button.mhc_button_transparent, .entry-summary p.price ins, .woocommerce div.product span.price, .woocommerce-page div.product span.price, .woocommerce #content div.product span.price, .woocommerce-page #content div.product span.price, .woocommerce div.product p.price, .woocommerce-page div.product p.price, .woocommerce #content div.product p.price, .woocommerce-page #content div.product p.price, .mh-loveit-container .mh-loveit.loved.mh_share_accent .icon-icon_heart, .mh_password_protected_form .mh_submit_button, .bbp-submit-wrapper button.button, #main-header .header-name, .mh_widget_info_inner p i, button.mhc_search_bar_submit i, .mh-social-accent-color li a{ color: <?php echo esc_html( get_theme_mod( 'accent_color', '#44cdcd') ); ?> !important; }
.woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before, .mhc_widget li a:hover, .mhc_bg_layout_light .mhc_promo_button.mhc_transify, .mhc_bg_layout_light .mhc_more_button, .mhc_filterable_portfolio .mhc_portfolio_filters li a.active, .mhc_filterable_portfolio .mhc_portofolio_pagination ul li a.active, .mhc_gallery .mhc_gallery_pagination ul li a.active, .wp-pagenavi span.current, .wp-pagenavi a:hover, .mhc_contact_submit.mhc_button_transparent,.mhc_wpcf7_transparent .wpcf7-form input[type="submit"], .mhc_bg_layout_light .mhc_newsletter_button, .mhc_bg_layout_light .mhc_mailpoet_form .wysija-submit, .bbp-topics-front ul.super-sticky:after, .bbp-topics ul.super-sticky:after, .bbp-topics ul.sticky:after, .bbp-forum-content ul.sticky:after{ color: <?php echo esc_html( get_theme_mod( 'accent_color', '#44cdcd') ); ?> !important; }
blockquote, .footer-widget li:before, .mhc_pricing_default .mhc_pricing li:before, .mhc_button_solid, .mhc_wpcf7_solid .wpcf7-form input[type="submit"], .mh_password_protected_form .mh_submit_button, #bbpress-forums .bbp-forums-list, .bbp-topics-front ul.super-sticky, #bbpress-forums li.bbp-body ul.topic.super-sticky, #bbpress-forums li.bbp-body ul.topic.sticky, .bbp-forum-content ul.sticky, .mhc_pricing_neon .mhc_featured_table, .mh-social-accent-color li, .mhc_contact_submit_message{ border-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#44cdcd') ); ?>; }
#bbpress-forums .hentry div.bbp-reply-content:before, #bbpress-forums .hentry div.bbp-topic-content:before{border-right-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#44cdcd') ); ?>;}
.rtl #bbpress-forums .hentry div.bbp-reply-content:before, .rtl #bbpress-forums .hentry div.bbp-topic-content:before{
border-left-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#44cdcd') ); ?>;
border-right-color:transparent;}

#main-footer { background-color: <?php echo esc_html( get_theme_mod( 'footer_widgets_bg', '#383838' ) ); ?>; }
#footer-bottom{ background-color: <?php echo esc_html( get_theme_mod( 'footer_bg', '#1b1b1b' ) ); ?>; }

.footer-widget{ color: <?php echo esc_html( get_theme_mod( 'footer_widgets_color', '#ffffff' ) ); ?>;}
.footer-widget a, .bottom-nav a, #footer-widgets .footer-widget li a{ color: <?php echo esc_html( get_theme_mod( 'footer_widgets_color_link', '#ffffff' ) ); ?>;}

.footer-widget h4.title { color: <?php echo esc_html( get_theme_mod( 'footer_widget_heading_color', get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?>;}
.mh_widget_title_style_line .footer-widget h4.title, .mh_widget_title_style_border .footer-widget h4.title, .mh_widget_title_style_smallborder .footer-widget h4.title{ border-color: <?php echo esc_html( get_theme_mod( 'footer_widget_heading_color', get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?>;}
.mh_widget_title_style_box .footer-widget h4.title, .mh_widget_title_style_arrow .footer-widget h4.title{ background-color: <?php echo esc_html( get_theme_mod( 'footer_widget_heading_alt_color', '#ffffff' ) ); ?>;}
 .mh_widget_title_style_arrow .footer-widget h4.title::after{ border-top-color:<?php echo esc_html( get_theme_mod( 'footer_widget_heading_alt_color', '#ffffff' ) ); ?>;}
 
#footer-info{ color: <?php echo esc_html( get_theme_mod( 'footer_color', '#5c5a5a' ) ); ?>;}
#footer-info a { color: <?php echo esc_html( get_theme_mod( 'footer_color_link', '#747474' ) ); ?>;}

#top-menu a, #main-header .header-tagline { color: <?php echo esc_html( get_theme_mod( 'menu_link', '#666666' ) ); ?>; }
#mh-top-navigation .app-nav-trigger-icon, #mh-top-navigation .mh_search_icon, #mh-top-navigation .mobile_menu_bar, #mh-top-navigation .mh-cart-icon  { color: <?php echo esc_html( get_theme_mod( 'menu_icons', 'rgba(0, 0, 0, 0.4)' ) ); ?>; }

#top-menu > li.current-menu-ancestor > a, #top-menu > li.current-menu-item > a, .mh_nav_text_color_light #top-menu li.current-menu-ancestor > a, .mh_nav_text_color_light .mh_nav_text_color_light #top-menu li.current-menu-item > a{ color: <?php echo esc_html( get_theme_mod( 'menu_link_active', get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?>; }
<?php if ('' !== get_theme_mod( 'menu_link_bg', '' )){ ?>
#top-menu > li{background-color: <?php echo esc_html( get_theme_mod( 'menu_link_bg', '' ) ); ?>; }
<?php } ?>
<?php if ('' !== get_theme_mod( 'menu_link_active_bg', '' )){ ?>
#top-menu > li.current-menu-ancestor, #top-menu > li.current-menu-item { background-color: <?php echo esc_html( get_theme_mod( 'menu_link_active_bg', '' ) ); ?> !important; }
<?php }else{ ?>
#top-menu > li.current-menu-ancestor, #top-menu > li.current-menu-item { background-color: transparent !important; }
<?php }
if ( '1' === get_theme_mod( 'enable_menu_link_sep_color', '0' ) ) :
if (is_rtl()){ ?>
#top-menu > li{border-left: 1px solid <?php echo esc_html( get_theme_mod( 'menu_link_sep_color', '#e2e2e2' ) ); ?>;}
<?php }else{ ?>
#top-menu > li{border-right: 1px solid <?php echo esc_html( get_theme_mod( 'menu_link_sep_color', '#e2e2e2' ) ); ?>;}
<?php } endif; ?>
<?php if ( '' !== get_theme_mod( 'menu_link_bg', '' )  && '' !== get_theme_mod( 'menu_link_active_bg', '' )) : ?>
#top-menu > li:hover{ background-color: <?php echo esc_html( get_theme_mod( 'menu_link_active_bg', '' ) ); ?>;}
#top-menu > li:hover > a, .mh_nav_text_color_light #top-menu li:hover > a{color: <?php echo esc_html( get_theme_mod( 'menu_link_active', get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?>;}

<?php endif; ?>

<?php if ( '' !== get_theme_mod( 'header_bg_img', '' ) && !is_page_template( 'page-template-trans.php' ) ) : ?>
#main-header { 	
background-image: url('<?php echo esc_html( get_theme_mod( 'header_bg_img', ' ' ) ); ?>');
background-position:
<?php echo esc_html( get_theme_mod( 'header_bg_position_x', 'center' ) .' '. get_theme_mod( 'header_bg_position_y', 'center' )); ?>;
background-repeat:<?php echo esc_html( get_theme_mod( 'header_bg_repeat', 'no-repeat' ) ); ?> ; 
background-size:<?php echo esc_html( get_theme_mod( 'header_bg_size', 'auto' ) ); ?> ;}
<?php endif; ?>
<?php if ( '' !== get_theme_mod( 'footer_bg_img', '' )) :
$footer_bg = esc_html( get_theme_mod( 'footer_bg', '#1b1b1b' ) );
$footer_bg_color = hex2rgb($footer_bg); ?>
#main-footer { 	
background-image: url('<?php echo esc_html( get_theme_mod( 'footer_bg_img', ' ' ) ); ?>');
background-position: <?php echo esc_html( get_theme_mod( 'footer_bg_position_x', 'center' ) .' '. get_theme_mod( 'footer_bg_position_y', 'center' )); ?>;
background-repeat:<?php echo esc_html( get_theme_mod( 'footer_bg_repeat', 'no-repeat' ) ); ?> ; 
background-size:<?php echo esc_html( get_theme_mod( 'footer_bg_size', 'auto' ) ); ?> ;}
#footer-bottom { background-color: rgba(<?php echo $footer_bg_color; ?>, 0.5);}
<?php endif; ?>

<?php if ( '' !== get_theme_mod( 'header_padding_top', '' ) ) : ?>
#main-header { padding-top:<?php echo esc_html( get_theme_mod( 'header_padding_top', '' ) ); ?>px;}
<?php endif; ?>
<?php if ( '' !== get_theme_mod( 'header_padding_bottom', '' ) ) : ?>
#main-header { padding-bottom:<?php echo esc_html( get_theme_mod( 'header_padding_bottom', '' ) ); ?>px;}
<?php endif; ?>

.mh-app-nav { background-color: <?php echo esc_html( get_theme_mod( 'app_menu_bg', '#f4f4f4' ) ); ?>; }
<?php
if ( '' !== ( $mharty_xl_logo = esc_attr( get_theme_mod( 'xl_logo', '' ) ) ) ) {
if ( false === get_theme_mod( 'header_padding', false )){
		$xl_logo = (int) $mharty_xl_logo; ?>
#logo{
	max-height: <?php  echo $xl_logo;?>px;
}
.mh_logo,
#top-menu > li > a,
.fullwidth-menu > li > a,
.mh_search_icon:before,
.app-nav-trigger-icon:before,
.mh-cart-icon:after {
  line-height: <?php  echo $xl_logo*2;?>px;
}
.mobile_menu_bar {
  line-height: <?php  echo $xl_logo*2;?>px;
}
.mh_logo {
  height: <?php  echo $xl_logo*2;?>px;
}
.mh_logo img {
  padding: <?php  echo $xl_logo/2;?>px 0;
}
#top-menu li.mega-menu > ul,
.fullwidth-menu-nav li.mega-menu > ul,
.mh_mobile_menu,
.mh-search-form,
.nav li ul {
  top: <?php  echo $xl_logo*2;?>px;
}
#top-menu .menu-item-has-children > a:first-child:after,
.fullwidth-menu .menu-item-has-children > a:first-child:after {
  line-height: <?php  echo $xl_logo*2;?>px;
}
.mh_header_style_centered #top-menu li.mega-menu > ul,
.mh_header_style_centered .fullwidth-menu-nav li.mega-menu > ul,
.mh_header_style_centered .mh-search-form{
  top: <?php  echo $xl_logo*4;?>px;
}
<?php
}else{
	$xl_logo = (int) $mharty_xl_logo; ?>
	
<?php if ( '' !== get_theme_mod( 'header_padding_top', '' ) ) : ?>
#main-header.mh-fixed-header { padding-top:<?php echo (esc_attr( get_theme_mod( 'header_padding_top', '' ) ) / 2) ?>px;}
<?php endif; ?>
<?php if ( '' !== get_theme_mod( 'header_padding_bottom', '' ) ) : ?>
#main-header.mh-fixed-header { padding-bottom:<?php echo (esc_attr( get_theme_mod( 'header_padding_bottom', '' ) ) / 2) ?>px;}
<?php endif; ?>


#logo{
	max-height: <?php  echo $xl_logo;?>px;
}
.mh_logo{
	line-height: <?php  echo $xl_logo;?>px;
	height: <?php  echo $xl_logo;?>px;
}
.mh_logo img, .mh-fixed-header #logo {
  padding:0;
}

#top-menu > li > a,
.fullwidth-menu > li > a,
#top-menu .menu-item-has-children > a:first-child:after,
.fullwidth-menu .menu-item-has-children > a:first-child:after {
  line-height: 34px;
}

.mh_search_icon:before,
.app-nav-trigger-icon:before,
.mh-cart-icon:after,
.mobile_menu_bar::before{
	line-height: <?php  echo $xl_logo;?>px;
}
.mobile_menu_bar{ margin:0;}
#top-menu > li,
.fullwidth-menu > li {
margin-top:<?php  echo ($xl_logo - 34)/2;?>px;
margin-bottom:<?php  echo ($xl_logo - 34)/2;?>px;
}

.mh-fixed-header #top-menu > li,
.mh-fixed-header .fullwidth-menu > li {
margin-top:14px;
margin-bottom:0;
}

#top-menu li.mega-menu > ul,
.fullwidth-menu-nav li.mega-menu > ul,
.mh_mobile_menu,
.mh-search-form,
.nav li ul {
top: auto;
}

.mh_header_style_centered #top-menu > li > a,
.mh_header_style_centered .fullwidth-menu > li > a,
.mh_header_style_centered #top-menu .menu-item-has-children > a:first-child:after,
.mh_header_style_centered .fullwidth-menu .menu-item-has-children > a:first-child:after {
  line-height: 34px;
}

.mh_header_style_centered #top-menu ul .menu-item-has-children > a:first-child:after,
.mh_header_style_centered .fullwidth-menu ul .menu-item-has-children > a:first-child:after {
  line-height: 25px;
}
.mh_header_style_centered #top-menu li.mega-menu > ul,
.mh_header_style_centered .fullwidth-menu-nav li.mega-menu > ul,
.mh_header_style_centered .mh-search-form,
.mh_header_style_centered .nav li ul{
	top: auto;
}

.mh_header_style_centered .mh_mobile_menu{
	top: 36px;
}

.mh-fixed-header #top-menu > li > a,
.mh-fixed-header .app-nav-trigger-icon::before,
.mh-fixed-header .fullwidth-menu > li > a,
.mh-fixed-header .mh-cart-icon::after,
.mh-fixed-header .mh_logo,
.mh-fixed-header .mh_search_icon::before,
.mh-fixed-header .mobile_menu_bar::before,
.mh-fixed-header #top-menu .menu-item-has-children > a:first-child::after{
	line-height: 25px;
}


.mh-fixed-header .app-nav-trigger-icon::before,
.mh-fixed-header .mh-cart-icon::after,
.mh-fixed-header .mh_search_icon::before,
.mh-fixed-header .mobile_menu_bar::before {
    vertical-align:middle;
	line-height:50px;
}
.mobile_menu_bar{
	transition: all 0.3s ease-in-out 0s;
}
<?php
}
}
if ( '1' === get_theme_mod( 'show_promo_bar', '0' ) ) :?>
.mh-promo { background-color: <?php echo esc_html( get_theme_mod( 'promo_bar_bg', get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?>;  }
.mh-promo .mh-promo-close, .mh-promo .mh-promo-inner p{ color: <?php echo esc_html( get_theme_mod( 'promo_bar_text_color', '#ffffff' ) ); ?>; }
.mh-promo .mh-promo-inner a{ background-color: <?php echo esc_html( get_theme_mod( 'promo_bar_button_bg', '#ffffff' ) ); ?>; color: <?php echo esc_html( get_theme_mod( 'promo_bar_button_text_color', get_theme_mod( 'accent_color', '#44cdcd' ) ) ); ?>; }
<?php
endif;
if ( false === get_theme_mod( 'always_show_nav_menu', false )){?>
@media only screen and ( max-width: 980px ) { #mh-secondary-nav, #mh-secondary-menu .mh-cart-info { display: none; } }
<?php }else{ ?>
@media only screen and ( max-width: 980px ) {.mh_secondary_nav_only_menu #top-header{ display: block; } #top-header .container{ padding-top: 0.5em; padding-bottom: 0.2em; }  }
@media only screen and ( max-width: 767px ) { #top-header .container{ padding-top: 0.85em; padding-bottom: 0.35em; } }
<?php } ?>
	
<?php if ( '' !== get_theme_mod( 'secondary_nav_phone_icon', '' ) ) :
if (is_rtl()){ ?>
#mh-info-phone:after { content: "\<?php echo esc_html( get_theme_mod( 'secondary_nav_phone_icon', '' ) ); ?>"; }
<?php }else{ ?>
#mh-info-phone:before { content: "\<?php echo esc_html( get_theme_mod( 'secondary_nav_phone_icon', '' ) ); ?>"; }
<?php } endif; ?>
<?php if ( '' !== get_theme_mod( 'secondary_nav_email_icon', '' ) ) :
if (is_rtl()){ ?>
#mh-info-email:after { content: "\<?php echo esc_html( get_theme_mod( 'secondary_nav_email_icon', '' ) ); ?>"; }
<?php }else{ ?>
#mh-info-email:before { content: "\<?php echo esc_html( get_theme_mod( 'secondary_nav_email_icon', '' ) ); ?>"; }
<?php } endif; ?>
<?php if ( '' !== get_theme_mod( 'secondary_nav_date_icon', '' ) ) :
if (is_rtl()){ ?>
#mh-info-date:after { content: "\<?php echo esc_html( get_theme_mod( 'secondary_nav_date_icon', '' ) ); ?>"; }
<?php }else{ ?>
#mh-info-date:before { content: "\<?php echo esc_html( get_theme_mod( 'secondary_nav_date_icon', '' ) ); ?>"; }
<?php } endif; ?>
	
<?php if ( false === get_theme_mod( 'alwyas_show_app_menu', true )):?>
@media (min-width: 981px) { .app-nav-trigger, .mh_vertical_nav.mh_header_style_centered .app-nav-trigger { display: none !important; } }
<?php endif; ?>

<?php if ( '0' === get_theme_mod( 'sidebar_border', '1' ) ) : ?>
#main-content .container::before{ background-color:transparent}
.mhc_widget_area_left, .mhc_widget_area_right{ border:none;}
<?php endif; ?>

<?php if(('accent' === mh_get_option('mharty_share_color', 'accent') && (function_exists('mh_loveit') ))):?>
.mh_share .mh_share_accent li{ border-color:<?php echo esc_html( get_theme_mod( 'accent_color', '#44cdcd') ); ?>;}
.mh_share .mh_share_accent.mh_share_border li span, .mh_share .mh_share_accent.mh_share_border li i{color:<?php echo get_theme_mod( 'accent_color', '#44cdcd'); ?>;}
.mh_share .mh_share_accent.mh_share_solid li{background-color:<?php echo esc_html( get_theme_mod( 'accent_color', '#44cdcd') ); ?>;}
.mh_share .mh_share_accent.mh_share_solid li span, .mh_share .mh_share_accent.mh_share_solid li i{color:#ffffff;}
<?php endif;
if ( true === get_theme_mod( 'fix_transparent_bg', false )):?>
#main-content{background:#ffffff;}
<?php endif;
if ( '1' === get_theme_mod( 'enable_menu_link_sep_color', '0' ) || '' !== get_theme_mod( 'menu_link_bg', '' ) || '' !== get_theme_mod( 'menu_link_active_bg', '' ) ) :
if (is_rtl()){ ?>
#top-menu > li:last-child { padding-left:15px;}
<?php }else{ ?>
#top-menu > li:last-child { padding-right:15px;}
<?php } endif;
echo wp_filter_nohtml_kses( get_theme_mod( 'customizer_custom_css') );
echo '</style>';

//Fonts
$mh_gf_heading_font = sanitize_text_field( get_theme_mod( 'heading_font', 'none' ) );
$mh_gf_body_font = sanitize_text_field( get_theme_mod( 'body_font', 'none' ) );
$mh_language_fonts = mh_get_language_fonts();
$mh_default_fonts = mh_get_default_fonts();
$site_locale = get_locale();
$menu_font =  get_theme_mod( 'menu_font', 'header' );
$secondary_nav_font = get_theme_mod( 'secondary_nav_font', 'body' );
$app_menu_font = get_theme_mod( 'app_menu_font', 'body' );
$footer_font = get_theme_mod( 'footer_font', 'body' );

echo '<style class="mh_font_css">';	
	if ( 'none' == $mh_gf_body_font){
		if ( isset( $mh_language_fonts[$site_locale] )) {	
			printf( '%s%s%s%s%s { font-family: %s; }',
				'body, input, textarea, select, .single_add_to_cart_button .button, .mhc_newsletter_form p input, .mfp-close, .mfp-image-holder .mfp-close, .mfp-iframe-holder .mfp-close, .orderby, .widget_search #searchsubmit, .mh-reviews-meta-score',
				('header' !== $menu_font ? ', #top-menu li .menu-item-link, #top-menu .megamenu-title, .fullwidth-menu-nav .megamenu-title, .fullwidth-menu-nav' : ''),
				('body' === $secondary_nav_font ? ', #top-header' : ''),
				('body' === $app_menu_font ? ', .mh-app-nav' : ''),
				('body' === $footer_font ? ', #mh-footer-nav, #footer-bottom' : ''),
				sanitize_text_field( $mh_language_fonts[$site_locale]['body'] )
			);
		}else{
			printf( '%s%s%s%s%s { font-family: %s; }',
				'body, input, textarea, select, .single_add_to_cart_button .button, .mhc_newsletter_form p input, .mfp-close, .mfp-image-holder .mfp-close, .mfp-iframe-holder .mfp-close, .orderby, .widget_search #searchsubmit, .mh-reviews-meta-score',
				('header' !== $menu_font ? ', #top-menu li .menu-item-link, #top-menu .megamenu-title, .fullwidth-menu-nav .megamenu-title, .fullwidth-menu-nav' : ''),
				('body' === $secondary_nav_font ? ', #top-header' : ''),
				('body' === $app_menu_font ? ', .mh-app-nav' : ''),
				('body' === $footer_font ? ', #mh-footer-nav, #footer-bottom' : ''),
				sanitize_text_field( $mh_default_fonts['body']['font_family'] )
			);
		}
	}else{
		mh_gf_attach_font( $mh_gf_body_font, 'body, input, textarea, select, .single_add_to_cart_button .button, .mhc_newsletter_form p input, .mfp-close, .mfp-image-holder .mfp-close, .mfp-iframe-holder .mfp-close, .orderby, .widget_search #searchsubmit, .mh-reviews-meta-score' );
		if ('header' !== $menu_font ) mh_gf_attach_font( $mh_gf_body_font, '#top-menu li .menu-item-link, #top-menu .megamenu-title, .fullwidth-menu-nav .megamenu-title, .fullwidth-menu-nav');
		if ('body' === $secondary_nav_font) mh_gf_attach_font( $mh_gf_body_font, '#top-header');
		if ('body' === $app_menu_font) mh_gf_attach_font( $mh_gf_body_font, '.mh-app-nav');
		if ('body' === $footer_font) mh_gf_attach_font( $mh_gf_body_font, '#mh-footer-nav, #footer-bottom');
	}
	
	if ( 'none' == $mh_gf_heading_font){
		if ( isset( $mh_language_fonts[$site_locale] )) {
			printf( '%s%s%s%s%s { font-family: %s; }',
				'h1, h2, h3, h4, h5, h6, .mhc_pricing_menus_item_title, .mhc_pricing_menus_item_price, .mhc_currency_sign, .mhc_testimonial_author, .mhc_testimonials_slide_author, .mh_quote_content blockquote, span.fn, span.fn a, #main-header .header-tagline, .mh-font-heading, .postnav-title, ul.post_share_footer.mh_share_name_icon li a .post_share_item_title, .header-font-family',
				('header' === $menu_font ? ', #top-menu li .menu-item-link, #top-menu .megamenu-title, .fullwidth-menu-nav .megamenu-title, .fullwidth-menu-nav' : ''),
				('body' !== $secondary_nav_font ? ', #top-header' : ''),
				('body' !== $app_menu_font ? ', .mh-app-nav' : ''),
				('body' !== $footer_font ? ', #mh-footer-nav, #footer-bottom' : ''),
				sanitize_text_field( $mh_language_fonts[$site_locale]['h'] )
			);
		}else{
			printf( '%s%s%s%s%s { font-family: %s; }',
				'h1, h2, h3, h4, h5, h6, .mhc_pricing_menus_item_title, .mhc_pricing_menus_item_price, .mhc_currency_sign, .mhc_testimonial_author, .mhc_testimonials_slide_author, .mh_quote_content blockquote, span.fn, span.fn a, #main-header .header-tagline, .mh-font-heading, .postnav-title, ul.post_share_footer.mh_share_name_icon li a .post_share_item_title, .header-font-family',
				('header' === $menu_font ? ', #top-menu li .menu-item-link, #top-menu .megamenu-title, .fullwidth-menu-nav .megamenu-title, .fullwidth-menu-nav' : ''),
				('body' !== $secondary_nav_font ? ', #top-header' : ''),
				('body' !== $app_menu_font ? ', .mh-app-nav' : ''),
				('body' !== $footer_font ? ', #mh-footer-nav, #footer-bottom' : ''),
				sanitize_text_field( $mh_default_fonts['h']['font_family'] )
			);
		}	
	}else{
		mh_gf_attach_font( $mh_gf_heading_font, 'h1, h2, h3, h4, h5, h6, .mhc_pricing_menus_item_title, .mhc_pricing_menus_item_price, .mhc_currency_sign, .mhc_testimonial_author, .mhc_testimonials_slide_author, .mh_quote_content blockquote, span.fn, span.fn a, #main-header .header-tagline, .mh-font-heading, .postnav-title, ul.post_share_footer.mh_share_name_icon li a .post_share_item_title, .header-font-family' );
		if ('header' === $menu_font ) mh_gf_attach_font( $mh_gf_heading_font, '#top-menu li .menu-item-link, #top-menu .megamenu-title, .fullwidth-menu-nav .megamenu-title, .fullwidth-menu-nav');
		if ('body' !== $secondary_nav_font) mh_gf_attach_font( $mh_gf_heading_font, '#top-header');
		if ('body' !== $app_menu_font) mh_gf_attach_font( $mh_gf_body_font, '.mh-app-nav');
		if ('body' !== $footer_font) mh_gf_attach_font( $mh_gf_heading_font, '#mh-footer-nav, #footer-bottom');
	}
echo '</style>';
 }
add_action( 'wp_head', 'mh_mharty_add_customizer_css' );
add_action( 'customize_controls_print_styles', 'mh_mharty_add_customizer_css' );