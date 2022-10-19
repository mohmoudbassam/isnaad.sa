<?php
class MHComposer_Component_Accordion extends MHComposer_Component {
	function init() {
		$this->name       = esc_html__( 'Accordion', 'mh-composer' );
		$this->slug       = 'mhc_accordion';
		$this->child_slug = 'mhc_accordion_item';
		$this->main_css_selector = '%%order_class%%.mhc_accordion';

		$this->approved_fields = array(
			'admin_label',
			'module_id',
			'module_class',
		);
		
		$this->custom_css_options = array(
			'accordion_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => '.mhc_toggle_title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'accordion_content' => array(
				'label'    => esc_html__( 'Content', 'mh-composer' ),
				'selector' => '.mhc_tab',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
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

	function pre_shortcode_content() {
		global $mhc_accordion_item_number;

		$mhc_accordion_item_number = 1;

	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id                      	 = $this->shortcode_atts['module_id'];
		$module_class                   	  = $this->shortcode_atts['module_class'];

		global $mhc_accordion_item_number;

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );


		$output = sprintf(
			'<div%2$s class="mhc_module mhc_accordion%3$s">
				%1$s
			</div> <!-- .mhc_accordion -->',
			$this->shortcode_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Accordion;

class MHComposer_Component_Accordion_Item extends MHComposer_Component {
	function init() {
		$this->name                  = esc_html__( 'Accordion', 'mh-composer' );
		$this->slug                  = 'mhc_accordion_item';
		$this->type                  = 'child';
		$this->child_title_var       = 'title';
		$this->no_shortcode_callback = true;

		$this->approved_fields = array(
			'title',
			'content_new',
			'background_color',
			'closed_background_color',
			'background_layout',
			'icon_color',
			'show_border',
			'border_color',
		);
		
		$this->fields_defaults = array(
			'background_layout'      			=> array( 'light' ),
			'show_border'       				  => array( 'on' ),
		);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'The toggle title will appear above the content and when the toggle is closed.', 'mh-composer' ),
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'mh-composer' ),
				'type'            => 'tiny_mce',
				'description'     => esc_html__( 'Input the main text content for your component here.', 'mh-composer' ),
			),
			'background_color' => array(
				'label'             => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'closed_background_color' => array(
				'label'             => esc_html__( 'Closed Toggle Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'light' => esc_html__( 'Dark', 'mh-composer' ),
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
				),
				'tab_slug'          => 'advanced',
			),
			'icon_color' => array(
				'label'             => esc_html__( 'Icon Colour', 'mh-composer' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'show_border' => array(
				'label'             => esc_html__( 'Show Border', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'tab_slug' => 'advanced',
				'affects'           => array(
					'#mhc_border_color',
				),
			),
			'border_color' => array(
				'label'             => esc_html__( 'Border Colour', 'mh-composer' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
				'depends_show_if'   => 'on',
			),
		);
		return $fields;
	}
}
new MHComposer_Component_Accordion_Item;