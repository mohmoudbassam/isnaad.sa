<?php
class MHComposer_Component_Writer extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Author', 'mh-composer' );
		$this->slug = 'mhc_writer';
		$this->main_css_selector = '%%order_class%%.mhc_author_card';
		
		$this->approved_fields = array(
			'user_post',
			'users_list',
			'user_avatar',
			'user_url',
			'user_social',
			'user_blurb',
			'animation',
			'background_layout',
			'size',
			'admin_label',
			'module_id',
			'module_class',
		);
		
		$this->fields_defaults = array(
			'user_post'			=> array( 'off' ),
			'users_list'		=> array( 'none' ),
			'user_avatar'		=> array( 'on' ),
			'user_url'			=> array( 'on' ),
			'user_social'		=> array( 'on' ),
			'user_blurb'		=> array( 'on' ),
			'animation'			=> array( 'off' ),
			'background_layout'	=> array( 'light' ),
			'size'				=> array( 'xl' ),
		);
		
		$this->custom_css_options = array(
			'writer_avatar' => array(
				'label'    => esc_html__( 'Author Avatar Container', 'mh-composer' ),
				'selector' => '.author-header-avatar',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'writer_avatar_img' => array(
				'label'    => esc_html__( 'Author Avatar', 'mh-composer' ),
				'selector' => '.author-header-avatar img',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'writer_name' => array(
				'label'    => esc_html__( 'Name', 'mh-composer' ),
				'selector' => '.author-name',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'writer_bio' => array(
				'label'    => esc_html__( 'Author Biographical Info', 'mh-composer' ),
				'selector' => '.author-bio',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'writer_url' => array(
				'label'    => esc_html__( 'Author URL', 'mh-composer' ),
				'selector' => '.author-posts-url',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'writer_social_icons' => array(
				'label'    => esc_html__( 'Author Social Icons', 'mh-composer' ),
				'selector' => '.author-social-icons',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
			'writer_social_icon' => array(
				'label'    => esc_html__( 'Author Social Icon', 'mh-composer' ),
				'selector' => '.author-social-icons a i',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-composer' ),
			),
		);
	}
	
	function get_fields() {
		$fields = array(
			'user_post' => array(
				'label'             => esc_html__( 'Current Post Author', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off'  => esc_html__( 'No', 'mh-composer' ),
					'on' => esc_html__( 'Yes', 'mh-composer' ),
				),
				'affects'           => array(
					'#mhc_users_list',
				),
				'description'     => esc_html__( 'Here you can define whether to show the author of the current post or choose from a list.', 'mh-composer' ),
			),
			'users_list' => array(
				'label'           => esc_html__( 'Author', 'mh-composer' ),
				'renderer'        => 'mh_composer_users_list_option',
				'description'     => esc_html__( 'Here you can choose an author/user.', 'mh-composer' ),
				'depends_show_if'     => 'off',
			),
			'size' => array(
				'label'          => esc_html__( 'Size', 'mh-composer' ),
				'type'           => 'select',
				'options'		=> array(
					'xl'	=> esc_html__( 'Large', 'mh-composer' ),
					'xs'	=> esc_html__( 'Small', 'mh-composer' ),
					),
				'description'    => esc_html__( 'This will change the size of this component.', 'mh-composer' ),
			),
			'user_avatar' => array(
				'label'           => esc_html__( 'Author Avatar', 'mh-composer' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'     => esc_html__( 'Here you can define whether to show the author avatar.', 'mh-composer' ),
			),
			'user_url' => array(
				'label'             => esc_html__( 'Author URL', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'     => esc_html__( 'Here you can define whether to display the author articles URL.', 'mh-composer' ),
			),
			'user_social' => array(
				'label'             => esc_html__( 'Author Social Icons', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'     => esc_html__( 'Here you can define whether to show the author social profiles icons.', 'mh-composer' ),
			),
			'user_blurb' => array(
				'label'             => esc_html__( 'Author Biographical Info', 'mh-composer' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-composer' ),
					'off' => esc_html__( 'No', 'mh-composer' ),
				),
				'description'     => esc_html__( 'Here you can define whether to show the author biographical info.', 'mh-composer' ),
			),
			'animation' => array(
				'label'             => esc_html__( 'Animation', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'off'     => esc_html__( 'No Animation', 'mh-composer' ),
					'fade_in' => esc_html__( 'Fade In', 'mh-composer' ),
					'right'   => esc_html__( 'Right To Left', 'mh-composer' ),
					'left'    => esc_html__( 'Left To Right', 'mh-composer' ),
					'top'     => esc_html__( 'Top To Bottom', 'mh-composer' ),
					'bottom'  => esc_html__( 'Bottom To Top', 'mh-composer' ),
					'scaleup' => esc_html__( 'Scale Up', 'mh-composer' ),
				),
				'description'       => esc_html__( 'This controls the direction of the lazy-loading animation.', 'mh-composer' ),
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Colour', 'mh-composer' ),
				'type'              => 'select',
				'options'           => array(
					'light'  => esc_html__( 'Dark', 'mh-composer' ),
					'dark' => esc_html__( 'Light', 'mh-composer' ),
				),
				'description'        => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-composer' ),
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
				'tab_slug'        => 'advanced',
			),
			'module_class' => array(
				'label'           => esc_html__( '{CSS Class}', 'mh-composer' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-composer' ),
				'tab_slug'        => 'advanced',
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
		$module_id    		= $this->shortcode_atts['module_id'];
		$module_class 		= $this->shortcode_atts['module_class'];
		$user_post 			= $this->shortcode_atts['user_post'];
		$users_list 		= $this->shortcode_atts['users_list'];
		$user_avatar 		= $this->shortcode_atts['user_avatar'];
		$user_url 			= $this->shortcode_atts['user_url'];
		$user_social 		= $this->shortcode_atts['user_social'];
		$user_blurb			= $this->shortcode_atts['user_blurb'];
		$animation 			= $this->shortcode_atts['animation'];
		$background_layout 	= $this->shortcode_atts['background_layout'];
		$size				= $this->shortcode_atts['size'];
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		global $post;
		$the_user = $user_posts_url = '';
		if ( 'off' !== $user_post){
			$user =  $post->post_author;
			$the_user =  get_userdata($user);
		}else{
			$the_user =  get_userdata($users_list);
		}
		
		if ( 'off' !== $user_url && 'none' !== $users_list ) {
			$user_posts_url = sprintf('<a class="author-posts-url" href="%1$s">%2$s %3$s</a>',
			 sprintf( '%1$s%2$s/',
			 esc_url( site_url( '/author/')),
			 esc_attr( $the_user->user_login )
			 ),
			 esc_html__( 'Articles by', 'mh-composer' ),
			esc_html( $the_user->display_name )
			 );
		}
		
		$the_user_avatar = '';
		 if ( 'off' !== $user_avatar && 'none' !== $users_list ) {
				$the_user_avatar = sprintf(
					'<div class="author-header-avatar">
						%1$s
					</div>',
					( 'xl' !== $size ? get_avatar( $the_user->user_email, 80 ) : get_avatar( $the_user->user_email, 110 ))
				);
			}
			
			$the_user_social = '';
		 if ( 'off' !== $user_social && 'none' !== $users_list ) {
				$the_user_social = sprintf(
					'%1$s%2$s%3$s%4$s%5$s%6$s%7$s%8$s%9$s',
					( '' !== $the_user->twitter ? sprintf( '<a href="%1$s" class="mh-author-net twitter" title="Twitter" target="_blank"><i class="icon"></i></a>', esc_url( $the_user->twitter ) ) : '' ),
					( '' !== $the_user->facebook ? sprintf( '<a href="%1$s" class="mh-author-net facebook" title="Facebook" target="_blank"><i class="icon"></i></a>', esc_url( $the_user->facebook ) ) : '' ),
					( '' !== $the_user->googleplus ? sprintf( '<a href="%1$s" class="mh-author-net google-plus" title="Google+" target="_blank"><i class="icon"></i></a>', esc_url( $the_user->googleplus ) ) : '' ),
					( '' !== $the_user->youtube ? sprintf( '<a href="%1$s" class="mh-author-net youtube" title="YouTube" target="_blank"><i class="icon"></i></a>', esc_url( $the_user->youtube ) ) : '' ),
					( '' !== $the_user->instagram ? sprintf( '<a href="%1$s" class="mh-author-net instagram" title="Instagram" target="_blank"><i class="icon"></i></a>', esc_url( $the_user->instagram ) ) : '' ),
					( '' !== $the_user->dribbble ? sprintf( '<a href="%1$s" class="mh-author-net dribbble" title="Dribbble" target="_blank"><i class="icon"></i></a>', esc_url( $the_user->dribbble ) ) : '' ),
					( '' !== $the_user->behance ? sprintf( '<a href="%1$s" class="mh-author-net behance" title="Behance" target="_blank"><i class="icon"></i></a>', esc_url( $the_user->behance ) ) : '' ),
					( '' !== $the_user->linkedin ? sprintf( '<a href="%1$s" class="mh-author-net linkedin" title="Linkedin" target="_blank"><i class="icon"></i></a>', esc_url( $the_user->linkedin ) ) : '' ),
					( '' !== $the_user->flickr ? sprintf( '<a href="%1$s" class="mh-author-net flickr" title="Flickr" target="_blank"><i class="icon"></i></a>', esc_url( $the_user->flickr ) ) : '' )
				);
			}
			$class = " mhc_module mhc_bg_layout_{$background_layout} mhc_animation_{$animation} mhc_author_{$size}";
			
			$output = sprintf(
			'<div%6$s class="mhc_author_card mhc_pct clearfix mh-waypoint%7$s%10$s">
			  <div class="author-header">
			  %8$s%1$s%9$s
				<div class="author-header-content">
				 <h4 class="author-name">%2$s</h4>
				 %3$s
				 %4$s
				 %5$s
				</div> <!-- .author-header-content --> 
			  </div> <!-- .author-header -->
			</div> <!--end .mhc_author_card-->',
			$the_user_avatar,
			('none' !== $users_list ? $the_user->display_name : ''),
			( 'off' !== $user_blurb && 'none' !== $users_list && '' !== $the_user->description ?  sprintf( 
			'<div class="author-bio">%1$s</div>',  $the_user->description) : ''),
			$user_posts_url,
			( 'on' === $user_social ?  sprintf( 
			' <div class="author-social-icons">%1$s</div>',  $the_user_social) : ''),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			('off' !== $user_url && 'none' !== $users_list ? sprintf( '<a href="%1$s%2$s/">', esc_url( site_url( '/author/')), esc_attr( $the_user->user_login ) ) : ''),
			('off' !== $user_url && 'none' !== $users_list ? '</a>' : ''),
			$class
			);
			
		return $output;
	
	}
}
new MHComposer_Component_Writer;