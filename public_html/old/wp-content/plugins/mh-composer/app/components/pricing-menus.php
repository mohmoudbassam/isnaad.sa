<?php
class MHComposer_Component_Pricing_Menus extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Special List', 'mh-composer' );
		$this->slug            = 'mhc_pricing_menus';
		$this->child_slug      = 'mhc_pricing_menu';
		$this->main_css_selector = '%%order_class%%.mhc_pricing_menus';
		
		$this->approved_fields = array(
			'module_class',
			'module_id',
			'background_layout',
			'heading',
			'separator_line',
			'margin',
			'use_background',
			'background_color',
			'admin_label',
		);
		
		$this->fields_defaults = array(
			'background_layout' => array( 'light' ),
			'separator_line' 	=> array( 'on' ),
			'margin' 		   => array( 'on' ),
			'use_background' 	=> array( 'off' ),
			'background_color'  => array( '#f5f5f5', 'append_default'),
		);

		$this->custom_css_options = array(
			'pricing_menus_title' => array(
				'label'    => esc_html__( 'List Title', 'mh-composer' ),
				'selector' => 'h3.mhc_pricing_menus_title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_menus_item' => array(
				'label'    => esc_html__( 'Item', 'mh-composer' ),
				'selector' => 'ul.mhc_pricing_menus_items li',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_menus_item_title' => array(
				'label'    => esc_html__( 'Item Title', 'mh-composer' ),
				'selector' => 'h4.mhc_pricing_menus_item_title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_menus_item_highlight' => array(
				'label'    => esc_html__( 'Featured Text', 'mh-composer' ),
				'selector' => '.mhc_pricing_menus_item_highlight',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'pricing_menus_item_price' => array(
				'label'    => esc_html__( 'Additional Cell', 'mh-composer' ),
				'selector' => '.mhc_pricing_menus_item_price',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			
		);
	}
	
	function get_fields() {
		$fields = array(
			'heading' => array(
				'label'           => esc_html__( 'List Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input a title for your list.', 'mh-composer' ),
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
			'separator_line' => array(
				'label'           => esc_html__( 'Show Divider', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on' => esc_html__( 'Yes', 'mh-composer' ),
					'off'  => esc_html__( 'No', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced',
			),
			'margin' => array(
				'label'           => esc_html__( 'Show Margins', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on' => esc_html__( 'Yes', 'mh-composer' ),
					'off'  => esc_html__( 'No', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced',
			),
			'use_background' => array(
				'label'           => esc_html__( 'Use Background Colour', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_background_color',
				),
				'description' => esc_html__( 'Enable this to pick a colour below.', 'mh-composer' ),
				'tab_slug'        => 'advanced',
			),
			'background_color' => array(
				'label'           => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'Here you can define a custom background colour.', 'mh-composer' ),
				'depends_default' => true,
				'custom_color'	=> true,
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
		$heading 				  = $this->shortcode_atts['heading'];
		$separator_line 		   = $this->shortcode_atts['separator_line'];
		$margin 				  = $this->shortcode_atts['margin'];
		$background_layout 		= $this->shortcode_atts['background_layout'];
		$use_background 	= $this->shortcode_atts['use_background'];
		$background_color  = $this->shortcode_atts['background_color'];
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		if ( 'off' === $separator_line ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_pricing_menus .mhc_separator_line',
				'declaration' => 'display: none;'
			) );
		}
		if ( 'off' === $margin ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_pricing_menus .mhc_separator_line, %%order_class%%.mhc_pricing_menus ul.mhc_pricing_menus_items li',
				'declaration' => 'margin:0;'
			) );
		}
		if ( 'off' !== $use_background && '' !== $background_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_pricing_menus',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $background_color )
				),
			) );
		}
		
		$class = " mhc_module mhc_bg_layout_{$background_layout}";
		$content = do_shortcode( mhc_fix_shortcodes( $content ) );
		$output = sprintf(
			'<div%3$s class="mhc_pricing_menus clearfix mhc_pct%4$s%5$s%6$s">
			%2$s
			<ul class="mhc_pricing_menus_items">
				%1$s
				</ul>
			</div>',
			$this->shortcode_content,
			( '' !== $heading ? sprintf( '<h3 class="mhc_pricing_menus_title">%1$s</h3>', esc_attr( $heading ) ) : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ), //3
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ), //4
			esc_attr( $class ),
			( 'off' !== $use_background ? ' mhc_has_bg' : '')
		);

		return $output;
	}
}
new MHComposer_Component_Pricing_Menus;

class MHComposer_Component_Pricing_Menus_Item extends MHComposer_Component {
	function init() {
		$this->name                        = esc_html__( 'List Item', 'mh-composer' );
		$this->slug                        = 'mhc_pricing_menu';
		$this->type                        = 'child';
		$this->child_title_var             = 'title';

		$this->approved_fields = array(
			'content_new',
			'title',
			'price',
			'featured',
			'featured_color',
			'url',
			'url_new_window'
		);
		$this->fields_defaults = array(
			'featured_color' => array( mh_composer_accent_color(), 'append_default' ),
			'url_new_window' => array( 'off' )
		);
		$this->advanced_setting_title_text = esc_html__( 'New Item', 'mh-composer' );
		$this->settings_text               = esc_html__( 'Item Settings', 'mh-composer' );
	}
		
		function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'The item title.', 'mh-composer' ),
			),
			'price' => array(
				'label'           => esc_html__( 'Additional Cell', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Here you can define the timing, price, a word such as "Free” etc.', 'mh-composer' ),
			),
			'featured' => array(
				'label'           => esc_html__( 'Featured Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Featuring an item will make it stand out from the rest. Input your desired text here.', 'mh-composer' ),
			),
			'featured_color' => array(
				'label'             => esc_html__( 'Featured Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Define a custom colour for your featured table here. Note: text is white.', 'mh-composer' ),
			),
			'url' => array(
				'label'           => esc_html__( 'Link URL', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'If you want this item to be a link, input the destination URL here.', 'mh-composer' ),
			),
			'url_new_window' => array(
				'label'             => esc_html__( 'URL Opens', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'off' => esc_html__( 'In The Same Window', 'mh-composer' ),
					'on'  => esc_html__( 'In a New Tab', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose whether your link opens in a new window.', 'mh-composer' ),
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'mh-composer' ),
				'type'            => 'tiny_mce',
				'description'     => esc_html__( 'Input the description for your item here.', 'mh-composer' ),
			),
		);
		return $fields;
	}
	
	function shortcode_callback( $atts, $content = null, $function_name ) {

		$title             	 = $this->shortcode_atts['title'];
		$price            	 = $this->shortcode_atts['price'];
		$featured     		  = $this->shortcode_atts['featured'];
		$featured_color 		= $this->shortcode_atts['featured_color'];
		$url          		   = $this->shortcode_atts['url'];
		$url_new_window     	= $this->shortcode_atts['url_new_window'];

		$module_class = MHComposer_Core::add_module_order_class( '', $function_name );
		

	$href = '';
 if ( '' !== $url ) {
		$href = sprintf( 'href="%1$s"%2$s',
			esc_url( $url ),
			( 'on' === $url_new_window ? ' target="_blank"' : '' )
		);
	}
	
if ( ! empty( $featured_color )) {
		$featured_color = sprintf( ' style="background-color: %1$s;"', esc_attr( $featured_color ) );
	}
	if ( '' !== $title ){
		$title = sprintf( '<h4 class="mhc_pricing_menus_item_title">%1$s %2$s</h4>', 
		( '' !== $title ? sprintf( esc_html( $title ) ) : '' ),
		( '' !== $featured ? sprintf( '<span class="mhc_pricing_menus_item_highlight"%2$s>%1$s</span>', esc_html( $featured ), $featured_color ) : '' )//2
		);
	}
	$output = sprintf(
		'<li>%4$s
			%1$s%2$s
      <div class="clearfix"></div>
      %3$s
      %5$s<span class="mhc_separator_line"></span></li>',
		( '' !== $title ? $title  : '' ), //1
		( '' !== $price ? sprintf( '<div class="mhc_pricing_menus_item_price">%1$s</div>', esc_html( $price ) ) : '' ), //2
		sanitize_text_field( $content ), //3
		( '' !== $href ? sprintf( '<a %1$s>', $href ) : '' ), //4
		( '' !== $href ? sprintf( '</a>') : '' ) //5
	);

	return $output;
	}

}
new MHComposer_Component_Pricing_Menus_Item;