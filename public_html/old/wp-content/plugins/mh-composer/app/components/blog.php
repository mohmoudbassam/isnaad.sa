<?php
class MHComposer_Component_Blog extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Blog', 'mh-composer' );
		$this->slug = 'mhc_blog';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'fullwidth',
			'posts_number',
			'include_categories',
			'meta_date',
			'show_thumbnail',
			'show_content',
			'show_author',
			'show_date',
			'show_categories',
			'show_comments',
			'show_views',
			'show_ratings',
			'show_pagination',
			'background_layout',
			'show_more',
			'show_more_button',
			'show_loveit',
			'show_meta_cont_aql',
			'show_avatar',
			'meta_info_style',
			'meta_info_position',
			'offset_posts',
			'tile_background_color',
			'button_color',
			'use_orderby',
			'post_orderby',
			'post_order',
		);

		$this->fields_defaults = array(
			'fullwidth'         	 => array( 'on' ),
			'posts_number'      	 => array( 10, 'append_default' ),
			'meta_date'         	 => array( 'd/m/Y', 'append_default' ),
			'show_thumbnail'   	     => array( 'on' ),
			'show_content'      	 => array( 'off' ),
			'show_author'       	 => array( 'on' ),
			'show_date'         	 => array( 'on' ),
			'show_categories'   	 => array( 'on' ),
			'show_comments' 	   	 => array( 'off' ),
			'show_views' 	   	     => array( 'off' ),
			'show_ratings'			 => array( 'off' ),
			'show_pagination'   	 => array( 'on' ),
			'background_layout'      => array( 'light' ),
			'show_more'         	 => array( 'off' ),
			'show_more_button'       => array( 'off' ),
			'show_loveit' 	   	  	 => array( 'off' ),
			'show_meta_cont_aql'   	 => array( 'off' ),
			'show_avatar' 	   	  	 => array( 'off' ),
			'meta_info_style'   	 => array( 'two' ),
			'meta_info_position'   	 => array( 'below' ),
			'offset_posts'           => array( 0, 'append_default' ),
			'use_orderby'   		 => array( 'off' ),
			'post_orderby'   		 => array( 'date' ),
			'post_order'   		   	 => array( 'DESC' ),
		);

		$this->main_css_selector = '%%order_class%% .mhc_post';

		$this->custom_css_options = array(
			'blog_post' => array(
				'label'    => esc_html__( 'Post', 'mh-composer' ),
				'selector' => '.mhc_post',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'blog_post_featured_image' => array(
				'label'    => esc_html__( 'Featured Image', 'mh-composer' ),
				'selector' => '.featured_image_container img',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'blog_post_content' => array(
				'label'    => esc_html__( 'Content', 'mh-composer' ),
				'selector' => '.mhc_post_content',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'blog_post_title' => array(
				'label'    => esc_html__( 'Title', 'mh-composer' ),
				'selector' => '.mhc_post h2',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'blog_post_meta' => array(
				'label'    => esc_html__( 'Post Meta', 'mh-composer' ),
				'selector' => '.mhc_post .post-meta',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}
	
	function get_fields() {
		$fields = array(
			'fullwidth' => array(
				'label'             => esc_html__( 'Layout', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'on'  		 => esc_html__( 'Full-width', 'mh-composer' ),
					'off' 		=> esc_html__( 'Grid', 'mh-composer' ),
					'horizontal' => esc_html__( 'Horizontal', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_tile_background_color',
				),
				'description'        => esc_html__( 'Toggle between the various blog layout types.', 'mh-composer' ),
			),
			'include_categories' => array(
				'label'            => esc_html__( 'Include Categories', 'mh-composer' ),
				'renderer'         => 'mh_composer_include_categories_option',
				'renderer_options' => array(
					'use_terms' => false,
				),
				'description'      => esc_html__( 'Choose which categories you would like to include in the feed.', 'mh-composer' ),
			),
			'posts_number' => array(
				'label'             => esc_html__( 'Number of Posts', 'mh-composer' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Choose how many posts you would like to show.', 'mh-composer' ),
			),
			'offset_posts' => array(
				'label'           => esc_html__( 'Offset Posts', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Choose by how many posts you would like to offset. Numeric value only', 'mh-composer' ),
			),
			'show_thumbnail' => array(
				'label'             => esc_html__( 'Featured Image', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show the post featured image.', 'mh-composer' ),
			),
			'show_avatar' => array(
				'label'             => esc_html__( 'Show Author Avatar', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show the author avatar.', 'mh-composer' ),
			),
			'show_author' => array(
				'label'             => esc_html__( 'Show Author', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show the author name.', 'mh-composer' ),
			),
			'show_date' => array(
				'label'             => esc_html__( 'Show Date', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_meta_date'
				),
				'description'        => esc_html__( 'Here you can define whether to show the date.', 'mh-composer' ),
			),
			'meta_date' => array(
				'label'             => esc_html__( 'Date Format', 'mh-composer' ),
				'type'              => 'text',
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'mh-composer' ),
			),
			'show_categories' => array(
				'label'             => esc_html__( 'Show Categories', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show categories links.', 'mh-composer' ),
			),
			'show_comments' => array(
				'label'             => esc_html__( 'Show Comments Count', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'       => esc_html__( 'Here you can choose whether or not display the Comments Count.', 'mh-composer' ),
			),
			'show_views' => array(
				'label'             => esc_html__( 'Show Views Count', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show Views Count. For this option to work you must have "WP-PostViews" plugin installed and activated.', 'mh-composer' ),
			),
			'show_ratings' => array(
				'label'             => esc_html__( 'Show Ratings', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show reviews rating. For this option to work you must have "MH REVIEWS" plugin installed and activated.', 'mh-composer' ),
			),
			'show_content' => array(
				'label'             => esc_html__( 'Content', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'off'   => esc_html__( 'Show Excerpt', 'mh-composer' ),
					'on'    => esc_html__( 'Show Content', 'mh-composer' ),
					'none'  => esc_html__( 'Hide', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_show_more',
				),
				'description'        => esc_html__( 'Showing Content will not truncate your posts on the index page. Showing Excerpt will only display your excerpt text.', 'mh-composer' ),
			),
			'show_more' => array(
				'label'             => esc_html__( 'Read More Link', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_show_more_button',
				),
				'depends_show_if'   => 'off',
				'description'       => esc_html__( 'Here you can define whether to show "read more" link after the excerpts.', 'mh-composer' ),
			),
			'show_more_button' => array(
				'label'             => esc_html__( 'Read More Button Style', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'depends_show_if'   => 'on',
				'affects'           => array(
					'#mhc_button_color',
				),
				'description'       => esc_html__( 'Here you can define whether to display "read more" link as a button.', 'mh-composer' ),
			),
			'show_loveit' => array(
				'label'             => esc_html__( 'Like Icon', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show "Like icon". For this option to work you must have "Mharty - Love it" plugin installed and activated.', 'mh-composer' ),
			),
			'meta_info_style' => array(
				'label'             => esc_html__( 'Post Meta Style', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'two'  => esc_html__( 'Two rows', 'mh-composer' ),
					'one'  => esc_html__( 'One row', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Choose the desired style.', 'mh-composer' ),
			),
			'meta_info_position' => array(
				'label'             => esc_html__( 'Post Meta Placement', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'below' 	 => esc_html__( 'Below Title', 'mh-composer' ),
					'middle'  	=> esc_html__( 'Above title', 'mh-composer' ),
					'above'	 => esc_html__( 'Above image and title', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Choose where to place the post mets.', 'mh-composer' ),
			),
			'show_pagination' => array(
				'label'             => esc_html__( 'Pagination', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show pagination. If you want to show a numeric style pagination, install "WP-PageNavi" plugin.', 'mh-composer' ),
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
			'background_layout' => array(
				'label'       => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'        => 'select',
				'options'           => array(
					'light' => esc_html__( 'Dark', 'mh-composer' ),
					'dark'  => esc_html__( 'Light', 'mh-composer' ),
				),
				'tab_slug'          => 'advanced',
				'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
			),
			'tile_background_color' => array(
				'label'             => esc_html__( 'Grid Tile Background Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
				'depends_show_if'   => 'off',
			),
			'button_color' => array(
				'label'             => esc_html__( 'Button Colour', 'mh-composer' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
				'depends_show_if'   => 'on',
			),
			'show_meta_cont_aql' => array(
				'label'             => esc_html__( 'Quote, Audio, Link', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'description'        => esc_html__( 'By default these post format have a compact style. Here you can define whether to show the content and the post meta.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
			),
			'use_orderby' => array(
				'label'             => esc_html__( 'Posts Order', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-composer' ),
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_post_order',
					'#mhc_post_orderby',
				),
				'description'        => esc_html__( 'This will show more options to adjust posts order.', 'mh-composer' ),
				'tab_slug'          => 'advanced',
			),
			'post_orderby' => array(
				'label'       => esc_html__( 'Sort By', 'mh-composer' ),
				'type'        => 'select',
				'options'           => array(
					'date'  			 => esc_html__( 'Post Date', 'mh-composer' ),
					'title'  			=> esc_html__( 'Post Title', 'mh-composer' ),
					'name'  			 => esc_html__( 'Post Slug', 'mh-composer' ),
					'ID'  			   => esc_html__( 'Post ID', 'mh-composer' ),
					'comment_count'  	=> esc_html__( 'Comments Count', 'mh-composer' ),
					'rand'   			 => esc_html__( 'Random Order', 'mh-composer' ),
				),
				'tab_slug'          => 'advanced',
				'depends_show_if'   => 'on',
			),
			'post_order' => array(
				'label'       => esc_html__( 'DESC/ASC', 'mh-composer' ),
				'type'        => 'select',
				'options'           => array(
					'DESC' => esc_html__( 'Descending Order', 'mh-composer' ),
					'ASC'  => esc_html__( 'Ascending Order', 'mh-composer' ),
				),
				'tab_slug'          => 'advanced',
				'depends_show_if'   => 'on',
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
		$module_id          			 = $this->shortcode_atts['module_id'];
		$module_class       			  = $this->shortcode_atts['module_class'];
		$fullwidth          			 = $this->shortcode_atts['fullwidth'];
		$posts_number       			  = $this->shortcode_atts['posts_number'];
		$include_categories 			= $this->shortcode_atts['include_categories'];
		$meta_date          			 = $this->shortcode_atts['meta_date'];
		$show_thumbnail     			= $this->shortcode_atts['show_thumbnail'];
		$show_content       			  = $this->shortcode_atts['show_content'];
		$show_author        		   = $this->shortcode_atts['show_author'];
		$show_date          			 = $this->shortcode_atts['show_date'];
		$show_categories   			   = $this->shortcode_atts['show_categories'];
		$show_comments				 = $this->shortcode_atts['show_comments'];
		$show_views				    = $this->shortcode_atts['show_views'];
		$show_ratings			    = $this->shortcode_atts['show_ratings'];
		$show_pagination    		   = $this->shortcode_atts['show_pagination'];
		$background_layout  			 = $this->shortcode_atts['background_layout'];
		$offset_posts      			  = $this->shortcode_atts['offset_posts'];
		$tile_background_color 		 = $this->shortcode_atts['tile_background_color'];
		$show_more		 			 = $this->shortcode_atts['show_more'];
		$show_more_button			  = $this->shortcode_atts['show_more_button'];
		$show_loveit				   = $this->shortcode_atts['show_loveit'];
		$show_meta_cont_aql			= $this->shortcode_atts['show_meta_cont_aql'];
		$show_avatar				   = $this->shortcode_atts['show_avatar'];
		$meta_info_style			   = $this->shortcode_atts['meta_info_style'];
		$meta_info_position			= $this->shortcode_atts['meta_info_position'];
		$button_color				  = $this->shortcode_atts['button_color'];
		$use_orderby				   = $this->shortcode_atts['use_orderby'];
		$post_order				    = $this->shortcode_atts['post_order'];
		$post_orderby				  = $this->shortcode_atts['post_orderby'];
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		global $paged;

		$container_is_closed = false;
		
		if ( '' !== $tile_background_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%%.mhc_blog_grid .mhc_post',
				'declaration' => sprintf(
					'background-color: %1$s; border-color: %1$s;',
					esc_html( $tile_background_color )
				),
			) );
		}
		if ( '' !== $button_color && 'off' !== $show_more_button) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_post .more-link.mhc_contact_submit',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $button_color )
				),
			) );
		}
		if ( 'on' === $fullwidth && 'off' === $show_more_button) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc_post.with-loveit .mh-loveit-container',
				'declaration' => 'bottom: -30px;'
			) );
		}

		if ( 'off' === $fullwidth ){
			wp_enqueue_script( 'jquery-masonry-3' );
		}
	
		$args = array( 'posts_per_page' => (int) $posts_number );

		$mh_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );

		if ( is_front_page() ) {
			$paged = $mh_paged;
		}
		
		//https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
		if ( '' !== $offset_posts && ! empty( $offset_posts ) ) {
			if ( $paged > 1 ) {
				$args['offset'] = ( ( $mh_paged - 1 ) * intval( $offset_posts ) ) + intval( $offset_posts );
			} else {
				$args['offset'] = intval( $offset_posts );
			}
		}
		
		if ( '' !== $include_categories )
			$args['cat'] = $include_categories;
	
		if ( ! is_search() ) {
			$args['paged'] = $mh_paged;
		}
		
	if ( is_single() && ! isset( $args['post__not_in'] ) ) {
	//	global $post;
	//	$args['post__not_in'] = array( $post->ID );
		$args['post__not_in'] = array( get_the_ID() );
	}
	//order & orderby args
	if ( 'off' !== $use_orderby ){
		if ( 'DESC' !== $post_order ){
			$args['order'] =  'ASC';
		}
		if ( 'date' !== $post_orderby ){
			$args['orderby'] = $post_orderby;
		}
	}
	ob_start();

	query_posts( $args );

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();

			$post_format = mh_post_format();
			$post_content = get_the_content();
			$thumb = '';

			$width = 'on' === $fullwidth ? 1080 : 400;
			$width = (int) apply_filters( 'mhc_blog_image_width', $width );

			$height = 'on' === $fullwidth ? 675 : 250;
			$height = (int) apply_filters( 'mhc_blog_image_height', $height );
			$classtext = 'on' === $fullwidth ? 'mhc_post_main_image' : '';
			$titletext = get_the_title();
			$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
			$thumb = $thumbnail["thumb"];

			$no_thumb_class = '' === $thumb || 'off' === $show_thumbnail ? ' mh_post_no_thumb' : '';
			$show_loveit_class = 'on' === $show_loveit ? ' with-loveit' : '';
			if ( in_array( $post_format, array( 'video', 'gallery' ) ) ) {
				$no_thumb_class = '';
			} 
			$meta_info_position_class = '';
			if (('off' !== $show_meta_cont_aql) || (! in_array( $post_format, array( 'link', 'audio', 'quote' )) ) ) {
				$meta_info_position_class = ' post-meta-' .$meta_info_position;
			}
?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'mhc_post' . $no_thumb_class . $show_loveit_class . $meta_info_position_class ); ?>>
				<?php // author with two styles
				$author_byline = '';
				$post_meta_block = '';
				if ( 'on' === $show_author){
					$author_byline =  mh_wp_kses( sprintf( '%1$s %2$s',
						mh_get_post_author_pre(),
						mh_get_the_author_posts_link()
					) );
				}
				$the_views = function_exists('the_views') ? '<span class="mhc_the_views">' . do_shortcode('[views]') . '</span>' : '';
				$the_ratings = class_exists( 'MHReviewsClass') && 'on' === $show_ratings ? do_shortcode('[mh_reviews_meta]') : '';
				$sep = mh_wp_kses( _x( ', ', 'This is a comma followed by a space.', 'mh-composer') );
	//check any info to show with two styles
	if ( 'on' === $show_avatar || 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories || 'on' === $show_comments || 'on' === $show_views ) {
		$post_meta_block = sprintf( '<div class="post-meta%11$s">%1$s %2$s %3$s %4$s %5$s %6$s %7$s %8$s %12$s %13$s %14$s %15$s %9$s %10$s</div>',
						( 'on' === $show_avatar
								? mh_get_the_author_avatar('40')
								: ''), //1
						('two' === $meta_info_style
								? '<div class="post-meta-inline">'
								: ''), //2
						$author_byline, //3
						('two' === $meta_info_style
								? '<p>'
								: ''), //4
						( ( 'on' === $show_author && 'on' === $show_date && 'one' === $meta_info_style ) ? mh_get_post_info_sep()
								: ''), //5
						( ('on' === $show_date)
						? mh_wp_kses( sprintf( __( '%s', 'mhc' ), esc_html( get_the_date( $meta_date ) ) ) )
								: ''), //6
						((( 'on' === $show_author || 'on' === $show_date ) && 'on' === $show_categories) ? mh_get_post_info_sep()
								: ''), //7
						('on' === $show_categories
									? get_the_category_list($sep)				
								: ''), //8
						('two' === $meta_info_style
								? '</p>'
								: ''), //9
						('two' === $meta_info_style
								? '</div>'
								: ''), //10
						('two' === $meta_info_style
								? ' post-meta-alt'
								: ''), //11
								((( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories) && 'on' === $show_comments) ? mh_get_post_info_sep()
								: ''), //12
								('on' === $show_comments
									? sprintf( esc_html__( '%s Comments','mh-composer'), number_format_i18n( get_comments_number() ) )
									: ''), //13
								((( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories || 'on' === $show_comments) && 'on' === $show_views && function_exists('the_views')) ? mh_get_post_info_sep()
								: ''), //14
						'on' === $show_views ? $the_views : ''//15
					); //$post_meta_block
				} //end check any info to show
				
				//if meta info position above title & thumbs
				if ('above' === $meta_info_position){
					if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
						echo $post_meta_block;
					} else if ('off' !== $show_meta_cont_aql){
						echo $post_meta_block;
					}
				}
				mh_mharty_post_format_content();
				
				//if for standard, gallery, video to load main content
				if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
					//if video
					if ( 'video' === $post_format && false !== ( $first_video = mh_get_first_video($post_content) ) ) :
						printf(
							'<div class="mh_main_video_container">
								%1$s
							</div>',
							$first_video
						);
					//if gallery	
					elseif ( 'gallery' === $post_format ) :
							mh_gallery_images();
					//if standard		
					elseif ( '' !== $thumb && 'on' === $show_thumbnail ) :
					//if standard & not fullwidth
					if ( 'on' !== $fullwidth ) echo '<div class="mhc_image_container">'; ?>
                        <a href="<?php esc_url( the_permalink() ); ?>" class="featured_image_container">
                            <?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
                        </a>
					<?php if ( 'on' !== $fullwidth ) echo '</div> <!-- .mhc_image_container -->'; endif;
				} ?>
				<div class="mhc_post_content">
				<?php //if meta info position above title & under thumbs
				if ('middle' === $meta_info_position){
					if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
						echo $post_meta_block;
					} else if ('off' !== $show_meta_cont_aql){
						echo $post_meta_block;
					}
				}

				if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {?>
					<h2><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a><?php echo $the_ratings; ?></h2>
				<?php }
				
				//if meta info position above title & under thumbs
				if ('below' === $meta_info_position){
					if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
						echo $post_meta_block;
					} else if ('off' !== $show_meta_cont_aql){
						echo $post_meta_block;
					}
				}
				
				if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) )  || ( in_array( $post_format, array( 'link', 'audio', 'quote' ) ) &&  'off' !== $show_meta_cont_aql)) {
					
						if ( 'on' === $show_content ) { 
							// do not display the content if it contains Blog or Portfolio
							if ( ! has_shortcode( $post_content, 'mhc_blog' ) && ! has_shortcode( $post_content, 'mhc_portfolio' ) && ! has_shortcode( $post_content, 'mhc_ticker' ) && ! has_shortcode( $post_content, 'mhc_fullwidth_ticker' ) && ! has_shortcode( $post_content, 'mhc_magazine' )  && ! has_shortcode( $post_content, 'mhc_fullwidth_magazine' ) ) {
								global $more;
								// page composer doesn't support more tag,
								//so display the_content() in case of post made with page composer
								if ( mh_composer_is_active( get_the_ID() ) ) {
									$more = 1;
									the_content();
								} else {
									$more = null;
									the_content( apply_filters( 'mh_read_more_text_filter', esc_html__( 'Read more', 'mh-composer' )) . '...' );
								}
								
							} else if ( has_excerpt() ) {
								the_excerpt();
							} //end ! has_shortcode
							
						} elseif ( 'off' === $show_content ) { 
								if ( has_excerpt() ) { 
									the_excerpt();
								} else { 
									if ( ! has_shortcode( $post_content, 'mhc_blog' ) && ! has_shortcode( $post_content, 'mhc_portfolio' ) && ! has_shortcode( $post_content, 'mhc_ticker' ) && ! has_shortcode( $post_content, 'mhc_fullwidth_ticker' ) && ! has_shortcode( $post_content, 'mhc_magazine' )  && ! has_shortcode( $post_content, 'mhc_fullwidth_magazine' ) )
								if ('off' === $fullwidth){truncate_post( 120 );}else{truncate_post( 270 ); }
								} //end nested if
								
								//show more link or not
					$more = 'on' == $show_more ? sprintf( '%4$s<a href="%1$s" class="more-link%3$s" >%2$s</a>%5$s',
						esc_url( get_permalink() ),
						apply_filters( 'mh_read_more_text_filter', esc_html__( 'Read more', 'mh-composer' )),
						'off' !== $show_more_button ? ' mhc_contact_submit' : '',
						'off' !== $show_more_button ? '<div class="mhc_more_link" >' : '', 
						'off' !== $show_more_button ? '</div>' : ''
						)  : '';
								echo $more;
					} // end if show_content
			} //end show_meta_cont_aql
			
			// show love icon      
			if (( 'on' === $show_loveit ) && ( function_exists('mh_loveit') )): mh_loveit();  endif; ?>
            </div> <!--mhc_post_content-->
		</article> <!-- .mhc_post -->
	<?php } // endwhile

	if ( 'on' === $show_pagination && ! is_search() ) {
		echo '</div> <!-- .mhc_posts -->';

		$container_is_closed = true;

		if ( function_exists( 'wp_pagenavi' ) )
			wp_pagenavi();
		else
			get_template_part( 'includes/navigation', 'index' );
	}

	wp_reset_query();
	
} else {
	get_template_part( 'includes/no-results', 'index' );
}

	$posts = ob_get_contents();

	ob_end_clean();

	$class = " mhc_bg_layout_{$background_layout}";

	$output = sprintf(
		'<div%4$s class="%1$s%5$s%6$s%7$s%8$s">
			%2$s
		%3$s',
		( 'off' !== $fullwidth ? ' mhc_posts' : 'mhc_blog_grid clearfix' ),
		$posts,
		( ! $container_is_closed ? '</div> <!-- .mhc_posts -->' : '' ),
		( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
		( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
		'horizontal' === $fullwidth ? ' mhc_blog_horizantal' : '',
		'on' === $fullwidth ? ' mhc_blog_fullwidth' : '',
		esc_attr( $class )
	);

	if ( 'off' === $fullwidth )
		$output = sprintf( '<div class="mhc_blog_grid_wrapper %2$s">%1$s</div>', $output, esc_attr( $class ) );

			return $output;
	}
}
new MHComposer_Component_Blog;