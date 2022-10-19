<?php
class MHComposer_Component_Comments extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Comments', 'mh-composer' );
		$this->slug            = 'mhc_comments';

		$this->approved_fields = array(
			'show_comments',
			'admin_label',
			'module_id',
			'module_class',
		);
		
		$this->fields_defaults = array(
			'show_comments' => array( 'on' ),
		);
	}
	
	function get_fields() {
		$fields = array(
			'show_comments' => array(
				'label'       => esc_html__( 'Show Comments', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
						'on'  => esc_html__( 'Yes', 'mh-composer' ),
						'off' => esc_html__( 'No', 'mh-composer' ),
					),
				'description'     => esc_html__( 'This component will display comments and comments form, for better results place this component in a wide column size at least half.', 'mh-composer' ) .' — ' . esc_html__( 'Note: please only place this component once on the same page, otherwise duplicate comments will be displayed.', 'mh-composer' ),
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
		$show_comments = $this->shortcode_atts['show_comments'];
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		
		ob_start();
		comments_template( '', true );
		$comments = ob_get_contents();
		ob_end_clean();
	
		$output = sprintf(
			'<div%2$s class="mhc_comments mhc_module mhc_pct%3$s">
			%1$s
			</div> <!-- .mhc_comments -->
			',
			('off' !== $show_comments ? $comments : ''),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
			);
	
		return $output;
	
	}
}
new MHComposer_Component_Comments;