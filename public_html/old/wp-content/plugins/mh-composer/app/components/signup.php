<?php
class MHComposer_Component_Signup extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Subscribe', 'mh-composer' );
		$this->slug = 'mhc_signup';
		$this->main_css_selector = '%%order_class%%.mhc_subscribe';

		$this->approved_fields = array(
			'provider',
			'feedburner_uri',
			'mailchimp_list',
			'jetpack_count',
			'mailpoet_form',
			'mailpoet_count',
			'mailpoet_count_text',
			'title',
			'button_text',
			'use_background_color',
			'background_color',
			'background_layout',
			'text_orientation',
			'content_new',
			'admin_label',
			'module_id',
			'module_class',
			'form_style',
		);

		$this->fields_defaults = array(
			'provider'               => array( 'mailchimp' ),
			'button_text'            => array( esc_html__( 'Subscribe', 'mh-composer' ) ),
			'use_background_color'   => array( 'on' ),
			'background_color'       => array( mh_composer_accent_color(), 'append_default' ),
			'background_layout'      => array( 'dark' ),
			'text_orientation'       => array( 'right' ),
			'form_style' 			 => array('off'),
			'jetpack_count'   		  => array( 'off' ),
			'mailpoet_count'		 => array( 'off' ),
		);
		
		$this->custom_css_options = array(
			'newsletter_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => '.mhc_newsletter_description h2',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'newsletter_form' => array(
				'label'    => esc_html__( 'Form', 'mh-composer' ),
				'selector' => '.mhc_newsletter_form',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'newsletter_button' => array(
				'label'    => esc_html__( 'Button', 'mh-composer' ),
				'selector' => '.mhc_newsletter_button',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$mhc_mailchimp_lists_options = array( 'none' => esc_html__( 'Select the list', 'mh-composer' ) );

		$mhc_mailchimp_lists = mhc_get_mailchimp_lists();

		if ( $mhc_mailchimp_lists ) {
			foreach ( $mhc_mailchimp_lists as $mhc_mailchimp_list_key => $mhc_mailchimp_list_name ) {
				$mhc_mailchimp_lists_options[ $mhc_mailchimp_list_key ] = $mhc_mailchimp_list_name;
			}
		}

		$fields = array(
			'provider' => array(
				'label'           => esc_html__( 'Service Provider', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'mailchimp'	 => esc_html__( 'MailChimp', 'mh-composer' ),
					'jetpack'	   => esc_html__( 'Jetpack', 'mh-composer' ),
					'feedburner'	=> esc_html__( 'FeedBurner', 'mh-composer' ),
					'mailpoet'	  => esc_html__( 'MailPoet', 'mh-composer' ),
				),
				'affects' => array(
					'#mhc_feedburner_uri',
					'#mhc_mailchimp_list',
					'#mhc_jetpack_count',
					'#mhc_mailpoet_form',
					'#mhc_mailpoet_count',
					'#mhc_mailpoet_count_text',
				),
				'description'       => esc_html__( 'Here you can choose a service provider.', 'mh-composer' ),
			),
			'feedburner_uri' => array(
				'label'           => esc_html__( 'Feed Title', 'mh-composer' ),
				'type'            => 'text',
				'depends_show_if' => 'feedburner',
				'description'     => mh_wp_kses( sprintf( __( 'Enter <a href="%1$s" target="_blank">Feed Title</a>.', 'mh-composer'), esc_url( 'http://feedburner.google.com/fb/a/myfeeds' ) ) ),
			),
			'mailchimp_list' => array(
				'label'           => esc_html__( 'MailChimp lists', 'mh-composer' ),
				'type'            => 'select',
				'options'         => $mhc_mailchimp_lists_options,
				'description'     => esc_html__( "Here you can choose to which MailChimp list to add customers. If you don't see any lists here, you need to make sure the MailChimp API key is set in Theme Panel and you have at least one list in your MailChimp account. If you have created a new list, but it doesn't appear here, activate 'Regenerate MailChimp Lists' option in Theme Panel. Don't forget to disable it once the list has been regenerated.", 'mh-composer'),
				'depends_show_if' => 'mailchimp',
			),
			'jetpack_count' => array(
				'label'             => esc_html__( 'Show Count', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_show_if' => 'jetpack',
				'description'       => esc_html__( 'Here you can choose to show your subscribers count.', 'mh-composer' ),
			),
			'mailpoet_form' => array(
				'label'           => esc_html__( 'Form', 'mh-composer' ),
				'renderer'        => 'mh_mailpoet_option',
				'description'     => esc_html__( 'Select the desired form. Note: to use this option you need to have "MailPoet" plugin installed and activated. Create your at least one form to be able to use it.', 'mh-composer' ),
				'depends_show_if' => 'mailpoet',
			),
			'mailpoet_count' => array(
				'label'             => esc_html__( 'Show Count', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_show_if' => 'mailpoet',
				'description'       => esc_html__( 'Here you can choose to show your subscribers count.', 'mh-composer' ),
				'affects' => array(
					'#mhc_mailpoet_count_text',
				),
			),
			'mailpoet_count_text' => array(
				'label'           => esc_html__( 'Count Label', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( '(Optional) input a text to display with your count.', 'mh-composer' ),
				'depends_show_if' => 'on',
			),
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Choose a title of your signup box.', 'mh-composer' ),
			),
			'button_text' => array(
				'label'             => esc_html__( 'Button Text', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Here you can change the text used for the signup button.', 'mh-composer' ),
				'depends_show_if_not' => 'mailpoet',
			),
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options(),
				'description'       => esc_html__( 'This will adjust the alignment of the text.', 'mh-composer' ),
			),
			'use_background_color' => array(
				'label'             => esc_html__( 'Use Background Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_background_color',
				),
				'description'       => esc_html__( 'Here you can choose whether background colour setting below should be used.', 'mh-composer' ),
			),
			'background_color' => array(
				'label'             => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Define a custom background colour for your component, or leave blank to use the default colour.', 'mh-composer' ),
				'depends_default'   => true,
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
					'light' => esc_html__( 'Dark', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			'form_style' => array(
				'label'           => esc_html__( 'Form Style', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'off'   => esc_html__( 'Default', 'mh-composer' ),
					'transparent' => esc_html__( 'Transparent', 'mh-composer' ),
					'bordered' => esc_html__( 'Bordered', 'mh-composer' ),
					'transparent-bordered' => esc_html__( 'Transparent and Bordered', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose the style for your form.', 'mh-composer' ),
			),
			'content_new' => array(
				'label'             => esc_html__( 'Content', 'mh-composer' ),
				'type'              => 'tiny_mce',
				'description'       => esc_html__( 'Input the main text content for your component here.', 'mh-composer' ),
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
		$module_id                   = $this->shortcode_atts['module_id'];
		$module_class                = $this->shortcode_atts['module_class'];
		$title                       = $this->shortcode_atts['title'];
		$button_text                 = $this->shortcode_atts['button_text'];
		$background_color            = $this->shortcode_atts['background_color'];
		$text_orientation            = $this->shortcode_atts['text_orientation'];
		$use_background_color        = $this->shortcode_atts['use_background_color'];
		$provider                    = $this->shortcode_atts['provider'];
		$mailchimp_list              = $this->shortcode_atts['mailchimp_list'];
		$jetpack_count               = $this->shortcode_atts['jetpack_count'];
		$feedburner_uri              = $this->shortcode_atts['feedburner_uri'];
		$mailpoet_form		 	   = $this->shortcode_atts['mailpoet_form'];
		$mailpoet_count			  = $this->shortcode_atts['mailpoet_count'];
		$mailpoet_count_text		 = $this->shortcode_atts['mailpoet_count_text'];
		$background_layout           = $this->shortcode_atts['background_layout'];
		$form_style           		  = $this->shortcode_atts['form_style'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );


		$class = " mhc_module mhc_bg_layout_{$background_layout} mhc_text_align_{$text_orientation}";
		if ('off' !== $form_style){
			$class .= " mh-form-{$form_style}";
		}

		$form = '';

		$firstname     = esc_html__( 'First Name', 'mh-composer' );
		$lastname      = esc_html__( 'Last Name', 'mh-composer' );
		$email_address = esc_html__( 'Email Address', 'mh-composer' );

		switch ( $provider ) {
			case 'jetpack':
				$form = sprintf(
					'<div class="mhc_newsletter_form mhc_jetpack_form">
						%1$s
					</div>',
					do_shortcode(
						sprintf( '[jetpack_subscription_form title=" " subscribe_text=" " subscribe_button="%1$s" show_subscribers_total="%2$s"]',
							esc_html( $button_text ),
							( 'on' === $jetpack_count ? '1'  : '0')
						)
					)
				);

			break;
			case 'mailchimp' :
				if ( ! in_array( $mailchimp_list, array( '', 'none' ) ) ) {
					$form = sprintf( '
						<div class="mhc_newsletter_form">
							<div class="mhc_newsletter_result"></div>
							<p>
								<label class="mhc_contact_form_label" for="mhc_signup_firstname" style="display: none;">%3$s</label>
								<input id="mhc_signup_firstname" class="input" type="text" value="%4$s" name="mhc_signup_firstname">
							</p>
							<p>
								<label class="mhc_contact_form_label" for="mhc_signup_lastname" style="display: none;">%5$s</label>
								<input id="mhc_signup_lastname" class="input" type="text" value="%6$s" name="mhc_signup_lastname">
							</p>
							<p>
								<label class="mhc_contact_form_label" for="mhc_signup_email" style="display: none;">%7$s</label>
								<input id="mhc_signup_email" class="input" type="text" value="%8$s" name="mhc_signup_email">
							</p>
							<p><a class="mhc_newsletter_button mhc_button" href="#"><span class="mh_subscribe_loader"></span><span class="mhc_newsletter_button_text">%1$s</span></a></p>
							<input type="hidden" value="%2$s" name="mhc_signup_list_id" />
						</div>',
						esc_html( $button_text ),
						( ! in_array( $mailchimp_list, array( '', 'none' ) ) ? esc_attr( $mailchimp_list ) : '' ),
						esc_html( $firstname ),
						esc_attr( $firstname ),
						esc_html( $lastname ),
						esc_attr( $lastname ),
						esc_html( $email_address ),
						esc_attr( $email_address )
					);
				}

				break;
			case 'feedburner':
				$form = sprintf( '
					<div class="mhc_newsletter_form mhc_feedburner_form">
						<form action="https://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(\'https://feedburner.google.com/fb/a/mailverify?uri=%4$s\', \'popupwindow\', \'scrollbars=yes,width=550,height=520\'); return true">
						<p>
							<label class="mhc_contact_form_label" for="email" style="display: none;">%2$s</label>
							<input id="email" class="input" type="text" value="%3$s" name="email">
						</p>
						<p><button class="mhc_newsletter_button mhc_button" type="submit">%1$s</button></p>
						<input type="hidden" value="%4$s" name="uri" />
						<input type="hidden" name="loc" value="%5$s" />
						</form>
					</div>',
					esc_html( $button_text ),
					esc_html( $email_address ),
					esc_attr( $email_address ),
					esc_attr( $feedburner_uri ),
					esc_attr( get_locale() )
				);

				break;
			case 'mailpoet':
			$form = sprintf(
				'<div class="mhc_newsletter_form mhc_mailpoet_form">%1$s%2$s</div>',
				do_shortcode('[wysija_form id="'. $mailpoet_form .'"]'),
				( 'on' === $mailpoet_count ? sprintf(
					'<div class="mhc_mailpoet_count">%1$s%2$s</div>',
					esc_html( $mailpoet_count_text ),
					do_shortcode('[wysija_subscribers_count]')
				) : '')
			);
		}

		$output = sprintf(
			'<div%6$s class="mhc_newsletter mhc_subscribe clearfix%4$s%7$s%8$s"%5$s>
				<div class="mhc_newsletter_description">
					%1$s
					%2$s
				</div>
				%3$s
			</div>',
			( '' !== $title ? '<h2>' . esc_html( $title ) . '</h2>' : '' ),
			$this->shortcode_content,
			$form,
			esc_attr( $class ),
			( 'on' === $use_background_color
				? sprintf( ' style="background-color: %1$s;"', esc_attr( $background_color ) )
				: ''
			),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			( 'on' !== $use_background_color ? ' mhc_no_bg' : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Signup;