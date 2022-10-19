<?php
get_header();
$is_page_composer_used = mh_composer_is_active( get_the_ID() );
if ( $is_page_composer_used ) : ?>
<div id="main-content">
	<?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content">
           		 <?php the_content(); ?>
                 <?php if (mh_get_option('mharty_show_project_nav') == 'on') mh_post_navigation();?>
            </div> <!-- .entry-content -->
        </article> <!-- .mhc_post -->
    <?php endwhile; ?>
</div> <!-- #main-content -->
<?php else: ?>
<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
       		<?php if ('on' === mh_get_option('mharty_enable_breadcrmbs', false)) echo do_shortcode( '[mh_breadcrumbs]' ); ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="mh_main_title mh_project_title">
						<h1><?php the_title(); ?></h1>
						<span class="mh_project_categories"><?php 
						$sep = mh_wp_kses( _x( ', ', 'This is a comma followed by a space.', 'mharty') );
						echo get_the_term_list( get_the_ID(), 'project_category', '', $sep ); ?>
                        </span>
					</div>
				<?php
					do_action('mh_before_project_content');
					$thumb = '';

					$width = (int) apply_filters( 'mhc_portfolio_single_image_width', 1080 );
					$height = (int) apply_filters( 'mhc_portfolio_single_image_height', 9999 );
					$classtext = 'mh_featured_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Projectimage' );
					$thumb = $thumbnail["thumb"];

					$page_layout = get_post_meta( get_the_ID(), '_mhc_page_layout', true );

					if ( 'on' === mh_get_option( 'mharty_thumbnails_project', 'on' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
				?>

					<div class="entry-content clearfix">
					<?php
						the_content();
						wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mharty' ), 'after' => '</div>' ) );?>
                    <?php do_action('mh_after_project_content'); ?>
                    <?php if (mh_get_option('mharty_show_project_nav') == 'on') mh_post_navigation();?>
					</div> <!-- .entry-content -->

					<?php if ( 'mh_full_width_page' !== $page_layout ) mhc_portfolio_meta_box(); ?>
					<?php if ( 'on' == mh_get_option( 'mharty_show_related_projects', 'off' )) mh_related_posts(); ?>
				</article> <!-- .mhc_post -->

			<?php 
				if ( comments_open() && 'on' == mh_get_option( 'mharty_show_projectcomments', 'on' ) )
					comments_template( '', true );
			?>
			<?php endwhile; ?>

			</div> <!-- #left-area -->
			<?php if ( 'mh_full_width_page' === $page_layout ) mhc_portfolio_meta_box(); ?>

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->
<?php endif; ?>
<?php if (!is_customize_preview()) { edit_post_link('');} ?>
<?php get_footer(); ?>