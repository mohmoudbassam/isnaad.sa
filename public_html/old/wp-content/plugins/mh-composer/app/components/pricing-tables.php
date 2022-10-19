<?php
class MHComposer_Component_Pricing_Tables extends MHComposer_Component {
	function init() {
		$this->name                 = esc_html__( 'Pricing Tables', 'mh-composer' );
		$this->slug                 = 'mhc_pricing_tables';
		$this->main_css_selector 	= '%%order_class%%.mhc_pricing';
		$this->child_slug           = 'mhc_pricing_table';
		$this->child_item_text      = esc_html__( 'Add New Pricing Table', 'mh-composer' );
		$this->additional_shortcode = 'mhc_pricing_item';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'background_layout',
			'button_style',
			'style',
			'color',
			'featured_color',
		);

		$this->fields_defaults = array(
			'button_style' => array( 'transparent' ),
			'style' => array( 'default' ),
			'background_layout' => array( 'light' ),
			'color' => array( '#e2e2e2', 'append_default' ),
			'featured_color' => array( mh_composer_accent_color(), 'append_default' )
		);

		$this->custom_css_options = array(
			'pricing_heading' => array(
				'label'    => esc_html__( 'Pricing Heading', 'mh-composer' ),
				'selector' => '.mhc_pricing_heading',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_title' => array(
				'label'    => esc_html__( 'Pricing Title', 'mh-composer' ),
				'selector' => '.mhc_pricing_heading h2',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_subheading' => array(
				'label'    => esc_html__( 'Pricing Subheading', 'mh-composer' ),
				'selector' => '.mhc_pricing_heading .mhc_best_value',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_content_top' => array(
				'label'    => esc_html__( 'Pricing Top', 'mh-composer' ),
				'selector' => '.mhc_pricing_content_top',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_price' => array(
				'label'    => esc_html__( 'Price', 'mh-composer' ),
				'selector' => '.mhc_sum',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_currency_sign' => array(
				'label'    => esc_html__( 'Currency Sign', 'mh-composer' ),
				'selector' => '.mhc_currency_sign',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_per_term' => array(
				'label'    => esc_html__( 'Term', 'mh-composer' ),
				'selector' => '.mhc_per_term',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_button' => array(
				'label'    => esc_html__( 'Pricing Button', 'mh-composer' ),
				'selector' => '.mhc_pricing_table_button',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'style' => array(
				'label'           => esc_html__( 'Style', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'mh-composer' ),
					'neon' => esc_html__( 'Neon', 'mh-composer' ),
				),
				'affects' => array(
					'#mhc_background_layout',
					'#mhc_color',
					'#mhc_featured_color',
				),
				'description'       => esc_html__( 'Choose the desired style.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
					'light' => esc_html__( 'Dark', 'mh-composer' ),
				),
				'depends_show_if'   => 'neon',
				'description'       => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			'color' => array(
				'label'             => esc_html__( 'Tables Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_show_if'   => 'neon',
				'description'       => esc_html__( 'Define a custom colour for your tables. Featured table could be coloured differently.', 'mh-composer' ),
			),
			'featured_color' => array(
				'label'             => esc_html__( 'Featured Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_show_if'   => 'neon',
				'description'       => esc_html__( 'Define a custom colour for your featured table here.', 'mh-composer' ),
			),
			'button_style' => array(
				'label'           => esc_html__( 'Button Style', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'transparent' => esc_html__( 'Transparent', 'mh-composer' ),
					'solid' => esc_html__( 'Solid', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This defines the button style.', 'mh-composer' ),
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

	function pre_shortcode_content() {
		global $mhc_pricing_tables_num, $mhc_pricing_tables_style;
		$mhc_pricing_tables_num 	= 0;
		$style 					 = $this->shortcode_atts['style'];
		$color 					 = $this->shortcode_atts['color'];
		$featured_color 	   		= $this->shortcode_atts['featured_color'];
		$button_style		 	  = $this->shortcode_atts['button_style'];
		
		$mhc_pricing_tables_style = array(
			'style' 			=> $style,
			'color'          	=> $color,
			'featured_color'   => $featured_color,
			'button_style'     => $button_style,
		);
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$button_style                           = $this->shortcode_atts['button_style'];
		$style                            	  = $this->shortcode_atts['style'];
		$background_layout                      = $this->shortcode_atts['background_layout'];
		$color                            	  = $this->shortcode_atts['color'];
		$featured_color                         = $this->shortcode_atts['featured_color'];
		$module_id                              = $this->shortcode_atts['module_id'];
		$module_class                           = $this->shortcode_atts['module_class'];

		global $mhc_pricing_tables_num, $mhc_pricing_tables_style;

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		

		$content = $this->shortcode_content;

		$output = sprintf(
			'<div%3$s class="mhc_module mhc_pricing clearfix%2$s%4$s%5$s%6$s">
				%1$s
			</div>',
			$content,
			esc_attr( " mhc_pricing_{$mhc_pricing_tables_num}" ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			esc_attr( " mhc_pricing_{$style}" ),
			( 'default' !== $style ? esc_attr( " mhc_bg_layout_{$background_layout}") : '')
		);

		return $output;
	}

	function additional_shortcode_callback( $atts, $content = null, $function_name ) {
		$attributes = shortcode_atts( array(
			'available' => 'on',
		), $atts );

		$output = sprintf( '<li%2$s><span>%1$s</span></li>',
			$content,
			( 'on' !== $attributes['available'] ? ' class="mhc_not_available"' : '' )
		);
		return $output;
	}
}
new MHComposer_Component_Pricing_Tables;

class MHComposer_Component_Pricing_Tables_Item extends MHComposer_Component {
	function init() {
		$this->name                        = esc_html__( 'Pricing Table', 'mh-composer' );
		$this->slug                        = 'mhc_pricing_table';
		$this->main_css_selector 		   = '%%order_class%%.mhc_pricing';
		$this->type                        = 'child';
		$this->child_title_var             = 'title';

		$this->approved_fields = array(
			'featured',
			'title',
			'subtitle',
			'currency',
			'per',
			'sum',
			'button_url',
			'button_text',
			'content_new',
		);

		$this->fields_defaults = array(
			'featured' => array( 'off' ),
		);

		$this->advanced_setting_title_text = esc_html__( 'New Pricing Table', 'mh-composer' );
		$this->settings_text               = esc_html__( 'Pricing Table Settings', 'mh-composer' );
		$this->main_css_selector = '%%order_class%%';
	}

	function get_fields() {
		$fields = array(
			'featured' => array(
				'label'           => esc_html__( 'Featured', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description' => esc_html__( 'Featuring a table will make it stand out from the rest.', 'mh-composer' ),
			),
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define a title for the pricing table.', 'mh-composer' ),
			),
			'subtitle' => array(
				'label'           => esc_html__( 'Subheading Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'If you would like to use a subheading, add it here.', 'mh-composer' ),
			),
			'currency' => array(
				'label'           => esc_html__( 'Currency', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input your desired currency symbol here.', 'mh-composer' ),
			),
			'per' => array(
				'label'           => esc_html__( 'Per', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'If your pricing is subscription based, input the subscription payment cycle here, e.g. Monthly, Annually, etc.', 'mh-composer' ),
			),
			'sum' => array(
				'label'           => esc_html__( 'Price', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input the price value here.', 'mh-composer' ),
			),
			'button_url' => array(
				'label'           => esc_html__( 'Button URL', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input the destination URL for the signup button.', 'mh-composer' ),
			),
			'button_text' => array(
				'label'           => esc_html__( 'Button Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Adjust the text used for the signup button.', 'mh-composer' ),
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'mh-composer' ),
				'type'            => 'tiny_mce',
				'description'     => sprintf(
					'%1$s<br/> 1 %2$s<br/> 0 %3$s',
					esc_html__( 'Input a list of features that are or are not included in the product. Place each item in a new line, and begin with either 1 (included) or 0 (not included) symbol: ', 'mh-composer' ),
					esc_html__( 'Included feature', 'mh-composer' ),
					esc_html__( 'Excluded feature', 'mh-composer' )
				),
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $mhc_pricing_tables_num, $mhc_pricing_tables_style;

		$featured      	 = $this->shortcode_atts['featured'];
		$title         	= $this->shortcode_atts['title'];
		$subtitle      	 = $this->shortcode_atts['subtitle'];
		$currency      	 = $this->shortcode_atts['currency'];
		$per           	  = $this->shortcode_atts['per'];
		$sum           	  = $this->shortcode_atts['sum'];
		$button_url       = $this->shortcode_atts['button_url'];
		$button_text   	  = $this->shortcode_atts['button_text'];
	

		$mhc_pricing_tables_num++;
		

		$module_class = MHComposer_Core::add_module_order_class( '', $function_name );
		
		$neon = $table_button_style = $table_title_style = $table_border_style  ='';
		if ('neon' === $mhc_pricing_tables_style['style'] && 'off' !== $featured)
			$neon = $mhc_pricing_tables_style['featured_color'];
		if ('neon' === $mhc_pricing_tables_style['style'] && 'off' === $featured)
			$neon = $mhc_pricing_tables_style['color'];
		
		if ( 'solid' !== $mhc_pricing_tables_style['button_style'] && 'neon' === $mhc_pricing_tables_style['style']){
			 $table_button_style .= sprintf( 'color:%1$s !important;',  $neon);
		}
		if ( 'solid' === $mhc_pricing_tables_style['button_style'] && 'neon' === $mhc_pricing_tables_style['style']){
			$table_button_style .= sprintf( 'background:%1$s!important; border-color:%1$s !important;',  $neon);
		}
		
				
		if ( '' !== $table_button_style ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mhc_pricing_table_button',
					'declaration' => ltrim( $table_button_style )
				) );
		}
		if ('default' !== $mhc_pricing_tables_style['style'] ){
			$table_title_style .= sprintf( 'color:%1$s !important;',  $neon);
			$table_border_style .= sprintf( 'border-color:%1$s !important;',  $neon);
		}
		if ( '' !== $table_title_style || '' !== $table_border_style ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mhc_pricing_title',
					'declaration' => ltrim( $table_title_style )
				) );
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mhc_sum',
					'declaration' => ltrim( $table_title_style )
				) );
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => ltrim( $table_border_style )
				) );
		}


		if ( '' !== $button_url && '' !== $button_text ) {
			$button_text = sprintf( '<a class="mhc_pricing_table_button mhc_button%3$s" href="%1$s">%2$s</a>',
				esc_url( $button_url ),
				esc_html( $button_text ),
				( 'solid' === $mhc_pricing_tables_style['button_style'] ? ' mhc_button_solid"' : ' mhc_button_transparent' )
			);
		}

		$output = sprintf(
			'<div class="mhc_pricing_table%1$s%9$s">
				<div class="mhc_pricing_heading">
					%2$s
					%3$s
				</div> <!-- .mhc_pricing_heading -->
				<div class="mhc_pricing_content_wrapper">
				<div class="mhc_pricing_content_top">
					<div class="mhc_price">%10$s%6$s%7$s</div>
					%8$s
				</div> <!-- .mhc_pricing_content_top -->
				<div class="mhc_pricing_content">
					<ul class="mhc_pricing">
						%4$s
					</ul>
				</div> <!-- .mhc_pricing_content -->
				%5$s
				</div> <!-- .mhc_pricing_content_wrapper -->
			</div>',
			( 'off' !== $featured ? ' mhc_featured_table' : '' ),
			( '' !== $title ? sprintf( '<h2 class="mhc_pricing_title">%1$s</h2>', esc_html( $title ) ) : '' ),
			( '' !== $subtitle ? sprintf( '<span class="mhc_best_value">%1$s</span>', esc_html( $subtitle ) ) : '' ),
			do_shortcode( mhc_fix_shortcodes( mhc_extract_items( $content ) ) ),
			$button_text,
			( '' !== $sum ? sprintf( '<span class="mhc_sum">%1$s</span>', esc_html( $sum ) ) : '' ),
			( '' !== $currency && is_rtl() ? sprintf( '<span class="mhc_currency_sign">%1$s</span>', esc_html( $currency ) ) : '' ),
			( '' !== $per ? sprintf( '<span class="mhc_per_term">- %1$s -</span>', esc_html( $per ) ) : '' ),
			esc_attr( $module_class ),
			( '' !== $currency && !is_rtl() ? sprintf( '<span class="mhc_currency_sign">%1$s</span>', esc_html( $currency ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Pricing_Tables_Item;