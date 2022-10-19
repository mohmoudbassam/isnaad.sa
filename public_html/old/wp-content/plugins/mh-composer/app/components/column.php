<?php
class MHComposer_Column extends MHComposer_Structure_Element {
	function init() {
		$this->name                       = esc_html__( 'Column', 'mh-composer' );
		$this->slug                       = 'mhc_column';
		$this->additional_shortcode_slugs = array( 'mhc_column_inner' );

		$this->approved_fields = array(
			'type',
			'specialty_columns',
			'saved_specialty_column_type',
		);

		$this->fields_defaults = array(
			'type'                        => array( '4_4' ),
			'specialty_columns'           => array( '' ),
			'saved_specialty_column_type' => array( '' ),
		);
	}

	function get_fields() {
		$fields = array(
			'type' => array(
				'type' => 'skip',
			),
			'specialty_columns' => array(
				'type' => 'skip',
			),
			'saved_specialty_column_type' => array(
				'type' => 'skip',
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
		$type                        = $this->shortcode_atts['type'];
		$specialty_columns           = $this->shortcode_atts['specialty_columns'];
		$saved_specialty_column_type = $this->shortcode_atts['saved_specialty_column_type'];

		global $mh_specialty_column_type;

		if ( 'mhc_column_inner' === $function_name ) {
			$mh_specialty_column_type = '' !== $saved_specialty_column_type ? $saved_specialty_column_type : $mh_specialty_column_type;

			switch ( $mh_specialty_column_type ) {
				case '1_2':
					if ( '1_2' === $type ) {
						$type = '1_4';
					}

					break;
				case '2_3':
					if ( '1_2' === $type ) {
						$type = '1_3';
					}

					break;
				case '3_4':
					if ( '1_2' === $type ) {
						$type = '3_8';
					} else if ( '1_3' === $type ) {
						$type = '1_4';
					}

					break;
			}
		}

		$inner_class = 'mhc_column_inner' === $function_name ? ' mhc_column_inner' : '';

		$class = 'mhc_column_' . $type . $inner_class;
		
		$class = MHComposer_Core::add_module_order_class( $class, $function_name );

		$inner_content = do_shortcode( mhc_fix_shortcodes( $content ) );
		$class .= '' == trim( $inner_content ) ? ' mhc_column_empty' : '';
		$class .= 'mhc_column_inner' !== $function_name && '' !== $specialty_columns ? ' mhc_specialty_column' : '';

		$output = sprintf(
			'<div class="mhc_column %1$s">
				%2$s
			</div> <!-- .mhc_column -->',
			esc_attr( $class ),
			$inner_content
		);

		return $output;

	}

}
new MHComposer_Column;