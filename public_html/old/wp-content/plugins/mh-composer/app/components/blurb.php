<?php
class MHComposer_Component_Blurb extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Blurb', 'mh-composer' );
		$this->slug = 'mhc_blurb';
		$this->main_css_selector = '%%order_class%%.mhc_blurb';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'title',
			'url',
			'url_new_window',
			'use_icon',
			'font_list',
			'font_mhicons',
			'font_steadysets',
			'font_awesome',
			'font_lineicons',
			'font_etline',
			'font_icomoon',
			'font_linearicons',
			'icon_color',
			'use_circle',
			'use_circle_bg',
			'circle_color',
			'use_circle_border',
			'circle_border_color',
			'image',
			'alt',
			'icon_placement',
			'animation',
			'background_layout',
			'text_orientation',
			'use_background',
			'background_color',
			'background_image',
			'wrap_inside_link',
			'hoverfx',
			'overlay_color',
			'overlay_text_color',
			'content_new',
			'use_icon_size',
			'icon_size',
			'circle_radius',
			'max_width',
		);

		$mh_accent_color = mh_composer_accent_color();

		$this->fields_defaults = array(
			'url_new_window'      => array( 'off' ),
			'use_icon'            => array( 'off' ),
			'font_list' 		   => array( 'mhicons' ),
			'icon_color'          => array( $mh_accent_color, 'append_default' ),
			'use_circle'          => array( 'off' ),
			'use_circle_bg'       => array( 'off' ),
			'circle_color'        => array( $mh_accent_color, 'append_default' ),
			'use_circle_border'   => array( 'off' ),
			'circle_border_color' => array( $mh_accent_color, 'append_default' ),
			'icon_placement'      => array( 'top' ),
			'animation'           => array( 'top' ),
			'background_layout'   => array( 'light' ),
			'text_orientation'    => array( 'center' ),
			'use_background'      => array( 'off' ),
			'background_color' 	=> array( '#f5f5f5', 'append_default' ),
			'wrap_inside_link'    => array( 'off' ),
			'hoverfx' 			 => array( 'none' ),
			'overlay_color' 	   => array( '#121212', 'append_default' ),
			'use_icon_size'  	   => array( 'off' ),
			'circle_radius'	   => array( '100', 'append_default' ),
		);
		$this->custom_css_options = array(
			'blurb_icon' => array(
				'label'    => esc_html__( 'Blurb Icon', 'mh-composer' ),
				'selector' => '.mhc-icon',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'blurb_image' => array(
				'label'    => esc_html__( 'Blurb Image', 'mh-composer' ),
				'selector' => '.mhc_main_blurb_image',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'blurb_title' => array(
				'label'    => esc_html__( 'Blurb Title', 'mh-composer' ),
				'selector' => 'h4',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$image_icon_placement = array(
			'top' 		=> esc_html__( 'Top', 'mh-composer' ),
			'right' 	  => esc_html__( 'Right', 'mh-composer' ),
			'left'	   => esc_html__( 'Left', 'mh-composer' ),
		);
		
		$animation_options = array(
			'right'    => esc_html__( 'Right To Left', 'mh-composer' ),
			'left'     => esc_html__( 'Left To Right', 'mh-composer' ),
			'top'      => esc_html__( 'Top To Bottom', 'mh-composer' ),
			'bottom'   => esc_html__( 'Bottom To Top', 'mh-composer' ),
			'scaleup'  => esc_html__( 'Scale Up', 'mh-composer' ),
			'fade_in'  => esc_html__( 'Fade In', 'mh-composer' ),
			'bouncing' => esc_html__( 'Bouncing', 'mh-composer' ),
			'off'      => esc_html__( 'No Animation', 'mh-composer' ),
		);

		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'The title of your blurb will appear in bold below your blurb image.', 'mh-composer' ),
			),
			'url' => array(
				'label'           => esc_html__( 'URL', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'If you would like to make your blurb a link, input your destination URL here.', 'mh-composer' ),
			),
			'url_new_window' => array(
				'label'           => esc_html__( 'URL Opens', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'mh-composer' ),
					'on'  => esc_html__( 'In a New Tab', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose whether your link opens in a new window.', 'mh-composer' ),
			),
			'use_icon' => array(
				'label'           => esc_html__( 'Use Icon', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'     => array(
					'#mhc_font_list',
					'#mhc_use_circle',
					'#mhc_icon_color',
					'#mhc_image',
					'#mhc_alt',
					'#mhc_max_width',
				),
				'description' => esc_html__( 'Here you can choose whether icon set below should be used.', 'mh-composer' ),
			),
			'font_list' => array(
				'label'               => esc_html__( 'Icons Font', 'mh-composer' ),
				'renderer'            => 'mh_composer_font_list_option',
				'description'         => esc_html__( 'If you want more icons, install & activate MH More Icons Plugin.', 'mh-composer'
				),
			),
			'font_mhicons' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'mhicons',
			),
			'font_steadysets' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_steadysets_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'steadysets',
			),
			'font_awesome' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_awesome_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'awesome',
			),
			'font_lineicons' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_lineicons_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'lineicons',
			),
			'font_etline' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_etline_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'etline',
			),
			'font_icomoon' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_icomoon_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'icomoon',
			),
			'font_linearicons' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_linearicons_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'linearicons',
			),
			'icon_color' => array(
				'label'             => esc_html__( 'Icon Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour for your icon.', 'mh-composer' ),
				'depends_default'   => true,
			),
			'use_circle' => array(
				'label'           => esc_html__( 'Circle Icon', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_use_circle_border',
					'#mhc_use_circle_bg',
					'#mhc_circle_radius',
				),
				'description' => esc_html__( 'Here you can choose whether icon set above should display within a circle.', 'mh-composer' ),
				'depends_default'   => true,
			),
			'use_circle_bg' => array(
				'label'           => esc_html__( 'Use Circle Colour', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_circle_color',
				),
				'description' => esc_html__( 'Enable this to pick a colour below.', 'mh-composer' ),
				'depends_default'   => true,
			),
			'circle_color' => array(
				'label'           => esc_html__( 'Circle Colour', 'mh-composer' ),
				'type'            => 'color',
				'description'     => esc_html__( 'Here you can define a custom colour for the icon circle.', 'mh-composer' ),
				'depends_default' => true,
			),
			'use_circle_border' => array(
				'label'           => esc_html__( 'Circle Border', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_circle_border_color',
				),
				'description' => esc_html__( 'Here you can choose whether the icon circle border should be displayed.', 'mh-composer' ),
				'depends_default'   => true,
			),
			'circle_border_color' => array(
				'label'           => esc_html__( 'Circle Border Colour', 'mh-composer' ),
				'type'            => 'color',
				'description'     => esc_html__( 'Here you can define a custom colour for the icon circle border.', 'mh-composer' ),
				'depends_default' => true,
			),
			'image' => array(
				'label'              => esc_html__( 'Image', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Image', 'mh-composer' ),
				'depends_show_if'    => 'off',
				'description'        => esc_html__( 'Upload an image to display at the top of your blurb.', 'mh-composer' ),
			),
			'alt' => array(
				'label'           => esc_html__( 'Image Alt Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'mh-composer' ),
				'depends_show_if' => 'off',
			),
			'icon_placement' => array(
				'label'             => esc_html__( 'Image/Icon Placement', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $image_icon_placement,
				'description'       => esc_html__( 'Here you can choose where to place the icon.', 'mh-composer' ),
				'affects'           => array(
					'#mhc_text_orientation',
				),
			),
			'animation' => array(
				'label'             => esc_html__( 'Image/Icon Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $animation_options,
				'description'       => esc_html__( 'This controls the direction of the lazy-loading animation.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'light' => esc_html__( 'Dark', 'mh-composer' ),
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options(),
				'description'       => esc_html__( 'This will adjust the alignment of the text.', 'mh-composer' ),
				'depends_show_if' => 'top',
			),
			'content_new' => array(
				'label'             => esc_html__( 'Content', 'mh-composer' ),
				'type'              => 'tiny_mce',
				'description'       => esc_html__( 'Input the main text content for your component here.', 'mh-composer' ),
			),
			'admin_label' => array(
				'label'             => esc_html__( 'Label', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'This will change the label of the component in the composer for easy identification.', 'mh-composer' ),
			),
			'module_id' => array(
				'label'             => esc_html__( '{CSS ID}', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-composer' ),
				'tab_slug'        => 'advanced',
			),
			'module_class' => array(
				'label'             => esc_html__( '{CSS Class}', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-composer' ),
				'tab_slug'        => 'advanced',
			),
			'use_background' => array(
				'label'           => esc_html__( 'Use Background', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_background_color',
					'#mhc_background_image',
				),
				'tab_slug'        => 'advanced',
			),
			'background_image' => array(
				'label'              => esc_html__( 'Background Image', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Image', 'mh-composer' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'mh-composer' ),
				'depends_default' => true,
				'tab_slug'        => 'advanced',
			),
			'background_color' => array(
				'label'             => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_default' => true,
				'custom_color'	=> true,
				'tab_slug'        => 'advanced',
			),
			'wrap_inside_link' => array(
				'label'           => esc_html__( 'Clickable Blurb', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'mh-composer' ),
				'affects'     => array(
					'#mhc_hoverfx',
				),
				'tab_slug' => 'advanced',
			),
			'hoverfx' => array(
				'label'             => esc_html__( 'Mouse Effect', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'none'  	   => esc_html__( 'No Effect', 'mh-composer' ),
					'color'  	  => esc_html__( 'Overlay Colour', 'mh-composer' ),
					'reverse' 	=> esc_html__( 'Reverse Overlay Colour', 'mh-composer' )
				),
				'description'       => esc_html__( 'This controls the effect when hovering on your blurb.', 'mh-composer' ),
				'tab_slug'        => 'advanced',
				'affects'     => array(
					'#mhc_overlay_color',
					'#mhc_overlay_text_color'
				),
				'depends_default'   => true,
			),
			'overlay_color' => array(
				'label'             => esc_html__( 'Overlay Colour', 'mh-composer' ),
				'type'              => 'color',
				'depends_default'   => true,
				'depends_show_if_not' => 'none',
				'tab_slug'        => 'advanced',
				'custom_color'	=> true,
				
			),
			'overlay_text_color' => array(
				'label'             => esc_html__( 'Overlay Text Colour', 'mh-composer' ),
				'type'              => 'color',
				'depends_default'   => true,
				'depends_show_if' => 'reverse',
				'tab_slug'        => 'advanced',
				'custom_color'	=> true,
			),
			'use_icon_size' => array(
				'label'           => esc_html__( 'Use Icon Size', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced',
				'affects'     => array(
					'#mhc_icon_size'
				),
			),
			'icon_size' => array(
				'label'           => esc_html__( 'Icon Size', 'mh-composer' ),
				'type'            => 'range',
				'default'         => '50',
				'range_settings' => array(
					'min'  => '10',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'        => 'advanced',
				'depends_default' => true,
			),
			'circle_radius' => array(
				'label'           => esc_html__( 'Circle Icon Radius', 'mh-composer' ),
				'type'            => 'range',
				'tab_slug'        => 'advanced',
				'depends_default'   => true,
			),
			'max_width' => array(
				'label'           => esc_html__( 'Image Max Width', 'mh-composer' ),
				'type'            => 'text',
				'tab_slug'        => 'advanced',
				'depends_show_if'    => 'off',
				'validate_unit'   => true,
			),
			'disabled_on' => array(
				'label'           => esc_html__( 'Hide on', 'mh-composer' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'mh-composer' ),
					'tablet'  => esc_html__( 'Tablet', 'mh-composer' ),
					'desktop' => esc_html__( 'Desktop', 'mh-composer' ),
				),
				'additional_att'  => 'disable_on',
				'description'     => esc_html__( 'This will hide the component on selected devices', 'mh-composer' ),
				'tab_slug'        => 'advanced',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id             = $this->shortcode_atts['module_id'];
		$module_class          = $this->shortcode_atts['module_class'];
		$title                 = $this->shortcode_atts['title'];
		$url                   = $this->shortcode_atts['url'];
		$image                 = $this->shortcode_atts['image'];
		$url_new_window        = $this->shortcode_atts['url_new_window'];
		$alt                   = $this->shortcode_atts['alt'];
		$background_layout     = $this->shortcode_atts['background_layout'];
		$text_orientation      = $this->shortcode_atts['text_orientation'];
		$animation             = $this->shortcode_atts['animation'];
		$icon_placement        = $this->shortcode_atts['icon_placement'];
		$use_icon              = $this->shortcode_atts['use_icon'];
		$font_list             = $this->shortcode_atts['font_list'];
		$font_mhicons          = $this->shortcode_atts['font_mhicons'];
		$font_steadysets       = $this->shortcode_atts['font_steadysets'];
		$font_awesome          = $this->shortcode_atts['font_awesome'];
		$font_lineicons        = $this->shortcode_atts['font_lineicons'];
		$font_etline           = $this->shortcode_atts['font_etline'];
		$font_icomoon          = $this->shortcode_atts['font_icomoon'];
		$font_linearicons      = $this->shortcode_atts['font_linearicons'];
		$use_circle_bg         = $this->shortcode_atts['use_circle_bg'];	
		$use_circle            = $this->shortcode_atts['use_circle'];
		$use_circle_border     = $this->shortcode_atts['use_circle_border'];
		$icon_color            = $this->shortcode_atts['icon_color'];
		$circle_color          = $this->shortcode_atts['circle_color'];
		$circle_border_color   = $this->shortcode_atts['circle_border_color'];
		$wrap_inside_link      = $this->shortcode_atts['wrap_inside_link'];
		$hoverfx    		   = $this->shortcode_atts['hoverfx'];
		$overlay_color    	   = $this->shortcode_atts['overlay_color'];
		$overlay_text_color    = $this->shortcode_atts['overlay_text_color'];
		$use_icon_size    	   = $this->shortcode_atts['use_icon_size'];
		$icon_size        	   = $this->shortcode_atts['icon_size'];
		$use_background    	   = $this->shortcode_atts['use_background'];
		$background_color      = $this->shortcode_atts['background_color'];
		$background_image      = $this->shortcode_atts['background_image'];
		$circle_radius 		   = $this->shortcode_atts['circle_radius'];
		$max_width			   = $this->shortcode_atts['max_width'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		if ( 'off' !== $use_icon_size ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-icon',
				'declaration' => sprintf(
					'font-size: %1$s;',
					esc_html( mh_composer_process_range_value( $icon_size ) )
				),
			) );
		}
		
		if ( '' !== $circle_radius ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-icon-circle',
				'declaration' => sprintf(
					'-webkit-border-radius: %1$s; -moz-border-radius: %1$s; border-radius: %1$s;',
					esc_html( mh_composer_process_range_value( $circle_radius ) )
				),
			) );
		}
		
		if ( 'off' !== $wrap_inside_link && 'none' !== $hoverfx ) {
			if ('' !== $overlay_color ){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_only_overlay',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_attr( $overlay_color )
					),
				) );
			}
			if ('' !== $overlay_text_color && 'reverse' === $hoverfx ){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% a:hover .mhc_blurb_content_inner a, %%order_class%% a:hover .mhc_blurb_content_inner h4, %%order_class%% a:hover .mhc_blurb_content_inner p',
					'declaration' => sprintf(
						'color: %1$s; transition: all 0.3s ease 0s;',
						esc_attr( $overlay_text_color )
					),
				) );
			}
		}
		if ( 'off' !== $use_background ) {
		 	if ( '' === $background_image ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_attr( $background_color )
					),
				) );
			}
		
			if ( '' !== $background_image ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => sprintf(
						'background-image:url(%1$s); -moz-background-size: cover; -webkit-background-size: cover; background-size:cover;',
						esc_url( $background_image )
					),
				) );
			}
		}
		
		if ( '' !== $max_width ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_main_blurb_image',
				'declaration' => sprintf(
					'max-width: %1$s;',
					esc_html( $max_width )
				),
			) );
		}
		

		if ( 'off' === $wrap_inside_link && '' !== $title && '' !== $url ) {
			$title = sprintf( '<a href="%1$s"%3$s>%2$s</a>',
				esc_url( $url ),
				esc_html( $title ),
				( 'on' === $url_new_window ? ' target="_blank"' : '' )
			);
		} elseif ( 'off' !== $wrap_inside_link && '' !== $title ){
			$title = esc_html( $title );
		}

		if ( '' !== $title ) {
			$title = "<h4>{$title}</h4>";
		}
		
		$font_icon = '';
		switch($font_list){
		case 'mhicons':
			$font_icon = $font_mhicons;
			break;
		case 'steadysets':
			$font_icon = $font_steadysets;
			break;
		case 'awesome':
			$font_icon = $font_awesome;
			break;
		case 'lineicons':
			$font_icon = $font_lineicons;
			break;
		case 'etline':
			$font_icon = $font_etline;
			break;
		case 'icomoon':
			$font_icon = $font_icomoon;
			break;
		case 'linearicons':
			$font_icon = $font_linearicons;
			break;
		
		}

		if ( '' !== trim( $image ) || '' !== $font_icon ) {
			if ( 'off' === $use_icon ) {
				$image = sprintf(
					'<img src="%1$s" alt="%2$s" class="mh-waypoint%3$s" />',
					esc_url( $image ),
					esc_attr( $alt ),
					esc_attr( " mhc_animation_{$animation}" )
				);
			} else {
				$icon_style = sprintf( 'color: %1$s;', esc_attr( $icon_color ) );

				if ( 'on' === $use_circle ) {
					if ( 'on' === $use_circle_bg ) {
						$icon_style .= sprintf( ' background-color: %1$s;', esc_attr( $circle_color ) );
					}
					if ( 'on' === $use_circle_border ) {
						$icon_style .= sprintf( ' border-color: %1$s;', esc_attr( $circle_border_color ) );
					}
				}
			
				$image = sprintf(
					'<span class="mhc-icon %5$s mh-waypoint%1$s%2$s%3$s" style="%4$s">%6$s</span>',
					esc_attr( " mhc_animation_{$animation}" ),
					( 'on' === $use_circle ? ' mhc-icon-circle' : '' ),
					( 'on' === $use_circle && 'on' === $use_circle_border ? ' mhc-icon-circle-border' : '' ),
					$icon_style,
					esc_attr($font_list),
					esc_attr( mhc_process_font_icon($font_icon, "mhc_font_{$font_list}_icon_symbols"))
				);
			}

			$image = sprintf(
				'<div class="mhc_main_blurb_image">%1$s</div>',
				( 'off' === $wrap_inside_link && '' !== $url
					? sprintf(
						'<a href="%1$s"%3$s>%2$s</a>',
						esc_url( $url ),
						$image,
						( 'on' === $url_new_window ? ' target="_blank"' : '' )
					)
					: $image
				)
			);
		}

		$class = " mhc_module mhc_pct mhc_bg_layout_{$background_layout} mhc_text_align_{$text_orientation}";

		$output = sprintf(
			'<div%5$s class="mhc_blurb%4$s%6$s%7$s%11$s%12$s">
			%8$s
				<div class="mhc_blurb_content">
					%2$s
					<div class="mhc_blurb_content_inner">
						%3$s
						%1$s
					</div>
				</div> <!-- .mhc_blurb_content -->
			%9$s
			%10$s
			</div> <!-- .mhc_blurb -->',
			$this->shortcode_content,
			$image,
			$title,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			sprintf( ' mhc_blurb_position_%1$s', esc_attr( $icon_placement ) ),
			( 'off' !== $wrap_inside_link && '' !== $url
			? sprintf('<a class="%3$s" href="%1$s"%2$s>',
				esc_url( $url ),
				( 'on' === $url_new_window ? ' target="_blank"' : '' ),
				('off' !== $use_background || 'none' !== $hoverfx ? 'mhc_has_bg' : '' )
			) : '' ),
			( 'off' !== $wrap_inside_link && '' !== $url ? '</a>' : '' ),
			( 'off' !== $wrap_inside_link && 'none' !== $hoverfx ? '<span class="mh_only_overlay"></span>' : '' ),
			( 'off' === $wrap_inside_link && ('off' !== $use_background || 'none' !== $hoverfx) ? ' mhc_has_bg' : '' ),
			( 'off' !== $wrap_inside_link && 'none' !== $hoverfx ? esc_attr(" mhc_fx_{$hoverfx}") : '' )
		);
			
		return $output;
	}
}
new MHComposer_Component_Blurb;