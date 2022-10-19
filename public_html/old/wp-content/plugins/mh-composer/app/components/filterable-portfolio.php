<?php
class MHComposer_Component_Filterable_Portfolio extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Filterable Portfolio', 'mh-composer' );
		$this->slug = 'mhc_filterable_portfolio';
		$this->main_css_selector = '%%order_class%%.mhc_filterable_portfolio';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'fullwidth',
			'posts_number',
			'include_categories',
			'show_title',
			'show_categories',
			'show_pagination',
			'background_layout',
			'grayscale',
			'overlay_color',
			'overlay_icon_color',
			'overlay_icon',
			'admin_label',
		);

		$this->fields_defaults = array(
			'fullwidth'         => array( 'on' ),
			'posts_number'      => array( 10, 'append_default' ),
			'show_title'        => array( 'on' ),
			'show_categories'   => array( 'on' ),
			'show_pagination'   => array( 'on' ),
			'background_layout' => array( 'light' ),
			'grayscale' 		 => array( 'off' ),
		);
		
		$this->custom_css_options = array(
			'portfolio_filters' => array(
				'label'    => esc_html__( 'Portfolio Filters', 'mh-composer' ),
				'selector' => '.mhc_portfolio_filters',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'portfolio_filter' => array(
				'label'    => esc_html__( 'Portfolio Filter', 'mh-composer' ),
				'selector' => '.mhc_portfolio_filters li a',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'portfolio_filter_active' => array(
				'label'    => esc_html__( 'Active Portfolio Filter', 'mh-composer' ),
				'selector' => '.mhc_portfolio_filters li a.active',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'portfolio_image' => array(
				'label'    => esc_html__( 'Portfolio Image', 'mh-composer' ),
				'selector' => '.mhc_portfolio_item img',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'portfolio_title' => array(
				'label'    => esc_html__( 'Portfolio Title', 'mh-composer' ),
				'selector' => '.mhc_portfolio_item h2',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'portfolio_post_meta' => array(
				'label'    => esc_html__( 'Portfolio Post Meta', 'mh-composer' ),
				'selector' => '.mhc_portfolio_item .post-meta',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'portfolio_post_meta_link' => array(
				'label'    => esc_html__( 'Portfolio Post Meta Link', 'mh-composer' ),
				'selector' => '.mhc_portfolio_item .post-meta a',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'fullwidth' => array(
				'label'           => esc_html__( 'Layout', 'mh-composer' ),
				'type'            => 'select',
				'options'         => array(
					'on'  => esc_html__( 'Full-width', 'mh-composer' ),
					'off' => esc_html__( 'Grid', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Choose your desired portfolio layout style.', 'mh-composer' ),
			),
			'posts_number' => array(
				'label'             => esc_html__( 'Number of Posts', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Define the number of projects that should be displayed per page.', 'mh-composer' ),
			),
			'include_categories' => array(
				'label'           => esc_html__( 'Include Categories', 'mh-composer' ),
				'renderer'        => 'mh_composer_include_categories_option',
				'description'     => esc_html__( 'Select the categories that you would like to include in the feed.', 'mh-composer' ),
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
			'show_categories' => array(
				'label'             => esc_html__( 'Categories', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show categories links.', 'mh-composer' ),
			),
			'show_pagination' => array(
				'label'             => esc_html__( 'Pagination', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show pagination.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'            => 'select',
				'options' => array(
					'light' => esc_html__( 'Dark', 'mh-composer' ),
					'dark' => esc_html__( 'Light', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			'grayscale' => array(
				'label'           => esc_html__( 'B/W Style', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on' => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can add black and white effect to your images.', 'mh-composer' ),
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
		$module_id          = $this->shortcode_atts['module_id'];
		$module_class       = $this->shortcode_atts['module_class'];
		$fullwidth          = $this->shortcode_atts['fullwidth'];
		$posts_number       = $this->shortcode_atts['posts_number'];
		$include_categories = $this->shortcode_atts['include_categories'];
		$show_title         = $this->shortcode_atts['show_title'];
		$show_categories    = $this->shortcode_atts['show_categories'];
		$show_pagination    = $this->shortcode_atts['show_pagination'];
		$background_layout  = $this->shortcode_atts['background_layout'];
		$overlay_icon_color   = $this->shortcode_atts['overlay_icon_color'];
		$overlay_color  		= $this->shortcode_atts['overlay_color'];
		$overlay_icon         = $this->shortcode_atts['overlay_icon'];
		$grayscale    		= $this->shortcode_atts['grayscale'];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );

		wp_enqueue_script( 'jquery-masonry-3' );
		wp_enqueue_script( 'hashchange' );

		$args = array();

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

		if( 'on' === $show_pagination ) {
			$args['nopaging'] = true;
		} else {
			$args['posts_per_page'] = (int) $posts_number;
		}

		if ( '' !== $include_categories ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'project_category',
					'field' => 'id',
					'terms' => explode( ',', $include_categories ),
					'operator' => 'IN',
				)
			);
		}

		$projects = mhc_get_projects( $args );
		$categories_included = array();
		
		ob_start();
		if( $projects->post_count > 0 ) {
			while ( $projects->have_posts() ) {
				$projects->the_post();

				$category_classes = array();
				$categories = get_the_terms( get_the_ID(), 'project_category' );
				if ( $categories ) {
					foreach ( $categories as $category ) {
						$category_classes[] = 'project_category_' . $category->term_id;
						$categories_included[] = $category->term_id;
					}
				}

				$category_classes = implode( ' ', $category_classes );

				$main_post_class = sprintf(
					'mhc_portfolio_item%1$s %2$s',
					( 'on' !== $fullwidth ? ' mhc_grid_item' : '' ),
					$category_classes
				);

				?>
				<div id="post-<?php the_ID(); ?>" <?php post_class( $main_post_class ); ?>>
				<?php
					$thumb = '';

					$width = 'on' === $fullwidth ?  1080 : 400;
					$width = (int) apply_filters( 'mhc_portfolio_image_width', $width );

					$height = 'on' === $fullwidth ?  9999 : 284;
					$height = (int) apply_filters( 'mhc_portfolio_image_height', $height );
					$classtext = 'on' === $fullwidth ? 'mhc_post_main_image' : '';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( '' !== $thumb ) : ?>
						<a href="<?php esc_url( the_permalink() ); ?>">
						<?php if ( 'on' !== $fullwidth ) : ?>
							<span class="mh_portfolio_image">
						<?php endif; ?>
								<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
						<?php if ( 'on' !== $fullwidth && 'on' !== $grayscale) :

								$data_icon = '' !== $overlay_icon
								? sprintf(
									' data-icon="%1$s"',
									esc_attr( mhc_process_font_icon( $overlay_icon, "mhc_font_mhicons_icon_symbols" ) )
								)
								: '';

							printf( '<span class="mh_overlay%1$s"%2$s></span>',
								( '' !== $overlay_icon ? ' mhc_data_icon' : '' ),
								$data_icon
								);

						?>
							</span>
						<?php endif; ?>
						</a>
				<?php
					endif;
				?>

				<?php if ( 'on' === $show_title ) : ?>
					<h2><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h2>
				<?php endif; ?>

				<?php if ( 'on' === $show_categories ) :
					$sep = mh_wp_kses( _x( ', ', 'This is a comma followed by a space.', 'mh-composer') );?>
					<p class="post-meta"><?php echo get_the_term_list( get_the_ID(), 'project_category', '', $sep ); ?></p>
				<?php endif; ?>

				</div><!-- .mhc_portfolio_item -->
				<?php
			}
		}

		wp_reset_postdata();

		$posts = ob_get_clean();

		$categories_included = explode ( ',', $include_categories );
		$terms_args = array(
			'include' => $categories_included,
			'orderby' => 'name',
			'order' => 'ASC',
		);
		$terms = get_terms( 'project_category', $terms_args );

		$category_filters = '<ul class="clearfix">';
		$category_filters .= sprintf( '<li class="mhc_portfolio_filter mhc_portfolio_filter_all"><a href="#" class="active" data-category-slug="all">%1$s<span></span></a></li>',
			esc_html__( 'All', 'mh-composer' )
		);
		foreach ( $terms as $term  ) {
			$category_filters .= sprintf( '<li class="mhc_portfolio_filter"><a href="#" data-category-slug="%1$s">%2$s<span></span></a></li>',
				esc_attr( $term->term_id ),
				esc_html( $term->name )
			);
		}
		$category_filters .= '</ul>';

		$class = " mhc_module mhc_bg_layout_{$background_layout}";

		$output = sprintf(
			'<div%5$s class="mhc_filterable_portfolio %1$s%4$s%6$s%10$s" data-posts-number="%7$d">
				<div class="mhc_portfolio_filters clearfix">%2$s</div><!-- .mhc_portfolio_filters -->

				<div class="mhc_portfolio_items_wrapper %8$s">
					<div class="column_width"></div>
					<div class="gutter_width"></div>
					<div class="mhc_portfolio_items">%3$s</div><!-- .mhc_portfolio_items -->
				</div>
				%9$s
			</div> <!-- .mhc_filterable_portfolio -->',
			( 'on' === $fullwidth ? 'mhc_filterable_portfolio_fullwidth' : 'mhc_filterable_portfolio_grid clearfix' ),
			$category_filters,
			$posts,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			esc_attr( $posts_number),
			('on' === $show_pagination ? '' : 'no_pagination' ),
			('on' === $show_pagination ? '<div class="mhc_portofolio_pagination"></div>' : '' ),
			('on' === $grayscale ? ' mh-grayscale' : '')
		);

		return $output;
	}
}
new MHComposer_Component_Filterable_Portfolio;