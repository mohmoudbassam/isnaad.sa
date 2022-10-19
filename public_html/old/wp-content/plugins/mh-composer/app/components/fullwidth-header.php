<?php
class MHComposer_Component_Fullwidth_Header extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Full-width Header', 'mh-composer' );
		$this->slug            = 'mhc_fullwidth_header';
		$this->fullwidth        = true;
		$this->main_css_selector = '%%order_class%%';
		
		$this->approved_fields = array(
			'module_id',
			'module_class',
			'title',
			'subhead',
			'background_layout',
			'text_orientation',
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
			'use_circle_border',
			'circle_color',
			'circle_border_color',
			'animation',
			'color',
			'subhead_color',
			'subhead_position',
			'size',
			'subhead_size',
			'title_bold',
			'custom_paddings',
			'use_icon_size',
			'icon_size',
			'admin_label',
		);
		
		$mh_accent_color = mh_composer_accent_color();
		$this->fields_defaults = array(
			'background_layout'   => array( 'light' ),
			'text_orientation'  	=> array( 'right' ),
			'use_icon'            => array( 'off' ),
			'font_list' 		   => array( 'mhicons' ),
			'use_circle'          => array( 'off' ),
			'use_circle_bg'   	   => array( 'off' ),
			'use_circle_border'   => array( 'off' ),
			'icon_color' 		  => array( $mh_accent_color, 'append_default' ),
			'circle_color' 		=> array( $mh_accent_color, 'append_default' ),
			'circle_border_color' => array( $mh_accent_color, 'append_default' ),
			'animation'           => array( 'off' ),
			'subhead_position' 	=> array( 'bottom' ),
			'title_bold' 		  => array( 'off'),
			'size' 		 		=> array( '26'),
			'subhead_size' 		=> array( '14'),
			'use_icon_size'  	   => array( 'off' ),
		);
		$this->custom_css_options = array(
			'fullwidth_header_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => '.mhc_fullwidth_header_title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'fullwidth_header_subhead' => array(
				'label'    => esc_html__( 'Subheading Text', 'mh-composer' ),
				'selector' => '.mhc_fullwidth_header_subhead',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'fullwidth_header_icon' => array(
				'label'    => esc_html__( 'Icon', 'mh-composer' ),
				'selector' => '.mhc-icon',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}
	
	function get_fields() {
		$animation_options = array(
			'off'      	 => esc_html__( 'No Animation', 'mh-composer' ),
			'fade_in'  	 => esc_html__( 'Fade In', 'mh-composer' ),
			'bouncein'	=> esc_html__( 'Bouncing', 'mh-composer' ),
			'scrollout'   => esc_html__( 'Fade Out on Scroll', 'mh-composer' ),
			'top'      	 => esc_html__( 'Top To Bottom', 'mh-composer' ),
			'bottom'   	  => esc_html__( 'Bottom To Top', 'mh-composer' ),
		);
		
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input your desired title here.', 'mh-composer' ),
			),
			'subhead' => array(
				'label'           => esc_html__( 'Subheading Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'If you would like to use a subheading, add it here.', 'mh-composer' ),
			),
			'subhead_position' => array(
				'label'           => esc_html__( 'Subheading Position', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'bottom' => esc_html__( 'Bottom', 'mh-composer' ),
					'top'  => esc_html__( 'Top', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose where to place your subheading.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'light' => esc_html__( 'Dark', 'mh-composer' ),
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
					'custom'  => esc_html__( 'Custom', 'mh-composer' ),
				),
				'affects'     => array(
					'#mhc_color',
					'#mhc_subhead_color',
				),
				'description'       => esc_html__( 'Here you can choose the value of your text. If you are working with a dark background, then your text should be set to light. If you are working with a light background, then your text should be dark.', 'mh-composer' ),
			),
			'color' => array(
				'label'             => esc_html__( 'Title Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour for your title.', 'mh-composer' ),
				'depends_show_if'     => 'custom',
			),
			'subhead_color' => array(
				'label'             => esc_html__( 'Subheading Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour for your subheading.', 'mh-composer' ),
				'depends_show_if'     => 'custom',
			),
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options_no_just(),
				'description'       => esc_html__( 'This will adjust the alignment of the text.', 'mh-composer' ),
			),
			'animation' => array(
				'label'             => esc_html__( 'Title Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $animation_options,
				'description'       => esc_html__( 'This controls the title animation.', 'mh-composer' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Label', 'mh-composer' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the component in the composer for easy identification.', 'mh-composer' ),
			),
			'module_id' => array(
				'label'           => esc_html__( '{CSS ID}', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-composer' ),
				'tab_slug'        => 'advanced',
			),
			'module_class' => array(
				'label'           => esc_html__( '{CSS Class}', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-composer' ),
				'tab_slug'        => 'advanced',
			),
			'size' => array(
				'label'           => esc_html__( 'Title Size', 'mh-composer' ),
				'type'            => 'text',
				'default' => '26',
				'validate_unit'   => false,
				'tab_slug'        => 'advanced',
			),
			'subhead_size' => array(
				'label'           => esc_html__( 'Subhead Size', 'mh-composer' ),
				'type'            => 'text',
				'default' => '14',
				'validate_unit'   => false,
				'tab_slug'        => 'advanced',
			),
			'title_bold' => array(
				'label'           => esc_html__( 'Bold Title', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced',
			),
			'custom_paddings' => array(
				'label'           => esc_html__( 'Padding', 'mh-composer' ),
				'type'            => 'range',
				'default' => '70',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
				),
				'validate_unit'   => true,
				'description'       => esc_html__( 'Define a custom padding here, e.g. 50', 'mh-composer' ),
				'tab_slug'        => 'advanced',
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
					'#mhc_use_icon_size',
				),
				'tab_slug'        => 'advanced',
				'description' => esc_html__( 'Here you can choose whether icon set below should be used.', 'mh-composer' ),
			),
			'font_list' => array(
				'label'               => esc_html__( 'Icons Font', 'mh-composer' ),
				'renderer'            => 'mh_composer_font_list_option',
				'description'         => esc_html__( 'If you want more icons, install & activate MH More Icons Plugin.', 'mh-composer'),
				'tab_slug'        => 'advanced',
			),
			'font_mhicons' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'mhicons',
				'tab_slug'        => 'advanced',
			),
			'font_steadysets' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_steadysets_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'steadysets',
				'tab_slug'        => 'advanced',
			),
			'font_awesome' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_awesome_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'awesome',
				'tab_slug'        => 'advanced',
			),
			'font_lineicons' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_lineicons_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'lineicons',
				'tab_slug'        => 'advanced',
			),
			'font_etline' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_etline_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'etline',
				'tab_slug'        => 'advanced',
			),
			'font_icomoon' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_icomoon_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'depends_show_if'     => 'icomoon',
				'tab_slug'        => 'advanced',
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
				'tab_slug'        => 'advanced',
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
				),
				'description' => esc_html__( 'Here you can choose whether icon set above should display within a circle.', 'mh-composer' ),
				'depends_default'   => true,
				'tab_slug'        => 'advanced',
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
				'tab_slug'        => 'advanced',
			),
			'circle_color' => array(
				'label'           => esc_html__( 'Circle Colour', 'mh-composer' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'Here you can define a custom colour for the icon circle.', 'mh-composer' ),
				'depends_default' => true,
				'tab_slug'        => 'advanced',
			),
			'use_circle_border' => array(
				'label'           => esc_html__( 'Use Circle Border', 'mh-composer' ),
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
				'tab_slug'        => 'advanced',
			),
			'circle_border_color' => array(
				'label'           => esc_html__( 'Circle Border Colour', 'mh-composer' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'Here you can define a custom colour for the icon circle border.', 'mh-composer' ),
				'depends_default' => true,
				'tab_slug'        => 'advanced',
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
		$subhead               = $this->shortcode_atts['subhead'];
		$background_layout     = $this->shortcode_atts['background_layout'];
		$text_orientation      = $this->shortcode_atts['text_orientation'];
		$color            	 = $this->shortcode_atts['color'];
		$subhead_color         = $this->shortcode_atts['subhead_color'];
		$size             	  = $this->shortcode_atts['size'];
		$subhead_size          = $this->shortcode_atts['subhead_size'];
		$use_icon              = $this->shortcode_atts['use_icon'];
		$font_list             = $this->shortcode_atts['font_list'];
		$font_mhicons          = $this->shortcode_atts['font_mhicons'];
		$font_steadysets       = $this->shortcode_atts['font_steadysets'];
		$font_awesome          = $this->shortcode_atts['font_awesome'];
		$font_lineicons        = $this->shortcode_atts['font_lineicons'];
		$font_etline           = $this->shortcode_atts['font_etline'];
		$font_icomoon          = $this->shortcode_atts['font_icomoon'];
		$font_linearicons      = $this->shortcode_atts['font_linearicons'];
		$icon_color            = $this->shortcode_atts['icon_color'];
		$use_circle            = $this->shortcode_atts['use_circle'];
		$use_circle_bg         = $this->shortcode_atts['use_circle_bg'];	
		$use_circle_border     = $this->shortcode_atts['use_circle_border'];
		$circle_color          = $this->shortcode_atts['circle_color'];
		$circle_border_color   = $this->shortcode_atts['circle_border_color'];
		$use_icon_size    	 = $this->shortcode_atts['use_icon_size'];
		$icon_size        	 = $this->shortcode_atts['icon_size'];
		$subhead_position	  = $this->shortcode_atts['subhead_position'];
		$title_bold 			= $this->shortcode_atts['title_bold'];
		$custom_paddings 	   = $this->shortcode_atts['custom_paddings'];
		$animation          	 = $this->shortcode_atts['animation'];

		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		if ( '70px' !== $custom_paddings && '' !== $custom_paddings) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_fullwidth_header',
				'declaration' => sprintf(
					'padding: %1$s 0;',
					esc_html( $custom_paddings )
				),
			) );
		}
		
		if ( '' !== $color && 'custom' === $background_layout ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_fullwidth_header h1.mhc_fullwidth_header_title',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $color )
				),
			) );
		}

		if ( '26' !== $size || '' !== $size) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_fullwidth_header h1.mhc_fullwidth_header_title',
				'declaration' => sprintf(
					'font-size: %1$spx;',
					esc_attr( $size )
				),
			) );
		}
		
		if ( 'off' !== $title_bold ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_fullwidth_header h1.mhc_fullwidth_header_title',
				'declaration' => 'font-weight:bold'
			) );
		}

		if ( '' !== $subhead_color && 'custom' === $background_layout) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_fullwidth_header .mhc_fullwidth_header_subhead',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $subhead_color )
				),
			) );
		}

		if ( '14' !== $subhead_size && '' !== $subhead_size ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_fullwidth_header .mhc_fullwidth_header_subhead',
				'declaration' => sprintf(
					'font-size: %1$spx;',
					esc_attr( $subhead_size )
				),
			) );
		}
		
		if ( 'off' !== $use_icon_size ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-icon',
				'declaration' => sprintf(
					'font-size: %1$s;',
					esc_html( mh_composer_process_range_value( $icon_size ) )
				),
			) );
		}
		
		$font_icon = $icon_style = '';
		
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
		
		if ( '' !== $font_icon ) {
			$icon_style = sprintf( 'color: %1$s;', esc_attr( $icon_color ) );
			if ( 'on' === $use_circle ) {
				if ( 'on' === $use_circle_bg ) {
					$icon_style .= sprintf( ' background-color: %1$s;', esc_attr( $circle_color ) );
				}
				if ( 'on' === $use_circle_border ) {
					$icon_style .= sprintf( ' border-color: %1$s;', esc_attr( $circle_border_color ) );
				}
			}
		}
			
		if ( '' !== $font_icon ) {
			$font_icon = sprintf(
				'<span class="mhc-icon %2$s%3$s%4$s" style="%5$s">%1$s</span>',
				esc_attr( mhc_process_font_icon($font_icon, "mhc_font_{$font_list}_icon_symbols")),
				esc_attr($font_list),
				( 'on' === $use_circle ? ' mhc-icon-circle' : '' ),
				( 'on' === $use_circle && 'on' === $use_circle_border ? ' mhc-icon-circle-border' : '' ),
				$icon_style
			);
		}

		
		$class = " mhc_module mhc_text_align_{$text_orientation}";
		if ('custom' !== $background_layout) $class .= " mhc_bg_layout_{$background_layout}";
		if ('top' === $subhead_position) $class .= " subhead_top";
		
		
		
		$subhead_text = '';
		if ( '' !== $subhead ) {
			$subhead_text = sprintf( '<p class="mhc_fullwidth_header_subhead">%1$s</p>', $subhead);
		}
		
		$output = sprintf(
		'<section%4$s class="mhc_fullwidth_header%3$s%5$s">
			<div class="mhc_row">
				<div class="mhc_fullwidth_header_content%8$s">
					%6$s
					<div class="mhc_fullwidth_header_titles">
						%7$s
						<h1 class="mhc_fullwidth_header_title">%1$s</h1>
						%2$s
					</div> <!--mhc_fullwidth_header_titles-->
				</div> <!--mhc_fullwidth_header_content-->
			</div>
		</section>',
		$title,
		('bottom' === $subhead_position ? $subhead_text : ''),
		esc_attr( $class ),
		( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
		( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
		( 'off' !== $use_icon ? $font_icon : '' ),
		('top' === $subhead_position ? $subhead_text : ''),
		'scrollout' !== $animation ? esc_attr( " mh-waypoint mhc_animation_{$animation}" ) : ' mhc_animation_scrollout'
	);
	
		return $output;
	
	}
}
new MHComposer_Component_Fullwidth_Header;