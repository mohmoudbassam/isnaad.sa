<?php
if (!class_exists('MHShop', false)) {
	class MHComposer_Component_Shop extends MHComposer_Component {
		function init() {
			$this->name = esc_html__( 'Shop', 'mh-composer' );
			$this->slug = 'mhc_shop';
			$this->custom_css_tab = false;
			
			$this->approved_fields = array(
				'info',
			);
		}
		function get_fields() {
			$fields = array(
				'info' => array(
				'type'              => 'info',
				'info-heading' => esc_html__( 'This component requires the following plugin: ', 'mh-composer' ),
				'info-heading-bold' => esc_html__( 'Mharty - Shop', 'mh-composer' ),
				'description'     => esc_html__( 'After the plugin has been installed and activated, its settings will be displayed in this area. Please note: The Shop also requires WooCommerce plugin installed and activated.', 'mh-composer' )
				),
			);
			return $fields;
		}
	}
	new MHComposer_Component_Shop;
}

if (!class_exists('WPCF7', false)) {
	class MHComposer_Component_Contact_Form7 extends MHComposer_Component {
		function init() {
			$this->name = esc_html__( 'Contact Form 7', 'mh-composer' );
			$this->slug = 'mhc_cf7';
			$this->custom_css_tab = false;
			
			$this->approved_fields = array(
				'info',
			);
		}
		function get_fields() {
			$fields = array(
				'info' => array(
				'type'              => 'info',
				'info-heading' => esc_html__( 'This component requires the following plugin: ', 'mh-composer' ),
				'info-heading-bold' => 'Contact Form 7',
				'description'     => esc_html__( 'After the plugin has been installed and activated, its settings will be displayed in this area.', 'mh-composer' )
				),
			);
			return $fields;
		}
	}
	new MHComposer_Component_Contact_Form7;
}else{
	function mh_cf7_enqueue_admin_inline_css() {
		echo '<style>.mhc-all-modules .mhc_cf7,.mhc_saved_layouts_list .mhc_cf7{background-color:transparent; opacity:1;}</style>';
	}
	add_action('admin_head', 'mh_cf7_enqueue_admin_inline_css');
	
	include MH_COMPOSER_DIR . 'components/cf7.php';
}

if (!class_exists('MHLoveitClass', false)) {
	class MHComposer_Component_Social_Media_Share extends MHComposer_Component {
		function init() {
			$this->name = esc_html__( 'Social Media Share', 'mh-composer' );
			$this->slug = 'mhc_display_social_media_share';
			$this->custom_css_tab = false;
			
			$this->approved_fields = array(
				'info',
			);
		}
		function get_fields() {
			$fields = array(
				'info' => array(
				'type'              => 'info',
				'info-heading' => esc_html__( 'This component requires the following plugin: ', 'mh-composer' ),
				'info-heading-bold' => esc_html__( 'Mharty - Love it', 'mh-composer' ),
				'description'     => esc_html__( 'After the plugin has been installed and activated, its settings will be displayed in this area.', 'mh-composer' )
				),
			);
			return $fields;
		}
	}
	new MHComposer_Component_Social_Media_Share;
}

if (!class_exists('MHMagazine', false)) {
	class MHComposer_Component_Magazine extends MHComposer_Component {
		function init() {
			$this->name = esc_html__( 'Magazine', 'mh-composer' );
			$this->slug = 'mhc_magazine';
			$this->custom_css_tab = false;
			
			$this->approved_fields = array(
				'info',
			);
		}
		function get_fields() {
			$fields = array(
				'info' => array(
				'type'              => 'info',
				'info-heading' => esc_html__( 'This component requires the following plugin: ', 'mh-composer' ),
				'info-heading-bold' => esc_html__( 'Mharty - Magazine', 'mh-composer' ),
				'description'     => esc_html__( 'After the plugin has been installed and activated, its settings will be displayed in this area.', 'mh-composer' )
				),
			);
			return $fields;
		}
	}
	new MHComposer_Component_Magazine;
	
	class MHComposer_Component_Fullwidth_Magazine extends MHComposer_Component {
		function init() {
			$this->name = esc_html__( 'Full-width Magazine', 'mh-composer' );
			$this->slug = 'mhc_fullwidth_magazine';
			$this->custom_css_tab = false;
			$this->fullwidth = true;
			
			$this->approved_fields = array(
				'info',
			);
		}
		function get_fields() {
			$fields = array(
				'info' => array(
				'type'              => 'info',
				'info-heading' => esc_html__( 'This component requires the following plugin: ', 'mh-composer' ),
				'info-heading-bold' => esc_html__( 'Mharty - Magazine', 'mh-composer' ),
				'description'     => esc_html__( 'After the plugin has been installed and activated, its settings will be displayed in this area.', 'mh-composer' )
				),
			);
			return $fields;
		}
	}
	new MHComposer_Component_Fullwidth_Magazine;
	
	class MHComposer_Component_Ticker extends MHComposer_Component {
		function init() {
			$this->name = esc_html__( 'Ticker', 'mh-composer' );
			$this->slug = 'mhc_ticker';
			$this->custom_css_tab = false;
			
			$this->approved_fields = array(
				'info',
			);
		}
		function get_fields() {
			$fields = array(
				'info' => array(
				'type'              => 'info',
				'info-heading' => esc_html__( 'This component requires the following plugin: ', 'mh-composer' ),
				'info-heading-bold' => esc_html__( 'Mharty - Magazine', 'mh-composer' ),
				'description'     => esc_html__( 'After the plugin has been installed and activated, its settings will be displayed in this area.', 'mh-composer' )
				),
			);
			return $fields;
		}
	}
	new MHComposer_Component_Ticker;
	
	class MHComposer_Component_Fullwidth_Ticker extends MHComposer_Component {
		function init() {
			$this->name = esc_html__( 'Full-width Ticker', 'mh-composer' );
			$this->slug = 'mhc_fullwidth_ticker';
			$this->custom_css_tab = false;
			$this->fullwidth = true;
			
			$this->approved_fields = array(
				'info',
			);
		}
		function get_fields() {
			$fields = array(
				'info' => array(
				'type'              => 'info',
				'info-heading' => esc_html__( 'This component requires the following plugin: ', 'mh-composer' ),
				'info-heading-bold' => esc_html__( 'Mharty - Magazine', 'mh-composer' ),
				'description'     => esc_html__( 'After the plugin has been installed and activated, its settings will be displayed in this area.', 'mh-composer' )
				),
			);
			return $fields;
		}
	}
	new MHComposer_Component_Fullwidth_Ticker;
	
	class MHComposer_Component_Classified extends MHComposer_Component {
		function init() {
			$this->name = esc_html__( 'Classified', 'mh-composer' );
			$this->slug = 'mhc_classified';
			
			$this->approved_fields = array(
				'info',
			);
		}
		function get_fields() {
			$fields = array(
				'info' => array(
				'type'              => 'info',
				'info-heading' => esc_html__( 'This component requires the following plugin: ', 'mh-composer' ),
				'info-heading-bold' => esc_html__( 'Mharty - Magazine', 'mh-composer' ),
				'description'     => esc_html__( 'After the plugin has been installed and activated, its settings will be displayed in this area.', 'mh-composer' )
				),
			);
			return $fields;
		}
	}
	new MHComposer_Component_Classified;
	
	class MHComposer_Component_Review extends MHComposer_Component {
		function init() {
			$this->name = esc_html__( 'Review', 'mh-composer' );
			$this->slug = 'mhc_review';
			
			$this->approved_fields = array(
				'info',
			);
		}
		function get_fields() {
			$fields = array(
				'info' => array(
				'type'              => 'info',
				'info-heading' => esc_html__( 'This component requires the following plugin: ', 'mh-composer' ),
				'info-heading-bold' => esc_html__( 'Mharty - Reviews', 'mh-composer' ),
				'description'     => esc_html__( 'After the plugin has been installed and activated, its settings will be displayed in this area.', 'mh-composer' )
				),
			);
			return $fields;
		}
	}
	new MHComposer_Component_Review;
}