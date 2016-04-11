<?php
/**
 * Plugin Name:       Simple Ajax Demo
 * Description:       A simple demonstration of the WordPress Ajax APIs.
 * Version:           1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

add_action( 'wp_enqueue_scripts', 'gens_add_ajax_support' );
/**
 * Adds support for WordPress to handle asynchronous requests on both the front-end
 * and the back-end of the website.
 *
 * @since    1.0.0
 */
function gens_add_ajax_support() {
     

    wp_enqueue_script( 'ajax-script', plugin_dir_url( __FILE__ ) . 'frontend.js', array( 'jquery' ));
    wp_localize_script('ajax-script','gens_demo',
        array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        )
    );
     
}

add_action( 'wp_ajax_get_current_user_info', 'gens_get_current_user_info' );
add_action( 'wp_ajax_nopriv_get_current_user_info', 'gens_get_current_user_info' );

/**
 * Retrieves information about the user who is currently logged into the site.
 *
 * This function is intended to be called via the client-side of the public-facing
 * side of the site.
 *
 * @since    1.0.0
 */
function gens_get_current_user_info() {

 	// Grab the current user's ID
    $user_id = get_current_user_id();
 
    // If the user is logged in and the user exists, return success with the user JSON
    if ( _gens_user_is_logged_in( $user_id ) && _gens_user_exists( $user_id ) ) {
 
        wp_send_json_success(
            json_encode( get_user_by( 'id', $user_id ) )
        );
 
    }
}

/**
 * Determines if a user is logged into the site using the specified user ID. If not,
 * then the following error code and message will be returned to the client:
 *
 * -2: The visitor is not currently logged into the site.
 *
 * @access   private
 * @since    1.0.0
 *
 * @param    int    $user_id    The current user's ID.
 */
function _gens_user_is_logged_in( $user_id ) {
 
    if ( 0 === $user_id ) {
 
        wp_send_json_error(
            new WP_Error( '-2', 'The visitor is not currently logged into the site.' )
        );
 
    }
 
}

/**
 * Determines if a user is logged into the site using the specified user ID. If not,
 * then the following error code and message will be returned to the client:
 *
 * -3: The visitor does not have an account
 *
 * @access   private
 * @since    1.0.0
 *
 * @param    int    $user_id    The current user's ID.
 */
function _gens_user_exists( $user_id ) {
 
    if ( 0 === $user_id ) {
 
        wp_send_json_error(
            new WP_Error( '-3', 'The visitor does not have an account with this site.' );
        );
 
    }
 
}