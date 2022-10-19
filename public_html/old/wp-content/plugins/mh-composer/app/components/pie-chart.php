<?php
class MHComposer_Component_Pie_Chart extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Pie Chart', 'mh-composer' );
		$this->slug            = 'mhc_pie_chart';
		$this->child_slug      = 'mhc_pie_chart_legend';
		$this->child_item_text = esc_html__( 'Add New Part', 'mh-composer' );
		$this->main_css_selector = '%%order_class%%.mhc_pie_chart_container';
		
		$this->approved_fields = array(
			'background_layout',
			'admin_label',
			'module_id',
			'module_class',
			'type',
		);
		
		$this->fields_defaults = array(
			'background_layout' 	=> array( 'light' ),
			'type' 				 => array( 'Pie' ),
		);
	}
	
	function get_fields() {
		$fields = array(
			'type' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'Pie'  => esc_html__( 'Pie', 'mh-composer' ),
					'Doughnut' => esc_html__( 'Doughnut', 'mh-composer' ),
				),
				'description'     => esc_html__( 'This will change the chart type.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'light'  => esc_html__( 'Dark', 'mh-composer' ),
					'dark' => esc_html__( 'Light', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
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
		$module_id    			= $this->shortcode_atts['module_id'];
		$module_class 		     = $this->shortcode_atts['module_class'];
		$type 				  	 = $this->shortcode_atts['type'];
		$background_layout 		= $this->shortcode_atts['background_layout'];
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		wp_enqueue_script( 'chart-appear-js');
		$id = mt_rand(1000, 9999);
		$class = " mhc_bg_layout_{$background_layout}";
		$size = "510";
		$content = $this->shortcode_content;
		
		
		$output = sprintf('<div class="mhc_pie_chart_container%2$s"><div class="mhc_pie_chart"><canvas id="pie%1$s" height="%3$s" width="%3$s"></canvas></div><div class="mhc_pie_chart_legend"><ul>%4$s</ul></div></div><script>var pie%1$s = [%5$s];%6$s',
	$id,
	$class,
	$size,
	mhc_extract_chart_parts( $content ),
	rtrim(mhc_extract_chart_parts_js( $content ), ','),
	"var \$j = jQuery.noConflict();
		\$j(document).ready(function() {
			if(\$j('.touch .no_delay').length){
				new Chart(document.getElementById('pie".$id."').getContext('2d')).".$type."(pie".$id.",{segmentStrokeColor : 'transparent', animationEasing : 'easeOutCubic',});
			}else{
				\$j('#pie".$id."').appear(function() {
					new Chart(document.getElementById('pie".$id."').getContext('2d')).".$type."(pie".$id.",{segmentStrokeColor : 'transparent', animationEasing : 'easeOutCubic',});
				},{accX: 0, accY: -200});
			}
		});
	</script>"
	);
	
		return $output;
	}
}
new MHComposer_Component_Pie_Chart;

class MHComposer_Component_Pie_Chart_Item extends MHComposer_Component {
	function init() {
		$this->name                        = esc_html__( 'Part', 'mh-composer' );
		$this->slug                        = 'mhc_pie_chart_legend';
		$this->type                        = 'child';
		$this->child_title_var             = 'content_new';
		$this->custom_css_tab              = false;

		$this->approved_fields = array(
			'content_new',
			'percent',
			'color',
		);
		$this->fields_defaults = array(
			'percent' => array( '30' ),
			'color'   => array( mh_composer_accent_color(), 'append_default' ),
		);
		$this->advanced_setting_title_text = esc_html__( 'New Part', 'mh-composer' );
		$this->settings_text               = esc_html__( 'Part Settings', 'mh-composer' );
	}
		
		function get_fields() {
		$fields = array(
			'content_new' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input a title for this part.', 'mh-composer' ),
			),
			'percent' => array(
				'label'           => esc_html__( 'Percent', 'mh-composer' ),
				'type'            => 'range',
				'default' => '30',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'description'     => esc_html__( 'Define a percentage for this part. Numeric value only.', 'mh-composer' ),
			),
			'color' => array(
				'label'             => esc_html__( 'Part Colour', 'mh-composer' ),
				'type'              => 'color',
				'description'       => esc_html__( 'Define a custom colour for this part.', 'mh-composer' ),
			),
		);
		return $fields;
	}
	
	function shortcode_callback( $atts, $content = null, $function_name ) {

		$percent             = $this->shortcode_atts['percent'];
		$color 			   = $this->shortcode_atts['color'];

		$module_class = MHComposer_Core::add_module_order_class( '', $function_name );
	
		$output = sprintf(
		'%1$s, %2$s, %3$s;',
		( '' !== $percent ? $percent : '30' ),
		( '' !== $color ? $color : '' ),
		sanitize_text_field( $content )
	);
	
	return $output;
	}

}
new MHComposer_Component_Pie_Chart_Item;