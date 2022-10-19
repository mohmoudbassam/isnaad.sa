<?php
class MHComposer_Component_Video extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Video', 'mh-composer' );
		$this->slug = 'mhc_video';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'src',
			'src_webm',
			'image_src',
			'play_icon_color',
		);

		$this->custom_css_options = array(
			'video_play_icon' => array(
				'label'    => esc_html__( 'Play Icon', 'mh-composer' ),
				'selector' => '.mhc_video_play',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'src' => array(
				'label'              => esc_html__( 'Video MP4/URL', 'mh-composer' ),
				'type'               => 'upload',
				'data_type'          => 'video',
				'upload_button_text' => esc_attr__( 'Upload a video', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Video MP4 File', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Video', 'mh-composer' ),
				'description'        => esc_html__( 'Upload your desired video in .MP4 format, or type in the URL to the video you would like to display', 'mh-composer' ),
			),
			'src_webm' => array(
				'label'              => esc_html__( 'Video WEBM', 'mh-composer' ),
				'type'               => 'upload',
				'data_type'          => 'video',
				'upload_button_text' => esc_attr__( 'Upload a video', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose a Video WEBM File', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Video', 'mh-composer' ),
				'description'        => esc_html__( 'Upload the .WEBM version of your video here. All uploaded videos should be in both .MP4 and .WEBM formats to ensure maximum compatibility in all browsers.', 'mh-composer' ),
			),
			'image_src' => array(
				'label'              => esc_html__( 'Image Overlay URL', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Image', 'mh-composer' ),
				'additional_button'  => sprintf(
					'<input type="button" class="button mhc-video-image-button" value="%1$s" />',
					esc_attr__( 'Generate From Video', 'mh-composer' )
				),
				'classes'            => 'mhc_video_overlay',
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display over your video. You can also generate a still image from your video.', 'mh-composer' ),
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
			'play_icon_color' => array(
				'label'             => esc_html__( 'Play Icon Colour', 'mh-composer' ),
				'type'              => 'color',
				'custom_color'      => true,
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

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id       = $this->shortcode_atts['module_id'];
		$module_class    = $this->shortcode_atts['module_class'];
		$src             = $this->shortcode_atts['src'];
		$src_webm        = $this->shortcode_atts['src_webm'];
		$image_src       = $this->shortcode_atts['image_src'];
		$play_icon_color = $this->shortcode_atts['play_icon_color'];
		$video_src       = '';

		if ( '' !== $image_src ) {
			$image_output = mhc_set_video_oembed_thumbnail_resolution( $image_src, 'high' );
		} else {
			$image_output = '';
		}

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		if ( '' !== $play_icon_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_video_play',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $play_icon_color )
				),
			) );
		}

		if ( '' !== $src ) {
			if ( false !== mhc_check_oembed_provider( esc_url( $src ) ) ) {
				$video_src = wp_oembed_get( esc_url( $src ) );
			} else {
				$video_src = sprintf( '
					<video controls>
						%1$s
						%2$s
					</video>',
					( '' !== $src ? sprintf( '<source type="video/mp4" src="%s" />', esc_url( $src ) ) : '' ),
					( '' !== $src_webm ? sprintf( '<source type="video/webm" src="%s" />', esc_url( $src_webm ) ) : '' )
				);

				wp_enqueue_style( 'wp-mediaelement' );
				wp_enqueue_script( 'wp-mediaelement' );
			}
		}

		$output = sprintf(
			'<div%2$s class="mhc_module mhc_video%3$s">
				<div class="mhc_video_box">
					%1$s
				</div>
				%4$s
			</div>',
			( '' !== $video_src ? $video_src : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			( '' !== $image_output
				? sprintf(
					'<div class="mhc_video_overlay" style="background-image: url(%1$s);">
						<div class="mhc_video_overlay_hover">
							<a href="#" class="mhc_video_play"></a>
						</div>
					</div>',
					esc_attr( $image_output )
				)
				: ''
			)
		);

		return $output;
	}
}
new MHComposer_Component_Video;