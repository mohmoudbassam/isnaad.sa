<?php
define( 'MH_COMPOSER_AJAX_TEMPLATES_AMOUNT', apply_filters( 'mhc_templates_loading_amount', 5 ) );
add_action( 'init', array( 'MHComposer_Core', 'set_media_queries' ), 11 );

class MHComposer_Core {
	public $name;
	public $slug;
	public $type;
	public $child_slug;
	public $decode_entities;
	public $fields = array();
	public $approved_fields = array();
	public $fields_unprocessed = array();
	public $main_css_selector;
	public $custom_css_options = array();
	public $child_title_var;
	public $child_title_fallback_var;
	public $shortcode_atts = array();
	public $shortcode_content;
	public $post_types = array();
	public $main_tabs = array();
	public $used_tabs = array();
	public $custom_css_tab;

	// number of times shortcode_callback function has been executed
	private $_shortcode_callback_num;

	// priority number, applied to some CSS rules
	private $_style_priority;

	private static $styles = array();
	private static $media_queries = array();
	private static $modules_order;
	private static $parent_modules = array();
	private static $child_modules = array();

	const DEFAULT_PRIORITY = 10;

	function __construct() {
		$this->init();

		$this->process_approved_fields();
		$this->set_fields();
		$this->_add_custom_css_fields();

		if ( ! isset( $this->main_css_selector ) ) {
			$this->main_css_selector = '%%order_class%%';
		}

		$this->_shortcode_callback_num = 0;

		$this->type = isset( $this->type ) ? $this->type : '';

		$this->decode_entities = isset( $this->decode_entities ) ? (bool) $this->decode_entities : false;

		$this->_style_priority = (int) self::DEFAULT_PRIORITY;
		if ( isset( $this->type ) && 'child' === $this->type ) {
			$this->_style_priority = $this->_style_priority + 1;
		}

		$this->main_tabs = $this->get_main_tabs();
		$this->custom_css_tab = isset( $this->custom_css_tab ) ? $this->custom_css_tab : true;

		$post_types = ! empty( $this->post_types ) ? $this->post_types : mh_composer_get_composer_post_types();

		if ( ! in_array( 'mhc_layout', $post_types ) ) {
			$post_types[] = 'mhc_layout';
		}

		$this->post_types = apply_filters( 'mh_composer_module_post_types', $post_types, $this->slug, $this->post_types );
		
		foreach ( $this->post_types as $post_type ) {
			if ( ! in_array( $post_type, $this->post_types ) ) {
				$this->register_post_type( $post_type );
			}

			if ( 'child' == $this->type ) {
				self::$child_modules[ $post_type ][ $this->slug ] = $this;
			} else {
				self::$parent_modules[ $post_type ][ $this->slug ] = $this;
			}
		}

		if ( ! isset( $this->no_shortcode_callback ) ) {
			$shortcode_slugs = array( $this->slug );

			if ( ! empty( $this->additional_shortcode_slugs ) ) {
				$shortcode_slugs = array_merge( $shortcode_slugs, $this->additional_shortcode_slugs );
			}

			foreach ( $shortcode_slugs as $shortcode_slug ) {
				add_shortcode( $shortcode_slug, array( $this, '_shortcode_callback' ) );
			}

			if ( isset( $this->additional_shortcode ) ) {
				add_shortcode( $this->additional_shortcode, array( $this, 'additional_shortcode_callback' ) );
			}
		}
	}

	function process_approved_fields() {
		$fields = array();

		foreach ( $this->approved_fields as $key ) {
			$fields[ $key ] = array();
		}

		$this->approved_fields = $fields;
	}

	/**
	 * Set $this->fields_unprocessed property to all field settings on backend.
	 * Store only default settings for use in shortcode_callback() on frontend.
	 */
	function set_fields() {
		$fields_defaults = array();

		$module_defaults = isset( $this->fields_defaults ) && is_array( $this->fields_defaults )
			? $this->fields_defaults
			: array();

		if ( ! empty( $module_defaults ) ) {
			foreach ( $module_defaults as $key => $default_setting ) {
				$setting_fields = array();

				$default_value = $module_defaults[ $key ][0];
				$use_append_default = isset( $module_defaults[ $key ][1] ) && 'append_default' === $module_defaults[ $key ][1];

				/**
				 * If default value is set, it should be used for "shortcode_default",
				 * unless 'append_default' is set
				 */
				if ( ! $use_append_default ) {
					$setting_fields['shortcode_default'] = $default_value;
				}

				/**
				 * Add "default" setting and set it to the default value,
				 * if 'append_default' is provided
				 */
				if ( $use_append_default ) {
					$setting_fields['default'] = $default_value;
				}

				$fields_defaults[ $key ] = $setting_fields;
			}
		}

		/**
		 * Only use approved fields names on frontend.
		 * All fields settings are only needed in Page Composer.
		 */
		$fields = ! is_admin() ? $this->approved_fields : $this->get_fields();

		# update settings with defaults
		foreach ( $fields as $key => $settings ) {
			if ( ! isset( $fields_defaults[ $key ] ) ) {
				continue;
			}

			$settings = array_merge( $settings, $fields_defaults[ $key ] );

			$fields[ $key ] = $settings;
		}

		$this->fields_unprocessed = $fields;
	}

	private function register_post_type( $post_type ) {
		$this->post_types[] = $post_type;
		self::$parent_modules[ $post_type ] = array();
		self::$child_modules[ $post_type ] = array();
	}

	/**
	 * Double quote are saved as "%22" in shortcode attributes.
	 * Decode them back into "
	 *
	 * @return void
	 */
	private function _decode_double_quotes() {
		if ( ! isset( $this->shortcode_atts ) ) {
			return;
		}

		$shortcode_attributes = array();
		$font_icon_options = array( 'overlay_icon', 'font_mhicons', 'font_steadysets', 'font_awesome', 'font_lineicons', 'font_etline', 'font_icomoon', 'font_linearicons' );

		foreach ( $this->shortcode_atts as $attribute_key => $attribute_value ) {
			$shortcode_attributes[ $attribute_key ] = in_array( $attribute_key, $font_icon_options ) || preg_match( "/^\%\%\d+\%\%$/i", $attribute_value ) ? $attribute_value : str_replace( '%22', '"', $attribute_value );
		}

		$this->shortcode_atts = $shortcode_attributes;
	}

	/**
	 * Provide a way for sub-class to access $this->_shortcode_callback_num without a chance to alter its value
	 *
	 * @return int
	 */
	protected function shortcode_callback_num() {
		return $this->_shortcode_callback_num;
	}

	function _shortcode_callback( $atts, $content = null, $function_name ) {
		$this->shortcode_atts = shortcode_atts( $this->get_shortcode_fields(), $atts );

		$this->_decode_double_quotes();

		//$this->_maybe_remove_default_atts_values();

		$shared_shortcode_content = false;

		// If the section/row/module is disabled, hide it
		if ( isset( $this->shortcode_atts['disabled'] ) && 'on' === $this->shortcode_atts['disabled'] ) {
			return;
		}

		//override module attributes for shared module
		if ( ! empty( $this->shortcode_atts['shared_module'] ) ) {
			$shared_content = mhc_load_shared_module( $this->shortcode_atts['shared_module'] );

			if ( '' !== $shared_content ) {
				$shared_atts = shortcode_parse_atts( $shared_content );

				foreach( $this->shortcode_atts as $single_attr => $value ) {
					if ( isset( $shared_atts[$single_attr] ) ) {
						$this->shortcode_atts[$single_attr] = $shared_atts[$single_attr];
					}
				}

				if ( false !== strpos( $this->shortcode_atts['saved_tabs'], 'general' ) || 'all' === $this->shortcode_atts['saved_tabs'] ) {
					$shared_shortcode_content = mhc_extract_shortcode_content( $shared_content, $function_name );
				}
			}
		}

		self::set_order_class( $function_name );

		$this->pre_shortcode_content();

		$content = false !== $shared_shortcode_content ? $shared_shortcode_content : $content;

		$this->shortcode_content = ! ( isset( $this->is_structure_element ) && $this->is_structure_element ) ? do_shortcode( mhc_fix_shortcodes( $content, $this->decode_entities ) ) : '';

		$this->shortcode_atts();
		
		$this->process_custom_css_options( $function_name );
		
		$output = $this->shortcode_callback( $atts, $content, $function_name );

		$this->_shortcode_callback_num++;
		
		// Hide module on specific screens if needed
		if ( isset( $this->shortcode_atts['disabled_on'] ) && '' !== $this->shortcode_atts['disabled_on'] ) {
			$disabled_on_array = explode( '|', $this->shortcode_atts['disabled_on'] );
			$i = 0;
			$current_media_query = 'max_width_767';

			foreach( $disabled_on_array as $value ) {
				if ( 'on' === $value ) {
					MHComposer_Component::set_style( $function_name, array(
						'selector'    => '%%order_class%%',
						'declaration' => 'display: none !important;',
						'media_query' => MHComposer_Core::get_media_query( $current_media_query ),
					) );
				}
				$i++;
				$current_media_query = 1 === $i ? '768_980' : 'min_width_981';
			}
		}

		
		if ( empty( $this->template_name ) ) {
			return $output;
		}

		return $this->shortcode_output();
	}

	function shortcode_output() {
		$this->shortcode_atts['content'] = $this->shortcode_content;
		extract( $this->shortcode_atts );
		ob_start();
		require( locate_template( $this->template_name . '.php' ) );
		return ob_get_clean();
	}

	function shortcode_atts_to_data_atts( $atts = array() ) {
		if ( empty( $atts ) ) {
			return;
		}

		$output = array();
		foreach ( $atts as $attr ) {
			$output[] = 'data-' . esc_attr( $attr ) . '="' . esc_attr( $this->shortcode_atts[ $attr ] ) . '"';
		}

		return implode( ' ', $output );
	}

	// intended to be overridden as needed
	function shortcode_atts(){}

	// intended to be overridden as needed
	function pre_shortcode_content(){}

	// intended to be overridden as needed
	function shortcode_callback( $atts, $content = null, $function_name ){}

	// intended to be overridden as needed
	function additional_shortcode_callback( $atts, $content = null, $function_name ){}
	
	// intended to be overridden as needed
	function predefined_child_modules(){}

	/**
	 * Generate shared setting name
	 * @param  string $option_slug  Option slug
	 * @return string               Shared setting name in the following format: "module_slug-option_slug"
	 */
	public function get_shared_setting_name( $option_slug ) {
		$shared_setting_name = sprintf(
			'%1$s-%2$s',
			isset( $this->shared_settings_slug ) ? $this->shared_settings_slug : $this->slug,
			$option_slug
		);

		return $shared_setting_name;
	}

	private function _add_custom_css_fields() {
		if ( isset( $this->custom_css_tab ) && ! $this->custom_css_tab ) {
			return;
		}

		$custom_css_fields = array();
		$custom_css_options = array();
		$current_module_unique_class = '.' . $this->slug . '_' . "<%= typeof( module_order ) !== 'undefined' ?  module_order : '<span class=\"mhc_module_order_placeholder\"></span>' %>";
		$main_css_selector_output = isset( $this->main_css_selector ) ? $this->main_css_selector : '%%order_class%%';
		$main_css_selector_output = str_replace( '%%order_class%%', $current_module_unique_class, $main_css_selector_output );

		$custom_css_default_options = array(
			'main_element' => array(
				'label'    => esc_html__( 'CSS', 'mh-composer' ),
				'description'       => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'before' => array(
				'label'    => esc_html__( 'CSS::before', 'mh-composer' ),
				'selector' => '::before',
				'no_space_before_selector' => true,
				'description'       => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'after' => array(
				'label'    => esc_html__( 'CSS::after', 'mh-composer' ),
				'selector' => '::after',
				'no_space_before_selector' => true,
				'description'       => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
		$custom_css_options = apply_filters( 'mh_default_custom_css_options', $custom_css_default_options );

		if ( ! empty( $this->custom_css_options ) ) {
			$custom_css_options = array_merge( $custom_css_options, $this->custom_css_options );
		}

		$this->custom_css_options = apply_filters( 'mh_custom_css_options_' . $this->slug, $custom_css_options );

		// optional settings names in custom css options
		$additional_option_slugs = array( 'description', 'priority' );

		foreach ( $custom_css_options as $slug => $option ) {
			$selector_output = isset( $option['selector'] ) ? str_replace( '%%order_class%%', $current_module_unique_class, $option['selector'] ) : '';
			$custom_css_fields[ "custom_css_{$slug}" ] = array(
				'label'    => sprintf(
					'%1$s<span>%2$s%3$s%4$s</span>',
					$option['label'],
					$main_css_selector_output,
					! isset( $option['no_space_before_selector'] ) && isset( $option['selector'] ) ? ' ' : '',
					$selector_output
				),
				'type'     => 'custom_css',
				'tab_slug' => 'custom_css',
				'no_colon' => true,
			);

			// add optional settings if needed
			foreach ( $additional_option_slugs as $option_slug ) {
				if ( isset( $option[ $option_slug ] ) ) {
					$custom_css_fields[ "custom_css_{$slug}" ][ $option_slug ] = $option[ $option_slug ];
				}
			}
		}

		if ( ! empty( $custom_css_fields ) ) {
			$this->fields_unprocessed = array_merge( $this->fields_unprocessed, $custom_css_fields );
		}
	}

	private function _get_fields() {
		$this->fields = array();

		$this->fields = $this->fields_unprocessed;

		$this->fields = $this->process_fields( $this->fields );

		$this->fields = apply_filters( 'mh_composer_module_fields_' . $this->slug, $this->fields );

		foreach ( $this->fields as $field_name => $field ) {
			$this->fields[ $field_name ] = apply_filters('mh_composer_module_fields_' . $this->slug . '_field_' . $field_name, $field );
			$this->fields[ $field_name ]['name'] = $field_name;
		}

		return $this->fields;
	}

	// intended to be overridden as needed
	function process_fields( $fields ) { return $fields; }

	// intended to be overridden as needed
	function get_fields() { return array(); }

	function hex2rgb( $color ) {
		if ( substr( $color, 0, 1 ) == '#' ) {
			$color = substr( $color, 1 );
		}

		if ( strlen( $color ) == 6 ) {
			list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return false;
		}

		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );

		return implode( ', ', array( $r, $g, $b ) );
	}

	function rgba_string_from_field_color_set( $color_set ) {
		if ( empty( $color_set ) || false === strpos($color_set, '|') ) {
			return false;
		}

		$color_set = explode('|', $color_set );

		$color_set_hex = $color_set[0];
		$color_set_rgb = $color_set[1];
		$color_set_alpha = $color_set[2];

		$color_set_rgba = 'rgba(' . $color_set_rgb . ', ' . $color_set_alpha . ')';
		return $color_set_rgba;
	}

	function get_post_type() {
		global $post, $mh_composer_post_type;

		if ( is_admin() ) {
			return $post->post_type;
		} else {
			return $mh_composer_post_type;
		}
	}

	function module_classes( $classes = array() ) {
		if ( ! empty( $classes ) ) {
			if ( ! is_array( $classes ) ) {
				if ( strpos( $classes, ' ' ) !== false ) {
					$classes = explode( ' ', $classes );
				} else {
					$classes = array( $classes );
				}
			}
		}

		$classes = apply_filters( 'mh_composer_module_classes', $classes, $this->slug );
		$classes = apply_filters( 'mh_composer_module_classes_' . $this->slug, $classes );

		$classes = array_map( 'trim', $classes );

		$_classes = array();
		foreach( $classes as $class ) {
			if ( ! empty( $class ) ) {
				$_classes[] = $class;
			}
		}

		return $_classes;
	}

	function wrap_settings_option( $option_output, $field ) {
		$depends = false;
		if ( isset( $field['depends_show_if'] ) || isset( $field['depends_show_if_not'] ) ) {
			$depends = true;
			if ( isset( $field['depends_show_if_not'] ) ) {
				$depends_attr = sprintf( ' data-depends_show_if_not="%s"', esc_attr( $field['depends_show_if_not'] ) );
			} else {
				$depends_attr = sprintf( ' data-depends_show_if="%s"', esc_attr( $field['depends_show_if'] ) );
			}
		}

		$output = sprintf(
			'%6$s<div class="mhc-option%1$s%2$s%3$s%8$s%9$s"%4$s tabindex="-1">%5$s</div> <!-- .mhc-option -->%7$s',
			( ! empty( $field['type'] ) && 'tiny_mce' == $field['type'] ? ' mhc-option-main-content' : '' ),
			( ( $depends || isset( $field['depends_default'] ) ) ? ' mhc-depends' : '' ),
			( ! empty( $field['type'] ) && 'hidden' == $field['type'] ? ' mhc_hidden' : '' ),
			( $depends ? $depends_attr : '' ),
			"\n\t\t\t\t" . $option_output . "\n\t\t\t",
			"\t",
			"\n\n\t\t",
			( ! empty( $field['type'] ) && 'hidden' == $field['type'] ? esc_attr( sprintf( ' mhc-option-%1$s', $field['name'] ) ) : '' ),
			( ! empty( $field['option_class'] ) ? ' ' . $field['option_class'] : '' )
		);

		return $output;
	}

	function wrap_settings_option_field( $field ) {
		$use_container_wrapper = isset( $field['use_container_wrapper'] ) && ! $field['use_container_wrapper'] ? false : true;

		if ( ! empty( $field['renderer'] ) ) {
			$renderer_options = isset( $field['renderer_options'] ) ? $field['renderer_options'] : $field;

			$field_el = is_callable( $field['renderer'] ) ? call_user_func( $field['renderer'], $renderer_options ) : $field['renderer'];

			if ( ! empty( $field['renderer_with_field'] ) && $field['renderer_with_field'] ) {
				$field_el .= $this->render_field( $field );
			}
		} else {
			$field_el = $this->render_field( $field );
		}

		$description = ! empty( $field['description'] ) ? sprintf( '%2$s<p class="description">%1$s</p>', $field['description'], "\n\t\t\t\t\t" ) : '';

		if ( '' === $description && ! $use_container_wrapper ) {
			$output = $field_el;
		} else {
			$output = sprintf(
				'%3$s<div class="mhc-option-container%5$s%6$s">
					%1$s
					%2$s
				%4$s</div> <!-- .mhc-option-container -->',
				$field_el,
				$description,
				"\n\n\t\t\t\t",
				"\t",
				( isset( $field['type'] ) && 'custom_css' === $field['type'] ? ' mhc-custom-css-option' : '' ),
				( isset( $field['type'] ) && 'info' === $field['type'] ? ' mhc-custom-info-box' : '' )
			);
		}

		return $output;
	}

	function wrap_settings_option_label( $field ) {
		if ( ! empty( $field['label'] ) ) {
			$label = $field['label'];
		} else {
			return '';
		}

		$field_name = $this->get_field_name( $field );

		$required = ! empty( $field['required'] ) ? '<span class="required">*</span>' : '';
		$attributes =  sprintf(' for="%1$s"', esc_attr( $field_name ) );

		$label = sprintf(
			'<label%1$s>%2$s%4$s %3$s</label>',
			$attributes,
			$label,
			$required,
			isset( $field['no_colon'] ) && true === $field['no_colon'] ? '' : ':'
		);

		return $label;
	}

	function get_field_name( $field ) {
		// Don't add 'mhc_' prefix to the "Label" field
		if ( 'admin_label' === $field['name'] ) {
			return $field['name'];
		}

		return sprintf( 'mhc_%s', $field['name'] );
	}

	function render_field( $field ) {
		$classes = array();
		$hidden_field = '';
		$is_custom_color = isset( $field['custom_color'] ) && $field['custom_color'];
		$reset_button_html = '<span class="mhc-reset-setting"></span>';

		if ( 'select' !== $field['type'] ) {
			$classes = array( 'regular-text' );
		}

		foreach( $this->get_validation_class_rules() as $rule ) {
			if ( ! empty( $field[ $rule ] ) ) {
				$this->validation_in_use = true;
				$classes[] = $rule;
			}
		}
		
		if ( isset( $field['validate_unit'] ) && $field['validate_unit'] ) {
			$classes[] = 'mhc-validate-unit';
		}


		if ( ! empty( $field['class'] ) ) {
			if ( is_string( $field['class'] ) ) {
				$field['class'] = array( $field['class'] );
			}

			$classes = array_merge( $classes, $field['class'] );
		}
		$field['class'] = implode(' ', $classes );

		$field_name = $this->get_field_name( $field );

		$field['id'] = ! empty( $field['id'] ) ? $field['id'] : $field_name;

		$field['name'] = $field_name;

		if ( isset( $this->type ) && 'child' === $this->type ) {
			$field_name = "data.{$field_name}";
		}

		$default = isset( $field['default'] ) ? $field['default'] : '';
		$value_html = ' value="<%%- typeof( %1$s ) !== \'undefined\' ?  %2$s : \'%3$s\' %%>" ';
		$value = sprintf(
			$value_html,
			esc_attr( $field_name ),
			esc_attr( $field_name ),
			$default
		);

		$attributes = '';
		if ( ! empty( $field['attributes'] ) ) {
			if ( is_array( $field['attributes'] )  ) {
				foreach( $field['attributes'] as $attribute_key => $attribute_value ) {
					$attributes .= ' ' . esc_attr( $attribute_key ) . '="' . esc_attr( $attribute_value ) . '"';
				}
			} else {
				$attributes = ' '.$field['attributes'];
			}
		}

		if ( ! empty( $field['affects'] ) ) {
			$field['class'] .= ' mhc-affects';
			$attributes .= sprintf( ' data-affects="%s"', esc_attr( implode( ', ', $field['affects'] ) ) );
		}
		if ( in_array( $field['type'], array( 'hidden', 'multiple_checkboxes' ) ) ) {
			$hidden_field = sprintf(
				'<input type="hidden" name="%1$s" id="%2$s" class="mhc-main-setting %3$s" data-default="%4$s" %5$s %6$s/>',
				esc_attr( $field['name'] ),
				esc_attr( $field['id'] ),
				esc_attr( $field['class'] ),
				esc_attr( $default ),
				$value,
				$attributes
			);
		}

		foreach ( $this->get_validation_attr_rules() as $rule ) {
			if ( ! empty( $field[ $rule ] ) ) {
				$this->validation_in_use = true;
				$attributes .= ' data-rule-' . esc_attr( $rule ). '="' . esc_attr( $field[ $rule ] ) . '"';
			}
		}

		switch( $field['type'] ) {
			case 'tiny_mce':
				if ( ! empty( $field['tiny_mce_html_mode'] ) ) {
					$field['class'] .= ' html_mode';
				}

				$main_content_property_name = $main_content_field_name = 'mhc_content_new';

				if ( isset( $this->type ) && 'child' === $this->type ) {
					$main_content_property_name = "data.{$main_content_property_name}";
				}

				$field_el = sprintf(
					'<div id="%1$s"><%%= typeof( %2$s ) !== \'undefined\' ? %2$s : \'\' %%></div>',
					esc_attr( $main_content_field_name ),
					esc_html( $main_content_property_name )
				);

				break;
			case 'textarea':
			case 'custom_css':
				$field_custom_value = esc_html( $field_name );
				if ( 'custom_css' === $field['type'] ) {
					$field_custom_value .= '.replace( /\|\|/g, "\n" )';
				}

				if ( 'mhc_raw_content' === $field_name ) {
					$field_custom_value = sprintf( '_.unescape( %1$s )', $field_custom_value );
				}

				$field_el = sprintf(
					'<textarea class="mhc-main-setting large-text code%1$s" rows="4" cols="50" id="%2$s"><%%= typeof( %3$s ) !== \'undefined\' ? %4$s : \'\' %%></textarea>',
					esc_attr( $field['class'] ),
					esc_attr( $field['id'] ),
					esc_html( $field_name ),
					$field_custom_value
				);
				break;
			case 'select':
			case 'switch_button':

				$button_options = array();

				if ( 'switch_button' === $field['type'] ) {
					$button_options = isset( $field['button_options'] ) ? $field['button_options'] : array();
				}

				$field_el = $this->render_select( $field_name, $field['options'], $field['id'], $field['class'], $attributes, $field['type'], $button_options );
				break;
			case 'color':
			case 'color-alpha':
				$field['default'] = ! empty( $field['default'] ) ? $field['default'] : '';

				if ( $is_custom_color && ( ! isset( $field['default'] ) || '' === $field['default'] ) ) {
					$field['default'] = '';
				}

				$default = ! empty( $field['default'] ) && ! $is_custom_color ? sprintf( ' data-default-color="%s"', $field['default'] ) : '';

				$color_id = sprintf( ' id="%1$s"', esc_attr( $field['id'] ) );
				$color_value_html = '<%%- typeof( %1$s ) !== \'undefined\' && %1$s !== \'\' ? %1$s : \'%2$s\' %%>';
				$main_color_value = sprintf( $color_value_html, esc_attr( $field_name ), $field['default'] );
				$hidden_color_value = sprintf( $color_value_html, esc_attr( $field_name ), '' );

				$field_el = sprintf(
					'<input%1$s class="mhc-color-picker-hex%5$s%8$s" type="text"%6$s%7$s placeholder="%9$s" data-selected-value="%2$s" value="%2$s"%3$s />
					%4$s',
					( ! $is_custom_color ? $color_id : '' ),
					$main_color_value,
					$default,
					( ! empty( $field['additional_code'] ) ? $field['additional_code'] : '' ),
					( 'color-alpha' === $field['type'] ? ' mhc-color-picker-hex-alpha' : '' ),
					( 'color-alpha' === $field['type'] ? ' data-alpha="true"' : '' ),
					( 'color' === $field['type'] ? ' maxlength="7"' : '' ),
					( ! $is_custom_color ? ' mhc-main-setting' : '' ),
					esc_attr__( 'Hex Value', 'mh-composer' )
				);

				if ( $is_custom_color ) {
					$field_el = sprintf(
						'<span class="mhc-custom-color-button mhc-choose-custom-color-button"><span>%1$s</span></span>
						<div class="mhc-custom-color-container mhc_hidden">
							%2$s
							<input%3$s class="mhc-main-setting mhc-custom-color-picker" type="hidden" value="%4$s" />
							%5$s
						</div> <!-- .mhc-custom-color-container -->',
						esc_html__( 'Pick a Colour', 'mh-composer' ),
						$field_el,
						$color_id,
						$hidden_color_value,
						$reset_button_html
					);
				}
				break;
			case 'upload':
				$field_data_type = ! empty( $field['data_type'] ) ? $field['data_type'] : 'image';
				$field['upload_button_text'] = ! empty( $field['upload_button_text'] ) ? $field['upload_button_text'] : esc_attr__( 'Upload', 'mh-composer' );
				$field['choose_text'] = ! empty( $field['choose_text'] ) ? $field['choose_text'] : esc_attr__( 'Choose image', 'mh-composer' );
				$field['update_text'] = ! empty( $field['update_text'] ) ? $field['update_text'] : esc_attr__( 'Set image', 'mh-composer' );
				$field['classes'] = ! empty( $field['classes'] ) ? ' ' . $field['classes'] : '';
				$field_additional_button = ! empty( $field['additional_button'] ) ? "\n\t\t\t\t\t" . $field['additional_button'] : '';

				$field_el = sprintf(
					'<input id="%1$s" type="text" class="mhc-main-setting regular-text mhc-upload-field%8$s" value="<%%- typeof( %2$s ) !== \'undefined\' ? %2$s : \'\' %%>" />
					<input type="button" class="button button-upload mhc-upload-button" value="%3$s" data-choose="%4$s" data-update="%5$s" data-type="%6$s" />%7$s',
					esc_attr( $field['id'] ),
					esc_attr( $field_name ),
					esc_attr( $field['upload_button_text'] ),
					esc_attr( $field['choose_text'] ),
					esc_attr( $field['update_text'] ),
					esc_attr( $field_data_type ),
					$field_additional_button,
					esc_attr( $field['classes'] )
				);
				break;
			case 'checkbox':
				$field_el = sprintf(
					'<input type="checkbox" name="%1$s" id="%2$s" class="mhc-main-setting" value="on" <%%- typeof( %1$s ) !==  \'undefined\' && %1$s == \'on\' ? checked="checked" : "" %%>>',
					esc_attr( $field['name'] ),
					esc_attr( $field['id'] )
				);
				break;
			case 'multiple_checkboxes' :
				$checkboxes_set = '<div class="mhc_checkboxes_wrapper">';

				if ( ! empty( $field['options'] ) ) {
					foreach( $field['options'] as $option_value => $option_label ) {
						$checkboxes_set .= sprintf(
							'%3$s<label><input type="checkbox" class="mhc_checkbox_%1$s" value="%1$s"> %2$s</label><br/>',
							esc_attr( $option_value ),
							esc_html( $option_label ),
							"\n\t\t\t\t\t"
						);
					}
				}
				
				// additional option for disable_on option for backward compatibility
				if ( isset( $field['additional_att'] ) && 'disable_on' === $field['additional_att'] ) {
					$mhc_disabled_value = sprintf(
						$value_html,
						esc_attr( 'mhc_disabled' ),
						esc_attr( 'mhc_disabled' ),
						''
					);

					$checkboxes_set .= sprintf(
						'<input type="hidden" id="mhc_disabled" class="mhc_disabled_option"%1$s>',
						$mhc_disabled_value
					);
				}
				

				$field_el = $checkboxes_set . $hidden_field . '</div>';
				break;
			case 'hidden':
				$field_el = $hidden_field;
				break;
			case 'info':
				$field_el = sprintf(
					'<h4>%1$s<br/><br/><strong>%2$s</strong></h4>',
					esc_attr( $field['info-heading'] ),
					esc_attr( $field['info-heading-bold'] )
				);
				break;
			case 'text':
			case 'date_picker':
			case 'range':
			default:
				$validate_number = isset( $field['number_validation'] ) && $field['number_validation'] ? true : false;

				if ( 'date_picker' === $field['type'] ) {
					$field['class'] .= ' mhc-date-time-picker';
				}

				$field['class'] .= 'range' === $field['type'] ? ' mhc-range-input' : ' mhc-main-setting';
				
				$field_el = sprintf(
					'<input id="%1$s" type="text" class="%2$s%5$s"%6$s%3$s%8$s %4$s/>%7$s',
					esc_attr( $field['id'] ),
					esc_attr( $field['class'] ),
					$value,
					$attributes,
					( $validate_number ? ' mh-validate-number' : '' ),
					( $validate_number ? ' maxlength="3"' : '' ),
					( ! empty( $field['additional_button'] ) ? $field['additional_button'] : '' ),
					( '' !== $default
						? sprintf( ' data-default="%1$s"', esc_attr( $default ) )
						: ''
					)
				);

				if ( 'range' === $field['type'] ) {
					$value = sprintf(
						$value_html,
						esc_attr( $field_name ),
						esc_attr( sprintf( 'parseFloat( %1$s )', $field_name ) ),
						( '' !== $default ? floatval( $default ) : '' )
					);

					$range_settings_html = '';
					$range_properties = apply_filters( 'mh_composer_range_properties', array( 'min', 'max', 'step' ) );
					foreach ( $range_properties as $property ) {
						if ( isset( $field['range_settings'][ $property ] ) ) {
							$range_settings_html .= sprintf( ' %2$s="%1$s"',
								esc_attr( $field['range_settings'][ $property ] ),
								esc_html( $property )
							);
						}
					}

					$range_el = sprintf(
						'<input type="range" class="mhc-main-setting mhc-range" data-default="%2$s"%1$s%3$s />',
						$value,
						esc_attr( $default ),
						$range_settings_html
					);

					$field_el = $range_el . "\n" . $field_el;
				}

				break;
		}

		return "\t" . $field_el;
	}

	function render_select( $name, $options, $id = '', $class = '', $attributes = '', $field_type = '', $button_options = array() ) {
		$options_output = '';
		foreach ( $options as $option_value => $option_label ) {
			$data = '';

			if ( is_array( $option_label ) ) {
				if ( isset( $option_label['data'] ) ) {
					$data_key_name = key( $option_label['data'] );

					$data = sprintf(
						' data-%1$s="%2$s"',
						esc_html( $data_key_name ),
						esc_attr( $option_label['data'][ $data_key_name ] )
					);
				}

				$option_label = $option_label['value'];
			}

			$selected_attr = '<%- typeof( ' . esc_attr( $name ) . ' ) !== \'undefined\' && \'' . esc_attr( $option_value ) . '\' === ' . esc_attr( $name ) . ' ?  \' selected="selected"\' : \'\' %>';
			$options_output .= sprintf(
				'%4$s<option%5$s value="%1$s"%2$s>%3$s</option>',
				esc_attr( $option_value ),
				$selected_attr,
				esc_html( $option_label ),
				"\n\t\t\t\t\t\t",
				( '' !== $data ? $data : '' )
			);
		}

		$class = rtrim( 'mhc-main-setting ' . $class );

		$output = sprintf(
			'%6$s
				<select name="%1$s"%2$s%3$s%4$s>%5$s</select>
			%7$s',
			esc_attr( $name ),
			( ! empty( $id ) ? sprintf(' id="%s"', esc_attr( $id ) ) : '' ),
			( ! empty( $class ) ? sprintf(' class="%s"', esc_attr( $class ) ) : '' ),
			( ! empty( $attributes ) ? $attributes : '' ),
			$options_output . "\n\t\t\t\t\t",
			'switch_button' === $field_type ?
				sprintf( '<div class="mhc_switch_button_wrapper %2$s">
						%1$s',
					sprintf( '<%%= window.mh_composer.options_switch_button_output(%1$s) %%>',
						json_encode( array(
							'on' => esc_html( $options['on'] ),
							'off' => esc_html( $options['off'] ),
						) )
					),
					( ! empty( $button_options['button_type'] ) && 'equal' === $button_options['button_type'] ? ' mhc_button_equal_sides' : '' )
				) : '',
			'switch_button' === $field_type ? '</div>' : ''
		);
		return $output;
	}

	function get_main_tabs() {
		$tabs = array(
			'general'    => esc_html__( 'General Settings', 'mh-composer' ),
			'advanced'   => esc_html__( 'Advanced Settings', 'mh-composer' ),
			'custom_css' => esc_html__( 'CSS Settings', 'mh-composer' ),
		);

		return apply_filters( 'mh_composer_main_tabs', $tabs );
	}

	function get_validation_attr_rules() {
		return array(
			'minlength',
			'maxlength',
			'min',
			'max'
		);
	}

	function get_validation_class_rules() {
		return array(
			'required',
			'email',
			'url',
			'date',
			'dateISO',
			'number',
			'digits',
			'creditcard'
		);
	}

	function sort_fields( $fields ) {
		$tabs_fields   = array();
		$sorted_fields = array();
		$i = 0;

		// Sort fields array by tab name
		foreach ( $fields as $field_slug => $field_options ) {
			$field_options['_order_number'] = $i;

			$tab_slug = ! empty( $field_options['tab_slug'] ) ? $field_options['tab_slug'] : 'general';
			$tabs_fields[ $tab_slug ][ $field_slug ] = $field_options;

			$i++;
		}

		// Sort fields within tabs by priority
		foreach ( $tabs_fields as $tab_fields ) {
			uasort( $tab_fields, array( 'self', 'compare_by_priority' ) );
			$sorted_fields = array_merge( $sorted_fields, $tab_fields );
		}

		return $sorted_fields;
	}

	function get_options() {
		$output = '';
		$tab_output = '';
		$tab_slug = '';
		$toggle_slug = '';
		$toggle_all_options_slug = 'all_options';
		$toggles_used = isset( $this->options_toggles );
		$tabs_output = array( 'general' => array() );
		$all_fields = $this->sort_fields( $this->_get_fields() );

		foreach( $all_fields as $field_name => $field ) {
			if ( ! empty( $field['type'] ) && 'skip' == $field['type'] ) {
				continue;
			}
			
			$option_output = '';
			$option_output .= $this->wrap_settings_option_label( $field );
			$option_output .= $this->wrap_settings_option_field( $field );

			$tab_slug = ! empty( $field['tab_slug'] ) ? $field['tab_slug'] : 'general';
			$is_toggle_option = isset( $field['toggle_slug'] ) && $toggles_used && isset( $this->options_toggles[ $tab_slug ] );
			$toggle_slug = $is_toggle_option ? $field['toggle_slug'] : $toggle_all_options_slug;
			$tabs_output[ $tab_slug ][ $toggle_slug ][] = $this->wrap_settings_option( $option_output, $field );

		}
		
		//custom_css tab is the last item
		if ( isset( $tabs_output['custom_css'] ) ) {
			$custom_css_output = $tabs_output['custom_css'];
			unset( $tabs_output['custom_css'] );
			$tabs_output['custom_css'] = $custom_css_output;
		}

		foreach ( $tabs_output as $tab_slug => $tab_settings ) {
			$tab_output        = '';
			$this->used_tabs[] = $tab_slug;
			$i = 0;

			if ( isset( $tabs_output[ $tab_slug ] ) ) {
				if ( isset( $this->options_toggles[ $tab_slug ] ) ) {
					foreach ( $this->options_toggles[ $tab_slug ]['toggles'] as $toggle_slug => $toggle_heading ) {
						$i++;
						$toggle_output = '';
						$is_accordion_disabled = isset( $this->options_toggles[ $tab_slug ]['settings']['toggles_disabled'] ) && $this->options_toggles[ $tab_slug ]['settings']['toggles_disabled'] ? true : false;

						foreach ( $tabs_output[ $tab_slug ][ $toggle_slug ] as $toggle_option_output ) {
							$toggle_output .= $toggle_option_output;
						}

						$toggle_output = sprintf(
							'<div class="mhc-options-toggle-container%3$s%4$s">
								<h3 class="mhc-option-toggle-title">%1$s</h3>
								<div class="mhc-option-toggle-content">
									%2$s
								</div> <!-- .mhc-option-toggle-content -->
							</div> <!-- .mhc-options-toggle-container -->',
							esc_html( $toggle_heading ),
							$toggle_output,
							( $is_accordion_disabled ? ' mhc-options-toggle-disabled' : ' mhc-options-toggle-enabled' ),
							( 1 === $i && ! $is_accordion_disabled ? ' mhc-option-toggle-content-open' : '' )
						);

						$tab_output .= $toggle_output;
					}
				}

				if ( isset( $tabs_output[ $tab_slug ][ $toggle_all_options_slug ] ) ) {
					foreach ( $tabs_output[ $tab_slug ][ $toggle_all_options_slug ] as $no_toggle_option_output ) {
						$tab_output .= $no_toggle_option_output;
					}
				}
			}

			$output .= sprintf(
				'<div class="mhc-options-tab mhc-options-tab-%1$s">
					%3$s
					%2$s
				</div> <!-- .mhc-options-tab_%1$s -->',
				esc_attr( $tab_slug ),
				$tab_output,
				( 'general' === $tab_slug ? $this->children_settings() : '' )
			);
		}

		// return error message if no tabs permitted for current user
		if ( '' === $output ) {
			$output = esc_html__( "You don't have sufficient permissions to access the settings", 'mh-composer' );
		}

		return $output;
	}

	function children_settings() {
		$output = '';
		if ( ! empty( $this->child_slug ) ) {
			$output = sprintf(
			'%6$s<div class="mhc-option-advanced-module-settings" data-module_type="%1$s">
				<ul class="mhc-sortable-options">
				</ul>
				<a href="#" class="mhc-add-sortable-option"><span>%2$s</span></a>
			</div> <!-- .mhc-option -->

			<div class="mhc-option mhc-option-main-content mhc-option-advanced-module">
				<label for="mhc_content_new">%3$s</label>
				<div class="mhc-option-container">
					<div id="mhc_content_new"><%%= typeof( mhc_content_new )!== \'undefined\' && \'\' !== mhc_content_new.trim() ? mhc_content_new.replace( /%%22/g, \'||\' ) : \'%7$s\' %%></div>
					<p class="description">%4$s</p>
				</div> <!-- .mhc-option-container -->
			</div> <!-- .mhc-option -->%5$s',
			esc_attr( $this->child_slug ),
			esc_html( $this->add_new_child_text() ),
			esc_html__( 'Content', 'mh-composer' ),
			esc_html__( 'Input the main text content for your component here.', 'mh-composer' ),
			"\n\n",
			"\t",
			 $this->predefined_child_modules()
			);
		}

		return $output;
	}

	function add_new_child_text() {
		$child_slug = ! empty( $this->child_item_text ) ? $this->child_item_text : '';

		$child_slug = '' === $child_slug ? esc_html__( 'Add New Item', 'mh-composer' ) : $child_slug;

		return $child_slug;
	}

	function wrap_settings( $output ) {
		$tabs_output = '';
		$i = 0;
		$tabs = array();

		// General Settings Tab should be added to all modules if permitted
		if ( mhc_permitted( 'general_settings' ) ) {
			$tabs['general'] = isset( $this->main_tabs['general'] ) ? $this->main_tabs['general'] : esc_html__( 'General Settings', 'mh-composer' );
		}

		foreach ( $this->used_tabs as $tab_slug ) {
			if ( 'general' === $tab_slug ) {
				continue;
			}

			// Add only tabs permitted for current user
			if ( mhc_permitted( $tab_slug . '_settings' ) ) {
				$tabs[ $tab_slug ] = $this->main_tabs[ $tab_slug ];
			}
		}
		
		$tabs_array = array();
		$tabs_json = '';

		foreach ( $tabs as $tab_slug => $tab_name ) {
			$i++;
			
			$tabs_array[$i] = array(
				'slug' => $tab_slug,
				'label' => $tab_name,
			);

			$tabs_json = json_encode( $tabs_array );
		}

		$tabs_output = sprintf( '<%%= window.mh_composer.options_tabs_output(%1$s) %%>', $tabs_json );
		$preview_tabs_output = '<%= window.mh_composer.preview_tabs_output() %>';

		$output = sprintf(
			'%2$s%3$s<div class="mhc-options-tabs">%1$s</div> <!-- .mhc-options-tabs --><div class="mhc-preview-tab"></div> <!-- .mhc-preview-tab -->',
			$output,
			$tabs_output,
			$preview_tabs_output
		);

		return sprintf(
			'%2$s<div class="mhc-main-settings">%1$s</div> <!-- .mhc-main-settings -->%3$s',
			"\n\t\t" . $output,
			"\n\t\t",
			"\n"
		);
	}

	function wrap_validation_form( $output ) {
		return '<form class="mh-composer-main-settings-form validate">' . $output . '</form>';
	}

	function get_shortcode_fields() {
		$fields = array();

		foreach( $this->process_fields( $this->fields_unprocessed ) as $field_name => $field ) {
			$value = '';
			if ( isset( $field['shortcode_default'] ) ) {
				$value = $field['shortcode_default'];
			} else if( isset( $field['default'] ) ) {
				$value = $field['default'];
			}

			$fields[ $field_name ] = $value;
		}

		$fields['disabled'] = 'off';
		$fields['disabled_on'] = '';
		$fields['shared_module'] = '';
		$fields['saved_tabs'] = '';

		return $fields;
	}

	function build_microtemplate() {
		$this->validation_in_use = false;
		$template_output = '';

		if ( 'child' === $this->type ) {
			$id_attr = sprintf( 'mh-composer-advanced-setting-%s', $this->slug );
		} else {
			$id_attr = sprintf( 'mh-composer-%s-module-template', $this->slug );
		}

		if ( ! isset( $this->settings_text ) ) {
			$settings_text = sprintf(
				__( '%1$s %2$s Settings', 'mh-composer' ),
				esc_html( $this->name ),
				'child' === $this->type ? esc_html__( 'Item', 'mh-composer' ) : ''
			);
		} else {
			$settings_text = $this->settings_text;
		}

		if ( file_exists( MH_COMPOSER_DIR . 'microtemplates/' . $this->slug . '.php' ) ) {
			ob_start();
			include MH_COMPOSER_DIR . 'microtemplates/' . $this->slug . '.php';
			$output = ob_get_clean();
		} else {
			$output = $this->get_options();
		}

		$output = $this->wrap_settings( $output );
		if ( $this->validation_in_use ) {
			$output = $this->wrap_validation_form( $output );
		}

		$template_output = sprintf(
			'<script type="text/template" id="%1$s">
				<h3 class="mhc-settings-heading">%2$s</h3>
				%3$s
			</script> <!-- #%4$s -->%5$s',
			esc_attr( $id_attr ),
			esc_html( $settings_text ),
			$output,
			esc_html( $id_attr ),
			"\n"
		);

		if ( $this->type == 'child' ) {
			$title_var = esc_js( $this->child_title_var );
			$title_var = false === strpos( $title_var, 'mhc_' ) ? 'mhc_'. $title_var : $title_var;
			$title_fallback_var = esc_js( $this->child_title_fallback_var );
			$title_fallback_var = false === strpos( $title_fallback_var, 'mhc_' ) ? 'mhc_'. $title_fallback_var : $title_fallback_var;
			$add_new_text = isset( $this->advanced_setting_title_text ) ? $this->advanced_setting_title_text : $this->add_new_child_text();

			$template_output .= sprintf(
				'%6$s<script type="text/template" id="mh-composer-advanced-setting-%1$s-title">
					<%% if ( typeof( %2$s ) !== \'undefined\' && typeof( %2$s ) === \'string\' && %2$s !== \'\' ) { %%>
						<%%- %2$s %%>
					<%% } else if ( typeof( %3$s ) !== \'undefined\' && typeof( %3$s ) === \'string\' && %3$s !== \'\' ) { %%>
						<%%- %3$s %%>
					<%% } else { %%>
						<%%- \'%4$s\' %%>
					<%% } %%>
				</script>%5$s',
				esc_attr( $this->slug ),
				esc_html( $title_var ),
				esc_html( $title_fallback_var ),
				esc_html( $add_new_text ),
				"\n\n",
				"\t"
			);
		}
		 return $template_output;
	}

	function process_custom_css_options( $function_name ) {
		if ( empty( $this->custom_css_options ) ) {
			return false;
		}

		foreach ( $this->custom_css_options as $slug => $option ) {
			$css      = $this->shortcode_atts["custom_css_{$slug}"];
			$selector = ! empty( $option['selector'] ) ? $option['selector'] : '';

			if ( false === strpos( $selector, '%%order_class%%' ) ) {
				if ( ! ( isset( $option['no_space_before_selector'] ) && $option['no_space_before_selector'] ) && '' !== $selector ) {
					$selector = " {$selector}";
				}

				$selector = "%%order_class%%{$selector}";
			}

			if ( '' !== $css ) {
				self::set_style( $function_name, array(
					'selector'    => $selector,
					'declaration' => trim( $css ),
				) );
			}
		}
	}

	static function compare_by_priority( $a, $b ) {
		$a_priority = ! empty( $a['priority'] ) ? (int) $a['priority'] : self::DEFAULT_PRIORITY;
		$b_priority = ! empty( $b['priority'] ) ? (int) $b['priority'] : self::DEFAULT_PRIORITY;

		if ( isset( $a['_order_number'], $b['_order_number'] ) && ( $a_priority === $b_priority ) ) {
			return $a['_order_number'] - $b['_order_number'];
		}

		return $a_priority - $b_priority;
	}

	static function compare_by_name( $a, $b ) {
		return strcasecmp( $a->name, $b->name );
	}
	
	static function get_modules_count( $post_type ) {
		$parent_modules = self::get_parent_modules( $post_type );
		$child_modules = self::get_child_modules( $post_type );
		$overall_count = count( $parent_modules ) + count( $child_modules );

		return $overall_count;
	}

	static function get_modules_js_array( $post_type ) {
		$modules = array();
		$parent_modules = self::get_parent_modules( $post_type );
		
		if ( ! empty( $parent_modules ) ) {
			$sorted_modules = $parent_modules;

			foreach( $sorted_modules as $module ) {
				/**
				 * Replace single and double quotes with %% and || respectively
				 * to avoid js conflicts
				 */
				$module_name = str_replace( array( '"', '&quot;', '&#34;', '&#034;' ) , '%%', $module->name );
				$module_name = str_replace( array( "'", '&#039;', '&#39;' ) , '||', $module_name );

				$modules[] = sprintf(
					'{ "title" : "%1$s", "label" : "%2$s"%3$s}',
					esc_js( $module_name ),
					esc_js( $module->slug ),
					( isset( $module->fullwidth ) && $module->fullwidth ? ', "fullwidth_only" : "on"' : '' )
				);
			}
		}

		return '[' . implode( ',', $modules ) . ']';
	}

	static function get_shortcodes_with_children( $post_type ) {
		$shortcodes = array();
		if ( ! empty( self::$parent_modules[ $post_type ] ) ) {
			foreach( self::$parent_modules[ $post_type ] as $module ) {
				if ( ! empty( $module->child_slug ) ) {
					$shortcodes[] = sprintf(
						'"%1$s":"%2$s"',
						esc_js( $module->slug ),
						esc_js( $module->child_slug )
					);
				}
			}
		}

		return '{' . implode( ',', $shortcodes ) . '}';
	}

	static function get_modules_array( $post_type = '' ) {
		$modules = array();

		if ( ! empty( $post_type ) ) {
			$parent_modules = self::get_parent_modules( $post_type );
			if ( ! empty( $parent_modules ) ) {
				$sorted_modules = $parent_modules;
			}
		} else {
			$parent_modules = self::get_parent_modules();
			if ( ! empty( $parent_modules ) ) {

				$all_modules = array();
				foreach( $parent_modules as $post_type => $post_type_modules ) {
					foreach ( $post_type_modules as $module_slug => $module ) {
						$all_modules[ $module_slug ] = $module;
					}
				}

				$sorted_modules = $all_modules;
			}
		}

		if ( ! empty( $sorted_modules ) ) {
			
			foreach( $sorted_modules as $module ) {
				/**
				 * Replace single and double quotes with %% and || respectively
				 * to avoid js conflicts
				 */
				$module_name = str_replace( '"', '%%', $module->name );
				$module_name = str_replace( "'", '||', $module_name );

				$_module = array(
					'title' => esc_attr( $module_name ),
					'label' => esc_attr( $module->slug ),
				);

				if ( isset( $module->fullwidth ) && $module->fullwidth ) {
					$_module['fullwidth_only'] = 'on';
				}

				$modules[] = $_module;
			}
		}

		return $modules;
	}

	static function get_parent_shortcodes( $post_type ) {
		$shortcodes = array();
		$parent_modules = self::get_parent_modules( $post_type );
		if ( ! empty( $parent_modules ) ) {
			foreach( $parent_modules as $module ) {
				$shortcodes[] = $module->slug;
			}
		}

		return implode( '|', $shortcodes );
	}

	static function get_child_shortcodes( $post_type ) {
		$shortcodes = array();
		$child_modules = self::get_child_modules( $post_type );
		if ( ! empty( $child_modules ) ) {
			foreach( $child_modules as $module ) {
				if ( ! empty( $module->slug ) ) {
					$shortcodes[] = $module->slug;
				}
			}
		}

		return implode( '|', $shortcodes );
	}

	static function get_raw_content_shortcodes( $post_type ) {
		$shortcodes = array();
		$parent_modules = self::get_parent_modules( $post_type );
		if ( ! empty( $parent_modules ) ) {
			foreach( $parent_modules as $module ) {
				if ( isset( $module->use_row_content ) && $module->use_row_content ) {
					$shortcodes[] = $module->slug;
				}
			}
		}

		$child_modules = self::get_child_modules( $post_type );
		if ( ! empty( $child_modules ) ) {
			foreach( $child_modules as $module ) {
				if ( isset( $module->use_row_content ) && $module->use_row_content ) {
					$shortcodes[] = $module->slug;
				}
			}
		}

		return implode( '|', $shortcodes );
	}

	static function output_templates( $post_type = '', $start_from = 0, $amount = 999 ) {
		$parent_modules = self::get_parent_modules( $post_type );
		$child_modules = self::get_child_modules( $post_type );
		$all_modules = array_merge( $parent_modules, $child_modules );
		$i = 0;
		$next_page = false;
		$output = array();
		$output['templates'] = '';

		if ( ! empty( $all_modules ) ) {
			foreach( $all_modules as $module ) {
				if ( $start_from <= $i && ( $amount + $start_from ) > $i ) {
					$output['templates'] .= $module->build_microtemplate();
				} elseif ( ( $amount + $start_from ) <= $i && false === $next_page ) {
					$next_page = $i; // define the next page if there are any templates out of range
				}

				$i++;
			}
		}

		$output['next_page'] = $next_page;

		return $output;
	}

	static function get_parent_modules( $post_type = '' ) {
		if ( ! empty( $post_type ) ) {
			$parent_modules = ! empty( self::$parent_modules[ $post_type ] ) ? self::$parent_modules[ $post_type ] : array();
		} else {
			$parent_modules = self::$parent_modules;
		}

		return apply_filters( 'mh_composer_get_parent_modules', $parent_modules, $post_type );
	}

	static function get_child_modules( $post_type = '' ) {
		if ( ! empty( $post_type ) ) {
			$child_modules = ! empty( self::$child_modules[ $post_type ] ) ? self::$child_modules[ $post_type ] : array();
		} else {
			$child_modules = self::$child_modules;
		}

		return apply_filters( 'mh_composer_get_child_modules', $child_modules, $post_type );
	}
	
	static function get_media_quries( $for_js=false ) {
		$media_queries = array(
			'min_width_1405' => '@media only screen and ( min-width: 1405px )',
			'1100_1405'      => '@media only screen and ( min-width: 1100px ) and ( max-width: 1405px)',
			'981_1405'       => '@media only screen and ( min-width: 981px ) and ( max-width: 1405px)',
			'981_1100'       => '@media only screen and ( min-width: 981px ) and ( max-width: 1100px )',
			'min_width_981'  => '@media only screen and ( min-width: 981px )',
			'max_width_980'  => '@media only screen and ( max-width: 980px )',
			'768_980'        => '@media only screen and ( min-width: 768px ) and ( max-width: 980px )',
			'max_width_767'  => '@media only screen and ( max-width: 767px )',
			'max_width_479'  => '@media only screen and ( max-width: 479px )',
		);

		$media_queries['mobile'] = $media_queries['max_width_767'];

		$media_queries = apply_filters( 'mh_composer_media_queries', $media_queries );

		if ( 'for_js' === $for_js ) {
			$processed_queries = array();

			foreach ( $media_queries as $key => $value ) {
				$processed_queries[] = array( $key, $value );
			}
		} else {
			$processed_queries = $media_queries;
		}

		return $processed_queries;
	}

	static function set_media_queries() {
		self::$media_queries = self::get_media_quries();
	}

	static function get_media_query( $name ) {
		if ( ! isset( self::$media_queries[ $name ] ) ) {
			return false;
		}

		return self::$media_queries[ $name ];
	}

	static function get_style() {
		if ( empty( self::$styles ) ) {
			return false;
		}

		$output = '';

		$styles_by_media_queries = self::$styles;
		$styles_count            = (int) count( $styles_by_media_queries );
		$media_queries_order     = array_merge( array( 'general' ), array_values( self::$media_queries ) );
		
		// make sure styles in the array ordered by media query correctly from bigger to smaller screensize
		$styles_by_media_queries_sorted = array_merge( array_flip( $media_queries_order ), $styles_by_media_queries );
		
		foreach ( $styles_by_media_queries_sorted as $media_query => $styles ) {
			// skip wrong values which were added during the array sorting
			if ( ! is_array( $styles ) ) {
				continue;
			}
			
			$media_query_output    = '';
			$wrap_into_media_query = 'general' !== $media_query;

			// sort styles by priority
			uasort( $styles, array( 'self', 'compare_by_priority' ) );

			// get each rule in a media query
			foreach ( $styles as $selector => $settings ) {
				$media_query_output .= sprintf(
					'%3$s%4$s%1$s { %2$s }',
					$selector,
					$settings['declaration'],
					"\n",
					( $wrap_into_media_query ? "\t" : '' )
				);
			}

			// All css rules that don't use media queries are assigned to the "general" key.
			// Wrap all non-general settings into media query.
			if ( $wrap_into_media_query ) {
				$media_query_output = sprintf(
					'%3$s%3$s%1$s {%2$s%3$s}',
					$media_query,
					$media_query_output,
					"\n"
				);
			}

			$output .= $media_query_output;
		}

		return $output;
	}

	static function set_style( $function_name, $style ) {
		$order_class_name = self::get_module_order_class( $function_name );

		//.mh_composer class before all CSS rules
		$selector = ".mh_composer .$order_class_name";
		
		$selector    = str_replace( '%%order_class%%', ".{$order_class_name}", $style['selector'] );
		$selector    = str_replace( '%order_class%', ".{$order_class_name}", $selector );
		$selector    = apply_filters( 'mhc_set_style_selector', $selector, $function_name );

		$declaration = $style['declaration'];
		// New lines are saved as || in CSS Custom settings, remove them
		$declaration = preg_replace( '/(\|\|)/i', '', $declaration );

		$media_query = isset( $style[ 'media_query' ] ) ? $style[ 'media_query' ] : 'general';

		if ( isset( self::$styles[ $media_query ][ $selector ]['declaration'] ) ) {
			self::$styles[ $media_query ][ $selector ]['declaration'] = sprintf(
				'%1$s %2$s',
				self::$styles[ $media_query ][ $selector ]['declaration'],
				$declaration
			);
		} else {
			self::$styles[ $media_query ][ $selector ]['declaration'] = $declaration;
		}

		if ( isset( $style['priority'] ) ) {
			self::$styles[ $media_query ][ $selector ]['priority'] = (int) $style['priority'];
		}
	}

	static function get_module_order_class( $function_name ) {
		if ( ! isset( self::$modules_order[ $function_name ] ) ) {
			return false;
		}

		$shortcode_order_num = self::$modules_order[ $function_name ];

		$order_class_name = sprintf( '%1$s_%2$s', $function_name, $shortcode_order_num );

		return $order_class_name;
	}

	static function set_order_class( $function_name ) {
		if ( ! isset( self::$modules_order ) ) {
			self::$modules_order = array();
		}

		self::$modules_order[ $function_name ] = isset( self::$modules_order[ $function_name ] ) ? (int) self::$modules_order[ $function_name ] + 1 : 0;
	}

	static function add_module_order_class( $module_class, $function_name ) {
		$order_class_name = self::get_module_order_class( $function_name );

		return "{$module_class} {$order_class_name}";
	}


	/**
	 * Convert smart quotes and &amp; entity to their applicable characters
	 * @param  string $text Input text
	 * @return string
	 */
	static function convert_smart_quotes_and_amp( $text ) {
		$quotes = array(
			'&#8220;',
			'&#8221;',
			'&#8243;',
			'&#8216;',
			'&#8217;',
			'&#x27;',
			'&amp;',
		);

		$replacewith = array(
			'&quot;',
			'&quot;',
			'&quot;',
			'&#39;',
			'&#39;',
			'&#39;',
			'&',
		);
		
		if ( 'fr_FR' === get_locale() ) {
			$french_quotes = array(
				'&nbsp;&raquo;',
				'&Prime;&gt;',
			);

			$french_replacewith = array(
				'&quot;',
				'&quot;&gt;',
			);

			$quotes = array_merge( $quotes, $french_quotes );
			$replacewith = array_merge( $replacewith, $french_replacewith );
		}
		
		$text = str_replace( $quotes, $replacewith, $text );

		return $text;
	}
}

do_action( 'mh_pagecomposer_module_init' );

class MHComposer_Component extends MHComposer_Core {}

class MHComposer_Structure_Element extends MHComposer_Core {
	public $is_structure_element = true;

	function wrap_settings_option( $option_output, $field ) {
			$depends = false;
			if ( isset( $field['depends_show_if'] ) || isset( $field['depends_show_if_not'] ) ) {
				$depends = true;
				if ( isset( $field['depends_show_if_not'] ) ) {
					$depends_attr = sprintf( ' data-depends_show_if_not="%s"', esc_attr( $field['depends_show_if_not'] ) );
				} else {
					$depends_attr = sprintf( ' data-depends_show_if="%s"', esc_attr( $field['depends_show_if'] ) );
				}
			}

			$output = sprintf(
				'%6$s<div class="mhc-option%1$s%2$s%3$s%8$s%9$s"%4$s>%5$s</div> <!-- .mhc-option -->%7$s',
				( ! empty( $field['type'] ) && 'tiny_mce' == $field['type'] ? ' mhc-option-main-content' : '' ),
				( ( $depends || isset( $field['depends_default'] ) ) ? ' mhc-depends' : '' ),
				( ! empty( $field['type'] ) && 'hidden' == $field['type'] ? ' mhc_hidden' : '' ),
				( $depends ? $depends_attr : '' ),
				"\n\t\t\t\t" . $option_output . "\n\t\t\t",
				"\t",
				"\n\n\t\t",
				( ! empty( $field['type'] ) && 'hidden' == $field['type'] ? esc_attr( sprintf( ' mhc-option-%1$s', $field['name'] ) ) : '' ),
				(! empty( $field['custom_class'] ) && 'section_regular_only' == $field['custom_class'] ? ' section-regular-only' : '' )
			);

		return $output;
	}
}