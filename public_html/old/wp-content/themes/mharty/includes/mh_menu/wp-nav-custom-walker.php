<?php 

class mharty_custom_menu {

    /*--------------------------------------------*
     * Constructor
     *--------------------------------------------*/
    function __construct() {

        
        // add custom menu fields to menu
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'mharty_add_custom_nav_fields' ) );

        // save menu custom fields
        add_action( 'wp_update_nav_menu_item', array( $this, 'mharty_update_custom_nav_fields'), 10, 3 );
        
        // edit menu walker
        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'mharty_edit_walker'), 10, 2 );

    } // end constructor
    

    /**
     * Add custom fields to $item nav object
     * in order to be used in custom Walker
     *
     * @access      public
     * @since       1.0 
     * @return      void
    */
    function mharty_add_custom_nav_fields( $menu_item ) {
    
		$menu_item->menu_icon = get_post_meta( $menu_item->ID, '_menu_item_menu_icon', true );
        $menu_item->megamenu = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
        $menu_item->megamenu_background = get_post_meta( $menu_item->ID, '_menu_item_megamenu_background', true );
        $menu_item->megamenu_styles = get_post_meta( $menu_item->ID, '_menu_item_megamenu_styles', true );
        return $menu_item;
        
    }
    
    /**
     * Save menu custom fields
     *
     * @access      public
     * @since       1.0 
     * @return      void
    */
    function mharty_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
    
        // Check if element is properly sent

        if (!empty($_REQUEST['menu-item-menu_icon']) && is_array( $_REQUEST['menu-item-menu_icon']) ) {
            $menu_icon_value = $_REQUEST['menu-item-menu_icon'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_menu_icon', $menu_icon_value );
        }

        if (!isset($_REQUEST['edit-menu-item-megamenu'][$menu_item_db_id])) {
            $_REQUEST['edit-menu-item-megamenu'][$menu_item_db_id] = '';
            
        }
        $menu_mega_enabled_value = $_REQUEST['edit-menu-item-megamenu'][$menu_item_db_id];        
        update_post_meta( $menu_item_db_id, '_menu_item_megamenu', $menu_mega_enabled_value );


        if (!isset($_REQUEST['menu-item-megamenu-background'][$menu_item_db_id])) {
        $_REQUEST['menu-item-megamenu-background'][$menu_item_db_id] = '';
            
        }
        $mega_menu_background_value = $_REQUEST['menu-item-megamenu-background'][$menu_item_db_id];        
        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_background', $mega_menu_background_value );


        if (!isset($_REQUEST['menu-item-megamenu-styles'][$menu_item_db_id])) {
        $_REQUEST['menu-item-megamenu-styles'][$menu_item_db_id] = '';
            
        }
        $mega_menu_styles_value = $_REQUEST['menu-item-megamenu-styles'][$menu_item_db_id];        
        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_styles', $mega_menu_styles_value );




    }
    
    /**
     * Define new Walker edit
     *
     * @access      public
     * @since       1.0 
     * @return      void
    */
    function mharty_edit_walker($walker,$menu_id) {
    
        return 'Walker_Nav_Menu_Edit_Custom'; 
    }
}

// instantiate plugin's class
$GLOBALS['mhartytheme_custom_menu'] = new mharty_custom_menu();


/**
 *  /!\ This is a copy of Walker_Nav_Menu_Edit class in core
 * 
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
        /**
         * @see Walker::$tree_type
         * @var string
         */
        var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
    
        /**
         * @see Walker::$db_fields
         * @todo Decouple this.
         * @var array
         */
        var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
    

        /**
         * @see Walker_Nav_Menu::start_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         */
        function start_lvl(&$output, $depth = 0, $args = array()) {  
        }
        
        /**
         * @see Walker_Nav_Menu::end_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         */
        function end_lvl(&$output, $depth = 0, $args = array()) {
        }
    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param object $args
     */
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        global $_wp_nav_menu_max_depth,
                $wp_registered_sidebars;
       
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
    
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    
        ob_start();
        $item_id = esc_attr( $item->ID );
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );


    
        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = $original_object->post_title;
        }
    
        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );
    
        $title = $item->title;
    
        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( esc_html__( '%s (Invalid)'), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( esc_html__('%s (Pending)'), $item->title );
        }
    
        $title = empty( $item->label ) ? $title : $item->label;
       
        ?>
        <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title"><?php echo esc_html( $title ); ?></span>
                    <span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-up-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
                            |
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-down-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
                            echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                        ?>"><?php esc_html_e( 'Edit Menu Item'); ?></a>
                    </span>
                </dt>
            </dl>
    
            <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
                <?php if( 'custom' == $item->type ) : ?>
                    <p class="field-url description description-wide">
                        <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                            <?php esc_html_e( 'URL'); ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                        </label>
                    </p>
                <?php endif; ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Navigation Label'); ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Title Attribute'); ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                        <?php esc_html_e( 'Open link in a new window/tab'); ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'CSS Classes (optional)'); ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Link Relationship (XFN)'); ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                    </label>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Description'); ?><br />
                        <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                        <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.'); ?></span>
                    </label>
                </p>
                <p class="description description-wide">
                <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                        <strong><?php esc_html_e( 'Menu Item Icon', "mharty" ); ?></strong><br />
                        <input class="widefat" type="text" id="edit-menu-item-menu-icon-<?php echo $item_id; ?>" name="menu-item-menu_icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_icon ); ?>" />   
                        <span class="description"><a target="_blank" href="<?php  echo esc_url( add_query_arg( array( 'page' => 'mh_theme_icons' ), admin_url( 'admin.php' ) ) ); ?>">
						<?php esc_html_e("Click here", "mharty")?></a> <?php esc_html_e("to go to the icons index. (Paste the code for your desired icon here).", "mharty"); ?></span>
                </label>
                </p>

                <p class="field-megamenu-checkbox description-wide">
                    <?php 

                        $value = get_post_meta( $item->ID, '_menu_item_megamenu', true);
                        if($value != "") $value = "checked='checked'";

                    ?>
                    <label for="edit-menu-item-megamenu-<?php echo $item_id; ?>">
                        <input type="checkbox" value="enabled" class="edit-menu-item-mh-megamenu-check" id="edit-menu-item-megamenu-<?php echo $item_id; ?>" name="edit-menu-item-megamenu[<?php echo $item_id; ?>]" <?php echo $value; ?> />
                        <strong><em><?php esc_html_e( 'Mega Menu?', "mharty" ); ?></em></strong>
                    </label>
                </p>

               

                <a href="#" id="mh-media-upload-<?php echo $item_id; ?>" class="mh-open-media button button-primary mh-megamenu-upload-background description-wide"><?php esc_html_e( 'Set Background Image', 'mharty' ); ?></a>
                <p class="field-megamenu-background description description-wide">
                    <label for="edit-menu-item-megamenu-background-<?php echo $item_id; ?>">
                        <input type="hidden" id="edit-menu-item-megamenu-background-<?php echo $item_id; ?>" class="mh-new-media-image widefat code edit-menu-item-megamenu-background" name="menu-item-megamenu-background[<?php echo $item_id; ?>]" value="<?php echo $item->megamenu_background; ?>" />
                        <img src="<?php echo $item->megamenu_background; ?>" id="mh-media-img-<?php echo $item_id; ?>" class="mh-megamenu-background-image" style="
                        <?php echo ( trim( $item->megamenu_background ) ) ? 'display: inline;' : '';?>" />
                        <a href="#" id="mh-media-remove-<?php echo $item_id; ?>" class="remove-mh-megamenu-background" style="
                        <?php echo ( trim( $item->megamenu_background ) ) ? 'display: inline;' : '';?>">Remove Image</a>
                    </label>
                </p>

                <p class="field-megamenu-styles description description-wide">
                    <label for="edit-menu-item-megamenu-styles-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Mega Menu Custom CSS', "mharty" ); ?><br />
                        <textarea id="edit-menu-item-megamenu-styles-<?php echo $item_id; ?>" class="widefat edit-menu-item-megamenu-styles" dir="ltr" rows="3" cols="20" name="menu-item-megamenu-styles[<?php echo $item_id; ?>]"><?php echo esc_html( $item->megamenu_styles ); // textarea_escaped ?></textarea>
                        <span class="description"><?php esc_html_e('Here you could add custom css styles for your Mega Menu e.g.', "mharty"); ?></span>
                        <code>background-position: left bottom;
    									background-repeat: no-repeat;</code>
                    </label>
                </p>

                <div class="menu-item-actions description-wide submitbox">
                    <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                        <p class="link-to-original">
                            <?php printf( esc_html__('Original: %s'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                        </p>
                    <?php endif; ?>
                    <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'delete-menu-item',
                                'menu-item' => $item_id,
                            ),
                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                        ),
                        'delete-menu_item_' . $item_id
                    ); ?>"><?php esc_html_e('Remove'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                        ?>#menu-item-settings-<?php echo $item_id; ?>"><?php esc_html_e('Cancel'); ?></a>
                </div>
    
                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul>
        <?php
        
        $output .= ob_get_clean();

        }
}




/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
class mharty_walker extends Walker_Nav_Menu {
    /**
         * @var int $columns 
         */
        var $columns = 0;
        var $max_columns = 0;
        var $rows = 1;
        var $rowsCounter = array();
        var $mega_active = 0;
    
    
    
        /**
         * @see Walker::start_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        function start_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);

            $style = '';
            
            if($depth === 0 && $this->active_megamenu) 
            {
                
                $style .= !empty($this->megamenu_background) ? ('Background-image:url('.$this->megamenu_background.');') : '';
                $style .= !empty($this->megamenu_styles) ? $this->megamenu_styles : '';
            }

            $output .= "\n$indent<ul style=\"$style\" class=\"sub-menu {locate_class}\">\n";

            

        }
    
        /**
         * @see Walker::end_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        function end_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
            
            if($depth === 0) 
            {
                if($this->active_megamenu)
                {

                    $output = str_replace("{locate_class}", "mega-col-".$this->max_columns."", $output);
                    
                    foreach($this->rowsCounter as $row => $columns)
                    {
                        $output = str_replace("{current_row_".$row."}", "mega-col-".$columns, $output);
                    }
                    
                    $this->columns = 0;
                    $this->max_columns = 0;
                    $this->rowsCounter = array();
                    
                }
                else
                {
                    $output = str_replace("{locate_class}", "", $output);
                }
            }
        }    

        function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
            global $wp_query;
            

            
            $item_output = $li_text_block_class = $column_class = "";
            $this->megamenu_background = get_post_meta( $item->ID, '_menu_item_megamenu_background', true );
            $this->megamenu_styles = get_post_meta( $item->ID, '_menu_item_megamenu_styles', true );
            

            if($depth === 0)
            {   
                $this->active_megamenu = get_post_meta( $item->ID, '_menu_item_megamenu', true);

                if($this->active_megamenu) {
                    $column_class .= " mega-menu";
                } else {
                    $column_class .= " no-mega-menu";
                }

            }


            
            
            if($depth === 1 && $this->active_megamenu)
            {
                $this->columns ++;
                

                $this->rowsCounter[$this->rows] = $this->columns;
                
                if($this->max_columns < $this->columns) $this->max_columns = $this->columns; 

                $column_class  = ' {current_row_'.$this->rows.'}';
                
                if($this->columns == 1)
                {
                    $column_class  .= " mh_mega_first";
                }

             //   if($this->megamenu_widgetarea == false) {
                
                $title = apply_filters( 'the_title', $item->title, $item->ID );

                if($title != "#" && $title != '"#"')
                {
                  $menu_icon_tag  = ! empty( $item->menu_icon ) ? '<i aria-hidden="true" data-icon="&#x'.esc_attr( $item->menu_icon ).';" class="mhc-menu-icon"></i>' : '';
                    $attributes = ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';      
                
                    $item_output .= $args->before;
                    $item_output .= '<div class="megamenu-title"'. $attributes .'>';
                	$item_output .= $menu_icon_tag;
                    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                    $item_output .= '</div>';
                    $item_output .= $args->after;
                }

               

               
            } else {

//                if($depth === 2 && $this->megamenu_widgetarea && $this->active_megamenu) {
//
//                if( is_active_sidebar( $this->megamenu_widgetarea ) ) {
//                    $item_output .= '<div class="megamenu-widgets-container">';
//                    ob_start();
//                        dynamic_sidebar( $this->megamenu_widgetarea );
//
//                    $item_output .= ob_get_clean() . '</div>';
//                }
//            } else {

             	$menu_icon_tag  = ! empty( $item->menu_icon ) ? '<i aria-hidden="true" data-icon="&#x'.esc_attr( $item->menu_icon ).';" class="mhc-menu-icon"></i>' : '';
                $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';            
            
                $item_output .= $args->before;
                $item_output .= '<a class="menu-item-link" '. $attributes .'>';
           		$item_output .= $menu_icon_tag;
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</a>';
                $item_output .= $args->after;
               // }
            }
            
            
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            $class_names = $value = '';
    
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
            $class_names = ' class="'.$li_text_block_class. esc_attr( $class_names ) . $column_class.' menu-item-'. $item->ID.'"';
  			//$class_names = ' class="'.$li_text_block_class. esc_attr( $class_names ) . $column_class.'"';
            $output .= $indent . '<li ' . $value . $class_names .'>';
            //  $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
            
            
            
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
}