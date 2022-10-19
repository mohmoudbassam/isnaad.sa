<?php
if (class_exists('WPCF7', false)) {
class MHComposer_Component_Contact_Form7 extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Contact Form 7', 'mh-composer' );
		$this->slug = 'mhc_cf7';

		$this->approved_fields = array(
			'cf7',
			'title',
			'background_layout',
			'button_style',
			'form_style',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'background_layout' => array( 'light' ),
			'button_style' => array( 'transparent' ),
			'form_style' => array('off'),
		);

		$this->main_css_selector = '%%order_class%%.mhc_contact_form_container';
		
		$this->custom_css_options = array(
			'contact_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => '.mhc_contact_main_title',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'contact_button' => array(
				'label'    => esc_html__( 'Button', 'mh-composer' ),
				'selector' => '.wpcf7-form input[type="submit"]',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'cf7' => array(
				'label'           => esc_html__( 'Email', 'mh-composer' ),
				'renderer'        => 'mh_contact_form7_option',
				'description'     => esc_html__( 'Select the desired form. Note: to use this component you need to have "Contact Form 7" plugin installed and activated. Create at least one form to be able to use it.', 'mh-composer' ),
			),
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define a title for your contact form.', 'mh-composer' ),
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
		$module_id             = $this->shortcode_atts['module_id'];
		$module_class          = $this->shortcode_atts['module_class'];
		$cf7               	   = $this->shortcode_atts['cf7'];
		$title                 = $this->shortcode_atts['title'];
		$background_layout     = $this->shortcode_atts['background_layout'];
		$button_style          = $this->shortcode_atts['button_style'];
		$form_style            = $this->shortcode_atts['form_style'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		$class = " mhc_bg_layout_{$background_layout} mhc_wpcf7_{$button_style}";
		if ('off' !== $form_style){
			$class .= " mh-form-{$form_style}";
		}
		
		$output = sprintf(
			'<div %3$s class="mhc_contact7 mhc_pct mhc_module%4$s%6$s">%2$s%5$s</div>',
			$cf7,
			( '' !== $title ? sprintf( '<h3 class="mhc_contact_main_title">%1$s</h3>', esc_html( $title ) ) : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			do_shortcode('[contact-form-7 id="'. $cf7.'" title=""]'),
			esc_attr( $class )
	);
		
		return $output;
	}
}
new MHComposer_Component_Contact_Form7;
}