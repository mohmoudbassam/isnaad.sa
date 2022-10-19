<?php
class MHComposer_Component_Fullwidth_Poster extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Full-width Poster', 'mh-composer' );
		$this->slug            = 'mhc_fullwidth_texton';
		$this->fullwidth       = true;
		$this->main_css_selector = '%%order_class%%.mhc_texton';
		
		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'heading',
			'sub_heading',
			'src',
			'alt',
			'title_text',
			'animation',
			'text_color',
			'text_placement',
			'text_size',
			'hoverfx',
			'url',
			'url_new_window',
			'background_color',
			'sticky',
			'text_shadow',
			'use_button',
			'button',
			'button_color',
			'button_text_color',
			'button_style',
			'wide_button',
			'content_new',
		);
				
		$this->fields_defaults = array(
			'animation' 		       => array( 'right' ),
			'text_color' 			  => array( '#ffffff', 'append_default' ),
			'text_placement' 		  => array( 'right_bottom' ),
			'text_size' 			   => array( 'xl' ),
			'hoverfx' 				 => array( 'scaleup' ),
			'url_new_window' 		  => array( 'off' ),
			'background_color' 		=> array( '#121212', 'append_default' ),
			'sticky' 				  => array( 'off' ),
			'use_button' 			  => array( 'off' ),
			'button_color' 			=> array( mh_composer_accent_color(), 'append_default' ),
			'button_text_color' 	   => array( '#ffffff', 'append_default' ),
			'button_style' 			=> array( 'off' ),
			'wide_button' 			 => array( 'off' ),
			'text_shadow' 			 => array( 'off' ),
		);

		$this->custom_css_options = array(
			'texton_image' => array(
				'label'    => esc_html__( 'Image', 'mh-composer' ),
				'selector' => '.mhc_texton_image',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'texton_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => 'h3.mhc_texton_title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'texton_subtitle' => array(
				'label'    => esc_html__( 'Subheading Text', 'mh-composer' ),
				'selector' => 'h4.mhc_texton_subtitle',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'texton_button' => array(
				'label'    => esc_html__( 'Button', 'mh-composer' ),
				'selector' => '.texton-button',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}
	
	function get_fields() {
		// List of animation options
		$animation_options_list = array(
			'right'   => esc_html__( 'Right To Left', 'mh-composer' ),
			'left'    => esc_html__( 'Left To Right', 'mh-composer' ),
			'top'     => esc_html__( 'Top To Bottom', 'mh-composer' ),
			'bottom'  => esc_html__( 'Bottom To Top', 'mh-composer' ),
			'scaleup' => esc_html__( 'Scale Up', 'mh-composer' ),
			'fade_in' => esc_html__( 'Fade In', 'mh-composer' ),
			'off'     => esc_html__( 'No Animation', 'mh-composer' ),
		);
		
		
		$fields = array(
			'heading' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define a title to show on your poster image.', 'mh-composer' ),
			),
			'sub_heading' => array(
				'label'           => esc_html__( 'Subheading Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'If you would like to use a subheading, add it here.', 'mh-composer' ),
			),
			'text_placement' => array(
				'label'             => esc_html__( 'Titles Position', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'right_bottom'	 => esc_html__( 'Bottom Right', 'mh-composer' ),
					'center_bottom' 	=> esc_html__( 'Bottom Centre', 'mh-composer' ),
					'left_bottom'	  => esc_html__( 'Bottom Left', 'mh-composer' ),
					'right_top'		=> esc_html__( 'Top Right', 'mh-composer' ),
					'center_top'	   => esc_html__( 'Top Centre', 'mh-composer' ),
					'left_top'		 => esc_html__( 'Top Left', 'mh-composer' ),
					'middle'		   => esc_html__( 'Centre', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Define the position for your titles.', 'mh-composer' ),
			),
			'text_size' => array(
				'label'             => esc_html__( 'Text Size', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'xl'	=> esc_html__( 'Large', 'mh-composer' ),
					'med'   => esc_html__( 'Medium', 'mh-composer' ),
					'small' => esc_html__( 'Small', 'mh-composer' ),
					'xxl'   => esc_html__( 'X Large', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Define the size of your titles, depends on the amount of your text and size of your image.', 'mh-composer' ),
			),
			'text_color' => array(
				'label'             => esc_html__( 'Titles Colour', 'mh-composer' ),
				'type'              => 'color',
				'description'       => esc_html__( 'Define a custom colour for your titles, or leave blank to use the default colour.', 'mh-composer' ),
			),
			'src' => array(
				'label'              => esc_html__( 'Image URL', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Image', 'mh-composer' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'mh-composer' ),
			),
			'alt' => array(
				'label'           => esc_html__( 'Image Alternative Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'mh-composer' ),
			),
			'title_text' => array(
				'label'           => esc_html__( 'Image Title Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'This defines the HTML Title text.', 'mh-composer' ),
			),
			'url' => array(
				'label'           => esc_html__( 'Link URL', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'If you would like your image to be a link, input your destination URL here. No link will be created if this field is left blank.', 'mh-composer' ),
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
			'animation' => array(
				'label'             => esc_html__( 'Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $animation_options_list,
				'description'       => esc_html__( 'This controls the direction of the lazy-loading animation.', 'mh-composer' ),
			),
			'hoverfx' => array(
				'label'             => esc_html__( 'Mouse Effect', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'scaleup' 	=> esc_html__( 'Scale Up', 'mh-composer' ),
					'shine' 	  => esc_html__( 'Shine', 'mh-composer' ),
					'color'  	  => esc_html__( 'Overlay Colour', 'mh-composer' ),
					'reverse' 	=> esc_html__( 'Reverse Overlay Colour', 'mh-composer' ),
					'flash' 	  => esc_html__( 'Flash Overlay Colour', 'mh-composer' ),
					'reveal'		=> esc_html__( 'Reveal Text', 'mh-composer' ),
					'none'  	   => esc_html__( 'No Effect', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This controls the effect when hovering on your poster.', 'mh-composer' ),
			),
			'background_color' => array(
				'label'             => esc_html__( 'Overlay Colour', 'mh-composer' ),
				'type'              => 'color',
				'description'       => esc_html__( 'Define a custom colour for your overlay effects.', 'mh-composer' ),
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'mh-composer' ),
				'type'            => 'tiny_mce',
				'description'     => esc_html__( 'Input the main text content for your component here.', 'mh-composer' ),
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
			'text_shadow' => array(
				'label'             => esc_html__( 'Text Shadow', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced',
			),
			'use_button' => array(
				'label'             => esc_html__( 'Use Button', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off'     => esc_html__( 'No', 'mh-composer' ),
					'on'      => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'     => array(
					'#mhc_button',
					'#mhc_button_style',
					'#mhc_wide_button',
				),
				'tab_slug'        => 'advanced',
			),
			'button' => array(
				'label'           => esc_html__( 'Button Text', 'mh-composer' ),
				'type'            => 'text',
				'tab_slug'        => 'advanced',
				'depends_show_if'     => 'on',
			),
			'button_style' => array(
				'label'           => esc_html__( 'Button Style', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'off' => esc_html__( 'Transparent', 'mh-composer' ),
					'on' => esc_html__( 'Solid', 'mh-composer' ),
				),
				'affects'     => array(
					'#mhc_button_color',
					'#mhc_button_text_color',
				),
				'depends_show_if'     => 'on',
				'tab_slug'        => 'advanced',
			),
			'button_color' => array(
				'label'             => esc_html__( 'Button Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_default'   => true,
				'depends_show_if'     => 'on',
				'tab_slug'        => 'advanced',
			),
			'button_text_color' => array(
				'label'             => esc_html__( 'Button Text Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_default'   => true,
				'depends_show_if'     => 'on',
				'tab_slug'        => 'advanced',
			),
			'wide_button' => array(
				'label'           => esc_html__( 'Full-width Button', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_show_if'     => 'on',
				'tab_slug'        => 'advanced',
			),
			'sticky' => array(
				'label'             => esc_html__( 'Remove Space Below The Image', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off'     => esc_html__( 'No', 'mh-composer' ),
					'on'      => esc_html__( 'Yes', 'mh-composer' ),
				),
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
		$module_id           = $this->shortcode_atts['module_id'];
		$module_class       	= $this->shortcode_atts['module_class'];
		$heading			 = $this->shortcode_atts['heading'];
		$sub_heading		 = $this->shortcode_atts['sub_heading'];
		$src				 = $this->shortcode_atts['src'];
		$alt				 = $this->shortcode_atts['alt'];
		$title_text		  = $this->shortcode_atts['title_text'];
		$animation		   = $this->shortcode_atts['animation'];
		$text_color		  = $this->shortcode_atts['text_color'];
		$text_placement	  = $this->shortcode_atts['text_placement'];
		$text_size		   = $this->shortcode_atts['text_size'];
		$hoverfx			 = $this->shortcode_atts['hoverfx'];
		$url				 = $this->shortcode_atts['url'];
		$url_new_window	  = $this->shortcode_atts['url_new_window'];
		$background_color	= $this->shortcode_atts['background_color'];
		$sticky			  = $this->shortcode_atts['sticky'];
		$module_id    	   = $this->shortcode_atts['module_id'];
		$module_class 		= $this->shortcode_atts['module_class'];
		$text_shadow		 = $this->shortcode_atts['text_shadow'];
		$use_button		  = $this->shortcode_atts['use_button'];
		$button			  = $this->shortcode_atts['button'];
		$button_color		= $this->shortcode_atts['button_color'];
		$button_text_color   = $this->shortcode_atts['button_text_color'];
		$button_style		= $this->shortcode_atts['button_style'];
		$wide_button		 = $this->shortcode_atts['wide_button'];
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		$content = $this->shortcode_content;
		
		if ( '' !== $text_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_texton .mhc_texton_heading',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $text_color )
				),
			) );
		}
		
		if ( 'off' !== $use_button && '' !== $button && 'on' === $button_style) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_texton .texton-button',
				'declaration' => sprintf(
					'background-color: %1$s; border-color:%1$s; color:%2$s;',
					esc_attr( $button_color ), 
					esc_attr( $button_text_color )
				),
			) );
		}
		
		if ( '' !== $background_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_texton',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $background_color )
				),
			) );
		}
		
		$url_output = $heading_output = '';
		if ( '' !== $url ) {
			$url_output = sprintf( 'href="%1$s"%2$s',
				esc_url( $url ),
				( 'on' === $url_new_window ? ' target="_blank"' : '' )
			);
		}

	if ( '' !== $heading || '' !== $sub_heading || '' !== $content || '' !== $button) {
			$heading_output = sprintf(
			'<div class="mhc_texton_heading%3$s%4$s%5$s">
			%1$s
			%2$s
			%6$s
			%7$s
			</div>',
			( '' !== $sub_heading ? sprintf( '<h4 class="mhc_texton_subtitle">%1$s</h4>', esc_attr( $sub_heading) ) : '' ),
			( '' !== $heading ? sprintf( '<h3 class="mhc_texton_title">%1$s</h3>', esc_attr( $heading) ) : '' ),
			( 'on' === $text_shadow ? esc_attr( ' mhc_texton_shadow' ) : '' ),
			esc_attr( " mhc_texton_place_{$text_placement}" ),
			esc_attr( " mhc_texton_size_{$text_size}" ),
			$content,
			( 'off' !== $use_button && '' !== $button ? sprintf( '<div class="texton-button mhc_promo_button%2$s%3$s">%1$s</div>',
		esc_attr( $button ), 
		( 'on' === $button_style
			? sprintf( ' mhc_solidify')
			: ' mhc_transify'
		),    
		('off' !== $wide_button ? ' mhc_button_fullwidth' : '')
		) : '')
			);
		}
	$class = " mhc_animation_{$animation} mhc_fx_{$hoverfx}";
	$output = sprintf(
		'<div%1$s class="mh-waypoint mhc_texton%2$s%3$s%4$s">
		%5$s
		%7$s
		<img class="mhc_texton_image" src="%8$s" alt="%9$s"%10$s />
		%6$s
		</div>',
		( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
		( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
		( 'on' === $sticky ? esc_attr( ' mhc_image_sticky' ) : '' ),
		esc_attr( $class ),
		( '' !== $url_output ? sprintf( '<a %1$s>', $url_output ) : '' ),
		( '' !== $url_output ? sprintf( '</a>') : '' ),
		( '' !== $heading_output ? $heading_output : '' ),
		esc_url( $src ),
		esc_attr( $alt ),
		( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' )
	);
	
	return $output;
	
	}
}
new MHComposer_Component_Fullwidth_Poster;