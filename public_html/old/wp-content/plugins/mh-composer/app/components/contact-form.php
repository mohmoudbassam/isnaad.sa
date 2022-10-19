<?php
class MHComposer_Component_Contact_Form extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Contact Form', 'mh-composer' );
		$this->slug = 'mhc_contact_form';
		$this->child_slug      = 'mhc_contact_field';
		$this->child_item_text = esc_html__( 'Add New Field', 'mh-composer' );
		$this->main_css_selector = '%%order_class%%.mhc_contact_form_container';

		$this->approved_fields = array(
			'captcha',
			'email',
			'title',
			'message',
			'background_layout',
			'button_style',
			'form_style',
			'admin_label',
			'module_id',
			'module_class',
			'message_pattern',
			'use_redirect',
			'redirect_url',
			'blurb',
		);

		$this->fields_defaults = array(
			'captcha'      => array( 'on' ),
			'background_layout'  => array( 'light' ),
			'button_style' 	   => array( 'transparent' ),
			'form_style' 		 => array('off'),
			'use_redirect' => array( 'off' ),
		);

		$this->custom_css_options = array(
			'contact_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => '.mhc_contact_main_title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'contact_blurb' => array(
				'label'    => esc_html__( 'Blurb', 'mh-composer' ),
				'selector' => '.mhc_contact_blurb',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'contact_button' => array(
				'label'    => esc_html__( 'Button', 'mh-composer' ),
				'selector' => '.mhc_contact_submit',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'contact_fields' => array(
				'label'    => esc_html__( 'Fields', 'mh-composer' ),
				'selector' => '.mhc_contact_left input',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'text_field' => array(
				'label'    => esc_html__( 'Message Field', 'mh-composer' ),
				'selector' => 'textarea.mhc_contact_message',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'captcha' => array(
				'label'           => esc_html__( 'Display Captcha', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description' => esc_html__( 'Turn the captcha on or off using this option.', 'mh-composer' ),
			),
			'email' => array(
				'label'           => esc_html__( 'Email', 'mh-composer' ),
				'type'            => 'text',
				'description'     => mh_wp_kses( __( "Input the email address where messages should be sent. It is recommended to use an email that is associated with your web domain, e.g. info@your-website.com or mail@your-website.com<br /><br />Note: you must create this email via your server's cPanel.", "mh-composer" ) ),
			),
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define a title for your contact form.', 'mh-composer' ),
			),
			'blurb' => array(
				'label'             => esc_html__( 'Excerpt', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Define an excerpt for your contact form.', 'mh-composer' ),
			),
			'message' => array(
				'label'           => esc_html__( 'Success Message', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define a message to display after successful form submission. Leave empty to use the default message.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'light' => esc_html__( 'Dark', 'mh-composer' ),
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			'form_style' => array(
				'label'           => esc_html__( 'Form Style', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'off'   				  => esc_html__( 'Default', 'mh-composer' ),
					'transparent' 		  => esc_html__( 'Transparent', 'mh-composer' ),
					'bordered' 			 => esc_html__( 'Bordered', 'mh-composer' ),
					'transparent-bordered' => esc_html__( 'Transparent and Bordered', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose the style for your form.', 'mh-composer' ),
			),
			'button_style' => array(
				'label'           => esc_html__( 'Button Style', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'transparent'  => esc_html__( 'Transparent', 'mh-composer' ),
					'solid' 		=> esc_html__( 'Solid', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This defines the button style.', 'mh-composer' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'mh-composer' ),
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
			'use_redirect' => array(
				'label'           => esc_html__( 'Redirect URL', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects' => array(
					'#mhc_redirect_url',
				),
				'description' => esc_html__( 'Redirect visitors after successful form submission.', 'mh-composer' ),
				'tab_slug'        => 'advanced',
			),
			'redirect_url' => array(
				'label'           => esc_html__( 'Redirect URL', 'mh-composer' ),
				'type'            => 'text',
				'depends_show_if' => 'on',
				'description'     => esc_html__( 'Input the Redirect URL.', 'mh-composer' ),
				'tab_slug'        => 'advanced',
			),
			'message_pattern' => array(
				'label'           => esc_html__( 'Message Pattern', 'mh-composer' ),
				'type'            => 'textarea',
				'description'     => mh_wp_kses( __( 'Here you can define a custom pattern for the email message. Fields should be included in the following format - <strong>%%field_id%%</strong>. For example, if you want to include the field with id = <strong>phone</strong> and field with id = <strong>message</strong>, then you can use the following pattern: <strong>My message is %%message%% and phone number is %%phone%%</strong>. Leave empty to use the default pattern.', 'mh-composer' ) ),
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

	function predefined_child_modules() {
		$output = sprintf(
			'[mhc_contact_field field_title="%1$s" field_type="input" field_id="Name" required_mark="on" fullwidth_field="off" /][mhc_contact_field field_title="%2$s" field_type="email" field_id="Email" required_mark="on" fullwidth_field="off" /][mhc_contact_field field_title="%3$s" field_type="text" field_id="Message" required_mark="on" /]',
			esc_attr__( 'Name', 'mh-composer' ),
			esc_attr__( 'Email Address', 'mh-composer' ),
			esc_attr__( 'Message', 'mh-composer' )
		);

		return $output;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id             = $this->shortcode_atts['module_id'];
		$module_class          = $this->shortcode_atts['module_class'];
		$captcha               = $this->shortcode_atts['captcha'];
		$email                 = $this->shortcode_atts['email'];
		$title                 = $this->shortcode_atts['title'];
		$message			   = $this->shortcode_atts['message'];
		$background_layout     = $this->shortcode_atts['background_layout'];
		$button_style          = $this->shortcode_atts['button_style'];
		$form_style            = $this->shortcode_atts['form_style'];
		$message_pattern       = $this->shortcode_atts['message_pattern'];
		$use_redirect          = $this->shortcode_atts['use_redirect'];
		$redirect_url          = $this->shortcode_atts['redirect_url'];
		$blurb	             = $this->shortcode_atts['blurb'];

		global $mhc_contact_form_num;

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		$class = " mhc_bg_layout_{$background_layout}";
		if ('off' !== $form_style){
			$class .= " mh-form-{$form_style}";
		}
		$buttonclass = " mhc_button_{$button_style}";

		$message = '' !== $message ? $message : esc_html__( 'Thank you for contacting us.', 'mh-composer' );

		$mhc_contact_form_num = $this->shortcode_callback_num();

		$content = $this->shortcode_content;

		$mh_error_message = '';
		$mh_contact_error = false;
		$current_form_fields = isset( $_POST['mhc_contact_email_fields_' . $mhc_contact_form_num] ) ? $_POST['mhc_contact_email_fields_' . $mhc_contact_form_num] : '';
		$contact_email = '';
		$processed_fields_values = array();

		$nonce_result = isset( $_POST['_wpnonce-mhc-contact-form-submitted'] ) && wp_verify_nonce( $_POST['_wpnonce-mhc-contact-form-submitted'], 'mhc-contact-form-submit' ) ? true : false;

		// check that the form was submitted and mhc_contactform_hpv field is empty to protect from spam
		if ( $nonce_result && isset( $_POST['mhc_contactform_submit_' . $mhc_contact_form_num] ) && empty( $_POST['mhc_contactform_hpv_' . $mhc_contact_form_num] ) ) {
			if ( '' !== $current_form_fields ) {
				$fields_data_json = str_replace( '\\', '' ,  $current_form_fields );
				$fields_data_array = json_decode( $fields_data_json, true );

				// check whether captcha field is not empty
				if ( 'on' === $captcha && ( ! isset( $_POST['mhc_contact_captcha_' . $mhc_contact_form_num] ) || empty( $_POST['mhc_contact_captcha_' . $mhc_contact_form_num] ) ) ) {
					$mh_error_message .= sprintf( '<p class="mhc_contact_error_text">%1$s</p>', esc_html__( 'Make sure you entered the captcha.', 'mh-composer' ) );
					$mh_contact_error = true;
				}

				// check all fields on current form and generate error message if needed
				if ( ! empty( $fields_data_array ) ) {
					foreach( $fields_data_array as $index => $value ) {
						// check all the required fields, generate error message if required field is empty
						if ( 'required' === $value['required_mark'] && empty( $_POST[ $value['field_id'] ] ) ) {
							$mh_error_message .= sprintf( '<p class="mhc_contact_error_text">%1$s</p>', esc_html__( 'Make sure you fill in all required fields.', 'mh-composer' ) );
							$mh_contact_error = true;
							continue;
						}

						// additional check for email field
						if ( 'email' === $value['field_type'] && 'required' === $value['required_mark'] && ! empty( $_POST[ $value['field_id'] ] ) ) {
							$contact_email = sanitize_email( $_POST[ $value['field_id'] ] );
							if ( ! is_email( $contact_email ) ) {
								$mh_error_message .= sprintf( '<p class="mhc_contact_error_text">%1$s</p>', esc_html__( 'Invalid Email.', 'mh-composer' ) );
								$mh_contact_error = true;
							}
						}

						// prepare the array of processed field values in convenient format
						if ( false === $mh_contact_error ) {
							$processed_fields_values[ $value['original_id'] ]['value'] = isset( $_POST[ $value['field_id'] ] ) ? $_POST[ $value['field_id'] ] : '';
							$processed_fields_values[ $value['original_id'] ]['label'] = $value['field_label'];
						}
					}
				}
			} else {
				$mh_error_message .= sprintf( '<p class="mhc_contact_error_text">%1$s</p>', esc_html__( 'Make sure you fill in all required fields.', 'mh-composer' ) );
				$mh_contact_error = true;
			}
		} else {
			if ( false === $nonce_result && isset( $_POST['mhc_contactform_submit_' . $mhc_contact_form_num] ) && empty( $_POST['mhc_contactform_hpv_' . $mhc_contact_form_num] ) ) {
				$mh_error_message .= sprintf( '<p class="mhc_contact_error_text">%1$s</p>', esc_html__( 'Please refresh the page and try again.', 'mh-composer' ) );
			}
			$mh_contact_error = true;
		}

		// generate digits for captcha
		$mhc_first_digit = rand( 1, 15 );
		$mhc_second_digit = rand( 1, 15 );

		if ( ! $mh_contact_error && $nonce_result ) {
			$mh_email_to = '' !== $email
				? $email
				: get_site_option( 'admin_email' );

			$mh_site_name = get_option( 'blogname' );

			$contact_name = isset( $processed_fields_values['name'] ) ? stripslashes( sanitize_text_field( $processed_fields_values['name']['value'] ) ) : '';

			if ( '' !== $message_pattern ) {
				$message_pattern = $message_pattern;
				// insert the data from contact form into the message pattern
				foreach ( $processed_fields_values as $key => $value ) {
					$message_pattern = str_ireplace( "%%{$key}%%", $value['value'], $message_pattern );
				}
			} else {
				// use default message pattern if custom pattern is not defined
				$message_pattern = isset( $processed_fields_values['message']['value'] ) ? $processed_fields_values['message']['value'] : '';

				// Add all custom fields into the message body by default
				foreach ( $processed_fields_values as $key => $value ) {
					if ( ! in_array( $key, array( 'message', 'name', 'email' ) ) ) {
						$message_pattern .= "\r\n";
						$message_pattern .= sprintf(
							'%1$s: %2$s',
							'' !== $value['label'] ? $value['label'] : $key,
							$value['value']
						);
					}
				}
			}

			$headers[] = "From: \"{$contact_name}\" <{$contact_email}>";
			$headers[] = "Reply-To: \"{$contact_name}\" <{$contact_email}>";
			
			$http_host = str_replace( 'www.', '', $_SERVER['HTTP_HOST'] );

			$headers[] = "From: \"{$contact_name}\" <mail@{$http_host}>";
			$headers[] = "Reply-To: \"{$contact_name}\" <{$contact_email}>";
			
			add_filter( 'mh_wp_kses', 'mh_allow_ampersand' );
			
			$email_message = trim( stripslashes( wp_strip_all_tags( $message_pattern ) ) );
			

			wp_mail( apply_filters( 'mh_contact_page_email_to', $mh_email_to ),
				mh_wp_kses( sprintf(
					__( 'New Message From %1$s%2$s', 'mh-composer' ),
					sanitize_text_field( html_entity_decode( $mh_site_name ) ),
					( '' !== $title ? sprintf( _x( ' - %s', 'contact form title separator', 'mh-composer' ), sanitize_text_field( html_entity_decode( $title ) ) ) : '' )	
				) ),
				! empty( $email_message ) ? $email_message : ' ',
				apply_filters( 'mh_contact_page_headers', $headers, $contact_name, $contact_email )
					
				//stripslashes( wp_strip_all_tags( $message_pattern ) ), apply_filters( 'mh_contact_page_headers', $headers, $contact_name, $contact_email ) );
				);

			remove_filter( 'mh_wp_kses', 'mh_allow_ampersand' );

			//$et_error_message = sprintf( '<p>%1$s</p>', esc_html( $success_message ) );

			$mh_error_message = sprintf( '<p class="mhc_contact_submit_message">%1$s</p>', esc_html( $message ) );
		}

		$form = '';

		$mhc_captcha = sprintf( '
			<div class="mhc_contact_left">
				<p class="clearfix">
					<span class="mhc_contact_captcha_quiz">%1$s</span> = <input type="text" size="2" class="input mhc_contact_captcha" data-first_digit="%3$s" data-second_digit="%4$s" value="" name="mhc_contact_captcha_%2$s" data-required_mark="required">
				</p>
			</div> <!-- .mhc_contact_left -->',
			sprintf( '%1$s + %2$s', esc_html( $mhc_first_digit ), esc_html( $mhc_second_digit ) ),
			esc_attr( $mhc_contact_form_num ),
			esc_attr( $mhc_first_digit ),
			esc_attr( $mhc_second_digit )
		);

		if ( '' === trim( $content ) ) {
			$content = do_shortcode( $this->predefined_child_modules() );
		}

		if ( $mh_contact_error ) {
			$form = sprintf( '
				<div class="mhc_contact">
					<form class="mhc_contact_form clearfix" method="post" action="%1$s">
						<div class="mhc_contact_right">
							%7$s
						</div> <!-- .mhc_contact_right -->
						<div class="clear"></div>
						<input type="hidden" value="mh_contact_proccess" name="mhc_contactform_submit_%5$s">
						<input type="text" value="" name="mhc_contactform_hpv_%5$s" class="mhc_contactform_hpv_field" />
						<div class="mh_contact_bottom_container">
							<button type="submit" class="mhc_contact_submit mhc_button%6$s">%3$s</button>
							%2$s
						</div>
						%4$s
					</form>
				</div> <!-- .mhc_contact -->',
				esc_url( get_permalink( get_the_ID() ) ),
				(  'on' === $captcha ? $mhc_captcha : '' ),
				esc_html__( 'Submit', 'mh-composer' ),
				wp_nonce_field( 'mhc-contact-form-submit', '_wpnonce-mhc-contact-form-submitted', true, false ),
				esc_attr( $mhc_contact_form_num ),
				esc_attr( $buttonclass ),
				$content
			);
		}

		$output = sprintf( '
			<div id="%4$s" class="mhc_module mhc_contact_form_container mhc_pct clearfix%5$s%9$s" data-form_unique_num="%6$s"%7$s>
				%1$s
				%8$s
				<div class="mhc-contact-message">%2$s</div>
				%3$s
			</div> <!-- .mhc_contact_form_container -->
			',
			( '' !== $title ? sprintf( '<h1 class="mhc_contact_main_title">%1$s</h1>', esc_html( $title ) ) : '' ),
			'' !== $mh_error_message ? $mh_error_message : '',
			$form,
			( '' !== $module_id
				? esc_attr( $module_id )
				: esc_attr( 'mhc_contact_form_' . $mhc_contact_form_num )
			),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			esc_attr( $mhc_contact_form_num ),
			'on' === $use_redirect && '' !== $redirect_url ? sprintf( ' data-redirect_url="%1$s"', esc_attr( $redirect_url ) ) : '',
			( '' !== $blurb ? sprintf( '<div class="mhc_contact_blurb">%1$s</div>', esc_html( $blurb ) ) : '' ),
			esc_attr( $class )
		);

		return $output;
	}
}
new MHComposer_Component_Contact_Form;

class MHComposer_Component_Contact_Form_Item extends MHComposer_Component {
	function init() {
		$this->name            = esc_html__( 'Field', 'mh-composer' );
		$this->slug            = 'mhc_contact_field';
		$this->type            = 'child';
		$this->child_title_var = 'field_title';

		$this->approved_fields = array(
			'field_title',
			'field_type',
			'field_id',
			'required_mark',
			'fullwidth_field',
		);

		$this->advanced_setting_title_text = esc_html__( 'New Field', 'mh-composer' );
		$this->settings_text               = esc_html__( 'Field Settings', 'mh-composer' );
		$this->main_css_selector = '%%order_class%%.mhc_contact_field .input';
	}

	function get_fields() {
		$fields = array(
			'field_title' => array(
				'label'       => esc_html__( 'Title', 'mh-composer' ),
				'type'        => 'text',
				'description' => esc_html__( 'Here you can define the field title.', 'mh-composer' ),
			),
			'field_id' => array(
				'label'       => esc_html__( 'Field ID', 'mh-composer' ),
				'type'        => 'text',
				'description' => esc_html__( 'Define a unique ID for this field. You should use only English letters without spaces.', 'mh-composer' ),
			),
			'field_type' => array(
				'label'       => esc_html__( 'Field Type', 'mh-composer' ),
				'type'        => 'select',
				'options'         => array(
					'input' => esc_html__( 'Input Field', 'mh-composer' ),
					'email' => esc_html__( 'Email Field', 'mh-composer' ),
					'text'  => esc_html__( 'Textarea', 'mh-composer' ),
				),
				'description' => esc_html__( 'Choose the field type.', 'mh-composer' ),
			),
			'required_mark' => array(
				'label'           => esc_html__( 'Required', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description' => esc_html__( 'Define whether this field should be required or optional.', 'mh-composer' ),
			),
			'fullwidth_field' => array(
				'label'           => esc_html__( 'Full-width', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description' => esc_html__( 'By default, the field will take 50% of the width of the content area. Enable this option to make it 100% width.', 'mh-composer' ),
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$field_title            = $this->shortcode_atts['field_title'];
		$field_type             = $this->shortcode_atts['field_type'];
		$field_id               = $this->shortcode_atts['field_id'];
		$required_mark          = $this->shortcode_atts['required_mark'];
		$fullwidth_field        = $this->shortcode_atts['fullwidth_field'];

		global $mhc_contact_form_num;

		// do not output the fields with empty ID
		if ( '' === $field_id ) {
			return;
		}

		$field_id = strtolower( $field_id );

		$current_module_num = '' === $mhc_contact_form_num ? 0 : intval( $mhc_contact_form_num ) + 1;

		$module_class = MHComposer_Core::add_module_order_class( '', $function_name );

		$this->half_width_counter = ! isset( $this->half_width_counter ) ? 0 : $this->half_width_counter;

		// count fields to add the mhc_contact_field_last properly
		if ( 'off' === $fullwidth_field ) {
			$this->half_width_counter++;
		} else {
			$this->half_width_counter = 0;
		}

		$input_field = '';

		switch( $field_type ) {
			case 'text':
				$input_field = sprintf(
					'<textarea name="mhc_contact_%3$s_%2$s" id="mhc_contact_%3$s_%2$s" class="mhc_contact_message input" data-required_mark="%5$s" data-field_type="%4$s" data-original_id="%3$s">%1$s</textarea>',
					( isset( $_POST['mhc_contact_' . $field_id . '_' . $current_module_num] ) ? esc_html( sanitize_text_field( $_POST['mhc_contact_' . $field_id . '_' . $current_module_num] ) ) : esc_html( $field_title ) ),
					esc_attr( $current_module_num ),
					esc_attr( $field_id ),
					esc_attr( $field_type ),
					'off' === $required_mark ? 'not_required' : 'required'
				);
				break;
			case 'input' :
			case 'email' :
				$input_field = sprintf(
					'<input type="text" id="mhc_contact_%3$s_%2$s" class="input" value="%1$s" name="mhc_contact_%3$s_%2$s" data-required_mark="%5$s" data-field_type="%4$s" data-original_id="%3$s">',
					( isset( $_POST['mhc_contact_' . $field_id . '_' . $current_module_num] ) ? esc_attr( sanitize_text_field( $_POST['mhc_contact_' . $field_id . '_' . $current_module_num] ) ) : esc_attr( $field_title ) ),
					esc_attr( $current_module_num ),
					esc_attr( $field_id ),
					esc_attr( $field_type ),
					'off' === $required_mark ? 'not_required' : 'required'
				);
				break;
		}

		$output = sprintf(
			'<p class="mhc_contact_field%5$s%6$s%7$s">
				<label for="mhc_contact_%3$s_%2$s" class="mhc_contact_form_label">%1$s</label>
				%4$s
			</p>',
			esc_html( $field_title ),
			esc_attr( $current_module_num ),
			esc_attr( $field_id ),
			$input_field,
			esc_attr( $module_class ),
			'off' === $fullwidth_field ? ' mhc_contact_field_half' : '',
			0 === $this->half_width_counter % 2 ? ' mhc_contact_field_last' : ''
		);

		return $output;
	}
}
new MHComposer_Component_Contact_Form_Item;