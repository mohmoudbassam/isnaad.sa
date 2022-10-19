<?php class MhLatestCommentsWidget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => esc_html__( 'The most recent comments.', 'mharty' ), 'classname' => 'mh_widget_latest_comments');
		$control_ops = array( 'width' => 250, 'height' => 400 );
		parent::__construct('mh_widget_latest_comments', esc_html__( 'MH Latest Comments', 'mharty' ), $widget_ops, $control_ops);
		$this->alt_option_name = 'mh_widget_latest_comments';
	}
	
	function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = null;
		extract( $args, EXTR_SKIP );

		echo $before_widget;
		
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base);
		if( $title ) echo $before_title . $title . $after_title;
		
		$comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => intval( $instance['count']), 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'post' ) ) );
		
		if(is_array($comments))
		{           
			$output = '<div class="Latest_comments">';
				$output .= '<ul>';
					foreach($comments as $comment)
					{
						$url = get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID .'" title="'.$comment->comment_author .' | '.get_the_title($comment->comment_post_ID);						
						//$date = get_comment_date();
						$output .= '<li>';
							$output .= '<span class="date_label">'. get_comment_date( '', $comment ) .'</span>';
							$output .= '<p><i class="icon-user"></i> <strong>'.strip_tags($comment->comment_author) .'</strong> | <a href="'. esc_url( $url ) .'">'. get_the_title($comment->comment_post_ID) .'</a></p>';
						$output .= '</li>';						
					}
				$output .= '</ul>';
						
			$output .= '</div>'."\n";
		}
		echo $output;
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = (int) $new_instance['count'];
		
		return $instance;
	}

	function form( $instance ) {
		
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 3;

		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'mharty' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of comments:', 'mharty' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3"/>
			</p>
			
		<?php
	}
}// end MhLatestCommentsWidget class

function MhLatestCommentsWidgetInit() {
	register_widget( 'MhLatestCommentsWidget' );
}

add_action( 'widgets_init', 'MhLatestCommentsWidgetInit' );