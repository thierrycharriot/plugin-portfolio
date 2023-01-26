<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://thierrycharriot.github.io
 * @since      1.0.0
 *
 * @package    Plugin_Portfolio
 * @subpackage Plugin_Portfolio/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Plugin_Portfolio
 * @subpackage Plugin_Portfolio/includes
 * @author     Thierry Charriot <thierrycharriot@chez.lui>
 */
class Plugin_Portfolio_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

        // https://developer.wordpress.org/reference/classes/wpdb
        // class wpdb {}
        // WordPress database access abstraction class.
        global $wpdb;

        $datas = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT ID from wp_posts WHERE post_name = %s",
                'portfolio'
            )
        );
        //var_dump($datas); die(); // OK

        $page_id = $datas->ID;
        if ( $page_id > 0 ) {
            // https://developer.wordpress.org/reference/functions/wp_delete_post/
            // wp_delete_post( int $postid, bool $force_delete = false ): WP_Post|false|null
            // Trash or delete a post or page.
            wp_delete_post( $page_id, true );
        }

        // https://developer.wordpress.org/reference/functions/wp_get_current_user/
        // wp_get_current_user()
        // Retrieve the current user object
        $user = wp_get_current_user(); 
        
        // https://developer.wordpress.org/reference/functions/delete_user_meta/
        // delete_user_meta( int $user_id, string $meta_key, mixed $meta_value = '' ): bool
        // Removes metadata matching criteria from a user.
        delete_user_meta( $user->ID, 'usermeta_user_profession');
        delete_user_meta( $user->ID, 'usermeta_cv_link');

	}

}
