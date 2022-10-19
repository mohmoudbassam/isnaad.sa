<?php
class MHComposer_Component_Testimonials_Slider extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Testimonials Slider', 'mh-composer' );
		$this->slug            = 'mhc_testimonials_slider';
		$this->child_slug      = 'mhc_testimonials_slide';
		$this->child_item_text = esc_html__( 'Add New Testimonial', 'mh-composer' );
		

		$this->approved_fields = array(
			'show_arrows',
			'show_pagination',
			'auto',
			'auto_speed',
			'admin_label',
			'module_id',
			'module_class',
			'min_height',
			'pagination_style',
			'pagination_color',
		);

		$this->fields_defaults = array(
			'show_arrows'             => array( 'on' ),
			'show_pagination'         => array( 'on' ),
			'auto'                    => array( 'off' ),
			'auto_speed'              => array( '7000', 'append_default'  ),
			'pagination_style'			=> array( 'dots' ),
		);
		
		$this->custom_css_options = array(
			'testimonial_portrait' => array(
				'label'    => esc_html__( 'Testimonial Portrait', 'mh-composer' ),
				'selector' => '.mhc_testimonials_slide_portrait',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'testimonial_author' => array(
				'label'    => esc_html__( 'Testimonial Author', 'mh-composer' ),
				'selector' => '.mhc_testimonial_author',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'testimonial_meta' => array(
				'label'    => esc_html__( 'Testimonial Meta', 'mh-composer' ),
				'selector' => '.mhc_testimonial_meta',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
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
			'min_height' => array(
				'label'           => esc_html__( 'Minimum Height', 'mh-composer' ),
				'type'            => 'range',
				'default' => '265',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '300',
					'step' => '1',
				),
				'tab_slug'        => 'advanced',
				'validate_unit'   => true,
				'description'     => esc_html__( 'This will change the minimum height for the slides.', 'mh-composer' ),
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
		$module_id               = $this->shortcode_atts['module_id'];
		$module_class            = $this->shortcode_atts['module_class'];
		$show_arrows             = $this->shortcode_atts['show_arrows'];
		$show_pagination         = $this->shortcode_atts['show_pagination'];
		$auto                    = $this->shortcode_atts['auto'];
		$auto_speed              = $this->shortcode_atts['auto_speed'];
		$min_height              = $this->shortcode_atts['min_height'];
		$pagination_style 		= $this->shortcode_atts['pagination_style'];
		$pagination_color 		= $this->shortcode_atts['pagination_color'];

		$content = $this->shortcode_content;

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		if ( '265' !== $min_height || '' !== $min_height ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_testimonials_slide_description',
				'declaration' => sprintf(
					'min-height: %1$s;',
					esc_html( mh_composer_process_range_value( $min_height ) )
				),
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

		$class  = '';
		$class .= 'off' === $show_arrows ? ' mhc_slider_no_arrows' : '';
		$class .= 'off' === $show_pagination ? ' mhc_slider_no_pagination' : '';
		$class .= 'on' === $auto ? ' mh_slider_auto mh_slider_speed_' . esc_attr( $auto_speed ) : '';
		$class .= 'lines' === $pagination_style ? ' mhc_controllers_corners' : '';

		$output = sprintf(
			'<div%3$s class="mhc_module mhc_testimonials_slider mhc_slider%1$s%3$s%4$s">
				<div class="mhc_slides">
					%2$s
				</div> <!-- .mhc_slides -->
			</div> <!-- .mhc_testimonials_slider -->
			',
			$class,
			$content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Testimonials_Slider;

class MHComposer_Component_Testimonials_Slider_Item extends MHComposer_Component {
	function init() {
		$this->name                        = esc_html__( 'Slide', 'mh-composer' );
		$this->slug                        = 'mhc_testimonials_slide';
		$this->type                        = 'child';
		$this->child_title_var             = 'admin_title';
		$this->child_title_fallback_var    = 'author';
		$this->advanced_setting_title_text = esc_html__( 'New Slide', 'mh-composer' );
		$this->settings_text               = esc_html__( 'Slide Settings', 'mh-composer' );
		$this->main_css_selector = '%%order_class%%';

		$this->approved_fields = array(
			'author',
			'job_title',
			'portrait_url',
			'company_name',
			'url',
			'quote_icon',
			'url_new_window',
			'quote_icon_color',
			'background_layout',
			'portrait_width',
			'portrait_height',
			'portrait_radius',
			'quote_icon_symbol',
		);

		$this->fields_defaults = array(
			'url_new_window'       => array( 'off' ),
			'quote_icon'           => array( 'off' ),
			'background_layout'    => array( 'light' ),
		);
	}

	function get_fields() {
		$fields = array(
			'author' => array(
				'label'           => esc_html__( 'Author Name', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input the name of the testimonial author.', 'mh-composer' ),
			),
			'job_title' => array(
				'label'           => esc_html__( 'Job Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input the job title.', 'mh-composer' ),
			),
			'company_name' => array(
				'label'           => esc_html__( 'Company Name', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input the name of the company.', 'mh-composer' ),
			),
			'url' => array(
				'label'           => esc_html__( 'Author/Company URL', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input the website of the author or leave blank for no link.', 'mh-composer' ),
			),
			'url_new_window' => array(
				'label'           => esc_html__( 'URL Opens', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'mh-composer' ),
					'on'  => esc_html__( 'In a New Tab', 'mh-composer' ),
				),
				'description'     => esc_html__( 'Here you can choose whether your link opens in a new window.', 'mh-composer' ),
			),
			'portrait_url' => array(
				'label'              => esc_html__( 'Portrait Image URL', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Image', 'mh-composer' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'light' => esc_html__( 'Dark', 'mh-composer' ),
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'mh-composer' ),
				'type'            => 'tiny_mce',
				'description'     => esc_html__( 'Input the main text content here.', 'mh-composer' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Label', 'mh-composer' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the slide in the composer for easy identification.', 'mh-composer' ),
			),
			'portrait_radius' => array(
				'label'           => esc_html__( 'Portrait Border Radius', 'mh-composer' ),
				'type'            => 'range',
				'tab_slug'        => 'advanced',
			),
			'portrait_width' => array(
				'label'           => esc_html__( 'Portrait Width', 'mh-composer' ),
				'type'            => 'range',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '200',
					'step' => '1',
				),
			),
			'portrait_height' => array(
				'label'           => esc_html__( 'Portrait Height', 'mh-composer' ),
				'type'            => 'range',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '200',
					'step' => '1',
				),
			),
			'quote_icon' => array(
				'label'           => esc_html__( 'Use Icon', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects' => array(
				'#mhc_quote_icon_color',
				'#mhc_quote_icon_symbol',
				),
				'tab_slug'          => 'advanced',
			),
			'quote_icon_color' => array(
				'label'             => esc_html__( 'Icon Colour', 'mh-composer' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
				'depends_default'   => true,
			),
			'quote_icon_symbol' => array(
				'label'               => esc_html__( 'Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_icon_list',
				'renderer_with_field' => true,
				'tab_slug'            => 'advanced',
				'depends_default'   => true,
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$author                 = $this->shortcode_atts['author'];
		$job_title              = $this->shortcode_atts['job_title'];
		$portrait_url           = $this->shortcode_atts['portrait_url'];
		$company_name           = $this->shortcode_atts['company_name'];
		$url                    = $this->shortcode_atts['url'];
		$quote_icon             = $this->shortcode_atts['quote_icon'];
		$url_new_window         = $this->shortcode_atts['url_new_window'];
		$background_layout      = $this->shortcode_atts['background_layout'];
		$quote_icon_color       = $this->shortcode_atts['quote_icon_color'];
		$portrait_radius 		= $this->shortcode_atts['portrait_radius'];
		$portrait_width         = $this->shortcode_atts['portrait_width'];
		$portrait_height        = $this->shortcode_atts['portrait_height'];
		$quote_icon_symbol	  = $this->shortcode_atts['quote_icon_symbol'];

		$class  = '';
		$class = MHComposer_Core::add_module_order_class( $class, $function_name );
		
		if ( '' !== $portrait_radius ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_testimonials_slide_portrait',
				'declaration' => sprintf(
					'-webkit-border-radius: %1$s; -moz-border-radius: %1$s; border-radius: %1$s;',
					esc_html( mh_composer_process_range_value( $portrait_radius ) )
				),
			) );
		}

		if ( '' !== $portrait_width ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_testimonials_slide_portrait',
				'declaration' => sprintf(
					'width: %1$s;',
					esc_html( mh_composer_process_range_value( $portrait_width ) )
				),
			) );
		}

		if ( '' !== $portrait_height ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_testimonials_slide_portrait',
				'declaration' => sprintf(
					'height: %1$s;',
					esc_html( mh_composer_process_range_value( $portrait_height ) )
				),
			) );
		}

		if ( '' !== $quote_icon_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_testimonials_slide_icon::before',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $quote_icon_color )
				),
			) );
		}


		$portrait_image = '';

		$class .= " mhc_module mhc_bg_layout_{$background_layout}";

		if ( ! isset( $atts['quote_icon'] ) ) {
			$class .= "	mhc_testimonial_old_layout";
		}

		if ( '' !== $portrait_url ) {
			$portrait_image = sprintf(
				'<div class="mhc_testimonials_slide_portrait" style="background-image: url(%1$s);">
				</div>',
				esc_attr( $portrait_url )
			);
		}

		if ( '' !== $url && ( '' !== $company_name || '' !== $author ) ) {
			$link_output = sprintf( '<a href="%1$s"%3$s>%2$s</a>',
				esc_url( $url ),
				( '' !== $company_name ? esc_html( $company_name ) : esc_html( $author ) ),
				( 'on' === $url_new_window ? ' target="_blank"' : '' )
			);

			if ( '' !== $company_name ) {
				$company_name = $link_output;
			} else {
				$author = $link_output;
			}
		}
		
		if ( 'off' !== $quote_icon && '' !== $quote_icon_symbol ) {
			$data_icon = '' !== $quote_icon_symbol
				? sprintf(
					' data-icon="%1$s"',
					esc_attr( mhc_process_font_icon( $quote_icon_symbol, "mhc_font_mhicons_icon_symbols" ) )
				)
				: '';
		}

		$output = sprintf(
			'<div class="mhc_testimonials_slide mhc_slide clearfix%3$s%7$s%8$s">
				<div class="mhc_testimonials_slide_description">
				%1$s
				%6$s
				%9$s
					<div class="mhc_testimonial_description_inner">
					
					<strong class="mhc_testimonial_author">%2$s</strong>
					<p class="mhc_testimonial_meta">%4$s%5$s</p>
					</div> <!-- .mhc_testimonial_description_inner -->
				</div> <!-- .mhc_testimonials_slide_description -->
			</div> <!-- .mhc_testimonials_slide -->',
			$this->shortcode_content,
			$author,
			( 'off' === $quote_icon ? ' mhc_icon_off' : '' ),
			( '' !== $job_title ? esc_html( $job_title ) : '' ),
			( '' !== $company_name
				? sprintf( '%3$s%2$s%1$s',
					$company_name,
						( '' !== $job_title && is_rtl() ? '، ' : '' ),
						( '' !== $job_title && !is_rtl() ? ', ' : '' )
				)
				: ''
			),
			( '' !== $portrait_image ? $portrait_image : '' ),
			( '' === $portrait_image ? ' mhc_testimonial_no_image' : '' ),
			esc_attr( $class ),
			( 'on' === $quote_icon ? sprintf(' <div class="mhc_testimonials_slide_icon%1$s"%2$s></div>',
			(  'off' !== $quote_icon && '' !== $quote_icon_symbol ? ' mhc_data_icon' : '' ),
			'off' !== $quote_icon && '' !== $quote_icon_symbol ? $data_icon : ''
			)
			 : '' )
		);

		return $output;

	}
}
new MHComposer_Component_Testimonials_Slider_Item;