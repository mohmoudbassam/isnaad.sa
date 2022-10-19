<?php
class MHComposer_Component_Toggle extends MHComposer_Component {
	function init() {
		$this->name                       = esc_html__( 'Toggle', 'mh-composer' );
		$this->slug                       = 'mhc_toggle';
		$this->additional_shortcode_slugs = array( 'mhc_accordion_item' );
		$this->main_css_selector = '%%order_class%%.mhc_toggle';

		$this->approved_fields = array(
			'title',
			'open',
			'content_new',
			'admin_label',
			'module_id',
			'module_class',
			'background_color',
			'closed_background_color',
			'background_layout',
			'icon_color',
			'show_border',
			'border_color',
		);

		$this->fields_defaults = array(
			'open' 				=> array( 'off' ),
			'background_layout'   => array( 'light' ),
			'show_border'       	 => array( 'on' ),
		);
		
		$this->custom_css_options = array(
			'toggle_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => '.mhc_tabs_controls li',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'toggle_content' => array(
				'label'    => esc_html__( 'Content', 'mh-composer' ),
				'selector' => '.mhc_tab',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'The toggle title will appear above the content and when the toggle is closed.', 'mh-composer' ),
			),
			'open' => array(
				'label'           => esc_html__( 'State', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'off' => esc_html__( 'Closed', 'mh-composer' ),
					'on'  => esc_html__( 'Open', 'mh-composer' ),
				),
				'description' => esc_html__( 'Choose whether this toggle should start in an open or closed state.', 'mh-composer' ),
			),
			'content_new' => array(
				'label'             => esc_html__( 'Content', 'mh-composer' ),
				'type'              => 'tiny_mce',
				'description'       => esc_html__( 'Input the main text content for your component here.', 'mh-composer' ),
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
		$title        = $this->shortcode_atts['title'];
		$open         = $this->shortcode_atts['open'];
		$background_color       			  = $this->shortcode_atts['background_color'];
		$background_layout       			 = $this->shortcode_atts['background_layout'];
		$show_border     				   = $this->shortcode_atts['show_border'];
		$border_color       				  = $this->shortcode_atts['border_color'];
		$closed_background_color 		   = $this->shortcode_atts['closed_background_color'];
		$icon_color 						= $this->shortcode_atts['icon_color'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		if ( '' !== $background_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_toggle_open',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $background_color )
				),
			) );
		}

		if ( '' !== $closed_background_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_toggle_close',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $closed_background_color )
				),
			) );
		}

		if ( '' !== $icon_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_toggle_title:before',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $icon_color )
				),
			) );
		}
		
		if ( 'off' !== $show_border && '' !== $border_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_toggle',
				'declaration' => sprintf(
					'border-color: %1$s;',
					esc_html( $border_color )
				),
			) );
		}

		$class = " mhc_module mhc_bg_layout_{$background_layout}";
		
		if ( 'mhc_accordion_item' === $function_name ) {
			global $mhc_accordion_item_number;

			$open = 1 === $mhc_accordion_item_number ? 'on' : 'off';

			$mhc_accordion_item_number++;
		}

		// Adding "_item" class for toggle module for customizer targetting. There's no proper selector
		// for toggle module styles since both accordion and toggle module use the same selector
		if( 'mhc_toggle' === $function_name ){
			$module_class .= " mhc_toggle_item";
		}

		$output = sprintf(
			'<div%4$s class="mhc_toggle%2$s%5$s%6$s%7$s">
				<h5 class="mhc_toggle_title">%1$s</h5>
				<div class="mhc_toggle_content clearfix">
					%3$s
				</div>
			</div>',
			esc_html( $title ),
			( 'on' === $open ? ' mhc_toggle_open' : ' mhc_toggle_close' ),
			$this->shortcode_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			('off' !== $show_border ? ' mhc_show_borders' : ''),
			$class
		);

		return $output;
	}
}
new MHComposer_Component_Toggle;