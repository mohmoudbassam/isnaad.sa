<?php
function mh_widgets_init() {
	register_sidebar( array(
		'name' => esc_html__( 'Sidebar', 'mharty' ),
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="mhc_widget %2$s">',
		'after_widget' => '</div> <!-- end .mhc_widget -->',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Widget', 'mharty' ) . ' #1',
		'id' => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="fwidget mhc_widget %2$s">',
		'after_widget' => '</div> <!-- end .fwidget -->',
		'before_title' => '<h4 class="title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Widget', 'mharty' ) . ' #2',
		'id' => 'sidebar-3',
		'before_widget' => '<div id="%1$s" class="fwidget mhc_widget %2$s">',
		'after_widget' => '</div> <!-- end .fwidget -->',
		'before_title' => '<h4 class="title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Widget', 'mharty' ) . ' #3',
		'id' => 'sidebar-4',
		'before_widget' => '<div id="%1$s" class="fwidget mhc_widget %2$s">',
		'after_widget' => '</div> <!-- end .fwidget -->',
		'before_title' => '<h4 class="title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer Widget', 'mharty' ) . ' #4',
		'id' => 'sidebar-5',
		'before_widget' => '<div id="%1$s" class="fwidget mhc_widget %2$s">',
		'after_widget' => '</div> <!-- end .fwidget -->',
		'before_title' => '<h4 class="title">',
		'after_title' => '</h4>',
	) );
	
	$mhc_widgets = get_theme_mod( 'mhc_widgets' );

	if ( $mhc_widgets['areas'] ) {
		foreach ( $mhc_widgets['areas'] as $id => $name ) {
			register_sidebar( array(
				'name' => sanitize_text_field( $name ),
				'id' => sanitize_text_field( $id ),
				'before_widget' => '<div id="%1$s" class="mhc_widget %2$s">',
				'after_widget' => '</div> <!-- end .mhc_widget -->',
				'before_title' => '<h4 class="widgettitle">',
				'after_title' => '</h4>',
			) );
		}
	}
}
add_action( 'widgets_init', 'mh_widgets_init' );