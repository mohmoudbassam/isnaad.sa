<?php
if ( ! function_exists( 'mharty_mh_theme_icons_admin_scripts' ) ) {
	function mharty_mh_theme_icons_admin_scripts( $hook ) {
		$ltr = is_rtl() ? "" : "-ltr";
		wp_enqueue_style( 'mh_menu_icons_style', get_template_directory_uri() . '/includes/mh_menu/css/style'. $ltr .'.min.css', array(), mh_get_theme_version() );
	}
}

if ( ! function_exists( 'mharty_mh_theme_icons_hook_scripts' ) ) {
	function mharty_mh_theme_icons_hook_scripts() {
		add_action( 'admin_enqueue_scripts', 'mharty_mh_theme_icons_admin_scripts' );
	}
}

if ( ! function_exists( 'mh_theme_icons_page' ) ) {
	function mh_theme_icons_page() { ?>

<div class="mh_menu_icons_main_container">
  <div class ="mh_menu_icons_header">
    <h1 class="mh_menu_icons_title">
      <?php _e( 'Mharty Theme Icons index', 'mharty' ); ?>
    </h1>
  </div>
  <div class="mh_menu_icons_all">
    <p class="mh_menu_icons_notice">
      <?php _e( 'Copy and paste the icon code in the specified field (Menu Item Icon)', 'mharty' ); ?>
    </p>
    <div class="clearfix mhl ptl">
	<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e600" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-mobile"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e601" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-mouse"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e602" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-directions"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e603" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-mail"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e604" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-paperplane"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e605" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-pencil"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e606" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-feather"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e607" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-paperclip"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e608" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-drawer"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e609" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-reply"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e60a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-reply-all"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e60b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-forward"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e60c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-user"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e60d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-users"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e60e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-user-add"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e60f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-vcard"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e610" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-export"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e611" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-location"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e612" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-map"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e613" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-compass"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e614" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-location2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e615" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-target"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e616" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-share"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e617" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-sharable"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e618" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-heart"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e619" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-heart2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e61a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-star"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e61b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-star2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e61c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-thumbsup"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e61d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-thumbsdown"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e61e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-chat"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e61f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-comment"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e620" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-quote"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e621" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-house"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e622" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-popup"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e623" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-search"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e624" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flashlight"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e625" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-printer"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e626" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-bell"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e627" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-link"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e628" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flag"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e629" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cog"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e62a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tools"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e62b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-trophy"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e62c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tag"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e62d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-camera"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e62e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-megaphone"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e62f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-moon"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e630" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-palette"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e631" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-leaf"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e632" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-music"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e633" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-music2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e634" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-new"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e635" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-graduation"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e636" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-book"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e637" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-newspaper"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e638" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-bag"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e639" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-airplane"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e63a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-lifebuoy"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e63b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-eye"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e63c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-clock"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e63d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-microphone"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e63e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-calendar2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e63f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-bolt"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e640" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-thunder"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e641" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-droplet"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e642" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cd"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e643" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-briefcase"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e644" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-air"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e645" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-hourglass"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e646" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-gauge"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e647" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-language"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e648" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-network"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e649" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-key"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e64a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-battery"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e64b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-bucket"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e64c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-magnet"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e64d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-drive"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e64e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cup"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e64f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-rocket"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e650" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-brush"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e651" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-suitcase"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e652" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cone"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e653" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-earth"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e654" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-keyboard"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e655" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-browser"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e656" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-publish"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e657" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-progress-3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e658" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-progress-2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e659" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-brogress-1"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e65a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-progress-0"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e65b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-sun"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e65c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-sun2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e65d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-adjust"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e65e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-code"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e65f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-screen"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e660" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-infinity"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e661" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-light-bulb"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e662" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-creditcard"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e663" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-database"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e664" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-voicemail"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e665" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-clipboard"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e666" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e667" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-box"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e668" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-ticket"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e669" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-rss"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e66a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-signal"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e66b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-thermometer"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e66c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-droplets"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e66d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uniE66E"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e66e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-statistics"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e66f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-pie"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e670" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-bars"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e671" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-graph"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e672" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-lock"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e673" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-lock-open"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e674" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-logout"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e675" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-login"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e676" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-checkmark"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e677" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cross"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e678" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-minus"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e679" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-plus"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e67a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cross2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e67b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-minus2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e67c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-plus2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e67d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cross3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e67e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-minus3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e67f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-plus3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e680" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-erase"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e681" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-blocked"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e682" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-info"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e683" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-info2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e684" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-question"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e685" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-help"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e686" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-warning"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e687" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cycle"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e688" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cw"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e689" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-ccw"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e68a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-shuffle"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e68b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e68c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e68d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-retweet"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e68e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-loop"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e68f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-history"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e690" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-back"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e691" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-switch"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e692" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-list"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e693" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-add-to-list"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e694" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-layout"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e695" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-list2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e696" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-text"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e697" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-text2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e698" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-document"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e699" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-docs"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e69a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-landscape"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e69b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-pictures"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e69c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-video"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e69d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-music3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e69e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-folder"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e69f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-archive"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6a0" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-trash"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6a1" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-upload"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6a2" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-download"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6a3" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-disk"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6a4" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-install"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6a5" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cloud"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6a6" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-upload2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6a7" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-bookmark"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6a8" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-bookmarks"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6a9" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-book2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6aa" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-play"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ab" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-pause"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ac" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-record"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ad" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-stop"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ae" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-next"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6af" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-previous"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6b0" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-first"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6b1" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-last"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6b2" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-resize-enlarge"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6b3" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-resize-shrink"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6b4" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-volume"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6b5" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-sound"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6b6" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-mute"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6b7" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flow-cascade"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6b8" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flow-branch"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6b9" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flow-tree"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ba" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flow-line"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6bb" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flow-parallel"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6bc" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-left"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6bd" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-down"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6be" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-up-upload"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6bf" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-right"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6c0" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-left2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6c1" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-down2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6c2" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-up"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6c3" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-right2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6c4" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-left3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6c5" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-down3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6c6" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-up2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6c7" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-right3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6c8" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-left4"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6c9" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-down4"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ca" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-up3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6cb" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-right4"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6cc" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-left5"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6cd" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-down5"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ce" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-up4"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6cf" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-right5"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6d0" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-left6"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6d1" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-down6"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6d2" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-up5"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6d3" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-right6"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6d4" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-left7"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6d5" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-down7"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6d6" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-up6"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6d7" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uniE6D8"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6d8" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-left8"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6d9" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-down8"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6da" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-up7"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6db" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-arrow-right7"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6dc" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-menu"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6dd" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-ellipsis"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6de" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-dots"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6df" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-dot"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6e0" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6e1" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc-by"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6e2" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc-nc"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6e3" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc-nc-eu"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6e4" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc-nc-jp"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6e5" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc-sa"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6e6" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc-nd"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6e7" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc-pd"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6e8" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc-zero"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6e9" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc-share"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ea" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cc-share2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6eb" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-danielbruce"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ec" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-danielbruce2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ed" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-github"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ee" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-github2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ef" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flickr"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6f0" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flickr2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6f1" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-vimeo"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6f2" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-vimeo2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6f3" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-twitter"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6f4" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-twitter2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6f5" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-facebook"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6f6" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-facebook2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6f7" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-facebook3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6f8" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-googleplus"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6f9" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-googleplus2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6fa" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-pinterest"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6fb" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-pinterest2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6fc" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tumblr"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6fd" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tumblr2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6fe" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-linkedin"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e6ff" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-linkedin2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e700" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-dribbble"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e701" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-dribbble2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e702" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-stumbleupon"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e703" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-stumbleupon2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e704" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-lastfm"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e705" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-lastfm2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e706" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-rdio"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e707" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-rdio2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e708" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-spotify"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e709" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-spotify2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e70a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-qq"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e70b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-instagram"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e70c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-dropbox"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e70d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-evernote"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e70e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flattr"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e70f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-skype"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e710" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-skype2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e711" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-renren"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e712" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-sina-weibo"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e713" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-paypal"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e714" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-picasa"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e715" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-soundcloud"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e716" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-mixi"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e717" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-behance"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e718" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-circles"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e719" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-vk"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e71a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-smashing"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e71b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-vine"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e71c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-youtube"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e71d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-google-drive"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e71e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni24"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e71f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni25"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e720" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni26"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e721" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni27"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e722" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni28"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e723" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni29"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e724" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni2A"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e725" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni2B"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e726" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni2C"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e727" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni2D"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e728" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e729" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni2F"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e72a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni30"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e72b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni32"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e72c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni33"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e72d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni34"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e72e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni35"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e72f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni36"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e730" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni37"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e731" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni38"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e732" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni39"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e733" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni3A"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e734" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni3B"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e735" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni3C"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e736" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni3D"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e737" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni3E"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e738" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni3F"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e739" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni40"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e73a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni41"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e73b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni42"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e73c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni43"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e73d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni44"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e73e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni45"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e73f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni46"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e740" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni47"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e741" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni48"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e742" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni49"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e743" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni4A"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e744" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni4B"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e745" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni4C"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e746" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni4D"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e747" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni4E"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e748" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni4F"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e749" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni51"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e74a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni52"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e74b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni53"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e74c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-uni54"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e74d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cog2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e74e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-heart3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e74f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-search2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e750" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-box2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e751" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tag2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e752" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-grid-2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e753" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-help2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e754" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flag2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e755" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone-alt"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e756" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-search-alt"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e757" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-printfriendly"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e758" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-buffer"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e759" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-mixlr"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e75a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-periscope"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e75b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-younow"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e75c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-whatsapp"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e75d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-app-store"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e75e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-windows-store"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e75f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-google-play"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e760" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-google"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e761" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-baidu"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e762" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flattr2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e763" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-foursquare"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e764" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-icloud"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e765" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-email"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e766" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-mail-with-circle"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e767" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-medium"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e768" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-onedrive"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e769" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-snapchat-square"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e76a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-snapchat-ghost"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e76b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-snapchat"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e76c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-wallet"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e76d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-clapperboard"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e76e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-round-brush"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e76f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-blackboard"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e770" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-laptop"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e771" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tablet-mobile-combo"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e772" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tablet"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e773" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-fingerprint"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e774" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-hand"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e775" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flower"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e776" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tree"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e777" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-emoji-sad"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e778" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-emoji-neutral"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e779" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-emoji-happy"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e77a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-emoji-flirt"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e77b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tripadvisor"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e77c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flag22"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e77d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="flag2, report2" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-at-sign"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e77e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="at-sign, mail" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-envelope"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e77f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="envelope, mail2" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-envelope-open"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e780" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="envelope-open, mail3" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-telephone"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e781" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="telephone, phone" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-telephone4"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e782" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-telephone2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e783" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="telephone2, phone12" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-map-marker"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e784" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="map-marker, pin3" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-calendar-full"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e785" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="calendar-full, calendar5" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-smartphone"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e786" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="smartphone, mobile2" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tablet2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e787" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="tablet, mobile7" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-tablet22"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e788" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="tablet2, mobile8" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e789" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="phone13, mobile" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-map2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e78a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="map, guide2" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-calendar-empty"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e78b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="calendar-empty, calendar" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-flag3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e78c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="flag, mark" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-at-sign2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e78d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="at-sign, mail" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-calendar"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e78e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="calendar, date" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-envelope2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e78f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="envelope, mail2" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-envelope-open3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e790" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="envelope-open, mail3" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-smartphone2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e791" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="smartphone2, phone23" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-smartphone3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e792" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="smartphone, phone22" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-road-sign"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e793" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="road-sign, navigation6" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-map-marker2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e794" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="map-marker, pin4" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-sun3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e795" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="sun, day" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-telephone3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e796" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="telephone, phone" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-telephone5"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e797" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-sun-o"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e798" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-calendar-o"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e799" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-calendar3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e79a" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-square"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e79b" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-envelope-square"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e79c" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone-square"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e79d" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone-square2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e79e" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-envelope3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e79f" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-mobile2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7a0" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-brightness_low"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7a1" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-moon2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7a2" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-moon3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7a3" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-date_range"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7a4" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-mail_outline"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7a5" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-mobile3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7a6" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone5"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7a7" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="call, local_phone, phone" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone6"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7a8" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone_msg"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7a9" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone_msg2"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7aa" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-sun4"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7ab" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-calendar4"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7ac" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-envelope4"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7ad" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone3"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7ae" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone4"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7af" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-phone7"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7b0" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>	
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart-alt-01"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7b1" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart-alt-02"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7b2" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart-alt-03"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7b3" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart-alt-04"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7b4" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart-alt-05"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7b5" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart-alt-06"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7b6" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart-alt-07"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7b7" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart-alt-08"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7b8" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>
<div class="glyph fs1">
  <div class="clearfix bshadow0 pbs"> <span class="mhicons-icon-cart-alt-09"> </span> </div>
  <fieldset class="fs0 size1of1 clearfix hidden-false">
    <input type="text" readonly value="e7b9" class="unit size1of2" />
  </fieldset>
  <div class="fs0 bshadow0 clearfix hidden-true"> <span class="unit pvs fgc1">liga: </span>
    <input type="text" readonly value="" class="liga unitRight" />
  </div>
</div>		

    </div>
  </div>
  <!--mh_menu_icons_all--> 
</div>
<!--mh_menu_icons_main_container-->
<?php }
}
