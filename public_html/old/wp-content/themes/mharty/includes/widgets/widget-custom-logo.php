<?php class CustomLogoWidget extends WP_Widget
{
    function __construct() {
		$widget_ops = array('description' => esc_html__( 'Logo or an image with text.', 'mharty' ));
		$control_ops = array('width' => 250, 'height' => 400);
		parent::__construct(false,$name= esc_html__( 'MH Custom Logo Widget', 'mharty' ),$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$logoImagePath = empty($instance['logoImagePath']) ? '' : $instance['logoImagePath'];
		$textInfo = empty($instance['textInfo']) ? '' : $instance['textInfo'];

		echo $before_widget;
?>
<p class="customlogowidget-logo"><img alt="" src="<?php echo esc_attr( $logoImagePath ); ?>" /></p>
<p><?php echo $textInfo; ?></p>

<?php
		echo $after_widget;
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['logoImagePath'] = esc_url_raw( $new_instance['logoImagePath'] );
		$instance['textInfo'] = current_user_can('unfiltered_html') ? $new_instance['textInfo'] : stripslashes( wp_filter_post_kses( addslashes($new_instance['textInfo']) ) );

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('logoImagePath'=>'', 'textInfo'=>'') );

		$logoImagePath = $instance['logoImagePath'];
		$textInfo = $instance['textInfo'];

		# Logo Image
		echo '<p><label for="' . $this->get_field_id('logoImagePath') . '">' . esc_html_e('Logo Image URL: ', 'mharty' ) . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('logoImagePath') . '" name="' . $this->get_field_name('logoImagePath') . '" >'. esc_attr( $logoImagePath ) .'</textarea></p>';
		# Text
		echo '<p><label for="' . $this->get_field_id('textInfo') . '">' . esc_html_e('Text: ', 'mharty') . '</label><textarea cols="20" rows="5" class="widefat" id="' . $this->get_field_id('textInfo') . '" name="' . $this->get_field_name('textInfo') . '" >'. esc_textarea( $textInfo ) .'</textarea></p>';
	}

}// end CustomLogoWidget class

function CustomLogoWidgetInit() {
  register_widget('CustomLogoWidget');
}

add_action('widgets_init', 'CustomLogoWidgetInit');