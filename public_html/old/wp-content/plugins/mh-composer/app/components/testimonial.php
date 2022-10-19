<?php
class MHComposer_Component_Testimonial extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Testimonial', 'mh-composer' );
		$this->slug = 'mhc_testimonial';
		$this->main_css_selector = '%%order_class%%.mhc_testimonial';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'author',
			'job_title',
			'portrait_url',
			'company_name',
			'url',
			'quote_icon',
			'url_new_window',
			'use_background_color',
			'background_color',
			'background_layout',
			'text_orientation',
			'quote_icon_color',
			'portrait_radius',
			'portrait_width',
			'portrait_height',
			'quote_icon_symbol',
			'content_new',
		);

		$this->fields_defaults = array(
			'url_new_window'       => array( 'off' ),
			'quote_icon'           => array( 'off' ),
			'use_background_color' => array( 'on' ),
			'background_color'     => array( '#f5f5f5', 'append_default' ),
			'background_layout'    => array( 'dark' ),
			'text_orientation'     => array( 'right' ),
		);

		$this->custom_css_options = array(
			'testimonial_portrait' => array(
				'label'    => esc_html__( 'Testimonial Portrait', 'mh-composer' ),
				'selector' => '.mhc_testimonial_portrait',
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
			'use_background_color' => array(
				'label'           => esc_html__( 'Use Background Colour', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_background_color',
				),
				'description'     => esc_html__( 'Here you can choose whether background colour setting below should be used.', 'mh-composer' ),
			),
			'background_color' => array(
				'label'             => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can choose whether background colour setting below should be used.', 'mh-composer' ),
				'depends_default'   => true,
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
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options(),
				'description'       => esc_html__( 'This will adjust the alignment of the text.', 'mh-composer' ),
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'mh-composer' ),
				'type'            => 'tiny_mce',
				'description'     => esc_html__( 'Input the main text content for your component here.', 'mh-composer' ),
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
				'tab_slug'          => 'advanced',
			),
			'module_class' => array(
				'label'           => esc_html__( '{CSS Class}', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
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
				'tab_slug'        => 'advanced',
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
		$module_id              = $this->shortcode_atts['module_id'];
		$module_class           = $this->shortcode_atts['module_class'];
		$author                 = $this->shortcode_atts['author'];
		$job_title              = $this->shortcode_atts['job_title'];
		$portrait_url           = $this->shortcode_atts['portrait_url'];
		$company_name           = $this->shortcode_atts['company_name'];
		$url                    = $this->shortcode_atts['url'];
		$quote_icon             = $this->shortcode_atts['quote_icon'];
		$url_new_window         = $this->shortcode_atts['url_new_window'];
		$use_background_color   = $this->shortcode_atts['use_background_color'];
		$background_color       = $this->shortcode_atts['background_color'];
		$background_layout      = $this->shortcode_atts['background_layout'];
		$text_orientation       = $this->shortcode_atts['text_orientation'];
		$quote_icon_color       = $this->shortcode_atts['quote_icon_color'];
		$portrait_radius 		= $this->shortcode_atts['portrait_radius'];
		$portrait_width         = $this->shortcode_atts['portrait_width'];
		$portrait_height        = $this->shortcode_atts['portrait_height'];
		$quote_icon_symbol	  = $this->shortcode_atts['quote_icon_symbol'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		if ( '' !== $portrait_radius ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_testimonial_portrait',
				'declaration' => sprintf(
					'-webkit-border-radius: %1$s; -moz-border-radius: %1$s; border-radius: %1$s;',
					esc_html( mh_composer_process_range_value( $portrait_radius ) )
				),
			) );
		}

		if ( '' !== $portrait_width ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_testimonial_portrait',
				'declaration' => sprintf(
					'width: %1$s;',
					esc_html( mh_composer_process_range_value( $portrait_width ) )
				),
			) );
		}

		if ( '' !== $portrait_height ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_testimonial_portrait',
				'declaration' => sprintf(
					'height: %1$s;',
					esc_html( mh_composer_process_range_value( $portrait_height ) )
				),
			) );
		}

		$style = '';

		if ( 'on' === $use_background_color && $this->fields_defaults['background_color'][0] !== $background_color ) {
			$style .= sprintf(
				'background-color: %1$s !important; ',
				esc_html( $background_color )
			);
		}

		if ( '' !== $style ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_testimonial',
				'declaration' => rtrim( $style ),
			) );
		}

		if ( '' !== $quote_icon_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_testimonial:before',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $quote_icon_color )
				),
			) );
		}


		$portrait_image = '';

		$class = " mhc_module mhc_bg_layout_{$background_layout} mhc_text_align_{$text_orientation}";

		if ( ! isset( $atts['quote_icon'] ) ) {
			$class .= "	mhc_testimonial_old_layout";
		}

		if ( '' !== $portrait_url ) {
			$portrait_image = sprintf(
				'<div class="mhc_testimonial_portrait" style="background-image: url(%1$s);">
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
		$sep = mh_wp_kses( _x( ', ', 'This is a comma followed by a space.', 'mh-composer') );
		$output = sprintf(
			'<div%3$s class="mhc_testimonial%4$s%5$s%9$s%10$s%12$s%13$s clearfix"%11$s%14$s>
				%8$s
				<div class="mhc_testimonial_description">
					<div class="mhc_testimonial_description_inner">
					%1$s
					<strong class="mhc_testimonial_author">%2$s</strong>
					<p class="mhc_testimonial_meta">%6$s%7$s</p>
					</div> <!-- .mhc_testimonial_description_inner -->
				</div> <!-- .mhc_testimonial_description -->
			</div> <!-- .mhc_testimonial -->',
			$this->shortcode_content,
			$author,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			( 'off' === $quote_icon ? ' mhc_icon_off' : '' ),
			( '' !== $job_title ? esc_html( $job_title ) : '' ),
			( '' !== $company_name ? sprintf( '%2$s%1$s', $company_name, ( '' !== $job_title ? $sep : '' )) : '' ),
			( '' !== $portrait_image ? $portrait_image : '' ),
			( '' === $portrait_image ? ' mhc_testimonial_no_image' : '' ),
			esc_attr( $class ),
			( 'on' === $use_background_color
				? sprintf( ' style="background-color: %1$s;"', esc_attr( $background_color ) )
				: ''
			),
			( 'off' === $use_background_color ? ' mhc_testimonial_no_bg' : '' ),
			(  'off' !== $quote_icon && '' !== $quote_icon_symbol ? ' mhc_data_icon' : '' ),
			'off' !== $quote_icon && '' !== $quote_icon_symbol ? $data_icon : ''
		);

		return $output;
	}
}
new MHComposer_Component_Testimonial;