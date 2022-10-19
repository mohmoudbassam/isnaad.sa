<?php
if (class_exists('MHComposer_Component', false)) {
    
    class MHLoveit_Component_Social_Media_Share extends MHComposer_Component {
        function init() {
            $this->name = esc_html__( 'Social Media Share', 'mh-loveit' );
            $this->slug = 'mhc_display_social_media_share';

            $this->approved_fields = array(
				'share_content',
				'share_text',
				'share_url',
                'twitter',
                'twitter_text',
                'facebook',
                'facebook_text',
                'google',
                'google_text',
                'pinterest',
                'pinterest_text',
                'linkedin',
                'linkedin_text',
                'gmail',
                'gmail_text',
                'buffer',
                'buffer_text',
                'printfriendly',
                'printfriendly_text',
                'yahoomail',
                'yahoomail_text',
                'whatsapp',
                'whatsapp_text',
				'telegram',
                'telegram_text',
                'type',
                'style',
                'use_color',
                'color',
                'share_color',
                'icons_alignment',
                'column',
                'show_share_mobile',
                'admin_label',
                'module_id',
                'module_class',
            );
    
            $this->fields_defaults = array(
				'share_content'	 	=> array( 'off' ),
                'twitter' 		   	=> array( 'on' ),
                'facebook' 	   	  	=> array( 'on' ),
                'google' 		 	=> array( 'on' ),
                'pinterest'	  	 	=> array( 'off' ),
                'linkedin'	   	  	=> array( 'off' ),
                'gmail'		  	 	=> array( 'off' ),
                'buffer'		 	=> array( 'off' ),
                'printfriendly'  	=> array( 'off' ),
                'yahoomail'		 	=> array( 'off' ),
                'whatsapp'		  	=> array( 'off' ),
				'telegram'		  	=> array( 'off' ),
                'type'  		   	=> array( 'title' ),
                'style'  		  	=> array( 'border' ),
                'use_color'	  	 	=> array( 'off' ),
                'color'  		  	=> array( mh_composer_accent_color(),  'append_default' ),
                'share_color'  	    => array( mh_composer_accent_color(),  'append_default' ),
                'icons_alignment'   => array( 'right' ),
                'column' 		 	=> array( '3' ),
                'show_share_mobile' => array( 'on' ),
            );
            $this->custom_css_options = array(
                'share_button_item' => array(
                    'label'    => esc_html__( 'Social Share Button', 'mh-loveit' ),
                    'selector' => 'li.post_share_item',
                    'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-loveit' ),
                ),
            );
        }
    
        function get_fields() {
            $fields = array(
				'share_content' => array(
                    'label'           => esc_html__( 'Share Content', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
						'off' => esc_html__( 'No', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_share_text',
						'#mhc_share_url',
                    ),
                    'description'        => esc_html__( 'By default, the title and the link to this page will be shared. Disable this option if you want to specify what to share.', 'mh-loveit' ),
                ),
				'share_url' => array(
                    'label'           => esc_html__( 'Share URL', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_show_if'   => 'off',
                    'description'     => esc_html__( 'Input the URL you want to share. This field cannot be empty.', 'mh-loveit' ),
                ),
				'share_text' => array(
                    'label'           => esc_html__( 'Share Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_show_if'   => 'off',
                    'description'     => esc_html__( 'Input the text you want to share.', 'mh-loveit' ),
                ),
                'type' => array(
                    'label'       => esc_html__( 'Share Buttons Type', 'mh-loveit' ),
                    'type'              => 'select',
                    'options'           => array(
                        'title'    => esc_html__( 'Title and icon', 'mh-loveit' ),
                        'icon_xl'  => esc_html__( 'Only icon - large', 'mh-loveit' ),
                        'icon'     => esc_html__( 'Only icon - small', 'mh-loveit' ),
                        'hover'    => esc_html__( 'Share icon', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_column',
                        '#mhc_share_color',
                        '#mhc_icons_alignment',
                    ),
                    'description'     => esc_html__( 'Here you can choose the type for your share buttons.', 'mh-loveit' ),
                ),
                'style' => array(
                    'label'           => esc_html__( 'Share Buttons Style', 'mh-loveit' ),
                    'type'            => 'select',
                    'options'    	 => array(
                        'border'  => esc_html__( 'Bordered', 'mh-loveit' ),
                        'solid'   => esc_html__( 'Solid', 'mh-loveit' ),
                    ),
                    'description'     => esc_html__( 'Here you can choose the style for your share buttons.', 'mh-loveit' ),
                ),
                'use_color' => array(
                    'label'           => esc_html__( 'Use Custom Colour', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_color',
                    ),
                    'description'        => esc_html__( 'Here you can choose whether to choose a custom colour for your share buttons or use the default colours.', 'mh-loveit' ),
                ),
                'color' => array(
                    'label'             => esc_html__( 'Colour', 'mh-loveit' ),
                    'type'              => 'color-alpha',
                    'depends_default'   => true,
                    'description'       => esc_html__( 'Here you can define a custom colour.', 'mh-loveit' ),
                ),
                'share_color' => array(
                    'label'             => esc_html__( 'Share Button Colour', 'mh-loveit' ),
                    'type'              => 'color-alpha',
                    'depends_show_if'   => 'hover',
                    'description'       => esc_html__( 'Here you can define a custom colour for the share button.', 'mh-loveit' ),
                ),
                'twitter' => array(
                    'label'           =>  esc_html__( 'Share to Twitter', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_twitter_text',
                    ),
                ),
                'facebook' => array(
                    'label'           =>  esc_html__( 'Share to Facebook', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_facebook_text',
                    ),
                ),
                'google' => array(
                    'label'           =>  esc_html__( 'Share to Google+', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_google_text',
                    ),
                ),
                'pinterest' => array(
                    'label'           =>  esc_html__( 'Share to Pinterest', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_pinterest_text',
                    ),
                ),
                'linkedin' => array(
                    'label'           =>  esc_html__( 'Share to LinkedIn', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_linkedin_text',
                    ),
                ),
                'gmail' => array(
                    'label'           =>  esc_html__( 'Share to Gmail', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_gmail_text',
                    ),
                ),
                'buffer' => array(
                    'label'           =>  esc_html__( 'Share to Buffer', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_buffer_text',
                    ),
                ),
                'printfriendly' => array(
                    'label'           =>  esc_html__( 'Share to PrintFriendly', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_printfriendly_text',
                    ),
                ),
                'yahoomail' => array(
                    'label'           =>  esc_html__( 'Share to Yahoo Mail', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_yahoomail_text',
                    ),
                ),
                'whatsapp' => array(
                    'label'           =>  esc_html__( 'Share to Whatsapp', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_whatsapp_text',
                    ),
                    'description' => esc_html__( 'This button is only visable on small screens.', 'mh-loveit' ),
                ),
				'telegram' => array(
                    'label'           =>  esc_html__( 'Share to Telegram', 'mh-loveit' ),
                    'type'            => 'switch_button',
                    'options'         => array(
                        'off' => esc_html__( 'No', 'mh-loveit' ),
                        'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                    ),
                    'affects'           => array(
                        '#mhc_telegram_text',
                    ),
                    'description' => esc_html__( 'This button is only visable on small screens.', 'mh-loveit' ),
                ),
                'admin_label' => array(
                    'label'       => esc_html__( 'Label', 'mh-loveit' ),
                    'type'        => 'text',
                    'description' => esc_html__( 'This will change the label of the component in the composer for easy identification.', 'mh-loveit' ),
                ),
                'module_id' => array(
                    'label'           => esc_html__( '{CSS ID}', 'mh-loveit' ),
                    'type'            => 'text',
                    'description'     => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-loveit' ),
                    'tab_slug'        => 'advanced',
                ),
                'module_class' => array(
                    'label'           => esc_html__( '{CSS Class}', 'mh-loveit' ),
                    'type'            => 'text',
                    'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-loveit' ),
                    'tab_slug'        => 'advanced',
                ),
				'icons_alignment' => array(
                    'label'           => esc_html__( 'Icons Placement', 'mh-loveit' ),
                    'type'            => 'select',
                    'options'         => mh_composer_get_text_orientation_options_no_just(),
					'tab_slug'        => 'advanced',
                    'depends_show_if'   => 'icon',
                    'description' => esc_html__( 'This option works only with "Only icon - samll".', 'mh-loveit' ),
                ),
                'column' => array(
                    'label'       => esc_html__( 'Share Buttons Columns', 'mh-loveit' ),
                    'type'              => 'select',
                    'options'           => array(
                        'three'  => esc_html__( 'Three', 'mh-loveit' ),
                        'four'   => esc_html__( 'Four', 'mh-loveit' ),
                    ),
                    'tab_slug'        => 'advanced',
                    'depends_show_if_not' => 'hover',
                    'description' => esc_html__( 'This option will work with "Title and icon" and "Only icon - large".', 'mh-loveit' ),
                ),
                'show_share_mobile' => array(
                    'label'       => esc_html__( 'Hide on Small Devices', 'mh-loveit' ),
                    'type'              => 'switch_button',
                    'options'           => array(
                            'on'  => esc_html__( 'Yes', 'mh-loveit' ),
                            'off' => esc_html__( 'No', 'mh-loveit' ),
                        ),
                    'description'     => esc_html__( 'This option hides the share buttons on small devices.', 'mh-loveit' ),
                    'tab_slug'        => 'advanced',
                ),
                'twitter_text' => array(
                    'label'           => esc_html__( 'Twitter Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
                ),
                'facebook_text' => array(
                    'label'           => esc_html__( 'Facebook Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
                ),
                'google_text' => array(
                    'label'           => esc_html__( 'Google+ Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
                ),
                'pinterest_text' => array(
                    'label'           => esc_html__( 'Pinterest Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
                ),
                'linkedin_text' => array(
                    'label'           => esc_html__( 'LinkedIn Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
                ),
                'gmail_text' => array(
                    'label'           => esc_html__( 'Gmail Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
                ),
                'buffer_text' => array(
                    'label'           => esc_html__( 'Buffer Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
                ),
                'printfriendly_text' => array(
                    'label'           => esc_html__( 'PrintFriendly Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
                ),
                'yahoomail_text' => array(
                    'label'           => esc_html__( 'Yahoo Mail Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
                ),
                'whatsapp_text' => array(
                    'label'           => esc_html__( 'Whatsapp Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
                ),
				'telegram_text' => array(
                    'label'           => esc_html__( 'Telegram Text', 'mh-loveit' ),
                    'type'            => 'text',
                    'depends_default'   => true,
                    'tab_slug'        => 'advanced',
                    'description'     => esc_html__( 'Here you can change the text appears on the share button.', 'mh-loveit' ),
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
            $module_id				= $this->shortcode_atts['module_id'];
            $module_class			= $this->shortcode_atts['module_class'];
			$share_content			= $this->shortcode_atts['share_content'];
			$share_text				= $this->shortcode_atts['share_text'];
			$share_url				= $this->shortcode_atts['share_url'];
            $twitter				= $this->shortcode_atts['twitter'];
            $twitter_text			= $this->shortcode_atts['twitter_text'];
            $facebook				= $this->shortcode_atts['facebook'];
            $facebook_text			= $this->shortcode_atts['facebook_text'];
            $google					= $this->shortcode_atts['google'];
            $google_text			= $this->shortcode_atts['google_text'];
            $pinterest				= $this->shortcode_atts['pinterest'];
            $pinterest_text			= $this->shortcode_atts['pinterest_text'];
            $linkedin				= $this->shortcode_atts['linkedin'];
            $linkedin_text			= $this->shortcode_atts['linkedin_text'];
            $gmail					= $this->shortcode_atts['gmail'];
            $gmail_text				= $this->shortcode_atts['gmail_text'];
            $buffer					= $this->shortcode_atts['buffer'];
            $buffer_text			= $this->shortcode_atts['buffer_text'];
            $printfriendly			= $this->shortcode_atts['printfriendly'];
            $printfriendly_text		= $this->shortcode_atts['printfriendly_text'];
            $yahoomail				= $this->shortcode_atts['yahoomail'];
            $yahoomail_text			= $this->shortcode_atts['yahoomail_text'];
            $whatsapp				= $this->shortcode_atts['whatsapp'];
            $whatsapp_text			= $this->shortcode_atts['whatsapp_text'];
			$telegram				= $this->shortcode_atts['telegram'];
            $telegram_text			= $this->shortcode_atts['telegram_text'];
            $type					= $this->shortcode_atts['type'];
            $style					= $this->shortcode_atts['style'];
            $use_color				= $this->shortcode_atts['use_color'];
            $color					= $this->shortcode_atts['color'];
            $share_color			= $this->shortcode_atts['share_color'];
            $icons_alignment		= $this->shortcode_atts['icons_alignment'];
            $column					= $this->shortcode_atts['column'];
            $show_share_mobile		= $this->shortcode_atts['show_share_mobile'];
    
            $module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
            
            if ( 'icon' === $type && '' !== $icons_alignment ) {
                MHComposer_Core::set_style( $function_name, array(
                    'selector'    => '%%order_class%%',
                    'declaration' => sprintf(
                        'text-align: %1$s;',
                        esc_attr( $icons_alignment )
                    ),
                ) );
            }
            if ('hover' === $type && '' !== $share_color){
                MHComposer_Core::set_style( $function_name, array(
                    'selector'    => '%%order_class%% .mh_share .post_share_btn',
                    'declaration' => sprintf(
                        'background-color:%1$s !important;',
                        esc_html( $share_color )
                    ),
                ) );
            }
            if('on' === $use_color && '' !== $color ){
                MHComposer_Core::set_style( $function_name, array(
                    'selector'    => '%%order_class%% .mh_share .mh_share_accent li',
                    'declaration' => sprintf(
                        'border-color:%1$s;',
                        esc_html( $color )
                    ),
                ) );
                if ('border' === $style){
                    MHComposer_Core::set_style( $function_name, array(
                        'selector'    => '%%order_class%% .mh_share .mh_share_accent.mh_share_border li span, %%order_class%% .mh_share .mh_share_accent.mh_share_border li i',
                        'declaration' => sprintf(
                            'color:%1$s !important;',
                            esc_html( $color )
                        ),
                    ) );
                }elseif('solid' === $style){
                    MHComposer_Core::set_style( $function_name, array(
                        'selector'    => '%%order_class%% .mh_share .mh_share_accent.mh_share_solid li',
                        'declaration' => sprintf(
                            'background-color:%1$s;',
                            esc_html( $color )
                        ),
                    ) );
                    MHComposer_Core::set_style( $function_name, array(
                        'selector'    => '%%order_class%% .mh_share .mh_share_accent.mh_share_solid li span, %%order_class%% .mh_share .mh_share_accent.mh_share_solid li i',
                        'declaration' => 'color:#ffffff;'
                    ) );
                }
            }
			$title = $url = '';
			
			if ( 'on' !== $share_content && '' !== $share_url ) {
				$title = esc_attr( $share_text );
				$url = esc_url( $share_url );
			}else{
            	$title = (is_home() ? esc_attr( get_bloginfo( 'name' ) ) : esc_attr( get_the_title() ) );
            	$url = (is_home() ? esc_url( home_url( '/' ) ) :  esc_url( get_permalink() ) );
			}
			
			$id = (is_home() ? 'homepage' : get_the_ID());	
            $networks = '';
            $networks = sprintf('%s%s%s%s%s%s%s%s%s%s%s',
                ('on' === $twitter ? sprintf(
                    '<li class="post_share_item twitter"><a data-post_id="%1$s" data-social_name="twitter" rel="nofollow" target="_blank" class="post_share_item_url" href="http://twitter.com/share?text=%3$s&amp;url=%2$s">
                    <i class="network-icon mh-icon-before"></i>
                    <span class="post_share_item_title">%4$s</span>
                    </a></li>',
                    $id,
                    $url,
                    $title,
                    '' !== $twitter_text ? esc_attr( $twitter_text ) : esc_html__("Twitter", "mh-loveit")			
                ) : ''),
                
                ('on' === $facebook ? sprintf(
                    '<li class="post_share_item facebook"><a data-post_id="%1$s" data-social_name="facebook" rel="nofollow" target="_blank" class="post_share_item_url" href="http://www.facebook.com/sharer.php?u=%2$s">
                        <i class="network-icon mh-icon-before"></i>
                        <span class="post_share_item_title">%3$s</span>
                        </a></li>',
                    $id,
                    $url,
                    '' !== $facebook_text ? esc_attr( $facebook_text ) : esc_html__("Facebook", "mh-loveit")
                ) : ''),
                
                ('on' === $google ? sprintf(
                    '<li class="post_share_item google google-plus"><a data-post_id="%1$s" data-social_name="googleplus" rel="nofollow" target="_blank" class="post_share_item_url" href="https://plus.google.com/share?url=%2$s">
                            <i class="network-icon mh-icon-before"></i>
                        <span class="post_share_item_title">%3$s</span>
                    </a></li>',
                    $id,
                    $url,
                    '' !== $google_text ? esc_attr( $google_text ) : esc_html__("Google+", "mh-loveit")
                ) : ''),
                
                ('on' === $pinterest ? sprintf(
                    '<li class="post_share_item pinterest"><a data-post_id="%1$s" data-social_name="pinterest" rel="nofollow" target="_blank" class="post_share_item_url" href="http://www.pinterest.com/pin/create/button/?url=%2$s&description=%3$s">
                    <i class="network-icon mh-icon-before"></i>
                <span class="post_share_item_title">%4$s</span>
            </a></li>',
                    $id,
                    $url,
                    $title,
                    '' !== $pinterest_text ? esc_attr( $pinterest_text ) : esc_html__("Pinterest", "mh-loveit")
                ) : ''),
                
                ('on' === $linkedin ? sprintf(
                    '<li class="post_share_item linkedin"><a data-post_id="%1$s" data-social_name="linkedin" rel="nofollow" target="_blank" class="post_share_item_url" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=%2$s&amp;title=%3$s">
                    <i class="network-icon mh-icon-before"></i>
                <span class="post_share_item_title">%4$s</span>
            </a></li>',
                    $id,
                    $url,
                    $title,
                    '' !== $linkedin_text ? esc_attr( $linkedin_text ) : esc_html__("LinkedIn", "mh-loveit")
                ) : ''),
                
                ('on' === $gmail ? sprintf(
                    '<li class="post_share_item google gmail"><a data-post_id="%1$s" data-social_name="gmail" rel="nofollow" target="_blank" class="post_share_item_url" href="https://mail.google.com/mail/u/0/?view=cm&amp;fs=1&amp;su=%3$s&amp;body=%2$s&amp;ui=2&amp;tf=1">
                    <i class="network-icon mh-icon-before"></i>
                <span class="post_share_item_title">%4$s</span>
            </a></li>',
                    $id,
                    $url,
                    $title,
                    '' !== $gmail_text ? esc_attr( $gmail_text ) : esc_html__("Gmail", "mh-loveit")
                ) : ''),
                
                ('on' === $buffer ? sprintf(
                    '<li class="post_share_item buffer"><a data-post_id="%1$s" data-social_name="buffer" rel="nofollow" target="_blank" class="post_share_item_url" href="https://bufferapp.com/add?url=%2$s&amp;title=%3$s">
                    <i class="network-icon mh-icon-before"></i>
                <span class="post_share_item_title">%4$s</span>
            </a></li>',
                    $id,
                    $url,
                    $title,
                    '' !== $buffer_text ? esc_attr( $buffer_text ) : esc_html__("Buffer", "mh-loveit")
                ) : ''),
                
                ('on' === $printfriendly ? sprintf(
                    '<li class="post_share_item printfriendly"><a data-post_id="%1$s" data-social_name="printfriendly" rel="nofollow" target="_blank" class="post_share_item_url" href="http://www.printfriendly.com/print?url=%2$s&title=%3$s">
                    <i class="network-icon mh-icon-before"></i>
                <span class="post_share_item_title">%4$s</span>
            </a></li>',
                    $id,
                    $url,
                    $title,
                    '' !== $printfriendly_text ? esc_attr( $printfriendly_text ) : esc_html__("PrintFriendly", "mh-loveit")
                ) : ''),
                
                ('on' === $yahoomail ? sprintf(
                    '<li class="post_share_item yahoomail"><a data-post_id="%1$s" data-social_name="yahoomail" rel="nofollow" target="_blank" class="post_share_item_url" href="http://compose.mail.yahoo.com/?body=%2$s">
                    <i class="network-icon mh-icon-before"></i>
                <span class="post_share_item_title">%3$s</span>
            </a></li>',
                    $id,
                    $url,
                    '' !== $yahoomail_text ? esc_attr( $yahoomail_text ) : esc_html__("Yahoo Mail", "mh-loveit")
                ) : ''),
                
                ('on' === $whatsapp ? sprintf(
                    '<li class="post_share_item whatsapp"><a data-post_id="%1$s" data-social_name="whatsapp" rel="nofollow" target="_blank" class="post_share_item_url" href="whatsapp://send?text=%3$s - %2$s">
        <i class="network-icon mh-icon-before"></i>
    <span class="post_share_item_title">%4$s</span>
</a></li>',
                    $id,
                    $url,
                    $title,
                    '' !== $whatsapp_text ? esc_attr( $whatsapp_text ) : esc_html__("Whatsapp", "mh-loveit")
                ) : ''),
				
				('on' === $telegram ? sprintf(
                    '<li class="post_share_item telegram"><a data-post_id="%1$s" data-social_name="telegram" rel="nofollow" target="_blank" class="post_share_item_url" href="https://t.me/share/url?url=%2$s">
        <i class="network-icon mh-icon-before"></i>
    <span class="post_share_item_title">%3$s</span>
</a></li>',
                    $id,
                    $url,
                    '' !== $telegram_text ? esc_attr( $telegram_text ) : esc_html__("Telegram", "mh-loveit")
                ) : '')
            
            );

            $class = " mh_share_type_{$type}";
            $output = sprintf(
                '<div%6$s class="mhc_display_social_media_share mh_share_footer mhc_module post_share_footer%7$s%9$s">
                    <div class="mh_share">
                        <ul class="%2$s%3$s%4$s%8$s">
                            %5$s
                            %1$s
                        </ul>
                    </div>
                </div>',
                $networks,
                ('on' === $use_color && '' !== $color ? ' mh_share_accent' : ' mh_share_color'),
                ('border' === $style ? ' mh_share_border': ' mh_share_solid'),
                ('three' === $column ? ' post_share_3col' : ' post_share_4col'),
                ('hover' === $type ? '<li class="post_share_btn mh_adjust_corners mh_adjust_bg"><i class="mhc-icon mhicons"></i></li>' : ''),
                ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
                esc_attr( $class ),
                ('on' === $show_share_mobile ? ' mh_share_mobile_hide' : '')
            );
            
            return $output;
        }
    }
    new MHLoveit_Component_Social_Media_Share;
}