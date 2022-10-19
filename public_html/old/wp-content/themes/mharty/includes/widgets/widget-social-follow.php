<?php class MhWidgetSocialFollow extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => esc_html__( 'Displays links to your social websites.', 'mharty' ));
		$control_ops = array( 'width' => 250, 'height' => 400 );
		parent::__construct( false, $name=esc_html__( 'MH Social Follow', 'mharty' ), $widget_ops, $control_ops );

	}


	function widget( $args, $instance ) {
		extract($args);

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$fullwidth = $instance["fullwidth"] ? "1" : "0";
		$social_colors = $instance["social_colors"] ? "1" : "0";
		$solid = $instance["solid"] ? "1" : "0";

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title; 
		$class = $fullwidth == true ? ' mh_social_follow_fullwidth' : '';
		$class .= $social_colors == true ? ' mh-social-default-color mh-social-bg-color' : ' mh-social-accent-color';
		$class .= $solid == true ? ' mh-social-solid-color' : ' mh-social-transparent';
            echo '<div class="mh_widget_social_follow_inner' . esc_attr($class) . ' clearfix">';
            get_template_part( 'includes/social_icons' );
            echo '</div> <!-- end social follow widget inner -->';   
		echo $after_widget;


	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance["title"] = strip_tags( $new_instance["title"] );
		$instance["fullwidth"] = !empty( $new_instance["fullwidth"] ) ? 1 : 0;
		$instance["social_colors"] = !empty( $new_instance["social_colors"] ) ? 1 : 0;
		$instance["solid"] = !empty( $new_instance["solid"] ) ? 1 : 0;

		return $instance;
	}


	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array(
		'title'=>__('Follow Us', 'mharty'), 'fullwidth' => 0, 'social_colors' => 0, 'solid' => 0, ) );

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$fullwidth = isset( $instance["fullwidth"] ) ? (bool) $instance["fullwidth"] : true;
		$social_colors = isset( $instance["social_colors"] ) ? (bool) $instance["social_colors"] : true;
		$solid = isset( $instance["solid"] ) ? (bool) $instance["solid"] : true;
        //title
        echo '<p><label for="' . $this->get_field_id('title') . '">' . esc_html('Title:', 'mharty') . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		//fullwidth style?
		?>
		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'fullwidth' ); ?>" name="<?php echo $this->get_field_name( 'fullwidth' ); ?>"<?php checked( $fullwidth ); ?> />
		<label for="<?php echo $this->get_field_id( 'fullwidth' ); ?>"><?php esc_html_e('Full-width', 'mharty'); ?></label></p>
        <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'social_colors' ); ?>" name="<?php echo $this->get_field_name( 'social_colors' ); ?>"<?php checked( $social_colors ); ?> />
		<label for="<?php echo $this->get_field_id( 'social_colors' ); ?>"><?php esc_html_e('Default Colours', 'mharty'); ?></label></p>
        <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'solid' ); ?>" name="<?php echo $this->get_field_name( 'solid' ); ?>"<?php checked( $solid ); ?> />
		<label for="<?php echo $this->get_field_id( 'solid' ); ?>"><?php esc_html_e('Solid Colour', 'mharty'); ?></label></p>
        <?php
		//explain
        echo '<p>' . esc_html_e('You may need to activate the desired icons from the theme panel.','mharty') . '</p><br />';

	}
}// end MhWidgetInfo class

function MhWidgetSocialFollowInit() {
	register_widget( 'MhWidgetSocialFollow' );
}

add_action( 'widgets_init', 'MhWidgetSocialFollowInit' );