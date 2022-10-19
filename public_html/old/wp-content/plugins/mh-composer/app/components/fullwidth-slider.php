<?php
class MHComposer_Component_Fullwidth_Slider extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Full-width Slider', 'mh-composer' );
		$this->slug            = 'mhc_fullwidth_slider';
		$this->fullwidth       = true;
		$this->child_slug      = 'mhc_slide';
		$this->child_item_text = esc_html__( 'Add New Slide', 'mh-composer' );

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'show_arrows',
			'show_pagination',
			'parallax',
			'parallax_method',
			'auto',
			'auto_speed',
			'inner_shadow',
			'top_padding',
			'bottom_padding',
			'show_media_on_mobile',
			'show_description_on_mobile',
			'show_buttons_on_mobile',
			'use_custom_animation',
			'custom_animation_image',
			'custom_animation_title',
			'custom_animation_content',
			'custom_animation_buttons',
			'pagination_style',
			'pagination_color',
			'admin_label',
		);

		$this->fields_defaults = array(
			'show_arrows'             => array( 'on' ),
			'show_pagination'         => array( 'on' ),
			'auto'                    => array( 'off' ),
			'auto_speed'              => array( '7000', 'append_default' ),
			'parallax'                => array( 'off' ),
			'parallax_method'         => array( 'off' ),
			'inner_shadow'            => array( 'on' ),
			'top_padding'			 => array( '17%', 'append_default' ),
			'bottom_padding'		  => array( '17%', 'append_default' ),
			'show_media_on_mobile' 	=> array( 'off' ),
			'show_description_on_mobile'  => array( 'off' ),
			'show_buttons_on_mobile'      => array( 'off' ),
			'use_custom_animation'        => array( 'off' ),
			'custom_animation_image'      => array( 'off' ),
			'custom_animation_title'      => array( 'off' ),
			'custom_animation_content'    => array( 'off' ),
			'custom_animation_buttons'    => array( 'off' ),
			'pagination_style'			=> array( 'dots' ),
		);
		
		$this->custom_css_options = array(
			'slide_description' => array(
				'label'    => esc_html__( 'Slide Description', 'mh-composer' ),
				'selector' => '.mhc_slide_description',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'slide_title' => array(
				'label'    => esc_html__( 'Slide Title', 'mh-composer' ),
				'selector' => '.mhc_slide_description .mhc_slide_title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'slide_button_one' => array(
				'label'    => esc_html__( 'Slide Button #1', 'mh-composer' ),
				'selector' => 'a.mhc_more_button1',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'slide_button_two' => array(
				'label'    => esc_html__( 'Slide Button #2', 'mh-composer' ),
				'selector' => 'a.mhc_more_button2',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'slide_controllers' => array(
				'label'    => esc_html__( 'Slide Controllers', 'mh-composer' ),
				'selector' => '.mhc-controllers',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'slide_controller' => array(
				'label'    => esc_html__( 'Slide Controller Dot', 'mh-composer' ),
				'selector' => '.mhc-controllers a',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'slide_controller_active' => array(
				'label'    => esc_html__( 'Slide Controller Acrive Dot', 'mh-composer' ),
				'selector' => '.mhc-controllers .mhc-active-control',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}
	
	function get_fields() {
		// List of animation options
		$animation_options = array(
			'off'     => esc_html__( 'No Animation', 'mh-composer' ),
			'right'   => esc_html__( 'Right To Left', 'mh-composer' ),
			'left'    => esc_html__( 'Left To Right', 'mh-composer' ),
			'top'     => esc_html__( 'Top To Bottom', 'mh-composer' ),
			'bottom'  => esc_html__( 'Bottom To Top', 'mh-composer' ),
			'fade_in' => esc_html__( 'Fade In', 'mh-composer' ),
		);
		$fields = array(
			'show_arrows'         => array(
				'label'           => esc_html__( 'Show Arrows', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'     => esc_html__( 'This setting will turn on and off the navigation arrows.', 'mh-composer' ),
			),
			'show_pagination' => array(
				'label'             => esc_html__( 'Show Controls', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'affects' => array(
					'#mhc_pagination_style',
				),
				'description'       => esc_html__( 'This setting will turn on and off the circle buttons at the bottom.', 'mh-composer' ),
			),
			'auto' => array(
				'label'           => esc_html__( 'Automatic Animation', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'Off', 'mh-composer' ),
					'on'  => esc_html__( 'On', 'mh-composer' ),
				),
				'affects' => array(
					'#mhc_auto_speed',
				),
				'description'        => esc_html__( 'If you would like the slider to play automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'mh-composer' ),
			),
			'auto_speed' => array(
				'label'             => esc_html__( 'Automatic Animation Speed (in ms)', 'mh-composer' ),
				'type'              => 'text',
				'depends_default'   => true,
				'description'       => esc_html__( "Here you can adjust the rotation speed. The higher the number the longer the pause between each rotation. (Ex. 1000 = 1 sec)", 'mh-composer' ),
			),
			'parallax' => array(
				'label'           => esc_html__( 'Parallax Effect', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_parallax_method'
				),
				'description'        => esc_html__( 'If enabled, your background image will stay fixed as your scroll, creating a parallax-like effect.', 'mh-composer' ),
			),
			'parallax_method' => array(
				'label'           => esc_html__( 'Parallax Method', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'off' => esc_html__( 'CSS Parallax', 'mh-composer' ),
					'on'  => esc_html__( 'JQuery Parallax', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'Define the method, used for the parallax effect.', 'mh-composer' ),
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
			'use_custom_animation' => array(
				'label'           => esc_html__( 'Use Custom Animation', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_custom_animation_image',
					'#mhc_custom_animation_title',
					'#mhc_custom_animation_content',
					'#mhc_custom_animation_buttons',
				),
				'tab_slug'          => 'advanced',
			),
			'custom_animation_image' => array(
				'label'           => esc_html__( 'Image Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $animation_options,
				'tab_slug'          => 'advanced',
				'depends_show_if'   => 'on',
			),
			'custom_animation_title' => array(
				'label'           => esc_html__( 'Title Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $animation_options,
				'tab_slug'          => 'advanced',
				'depends_show_if'   => 'on',
			),
			'custom_animation_content' => array(
				'label'           => esc_html__( 'Content Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $animation_options,
				'tab_slug'          => 'advanced',
				'depends_show_if'   => 'on',
			),
			'custom_animation_buttons' => array(
				'label'           => esc_html__( 'Buttons Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $animation_options,
				'tab_slug'          => 'advanced',
				'depends_show_if'   => 'on',
			),
			'inner_shadow' => array(
				'label'           => esc_html__( 'Show Inner Shadow', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on' => esc_html__( 'Yes', 'mh-composer' ),
					'off'  => esc_html__( 'No', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced',
			),
			'top_padding' => array(
				'label'           => esc_html__( 'Top Padding (%)', 'mh-composer' ),
				'type'            => 'range',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '17',
					'step' => '1',
				),
				'tab_slug'        => 'advanced',
			),
			'bottom_padding' => array(
				'label'           => esc_html__( 'Bottom Padding (%)', 'mh-composer' ),
				'type'            => 'range',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '17',
					'step' => '1',
				),
				'tab_slug'        => 'advanced',
			),
			'pagination_style' => array(
				'label'           => esc_html__( 'Pagination Style', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'dots' => esc_html__( 'Dots', 'mh-composer' ),
					'lines'  => esc_html__( 'Lines', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'Define the style for the pagination.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
			),
			'pagination_color' => array(
				'label'           => esc_html__( 'Pagination Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour for the arrows and pagination.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
				'custom_color' => true,
			),
			'show_media_on_mobile' => array(
				'label'           => esc_html__( 'Show Image / Video On Mobile', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced',
			),
			'show_description_on_mobile' => array(
				'label'           => esc_html__( 'Show Content On Mobile', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'tab_slug'          => 'advanced',
			),
			'show_buttons_on_mobile' => array(
				'label'           => esc_html__( 'Show Buttons On Mobile', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'tab_slug'          => 'advanced',
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

function pre_shortcode_content() {
		global $mhc_slider_has_video, $mhc_slider_parallax, $mhc_slider_parallax_method, $mhc_slider_hide_mobile, $mhc_slider_custom_animation, $mhc_slider_item_num;

		$mhc_slider_item_num = 0;

		$parallax        			   = $this->shortcode_atts['parallax'];
		$parallax_method 		 		= $this->shortcode_atts['parallax_method'];
		$show_description_on_mobile  	 = $this->shortcode_atts['show_description_on_mobile'];
		$show_buttons_on_mobile      	 = $this->shortcode_atts['show_buttons_on_mobile'];
		$custom_animation_image		 = $this->shortcode_atts['custom_animation_image'];
		$custom_animation_title		 = $this->shortcode_atts['custom_animation_title'];
		$custom_animation_content	   = $this->shortcode_atts['custom_animation_content'];
		$custom_animation_buttons	   = $this->shortcode_atts['custom_animation_buttons'];

		$mhc_slider_has_video = false;
		$mhc_slider_parallax = $parallax;
		$mhc_slider_parallax_method = $parallax_method;

		$mhc_slider_hide_mobile = array(
			'show_description_on_mobile'  => $show_description_on_mobile,
			'show_buttons_on_mobile'      => $show_buttons_on_mobile,
		);
		$mhc_slider_custom_animation = array(
			'custom_animation_image'	=> $custom_animation_image,
			'custom_animation_title'	=> $custom_animation_title,
			'custom_animation_content'  => $custom_animation_content,
			'custom_animation_buttons'  => $custom_animation_buttons,
		);

	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id               = $this->shortcode_atts['module_id'];
		$module_class            = $this->shortcode_atts['module_class'];
		$show_arrows             = $this->shortcode_atts['show_arrows'];
		$show_pagination         = $this->shortcode_atts['show_pagination'];
		$parallax                = $this->shortcode_atts['parallax'];
		$parallax_method         = $this->shortcode_atts['parallax_method'];
		$auto                    = $this->shortcode_atts['auto'];
		$auto_speed              = $this->shortcode_atts['auto_speed'];
		$inner_shadow     		= $this->shortcode_atts['inner_shadow'];
		$top_padding             = $this->shortcode_atts['top_padding'];
		$bottom_padding          = $this->shortcode_atts['bottom_padding'];
		$show_description_on_mobile  = $this->shortcode_atts['show_description_on_mobile'];
		$show_buttons_on_mobile      = $this->shortcode_atts['show_buttons_on_mobile'];
		$show_media_on_mobile 		= $this->shortcode_atts['show_media_on_mobile'];
		$use_custom_animation		   = $this->shortcode_atts['use_custom_animation'];
		$custom_animation_image		 = $this->shortcode_atts['custom_animation_image'];
		$custom_animation_title		 = $this->shortcode_atts['custom_animation_title'];
		$custom_animation_content	   = $this->shortcode_atts['custom_animation_content'];
		$custom_animation_buttons	   = $this->shortcode_atts['custom_animation_buttons'];
		$pagination_style 			   = $this->shortcode_atts['pagination_style'];
		$pagination_color 			   = $this->shortcode_atts['pagination_color'];

		global $mhc_slider_has_video, $mhc_slider_parallax, $mhc_slider_parallax_method, $mhc_slider_hide_mobile, $mhc_slider_custom_animation;

		$content = $this->shortcode_content;
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		if ( '17%' !== $top_padding ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_slide_description, .mhc_slider_fullwidth_off%%order_class%% .mhc_slide_description',
				'declaration' => sprintf(
					'padding-top: %1$s;',
					esc_html( mh_composer_process_range_value( $top_padding ))
				),
			) );
		}

		if ( '17%' !== $bottom_padding ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_slide_description, .mhc_slider_fullwidth_off%%order_class%% .mhc_slide_description',
				'declaration' => sprintf(
					'padding-bottom: %1$s;',
					esc_html( mh_composer_process_range_value( $bottom_padding ))
				),
			) );
		}

		if ( '17%' !== $bottom_padding  || '17%' !== $top_padding ) {
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_slide_description, .mhc_slider_fullwidth_off%%order_class%% .mhc_slide_description',
				'declaration' => 'padding-right: 0; padding-left: 0;',
			) );
		}
		
		if ( 'lines' === $pagination_style ) {
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-controllers a',
				'declaration' => 'width:30px; height:7px;',
			) );
		}
		
		if ( '' !== $pagination_color ) {
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-arrow-next, %%order_class%% .mhc-arrow-prev',
				'declaration' => sprintf(
					'color:%1$s !important;',
				esc_html( $pagination_color ))
			) );
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-controllers a',
				'declaration' => sprintf(
					'background-color:%1$s !important; opacity:0.5;',
				esc_html( $pagination_color ))
			) );
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-controllers a.mhc-active-control',
				'declaration' => sprintf(
					'background-color:%1$s !important; opacity:1;',
				esc_html( $pagination_color ))
			) );
		}

		$fullwidth = 'mhc_fullwidth_slider' === $function_name ? 'on' : 'off';

		$class  = '';
		$class .= 'off' === $fullwidth ? ' mhc_slider_fullwidth_off' : '';
		$class .= 'off' === $show_arrows ? ' mhc_slider_no_arrows' : '';
		$class .= 'off' === $show_pagination ? ' mhc_slider_no_pagination' : '';
		$class .= 'on' === $parallax ? ' mhc_slider_parallax' : '';
		$class .= 'on' === $auto ? ' mh_slider_auto mh_slider_speed_' . esc_attr( $auto_speed ) : '';
		$class .= 'on' !== $inner_shadow ? ' mhc_slider_hide_shadow' : '';
		$class .= 'on' !== $show_media_on_mobile ? ' mhc_slider_hide_media' : '';
		$class .= 'on' !== $use_custom_animation ? ' mh_slide_animation' : ' mh_custom_animation';
		$class .= 'lines' === $pagination_style ? ' mhc_controllers_corners' : '';

		$output = sprintf(
			'<div%4$s class="mhc_module mhc_slider%1$s%3$s%5$s">
				<div class="mhc_slides">
					%2$s
				</div> <!-- .mhc_slides -->
			</div> <!-- .mhc_slider -->
			',
			$class,
			$content,
			( $mhc_slider_has_video ? ' mhc_preload' : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Fullwidth_Slider;