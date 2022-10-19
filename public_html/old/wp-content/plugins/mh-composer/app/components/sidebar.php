<?php
class MHComposer_Component_Sidebar extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Sidebar', 'mh-composer' );
		$this->slug = 'mhc_sidebar';
		$this->main_css_selector = '%%order_class%%.mhc_widget_area';

		$this->approved_fields = array(
			'orientation',
			'area',
			'background_layout',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'orientation'       => array( 'left' ),
			'background_layout' => array( 'light' ),
		);
	
		$this->custom_css_options = array(
			'sidebar_widget' => array(
				'label'    => esc_html__( 'Widget', 'mh-composer' ),
				'selector' => '.mhc_widget',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'sidebar_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => 'h4.widgettitle',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'orientation' => array(
				'label'             => esc_html__( 'Orientation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'left'  => esc_html__( 'Left', 'mh-composer' ),
					'right' => esc_html__( 'Right', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Choose on which side of the page your sidebar will be placed. This setting controls text orientation and border position.', 'mh-composer' ),
			),
			'area' => array(
				'label'           => esc_html__( 'Widget Area', 'mh-composer' ),
				'renderer'        => 'mh_composer_get_widget_areas',
				'description'     => esc_html__( 'Select a widget area that you would like to display. You can create new widget areas within the Appearances > Widgets tab.', 'mh-composer' )
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
			'admin_label' => array(
				'label'       => esc_html__( 'Label', 'mh-composer' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the component in the composer for easy identification.', 'mh-composer' ),
			),
			'module_id' => array(
				'label'           => esc_html__( '{CSS ID}', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-composer' ),
				'tab_slug' => 'advanced',
			),
			'module_class' => array(
				'label'           => esc_html__( '{CSS Class}', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-composer' ),
				'tab_slug' => 'advanced',
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
		$module_id        = $this->shortcode_atts['module_id'];
		$module_class     = $this->shortcode_atts['module_class'];
		$orientation      = $this->shortcode_atts['orientation'];
		$area             = "" === $this->shortcode_atts['area'] ? $this->get_default_area() : $this->shortcode_atts['area'];
		$background_layout = $this->shortcode_atts['background_layout'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$widgets = '';

		ob_start();


		if ( is_active_sidebar( $area ) )
			dynamic_sidebar( $area );

		$widgets = ob_get_contents();

		ob_end_clean();

		$class = " mhc_module mhc_bg_layout_{$background_layout}";

		$output = sprintf(
			'<div%4$s class="mhc_widget_area %2$s clearfix%3$s%5$s">
				%1$s
			</div> <!-- .mhc_widget_area -->',
			$widgets,
			esc_attr( "mhc_widget_area_{$orientation}" ),
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}

	function get_default_area() {
		global $wp_registered_sidebars;

		if ( ! empty( $wp_registered_sidebars ) ) {
			$sidebar_ids = wp_list_pluck( $wp_registered_sidebars, 'id' );
			
			return array_shift( $sidebar_ids );
		}

		return "";
	}
}
new MHComposer_Component_Sidebar;