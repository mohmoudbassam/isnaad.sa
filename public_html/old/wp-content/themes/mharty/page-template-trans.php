<?php
/*
Template Name: Transparent Header
*/
esc_html__('Transparent Header', 'mharty');
get_header();
$is_page_composer_used = mh_composer_is_active( get_the_ID() ); ?>
<div id="main-content">
<?php if ( !$is_page_composer_used ) : ?>
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
            <?php if ('on' === mh_get_option('mharty_enable_breadcrmbs', false)) echo do_shortcode( '[mh_breadcrumbs]' ); ?>
<?php endif; ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( !$is_page_composer_used ) : ?>
						<h1 class="main_title"><?php the_title(); ?></h1>
						<?php
						$thumb = '';
						$width = (int) apply_filters( 'mhc_index_blog_image_width', 1080 );
						$height = (int) apply_filters( 'mhc_index_blog_image_height', 675 );
						$classtext = 'mh_featured_image';
						$titletext = get_the_title();
						$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
						$thumb = $thumbnail["thumb"];
	
						if ( 'on' === mh_get_option( 'mharty_page_thumbnails', 'false' ) && '' !== $thumb )
							print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
                        ?>
				<?php endif; ?>
					<div class="entry-content clearfix">
					<?php
						the_content();
						if ( !$is_page_composer_used )
						wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mharty' ), 'after' => '</div>' ) );
					?>
					</div> <!-- .entry-content -->

				<?php
					if ( !$is_page_composer_used && comments_open() && 'on' === mh_get_option( 'mharty_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article> <!-- .mhc_post -->

			<?php endwhile; ?>
			<?php if ( !$is_page_composer_used ) : ?>
			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
    <?php endif; ?>
</div> <!-- #main-content -->

<?php if (!is_customize_preview()) { edit_post_link('');} ?>
<?php get_footer(); ?>