<?php
if ( is_page_template( 'page-template-blank.php' ) || (is_single() && 'mh_post_blank' === get_post_meta( get_the_ID(), '_mhc_post_custom_template', true ) ) ): ?>
	<footer id="main-footer" style="display:none;">
		<?php if ( '' !== ( $mharty_cr_notice = get_theme_mod( 'cr_notice', '' ) ) ) { echo  '<div class="mh-copyrights">' . mh_sanitize_text_input( $mharty_cr_notice ) . '</div>';} ?>
		<div class="mh_cr"><?php mh_wp_kses( printf( __( 'Powered by %1$s | %2$s', 'mharty' ), '<a href="http://mharty.com" title="'. esc_html__( 'Premium RTL Wordpress Theme', 'mharty' ) .'">'. esc_html__( 'Mharty', 'mharty' ) .'</a>', '<a href="http://wordpress.org">'. esc_html__( 'WordPress', 'mharty' ) .'</a>' ) );?></div>
	</footer>
	
<?php else: ?>
	<footer id="main-footer">
		<?php get_sidebar( 'footer' ); ?>
		
		<?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
			<div id="mh-footer-nav">
				<div class="container">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'footer-menu',
							'depth'          => '1',
							'menu_class'     => 'bottom-nav',
							'container'      => '',
							'fallback_cb'    => '',
							'walker' => new mharty_walker,
						) );
					?>
				</div>
			</div> <!-- #mh-footer-nav -->
		<?php endif; ?>
		
		<div id="footer-bottom">
			<div class="container clearfix">
				<?php if ( '1' === get_theme_mod( 'show_footer_social_icons', '0' ) ) {
					$colorclass = '';
					if ( 'light' === get_theme_mod( 'footer_social_icons_color', 'dark' ) )
					$colorclass = ' mh-social-light-color';
					if ( 'color' === get_theme_mod( 'footer_social_icons_color', 'dark' ) )
					$colorclass = ' mh-social-default-color';
					echo '<div class="social-icons-wrapper'.$colorclass.'">';
						get_template_part( 'includes/social_icons', 'footer' );
					echo '</div>';
					}?>

				<div id="footer-info">
				<?php if ( '' !== ( $mharty_cr_notice = get_theme_mod( 'cr_notice', '' ) ) ) {
					echo  '<div class="mh-copyrights">' . mh_sanitize_text_input( $mharty_cr_notice ) . '</div>';	} ?>
					<div class="mh_cr"<?php if ( 'on' !== mh_get_option( 'mharty_show_cr', 'on')) echo ' style="display:none;"'; ?>><?php mh_wp_kses( printf( __( 'Powered by %1$s | %2$s', 'mharty' ), '<a href="http://mharty.com" title="'. esc_html__( 'Premium RTL Wordpress Theme', 'mharty' ) .'">'. esc_html__( 'Mharty', 'mharty' ) .'</a>', '<a href="http://wordpress.org">'. esc_html__( 'WordPress', 'mharty' ) .'</a>' ) );?>
					</div>
				</div>
			</div>	<!-- .container -->
		</div> <!--footer-bottom-->
	</footer> <!-- #main-footer -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>
</div> <!-- #mh-main-area -->
<?php  do_action('mh_before_end_container');
   if ( '1' === get_theme_mod( 'back_to_top', '0' ) ) : ?>
   		<span class="mhc_scroll_top mh_adjust_corners"></span>
	<?php endif; ?> 
        
</div> <!-- #page-container -->
<?php do_action('mh_after_end_container'); ?>
<?php wp_footer(); ?>
</body>
</html>