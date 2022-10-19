<?php class FoursixeightWidget extends WP_Widget
{
	function __construct() {
		$widget_ops = array( 'description' => esc_html__('Displays 468 Ads', 'mharty'));
		$control_ops = array( 'width' => 250, 'height' => 500 );
		parent::__construct( false, $name=esc_html__('MH 468 Ad Widget', 'mharty'), $widget_ops,$control_ops );
	}

	/* Displays the Widget in the front-end */
	function widget( $args, $instance ){
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : esc_html( $instance['title'] ) );
		$foursixeightCode = empty( $instance['foursixeightCode'] ) ? '' : $instance['foursixeightCode'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;
		?>
		<div style="overflow: hidden;">
			<?php echo $foursixeightCode; ?>
			<div class="clearfix"></div>
		</div> <!-- end foursixeight -->
	<?php
		echo $after_widget;
	}

	/*Saves the settings. */
	function update( $new_instance, $old_instance ){
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['foursixeightCode'] = current_user_can('unfiltered_html') ? $new_instance['foursixeightCode'] : stripslashes( wp_filter_post_kses( addslashes($new_instance['foursixeightCode']) ) );

		return $instance;
	}

	/*Creates the form for the widget in the back-end. */
	function form( $instance ){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title'=> esc_html__('Ad', 'mharty'), 'foursixeightCode'=>'' ) );

		$title = esc_attr( $instance['title'] );
		$foursixeightCode = esc_textarea( $instance['foursixeightCode'] );

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . esc_html_e('Title:', 'mharty') . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		# Foursixeight Code
		echo '<p><label for="' . $this->get_field_id('foursixeightCode') . '">' . esc_html_e('Ad Code:', 'mharty') . '</label><textarea cols="20" rows="12" class="widefat" id="' . $this->get_field_id('foursixeightCode') . '" name="' . $this->get_field_name('foursixeightCode') . '" >'. $foursixeightCode .'</textarea></p>';
	}

}// end FoursixeightWidget class

function FoursixeightWidgetInit() {
	register_widget('FoursixeightWidget');
}

add_action('widgets_init', 'FoursixeightWidgetInit'); ?>