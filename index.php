<?php 
/*
Plugin Name: KSTAD COSIE Certificate
Plugin URI:  https://github.com/
Description: For stuff that's magical
Version:     1.0
Author:      Tom Woodward
Author URI:  https://tomwoodward.us
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset

*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action('wp_enqueue_scripts', 'cosie_load_scripts');

function cosie_load_scripts() {                           
    $deps = array('jquery');
    $version= '1.0'; 
    $in_footer = true;    
    wp_enqueue_script('cosie-main-js', plugin_dir_url( __FILE__) . 'js/cosie-main.js', $deps, $version, $in_footer); 
    wp_enqueue_style( 'cosie-main-css', plugin_dir_url( __FILE__) . 'css/cosie-main.css');
}




//LOGGER -- like frogger but more useful

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

  //print("<pre>".print_r($a,true)."</pre>");

//create participant user role *********************************************************************

function cosie_update_custom_roles() {
    if ( get_option( 'custom_roles_version' ) < 1 ) {
        add_role( 'cosie_participant', 'Participant', get_role( 'author' )->capabilities  );
        update_option( 'custom_roles_version', 1 );
    }
}
add_action( 'init', 'cosie_update_custom_roles' );

//make participant page after user registration 

add_action( 'gform_user_registered', 'cosie_make_page', 10, 4 );

function cosie_make_page($user_id){
        $user = get_userdata( $user_id );
        $args = array(
        'post_title'    =>  $user->user_login,
        'post_author'   => $user_id,
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_type' => 'participant'
         );
         wp_insert_post( $args );
}



//ADD CUSTOM POST TYPE TEMPLATE**********************************************************************

/* Filter the single_template with our custom function*/
add_filter('single_template', 'participant_custom_template');

function participant_custom_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'participant' ) {
        if ( file_exists( plugin_dir_path(__FILE__) . '/single-participant.php' ) ) {
            return plugin_dir_path(__FILE__) . '/single-participant.php';
        }
    }

    return $single;

}

//ACF**************************************************************************************************
//options page
if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page(array(
    'page_title'  => 'Cosie Prompts',
    'menu_title'  => 'Cosie Prompts',
    'menu_slug'   => 'cosie-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));
  
}

//on option save, change fields

add_filter('acf/load_field/key=field_605ded9481995', 'prompt_1_field_label');
function prompt_1_field_label($field) {
  $label = get_field('prompt_1_title', 'option');
  $prompt = get_field('prompt_1', 'option');
  if ($label) {
    $field['label'] = $label;
    $field['instructions'] = $prompt;
  }
  return $field;
}
//add_filter('the_content', 'my_content', 10, 2, $my_param)

add_filter('acf/load_field/key=field_605df51a632e1', 'prompt_2_field_label');
function prompt_2_field_label($field) {
  $label = get_field('prompt_2_title', 'option');
  $prompt = get_field('prompt_2', 'option');
  if ($label) {
    $field['label'] = $label;
    $field['instructions'] = $prompt;
  }
  return $field;
}

add_filter('acf/load_field/key=field_605df521632e2', 'prompt_3_field_label');
function prompt_3_field_label($field) {
  $label = get_field('prompt_3_title', 'option');
  $prompt = get_field('prompt_3', 'option');
  if ($label) {
    $field['label'] = $label;
    $field['instructions'] = $prompt;
  }
  return $field;
}

add_filter('acf/load_field/key=field_605df528632e3', 'prompt_4_field_label');
function prompt_4_field_label($field) {
  $label = get_field('prompt_4_title', 'option');
  $prompt = get_field('prompt_4', 'option');
  if ($label) {
    $field['label'] = $label;
    $field['instructions'] = $prompt;
  }
  return $field;
}



  //save acf json
    add_filter('acf/settings/save_json', 'cosie_json_save_point');
     
    function cosie_json_save_point( $path ) {
        
        // update path
        $path = plugin_dir_path(__FILE__) . '/acf-json'; //replace w get_stylesheet_directory() for theme
        
        
        // return
        return $path;
        
    }


    // load acf json
    add_filter('acf/settings/load_json', 'cosie_json_load_point');

    function cosie_json_load_point( $paths ) {
        
        // remove original path (optional)
        unset($paths[0]);
        
        
        // append path
        $paths[] = plugin_dir_path(__FILE__)  . '/acf-json';//replace w get_stylesheet_directory() for theme
        
        
        // return
        return $paths;
        
    }

/**
 * THIS GIVES YOU THE OPTION TO PICK FORMS FROM THE OPTIONS AREA
 * Populate ACF select field options with Gravity Forms forms
 * from https://gist.github.com/psaikali/2b29e6e83f50718625af27c2958c828f
 */
function acf_populate_gf_forms_ids( $field ) {
  //write_log($field);
  if ( class_exists( 'GFFormsModel' ) ) {
    $choices = [];
    foreach ( \GFFormsModel::get_forms() as $form ) {
      $choices[ $form->id ] = $form->title;
    }
    $field['choices'] = $choices;
  }

  return $field;
}

add_filter( 'acf/load_field/key=field_60893b01a8896', 'acf_populate_gf_forms_ids' );



//participant custom post type

// Register Custom Post Type participant
// Post Type Key: participant

function create_participant_cpt() {

  $labels = array(
    'name' => __( 'Participants', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'Participant', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'Participant', 'textdomain' ),
    'name_admin_bar' => __( 'Participant', 'textdomain' ),
    'archives' => __( 'Participant Archives', 'textdomain' ),
    'attributes' => __( 'Participant Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'Participant:', 'textdomain' ),
    'all_items' => __( 'All Participants', 'textdomain' ),
    'add_new_item' => __( 'Add New Participant', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New Participant', 'textdomain' ),
    'edit_item' => __( 'Edit Participant', 'textdomain' ),
    'update_item' => __( 'Update Participant', 'textdomain' ),
    'view_item' => __( 'View Participant', 'textdomain' ),
    'view_items' => __( 'View Participants', 'textdomain' ),
    'search_items' => __( 'Search Participants', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into participant', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this participant', 'textdomain' ),
    'items_list' => __( 'Participant list', 'textdomain' ),
    'items_list_navigation' => __( 'Participant list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter Participant list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'participant', 'textdomain' ),
    'description' => __( '', 'textdomain' ),
    'labels' => $labels,
    'menu_icon' => '',
    'supports' => array('title', 'editor', 'revisions', 'author', 'trackbacks', 'custom-fields', 'thumbnail',),
    'taxonomies' => array('category', 'post_tag'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-universal-access-alt',
  );
  register_post_type( 'participant', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_participant_cpt', 0 );