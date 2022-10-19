<?php
class MHComposer_Component_Divider extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Divider', 'mh-composer' );
		$this->slug = 'mhc_divider';
		$this->main_css_selector = '%%order_class%%';

		$this->approved_fields = array(
			'color',
			'show_divider',
			'height',
			'admin_label',
			'module_id',
			'module_class',
			'divider_style',
			'borderw',
			'keep_visible',
			'custom_orientation',
			'custom_width',
			'custom_radius',
		);

		$this->fields_defaults = array(
			'color'          		=> array( mh_composer_accent_color(), 'append_default' ),
			'show_divider'   		 => array( 'off' ),
			'keep_visible' 	     => array( 'off' ),
			'borderw'			  => array( '1', 'append_default' ),
			'divider_style'    	=> array( 'solid' ),
			'custom_orientation'   => array( 'right' ),
			'custom_radius'		=> array( 'on' ),
		);
	}

	function get_fields() {
		$fields = array(
			'show_divider' => array(
				'label'             => esc_html__( 'Show Divider', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects' => array(
					'#mhc_color',
					'#mhc_divider_style',
					'#mhc_borderw',
					'#mhc_custom_width',
					'#mhc_custom_orientation',
				),
				'description'        => esc_html__( 'This settings turns on and off the divider line.', 'mh-composer' ),
			),
			'color' => array(
				'label'       => esc_html__( 'Colour', 'mh-composer' ),
				'type'        => 'color-alpha',
				'description' => esc_html__( 'This will adjust the colour of 1px divider line.', 'mh-composer' ),
				'default' => '#cccccc'
			),
			'borderw' => array(
				'label'             => esc_html__( 'Divider Thickness', 'mh-composer' ),
				'type'              => 'range',
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'This will change the divider thickness.', 'mh-composer' ),
				'default' => '5'
			),
			'custom_width' => array(
				'label'           => esc_html__( 'Width', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define the divider width (in pixels - numeric value only). Leave empty to set it to full width.', 'mh-composer' ),
				'depends_show_if'   => 'on',
			),
			'custom_orientation' => array(
				'label'           => esc_html__( 'Divider Alignment', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options_no_just(),
				'depends_show_if'   => 'on',
				'description'     => esc_html__( 'In case you choose a width for your divider, define the alignment here.', 'mh-composer' ),
			),
			'height' => array(
				'label'           => esc_html__( 'Height', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define how much space should be added below the divider (in pixels - numeric value only).', 'mh-composer' ),
			),
			'divider_style' => array(
				'label'             => esc_html__( 'Divider Style', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_border_styles(),
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'This will change the divider style.', 'mh-composer' ),
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
			'keep_visible' => array(
				'label'             => esc_html__( 'Show On Mobile', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'tab_slug'          => 'advanced',
			),
			'custom_radius' => array(
				'label'             => esc_html__( 'Corners Radius', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'tab_slug'          => 'advanced',
				'description'     => esc_html__( 'By default, the divider corners adjust according to your choice in Theme Customizer. You could disable it here.', 'mh-composer' ),
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
		$module_id           = $this->shortcode_atts['module_id'];
		$module_class     	= $this->shortcode_atts['module_class'];
		$color               = $this->shortcode_atts['color'];
		$show_divider     	= $this->shortcode_atts['show_divider'];
		$height           	  = $this->shortcode_atts['height'];
		$divider_style       = $this->shortcode_atts['divider_style'];
		$borderw   		  	 = $this->shortcode_atts['borderw'];
		$custom_orientation  = $this->shortcode_atts['custom_orientation'];
		$custom_width   	 	= $this->shortcode_atts['custom_width'];
		$keep_visible   	    = $this->shortcode_atts['keep_visible'];
		$custom_radius	   = $this->shortcode_atts['custom_radius'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$style = '';

		if ( '' !== $color && 'on' === $show_divider ) {
			$style .= sprintf( ' border-color: %s;',
				esc_attr( $color )
			);

			$style .= sprintf( ' border-style: %s;',
				( 'solid' !== $divider_style ? esc_attr( $divider_style ) : 'solid')
			);

			if ( '' !== $borderw ) {
				$style .= sprintf( ' border-width: %1$spx;',
					( '' !== $borderw ? esc_attr( $borderw ) : '1' )
				);
			}
			if ( '' !== $custom_width){
				$style .= sprintf( 'width:%1$spx;',
					esc_attr( $custom_width )
				);
			}
			if ( 'right' !== $custom_orientation ) {
				$style .= sprintf( '%1$s%2$s%3$s',				
					( 'right' === $custom_orientation ? ' margin-left:auto; margin-right:0;' : '' ),
					( 'center' === $custom_orientation ? ' margin-left:auto; margin-right:auto;' : '' ),
					( 'left' === $custom_orientation ? ' margin-left:0; margin-right:auto;' : '' )
				);
			}

			if ( '' !== $style ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => ltrim( $style )
				) );
			}
		}

		if ( '' !== $height ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'margin-bottom: %s;',
					esc_attr( mh_composer_process_range_value( $height ) )
				),
			) );
		}

		if ( 'off' === $keep_visible ) {
			$module_class .= ' mh_hide_on_small';
		}

		$output = sprintf(
			'<div%2$s class="mhc_module mhc_space%1$s%3$s%4$s"></div>',
			( 'on' === $show_divider ? ' mhc_divider' : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			( 'off' !== $custom_radius ? ' mh_adjust_corners' : '')
		);

		return $output;
	}
}
new MHComposer_Component_Divider;