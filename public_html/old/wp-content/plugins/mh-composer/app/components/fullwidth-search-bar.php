<?php
class MHComposer_Component_Fulwidth_Search_Bar extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Full-width Search Bar', 'mh-composer' );
		$this->slug = 'mhc_fullwidth_search_bar';
		$this->fullwidth        = true;
		$this->main_css_selector = '%%order_class%%.mhc_search_bar';

		$this->approved_fields = array(
			'post_type',
			'show_terms',
			'terms_tax',
			'placeholder',
			'icon_color',
			'background_layout',
			'animation',
			'background_color',
			'text_color',
			'border_radius',
			'custom_paddings',
			'admin_label',
			'module_id',
			'module_class',
			'content_new',
		);

		$this->fields_defaults = array(
			'post_type'       	   => array( 'all' ),
			'show_terms' 			   => array( 'off' ),
			'terms_tax' 			   => array( 'post_tag' ),
			'background_layout'    => array( 'dark' ),
			'animation' 		   => array( 'off' ),
			'custom_paddings'      => array( '70', 'append_default' ),
			'icon_color'		   => array( mh_composer_accent_color(), 'append_default' ),
		);
	
		$this->custom_css_options = array(
			'search_bar' => array(
				'label'    => esc_html__( 'Search Bar', 'mh-composer' ),
				'selector' => '.mhc_search_bar_field',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'search_icon' => array(
				'label'    => esc_html__( 'Search Icon', 'mh-composer' ),
				'selector' => '.mhc_search_bar_icon',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		// list of content
		$post_type_options = array();
		$post_type_options['all'] = esc_html__( 'All', 'mh-composer' );
		$post_type_options['post'] = esc_html__( 'Posts', 'mh-composer' );
		$post_type_options['project'] = esc_html__( 'Projects', 'mh-composer' );
		if ( class_exists( 'WooCommerce', false ) ) {
			$post_type_options['product'] = esc_html__( 'Products', 'mh-composer' );
		}
		
		// list of content
		$tax_type_options = array();
		$tax_type_options['post_tag'] = esc_html__( 'Post Tags', 'mh-composer' );
		$tax_type_options['category'] = esc_html__( 'Post Categories', 'mh-composer' );
		$tax_type_options['project_tag'] = esc_html__( 'Project Tags', 'mh-composer' );
		$tax_type_options['project_category'] = esc_html__( 'Project Categories', 'mh-composer' );
		if ( class_exists( 'WooCommerce', false ) ) {
			$tax_type_options['product_tag'] = esc_html__( 'Product Tags', 'mh-composer' );
			$tax_type_options['product_cat'] = esc_html__( 'Product Categories', 'mh-composer' );
		}
		
		$fields = array(
			'post_type' => array(
				'label'             => esc_html__( 'Search Content', 'mh-composer' ),
				'type'              => 'select',
				'options'           => $post_type_options,
				'description'       => esc_html__( 'Select the desired content type.', 'mh-composer' ),
			),
			'show_terms' => array(
				'label'           => esc_html__( 'Show Terms', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'     => array(
					'#mhc_terms_tax',
				),
				'description' => esc_html__( 'Here you can choose whether to show a list of all terms.', 'mh-composer' ),
			),
			'terms_tax' => array(
				'label'           => esc_html__( 'Tags Type', 'mh-composer' ),
				'type'            => 'select',
				'options'           => $tax_type_options,
				'description' => esc_html__( 'Toggle between the various types.', 'mh-composer' ),
			),
			'placeholder' => array(
				'label'           => esc_html__( 'Search Placeholder', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Input your search placeholder here.', 'mh-composer' ),
			),
			'icon_color' => array(
				'label'             => esc_html__( 'Icon Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour for the search icon.', 'mh-composer' ),
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
			'animation' => array(
				'label'             => esc_html__( 'Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'off'    	=> esc_html__( 'No Animation', 'mh-composer' ),
					'fade_in'	=> esc_html__( 'Fade In', 'mh-composer' ),
					'top'    	=> esc_html__( 'Top To Bottom', 'mh-composer' ),
					'bottom' 	 => esc_html__( 'Bottom To Top', 'mh-composer' ),
					'bouncein'   => esc_html__( 'Bouncing', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This controls the direction of the lazy-loading animation.', 'mh-composer' ),
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content Below Bar', 'mh-composer' ),
				'type'            => 'tiny_mce',
				'description'     => esc_html__( 'This text content will appear under the bar.', 'mh-composer' ),
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
				'tab_slug' => 'advanced',
			),
			'module_class' => array(
				'label'           => esc_html__( '{CSS Class}', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-composer' ),
				'tab_slug' => 'advanced',
			),
			'background_color' => array(
				'label'             => esc_html__( 'Bar Background Colour', 'mh-composer' ),
				'type'              => 'color',
				'tab_slug' 		  => 'advanced',
				'custom_color'	  => true,
			),
			'text_color' => array(
				'label'             => esc_html__( 'Bar Text Colour', 'mh-composer' ),
				'type'              => 'color',
				'tab_slug' 		  => 'advanced',
				'custom_color'	  => true,
			),
			'border_radius' => array(
				'label'           => esc_html__( 'Bar Radius', 'mh-composer' ),
				'type'            => 'range',
				'tab_slug'        => 'advanced',
			),
			'custom_paddings' => array(
				'label'           => esc_html__( 'Padding', 'mh-composer' ),
				'type'            => 'range',
				'default' => '70',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
				),
				'validate_unit'   => true,
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
		$module_id        		 = $this->shortcode_atts['module_id'];
		$module_class     		 = $this->shortcode_atts['module_class'];
		$post_type 				 = $this->shortcode_atts['post_type'];
		$show_terms				 = $this->shortcode_atts['show_terms'];
		$terms_tax				 = $this->shortcode_atts['terms_tax'];
		$placeholder 			 = $this->shortcode_atts['placeholder'];
		$icon_color            	 = $this->shortcode_atts['icon_color'];
		$background_layout 		 = $this->shortcode_atts['background_layout'];
		$animation            	 = $this->shortcode_atts['animation'];
		$background_color		 = $this->shortcode_atts['background_color'];
		$text_color				 = $this->shortcode_atts['text_color'];
		$border_radius 			 = $this->shortcode_atts['border_radius'];
		$custom_paddings 		 = $this->shortcode_atts['custom_paddings'];
		

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		if ( '' !== $text_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_search_bar_field::placeholder, %%order_class%% .mhc_search_bar_field',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $text_color )
				),
			) );
		}
		if ( '' !== $background_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_search_bar_form .mhc_search_bar_input .mhc_search_bar_field',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $background_color )
				),
			) );
		}
		
		if ( '' !== $icon_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% button.mhc_search_bar_submit i',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $icon_color )
				),
			) );
		}
		
		if ( '70px' !== $custom_paddings ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'padding: %1$s 0;',
					esc_html( $custom_paddings )
				),
			) );
		}
		
		if ( '' !== $border_radius ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_search_bar_field',
				'declaration' => sprintf(
					'-webkit-border-radius: %1$s; -moz-border-radius: %1$s; border-radius: %1$s;',
					esc_html( mh_composer_process_range_value( $border_radius ) )
				),
			) );
		}

		$class = " mhc_module mhc_pct mhc_animation_{$animation}";
		$contet_class = " mhc_bg_layout_{$background_layout}";
		$content =  sprintf(
			'<div class="mhc_search_bar_content%1$s">%2$s</div>',
			esc_attr( $contet_class ),
			$this->shortcode_content
			);
		
		
		$output_terms = '';
		$tax = $terms_tax;
		$get_terms = get_terms( $tax, array( 'hide_empty=0' ) );
		if ( ! empty( $get_terms ) && ! is_wp_error( $get_terms ) ) {
			$count = count( $get_terms );
			$terms = '<div class="mhc_search_bar_terms ' . $contet_class . '">';
			foreach ( $get_terms as $term ) {
				$terms .= '<a class="mh_adjust_corners" href="' . esc_url( get_term_link( $term ) ) . '">' . $term->name . '</a>';
			}
			$terms .= '</div>';
			$output_terms = $terms;
		}

		$output = sprintf(
			'<div%1$s class="mhc_fullwidth_search_bar mhc_search_bar mh-waypoint clearfix%2$s%3$s">
				<div class="mhc_container">
					<form role="search" method="get" class="mhc_search_bar_form mh-hidden" action="%4$s">
						<div class="mhc_search_bar_input">
							<input id="s" type="search" class="mhc_search_bar_field%9$s" autocomplete="off" placeholder="%5$s" value="%6$s" name="s" title="%7$s" />
							<span class="mhc_search_bar_btn">
								<button type="submit" class="button mhc_search_bar_submit"><i class="mh-icon-before"></i></button>
							</span>
							%8$s
						</div>
					</form>
				</div>
				%10$s
				%11$s
			</div> <!-- .mhc_search_bar -->',
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			esc_attr( $class ),
			esc_url( home_url( '/' ) ),
			('' !== $placeholder ? esc_attr($placeholder) : esc_html__( 'Search &hellip;', 'mh-composer' )),
			get_search_query(),
			esc_html__( 'Search for:', 'mh-composer' ),
			'all' !== $post_type ? sprintf(
			'<input type="hidden" value="%1$s" name="post_type" id="post_type" />', esc_attr($post_type)
			) : '',
			'' === $border_radius ? ' mh_adjust_corners' : '',
			$content,
			'on' === $show_terms ? $output_terms : ''
			
		);

		return $output;
	}
}
new MHComposer_Component_Fulwidth_Search_Bar;