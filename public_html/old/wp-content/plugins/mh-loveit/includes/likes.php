<?php

//function mh_loveits_init() {

class MHLoveit {
	
	 function __construct()   {	
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
        add_action('wp_ajax_mh-loveit', array(&$this, 'ajax'));
		add_action('wp_ajax_nopriv_mh-loveit', array(&$this, 'ajax'));
	}
	
	function enqueue_scripts() {
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'mh-loveit', MH_LOVEIT_URL . 'assets/js/mh-loveit.js', 'jquery', MH_LOVEIT_VER, TRUE );
		
		wp_localize_script( 'mh-loveit', 'mhLoveit', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'loveitNonce' => wp_create_nonce('mh-loveit-nonce')
		));
	}
	
	function ajax($post_id) {
		
		//update
		if( isset($_POST['loves_id']) ) {
			$post_id = str_replace('mh-loveit-', '', $_POST['loves_id']);
			echo $this->loveit_post($post_id, 'update');
		} 
		
		//get
		else {
			$post_id = str_replace('mh-loveit-', '', $_POST['loves_id']);
			echo $this->loveit_post($post_id, 'get');
		}
		
		exit;
	}
	
	
	function loveit_post($post_id, $action = 'get') 
	{
		if(!is_numeric($post_id)) return;
	
		switch($action) {
		
			case 'get':
				$loveit_count = get_post_meta($post_id, '_mh_loveit', true);
				if( !$loveit_count ){
					$loveit_count = 0;
					add_post_meta($post_id, '_mh_loveit', $loveit_count, true);
				}
				
				return '<span class="mh-loveit-count">'. $loveit_count .'</span>';
				break;
				
			case 'update':
				
				if(!isset($_POST['loveit_nonce'])) return;
				
				$loveit_count = get_post_meta($post_id, '_mh_loveit', true);
				if( isset($_COOKIE['mh_loveit_'. $post_id]) ) return $loveit_count;
				
				$loveit_count++;
				update_post_meta($post_id, '_mh_loveit', $loveit_count);
				setcookie('mh_loveit_'. $post_id, $post_id, time()+60*60*24*30, '/');
				
				return '<span class="mh-loveit-count">'. $loveit_count .'</span>';
				break;
		
		}
	}


	function add_loveit() {
		global $post;

		$output = $this->loveit_post($post->ID);
  
  		$class = 'mh-loveit';
  		$title = esc_html__('I like it', 'mh-loveit');
		
		if( isset($_COOKIE['mh_loveit_'. $post->ID]) ){
			$class = 'mh-loveit loved';
			$title = esc_html__('You like this!', 'mh-loveit');
		}
		$class .= ('accent' === mh_get_option('mharty_share_color', 'accent') ? ' mh_share_accent' : ' mh_share_color');
		
		return '<div class="mh-loveit-container"><a href="#" class="'. $class .'" id="mh-loveit-'. $post->ID .'" title="'. $title .'"> <i class="icon-icon_heart"></i> '. $output .'</a></div>';
	}
	
}

global $mh_loveit;
$mh_loveit = new MHLoveit();

// mh_loveit function
function mh_loveit($return = '') {
	
	global $mh_loveit;

	if($return == 'return') {
		return $mh_loveit->add_loveit(); 
	} else {
		echo $mh_loveit->add_loveit(); 
	}
	
}

//} //end mh_loveit_init
//add_action( 'init', 'mh_loveits_init' );