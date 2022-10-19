<?php
if ( ! defined( 'ABSPATH' ) ) { die( '-1' ); }

if (class_exists('MH_Meta_Box', false) ) {
	class MH_Theme_Meta_Box extends MH_Meta_Box {

		public function __construct() {
			parent::__construct( 'mh_settings_meta_box', esc_html__( 'Theme Settings', 'mharty' ), array(
				'post_type' => array('page', 'post', 'project', 'product', ),
				'context'   => 'side',
				'priority'  => 'high',
			) );
		}
		
		function fields() {
			global $post;

			if ( is_rtl() ){
				$page_layouts = array(
					'mh_left_sidebar'    => esc_html__( 'Left Sidebar', 'mharty' ),
					'mh_right_sidebar'   => esc_html__( 'Right Sidebar', 'mharty' ),
					'mh_full_width_page' => esc_html__( 'Full-width', 'mharty' ),
				);
			}else{
				$page_layouts = array(
					'mh_right_sidebar'   => esc_html__( 'Right Sidebar', 'mharty' ),
					'mh_left_sidebar'    => esc_html__( 'Left Sidebar', 'mharty' ),
					'mh_full_width_page' => esc_html__( 'Full-width', 'mharty' ),
				);
			}

			$post_custom_templates = array(
				'mh_post_default'    => esc_html__( 'Default', 'mharty' ),
				'mh_post_noheader'   => esc_html__( 'No Header Page', 'mharty' ),
				'mh_post_blank' 	 => esc_html__( 'Blank Page', 'mharty' ),
			);

			$bg_layout = array(
				'light' => esc_html__( 'Light', 'mharty' ),
				'dark'  => esc_html__( 'Dark', 'mharty' ),
			);
			
			$this->fields = array(
				'_mhc_page_layout'            => array(
					'title'                   => esc_html__( 'Page Layout', 'mharty' ),
					'type'       => 'select',
					'options'    => $page_layouts
				),
				'_mhc_side_nav'            => array(
					'title'                   => esc_html__( 'Side Navigation', 'mharty' ),
					'type'       => 'select',
					'options'    => array(
						'off' => esc_html__( 'Off', 'mharty' ),
						'on'  => esc_html__( 'On', 'mharty' ),
					),
				),
			);
			
			if ( 'page' == $post->post_type ) {
				$this->fields['_mhc_page_menu_color'] = array(
					'title'                   => esc_html__( 'Menu Colour', 'mharty' ),
					'description'             => esc_html__( 'Change this if you want to adjust the menu text colour to be more visible.', 'mharty' ),
				);
				$this->fields['_mh_page_bg_color'] = array(
					'title'                   => esc_html__( 'Background Colour', 'mharty' ),
					'description'             => esc_html__( 'Change this if you want to adjust the background colour.', 'mharty' ),
				);
			}
			
			if ( 'post' === $post->post_type || 'project' === $post->post_type ) {
				$this->fields['_mhc_post_custom_template'] = array(
					'title'                   => esc_html__( 'Post Template', 'mharty' ),
					'type'       => 'select',
					'options'    => $post_custom_templates
				);
				
			}
			
			if ( 'post' === $post->post_type ) {
				$this->fields['_mh_post_use_bg_color'] = array(
					'title'                   => esc_html__( 'Use Background Colour', 'mharty' ),
					'type'                    => 'checkbox',
					'value_sanitize_function' => 'wp_validate_boolean',
				);
				$this->fields['_mh_post_use_thumb_bg'] = array(
					'title'                   => esc_html__( 'Use Featured Thumbnail as Background', 'mharty' ),
					'type'                    => 'checkbox',
					'value_sanitize_function' => 'wp_validate_boolean',
				);
				$this->fields['_mh_post_bg_color'] = array(
					'title'                   => esc_html__( 'Background Colour', 'mharty' ),
				);
				$this->fields['_mh_post_bg_layout'] = array(
					'title'                   => esc_html__( 'Text Colour', 'mharty' ),
					'type'       => 'select',
					'options'    => $bg_layout
				);
				$this->fields['_mh_post_quote_author'] = array(
					'title'                   => esc_html__( 'Quote Author', 'mharty' ),
					'value_sanitize_function' => 'sanitize_text_field',
				);
				
			}
		}

		function display( $post ) {		
			echo '<div class="form-field">';?>
			<p class="mhc_page_settings mhc_page_layout_settings">
				<label for="mhc_page_layout" style="display: block; font-weight: bold; margin-bottom: 5px;">
					<?php echo $this->fields['_mhc_page_layout']['title']; ?>: </label>

				<select id="mhc_page_layout" name="_mhc_page_layout">
					<?php $page_layout = $this->fields['_mhc_page_layout']['value'];
					foreach ( $this->fields['_mhc_page_layout']['options'] as $layout_value => $layout_name ) {
						printf( '<option value="%2$s"%3$s>%1$s</option>',
							esc_html( $layout_name ),
							esc_attr( $layout_value ),
							selected( $layout_value, $page_layout, false )
						);
					} ?>
				</select>
				</p> <!--mhc_page_layout_settings-->
				
				<p class="mhc_page_settings mhc_side_nav_settings" style="display: none;">
					<label for="mhc_side_nav" style="display: block; font-weight: bold; margin-bottom: 5px;">
						<?php echo $this->fields['_mhc_side_nav']['title']; ?>: </label>
	
					<select id="mhc_side_nav" name="_mhc_side_nav">
					<?php $side_nav = $this->fields['_mhc_side_nav']['value'];
					foreach ( $this->fields['_mhc_side_nav']['options'] as $side_nav_value => $side_nav_name ) {
						printf( '<option value="%2$s"%3$s>%1$s</option>',
							esc_html( $side_nav_name ),
							esc_attr( $side_nav_value ),
							selected( $side_nav_value, $side_nav, false )
						);
					} ?>
					</select>
				</p> <!--mhc_side_nav_settings-->
				
				<?php if ( 'page' == $post->post_type ) { ?>
				<p id="mhc_page_menu_color_settings">
					<label for="mhc_page_menu_color" style="display: block; font-weight: bold; margin-bottom: 5px;">
						<?php echo $this->fields['_mhc_page_menu_color']['title']; ?>: </label>
					
					<input id="mhc_page_menu_color" name="_mhc_page_menu_color" class="color-picker-hex" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value', 'mharty' ); ?>" value="<?php echo esc_attr( $this->fields['_mhc_page_menu_color']['value'] ); ?>" data-default-color="#ffffff" />
					<br />
					<small><?php echo $this->fields['_mhc_page_menu_color']['description']; ?></small>
				</p> <!--mhc_page_menu_color_settings-->
   			
    			<p id="mh_page_bg_color">
					<label for="mh_page_bg_color" style="display: block; font-weight: bold; margin-bottom: 5px;">
						<?php echo $this->fields['_mh_page_bg_color']['title']; ?>: </label>

					<input id="mh_page_bg_color" name="_mh_page_bg_color" class="color-picker-hex" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value', 'mharty' ); ?>" value="<?php echo esc_attr( $this->fields['_mh_page_bg_color']['value'] ); ?>" data-default-color="#ffffff" />
					<br />
					<small><?php echo $this->fields['_mh_page_bg_color']['description']; ?></small>
				</p> <!--mh_page_bg_color-->
				<?php  } ?>
	    	
		    	<?php if ( 'post' === $post->post_type || 'project' === $post->post_type)  { ?>
		    	<p class="mhc_post_settings mhc_post_custom_template_settings">
		    		<label for="mhc_post_custom_template" style="display: block; font-weight: bold; margin-bottom: 5px;">
		    			<?php echo $this->fields['_mhc_post_custom_template']['title']; ?>: </label>

					<select id="mhc_post_custom_template" name="_mhc_post_custom_template">
					<?php $post_custom_template = $this->fields['_mhc_post_custom_template']['value'];
					foreach ( $this->fields['_mhc_post_custom_template']['options'] as $template_value => $template_name ) {
						printf( '<option value="%2$s"%3$s>%1$s</option>',
							esc_html( $template_name ),
							esc_attr( $template_value ),
							selected( $template_value, $post_custom_template, false )
						);
					} ?>
					</select>
				</p> <!--mhc_post_custom_template_settings-->
		    	<?php  } ?>
		    	
		    	<?php if ( 'post' == $post->post_type ) { ?>
		    		<p class="mh_mharty_quote_settings mh_mharty_audio_settings mh_mharty_link_settings mh_mharty_format_setting">
						<label for="mh_post_use_bg_color" style="display: block; font-weight: bold; margin-bottom: 5px;">
						<input name="_mh_post_use_bg_color" type="checkbox" id="mh_post_use_bg_color" <?php checked( $this->fields['_mh_post_use_bg_color']['value'], '1' ); ?> />
							<?php echo $this->fields['_mh_post_use_bg_color']['title']; ?></label>
					</p>

					<p class="mh_mharty_quote_settings mh_mharty_audio_settings mh_mharty_link_settings mh_mharty_format_setting">
						<label for="mh_post_use_thumb_bg" style="display: block; font-weight: bold; margin-bottom: 5px;">
						<input name="_mh_post_use_thumb_bg" type="checkbox" id="mh_post_use_thumb_bg" <?php checked( $this->fields['_mh_post_use_thumb_bg']['value'], '1' ); ?> />
							<?php echo $this->fields['_mh_post_use_thumb_bg']['title']; ?></label>
					</p>

					<p class="mh_post_bg_color_setting mh_mharty_format_setting">
						<label for="mh_post_bg_color" style="display: block; font-weight: bold; margin-bottom: 5px;">
							<?php echo $this->fields['_mh_post_bg_color']['title']; ?>: </label>
							
						<input id="mh_post_bg_color" name="_mh_post_bg_color" class="color-picker-hex" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value', 'mharty' ); ?>" value="<?php echo esc_attr( $this->fields['_mh_post_bg_color']['value'] ); ?>" data-default-color="#ffffff" />
					</p>

					<p class="mh_mharty_quote_settings mh_mharty_audio_settings mh_mharty_link_settings mh_mharty_format_setting">
						<label for="mh_post_bg_layout" style="font-weight: bold; margin-bottom: 5px;">
							<?php echo $this->fields['_mh_post_bg_layout']['title']; ?></label>
							
						<select id="mh_post_bg_layout" name="_mh_post_bg_layout">
					<?php
					$post_bg_layout = $this->fields['_mh_post_bg_layout']['value'];
					foreach ( $this->fields['_mh_post_bg_layout']['options'] as $layout_name => $layout_title )
							printf( '<option value="%s"%s>%s</option>',
								esc_attr( $layout_name ),
								selected( $layout_name, $post_bg_layout, false ),
								esc_html( $layout_title )
							);
					?>
						</select>
					</p>
					
					<p class="mh_mharty_format_setting mh_mharty_quote_settings">
						<label for="mh_post_quote_author" style="display: block; font-weight: bold; margin-bottom: 5px;">
							<?php echo $this->fields['_mh_post_quote_author']['title']; ?>: </label>
							
						<input id="mh_post_quote_author" name="_mh_post_quote_author" type="text" placeholder="<?php esc_attr_e( 'Author Name', 'mharty' ); ?>" value="<?php echo esc_attr( $this->fields['_mh_post_quote_author']['value'] ); ?>" />
					</p>
		    
			    <?php  } ?>
			    
		<?php echo '</div><br />';
			
		}
	}
	new MH_Theme_Meta_Box;
}