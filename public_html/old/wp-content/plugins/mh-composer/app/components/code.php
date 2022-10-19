<?php
class MHComposer_Component_Code extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Code', 'mh-composer' );
		$this->slug            = 'mhc_code';
		$this->use_row_content = true;
		$this->decode_entities = true;

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'raw_content',
			'admin_label',
		);
	}

	function get_fields() {
		$fields = array(
			'raw_content' => array(
				'label'           => esc_html__( 'Content', 'mh-composer' ),
				'type'            => 'textarea',
				'description'     => esc_html__( 'Use this field for custom content, HTML, JS, Shortcodes from third-party plugins etc.', 'mh-composer' ),
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
		$module_id    = $this->shortcode_atts['module_id'];
		$module_class = $this->shortcode_atts['module_class'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$this->shortcode_content = mh_composer_replace_code_content_entities( $this->shortcode_content );


		$output = sprintf(
			'<div%2$s class="mhc_code mhc_module%3$s">
				%1$s
			</div> <!-- .mhc_code -->',
			$this->shortcode_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Code;