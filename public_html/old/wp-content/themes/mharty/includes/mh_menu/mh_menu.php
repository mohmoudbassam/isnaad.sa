<?php
if ( ! function_exists( 'mh_mharty_get_top_nav_items' ) ) {
	function mh_mharty_get_top_nav_items() {
		$items = new stdClass;
		$items->show_header_date = ( '1' === get_theme_mod( 'show_header_date', '0' ));
		$items->header_phrase = ( '' !== get_theme_mod( 'header_phrase', '' ));
		$items->phone_number = ( '' !== get_theme_mod( 'phone_number', '' ));
		$items->email = ( '' !== get_theme_mod( 'header_email', ''));
		$items->contact_info_defined = $items->phone_number || $items->email || $items->header_phrase || $items->show_header_date;
		$items->show_header_social_icons = ( '1' === get_theme_mod( 'show_header_social_icons', '0' ));
		$items->secondary_nav = wp_nav_menu(array(
				'theme_location' => 'secondary-menu',
				'container'      => '',
				'fallback_cb'    => '',
				'menu_id'        => 'mh-secondary-nav',
				'echo'           => false,
				'walker' => new mharty_walker,
		));
		
		
		$items->top_info_defined = $items->contact_info_defined || $items->show_header_social_icons || $items->secondary_nav;
		$items->two_info_panels = $items->contact_info_defined && ( $items->show_header_social_icons || $items->secondary_nav );
		$items->promo = ( '1' === get_theme_mod( 'show_promo_bar', '0' ) && '' !== get_theme_mod( 'promo_bar_text', '' ));
		return $items;
	}
}

add_action('mh_main_navigation','mh_add_main_navigation');
if (!function_exists('mh_add_main_navigation')) {
	function mh_add_main_navigation() {
$menuClass = 'nav';
if ( 'on' == mh_get_option( 'mharty_disable_toptier' ) ) $menuClass .= ' mh_disable_top_tier';
$primaryNav = '';
$primaryNav = wp_nav_menu(array(
				'theme_location' => 'primary-menu',
				'container' => 'nav',
				'container_id' => 'top-menu-nav',
				'container_class' => 'main_menu',
				'menu_class' =>$menuClass,
				'menu_id' => 'top-menu',
				'echo' => false,
				'fallback_cb' => 'link_to_menu_editor',
				'walker' => new mharty_walker,
			));
	if ( true !== get_theme_mod( 'hide_nav_menu', false )){
		if ( '' == $primaryNav ) :
			?>
            <nav id="top-menu-nav">
				<ul id="top-menu" class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if ( 'on' == mh_get_option( 'mharty_home_link' ) ) { ?>
						<li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'mharty' ); ?></a></li>
					<?php }; ?>
		
					<?php show_page_menu( $menuClass, false, false ); ?>
					<?php show_categories_menu( $menuClass, false ); ?>
				</ul>
                </nav>
			<?php
		else :
			echo( $primaryNav );
		endif;		
		} // hide_nav_menu
	}
}

function mh_add_mobile_navigation(){
	if  (true !== get_theme_mod( 'hide_nav_menu', false ) && true !== get_theme_mod( 'app_menu', false )){
	printf(
		'<div id="mh_mobile_nav_menu">
			<a href="#" class="mobile_nav closed">
				<span class="select_page">%1$s</span>
				<span class="mobile_menu_bar mh-icon-before"></span>
			</a>
		</div>',
		esc_html__( 'Select Page', 'mharty' )
	);
	}
}
add_action( 'mh_header_top', 'mh_add_mobile_navigation' );

if ( ! function_exists( 'mh_header_menu' ) ) {
	function mh_header_menu() {
	
	//hide header on blank & no-header templates
		if ( is_page_template( 'page-template-blank.php' )  || is_page_template( 'page-template-noheader.php' ) || ( is_single() && ('mh_post_noheader' === get_post_meta( get_the_ID(), '_mhc_post_custom_template', true )) ) || ( is_single() && ('mh_post_blank' === get_post_meta( get_the_ID(), '_mhc_post_custom_template', true ) ) ) ){
		return;
	}
	echo '<div class="header-container">';
	$mh_secondary_nav_items = mh_mharty_get_top_nav_items();
	$show_header_date = $mh_secondary_nav_items->show_header_date;
	$mh_custom_phrase = $mh_secondary_nav_items->header_phrase;
	$mh_phone_number = $mh_secondary_nav_items->phone_number;
	$mh_email = $mh_secondary_nav_items->email;
	$mh_contact_info_defined = $mh_secondary_nav_items->contact_info_defined;
	$show_header_social_icons = $mh_secondary_nav_items->show_header_social_icons;
	$mh_secondary_nav = $mh_secondary_nav_items->secondary_nav;
	if ( '' !== ( $primary_nav_text_color = get_theme_mod( 'primary_nav_text_color', 'dark' ) ) ) :
	$primary_nav_class = 'mh_nav_text_color_' . $primary_nav_text_color;
	endif;
	if ( '' !== ( $primary_subnav_text_color = get_theme_mod( 'primary_subnav_text_color', 'dark' ) ) ) :
	$primary_subnav_class = ' mh_subnav_text_color_' . $primary_subnav_text_color;
	endif;
	if ( '' !== ( $secondary_nav_text_color = get_theme_mod( 'secondary_nav_text_color', 'light' ) ) ) :
	$secondary_nav_class = 'mh_nav_text_color_' . $secondary_nav_text_color;
	endif;
	$mh_top_info_defined = $mh_secondary_nav_items->top_info_defined;
	$promo = $mh_secondary_nav_items->promo;
	$promo_class = (!$mh_top_info_defined &&  ( true === $promo ) ) ? ' mh-has-promo-only' : '';
	$promo_class .= ( $mh_top_info_defined &&  ( true === $promo ) ) ? ' mh-has-promo' : '';
	$promo_output = sprintf('<div class="mh-promo mhc_animation_%4$s mh-animated"%3$s><div class="container clearfix"><div class="mh-promo-inner"><p>%1$s</p>%2$s</div></div><div class="mh-promo-close mh-icon-before"></div></div>',
					esc_attr( get_theme_mod( 'promo_bar_text', '' ) ), //1
					'' !== get_theme_mod( 'promo_bar_button_text', '' ) ? sprintf(' <a class ="mh-promo-button mh_adjust_corners" href="%2$s">%1$s</a>',
						esc_attr( get_theme_mod( 'promo_bar_button_text', '' ) ),
						'' !== get_theme_mod( 'promo_bar_button_url', '' ) ? esc_attr( get_theme_mod( 'promo_bar_button_url', '' )) :'#'
					) : '', //2
					false !== get_theme_mod( 'show_promo_bar_once', false ) ? 'data-once="true"' : '', //3
					esc_attr( get_theme_mod( 'promo_bar_animation', 'top' ) )
					);
		
	if (!$mh_top_info_defined && true === $promo): ?>
		<div id="top-header" class="<?php echo esc_attr( $secondary_nav_class . $promo_class );?>">
			<?php echo $promo_output; ?>
		</div> <!-- #top-header -->
	<?php elseif ( ('1' == get_theme_mod('secondary_nav_position', '0') && $mh_top_info_defined) || $mh_top_info_defined && is_page_template( 'page-template-trans.php' ) ) : ?>

		<div id="top-header" class="<?php echo esc_attr( $secondary_nav_class . $promo_class );?>">
			<?php if ( true === $promo ) { echo $promo_output; }  ?>
			<div class="container clearfix">
			<?php if ( $mh_contact_info_defined ) : ?>

				<div id="mh-info">
                <?php if ( true === $show_header_date ) : 
				$date = '' !== mh_get_option( 'mharty_header_date_format') ? mh_get_option( 'mharty_header_date_format', 'd/m/Y' ): 'd/m/Y';?>
					<span id="mh-info-date" class="mh-icon-before mh-icon-after"><?php echo date_i18n( $date, time() ); ?></span>
				<?php endif; ?>
                
				<?php if ( '' !== ( $mh_custom_phrase = get_theme_mod( 'header_phrase', '' ) ) ) : ?>
					<span id="mh-info-custom-text" class="mh-icon-before mh-icon-after"><?php echo mh_sanitize_text_input( $mh_custom_phrase ); ?></span></a>
				<?php endif; ?>
                
                <?php if ( '' !== ( $mh_phone_number = get_theme_mod( 'phone_number', '' ) ) ) : ?>
                    <span id="mh-info-phone" class="mh-icon-before mh-icon-after"><?php echo mh_sanitize_text_input( $mh_phone_number ); ?></span>
				<?php endif; ?>
                
        		<?php if ( '' !== ( $mh_email = get_theme_mod( 'header_email', '' ) ) ) : ?>
					<a id="mh-info-email-url" href="<?php echo esc_attr( 'mailto:' . $mh_email ); ?>"><span id="mh-info-email" class="mh-icon-before mh-icon-after"><?php echo esc_html( $mh_email ); ?></span></a>
				<?php endif; ?>
        
				<?php
				if ( true === $show_header_social_icons ) {
					get_template_part( 'includes/social_icons', 'header' );
				} ?>
				</div> <!-- #mh-info -->

			<?php endif; // true === $mh_contact_info_defined ?>
          
				<div id="mh-secondary-menu">
				<?php
					if ( ! $mh_contact_info_defined && true === $show_header_social_icons ) {
						echo '<div id="mh-info">';
						get_template_part( 'includes/social_icons', 'header' );
						echo '	</div> <!-- #mh-info -->';
					} else if ( $mh_contact_info_defined && true === $show_header_social_icons ) {
						ob_start();

						get_template_part( 'includes/social_icons', 'header' );

						$duplicate_social_icons = ob_get_contents();

						ob_end_clean();

						printf(
							'<div class="mh_duplicate_social_icons">
								%1$s
							</div>',
							$duplicate_social_icons
						);
					} 

					if ( '' !== $mh_secondary_nav ) {
						echo $mh_secondary_nav;
					}
					if ( $mh_top_info_defined ) {
						do_action ('mh_header_mini_cart');
					}
				?>
				</div> <!-- #mh-secondary-menu -->

			</div> <!-- .container -->
			
		</div> <!-- #top-header -->
	<?php endif; // true ==== $mh_top_info_defined ?>
    
		<header id="main-header" class="<?php echo esc_attr( $primary_nav_class ); ?><?php echo esc_attr( $primary_subnav_class ); ?><?php if ( is_page_template( 'page-template-trans.php' ) ) echo' transparent'; ?>">
			<div class="container clearfix">
			<?php
				$template_uri = get_template_directory_uri();
				$logo = ( $user_logo = get_theme_mod( 'mharty_logo' ) ) && '' != $user_logo
					? esc_url( $user_logo )
					: $template_uri . '/images/logo.png';
					//sticky logo
					$sticky_logo = ( $sticky_user_logo = get_theme_mod( 'mharty_logo_sticky' ) ) && '' != $sticky_user_logo
					? esc_url( $sticky_user_logo )
					: $template_uri . '/images/logo_icon.png';
			?>
				<a href="<?php echo esc_url( apply_filters( 'mh_logo_url_filter', home_url( '/' ) ) ); ?>" class="mh_logo<?php if ( '1' === get_theme_mod( 'mharty_logo_sticky_active', '0' )) : echo ' has_sticky_logo'; endif;?>">
					
					<?php if ( true !== get_theme_mod( 'use_logo_text', false )): ?>
                    	<img src="<?php echo esc_url( apply_filters( 'mh_logo_filter', $logo ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" />
                    	<?php if ( '1' === get_theme_mod( 'mharty_logo_sticky_active', '0' ) ) : ?>
                    	<img src="<?php echo esc_url( apply_filters( 'mh_logo_sticky_filter', $sticky_logo ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="sticky_logo" />
                    	<?php endif; ?>
     				<?php else: ?>
                    	<h1 class="header-name"><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></h1>
     					<p class="header-tagline"><?php echo esc_attr( get_bloginfo( 'description' ) ); ?></p>
    				 <?php endif; ?>
				</a>
				<div class="mh-top-navigation-wrapper">     
				<div id="mh-top-navigation">                
                    <?php do_action('mh_main_navigation');?>
					<?php if ('full' === get_theme_mod( 'show_search_icon', 'full') || '1' === get_theme_mod( 'show_search_icon', '1') ) : ?>
                <div id="mh_top_search" class="mh-full-search-trigger">
						<i class="mh_search_icon mh-icon-before"></i>
                  </div>
                        <?php elseif ('default' === get_theme_mod( 'show_search_icon', 'full') || '2' === get_theme_mod( 'show_search_icon', 'full') ) : ?>
					<div id="mh_top_search">
						<i class="mh_search_icon mh-icon-before"></i>
						<form role="search" method="get" class="mh-search-form mh-hidden" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search" class="mh-search-field" placeholder="<?php esc_attr_e( 'Search &hellip;', 'mharty' ); ?>" value="<?php get_search_query() ?>" name="s" title="<?php esc_attr_e( 'Search for:', 'mharty' ); ?>" />
						</form>
					</div>
					<?php endif; //fullwidth_search & show_search_icon ?>
                    <?php if ( !$mh_top_info_defined ) {
						do_action ('mh_header_mini_cart');
					}
					?>
                    <?php if ( true === get_theme_mod( 'app_menu', false)  ) { ?>
                        	<div class="app-nav-trigger">
                 				<div class="app-nav-trigger-a"><i class="app-nav-trigger-icon mh-icon-before"></i></div>
                 			</div><!--app-nav-trigger-->
                    <?php } ?>
					<?php do_action( 'mh_header_top' ); ?>
				</div> <!-- #mh-top-navigation -->
			</div><!-- .mh-top-navigation-wrapper -->
		</div> <!-- .container -->
	</header> <!-- #main-header -->
        
<?php if ( ('0' == get_theme_mod('secondary_nav_position', '0') && $mh_top_info_defined && ! is_page_template( 'page-template-trans.php' ) ) ) : ?>
		<div id="top-header" class="<?php echo esc_attr( $secondary_nav_class . $promo_class );?>">
			<?php if ( true === $promo ) { echo $promo_output; }  ?>
			<div class="container clearfix">
			
			<?php if ( $mh_contact_info_defined ) : ?>

				<div id="mh-info">
                <?php 
				if ( true === $show_header_date ) : ?>
					<span id="mh-info-date" class="mh-icon-before mh-icon-after"><?php echo date_i18n( mh_get_option( 'mharty_header_date_format', 'd/m/Y' ), time() ); ?></span>
				<?php endif; ?>
                
				<?php if ( '' !== ( $mh_custom_phrase = get_theme_mod( 'header_phrase', '' ) ) ) : ?>
					<span id="mh-info-custom-text" class="mh-icon-before mh-icon-after"><?php echo mh_sanitize_text_input( $mh_custom_phrase ); ?></span></a>
				<?php endif; ?>
                
                <?php if ( '' !== ( $mh_phone_number = get_theme_mod( 'phone_number', '' ) ) ) : ?>
                    <span id="mh-info-phone" class="mh-icon-before mh-icon-after"><?php echo mh_sanitize_text_input( $mh_phone_number ); ?></span>
				<?php endif; ?>
                
       			<?php if ( '' !== ( $mh_email = get_theme_mod( 'header_email', '' ) ) ) : ?>
					<a id="mh-info-email-url" href="<?php echo esc_attr( 'mailto:' . $mh_email ); ?>"><span id="mh-info-email" class="mh-icon-before mh-icon-after"><?php echo esc_html( $mh_email ); ?></span></a>
				<?php endif; ?>

				<?php
				if ( true === $show_header_social_icons ) {
					get_template_part( 'includes/social_icons', 'header' );
				} ?>
				</div> <!-- #mh-info -->
			<?php endif; // true === $mh_contact_info_defined ?>
          
				<div id="mh-secondary-menu">
				<?php
					if ( ! $mh_contact_info_defined && true === $show_header_social_icons ) {
						echo '<div id="mh-info">';
						get_template_part( 'includes/social_icons', 'header' );
						echo '	</div> <!-- #mh-info -->';
					} else if ( $mh_contact_info_defined && true === $show_header_social_icons ) {
						ob_start();

						get_template_part( 'includes/social_icons', 'header' );

						$duplicate_social_icons = ob_get_contents();

						ob_end_clean();

						printf(
							'<div class="mh_duplicate_social_icons">
								%1$s
							</div>',
							$duplicate_social_icons
						);
					} 

					if ( '' !== $mh_secondary_nav ) {
						echo $mh_secondary_nav;
					}
					if ( $mh_top_info_defined ) {
						do_action ('mh_header_mini_cart');
					}
				?>
				</div> <!-- #mh-secondary-menu -->
				
			</div> <!-- .container -->
		</div> <!-- #top-header -->
	<?php endif; // true ==== $mh_top_info_defined
		echo '</div> <!--header-container-->';
	}
}

if ( ! function_exists( 'mh_fullwidth_search' ) ) :
function mh_fullwidth_search(){ 
if ('full' === get_theme_mod( 'show_search_icon', 'full') || '1' === get_theme_mod( 'show_search_icon', 'full') ) { ?>
   <div class="mh-full-search-overlay">
        <div class="mh-full-search-overlay-inner">
          <div class="container">
            <form method="get" id="searchform" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
              <h4><?php $full_search_text = get_theme_mod( 'full_search_text' );
			  	if ( '' === $full_search_text){
					esc_html_e( 'Type and Press &ldquo;Enter&rdquo;', 'mharty' );
				}else{
					echo esc_attr($full_search_text);
				} ?>
              </h4>
              <input type="text" id="s" class="search-input" name="s">
              <?php do_action('mh_header_search_custom_input'); ?>
            </form>
          </div>
        </div>
      </div> <!-- mh-full-search-overlay-->
<?php } } endif;
add_action( 'mh_before_end_container', 'mh_fullwidth_search'); 

if ( ! function_exists( 'mh_add_app_nav' ) ) :
function mh_add_app_nav(){
	if ( true === get_theme_mod( 'app_menu', false)  ) {
	$app_menu_class = '';
	if ( '' !== ( $app_menu_text_color = get_theme_mod( 'app_menu_text_color', 'dark' ) ) ) :
		$app_menu_class .= ' mh_nav_text_color_' . $app_menu_text_color;
	
	endif;?>

		<div class="mh-app-nav app-nav<?php echo esc_attr( $app_menu_class ); ?>">
        <span class="app-nav-close"><i class="mh-icon-before"></i></span>
			<div class="mh-app-nav-container">
				<?php $app_logo =  get_theme_mod( 'app_logo' ); 
                if ( '' != $app_logo){ ?>
                <a href="<?php echo esc_url( apply_filters( 'mh_logo_url_filter', home_url( '/' ) ) ); ?>" class="mh-app-logo">
                <img src="<?php echo esc_url( $app_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="app-logo" /></a>
                <?php }
				$tagline = '' != get_theme_mod( 'app_tagline_alt' ) ? esc_attr( get_theme_mod( 'app_tagline_alt' ) ) : esc_attr( get_bloginfo( 'description' ) );
                if ('show' === ( get_theme_mod( 'app_tagline', 'show' ) ) ) echo '<p class="app-tagline">' . $tagline . '</p>'; ?>
                <?php if ( has_nav_menu( 'app-menu' ) ) : ?>
                <div class="app-menu">
                	<div class="divider-top"></div>
                    <?php wp_nav_menu( array(
                            'theme_location' => 'app-menu',
                            'depth'          => '1',
                            'menu_class'     => 'app-menu',
                            'container'      => '',
                            'fallback_cb'    => '',
                            'walker' => new mharty_walker,
                        ) ); ?>
                    <div class="divider-bottom"></div>
                </div>
                <?php endif; ?>
<?php if ('' !== ( $mh_phone_number = get_theme_mod( 'app_phone_number', '' ) ) ||  '' !== ( $mh_email = get_theme_mod( 'app_email', '' ) ) ){ ?>
               <div class="app-nav-info<?php  if ( has_nav_menu( 'app-menu' ) ) echo ' app-nav-has-menu';?>">
               
				<?php if ( '' !== ( $mh_phone_number = get_theme_mod( 'app_phone_number', '' ) ) ) : ?>
					<span id="mh-info-phone" class="mh-icon-before mh-icon-after"><?php echo mh_sanitize_text_input( $mh_phone_number ); ?></span>
				<?php endif; ?>
                
                <?php if ( '' !== ( $mh_email = get_theme_mod( 'app_email', '' ) ) ) : ?>
					<a href="<?php echo esc_attr( 'mailto:' . $mh_email ); ?>"><span id="mh-info-email" class="mh-icon-before mh-icon-after"><?php echo esc_html( $mh_email ); ?></span></a>
				<?php endif; ?>
                
                </div>
                <?php } ?>
                <?php if ( '1' === get_theme_mod( 'show_app_social_icons', '0' ) ) {
                    get_template_part( 'includes/social_icons', 'footer' );
                } ?>
			</div>
		</div>
	<?php } }
endif;
add_action( 'mh_before_start_container', 'mh_add_app_nav' );