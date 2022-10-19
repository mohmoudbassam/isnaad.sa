<?php
class MHComposer_Section extends MHComposer_Structure_Element {
	function init() {
		$this->name = esc_html__( 'Section', 'mh-composer' );
		$this->slug = 'mhc_section';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'background_image',
			'background_color',
			'gradient_background',
			'gradient_style',
			'background_color_second',
			'background_video_mp4',
			'background_video_webm',
			'background_video_width',
			'background_video_height',
			'inner_shadow',
			'parallax',
			'parallax_method',
			'fullwidth',
			'specialty',
			'transparent_background',
			'transparent_image',
			'video_pause',
			'separator_top',
			'separator_bottom',
			//advanced
			'allow_advanced_padding',
			'remove_padding',
			'force_fullwidth',
			'column_paddings',
			'column_match_heights',
		);

		$this->fields_defaults = array(
			'gradient_background' 	=> array( 'off' ),
			'gradient_style' 		 => array( 'horizontal' ),
			'inner_shadow'           => array( 'off' ),
			'parallax'               => array( 'off' ),
			'parallax_method'        => array( 'off' ),
			'transparent_background' => array( 'off' ),
			'video_pause'     		=> array( 'off' ),
			'separator_top' 		  => array( 'off' ),
			'separator_bottom' 	   => array( 'off' ),
			'fullwidth'              => array( 'off' ),
			'specialty'              => array( 'off' ),
			'allow_advanced_padding' => array( 'off' ),
			'remove_padding' 		 => array( 'off' ),
			'force_fullwidth' 		=> array( 'off' ),
			'column_paddings' 		=> array( 'padding-3pct' ),
			'column_match_heights'   => array( 'off' ),
		);
	}


	function get_fields() {
		$fields = array(
			'background_image' => array(
				'label'              => esc_html__( 'Background Image', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Background Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Background', 'mh-composer' ),
				'description'        => esc_html__( 'If defined, this image will be used as a background. To remove a background image, simply delete the URL from the settings field.', 'mh-composer' ),
			),
			'transparent_background' => array(
				'label'             => esc_html__( 'Transparent Background Colour', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_transparent_image',
					'#mhc_separator_top',
					'#mhc_separator_bottom',
				),
				'description'       => esc_html__( 'Switch on this option if you want the background image to be transparent.', 'mh-composer' ),
			),
			'transparent_image' => array(
				'label'           => esc_html__( 'Transparent Image', 'mh-composer' ),
				'type'            => 'range',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '99',
					'step' => '1',
				),
				'depends_show_if'   => 'on',
				'description'     => esc_html__( 'This will change the opacity of your image.', 'mh-composer' ),
			),
			'gradient_background' => array(
				'label'             => esc_html__( 'Gradient Background', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_gradient_style',
					'#mhc_background_color_second',
				),
				'description'       => esc_html__( 'Switch on this option if you want a gradient background colour for this section.', 'mh-composer' ),
			),
			'background_color' => array(
				'label'           => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'            => 'color-alpha',
				'default'         => '#ffffff',
				'description'     => esc_html__( 'Define a custom background colour for your component, or leave blank to use the default colour.', 'mh-composer' ),
			),
			'background_color_second' => array(
				'label'           => esc_html__( 'Gradient Colour', 'mh-composer' ),
				'type'            => 'color-alpha',
				'depends_show_if' => 'on',
				'description'     => esc_html__( 'Define a custom gradient colour for your section.', 'mh-composer' ),
			),
			'gradient_style' => array(
				'label'             => esc_html__( 'Gradient Style', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'horizontal' => esc_html__( 'Horizontal', 'mh-composer' ),
					'vertical'  => esc_html__( 'Vertical', 'mh-composer' ),
					'diagonal_top'  => esc_html__( 'Diagonal Top', 'mh-composer' ),
					'diagonal_bottom'  => esc_html__( 'Diagonal Bottom', 'mh-composer' ),
					'radial'  => esc_html__( 'Radial', 'mh-composer' ),
				),
				'depends_show_if' => 'on',
				'description'       => esc_html__( 'This controls the style of the gradient colour.', 'mh-composer' ),
			),
			'inner_shadow' => array(
				'label'           => esc_html__( 'Inner Shadow', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can select whether your section has an inner shadow.', 'mh-composer' ),
			),
			'parallax' => array(
				'label'             => esc_html__( 'Parallax Effect', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_parallax_method',
				),
				'description'       => esc_html__( 'If enabled, your background image will stay fixed as your scroll, creating a parallax-like effect.', 'mh-composer' ),
			),
			'parallax_method' => array(
				'label'             => esc_html__( 'Parallax Method', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'off'  => esc_html__( 'CSS Parallax', 'mh-composer' ),
					'on'   => esc_html__( 'JQuery Parallax', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'Define the method, used for the parallax effect.', 'mh-composer' ),
			),
			'background_video_mp4' => array(
				'label'              => esc_html__( 'Background Video MP4', 'mh-composer' ),
				'type'               => 'upload',
				'data_type'          => 'video',
				'upload_button_text' => esc_attr__( 'Upload a video', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Background Video MP4 File', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Background Video', 'mh-composer' ),
				'description'        => mh_wp_kses( __( 'All videos should be uploaded in both .MP4 and .WEBM formats to ensure maximum compatibility in all browsers. Upload the .MP4 version here. <b>Important Note: Video backgrounds are disabled from mobile devices. Instead, your background image will be used. For this reason, you should define both a background image and a background video to ensure best results.</b>', 'mh-composer' ) ),
			),
			'background_video_webm' => array(
				'label'              => esc_html__( 'Background Video WEBM', 'mh-composer' ),
				'type'               => 'upload',
				'data_type'          => 'video',
				'upload_button_text' => esc_attr__( 'Upload a video', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Background Video WEBM File', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Background Video', 'mh-composer' ),
				'description'        => mh_wp_kses( __( 'All videos should be uploaded in both .MP4 and .WEBM formats to ensure maximum compatibility in all browsers. Upload the .WEBM version here. <b>Important Note: Video backgrounds are disabled from mobile devices. Instead, your background image will be used. For this reason, you should define both a background image and a background video to ensure best results.</b>', 'mh-composer' ) ),
			),
			'background_video_width' => array(
				'label'           => esc_html__( 'Background Video Width', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'In order for videos to be sized correctly, you must input the exact width (in pixels) of your video here.', 'mh-composer' ),
			),
			'background_video_height' => array(
				'label'           => esc_html__( 'Background Video Height', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'In order for videos to be sized correctly, you must input the exact height (in pixels) of your video here.', 'mh-composer' ),
			),
			'video_pause' => array(
				'label'           => esc_html__( 'Pause Video', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Allow video to be paused by other players when they begin playing', 'mh-composer' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Label', 'mh-composer' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the section in the composer for easy identification when collapsed.', 'mh-composer' ),
			),
			'module_id' => array(
				'label'             => esc_html__( '{CSS ID}', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-composer' ),
				'tab_slug' => 'advanced',
			),
			'module_class' => array(
				'label'             => esc_html__( '{CSS Class}', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-composer' ),
				'tab_slug' => 'advanced',
			),
			'allow_advanced_padding' => array(
				'label'           => esc_html__( 'Advanced Paddings', 'mh-composer' ),
				'type'            => 'switch_button',
				'custom_class' => 'section_regular_only',
				'options'         => array(
					'off' => esc_html__( 'Off', 'mh-composer' ),
					'on'  => esc_html__( 'On', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_remove_padding',
					'#mhc_force_fullwidth',
				),
				'tab_slug'        => 'advanced',
				'description'       => esc_html__( 'Enable this option to show more advanced settings or disable to ignore all settings below.', 'mh-composer' ),
			),
			'remove_padding' => array(
				'label'           => esc_html__( 'Remove Paddings', 'mh-composer' ),
				'type'            => 'switch_button',
				'custom_class' => 'section_regular_only',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_default'   => true,
				'affects'           => array(
					'#mhc_column_fit_row',
					'#mhc_column_padding',
				),
				'tab_slug'        => 'advanced',
				'description'       => esc_html__( 'This option will remove all top and bottom paddings for this section and its rows. You could use the divider component to set your custom visual paddings.', 'mh-composer' ),
			),
			'force_fullwidth' => array(
				'label'           => esc_html__( 'Full-width Row', 'mh-composer' ),
				'type'            => 'switch_button',
				'custom_class' => 'section_regular_only',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_default'   => true,
				'affects'           => array(
					'#mhc_column_paddings',
					'#mhc_column_match_heights',
				),
				'tab_slug'        => 'advanced',
				'description'       => esc_html__( 'This option will extend the width of this section rows to the edge of the browser window. It will also remove all margins between columns. This is optimized for sections containing the following components: Text, Image, Gallery (Layout: Slider), Video, Poster, Blurb, Call To Action, Audio, Testimonial, Testimonials Slider.', 'mh-composer' ),
			),
			'column_paddings' => array(
				'label'           => esc_html__( 'Column Paddings', 'mh-composer' ),
				'type'            => 'select',
				'custom_class' => 'section_regular_only',
				'options'         => array(
					'padding-0pct' => '0%',
					'padding-1pct' => '1%',
					'padding-2pct' => '2%',
					'padding-3pct' => '3%',
					'padding-4pct' => '4%',
					'padding-5pct' => '5%',
					'padding-6pct' => '6%',
					'padding-7pct' => '7%',
				),
				'depends_default'   => true,
				'tab_slug'        => 'advanced',
				'description'       => esc_html__( 'Adjust column paddings. Default is (3%). This will effect the following components inside your section: Text, Blurb, Call To Action, Person Card, Social Media Icons, Number Counter, Contact Form, Contact Form 7, Comments', 'mh-composer' ),
			),
			'column_match_heights' => array(
				'label'           => esc_html__( 'Match Component Heights', 'mh-composer' ),
				'type'            => 'switch_button',
				'custom_class' => 'section_regular_only',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_default'   => true,
				'tab_slug'        => 'advanced',
				'description'       => esc_html__( 'All components within a row will match the height of its tallest component.', 'mh-composer' ),
			),
			'separator_top' => array(
				'label'           => esc_html__( 'Top Separator', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'off' 				=> esc_html__( 'Off', 'mh-composer' ),
					'diagonalright' 	  => esc_html__( 'Diagonal Right', 'mh-composer' ),
					'diagonalleft' 	   => esc_html__( 'Diagonal Left', 'mh-composer' ),
					'curve' 			  => esc_html__( 'Curve', 'mh-composer' ),
					'curve-alt' 		  => esc_html__( 'Curve Alt', 'mh-composer' ),
					'arrow' 			  => esc_html__( 'Arrow', 'mh-composer' ),
					'clouds' 			 => esc_html__( 'Clouds', 'mh-composer' ),
					'waves' 			  => esc_html__( 'Waves', 'mh-composer' ),
					'zigzag' 			 => esc_html__( 'Zigzag', 'mh-composer' ),
				),
				'depends_show_if' => 'off',
				'description'       => esc_html__( '[Beta] This Controls the Top Separator.', 'mh-composer' ) . '<br />' . esc_html__( 'Note: avoid Top Separator for the first section in a page as it will be covered by the main menu of your site.', 'mh-composer' ),
				'tab_slug' => 'advanced',
			),
			'separator_bottom' => array(
				'label'           => esc_html__( 'Bottom Separator', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'off' 				=> esc_html__( 'Off', 'mh-composer' ),
					'diagonalright' 	  => esc_html__( 'Diagonal Right', 'mh-composer' ),
					'diagonalleft' 	   => esc_html__( 'Diagonal Left', 'mh-composer' ),
					'curve' 			  => esc_html__( 'Curve', 'mh-composer' ),
					'curve-alt' 		  => esc_html__( 'Curve Alt', 'mh-composer' ),
					'arrow' 			  => esc_html__( 'Arrow', 'mh-composer' ),
					'smallarrow'		 => esc_html__( 'Small Arrow', 'mh-composer' ),
				),
				'depends_show_if' => 'off',
				'description'       => esc_html__( '[Beta] This Controls the Bottom Separator.', 'mh-composer' ) . '<br />' . esc_html__( 'Note: when using a Bottom Separator in a section and a Top Separator for the next section, one of them will override the other.', 'mh-composer' ),
				'tab_slug' => 'advanced',
			),
			'fullwidth' => array(
				'type' => 'skip',
			),
			'specialty' => array(
				'type' => 'skip',
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
		$module_class            = $this->shortcode_atts['module_class'];
		$background_image        = $this->shortcode_atts['background_image'];
		$background_color        = $this->shortcode_atts['background_color'];
		$separator_top     	   = $this->shortcode_atts['separator_top'];
		$separator_bottom     	= $this->shortcode_atts['separator_bottom'];
		$gradient_background     = $this->shortcode_atts['gradient_background'];
		$background_color_second = $this->shortcode_atts['background_color_second'];
		$gradient_style      	  = $this->shortcode_atts['gradient_style'];
		$background_video_mp4    = $this->shortcode_atts['background_video_mp4'];
		$background_video_webm   = $this->shortcode_atts['background_video_webm'];
		$background_video_width  = $this->shortcode_atts['background_video_width'];
		$background_video_height = $this->shortcode_atts['background_video_height'];
		$video_pause      		 = $this->shortcode_atts['video_pause'];
		$inner_shadow            = $this->shortcode_atts['inner_shadow'];
		$parallax                = $this->shortcode_atts['parallax'];
		$parallax_method         = $this->shortcode_atts['parallax_method'];
		$fullwidth               = $this->shortcode_atts['fullwidth'];
		$specialty               = $this->shortcode_atts['specialty'];
		$transparent_background  = $this->shortcode_atts['transparent_background'];
		$transparent_image	   = $this->shortcode_atts['transparent_image'];
		$allow_advanced_padding  = $this->shortcode_atts['allow_advanced_padding'];
		$remove_padding	  	  = $this->shortcode_atts['remove_padding'];
		$force_fullwidth	     = $this->shortcode_atts['force_fullwidth'];
		$column_paddings	     = $this->shortcode_atts['column_paddings'];
		$column_match_heights	= $this->shortcode_atts['column_match_heights'];
		$shared_module           = $this->shortcode_atts['shared_module'];

		if ( '' !== $shared_module ) {
			$shared_content = mhc_load_shared_module( $shared_module );

			if ( '' !== $shared_content ) {
				return do_shortcode( $shared_content );
			}
		}

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		if ( 'on' === $specialty ) {
			global $mhc_columns_counter;
		
			$mhc_columns_counter = 0;
		}

		$background_video = '';

		if ( '' !== $background_video_mp4 || '' !== $background_video_webm ) {
			$background_video = sprintf(
				'<div class="mhc_section_video_bg%2$s">
					%1$s
				</div>',
				do_shortcode( sprintf( '
					<video loop="loop"%3$s%4$s>
						%1$s
						%2$s
					</video>',
					( '' !== $background_video_mp4 ? sprintf( '<source type="video/mp4" src="%s" />', esc_url( $background_video_mp4 ) ) : '' ),
					( '' !== $background_video_webm ? sprintf( '<source type="video/webm" src="%s" />', esc_url( $background_video_webm ) ) : '' ),
					( '' !== $background_video_width ? sprintf( ' width="%s"', esc_attr( intval( $background_video_width ) ) ) : '' ),
					( '' !== $background_video_height ? sprintf( ' height="%s"', esc_attr( intval( $background_video_height ) ) ) : '' )
					
				) ),
				( 'on' === $video_pause ? ' mhc_video_pause' : '' )
			);

			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
		
		if ('off' !== $allow_advanced_padding && 'off' !== $remove_padding){
			MHComposer_Core::set_style( $function_name, array(
			'selector'    => '%%order_class%%',
			'declaration' => 'padding:0;',
			) );
			MHComposer_Core::set_style( $function_name, array(
			'selector'    => '%%order_class%% .mhc_row',
			'declaration' => 'padding:0;',
			) );
			MHComposer_Core::set_style( $function_name, array(
			'selector'    => '%%order_class%% .mhc_row_inner:nth-of-type(n+2)',
			'declaration' => 'padding:0;',
			) );
		}
		
		// simple background image with no paralax and no transparency
		if ( '' !== $background_image && 'on' !== $parallax && 'off' === $transparent_background ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'background-image:url(%s);',
					esc_url( $background_image )
				),
			) );
		}
		//simple parallax bg
		if ( '' !== $background_image && 'on' === $parallax) {
			 MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_parallax_bg',
				'declaration' => sprintf( 'background-image:url(%1$s);', 
				esc_url( $background_image )
				 ),
			) );
			//parallax with transparncey
			if ('off' !== $transparent_background) {
				 MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_parallax_bg',
					'declaration' => sprintf( 'opacity:%1$s; filter: alpha(opacity=%2$s);', 
					esc_attr( $transparent_image / 100  ),
					esc_attr( $transparent_image)
					 ),
				) );
			}	
		} //end parallax
		
		//simple transparent background with no parallax
		elseif( '' !== $background_image && 'on' !== $parallax && '' !== $transparent_image && 'off' !== $transparent_background) {
			 MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_transparent_bg',
				'declaration' => sprintf( 'background-image:url(%3$s); opacity:%1$s; filter: alpha(opacity=%2$s);', 
				esc_attr( $transparent_image / 100  ),
				esc_attr( $transparent_image),
				esc_url( $background_image )
				 ),
			) );
		}
		
		//simple background colour
		if ( '' !== $background_color && 'off' === $gradient_background ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_section',
				'declaration' => sprintf(
					'background-color:%s !important;',
					esc_html( $background_color )
				),
			) );
		}elseif ( 'off' !== $gradient_background  && '' !== $background_color && '' !== $background_color_second) {
		$color1 = esc_html( $background_color );
		$color2 = esc_html( $background_color_second );
		if ('horizontal' === $gradient_style){	
			MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => "background: $color1; background: -moz-linear-gradient(left, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left top, right top, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(left, $color1 0%,$color2 100%); background: -o-linear-gradient(left, $color1 0%,$color2 100%); background: -ms-linear-gradient(left, $color1 0%,$color2 100%); background: linear-gradient(to right, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
			) );
		}
			 
		if ('vertical' === $gradient_style){
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => "background: $color1; background: -moz-linear-gradient(top, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(top, $color1 0%,$color2 100%); background: -o-linear-gradient(top, $color1 0%,$color2 100%); background: -ms-linear-gradient(top, $color1 0%,$color2 100%); background: linear-gradient(to bottom, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=0 );",
			) );
		}

		if ('diagonal_top' === $gradient_style){
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => "background: $color1; background: -moz-linear-gradient(-45deg, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(-45deg, $color1 0%,$color2 100%); background: -o-linear-gradient(-45deg, $color1 0%,$color2 100%); background: -ms-linear-gradient(-45deg, $color1 0%,$color2 100%); background: linear-gradient(135deg, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
			) );
		}
			
		if ('diagonal_bottom' === $gradient_style){
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => "background: $color1; background: -moz-linear-gradient(45deg, $color1 0%, $color2 100%); background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-linear-gradient(45deg, $color1 0%,$color2 100%); background: -o-linear-gradient(45deg, $color1 0%,$color2 100%); background: -ms-linear-gradient(45deg, $color1 0%,$color2 100%); background: linear-gradient(45deg, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
			) );
		}
		
		if ('radial' === $gradient_style){
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => "background: $color1; background: -moz-radial-gradient(center, ellipse cover, $color1 0%, $color2 100%); background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,$color1), color-stop(100%,$color2)); background: -webkit-radial-gradient(center, ellipse cover, $color1 0%,$color2 100%); background: -o-radial-gradient(center, ellipse cover, $color1 0%,$color2 100%); background: -ms-radial-gradient(center, ellipse cover, $color1 0%,$color2 100%); background: radial-gradient(ellipse at center, $color1 0%,$color2 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color1', endColorstr='$color2',GradientType=1 );",
			) );
		}
			 
	} //gradient 
		
	$svg_top = $svg_bottom = '';
	if ('off' !== $separator_top){
		$svg_top = sprintf( '%1$s%2$s%3$s%4$s%5$s%6$s%7$s%8$s',
		
			('waves' === $separator_top ?  sprintf('
	<div class="separator-top"><svg xmlns="http://www.w3.org/2000/svg" width="%2$s" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" height="%2$s" class="mh-separator"><path d="M0 100 Q 2.5 40 5 100 Q 7.5 40 10 100 Q 12.5 40 15 100 Q 17.5 40 20 100 Q 22.5 40 25 100 Q 27.5 40 30 100 Q 32.5 40 35 100 Q 37.5 40 40 100 Q 42.5 40 45 100 Q 47.5 40 50 100 Q 52.5 40 55 100 Q 57.5 40 60 100 Q 62.5 40 65 100 Q 67.5 40 70 100 Q 72.5 40 75 100 Q 77.5 40 80 100 Q 82.5 40 85 100 Q 87.5 40 90 100 Q 92.5 40 95 100 Q 97.5 40 100 100" stroke-width="0" fill="%1$s" stroke="%1$s"></path></svg></div>', 
			esc_attr($background_color),
			'100%' ) : ''),
			
			('zigzag' === $separator_top ?  sprintf('
<div class="separator-top"><svg xmlns="http://www.w3.org/2000/svg" width="%2$s" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" height="%2$s" class="mh-separator"><path stroke-width="0" d="M0 100 L2 60 L4 100 L6 60 L8 100 L10 60 L12 100 L14 60 L16 100 L18 60 L20 100 L22 60 L24 100 L26 60 L28 100 L30 60 L32 100 L34 60 L36 100 L38 60 L40 100 L42 60 L44 100 L46 60 L48 100 L50 60 L52 100 L54 60 L56 100 L58 60 L60 100 L62 60 L64 100 L66 60 L68 100 L70 60 L72 100 L74 60 L76 100 L78 60 L80 100 L82 60 L84 100 L86 60 L88 100 L90 60 L92 100 L94 60 L96 100 L98 60 L100 100 Z" fill="%1$s" stroke="%1$s"></path></svg></div>', 
			esc_attr($background_color),
			'100%' ) : ''),
			
			('clouds' === $separator_top ?  sprintf('
<div class="separator-top"><svg preserveAspectRatio="none" viewBox="0 0 100 100" height="%2$s" width="%2$s" version="1.1" xmlns="http://www.w3.org/2000/svg" class="mh-separator"><path d="M-5 100 Q 0 2 5 100 Z M0 100 Q 5 0 10 100 M5 100 Q 10 30 15 100 M10 100 Q 15 10 20 100 M15 100 Q 20 30 25 100 M20 100 Q 25 0 30 100 M25 100 Q 30 -20 35 100 M30 100 Q 35 30 40 100 M35 100 Q 40 10 45 100 M40 100 Q 45 50 50 100 M45 100 Q 50 30 55 100 M50 100 Q 55 10 60 100 M55 100 Q 60 30 65 100 M60 100 Q 65 49 70 100 M65 100 Q 70 10 75 100 M70 100 Q 75 30 80 100 M75 100 Q 80 30 85 100 M80 100 Q 85 50 90 100 M85 100 Q 90 10 95 100 M90 100 Q 95 25 100 100 M95 100 Q 100 2 105 100 Z" stroke-width="0" fill="%1$s" stroke="%1$s">
				</path>
			</svg></div>',
			esc_attr($background_color),
			'100%'
			 ) : ''),
			 
			 ('curve' === $separator_top ?  sprintf('<div class="separator-top"><svg xmlns="http://www.w3.org/2000/svg" width="%2$s" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" height="%2$s" class="mh-separator"><path stroke-width="0" d="M0 100 C50 0 50 0 100 100 Z" stroke="%1$s" fill="%1$s" /></svg></div>', 
			esc_attr($background_color),
			'100%' ) : ''),
			
			 ('curve-alt' === $separator_top ?  sprintf('
<div class="separator-top"><svg preserveAspectRatio="none" viewBox="0 0 100 100" height="%2$s" width="%2$s" version="1.1" xmlns="http://www.w3.org/2000/svg" class="mh-separator"><path stroke-width="0" stroke="%1$s" fill="%1$s" d="M0 100 C 20 0 60 0 100 100 Z"/></svg></div>', esc_attr($background_color),
			'100%' ) : ''),		
			
			('diagonalright' === $separator_top ?  sprintf('
<div class="separator-top"><svg xmlns="http://www.w3.org/2000/svg" width="%2$s" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" height="%2$s" class="mh-separator"><path stroke-width="0" d="M0 100 L100 0 L100 100" fill="%1$s" stroke="%1$s" /></svg></div>', 
			esc_attr($background_color),
			'100%'
			 ) : ''),
			 
			 ('diagonalleft' === $separator_top ?  sprintf('
<div class="separator-top"><svg xmlns="http://www.w3.org/2000/svg" width="%2$s" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" height="%2$s" class="mh-separator"><path stroke-width="0" d="M0 0 L100 100 L0 100" fill="%1$s" stroke="%1$s"></path></svg></div>', 
			esc_attr($background_color),
			'100%'
			 ) : ''),
			 
			('arrow' === $separator_top ?  sprintf('
<div class="separator-top"><svg xmlns="http://www.w3.org/2000/svg" width="%2$s" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" height="%2$s" class="mh-separator"><path stroke-width="0" stroke="%1$s" fill="%1$s" d="M0 0 L50 100 L100 0 L100 100 L0 100"/></svg></div>', 
			esc_attr($background_color),
			'100%'
			 ) : '')
		);
	}
	if ('off' !== $separator_bottom){	
		$svg_bottom = sprintf( '%1$s%2$s%3$s%4$s%5$s%6$s',
					('curve' === $separator_bottom ?  sprintf('
	<div class="separator-bottom"><svg  class="mh-separator" xmlns="http://www.w3.org/2000/svg" version="1.1" width="%2$s" height="%2$s" viewBox="0 0 100 100" preserveAspectRatio="none">
					<path fill="%1$s" stroke="%1$s" d="M0 0 C 60 100 40 100 100 0 Z"></path>
				</svg></div>', 
				esc_attr($background_color),
				'100%' ) : ''),
				
				('curve-alt' === $separator_bottom ?  sprintf('
	<div class="separator-bottom"><svg preserveAspectRatio="none" viewBox="0 0 100 100" height="%2$s" width="%2$s" version="1.1" xmlns="http://www.w3.org/2000/svg" class="mh-separator"><path stroke-width="0" stroke="%1$s" fill="%1$s" d="M0 0 C 50 100 90 100 100 0 Z"/> </svg></div>', esc_attr($background_color),
				'100%' ) : ''),
				
			('arrow' === $separator_bottom ?  sprintf('
	<div class="separator-bottom"><svg xmlns="http://www.w3.org/2000/svg" width="%2$s" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" height="%2$s" class="mh-separator"><path stroke-width="0" stroke="%1$s" fill="%1$s" d="M0 0 L50 100 L100 0 Z"/></svg></div>', 
				esc_attr($background_color),
				'100%'
				 ) : ''),
				 
				 ('diagonalright' === $separator_bottom ?  sprintf('
	<div class="separator-bottom"><svg xmlns="http://www.w3.org/2000/svg" width="%2$s" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" height="%2$s" class="mh-separator"><path stroke-width="0" d="M0 0 L0 100 L100 0 Z" fill="%1$s" stroke="%1$s" /></svg></div>', 
				esc_attr($background_color),
				'100%'
				 ) : ''),
				 
				 ('diagonalleft' === $separator_bottom ?  sprintf('
	<div class="separator-bottom"><svg xmlns="http://www.w3.org/2000/svg" width="%2$s" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" height="%2$s" class="mh-separator"><path stroke-width="0" d="M0 0 L100 100 100 0 Z" fill="%1$s" stroke="%1$s"></path></svg></div>', 
				esc_attr($background_color),
				'100%'
				 ) : ''),
				 
				 ('smallarrow' === $separator_bottom ?  sprintf('<div class="separator-bottom"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="%2$s" height="%2$s" viewBox="0 0 100 100" preserveAspectRatio="none" class="mh-separator"><path stroke-width="0" fill="%1$s" stroke="%1$s" d="M44 0 L50 78 L56 0 Z" /></svg></div>',
				esc_attr($background_color),
				'100%' ) : '')
			);
		}
			
		$output = sprintf(
			'<div%7$s class="mhc_section%3$s%4$s%5$s%6$s%8$s%12$s%13$s%14$s%15$s%19$s%20$s%21$s"%18$s>
			%16$s 
				%22$s
				%11$s
				%9$s
				%2$s
				%1$s
				%10$s
			%17$s
			</div> <!-- .mhc_section -->',
			do_shortcode( mhc_fix_shortcodes( $content ) ),//1
			$background_video, //2
			( '' !== $background_video ? ' mhc_section_video mhc_preload' : '' ), //3
			(  'off' !== $inner_shadow && 'off' === $separator_top && 'off' === $separator_bottom && ! ( '' !== $background_image && 'on' === $parallax && 'off' === $parallax_method ) ? ' mhc_inner_shadow' : '' ),//4
			( 'off' !== $parallax ? ' mhc_section_parallax' : '' ),//5
			( 'off' !== $fullwidth ? ' mhc_fullwidth_section' : '' ),//6
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ), //7
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ), //8
			( 'on' === $specialty ? '<div class="mhc_row">' : '' ), //9
			( 'on' === $specialty ? '</div> <!-- .mhc_row -->' : '' ), //10
			( '' !== $background_image && 'on' === $parallax
				? sprintf(
					'<div class="mh_parallax_bg%1$s%2$s"></div>',
					( 'off' === $parallax_method ? ' mhc_parallax_css' : '' ),
					( 'off' !== $inner_shadow && 'off' === $parallax_method ? ' mhc_inner_shadow' : '' )
				)
				: ''
			),//11
			( 'on' === $specialty ? ' mh_section_specialty' : ' mh_section_regular' ), //12
			( 'on' === $transparent_background && '#ffffff' !== $background_color && '100' !== $transparent_image ? ' mh_section_transparent' : '' ), //13
		
			('off' !== $separator_top ? ' top-separator' : ''), //14
			('off' !== $separator_bottom ? ' bottom-separator' : ''), //15
			( '' !== $separator_top ? $svg_top : ''), //16
			( '' !== $separator_bottom ? $svg_bottom : ''), //17
			( '' !== $background_color ? sprintf(' data-bg-color="%1$s"', esc_attr($background_color) ) : ''), //18
			//advanced
			('off' !== $allow_advanced_padding && 'off' !== $force_fullwidth ? ' mhc_force_fullwidth' : ''), //19
			('off' !== $allow_advanced_padding && 'off' !== $force_fullwidth ? sprintf( ' %1$s', 
			('default' !== $column_paddings ? $column_paddings : 'padding-3pct')
			) : ''), //20
			('off' !== $allow_advanced_padding && 'off' !== $force_fullwidth && 'off' !== $column_match_heights ? ' column-match-heights' : ''), //21
			( '' !== $background_image && 'on' !== $parallax && '' !== $transparent_image && 'off' !== $transparent_background ? '<div class="mh_transparent_bg"></div>' : '') //22
				
		);

		return $output;

	}

}
new MHComposer_Section;