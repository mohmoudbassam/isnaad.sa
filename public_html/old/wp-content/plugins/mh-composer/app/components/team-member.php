<?php
class MHComposer_Component_Team_Member extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Personal Card', 'mh-composer' );
		$this->slug = 'mhc_team_member';
		$this->main_css_selector = '%%order_class%%.mhc_team_member';

		$this->approved_fields = array(
			'name',
			'position',
			'image_url',
			'animation',
			'background_layout',
			'text_orientation',
			'twitter_url',
			'facebook_url',
			'instagram_url',
			'behance_url',
			'google_url',
			'linkedin_url',
			'content_new',
			'admin_label',
			'module_id',
			'module_class',
			'icon_color',
			'icon_hover_color',
			'show_border',
		);

		$this->fields_defaults = array(
			'animation'         => array( 'off' ),
			'background_layout' => array( 'light' ),
			'text_orientation'  => array( 'right' ),
			'show_border'	   => array( 'on' ),
		);
		
		$this->custom_css_options = array(
			'member_image' => array(
				'label'    => esc_html__( 'Image', 'mh-composer' ),
				'selector' => '.mhc_team_member_image',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'member_name' => array(
				'label'    => esc_html__( 'Name', 'mh-composer' ),
				'selector' => '.mhc_team_member_description h4',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'member_position' => array(
				'label'    => esc_html__( 'Position', 'mh-composer' ),
				'selector' => '.mhc_member_position',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'member_social_links' => array(
				'label'    => esc_html__( 'Social Links', 'mh-composer' ),
				'selector' => '.mhc_member_social_links',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'member_social_link' => array(
				'label'    => esc_html__( 'Social Link', 'mh-composer' ),
				'selector' => '.mhc_member_social_links a',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'name' => array(
				'label'           => esc_html__( 'Name', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input the name of the person.', 'mh-composer' ),
			),
			'position' => array(
				'label'           => esc_html__( 'Position', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( "Input the person's position.", 'mh-composer' ),
			),
			'image_url' => array(
				'label'              => esc_html__( 'Image URL', 'mh-composer' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'mh-composer' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'mh-composer' ),
				'update_text'        => esc_attr__( 'Set As Image', 'mh-composer' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'mh-composer' ),
			),
			'animation' => array(
				'label'             => esc_html__( 'Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'off'     => esc_html__( 'No Animation', 'mh-composer' ),
					'right'   => esc_html__( 'Right To Left', 'mh-composer' ),
					'left'    => esc_html__( 'Left To Right', 'mh-composer' ),
					'top'     => esc_html__( 'Top To Bottom', 'mh-composer' ),
					'bottom'  => esc_html__( 'Bottom To Top', 'mh-composer' ),
					'scaleup' => esc_html__( 'Scale Up', 'mh-composer' ),
					'fade_in' => esc_html__( 'Fade In', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This controls the direction of the lazy-loading animation.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'            => 'select',
				'options'           => array(
					'light' => esc_html__( 'Dark', 'mh-composer' ),
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose the value of your text. If you are working with a dark background, then your text should be set to light. If you are working with a light background, then your text should be dark.', 'mh-composer' ),
			),
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options(),
				'description'       => esc_html__( 'This will adjust the alignment of the text.', 'mh-composer' ),
			),
			'twitter_url' => array(
				'label'           => esc_html__( 'Twitter', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input Twitter Profile URL', 'mh-composer' ),
			),
			'facebook_url' => array(
				'label'           => esc_html__( 'Facebook', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input Facebook Profile URL', 'mh-composer' ),
			),
			'instagram_url' => array(
				'label'           => esc_html__( 'Instagram', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input Instagram Profile URL', 'mh-composer' ),
			),
			'behance_url' => array(
				'label'           => esc_html__( 'Behance', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input Behance Profile URL', 'mh-composer' ),
			),
			'google_url' => array(
				'label'           => esc_html__( 'Google+', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input Google+ Profile URL', 'mh-composer' ),
			),
			'linkedin_url' => array(
				'label'           => esc_html__( 'LinkedIn', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input LinkedIn Profile URL', 'mh-composer' ),
			),
			'content_new' => array(
				'label'           => esc_html__( 'Blurb', 'mh-composer' ),
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
			'icon_color' => array(
				'label'             => esc_html__( 'Icon Colour', 'mh-composer' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'icon_hover_color' => array(
				'label'             => esc_html__( 'Icon Hover Colour', 'mh-composer' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'show_border' => array(
				'label'           => esc_html__( 'Show Border', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
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
		$module_id         = $this->shortcode_atts['module_id'];
		$module_class      = $this->shortcode_atts['module_class'];
		$name              = $this->shortcode_atts['name'];
		$position          = $this->shortcode_atts['position'];
		$image_url         = $this->shortcode_atts['image_url'];
		$animation         = $this->shortcode_atts['animation'];
		$twitter_url       = $this->shortcode_atts['twitter_url'];
		$facebook_url      = $this->shortcode_atts['facebook_url'];
		$instagram_url     = $this->shortcode_atts['instagram_url'];
		$behance_url       = $this->shortcode_atts['behance_url'];
		$google_url        = $this->shortcode_atts['google_url'];
		$linkedin_url      = $this->shortcode_atts['linkedin_url'];
		$background_layout = $this->shortcode_atts['background_layout'];
		$text_orientation     = $this->shortcode_atts['text_orientation'];
		$icon_color        = $this->shortcode_atts['icon_color'];
		$icon_hover_color  = $this->shortcode_atts['icon_hover_color'];
		$show_border	   = $this->shortcode_atts['show_border'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$image = $social_links = '';

		if ( '' !== $icon_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_member_social_links a',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $icon_color )
				),
			) );
		}

		if ( '' !== $icon_hover_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_member_social_links a:hover',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $icon_hover_color )
				),
			) );
		}
		if ( '' !== $twitter_url ) {
			$social_links .= sprintf(
				'<li><a href="%1$s" class="mhc_font_icon mhc_twitter_icon"><span>%2$s</span></a></li>',
				esc_url( $twitter_url ),
				esc_html__( 'Twitter', 'mh-composer' )
			);
		}
		
		if ( '' !== $facebook_url ) {
			$social_links .= sprintf(
				'<li><a href="%1$s" class="mhc_font_icon mhc_facebook_icon"><span>%2$s</span></a></li>',
				esc_url( $facebook_url ),
				esc_html__( 'Facebook', 'mh-composer' )
			);
		}

		if ( '' !== $instagram_url ) {
			$social_links .= sprintf(
				'<li><a href="%1$s" class="mhc_font_icon mhc_instagram_icon"><span>%2$s</span></a></li>',
				esc_url( $instagram_url ),
				esc_html__( 'Instagram', 'mh-composer' )
		);
		}
		
		if ( '' !== $behance_url ) {
		$social_links .= sprintf(
			'<li><a href="%1$s" class="mhc_font_icon mhc_behance_icon"><span>%2$s</span></a></li>',
			esc_url( $behance_url ),
			esc_html__( 'Behance', 'mh-composer' )
		);
		}

		if ( '' !== $google_url ) {
			$social_links .= sprintf(
				'<li><a href="%1$s" class="mhc_font_icon mhc_google_icon"><span>%2$s</span></a></li>',
				esc_url( $google_url ),
				esc_html__( 'Google+', 'mh-composer' )
			);
		}

		if ( '' !== $linkedin_url ) {
			$social_links .= sprintf(
				'<li><a href="%1$s" class="mhc_font_icon mhc_linkedin_icon"><span>%2$s</span></a></li>',
				esc_url( $linkedin_url ),
				esc_html__( 'LinkedIn', 'mh-composer' )
			);
		}

		if ( '' !== $social_links ) {
			$social_links = sprintf( '<ul class="mhc_member_social_links">%1$s</ul>', $social_links );
		}

		if ( '' !== $image_url ) {
			$image = sprintf(
				'<div class="mhc_team_member_image mh-waypoint%3$s">
					<img src="%1$s" alt="%2$s" />
				</div>',
				esc_url( $image_url ),
				esc_attr( $name ),
				esc_attr( " mhc_animation_{$animation}" )
			);
		}
		$class = " mhc_module mhc_bg_layout_{$background_layout} mhc_text_align_{$text_orientation}";
		$output = sprintf(
			'<div%3$s class="mhc_module mhc_team_member%4$s%9$s%8$s clearfix">
				%2$s
				<div class="mhc_team_member_description">
					%5$s
					%6$s
					%1$s
					%7$s
				</div> <!-- .mhc_team_member_description -->
			</div> <!-- .mhc_team_member -->',
			$this->shortcode_content,
			( '' !== $image ? $image : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			( '' !== $name ? sprintf( '<h4>%1$s</h4>', esc_html( $name ) ) : '' ),
			( '' !== $position ? sprintf( '<p class="mhc_member_position%2$s">%1$s</p>', 
				esc_html( $position ),
				'on' === $show_border ? ' mhc_show_borders' : ''
			) : '' ),
			$social_links,
			$class,
			( '' === $image ? ' mhc_team_member_no_image' : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Team_Member;