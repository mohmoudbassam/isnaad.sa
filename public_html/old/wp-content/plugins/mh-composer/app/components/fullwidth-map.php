<?php
class MHComposer_Component_Fullwidth_Map extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Full-width Map', 'mh-composer' );
		$this->slug            = 'mhc_fullwidth_map';
		$this->fullwidth       = true;
		$this->child_slug      = 'mhc_map_pin';
		$this->child_item_text = esc_html__( 'Add New Pin', 'mh-composer' );

		$this->approved_fields = array(
			'address',
			'zoom_level',
			'address_lat',
			'address_lng',
			'map_center_map',
			'mouse_wheel',
			'admin_label',
			'module_id',
			'module_class',
			'pin_image',
			'map_style',
			'map_color',
		);

		$this->fields_defaults = array(
			'zoom_level'		 => array( '18', 'append_default' ),
			'mouse_wheel' 		=> array( 'on' ),
			'map_style'		  => array( '1' ),
			'map_color'		  => array( mh_composer_accent_color(), 'append_default' ),
		);
	}

	function get_fields() {
		$fields = array(
			'google_api_key' => array(
				'label'             => esc_html__( 'Google API Key', 'mh-composer' ),
				'type'              => 'text',
				'attributes'        => 'readonly',
				'additional_button' => sprintf(
					' <a href="%2$s" target="_blank" class="mhc_update_google_key button" data-empty_text="%3$s">%1$s</a>',
					esc_html__( 'Change API Key', 'mh-composer' ),
					esc_url( mh_get_theme_panel_link_advanced() ),
					esc_attr__( 'Add Your API Key', 'mh-composer' )
				),
				'class' => array( 'mhc_google_api_key', 'mhc-helper-field' ),
				'description'       => mh_wp_kses( sprintf( __( 'The Maps component uses the Google Maps API and requires a valid Google API Key to work. Before using the map component, please make sure you input your API key in the field. Learn more about how to create your Google API Key <a target="_blank" href="%1$s">here</a>.', 'mh-composer' ), 'http://mharty.com/docs/maps' ) ),
			),
			'address' => array(
				'label'             => esc_html__( 'Map Centre Address', 'mh-composer' ),
				'type'              => 'text',
				'additional_button' => sprintf(
					' <a href="#" class="mhc_find_address button">%1$s</a>',
					esc_html__( 'Find', 'mh-composer' )
				),
				'class'       => array( 'mhc_address' ),
				'description' => esc_html__( 'Enter an address for the map centre point, and the address will be geocoded and displayed on the map below.', 'mh-composer' ),
			),
			'zoom_level' => array(
				'type'    => 'hidden',
				'class'   => array( 'mhc_zoom_level' ),
			),
			'address_lat' => array(
				'type'  => 'hidden',
				'class' => array( 'mhc_address_lat' ),
			),
			'address_lng' => array(
				'type'  => 'hidden',
				'class' => array( 'mhc_address_lng' ),
			),
			'map_center_map' => array(
				'renderer'              => 'mh_composer_generate_center_map_setting',
				'use_container_wrapper' => false,
			),
			'mouse_wheel' => array(
				'label'           => esc_html__( 'Mouse Wheel Zoom', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'On', 'mh-composer' ),
					'off' => esc_html__( 'Off', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose whether the zoom level will be controlled by mouse wheel.', 'mh-composer' ),
			),
			'map_style' => array(
				'label'           => esc_html__( 'Map Style', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'1'  => esc_html__( 'Default', 'mh-composer' ),
					'2' => esc_html__( 'Dark', 'mh-composer' ),
					'3' => esc_html__( 'Light Colour', 'mh-composer' ),
					'4' => esc_html__( 'Dark Colour', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose the style for your map.', 'mh-composer' ),
			),
			'map_color' => array(
				'label'             => esc_html__( 'Map Colour', 'mh-composer' ),
				'type'              => 'color',
				'description'       => esc_html__( 'Define a custom colour for your map. Some map style options will ignore this option.', 'mh-composer' ),
			),
			'pin_image' => array(
				'label'              => esc_html__( 'Pin Icon Image', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Image', 'mh-composer' ),
				'description'        => esc_html__( 'You can change the default icon. Upload your desired image, or type in the URL to the image you would like to display.', 'mh-composer' ),
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
		$module_id            = $this->shortcode_atts['module_id'];
		$module_class         = $this->shortcode_atts['module_class'];
		$address_lat          = $this->shortcode_atts['address_lat'];
		$address_lng          = $this->shortcode_atts['address_lng'];
		$zoom_level           = $this->shortcode_atts['zoom_level'];
		$mouse_wheel          = $this->shortcode_atts['mouse_wheel'];
		$map_style            = $this->shortcode_atts['map_style'];
		$map_color           	= $this->shortcode_atts['map_color'];
		$pin_image			= $this->shortcode_atts['pin_image'];
		
		wp_enqueue_style( 'mharty-maps');
		wp_enqueue_script( 'mharty-maps');
		
		$id = 'mhc_map_id_' . uniqid();

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$all_pins_content = $this->shortcode_content;

		$output = sprintf(
			'<div%5$s class="mhc_module mhc_map_container%6$s">
				<div id="%8$s" class="mhc_map" data-center-lat="%1$s" data-center-lng="%2$s" data-zoom="%3$d" data-mouse-wheel="%7$s" data-map-style="%9$s" data-map-color="%10$s" data-pin-image="%11$s"></div>
				<div class="mhc_map_pins %8$s">
					%4$s
				</div>
			</div>',
			esc_attr( $address_lat ),
			esc_attr( $address_lng ),
			esc_attr( $zoom_level ),
			$all_pins_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			esc_attr( $mouse_wheel ),
			$id,
			esc_attr($map_style),
			esc_attr( $map_color ),
			('' !== $pin_image ? esc_attr( $pin_image ) :  MH_COMPOSER_URI . '/images/marker.png')
		);

		return $output;
	}
}
new MHComposer_Component_Fullwidth_Map;