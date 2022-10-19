<?php
class MHComposer_Component_Social_Media_Follow extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Social Media Follow', 'mh-composer' );
		$this->slug            = 'mhc_social_media_follow';
		$this->child_slug      = 'mhc_social_media_follow_network';
		$this->child_item_text = esc_html__( 'Add New Social Network', 'mh-composer' );

		$this->approved_fields = array(
			'link_shape',
			'url_new_window',
			'background_layout',
			'icons_size',
			'icons_alignment',
			'admin_label',
			'module_id',
			'module_class',
			
		);

		$this->fields_defaults = array(
			'link_shape'        => array( 'rounded_rectangle' ),
			'background_layout' => array( 'light' ),
			'url_new_window'    => array( 'on' ),
			'icons_size'   		=> array( 'small' ),
			'icons_alignment'   => array( 'right' ),
		);

		$this->custom_css_options = array(
			'social_follow' => array(
				'label'    => esc_html__( 'Social Network', 'mh-composer' ),
				'selector' => 'li',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'link_shape' => array(
				'label'           => esc_html__( 'Icon Shape', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'rounded_rectangle' => esc_html__( 'Rounded Rectangle', 'mh-composer' ),
					'circle'            => esc_html__( 'Circle', 'mh-composer' ),
					'square'            => esc_html__( 'Square', 'mh-composer' ),
					'bordered_rounded'  => esc_html__( 'Bordered Rounded Rectangle', 'mh-composer' ),
					'bordered_circle'   => esc_html__( 'Bordered Circle', 'mh-composer' ),
					'bordered'          => esc_html__( 'Bordered Square', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose the shape of your social network icons.', 'mh-composer' ),
			),
			'icons_size' => array(
				'label'           => esc_html__( 'Icon Size', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'small'	 => esc_html__( 'Small', 'mh-composer' ),
					'large'	 => esc_html__( 'Medium', 'mh-composer' ),
					'xlarge'	=> esc_html__( 'Large', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose the size of your social network icons.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'light' => esc_html__( 'Light', 'mh-composer' ),
					'dark'  => esc_html__( 'Dark', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			'icons_alignment' => array(
				'label'           => esc_html__( 'Icons Placement', 'mh-composer' ),
				'type'            => 'select',
				'options'         => mh_composer_get_text_orientation_options_no_just(),
				'description' => esc_html__( 'Here you can choose where to place the icons.', 'mh-composer' ),
			),
			'url_new_window' => array(
				'label'           => esc_html__( 'URL Opens', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'mh-composer' ),
					'on'  => esc_html__( 'In a New Tab', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose whether your link opens in a new window.', 'mh-composer' ),
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

	function pre_shortcode_content() {
		global $mhc_social_media_follow_link;

		$link_shape        = $this->shortcode_atts['link_shape'];
		$url_new_window    = $this->shortcode_atts['url_new_window'];
		
		$mhc_social_media_follow_link = array(
			'url_new_window' => $url_new_window,
			'shape'          => $link_shape,
		);
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $mhc_social_media_follow_link;

		$module_id         = $this->shortcode_atts['module_id'];
		$module_class      = $this->shortcode_atts['module_class'];
		$background_layout = $this->shortcode_atts['background_layout'];
		$icons_alignment   = $this->shortcode_atts['icons_alignment'];
		$icons_size		= $this->shortcode_atts['icons_size'];
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		if ( '' !== $icons_alignment ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_social_media_follow',
				'declaration' => sprintf(
					'text-align: %1$s;',
					esc_html( $icons_alignment )
				),
			) );
		}
		
		$class = " mhc_module mhc_bg_layout_{$background_layout} mhc_social_media_{$icons_size} mhc_social_icons_{$icons_alignment}";
		
		$output = sprintf(
			'<ul%3$s class="mhc_social_media_follow mhc_pct%2$s%4$s clearfix">
				%1$s
			</ul> <!-- .mhc_social_media_follow -->',
			$this->shortcode_content,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Social_Media_Follow;

class MHComposer_Component_Social_Media_Follow_Item extends MHComposer_Component {
	function init() {
		$this->name                        = esc_html__( 'Social Network', 'mh-composer' );
		$this->slug                        = 'mhc_social_media_follow_network';
		$this->type                        = 'child';
		$this->child_title_var             = 'content_new';

		$this->approved_fields = array(
			'social_network',
			'url',
			'bg_color',
			'follow_button',
			'follow_text',
			'content_new',
			'skype_url',
			'skype_action',

		);

		$this->fields_defaults = array(
			'url'          => array( '#' ),
			'bg_color'     => array( mh_composer_accent_color(), 'append_default' ),
			'follow_button'     => array( 'off' ),
			'skype_action' => array( 'call' ),
		);

		$this->advanced_setting_title_text = esc_html__( 'New Social Network', 'mh-composer' );
		$this->settings_text               = esc_html__( 'Social Network Settings', 'mh-composer' );
	}

	function get_fields() {
		$fields = array(
			'social_network' => array(
				'label'           => esc_html__( 'Social Network', 'mh-composer' ),
				'type'            => 'select',
				'class'           => 'mhc-social-network',
				'options' => array(
					''            => esc_html__( 'Select a Network', 'mh-composer' ),
					'twitter'    => array(
						'value' => esc_html__( 'Twitter', 'mh-composer' ),
						'data'  => array( 'color' => '#00aced' ),
					),
					'facebook'    => array(
						'value' => esc_html__( 'Facebook', 'mh-composer' ),
						'data'  => array( 'color' => '#3b5998' ),
					),
					'instagram'    => array(
						'value' => esc_html__( 'Instagram', 'mh-composer' ),
						'data'  => array( 'color' => '#e1306c' ),
					),
					'google-plus'    => array(
						'value' => esc_html__( 'Google+', 'mh-composer' ),
						'data'  => array( 'color' => '#dc4e41' ),
					),
					'pinterest'    => array(
						'value' => esc_html__( 'Pinterest', 'mh-composer' ),
						'data'  => array( 'color' => '#cb2027' ),
					),
					'linkedin'    => array(
						'value' => esc_html__( 'Linkedin', 'mh-composer' ),
						'data'  => array( 'color' => '#007bb6' ),
					),
					'tumblr'    => array(
						'value' => esc_html__( 'Tumblr', 'mh-composer' ),
						'data'  => array( 'color' => '#32506d' ),
					),
					'skype'    => array(
						'value' => esc_html__( 'Skype', 'mh-composer' ),
						'data'  => array( 'color' => '#12A5F4' ),
					),
					'flickr'    => array(
						'value' => esc_html__( 'Flickr', 'mh-composer' ),
						'data'  => array( 'color' => '#ff0084' ),
					),
					'soundcloud'    => array(
						'value' => esc_html__( 'Soundcloud', 'mh-composer' ),
						'data'  => array( 'color' => '#ff3a00' ),
					),
					'dribbble'    => array(
						'value' => esc_html__( 'Dribbble', 'mh-composer' ),
						'data'  => array( 'color' => '#ea4c8d' ),
					),
					'youtube'    => array(
						'value' => esc_html__( 'Youtube', 'mh-composer' ),
						'data'  => array( 'color' => '#a82400' ),
					),
					'vimeo'    => array(
						'value' => esc_html__( 'Vimeo', 'mh-composer' ),
						'data'  => array( 'color' => '#45bbff' ),
					),
					'dropbox'    => array(
						'value' => esc_html__( 'Dropbox', 'mh-composer' ),
						'data'  => array( 'color' => '#007ee5' ),
					),
					'behance'    => array(
						'value' => esc_html__( 'Behance', 'mh-composer' ),
						'data'  => array( 'color' => '#36393a' ),
					),
					'vine'    => array(
						'value' => esc_html__( 'Vine', 'mh-composer' ),
						'data'  => array( 'color' => '#00a478' ),
					),
					'drive'    => array(
						'value' => esc_html__( 'Google Drive', 'mh-composer' ),
						'data'  => array( 'color' => '#4285f4' ),
					),
					'telegram'    => array(
						'value' => esc_html__( 'Telegram', 'mh-composer' ),
						'data'  => array( 'color' => '#0088cc' ),
					),
					'mixlr'    => array(
						'value' => esc_html__( 'Mixlr', 'mh-composer' ),
						'data'  => array( 'color' => '#ed1c24' ),
					),
					'periscope'    => array(
						'value' => esc_html__( 'Periscope', 'mh-composer' ),
						'data'  => array( 'color' => '#40a4c4' ),
					),
					'younow'    => array(
						'value' => esc_html__( 'YouNow', 'mh-composer' ),
						'data'  => array( 'color' => '#85d855' ),
					),
					'snapchat'    => array(
						'value' => esc_html__( 'Snapchat', 'mh-composer' ),
						'data'  => array( 'color' => '#36393a' ),
					),   
					'tripadvisor'    => array(
						'value' => esc_html__( 'TripAdvisor', 'mh-composer' ),
						'data'  => array( 'color' => '#589442' ),
					),
					'rss'    => array(
						'value' => esc_html__( 'RSS', 'mh-composer' ),
						'data'  => array( 'color' => '#ff8a3c' ),
					),
				),
				'description' => esc_html__( 'Choose the social network', 'mh-composer' ),
				'affects'           => array(
					'#mhc_url',
					'#mhc_skype_url',
					'#mhc_skype_action',
				),
			),
			'content_new' => array(
				'label' => esc_html__( 'Content', 'mh-composer' ),
				'type'  => 'hidden',
			),
			'url' => array(
				'label'               => esc_html__( 'Account URL', 'mh-composer' ),
				'type'                => 'text',
				'description'         => esc_html__( 'The URL for your social network account.', 'mh-composer' ),
				'depends_show_if_not' => 'skype',
			),
			'skype_url' => array(
				'label'           => esc_html__( 'Account Name', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Your Skype account name.', 'mh-composer' ),
				'depends_show_if' => 'skype',
			),
			'skype_action' => array(
				'label'           => esc_html__( 'Skype Icon Type', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'call' => esc_html__( 'Call', 'mh-composer' ),
					'chat' => esc_html__( 'Chat', 'mh-composer' ),
				),
				'depends_show_if' => 'skype',
				'description'     => esc_html__( 'Here you can choose which type of action for Skype.', 'mh-composer' ),
			),
			'bg_color' => array(
				'label'           => esc_html__( 'Icon Colour', 'mh-composer' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'This will change the icon colour.', 'mh-composer' ),
			),
			'follow_button' => array(
				'label'           => esc_html__( 'Follow Word', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'Off', 'mh-composer' ),
					'on'  => esc_html__( 'On', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_follow_text',
				),
				'description' => esc_html__( 'Here you can choose whether your want to display a follow word next to your icon. This will change the style of your icon.', 'mh-composer' ),
			),
			'follow_text' => array(
				'label'           => esc_html__( 'Follow Word Text', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input your follow word text here.', 'mh-composer' ),
				'depends_show_if' => 'on',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $mhc_social_media_follow_link;

		$social_network = $this->shortcode_atts['social_network'];
		$url            = $this->shortcode_atts['url'];
		$bg_color       = $this->shortcode_atts['bg_color'];
		$follow_button  = $this->shortcode_atts['follow_button'];
		$follow_text    = $this->shortcode_atts['follow_text'];
		$skype_url      = $this->shortcode_atts['skype_url'];
		$skype_action   = $this->shortcode_atts['skype_action'];
		$is_skype       = false;

		$icon_color_style ='';
	if ( isset( $bg_color ) && '' !== $bg_color && ( 'bordered_rounded' != $mhc_social_media_follow_link['shape'] || 'bordered_circle' !== $mhc_social_media_follow_link['shape'] || 'bordered' !== $mhc_social_media_follow_link['shape']) ) {
		$bg_color_style = sprintf( 'background-color: %1$s;', esc_attr( $bg_color ) );
	}
	if ( isset( $bg_color ) && '' !== $bg_color  && 'on' !== $follow_button && ( 'bordered_rounded' === $mhc_social_media_follow_link['shape'] || 'bordered_circle' === $mhc_social_media_follow_link['shape'] || 'bordered' === $mhc_social_media_follow_link['shape']) ) {
		$bg_color_style = sprintf( 'border-color: %1$s;', esc_attr( $bg_color ) );
		$icon_color_style = sprintf( 'color: %1$s!important;', esc_attr( $bg_color ) );
	}
	if ( '' !== $follow_text )
		$title = "{$follow_text}";
		
		if ( '' !== $follow_button ) {
		$the_button = sprintf(
			'<span class="follow-text">%1$s</span>',
			esc_attr( $follow_text )
		);
	}
	if ( 'skype' === $social_network ) {
			$skype_url = sprintf(
				'skype:%1$s?%2$s',
				sanitize_text_field( $skype_url ),
				sanitize_text_field( $skype_action )
			);
			$is_skype = true;
		}

$output = sprintf(
		'<li class="mhc_social_icon mhc_social_network_link%1$s%8$s%11$s">
			<a href="%4$s" class="icon%2$s" title="%5$s"%7$s style="%3$s %10$s"><span class="follow-icon">%6$s</span>%9$s</a>
		</li>',
		( '' !== $social_network ? sprintf( ' mh-social-%s', esc_attr( $social_network ) ) : '' ), //1
		( '' !== $mhc_social_media_follow_link['shape'] ? sprintf( ' %s', esc_attr( $mhc_social_media_follow_link['shape'] ) ) : '' ),//2
		$bg_color_style,//3
		! $is_skype ? esc_url( $url ) : $skype_url, //4
		esc_attr( trim( wp_strip_all_tags( $content ) ) ), //5
		sanitize_text_field( $content ),//6
		( 'on' === $mhc_social_media_follow_link['url_new_window'] ? ' target="_blank"' : '' ),//7
		( 'on' === $follow_button ? ' has_follow_button' : '' ),//8
		$the_button,//9
		$icon_color_style, //10
		( 'on' !== $follow_button ? ' not_follow_button' : '' )//11
		
	);

	return $output;
	
	}
}
new MHComposer_Component_Social_Media_Follow_Item;