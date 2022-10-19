<?php
class MHComposer_Component_Gallery extends MHComposer_Component {
	function init() {
		$this->name       = esc_html__( 'Gallery', 'mh-composer' );
		$this->slug       = 'mhc_gallery';
		$this->main_css_selector = '%%order_class%%.mhc_gallery';

		$this->approved_fields = array(
			'src',
			'gallery_ids',
			'gallery_orderby',
			'fullwidth',
			'posts_number',
			'show_title_and_caption',
			'show_pagination',
			'show_arrows',
			'background_layout',
			'auto',
			'auto_speed',
			'align',
			'infinite_scroll',
			'admin_label',
			'module_id',
			'module_class',
			'overlay_icon_color',
			'overlay_color',
			'overlay_icon',
			'pagination_style',
			'pagination_color',
		);

		$this->fields_defaults = array(
			'fullwidth'              => array( 'off' ),
			'posts_number'           => array( 4, 'append_default' ),
			'show_title_and_caption' => array( 'on' ),
			'show_pagination'        => array( 'on' ),
			'show_arrows'        	=> array( 'on' ),
			'background_layout'      => array( 'light' ),
			'auto'                   => array( 'off' ),
			'auto_speed'             => array( '7000', 'append_default' ),
			'infinite_scroll'		=> array( 'on' ),
			'pagination_style'	   => array( 'dots' ),
		);

		$this->custom_css_options = array(
			'gallery_item' => array(
				'label'    => esc_html__( 'Gallery Item', 'mh-composer' ),
				'selector' => '.mhc_gallery_item',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'gallery_item_title' => array(
				'label'    => esc_html__( 'Gallery Item Title', 'mh-composer' ),
				'selector' => '.mhc_gallery_title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'gallery_overlay' => array(
				'label'    => esc_html__( 'Overlay', 'mh-composer' ),
				'selector' => '.mh_overlay',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'gallery_overlay_icon' => array(
				'label'    => esc_html__( 'Overlay Icon', 'mh-composer' ),
				'selector' => '.mh_overlay::before',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'src' => array(
				'label'           => esc_html__( 'Images', 'mh-composer' ),
				'renderer'        => 'mh_composer_get_gallery_settings',
			),
			'gallery_ids' => array(
				'type'  => 'hidden',
				'class' => array( 'mhc-gallery-ids-field' ),
			),
			'gallery_orderby' => array(
				'label' => esc_html__( 'Images', 'mh-composer' ),
				'type'  => 'hidden',
				'class' => array( 'mhc-gallery-ids-field' ),
			),
			'fullwidth' => array(
				'label'             => esc_html__( 'Layout', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'off' 		=> esc_html__( 'Grid', 'mh-composer' ),
					'on'		 => esc_html__( 'Slides', 'mh-composer' ),
					'logos'	  => esc_html__( 'Grid Logos', 'mh-composer' ),
					'carousel'   => esc_html__( 'Carousel Logos', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Toggle between the various layouts. For best results: when using "Grid Logos",  make sure your logos are in a square shape image, and when using "Carousel Logos" to have at least 5 images.', 'mh-composer' ),
				'affects'           => array(
					'#mhc_posts_number',
					'#mhc_show_title_and_caption',
					'#mhc_show_arrows',
					'#mhc_background_layout',
					'#mhc_overlay_icon_color',
					'#mhc_overlay_color',
					'#mhc_align',
					'#mhc_infinite_scroll',
					'#mhc_overlay_icon',
				),
			),
			'posts_number' => array(
				'label'             => esc_html__( 'Number of Images', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'mh-composer' ),
				'depends_show_if_not'   => 'carousel',
			),
			'show_title_and_caption' => array(
				'label'              => esc_html__( 'Show Title and Caption', 'mh-composer' ),
				'type'               => 'switch_button',
				'options'            => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'depends_show_if'   => 'off',
				'description'        => esc_html__( 'Here you can choose whether to show the images title and caption, if the image has them.', 'mh-composer' ),
			),
			'show_arrows' => array(
				'label'           => esc_html__( 'Show Arrows', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_show_if'   => 'carousel',
				'description'     => esc_html__( 'This setting will turn on and off the navigation arrows.', 'mh-composer' ),
			),
			'show_pagination' => array(
				'label'             => esc_html__( 'Pagination/Controls', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'affects' => array(
					'#mhc_pagination_style',
				),
				'description'        => esc_html__( 'Here you can define whether to show pagination.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'light'  => esc_html__( 'Dark', 'mh-composer' ),
					'dark' => esc_html__( 'Light', 'mh-composer' ),
				),
				'depends_show_if_not'   => 'carousel',
				'description'        => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
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
				'description'       => esc_html__( 'If you would like the slider to play automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired. This option will work only with "Slides" and "Carousel Logos".', 'mh-composer' ),
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
			'infinite_scroll' => array(
				'label'           => esc_html__( 'Infinite Rotation', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'On', 'mh-composer' ),
					'off' => esc_html__( 'Off', 'mh-composer' ),
				),
				'depends_show_if'   => 'carousel',
				'tab_slug'          => 'advanced',
			),
			'align' => array(
				'label'           => esc_html__( 'First Item Alignment', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'center'  => esc_html__( 'Centre', 'mh-composer' ),
					'right'   => esc_html__( 'Right', 'mh-composer' ),
					'left' 	=> esc_html__( 'Left', 'mh-composer' ),
				),
				'depends_show_if'   => 'carousel',
				'tab_slug'          => 'advanced',
			),
			'overlay_color' => array(
				'label'             => esc_html__( 'Hover Overlay Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'depends_show_if'   => 'off',
				'tab_slug'          => 'advanced',
			),
			'overlay_icon_color' => array(
				'label'             => esc_html__( 'Overlay Icon Colour', 'mh-composer' ),
				'type'              => 'color',
				'custom_color'      => true,
				'depends_show_if'   => 'off',
				'tab_slug'          => 'advanced',
			),
			'overlay_icon' => array(
				'label'               => esc_html__( 'Overlay Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_icon_list',
				'renderer_with_field' => true,
				'depends_show_if'     => 'off',
				'description'         => esc_html__( 'Select an icon to use it.', 'mh-composer' ),
				'tab_slug'            => 'advanced',
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
		$fullwidth              = $this->shortcode_atts['fullwidth'];
		$show_title_and_caption = $this->shortcode_atts['show_title_and_caption'];
		$background_layout      = $this->shortcode_atts['background_layout'];
		$posts_number           = $this->shortcode_atts['posts_number'];
		$show_pagination        = $this->shortcode_atts['show_pagination'];
		$gallery_orderby        = $this->shortcode_atts['gallery_orderby'];
		$overlay_icon_color     = $this->shortcode_atts['overlay_icon_color'];
		$overlay_color   		  = $this->shortcode_atts['overlay_color'];
		$overlay_icon           = $this->shortcode_atts['overlay_icon'];
		$auto                   = $this->shortcode_atts['auto'];
		$auto_speed             = $this->shortcode_atts['auto_speed'];
		$show_arrows        	= $this->shortcode_atts['show_arrows'];
		$align                  = $this->shortcode_atts['align'];
		$infinite_scroll        = $this->shortcode_atts['infinite_scroll'];
		$pagination_style	   = $this->shortcode_atts['pagination_style'];
		$pagination_color	   = $this->shortcode_atts['pagination_color'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		if ( 'lines' === $pagination_style ) {
			if ('carousel' === $fullwidth ){
				MHComposer_Component::set_style( $function_name, array(
					'selector'    => '%%order_class%% .flickity-page-dots .dot',
					'declaration' => 'width:30px;',
				) );
				MHComposer_Component::set_style( $function_name, array(
					'selector'    => '%%order_class%% .flickity-page-dots .dot::before',
					'declaration' => 'height:7px;',
				) );
			}else{
				MHComposer_Component::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mhc-controllers a',
					'declaration' => 'width:30px; height:7px;',
				) );
			}
		}
		
		if ( '' !== $pagination_color ) {
			if ('carousel' === $fullwidth ){
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
			}else{
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-arrow-next, %%order_class%% .mhc-arrow-prev',
				'declaration' => sprintf(
					'color:%1$s !important;',
				esc_html( $pagination_color ))
			) );
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-controllers a',
				'declaration' => sprintf(
					'background-color:%1$s !important; opacity:0.5;',
				esc_html( $pagination_color ))
			) );
			MHComposer_Component::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-controllers a.mhc-active-control',
				'declaration' => sprintf(
					'background-color:%1$s !important; opacity:1;',
				esc_html( $pagination_color ))
			) );
			}
		}

		if ( 'off' === $fullwidth && '' !== $overlay_icon_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_overlay:before',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $overlay_icon_color )
				),
			) );
		}

		if ( 'off' === $fullwidth && '' !== $overlay_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_overlay',
				'declaration' => sprintf(
					'background-color: %1$s;
					border-color: %1$s;',
					esc_html( $overlay_color )
				),
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
			
		if ( 'carousel' === $fullwidth ) {
			wp_enqueue_script( 'flickity' );
		} else {
		wp_enqueue_script( 'jquery-masonry-3' );
		wp_enqueue_script( 'hashchange' );
		}
		$gallery_class = '';
		$gallery_class .= 'on' === $fullwidth ?  ' mhc_gallery mhc_slider mhc_gallery_fullwidth' : '';
		$gallery_class .= 'off' === $fullwidth ? ' mhc_gallery mhc_gallery_grid' : '';
		$gallery_class .= 'logos' === $fullwidth ? ' mhc_gallery mhc_gallery_grid mhc_logos_grid' : '';
		$gallery_class .= 'carousel' === $fullwidth ? ' mhc_carousel_gallery mhc_flickity_continer' : '';
		$background_class = " mhc_bg_layout_{$background_layout}";

		$module_class .= 'on' === $auto && 'on' === $fullwidth ? ' mh_slider_auto mh_slider_speed_' . esc_attr( $auto_speed ) : '';
		$module_class .= 'on' === $fullwidth && 'off' === $show_pagination ? ' mhc_slider_no_pagination' : '';
		$module_class .= 'lines' === $pagination_style ? ' mhc_controllers_corners' : '';
		$data = '';
		if ( 'carousel' === $fullwidth )
			$data = sprintf(' data-pagination="%1$s" data-arrows="%2$s" data-auto="%3$s" data-speed="%4$s" data-align="%5$s" data-infinite="%6$s" data-setsize="on"',
				'off' !== $show_pagination  ? 'on' : 'off',
				'off' !== $show_arrows ? 'on' : 'off',
				'off' !== $auto ? 'on' : 'off',
				'' !== $auto_speed ?  esc_attr( $auto_speed ) : '7000',
				'center' !== $align ?  esc_attr( $align ) : 'center',
				'off' !== $infinite_scroll ? 'on' : 'off'
			);
			
		$output = sprintf(
			'<div%1$s class="mhc_module%2$s%3$s%4$s clearfix">
				%6$s
				<div class="mhc_gallery_items%7$s" data-per_page="%5$d"%8$s>',
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			esc_attr( $gallery_class ),
			'carousel' !== $fullwidth ? esc_attr( $background_class ) : '',
			esc_attr( $posts_number ),
			( 'off' === $fullwidth || 'logos' === $fullwidth ? '<div class="column_width"></div><div class="gutter_width"></div>' : '' ),
			'carousel' === $fullwidth ? ' mhc_flickity' : ' mh_post_gallery',
			$data
		);

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {

			$width = 'on' === $fullwidth ?  1080 : 400;
			$width = (int) apply_filters( 'mhc_gallery_image_width', $width );

			$height = 'on' === $fullwidth ?  9999 : 284;
			$height = (int) apply_filters( 'mhc_gallery_image_height', $height );

			list($full_src, $full_width, $full_height) = wp_get_attachment_image_src( $id, 'full' );
			list($thumb_src, $thumb_width, $thumb_height) = wp_get_attachment_image_src( $id, array( $width, $height ) );

			
		$data_icon = '' !== $overlay_icon
		? sprintf(
			' data-icon="%1$s"',
			esc_attr( mhc_process_font_icon( $overlay_icon, "mhc_font_mhicons_icon_symbols" ) )
		)
		: '';

		if ('logos' === $fullwidth || 'carousel' === $fullwidth){
				$image_output = sprintf(
					'<img src="%2$s" alt="%1$s" />',
					esc_attr( $attachment->post_title ),
					'logos' === $fullwidth ? esc_url( $full_src ) : esc_url( $thumb_src )
				);
		 }else{
				$image_output = sprintf(
					'<a href="%1$s" title="%2$s">
						<img src="%3$s" alt="%2$s" /><span class="mh_overlay%4$s"%5$s></span>
					</a>',
					esc_url( $full_src ),
					esc_attr( $attachment->post_title ),
					esc_url( $thumb_src ),
					( '' !== $data_icon ? ' mhc_data_icon' : '' ),
					$data_icon
				);
		 }
			$orientation = ( $thumb_height > $thumb_width ) ? 'portrait' : 'landscape';

			$output .= sprintf(
				'<div class="mhc_gallery_item%2$s%1$s">',
				esc_attr( $background_class ),
				( 'on' !== $fullwidth ? ' mhc_grid_item' : '' )
			);
			$output .= "
				<div class='mhc_gallery_image {$orientation}'>
					$image_output
				</div>";

			if ( 'off' === $fullwidth && 'on' === $show_title_and_caption ) {
				if ( trim($attachment->post_title) ) {
					$output .= "
						<h3 class='mhc_gallery_title'>
						" . wptexturize($attachment->post_title) . "
						</h3>";
				}
				if ( trim($attachment->post_excerpt) ) {
				$output .= "
						<p class='mhc_gallery_caption'>
						" . wptexturize($attachment->post_excerpt) . "
						</p>";
				}
			}
			$output .= "</div>";
		}

		$output .= "</div><!-- .mhc_gallery_items -->";

		if ( 'on' !== $fullwidth && 'on' === $show_pagination ) {
			$output .= "<div class='mhc_gallery_pagination'></div>";
		}

		$output .= "</div><!-- .mhc_gallery -->";

		return $output;
	}
}
new MHComposer_Component_Gallery;