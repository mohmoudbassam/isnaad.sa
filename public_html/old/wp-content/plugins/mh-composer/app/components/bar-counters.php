<?php
class MHComposer_Component_Bar_Counters extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Bar Counters', 'mh-composer' );
		$this->slug            = 'mhc_counters';
		$this->child_slug      = 'mhc_counter';
		$this->child_item_text = esc_html__( 'Add New Bar Counter', 'mh-composer' );

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'background_layout',
			'background_color',
			'bar_bg_color',
			'percent_sign',
			'bar_width',
			'custom_radius',
			'admin_label',
		);

		$this->fields_defaults = array(
			'background_layout' => array( 'light' ),
			'background_color'  => array( '#dddddd', 'append_default' ),
			'bar_bg_color'      => array( mh_composer_accent_color(), 'append_default' ),
			'percent_sign'  	  => array( 'on' ),
			'bar_width'   		 => array( 'default' ),
			'custom_radius'		=> array( 'on' ),
		);

		$this->main_css_selector = '%%order_class%%.mhc_counters';
		
		$this->custom_css_options = array(
			'counter_title' => array(
				'label'    => esc_html__( 'Counter Title', 'mh-composer' ),
				'selector' => '.mhc_counter_title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'counter_container' => array(
				'label'    => esc_html__( 'Counter Background', 'mh-composer' ),
				'selector' => '.mhc_counter_container',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'counter_amount' => array(
				'label'    => esc_html__( 'Counter Amount', 'mh-composer' ),
				'selector' => '.mhc_counter_amount',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'background_layout' => array(
				'label'           => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'light' => esc_html__( 'Dark', 'mh-composer' ),
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			'background_color' => array(
				'label'             => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'This will adjust the colour of the empty space in the bar (default grey).', 'mh-composer' ),
			),
			'bar_bg_color' => array(
				'label'             => esc_html__( 'Bar Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'This will change the fill colour for the bar.', 'mh-composer' ),
			),
			'percent_sign' => array(
				'label'             => esc_html__( 'Percent Sign', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'On', 'mh-composer' ),
					'off' => esc_html__( 'Off', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can choose whether the percent sign should be added after the number set above.', 'mh-composer' ),
			),
			'bar_width' => array(
				'label'           => esc_html__( 'Bar Thickness', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'default'  => esc_html__( 'Default', 'mh-composer' ),
					'thin'	 => esc_html__( 'Thin', 'mh-composer' ),
					'thick'	=> esc_html__( 'Thick', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This will change the bar thickness.', 'mh-composer' ),
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

	function pre_shortcode_content() {
		global $mhc_counters_settings;

		$background_color   = $this->shortcode_atts['background_color'];
		$bar_bg_color       = $this->shortcode_atts['bar_bg_color'];
		$percent_sign	   = $this->shortcode_atts['percent_sign'];
		$bar_width          = $this->shortcode_atts['bar_width'];
		$custom_radius	  = $this->shortcode_atts['custom_radius'];

		$mhc_counters_settings = array(
			'background_color'   => $background_color,
			'bar_bg_color'       => $bar_bg_color,
			'percent_sign'       => $percent_sign,
			'bar_width'          => $bar_width,
			'custom_radius'	  => $custom_radius,
		);
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id          = $this->shortcode_atts['module_id'];
		$module_class       = $this->shortcode_atts['module_class'];
		$background_layout  = $this->shortcode_atts['background_layout'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$class = " mhc_module mhc_bg_layout_{$background_layout}";

		$output = sprintf(
			'<ul%3$s class="mhc_counters mh-waypoint%2$s%4$s">
				%1$s
			</ul> <!-- .mhc_counters -->',
			$this->shortcode_content,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Bar_Counters;

class MHComposer_Component_Bar_Counters_Item extends MHComposer_Component {
	function init() {
		$this->name                        = esc_html__( 'Bar Counter', 'mh-composer' );
		$this->slug                        = 'mhc_counter';
		$this->type                        = 'child';
		$this->child_title_var             = 'content_new';

		$this->approved_fields = array(
			'content_new',
			'percent',
		);

		$this->fields_defaults = array(
			'percent' => array( '1' ),
		);

		$this->advanced_setting_title_text = esc_html__( 'New Bar Counter', 'mh-composer' );
		$this->settings_text               = esc_html__( 'Bar Counter Settings', 'mh-composer' );
	}

	function get_fields() {
		$fields = array(
			'content_new' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input a title for this counter.', 'mh-composer' ),
			),
			'percent' => array(
				'label'           => esc_html__( 'Percent', 'mh-composer' ),
				'type'            => 'range',
				'default' => '90',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'description'     => esc_html__( 'Define a percentage for this bar. Numeric value only.', 'mh-composer' ),
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $mhc_counters_settings;
		
		$percent              = $this->shortcode_atts['percent'];
		$module_class = MHComposer_Core::add_module_order_class( '', $function_name );

		// Add % only if it hasn't been added to the attribute
		if ( '%' !== substr( trim( $percent ), -1 ) ) {
			$percent .= '%';
		}

		$background_color_style = $bar_bg_color_style = '';

		if (isset( $mhc_counters_settings['background_color'] ) && '' !== $mhc_counters_settings['background_color'] ) {
			$background_color_style = sprintf( ' style="background-color: %1$s;"', esc_attr( $mhc_counters_settings['background_color'] ) );
		}

		if (isset( $mhc_counters_settings['bar_bg_color'] ) && '' !== $mhc_counters_settings['bar_bg_color'] ) {
			$bar_bg_color_style = sprintf( ' background-color: %1$s;', esc_attr( $mhc_counters_settings['bar_bg_color'] ) );
		}

		if (isset( $mhc_counters_settings['bar_width'] ) && 'default' !== $mhc_counters_settings['bar_width'] ) {
			MHComposer_Core::set_style( $function_name, array(
						'selector'    => '%%order_class%% .mhc_counter_amount',
						'declaration' => sprintf(
							'line-height: %1$s;',
							('thin' === $mhc_counters_settings['bar_width'] ? '1em' : '2.7em')
						),
					) );
		}

		$output = sprintf(
			'<li class="%6$s">
				<span class="mhc_counter_title">%1$s</span>
				<span class="mhc_counter_container%7$s"%4$s>
					<span class="mhc_counter_amount%7$s" style="width: %3$s; %5$s" data-width="%3$s"><span class="mhc_counter_amount_number">%2$s</span></span>
				</span>
			</li>',
			sanitize_text_field( $content ),
			( isset( $mhc_counters_settings['percent_sign'] ) && 'on' === $mhc_counters_settings['percent_sign'] ? esc_html( $percent ) : str_replace('%', '', $percent) ),
			esc_attr( $percent ),
			$background_color_style,
			$bar_bg_color_style,
			esc_attr( ltrim( $module_class ) ),
			( isset( $mhc_counters_settings['custom_radius'] ) && 'on' === $mhc_counters_settings['custom_radius'] ? ' mh_adjust_corners' : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Bar_Counters_Item;