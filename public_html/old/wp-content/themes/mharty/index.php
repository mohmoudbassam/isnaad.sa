<?php get_header();
$blogstyle = mh_get_option( 'mharty_archive_page_style', 'fullwidth' );
$readbutton = mh_get_option('mharty_readmore_button', 'off');
if ( 'grid' === $blogstyle ) wp_enqueue_script( 'jquery-masonry-3' );
?>
<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
            	 <?php 
				 //breadcrumbs
				 if ('on' === mh_get_option('mharty_enable_breadcrmbs', false))
					echo mh_breadcrumb(array(
                    'show_browse' => false,
                    'separator' => mh_wp_kses( _x(' / ', 'This is the breadcrumb separator.', 'mharty') ),
                    'show_home'  => esc_html__( 'Home', 'mharty' ),
                    'echo'       => false
                )); ?>
                
				<?php
				//archive title	& description			
				if (('on' == mh_get_option( 'mharty_archive_title', 'off' ) ) || ('on' == mh_get_option( 'mharty_archive_description', 'off' ) )): ?>
				<div class="mh_main_title">
					<?php if ('on' == mh_get_option( 'mharty_archive_title', 'off' ) ): ?>
					<h1>
					<?php if ( is_search() ) {
							echo sprintf( esc_html__( 'Search Results for: %s', 'mharty' ), get_search_query() );
						} else if ( is_archive() ) {
							the_archive_title();
						} ?>
					</h1>
					<?php endif; 
					if ('on' == mh_get_option( 'mharty_archive_description', 'off' ) ):
						the_archive_description();
					endif; ?>
				</div>
				<?php endif; ?>
				
                <?php //start main loop
				if ( have_posts() ) :
					//main posts container depends on the style
					$div_output = sprintf('%1$s<div class="mhc_archive_posts%2$s%3$s%4$s%5$s">',
						'grid' === $blogstyle ? '<div class="mhc_blog_grid_wrapper">' : '',
						'fullwidth' === $blogstyle ? ' mhc_blog_fullwidth' : '',
						'horizontal' === $blogstyle ? ' mhc_blog_horizantal' : '',
						'grid' === $blogstyle ? ' mhc_blog_grid clearfix' : '',
						'fullwidth' === $blogstyle && 'on' !== $readbutton ? ' has_no_more_button' : ''
					);
					echo $div_output;
					
					while ( have_posts() ) : the_post();
						$post_format = mh_post_format();
						$post_content = get_the_content();
						$show_loveit_class = $no_thumb_class = '';
						//loveit class
						if(function_exists('mh_loveit') && 'on' === mh_get_option( 'mharty_archive_show_loveit', 'off'))
						$show_loveit_class = ' with-loveit';
						
						//meta info class
						$meta_info_position_class = '';
						if ( in_array( $post_format, array( 'link', 'audio', 'quote' ) ) && 'grid' !== $blogstyle ) {
							$meta_info_position_class = ' post-meta-' . esc_attr( mh_get_option('mharty_postinfo1_position') );
						}
						if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
							$meta_info_position_class = ' post-meta-' . esc_attr( mh_get_option('mharty_postinfo1_position') );
						}
						
						//get the thumbnail
						$thumb = '';
						$width = 'fullwidth' === $blogstyle ? 1080 : 400;
						$width = (int) apply_filters( 'mhc_blog_image_width', $width );
						$height = 'fullwidth' === $blogstyle ? 675 : 250;
						$height = (int) apply_filters( 'mhc_blog_image_height', $height );
						$classtext = 'fullwidth' === $blogstyle ? 'mhc_post_main_image' : '';
						$titletext = get_the_title();
						$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
						$thumb = $thumbnail["thumb"];
						
						//thumbnail class
						if ( '' === $thumb || 'on' != mh_get_option( 'mharty_thumbnails_index', 'on' )){
							$no_thumb_class = ' mh_post_no_thumb';
						} ?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'mhc_post' . $show_loveit_class . $meta_info_position_class . $no_thumb_class); ?>>
                        
                        	<?php
							//get the post content
							mh_mharty_post_format_content();
							
							//target all post format except link, audio, quote
							if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
								
								//post info positon above
								if ('above' === mh_get_option('mharty_postinfo1_position', 'above')) 
									mh_mharty_post_meta();
								
								//video post format
								if ( 'video' === $post_format && false !== ( $first_video = mh_get_first_video($post_content) ) ) :
									printf('<div class="mh_main_video_container">%1$s</div>',
										$first_video
									);
									
								//gallery post format
								elseif ( 'gallery' === $post_format ) :
									mh_gallery_images();
								
								//standard post format
								elseif ( 'on' == mh_get_option( 'mharty_thumbnails_index', 'on' ) && '' !== $thumb  ) : 
									//add thumbnail container if it is a grid or horizontal
									if ( 'grid' === $blogstyle || 'horizontal' === $blogstyle)
										echo '<div class="mhc_image_container">'; ?>
                                      
                                        <a href="<?php the_permalink(); ?>">
                                            <?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
                                        </a>
									<?php
									// close thumbnail container
									if ( 'grid' === $blogstyle || 'horizontal' === $blogstyle )
										echo '</div> <!-- .mhc_image_container -->';
									
								endif; // end post format
							} //end !in_array
							
							//all post format except link, audio, quote, gallery
							if ( ! in_array( $post_format, array( 'link', 'audio', 'quote', 'gallery' ) ) ) : ?>
                            
								<div class="mhc_post_content">
                					<div class="mhc_post_content_inner">
                                    	
                                    	<?php
                                        //all post format except link, audio
										if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) :
											
											//post info positon middle
											if ('middle' === mh_get_option('mharty_postinfo1_position', 'above'))
												mh_mharty_post_meta();
											?>
                                            
											<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php mh_after_post_title(); ?></h2>
										<?php endif;
										
										//post info positon below title
										if ('below' === mh_get_option('mharty_postinfo1_position', 'above'))
											mh_mharty_post_meta();
											
										//get post content
										if ( 'on' !== mh_get_option( 'mharty_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_mhc_use_composer', true ) ) ) ){
											truncate_post( 270 );
											//get more button
											$more = 'on' === mh_get_option('mharty_readmore_index', 'false') ? sprintf(
											'%4$s<a href="%1$s" class="more-link%3$s" >%2$s</a>%5$s',
												esc_url( get_permalink() ),
												apply_filters( 'mh_read_more_text_filter', esc_html__( 'Read more', 'mharty' )),
												'on' === $readbutton ? ' mhc_contact_submit' : '',
												'on' === $readbutton ? '<div class="mhc_more_link" >' : '',
												'on' === $readbutton ? '</div>' : ''
											) : '';
											
											echo $more;
										}else{
											the_content();
										} ?>
                					</div> <!--mhc_post_content_inner-->
                                    <?php do_action('mh_archive_after_post'); ?>
								</div> <!--mhc_post_content-->
							<?php endif; //end !in_array ?>       
                        </article> <!-- .mhc_post -->
				
                	<?php endwhile; ?>
					</div> <!--.mhc_archive_posts-->
				
					<?php 
					// pagination
					if ( function_exists( 'wp_pagenavi' ) )
						wp_pagenavi();
					else
						get_template_part( 'includes/navigation', 'index' );
					?>
                    
                <?php if ( 'grid' === $blogstyle ) echo '</div> <!--mhc_blog_grid_wrapper-->'; ?>
                <?php else :
					get_template_part( 'includes/no-results', 'index' );
				endif; //end main loop ?>
			</div> <!-- #left-area -->
			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->
<?php get_footer(); ?>