<?php
class MHComposer_Component_Image extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Image', 'mh-composer' );
		$this->slug = 'mhc_image';

		$this->approved_fields = array(
			'src',
			'alt',
			'title_text',
			'show_in_lightbox',
			'url',
			'url_new_window',
			'animation',
			'hoverfx',
			'admin_label',
			'module_id',
			'module_class',
			'sticky',
			'align',
			'image_mask',
			'border_radius',
			'force_center_on_mobile',
			'max_width',
		);

		$this->fields_defaults = array(
			'show_in_lightbox'        => array( 'off' ),
			'url_new_window'          => array( 'off' ),
			'animation'               => array( 'right' ),
			'hoverfx' 				 => array( 'none' ),
			'sticky'                  => array( 'off' ),
			'align'                   => array( 'right' ),
			'image_mask'       		  => array( 'off' ),
			'force_center_on_mobile'  => array( 'on' ),
			'border_radius'	   	   => array( '0', 'append_default' ),
		);
		$this->custom_css_options = array(
			'image' => array(
				'label'    => esc_html__( 'Image', 'mh-composer' ),
				'selector' => 'img',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			)
		);
	}

	function get_fields() {
		// List of animation options
		$animation_options = array(
			'right'   => esc_html__( 'Right To Left', 'mh-composer' ),
			'left'    => esc_html__( 'Left To Right', 'mh-composer' ),
			'top'     => esc_html__( 'Top To Bottom', 'mh-composer' ),
			'bottom'  => esc_html__( 'Bottom To Top', 'mh-composer' ),
			'scaleup' => esc_html__( 'Scale Up', 'mh-composer' ),
			'fade_in' => esc_html__( 'Fade In', 'mh-composer' ),
			'off'     => esc_html__( 'No Animation', 'mh-composer' ),
		);

		$fields = array(
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
			'show_in_lightbox' => array(
				'label'             => esc_html__( 'Lightbox', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_url',
					'#mhc_url_new_window',
				),
				'description'       => esc_html__( 'Here you can choose whether the image should open in Lightbox. Note: if you select to open the image in Lightbox, URL options below will be ignored.', 'mh-composer' ),
			),
			'url' => array(
				'label'           => esc_html__( 'Link URL', 'mh-composer' ),
				'type'            => 'text',
				'depends_show_if' => 'off',
				'description'     => esc_html__( 'If you would like your image to be a link, input your destination URL here. No link will be created if this field is left blank.', 'mh-composer' ),
			),
			'url_new_window' => array(
				'label'             => esc_html__( 'URL Opens', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'off' => esc_html__( 'In The Same Window', 'mh-composer' ),
					'on'  => esc_html__( 'In a New Tab', 'mh-composer' ),
				),
				'depends_show_if'   => 'off',
				'description'       => esc_html__( 'Here you can choose whether your link opens in a new window.', 'mh-composer' ),
			),
			'animation' => array(
				'label'             => esc_html__( 'Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $animation_options,
				'description'       => esc_html__( 'This controls the direction of the lazy-loading animation.', 'mh-composer' ),
			),
			'hoverfx' => array(
				'label'             => esc_html__( 'Mouse Effect', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'none'  	   => esc_html__( 'No Effect', 'mh-composer' ),
					'scaleup' 	=> esc_html__( 'Scale Up', 'mh-composer' ),
					'shine' 	  => esc_html__( 'Shine', 'mh-composer' ),
					'rotate' 	 => esc_html__( 'Rotate', 'mh-composer' ),
					'flash' 	  => esc_html__( 'Flash', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This controls the effect when hovering on your image.', 'mh-composer' ),
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
			'sticky' => array(
				'label'             => esc_html__( 'Remove Space Below The Image', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off'     => esc_html__( 'No', 'mh-composer' ),
					'on'      => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose whether the image should have a space below it.', 'mh-composer' ),
				'tab_slug'    => 'advanced',
			),
			'image_mask' => array(
				'label'             => esc_html__( 'Image Shape', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'off'   => esc_html__( 'Default', 'mh-composer' ),
					'circle' => esc_html__( 'Circle', 'mh-composer' ),
				),
				'affects'     => array(
					'#mhc_border_radius',
				),
				'description'       => esc_html__( 'This controls the shape of your image.', 'mh-composer' ),
				'tab_slug'    => 'advanced',
			),
			'border_radius' => array(
				'label'             => esc_html__( 'Image Radius', 'mh-composer' ),
				'type'            => 'range',
				'depends_show_if' => 'off',
				'tab_slug'        => 'advanced',
			),
			'align' => array(
				'label'           => esc_html__( 'Image Alignment', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'right'  => esc_html__( 'Right', 'mh-composer' ),
					'left'   => esc_html__( 'Left', 'mh-composer' ),
					'center' => esc_html__( 'Centre', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This controls the image alignment.', 'mh-composer' ),
				'tab_slug'    => 'advanced',
			),
			'force_center_on_mobile' => array(
				'label'             => esc_html__( 'Always Centre Image On Mobile', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( "No", 'mh-composer' ),
				),
				'tab_slug'    => 'advanced',
			),
			'max_width' => array(
				'label'           => esc_html__( 'Image Max Width', 'mh-composer' ),
				'type'            => 'text',
				'tab_slug'        => 'advanced',
				'validate_unit'   => true,
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
		$module_id               = $this->shortcode_atts['module_id'];
		$module_class         	= $this->shortcode_atts['module_class'];
		$src                     = $this->shortcode_atts['src'];
		$alt                     = $this->shortcode_atts['alt'];
		$title_text              = $this->shortcode_atts['title_text'];
		$animation               = $this->shortcode_atts['animation'];
		$hoverfx			 	 = $this->shortcode_atts['hoverfx'];
		$url                     = $this->shortcode_atts['url'];
		$url_new_window          = $this->shortcode_atts['url_new_window'];
		$show_in_lightbox        = $this->shortcode_atts['show_in_lightbox'];
		$image_mask              = $this->shortcode_atts['image_mask'];
		$sticky                  = $this->shortcode_atts['sticky'];
		$align                   = $this->shortcode_atts['align'];
		$border_radius	 	   = $this->shortcode_atts['border_radius'];
		$force_center_on_mobile  = $this->shortcode_atts['force_center_on_mobile'];
		$max_width			   = $this->shortcode_atts['max_width'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		if ( 'on' === $force_center_on_mobile ) {
			$module_class .= ' mh_force_center_on_mobile';
		}

		if ( $this->fields_defaults['align'][0] !== $align ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'text-align: %1$s;',
					esc_html( $align )
				),
			) );
		}

		if ( 'center' !== $align ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'margin-%1$s: 0;',
					esc_html( $align )
				),
			) );
		}
		
		if ( '' !== $border_radius && 'off' === $image_mask ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% img',
				'declaration' => sprintf(
					'-webkit-border-radius: %1$s; -moz-border-radius: %1$s; border-radius: %1$s;',
					esc_html( mh_composer_process_range_value( $border_radius ) )
				),
			) );
		}
		
		if ( '' !== $max_width ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'max-width: %1$s;',
					esc_html( $max_width )
				),
			) );
		}
		
		$output = sprintf(
			'<img src="%1$s" alt="%2$s"%3$s />',
			esc_url( $src ),
			esc_attr( $alt ),
			( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' )
		);

		if ( 'on' === $show_in_lightbox ) {
			$output = sprintf( '<a href="%1$s" class="mhc_lightbox_image" title="%3$s">%2$s</a>',
				esc_url( $src ),
				$output,
				esc_attr( $alt )
			);
		} else if ( '' !== $url ) {
			$output = sprintf( '<a href="%1$s"%3$s>%2$s</a>',
				esc_url( $url ),
				$output,
				( 'on' === $url_new_window ? ' target="_blank"' : '' )
			);
		}
		$class = " mhc_animation_{$animation} mhc_fx_{$hoverfx}";
		$output = sprintf(
			'<div%5$s class="mhc_module mh-waypoint mhc_image%2$s%3$s%4$s%6$s">
				%1$s
			</div>',
			$output,
			esc_attr( $class ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			( 'on' === $sticky ? esc_attr( ' mhc_image_sticky' ) : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			('off' !== $image_mask ? sprintf(' mh-mask-%1$s', esc_attr($image_mask)) : '')
		);

		return $output;
	}
}
new MHComposer_Component_Image;