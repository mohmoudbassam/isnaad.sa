<?php
class MHComposer_Component_Fullwidth_Gallery extends MHComposer_Component {
	function init() {
		$this->name       = esc_html__( 'Full-width Gallery', 'mh-composer' );
		$this->slug       = 'mhc_fullwidth_gallery';
		$this->fullwidth       = true;
		$this->main_css_selector = '%%order_class%%.mhc_fullwidth_gallery';

		$this->approved_fields = array(
			'src',
			'gallery_ids',
			'gallery_orderby',
			'show_pagination',
			'show_arrows',
			'show_in_lightbox',
			'auto',
			'auto_speed',
			'align',
			'max_height',
			'infinite_scroll',
			'pagination_style',
			'pagination_color',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'show_pagination'        => array( 'on' ),
			'show_arrows'        	=> array( 'off' ),
			'show_in_lightbox'        => array( 'off' ),
			'auto'                   => array( 'off' ),
			'auto_speed'             => array( '3000', 'append_default' ),		
			'infinite_scroll'		=> array( 'on' ),
			'pagination_style'	   => array( 'dots' ),
		);

		$this->custom_css_options = array(
			'gallery_item' => array(
				'label'    => esc_html__( 'Gallery Item', 'mh-composer' ),
				'selector' => '.mhc_gallery_item',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'gallery_active_item' => array(
				'label'    => esc_html__( 'Active Gallery Item', 'mh-composer' ),
				'selector' => '.mhc_gallery_item.is-selected',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'src' => array(
				'label' => esc_html__( 'Images', 'mh-composer' ),
				'renderer' => 'mh_composer_get_gallery_settings',
			),
			'gallery_ids' => array(
				'type' => 'hidden',
				'class' => array( 'mhc-gallery-ids-field' ),
			),
			'gallery_orderby' => array(
				'label' => esc_html__( 'Images', 'mh-composer' ),
				'type'  => 'hidden',
				'class' => array( 'mhc-gallery-ids-field' ),
			),
			'show_arrows' => array(
				'label'           => esc_html__( 'Show Arrows', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'     => esc_html__( 'This setting will turn on and off the navigation arrows.', 'mh-composer' ),
			),
			'show_pagination' => array(
				'label'             => esc_html__( 'Show Controls', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'affects' => array(
					'#mhc_pagination_style',
				),
				'description'       => esc_html__( 'This setting will turn on and off the circle buttons at the bottom.', 'mh-composer' ),
			),
			'show_in_lightbox' => array(
				'label'             => esc_html__( 'Lightbox', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose whether the image should open in Lightbox.', 'mh-composer' ),
			),
			'auto' => array(
				'label'           => esc_html__( 'Automatic Animation', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'Off', 'mh-composer' ),
					'on'  => esc_html__( 'On', 'mh-composer' ),
				),
				'affects' => array(
					'#mhc_auto_speed',
				),
				'description'       => esc_html__( 'If you would like the gallary to play automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'mh-composer' ),
			),
			'auto_speed' => array(
				'label'             => esc_html__( 'Automatic Animation Speed (in ms)', 'mh-composer' ),
				'type'              => 'text',
				'depends_default'   => true,
				'description'       => esc_html__( "Here you can adjust the rotation speed. The higher the number the longer the pause between each rotation. (Ex. 1000 = 1 sec)", 'mh-composer' ),
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
			'max_height' => array(
				'label'           => esc_html__( 'Maximum Height', 'mh-composer' ),
				'type'            => 'text',
				'tab_slug'        => 'advanced',
				'validate_unit'   => true,
				'description'     => esc_html__( 'This will change the maximum height for the slides.', 'mh-composer' ),
			),
			'infinite_scroll' => array(
				'label'           => esc_html__( 'Infinite Rotation', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'On', 'mh-composer' ),
					'off' => esc_html__( 'Off', 'mh-composer' ),
				),
				'tab_slug'          => 'advanced',
			),
			'align' => array(
				'label'           => esc_html__( 'First Item Alignment', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'center'  	 => esc_html__( 'Centre', 'mh-composer' ),
					'right' 	=> esc_html__( 'Right', 'mh-composer' ),
					'left' 	=> esc_html__( 'Left', 'mh-composer' ),
				),
				'tab_slug'          => 'advanced',
			),
			'pagination_style' => array(
				'label'           => esc_html__( 'Pagination Style', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'dots' => esc_html__( 'Dots', 'mh-composer' ),
					'lines'  => esc_html__( 'Lines', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'Define the style for the pagination.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
			),
			'pagination_color' => array(
				'label'           => esc_html__( 'Pagination Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour for the arrows and pagination.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
				'custom_color' => true,
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
		$module_id              = $this->shortcode_atts['module_id'];
		$module_class           = $this->shortcode_atts['module_class'];
		$gallery_ids            = $this->shortcode_atts['gallery_ids'];
		$gallery_orderby        = $this->shortcode_atts['gallery_orderby'];
		$show_pagination        = $this->shortcode_atts['show_pagination'];
		$show_in_lightbox       = $this->shortcode_atts['show_in_lightbox'];
		$show_arrows        	= $this->shortcode_atts['show_arrows'];
		$auto                   = $this->shortcode_atts['auto'];
		$auto_speed             = $this->shortcode_atts['auto_speed'];
		$align                  = $this->shortcode_atts['align'];
		$infinite_scroll        = $this->shortcode_atts['infinite_scroll'];
		$pagination_style	   = $this->shortcode_atts['pagination_style'];
		$pagination_color	   = $this->shortcode_atts['pagination_color'];
		$max_height             = $this->shortcode_atts['max_height'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		if ( 'lines' === $pagination_style ) {
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .flickity-page-dots .dot',
				'declaration' => 'width:30px;',
			) );
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .flickity-page-dots .dot::before',
				'declaration' => 'height:7px;',
			) );
		}
		
		if ( '' !== $pagination_color ) {
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .flickity-prev-next-button .arrow',
				'declaration' => sprintf(
					'fill:%1$s;',
				esc_html( $pagination_color ))
			) );
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .flickity-prev-next-button.no-svg',
				'declaration' => sprintf(
					'color:%1$s;',
				esc_html( $pagination_color ))
			) );
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .flickity-page-dots .dot::before',
				'declaration' => sprintf(
					'background-color:%1$s !important; opacity:0.5;',
				esc_html( $pagination_color ))
			) );
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .flickity-page-dots .dot.is-selected::before',
				'declaration' => sprintf(
					'background-color:%1$s !important; opacity:1;',
				esc_html( $pagination_color ))
			) );
		}
		if ( '' !== $max_height ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_fullwidth_gallery_items',
				'declaration' => sprintf(
					'max-height: %1$s; height: %1$s;',
					esc_html( $max_height )
				),
			) );
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_gallery_item',
				'declaration' => 'height: 100%;'
			) );
		}
		
		$attachments = array();
		if ( ! empty( $gallery_ids ) ) {
			$attachments_args = array(
				'include'        => $gallery_ids,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => 'ASC',
				'orderby'        => 'post__in',
			);

			if ( 'rand' === $gallery_orderby ) {
				$attachments_args['orderby'] = 'rand';
			}

			$_attachments = get_posts( $attachments_args );

			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		}

		if ( empty($attachments) )
			return '';
			
		wp_enqueue_script( 'flickity' );

		$module_class .= 'on' === $auto ? ' mh_slider_auto mh_slider_speed_' . esc_attr( $auto_speed ) : '';
		$module_class .= 'lines' === $pagination_style ? ' mhc_controllers_corners' : '';
		$module_class .= 'on' === $show_in_lightbox ? ' mhc_flickity_lightbox' : '';
		$output = sprintf(
			'<div%1$s class="mhc_module mhc_flickity_continer mhc_fullwidth_gallery%2$s clearfix">
				<div class="mhc_fullwidth_gallery_items mhc_flickity" data-pagination="%3$s" data-arrows="%4$s" data-auto="%5$s" data-speed="%6$s" data-align="%7$s" data-infinite="%8$s" data-setsize="%9$s">',
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			'off' !== $show_pagination  ? 'on' : 'off',
			'off' !== $show_arrows ? 'on' : 'off',
			'off' !== $auto ? 'on' : 'off',
			'' !== $auto_speed ?  esc_attr( $auto_speed ) : '7000',
			'center' !== $align ?  esc_attr( $align ) : 'center',
			'off' !== $infinite_scroll ? 'on' : 'off',
			'' !==  $max_height ? 'off' : 'on'
		);

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {

			$width = 1080;
			$width = (int) apply_filters( 'mhc_gallery_image_width', $width );

			$height = 9999;
			$height = (int) apply_filters( 'mhc_gallery_image_height', $height );
			
			list($full_src, $full_width, $full_height) = wp_get_attachment_image_src( $id, 'full' );
			list($thumb_src, $thumb_width, $thumb_height) = wp_get_attachment_image_src( $id, array( $width, $height ) );
			
			
			
			if ( 'on' === $show_in_lightbox ) {
				$image_output = sprintf(
					'<a href="%1$s" title="%2$s">
						<img src="%3$s" alt="%2$s" />
					</a>',
					esc_url( $full_src ),
					esc_attr( $attachment->post_title ),
					esc_url( $thumb_src )
				);
			}else{
				$image_output = sprintf(
					'<img src="%1$s" alt="%2$s" />',
					esc_url( $thumb_src ),
					esc_attr( $attachment->post_title )
				);
			}

			
			$orientation = ( $thumb_height > $thumb_width ) ? 'portrait' : 'landscape';
			$output .= '<div class="mhc_gallery_item">';
			$output .= "
				<div class='mhc_gallery_image {$orientation}'>
					$image_output
				</div>";
			$output .= "</div>";
		}

		$output .= "</div><!-- .mhc_gallery_items -->";
		$output .= "</div><!-- .mhc_gallery -->";

		return $output;
	}
}
new MHComposer_Component_Fullwidth_Gallery;