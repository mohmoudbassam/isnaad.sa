<?php
class MHComposer_Component_Fullwidth_Menu extends MHComposer_Component {
	function init() {
		$this->name       = esc_html__( 'Full-width Menu', 'mh-composer' );
		$this->slug       = 'mhc_fullwidth_menu';
		$this->fullwidth  = true;
		$this->main_css_selector = '%%order_class%%.mhc_fullwidth_menu';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'menu_id',
			'background_color',
			'background_layout',
			'text_orientation',
			'submenu_direction',
			'fullwidth_menu',
			'admin_label',
		);

		$this->fields_defaults = array(
			'background_color'  => array( '#ffffff', 'append_default' ),
			'background_layout' => array( 'light' ),
			'text_orientation'  => array( 'right' ),
			'submenu_direction' => array( 'downwards' ),
		);
	}

	function get_fields() {
		$fields = array(
			'menu_id' => array(
				'label'           => esc_html__( 'Menu', 'mh-composer' ),
				'type'            => 'select',
				'options'         => mh_composer_get_nav_menus_options(),
				'description'     => sprintf(
					'<p class="description">%2$s. <a href="%1$s" target="_blank">%3$s</a>.</p>',
					esc_url( admin_url( 'nav-menus.php' ) ),
					esc_html__( 'Select a menu that should be used in the component', 'mh-composer' ),
					esc_html__( 'Click here to create new menu', 'mh-composer' )
				),
			),
			'background_color' => array(
				'label'       => esc_html__( 'Background Colour', 'mh-composer' ),
				'type'        => 'color-alpha',
				'description' => esc_html__( 'Use the colour picker to choose a background colour for this component.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'light' => esc_html__( 'Dark', 'mh-composer' ),
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose the value of your text. If you are working with a dark background, then your text should be set to light. If you are working with a light background, then your text should be dark.', 'mh-composer' ),
			),
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options_no_just(),
				'description'       => esc_html__( 'This controls the how your text is aligned.', 'mh-composer' ),
			),
			'submenu_direction' => array(
				'label'           => esc_html__( 'Sub-Menus Open', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'downwards' => esc_html__( 'Downwards', 'mh-composer' ),
					'upwards'   => esc_html__( 'Upwards', 'mh-composer' ),
				),
				'description' => esc_html__( 'Here you can choose the direction that your sub-menus will open. You can choose to have them open downwards or upwards.', 'mh-composer' ),
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
			'fullwidth_menu' => array(
				'label'           => esc_html__( 'Force Full-width Menu', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
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
		$background_color  = $this->shortcode_atts['background_color'];
		$background_layout = $this->shortcode_atts['background_layout'];
		$text_orientation  = $this->shortcode_atts['text_orientation'];
		$menu_id           = $this->shortcode_atts['menu_id'];
		$submenu_direction = $this->shortcode_atts['submenu_direction'];
		$fullwidth_menu    = $this->shortcode_atts['fullwidth_menu'] === 'on' ? ' mhc_force_fullwidth_menu' : '';

		$style = '';

		if ( '' !== $background_color ) {
			$style .= sprintf( ' style="background-color: %s;"',
				esc_attr( $background_color )
			);
		}

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		$class = " mhc_module mhc_bg_layout_{$background_layout} mhc_text_align_{$text_orientation}{$fullwidth_menu}";

		$menu = '<nav class="fullwidth-menu-nav">';
		$menuClass = 'fullwidth-menu nav';
		if ( 'on' == mh_get_option( 'mharty_disable_toptier' ) ) {
			$menuClass .= ' mh_disable_top_tier';
		}
		$menuClass .= ( '' !== $submenu_direction ? sprintf( ' %s', esc_attr( $submenu_direction ) ) : '' );

		$primaryNav = '';

		$menu_args = array(
			'theme_location' => 'primary-menu',
			'container'      => '',
			'fallback_cb' => 'link_to_menu_editor',
			'menu_class'     => $menuClass,
			'menu_id'        => '',
			'echo'           => false,
			'walker' => new mharty_walker,
		);

		if ( '' !== $menu_id ) {
			$menu_args['menu'] = (int) $menu_id;
		}

		$primaryNav = wp_nav_menu( apply_filters( 'mh_fullwidth_menu_args', $menu_args ) );

		if ( '' == $primaryNav ) {
			$menu .= sprintf(
				'<ul class="%1$s">
					%2$s',
				esc_attr( $menuClass ),
				( 'on' === mh_get_option( 'mharty_home_link' )
					? sprintf( '<li%1$s><a href="%2$s">%3$s</a></li>',
						( is_home() ? ' class="current_page_item"' : '' ),
						esc_url( home_url( '/' ) ),
						esc_html__( 'Home', 'mh-composer' )
					)
					: ''
				)
			);

			ob_start();

			show_page_menu( $menuClass, false, false );
			show_categories_menu( $menuClass, false );

			$menu .= ob_get_contents();

			$menu .= '</ul>';

			ob_end_clean();
		} else {
			$menu .= $primaryNav;
		}

		$menu .= '</nav>';

		$output = sprintf(
			'<div%4$s class="mhc_fullwidth_menu%3$s%5$s"%2$s%6$s>
				<div class="mhc_row clearfix">
					%1$s
					<div class="mh_mobile_nav_menu">
						<a href="#" class="mobile_nav closed">
							<span class="mobile_menu_bar mh-icon-before"></span>
						</a>
					</div>
				</div>
			</div>',
			$menu,
			$style,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			( '' !== $style ? sprintf( ' data-bg_color=%1$s', esc_attr( $background_color ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Fullwidth_Menu;