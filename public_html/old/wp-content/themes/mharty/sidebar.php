<?php
if ( (is_home() && 'mh_full_width_page' === mh_get_option( 'mharty_index_page_sidebar', 'mh_left_sidebar' )) || (( is_archive() || is_search() || is_404()) && 'mh_full_width_page' === mh_get_option( 'mharty_archive_page_sidebar', 'mh_left_sidebar' ) ) || (
( is_single() || is_page() ) && 'mh_full_width_page' === get_post_meta( get_the_ID(), '_mhc_page_layout', true ))) return;
if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="sidebar">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div> <!-- end #sidebar -->
<?php endif; ?>