<?php
class MHComposer_Component_Countdown_Timer extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Countdown Timer', 'mh-composer' );
		$this->slug = 'mhc_countdown_timer';

		$this->approved_fields = array(
			'title',
			'date_time',
			'background_layout',
			'use_background_color',
			'background_color',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'background_layout'    => array( 'dark' ),
			'use_background_color' => array( 'on' ),
			'background_color'     => array( mh_composer_accent_color(), 'append_default' ),
		);

		$this->main_css_selector = '%%order_class%%.mhc_countdown_timer';
		$this->custom_css_options = array(
			'countdown_container' => array(
				'label'    => esc_html__( 'Countdown Timer Container', 'mh-composer' ),
				'selector' => '.mhc_countdown_timer_container',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'countdown_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => '.title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'countdown_section' => array(
				'label'    => esc_html__( 'Timer Section', 'mh-composer' ),
				'selector' => '.section',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input a title for this counter.', 'mh-composer' ),
			),
			'date_time' => array(
				'label'           => esc_html__( 'Countdown To', 'mh-composer' ),
				'type'            => 'date_picker',
				'description'     => esc_html__( 'This is the date to which the countdown timer is counting down.', 'mh-composer' ),
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
			'use_background_color' => array(
				'label'           => esc_html__( 'Use Background Colour', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on' => esc_html__( 'Yes', 'mh-composer' ),
					'off'  => esc_html__( 'No', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_background_color',
				),
				'description' => esc_html__( 'Here you can choose whether background colour setting below should be used.', 'mh-composer' ),
			),
			'background_color' => array(
				'label'             => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_default'   => true,
				'description'       => esc_html__( 'Here you can define a custom background colour.', 'mh-composer' ),
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
		$title                = $this->shortcode_atts['title'];
		$date_time            = $this->shortcode_atts['date_time'];
		$background_layout    = $this->shortcode_atts['background_layout'];
		$background_color     = $this->shortcode_atts['background_color'];
		$use_background_color = $this->shortcode_atts['use_background_color'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$module_id = '' !== $module_id ? sprintf( ' id="%s"', esc_attr( $module_id ) ) : '';
		$module_class = '' !== $module_class ? sprintf( ' %s', esc_attr( $module_class ) ) : '';

		$background_layout = sprintf( ' mhc_bg_layout_%s', esc_attr( $background_layout ) );

		$end_date = gmdate( 'M d, Y H:i:s', strtotime( $date_time ) );
		$gmt_offset        = get_option( 'gmt_offset' );

		if ( '' !== $title ) {
			$title = sprintf( '<h4 class="title">%s</h4>', esc_html( $title ) );
		}

		$background_color_style = '';
		if ( ! empty( $background_color ) && 'on' == $use_background_color ) {
			$background_color_style = sprintf( ' style="background-color: %1$s;"', esc_attr( $background_color ) );
		}

		$output = sprintf(
			'<div%1$s class="mhc_module mhc_countdown_timer%2$s%3$s"%4$s data-end-date="%5$s" data-gmt-offset="%6$s">
				<div class="mhc_countdown_timer_container clearfix" dir="ltr">
				%7$s
				<div class="days section values">
					<p class="value"></p>
					<p class="label">%8$s</p>
				</div>
				<div class="sep section"><p>:</p></div>
				<div class="hours section values" data-short="%10$s">
					<p class="value"></p>
					<p class="label">%9$s</p>
				</div>
				<div class="sep section"><p>:</p></div>
				<div class="minutes section values" data-short="%12$s">
					<p class="value"></p>
					<p class="label">%11$s</p>
				</div>
				<div class="sep section"><p>:</p></div>
				<div class="seconds section values" data-short="%14$s">
					<p class="value"></p>
					<p class="label">%13$s</p>
				</div>
			</div>
		</div>',
			$module_id,
			$background_layout,
			$module_class,
			$background_color_style,
			esc_attr( $end_date ),
			esc_attr( $gmt_offset ),
			$title,
			esc_html__( 'Days', 'mh-composer' ),
			esc_html__( 'Hours', 'mh-composer' ),
			esc_attr__( 'Hrs', 'mh-composer' ),
			esc_html__( 'Minutes', 'mh-composer' ),
			esc_attr__( 'Min', 'mh-composer' ),
			esc_html__( 'Seconds', 'mh-composer' ),
			esc_attr__( 'Sec', 'mh-composer' )
		);

		return $output;
	}
}
new MHComposer_Component_Countdown_Timer;