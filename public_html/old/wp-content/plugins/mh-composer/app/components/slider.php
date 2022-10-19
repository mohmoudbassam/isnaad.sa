<?php
class MHComposer_Component_Slider extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Slider', 'mh-composer' );
		$this->slug            = 'mhc_slider';
		$this->child_slug      = 'mhc_slide';
		$this->child_item_text = esc_html__( 'Add New Slide', 'mh-composer' );
		$this->main_css_selector = '%%order_class%%.mhc_slider';
		
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
new MHComposer_Component_Slider;

class MHComposer_Component_Slider_Item extends MHComposer_Component {
	function init() {
		$this->name                        = esc_html__( 'Slide', 'mh-composer' );
		$this->slug                        = 'mhc_slide';
		$this->type                        = 'child';
		$this->child_title_var             = 'admin_title';
		$this->child_title_fallback_var    = 'heading';
		$this->advanced_setting_title_text = esc_html__( 'New Slide', 'mh-composer' );
		$this->settings_text               = esc_html__( 'Slide Settings', 'mh-composer' );
		$this->main_css_selector = '%%order_class%%';

		$this->approved_fields = array(
			'alignment',
			'heading',
			'button_text',
			'button_link',
			'button_style',
			'button_color',
			'button_text_color',
			'button2_text',
			'button2_link',
			'button2_style',
			'button2_color',
			'button2_text_color',
			'background_color',
			'background_image',
			'background_position',
			'background_size',
			'image',
			'image_alt',
			'content_orientation',
			'background_layout',
			'title_color',
			'content_color',
			'title_bold',
			'video_bg_mp4',
			'video_bg_webm',
			'video_bg_width',
			'video_bg_height',
			'video_pause',
			'video_url',
			'content_new',
			'admin_title',
			'show_video_fields',
		);
		$accent_color = mh_composer_accent_color();
		$this->fields_defaults = array(
			'button_style'        => array( 'off' ),
			'button_color'		=> array( $accent_color, 'append_default' ),
			'button_text_color'   => array( '#ffffff', 'append_default' ),
			'button2_style'       => array( 'off' ),
			'button2_color'	   => array( $accent_color, 'append_default' ),
			'button2_text_color'  => array( '#ffffff', 'append_default' ),
			'background_position' => array( 'default' ),
			'background_size'     => array( 'default' ),
			'background_color'    => array( '#ffffff', 'append_default' ),
			'alignment'           => array( 'center' ),
			'background_layout'   => array( 'dark' ),
			'video_pause'  		 => array( 'off' ),
			'content_orientation' => array( 'center' ),
			'title_bold' 		  => array( 'off'),
		);
	}
	
	function get_fields() {
		$fields = array(
			'heading' => array(
				'label'           => esc_html__( 'Heading', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define the title text for your slide.', 'mh-composer' ),
			),
			'button_text' => array(
				'label'           => esc_html__( 'Button #1 Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define the text for the slide button.', 'mh-composer' ),
			),
			'button_link' => array(
				'label'           => esc_html__( 'Button #1 URL', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input a destination URL for the slide button.', 'mh-composer' ),
			),
			'button_style' => array(
				'label'           => esc_html__( 'Button #1 Style', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'off' => esc_html__( 'Transparent', 'mh-composer' ),
					'on' => esc_html__( 'Solid', 'mh-composer' ),
				),
				'affects'     => array(
					'#mhc_button_color',
					'#mhc_button_text_color',
				),
				'description'       => esc_html__( 'This defines the button style.', 'mh-composer' ),
			),
			'button_color' => array(
				'label'             => esc_html__( 'Button Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_default'   => true,
				'description'       => esc_html__( 'Define a custom colour for your button, or leave blank to use the default colour.', 'mh-composer' ),
				'depends_default' => true,
			),
			'button_text_color' => array(
				'label'             => esc_html__( 'Button Text Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_default'   => true,
				'description'       => esc_html__( 'Define a custom colour for your button text, or leave blank to use the default colour.', 'mh-composer' ),
				'depends_default' => true,
			),
			'button2_text' => array(
				'label'           => esc_html__( 'Button #2 Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define the text for the slide button.', 'mh-composer' ),
			),
			'button2_link' => array(
				'label'           => esc_html__( 'Button #2 URL', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input a destination URL for the slide button.', 'mh-composer' ),
			),
			'button2_style' => array(
				'label'           => esc_html__( 'Button #2 Style', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'off' => esc_html__( 'Transparent', 'mh-composer' ),
					'on' => esc_html__( 'Solid', 'mh-composer' ),
				),
				'affects'     => array(
					'#mhc_button2_color',
					'#mhc_button2_text_color',
				),
				'description'       => esc_html__( 'This defines the button style.', 'mh-composer' ),
			),
			'button2_color' => array(
				'label'             => esc_html__( 'Button Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_default'   => true,
				'description'       => esc_html__( 'Define a custom colour for your button, or leave blank to use the default colour.', 'mh-composer' ),
				'depends_default' => true,
			),
			'button2_text_color' => array(
				'label'             => esc_html__( 'Button Text Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_default'   => true,
				'description'       => esc_html__( 'Define a custom colour for your button text, or leave blank to use the default colour.', 'mh-composer' ),
				'depends_default' => true,
			),
			'background_image' => array(
				'label'              => esc_html__( 'Background Image', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Background Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Background', 'mh-composer' ),
				'description'        => esc_attr__( 'If defined, this image will be used as a background. To remove a background image, simply delete the URL from the settings field.', 'mh-composer' ),
			),
			'background_position' => array(
				'label'           => esc_html__( 'Background Image Position', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'default'       => esc_html__( 'Default', 'mh-composer' ),
					'center'        => esc_html__( 'Centre', 'mh-composer' ),
					'top_left'      => esc_html__( 'Top Left', 'mh-composer' ),
					'top_center'    => esc_html__( 'Top Centre', 'mh-composer' ),
					'top_right'     => esc_html__( 'Top Right', 'mh-composer' ),
					'center_right'  => esc_html__( 'Centre Right', 'mh-composer' ),
					'center_left'   => esc_html__( 'Centre Left', 'mh-composer' ),
					'bottom_left'   => esc_html__( 'Bottom Left', 'mh-composer' ),
					'bottom_center' => esc_html__( 'Bottom Centre', 'mh-composer' ),
					'bottom_right'  => esc_html__( 'Bottom Right', 'mh-composer' ),
				),
			),
			'background_size' => array(
				'label'           => esc_html__( 'Background Image Size', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'default' => esc_html__( 'Default', 'mh-composer' ),
					'cover'   => esc_html__( 'Cover', 'mh-composer' ),
					'contain' => esc_html__( 'Fit', 'mh-composer' ),
					'initial' => esc_html__( 'Actual Size', 'mh-composer' ),
				),
			),
			'background_color' => array(
				'label'       => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'        => 'color-alpha',
				'description' => esc_html__( 'Use the colour picker to choose a background colour for this component.', 'mh-composer' ),
			),
			'image' => array(
				'label'              => esc_html__( 'Slide Image', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Slide Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Slide Image', 'mh-composer' ),
				'description'        => esc_html__( 'If defined, this slide image will appear beside your slide text. Upload an image, or leave blank for a text-only slide.', 'mh-composer' ),
			),
			'image_alt' => array(
				'label'           => esc_html__( 'Image Alternative Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'If you have a slide image defined, input your HTML ALT text for the image here.', 'mh-composer' ),
			),
			'alignment' => array(
				'label'           => esc_html__( 'Slide Image Vertical Alignment', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'center' => esc_html__( 'Centre', 'mh-composer' ),
					'top' => esc_html__( 'Top', 'mh-composer' ),
					'bottom' => esc_html__( 'Bottom', 'mh-composer' ),
				),
				'description' => esc_html__( 'This setting determines the vertical alignment of your image.', 'mh-composer' ),
			),
			'video_url' => array(
				'label'           => esc_html__( 'Slide Video', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'If defined, this video will appear beside your slide text. Enter youtube or vimeo page URL, or leave blank for a text-only slide.', 'mh-composer' ),
			),
			'content_orientation' => array(
				'label'             => esc_html__( 'Content Orientation', 'mh-composer' ),
				'type'              => 'select',
				'options'         => array(
					'center'  	 => esc_html__( 'Centre', 'mh-composer' ),
					'right' 	=> esc_html__( 'Right', 'mh-composer' ),
					'left' 	=> esc_html__( 'Left', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can adjust the alignment of the content. This will not work if you have a slide image or a slide video.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'dark'  	 => esc_html__( 'Light', 'mh-composer' ),
					'light' 	=> esc_html__( 'Dark', 'mh-composer' ),
				),
				'description'     => esc_html__( 'Here you can choose whether your text is light or dark. If you have a slide with a dark background, then choose light text. If you have a light background, then use dark text.' , 'mh-composer' ),
			),
			'show_video_fields' => array(
				'label'           => esc_html__( 'Video Background', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_video_bg_mp4',
					'#mhc_video_bg_webm',
					'#mhc_video_bg_width',
					'#mhc_video_bg_height',
					'#mhc_video_pause',
				),
				'description' => esc_html__( 'Enable this option if you want to use a video background. More options will appear below.', 'mh-composer' ),
			),
			'video_bg_mp4' => array(
				'label'              => esc_html__( 'Background Video MP4', 'mh-composer' ),
				'type'               => 'upload',
				'data_type'          => 'video',
				'upload_button_text' => esc_attr__( 'Upload a video', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Background Video MP4 File', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Background Video', 'mh-composer' ),
				'description'        => mh_wp_kses( __( 'All videos should be uploaded in both .MP4 and .WEBM formats to ensure maximum compatibility in all browsers. Upload the .MP4 version here. <b>Important Note: Video backgrounds are disabled from mobile devices. Instead, your background image will be used. For this reason, you should define both a background image and a background video to ensure best results.</b>', 'mh-composer' )),
			),
			'video_bg_webm' => array(
				'label'              => esc_html__( 'Background Video WEBM', 'mh-composer' ),
				'type'               => 'upload',
				'data_type'          => 'video',
				'upload_button_text' => esc_attr__( 'Upload a video', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Background Video WEBM File', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Background Video', 'mh-composer' ),
				'description'        => mh_wp_kses( __( 'All videos should be uploaded in both .MP4 and .WEBM formats to ensure maximum compatibility in all browsers. Upload the .WEBM version here. <b>Important Note: Video backgrounds are disabled from mobile devices. Instead, your background image will be used. For this reason, you should define both a background image and a background video to ensure best results.</b>', 'mh-composer' )),
				'depends_show_if'   => 'on',
			),
			'video_bg_width' => array(
				'label'           => esc_html__( 'Background Video Width', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'In order for videos to be sized correctly, you must input the exact width (in pixels) of your video here.' ,'mh-composer' ),
			),
			'video_bg_height' => array(
				'label'           => esc_html__( 'Background Video Height', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'In order for videos to be sized correctly, you must input the exact height (in pixels) of your video here.' ,'mh-composer' ),
				'depends_show_if'   => 'on',
			),
			'video_pause' => array(
				'label'           => esc_html__( 'Pause Video', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'     => esc_html__( 'Allow video to be paused by other players when they begin playing' ,'mh-composer' ),
				'depends_show_if'   => 'on',
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'mh-composer' ),
				'type'            => 'tiny_mce',
				'description'     => esc_html__( 'Input the main text content here.', 'mh-composer' ),
			),
			'admin_title' => array(
				'label'       => esc_html__( 'Label', 'mh-composer' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the slide in the composer for easy identification.', 'mh-composer' ),
			),
			'title_color' => array(
				'label'             => esc_html__( 'Title Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour for the title.', 'mh-composer' ),
				'custom_color'      => true,
				'tab_slug'     => 'advanced',
			),
			'title_bold' => array(
				'label'           => esc_html__( 'Bold Title', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose whether your title is bold.', 'mh-composer' ),
				'tab_slug'     => 'advanced',
			),
			'content_color' => array(
				'label'             => esc_html__( 'Content Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour for the slider content.', 'mh-composer' ),
				'custom_color'      => true,
				'tab_slug'     => 'advanced',
			),
		);
		return $fields;
	}
	
	function shortcode_callback( $atts, $content = null, $function_name ) {
		$alignment            = $this->shortcode_atts['alignment'];
		$heading              = $this->shortcode_atts['heading'];
		$button_text          = $this->shortcode_atts['button_text'];
		$button_link          = $this->shortcode_atts['button_link'];
		$button_style         = $this->shortcode_atts['button_style'];
		$button_color         = $this->shortcode_atts['button_color'];
		$button_text_color    = $this->shortcode_atts['button_text_color'];
		$button2_text         = $this->shortcode_atts['button2_text'];
		$button2_link         = $this->shortcode_atts['button2_link'];
		$button2_style        = $this->shortcode_atts['button2_style'];
		$button2_color        = $this->shortcode_atts['button2_color'];
		$button2_text_color   = $this->shortcode_atts['button2_text_color'];
		$background_color     = $this->shortcode_atts['background_color'];
		$background_image     = $this->shortcode_atts['background_image'];
		$background_position  = $this->shortcode_atts['background_position'];
		$background_size      = $this->shortcode_atts['background_size'];
		$image                = $this->shortcode_atts['image'];
		$image_alt            = $this->shortcode_atts['image_alt'];
		$background_layout    = $this->shortcode_atts['background_layout'];
		$title_color          = $this->shortcode_atts['title_color'];
		$content_color          = $this->shortcode_atts['content_color'];
		$title_bold 		   = $this->shortcode_atts['title_bold'];
		$content_orientation  = $this->shortcode_atts['content_orientation'];
		$video_bg_webm        = $this->shortcode_atts['video_bg_webm'];
		$video_bg_mp4         = $this->shortcode_atts['video_bg_mp4'];
		$video_bg_width       = $this->shortcode_atts['video_bg_width'];
		$video_bg_height      = $this->shortcode_atts['video_bg_height'];
		$video_url            = $this->shortcode_atts['video_url'];
		$video_pause   		  = $this->shortcode_atts['video_pause'];
		$show_video_fields   = $this->shortcode_atts['show_video_fields'];

		global $mhc_slider_has_video, $mhc_slider_parallax, $mhc_slider_parallax_method, $mhc_slider_hide_mobile, $mhc_slider_custom_animation, $mhc_slider_item_num;
		
		$background_video = $class = $style = $button = $button2 = '';
		$mhc_slider_item_num++;
		$first_video = false;
		$hide_on_mobile_class = 'mh_hide_on_small';
		
		if ( '' !== $video_bg_mp4 || '' !== $video_bg_webm ) {
			if ( ! $mhc_slider_has_video )
				$first_video = true;

			$background_video = sprintf(
				'<div class="mhc_section_video_bg%2$s%3$s">
					%1$s
				</div>',
				do_shortcode( sprintf( '
					<video loop="loop"%3$s%4$s>
						%1$s
						%2$s
					</video>',
					( '' !== $video_bg_mp4 ? sprintf( '<source type="video/mp4" src="%s" />', esc_url( $video_bg_mp4 ) ) : '' ),
					( '' !== $video_bg_webm ? sprintf( '<source type="video/webm" src="%s" />', esc_url( $video_bg_webm ) ) : '' ),
					( '' !== $video_bg_width ? sprintf( ' width="%s"', esc_attr( intval( $video_bg_width ) ) ) : '' ),
					( '' !== $video_bg_height ? sprintf( ' height="%s"', esc_attr( intval( $video_bg_height ) ) ) : '' ),
					( '' !== $background_image ? sprintf( ' poster="%s"', esc_url( $background_image ) ) : '' )
				) ),
				( $first_video ? ' mhc_first_video' : '' ),
				( 'on' === $video_pause ? ' mhc_video_pause' : '' )
			);

			$mhc_slider_has_video = true;

			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
		
		if ( '' !== $heading ) {
			if ( '#' !== $button_link ) {
				$heading = sprintf( '<a href="%1$s">%2$s</a>',
					esc_url( $button_link ),
					$heading
				);
			}
			$heading = sprintf('<h2 class="mhc_slide_title%2$s">%1$s</h2>',
			$heading,
			( 'off' !== $mhc_slider_custom_animation['custom_animation_title'] ? esc_attr( " mh_custom_animation_{$mhc_slider_custom_animation['custom_animation_title']}" ) : '')
			);
			
		}
		//button1
		if ( '' !== $button_text ) {
			$button = sprintf( '<a href="%1$s" class="mhc_more_button mhc_more_button1%3$s%4$s%5$s">%2$s</a>',
				('' !== $button_link ? esc_url( $button_link ) : '#'),
				esc_html( $button_text ),
				( 'on' === $button_style
					? sprintf( ' mhc_solidify')
					: ' mhc_transify'
				),
				( 'on' !== $mhc_slider_hide_mobile['show_buttons_on_mobile'] ? esc_attr( " {$hide_on_mobile_class}" ) : '' ),
				( 'off' !== $mhc_slider_custom_animation['custom_animation_buttons'] ? esc_attr( " mh_custom_animation_{$mhc_slider_custom_animation['custom_animation_buttons']}" ) : '')
			);
		}
		//button2
		if ( '' !== $button2_text ) {
			$button2 = sprintf( '<a href="%1$s" class="mhc_more_button mhc_more_button2%3$s%4$s%5$s">%2$s</a>',
				('' !== $button2_link ? esc_url( $button2_link ) : '#'),
				esc_html( $button2_text ),
				( 'on' === $button2_style
					? sprintf( ' mhc_solidify')
					: ' mhc_transify'
				),
				( 'on' !== $mhc_slider_hide_mobile['show_buttons_on_mobile'] ? esc_attr( " {$hide_on_mobile_class}" ) : '' ),
				( 'off' !== $mhc_slider_custom_animation['custom_animation_buttons'] ? esc_attr( " mh_custom_animation_{$mhc_slider_custom_animation['custom_animation_buttons']}" ) : '')
			);
		}

		$image = '' !== $image
			? sprintf( '<div class="mhc_slide_image%3$s"><img src="%1$s" alt="%2$s" /></div>',
				esc_url( $image ),
				esc_attr( $image_alt ),
				( 'off' !== $mhc_slider_custom_animation['custom_animation_image'] ? esc_attr( " mh_custom_animation_{$mhc_slider_custom_animation['custom_animation_image']}" ) : '')
			)
			: '';

		if ( '' !== $video_url ) {
			global $wp_embed;

			$video_embed = apply_filters( 'the_content', $wp_embed->shortcode( '', esc_url( $video_url ) ) );

			$video_embed = preg_replace('/<embed /','<embed wmode="transparent" ',$video_embed);
			$video_embed = preg_replace('/<\/object>/','<param name="wmode" value="transparent" /></object>',$video_embed);

			$image = sprintf( '<div class="mhc_slide_video">%1$s</div>',
				$video_embed
			);
		}

		if ( '' !== $image ) $class .= ' mhc_slide_with_image';

		if ( '' !== $video_url ) $class .= ' mhc_slide_with_video';

		$class .= " mhc_bg_layout_{$background_layout}";

		if ( 'bottom' !== $alignment ) {
			$class .= " mhc_media_alignment_{$alignment}";
		}
		
		if ( '' !== $background_color )
			$style .= sprintf( 'background-color:%s;',
				esc_attr( $background_color )
			);

		if ( '' !== $background_image && 'on' !== $mhc_slider_parallax )
			$style .= sprintf( 'background-image:url(%s);',
				esc_url( $background_image )
			);

		$style = '' !== $style ? " style='{$style}'" : '';
		
		if ( 'on' === $button_style ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '.mhc_slider %%order_class%% .mhc_more_button1',
				'declaration' => sprintf(
					'background-color: %1$s; border-color:%1$s; color:%2$s !important;',
					esc_attr( $button_color ),
					esc_attr( $button_text_color )
				),
			) );
		}
		
		if ( 'on' === $button2_style ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '.mhc_slider %%order_class%% .mhc_more_button2',
				'declaration' => sprintf(
					'background-color: %1$s; border-color:%1$s; color:%2$s !important;',
					esc_attr( $button2_color ),
					esc_attr( $button2_text_color )
				),
			) );
		}
		
		if ( 'default' !== $background_position && 'off' === $mhc_slider_parallax ) {
			$processed_position = str_replace( '_', ' ', $background_position );

			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '.mhc_slider %%order_class%%',
				'declaration' => sprintf(
					'background-position: %1$s;',
					esc_html( $processed_position )
				),
			) );
		}

		if ( 'default' !== $background_size && 'off' === $mhc_slider_parallax ) {
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '.mhc_slider %%order_class%%',
				'declaration' => sprintf(
					'-moz-background-size: %1$s;
					-webkit-background-size: %1$s;
					background-size: %1$s;',
					esc_html( $background_size )
				),
			) );
		}
		if ( 'initial' === $background_size ) {
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => 'body.ie %%order_class%% .mhc_slide',
				'declaration' => sprintf(
					'-moz-background-size: %1$s;
					-webkit-background-size: %1$s;
					background-size: %1$s;',
					'auto'
				),
			) );
		}
		if ( '' !== $title_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '.mhc_slider %%order_class%% .mhc_slide_title',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $title_color )
				),
			) );
		}
		if ( 'off' !== $title_bold ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '.mhc_slider %%order_class%% .mhc_slide_title',
				'declaration' => 'font-weight:bold'
			) );
		}
		if ( '' !== $content_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '.mhc_slider %%order_class%% .mhc_slide_content, .mhc_slider %%order_class%% .mhc_slide_content h1, .mhc_slider %%order_class%% .mhc_slide_content h2, .mhc_slider %%order_class%% .mhc_slide_content h3, .mhc_slider %%order_class%% .mhc_slide_content h4, .mhc_slider %%order_class%% .mhc_slide_content h5, .mhc_slider %%order_class%% .mhc_slide_content h6',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $content_color )
				),
			) );
		}
		if ('center' !== $content_orientation && '' === $image && '' === $video_url) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '.mhc_slider %%order_class%% .mhc_slide_description',
				'declaration' => sprintf(
					'text-align:%1$s',
					esc_html( $content_orientation )
				),
			) );
		}
		$class = MHComposer_Core::add_module_order_class( $class, $function_name );
		
		if ( 1 === $mhc_slider_item_num ) {
			$class .= " mhc-active-slide";
		}
		
		$output = sprintf(
			'<div class="mhc_slide%6$s%10$s"%11$s>
				%8$s
				<div class="mhc_container clearfix">
					%5$s
					<div class="mhc_slide_description">
						%1$s
						<div class="mhc_slide_content%9$s%12$s">%2$s</div>
						%3$s%4$s
					</div> <!-- .mhc_slide_description -->
				</div> <!-- .mhc_container -->
				%7$s
			</div> <!-- .mhc_slide -->
			',
			$heading,
			$this->shortcode_content,
			$button,
			$button2,
			$image,
			esc_attr( $class ),
			( '' !== $background_video ? $background_video : '' ),
			( '' !== $background_image && 'on' === $mhc_slider_parallax ? sprintf(
				'<div class="mh_parallax_bg%2$s" style="background-image: url(%1$s);"></div>',
				esc_url( $background_image ),
				( 'off' === $mhc_slider_parallax_method ? ' mhc_parallax_css' : '' )
				) : '' ),
			( 'on' !== $mhc_slider_hide_mobile['show_description_on_mobile'] ? esc_attr( " {$hide_on_mobile_class}" ) : '' ),
			('' !== $button2 ? ' has_two_buttons' : ''),
			$style,
			( 'off' !== $mhc_slider_custom_animation['custom_animation_content'] ? esc_attr( " mh_custom_animation_{$mhc_slider_custom_animation['custom_animation_content']}" ) : '')
		);

		return $output;
	}
}
new MHComposer_Component_Slider_Item;