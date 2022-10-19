<?php
// exclude preset layouts from import
function mh_remove_preset_layouts_from_import( $posts ) {
	$processed_posts = $posts;

	if ( isset( $posts ) && is_array( $posts ) ) {
		$processed_posts = array();

		foreach ( $posts as $post ) {
			if ( isset( $post['postmeta'] ) && is_array( $post['postmeta'] ) ) {
				foreach ( $post['postmeta'] as $meta ) {
					if ( '_mhc_preset_layout' === $meta['key'] && 'on' === $meta['value'] )
						continue 2;
				}
			}

			$processed_posts[] = $post;
		}
	}

	return $processed_posts;
}
add_filter( 'wp_import_posts', 'mh_remove_preset_layouts_from_import', 5 );

// set the layout_type taxonomy to "layout" for layouts imported from old version of mharty.
function mh_update_old_layouts_taxonomy( $posts ) {
	$processed_posts = $posts;

	if ( isset( $posts ) && is_array( $posts ) ) {
		$processed_posts = array();

		foreach ( $posts as $post ) {
			$update_built_for_post_type = false;

			if ( 'mhc_layout' === $post['post_type'] ) {
				if ( ! isset( $post['terms'] ) ) {
					$post['terms'][] = array(
						'name'   => 'layout',
						'slug'   => 'layout',
						'domain' => 'layout_type'
					);
					$post['terms'][] = array(
						'name'   => 'not_shared',
						'slug'   => 'not_shared',
						'domain' => 'scope'
					);
				}
				
				$update_built_for_post_type = true;
				
				// check whether _mhc_built_for_post_type custom field exists
				if ( ! empty( $post['postmeta'] ) ) {
					foreach ( $post['postmeta'] as $index => $value ) {
						if ( '_mhc_built_for_post_type' === $value['key'] ) {
							$update_built_for_post_type = false;
						}
					}
				}
			}

			// set _mhc_built_for_post_type value to 'page' if not exists
			if ( $update_built_for_post_type ) {
				$post['postmeta'][] = array(
					'key'   => '_mhc_built_for_post_type',
					'value' => 'page',
				);
			}

			$processed_posts[] = $post;
		}
	}

	return $processed_posts;
}
add_filter( 'wp_import_posts', 'mh_update_old_layouts_taxonomy', 10 );

// add custom filters for posts in the Composer Vault
if ( ! function_exists( 'mhc_add_layout_filters' ) ) :
function mhc_add_layout_filters() {
	if ( isset( $_GET['post_type'] ) && 'mhc_layout' === $_GET['post_type'] ) {
		$layout_categories = get_terms( 'layout_category' );
		$filter_category = array();
		$filter_category[''] = esc_html__( 'All Categories', 'mh-composer' );

		if ( is_array( $layout_categories ) && ! empty( $layout_categories ) ) {
			foreach( $layout_categories as $category ) {
				$filter_category[$category->slug] = $category->name;
			}
		}

		$filter_layout_type = array(
			''        => esc_html__( 'All Layouts', 'mh-composer' ),
			'module'  => esc_html__( 'Components', 'mh-composer' ),
			'row'     => esc_html__( 'Rows', 'mh-composer' ),
			'section' => esc_html__( 'Sections', 'mh-composer' ),
			'layout'  => esc_html__( 'Layouts', 'mh-composer' ),
		);

		$filter_scope = array(
			''           => esc_html__( 'Shared/not Shared', 'mh-composer' ),
			'shared'     => esc_html__( 'Shared', 'mh-composer' ),
			'not_shared' => esc_html__( 'not Shared', 'mh-composer' )
		);
		?>

		<select name="layout_type">
		<?php
			$selected = isset( $_GET['layout_type'] ) ? $_GET['layout_type'] : '';
			foreach ( $filter_layout_type as $value => $label ) {
				printf( '<option value="%1$s"%2$s>%3$s</option>',
					esc_attr( $value ),
					$value == $selected ? ' selected="selected"' : '',
					esc_html( $label )
				);
			} ?>
		</select>

		<select name="scope">
		<?php
			$selected = isset( $_GET['scope'] ) ? $_GET['scope'] : '';
			foreach ( $filter_scope as $value => $label ) {
				printf( '<option value="%1$s"%2$s>%3$s</option>',
					esc_attr( $value ),
					$value == $selected ? ' selected="selected"' : '',
					esc_html( $label )
				);
			} ?>
		</select>

		<select name="layout_category">
		<?php
			$selected = isset( $_GET['layout_category'] ) ? $_GET['layout_category'] : '';
			foreach ( $filter_category as $value => $label ) {
				printf( '<option value="%1$s"%2$s>%3$s</option>',
					esc_attr( $value ),
					$value == $selected ? ' selected="selected"' : '',
					esc_html( $label )
				);
			} ?>
		</select>
	<?php
	}
}
endif;
add_action( 'restrict_manage_posts', 'mhc_add_layout_filters' );

 //Add "Export Layouts" button to the Composer Vault page
if ( ! function_exists( 'mhc_load_manage_vault_cats' ) ) :
function mhc_load_manage_vault_cats(){
	$current_screen = get_current_screen();

	if ( 'edit-mhc_layout' === $current_screen->id ) {
		// display wp error screen if vault is disabled for current user
		if ( ! mhc_permitted( 'mharty_vault' ) || ! mhc_permitted( 'add_vault' ) || ! mhc_permitted( 'save_vault' ) ) {
			wp_die( esc_html__( "you don't have sufficient permissions to access this page", 'mh-composer' ) );
		}

		add_action( 'all_admin_notices', 'mhc_vault_tools' );
	}
}
endif;
add_action( 'load-edit.php', 'mhc_load_manage_vault_cats' );

// Check whether the vault editor page should be displayed or not
function mhc_check_vault_permissions(){
	$current_screen = get_current_screen();

	if ( 'mhc_layout' === $current_screen->id && ( ! mhc_permitted( 'mharty_vault' ) || ! mhc_permitted( 'save_vault' ) ) ) {
		// display wp error screen if vault is disabled for current user
		wp_die( esc_html__( "you don't have sufficient permissions to access this page", 'mh-composer' ) );
	}
}
add_action( 'load-post.php', 'mhc_check_vault_permissions' );

// exclude premade layouts from the list of all templates in the vault.
if ( ! function_exists( 'exclude_premade_layouts_vault' ) ) :
function exclude_premade_layouts_vault( $query ) {
	global $pagenow;
	$current_post_type = get_query_var( 'post_type' );

	if ( is_admin() && 'edit.php' === $pagenow && $current_post_type && 'mhc_layout' === $current_post_type ) {
		$meta_query = array(
			array(
				'key'     => '_mhc_preset_layout',
				'value'   => 'on',
				'compare' => 'NOT EXISTS',
			),
		);
		
		$used_built_for_post_types = mhc_get_used_built_for_post_types();
		if ( isset( $_GET['built_for'] ) && count( $used_built_for_post_types ) > 1 ) {
			$built_for_post_type = sanitize_text_field( $_GET['built_for'] );
			// get array of all standard post types if built_for is one of them
			$built_for_post_type_processed = in_array( $built_for_post_type, mhc_get_standard_post_types() ) ? mhc_get_standard_post_types() : $built_for_post_type;

			if ( in_array( $built_for_post_type, $used_built_for_post_types ) ) {
				$meta_query[] = array(
					'key'     => '_mhc_built_for_post_type',
					'value'   => $built_for_post_type_processed,
					'compare' => 'IN',
				);
			}
		}
		
		$query->set( 'meta_query', $meta_query );
	}

	return $query;
}
endif;
add_action( 'pre_get_posts', 'exclude_premade_layouts_vault' );

if ( ! function_exists( 'exclude_premade_layouts_vault_count' ) ) :
/**
 * Post count for "mine" in post table relies to fixed value set by WP_Posts_List_Table->user_posts_count
 * Thus, exclude_premade_layouts_vault() action doesn't automatically exclude premade layout and
 * it has to be late filtered via this exclude_premade_layouts_vault_count()
 *
 * @see WP_Posts_List_Table->user_posts_count to see how mine post value is retrieved
 *
 * @param array
 * @return array
 */
function exclude_premade_layouts_vault_count( $views ) {
	if ( isset( $views['mine'] ) ) {
		$current_user_id = get_current_user_id();

		if ( isset( $_GET['author'] ) && ( $_GET['author'] == $current_user_id ) ) {
			$class = 'current';

			// Reuse current $wp_query global
			global $wp_query;

			$mine_posts_count = $wp_query->found_posts;
		} else {
			$class = '';

			// Use WP_Query instead of plain MySQL SELECT because the custom field filtering uses
			// GROUP BY which needs FOUND_ROWS() and this has been automatically handled by WP_Query
			$query = new WP_Query( array(
				'post_type'  => 'mhc_layout',
				'author'     => $current_user_id,
				'meta_query' => array(
					'key'     => '_mhc_preset_layout',
					'value'   => 'on',
					'compare' => 'NOT EXISTS',
				),
			) );

			$mine_posts_count = $query->found_posts;
		}

		$url = add_query_arg(
			array(
				'post_type' => 'mhc_layout',
				'author'    => $current_user_id,
			),
			'edit.php'
		);

		$views['mine'] = sprintf(
			'<a href="%1$s" class="%2$s">%3$s <span class="count">(%4$s)</span></a>',
			esc_url( $url ),
			esc_attr( $class ),
			esc_html__( 'Mine', 'mh-composer' ),
			esc_html( intval( $mine_posts_count ) )
		);
	}

	return $views;
}
endif;
add_filter( 'views_edit-mhc_layout', 'exclude_premade_layouts_vault_count' );

if ( ! function_exists( 'mhc_font_mhicons_icon_symbols' ) ) :
function mhc_font_mhicons_icon_symbols() {
	$symbols = array( '&amp;#xe600;','&amp;#xe601;','&amp;#xe602;','&amp;#xe603;','&amp;#xe604;','&amp;#xe605;','&amp;#xe606;','&amp;#xe607;','&amp;#xe608;','&amp;#xe609;','&amp;#xe60a;','&amp;#xe60b;','&amp;#xe60c;','&amp;#xe60d;','&amp;#xe60e;','&amp;#xe60f;','&amp;#xe610;','&amp;#xe611;','&amp;#xe612;','&amp;#xe613;','&amp;#xe614;','&amp;#xe615;','&amp;#xe616;','&amp;#xe617;','&amp;#xe618;','&amp;#xe619;','&amp;#xe61a;','&amp;#xe61b;','&amp;#xe61c;','&amp;#xe61d;','&amp;#xe61e;','&amp;#xe61f;','&amp;#xe620;','&amp;#xe621;','&amp;#xe622;','&amp;#xe623;','&amp;#xe624;','&amp;#xe625;','&amp;#xe626;','&amp;#xe627;','&amp;#xe628;','&amp;#xe629;','&amp;#xe62a;','&amp;#xe62b;','&amp;#xe62c;','&amp;#xe62d;','&amp;#xe62e;','&amp;#xe62f;','&amp;#xe630;','&amp;#xe631;','&amp;#xe632;','&amp;#xe633;','&amp;#xe634;','&amp;#xe635;','&amp;#xe636;','&amp;#xe637;','&amp;#xe638;','&amp;#xe639;','&amp;#xe63a;','&amp;#xe63b;','&amp;#xe63c;','&amp;#xe63d;','&amp;#xe63e;','&amp;#xe63f;','&amp;#xe640;','&amp;#xe641;','&amp;#xe642;','&amp;#xe643;','&amp;#xe644;','&amp;#xe645;','&amp;#xe646;','&amp;#xe647;','&amp;#xe648;','&amp;#xe649;','&amp;#xe64a;','&amp;#xe64b;','&amp;#xe64c;','&amp;#xe64d;','&amp;#xe64e;','&amp;#xe64f;','&amp;#xe650;','&amp;#xe651;','&amp;#xe652;','&amp;#xe653;','&amp;#xe654;','&amp;#xe655;','&amp;#xe656;','&amp;#xe657;','&amp;#xe658;','&amp;#xe659;','&amp;#xe65a;','&amp;#xe65b;','&amp;#xe65c;','&amp;#xe65d;','&amp;#xe65e;','&amp;#xe65f;','&amp;#xe660;','&amp;#xe661;','&amp;#xe662;','&amp;#xe663;','&amp;#xe664;','&amp;#xe665;','&amp;#xe666;','&amp;#xe667;','&amp;#xe668;','&amp;#xe669;','&amp;#xe66a;','&amp;#xe66b;','&amp;#xe66c;','&amp;#xe66d;','&amp;#xe66e;','&amp;#xe66f;','&amp;#xe670;','&amp;#xe671;','&amp;#xe672;','&amp;#xe673;','&amp;#xe674;','&amp;#xe675;','&amp;#xe676;','&amp;#xe677;','&amp;#xe678;','&amp;#xe679;','&amp;#xe67a;','&amp;#xe67b;','&amp;#xe67c;','&amp;#xe67d;','&amp;#xe67e;','&amp;#xe67f;','&amp;#xe680;','&amp;#xe681;','&amp;#xe682;','&amp;#xe683;','&amp;#xe684;','&amp;#xe685;','&amp;#xe686;','&amp;#xe687;','&amp;#xe688;','&amp;#xe689;','&amp;#xe68a;','&amp;#xe68b;','&amp;#xe68c;','&amp;#xe68d;','&amp;#xe68e;','&amp;#xe68f;','&amp;#xe690;','&amp;#xe691;','&amp;#xe692;','&amp;#xe693;','&amp;#xe694;','&amp;#xe695;','&amp;#xe696;','&amp;#xe697;','&amp;#xe698;','&amp;#xe699;','&amp;#xe69a;','&amp;#xe69b;','&amp;#xe69c;','&amp;#xe69d;','&amp;#xe69e;','&amp;#xe69f;','&amp;#xe6a0;','&amp;#xe6a1;','&amp;#xe6a2;','&amp;#xe6a3;','&amp;#xe6a4;','&amp;#xe6a5;','&amp;#xe6a6;','&amp;#xe6a7;','&amp;#xe6a8;','&amp;#xe6a9;','&amp;#xe6aa;','&amp;#xe6ab;','&amp;#xe6ac;','&amp;#xe6ad;','&amp;#xe6ae;','&amp;#xe6af;','&amp;#xe6b0;','&amp;#xe6b1;','&amp;#xe6b2;','&amp;#xe6b3;','&amp;#xe6b4;','&amp;#xe6b5;','&amp;#xe6b6;','&amp;#xe6b7;','&amp;#xe6b8;','&amp;#xe6b9;','&amp;#xe6ba;','&amp;#xe6bb;','&amp;#xe6bc;','&amp;#xe6bd;','&amp;#xe6be;','&amp;#xe6bf;','&amp;#xe6c0;','&amp;#xe6c1;','&amp;#xe6c2;','&amp;#xe6c3;','&amp;#xe6c4;','&amp;#xe6c5;','&amp;#xe6c6;','&amp;#xe6c7;','&amp;#xe6c8;','&amp;#xe6c9;','&amp;#xe6ca;','&amp;#xe6cb;','&amp;#xe6cc;','&amp;#xe6cd;','&amp;#xe6ce;','&amp;#xe6cf;','&amp;#xe6d0;','&amp;#xe6d1;','&amp;#xe6d2;','&amp;#xe6d3;','&amp;#xe6d4;','&amp;#xe6d5;','&amp;#xe6d6;','&amp;#xe6d7;','&amp;#xe6d8;','&amp;#xe6d9;','&amp;#xe6da;','&amp;#xe6db;','&amp;#xe6dc;','&amp;#xe6dd;','&amp;#xe6de;','&amp;#xe6df;','&amp;#xe6e0;','&amp;#xe6e1;','&amp;#xe6e2;','&amp;#xe6e3;','&amp;#xe6e4;','&amp;#xe6e5;','&amp;#xe6e6;','&amp;#xe6e7;','&amp;#xe6e8;','&amp;#xe6e9;','&amp;#xe6ea;','&amp;#xe6eb;','&amp;#xe6ec;','&amp;#xe6ed;','&amp;#xe6ee;','&amp;#xe6ef;','&amp;#xe6f0;','&amp;#xe6f1;','&amp;#xe6f2;','&amp;#xe6f3;','&amp;#xe6f4;','&amp;#xe6f5;','&amp;#xe6f6;','&amp;#xe6f7;','&amp;#xe6f8;','&amp;#xe6f9;','&amp;#xe6fa;','&amp;#xe6fb;','&amp;#xe6fc;','&amp;#xe6fd;','&amp;#xe6fe;','&amp;#xe6ff;','&amp;#xe700;','&amp;#xe701;','&amp;#xe702;','&amp;#xe703;','&amp;#xe704;','&amp;#xe705;','&amp;#xe706;','&amp;#xe707;','&amp;#xe708;','&amp;#xe709;','&amp;#xe70a;','&amp;#xe70b;','&amp;#xe70c;','&amp;#xe70d;','&amp;#xe70e;','&amp;#xe70f;','&amp;#xe710;','&amp;#xe711;','&amp;#xe712;','&amp;#xe713;','&amp;#xe714;','&amp;#xe715;','&amp;#xe716;','&amp;#xe717;','&amp;#xe718;','&amp;#xe719;','&amp;#xe71a;','&amp;#xe71b;','&amp;#xe71c;','&amp;#xe71d;','&amp;#xe71e;','&amp;#xe71f;','&amp;#xe720;','&amp;#xe721;','&amp;#xe722;','&amp;#xe723;','&amp;#xe724;','&amp;#xe725;','&amp;#xe726;','&amp;#xe727;','&amp;#xe728;','&amp;#xe729;','&amp;#xe72a;','&amp;#xe72b;','&amp;#xe72c;','&amp;#xe72d;','&amp;#xe72e;','&amp;#xe72f;','&amp;#xe730;','&amp;#xe731;','&amp;#xe732;','&amp;#xe733;','&amp;#xe734;','&amp;#xe735;','&amp;#xe736;','&amp;#xe737;','&amp;#xe738;','&amp;#xe739;','&amp;#xe73a;','&amp;#xe73b;','&amp;#xe73c;','&amp;#xe73d;','&amp;#xe73e;','&amp;#xe73f;','&amp;#xe740;','&amp;#xe741;','&amp;#xe742;','&amp;#xe743;','&amp;#xe744;','&amp;#xe745;','&amp;#xe746;','&amp;#xe747;','&amp;#xe748;','&amp;#xe749;','&amp;#xe74a;','&amp;#xe74b;','&amp;#xe74c;','&amp;#xe74d;','&amp;#xe74e;','&amp;#xe74f;','&amp;#xe750;','&amp;#xe751;','&amp;#xe752;','&amp;#xe753;','&amp;#xe754;','&amp;#xe755;','&amp;#xe756;','&amp;#xe757;','&amp;#xe758;','&amp;#xe759;','&amp;#xe75a;','&amp;#xe75b;','&amp;#xe75c;','&amp;#xe75d;','&amp;#xe75e;','&amp;#xe75f;','&amp;#xe760;','&amp;#xe761;','&amp;#xe762;','&amp;#xe763;','&amp;#xe764;','&amp;#xe765;','&amp;#xe766;','&amp;#xe767;','&amp;#xe768;','&amp;#xe769;','&amp;#xe76a;','&amp;#xe76b;','&amp;#xe76c;','&amp;#xe76d;','&amp;#xe76e;','&amp;#xe76f;','&amp;#xe770;','&amp;#xe771;','&amp;#xe772;','&amp;#xe773;','&amp;#xe774;','&amp;#xe775;','&amp;#xe776;','&amp;#xe777;','&amp;#xe778;','&amp;#xe779;','&amp;#xe77a;','&amp;#xe77b;','&amp;#xe77c;','&amp;#xe77d;','&amp;#xe77e;','&amp;#xe77f;','&amp;#xe780;','&amp;#xe781;','&amp;#xe782;','&amp;#xe783;','&amp;#xe784;','&amp;#xe785;','&amp;#xe786;','&amp;#xe787;','&amp;#xe788;','&amp;#xe789;','&amp;#xe78a;','&amp;#xe78b;','&amp;#xe78c;','&amp;#xe78d;','&amp;#xe78e;','&amp;#xe78f;','&amp;#xe790;','&amp;#xe791;','&amp;#xe792;','&amp;#xe793;','&amp;#xe794;','&amp;#xe795;','&amp;#xe796;','&amp;#xe797;','&amp;#xe798;','&amp;#xe799;','&amp;#xe79a;','&amp;#xe79b;','&amp;#xe79c;','&amp;#xe79d;','&amp;#xe79e;','&amp;#xe79f;','&amp;#xe7a0;','&amp;#xe7a1;','&amp;#xe7a2;','&amp;#xe7a3;','&amp;#xe7a4;','&amp;#xe7a5;','&amp;#xe7a6;','&amp;#xe7a7;','&amp;#xe7a8;','&amp;#xe7a9;','&amp;#xe7aa;','&amp;#xe7ab;','&amp;#xe7ac;','&amp;#xe7ad;','&amp;#xe7ae;','&amp;#xe7af;','&amp;#xe7b0;','&amp;#xe7b1;','&amp;#xe7b2;','&amp;#xe7b3;','&amp;#xe7b4;','&amp;#xe7b5;','&amp;#xe7b6;','&amp;#xe7b7;','&amp;#xe7b8;','&amp;#xe7b9;'
 );
	$symbols = apply_filters( 'mh_font_icon_symbols', $symbols );

	return $symbols;
}
endif;


if ( ! function_exists( 'mhc_get_font_icon_list' ) ) :
function mhc_get_font_icon_list() {
	$output = is_customize_preview() ? mhc_get_font_icon_list_items() : '<%= window.mh_composer.font_icon_list_template() %>';

	$output = sprintf( '<ul class="mhc-icon mhicons">%1$s</ul>', $output );

	return $output;
}
endif;

if ( ! function_exists( 'mhc_get_font_icon_list_items' ) ) :
function mhc_get_font_icon_list_items() {
	$output = '';

	$symbols = mhc_font_mhicons_icon_symbols();

	foreach ( $symbols as $symbol ) {
		$output .= sprintf( '<li data-icon="%1$s"></li>', esc_attr( $symbol ) );
	}

	return $output;
}
endif;

if ( ! function_exists( 'mhc_font_icon_list' ) ) :
function mhc_font_icon_list() {
	echo mhc_get_font_icon_list();
}
endif;

/**
 * Processes font icon value for use on front-end
 *
 * @param string $font_icon        Font Icon ( exact value or in %%index_number%% format ).
 * @param string $symbols_function Optional. Name of the function that gets an array of font icon values.
 *                                 mhc_font_mhicons_icon_symbols function is used by default.
 * @return string $font_icon       Font Icon value
 */
if ( ! function_exists( 'mhc_process_font_icon' ) ) :
function mhc_process_font_icon( $font_icon, $symbols_function = 'default' ) {
	// the exact font icon value is saved
	if ( 1 !== preg_match( "/^%%/", trim( $font_icon ) ) ) {
		return $font_icon;
	}

	// the font icon value is saved in the following format: %%index_number%%
	$icon_index   = (int) str_replace( '%', '', $font_icon );
	$icon_symbols = 'default' === $symbols_function || ! class_exists( 'MHMoreIconsClass', false ) ? mhc_font_mhicons_icon_symbols() : call_user_func( $symbols_function );
	$font_icon    = isset( $icon_symbols[ $icon_index ] ) ? $icon_symbols[ $icon_index ] : '';

	return $font_icon;
}
endif;


if ( ! function_exists( 'mh_composer_font_list_option' ) ) :
function mh_composer_font_list_option() {
	$output = sprintf('<select name="mhc_font_list" id="mhc_font_list" class="mhc-main-setting mhc-affects" data-affects="#mhc_font_mhicons, #mhc_font_steadysets, #mhc_font_awesome, #mhc_font_lineicons, #mhc_font_etline, #mhc_font_icomoon, #mhc_font_linearicons"><option value="mhicons"%2$s>Entypo - %1$s</option>',
	esc_html__( 'Default', 'mh-composer' ),
	'<%= typeof( mhc_font_list) !== "undefined" && "mhicons" === mhc_font_list ?  " selected=\'selected\'" : "" %>'
	); 
	
	if( class_exists( 'MHMoreIconsClass', false ) ) {
		if ('on' === (mh_get_option('mharty_use_steadysets', 'false'))){
							$output .= '<option value="steadysets"<%= typeof( mhc_font_list ) !== "undefined" && "steadysets" === mhc_font_list ?  " selected=\'selected\'" : "" %>>Steadysets</option>';}
		if ('on' === (mh_get_option('mharty_use_awesome', 'false'))){
							$output .= '<option value="awesome"<%= typeof( mhc_font_list ) !== "undefined" && "awesome" === mhc_font_list ?  " selected=\'selected\'" : "" %>>FontAwesome</option>';}
		if ('on' === (mh_get_option('mharty_use_lineicons', 'false'))){
							$output .= '<option value="lineicons"<%= typeof( mhc_font_list ) !== "undefined" && "lineicons" === mhc_font_list ?  " selected=\'selected\'" : "" %>>Lineicons</option>';}
		if ('on' === (mh_get_option('mharty_use_etline', 'false'))){
							$output .= '<option value="etline"<%= typeof( mhc_font_list ) !== "undefined" && "etline" === mhc_font_list ?  " selected=\'selected\'" : "" %>>ETlineicons</option>';}
		if ('on' === (mh_get_option('mharty_use_icomoon', 'false'))){
							$output .= '<option value="icomoon"<%= typeof( mhc_font_list ) !== "undefined" && "icomoon" === mhc_font_list ?  " selected=\'selected\'" : "" %>>IcoMoon</option>';}
		if ('on' === (mh_get_option('mharty_use_linearicons', 'false'))){
							$output .= '<option value="linearicons"<%= typeof( mhc_font_list ) !== "undefined" && "linearicons" === mhc_font_list ?  " selected=\'selected\'" : "" %>>Linearicons</option>';}
	}
				
	$output .= '</select>';


	return $output;
}
endif;

if ( ! function_exists( 'mh_composer_accent_color' ) ) :
function mh_composer_accent_color( $default_color = '#44cdcd' ) {
	$accent_color = get_theme_mod( 'accent_color', $default_color );

	return apply_filters( 'mh_composer_accent_color', $accent_color );
}
endif;

if ( ! function_exists( 'mh_composer_get_text_orientation_options' ) ) :
function mh_composer_get_text_orientation_options() {
	$text_orientation_options = array(
		'right'     => esc_html__( 'Right', 'mh-composer' ),
		'left'      => esc_html__( 'Left', 'mh-composer' ),
		'center'    => esc_html__( 'Centre', 'mh-composer' ),
		'justified' => esc_html__( 'Justified', 'mh-composer' ),
	);

	if ( !is_rtl() ) {
		$text_orientation_options = array(
			'left'      => esc_html__( 'Left', 'mh-composer' ),
			'right'  	 => esc_html__( 'Right', 'mh-composer' ),
			'center' 	=> esc_html__( 'Centre', 'mh-composer' ),
			'justified' => esc_html__( 'Justified', 'mh-composer' ),
		);
	}

	return apply_filters( 'mh_composer_text_orientation_options', $text_orientation_options );
}
endif;


if ( ! function_exists( 'mh_composer_get_text_orientation_options_no_just' ) ) :
function mh_composer_get_text_orientation_options_no_just() {
	$text_orientation_options = array(
		'right'     => esc_html__( 'Right', 'mh-composer' ),
		'left'      => esc_html__( 'Left', 'mh-composer' ),
		'center'    => esc_html__( 'Centre', 'mh-composer' ),
	);

	if ( !is_rtl() ) {
		$text_orientation_options = array(
			'left'   => esc_html__( 'Left', 'mh-composer' ),
			'right'  => esc_html__( 'Right', 'mh-composer' ),
			'center' => esc_html__( 'Centre', 'mh-composer' ),
		);
	}

	return apply_filters( 'mh_composer_text_orientation_options_no_just', $text_orientation_options );
}
endif;

if ( ! function_exists( 'mh_composer_get_gallery_settings' ) ) :
function mh_composer_get_gallery_settings() {
	$output = sprintf(
		'<input type="button" class="button button-upload mhc-gallery-button" value="%1$s" />',
		esc_attr__( 'Update Gallery', 'mh-composer' )
	);

	return $output;
}
endif;

if ( ! function_exists( 'mh_composer_get_nav_menus_options' ) ) :
function mh_composer_get_nav_menus_options() {
	$nav_menus_options = array( 'none' => esc_html__( 'Select a menu', 'mh-composer' ) );

	$nav_menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
	foreach ( (array) $nav_menus as $_nav_menu ) {
		$nav_menus_options[ $_nav_menu->term_id ] = $_nav_menu->name;
	}

	return apply_filters( 'mh_composer_nav_menus_options', $nav_menus_options );
}
endif;

if ( ! function_exists( 'mh_composer_users_list_option' ) ) :
function mh_composer_users_list_option() {
	$user_array = get_users( 'orderby=nicename' );

	$output = sprintf('<select name="mhc_users_list" id="mhc_users_list"><option value="none"%2$s>%1$s</option>',
	esc_html__( 'Choose an author.', 'mh-composer' ),
	'<%= typeof( mhc_users_list ) !== "undefined" && "none" === mhc_users_list ? " selected=\'selected\'" : "" %>'
	);
	if ( $user_array ) {
		foreach ( $user_array as $user ) {
			$output .= sprintf( '<option value="%1$s"%2$s>%3$s</option>',
				esc_html( $user->ID ),
				sprintf('<%%= typeof( mhc_users_list ) !== "undefined" && "%1$s" === mhc_users_list ?  " selected=\'selected\'" : "" %%>',
			esc_html( $user->ID )
		),
				esc_html( $user->display_name )
			);
		}
   }
	$output .= '</select>';


	return $output;
}
endif;

if ( ! function_exists( 'mh_contact_form7_option' ) ) :
function mh_contact_form7_option() {
	$output = sprintf(
		'<select name="mhc_cf7" id="mhc_cf7"><option value="none"%2$s>%1$s</option>',
		esc_html__( 'Select a form', 'mh-composer' ),
		'<%= typeof( mhc_cf7 ) !== "undefined" && "none" === mhc_cf7 ? " selected=\'selected\'" : "" %>'
	);
 	//Require plugin.php to use is_plugin_active() below
 	include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
  	if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
		global $wpdb;
		
		$cf7 = $wpdb->get_results(
		  "
		  SELECT ID, post_title
		  FROM $wpdb->posts
		  WHERE post_type = 'wpcf7_contact_form'
		  "
		);
		
		$contact_forms = array();
		
		if ( $cf7 ) {
			foreach ( $cf7 as $cform ) {
				$contact_forms[ $cform->post_title ] = $cform->ID;
				$selected = sprintf(
		   			'<%%= typeof( mhc_cf7 ) !== "undefined" && "%1$s" === mhc_cf7 ?  " selected=\'selected\'" : "" %%>',
					esc_attr( $cform->ID )
				);
		
				$output .= sprintf(
					'<option value="%1$s"%2$s>%3$s</option>',
					esc_attr( $cform->ID ),
					$selected,
					esc_html( $cform->post_title )
				);
			}
		}
	 }
	 $output .= '</select>';
	 return $output; 
}
endif;

if ( ! function_exists( 'mh_mailpoet_option' ) ) :
function mh_mailpoet_option() {
	$output = sprintf(
		'<select name="mhc_mailpoet_form" id="mhc_mailpoet_form"><option value="none"%2$s>%1$s</option>',
		esc_html__( 'Select a form', 'mh-composer' ),
		'<%= typeof( mhc_mailpoet_form ) !== "undefined" && "none" === mhc_mailpoet_form ? " selected=\'selected\'" : "" %>'
	);
 	//Require plugin.php to use is_plugin_active() below
 	include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
  	if ( is_plugin_active( 'wysija-newsletters/index.php' ) ) {
		global $wpdb;
		
		$form = $wpdb->get_results(
		  "
		  SELECT form_id, name
		  FROM {$wpdb->prefix}wysija_form
		  "
		);
		
		$contact_forms = array();
		
		if ( $form ) {
			foreach ( $form as $cform ) {
				$contact_forms[ $cform->name ] = $cform->form_id;
				$selected = sprintf(
		   			'<%%= typeof( mhc_mailpoet_form ) !== "undefined" && "%1$s" === mhc_mailpoet_form ?  " selected=\'selected\'" : "" %%>',
					esc_attr( $cform->form_id )
				);
		
				$output .= sprintf(
					'<option value="%1$s"%2$s>%3$s</option>',
					esc_attr( $cform->form_id ),
					$selected,
					esc_html( $cform->name )
				);
			}
		}
	 }
	 $output .= '</select>';
	 return $output; 
}
endif;

if ( ! function_exists( 'mh_composer_generate_center_map_setting' ) ) :
function mh_composer_generate_center_map_setting() {
	return '<div id="mhc_map_center_map" class="mhc-map mhc_map_center_map"></div>';
}
endif;

if ( ! function_exists( 'mh_composer_generate_pin_zoom_level_input' ) ) :
function mh_composer_generate_pin_zoom_level_input() {
	return '<input class="mhc_zoom_level" type="hidden" value="18" />';
}
endif;

if ( ! function_exists( 'mh_composer_include_categories_option' ) ) :
function mh_composer_include_categories_option( $args = array() ) {
	$defaults = apply_filters( 'mh_composer_include_categories_defaults', array (
		'use_terms' => true,
		'term_name' => 'project_category',
	) );

	$args = wp_parse_args( $args, $defaults );

	$output = "\t" . "<% var mhc_include_categories_temp = typeof mhc_include_categories !== 'undefined' ? mhc_include_categories.split( ',' ) : []; %>" . "\n";

	if ( $args['use_terms'] ) {
		$cats_array = get_terms( $args['term_name'] );
	} else {
		$cats_array = get_categories( apply_filters( 'mh_composer_get_categories_args', 'hide_empty=0' ) );
	}
	
	if ( empty( $cats_array ) ) {
		$output = '<p>' . esc_html__( "You currently don't have any projects assigned to a category.", 'mh-composer' ) . '</p>';
	}
	
	foreach ( $cats_array as $category ) {
		$contains = sprintf(
			'<%%= _.contains( mhc_include_categories_temp, "%1$s" ) ? checked="checked" : "" %%>',
			esc_html( $category->term_id )
		);

		$output .= sprintf(
			'%4$s<label><input type="checkbox" name="mhc_include_categories" value="%1$s"%3$s> %2$s</label><br/>',
			esc_attr( $category->term_id ),
			esc_html( $category->name ),
			$contains,
			"\n\t\t\t\t\t"
		);
	}
	
	$output = '<div id="mhc_include_categories">' . $output . '</div>';

	return apply_filters( 'mh_composer_include_categories_option_html', $output );
}
endif;

if ( ! function_exists( 'mh_composer_choose_category_option' ) ) :
function mh_composer_choose_category_option() {
	$cats_array = get_categories( apply_filters( 'mh_composer_choose_category_args', 'hide_empty=0&parent=0' ) );
	$output = '<select name="mhc_choose_category" id="mhc_choose_category">';
	
	if ( empty( $cats_array ) ) {
		$output = '<p>' . esc_html__( "You currently don't have any posts assigned to a category.", 'mh-composer' ) . '</p>';
	}
	foreach ( $cats_array as $category ) {
		$selected = sprintf(
			'<%%= typeof( mhc_choose_category ) !== "undefined" && "%1$s" === mhc_choose_category ?  " selected=\'selected\'" : "" %%>',
			esc_html( $category->term_id )
		);

		$output .= sprintf(
			'<option value="%1$s"%2$s>%3$s</option>',
			esc_attr( $category->term_id ),
			$selected,
			esc_html( $category->name )
		);
	}

	$output .= '</select>';

	return $output;
}
endif;

if ( ! function_exists( 'mhc_get_projects' ) ) :
function mhc_get_projects( $args = array() ) {
	$default_args = array(
		'post_type' => 'project',
	);
	$args = wp_parse_args( $args, $default_args );
	return new WP_Query( $args );
}
endif;

if ( ! function_exists( 'mhc_extract_items' ) ) :
function mhc_extract_items( $content ) {
	$output = $first_character = '';
	$lines = array_filter( explode( "\n", str_replace( array( '<p>', '</p>', '<br />' ), "\n", $content ) ) );
	foreach ( $lines as $line ) {
		$line = trim( $line );
		//@todo check in case item starts with another 0 or 1 
		//if ( '1' === substr( $line, 0, 7 ) ) {
		//			$line = '1' . substr( $line, 7 );
		//		}
		if ( '' === $line ) {
			continue;
		}
		$first_character = $line[0];
		if ( in_array( $first_character, array( '0', '1' ) ) ) {
			$line = trim( substr( $line, 1 ) );
		}
		$output .= sprintf( '[mhc_pricing_item available="%2$s"]%1$s[/mhc_pricing_item]',
			$line,
			( '0' === $first_character ? 'off' : 'on' )
		);
	}
	return do_shortcode( $output );
}
endif;

if ( ! function_exists( 'mhc_extract_chart_parts' ) ) :
function mhc_extract_chart_parts( $content ) {
	$output = $percent = $color = '';
	$legends = explode(';', $content);
	foreach ( $legends as $legend ) {
		$legend = trim( $legend );
		if ( '' === $legend ) {
			continue;
		}
		$pie_chart_el = explode(',', $legend);
		$color = $pie_chart_el[1];
		$content = $pie_chart_el[2];
		$output .= sprintf( '<li><div class="color_choice" style="background-color: %1$s;"></div><p>%2$s</p></li>',
			$color,
			$content
		);
	}
	return  $output;
}
endif;

if ( ! function_exists( 'mhc_extract_chart_parts_js' ) ) :
function mhc_extract_chart_parts_js( $content ) {
	$output = $percent = $color = '';
	$legends = explode(';', $content);
	foreach ( $legends as $legend ) {
		$legend = trim( $legend );
		if ( '' === $legend ) {
			continue;
		}
		$pie_chart_el = explode(',', $legend);
		$percent = $pie_chart_el[0];
		$color = $pie_chart_el[1];
		
		$output .= sprintf('{value:%2$s,color:"%1$s"},',
			$color,
			$percent
		);
	}
	return  $output;
}
endif;

if ( ! function_exists( 'mh_composer_process_range_value' ) ) :
function mh_composer_process_range_value( $range, $option_type = '' ) {
	$range = trim( $range );
	$range_digit = floatval( $range );
	$range_string = str_replace( $range_digit, '', (string) $range );

	if ( '' === $range_string ) {
		$range_string = 'line_height' === $option_type && 3 >= $range_digit ? 'em' : 'px';
	}

	$result = $range_digit . $range_string;

	return apply_filters( 'mh_composer_processed_range_value', $result, $range, $range_string );
}
endif;

if ( ! function_exists( 'mh_composer_get_border_styles' ) ) :
function mh_composer_get_border_styles() {
	$styles = array(
		'solid'  => esc_html__( 'Solid', 'mh-composer' ),
		'dotted' => esc_html__( 'Dotted', 'mh-composer' ),
		'dashed' => esc_html__( 'Dashed', 'mh-composer' ),
		'double' => esc_html__( 'Double', 'mh-composer' ),
		'groove' => esc_html__( 'Groove', 'mh-composer' ),
		'ridge'  => esc_html__( 'Ridge', 'mh-composer' ),
		'inset'  => esc_html__( 'Inset', 'mh-composer' ),
		'outset' => esc_html__( 'Outset', 'mh-composer' ),
	);

	return apply_filters( 'mh_composer_border_styles', $styles );
}
endif;

function mhc_maybe_add_advanced_styles() {
	$style = MHComposer_Core::get_style();

	if ( $style ) {
		printf(
			'<style type="text/css" id="mh-composer-advanced-style">
				%1$s
			</style>',
			$style
		);
	}
}
add_action( 'wp_footer', 'mhc_maybe_add_advanced_styles' );

if ( ! function_exists( 'mhc_check_oembed_provider' ) ) {
function mhc_check_oembed_provider( $url ) {
	require_once( ABSPATH . WPINC . '/class-oembed.php' );
	$oembed = _wp_oembed_get_object();
	return $oembed->get_provider( esc_url( $url ), array( 'discover' => false ) );
}
}
// get a high resolution YouTube video thumbnails
if ( ! function_exists( 'mhc_set_video_oembed_thumbnail_resolution' ) ) :
function mhc_set_video_oembed_thumbnail_resolution( $image_src, $resolution = 'default' ) {
	
	if ( 'high' === $resolution && false !== strpos( $image_src,  'hqdefault.jpg' ) ) {
		$high_res_image_src = str_replace( 'hqdefault.jpg', 'maxresdefault.jpg', $image_src );
		$protocol = is_ssl() ? 'https://' : 'http://';
		$processed_image_url = esc_url( str_replace( '//', $protocol, $high_res_image_src ), array('http', 'https') );
		$response = wp_remote_get( $processed_image_url, array( 'timeout' => 30 ) );

		// Youtube doesn't guarantee that high res image exists for any video, so we need to check whether it exists and fallback to default image in case of error
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return $image_src;
		}

		return $high_res_image_src;
	}

	

	return $image_src;
}
endif;

function mh_composer_widgets_init(){
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

add_action( 'init', 'mh_composer_widgets_init', 20 );
//add_action( 'widgets_init', 'mh_composer_widgets_init' );


function mh_composer_get_widget_areas_list() {
	global $wp_registered_sidebars;

	$widget_areas = array();

	foreach ( $wp_registered_sidebars as $sidebar_key => $sidebar ) {
		$widget_areas[ $sidebar_key ] = array(
			'name' => $sidebar[ 'name' ]
		);
	}

	return $widget_areas;
}



if ( ! function_exists( 'mh_composer_get_widget_areas' ) ) :
function mh_composer_get_widget_areas() {
	global $wp_registered_sidebars;
	$wp_registered_sidebars = mh_composer_get_widget_areas_list();
	$mhc_widgets = get_theme_mod( 'mhc_widgets' );

	$output = '<select name="mhc_area" id="mhc_area">';

	foreach ( $wp_registered_sidebars as $id => $options ) {
		$selected = sprintf(
			'<%%= typeof( mhc_area ) !== "undefined" && "%1$s" === mhc_area ?  " selected=\'selected\'" : "" %%>',
			esc_html( $id )
		);

		$output .= sprintf(
			'<option value="%1$s"%2$s>%3$s</option>',
			esc_attr( $id ),
			$selected,
			esc_html( $options['name'] )
		);
	}

	$output .= '</select>';

	return $output;
}
endif;

if ( ! function_exists( 'mhc_vault_tools' ) ) :
function mhc_vault_tools() {
	if ( ! current_user_can( 'export' ) )
		wp_die( __( 'You do not have sufficient permissions to export the content of this site.', 'mh-composer' ) );
	?>
    <div class="mhc_vaults_main_container">
		<div class ="mhc_vaults_header">
			<h1 class="mhc_vaults_title"><?php _e( 'Composer Vault', 'mh-composer' ); ?></h1>
             <a href="<?php echo admin_url( 'edit-tags.php?taxonomy=layout_category' ); ?>" id="mh_vault_cats_button" class="mh-app-defaults-button mhc-vaults-cats-button"><?php _e( 'Manage Categories', 'mh-composer' ); ?></a>
			<?php echo mh_app_impoexpo_link( 'mh_composer_layouts', array( 'class' => 'mh-app-defaults-button mhc-impoexpo-button' ) ); ?>
		</div>
   </div>
	<?php
}
endif;

add_action( 'export_wp', 'mhc_edit_export_query' );
function mhc_edit_export_query() {
	add_filter( 'query', 'mhc_edit_export_query_filter' );
}

function mhc_edit_export_query_filter( $query ) {
	// Apply filter only once
	remove_filter( 'query', 'mhc_edit_export_query_filter') ;

	global $wpdb;

	$content = ! empty( $_GET['content'] ) ? $_GET['content'] : '';

	if ( MH_COMPOSER_LAYOUT_POST_TYPE !== $content ) {
		return $query;
	}

	$sql = '';
	$i = 0;
	$possible_types = array(
		'layout',
		'section',
		'row',
		'module',
		'fullwidth_section',
		'specialty_section',
		'fullwidth_module',
	);

	foreach ( $possible_types as $template_type ) {
		$selected_type = 'mhc_template_' . $template_type;

		if ( isset( $_GET[ $selected_type ] ) ) {
			if ( 0 === $i ) {
				$sql = " AND ( {$wpdb->term_relationships}.term_taxonomy_id = %d";
			} else {
				$sql .= " OR {$wpdb->term_relationships}.term_taxonomy_id = %d";
			}

			$sql_args[] = (int) $_GET[ $selected_type ];

			$i++;
		}
	}

	if ( '' !== $sql ) {
		$sql  .= ' )';

		$sql = sprintf(
			'SELECT ID FROM %4$s
			 INNER JOIN %3$s ON ( %4$s.ID = %3$s.object_id )
			 WHERE %4$s.post_type = "%1$s"
			 AND %4$s.post_status != "auto-draft"
			 %2$s',
			MH_COMPOSER_LAYOUT_POST_TYPE,
			$sql,
			$wpdb->term_relationships,
			$wpdb->posts
		);

		$query = $wpdb->prepare( $sql, $sql_args );
	}

	return $query;
}


function mhc_setup_theme(){
	add_action( 'add_meta_boxes', 'mhc_add_custom_box' );
}
add_action( 'init', 'mhc_setup_theme', 11 );

function mh_composer_set_post_type( $post_type = '' ) {
	global $mh_composer_post_type, $post;

	$mh_composer_post_type = ! empty( $post_type ) ? $post_type : $post->post_type;
}

function mhc_metabox_settings_save_details( $post_id, $post ){
	global $pagenow;

	if ( 'post.php' != $pagenow ) return $post_id;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	if ( ! isset( $_POST['mhc_settings_nonce'] ) || ! wp_verify_nonce( $_POST['mhc_settings_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	if ( isset( $_POST['mhc_use_composer'] ) ) {
		update_post_meta( $post_id, '_mhc_use_composer', sanitize_text_field( $_POST['mhc_use_composer'] ) );
	} else {
		delete_post_meta( $post_id, '_mhc_use_composer' );
	}

	if ( isset( $_POST['mhc_old_content'] ) ) {
		update_post_meta( $post_id, '_mhc_old_content', $_POST['mhc_old_content'] );
	} else {
		delete_post_meta( $post_id, '_mhc_old_content' );
	}
}
add_action( 'save_post', 'mhc_metabox_settings_save_details', 12, 2 );

function mhc_before_main_editor( $post ) {
	if ( ! in_array( $post->post_type, mh_composer_get_composer_post_types() ) ) return;

	$_mh_composer_use_composer = get_post_meta( $post->ID, '_mhc_use_composer', true );
	$is_composer_used = 'on' === $_mh_composer_use_composer ? true : false;

	$composer_always_enabled = apply_filters('mh_composer_always_enabled', false, $post->post_type, $post );
	if ( $composer_always_enabled || 'mhc_layout' === $post->post_type ) {
		$is_composer_used = true;
		$_mh_composer_use_composer = 'on';
	}

	// Add composer button only if this user is permitted.
	if ( mhc_permitted( 'mharty_composer_control' ) ) {
		printf( '<div class="mhc_toggle_composer_wrapper%5$s"><a href="#" id="mhc_toggle_composer" data-composer="%2$s" data-editor="%3$s" class="button button-primary button-large%5$s%6$s">%1$s</a></div><div id="mhc_main_editor_wrap"%4$s>',
			( $is_composer_used ? esc_html__( 'Use the default Editor', 'mh-composer' ) : esc_html__( 'Use the Page Composer', 'mh-composer' ) ),
			esc_html__( 'Use the Page Composer', 'mh-composer' ),
			esc_html__( 'Use the default Editor', 'mh-composer' ),
			( $is_composer_used ? ' class="mhc_hidden"' : '' ),
			( $is_composer_used ? ' mhc_composer_is_used' : '' ),
			( $composer_always_enabled ? ' mhc_hidden' : '' )
		);
	} else {
		printf( '<div class="mhc_toggle_composer_wrapper%2$s"></div><div id="mhc_main_editor_wrap"%1$s>',
			( $is_composer_used ? ' class="mhc_hidden"' : '' ),
			( $is_composer_used ? ' mhc_composer_is_used' : '' )
		);
	}

	?>
	<p class="mhc_page_settings" style="display: none;">
		<?php wp_nonce_field( basename( __FILE__ ), 'mhc_settings_nonce' ); ?>
		<input type="hidden" id="mhc_use_composer" name="mhc_use_composer" value="<?php echo esc_attr( $_mh_composer_use_composer ); ?>" />
		<textarea id="mhc_old_content" name="mhc_old_content"><?php echo esc_attr( get_post_meta( $post->ID, '_mhc_old_content', true ) ); ?></textarea>
	</p>
	<?php
}
add_action( 'edit_form_after_title', 'mhc_before_main_editor' );

function mhc_after_main_editor( $post ) {
	if ( ! in_array( $post->post_type, mh_composer_get_composer_post_types() ) ) return;
	echo '</div> <!-- #mhc_main_editor_wrap -->';
}
add_action( 'edit_form_after_editor', 'mhc_after_main_editor' );

function mhc_admin_scripts_styles( $hook ) {
	global $typenow;

	if ( $hook === 'widgets.php' ) {
		wp_enqueue_script( 'mhc_widgets_js', MH_COMPOSER_URI . '/js/widgets.js', array( 'jquery' ), MH_COMPOSER_VER, true );

		wp_localize_script( 'mhc_widgets_js', 'mhc_options', apply_filters( 'mhc_options_admin', array(
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			'mh_admin_load_nonce' => wp_create_nonce( 'mh_admin_load_nonce' ),
			'widget_strings'   => sprintf( '<div id="mhc_widget_area_create"><p>%1$s</p><p>%2$s</p><p><label>%3$s <input id="mhc_new_widget_area_name" value="" /></label><button class="button button-primary mhc_create_widget_area">%4$s</button><small>%5$s</small></p><p class="mhc_widget_area_result"></p></div>',							  
				esc_html__( 'Here you can create new widget areas for use in the Sidebar component.', 'mh-composer' ),
				esc_html__( 'Note: Naming your widget area "sidebar 1", "sidebar 2", "sidebar 3", "sidebar 4" or "sidebar 5" will cause conflicts with this theme.', 'mh-composer' ),
				esc_html__( 'Widget Name', 'mh-composer' ),
				esc_html__( 'Create', 'mh-composer' ),
				esc_html__( 'Refresh the page after creating your widget(s).', 'mh-composer' )
			),
			'delete_string' => esc_html__( 'Delete', 'mh-composer' ),
		) ) );

		wp_enqueue_style( 'mhc_widgets_css', MH_COMPOSER_URI . '/css/widgets.css', array(), MH_COMPOSER_VER );

		return;
	}

	if ( ! in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) return;

	/*
	 * Load the composer javascript and css files for custom post types
	 * custom post types can be added using mh_composer_post_types filter
	*/

	$post_types = mh_composer_get_composer_post_types();

	if ( isset( $typenow ) && in_array( $typenow, $post_types ) ){
		mhc_add_composer_page_js_css();
	}
}
add_action( 'admin_enqueue_scripts', 'mhc_admin_scripts_styles', 10, 1 );


/**
 * Disable emoji detection script on edit page which has Backend Builder on it.
 * WordPress automatically replaces emoji with plain image for backward compatibility
 * on older browsers. This causes issue when emoji is used on header or other input
 * text field because (when the modal is saved, shortcode is generated, and emoji
 * is being replaced with plain image) it creates incorrect attribute markup
 * such as `title="I <img class="emoji" src="../heart.png" /> WP"` and causes
 * the whole input text value to be disappeared
 * @return void
 */
function mhc_remove_emoji_detection_script() {
	global $pagenow;

	$disable_emoji_detection = false;

	// Disable emoji detection script on editing page which has Backend Builder
	// global $post isn't available at admin_init, so retrieve $post data manually
	if ( 'post.php' === $pagenow && isset( $_GET['post'] ) ) {
		$post_id   = (int) $_GET['post'];
		$post      = get_post( $post_id );
		$post_type = isset( $post->post_type ) ? $post->post_type : '';

		if ( in_array( $post_type, mh_composer_get_composer_post_types() ) ) {
			$disable_emoji_detection = true;
		}
	}

	// Disable emoji detection script on post new page which has Backend Builder
	$has_post_type_query = isset( $_GET['post_type'] );
	if ( 'post-new.php' === $pagenow && ( ! $has_post_type_query || ( $has_post_type_query && in_array( $_GET['post_type'], mh_composer_get_composer_post_types() ) ) ) ) {
		$disable_emoji_detection = true;
	}

	if ( $disable_emoji_detection ) {
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	}
}
add_action( 'admin_init', 'mhc_remove_emoji_detection_script' );


function mhc_fix_composer_shortcodes( $content ) {
	// if the composer is used for the page, get rid of random p tags
	if ( is_singular() && 'on' === get_post_meta( get_the_ID(), '_mhc_use_composer', true ) ) {
		$content = mhc_fix_shortcodes( $content );
	}

	return $content;
}
add_filter( 'the_content', 'mhc_fix_composer_shortcodes' );

// generate the html for "Add new template" Modal in Library
if ( ! function_exists( 'mhc_generate_new_layout_modal' ) ) {
	function mhc_generate_new_layout_modal() {
		$template_type_option_output = '';
		$template_module_tabs_option_output = '';
		$template_shared_option_output = '';
		$layout_cat_option_output = '';

		$template_type_options = apply_filters( 'mhc_new_layout_template_types', array(
			'module'            => esc_html__( 'Component', 'mh-composer' ),
			'fullwidth_module'  => esc_html__( 'Full-width Component', 'mh-composer' ),
			'row'               => esc_html__( 'Row', 'mh-composer' ),
			'section'           => esc_html__( 'Section', 'mh-composer' ),
			'fullwidth_section' => esc_html__( 'Full-width Section', 'mh-composer' ),
			'specialty_section' => esc_html__( 'Advanced Section', 'mh-composer' ),
			'layout'            => esc_html__( 'Layout', 'mh-composer' ),
		) );

		$template_module_tabs_options = apply_filters( 'mhc_new_layout_module_tabs', array(
			'general'  => esc_html__( 'Include General Settings', 'mh-composer' ),
			'advanced' => esc_html__( 'Include Advanced Settings', 'mh-composer' ),
			'css'      => esc_html__( 'Include CSS Settings', 'mh-composer' ),
		) );

		// construct output for the template type option
		if ( ! empty( $template_type_options ) ) {
			$template_type_option_output = sprintf(
				'<br><label>%1$s:</label>
				<select id="new_template_type">',
				esc_html__( 'Layout Type', 'mh-composer' )
			);

			foreach( $template_type_options as $option_id => $option_name ) {
				$template_type_option_output .= sprintf(
					'<option value="%1$s">%2$s</option>',
					esc_attr( $option_id ),
					esc_html( $option_name )
				);
			}

			$template_type_option_output .= '</select>';
		}

		// construct output for the module tabs option
		if ( ! empty( $template_module_tabs_options ) ) {
			$template_module_tabs_option_output = '<br><div class="mh_module_tabs_options">';

			foreach( $template_module_tabs_options as $option_id => $option_name ) {
				$template_module_tabs_option_output .= sprintf(
					'<label><i class="mhc_%2$s_icon"></i>%1$s<input type="checkbox" value="%2$s" id="mhc_template_general" checked /></label>',
					esc_html( $option_name ),
					esc_attr( $option_id )
				);
			}

			$template_module_tabs_option_output .= '</div>';
		}

		$template_shared_option_output = apply_filters( 'mhc_new_layout_shared_option', sprintf(
			'<br><label>%1$s<input type="checkbox" value="shared" id="mhc_template_shared"></label>',
			esc_html__( 'Shared', 'mh-composer' )
		) );

		// construct output for the layout category option
		$layout_cat_option_output .= sprintf(
			'<br><label>%1$s</label>',
			 esc_html__( 'Select category(ies) for new layout or type a new name ( optional )', 'mh-composer' )
		);

		$layout_categories = apply_filters( 'mhc_new_layout_cats_array', get_terms( 'layout_category', array( 'hide_empty' => false ) ) );
		if ( is_array( $layout_categories ) && ! empty( $layout_categories ) ) {
			$layout_cat_option_output .= '<div class="layout_cats_container">';

			foreach( $layout_categories as $category ) {
				$layout_cat_option_output .= sprintf(
					'<label>%1$s<input type="checkbox" value="%2$s"/></label>',
					esc_html( $category->name ),
					esc_attr( $category->term_id )
				);
			}

			$layout_cat_option_output .= '</div>';
		}

		$layout_cat_option_output .= '<input type="text" value="" id="mhc_new_cat_name" class="regular-text">';

		$output = sprintf(
			'<div class="mhc_modal_overlay mh_modal_on_top mhc_new_template_modal">
				<div class="mhc_prompt_modal">
					<h3>%1$s</h3>
					<div class="mhc_prompt_modal_inside">
						<label>%2$s:</label>
							<input type="text" value="" id="mhc_new_template_name" class="regular-text">
							%7$s
							%3$s
							%4$s
							%5$s
							%6$s
							%8$s
							<input id="mh_composer_layout_built_for_post_type" type="hidden" value="page">
					</div>
					<a href="#"" class="mhc_prompt_dont_proceed mhc-modal-close"></a>
					<div class="mhc_prompt_buttons">
						<br>
						<span class="spinner"></span>
						<input type="submit" class="mhc_create_template button-primary mhc_prompt_proceed" value="%9$s">
					</div>
				</div>
			</div>',
			esc_html__( 'New Layout Settings', 'mh-composer' ),
			esc_html__( 'Layout Name', 'mh-composer' ),
			$template_type_option_output,
			$template_module_tabs_option_output,
			$template_shared_option_output,
			$layout_cat_option_output,
			apply_filters( 'mhc_new_layout_before_options', '' ),
			apply_filters( 'mhc_new_layout_after_options', '' ),
			esc_html__( 'Create', 'mh-composer' )
		);

		return apply_filters( 'mhc_new_layout_modal_output', $output );
	}
}

/**
 * Get layout type of given post ID
 * @return string|bool
 */
if ( ! function_exists( 'mhc_get_layout_type' ) ) :
function mhc_get_layout_type( $post_id ) {
	// Get taxonomies
	$layout_type_data = wp_get_post_terms( $post_id, 'layout_type' );

	if ( empty( $layout_type_data ) ) {
		return false;
	}

	// Pluck name out of taxonomies
	$layout_type_array = wp_list_pluck( $layout_type_data, 'name' );

	// Logically, a layout only have one layout type.
	$layout_type = implode( "|", $layout_type_array );

	return $layout_type;
}
endif;

if ( ! function_exists( 'mhc_is_wp_pre_4_5' ) ) :
function mhc_is_wp_pre_4_5() {
	global $wp_version;

	$wp_major_version = substr( $wp_version, 0, 3 );

	if ( version_compare( $wp_major_version, '4.5', '<' ) ) {
		return true;
	}

	return false;
}
endif;

if ( ! function_exists( 'mhc_add_composer_page_js_css' ) ) :
function mhc_add_composer_page_js_css(){
	global $typenow, $post, $wp_version;
	
	// Get WP major version
	$wp_major_version = substr( $wp_version, 0, 3 );

	if ( mh_is_yoast_seo_plugin_active() ) {
		// Get list of shortcodes that causes issue if being triggered in admin
		$conflicting_shortcodes = mhc_admin_excluded_shortcodes();

		if ( ! empty( $conflicting_shortcodes ) ) {
			foreach ( $conflicting_shortcodes as $shortcode ) {
				remove_shortcode( $shortcode );
			}
		}
		// save the original content of $post variable
		$post_original = $post;
		// get the content for yoast
		$post_content_processed = do_shortcode( $post->post_content );
		// set the $post to the original content to make sure it wasn't changed by do_shortcode()
		$post = $post_original;
	}

	// we need some post data when editing saved templates.
	if ( 'mhc_layout' === $typenow ) {
		$template_scope = wp_get_object_terms( get_the_ID(), 'scope' );
		$is_shared_template = ! empty( $template_scope[0] ) ? $template_scope[0]->slug : 'regular';
		$post_id = get_the_ID();

		// Check whether it's a Shared item's page and display wp error if Shared items disabled for current user
		if ( ! mhc_permitted( 'edit_shared_vault' ) && 'shared' === $is_shared_template ) {
			wp_die( esc_html__( "you don't have sufficient permissions to access this page", 'mh-composer' ) );
		}
		
		$built_for_post_type = get_post_meta( get_the_ID(), '_mhc_built_for_post_type', true );
		$built_for_post_type = '' !== $built_for_post_type ? $built_for_post_type : 'page';
		$post_type = apply_filters( 'mhc_built_for_post_type', $built_for_post_type, get_the_ID() );

	} else {
		$is_shared_template = '';
		$post_id = '';
		$post_type = $typenow;
	}

	// we need this data to create the filter when adding saved modules
	$layout_categories = get_terms( 'layout_category' );
	$layout_cat_data = array();
	$layout_cat_data_json = '';

	if ( is_array( $layout_categories ) && ! empty( $layout_categories ) ) {
		foreach( $layout_categories as $category ) {
			$layout_cat_data[] = array(
				'slug' => $category->slug,
				'name' => $category->name,
			);
		}
	}
	if ( ! empty( $layout_cat_data ) ) {
		$layout_cat_data_json = json_encode( $layout_cat_data );
	}

	// Set fixed protocol for preview URL to prevent cross origin issue
	$preview_scheme = is_ssl() ? 'https' : 'http';
	$preview_url = esc_url( get_permalink( $post->ID ) ); //@todo esc_url( home_url( '/' ) );
	
	if ( 'https' === $preview_scheme && ! strpos( $preview_url, 'https://' ) ) {
		$preview_url = str_replace( 'http://', 'https://', $preview_url );
	}

	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'underscore' );
	wp_enqueue_script( 'backbone' );
	
	

	wp_enqueue_script( 'google-maps-api', esc_url( add_query_arg( array( 'key' => mh_get_google_api_key(), 'callback' => 'initMap', 'v' => 3, 'sensor' => 'false' ), is_ssl() ? 'https://maps.googleapis.com/maps/api/js' : 'http://maps.googleapis.com/maps/api/js' ) ), array(), '3', true );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-color-picker' );
	if ( version_compare( $wp_major_version, '4.9', '>=' ) ) {
		wp_enqueue_script( 'wp-color-picker-alpha', MH_COMPOSER_URI . '/js/wp-color-picker-alpha.min.js', array( 'jquery', 'wp-color-picker' ), MH_COMPOSER_VER, true );
		wp_localize_script( 'wp-color-picker-alpha', 'mhc_color_picker_strings', apply_filters( 'mhc_color_picker_strings_filter', array(
			'legacy_pick'    => esc_html__( 'Select', 'mh-composer' ),
			'legacy_current' => esc_html__( 'Current Colour', 'mh-composer' ),
		) ) );
	} else {
		wp_enqueue_script( 'wp-color-picker-alpha', MH_COMPOSER_URI . '/js/wp-color-picker-alpha-legacy.min.js', array( 'jquery', 'wp-color-picker' ), MH_COMPOSER_VER, true );
	}
	
	
	

	// load 1.10.4 versions of jQuery-ui scripts if WP version is less than 4.5, load 1.11.4 version otherwise
	if ( mhc_is_wp_pre_4_5() ) {
		wp_enqueue_script( 'mhc_admin_date_js', MH_COMPOSER_URI . '/js/jquery-ui-1.10.4.custom.min.js', array( 'jquery' ), MH_COMPOSER_VER, true );
	} else {
		wp_enqueue_script( 'mhc_admin_date_js', MH_COMPOSER_URI . '/js/jquery-ui-1.11.4.custom.min.js', array( 'jquery' ), MH_COMPOSER_VER, true );
	}
	wp_enqueue_script( 'mhc_admin_date_addon_js', MH_COMPOSER_URI . '/js/jquery-ui-timepicker-addon.js', array( 'mhc_admin_date_js' ), MH_COMPOSER_VER, true );

	wp_enqueue_script( 'validation', MH_COMPOSER_URI . '/js/jquery.validate.js', array( 'jquery' ), MH_COMPOSER_VER, true );
	wp_enqueue_script( 'minicolors', MH_COMPOSER_URI . '/js/jquery.minicolors.js', array( 'jquery' ), MH_COMPOSER_VER, true );

	wp_enqueue_script( 'mhc_app_js', MH_COMPOSER_URI .'/js/app.js', array( 'jquery', 'jquery-ui-core', 'underscore', 'backbone', 'mhc_admin_js' ), MH_COMPOSER_VER, true );

	wp_localize_script( 'mhc_app_js', 'mhc_options', apply_filters( 'mhc_options_composer', array(
		'debug'                                    => true,
		'ajaxurl'                                  => admin_url( 'admin-ajax.php' ),
		'home_url'                                 => home_url(),
		'preview_url'                              => add_query_arg( 'mhc_preview', 'true', $preview_url),
		'mh_admin_load_nonce'                      => wp_create_nonce( 'mh_admin_load_nonce' ),
		'images_uri'                               => MH_COMPOSER_URI .'/images',
		'post_type'                                => $post_type,
		'mh_composer_module_parent_shortcodes'      => MHComposer_Core::get_parent_shortcodes( $post_type ),
		'mh_composer_module_child_shortcodes'       => MHComposer_Core::get_child_shortcodes( $post_type ),
		'mh_composer_module_raw_content_shortcodes' => MHComposer_Core::get_raw_content_shortcodes( $post_type ),
		'mh_composer_modules'                       => MHComposer_Core::get_modules_js_array( $post_type ),
		'mh_composer_modules_count'                 => MHComposer_Core::get_modules_count( $post_type ),
		'mh_composer_modules_with_children'         => MHComposer_Core::get_shortcodes_with_children( $post_type ),
		'mh_composer_templates_amount'              => MH_COMPOSER_AJAX_TEMPLATES_AMOUNT,
		'default_initial_column_type'              => apply_filters( 'mh_composer_default_initial_column_type', '4_4' ),
		'default_initial_text_module'              => apply_filters( 'mh_composer_default_initial_text_module', 'mhc_text' ),
		'section_only_row_dragged_away'            => esc_html__( 'The section should have at least one row.', 'mh-composer' ),
		'fullwidth_module_dragged_away'            => esc_html__( 'Full-width component can\'t be used outside of the Full-width Section.', 'mh-composer' ),
		'stop_dropping_3_col_row'                  => esc_html__( '3 column row can\'t be used in this column.', 'mh-composer' ),
		'preview_image'                            => esc_html__( 'Preview', 'mh-composer' ),
		'empty_admin_label'                        => esc_html__( 'Component', 'mh-composer' ),
		'video_module_image_error'                 => esc_html__( 'Still images cannot be generated from this video service and/or this video format', 'mh-composer' ),
		'geocode_error'                            => esc_html__( 'Geocode was not successful for the following reason', 'mh-composer' ),
		'geocode_error_2'                          => esc_html__( 'Geocoder failed due to', 'mh-composer' ),
		'no_results'                               => esc_html__( 'No results found', 'mh-composer' ),
		'all_tab_options_hidden'                   => esc_html__( 'There are no options for this configuration.', 'mh-composer' ),
		'update_shared_module'                     => esc_html__( 'You\'re about to update shared component. This change will be applied to all pages where you use this component. Press OK if you want to update this component', 'mh-composer' ),
		'shared_row_alert'                         => esc_html__( 'You cannot add shared rows into shared sections', 'mh-composer' ),
		'shared_module_alert'                      => esc_html__( 'You cannot add shared components into shared sections or rows', 'mh-composer' ),
		'all_cat_text'                             => esc_html__( 'All Categories', 'mh-composer' ),
		'is_shared_template'                       => $is_shared_template,
		'template_post_id'                         => $post_id,
		'layout_categories'                        => $layout_cat_data_json,
		'map_pin_address_error'                    => esc_html__( 'Map Pin Address cannot be empty', 'mh-composer' ),
		'map_pin_address_invalid'                  => esc_html__( 'Invalid Pin and address data. Please try again.', 'mh-composer' ),
		'locked_section_permission_alert'          => esc_html__( 'You do not have permission to unlock this section.', 'mh-composer' ),
		'locked_row_permission_alert'              => esc_html__( 'You do not have permission to unlock this row.', 'mh-composer' ),
		'locked_module_permission_alert'           => esc_html__( 'You do not have permission to unlock this component.', 'mh-composer' ),
		'locked_item_permission_alert'             => esc_html__( 'You do not have permission to perform this task.', 'mh-composer' ),
		'localstorage_unavailability_alert'        => esc_html__( 'Unable to use copy/paste process because localStorage feature in your browser is not available. Please use a latest modern browser (Chrome, Firefox, or Safari) to perform copy/paste process', 'mh-composer' ),
		'invalid_color'    						=> esc_html__( 'Invalid Colour', 'mh-composer' ),
		'mhc_preview_nonce'						=> wp_create_nonce( 'mhc_preview_nonce' ),
		'is_mharty_vault'						  => 'mhc_layout' === $typenow ? 1 : 0,
		'layout_type'							  => 'mhc_layout' === $typenow ? mhc_get_layout_type( get_the_ID() ) : 0,
		'yoast_content'							=> mh_is_yoast_seo_plugin_active() ? $post_content_processed : '',
		'default_color_scheme'                     => implode( '|', mh_default_color_scheme() ),
		'verb'          => array(
			'did'       => esc_html__( 'Did', 'mh-composer' ),
			'added'     => esc_html__( 'Added', 'mh-composer' ),
			'edited'    => esc_html__( 'Edited', 'mh-composer' ),
			'removed'   => esc_html__( 'Removed', 'mh-composer' ),
			'moved'     => esc_html__( 'Moved', 'mh-composer' ),
			'expanded'  => esc_html__( 'Expanded', 'mh-composer' ),
			'collapsed' => esc_html__( 'Collapsed', 'mh-composer' ),
			'locked'    => esc_html__( 'Locked', 'mh-composer' ),
			'unlocked'  => esc_html__( 'Unlocked', 'mh-composer' ),
			'cloned'    => esc_html__( 'Cloned', 'mh-composer' ),
			'cleared'   => esc_html__( 'Cleared', 'mh-composer' ),
			'enabled'   => esc_html__( 'Enabled', 'mh-composer' ),
			'disabled'  => esc_html__( 'Disabled', 'mh-composer' ),
			'copied'    => esc_html__( 'Copied', 'mh-composer' ),
			'renamed'   => esc_html__( 'Renamed', 'mh-composer' ),
			'loaded'    => esc_html__( 'Loaded', 'mh-composer' ),
		),
		'noun'                  => array(
			'section'           => esc_html__( 'Section', 'mh-composer' ),
			'saved_section'     => esc_html__( 'Saved Section', 'mh-composer' ),
			'fullwidth_section' => esc_html__( 'Full-width Section', 'mh-composer' ),
			'specialty_section' => esc_html__( 'Advanced Section', 'mh-composer' ),
			'column'            => esc_html__( 'Column', 'mh-composer' ),
			'row'               => esc_html__( 'Row', 'mh-composer' ),
			'saved_row'         => esc_html__( 'Saved Row', 'mh-composer' ),
			'module'            => esc_html__( 'Component', 'mh-composer' ),
			'saved_module'      => esc_html__( 'Saved Component', 'mh-composer' ),
			'page'              => esc_html__( 'Page', 'mh-composer' ),
			'layout'            => esc_html__( 'Layout', 'mh-composer' ),
		),
		'invalid_color'    => esc_html__( 'Invalid Colour', 'mh-composer' ),
		'mhc_preview_nonce' => wp_create_nonce( 'mhc_preview_nonce' ),
		'is_mharty_vault'  => 'mhc_layout' === $typenow ? 1 : 0,
		'layout_type'      => 'mhc_layout' === $typenow ? mhc_get_layout_type( get_the_ID() ) : 0,
		'yoast_content'    => mh_is_yoast_seo_plugin_active() ? $post_content_processed : '',
		'google_api_key' => mh_get_google_api_key(),
		'theme_panel_advanced' => mh_get_theme_panel_link_advanced(),
	) ) );
	$ltr = is_rtl() ? "" : "-ltr";
	wp_enqueue_style( 'mhc_app_css', MH_COMPOSER_URI .'/css/app'. $ltr . '.css', array(), MH_COMPOSER_VER );
	wp_enqueue_style( 'mhc_app_date_css', MH_COMPOSER_URI . '/css/jquery-ui-1.10.4.custom.css', array(), MH_COMPOSER_VER );
}
endif;

function mhc_add_custom_box() {
	$post_types = mh_composer_get_composer_post_types();

	foreach ( $post_types as $post_type ){
		add_meta_box( MH_COMPOSER_LAYOUT_POST_TYPE, esc_html__( 'The Page Composer', 'mh-composer' ), 'mhc_pagecomposer_meta_box', $post_type, 'normal', 'high' );
	}
}

if ( ! function_exists( 'mhc_get_the_author_avatar' ) ) :
function mhc_get_the_author_avatar($size = false){
	global $authordata, $post;

	// Fallback for preview
	if ( empty( $authordata ) && isset( $post->post_author ) ) {
		$authordata = get_userdata( $post->post_author );
	}

	// If $authordata is empty, don't continue
	if ( empty( $authordata ) ) {
		return;
	}
	
	$link = sprintf(
		'<a class="mh_author_avatar_40" href="%1$s">%2$s</a>',
		esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
		get_avatar( get_the_author_meta('email'), $size )
	);
	return apply_filters( 'the_author_posts_link', $link );
}
endif;

if ( ! function_exists( 'mhc_get_the_author_posts_link' ) ) :
function mhc_get_the_author_posts_link(){
	global $authordata, $post;

	// Fallback for preview
	if ( is_null( $authordata ) && isset( $post->post_author ) ) {
		$authordata = get_userdata( $post->post_author );
	}

	// If no $author data or $post data found, don't continue
	if ( is_null( $authordata ) && is_null( $post ) ) {
		return;
	}

	$link = sprintf(
		'<a class="mh_author_link" href="%1$s" title="%2$s" rel="author">%3$s</a>',
		esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
		esc_attr( sprintf( __( 'Posts by %s', 'mh-composer' ), get_the_author() ) ),
		get_the_author()
	);
	return apply_filters( 'the_author_posts_link', $link );
}
endif;

if ( ! function_exists( 'mhc_get_comments_popup_link' ) ) :
function mhc_get_comments_popup_link( $zero = false, $one = false, $more = false ){
	$id = get_the_ID();
	$number = get_comments_number( $id );

	if ( 0 == $number && !comments_open() && !pings_open() ) return;

	if ( $number > 1 )
		$output = str_replace( '%', number_format_i18n( $number ), ( false === $more ) ? __( '% Comments', 'mh-composer' ) : $more );
	elseif ( $number == 0 )
		$output = ( false === $zero ) ? __( '0 Comments', 'mh-composer' ) : $zero;
	else // must be one
		$output = ( false === $one ) ? __( '1 Comment', 'mh-composer' ) : $one;

	return '<span class="comments-number">' . '<a href="' . esc_url( get_permalink() . '#respond' ) . '">' . apply_filters( 'comments_number', esc_html( $output ), esc_html( $number ) ) . '</a>' . '</span>';
}
endif;
if ( ! function_exists( 'mhc_postinfo_meta' ) ) :
function mhc_postinfo_meta( $postinfo, $date_format, $comment_zero, $comment_one, $comment_more ){
	$postinfo_meta = '';
	
	if ( in_array( 'avatar', $postinfo ) )
		$postinfo_meta .=  mhc_get_the_author_avatar('80');
	
		$postinfo_meta .= '<div class="post-meta-inline">';
		
	if ( in_array( 'author', $postinfo ) )
		$postinfo_meta .= ' ' . mh_get_post_author_pre() . ' ' . mhc_get_the_author_posts_link();
		
		$postinfo_meta .= '<p>';

	if ( in_array( 'date', $postinfo ) ) {
		$postinfo_meta .= esc_html( get_the_time( wp_unslash( $date_format ) ) );
	}
	
	if ( in_array( 'categories', $postinfo ) && is_singular( 'post' ) ){
		$categories_list = sprintf( '%1$s', is_rtl() ? get_the_category_list('، ') : get_the_category_list(', ') );
		
		// do not output anything if no categories retrieved
		if ( '' !== $categories_list ) {
			if ( in_array( 'date', $postinfo ) ) $postinfo_meta .= mh_get_post_info_sep();
	
			$postinfo_meta .= $categories_list;
		}
	}

	if ( in_array( 'comments', $postinfo ) ){
		if ( in_array( 'date', $postinfo ) || in_array( 'categories', $postinfo ) ) 			
		$postinfo_meta .= mh_get_post_info_sep();
		$postinfo_meta .= mhc_get_comments_popup_link( $comment_zero, $comment_one, $comment_more );
	}
	
	if ( in_array( 'views', $postinfo ) && function_exists('the_views') ){
		if ( in_array( 'date', $postinfo ) || in_array( 'categories', $postinfo ) || in_array( 'comments', $postinfo) ) $postinfo_meta .= mh_get_post_info_sep();
		$postinfo_meta .= function_exists('the_views') ? '<span class="mhc_the_views">' . do_shortcode('[views]') . '</span>' : '';
	}
	
	$postinfo_meta .= '</p></div>';

	return $postinfo_meta;
}
endif;

if ( ! function_exists( 'mhc_fix_shortcodes' ) ){
	function mhc_fix_shortcodes( $content, $decode_entities = false ){
		if ( $decode_entities ) {
			$content = mh_composer_replace_code_content_entities( $content );
			$content = MHComposer_Core::convert_smart_quotes_and_amp( $content );
			$content = html_entity_decode( $content, ENT_QUOTES );
		}

		$replace_tags_from_to = array (
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']',
			"<br />\n[" => '[',
		);

		return strtr( $content, $replace_tags_from_to );
	}
}

if ( ! function_exists( 'mhc_load_shared_module' ) ) {
	function mhc_load_shared_module( $shared_id, $row_type = '' ) {
		$shared_shortcode = '';

		if ( '' !== $shared_id ) {
			$query = new WP_Query( array(
				'p'         => (int) $shared_id,
				'post_type' => MH_COMPOSER_LAYOUT_POST_TYPE
			) );

			wp_reset_postdata();
			if ( ! empty( $query->post ) ) {
				$shared_shortcode = $query->post->post_content;

				if ( '' !== $row_type && 'mhc_row_inner' === $row_type ) {
					$shared_shortcode = str_replace( 'mhc_row', 'mhc_row_inner', $shared_shortcode );
				}
			}
		}

		return $shared_shortcode;
	}
}

if ( ! function_exists( 'mhc_extract_shortcode_content' ) ) {
	function mhc_extract_shortcode_content( $content, $shortcode_name ) {

		$start = strpos( $content, ']' ) + 1;
		$end = strrpos( $content, '[/' . $shortcode_name );

		if ( false !== $end ) {
			$content = substr( $content, $start, $end - $start );
		} else {
			$content = (bool) false;
		}

		return $content;
	}
}

function mh_composer_get_columns_layout() {
	$layout_columns =
		'<% if ( typeof mhc_specialty !== \'undefined\' && mhc_specialty === \'on\' ) { %>
			<li data-layout="1_2,1_2" data-specialty="1,0" data-specialty_columns="2">
				<div class="mhc_layout_column mhc_column_layout_1_2 mhc_variations mhc_2_variations">
					<div class="mhc_variation mhc_variation_full"></div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_2"></div>
						<div class="mhc_variation mhc_variation_1_2"></div>
					</div>
				</div>
				<div class="mhc_layout_column mhc_column_layout_1_2 mhc_specialty_column"></div>
			</li>

			<li data-layout="1_2,1_2" data-specialty="0,1" data-specialty_columns="2">
				<div class="mhc_layout_column mhc_column_layout_1_2 mhc_specialty_column"></div>

				<div class="mhc_layout_column mhc_column_layout_1_2 mhc_variations mhc_2_variations">
					<div class="mhc_variation mhc_variation_full"></div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_2"></div>
						<div class="mhc_variation mhc_variation_1_2"></div>
					</div>
				</div>
			</li>

			<li data-layout="1_4,3_4" data-specialty="0,1" data-specialty_columns="3">
				<div class="mhc_layout_column mhc_column_layout_1_4 mhc_specialty_column"></div>
				<div class="mhc_layout_column mhc_column_layout_3_4 mhc_variations mhc_3_variations">
					<div class="mhc_variation mhc_variation_full"></div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_2"></div>
						<div class="mhc_variation mhc_variation_1_2"></div>
					</div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_3"></div>
						<div class="mhc_variation mhc_variation_1_3"></div>
						<div class="mhc_variation mhc_variation_1_3"></div>
					</div>
				</div>
			</li>

			<li data-layout="3_4,1_4" data-specialty="1,0" data-specialty_columns="3">
				<div class="mhc_layout_column mhc_column_layout_3_4 mhc_variations mhc_3_variations">
					<div class="mhc_variation mhc_variation_full"></div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_2"></div>
						<div class="mhc_variation mhc_variation_1_2"></div>
					</div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_3"></div>
						<div class="mhc_variation mhc_variation_1_3"></div>
						<div class="mhc_variation mhc_variation_1_3"></div>
					</div>
				</div>
				<div class="mhc_layout_column mhc_column_layout_1_4 mhc_specialty_column"></div>
			</li>

			<li data-layout="1_4,1_2,1_4" data-specialty="0,1,0" data-specialty_columns="2">
				<div class="mhc_layout_column mhc_column_layout_1_4 mhc_specialty_column"></div>
				<div class="mhc_layout_column mhc_column_layout_1_2 mhc_variations mhc_2_variations">
					<div class="mhc_variation mhc_variation_full"></div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_2"></div>
						<div class="mhc_variation mhc_variation_1_2"></div>
					</div>
				</div>
				<div class="mhc_layout_column mhc_column_layout_1_4 mhc_specialty_column"></div>
			</li>

			<li data-layout="1_2,1_4,1_4" data-specialty="1,0,0" data-specialty_columns="2">
				<div class="mhc_layout_column mhc_column_layout_1_2 mhc_variations mhc_2_variations">
					<div class="mhc_variation mhc_variation_full"></div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_2"></div>
						<div class="mhc_variation mhc_variation_1_2"></div>
					</div>
				</div>
				<div class="mhc_layout_column mhc_column_layout_1_4 mhc_specialty_column"></div>
				<div class="mhc_layout_column mhc_column_layout_1_4 mhc_specialty_column"></div>
			</li>

			<li data-layout="1_4,1_4,1_2" data-specialty="0,0,1" data-specialty_columns="2">
				<div class="mhc_layout_column mhc_column_layout_1_4 mhc_specialty_column"></div>
				<div class="mhc_layout_column mhc_column_layout_1_4 mhc_specialty_column"></div>
				<div class="mhc_layout_column mhc_column_layout_1_2 mhc_variations mhc_2_variations">
					<div class="mhc_variation mhc_variation_full"></div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_2"></div>
						<div class="mhc_variation mhc_variation_1_2"></div>
					</div>
				</div>
			</li>

			<li data-layout="1_3,2_3" data-specialty="0,1" data-specialty_columns="2">
				<div class="mhc_layout_column mhc_column_layout_1_3 mhc_specialty_column"></div>
				<div class="mhc_layout_column mhc_column_layout_2_3 mhc_variations mhc_2_variations">
					<div class="mhc_variation mhc_variation_full"></div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_2"></div>
						<div class="mhc_variation mhc_variation_1_2"></div>
					</div>
				</div>
			</li>

			<li data-layout="2_3,1_3" data-specialty="1,0" data-specialty_columns="2">
				<div class="mhc_layout_column mhc_column_layout_2_3 mhc_variations mhc_2_variations">
					<div class="mhc_variation mhc_variation_full"></div>
					<div class="mhc_variation_row">
						<div class="mhc_variation mhc_variation_1_2"></div>
						<div class="mhc_variation mhc_variation_1_2"></div>
					</div>
				</div>
				<div class="mhc_layout_column mhc_column_layout_1_3 mhc_specialty_column"></div>
			</li>
			<li data-layout="1_8,3_4 w7_9_5,1_8" data-specialty="0,1,0" data-specialty_columns="3">
			  <div class="mhc_layout_column mhc_column_layout_1_8 mhc_specialty_column"></div>
			  <div class="mhc_layout_column mhc_column_layout_3_4 w7_9_5 mhc_variations mhc_3_variations">
				<div class="mhc_variation mhc_variation_full"></div>
				<div class="mhc_variation_row">
				  <div class="mhc_variation mhc_variation_1_2"></div>
				  <div class="mhc_variation mhc_variation_1_2"></div>
				</div>
				<div class="mhc_variation_row">
				  <div class="mhc_variation mhc_variation_1_3"></div>
				  <div class="mhc_variation mhc_variation_1_3"></div>
				  <div class="mhc_variation mhc_variation_1_3"></div>
				</div>
			  </div>
			  <div class="mhc_layout_column mhc_column_layout_1_8 mhc_specialty_column"></div>
			</li>
		<% } else if ( typeof view !== \'undefined\' && typeof view.model.attributes.specialty_columns !== \'undefined\' ) { %>
			<li data-layout="4_4">
				<div class="mhc_layout_column mhc_column_layout_fullwidth"></div>
			</li>
			<li data-layout="1_2,1_2">
				<div class="mhc_layout_column mhc_column_layout_1_2"></div>
				<div class="mhc_layout_column mhc_column_layout_1_2"></div>
			</li>

			<% if ( view.model.attributes.specialty_columns === 3 ) { %>
				<li data-layout="1_3,1_3,1_3">
					<div class="mhc_layout_column mhc_column_layout_1_3"></div>
					<div class="mhc_layout_column mhc_column_layout_1_3"></div>
					<div class="mhc_layout_column mhc_column_layout_1_3"></div>
				</li>
			<% } %>
		<% } else { %>
			<li data-layout="4_4">
				<div class="mhc_layout_column mhc_column_layout_fullwidth"></div>
			</li>
			<li data-layout="1_2,1_2">
				<div class="mhc_layout_column mhc_column_layout_1_2"></div>
				<div class="mhc_layout_column mhc_column_layout_1_2"></div>
			</li>
			<li data-layout="1_3,1_3,1_3">
				<div class="mhc_layout_column mhc_column_layout_1_3"></div>
				<div class="mhc_layout_column mhc_column_layout_1_3"></div>
				<div class="mhc_layout_column mhc_column_layout_1_3"></div>
			</li>
			<li data-layout="1_4,1_4,1_4,1_4">
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
			</li>
			<li data-layout="2_3,1_3">
				<div class="mhc_layout_column mhc_column_layout_2_3"></div>
				<div class="mhc_layout_column mhc_column_layout_1_3"></div>
			</li>
			<li data-layout="1_3,2_3">
				<div class="mhc_layout_column mhc_column_layout_1_3"></div>
				<div class="mhc_layout_column mhc_column_layout_2_3"></div>
			</li>
			<li data-layout="1_4,3_4">
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
				<div class="mhc_layout_column mhc_column_layout_3_4"></div>
			</li>
			<li data-layout="3_4,1_4">
				<div class="mhc_layout_column mhc_column_layout_3_4"></div>
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
			</li>
			<li data-layout="1_2,1_4,1_4">
				<div class="mhc_layout_column mhc_column_layout_1_2"></div>
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
			</li>
			<li data-layout="1_4,1_4,1_2">
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
				<div class="mhc_layout_column mhc_column_layout_1_2"></div>
			</li>
			<li data-layout="1_4,1_2,1_4">
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
				<div class="mhc_layout_column mhc_column_layout_1_2"></div>
				<div class="mhc_layout_column mhc_column_layout_1_4"></div>
			</li>
			<li data-layout="3_4 w7_9_5">
				<div class="mhc_layout_column mhc_column_layout_3_4 mhc_column_layout_7_9_5"></div>
			</li>
	<%
		}
	%>';

	return apply_filters( 'mh_composer_layout_columns', $layout_columns );
}


function mhc_pagecomposer_meta_box() {
	global $typenow, $post;

	do_action( 'mhc_before_page_composer' );

	echo '<div id="mhc_hidden_editor">';
	wp_editor( '', 'mhc_content_new', array( 'media_buttons' => true, 'tinymce' => array( 'wp_autoresize_on' => true ) ) );
	echo '</div>';

	printf(
		'<div id="mhc_main_container" class="post-type-%1$s%2$s"></div>',
		esc_attr( $typenow ),
		! mhc_permitted( 'move_module' ) ? ' mhc-disable-sort' : ''
	);
	$rename_module_menu = sprintf(
		'<%% if ( this.hasOption( "rename" ) ) { %%>
			<li><a class="mhc-right-click-rename" href="#">%1$s</a></li>
		<%% } %%>',
		esc_html__( 'Rename', 'mh-composer' )
	);
	$copy_module_menu = sprintf(
		'<%% if ( this.hasOption( "copy" ) ) { %%>
			<li><a class="mhc-right-click-copy" href="#">%1$s</a></li>
		<%% } %%>',
		esc_html__( 'Copy', 'mh-composer' )
	);
	$paste_after_menu = sprintf(
		'<%% if ( this.hasOption( "paste-after" ) ) { %%>
			<li><a class="mhc-right-click-paste-after" href="#">%1$s</a></li>
		<%% } %%>',
		esc_html__( 'Place', 'mh-composer' )
	);
	$paste_menu_item = sprintf(
		'<%% if ( this.hasOption( "paste-column" ) ) { %%>
			<li><a class="mhc-right-click-paste-column" href="#">%1$s</a></li>
		<%% } %%>',
		esc_html__( 'Paste', 'mh-composer' )
	);
	$paste_app_menu_item = sprintf(
		'<%% if ( this.hasOption( "paste-app" ) ) { %%>
			<li><a class="mhc-right-click-paste-app" href="#">%1$s</a></li>
		<%% } %%>',
		esc_html__( 'Paste', 'mh-composer' )
	);
	$save_to_vault_menu = sprintf(
		'<%% if ( this.hasOption( "save-to-vault") ) { %%>
			<li><a class="mhc-right-click-save-to-vault" href="#">%1$s</a></li>
		<%% } %%>',
		esc_html__( 'Save', 'mh-composer' )
	);
	$lock_unlock_menu = sprintf(
		'<%% if ( this.hasOption( "lock" ) ) { %%>
			<li><a class="mhc-right-click-lock" href="#"><span class="unlock">%1$s</span><span class="lock">%2$s</span></a></li>
		<%% } %%>',
		esc_html__( 'Unlock', 'mh-composer' ),
		esc_html__( 'Lock', 'mh-composer' )
	);
	$enable_disable_menu = sprintf(
		'<%% if ( this.hasOption( "disable" ) ) { %%>
			<li><a class="mhc-right-click-disable" href="#"><span class="enable">%1$s</span><span class="disable">%2$s</span></a></li>
		<%% } %%>',
		esc_html__( 'Enabled', 'mh-composer' ),
		esc_html__( 'Disabled', 'mh-composer' )
	);
	$disable_shared_menu = sprintf(
		'<%% if ( this.hasOption( "disable-shared") ) { %%>
			<li><a class="mhc-right-click-disable-shared" href="#">%1$s</a></li>
		<%% } %%>',
		esc_html__( 'Disable Shared', 'mh-composer' )
	);
	// Right click options Template
	printf(
		'<script type="text/template" id="mh-composer-right-click-controls-template">
		<ul class="options">
			<%% if ( "module" !== this.options.model.attributes.type || _.contains( %13$s, this.options.model.attributes.module_type ) ) { %%>
				%1$s
				%8$s
				<%% if ( this.hasOption( "undo" ) ) { %%>
				<li><a class="mhc-right-click-undo" href="#">%9$s</a></li>
				<%% } %%>
				<%% if ( this.hasOption( "redo" ) ) { %%>
				<li><a class="mhc-right-click-redo" href="#">%10$s</a></li>
				<%% } %%>
				%2$s
				%3$s
				<%% if ( this.hasOption( "collapse" ) ) { %%>
				<li><a class="mhc-right-click-collapse" href="#"><span class="expand">%4$s</span><span class="collapse">%5$s</span></a></li>
				<%% } %%>
				%6$s
				%7$s
				%12$s
				%11$s
			<%% } %%>
			<%% if ( this.hasOption( "preview" ) ) { %%>
			<li><a class="mhc-right-click-preview" href="#">%14$s</a></li>
			<%% } %%>
				%15$s
		</ul>
		</script>',
		mhc_permitted( 'edit_module' ) && ( mhc_permitted( 'general_settings' ) || mhc_permitted( 'advanced_settings' ) || mhc_permitted( 'custom_css_settings' ) ) ? $rename_module_menu : '',
		mhc_permitted( 'disable_module' ) ? $enable_disable_menu : '',
		mhc_permitted( 'lock_module' ) ? $lock_unlock_menu : '',
		esc_html__( 'Expand', 'mh-composer' ),
		esc_html__( 'Collapse', 'mh-composer' ), //#5
		mhc_permitted( 'add_module' ) ? $copy_module_menu : '',
		mhc_permitted( 'add_module' ) ? $paste_after_menu : '',
		mhc_permitted( 'mharty_vault' ) && mhc_permitted( 'save_vault' ) ? $save_to_vault_menu : '',
		esc_html__( 'Undo', 'mh-composer' ),
		esc_html__( 'Redo', 'mh-composer' ), //#10
		mhc_permitted( 'add_module' ) ? $paste_menu_item : '',
		mhc_permitted( 'add_module' ) ? $paste_app_menu_item : '',
		mhc_permitted_elements(),
		esc_html__( 'Preview', 'mh-composer' ),
		mhc_permitted( 'edit_module' ) && mhc_permitted( 'edit_shared_vault' ) ? $disable_shared_menu : ''
	);

	// "Rename Module Label" Modal Window Template
	printf(
		'<script type="text/template" id="mh-composer-prompt-modal-rename_admin_label">
			<div class="mhc_prompt_modal">
				<a href="#" class="mhc_prompt_dont_proceed mhc-modal-close">
					<span>%1$s</span>
				</a>
				<div class="mhc_prompt_buttons">
					<input type="submit" class="mhc_prompt_proceed" value="%2$s" />
				</div>
			</div>
		</script>',
		esc_html__( 'Cancel', 'mh-composer' ),
		esc_attr__( 'Save', 'mh-composer' )
	);

	// "Rename Module Label" Modal Content Template
	printf(
		'<script type="text/template" id="mh-composer-prompt-modal-rename_admin_label-text">
			<h3>%1$s</h3>
			<p>%2$s</p>

			<input type="text" value="" id="mhc_new_admin_label" class="regular-text" />
		</script>',
		esc_html__( 'Rename', 'mh-composer' ),
		esc_html__( 'Enter a new name for this Item', 'mh-composer' )
	);

	$save_to_vault_button = sprintf(
		'<a href="#" class="mhc-layout-buttons mhc-layout-buttons-save" title="%1$s">
			<span class="icon"></span><span class="label">%2$s</span>
		</a>',
		esc_attr__( 'Save To Vault', 'mh-composer' ),
		esc_html__( 'Save To Vault', 'mh-composer' )
	);
	$load_from_vault_button = sprintf(
		'<a href="#" class="mhc-layout-buttons mhc-layout-buttons-load" title="%1$s">
			<span class="icon"></span><span class="label">%2$s</span>
		</a>',
		esc_attr__( 'Add From Vault', 'mh-composer' ),
		esc_html__( 'Add From Vault', 'mh-composer' )
	);
	$redo_button = sprintf(
		'<a href="#" class="mhc-layout-buttons mhc-layout-buttons-redo" title="%1$s"><span class="icon"></span><span class="label">%2$s</span></a>',
		esc_attr__( 'Redo', 'mh-composer' ),
		esc_html__( 'Redo', 'mh-composer' )
	);
	$undo_button = sprintf(
		'<a href="#" class="mhc-layout-buttons mhc-layout-buttons-undo" title="%1$s"><span class="icon"></span><span class="label">%2$s</span></a>',
		esc_attr__( 'Undo', 'mh-composer' ),
		esc_html__( 'Undo', 'mh-composer' )
	);
	$clear_layout_button = sprintf(
		'<a href="#" class="mhc-layout-buttons mhc-layout-buttons-clear" title="%1$s">
			<span class="icon"></span><span class="label">%2$s</span>
		</a>',
		esc_attr__( 'Clear Layout', 'mh-composer' ),
		esc_html__( 'Clear Layout', 'mh-composer' )
	);
	$see_history_button = sprintf(
		'<a href="#" class="mhc-layout-buttons mhc-layout-buttons-history" title="%1$s">
			<span class="icon"></span><span class="label">%2$s</span>
		</a>',
		esc_attr__( 'See History', 'mh-composer' ),
		esc_html__( 'See History', 'mh-composer' )
	);
	// App Template
	printf(
		'<script type="text/template" id="mh-composer-app-template">
			<div id="mhc_layout_controls">
				<h3 class="mhc_layout_title"><span>%1$s</span></h3>
				<div class="mhc-layout-buttons-wrapper">
					%2$s
					%3$s
					%4$s
					%5$s
					%6$s	
				</div>
			</div>
			<div id="mhc-histories-visualizer-overlay"></div>
			<ol id="mhc-histories-visualizer"></ol>
		</script>',
		esc_html__( 'The Page Composer', 'mh-composer' ),
		mhc_permitted( 'mharty_vault' ) && mhc_permitted( 'save_vault' ) ? $save_to_vault_button : '',
		mhc_permitted( 'mharty_vault' ) && mhc_permitted( 'load_layout' ) && mhc_permitted( 'add_vault' ) && mhc_permitted( 'add_module' ) ? $load_from_vault_button : '',
		mhc_permitted( 'add_module' ) ? $clear_layout_button : '',
		is_rtl() ? $redo_button . $undo_button : $undo_button . $redo_button,
		$see_history_button				
	);

	$section_settings_button = sprintf(
		'<%% if ( ( typeof mhc_template_type === \'undefined\' || \'section\' === mhc_template_type || \'\' === mhc_template_type )%3$s ) { %%>
			<a href="#" class="mhc-settings mhc-settings-section" title="%1$s"><span>%2$s</span></a>
		<%% } %%>',
		esc_attr__( 'Settings', 'mh-composer' ),
		esc_html__( 'Settings', 'mh-composer' ),
		! mhc_permitted( 'edit_shared_vault' ) ? ' && typeof mhc_shared_module === "undefined"' : '' 
		// do not display settings on shared sections if not permitted for this user
	);
	$section_clone_button = sprintf(
		'<a href="#" class="mhc-clone mhc-clone-section" title="%1$s"><span>%2$s</span></a>',
		esc_attr__( 'Clone Section', 'mh-composer' ),
		esc_html__( 'Clone Section', 'mh-composer' )
	);
	$section_remove_button = sprintf(
		'<a href="#" class="mhc-remove mhc-remove-section" title="%1$s"><span>%2$s</span></a>',
		esc_attr__( 'Delete Section', 'mh-composer' ),
		esc_html__( 'Delete Section', 'mh-composer' )
	);
	$section_unlock_button = sprintf(
		'<a href="#" class="mhc-unlock" title="%1$s"><span>%2$s</span></a>',
		esc_attr__( 'Unlock Section', 'mh-composer' ),
		esc_html__( 'Unlock Section', 'mh-composer' )
	);
	// Section Template
	$settings_controls = sprintf(
		'<div class="mhc-controls">
			%1$s

			<%% if ( typeof mhc_template_type === \'undefined\' || ( \'section\' !== mhc_template_type && \'row\' !== mhc_template_type && \'module\' !== mhc_template_type ) ) { %%>
				%2$s
				%3$s
			<%% } %%>

			<a href="#" class="mhc-expand" title="%4$s"><span>%5$s</span></a>
			%6$s
		</div>',
		mhc_permitted( 'edit_module' ) && ( mhc_permitted( 'general_settings' ) || mhc_permitted( 'advanced_settings' ) || mhc_permitted( 'custom_css_settings' ) ) ? $section_settings_button : '',
		mhc_permitted( 'add_module' ) ? $section_clone_button : '',
		mhc_permitted( 'add_module' ) ? $section_remove_button : '',
		esc_attr__( 'Expand Section', 'mh-composer' ),
		esc_html__( 'Expand Section', 'mh-composer' ),
		mhc_permitted( 'lock_module' ) ? $section_unlock_button : ''
	);
	
	$add_from_vault_section = sprintf(
		'<span class="mhc-section-add-saved">%1$s</span>',
		esc_html__( 'Add From Vault', 'mh-composer' )
	);
	$add_standard_section_button = sprintf(
		'<span class="mhc-section-add-main">%1$s</span>',
		esc_html__( 'Default Section', 'mh-composer' )
	);
	$add_standard_section_button = apply_filters( 'mh_composer_add_main_section_button', $add_standard_section_button );

	$add_fullwidth_section_button = sprintf(
		'<span class="mhc-section-add-fullwidth">%1$s</span>',
		esc_html__( 'Full-width Section', 'mh-composer' )
	);
	$add_fullwidth_section_button = apply_filters( 'mh_composer_add_fullwidth_section_button', $add_fullwidth_section_button );

	$add_specialty_section_button = sprintf(
		'<span class="mhc-section-add-specialty">%1$s</span>',
		esc_html__( 'Advanced Section', 'mh-composer' )
	);
	$add_specialty_section_button = apply_filters( 'mh_composer_add_specialty_section_button', $add_specialty_section_button );
	
	$settings_add_controls = sprintf(
		'<%% if ( typeof mhc_template_type === \'undefined\' || ( \'section\' !== mhc_template_type && \'row\' !== mhc_template_type && \'module\' !== mhc_template_type ) ) { %%>
			<a href="#" class="mhc-section-add">
				%1$s
				%2$s
				%3$s
				%4$s
			</a>
		<%% } %%>',
		$add_standard_section_button,
		$add_fullwidth_section_button,
		$add_specialty_section_button,
		mhc_permitted( 'mharty_vault' ) && mhc_permitted( 'add_vault' ) ? $add_from_vault_section : ''
	);

	printf(
		'<script type="text/template" id="mh-composer-section-template">
			<div class="mhc-right-click-trigger-overlay"></div>
			%1$s
			<div class="mhc-section-content mhc-data-cid%3$s%4$s" data-cid="<%%= cid %%>" data-skip="<%%= typeof( mhc_skip_module ) === \'undefined\' ? \'false\' : \'true\' %%>">
			</div>
			%2$s
			<div class="mhc-locked-overlay mhc-locked-overlay-section"></div>
			<span class="mhc-section-title"><%%= admin_label.replace( /%%22/g, "&quot;" ) %%></span>
		</script>',
		apply_filters( 'mh_composer_section_settings_controls', $settings_controls ),
		mhc_permitted( 'add_module' ) ? apply_filters( 'mh_composer_section_add_controls', $settings_add_controls ) : '',
		! mhc_permitted( 'move_module' ) ? ' mhc-disable-sort' : '',
		! mhc_permitted( 'edit_shared_vault' )
			? sprintf( '<%%= typeof mhc_shared_module !== \'undefined\' ? \' mhc-disable-sort\' : \'\' %%>' )
			: ''
	);

	$row_settings_button = sprintf(
		'<%% if ( ( typeof mhc_template_type === \'undefined\' || mhc_template_type !== \'module\' )%3$s ) { %%>
			<a href="#" class="mhc-settings mhc-settings-row" title="%1$s"><span>%2$s</span></a>
		<%% } %%>',
		esc_attr__( 'Settings', 'mh-composer' ),
		esc_html__( 'Settings', 'mh-composer' ),
		! mhc_permitted( 'edit_shared_vault' ) ? ' && ( typeof mhc_shared_module === "undefined" || "" === mhc_shared_module ) && ( typeof mhc_shared_parent === "undefined" || "" === mhc_shared_parent )' : '' 
		// do not display settings button on shared rows if not permitted for thid user
	);
	$row_clone_button = sprintf(
		'%3$s
			<a href="#" class="mhc-clone mhc-clone-row" title="%1$s"><span>%2$s</span></a>
		%4$s',
		esc_attr__( 'Clone Row', 'mh-composer' ),
		esc_html__( 'Clone Row', 'mh-composer' ),
		! mhc_permitted( 'edit_shared_vault' ) ? '<% if ( typeof mhc_shared_parent === "undefined" || "" === mhc_shared_parent ) { %>' : '', 
		// do not display clone button on rows within shared sections if not permitted for this user
		! mhc_permitted( 'edit_shared_vault' ) ? '<% } %>' : ''
	);
	$row_remove_button = sprintf(
		'%3$s
			<a href="#" class="mhc-remove mhc-remove-row" title="%1$s"><span>%2$s</span></a>
		%4$s',
		esc_attr__( 'Delete Row', 'mh-composer' ),
		esc_html__( 'Delete Row', 'mh-composer' ),
		! mhc_permitted( 'edit_shared_vault' ) ? '<% if ( typeof mhc_shared_parent === "undefined" || "" === mhc_shared_parent ) { %>' : '', 
		// do not display clone button on rows within shared sections if not permitted for this user
		! mhc_permitted( 'edit_shared_vault' ) ? '<% } %>' : ''
	);
	$row_change_structure_button = sprintf(
		'%3$s
			<a href="#" class="mhc-change-structure" title="%1$s"><span>%2$s</span></a>
		%4$s',
		esc_attr__( 'Change Structure', 'mh-composer' ),
		esc_html__( 'Change Structure', 'mh-composer' ),
		! mhc_permitted( 'edit_shared_vault' ) ? '<% if ( ( typeof mhc_shared_module === "undefined" || "" === mhc_shared_module ) && ( typeof mhc_shared_parent === "undefined" || "" === mhc_shared_parent ) ) { %>' : '', 
		// do not display change structure button on shared rows if not permitted for this user
		! mhc_permitted( 'edit_shared_vault' ) ? '<% } %>' : ''
	);
	$row_unlock_button = sprintf(
		'<a href="#" class="mhc-unlock" title="%1$s"><span>%2$s</span></a>',
		esc_attr__( 'Unlock Row', 'mh-composer' ),
		esc_html__( 'Unlock Row', 'mh-composer' )
	);
	// Row Template
	$settings = sprintf(
		'<div class="mhc-controls">
			%1$s
		<%% if ( typeof mhc_template_type === \'undefined\' || \'section\' === mhc_template_type ) { %%>
			%2$s
		<%% }

		if ( typeof mhc_template_type === \'undefined\' || mhc_template_type !== \'module\' ) { %%>
			%4$s
		<%% }

		if ( typeof mhc_template_type === \'undefined\' || \'section\' === mhc_template_type ) { %%>
			%3$s
		<%% } %%>

		<a href="#" class="mhc-expand" title="%5$s"><span>%6$s</span></a>
		%7$s
		</div>',
		mhc_permitted( 'edit_module' ) && ( mhc_permitted( 'general_settings' ) || mhc_permitted( 'advanced_settings' ) || mhc_permitted( 'custom_css_settings' ) ) ? $row_settings_button : '',
		mhc_permitted( 'add_module' ) ? $row_clone_button : '',
		mhc_permitted( 'add_module' ) ? $row_remove_button : '',
		mhc_permitted( 'add_module' ) ? $row_change_structure_button : '',
		esc_attr__( 'Expand Row', 'mh-composer' ),
		esc_html__( 'Expand Row', 'mh-composer' ),
		mhc_permitted( 'lock_module' ) ? $row_unlock_button : ''
	);

	$row_class = sprintf(
		'class="mhc-row-content mhc-data-cid%1$s%2$s <%%= typeof mhc_template_type !== \'undefined\' && \'module\' === mhc_template_type ? \' mhc_hide_insert\' : \'\' %%>"',
		! mhc_permitted( 'move_module' ) ? ' mhc-disable-sort' : '',
		! mhc_permitted( 'edit_shared_vault' )
			? sprintf( '<%%= typeof mhc_shared_parent !== \'undefined\' || typeof mhc_shared_module !== \'undefined\' ? \' mhc-disable-sort\' : \'\' %%>' )
			: ''
	);

	$data_skip = 'data-skip="<%= typeof( mhc_skip_module ) === \'undefined\' ? \'false\' : \'true\' %>"';

	$add_row_button = sprintf(
		'<%% if ( ( typeof mhc_template_type === \'undefined\' || \'section\' === mhc_template_type )%2$s ) { %%>
			<a href="#" class="mhc-row-add">
				<span>%1$s</span>
			</a>
		<%% } %%>',
		esc_html__( 'Add Row', 'mh-composer' ),
		! mhc_permitted( 'edit_shared_vault' ) ? ' && typeof mhc_shared_parent === "undefined"' : '' 
		// do not display add row buton on shared sections if not permitted for this user
	);

	$insert_column_button = sprintf(
		'<a href="#" class="mhc-insert-column">
			<span>%1$s</span>
		</a>',
		esc_html__( 'Add Column(s)', 'mh-composer' )
	);

	printf(
		'<script type="text/template" id="mh-composer-row-template">
			<div class="mhc-right-click-trigger-overlay"></div>
			%1$s
			<div data-cid="<%%= cid %%>" %2$s %3$s>
				<div class="mhc-row-container"></div>
				%4$s
			</div>
			%5$s
			<div class="mhc-locked-overlay mhc-locked-overlay-row"></div>
			<span class="mhc-row-title"><%%= admin_label.replace( /%%22/g, "&quot;" ) %%></span>
		</script>',
		apply_filters( 'mh_composer_row_settings_controls', $settings ),
		$row_class,
		$data_skip,
		mhc_permitted( 'add_module' ) ? $insert_column_button : '',
		mhc_permitted( 'add_module' ) ? $add_row_button : ''
	);


	// Module Block Template
	$clone_button = sprintf(
		'<%% if ( ( typeof mhc_template_type === \'undefined\' || mhc_template_type !== \'module\' )%3$s && _.contains(%4$s, module_type) ) { %%>
			<a href="#" class="mhc-clone mhc-clone-module" title="%1$s">
				<span>%2$s</span>
			</a>
		<%% } %%>',
		esc_attr__( 'Clone Component', 'mh-composer' ),
		esc_html__( 'Clone Component', 'mh-composer' ),
		! mhc_permitted( 'edit_shared_vault' ) ? ' &&  ( typeof mhc_shared_parent === "undefined" || "" === mhc_shared_parent )' : '',
		mhc_permitted_elements()
	);
	$remove_button = sprintf(
		'<%% if ( ( typeof mhc_template_type === \'undefined\' || mhc_template_type !== \'module\' )%3$s && _.contains(%4$s, module_type) ) { %%>
			<a href="#" class="mhc-remove mhc-remove-module" title="%1$s">
				<span>%2$s</span>
			</a>
		<%% } %%>',
		esc_attr__( 'Remove Component', 'mh-composer' ),
		esc_html__( 'Remove Component', 'mh-composer' ),
		! mhc_permitted( 'edit_shared_vault' ) ? ' &&  ( typeof mhc_shared_parent === "undefined" || "" === mhc_shared_parent )' : '',
		mhc_permitted_elements()
	);
	$unlock_button = sprintf(
		'<%% if ( typeof mhc_template_type === \'undefined\' || mhc_template_type !== \'module\' ) { %%>
			<a href="#" class="mhc-unlock" title="%1$s">
				<span>%2$s</span>
			</a>
		<%% } %%>',
		esc_html__( 'Unlock Component', 'mh-composer' ),
		esc_attr__( 'Unlock Component', 'mh-composer' )
	);
	$settings_button = sprintf(
		'<%% if (%3$s _.contains( %4$s, module_type ) ) { %%>
			<a href="#" class="mhc-settings" title="%1$s">
				<span>%2$s</span>
			</a>
		<%% } %%>',
		esc_attr__( 'Component Settings', 'mh-composer' ),
		esc_html__( 'Component Settings', 'mh-composer' ),
		! mhc_permitted( 'edit_shared_vault' ) ? ' ( typeof mhc_shared_parent === "undefined" || "" === mhc_shared_parent ) && ( typeof mhc_shared_module === "undefined" || "" === mhc_shared_module ) &&' : '',
		mhc_permitted_elements()
	);

	printf(
		'<script type="text/template" id="mh-composer-block-module-template">
			%1$s
			%2$s
			%3$s
			%4$s
			<span class="mhc-module-title"><%%= admin_label.replace( /%%22/g, "&quot;" ) %%></span>
		</script>',
		mhc_permitted( 'edit_module' ) && ( mhc_permitted( 'general_settings' ) || mhc_permitted( 'advanced_settings' ) || mhc_permitted( 'custom_css_settings' ) ) ? $settings_button : '',
		mhc_permitted( 'add_module' ) ? $clone_button : '',
		mhc_permitted( 'add_module' ) ? $remove_button : '',
		mhc_permitted( 'lock_module' ) ? $unlock_button : ''
	);


	// Modal Template
	$save_exit_button = sprintf(
		'<a href="#" class="mhc-modal-save button button-primary">
			<span>%1$s</span>
		</a>',
		esc_html__( 'Save', 'mh-composer' )
	);

	$save_template_button = sprintf(
		'<%% if ( typeof mhc_template_type === \'undefined\' || \'\' === mhc_template_type ) { %%>
			<a href="#" class="mhc-modal-save-template button">
				<span>%1$s</span>
			</a>
		<%% } %%>',
		esc_html__( 'Save & Add To Vault', 'mh-composer' )
	);
	$preview_template_button = sprintf(
		'<a class="mhc-modal-preview-template button " href="#">
			<span class="icon"></span>
			<span class="label">%1$s</span>
		</a>',
		esc_html__( 'Preview', 'mh-composer' )
	);

	$can_edit_or_has_modal_view_tab = mhc_permitted( 'edit_module' ) && ( mhc_permitted( 'general_settings' ) || mhc_permitted( 'advanced_settings' ) || mhc_permitted( 'custom_css_settings' ) );

	printf(
		'<script type="text/template" id="mh-composer-modal-template">
			<div class="mhc-modal-container%5$s">

				<a href="#" class="mhc-modal-close">
					<span>%1$s</span>
				</a>

			<%% if ( ! ( typeof open_view !== \'undefined\' && open_view === \'column_specialty_settings\' ) && typeof type !== \'undefined\' && ( type === \'module\' || type === \'section\' || type === \'row_inner\' || ( type === \'row\' && typeof open_view === \'undefined\' ) ) ) { %%>
				<div class="mhc-modal-bottom-container%4$s">
					%3$s
					%2$s
					%6$s
				</div>
			<%% } %%>

			</div>
		</script>',
		esc_html__( 'Cancel', 'mh-composer' ),
		mhc_permitted( 'mharty_vault' ) && mhc_permitted( 'save_vault' ) ? $save_template_button : '',
		$can_edit_or_has_modal_view_tab ? $save_exit_button : '',
		! mhc_permitted( 'mharty_vault' ) || ! mhc_permitted( 'save_vault' ) ? ' mhc_single_button' : '',
		$can_edit_or_has_modal_view_tab ? '' : ' mhc_no_editing',
		$preview_template_button
	);


	// Column Settings Template
	$columns_number =
		'<% if ( view.model.attributes.specialty_columns === 3 ) { %>
			3
		<% } else { %>
			2
		<% } %>';
	$data_specialty_columns = sprintf(
		'<%% if ( typeof view !== \'undefined\' && typeof view.model.attributes.specialty_columns !== \'undefined\' ) { %%>
			data-specialty_columns="%1$s"
		<%% } %%>',
		$columns_number
	);

	$saved_row_tab = sprintf(
		'<li class="mhc-saved-module" data-open_tab="mhc-saved-modules-tab">
			<a href="#">%1$s</a>
		</li>',
		esc_html__( 'Add From Vault', 'mh-composer' )
	);
	$saved_row_container = '<% if ( ( typeof change_structure === \'undefined\' || \'true\' !== change_structure ) && ( typeof mhc_specialty === \'undefined\' || mhc_specialty !== \'on\' ) ) { %>
								<div class="mhc-main-settings mhc-main-settings-full mhc-saved-modules-tab"></div>
							<% } %>';
	printf(
		'<script type="text/template" id="mh-composer-column-settings-template">

			<h3 class="mhc-settings-heading" data-current_row="<%%= cid %%>">%1$s</h3>

		<%% if ( ( typeof change_structure === \'undefined\' || \'true\' !== change_structure ) && ( typeof mhc_specialty === \'undefined\' || mhc_specialty !== \'on\' ) ) { %%>
			<ul class="mhc-options-tabs-links mhc-saved-modules-switcher" %2$s>
				<li class="mhc-saved-module mhc-options-tabs-links-active" data-open_tab="mhc-new-modules-tab" data-content_loaded="true">
					<a href="#">%3$s</a>
				</li>
				%4$s
			</ul>
		<%% } %%>

			<div class="mhc-main-settings mhc-main-settings-full mhc-new-modules-tab active-container">
				<ul class="mhc-column-layouts">
					%5$s
				</ul>
			</div>

			%6$s

		</script>',
		esc_html__( 'Add Columns', 'mh-composer' ),
		$data_specialty_columns,
		esc_html__( 'New Row', 'mh-composer' ),
		mhc_permitted( 'mharty_vault' ) && mhc_permitted( 'add_vault' ) ? $saved_row_tab : '',
		mh_composer_get_columns_layout(),
		mhc_permitted( 'mharty_vault' ) && mhc_permitted( 'add_vault' ) ? $saved_row_container : ''
	);

	// "Add Module" Template
	$fullwidth_class =
		'<% if ( typeof module.fullwidth_only !== \'undefined\' && module.fullwidth_only === \'on\' ) { %> mhc_fullwidth_only_module<% } %>';
	$saved_modules_tab = sprintf(
		'<li class="mhc-saved-module" data-open_tab="mhc-saved-modules-tab">
			<a href="#">%1$s</a>
		</li>',
		esc_html__( 'Add From Vault', 'mh-composer' )
	);
	$saved_modules_container = '<div class="mhc-main-settings mhc-main-settings-full mhc-saved-modules-tab"></div>';
	printf(
		'<script type="text/template" id="mh-composer-modules-template">
			<h3 class="mhc-settings-heading">%1$s</h3>

			<ul class="mhc-options-tabs-links mhc-saved-modules-switcher">
				<li class="mhc-new-module mhc-options-tabs-links-active" data-open_tab="mhc-all-modules-tab">
					<a href="#">%2$s</a>
				</li>

				%3$s
			</ul>

			<div class="mhc-main-settings mhc-main-settings-full mhc-all-modules-tab active-container">
				<ul class="mhc-all-modules">
				<%% _.each(modules, function(module) { %%>
					<%% if ( "mhc_row" !== module.label && "mhc_section" !== module.label && "mhc_column" !== module.label && "mhc_row_inner" !== module.label && _.contains(%6$s, module.label ) ) { %%>
						<li class="<%%= module.label %%>%4$s">
							<span class="mh_module_title"><%%= module.title %%></span>
						</li>
					<%% } %%>
				<%% }); %%>
				</ul>
			</div>

			%5$s
		</script>',
		esc_html__( 'Add Component', 'mh-composer' ),
		esc_html__( 'New Component', 'mh-composer' ),
		mhc_permitted( 'mharty_vault' ) && mhc_permitted( 'add_vault' ) ? $saved_modules_tab : '',
		$fullwidth_class,
		mhc_permitted( 'mharty_vault' ) && mhc_permitted( 'add_vault' ) ? $saved_modules_container : '',
		mhc_permitted_elements()
	);


	// Load Layout Template
	printf(
		'<script type="text/template" id="mh-composer-load_layout-template">
			<h3 class="mhc-settings-heading">%1$s</h3>

		<%% if ( typeof display_switcher !== \'undefined\' && display_switcher === \'on\' ) { %%>
			<ul class="mhc-options-tabs-links mhc-saved-modules-switcher">
				<li class="mhc-saved-module mhc-options-tabs-links-active" data-open_tab="mhc-saved-modules-tab">
					<a href="#">%2$s</a>
				</li>
			</ul>
		<%% } %%>

		<%% if ( typeof display_switcher !== \'undefined\' && display_switcher === \'on\' ) { %%>
			<div class="mhc-main-settings mhc-main-settings-full mhc-saved-modules-tab active-container"></div>
			<div class="mhc-main-settings mhc-main-settings-full mhc-all-modules-tab" style="display: none;"></div>
		<%% } else { %%>
			<div class="mhc-main-settings mhc-main-settings-full mhc-saved-modules-tab active-container"></div>
		<%% } %%>
		</script>',
		esc_html__( 'Layouts', 'mh-composer' ),
		esc_html__( 'Add From Vault', 'mh-composer' )
	);

	$insert_module_button = sprintf(
		'%2$s
		<a href="#" class="mhc-insert-module<%%= typeof mhc_template_type === \'undefined\' || \'module\' !== mhc_template_type ? \'\' : \' mhc_hidden_button\' %%>">
			<span>%1$s</span>
		</a>
		%3$s',
		esc_html__( 'Add Component', 'mh-composer' ),
		! mhc_permitted( 'edit_shared_vault' ) ? '<% if ( typeof mhc_shared_parent === "undefined" ) { %>' : '',
		! mhc_permitted( 'edit_shared_vault' ) ? '<% } %>' : ''
	);
	// Column Template
	printf(
		'<script type="text/template" id="mh-composer-column-template">
			%1$s
		</script>',
		mhc_permitted( 'add_module' ) ? $insert_module_button : ''
	);


	// Advanced Settings Buttons Module
	printf(
		'<script type="text/template" id="mh-composer-advanced-setting">
			<a href="#" class="mhc-advanced-setting-remove">
				<span>%1$s</span>
			</a>

			<a href="#" class="mhc-advanced-setting-options">
				<span>%2$s</span>
			</a>

			<a href="#" class="mhc-clone mhc-advanced-setting-clone">
				<span>%3$s</span>
			</a>
		</script>',
		esc_html__( 'Delete', 'mh-composer' ),
		esc_html__( 'Settings', 'mh-composer' ),
		esc_html__( 'Clone Component', 'mh-composer' )
	);

	// Advanced Settings Modal Buttons Template
	printf(
		'<script type="text/template" id="mh-composer-advanced-setting-edit">
			<div class="mhc-modal-container">
				<a href="#" class="mhc-modal-close">
					<span>%1$s</span>
				</a>

				<div class="mhc-modal-bottom-container">
					<a href="#" class="mhc-modal-save">
						<span>%2$s</span>
					</a>
				</div>
			</div>
		</script>',
		esc_html__( 'Cancel', 'mh-composer' ),
		esc_html__( 'Save', 'mh-composer' )
	);


	// "Deactivate Composer" Modal Message Template
	printf(
		'<script type="text/template" id="mh-composer-prompt-modal-deactivate_composer-text">
			<h3>%1$s</h3>
			<p>%2$s</p>
			<p>%3$s</p>
		</script>',
		esc_html__( 'Disable Composer', 'mh-composer' ),
		esc_html__( 'All content created in the Page Composer will be lost.', 'mh-composer' ),
		esc_html__( 'Do you want to proceed?', 'mh-composer' )
	);


	// "Clear Layout" Modal Window Template
	printf(
		'<script type="text/template" id="mh-composer-prompt-modal-clear_layout-text">
			<h3>%1$s</h3>
			<p>%2$s</p>
			<p>%3$s</p>
		</script>',
		esc_html__( 'Clear Layout', 'mh-composer' ),
		esc_html__( 'All content created in this page will be lost.', 'mh-composer' ),
		esc_html__( 'Do you want to proceed?', 'mh-composer' )
	);


	// "Reset Advanced Settings" Modal Template
	printf(
		'<script type="text/template" id="mh-composer-prompt-modal-reset_advanced_settings-text">
			<p>%1$s</p>
			<p>%2$s</p>
		</script>',
		esc_html__( 'All advanced settings in will be lost.', 'mh-composer' ),
		esc_html__( 'Do you want to proceed?', 'mh-composer' )
	);


	// "Save Layout" Modal Window Template
	printf(
		'<script type="text/template" id="mh-composer-prompt-modal-save_layout">
			<div class="mhc_prompt_modal">
				<a href="#" class="mhc_prompt_dont_proceed mhc-modal-close">
					<span>%1$s</span>
				</a>
				<div class="mhc_prompt_buttons">
					<br/>
					<input type="submit" class="mhc_prompt_proceed" value="%2$s" />
				</div>
			</div>
		</script>',
		esc_html__( 'Cancel', 'mh-composer' ),
		esc_html__( 'Save', 'mh-composer' )
	);


	// "Save Layout" Modal Content Template
	printf(
		'<script type="text/template" id="mh-composer-prompt-modal-save_layout-text">
			<h3>%1$s</h3>
			<p>%2$s</p>

			<label>%3$s</label>
			<input type="text" value="" id="mhc_new_layout_name" class="regular-text" />
		</script>',
		esc_html__( 'Save To Vault', 'mh-composer' ),
		esc_html__( 'Save your current page to the Composer Vault for later use.', 'mh-composer' ),
		esc_html__( 'Layout Name:', 'mh-composer' )
	);


	// "Save Template" Modal Window Layout
	printf(
		'<script type="text/template" id="mh-composer-prompt-modal-save_template">
			<div class="mhc_prompt_modal mhc_prompt_modal_save_vault">
				<div class="mhc_prompt_buttons">
					<br/>
					<input type="submit" class="mhc_prompt_proceed" value="%1$s" />
				</div>
			</div>
		</script>',
		esc_attr__( 'Save & Add To Vault', 'mh-composer' )
	);


	// "Save Template" Content Layout
	$layout_categories = get_terms( 'layout_category', array( 'hide_empty' => false ) );
	$categories_output = sprintf( '<div class="mhc-option"><label>%1$s</label>',
		esc_html__( 'Add To Categories:', 'mh-composer' )
	);

	if ( is_array( $layout_categories ) && ! empty( $layout_categories ) ) {
		$categories_output .= '<div class="mhc-option-container layout_cats_container">';
		foreach( $layout_categories as $category ) {
			$categories_output .= sprintf( '<label>%1$s<input type="checkbox" value="%2$s"/></label>',
				esc_html( $category->name ),
				esc_attr( $category->term_id )
			);
		}
		$categories_output .= '</div></div>';
	}

	$categories_output .= sprintf( '
		<div class="mhc-option">
			<label>%1$s:</label>
			<div class="mhc-option-container">
				<input type="text" value="" id="mhc_new_cat_name" class="regular-text" />
			</div>
		</div>',
		esc_html__( 'Create New Category', 'mh-composer' )
	);

	$general_checkbox = sprintf(
		'<label>
			<i class="mhc_general_icon"></i>%1$s <input type="checkbox" value="general" id="mhc_template_general" checked />
		</label>',
		esc_html__( 'Include General Settings', 'mh-composer' )
	);
	$advanced_checkbox = sprintf(
		'<label>
			<i class="mhc_advanced_icon"></i>%1$s <input type="checkbox" value="advanced" id="mhc_template_advanced" checked />
		</label>',
		esc_html__( 'Include Advanced Settings', 'mh-composer' )
	);
	$css_checkbox = sprintf(
		'<label>
			<i class="mhc_css_icon"></i>%1$s <input type="checkbox" value="css" id="mhc_template_css" checked />
		</label>',
		esc_html__( 'Include CSS Settings', 'mh-composer' )
	);

	printf(
		'<script type="text/template" id="mh-composer-prompt-modal-save_template-text">
			<div class="mhc-main-settings">
				<p>%1$s</p>

				<div class="mhc-option">
					<label>%2$s:</label>

					<div class="mhc-option-container">
						<input type="text" value="" id="mhc_new_template_name" class="regular-text" />
					</div>
				</div>

			<%% if ( \'module\' === module_type ) { %%>
				<div class="mhc-option">
					<label>%3$s:</label>

					<div class="mhc-option-container mhc_select_module_tabs">
						%4$s

						%5$s

						%6$s
						<p class="mhc_error_message_save_template" style="display: none;">
							%7$s
						</p>
					</div>
				</div>
			<%% } %%>

			<%% if ( \'shared\' !== is_shared && \'shared\' !== is_shared_child ) { %%>
				<div class="mhc-option">
					<label>%8$s</label>

					<div class="mhc-option-container">
						<label>
							%9$s <input type="checkbox" value="" id="mhc_template_shared" />
						</label>
					</div>
				</div>
			<%% } %%>

				%10$s
			</div>
		</script>',
		esc_html__( 'Here you can save the current item and add it to your Composer Vault for later use as well.', 'mh-composer' ),
		esc_html__( 'Layout Name', 'mh-composer' ),
		esc_html__( 'Selective Sync', 'mh-composer' ),
		mhc_permitted( 'general_settings' ) ? $general_checkbox : '',
		mhc_permitted( 'advanced_settings' ) ? $advanced_checkbox : '',
		mhc_permitted( 'custom_css_settings' ) ? $css_checkbox : '',
		esc_html__( 'Please select at least 1 tab to save', 'mh-composer' ),
		esc_html__( 'Save as Shared:', 'mh-composer' ),
		esc_html__( 'Make this a shared item', 'mh-composer' ),
		$categories_output
	);


	// Prompt Modal Window Template
	printf(
		'<script type="text/template" id="mh-composer-prompt-modal">
			<div class="mhc_prompt_modal">
				<a href="#" class="mhc_prompt_dont_proceed mhc-modal-close">
					<span>%1$s<span>
				</a>

				<div class="mhc_prompt_buttons">
					<a href="#" class="mhc_prompt_proceed">%2$s</a>
				</div>
			</div>
		</script>',
		esc_html__( 'No', 'mh-composer' ),
		esc_html__( 'Yes', 'mh-composer' )
	);
	
	// "Add Advanced Section" Button Template
	printf(
		'<script type="text/template" id="mh-composer-add-specialty-section-button">
			<a href="#" class="mhc-section-add-specialty mhc-add-specialty-template" data-is_template="true">%1$s</a>
		</script>',
		esc_html__( 'Add Advanced Section', 'mh-composer' )
	);


	// Saved Entry Template
	echo
		'<script type="text/template" id="mh-composer-saved-entry">
			<a class="mhc_saved_entry_item"><%= title %></a>
		</script>';

	// Font Icons Template
	printf(
		'<script type="text/template" id="mh-composer-font-icon-list-items">
			%1$s
		</script>',
		mhc_get_font_icon_list_items()
	);
	
	if( class_exists( 'MHMoreIconsClass', false ) ) {
		if ('on' === (mh_get_option('mharty_use_steadysets', 'false'))){
	// Font Icons Template
	printf(
		'<script type="text/template" id="mh-composer-font-steadysets-icon-list-items">
			%1$s
		</script>',
		mhc_get_font_steadysets_icon_list_items()
	);
		}
		if ('on' === (mh_get_option('mharty_use_awesome', 'false'))){
	// Font Icons Template
	printf(
		'<script type="text/template" id="mh-composer-font-awesome-icon-list-items">
			%1$s
		</script>',
		mhc_get_font_awesome_icon_list_items()
	);
		}
		
		if ('on' === (mh_get_option('mharty_use_lineicons', 'false'))){
				// Font Icons Template			
		printf('<script type="text/template" id="mh-composer-font-lineicons-icon-list-items">
			%1$s
		</script>',
		mhc_get_font_lineicons_icon_list_items()
	);
		}
	
		if ('on' === (mh_get_option('mharty_use_icomoon', 'false'))){
		// Font Icons Template
	printf(
		'<script type="text/template" id="mh-composer-font-icomoon-icon-list-items">
			%1$s
		</script>',
		mhc_get_font_icomoon_icon_list_items()
	);
		}
		if ('on' === (mh_get_option('mharty_use_etline', 'false'))){
	// Font Icons Template
	printf(
		'<script type="text/template" id="mh-composer-font-etline-icon-list-items">
			%1$s
		</script>',
		mhc_get_font_etline_icon_list_items()
	);
		}
		if ('on' === (mh_get_option('mharty_use_linearicons', 'false'))){
		// Font Icons Template
	printf(
		'<script type="text/template" id="mh-composer-font-linearicons-icon-list-items">
			%1$s
		</script>',
		mhc_get_font_linearicons_icon_list_items()
	);
		}
	} //end if
	// Histories Visualizer Item Template
	printf(
		'<script type="text/template" id="mh-composer-histories-visualizer-item-template">
			<li id="mhc-history-<%%= this.options.get( "timestamp" ) %%>" class="<%%= this.options.get( "current_active_history" ) ? "active" : "undo"  %%>" data-timestamp="<%%= this.options.get( "timestamp" )  %%>">
				<span class="datetime"><%%= this.options.get( "datetime" )  %%></span>
				<span class="verb"> <%%= this.getVerb()  %%></span>
				<span class="noun"> <%%= this.getNoun()  %%></span>
			</li>
		</script>'
	);
	
	printf(
		'<script type="text/template" id="mh-composer-preview-icons-template">
			<ul class="mhc-preview-screensize-switcher">
				<li><a href="#" class="mhc-preview-desktop active"><span class="label">%3$s</span></a></li>
				<li><a href="#" class="mhc-preview-tablet" data-width="767"><span class="label">%2$s</span></a></li>
				<li><a href="#" class="mhc-preview-mobile" data-width="375"><span class="label">%1$s</span></a></li>
			</ul>
		</script>',
		esc_html__( 'Mobile', 'mh-composer' ),
		esc_html__( 'Tablet', 'mh-composer' ),
		esc_html__( 'Desktop', 'mh-composer' )
	);
	
	printf(
		'<script type="text/template" id="mh-composer-options-tabs-links-template">
			<ul class="mhc-options-tabs-links">
				<%% _.each(this.mh_composer_template_options.tabs.options, function(tab, index) { %%>
					<li class="mhc_options_tab_<%%= tab.slug %%><%%= \'1\' === index ? \' mhc-options-tabs-links-active\' : \'\' %%>">
						<a href="#" title="<%%= tab.label %%>"></a>
					</li>
				<%% }); %%>
			</ul>
		</script>'
	);
	
	printf(
		'<script type="text/template" id="mh-composer-mobile-options-tabs-template">
			<div class="mhc_mobile_settings_tabs">
				<a href="#" class="mhc_mobile_settings_tab mhc_mobile_settings_active_tab" data-settings_tab="desktop">
					%1$s
				</a>
				<a href="#" class="mhc_mobile_settings_tab" data-settings_tab="tablet">
					%2$s
				</a>
				<a href="#" class="mhc_mobile_settings_tab" data-settings_tab="phone">
					%3$s
				</a>
			</div>
		</script>',
		esc_html__( 'Desktop', 'mh-composer' ),
		esc_html__( 'Tablet', 'mh-composer' ),
		esc_html__( 'Mobile', 'mh-composer' )
	);
	
	printf(
		'<script type="text/template" id="mh-composer-switch-button-template">
			<div class="mhc_switch_button mhc_off_state">
				<span class="mhc_value_text mhc_on_value"><%%= this.mh_composer_template_options.switch_button.options.on %%></span>
				<span class="mhc_button_slider"></span>
				<span class="mhc_value_text mhc_off_value"><%%= this.mh_composer_template_options.switch_button.options.off %%></span>
			</div>
		</script>'
	);
	
	do_action( 'mhc_after_page_composer' );
}

/**
 * Modify editor's TinyMCE configuration in MHComposer
 *
 * @return array
 */
function mhc_content_new_modify_mce( $mceInit, $editor_id ) {
	if ( 'mhc_content_new' === $editor_id && isset( $mceInit['toolbar1'] ) ) {
		// Get toolbar as array
		$toolbar1 = explode(',', $mceInit['toolbar1'] );

		// Look for read more (wp_more)'s array' key
		$wp_more_key = array_search( 'wp_more', $toolbar1 );

		if ( $wp_more_key ) {
			unset( $toolbar1[ $wp_more_key ] );
		}

		// Update toolbar1 configuration
		$mceInit['toolbar1'] = implode(',', $toolbar1 );
	}

	return $mceInit;
}
add_filter( 'tiny_mce_before_init', 'mhc_content_new_modify_mce', 10, 2 );


/**
 * Return post format into false when using pagecomposer
 *
 * @return mixed string|bool string of post format or false for default
 */
function mh_post_format_in_pagecomposer( $post_format, $post_id ) {

	if ( mh_composer_is_active( $post_id ) ) {
		return false;
	}

	return $post_format;
}
add_filter( 'mh_post_format', 'mh_post_format_in_pagecomposer', 10, 2 );

if ( ! function_exists( 'mhc_get_audio_player' ) ) :
function mhc_get_audio_player() {
	$output = sprintf(
		'<div class="mh_audio_container">
			%1$s
		</div> <!-- .mh_audio_container -->',
		do_shortcode( '[audio]' )
	);

	return $output;
}
endif;

/**
 * Fix JetPack post excerpt shortcode issue.
 */
function mh_jetpack_post_excerpt( $results ) {
    foreach ( $results as $key => $post ) {
        if ( isset( $post['excerpt'] ) ) {
        	// Remove MHComposer shortcodes from JetPack excerpt.
            $results[$key]['excerpt'] = preg_replace( '#\[mhc(.*)\]#', '', $post['excerpt'] );
        }
    }
    return $results;
}
add_filter( 'jetpack_relatedposts_returned_results', 'mh_jetpack_post_excerpt' );

/**
 * Adds a mh-composer gallery type when the Jetpack plugin is enabled
 */
function mh_jetpack_gallery_type( $types ) {
	$types['mh-composer'] = 'mh-composer';
	return $types;
}
add_filter( 'jetpack_gallery_types', 'mh_jetpack_gallery_type' );

if ( ! function_exists( 'mh_get_gallery_attachments' ) ) :
/**
 * Fetch the gallery attachments
 */
function mh_get_gallery_attachments( $attr ) {
	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] ) {
			unset( $attr['orderby'] );
		}
	}
	$html5 = current_theme_supports( 'html5', 'gallery' );
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => get_the_ID() ? get_the_ID() : 0,
		'itemtag'    => $html5 ? 'figure'     : 'dl',
		'icontag'    => $html5 ? 'div'        : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => '',
	), $attr, 'gallery' );

	$id = intval( $atts['id'] );
	if ( 'RAND' == $atts['order'] ) {
		$atts['orderby'] = 'none';
	}
	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array(
			'include'        => $atts['include'],
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $atts['order'],
			'orderby'        => $atts['orderby'],
		) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array(
			'post_parent'    => $id,
			'exclude'        => $atts['exclude'],
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $atts['order'],
			'orderby'        => $atts['orderby'],
		) );
	} else {
		$attachments = get_children( array(
			'post_parent'    => $id,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $atts['order'],
			'orderby'        => $atts['orderby'],
		) );
	}

	return $attachments;
}
endif;

/**
 * Generate the HTML for custom gallery layouts
 */
function mh_gallery_layout( $val, $attr ) {
	// check to see if the gallery output is already rewritten
	if ( ! empty( $val ) ) {
		return $val;
	}

	return $val;
	
	if ( ! apply_filters( 'mh_gallery_layout_enable', false ) ) {
		return $val;
	}
	
	$output = '';

	if ( ! is_singular() && ! mh_composer_is_active( get_the_ID() ) ) {
		$attachments = mh_get_gallery_attachments( $attr );
		$gallery_output = '';
		foreach ( $attachments as $attachment ) {
			$attachment_image = wp_get_attachment_url( $attachment->ID, 'mhc-post-main-image-fullwidth' );
			$gallery_output .= sprintf(
				'<div class="mhc_slide" style="background: url(%1$s);"></div>',
				esc_attr( $attachment_image )
			);
		}
		$output = sprintf(
			'<div class="mhc_slider mhc_slider_fullwidth_off mhc_gallery_post_type">
				<div class="mhc_slides">
					%1$s
				</div>
			</div>',
			$gallery_output
		);

	} else {
		if ( ! isset( $attr['type'] ) || ! in_array( $attr['type'], array( 'rectangular', 'square', 'circle', 'rectangle' ) ) ) {
			$attachments = mh_get_gallery_attachments( $attr );
			$gallery_output = '';
			foreach ( $attachments as $attachment ) {
				$gallery_output .= sprintf(
					'<li class="mh_gallery_item">
						<a href="%1$s" title="%3$s">
							<span class="mh_portfolio_image">
								%2$s
								<span class="mh_overlay"></span>
							</span>
						</a>
						%4$s
					</li>',
					esc_url( wp_get_attachment_url( $attachment->ID, 'full' ) ),
					wp_get_attachment_image( $attachment->ID, 'mhc-portfolio-image' ),
					esc_attr( $attachment->post_title ),
					! empty( $attachment->post_excerpt )
						? sprintf( '<p class="mhc_gallery_caption">%1$s</p>', esc_html( $attachment->post_excerpt ) )
						: ''
				);
			}
			$output = sprintf(
				'<ul class="mh_post_gallery clearfix">
					%1$s
				</ul>',
				$gallery_output
			);
		}
	}
	return $output;
}
add_filter( 'post_gallery', 'mh_gallery_layout', 1000, 2 );

if ( ! function_exists( 'mhc_gallery_images' ) ) :
function mhc_gallery_images( $force_gallery_layout = '' ) {
	if ( 'slider' === $force_gallery_layout ) {
		$attachments = get_post_gallery( get_the_ID(), false );
		$gallery_output = '';
		$output = '';
		$images_array = ! empty( $attachments['ids'] ) ? explode( ',', $attachments['ids'] ) : array();

		if ( empty ( $images_array ) ) {
			return $output;
		}

		foreach ( $images_array as $attachment ) {
			$image_src = wp_get_attachment_url( $attachment, 'mhc-post-main-image-fullwidth' );
			$gallery_output .= sprintf(
				'<div class="mhc_slide" style="background: url(%1$s);"></div>',
				esc_url( $image_src )
			);
		}
		printf(
			'<div class="mhc_slider mhc_slider_fullwidth_off mhc_gallery_post_type">
				<div class="mhc_slides">
					%1$s
				</div>
			</div>',
			$gallery_output
		);
	} else {
		add_filter( 'mh_gallery_layout_enable', 'mh_gallery_layout_turn_on' );
		printf( do_shortcode( '%1$s' ), get_post_gallery() );
		remove_filter( 'mh_gallery_layout_enable', 'mh_gallery_layout_turn_on' );
	}
}
endif;

/**
 * This is to allow gallery in mhc_gallery_images
 */
function mh_gallery_layout_turn_on() {
	return true;
}

/*
 * Remove MHComposer plugin filter, that activates visual mode on each page load in WP-Admin
 */
function mhc_remove_lb_plugin_force_editor_mode() {
	remove_filter( 'wp_default_editor', 'mh_force_tmce_editor' );
}
add_action( 'admin_init', 'mhc_remove_lb_plugin_force_editor_mode' );

/**
 *
 * Generates array of all Role options
 *
 */
function mhc_all_role_options() {
	// get all the modules and build array of capabilities for them
	$all_modules_array = MHComposer_Core::get_modules_array();
	$module_capabilies = array();

	foreach ( $all_modules_array as $module => $module_details ) {
		if ( ! in_array( $module_details['label'], array( 'mhc_section', 'mhc_row', 'mhc_row_inner', 'mhc_column' ) ) ) {
			$module_capabilies[ $module_details['label'] ] = array(
				'name'    => sanitize_text_field( $module_details['title'] ),
				'default' => 'on',
			);
		}
	}
	
	$all_role_options = array(
		'composer_capabilities' => array(
			'section_title' => esc_html__( 'Composer Interface', 'mh-composer'),
			'options'       => array(
				'mharty_vault'  => array(
					'name'    => esc_html__( 'Composer Vault', 'mh-composer' ),
					'default' => 'on',
				),
				'mharty_composer_control' => array(
					'name'    => esc_html__( 'Use Composer Button', 'mh-composer' ),
					'default' => 'on',
				),
				'load_layout' => array(
					'name'    => esc_html__( 'Load Layout', 'mh-composer' ),
					'default' => 'on',
				),
				'save_vault' => array(
					'name'    => esc_html__( 'Save To Vault', 'mh-composer' ),
					'default' => 'on',
				),
				'add_vault' => array(
					'name'    => esc_html__( 'Add From Vault', 'mh-composer' ),
					'default' => 'on',
				),
				'edit_shared_vault' => array(
					'name'    => esc_html__( 'Edit Shared Items', 'mh-composer' ),
					'default' => 'on',
				),
				'add_module' => array(
					'name'    => esc_html__( 'Add/Delete Item', 'mh-composer' ),
					'default' => 'on',
				),
				'edit_module' => array(
					'name'    => esc_html__( 'Edit Item', 'mh-composer' ),
					'default' => 'on',
				),
				'move_module' => array(
					'name'    => esc_html__( 'Move Item', 'mh-composer' ),
					'default' => 'on',
				),
				'disable_module' => array(
					'name'    => esc_html__( 'Disable Item', 'mh-composer' ),
					'default' => 'on',
				),
				'lock_module' => array(
					'name'    => esc_html__( 'Lock Item', 'mh-composer' ),
					'default' => 'on',
				),

			),
		),
		'module_tabs' => array(
			'section_title' => esc_html__( 'Settings Tabs', 'mh-composer' ),
			'options'       => array(
				'general_settings' => array(
					'name'    => esc_html__( 'General Settings', 'mh-composer' ),
					'default' => 'on',
				),
				'advanced_settings' => array(
					'name'    => esc_html__( 'Advanced Settings', 'mh-composer' ),
					'default' => 'on',
				),
				'custom_css_settings' => array(
					'name'    => esc_html__( 'CSS Settings', 'mh-composer' ),
					'default' => 'on',
				),
			),
		),
		'module_capabilies' => array(
			'section_title' => esc_html__( 'Component Use', 'mh-composer' ),
			'options'       => $module_capabilies,
		),
	);
	
	// Set (impoexpo) capabilities.
	$registered_impoexpos = mh_app_cache_get_group( 'mh_app_impoexpo' );

	if ( ! empty( $registered_impoexpos ) ) {
		$all_role_options['impoexpo'] = array(
			'section_title' => esc_html__( 'Export &amp; Import', 'mh-composer' ),
			'options'       => array(),
		);

		// Dynamically create an option foreach impoexpo.
		foreach ( $registered_impoexpos as $impoexpo_context => $impoexpo_instance ) {
			$all_role_options['impoexpo']['options']["{$impoexpo_context}_impoexpo"] = array(
				'name'    => esc_html__( $impoexpo_instance->name, 'mh-composer' ),
				'default' => 'on',
			);
		}
	}


	return $all_role_options;
}
/**
 *
 * Prints the admin page for Role Editor
 *
 */
function mhc_display_roles_manager() {
	$all_role_options = mhc_all_role_options();
	$option_tabs = '';
	$menu_tabs = '';

	// get all roles registered in current WP
	if ( ! function_exists( 'get_editable_roles' ) ) {
		require_once( ABSPATH . '/wp-admin/includes/user.php' );
	}

	$all_roles = get_editable_roles();
	$composer_roles_array = array();

	if ( ! empty( $all_roles ) ) {
		foreach( $all_roles as $role => $role_data ) {
			// add roles with edit_posts capability into $composer_roles_array
			if ( ! empty( $role_data['capabilities']['edit_posts'] ) && 1 === (int) $role_data['capabilities']['edit_posts'] ) {
				$composer_roles_array[ $role ] = $role_data['name'];
			}
		}
	}
	
	// fill the composer roles array with default roles if it's empty
	if ( empty( $composer_roles_array ) ) {
		$composer_roles_array = array(
			'administrator' => esc_html__( 'Administrator', 'mh-composer' ),
			'editor'        => esc_html__( 'Editor', 'mh-composer' ),
			'author'        => esc_html__( 'Author', 'mh-composer' ),
			'contributor'   => esc_html__( 'Contributor', 'mh-composer' ),
		);
	}

	foreach( $composer_roles_array as $role => $role_title ) {
		$option_tabs .= mhc_generate_roles_tab( $all_role_options, $role );

		$menu_tabs .= sprintf(
			'<a href="#" class="mhc-layout-buttons%4$s" data-open_tab="mhc_role-%3$s_options" title="%1$s">
				<span>%2$s</span>
			</a>',
			esc_attr( $role_title ),
			esc_html__( $role_title, 'mh-composer' ), // needed to get strings translated
			esc_attr( $role ),
			'administrator' === $role ? ' mhc_roles_active_menu' : ''
		);
	}

	printf(
		'<div class="mhc_roles_main_container">
			<a href="#" id="mhc_save_roles" class="button button-primary button-large">%3$s</a>
				<div class ="mhc_roles_header">
					<h1 class="mhc_roles_title">%2$s</h1>
					<a href="#" class="mh-app-defaults-button mhc-layout-buttons-reset" title="Reset all settings">
						<span class="icon"></span><span class="label">Reset</span>
					</a>
				</div>
			<div id="mhc_main_container" class="post-type-page">
				<div id="mhc_layout_controls">
					%1$s
				</div>
			</div>
			<div class="mhc_roles_container_all">
				%4$s
			</div>
		</div>',
		$menu_tabs,
		esc_html__( 'Composer Roles Manager', 'mh-composer' ),
		esc_html__( 'Save Composer Roles', 'mh-composer' ),
		$option_tabs
		//mh_app_impoexpo_link( 'mhc_roles', array( 'class' => 'mh-app-defaults-button mhc-impoexpo-button' ) ),
	);
}

/**
 *
 * Generates the options tab for specified role.
 *
 * @return string
 */
function mhc_generate_roles_tab( $all_role_options, $role ) {
	$form_sections = '';

	// generate all sections of the form for current role.
	if ( ! empty( $all_role_options ) ) {
		foreach( $all_role_options as $capability_id => $capability_options ) {
			$form_sections .= sprintf(
				'<div class="mhc_roles_section_container">
					%1$s
					<div class="mhc_roles_options_internal">
						%2$s
					</div>
				</div>',
				! empty( $capability_options['section_title'] )
					? sprintf( '<h4 class="mhc_roles_divider">%1$s <span class="mhc_toggle_all"></span></h4>', esc_html( $capability_options['section_title'] ) )
					: '',
				mhc_generate_capabilities_output( $capability_options['options'], $role )
			);
		}
	}

	$output = sprintf(
		'<div class="mhc_roles_options_container mhc_role-%2$s_options%3$s">
			<p class="mhc_roles_notice">%1$s</p>
			<form id="mhc_%2$s_role" data-role_id="%2$s">
				%4$s
			</form>
		</div>',
		esc_html__( 'MH Composer Roles Manager will let you limit the actions and components that can be available to your website users to ensure that they only have the necessary options available to them.', 'mh-composer' ),
		esc_attr( $role ),
		'administrator' === $role ? ' active-container' : '',
		$form_sections // #4
	);

	return $output;
}

/**
 *
 * Generates the enable/disable buttons list based on provided capabilities array and role
 *
 * @return string
 */
function mhc_generate_capabilities_output( $cap_array, $role ) {
	$output = '';
	$saved_capabilities = get_option( 'mhc_role_settings', array() );

	if ( ! empty( $cap_array ) ) {
		foreach ( $cap_array as $capability => $capability_details ) {
			if ( empty( $capability_details['applicability'] ) || ( ! empty( $capability_details['applicability'] ) && in_array( $role, $capability_details['applicability'] ) ) ) {
				$output .= sprintf(
					'<div class="mhc_capability_option">
						<span class="mhc_capability_title">%4$s</span>
						<div class="mhc_switch_button_wrapper">
							<div class="mhc_switch_button mhc_on_state">
								<span class="mhc_value_text mhc_on_value">%1$s</span>
								<span class="mhc_button_slider"></span>
								<span class="mhc_value_text mhc_off_value">%2$s</span>
							</div>
							<select name="%3$s" id="%3$s" class="mhc-main-setting regular-text">
								<option value="on" %5$s>Yes</option>
								<option value="off" %6$s>No</option>
							</select>
						</div>
					</div>',
					esc_html__( 'Enabled', 'mh-composer' ),
					esc_html__( 'Disabled', 'mh-composer' ),
					esc_attr( $capability ),
					esc_html__( $capability_details['name'], 'mh-composer' ), // needed to get strings translated
					! empty( $saved_capabilities[$role][$capability] ) ? selected( 'on', $saved_capabilities[$role][$capability], false ) : selected( 'on', $capability_details['default'], false ),
					! empty( $saved_capabilities[$role][$capability] ) ? selected( 'off', $saved_capabilities[$role][$capability], false ) : selected( 'off', $capability_details['default'], false )
				);
			}
		}
	}

	return $output;
}

/**
 *
 * Loads scripts and styles for Role Editor Admin page
 *
 */
function mhc_load_roles_admin( $hook ) {
	// load scripts only on role editor page
	
	//@todo page hooks get translated as WP bug.
	//if ( 'theme-panel_page_mh_mharty_roles_manager' !== $hook ) {
	global $admin_page_hooks;
	$screen = get_current_screen();
	if ( !( !empty( $screen ) && !empty( $admin_page_hooks['mh_panel'] ) &&  $screen->base == $admin_page_hooks['mh_panel'] . '_page_mh_mharty_roles_manager' )) {
 	return;
	}
	$ltr = is_rtl() ? "" : "-ltr";
	// enqueue your assets
	wp_enqueue_style( 'mhc-roles-css', MH_COMPOSER_URI . '/css/roles'. $ltr .'.css' );
	wp_enqueue_script( 'mhc-roles-js', MH_COMPOSER_URI . '/js/roles.js', array( 'jquery', 'mhc_admin_js' ), MH_COMPOSER_VER, true );
	wp_localize_script( 'mhc-roles-js', 'mhc_roles_options', array(
		'ajaxurl'        => admin_url( 'admin-ajax.php' ),
		'mhc_roles_nonce' => wp_create_nonce( 'mhc_roles_nonce' ),
		'modal_title'    => esc_html__( 'Reset Roles', 'mh-composer' ),
		'modal_message'  => esc_html__( 'All of your current role settings will be set to defaults. Do you want to proceed?', 'mh-composer' ),
		'modal_yes'      => esc_html__( 'yes', 'mh-composer' ),
		'modal_no'       => esc_html__( 'no', 'mh-composer' ),
	) );

}
add_action( 'admin_enqueue_scripts', 'mhc_load_roles_admin' );

/**
 * The array of permitted components jQuery Array
 * @return string
 */
function mhc_permitted_elements( $role = '' ) {
	global $typenow;
	
	// always return empty array if user doesn't have the edit_posts capability
	if ( ! current_user_can( 'edit_posts' ) ) {
		return "[]";
	}

	$saved_capabilities = mhc_get_role_settings();
	$role = '' === $role ? mhc_get_current_user_role() : $role;
	$all_modules_array = MHComposer_Core::get_modules_array( $typenow );
	
	$saved_modules_capabilities = isset( $saved_capabilities[ $role ] ) ? $saved_capabilities[ $role ] : array();

	$alowed_modules = "[";
	foreach ( $all_modules_array as $module => $module_details ) {
		if ( ! in_array( $module_details['label'], array( 'mhc_section', 'mhc_row', 'mhc_row_inner', 'mhc_column' ) ) ) {
			// Add module into the list if it's not saved or if it's saved not with "off" state
			if ( ! isset( $saved_modules_capabilities[ $module_details['label'] ] ) || ( isset( $saved_modules_capabilities[ $module_details['label'] ] ) && 'off' !== $saved_modules_capabilities[ $module_details['label'] ] ) ) {
				$alowed_modules .= "'" . $module_details['label'] . "',";
			}
		}
	}

	//$alowed_modules = "[";
//
//	foreach ( $saved_modules_capabilities as $capability => $cap_state ) {
//		if ( false !== strpos( $capability, 'mhc_' ) && 'off' !== $cap_state ) {
//			$alowed_modules .= "'" . $capability . "',";
//		}
//	}

	$alowed_modules .= "]";

	return $alowed_modules;
}


/**
 * Register rewrite rule and tag for preview page
 * @return void
 */
function mhc_register_preview_endpoint() {
	add_rewrite_tag( '%mhc_preview%', 'true' );
}
add_action( 'init', 'mhc_register_preview_endpoint', 11 );

/**
 * Flush rewrite rules to fix the issue "preg_match" issue with 2.5
 * @return void
 */
function mhc_maybe_flush_rewrite_rules() {
	mh_composer_maybe_flush_rewrite_rules( '2_5_flush_rewrite_rules' );

}
add_action( 'init', 'mhc_maybe_flush_rewrite_rules', 9 );

/**
 * Register template for preview page
 * @return string path to template file
 */
function mhc_register_preview_page( $template ) {
	global $wp_query;

	if ( 'true' === $wp_query->get( 'mhc_preview' ) && isset( $_GET['mhc_preview_nonce'] ) ) {
		show_admin_bar( false );

		return MH_COMPOSER_DIR . 'template-preview.php';
	}

	return $template;
}
add_action( 'template_include', 'mhc_register_preview_page' );

/**
 * do_shortcode() replaces square brackers with html entities,
 * convert them back to make sure js code works ok
 */
if ( ! function_exists( 'mh_composer_replace_code_content_entities' ) ) :
function mh_composer_replace_code_content_entities( $content ) {
	$content = str_replace( '&#091;', '[', $content );
	$content = str_replace( '&#093;', ']', $content );
	$content = str_replace( '&#215;', 'x', $content );

	return $content;
}
endif;

// adjust the number of all layouts displayed on vault page to exclude preset layouts
function mhc_fix_count_vault_items( $counts ) {
	// do nothing if get_current_screen function doesn't exists at this point to avoid php errors in some plugins.
	if ( ! function_exists( 'get_current_screen' ) ) {
		return $counts;
	}

	$current_screen = get_current_screen();

	if ( isset( $current_screen->id ) && 'edit-mhc_layout' === $current_screen->id && isset( $counts->publish ) ) {
		// perform query to get all the not preset layouts
		$query = new WP_Query( array(
			'meta_query'      => array(
				array(
					'key'     => '_mhc_preset_layout',
					'value'   => 'on',
					'compare' => 'NOT EXISTS',
				),
			),
			'post_type'       => MH_COMPOSER_LAYOUT_POST_TYPE,
			'posts_per_page'  => '-1',
		) );

		// set the $counts->publish = amount of non preset layouts
		$counts->publish = isset( $query->post_count ) ? (int) $query->post_count : 0;
	}

	return $counts;
}
add_filter( 'wp_count_posts', 'mhc_fix_count_vault_items' );

/* Exclude library related taxonomies from Yoast SEO Sitemap */
function mh_wpseo_sitemap_exclude_taxonomy( $value, $taxonomy ) {
	$excluded = array( 'scope', 'module_width', 'layout_type', 'layout_category', 'layout' );

	if ( in_array( $taxonomy, $excluded ) ) {
		return true;
	}

	return false;
}
add_filter( 'wpseo_sitemap_exclude_taxonomy', 'mh_wpseo_sitemap_exclude_taxonomy', 10, 2 );

/**
 * Is Yoast SEO plugin active?
 *
 * @return bool  True - if the plugin is active
 */
if ( ! function_exists( 'mh_is_yoast_seo_plugin_active' ) ) :
function mh_is_yoast_seo_plugin_active() {
	return class_exists( 'WPSEO_Options', false );
}
endif;

/**
 * Display the Notice about cache once the theme was udpated
 */
function mhc_maybe_display_cache_notice() {
	$ignore_notice_option = get_option( 'mhc_cache_notice', array() );
	$ignore_this_notice = empty( $ignore_notice_option[ MH_COMPOSER_VER ] ) ? 'show' : $ignore_notice_option[ MH_COMPOSER_VER ];
	$screen = get_current_screen();

	// check whether any cache plugin installed and get its page link
	$plugin_page = mhc_detect_cache_plugins();

	if ( 'post' === $screen->base && 'ignore' !== $ignore_this_notice && false !== $plugin_page ) {
		$hide_button = sprintf(
			' <br> <a class="mhc_hide_cache_notice" href="%3$s">%2$s</a> <a class="mhc_hide_cache_notice" href="#">%1$s</a>',
			esc_html__( 'Hide Notice', 'mh-composer' ),
			esc_html__( 'Clear Cache', 'mh-composer' ),
			esc_url( admin_url( $plugin_page ) )
		);

		$notice_text = mh_wp_kses( __( '<strong>Mharty - Page Composer</strong> has been updated but you are currently using a caching plugin. Please clear your plugin cache <strong>and</strong> clear your browser cache (in that order) to make sure that the updated files are loading. Cached files may cause the composer to malfunction.', 'mh-composer' ) );

		printf( '<div class="update-nag mhc-update-nag"><p>%1$s%2$s</p></div>', $notice_text, $hide_button );
	}
}
add_action( 'admin_notices', 'mhc_maybe_display_cache_notice' );

/**
 * Update mhc_cache_notice option to indicate that Cache Notice was closed for current version of theme
 */
function mhc_hide_cache_notice() {
	if ( ! wp_verify_nonce( $_POST['mh_admin_load_nonce'], 'mh_admin_load_nonce' ) ) {
		die( -1 );
	}

	if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

	update_option(
		'mhc_cache_notice',
		array(
			MH_COMPOSER_VER => 'ignore',
		)
	);
}
add_action( 'wp_ajax_mhc_hide_cache_notice', 'mhc_hide_cache_notice' );

/**
 * List of shortcodes that triggers error if being used in admin
 *
 * @return array shortcode tag
 */
function mhc_admin_excluded_shortcodes() {
	$shortcodes = array();

	// Triggers issue if Sensei and YOAST SEO are activated
	if ( mh_is_yoast_seo_plugin_active() && function_exists( 'Sensei' ) ) {
		$shortcodes[] = 'usercourses';
	}

	return apply_filters( 'mhc_admin_excluded_shortcodes', $shortcodes );
}

if ( ! function_exists( 'mh_default_color_scheme' ) ) :
	function mh_default_color_scheme($post_id = 0) {
		$default_scheme = array(
			'#000000',
			'#FFFFFF',
			'#E02B20',
			'#E09900',
			'#EDF000',
			'#7CDA24',
			'#0C71C3',
			'#8300E9',
		);
	
		$saved_scheme = mh_get_option( 'mharty_color_scheme' );
	
		$scheme = $saved_scheme && '' !== str_replace( '|', '', $saved_scheme ) ? explode( '|', $saved_scheme ) : $default_scheme;
		
		return apply_filters( 'mh_default_color_scheme', $scheme, $post_id );
	}
endif;

if ( ! function_exists( 'mh_get_theme_panel_link_advanced' ) ) :
function mh_get_theme_panel_link_advanced() {

	return apply_filters( 'mh_theme_panel_link_advanced', admin_url( 'admin.php?page=mh_panel#wrap-advanced' ) );
}
endif;

if ( ! function_exists( 'mh_get_google_api_key' ) ) :
function mh_get_google_api_key() {
	$google_api_option = mh_get_option( 'mharty_google_maps_api_key', '' );

	return $google_api_option;
}
endif;
	
if ( ! function_exists( 'mh_composer_maybe_flush_rewrite_rules' ) ) :
function mh_composer_maybe_flush_rewrite_rules( $setting_name ) {
	if ( mh_get_option( $setting_name ) ) {
		return;
	}

	flush_rewrite_rules();

	mh_update_option( $setting_name, 'done' );
}
endif;

/**
 * Flush rewrite rules to fix the issue Layouts, not being visible on front-end,
 * if pretty permalinks were enabled
 * @return void
 */
function mhc_maybe_flush_3_0_rewrite_rules() {
	mh_composer_maybe_flush_rewrite_rules( '3_0_flush_rewrite_rules_2' );
}
add_action( 'init', 'mhc_maybe_flush_3_0_rewrite_rules', 9 );