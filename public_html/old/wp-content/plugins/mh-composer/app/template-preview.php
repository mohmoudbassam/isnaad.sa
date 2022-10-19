<?php
// Prevent file from being loaded directly
if ( ! defined( 'ABSPATH' ) ) {
	die('-1');
}

// Early nonce check
if ( ! isset( $_GET['mhc_preview_nonce'] ) || ! wp_verify_nonce( $_GET['mhc_preview_nonce'], 'mhc_preview_nonce' ) ) {
	wp_die( esc_html__( 'Authentication failed. You cannot preview this item.', 'mh-composer' ) );
}

// Logged in check
if ( ! is_user_logged_in() ) {
	wp_die( esc_html__( 'Authentication failed. You are not logged in.', 'mh-composer' ) );
}

// Early permission check
if ( ! current_user_can( 'edit_posts' ) ) {
	wp_die( esc_html__( 'Authentication failed. You have no permission to preview this item.', 'mh-composer' ) );
}

?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />

		<?php do_action( 'mh_head_meta' ); ?>

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<?php $template_directory_uri = get_template_directory_uri(); ?>
		<!--[if lt IE 9]>
		<script src="<?php echo esc_url( $template_directory_uri . '/js/html5.js"' ); ?>" type="text/javascript"></script>
		<![endif]-->

		<script type="text/javascript">
			document.documentElement.className = 'js';
		</script>

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="page-container">
			<div id="main-content">
				<div class="container">
					<div id="<?php echo esc_attr( apply_filters( 'mhc_preview_wrap_id', 'content' ) ); ?>">
					<div class="<?php echo esc_attr( apply_filters( 'mhc_preview_wrap_class', 'entry-content' ) ); ?>">

					<?php
						if ( isset( $_POST['shortcode' ] ) ) {
							if( ! isset( $_POST['mhc_preview_nonce'] ) || ! wp_verify_nonce( $_POST['mhc_preview_nonce'], 'mhc_preview_nonce' ) ) {
								// Auth nonce
								printf( '<p class="mhc-preview-message">%1$s</p>', esc_html__( 'Authentication failed. You cannot preview this item.', 'mh-composer' ) );
							} elseif( ! current_user_can( 'edit_posts' ) ) {
								// Auth user
								printf( '<p class="mhc-preview-message">%1$s</p>', esc_html__( 'Authentication failed. You have no permission to preview this item.', 'mh-composer' ) );
							} else {
								$content = apply_filters( 'the_content', wp_unslash( $_POST['shortcode'] ) );
								$content = str_replace( ']]>', ']]&gt;', $content );
								echo $content;
							}
						} else {
							printf( '<p class="mhc-preview-loading"><span>%1$s</span></p>', esc_html__( 'Loading preview...', 'mh-composer' ) );
						}
					?>

					</div> <!-- .entry-content.post-content.entry -->
					</div> <!-- #content -->
					<div class="mhc_modal_overlay link-disabled">
						<div class="mhc_prompt_modal">
							<h3><?php esc_html_e( 'Link Disabled', 'mh-composer' ); ?></h3>
							<p><?php esc_html_e( 'During preview, link to different page is disabled', 'mh-composer' ); ?></p>

							<div class="mhc_prompt_buttons">
								<a href="#" class="mhc_prompt_proceed"><?php esc_html_e( 'Close', 'mh-composer' ); ?></a>
							</div>
						</div><!-- .mhc_prompt_modal -->
					</div><!-- .mhc_modal_overlay -->
				</div><!-- .container -->
			</div><!-- #main-content -->
		</div> <!-- #page-container -->
		<?php wp_footer(); ?>
	</body>
</html>