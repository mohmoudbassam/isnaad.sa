<?php

function mh_more_icons_css() {
	wp_register_style( 'mh-more-icons-style', MH_MORE_ICONS_URL .'assets/css/style.css' );
	wp_enqueue_style( 'mh-more-icons-style');
}
add_action( 'admin_enqueue_scripts', 'mh_more_icons_css', 10, 1 );

//steadysets
if ( ! function_exists( 'mhc_font_steadysets_icon_symbols' ) ) :
function mhc_font_steadysets_icon_symbols() {
	$symbols = array('&amp;#xe600;','&amp;#xe601;','&amp;#xe602;','&amp;#xe603;','&amp;#xe604;','&amp;#xe605;','&amp;#xe606;','&amp;#xe607;','&amp;#xe608;','&amp;#xe609;','&amp;#xe60a;','&amp;#xe60b;','&amp;#xe60c;','&amp;#xe60d;','&amp;#xe60e;','&amp;#xe60f;','&amp;#xe610;','&amp;#xe611;','&amp;#xe612;','&amp;#xe613;','&amp;#xe614;','&amp;#xe615;','&amp;#xe616;','&amp;#xe617;','&amp;#xe618;','&amp;#xe619;','&amp;#xe61a;','&amp;#xe61b;','&amp;#xe61c;','&amp;#xe61d;','&amp;#xe61e;','&amp;#xe61f;','&amp;#xe620;','&amp;#xe621;','&amp;#xe622;','&amp;#xe623;','&amp;#xe624;','&amp;#xe625;','&amp;#xe626;','&amp;#xe627;','&amp;#xe628;','&amp;#xe629;','&amp;#xe62a;','&amp;#xe62b;','&amp;#xe62c;','&amp;#xe62d;','&amp;#xe62e;','&amp;#xe62f;','&amp;#xe630;','&amp;#xe631;','&amp;#xe632;','&amp;#xe633;','&amp;#xe634;','&amp;#xe635;','&amp;#xe636;','&amp;#xe637;','&amp;#xe638;','&amp;#xe639;','&amp;#xe63a;','&amp;#xe63b;','&amp;#xe63c;','&amp;#xe63d;','&amp;#xe63e;','&amp;#xe63f;','&amp;#xe640;','&amp;#xe641;','&amp;#xe642;','&amp;#xe643;','&amp;#xe644;','&amp;#xe645;','&amp;#xe646;','&amp;#xe647;','&amp;#xe648;','&amp;#xe649;','&amp;#xe64a;','&amp;#xe64b;','&amp;#xe64c;','&amp;#xe64d;','&amp;#xe64e;','&amp;#xe64f;','&amp;#xe650;','&amp;#xe651;','&amp;#xe652;','&amp;#xe653;','&amp;#xe654;','&amp;#xe655;','&amp;#xe656;','&amp;#xe657;','&amp;#xe658;','&amp;#xe659;','&amp;#xe65a;','&amp;#xe65b;','&amp;#xe65c;','&amp;#xe65d;','&amp;#xe65e;','&amp;#xe65f;','&amp;#xe660;','&amp;#xe661;','&amp;#xe662;','&amp;#xe663;','&amp;#xe664;','&amp;#xe665;','&amp;#xe666;','&amp;#xe667;','&amp;#xe668;','&amp;#xe669;','&amp;#xe66a;','&amp;#xe66b;','&amp;#xe66c;','&amp;#xe66d;','&amp;#xe66e;','&amp;#xe66f;','&amp;#xe670;','&amp;#xe671;','&amp;#xe672;','&amp;#xe673;','&amp;#xe674;','&amp;#xe675;','&amp;#xe676;','&amp;#xe677;','&amp;#xe678;','&amp;#xe679;','&amp;#xe67a;','&amp;#xe67b;','&amp;#xe67c;','&amp;#xe67d;','&amp;#xe67e;','&amp;#xe67f;','&amp;#xe680;','&amp;#xe681;','&amp;#xe682;','&amp;#xe683;','&amp;#xe684;','&amp;#xe685;','&amp;#xe686;','&amp;#xe687;','&amp;#xe688;','&amp;#xe689;','&amp;#xe68a;','&amp;#xe68b;');
	return $symbols;
}
endif;

if ( ! function_exists( 'mhc_get_font_steadysets_icon_list' ) ) :
function mhc_get_font_steadysets_icon_list() {
	$output = is_customize_preview() ? mhc_get_font_steadysets_icon_list_items() : '<%= window.mh_composer.steadysets_icon_list_template() %>';

	$output = sprintf( '<ul class="mhc-icon steadysets">%1$s</ul>', $output );

	return $output;
}
endif;

if ( ! function_exists( 'mhc_get_font_steadysets_icon_list_items' ) ) :
function mhc_get_font_steadysets_icon_list_items() {
	$output = '';

	$symbols = mhc_font_steadysets_icon_symbols();

	foreach ( $symbols as $symbol ) {
		$output .= sprintf( '<li data-icon="%1$s"></li>', esc_attr( $symbol ) );
	}

	return $output;
}
endif;

if ( ! function_exists( 'mhc_steadysets_icon_list' ) ) :
function mhc_font_steadysets_icon_list() {
	echo mhc_get_font_steadysets_icon_list();
}
endif;

//FontAwesome
if ( ! function_exists( 'mhc_font_awesome_icon_symbols' ) ) :
function mhc_font_awesome_icon_symbols() {
	$symbols = array('&amp;#xe602;','&amp;#xe603;','&amp;#xe604;','&amp;#xe605;','&amp;#xe606;','&amp;#xe607;','&amp;#xe608;','&amp;#xe609;','&amp;#xe60a;','&amp;#xe60b;','&amp;#xe60c;','&amp;#xe60d;','&amp;#xe60e;','&amp;#xe60f;','&amp;#xe610;','&amp;#xe611;','&amp;#xe612;','&amp;#xe613;','&amp;#xe614;','&amp;#xe615;','&amp;#xe616;','&amp;#xe617;','&amp;#xe618;','&amp;#xe619;','&amp;#xe61a;','&amp;#xe61b;','&amp;#xe61c;','&amp;#xe61d;','&amp;#xe61e;','&amp;#xe61f;','&amp;#xe620;','&amp;#xe621;','&amp;#xe622;','&amp;#xe623;','&amp;#xe624;','&amp;#xe625;','&amp;#xe626;','&amp;#xe627;','&amp;#xe628;','&amp;#xe629;','&amp;#xe62a;','&amp;#xe62b;','&amp;#xe62c;','&amp;#xe62d;','&amp;#xe62e;','&amp;#xe62f;','&amp;#xe630;','&amp;#xe631;','&amp;#xe632;','&amp;#xe633;','&amp;#xe634;','&amp;#xe635;','&amp;#xe636;','&amp;#xe637;','&amp;#xe638;','&amp;#xe639;','&amp;#xe63a;','&amp;#xe63b;','&amp;#xe63c;','&amp;#xe63d;','&amp;#xe63e;','&amp;#xe63f;','&amp;#xe640;','&amp;#xe641;','&amp;#xe642;','&amp;#xe643;','&amp;#xe644;','&amp;#xe645;','&amp;#xe646;','&amp;#xe647;','&amp;#xe648;','&amp;#xe649;','&amp;#xe64a;','&amp;#xe64b;','&amp;#xe64c;','&amp;#xe64d;','&amp;#xe64e;','&amp;#xe64f;','&amp;#xe650;','&amp;#xe651;','&amp;#xe652;','&amp;#xe653;','&amp;#xe654;','&amp;#xe655;','&amp;#xe656;','&amp;#xe657;','&amp;#xe658;','&amp;#xe659;','&amp;#xe65a;','&amp;#xe65b;','&amp;#xe65c;','&amp;#xe65d;','&amp;#xe65e;','&amp;#xe65f;','&amp;#xe660;','&amp;#xe661;','&amp;#xe662;','&amp;#xe663;','&amp;#xe664;','&amp;#xe665;','&amp;#xe666;','&amp;#xe667;','&amp;#xe668;','&amp;#xe669;','&amp;#xe66a;','&amp;#xe66b;','&amp;#xe66c;','&amp;#xe66d;','&amp;#xe66e;','&amp;#xe66f;','&amp;#xe670;','&amp;#xe671;','&amp;#xe672;','&amp;#xe673;','&amp;#xe674;','&amp;#xe675;','&amp;#xe676;','&amp;#xe677;','&amp;#xe678;','&amp;#xe679;','&amp;#xe67a;','&amp;#xe67b;','&amp;#xe67c;','&amp;#xe67d;','&amp;#xe67e;','&amp;#xe67f;','&amp;#xe680;','&amp;#xe681;','&amp;#xe682;','&amp;#xe683;','&amp;#xe684;','&amp;#xe685;','&amp;#xe686;','&amp;#xe687;','&amp;#xe688;','&amp;#xe689;','&amp;#xe68a;','&amp;#xe68b;','&amp;#xe68c;','&amp;#xe68d;','&amp;#xe68e;','&amp;#xe68f;','&amp;#xe690;','&amp;#xe691;','&amp;#xe692;','&amp;#xe693;','&amp;#xe694;','&amp;#xe695;','&amp;#xe696;','&amp;#xe697;','&amp;#xe698;','&amp;#xe699;','&amp;#xe69a;','&amp;#xe69b;','&amp;#xe69c;','&amp;#xe69d;','&amp;#xe69e;','&amp;#xe69f;','&amp;#xe6a0;','&amp;#xe6a1;','&amp;#xe6a2;','&amp;#xe6a3;','&amp;#xe6a4;','&amp;#xe6a5;','&amp;#xe6a6;','&amp;#xe6a7;','&amp;#xe6a8;','&amp;#xe6a9;','&amp;#xe6aa;','&amp;#xe6ab;','&amp;#xe6ac;','&amp;#xe6ad;','&amp;#xe6ae;','&amp;#xe6af;','&amp;#xe6b0;','&amp;#xe6b1;','&amp;#xe6b2;','&amp;#xe6b3;','&amp;#xe6b4;','&amp;#xe6b5;','&amp;#xe6b6;','&amp;#xe6b7;','&amp;#xe6b8;','&amp;#xe6b9;','&amp;#xe6ba;','&amp;#xe6bb;','&amp;#xe6bc;','&amp;#xe6bd;','&amp;#xe6be;','&amp;#xe6bf;','&amp;#xe6c0;','&amp;#xe6c1;','&amp;#xe6c2;','&amp;#xe6c3;','&amp;#xe6c4;','&amp;#xe6c5;','&amp;#xe6c6;','&amp;#xe6c7;','&amp;#xe6c8;','&amp;#xe6c9;','&amp;#xe6ca;','&amp;#xe6cb;','&amp;#xe6cc;','&amp;#xe6cd;','&amp;#xe6ce;','&amp;#xe6cf;','&amp;#xe6d0;','&amp;#xe6d1;','&amp;#xe6d2;','&amp;#xe6d3;','&amp;#xe6d4;','&amp;#xe6d5;','&amp;#xe6d6;','&amp;#xe6d7;','&amp;#xe6d8;','&amp;#xe6d9;','&amp;#xe6da;','&amp;#xe6db;','&amp;#xe6dc;','&amp;#xe6dd;','&amp;#xe6de;','&amp;#xe6df;','&amp;#xe6e0;','&amp;#xe6e1;','&amp;#xe6e2;','&amp;#xe6e3;','&amp;#xe6e4;','&amp;#xe6e5;','&amp;#xe6e6;','&amp;#xe6e7;','&amp;#xe6e8;','&amp;#xe6e9;','&amp;#xe6ea;','&amp;#xe6eb;','&amp;#xe6ec;','&amp;#xe6ed;','&amp;#xe6ee;','&amp;#xe6ef;','&amp;#xe6f0;','&amp;#xe6f1;','&amp;#xe6f2;','&amp;#xe6f3;','&amp;#xe6f4;','&amp;#xe6f5;','&amp;#xe6f6;','&amp;#xe6f7;','&amp;#xe6f8;','&amp;#xe6f9;','&amp;#xe6fa;','&amp;#xe6fb;','&amp;#xe6fc;','&amp;#xe6fd;','&amp;#xe6fe;','&amp;#xe6ff;','&amp;#xe700;','&amp;#xe701;','&amp;#xe702;','&amp;#xe703;','&amp;#xe704;','&amp;#xe705;','&amp;#xe706;','&amp;#xe707;','&amp;#xe708;','&amp;#xe709;','&amp;#xe70a;','&amp;#xe70b;','&amp;#xe70c;','&amp;#xe70d;','&amp;#xe70e;','&amp;#xe70f;','&amp;#xe710;','&amp;#xe711;','&amp;#xe712;','&amp;#xe713;','&amp;#xe714;','&amp;#xe715;','&amp;#xe716;','&amp;#xe717;','&amp;#xe718;','&amp;#xe719;','&amp;#xe71a;','&amp;#xe71b;','&amp;#xe71c;','&amp;#xe71d;','&amp;#xe71e;','&amp;#xe71f;','&amp;#xe720;','&amp;#xe721;','&amp;#xe722;','&amp;#xe723;','&amp;#xe724;','&amp;#xe725;','&amp;#xe726;','&amp;#xe727;','&amp;#xe728;','&amp;#xe729;','&amp;#xe72a;','&amp;#xe72b;','&amp;#xe72c;','&amp;#xe72d;','&amp;#xe72e;','&amp;#xe72f;','&amp;#xe730;','&amp;#xe731;','&amp;#xe732;','&amp;#xe733;','&amp;#xe734;','&amp;#xe735;','&amp;#xe736;','&amp;#xe737;','&amp;#xe738;','&amp;#xe739;','&amp;#xe73a;','&amp;#xe73b;','&amp;#xe73c;','&amp;#xe73d;','&amp;#xe73e;','&amp;#xe73f;','&amp;#xe740;','&amp;#xe741;','&amp;#xe742;','&amp;#xe743;','&amp;#xe744;','&amp;#xe745;','&amp;#xe746;','&amp;#xe747;','&amp;#xe748;','&amp;#xe749;','&amp;#xe74a;','&amp;#xe74b;','&amp;#xe74c;','&amp;#xe74d;','&amp;#xe74e;','&amp;#xe74f;','&amp;#xe750;','&amp;#xe751;','&amp;#xe752;','&amp;#xe753;','&amp;#xe754;','&amp;#xe755;','&amp;#xe756;','&amp;#xe757;','&amp;#xe758;','&amp;#xe759;','&amp;#xe75a;','&amp;#xe75b;','&amp;#xe75c;','&amp;#xe75d;','&amp;#xe75e;','&amp;#xe75f;','&amp;#xe760;','&amp;#xe761;','&amp;#xe762;','&amp;#xe763;','&amp;#xe764;','&amp;#xe765;','&amp;#xe766;','&amp;#xe767;','&amp;#xe768;','&amp;#xe769;','&amp;#xe76a;','&amp;#xe76b;','&amp;#xe76c;','&amp;#xe76d;','&amp;#xe76e;','&amp;#xe76f;','&amp;#xe770;','&amp;#xe771;','&amp;#xe772;','&amp;#xe773;','&amp;#xe774;','&amp;#xe775;','&amp;#xe776;','&amp;#xe777;','&amp;#xe778;','&amp;#xe779;','&amp;#xe77a;','&amp;#xe77b;','&amp;#xe77c;','&amp;#xe77d;','&amp;#xe77e;','&amp;#xe77f;','&amp;#xe780;','&amp;#xe781;','&amp;#xe782;','&amp;#xe783;','&amp;#xe784;','&amp;#xe785;','&amp;#xe786;','&amp;#xe787;','&amp;#xe788;','&amp;#xe789;','&amp;#xe78a;','&amp;#xe78b;','&amp;#xe78c;','&amp;#xe78d;','&amp;#xe78e;','&amp;#xe78f;','&amp;#xe790;','&amp;#xe791;','&amp;#xe792;','&amp;#xe793;','&amp;#xe794;','&amp;#xe795;','&amp;#xe796;','&amp;#xe797;','&amp;#xe798;','&amp;#xe799;','&amp;#xe79a;','&amp;#xe79b;','&amp;#xe79c;','&amp;#xe79d;','&amp;#xe79e;','&amp;#xe79f;','&amp;#xe7a0;','&amp;#xe7a1;','&amp;#xe7a2;','&amp;#xe7a3;','&amp;#xe7a4;','&amp;#xe7a6;','&amp;#xe7a7;','&amp;#xe7a8;','&amp;#xe7a9;','&amp;#xe7aa;','&amp;#xe7ab;','&amp;#xe7ac;','&amp;#xe7ad;','&amp;#xe7ae;','&amp;#xe7af;','&amp;#xe7b0;','&amp;#xe7b1;','&amp;#xe7b2;','&amp;#xe7b3;','&amp;#xe7b4;','&amp;#xe7b5;','&amp;#xe7b6;','&amp;#xe7b7;','&amp;#xe7b8;','&amp;#xe7b9;','&amp;#xe7ba;','&amp;#xe7bb;','&amp;#xe7bc;','&amp;#xe7bd;','&amp;#xe7be;','&amp;#xe7bf;','&amp;#xe7c0;','&amp;#xe7c1;','&amp;#xe7c2;','&amp;#xe7c3;','&amp;#xe7c4;','&amp;#xe7c5;','&amp;#xe7c6;','&amp;#xe7c7;','&amp;#xe7c8;','&amp;#xe7c9;','&amp;#xe7ca;','&amp;#xe7cb;','&amp;#xe7cc;','&amp;#xe7cd;','&amp;#xe7ce;','&amp;#xe7cf;','&amp;#xe7d0;','&amp;#xe7d1;','&amp;#xe7d2;','&amp;#xe7d3;','&amp;#xe7d4;','&amp;#xe7d5;','&amp;#xe7d6;','&amp;#xe7d7;','&amp;#xe7d8;','&amp;#xe7d9;','&amp;#xe7da;','&amp;#xe7db;','&amp;#xe7dc;','&amp;#xe7dd;','&amp;#xe7de;');

	return $symbols;
}
endif;

if ( ! function_exists( 'mhc_get_font_awesome_icon_list' ) ) :
function mhc_get_font_awesome_icon_list() {
	$output = is_customize_preview() ? mhc_get_font_awesome_icon_list_items() : '<%= window.mh_composer.awesome_icon_list_template() %>';

	$output = sprintf( '<ul class="mhc-icon awesome">%1$s</ul>', $output );

	return $output;
}
endif;

if ( ! function_exists( 'mhc_get_font_awesome_icon_list_items' ) ) :
function mhc_get_font_awesome_icon_list_items() {
	$output = '';

	$symbols = mhc_font_awesome_icon_symbols();

	foreach ( $symbols as $symbol ) {
		$output .= sprintf( '<li data-icon="%1$s"></li>', esc_attr( $symbol ) );
	}

	return $output;
}
endif;

if ( ! function_exists( 'mhc_font_awesome_icon_list' ) ) :
function mhc_font_awesome_icon_list() {
	echo mhc_get_font_awesome_icon_list();
}
endif;

//lineicons
if ( ! function_exists( 'mhc_font_lineicons_icon_symbols' ) ) :
function mhc_font_lineicons_icon_symbols() {
	$symbols = array('&amp;#xe600;','&amp;#xe601;','&amp;#xe602;','&amp;#xe603;','&amp;#xe604;','&amp;#xe605;','&amp;#xe606;','&amp;#xe607;','&amp;#xe608;','&amp;#xe609;','&amp;#xe60a;','&amp;#xe60b;','&amp;#xe60c;','&amp;#xe60d;','&amp;#xe60e;','&amp;#xe60f;','&amp;#xe610;','&amp;#xe611;','&amp;#xe612;','&amp;#xe613;','&amp;#xe614;','&amp;#xe615;','&amp;#xe616;','&amp;#xe617;','&amp;#xe618;','&amp;#xe619;','&amp;#xe61a;','&amp;#xe61b;','&amp;#xe61c;','&amp;#xe61d;','&amp;#xe61e;','&amp;#xe61f;','&amp;#xe620;','&amp;#xe621;','&amp;#xe622;','&amp;#xe623;','&amp;#xe624;','&amp;#xe625;','&amp;#xe626;','&amp;#xe627;','&amp;#xe628;','&amp;#xe629;','&amp;#xe62a;','&amp;#xe62b;','&amp;#xe62c;','&amp;#xe62d;','&amp;#xe62e;','&amp;#xe62f;');

	return $symbols;
}
endif;

if ( ! function_exists( 'mhc_get_font_lineicons_icon_list' ) ) :
function mhc_get_font_lineicons_icon_list() {
	$output = is_customize_preview() ? mhc_get_font_lineicons_icon_list_items() : '<%= window.mh_composer.lineicons_icon_list_template() %>';

	$output = sprintf( '<ul class="mhc-icon lineicons">%1$s</ul>', $output );

	return $output;
}
endif;

if ( ! function_exists( 'mhc_get_font_lineicons_icon_list_items' ) ) :
function mhc_get_font_lineicons_icon_list_items() {
	$output = '';

	$symbols = mhc_font_lineicons_icon_symbols();

	foreach ( $symbols as $symbol ) {
		$output .= sprintf( '<li data-icon="%1$s"></li>', esc_attr( $symbol ) );
	}

	return $output;
}
endif;

if ( ! function_exists( 'mhc_font_lineicons_icon_list' ) ) :
function mhc_font_lineicons_icon_list() {
	echo mhc_get_font_lineicons_icon_list();
}
endif;

//etline
if ( ! function_exists( 'mhc_font_etline_icon_symbols' ) ) :
function mhc_font_etline_icon_symbols() {
	$symbols = array('&amp;#xe600;','&amp;#xe601;','&amp;#xe602;','&amp;#xe603;','&amp;#xe604;','&amp;#xe605;','&amp;#xe606;','&amp;#xe607;','&amp;#xe608;','&amp;#xe609;','&amp;#xe60a;','&amp;#xe60b;','&amp;#xe60c;','&amp;#xe60d;','&amp;#xe60e;','&amp;#xe60f;','&amp;#xe610;','&amp;#xe611;','&amp;#xe612;','&amp;#xe613;','&amp;#xe614;','&amp;#xe615;','&amp;#xe616;','&amp;#xe617;','&amp;#xe618;','&amp;#xe619;','&amp;#xe61a;','&amp;#xe61b;','&amp;#xe61c;','&amp;#xe61d;','&amp;#xe61e;','&amp;#xe61f;','&amp;#xe620;','&amp;#xe621;','&amp;#xe622;','&amp;#xe623;','&amp;#xe624;','&amp;#xe625;','&amp;#xe626;','&amp;#xe627;','&amp;#xe628;','&amp;#xe629;','&amp;#xe62a;','&amp;#xe62b;','&amp;#xe62c;','&amp;#xe62d;','&amp;#xe62e;','&amp;#xe62f;','&amp;#xe630;','&amp;#xe631;','&amp;#xe632;','&amp;#xe633;','&amp;#xe634;','&amp;#xe635;','&amp;#xe636;','&amp;#xe637;','&amp;#xe638;','&amp;#xe639;','&amp;#xe63a;','&amp;#xe63b;','&amp;#xe63c;','&amp;#xe63d;','&amp;#xe63e;','&amp;#xe63f;','&amp;#xe640;','&amp;#xe641;','&amp;#xe642;','&amp;#xe643;','&amp;#xe644;','&amp;#xe645;','&amp;#xe646;','&amp;#xe647;','&amp;#xe648;','&amp;#xe649;','&amp;#xe64a;','&amp;#xe64b;','&amp;#xe64c;','&amp;#xe64d;','&amp;#xe64e;','&amp;#xe64f;','&amp;#xe650;','&amp;#xe651;','&amp;#xe652;','&amp;#xe653;','&amp;#xe654;','&amp;#xe655;','&amp;#xe656;','&amp;#xe657;','&amp;#xe658;','&amp;#xe659;','&amp;#xe65a;','&amp;#xe65b;','&amp;#xe65c;','&amp;#xe65d;','&amp;#xe65e;','&amp;#xe65f;','&amp;#xe660;','&amp;#xe661;','&amp;#xe662;');

	return $symbols;
}
endif;

if ( ! function_exists( 'mhc_get_font_etline_icon_list' ) ) :
function mhc_get_font_etline_icon_list() {
	$output = is_customize_preview() ? mhc_get_font_etline_icon_list_items() : '<%= window.mh_composer.etline_icon_list_template() %>';

	$output = sprintf( '<ul class="mhc-icon etline">%1$s</ul>', $output );

	return $output;
}
endif;

if ( ! function_exists( 'mhc_get_font_etline_icon_list_items' ) ) :
function mhc_get_font_etline_icon_list_items() {
	$output = '';

	$symbols = mhc_font_etline_icon_symbols();

	foreach ( $symbols as $symbol ) {
		$output .= sprintf( '<li data-icon="%1$s"></li>', esc_attr( $symbol ) );
	}

	return $output;
}
endif;

if ( ! function_exists( 'mhc_font_etline_icon_list' ) ) :
function mhc_font_etline_icon_list() {
	echo mhc_get_font_etline_icon_list();
}
endif;

//icomoon
if ( ! function_exists( 'mhc_font_icomoon_icon_symbols' ) ) :
function mhc_font_icomoon_icon_symbols() {
	$symbols = array('&amp;#xe600;','&amp;#xe601;','&amp;#xe602;','&amp;#xe603;','&amp;#xe604;','&amp;#xe605;','&amp;#xe606;','&amp;#xe607;','&amp;#xe608;','&amp;#xe609;','&amp;#xe60a;','&amp;#xe60b;','&amp;#xe60c;','&amp;#xe60d;','&amp;#xe60e;','&amp;#xe60f;','&amp;#xe610;','&amp;#xe611;','&amp;#xe612;','&amp;#xe613;','&amp;#xe614;','&amp;#xe615;','&amp;#xe616;','&amp;#xe617;','&amp;#xe618;','&amp;#xe619;','&amp;#xe61a;','&amp;#xe61b;','&amp;#xe61c;','&amp;#xe61d;','&amp;#xe61e;','&amp;#xe61f;','&amp;#xe620;','&amp;#xe621;','&amp;#xe622;','&amp;#xe623;','&amp;#xe624;','&amp;#xe625;','&amp;#xe626;','&amp;#xe627;','&amp;#xe628;','&amp;#xe629;','&amp;#xe62a;','&amp;#xe62b;','&amp;#xe62c;','&amp;#xe62d;','&amp;#xe62e;','&amp;#xe62f;','&amp;#xe630;','&amp;#xe631;','&amp;#xe632;','&amp;#xe633;','&amp;#xe634;','&amp;#xe635;','&amp;#xe636;','&amp;#xe637;','&amp;#xe638;','&amp;#xe639;','&amp;#xe63a;','&amp;#xe63b;','&amp;#xe63c;','&amp;#xe63d;','&amp;#xe63e;','&amp;#xe63f;','&amp;#xe640;','&amp;#xe641;','&amp;#xe642;','&amp;#xe643;','&amp;#xe644;','&amp;#xe645;','&amp;#xe646;','&amp;#xe647;','&amp;#xe648;','&amp;#xe649;','&amp;#xe64a;','&amp;#xe64b;','&amp;#xe64c;','&amp;#xe64d;','&amp;#xe64e;','&amp;#xe64f;','&amp;#xe650;','&amp;#xe651;','&amp;#xe652;','&amp;#xe653;','&amp;#xe654;','&amp;#xe655;','&amp;#xe656;','&amp;#xe657;','&amp;#xe658;','&amp;#xe659;','&amp;#xe65a;','&amp;#xe65b;','&amp;#xe65c;','&amp;#xe65d;','&amp;#xe65e;','&amp;#xe65f;','&amp;#xe660;','&amp;#xe661;','&amp;#xe662;','&amp;#xe663;','&amp;#xe664;','&amp;#xe665;','&amp;#xe666;','&amp;#xe667;','&amp;#xe668;','&amp;#xe669;','&amp;#xe66a;','&amp;#xe66b;','&amp;#xe66c;','&amp;#xe66d;','&amp;#xe66e;','&amp;#xe66f;','&amp;#xe670;','&amp;#xe671;','&amp;#xe672;','&amp;#xe673;','&amp;#xe674;','&amp;#xe675;','&amp;#xe676;','&amp;#xe677;','&amp;#xe678;','&amp;#xe679;','&amp;#xe67a;','&amp;#xe67b;','&amp;#xe67c;','&amp;#xe67d;','&amp;#xe67e;','&amp;#xe67f;','&amp;#xe680;','&amp;#xe681;','&amp;#xe682;','&amp;#xe683;','&amp;#xe684;','&amp;#xe685;','&amp;#xe686;','&amp;#xe687;','&amp;#xe688;','&amp;#xe689;','&amp;#xe68a;','&amp;#xe68b;','&amp;#xe68c;','&amp;#xe68d;','&amp;#xe68e;','&amp;#xe68f;','&amp;#xe690;','&amp;#xe691;','&amp;#xe692;','&amp;#xe693;','&amp;#xe694;','&amp;#xe695;','&amp;#xe696;','&amp;#xe697;','&amp;#xe698;','&amp;#xe699;','&amp;#xe69a;','&amp;#xe69b;','&amp;#xe69c;','&amp;#xe69d;','&amp;#xe69e;','&amp;#xe69f;','&amp;#xe6a0;','&amp;#xe6a1;','&amp;#xe6a2;','&amp;#xe6a3;','&amp;#xe6a4;','&amp;#xe6a5;','&amp;#xe6a6;','&amp;#xe6a7;','&amp;#xe6a8;','&amp;#xe6a9;','&amp;#xe6aa;','&amp;#xe6ab;','&amp;#xe6ac;','&amp;#xe6ad;','&amp;#xe6ae;','&amp;#xe6af;','&amp;#xe6b0;','&amp;#xe6b1;','&amp;#xe6b2;','&amp;#xe6b3;','&amp;#xe6b4;','&amp;#xe6b5;','&amp;#xe6b6;','&amp;#xe6b7;','&amp;#xe6b8;','&amp;#xe6b9;','&amp;#xe6ba;','&amp;#xe6bb;','&amp;#xe6bc;','&amp;#xe6bd;','&amp;#xe6be;','&amp;#xe6bf;','&amp;#xe6c0;','&amp;#xe6c1;','&amp;#xe6c2;','&amp;#xe6c3;','&amp;#xe6c4;','&amp;#xe6c5;','&amp;#xe6c6;','&amp;#xe6c7;','&amp;#xe6c8;','&amp;#xe6c9;','&amp;#xe6ca;','&amp;#xe6cb;','&amp;#xe6cc;','&amp;#xe6cd;','&amp;#xe6ce;','&amp;#xe6cf;','&amp;#xe6d0;','&amp;#xe6d1;','&amp;#xe6d2;','&amp;#xe6d3;','&amp;#xe6d4;','&amp;#xe6d5;','&amp;#xe6d6;','&amp;#xe6d7;','&amp;#xe6d8;','&amp;#xe6d9;','&amp;#xe6da;','&amp;#xe6db;','&amp;#xe6dc;','&amp;#xe6dd;','&amp;#xe6de;','&amp;#xe6df;','&amp;#xe6e0;','&amp;#xe6e1;','&amp;#xe6e2;','&amp;#xe6e3;','&amp;#xe6e4;','&amp;#xe6e5;','&amp;#xe6e6;','&amp;#xe6e7;','&amp;#xe6e8;','&amp;#xe6e9;','&amp;#xe6ea;','&amp;#xe6eb;','&amp;#xe6ec;','&amp;#xe6ed;','&amp;#xe6ee;','&amp;#xe6ef;','&amp;#xe6f0;','&amp;#xe6f1;','&amp;#xe6f2;','&amp;#xe6f3;','&amp;#xe6f4;','&amp;#xe6f5;','&amp;#xe6f6;','&amp;#xe6f7;','&amp;#xe6f8;','&amp;#xe6f9;','&amp;#xe6fa;','&amp;#xe6fb;','&amp;#xe6fc;','&amp;#xe6fd;','&amp;#xe6fe;','&amp;#xe6ff;','&amp;#xe700;','&amp;#xe701;','&amp;#xe702;','&amp;#xe703;','&amp;#xe704;','&amp;#xe705;','&amp;#xe706;','&amp;#xe707;','&amp;#xe708;','&amp;#xe709;','&amp;#xe70a;','&amp;#xe70b;','&amp;#xe70c;','&amp;#xe70d;','&amp;#xe70e;','&amp;#xe70f;','&amp;#xe710;','&amp;#xe711;','&amp;#xe712;','&amp;#xe713;','&amp;#xe714;','&amp;#xe715;','&amp;#xe716;','&amp;#xe717;','&amp;#xe718;','&amp;#xe719;','&amp;#xe71a;','&amp;#xe71b;','&amp;#xe71c;','&amp;#xe71d;','&amp;#xe71e;','&amp;#xe71f;','&amp;#xe720;','&amp;#xe721;','&amp;#xe722;','&amp;#xe723;','&amp;#xe724;','&amp;#xe725;','&amp;#xe726;','&amp;#xe727;','&amp;#xe728;','&amp;#xe729;','&amp;#xe72a;','&amp;#xe72b;','&amp;#xe72c;','&amp;#xe72d;','&amp;#xe72e;','&amp;#xe72f;','&amp;#xe730;','&amp;#xe731;','&amp;#xe732;','&amp;#xe733;','&amp;#xe734;','&amp;#xe735;','&amp;#xe736;','&amp;#xe737;','&amp;#xe738;','&amp;#xe739;','&amp;#xe73a;','&amp;#xe73b;','&amp;#xe73c;','&amp;#xe73d;','&amp;#xe73e;','&amp;#xe73f;','&amp;#xe740;','&amp;#xe741;','&amp;#xe742;','&amp;#xe743;','&amp;#xe744;','&amp;#xe745;','&amp;#xe746;','&amp;#xe747;','&amp;#xe748;','&amp;#xe749;','&amp;#xe74a;','&amp;#xe74b;','&amp;#xe74c;','&amp;#xe74d;','&amp;#xe74e;','&amp;#xe74f;','&amp;#xe750;','&amp;#xe751;','&amp;#xe752;','&amp;#xe753;','&amp;#xe754;','&amp;#xe755;','&amp;#xe756;','&amp;#xe757;','&amp;#xe758;','&amp;#xe759;','&amp;#xe75a;','&amp;#xe75b;','&amp;#xe75c;','&amp;#xe75d;','&amp;#xe75e;','&amp;#xe75f;','&amp;#xe760;','&amp;#xe761;','&amp;#xe762;','&amp;#xe763;','&amp;#xe764;','&amp;#xe765;','&amp;#xe766;','&amp;#xe767;','&amp;#xe768;','&amp;#xe769;','&amp;#xe76a;','&amp;#xe76b;','&amp;#xe76c;','&amp;#xe76d;','&amp;#xe76e;','&amp;#xe76f;','&amp;#xe770;','&amp;#xe771;','&amp;#xe772;','&amp;#xe773;','&amp;#xe774;','&amp;#xe775;','&amp;#xe776;','&amp;#xe777;','&amp;#xe778;','&amp;#xe779;','&amp;#xe77a;','&amp;#xe77b;','&amp;#xe77c;','&amp;#xe77d;','&amp;#xe77e;','&amp;#xe77f;','&amp;#xe780;','&amp;#xe781;','&amp;#xe782;','&amp;#xe783;','&amp;#xe784;','&amp;#xe785;','&amp;#xe786;','&amp;#xe787;','&amp;#xe788;','&amp;#xe789;','&amp;#xe78a;','&amp;#xe78b;','&amp;#xe78c;','&amp;#xe78d;','&amp;#xe78e;','&amp;#xe78f;','&amp;#xe790;','&amp;#xe791;','&amp;#xe792;','&amp;#xe793;','&amp;#xe794;','&amp;#xe795;','&amp;#xe796;','&amp;#xe797;','&amp;#xe798;','&amp;#xe799;','&amp;#xe79a;','&amp;#xe79b;','&amp;#xe79c;','&amp;#xe79d;','&amp;#xe79e;','&amp;#xe79f;','&amp;#xe7a0;','&amp;#xe7a1;','&amp;#xe7a2;','&amp;#xe7a3;','&amp;#xe7a4;','&amp;#xe7a5;','&amp;#xe7a6;','&amp;#xe7a7;','&amp;#xe7a8;','&amp;#xe7a9;','&amp;#xe7aa;','&amp;#xe7ab;','&amp;#xe7ac;','&amp;#xe7ad;','&amp;#xe7ae;','&amp;#xe7af;','&amp;#xe7b0;','&amp;#xe7b1;','&amp;#xe7b2;','&amp;#xe7b3;','&amp;#xe7b4;','&amp;#xe7b5;','&amp;#xe7b6;','&amp;#xe7b7;','&amp;#xe7b8;','&amp;#xe7b9;','&amp;#xe7ba;','&amp;#xe7bb;','&amp;#xe7bc;','&amp;#xe7bd;','&amp;#xe7be;','&amp;#xe7bf;','&amp;#xe7c0;','&amp;#xe7c1;','&amp;#xe7c2;');

	return $symbols;
}
endif;

if ( ! function_exists( 'mhc_get_font_icomoon_icon_list' ) ) :
function mhc_get_font_icomoon_icon_list() {
	$output = is_customize_preview() ? mhc_get_font_icomoon_icon_list_items() : '<%= window.mh_composer.icomoon_icon_list_template() %>';

	$output = sprintf( '<ul class="mhc-icon icomoon">%1$s</ul>', $output );

	return $output;
}
endif;

if ( ! function_exists( 'mhc_get_font_icomoon_icon_list_items' ) ) :
function mhc_get_font_icomoon_icon_list_items() {
	$output = '';

	$symbols = mhc_font_icomoon_icon_symbols();

	foreach ( $symbols as $symbol ) {
		$output .= sprintf( '<li data-icon="%1$s"></li>', esc_attr( $symbol ) );
	}

	return $output;
}
endif;

if ( ! function_exists( 'mhc_font_icomoon_icon_list' ) ) :
function mhc_font_icomoon_icon_list() {
	echo mhc_get_font_icomoon_icon_list();
}
endif;


//linearicons
if ( ! function_exists( 'mhc_font_linearicons_icon_symbols' ) ) :
function mhc_font_linearicons_icon_symbols() {
	$symbols = array('&amp;#xe600;','&amp;#xe601;','&amp;#xe602;','&amp;#xe603;','&amp;#xe604;','&amp;#xe605;','&amp;#xe606;','&amp;#xe607;','&amp;#xe608;','&amp;#xe609;','&amp;#xe60a;','&amp;#xe60b;','&amp;#xe60c;','&amp;#xe60d;','&amp;#xe60e;','&amp;#xe60f;','&amp;#xe610;','&amp;#xe611;','&amp;#xe612;','&amp;#xe613;','&amp;#xe614;','&amp;#xe615;','&amp;#xe616;','&amp;#xe617;','&amp;#xe618;','&amp;#xe619;','&amp;#xe61a;','&amp;#xe61b;','&amp;#xe61c;','&amp;#xe61d;','&amp;#xe61e;','&amp;#xe61f;','&amp;#xe620;','&amp;#xe621;','&amp;#xe622;','&amp;#xe623;','&amp;#xe624;','&amp;#xe625;','&amp;#xe626;','&amp;#xe627;','&amp;#xe628;','&amp;#xe629;','&amp;#xe62a;','&amp;#xe62b;','&amp;#xe62c;','&amp;#xe62d;','&amp;#xe62e;','&amp;#xe62f;','&amp;#xe630;','&amp;#xe631;','&amp;#xe632;','&amp;#xe633;','&amp;#xe634;','&amp;#xe635;','&amp;#xe636;','&amp;#xe637;','&amp;#xe638;','&amp;#xe639;','&amp;#xe63a;','&amp;#xe63b;','&amp;#xe63c;','&amp;#xe63d;','&amp;#xe63e;','&amp;#xe63f;','&amp;#xe640;','&amp;#xe641;','&amp;#xe642;','&amp;#xe643;','&amp;#xe644;','&amp;#xe645;','&amp;#xe646;','&amp;#xe647;','&amp;#xe648;','&amp;#xe649;','&amp;#xe64a;','&amp;#xe64b;','&amp;#xe64c;','&amp;#xe64d;','&amp;#xe64e;','&amp;#xe64f;','&amp;#xe650;','&amp;#xe651;','&amp;#xe652;','&amp;#xe653;','&amp;#xe654;','&amp;#xe655;','&amp;#xe656;','&amp;#xe657;','&amp;#xe658;','&amp;#xe659;','&amp;#xe65a;','&amp;#xe65b;','&amp;#xe65c;','&amp;#xe65d;','&amp;#xe65e;','&amp;#xe65f;','&amp;#xe660;','&amp;#xe661;','&amp;#xe662;','&amp;#xe663;','&amp;#xe664;','&amp;#xe665;','&amp;#xe666;','&amp;#xe667;','&amp;#xe668;','&amp;#xe669;','&amp;#xe66a;','&amp;#xe66b;','&amp;#xe66c;','&amp;#xe66d;','&amp;#xe66e;','&amp;#xe66f;','&amp;#xe670;','&amp;#xe671;','&amp;#xe672;','&amp;#xe673;','&amp;#xe674;','&amp;#xe675;','&amp;#xe676;','&amp;#xe677;','&amp;#xe678;','&amp;#xe679;','&amp;#xe67a;','&amp;#xe67b;','&amp;#xe67c;','&amp;#xe67d;','&amp;#xe67e;','&amp;#xe67f;','&amp;#xe680;','&amp;#xe681;','&amp;#xe682;','&amp;#xe683;','&amp;#xe684;','&amp;#xe685;','&amp;#xe686;','&amp;#xe687;','&amp;#xe688;','&amp;#xe689;','&amp;#xe68a;','&amp;#xe68b;','&amp;#xe68c;','&amp;#xe68d;','&amp;#xe68e;','&amp;#xe68f;','&amp;#xe690;','&amp;#xe691;','&amp;#xe692;','&amp;#xe693;','&amp;#xe694;','&amp;#xe695;','&amp;#xe696;','&amp;#xe697;','&amp;#xe698;','&amp;#xe699;','&amp;#xe69a;','&amp;#xe69b;','&amp;#xe69c;','&amp;#xe69d;','&amp;#xe69e;','&amp;#xe69f;','&amp;#xe6a0;','&amp;#xe6a1;','&amp;#xe6a2;','&amp;#xe6a3;','&amp;#xe6a4;','&amp;#xe6a5;','&amp;#xe6a6;','&amp;#xe6a7;','&amp;#xe6a8;','&amp;#xe6a9;','&amp;#xe6aa;','&amp;#xe6ab;','&amp;#xe6ac;','&amp;#xe6ad;','&amp;#xe6ae;','&amp;#xe6af;','&amp;#xe6b0;','&amp;#xe6b1;','&amp;#xe6b2;','&amp;#xe6b3;','&amp;#xe6b4;','&amp;#xe6b5;','&amp;#xe6b6;','&amp;#xe6b7;','&amp;#xe6b8;','&amp;#xe6b9;','&amp;#xe6ba;','&amp;#xe6bb;','&amp;#xe6bc;','&amp;#xe6bd;','&amp;#xe6be;','&amp;#xe6bf;','&amp;#xe6c0;','&amp;#xe6c1;','&amp;#xe6c2;','&amp;#xe6c3;','&amp;#xe6c4;','&amp;#xe6c5;','&amp;#xe6c6;','&amp;#xe6c7;','&amp;#xe6c8;','&amp;#xe6c9;','&amp;#xe6ca;','&amp;#xe6cb;','&amp;#xe6cc;','&amp;#xe6cd;','&amp;#xe6ce;','&amp;#xe6cf;','&amp;#xe6d0;','&amp;#xe6d1;','&amp;#xe6d2;','&amp;#xe6d3;','&amp;#xe6d4;','&amp;#xe6d5;','&amp;#xe6d6;','&amp;#xe6d7;','&amp;#xe6d8;','&amp;#xe6d9;','&amp;#xe6da;','&amp;#xe6db;','&amp;#xe6dc;','&amp;#xe6dd;','&amp;#xe6de;','&amp;#xe6df;','&amp;#xe6e0;','&amp;#xe6e1;','&amp;#xe6e2;','&amp;#xe6e3;','&amp;#xe6e4;','&amp;#xe6e5;','&amp;#xe6e6;','&amp;#xe6e7;','&amp;#xe6e8;','&amp;#xe6e9;','&amp;#xe6ea;','&amp;#xe6eb;','&amp;#xe6ec;','&amp;#xe6ed;','&amp;#xe6ee;','&amp;#xe6ef;','&amp;#xe6f0;','&amp;#xe6f1;','&amp;#xe6f2;','&amp;#xe6f3;','&amp;#xe6f4;','&amp;#xe6f5;','&amp;#xe6f6;','&amp;#xe6f7;','&amp;#xe6f8;','&amp;#xe6f9;','&amp;#xe6fa;','&amp;#xe6fb;','&amp;#xe6fc;','&amp;#xe6fd;','&amp;#xe6fe;','&amp;#xe6ff;','&amp;#xe700;','&amp;#xe701;','&amp;#xe702;','&amp;#xe703;','&amp;#xe704;','&amp;#xe705;','&amp;#xe706;','&amp;#xe707;','&amp;#xe708;','&amp;#xe709;','&amp;#xe70a;','&amp;#xe70b;','&amp;#xe70c;','&amp;#xe70d;','&amp;#xe70e;','&amp;#xe70f;','&amp;#xe710;','&amp;#xe711;','&amp;#xe712;','&amp;#xe713;','&amp;#xe714;','&amp;#xe715;','&amp;#xe716;','&amp;#xe717;','&amp;#xe718;','&amp;#xe719;','&amp;#xe71a;','&amp;#xe71b;','&amp;#xe71c;','&amp;#xe71d;','&amp;#xe71e;','&amp;#xe71f;','&amp;#xe720;','&amp;#xe721;','&amp;#xe722;','&amp;#xe723;','&amp;#xe724;','&amp;#xe725;','&amp;#xe726;','&amp;#xe727;','&amp;#xe728;','&amp;#xe729;','&amp;#xe72a;','&amp;#xe72b;','&amp;#xe72c;','&amp;#xe72d;','&amp;#xe72e;','&amp;#xe72f;','&amp;#xe730;','&amp;#xe731;','&amp;#xe732;','&amp;#xe733;','&amp;#xe734;','&amp;#xe735;','&amp;#xe736;','&amp;#xe737;','&amp;#xe738;','&amp;#xe739;','&amp;#xe73a;','&amp;#xe73b;','&amp;#xe73c;','&amp;#xe73d;','&amp;#xe73e;','&amp;#xe73f;','&amp;#xe740;','&amp;#xe741;','&amp;#xe742;','&amp;#xe743;','&amp;#xe744;','&amp;#xe745;','&amp;#xe746;','&amp;#xe747;','&amp;#xe748;','&amp;#xe749;','&amp;#xe74a;','&amp;#xe74b;','&amp;#xe74c;','&amp;#xe74d;','&amp;#xe74e;','&amp;#xe74f;','&amp;#xe750;','&amp;#xe751;','&amp;#xe752;','&amp;#xe753;','&amp;#xe754;','&amp;#xe755;','&amp;#xe756;','&amp;#xe757;','&amp;#xe758;','&amp;#xe759;','&amp;#xe75a;','&amp;#xe75b;','&amp;#xe75c;','&amp;#xe75d;','&amp;#xe75e;','&amp;#xe75f;','&amp;#xe760;','&amp;#xe761;','&amp;#xe762;','&amp;#xe763;','&amp;#xe764;','&amp;#xe765;','&amp;#xe766;','&amp;#xe767;','&amp;#xe768;','&amp;#xe769;','&amp;#xe76a;','&amp;#xe76b;','&amp;#xe76c;','&amp;#xe76d;','&amp;#xe76e;','&amp;#xe76f;','&amp;#xe770;','&amp;#xe771;','&amp;#xe772;','&amp;#xe773;','&amp;#xe774;','&amp;#xe775;','&amp;#xe776;','&amp;#xe777;','&amp;#xe778;','&amp;#xe779;','&amp;#xe77a;','&amp;#xe77b;','&amp;#xe77c;','&amp;#xe77d;','&amp;#xe77e;','&amp;#xe77f;','&amp;#xe780;','&amp;#xe781;','&amp;#xe782;','&amp;#xe783;','&amp;#xe784;','&amp;#xe785;','&amp;#xe786;','&amp;#xe787;','&amp;#xe788;','&amp;#xe789;','&amp;#xe78a;','&amp;#xe78b;','&amp;#xe78c;','&amp;#xe78d;','&amp;#xe78e;','&amp;#xe78f;','&amp;#xe790;','&amp;#xe791;','&amp;#xe792;','&amp;#xe793;','&amp;#xe794;','&amp;#xe795;','&amp;#xe796;','&amp;#xe797;','&amp;#xe798;','&amp;#xe799;','&amp;#xe79a;','&amp;#xe79b;','&amp;#xe79c;','&amp;#xe79d;','&amp;#xe79e;','&amp;#xe79f;','&amp;#xe7a0;','&amp;#xe7a1;','&amp;#xe7a2;','&amp;#xe7a3;','&amp;#xe7a4;','&amp;#xe7a5;','&amp;#xe7a6;','&amp;#xe7a7;','&amp;#xe7a8;','&amp;#xe7a9;','&amp;#xe7aa;','&amp;#xe7ab;','&amp;#xe7ac;','&amp;#xe7ad;','&amp;#xe7ae;','&amp;#xe7af;','&amp;#xe7b0;','&amp;#xe7b1;','&amp;#xe7b2;','&amp;#xe7b3;','&amp;#xe7b4;','&amp;#xe7b5;','&amp;#xe7b6;','&amp;#xe7b7;','&amp;#xe7b8;','&amp;#xe7b9;','&amp;#xe7ba;','&amp;#xe7bb;','&amp;#xe7bc;','&amp;#xe7bd;','&amp;#xe7be;','&amp;#xe7bf;','&amp;#xe7c0;','&amp;#xe7c1;','&amp;#xe7c2;','&amp;#xe7c3;','&amp;#xe7c4;','&amp;#xe7c5;','&amp;#xe7c6;','&amp;#xe7c7;','&amp;#xe7c8;','&amp;#xe7c9;','&amp;#xe7ca;','&amp;#xe7cb;','&amp;#xe7cc;','&amp;#xe7cd;','&amp;#xe7ce;','&amp;#xe7cf;','&amp;#xe7d0;','&amp;#xe7d1;','&amp;#xe7d2;','&amp;#xe7d3;','&amp;#xe7d4;','&amp;#xe7d5;','&amp;#xe7d6;','&amp;#xe7d7;','&amp;#xe7d8;','&amp;#xe7d9;','&amp;#xe7da;','&amp;#xe7db;','&amp;#xe7dc;','&amp;#xe7dd;','&amp;#xe7de;','&amp;#xe7df;','&amp;#xe7e0;','&amp;#xe7e1;','&amp;#xe7e2;','&amp;#xe7e3;','&amp;#xe7e4;','&amp;#xe7e5;','&amp;#xe7e6;','&amp;#xe7e7;','&amp;#xe7e8;','&amp;#xe7e9;','&amp;#xe7ea;','&amp;#xe7eb;','&amp;#xe7ec;','&amp;#xe7ed;','&amp;#xe7ee;','&amp;#xe7ef;','&amp;#xe7f0;','&amp;#xe7f1;','&amp;#xe7f2;','&amp;#xe7f3;','&amp;#xe7f4;','&amp;#xe7f5;','&amp;#xe7f6;','&amp;#xe7f7;','&amp;#xe7f8;','&amp;#xe7f9;','&amp;#xe7fa;','&amp;#xe7fb;','&amp;#xe7fc;','&amp;#xe7fd;','&amp;#xe7fe;','&amp;#xe7ff;','&amp;#xe800;','&amp;#xe801;','&amp;#xe802;','&amp;#xe803;','&amp;#xe804;','&amp;#xe805;','&amp;#xe806;','&amp;#xe807;','&amp;#xe808;','&amp;#xe809;','&amp;#xe80a;','&amp;#xe80b;','&amp;#xe80c;','&amp;#xe80d;','&amp;#xe80e;','&amp;#xe80f;','&amp;#xe810;','&amp;#xe811;','&amp;#xe812;','&amp;#xe813;','&amp;#xe814;','&amp;#xe815;','&amp;#xe816;','&amp;#xe817;','&amp;#xe818;','&amp;#xe819;','&amp;#xe81a;','&amp;#xe81b;','&amp;#xe81c;','&amp;#xe81d;','&amp;#xe81e;','&amp;#xe81f;','&amp;#xe820;','&amp;#xe821;','&amp;#xe822;','&amp;#xe823;','&amp;#xe824;','&amp;#xe825;','&amp;#xe826;','&amp;#xe827;','&amp;#xe828;','&amp;#xe829;','&amp;#xe82a;','&amp;#xe82b;','&amp;#xe82c;','&amp;#xe82d;','&amp;#xe82e;','&amp;#xe82f;','&amp;#xe830;','&amp;#xe831;','&amp;#xe832;','&amp;#xe833;','&amp;#xe834;','&amp;#xe835;','&amp;#xe836;','&amp;#xe837;','&amp;#xe838;','&amp;#xe839;','&amp;#xe83a;','&amp;#xe83b;','&amp;#xe83c;','&amp;#xe83d;','&amp;#xe83e;','&amp;#xe83f;','&amp;#xe840;','&amp;#xe841;','&amp;#xe842;','&amp;#xe843;','&amp;#xe844;','&amp;#xe845;','&amp;#xe846;','&amp;#xe847;','&amp;#xe848;','&amp;#xe849;','&amp;#xe84a;','&amp;#xe84b;','&amp;#xe84c;','&amp;#xe84d;','&amp;#xe84e;','&amp;#xe84f;','&amp;#xe850;','&amp;#xe851;','&amp;#xe852;','&amp;#xe853;','&amp;#xe854;','&amp;#xe855;','&amp;#xe856;','&amp;#xe857;');

	return $symbols;
}
endif;

if ( ! function_exists( 'mhc_get_font_linearicons_icon_list' ) ) :
function mhc_get_font_linearicons_icon_list() {
	$output = is_customize_preview() ? mhc_get_font_linearicons_icon_list_items() : '<%= window.mh_composer.linearicons_icon_list_template() %>';

	$output = sprintf( '<ul class="mhc-icon linearicons">%1$s</ul>', $output );

	return $output;
}
endif;

if ( ! function_exists( 'mhc_get_font_linearicons_icon_list_items' ) ) :
function mhc_get_font_linearicons_icon_list_items() {
	$output = '';

	$symbols = mhc_font_linearicons_icon_symbols();

	foreach ( $symbols as $symbol ) {
		$output .= sprintf( '<li data-icon="%1$s"></li>', esc_attr( $symbol ) );
	}

	return $output;
}
endif;

if ( ! function_exists( 'mhc_font_linearicons_icon_list' ) ) :
function mhc_font_linearicons_icon_list() {
	echo mhc_get_font_linearicons_icon_list();
}
endif;

function mh_more_icons_css_head (){
if ('on' === (mh_get_option('mharty_use_steadysets', 'false'))){ 
	echo '<link id="steadysets-css" rel="stylesheet" href="' . MH_MORE_ICONS_URL .'assets/css/steadysets.css" type="text/css" media="all" />'; }
if ('on' === (mh_get_option('mharty_use_awesome', 'false'))){ 
	echo '<link id="fontawesome-css" rel="stylesheet" href="'. MH_MORE_ICONS_URL .'assets/css/fontawesome.css" type="text/css" media="all" />';  }
if ('on' === (mh_get_option('mharty_use_lineicons', 'false'))){ 
	echo '<link id="lineicons-css" rel="stylesheet" href="'. MH_MORE_ICONS_URL .'assets/css/lineicons.css" type="text/css" media="all" />';  }
if ('on' === (mh_get_option('mharty_use_etline', 'false'))){ 
	echo '<link id="etline-css" rel="stylesheet" href="'. MH_MORE_ICONS_URL .'assets/css/etline.css" type="text/css" media="all" />';  }

if ('on' === (mh_get_option('mharty_use_icomoon', 'false'))){ 
	echo '<link id="icomoon-css" rel="stylesheet" href="'. MH_MORE_ICONS_URL .'assets/css/icomoon.css" type="text/css" media="all" />';  }

if ('on' === (mh_get_option('mharty_use_linearicons', 'false'))){ 
	echo '<link id="linearicons-css" rel="stylesheet" href="'. MH_MORE_ICONS_URL .'assets/css/linearicons.css" type="text/css" media="all" />';  }
}
add_action('wp_head','mh_more_icons_css_head',13);

function mh_more_icons_append_options($options) {
	$append_options = array(
	
		array( "name" => "wrap-mhmoreicons",
			"type" => "contenttab-wrapstart",),
	
		array( "type" => "subnavtab-start",),
	
		array( "name" => "mhmoreicons-1",
			   "type" => "subnav-tab",
			   "desc" => esc_html__("More Icons", "mh-more-icons")
		),
		array( "type" => "subnavtab-end",),

		array( "name" => "mhmoreicons-1",
			   "type" => "subcontent-start",),	
  
		array(  "name" => "steadysets",
				"type" => "iconpreview",
				"desc" => esc_html__("Steadysets (140)", "mh-more-icons"),
				"function_name" => 'mhc_get_font_steadysets_icon_list_items',
		),
		
		array( "name" => esc_html__("Use", "mh-more-icons") . ' Steadysets',
			   "id" => "mharty_use_steadysets",
			   "type" => "checkbox",
			   "std" => "false",
			   "desc" => esc_html__("Enable this icon font to use it within the Page Composer Modules. Icon fonts consist of lightweight files, however, only enable the ones you need.", "mh-more-icons"),
		),
		
		array( "name" => "awesome",
			   "type" => "iconpreview",
			   "desc" => esc_html__("FontAwesome (479)", "mh-more-icons"),
			   "function_name" => 'mhc_get_font_awesome_icon_list_items',
		),
		
		array( "name" => esc_html__("Use", "mh-more-icons") . ' FontAwesome',
			   "id" => "mharty_use_awesome",
			   "type" => "checkbox",
			   "std" => "false",
			   "desc" => esc_html__("Enable this icon font to use it within the Page Composer Modules. Icon fonts consist of lightweight files, however, only enable the ones you need.", "mh-more-icons"),
		),
	
		array( "name" => "lineicons",
			   "type" => "iconpreview",
			   "desc" => esc_html__("Linecons (48)", "mh-more-icons"),
			   "function_name" => 'mhc_get_font_lineicons_icon_list_items',
		),
		
		array( "name" => esc_html__("Use", "mh-more-icons") . ' Linecons',
			   "id" => "mharty_use_lineicons",
			   "type" => "checkbox",
			   "std" => "false",
			   "desc" => esc_html__("Enable this icon font to use it within the Page Composer Modules. Icon fonts consist of lightweight files, however, only enable the ones you need.", "mh-more-icons"),
		),
		
 
		array( "name" => "etline",
			   "type" => "iconpreview",
			   "desc" => esc_html__("ETlineicons (99)", "mh-more-icons"),
			   "function_name" => 'mhc_get_font_etline_icon_list_items',
		),
		
		array( "name" => esc_html__("Use", "mh-more-icons") . ' ETlineicons',
			   "id" => "mharty_use_etline",
			   "type" => "checkbox",
			   "std" => "false",
			   "desc" => esc_html__("Enable this icon font to use it within the Page Composer Modules. Icon fonts consist of lightweight files, however, only enable the ones you need.", "mh-more-icons"),
		),
		
		array( "name" => "icomoon",
			   "type" => "iconpreview",
			   "desc" => esc_html__("IcoMoon (451)", "mh-more-icons"),
			   "function_name" => 'mhc_get_font_icomoon_icon_list_items',
		),
		
		array( "name" => esc_html__("Use", "mh-more-icons") . ' IcoMoon',
			   "id" => "mharty_use_icomoon",
			   "type" => "checkbox",
			   "std" => "false",
			   "desc" => esc_html__("Enable this icon font to use it within the Page Composer Modules. Icon fonts consist of lightweight files, however, only enable the ones you need.", "mh-more-icons"),  
		),
			
		array( "name" => "linearicons",
			   "type" => "iconpreview",
			   "desc" => esc_html__("Linearicons (600)", "mh-more-icons"),
			   "function_name" => 'mhc_get_font_linearicons_icon_list_items',
		),
		
		array( "name" => esc_html__("Use", "mh-more-icons") . ' Linearicons',
			   "id" => "mharty_use_linearicons",
			   "type" => "checkbox",
			   "std" => "false",
			   "desc" => esc_html__("Enable this icon font to use it within the Page Composer Modules. Icon fonts consist of lightweight files, however, only enable the ones you need.", "mh-more-icons"),
		),
		
		array( "name" => "mhmoreicons-1",
			"type" => "subcontent-end",),

		array( "name" => "wrap-mhmoreicons",
		   "type" => "contenttab-wrapend",),
			   
	);
	// now merge the two arrays!
	$options = array_merge($options, $append_options);
 
	return $options;
}
add_filter('mh_defined_options', 'mh_more_icons_append_options', 13);


// append tab to mharty panel
function mh_more_icons_append_tab($mh_panelMainTabs){
	$append_tab = array('mhmoreicons');
	$mh_panelMainTabs = array_merge($mh_panelMainTabs, $append_tab);
	return $mh_panelMainTabs;
}
add_filter('mh_panel_page_maintabs', 'mh_more_icons_append_tab', 13);

// append title to mharty panel
function mh_more_icons_append_list(){?>
	<li id="mh-nav-mhmoreicons"><a href="#wrap-mhmoreicons"><i class="mh-panel-nav-icon"></i><?php esc_html_e( "More Icons", "mh-more-icons" ); ?></a></li>
<?php }
add_action('mh_panel_render_maintabs', 'mh_more_icons_append_list', 13);