<?php
class MHComposer_Component_Circle_Counter extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Circle Counter', 'mh-composer' );
		$this->slug = 'mhc_circle_counter';

		$this->approved_fields = array(
			'title',
			'number',
			'percent_sign',
			'background_layout',
			'bar_bg_color',
			'bar_width',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'number'            => array( '1' ),
			'percent_sign'      => array( 'on' ),
			'background_layout' => array( 'light' ),
			'bar_bg_color'      => array( mh_composer_accent_color(), 'append_default' ),
			'bar_width' => array( '6' ),
		);

		$this->main_css_selector = '%%order_class%%.mhc_circle_counter';
		$this->custom_css_options = array(
			'counter_title' => array(
				'label'    => esc_html__( 'Counter Title', 'mh-composer' ),
				'selector' => 'h3',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'counter_number' => array(
				'label'    => esc_html__( 'Number', 'mh-composer' ),
				'selector' => '.percent p',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description' => esc_html__( 'Input a title for this counter.', 'mh-composer' ),
			),
			'number' => array(
				'label'             => esc_html__( 'Number', 'mh-composer' ),
				'type'            => 'range',
				'default' => '90',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'description'       => esc_html__( "Define a percentage for this bar. Numeric value only.", 'mh-composer' ),
			),
			'percent_sign' => array(
				'label'           => esc_html__( 'Percent Sign', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'On', 'mh-composer' ),
					'off' => esc_html__( 'Off', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can choose whether the percent sign should be added after the number set above.', 'mh-composer' ),
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
			'bar_bg_color' => array(
				'label'             => esc_html__( 'Bar Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'This will change the fill colour for the bar.', 'mh-composer' ),
			),
			'bar_width' => array(
				'label'           => esc_html__( 'Bar Width', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'6'   => esc_html__( 'Thin', 'mh-composer' ),
					'12' => esc_html__( 'Medium', 'mh-composer' ),
					'22' => esc_html__( 'Thick', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This will change the bar width.', 'mh-composer' ),
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
		wp_enqueue_script( 'easypiechart' );
		$number                      = $this->shortcode_atts['number'];
		$percent_sign                = $this->shortcode_atts['percent_sign'];
		$title                       = $this->shortcode_atts['title'];
		$module_id                   = $this->shortcode_atts['module_id'];
		$module_class                = $this->shortcode_atts['module_class'];
		$background_layout           = $this->shortcode_atts['background_layout'];
		$bar_bg_color                = $this->shortcode_atts['bar_bg_color'];
		$bar_width				   = $this->shortcode_atts['bar_width'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$number = str_ireplace( '%', '', $number );

		$class = " mhc_module mhc_bg_layout_{$background_layout}";

		$output = sprintf(
			'<div%1$s class="mhc_circle_counter container-width-change-notify%2$s%3$s" data-number-value="%4$s" data-bar-bg-color="%5$s" data-bar-width="%8$s">
					<div class="percent"><p><span class="percent-value"></span>%6$s</p></div>
					%7$s
			</div><!-- .mhc_circle_counter -->',
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			esc_attr( $class ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			esc_attr( $number ),
			esc_attr( $bar_bg_color ),
			( 'on' == $percent_sign ? '%' : ''),
			( '' !== $title ? '<h3>' . esc_html( $title ) . '</h3>' : '' ),
			$bar_width
		);

		return $output;
	}
}
new MHComposer_Component_Circle_Counter;