<?php
class MHComposer_Row extends MHComposer_Structure_Element {
	function init() {
		$this->name = esc_html__( 'Row', 'mh-composer' );
		$this->slug = 'mhc_row';

		$this->approved_fields = array(
			'background_image',
			'background_color',
			'gradient_background',
			'gradient_style',
			'background_color_second',
			'remove_padding',
			'top_padding',
			'bottom_padding',
			'module_id',
			'module_class',
			'admin_label',
		);
		
		$this->fields_defaults = array(
			'gradient_background' 	=> array( 'off' ),
			'gradient_style' 		 => array( 'horizontal' ),
			'remove_padding' 		 => array( 'off' ),
		
		);
	}

	function get_fields() {
		$fields = array(
			'background_image' => array(
				'label'              => esc_html__( 'Background Image', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Background Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Background', 'mh-composer' ),
				'description'        => esc_html__( 'If defined, this image will be used as a background. To remove a background image, simply delete the URL from the settings field.', 'mh-composer' ),
			),
			'gradient_background' => array(
				'label'             => esc_html__( 'Gradient Background', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_gradient_style',
					'#mhc_background_color_second',
				),
				'description'       => esc_html__( 'Switch on this option if you want a gradient background colour for this row.', 'mh-composer' ),
			),
			'background_color' => array(
				'label'           => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'Define a custom background colour for your component, or leave blank to use the default colour.', 'mh-composer' ),
			),
			'background_color_second' => array(
				'label'           => esc_html__( 'Gradient Colour', 'mh-composer' ),
				'type'            => 'color-alpha',
				'depends_show_if' => 'on',
				'description'     => esc_html__( 'Define a custom gradient colour for your row.', 'mh-composer' ),
			),
			'gradient_style' => array(
				'label'             => esc_html__( 'Gradient Style', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'horizontal' 		=> esc_html__( 'Horizontal', 'mh-composer' ),
					'vertical'  		  => esc_html__( 'Vertical', 'mh-composer' ),
					'diagonal_top'	  => esc_html__( 'Diagonal Top', 'mh-composer' ),
					'diagonal_bottom'   => esc_html__( 'Diagonal Bottom', 'mh-composer' ),
					'radial'			=> esc_html__( 'Radial', 'mh-composer' ),
				),
				'depends_show_if' => 'on',
				'description'       => esc_html__( 'This controls the style of the gradient colour.', 'mh-composer' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Label', 'mh-composer' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the row in the composer for easy identification when collapsed.', 'mh-composer' ),
			),
			'module_id' => array(
				'label'             => esc_html__( '{CSS ID}', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
			),
			'module_class' => array(
				'label'             => esc_html__( '{CSS Class}', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
			),
			'remove_padding' => array(
				'label'           => esc_html__( 'Remove Paddings', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_top_padding',
					'#mhc_bottom_padding',
				),
				'tab_slug'        => 'advanced',
				'description'       => esc_html__( 'This option will remove all top and bottom paddings for this row.', 'mh-composer' ),
			),
			'top_padding' => array(
				'label'           => esc_html__( 'Top Padding (px)', 'mh-composer' ),
				'type'            => 'range',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
				),
				'depends_show_if'   => 'on',
				'tab_slug'        => 'advanced',
			),
			'bottom_padding' => array(
				'label'           => esc_html__( 'Bottom Padding (px)', 'mh-composer' ),
				'type'            => 'range',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
				),
				'depends_show_if'   => 'on',
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
		$module_id               = $this->shortcode_atts['module_id'];
		$module_class            = $this->shortcode_atts['module_class'];
		$shared_module           = $this->shortcode_atts['shared_module'];
		$background_image        = $this->shortcode_atts['background_image'];
		$background_color        = $this->shortcode_atts['background_color'];
		$gradient_background     = $this->shortcode_atts['gradient_background'];
		$background_color_second = $this->shortcode_atts['background_color_second'];
		$gradient_style      	  = $this->shortcode_atts['gradient_style'];
		$remove_padding	  	  = $this->shortcode_atts['remove_padding'];
		$top_padding             = $this->shortcode_atts['top_padding'];
		$bottom_padding          = $this->shortcode_atts['bottom_padding'];


		if ( '' !== $shared_module ) {
			$shared_content = mhc_load_shared_module( $shared_module, $function_name );

			if ( '' !== $shared_content ) {
				return do_shortcode( $shared_content );
			}
		}

		$module_class .= ' mhc_row';

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$inner_content = do_shortcode( mhc_fix_shortcodes( $content ) );
		$module_class .= '' == trim( $inner_content ) ? ' mhc_row_empty' : '';
		
		if ('off' !== $remove_padding){
			MHComposer_Core::set_style( $function_name, array(
			'selector'    => '%%order_class%%',
			'declaration' => sprintf('padding-top:%1$s !important; padding-bottom:%2$s !important;',
			'' !== $top_padding ? esc_html( mh_composer_process_range_value( $top_padding )) : '0',
			'' !== $bottom_padding ? esc_html( mh_composer_process_range_value( $bottom_padding )) : '0'
			)
			) );
		}
		//background image
		if ( '' !== $background_image ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'background-image:url(%s);',
					esc_url( $background_image )
				),
			) );
		}
		//background colour
		if ( '' !== $background_color && 'off' === $gradient_background ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'background-color:%s;',
					esc_html( $background_color )
				),
			) );
		//gradient colour
		}elseif ( 'off' !== $gradient_background  && '' !== $background_color && '' !== $background_color_second) {
			$color1 = esc_html( $background_color );
			$color2 = esc_html( $background_color_second );
			if ('horizontal' === $gradient_style){	
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-linear-gradient(left, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left top, right top, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(left, $color1 0%,$color2 100%); background: -o-linear-gradient(left, $color1 0%,$color2 100%); background: -ms-linear-gradient(left, $color1 0%,$color2 100%); background: linear-gradient(to right, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
				) );
			}
				 
			if ('vertical' === $gradient_style){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-linear-gradient(top, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(top, $color1 0%,$color2 100%); background: -o-linear-gradient(top, $color1 0%,$color2 100%); background: -ms-linear-gradient(top, $color1 0%,$color2 100%); background: linear-gradient(to bottom, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=0 );",
				) );
			}
	
			if ('diagonal_top' === $gradient_style){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-linear-gradient(-45deg, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(-45deg, $color1 0%,$color2 100%); background: -o-linear-gradient(-45deg, $color1 0%,$color2 100%); background: -ms-linear-gradient(-45deg, $color1 0%,$color2 100%); background: linear-gradient(135deg, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
				) );
			}
				
			if ('diagonal_bottom' === $gradient_style){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-linear-gradient(45deg, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(45deg, $color1 0%,$color2 100%); background: -o-linear-gradient(45deg, $color1 0%,$color2 100%); background: -ms-linear-gradient(45deg, $color1 0%,$color2 100%); background: linear-gradient(45deg, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
			) );
			}
			
			if ('radial' === $gradient_style){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-radial-gradient(center, ellipse cover, $color1 0%, $color2 100%); background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-radial-gradient(center, ellipse cover, $color1 0%,$color2 100%); background: -o-radial-gradient(center, ellipse cover, $color1 0%,$color2 100%); background: -ms-radial-gradient(center, ellipse cover, $color1 0%,$color2 100%); background: radial-gradient(ellipse at center, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
				) );
			}
		} //gradient
		
		$output = sprintf(
			'<div%4$s class="%2$s">
				%1$s
			</div> <!-- .%3$s -->',
			$inner_content,
			esc_attr( $module_class ),
			esc_html( $function_name ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Row;

class MHComposer_Row_Inner extends MHComposer_Structure_Element {
	function init() {
		$this->name = esc_html__( 'Row', 'mh-composer' );
		$this->slug = 'mhc_row_inner';

		$this->approved_fields = array(
			'background_image',
			'background_color',
			'gradient_background',
			'gradient_style',
			'background_color_second',
			'remove_padding',
			'top_padding',
			'bottom_padding',
			'module_id',
			'module_class',
			'admin_label',
		);
		
		$this->fields_defaults = array(
			'gradient_background' 	=> array( 'off' ),
			'gradient_style' 		 => array( 'horizontal' ),
			'remove_padding' 		 => array( 'off' ),
		
		);
	}

	function get_fields() {
		$fields = array(
			'background_image' => array(
				'label'              => esc_html__( 'Background Image', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Background Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Background', 'mh-composer' ),
				'description'        => esc_html__( 'If defined, this image will be used as a background. To remove a background image, simply delete the URL from the settings field.', 'mh-composer' ),
			),
			'gradient_background' => array(
				'label'             => esc_html__( 'Gradient Background', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_gradient_style',
					'#mhc_background_color_second',
				),
				'description'       => esc_html__( 'Switch on this option if you want a gradient background colour for this row.', 'mh-composer' ),
			),
			'background_color' => array(
				'label'           => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'Define a custom background colour for your component, or leave blank to use the default colour.', 'mh-composer' ),
			),
			'background_color_second' => array(
				'label'           => esc_html__( 'Gradient Colour', 'mh-composer' ),
				'type'            => 'color-alpha',
				'depends_show_if' => 'on',
				'description'     => esc_html__( 'Define a custom gradient colour for your row.', 'mh-composer' ),
			),
			'gradient_style' => array(
				'label'             => esc_html__( 'Gradient Style', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'horizontal'		=> esc_html__( 'Horizontal', 'mh-composer' ),
					'vertical'		  => esc_html__( 'Vertical', 'mh-composer' ),
					'diagonal_top'	  => esc_html__( 'Diagonal Top', 'mh-composer' ),
					'diagonal_bottom'   => esc_html__( 'Diagonal Bottom', 'mh-composer' ),
					'radial'			=> esc_html__( 'Radial', 'mh-composer' ),
				),
				'depends_show_if' => 'on',
				'description'       => esc_html__( 'This controls the style of the gradient colour.', 'mh-composer' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Label', 'mh-composer' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the row in the composer for easy identification when collapsed.', 'mh-composer' ),
			),
			'module_id' => array(
				'label'             => esc_html__( '{CSS ID}', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
			),
			'module_class' => array(
				'label'             => esc_html__( '{CSS Class}', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
			),
			'remove_padding' => array(
				'label'           => esc_html__( 'Remove Paddings', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_top_padding',
					'#mhc_bottom_padding',
				),
				'tab_slug'        => 'advanced',
				'description'       => esc_html__( 'This option will remove all top and bottom paddings for this row.', 'mh-composer' ),
			),
			'top_padding' => array(
				'label'           => esc_html__( 'Top Padding (px)', 'mh-composer' ),
				'type'            => 'range',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
				),
				'depends_show_if'   => 'on',
				'tab_slug'        => 'advanced',
			),
			'bottom_padding' => array(
				'label'           => esc_html__( 'Bottom Padding (px)', 'mh-composer' ),
				'type'            => 'range',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
				),
				'depends_show_if'   => 'on',
				'tab_slug'        => 'advanced',
			),
		);

		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id               = $this->shortcode_atts['module_id'];
		$module_class            = $this->shortcode_atts['module_class'];
		$shared_module           = $this->shortcode_atts['shared_module'];
		$background_image        = $this->shortcode_atts['background_image'];
		$background_color        = $this->shortcode_atts['background_color'];
		$gradient_background     = $this->shortcode_atts['gradient_background'];
		$background_color_second = $this->shortcode_atts['background_color_second'];
		$gradient_style      	  = $this->shortcode_atts['gradient_style'];
		$remove_padding	  	  = $this->shortcode_atts['remove_padding'];
		$top_padding             = $this->shortcode_atts['top_padding'];
		$bottom_padding          = $this->shortcode_atts['bottom_padding'];

		if ( '' !== $shared_module ) {
			$shared_content = mhc_load_shared_module( $shared_module, $function_name );

			if ( '' !== $shared_content ) {
				return do_shortcode( $shared_content );
			}
		}

		$module_class .= ' mhc_row_inner';

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$inner_content = do_shortcode( mhc_fix_shortcodes( $content ) );
		$module_class .= '' == trim( $inner_content ) ? ' mhc_row_empty' : '';
		
		if ('off' !== $remove_padding){
			MHComposer_Core::set_style( $function_name, array(
			'selector'    => '%%order_class%%',
			'declaration' => sprintf('padding-top:%1$s !important; padding-bottom:%2$s !important;',
			'' !== $top_padding ? esc_html( mh_composer_process_range_value( $top_padding )) : '0',
			'' !== $bottom_padding ? esc_html( mh_composer_process_range_value( $bottom_padding )) : '0'
			)
			) );
		}
		//background image
		if ( '' !== $background_image ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'background-image:url(%s);',
					esc_url( $background_image )
				),
			) );
		}
		//background colour
		if ( '' !== $background_color && 'off' === $gradient_background ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'background-color:%s;',
					esc_html( $background_color )
				),
			) );
		//gradient colour
		}elseif ( 'off' !== $gradient_background  && '' !== $background_color && '' !== $background_color_second) {
			$color1 = esc_html( $background_color );
			$color2 = esc_html( $background_color_second );
			if ('horizontal' === $gradient_style){	
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-linear-gradient(left, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left top, right top, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(left, $color1 0%,$color2 100%); background: -o-linear-gradient(left, $color1 0%,$color2 100%); background: -ms-linear-gradient(left, $color1 0%,$color2 100%); background: linear-gradient(to right, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
				) );
			}
				 
			if ('vertical' === $gradient_style){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-linear-gradient(top, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(top, $color1 0%,$color2 100%); background: -o-linear-gradient(top, $color1 0%,$color2 100%); background: -ms-linear-gradient(top, $color1 0%,$color2 100%); background: linear-gradient(to bottom, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=0 );",
				) );
			}
	
			if ('diagonal_top' === $gradient_style){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-linear-gradient(-45deg, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(-45deg, $color1 0%,$color2 100%); background: -o-linear-gradient(-45deg, $color1 0%,$color2 100%); background: -ms-linear-gradient(-45deg, $color1 0%,$color2 100%); background: linear-gradient(135deg, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
				) );
			}
				
			if ('diagonal_bottom' === $gradient_style){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-linear-gradient(45deg, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(45deg, $color1 0%,$color2 100%); background: -o-linear-gradient(45deg, $color1 0%,$color2 100%); background: -ms-linear-gradient(45deg, $color1 0%,$color2 100%); background: linear-gradient(45deg, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
			) );
			}
			
			if ('radial' === $gradient_style){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-radial-gradient(center, ellipse cover, $color1 0%, $color2 100%); background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-radial-gradient(center, ellipse cover, $color1 0%,$color2 100%); background: -o-radial-gradient(center, ellipse cover, $color1 0%,$color2 100%); background: -ms-radial-gradient(center, ellipse cover, $color1 0%,$color2 100%); background: radial-gradient(ellipse at center, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
				) );
			}
		} //gradient

		$output = sprintf(
			'<div%4$s class="%2$s">
				%1$s
			</div> <!-- .%3$s -->',
			$inner_content,
			esc_attr( $module_class ),
			esc_html( $function_name ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Row_Inner;