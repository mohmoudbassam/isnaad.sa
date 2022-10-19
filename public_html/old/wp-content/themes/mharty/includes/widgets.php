<?php
get_template_part( 'includes/widgets/widget-about' );
get_template_part( 'includes/widgets/widget-foursixeight' );
get_template_part( 'includes/widgets/widget-ads' );
get_template_part( 'includes/widgets/widget-custom-logo' );
get_template_part( 'includes/widgets/widget-popular-posts' );
get_template_part( 'includes/widgets/widget-latest-posts' );
get_template_part( 'includes/widgets/widget-latest-comments' );
get_template_part( 'includes/widgets/widget-info' );
get_template_part( 'includes/widgets/widget-social-follow' );
if( class_exists( 'MHReviewsClass', false ) )
get_template_part( 'includes/widgets/widget-reviews-posts' );
