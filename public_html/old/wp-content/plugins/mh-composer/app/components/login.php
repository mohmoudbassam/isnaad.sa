<?php
class MHComposer_Component_Login extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Login', 'mh-composer' );
		$this->slug = 'mhc_login';
		$this->main_css_selector = '%%order_class%%.mhc_login';

		$this->approved_fields = array(
			'title',
			'current_page_redirect',
			'use_background_color',
			'background_color',
			'background_layout',
			'text_orientation',
			'form_style',
			'content_new',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'current_page_redirect'  => array( 'off' ),
			'use_background_color'   => array( 'on' ),
			'background_color'       => array( mh_composer_accent_color(), 'append_default' ),
			'background_layout'      => array( 'light' ),
			'text_orientation'       => array( 'right' ),
			'form_style' => array('off'),
		);
		
		$this->custom_css_options = array(
			'login_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => '.mhc_newsletter_description h2',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'login_form' => array(
				'label'    => esc_html__( 'Form', 'mh-composer' ),
				'selector' => '.mhc_newsletter_form',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'login_button' => array(
				'label'    => esc_html__( 'Button', 'mh-composer' ),
				'selector' => '.mhc_newsletter_button',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Choose a title of your login box.', 'mh-composer' ),
			),
			'current_page_redirect' => array(
				'label'           => esc_html__( 'Redirect To The Current Page', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose whether the user should be redirected to the current page.', 'mh-composer' ),
			),
			'use_background_color' => array(
				'label'           => esc_html__( 'Use Background Colour', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'          => esc_html__( 'Yes', 'mh-composer' ),
					'off'         => esc_html__( 'No', 'mh-composer' ),
				),
				'affects' => array(
					'#mhc_background_color',
				),
				'description' => esc_html__( 'Here you can choose whether background colour setting below should be used.', 'mh-composer' ),
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
				'options'      	  => array(
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
					'light' => esc_html__( 'Dark', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options(),
				'description'       => esc_html__( 'This will adjust the alignment of the text.', 'mh-composer' ),
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
		$background_color            = $this->shortcode_atts['background_color'];
		$background_layout           = $this->shortcode_atts['background_layout'];
		$text_orientation            = $this->shortcode_atts['text_orientation'];
		$use_background_color        = $this->shortcode_atts['use_background_color'];
		$current_page_redirect       = $this->shortcode_atts['current_page_redirect'];
		$content                     = $this->shortcode_content;
		$form_style            	  = $this->shortcode_atts['form_style'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );


		$redirect_url = 'on' === $current_page_redirect
			? ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
			: '';

		if ( is_user_logged_in() ) {
			
			$current_user = wp_get_current_user();
			
			$content .= sprintf( '<br/>%1$s <a href="%2$s">%3$s</a>',
				sprintf( esc_html__( 'Logged in as %1$s', 'mh-composer' ), esc_html( $current_user->display_name ) ),
				esc_url( wp_logout_url( $redirect_url ) ),
				esc_html__( 'Log out', 'mh-composer' )
			);
		}

		$class = " mhc_module mhc_bg_layout_{$background_layout} mhc_text_align_{$text_orientation}";
		if ('off' !== $form_style){
			$class .= " mh-form-{$form_style}";
		}

		$form = '';

		if ( !is_user_logged_in() ) {
			$username = esc_html__( 'Username', 'mh-composer' );
			$password = esc_html__( 'Password', 'mh-composer' );

			$form = sprintf( '
				<div class="mhc_newsletter_form mhc_login_form">
					<form action="%7$s" method="post">
						<p>
							<label class="mhc_contact_form_label" for="user_login" style="display: none;">%3$s</label>
							<input id="user_login" placeholder="%4$s" class="input" type="text" value="" name="log" />
						</p>
						<p>
							<label class="mhc_contact_form_label" for="user_pass" style="display: none;">%5$s</label>
							<input id="user_pass" placeholder="%6$s" class="input" type="password" value="" name="pwd" />
						</p>
						<p class="mhc_forgot_password"><a href="%2$s">%1$s</a></p>
						<p>
							<button type="submit" class="mhc_newsletter_button mhc_button">%8$s</button>
							%9$s
						</p>
					</form>
				</div>',
				esc_html__( 'Forgot your password?', 'mh-composer' ),
				esc_url( wp_lostpassword_url() ),
				esc_html( $username ),
				esc_attr( $username ),
				esc_html( $password ),
				esc_attr( $password ),
				esc_url( site_url( 'wp-login.php', 'login_post' ) ),
				esc_html__( 'Login', 'mh-composer' ),
				( 'on' === $current_page_redirect
					? sprintf( '<input type="hidden" name="redirect_to" value="%1$s" />',  $redirect_url )
					: ''
				)
			);
		}

		$output = sprintf(
			'<div%6$s class="mhc_newsletter mhc_login clearfix%4$s%7$s"%5$s>
				<div class="mhc_newsletter_description">
					%1$s
					%2$s
				</div>
				%3$s
			</div>',
			( '' !== $title ? '<h2>' . esc_html( $title ) . '</h2>' : '' ),
			$content,
			$form,
			esc_attr( $class ),
			( 'on' === $use_background_color
				? sprintf( ' style="background-color: %1$s;"', esc_attr( $background_color ) )
				: ''
			),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Login;