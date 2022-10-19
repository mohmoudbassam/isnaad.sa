<?php class MhWidgetReviewsPosts extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => esc_html__( 'Displays reviews.', 'mharty' ), 'classname' => 'mh_list_posts mh_reviews_widget');
		$control_ops = array( 'width' => 250, 'height' => 400 );
		parent::__construct( 'reviews_posts', esc_html__( 'MH Reviews Posts', 'mharty' ), $widget_ops, $control_ops);
		$this-> alt_option_name = "widget_reviews_posts";

		add_action( "save_post", array( &$this, "flush_widget_cache" ) );
		add_action( "deleted_post", array( &$this, "flush_widget_cache" ) );
		add_action( "switch_theme", array( &$this, "flush_widget_cache" ) );
	}

	function widget( $args, $instance ) {

		$cache = wp_cache_get( "Mh_Widget_Reviews_Posts", "widget" );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args );


		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		if ( !$posts_number = (int) $instance['posts_number'] )
			$posts_number = 10;
		else if ( $posts_number < 1 )
				$posts_number = 1;
			else if ( $posts_number > 15 )
					$posts_number = 15;

		$orderby_score = $instance["orderby_score"] ? "1" : "0";
		$query = array(
			'posts_per_page' => $posts_number,
			'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'meta_query'     => array(
				'relation' => 'AND',
    			array(
					'key' => '_post_review_features_count', 
					'value' => '0',
					'compare' => '!=',
					'type' => 'NUMERIC'
				),
				array(
					'key' => '_post_review_hide', 
					'value' => '1',
					'compare' => 'NOT EXISTS',
					'type' => 'NUMERIC'
				),
				array(
					'key' => '_post_review_features', 
					'compare' => 'EXISTS',
				)
			)
		);
		if ( !empty( $instance["cats"] ) ) {
			$query["cat"] = implode( ",", $instance["cats"] );
		}
		if($orderby_score == true) {
			$query["meta_key"] = '_post_review_features_score';
			$query["orderby"] = 'meta_value_num';
			$query["order"] = 'DESC';
		}

		$recent = new WP_Query( $query );

		if ( $recent-> have_posts() ) :

			echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title; ?>

        <ul>

		<?php

		$no_thumb_css = '';

		while ( $recent-> have_posts() ) : $recent -> the_post(); ?>

        <li class="list-post">
		<?php if ( has_post_thumbnail()) : ?>
		   <a class="list-post-thumb" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
		   <?php the_post_thumbnail('mhc-post-thumbnail'); ?>
		   </a>
		<?php else:
			$no_thumb_css = 'post-no-thumb';
			endif;
		 ?>
        <div class="list-post-info <?php echo $no_thumb_css; ?>">
        <a href="<?php the_permalink(); ?>" class="list-post-title"><?php the_title(); ?></a>
        <div class="list-post-meta">
	      <?php echo do_shortcode('[mh_reviews_meta]'); ?>
   	   </div>	
       </div>
       </li>
        
        <?php endwhile;  ?>

        </ul>
        <?php
		echo $after_widget;

		wp_reset_query();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'Mh_Widget_Reviews_Posts', $cache, 'widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance["title"] = strip_tags( $new_instance["title"] );
		$instance["posts_number"] = (int) $new_instance["posts_number"];
		$instance["orderby_score"] = !empty( $new_instance["orderby_score"] ) ? 1 : 0;
		$instance["cats"] = !empty( $new_instance["cats"] ) ? $new_instance["cats"] : '';

		$this-> flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['Mh_Widget_Reviews_Posts'] ) )
			delete_option( 'Mh_Widget_Reviews_Posts' );

		return $instance;
	}



	function flush_widget_cache() {
		wp_cache_delete( 'Mh_Widget_Reviews_Posts', 'widget' );
	}

	function form( $instance ) {

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

		$orderby_score = isset( $instance["orderby_score"] ) ? (bool) $instance["orderby_score"] : true;
		$cats = isset( $instance['cats'] ) ? $instance['cats'] : array();

		if ( !isset( $instance['posts_number'] ) || !$posts_number = (int) $instance['posts_number'] )
			$posts_number = 3;


		$categories = get_categories( 'orderby=name&hide_empty=0' );


?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title:', 'mharty'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'posts_number' ); ?>"><?php esc_html_e('Number of posts:', 'mharty'); ?></label>
		<input id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" type="text" value="<?php echo $posts_number; ?>" class="widefat" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'orderby_score' ); ?>" name="<?php echo $this->get_field_name( 'orderby_score' ); ?>"<?php checked( $orderby_score ); ?> />
		<label for="<?php echo $this->get_field_id( 'orderby_score' ); ?>"><?php esc_html_e('Order by Score', 'mharty'); ?></label></p>

        <p><label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php esc_html_e('Which Categories to show?', 'mharty'); ?></label>
        <select style="height:15em" name="<?php echo $this->get_field_name( 'cats' ); ?>[]" id="<?php echo $this->get_field_id( 'cats' ); ?>" class="widefat" multiple="multiple">
            <?php foreach ( $categories as $category ):?>
            <option value="<?php echo $category->term_id;?>"<?php echo in_array( $category->term_id, array($cats) ) ? ' selected="selected"':'';?>><?php echo $category->name;?></option>
            <?php endforeach;?>
        </select></p>
<?php
	}
}// end MhWidgetReviewsPosts class

function MhWidgetReviewsPostsInit() {
	register_widget( 'MhWidgetReviewsPosts' );
}

add_action( 'widgets_init', 'MhWidgetReviewsPostsInit' );