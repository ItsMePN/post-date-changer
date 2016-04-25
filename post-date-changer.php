<?php
/*
Plugin Name: Post Date Changer
Plugin URI: https://profiles.wordpress.org/prasad-nevase
Description: This plugin will update post date on every status change.
Version: 1.0
Author: prasad-nevase
Author URI: https://profiles.wordpress.org/prasad-nevase
*/

// don't load directly
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

//auto change post date on every status change
add_filter('wp_insert_post_data','reset_post_date',99,2);
function reset_post_date($data,$postarr) {
    $data['post_date'] = $data['post_modified'];
    $data['post_date_gmt'] = $data['post_modified_gmt'];
     if (get_post_type($post) !== 'post')
     return $data;    //Don't touch anything that's not a post (i.e. ignore links and attachments and whatnot )
//Add post meta to post title
$data['post_title'] = 'Desired Title - '. current_time ( 'F j, Y' );
//Update the slug of the post for the URL
$data['post_name'] = wp_unique_post_slug( sanitize_title( $data['post_title'] ), $postarr['ID'], $data['post_status'], $data['post_type'], $data['post_parent'] );
return $data;
}

?>
