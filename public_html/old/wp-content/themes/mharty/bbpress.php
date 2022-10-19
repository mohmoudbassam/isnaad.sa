<?php get_header();?>
<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
            <?php 
			if ('on' === mh_get_option('mharty_enable_breadcrmbs', false))
					echo mh_breadcrumb(array(
                    'show_browse' => false,
                    'separator' => mh_wp_kses( _x(' / ', 'This is the breadcrumb separator.', 'mharty') ),
                    'show_home'  => esc_html__( 'Home', 'mharty' ),
                    'echo'       => false
                )); ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<h1 class="main_title"><?php the_title(); ?></h1>

					<div class="entry-content">
					<?php
						the_content();?>
					</div> <!-- .entry-content -->


				</article> <!-- .mhc_post -->

			<?php endwhile; ?>

			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>

		</div> <!-- #content-area -->
	</div> <!-- .container -->

</div> <!-- #main-content -->
<?php get_footer(); ?>