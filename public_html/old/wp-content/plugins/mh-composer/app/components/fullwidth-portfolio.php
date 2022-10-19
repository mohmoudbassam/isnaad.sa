<?php
class MHComposer_Component_Fullwidth_Portfolio extends MHComposer_Component {
	function init() {
		$this->name       = esc_html__( 'Full-width Portfolio', 'mh-composer' );
		$this->slug       = 'mhc_fullwidth_portfolio';
		$this->fullwidth  = true;
		
		// need to use global settings from the slider module
		$this->global_settings_slug = 'mhc_portfolio';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'title',
			'fullwidth',
			'include_categories',
			'posts_number',
			'show_title',
			'show_date',
			'background_layout',
			'auto',
			'auto_speed',
			'overlay_color',
			'overlay_icon_color',
			'overlay_icon',
			'admin_label',
		);

		$this->fields_defaults = array(
			'fullwidth'         => array( 'on' ),
			'show_title'        => array( 'on' ),
			'show_date'         => array( 'on' ),
			'background_layout' => array( 'light' ),
			'auto'              => array( 'off' ),
			'auto_speed'        => array( '7000', 'append_default' ),
		);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Portfolio Title', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Title displayed above the portfolio.', 'mh-composer' ),
			),
			'fullwidth' => array(
				'label'             => esc_html__( 'Layout', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'on'  => esc_html__( 'Carousel', 'mh-composer' ),
					'off' => esc_html__( 'Grid', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_auto',
				),
				'description'        => esc_html__( 'Choose your desired portfolio layout style.', 'mh-composer' ),
			),
			'include_categories' => array(
				'label'           => esc_html__( 'Include Categories', 'mh-composer' ),
				'renderer'        => 'mh_composer_include_categories_option',
				'description'     => esc_html__( 'Select the categories that you would like to include in the feed.', 'mh-composer' ),
			),
			'posts_number' => array(
				'label'           => esc_html__( 'Items Number', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Control how many projects are displayed. Leave blank or use 0 for unlimited.', 'mh-composer' ),
			),
			'show_title' => array(
				'label'             => esc_html__( 'Title', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show project titles.', 'mh-composer' ),
			),
			'show_date' => array(
				'label'             => esc_html__( 'Date', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show the date.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'light'  => esc_html__( 'Dark', 'mh-composer' ),
					'dark' => esc_html__( 'Light', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			'auto' => array(
				'label'             => esc_html__( 'Automatic Carousel Rotation', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off'  => esc_html__( 'Off', 'mh-composer' ),
					'on' => esc_html__( 'On', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_auto_speed',
				),
				'depends_show_if' => 'on',
				'description'        => esc_html__( 'If you the carousel layout option is chosen and you would like the carousel to play automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'mh-composer' ),
			),
			'auto_speed' => array(
				'label'             => esc_html__( 'Automatic Animation Speed (in ms)', 'mh-composer' ),
				'type'              => 'text',
				'depends_default'   => true,
				'description'       => esc_html__( "Here you can adjust the rotation speed. The higher the number the longer the pause between each rotation. (Ex. 1000 = 1 sec)", 'mh-composer' ),
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
			'overlay_color' => array(
				'label'             => esc_html__( 'Overlay Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'overlay_icon_color' => array(
				'label'             => esc_html__( 'Overlay Icon Colour', 'mh-composer' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'overlay_icon' => array(
				'label'               => esc_html__( 'Overlay Icon', 'mh-composer' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_icon_list',
				'renderer_with_field' => true,
				'tab_slug'            => 'advanced',
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
		$title              = $this->shortcode_atts['title'];
		$module_id          = $this->shortcode_atts['module_id'];
		$module_class       = $this->shortcode_atts['module_class'];
		$fullwidth          = $this->shortcode_atts['fullwidth'];
		$include_categories = $this->shortcode_atts['include_categories'];
		$posts_number       = $this->shortcode_atts['posts_number'];
		$show_title         = $this->shortcode_atts['show_title'];
		$show_date          = $this->shortcode_atts['show_date'];
		$background_layout  = $this->shortcode_atts['background_layout'];
		$auto               = $this->shortcode_atts['auto'];
		$auto_speed         = $this->shortcode_atts['auto_speed'];
		$overlay_icon_color   = $this->shortcode_atts['overlay_icon_color'];
		$overlay_color  		= $this->shortcode_atts['overlay_color'];
		$overlay_icon         = $this->shortcode_atts['overlay_icon'];
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		if ( '' !== $overlay_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_overlay',
				'declaration' => sprintf(
					'background-color: %1$s;
					border-color: %1$s;',
					esc_html( $overlay_color )
				),
			) );
		}
		
		if ( '' !== $overlay_icon_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_overlay:before',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $overlay_icon_color )
				),
			) );
		}

		$args = array();
		if ( is_numeric( $posts_number ) && $posts_number > 0 ) {
			$args['posts_per_page'] = $posts_number;
		} else {
			$args['nopaging'] = true;
		}

		if ( '' !== $include_categories ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'project_category',
					'field' => 'id',
					'terms' => explode( ',', $include_categories ),
					'operator' => 'IN'
				)
			);
		}

		$projects = mhc_get_projects( $args );

		ob_start();
		if( $projects->post_count > 0 ) {
			while ( $projects->have_posts() ) {
				$projects->the_post();
				?>
				<div id="post-<?php the_ID(); ?>" <?php post_class( 'mhc_portfolio_item mhc_grid_item ' ); ?>>
				<?php
					$thumb = '';

					$width = 510;
					$width = (int) apply_filters( 'mhc_portfolio_image_width', $width );

					$height = 382;
					$height = (int) apply_filters( 'mhc_portfolio_image_height', $height );

					list($thumb_src, $thumb_width, $thumb_height) = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array( $width, $height ) );

					$orientation = ( $thumb_height > $thumb_width ) ? 'portrait' : 'landscape';

					if ( '' !== $thumb_src ) : ?>
						<div class="mhc_portfolio_image <?php echo esc_attr( $orientation ); ?>">
							<img src="<?php echo esc_url( $thumb_src ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"/>
								<div class="meta">
                                	<a href="<?php esc_url( the_permalink() ); ?>">
									<?php	$data_icon = '' !== $overlay_icon
                                    ? sprintf(
                                        ' data-icon="%1$s"',
                                        esc_attr( mhc_process_font_icon( $overlay_icon, 'mhc_font_mhicons_icon_symbols' ) )
                                    )
                                    : '';
    
                                printf( '<span class="mh_overlay%1$s"%2$s></span>',
                                    ( '' !== $overlay_icon ? ' mhc_data_icon' : '' ),
                                    $data_icon
                                ); ?>

								<?php if ( 'on' === $show_title ) : ?>
                                    <h3><?php the_title(); ?></h3>
                                <?php endif; ?>

                                <?php if ( 'on' === $show_date ) : ?>
                                    <p class="post-meta"><?php echo get_the_date(); ?></p>
                                <?php endif; ?>
								</a>
							</div>
						</div>
				<?php endif; ?>
				</div>
				<?php
			}
		}

		wp_reset_postdata();

		$posts = ob_get_clean();

		$class = " mhc_module mhc_bg_layout_{$background_layout}";

		$output = sprintf(
			'<div%4$s class="mhc_fullwidth_portfolio %1$s%3$s%5$s" data-auto-rotate="%6$s" data-auto-rotate-speed="%7$s">
				%8$s
				<div class="mhc_portfolio_items clearfix">
					%2$s
				</div><!-- .mhc_portfolio_items -->
			</div> <!-- .mhc_fullwidth_portfolio -->',
			( 'on' === $fullwidth ? 'mhc_fullwidth_portfolio_carousel' : 'mhc_fullwidth_portfolio_grid clearfix' ),
			$posts,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			( '' !== $auto && in_array( $auto, array('on', 'off') ) ? esc_attr( $auto ) : 'off' ),
			( '' !== $auto_speed && is_numeric( $auto_speed ) ? esc_attr( $auto_speed ) : '7000' ),
			( '' !== $title ? sprintf( '<h2>%s</h2>', esc_html( $title ) ) : '' )
		);

		return $output;
	}
}
new MHComposer_Component_Fullwidth_Portfolio;