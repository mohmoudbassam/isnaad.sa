<?php
class MHComposer_Component_Tabs extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Tabs', 'mh-composer' );
		$this->slug            = 'mhc_tabs';
		$this->child_slug      = 'mhc_tab';
		$this->child_item_text = esc_html__( 'Add New Tab', 'mh-composer' );
		$this->main_css_selector = '%%order_class%%.mhc_tabs';

		$this->approved_fields = array(
			'admin_label',
			'module_id',
			'module_class',
			'controls_background_color',
			'background_color',
			'background_layout',
			'show_border',
			'border_color',
		);
		
		$this->fields_defaults = array(
			'background_layout'      => array( 'light' ),
			'show_border'       		=> array( 'on' ),
		);
		
		$this->custom_css_options = array(
			'tab_title' => array(
				'label'    => esc_html__( 'Tab Title', 'mh-composer' ),
				'selector' => '.mhc_tabs_controls li',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'tab' => array(
				'label'    => esc_html__( 'Tab', 'mh-composer' ),
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
			'controls_background_color' => array(
				'label'             => esc_html__( 'Controls Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'background_color' => array(
				'label'             => esc_html__( 'Background Colour', 'mh-composer' ),
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
		$module_id                         = $this->shortcode_atts['module_id'];
		$module_class                      = $this->shortcode_atts['module_class'];
		$controls_background_color	     = $this->shortcode_atts['controls_background_color'];
		$background_color       			  = $this->shortcode_atts['background_color'];
		$background_layout       			 = $this->shortcode_atts['background_layout'];
		$show_border     				   = $this->shortcode_atts['show_border'];
		$border_color       				  = $this->shortcode_atts['border_color'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$all_tabs_content = $this->shortcode_content;

		global $mhc_tab_titles;
		global $mhc_tab_classes;

		if ( '' !== $controls_background_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_tabs_controls, %%order_class%% .mhc_tabs_controls li',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $controls_background_color )
				),
			) );
		}

		if ( '' !== $background_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_all_tabs, %%order_class%% .mhc_tabs_controls li.mhc_tab_active',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $background_color )
				),
			) );
		}
		
		if ( 'off' !== $show_border && '' !== $border_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_tabs, %%order_class%% .mhc_tabs_controls, %%order_class%% .mhc_tabs_controls li',
				'declaration' => sprintf(
					'border-color: %1$s;',
					esc_html( $border_color )
				),
			) );
		}

		$tabs = '';

		$i = 0;
		if ( ! empty( $mhc_tab_titles ) ) {
			foreach ( $mhc_tab_titles as $tab_title ){
				++$i;
				$tabs .= sprintf( '<li class="%3$s%1$s"><a href="#">%2$s</a></li>',
					( 1 == $i ? ' mhc_tab_active' : '' ),
					esc_html( $tab_title ),
					esc_attr( ltrim( $mhc_tab_classes[ $i-1 ] ) )
				);
			}
		}

		$mhc_tab_titles = $mhc_tab_classes = array();
		
		$class = " mhc_bg_layout_{$background_layout}";
		
		$output = sprintf(
			'<div%3$s class="mhc_tabs_container mhc_module mhc_pct%4$s">
				<div class="mhc_tabs%5$s%6$s">
				<ul class="mhc_tabs_controls clearfix">
					%1$s
				</ul>
				<div class="mhc_all_tabs">
					%2$s
				</div> <!-- .mhc_all_tabs -->
			</div>
			</div> <!-- .mhc_tabs_container -->',
			$tabs,
			$all_tabs_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			$class,
			('off' !== $show_border ? ' mhc_show_borders' : '')
		);

		return $output;
	}
}
new MHComposer_Component_Tabs;

class MHComposer_Component_Tabs_Item extends MHComposer_Component {
	function init() {
		$this->name                        = esc_html__( 'Tab', 'mh-composer' );
		$this->slug                        = 'mhc_tab';
		$this->type                        = 'child';
		$this->child_title_var             = 'title';

		$this->approved_fields = array(
			'title',
			'content_new',
		);

		$this->advanced_setting_title_text = esc_html__( 'New Tab', 'mh-composer' );
		$this->settings_text               = esc_html__( 'Tab Settings', 'mh-composer' );
		$this->main_css_selector = '%%order_class%%';
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'       => esc_html__( 'Title', 'mh-composer' ),
				'type'        => 'text',
				'description' => esc_html__( 'The title will be used within the tab button for this tab.', 'mh-composer' ),
			),
			'content_new' => array(
				'label'       => esc_html__( 'Content', 'mh-composer' ),
				'type'        => 'tiny_mce',
				'description' => esc_html__( 'Input the main text content for your component here.', 'mh-composer' ),
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $mhc_tab_titles;
		global $mhc_tab_classes;

		$title = $this->shortcode_atts['title'];

		$module_class = MHComposer_Core::add_module_order_class( '', $function_name );

		$i = 0;

		$mhc_tab_titles[]  = '' !== $title ? $title : esc_html__( 'Tab', 'mh-composer' );
		$mhc_tab_classes[] = $module_class;

		$output = sprintf(
			'<div class="mhc_tab clearfix%2$s%3$s">
				%1$s
			</div> <!-- .mhc_tab -->',
			$this->shortcode_content,
			( 1 === count( $mhc_tab_titles ) ? ' mhc_active_content' : '' ),
			esc_attr( $module_class )
		);

		return $output;
	}
}
new MHComposer_Component_Tabs_Item;