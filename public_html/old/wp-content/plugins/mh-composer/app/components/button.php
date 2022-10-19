<?php
class MHComposer_Component_Button extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Button', 'mh-composer' );
		$this->slug = 'mhc_button';
		$this->main_css_selector = '%%order_class%%';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'button_url',
			'url_new_window',
			'button_text',
			'button_style',
			'button_color',
			'button_text_color',
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
			'animation',
			'button_fx',
			'button_size',
			'button_font',
			'wide_button',
		);
		
		$mh_accent_color = mh_composer_accent_color();

		$this->fields_defaults = array(
			'text_orientation'     => array( 'center' ),
			'button_style' 		 => array( 'off' ),
			'button_size' 		 => array( 'default' ),
			'button_color' 		 => array( $mh_accent_color, 'append_default' ),
			'button_text_color' 	=> array( '#ffffff', 'append_default' ),
			'background_layout'    => array( 'dark' ),
			'url_new_window'       => array( 'off' ),
			'use_icon' 		  	 => array( 'off' ),
			'font_list' 			=> array( 'mhicons' ),
			'wide_button' 		  => array( 'off' ),
			'animation' 			=> array( 'off' ),
			'button_fx' 			=> array( 'off' ),
			'button_font'		  => array( 'off' ),
		);
		
		$this->custom_css_options = array(
			'button' => array(
				'label'		=> esc_html__( 'Button', 'mh-composer' ),
				'selector'	 => '.mhc_promo_button',
				'description'  => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		// List of animation options
		$animation_options = array(
			'off'    	=> esc_html__( 'No Animation', 'mh-composer' ),
			'top'    	=> esc_html__( 'Top To Bottom', 'mh-composer' ),
			'right'  	  => esc_html__( 'Right To Left', 'mh-composer' ),
			'left'   	   => esc_html__( 'Left To Right', 'mh-composer' ),
			'bottom' 	 => esc_html__( 'Bottom To Top', 'mh-composer' ),
			'scaleup'	=> esc_html__( 'Scale Up', 'mh-composer' ),
			'fade_in'	=> esc_html__( 'Fade In', 'mh-composer' ),
			'bouncein'		=> esc_html__( 'Bouncing', 'mh-composer' ),
			'bounceinup'	  => esc_html__( 'Top Bouncing', 'mh-composer' ),
			'bounceindown'	=> esc_html__( 'Bottom Bouncing', 'mh-composer' ),
			'bounceinright'   => esc_html__( 'Right Bouncing', 'mh-composer' ),
			'bounceinleft'	=> esc_html__( 'Left Bouncing', 'mh-composer' ),
		);
		$fields = array(
			'button_url' => array(
				'label'           => esc_html__( 'Button URL', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input the destination URL for your CTA button.', 'mh-composer' ),
			),
			'button_text' => array(
				'label'           => esc_html__( 'Button Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input your desired button text, or leave blank for no button.', 'mh-composer' ),
			),
			'url_new_window' => array(
				'label'           => esc_html__( 'URL Opens', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'mh-composer' ),
					'on'  => esc_html__( 'In a New Tab', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose whether your link opens in a new window.', 'mh-composer' ),
			),
			'button_style' => array(
				'label'           => esc_html__( 'Button Style', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'off' => esc_html__( 'Transparent', 'mh-composer' ),
					'on' => esc_html__( 'Solid', 'mh-composer' ),
				),
				'affects'     => array(
					'#mhc_button_text_color',
					'#mhc_background_layout',
				),
				'description'       => esc_html__( 'This defines the button style, if you choose solid you will be able to pick your colour below.', 'mh-composer' ),
			),
			'button_color' => array(
				'label'             => esc_html__( 'Button Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Define a custom colour for your button, or leave blank to use the default colour.', 'mh-composer' ),
			),
			'button_text_color' => array(
				'label'             => esc_html__( 'Button Text Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_default'   => true,
				'description'       => esc_html__( 'Define a custom colour for your button text, or leave blank to use the default colour.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Hover Style', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
					'light' => esc_html__( 'Dark', 'mh-composer' ),
				),
				'depends_show_if'     => 'off',
				'description' => esc_html__( 'Here you can choose the hover style.', 'mh-composer' ),
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
			'text_orientation' => array(
				'label'             => esc_html__( 'Button Alignment', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options_no_just(),
				'description'       => esc_html__( 'This will adjust the alignment of the button.', 'mh-composer' ),
			),
			'animation' => array(
				'label'             => esc_html__( 'Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $animation_options,
				'description'       => esc_html__( 'This controls the direction of the lazy-loading animation.', 'mh-composer' ),
			),
			'button_fx' => array(
				'label'             => esc_html__( 'Button Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'off'      => esc_html__( 'No Animation', 'mh-composer' ),
					'bounce'   => esc_html__( 'Bouncing', 'mh-composer' ),
					'shake'	=> esc_html__( 'Shake', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This controls the away-from-the-button animation.', 'mh-composer' ),
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
			'button_size' => array(
				'label'           => esc_html__( 'Button Size', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'default'  => esc_html__( 'Default', 'mh-composer' ),
					'medium'   => esc_html__( 'Medium', 'mh-composer' ),
					'large'    => esc_html__( 'Large', 'mh-composer' ),
					'xlarge'   => esc_html__( 'X Large', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced',
			),
			'button_font' => array(
				'label'           => esc_html__( 'Use Header Font', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced'
			),
			'wide_button' => array(
				'label'           => esc_html__( 'Full-width Button', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced',
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
		$module_id            = $this->shortcode_atts['module_id'];
		$module_class         = $this->shortcode_atts['module_class'];
		$button_url           = $this->shortcode_atts['button_url'];
		$button_text          = $this->shortcode_atts['button_text'];
		$button_size          = $this->shortcode_atts['button_size'];
		$background_layout    = $this->shortcode_atts['background_layout'];
		$text_orientation     = $this->shortcode_atts['text_orientation'];
		$url_new_window       = $this->shortcode_atts['url_new_window'];
		$wide_button          = $this->shortcode_atts['wide_button'];
		$animation            = $this->shortcode_atts['animation'];
		$button_fx            = $this->shortcode_atts['button_fx'];
		$button_style         = $this->shortcode_atts['button_style'];
		$button_color         = $this->shortcode_atts['button_color'];
		$button_font		  = $this->shortcode_atts['button_font'];
		$button_text_color    = $this->shortcode_atts['button_text_color'];
		$use_icon             = $this->shortcode_atts['use_icon'];
		$font_list            = $this->shortcode_atts['font_list'];
		$font_mhicons         = $this->shortcode_atts['font_mhicons'];
		$font_steadysets      = $this->shortcode_atts['font_steadysets'];
		$font_awesome         = $this->shortcode_atts['font_awesome'];
		$font_lineicons       = $this->shortcode_atts['font_lineicons'];
		$font_etline          = $this->shortcode_atts['font_etline'];
		$font_icomoon         = $this->shortcode_atts['font_icomoon'];
		$font_linearicons     = $this->shortcode_atts['font_linearicons'];
		

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		$content = $this->shortcode_content;
		
		if ( '' !== $button_color && 'on' !== $button_style ) {
		MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_promo_button.mhc_transify',
				'declaration' => sprintf(
					'color:%1$s !important;',
					esc_attr( $button_color )
				),
			) );
		}
		if ( 'on' === $button_style ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_promo_button',
				'declaration' => sprintf(
					'background-color: %1$s !important; border-color:%1$s !important; color:%2$s !important;',
					esc_attr( $button_color ),
					esc_attr( $button_text_color )
				),
			) );
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
		
		if ( '' !== $font_icon ) {
			$font_icon = sprintf(
				'<span class="mhc-icon %2$s">%1$s</span>',
				esc_attr( mhc_process_font_icon($font_icon, "mhc_font_{$font_list}_icon_symbols")),
				esc_attr($font_list)
			);
		}


		$class = " mhc_module mhc_text_align_{$text_orientation} mhc_animation_{$animation}";
		if ( 'off' === $button_style){
			$class .= " mhc_bg_layout_{$background_layout}";
		}

		$output = sprintf(
			'<div%2$s class="mhc_button_wrapper mh-waypoint%3$s%4$s%5$s">
				%1$s
			</div>',
			('' !== $button_url && '' !== $button_text ? sprintf( 
				'<a class="mhc_promo_button mhc_single_button%4$s%5$s%6$s%7$s%8$s"%9$s href="%1$s">%3$s%2$s</a>',
					esc_url( $button_url ),
					esc_html( $button_text ),	
					('off' !== $use_icon ? $font_icon : '' ),
					( 'on' === $button_style
						? sprintf( ' mhc_solidify')
						: ' mhc_transify'
					),
					('off' !== $wide_button ? ' mhc_button_fullwidth' : ''),
					('off' !== $button_fx ?  sprintf(' mhc_animation_%1$s', esc_attr($button_fx)) : ''),
					('default' !== $button_size ? " mhc_button_{$button_size}" : ""),
					('off' !==  $button_font ? ' header-font-family' : ''),
					( 'on' === $url_new_window ? ' target="_blank"' : '' )
			) : '' ), //button ends here
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			esc_attr( $class ),
			('off' !== $button_fx ? ' mh_button_fx' : '')
		);

		return $output;
	}
}
new MHComposer_Component_Button;