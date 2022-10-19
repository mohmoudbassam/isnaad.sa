<?php
class MHComposer_Component_Audio extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Audio', 'mh-composer' );
		$this->slug = 'mhc_audio';
		$this->main_css_selector = '%%order_class%%.mhc_audio_module';

		$this->approved_fields = array(
			'audio',
			'title',
			'artist_name',
			'album_name',
			'image_url',
			'background_color',
			'background_layout',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'background_color'  => array( mh_composer_accent_color(), 'append_default' ),
			'background_layout' => array( 'dark' ),
		);
		
		$this->custom_css_options = array(
			'audio_cover_image' => array(
				'label'    => esc_html__( 'Cover Image', 'mh-composer' ),
				'selector' => '.mhc_audio_cover_art',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'audio_title' => array(
				'label'    => esc_html__( 'Audio Title', 'mh-composer' ),
				'selector' => '.mhc_audio_module_content h2',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'audio_meta' => array(
				'label'    => esc_html__( 'Audio Meta', 'mh-composer' ),
				'selector' => '.mh_audio_module_meta',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'audio' => array(
				'label'              => esc_html__( 'Audio', 'mh-composer' ),
				'type'               => 'upload',
				'data_type'          => 'audio',
				'upload_button_text' => esc_attr__( 'Upload an audio file', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose an audio file', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set as audio for the component', 'mh-composer' ),
				'description'        => esc_html__( 'Define the audio file for use in the component. To remove an audio file from the component, simply delete the URL from the settings field.', 'mh-composer' ),
			),
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define a title.', 'mh-composer' ),
			),
			'artist_name' => array(
				'label'           => esc_html__( 'Artist Name', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define an artist name.', 'mh-composer' ),
			),
			'album_name' => array(
				'label'           => esc_html__( 'Album name', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define an album name.', 'mh-composer' ),
			),
			'image_url' => array(
				'label'              => esc_html__( 'Cover Image URL', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Image', 'mh-composer' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'mh-composer' ),
			),
			'background_color' => array(
				'label'             => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Define a custom background colour for your component, or leave blank to use the default colour.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
					'light' => esc_html__( 'Dark', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
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
		$module_id         = $this->shortcode_atts['module_id'];
		$module_class      = $this->shortcode_atts['module_class'];
		$audio             = $this->shortcode_atts['audio'];
		$title             = $this->shortcode_atts['title'];
		$artist_name       = $this->shortcode_atts['artist_name'];
		$album_name        = $this->shortcode_atts['album_name'];
		$image_url         = $this->shortcode_atts['image_url'];
		$background_color  = "" !== $this->shortcode_atts['background_color'] ? $this->shortcode_atts['background_color'] : $this->fields_defaults['background_color'][0];
		$background_layout = $this->shortcode_atts['background_layout'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$meta = $cover_art = '';
		$class = " mhc_module mhc_bg_layout_{$background_layout}";

		if ( 'light' === $background_layout ) {
			$class .= " mhc_text_color_dark";
		}

		if ( '' !== $artist_name || '' !== $album_name ) {
			if ( '' !== $artist_name && '' !== $album_name ) {
				$album_name = ' | ' . $album_name;
			}

			if ( '' !== $artist_name ) {
				$artist_name = sprintf( mh_wp_kses( _x( 'by <strong>%1$s</strong>', 'Audio Component meta information', 'mh-composer' ) ),
					esc_html( $artist_name )
				);
			}

			$meta = sprintf( '%1$s%2$s',
				$artist_name,
				esc_html( $album_name )
			);

			$meta = sprintf( '<p class="mh_audio_module_meta">%1$s</p>', $meta );
		}

		if ( '' !== $image_url ) {
			$cover_art = sprintf(
				'<div class="mhc_audio_cover_art" style="background-image: url(%1$s);">
				</div>',
				esc_url( $image_url )
			);
		}

		// some themes do not include these styles/scripts so we need to enqueue them in this module
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'mh-composer-mediaelement' );

		// remove all filters from WP audio shortcode to make sure current theme doesn't add any elements into audio module
		remove_all_filters( 'wp_audio_shortcode_vault' );
		remove_all_filters( 'wp_audio_shortcode' );
		remove_all_filters( 'wp_audio_shortcode_class');

		$output = sprintf(
			'<div%8$s class="mhc_audio_module clearfix%4$s%7$s%9$s"%5$s>
				%6$s

				<div class="mhc_audio_module_content mh_audio_container">
					%1$s
					%2$s
					%3$s
				</div>
			</div>',
			( '' !== $title ? '<h2>' . esc_html( $title ) . '</h2>' : '' ),
			$meta,
			do_shortcode(
				sprintf( '[audio src="%1$s" /]', esc_url( $audio ) )
			),
			esc_attr( $class ),
			sprintf( ' style="background-color: %1$s;"', esc_attr( $background_color ) ),
			$cover_art,
			( '' === $image_url ? ' mhc_audio_no_image' : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Audio;