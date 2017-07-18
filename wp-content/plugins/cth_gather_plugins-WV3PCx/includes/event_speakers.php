<?php
if ( ! defined('ABSPATH') ) {
    die('Please do not load this file directly!');
}
function cth_register_cpt_Cth_Speakers() {
    
    $labels = array( 
        'name' => __( 'Speakers', 'cth' ),
        'singular_name' => __( 'Speaker', 'cth' ),
        'add_new' => __( 'Add New Speaker', 'cth' ),
        'add_new_item' => __( 'Add New Speaker', 'cth' ),
        'edit_item' => __( 'Edit Speaker', 'cth' ),
        'new_item' => __( 'New Speaker', 'cth' ),
        'view_item' => __( 'View Speaker', 'cth' ),
        'search_items' => __( 'Search Speakers', 'cth' ),
        'not_found' => __( 'No Speakers found', 'cth' ),
        'not_found_in_trash' => __( 'No Speakers found in Trash', 'cth' ),
        'parent_item_colon' => __( 'Parent Speaker:', 'cth' ),
        'menu_name' => __( 'Gather Event Speakers', 'cth' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'List Speakers',
        'supports' => array( 'title', 'editor', 'thumbnail'/*,'comments', 'post-formats'*/),
        //'taxonomies' => array('cth_speaker_cat'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon'   => 'dashicons-groups',
        //'menu_icon' => plugin_dir_url( __FILE__ ) .'assets/admin_ico_portfolio.png', 
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        //'rewrite' => true,
        'rewrite' => array('slug'=>'cth_speaker'),
        'capability_type' => 'post'
    );

    register_post_type( 'cth_speaker', $args );
}

//Register Schedule 
add_action( 'init', 'cth_register_cpt_Cth_Speakers' );

function cth_gather_plugins_speakers_add_meta_box() {

    $screens = array( 'cth_speaker');

    foreach ( $screens as $screen ) {

        add_meta_box(
            'cth_speaker_job',
            __( 'Details', 'cth-gather-plugins' ),
            'cth_gather_plugins_speakers_meta_box_job_callback',
            $screen,
            'normal',
            'core'
            //,'normal', //('normal', 'advanced', or 'side')
            //'core'//('high', 'core', 'default' or 'low') 
        );
        add_meta_box(
            'cth_speaker_single_layout',
            __( 'Single Sidebar', 'cth-gather-plugins' ),
            'cth_gather_plugins_speakers_meta_box_single_layout_callback',
            $screen,
            'normal',
            'core'
            //,'normal', //('normal', 'advanced', or 'side')
            //'core'//('high', 'core', 'default' or 'low') 
        );

        
    }

    
}
add_action( 'add_meta_boxes', 'cth_gather_plugins_speakers_add_meta_box' );
function cth_gather_plugins_speakers_meta_box_job_callback( $post ) {
    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'cth_gather_plugins_save_meta_box_data', 'cth_gather_plugins_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value = get_post_meta( $post->ID, 'cth_speaker_job', true );
    
    echo '<table class="form-table"><tbody>';

    echo '<tr><th style="width:20%">';
        echo '<label>';
        _e( 'Speaker Job: ', 'cth-gather-plugins' );
        echo '</label> ';
    echo '</th>';
    echo '<td>';
        echo '<input type="text" id="cth_speaker_job" name="cth_speaker_job" value="' . esc_attr( $value ) . '" size="25" />';
    echo '</td></tr>';

    echo '</tbody></table>';  
}

function cth_gather_plugins_speakers_meta_box_single_layout_callback( $post ) {

    // default reservation status
    $defauls = array(
        'right_sidebar'=>__('Right Sidebar','cth-gather-plugins'), 
        'left_sidebar'=>__('Left Sidebar','cth-gather-plugins'), 
        'fullwidth'=>__('No Sidebar','cth-gather-plugins')
    );

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'cth_gather_plugins_save_meta_box_data', 'cth_gather_plugins_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value = get_post_meta( $post->ID, 'cth_speaker_single_layout', true );

    echo '<table class="form-table"><tbody><tr>';
    echo '<th style="width:20%">';
        echo '<label for="cth_speaker_single_layout">';
        _e( 'Sidebar', 'cth-gather-plugins' );
        echo '</label> ';
    echo '</th>';
    echo '<td>';
        echo '<select id="cth_speaker_single_layout" name="cth_speaker_single_layout">';
        foreach ($defauls as $key => $val) {
            $selected = '';
            if($value === $key){
                $selected = ' selected="selected"';
            }
            echo '<option value="'.$key.'"'.$selected.'>'.$val.'</option>';
        }
        echo '</select>';
    echo '</td></tr>';
    echo '</tbody></table>';  
}

function cth_gather_plugins_speakers_save_meta_box_datas( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['cth_gather_plugins_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['cth_gather_plugins_meta_box_nonce'], 'cth_gather_plugins_save_meta_box_data' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'cth_speaker' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }




    if(isset($_POST['cth_speaker_job'])){
        update_post_meta( $post_id, 'cth_speaker_job', sanitize_text_field( $_POST['cth_speaker_job'] ) );
    }
    if(isset($_POST['cth_speaker_single_layout'])){
        update_post_meta( $post_id, 'cth_speaker_single_layout', sanitize_text_field( $_POST['cth_speaker_single_layout'] ) );
    }
    
    
    
}
add_action( 'save_post', 'cth_gather_plugins_speakers_save_meta_box_datas' );

if(!function_exists('cth_gather_plugins_speakers_columns_head')){
    function cth_gather_plugins_speakers_columns_head($defaults) {
        unset($defaults['date']);
        // unset($defaults['title']);
        $defaults['cth_speaker_job']             = __('Speaker Job','cth-gather-plugins');
        $defaults['date']             = __('Date','cth-gather-plugins');
        $defaults['cth_speaker_id']             = __('ID','cth-gather-plugins');
        

        return $defaults;
    }
}

if(!function_exists('cth_gather_plugins_speakers_columns_content')){
    function cth_gather_plugins_speakers_columns_content($column_name, $post_ID) {
        if ($column_name == 'cth_speaker_id') {
            echo '<strong>'.esc_attr($post_ID ).'</strong>';
            
        }
        if ($column_name == 'cth_speaker_job') {
            echo '<strong>'.get_post_meta( $post_ID, 'cth_speaker_job', true ).'</strong>';
            
        }
        
    }
}


add_filter('manage_cth_speaker_posts_columns', 'cth_gather_plugins_speakers_columns_head');
add_action('manage_cth_speaker_posts_custom_column', 'cth_gather_plugins_speakers_columns_content', 10, 2);

function cth_gather_plugins_speakers_register_vc_elements(){
    if(function_exists('vc_map')){

        vc_map( array(
            "name"      => __("Speaker Slider", 'cth-gather-plugins'),
            "base"      => "cth_speakers_cpt",
            "class"     => "",
            "icon" => CTH_EVENTRES_DIR_URL . "assets/cth-icon.png",
            "category"=>"Gather",
            "html_template" => CTH_EVENTRES_DIR.'vc_templates/cth_speakers_cpt.php',
            "params"    => array(
                array(
                    "type" => "textfield", 
                    "heading" => __("Count", "gather"), 
                    "param_name" => "count", 
                    "description" => __("Number of speakers to get from.", "gather"),
                    "value" => "9"
                ),
                array(
                    "type" => "dropdown", 
                    "class" => "", 
                    "heading" => __('Order Speakers by', 'gather'), 
                    "param_name" => "order_by", 
                    "value" => array(
                        __('Date', 'gather') => 'date', 
                        __('ID', 'gather') => 'ID', 
                        __('Author', 'gather') => 'author', 
                        __('Title', 'gather') => 'title', 
                        __('Modified', 'gather') => 'modified',
                    ), 
                    "description" => __("Order Speakers by", 'gather'), 
                    "default" => 'date',
                ), 
                array(
                    "type" => "dropdown", 
                    "class" => "", 
                    "heading" => __('Order Speakers', 'gather'), 
                    "param_name" => "order", 
                    "value" => array(
                        
                        __('Descending', 'gather') => 'DESC', 
                        __('Ascending', 'gather') => 'ASC',
                        
                    ), 
                    "description" => __("Order Speakers", 'gather'),
                    "default" => 'DESC',
                ), 
                array(
                    "type" => "textfield", 
                    "heading" => __("Or Enter Speakers IDs", "gather"), 
                    "param_name" => "ids", 
                    "description" => __("Enter speaker ids to show, separated by a comma.", "gather")
                ), 
                array(
                    "type" => "dropdown",
                    //"class"=>"",
                    "heading" => __('Link to single speaker page', 'gather'),
                    "param_name" => "singlespeaker",
                    "value" => array(   
                                    __('No', 'gather') => 'no', 
                                    __('Yes', 'gather') => 'yes',  
                                                                                                                   
                                ),
                    //"description" => __("Set this to No to hide filter buttons bar.", "gather"), 
                ),
                array(
                    "type" => "dropdown",
                    //"class"=>"",
                    "heading" => __('Show Excerpt', 'gather'),
                    "param_name" => "showexcerpt",
                    "value" => array(   
                                    __('No', 'gather') => 'no', 
                                    __('Yes', 'gather') => 'yes',  
                                                                                                                   
                                ),
                    //"description" => __("Set this to No to hide filter buttons bar.", "gather"), 
                ),
                array(
                    "type"      => "textfield",
                    "class"     => "",
                    //"holder"=>'div',
                    "heading"   => __("Slides to show", 'gather'),
                    "param_name"=> "slidestoshow",
                    "value"     => "6",

                    "description" => __("Number of slides which will display in viewport.", 'gather')
                ),
                array(
                    "type" => "dropdown",
                    //"class"=>"",
                    "heading" => __('Show Navigation', 'gather'),
                    "param_name" => "arrows",
                    "value" => array(   
                                    __('Yes', 'gather') => 'true',  
                                    __('No', 'gather') => 'false', 
                                    
                                                                                                                   
                                ),
                    //"description" => __("Set this to No to hide filter buttons bar.", "gather"), 
                ),
                array(
                    "type" => "dropdown",
                    //"class"=>"",
                    "heading" => __('Show Pagination', 'gather'),
                    "param_name" => "dots",
                    "value" => array(   
                                    __('No', 'gather') => 'false', 
                                    __('Yes', 'gather') => 'true',  
                                                                                                                   
                                ),
                    //"description" => __("Set this to No to hide filter buttons bar.", "gather"), 
                ),
                array(
                    "type" => "dropdown",
                    //"class"=>"",
                    "heading" => __('Use Center Mode', 'gather'),
                    "param_name" => "centermode",
                    "value" => array(   
                                    __('No', 'gather') => 'false', 
                                    __('Yes', 'gather') => 'true',  
                                                                                                                   
                                ),
                    //"description" => __("Set this to No to hide filter buttons bar.", "gather"), 
                ),
                array(
                    "type" => "dropdown",
                    //"class"=>"",
                    "heading" => __('Auto Play', 'gather'),
                    "param_name" => "autoplay",
                    "value" => array(   
                                    __('No', 'gather') => 'false', 
                                    __('Yes', 'gather') => 'true',  
                                                                                                                   
                                ),
                    //"description" => __("Set this to No to hide filter buttons bar.", "gather"), 
                ),
                array(
                    "type"      => "textfield",
                    "class"     => "",
                    //"holder"=>'div',
                    "heading"   => __("Responsive Setting", 'gather'),
                    "param_name"=> "responsive",
                    "value"     => "1200:5|992:3|520:1",

                    "description" => __("Separated by a '|'. Format: viewport width and number of slides to show separated by a ':'. Example: 1200:5|992:3|520:1", 'gather')
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Extra class name", "gather"),
                    "param_name" => "el_class",
                    "value"=>'',
                    "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "wpb")
                ),

            )));


        if ( class_exists( 'WPBakeryShortCode' ) ) {
            class WPBakeryShortCode_Cth_Speakers_Cpt extends WPBakeryShortCode {}
        }

    }
}
add_action('init','cth_gather_plugins_speakers_register_vc_elements' );
function get_cth_speaker_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'cth_speaker') {
          $single_template = dirname( __FILE__ ) . '/cth_speaker-template.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_cth_speaker_post_type_template' );
function cth_gather_plugins_register_sidebars(){
    register_sidebar(
        array(
            'name' => __('Speaker Sidebar Widget', 'gather'), 
            'id' => 'speaker_sidebar_widget', 
            'description' => __('Sidebar widget on single speaker page', 'gather'), 
            'before_widget' => '<div id="%1$s" class="widget %2$s">', 
            'after_widget' => '</div>', 
            'before_title' => '<h3 class="widget-title">', 
            'after_title' => '</h3>',
        )
    );
}

add_action('widgets_init', 'cth_gather_plugins_register_sidebars');
