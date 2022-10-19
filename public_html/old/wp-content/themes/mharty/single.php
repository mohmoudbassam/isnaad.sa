<?php
get_header();
$is_page_composer_used = mh_composer_is_active( get_the_ID() );
if ( $is_page_composer_used ) : ?>
<div id="main-content">
	<?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content">
           		 <?php the_content(); ?>
                 <?php if (mh_get_option('mharty_show_post_nav') == 'on') mh_post_navigation(true);?>
            </div> <!-- .entry-content -->
        </article> <!-- .mhc_post -->
    <?php endwhile; ?>
</div> <!-- #main-content -->
<?php else: ?>
<div id="main-content">
<?php
// video cover outside the loop
global $post;
$post_format = get_post_format( $post->ID);
$post_content = $post->post_content;
if ( 'video' === $post_format && false !== ( $first_video = mh_get_first_video($post_content) )) {
	if ('on' === mh_get_option( 'mharty_video_cover', 'off' )){
		printf(
			'<div class="mh-video-cover">
				<div class="mh-video-container">
					<div class="mh_main_video_container">
						%1$s
					</div>
				</div>
			</div>',
			$first_video
		);
	}
}
?>
	<div class="container">
		<div id="content-area" class="clearfix">      
			<div id="left-area">
            <?php if ('on' === mh_get_option('mharty_enable_breadcrmbs', false)) echo do_shortcode( '[mh_breadcrumbs]' ); ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if (mh_get_option('mharty_integration_single_top') <> '' && mh_get_option('mharty_integrate_singletop_enable') == 'on') echo (mh_get_option('mharty_integration_single_top'));
				 
				$meta_info_position_class = ' post-meta-' .mh_get_option('mharty_postinfo2_position');
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'mhc_post' . $meta_info_position_class ); ?>>
                <?php  if ('above' === mh_get_option('mharty_postinfo2_position', 'above'))
						mh_mharty_post_meta();?>
					<h1><?php the_title(); ?><?php mh_after_post_title(); ?></h1>
					
				<?php
					if ( ! post_password_required() ) :

					 if ('below' === mh_get_option('mharty_postinfo2_position', 'above'))
						mh_mharty_post_meta();

						$thumb = '';

						$width = (int) apply_filters( 'mhc_index_blog_image_width', 1080 );

						$height = (int) apply_filters( 'mhc_index_blog_image_height', 675 );
						$classtext = 'mh_featured_image';
						$titletext = get_the_title();
						$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
						$thumb = $thumbnail["thumb"];

						$post_format = mh_post_format();
						$post_content = get_the_content();
						if ( 'video' === $post_format && false !== ( $first_video = mh_get_first_video($post_content) ) ) {
							if ('on' !== mh_get_option( 'mharty_video_cover', 'off' )){
								printf(
									'<div class="mh_main_video_container">
										%1$s
									</div>',
									$first_video
								);
							}
						} else if ( ! in_array( $post_format, array( 'gallery', 'link', 'quote', 'video' ) ) && 'on' === mh_get_option( 'mharty_thumbnails', 'on' ) && '' !== $thumb ) {
							print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
						} else if ( 'gallery' === $post_format ) {
							mh_gallery_images();
						}
					?>

					<?php
						$text_color_class = mh_mharty_get_post_text_color();

						$inline_style = mh_mharty_get_post_bg_inline_style();

						switch ( $post_format ) {
							case 'audio' :
								printf(
									'<div class="mh_audio_content%1$s"%2$s>
										%3$s
									</div>',
									esc_attr( $text_color_class ),
									$inline_style,
									mhc_get_audio_player()
								);

								break;
							case 'quote' :
								printf(
									'<div class="mh_quote_content%2$s"%3$s>
										%1$s
										%4$s
									</div> <!-- .mh_quote_content -->',
									mh_get_blockquote_in_content(),
									esc_attr( $text_color_class ),
									$inline_style,
									mh_mharty_get_post_quote_author()
								);

								break;
							case 'link' :
								printf(
									'<div class="mh_link_content%3$s"%4$s>
										<a href="%1$s" class="mh_link_main_url">%2$s</a>
									</div> <!-- .mh_link_content -->',
									esc_url( mh_get_link_url() ),
									esc_html( mh_get_link_url() ),
									esc_attr( $text_color_class ),
									$inline_style
								);

								break;
						}

					endif;
					
					 if ('middle' === mh_get_option('mharty_postinfo2_position', 'above'))
						mh_mharty_post_meta();
				?>

					<div class="entry-content clearfix">
					<?php
						do_action('mh_before_post_content');
						the_content();

						wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mharty' ), 'after' => '</div>' ) );?>
                    <?php do_action('mh_after_post_content'); ?>
					<?php  if (mh_get_option('mharty_show_post_nav') == 'on') mh_post_navigation(true);?>
					</div> <!-- .entry-content -->
					<div class="mh_post_meta_wrapper">
					<?php
					if ( mh_get_option('mharty_468_enable') == 'on' ){
						echo '<div class="mh-single-post-ad">';
						if ( mh_get_option('mharty_468_foursixeight') <> '' ) echo( mh_get_option('mharty_468_foursixeight') ); else { ?>
							<a href="<?php echo esc_url(mh_get_option('mharty_468_url')); ?>"><img src="<?php echo esc_attr(mh_get_option('mharty_468_image')); ?>" alt="468" class="foursixeight" /></a>
				<?php 	} echo '</div> <!-- .mh-single-post-ad -->';} ?>
                
<?php the_tags( '<div class="mh-tags"><span class="tag-links">', '', '</span></div>' ); ?>
<?php do_action('mh_after_post'); ?>
<?php if (mh_get_option('mharty_integration_single_bottom') <> '' && mh_get_option('mharty_integrate_singlebottom_enable') == 'on') echo(mh_get_option('mharty_integration_single_bottom')); ?>
<?php if ( 'on' == mh_get_option( 'mharty_show_related_posts', 'off' )) mh_related_posts(); ?>
<?php if ( ( comments_open() || get_comments_number() ) && 'on' == mh_get_option( 'mharty_show_postcomments', 'on' ) ) comments_template( '', true ); ?>
					</div> <!--mh_post_meta_wrapper-->
				</article> <!-- .mhc_post -->

			<?php endwhile; ?>
			</div> <!-- #left-area -->
			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->
<?php endif; ?>
<?php if (!is_customize_preview()) { edit_post_link('');} ?>
<?php get_footer(); ?>