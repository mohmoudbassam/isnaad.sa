<?php class MhWidgetInfo extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => esc_html__( 'Displays email, phone and location.', 'mharty' ));
		$control_ops = array( 'width' => 250, 'height' => 400 );
		parent::__construct( false, $name= esc_html__( 'MH Info', 'mharty' ), $widget_ops, $control_ops );

	}


	function widget( $args, $instance ) {
		extract($args);

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$show_icons = $instance["show_icons"] ? "1" : "0";
		$email = empty( $instance['email'] ) ? '' : $instance['email'];
		$email_ex = empty( $instance['email_ex'] ) ? '' : $instance['email_ex'];
		$phone = empty( $instance['phone'] ) ? '' : $instance['phone'];
		$phone_ex = empty( $instance['phone_ex'] ) ? '' : $instance['phone_ex'];
		$location = empty( $instance['location'] ) ? '' : $instance['location'];
		

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title; 
            echo '<div class="mh_widget_info_inner clearfix">';
                if ( $email || $email_ex ){
                    echo '<p class="mh_widget_info_email">';
					if($show_icons == true) echo '<i class="mhc-icon mhicons"></i><br />';
                    echo esc_attr( $email );
                    if ( $email_ex && $email) echo '<br />';
                    echo  esc_attr( $email_ex );
                    echo '</p>';
				}
				if ( $phone || $phone_ex ){
                    echo '<p class="mh_widget_info_phone">';
					if($show_icons == true) echo '<i class="mhc-icon mhicons"></i><br />';
                    echo mh_sanitize_text_input( $phone ); 
                    if ( $phone_ex && $phone) echo '<br />';
                   	echo mh_sanitize_text_input( $phone_ex );
                    echo '</p>';
				}
				if ( $location) {
				echo '<p class="mh_widget_info_location">';
				if($show_icons == true) echo '<i class="mhc-icon mhicons"></i><br />';
				 echo wp_kses_post( $location ) . '</p>';
				}
                
            echo '</div> <!-- end info widget -->';   
		echo $after_widget;


	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance["title"] = strip_tags( $new_instance["title"] );
		$instance["show_icons"] = !empty( $new_instance["show_icons"] ) ? 1 : 0;
		$instance["email"] = strip_tags( $new_instance["email"] );
		$instance["email_ex"] = strip_tags( $new_instance["email_ex"] );
		$instance["phone"] = strip_tags( $new_instance["phone"] );
		$instance["phone_ex"] = strip_tags( $new_instance["phone_ex"] );
		$instance['location'] = current_user_can('unfiltered_html') ? $new_instance['location'] : stripslashes( wp_filter_post_kses( addslashes($new_instance['location']) ) );

		return $instance;
	}


	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array(
		'title'=> esc_html__('Info', 'mharty'), 'show_icons' => 0, 'email'=>'', 'email_ex'=>'', 'phone'=>'', 'phone_ex'=>'', 'location'=>'') );

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$show_icons = isset( $instance["show_icons"] ) ? (bool) $instance["show_icons"] : true;
		$email = esc_attr( $instance['email'] );
		$email_ex = esc_attr( $instance['email_ex'] );
		$phone = mh_sanitize_text_input( $instance['phone'] );
		$phone_ex = mh_sanitize_text_input( $instance['phone_ex'] );
		$location = wp_kses_post( $instance['location'] );


        //title
        echo '<p><label for="' . $this->get_field_id('title') . '">' . esc_html__('Title:', 'mharty') . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		//show icons?
		?>
		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_icons' ); ?>" name="<?php echo $this->get_field_name( 'show_icons' ); ?>"<?php checked( $show_icons ); ?> />
		<label for="<?php echo $this->get_field_id( 'show_icons' ); ?>"><?php esc_html_e('Show icons', 'mharty'); ?></label></p>
        <?php
		//explain
        echo '<p>' . esc_html_e('If you don\'t want to display some info, leave its fields empty.','mharty') . '</p>';
        //email #1
        echo '<p><label for="' . $this->get_field_id('email') . '">' . esc_html__('Email #1', 'mharty') . ': </label><input class="widefat" dir="ltr" id="' . $this->get_field_id('email') . '" name="' . $this->get_field_name('email') . '" type="text" value="' . $email . '" /></p>';
        //email #2
        echo '<p><label for="' . $this->get_field_id('email_ex') . '">' . esc_html__('Email #2', 'mharty') . ': </label><input class="widefat" dir="ltr" id="' . $this->get_field_id('email_ex') . '" name="' . $this->get_field_name('email_ex') . '" type="text" value="' . $email_ex . '" /></p>';        
        //phone #1
        echo '<p><label for="' . $this->get_field_id('phone') . '">' . esc_html__('Phone #1', 'mharty') . ': </label><input class="widefat" dir="ltr" id="' . $this->get_field_id('phone') . '" name="' . $this->get_field_name('phone') . '" type="text" value="' . $phone . '" /></p>';
        //phone #2
        echo '<p><label for="' . $this->get_field_id('phone_ex') . '">' . esc_html__('Phone #2', 'mharty') . ': </label><input class="widefat" dir="ltr" id="' . $this->get_field_id('phone_ex') . '" name="' . $this->get_field_name('phone_ex') . '" type="text" value="' . $phone_ex . '" /></p>';
        //location
        echo '<p><label for="' . $this->get_field_id('location') . '">' . esc_html__('Location', 'mharty') . ': </label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('location') . '" name="' . $this->get_field_name('location') . '" >'. $location .'</textarea></p>';
	


	}
}// end MhWidgetInfo class

function MhWidgetInfoInit() {
	register_widget( 'MhWidgetInfo' );
}

add_action( 'widgets_init', 'MhWidgetInfoInit' );