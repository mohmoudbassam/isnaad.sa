<?php if ( ! isset( $_SESSION ) ) session_start(); ?>
<!DOCTYPE html>
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
	<?php mharty_description(); ?>
	<?php mharty_keywords(); ?>
	<?php mharty_canonical(); ?>

	<?php do_action( 'mh_head_meta' ); ?>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() . '/js/html5.js"' ); ?>" type="text/javascript"></script>
	<![endif]-->

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="page-container" class="<?php if ( ! is_page_template( 'page-template-trans.php' ) ) echo'not-trans';?>">
    	<?php do_action('mh_before_start_container'); ?>
		<?php mh_header_menu();?>
		<div id="mh-main-area">
			<?php do_action('mh_before_content'); ?>