<?php class MhWidgetPopularPosts extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => esc_html__( 'Displays popular posts..', 'mharty' ), 'classname' => 'mh_list_posts');
		$control_ops = array( 'width' => 250, 'height' => 400 );
		parent::__construct( 'popular_posts', esc_html__( 'MH Popular Posts.', 'mharty' ), $widget_ops, $control_ops);
		$this-> alt_option_name = "widget_popular_posts";

		add_action( "save_post", array( &$this, "flush_widget_cache" ) );
		add_action( "deleted_post", array( &$this, "flush_widget_cache" ) );
		add_action( "switch_theme", array( &$this, "flush_widget_cache" ) );
	}


	function widget( $args, $instance ) {

		$cache = wp_cache_get( "Mh_Widget_Popular_Posts", "widget" );

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

		$disable_time = $instance["disable_time"] ? "1" : "0";
		$query = array( 'showposts' => $posts_number, 'nopaging' => 0, 'orderby' => 'comment_count', 'order' => 'DSC', 'post_status' => 'publish', 'ignore_sticky_posts' => 1 );
		if ( !empty( $instance["cats"] ) ) {
			$query["cat"] = implode( ",", $instance["cats"] );
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
	       <?php if($disable_time == true) {  ?>
	       <time datetime="<?php the_date() ?>"><?php echo get_the_date(); ?></time>
	       <?php } ?>
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
		wp_cache_set( 'Mh_Widget_Popular_Posts', $cache, 'widget' );


	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance["title"] = strip_tags( $new_instance["title"] );
		$instance["posts_number"] = (int) $new_instance["posts_number"];
		$instance["disable_time"] = !empty( $new_instance["disable_time"] ) ? 1 : 0;
		$instance["cats"] = !empty( $new_instance["cats"] ) ? $new_instance["cats"] : '';

		$this-> flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['Mh_Widget_Popular_Posts'] ) )
			delete_option( 'Mh_Widget_Popular_Posts' );

		return $instance;
	}



	function flush_widget_cache() {
		wp_cache_delete( 'Mh_Widget_Popular_Posts', 'widget' );
	}





	function form( $instance ) {

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

		$disable_time = isset( $instance["disable_time"] ) ? (bool) $instance["disable_time"] : true;
		$cats = isset( $instance['cats'] ) ? $instance['cats'] : array();

		if ( !isset( $instance['posts_number'] ) || !$posts_number = (int) $instance['posts_number'] )
			$posts_number = 3;


		$categories = get_categories( 'orderby=name&hide_empty=0' );


?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title:', 'mharty'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'posts_number' ); ?>"><?php esc_html_e('Number of posts:', 'mharty'); ?></label>
		<input id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" type="text" value="<?php echo $posts_number; ?>" class="widefat" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'disable_time' ); ?>" name="<?php echo $this->get_field_name( 'disable_time' ); ?>"<?php checked( $disable_time ); ?> />
		<label for="<?php echo $this->get_field_id( 'disable_time' ); ?>"><?php esc_html_e('Show Date', 'mharty'); ?></label></p>

        <p><label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php esc_html_e('Which Categories to show?', 'mharty'); ?></label>
        <select style="height:15em" name="<?php echo $this->get_field_name( 'cats' ); ?>[]" id="<?php echo $this->get_field_id( 'cats' ); ?>" class="widefat" multiple="multiple">
            <?php foreach ( $categories as $category ):?>
            <option value="<?php echo $category->term_id;?>"<?php echo in_array( $category->term_id, array($cats) ) ? ' selected="selected"':'';?>><?php echo $category->name;?></option>
            <?php endforeach;?>
        </select></p>
<?php


	}
}// end MhWidgetPopularPosts class

function MhWidgetPopularPostsInit() {
	register_widget( 'MhWidgetPopularPosts' );
}

add_action( 'widgets_init', 'MhWidgetPopularPostsInit' );