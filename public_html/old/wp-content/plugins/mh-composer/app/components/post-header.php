<?php
class MHComposer_Component_Post_Header extends MHComposer_Component {
	function init() {
		$this->name             = esc_html__( 'Post Header', 'mh-composer' );
		$this->slug             = 'mhc_post_header';
		$this->main_css_selector = '%%order_class%%.mhc_post_header';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'title',
			'meta',
			'avatar',
			'author',
			'date',
			'date_format',
			'categories',
			'comments',
			'views',
			'featured_image',
			'featured_placement',
			'text_orientation',
			'text_color',
			'text_background',
			'text_bg_color',
			'bg_color',
			'custom_paddings',
			'text_shadow',
			'overlay',
			'size',
			'title_bold',
			'parallax',
			'parallax_method',
			'animation',
		);

		$this->fields_defaults = array(
			'title'              => array( 'on' ),
			'meta'               => array( 'on' ),
			'author'             => array( 'on' ),
			'avatar' 	   	  	 => array( 'on' ),
			'date'               => array( 'on' ),
			'date_format'        => array( 'd/m/Y', 'append_default' ),
			'categories'         => array( 'on' ),
			'comments'           => array( 'off' ),
			'views'           	  => array( 'off' ),
			'featured_image'     => array( 'on' ),
			'featured_placement' => array( 'below' ),
			'parallax'           => array( 'off' ),
			'parallax_method'    => array( 'off' ),
			'animation'          => array( 'off' ),
			'custom_paddings'    => array( '40', 'append_default' ),
			'text_orientation'   => array( 'right' ),
			'text_color'         => array( 'dark' ),
			'text_background'    => array( 'off' ),
			'text_bg_color'      => array( '#ffffff', 'append_default' ),
			'text_shadow' 		=> array( 'off' ),
			'overlay' 			=> array( 'on' ),
			'title_bold' 		 => array( 'off'),
			'size' 		 	   => array( '26', 'append_default'),
		);

		$this->custom_css_options = array(
			'post_header_image_conatainer' => array(
				'label'    => esc_html__( 'Image Container', 'mh-composer' ),
				'selector' => '.mhc_title_featured_container',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'post_header_image_conatainer' => array(
				'label'    => esc_html__( 'Image', 'mh-composer' ),
				'selector' => '.mhc_title_featured_container img',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'post_header_title_container' => array(
				'label'    => esc_html__( 'Title Container', 'mh-composer' ),
				'selector' => '.mhc_title_container',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'post_header_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => '.mhc_title_container h1',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'post_header_meta' => array(
				'label'    => esc_html__( 'Post Meta', 'mh-composer' ),
				'selector' => '.mhc_title_meta_container',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$animation_options = array(
			'off'      	 => esc_html__( 'No Animation', 'mh-composer' ),
			'fade_in'  	 => esc_html__( 'Fade In', 'mh-composer' ),
			'bouncein'	=> esc_html__( 'Bouncing', 'mh-composer' ),
			'scrollout'   => esc_html__( 'Fade Out on Scroll', 'mh-composer' ),
			'top'      	 => esc_html__( 'Top To Bottom', 'mh-composer' ),
			'bottom'   	  => esc_html__( 'Bottom To Top', 'mh-composer' ),
		);
		
		$fields = array(
			'title' => array(
				'label'             => esc_html__( 'Show Title', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_animation',
				),
				'description'       => esc_html__( 'Here you can choose whether or not display the Post Title', 'mh-composer' ),
			),
			'meta' => array(
				'label'             => esc_html__( 'Show Meta', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_author',
					'#mhc_avatar',
					'#mhc_date',
					'#mhc_categories',
					'#mhc_comments',
					'#mhc_views',
				),
				'description'       => esc_html__( 'Here you can choose whether or not display the Post Meta', 'mh-composer' ),
			),
			'avatar' => array(
				'label'             => esc_html__( 'Show Author Avatar', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'description'        => esc_html__( 'Here you can define whether to show the author avatar.', 'mh-composer' ),
			),
			'author' => array(
				'label'             => esc_html__( 'Show Author', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'Here you can choose whether or not display the Author Name in Post Meta', 'mh-composer' ),
			),
			'date' => array(
				'label'             => esc_html__( 'Show Date', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'affects'           => array(
					'#mhc_date_format'
				),
				'description'   => esc_html__( 'Here you can choose whether or not display the Date in Post Meta', 'mh-composer' ),
			),

			'date_format' => array(
				'label'             => esc_html__( 'Date Format', 'mh-composer' ),
				'type'              => 'text',
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'mh-composer' ),
			),
			'categories' => array(
				'label'             => esc_html__( 'Show Categories', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'Here you can define whether to show categories links. Note: This option works only with posts.', 'mh-composer' ),
			),
			'comments' => array(
				'label'             => esc_html__( 'Show Comments Count', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'Here you can choose whether or not display the Comments Count.', 'mh-composer' ),
			),
			'views' => array(
				'label'             => esc_html__( 'Show Views Count', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'description'        => esc_html__( 'Here you can define whether to show Views Count. For this option to work you must have "WP-PostViews" plugin installed and activated.', 'mh-composer' ),
			),
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options_no_just(),
				'description'       => esc_html__( 'Here you can choose the orientation for the Title/Meta text', 'mh-composer' ),
			),
			'text_color' => array(
				'label'             => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'dark'  => esc_html__( 'Dark', 'mh-composer' ),
					'light' => esc_html__( 'Light', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose the colour for the Title/Meta text', 'mh-composer' ),
			),
			'featured_image' => array(
				'label'             => esc_html__( 'Featured Image', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_featured_placement',
				),
				'description'      => esc_html__( 'Here you can choose whether or not display the Featured Image', 'mh-composer' ),
			),
			'featured_placement' => array(
				'label'             => esc_html__( 'Featured Image Placement', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'below'      => esc_html__( 'Below Title', 'mh-composer' ),
					'above'      => esc_html__( 'Above Title', 'mh-composer' ),
					'background' => esc_html__( 'Background Image', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'affects'           => array(
					//'#mhc_meta_placement',
					'#mhc_custom_paddings',
					'#mhc_text_shadow',
					'#mhc_overlay',
					'#mhc_text_background',
					'#mhc_parallax',
				),
				'description'       => esc_html__( 'Here you can choose where to place the Featured Image.', 'mh-composer' ),
			),
			'parallax' => array(
				'label'           => esc_html__( 'Parallax Effect', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_parallax_method'
				),
				'depends_show_if'   => 'background',
				'description'        => esc_html__( 'If enabled, your background image will stay fixed as your scroll, creating a parallax-like effect.', 'mh-composer' ),
			),
			'parallax_method' => array(
				'label'           => esc_html__( 'Parallax Method', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'off' => esc_html__( 'CSS Parallax', 'mh-composer' ),
					'on'  => esc_html__( 'JQuery Parallax', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'Define the method, used for the parallax effect.', 'mh-composer' ),
			),
			'animation' => array(
				'label'             => esc_html__( 'Title Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $animation_options,
				'description'       => esc_html__( 'This controls the title animation.', 'mh-composer' ),
				'depends_show_if'   => 'on',
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
				'tab_slug' => 'advanced',
			),
			'module_class' => array(
				'label'           => esc_html__( '{CSS Class}', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-composer' ),
				'tab_slug' => 'advanced',
			),
			'bg_color' => array(
				'label'    => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'     => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'        => 'advanced',
			),
			'custom_paddings' => array(
				'label'           => esc_html__( 'Featured Image Padding', 'mh-composer' ),
				'type'            => 'range',
				'default' => '40',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'depends_show_if'   => 'background',
				'tab_slug'        => 'advanced',
			),
			'size' => array(
				'label'           => esc_html__( 'Title Size', 'mh-composer' ),
				'type'            => 'range',
				'default' => '26',
				'validate_unit'   => true,
				'range_settings' => array(
					'min'  => '10',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'        => 'advanced',
			),
			'title_bold' => array(
				'label'           => esc_html__( 'Bold Title', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'tab_slug'        => 'advanced',
			),
			'text_shadow' => array(
				'label'             => esc_html__( 'Text Shadow', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_show_if'   => 'background',
				'tab_slug' => 'advanced',
			),
			'text_background' => array(
				'label'             => esc_html__( 'Use Text Background Colour', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_text_bg_color',
				),
				'depends_show_if'   => 'background',
				'tab_slug' => 'advanced',
			),
			'text_bg_color' => array(
				'label'             => esc_html__( 'Text Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'depends_default'   => true,
				'custom_color'	  => true,
				'tab_slug' => 'advanced',
			),
			'overlay' => array(
				'label'             => esc_html__( 'Image Overlay', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'depends_show_if'   => 'background',
				'tab_slug' => 'advanced',
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
		$module_id          = $this->shortcode_atts['module_id'];
		$module_class       = $this->shortcode_atts['module_class'];
		$title              = $this->shortcode_atts['title'];
		$meta               = $this->shortcode_atts['meta'];
		$author             = $this->shortcode_atts['author'];
		$avatar             = $this->shortcode_atts['avatar'];
		$date               = $this->shortcode_atts['date'];
		$date_format        = $this->shortcode_atts['date_format'];
		$categories         = $this->shortcode_atts['categories'];
		$comments           = $this->shortcode_atts['comments'];
		$views          	  = $this->shortcode_atts['views'];
		$featured_image     = $this->shortcode_atts['featured_image'];
		$featured_placement = $this->shortcode_atts['featured_placement'];
		$custom_paddings 	= $this->shortcode_atts['custom_paddings'];
		$text_orientation   = $this->shortcode_atts['text_orientation'];
		$text_color         = $this->shortcode_atts['text_color'];
		$text_background    = $this->shortcode_atts['text_background'];
		$text_bg_color      = $this->shortcode_atts['text_bg_color'];
		$bg_color    	   = $this->shortcode_atts['bg_color'];
		$text_shadow		= $this->shortcode_atts['text_shadow'];
		$size               = $this->shortcode_atts['size'];
		$title_bold 		 = $this->shortcode_atts['title_bold'];
		$overlay     		= $this->shortcode_atts['overlay'];
		$parallax           = $this->shortcode_atts['parallax'];
		$parallax_method 	= $this->shortcode_atts['parallax_method'];
		$animation          = $this->shortcode_atts['animation'];

		// display the shortcode only on singlular pages
		if ( ! is_singular() ) {
			return;
		}

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$output = '';
		$featured_image_output = '';

		if ( 'on' === $featured_image && ( 'above' === $featured_placement || 'below' === $featured_placement ) ) {
			$featured_image_output = sprintf( '<div class="mhc_title_featured_container">%1$s</div>',
				get_the_post_thumbnail( get_the_ID(), 'large' )
			);
		}

		if ( 'on' === $title ) {
			if ( is_mhc_preview() && isset( $_POST['post_title'] ) && wp_verify_nonce( $_POST['mhc_preview_nonce'], 'mhc_preview_nonce' ) ) {
				$post_title = sanitize_text_field( wp_unslash( $_POST['post_title'] ) );
			} else {
				$post_title = get_the_title();
			}

			$output .= sprintf( '<h1 class="entry-title">%s</h1>',
				$post_title
			);
		}

		if ( 'on' === $meta ) {
			$meta_array = array();
			foreach( array( 'avatar', 'author', 'date', 'categories', 'comments', 'views' ) as $single_meta ) {
				if ( 'on' === $$single_meta && ( 'categories' !== $single_meta || ( 'categories' === $single_meta && is_singular( 'post' ) ) ) ) {
					 $meta_array[] = $single_meta;
				}
			}
			
			$output .= sprintf( '<div class="mhc_title_meta_container post-meta post-meta-alt">%1$s</div>',
				mhc_postinfo_meta( $meta_array, $date_format, esc_html__( '0 comments', 'mh-composer' ), esc_html__( '1 comment', 'mh-composer' ), '% ' . esc_html__( 'comments', 'mh-composer' ) )
			);
		}
		
		$featured_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		//parallax image
		if ( 'on' === $featured_image && 'background' === $featured_placement) {
			$featured_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
			
			if ('on' === $parallax){
				 MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_parallax_bg',
					'declaration' => sprintf( 'background-image:url(%1$s);', 
					esc_url( $featured_image_src[0] )
					 ),
				) );
			} else {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => sprintf(
						'background-image: url("%1$s");',
						esc_url( $featured_image_src[0] )
					),
				) );
			}
		}

		if ( 'on' === $text_background && 'on' === $featured_image && 'background' === $featured_placement ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_title_container',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $text_bg_color )
				),
			) );
		}
		
		if ( 'on' !== $title ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_title_container',
				'declaration' => 'padding-top: 15px;'
			) );
		}
		
		if ('on' === $featured_image && 'background' === $featured_placement && ('' !== $custom_paddings || '40' !== $custom_paddings) ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_featured_bg',
				'declaration' => sprintf(
					'padding:%1$s%2$s 8%2$s;',
					esc_html( $custom_paddings / 2 ),
					'%'
				),
			) );
		}

		MHComposer_Core::set_style( $function_name, array(
			'selector'    => '%%order_class%%',
			'declaration' => sprintf(
				'text-align: %1$s;',
				esc_html( $text_orientation )
			),
		) );
		
		if ( '26' !== $size || '' !== $size) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_title_container h1',
				'declaration' => sprintf(
					'font-size: %1$s;',
					esc_attr( $size )
				),
			) );
		}
		
		if ( 'off' !== $title_bold ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_title_container h1',
				'declaration' => 'font-weight:bold'
			) );
		}
		MHComposer_Core::set_style( $function_name, array(
			'selector'    => '%%order_class%%',
			'declaration' => sprintf(
				'background-color: %1$s;',
				esc_html( $bg_color )
			),
		) );
		
		$background_layout = 'dark' === $text_color ? 'light' : 'dark';
		$class = " mhc_bg_layout_{$background_layout} mhc_image_{$featured_placement}";
		$output = sprintf(
			'<div%3$s class="mhc_module mhc_post_header %2$s%4$s%8$s%9$s%11$s">
			%10$s
				%5$s
				<div class="mhc_title_container%7$s%12$s%13$s">
					%1$s
				</div>
				%6$s
			</div>',
			$output,
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			'on' === $featured_image && 'background' === $featured_placement ? ' mhc_featured_bg' : '',
			'on' === $featured_image && 'above' === $featured_placement ? $featured_image_output : '',
			'on' === $featured_image && 'below' === $featured_placement ? $featured_image_output : '',
			'on' === $featured_image && 'background' === $featured_placement && 'on' === $text_shadow ?  ' mhc_title_shadow' : '',
			'on' === $featured_image && 'background' === $featured_placement && 'on' === $overlay ?  ' mhc_overlay_shadow' : '',
			esc_attr( $class ),
			( 'on' === $featured_image && 'background' === $featured_placement && 'on' === $parallax
				? sprintf( '<div class="mh_parallax_bg%1$s"></div>',
				( 'off' === $parallax_method ? ' mhc_parallax_css' : '' ) ) : '' ),
			( 'off' !== $parallax ? ' mhc_section_parallax' : '' ),
			'scrollout' !== $animation ? esc_attr( " mh-waypoint mhc_animation_{$animation}" ) : ' mhc_animation_scrollout',
			'on' === $text_background ? ' mhc_title_container_has_bg' : ''
		);

		return $output;
	}
}
new MHComposer_Component_Post_Header;