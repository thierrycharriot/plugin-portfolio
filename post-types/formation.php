<?php

/**
 * Registers the `formation` post type.
 */
function formation_init() {
	register_post_type(
		'formation',
		[
			'labels'                => [
				'name'                  => __( 'Formations', 'underscores-bootstrap-portfolio' ),
				'singular_name'         => __( 'Formation', 'underscores-bootstrap-portfolio' ),
				'all_items'             => __( 'All Formations', 'underscores-bootstrap-portfolio' ),
				'archives'              => __( 'Formation Archives', 'underscores-bootstrap-portfolio' ),
				'attributes'            => __( 'Formation Attributes', 'underscores-bootstrap-portfolio' ),
				'insert_into_item'      => __( 'Insert into Formation', 'underscores-bootstrap-portfolio' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Formation', 'underscores-bootstrap-portfolio' ),
				'featured_image'        => _x( 'Featured Image', 'formation', 'underscores-bootstrap-portfolio' ),
				'set_featured_image'    => _x( 'Set featured image', 'formation', 'underscores-bootstrap-portfolio' ),
				'remove_featured_image' => _x( 'Remove featured image', 'formation', 'underscores-bootstrap-portfolio' ),
				'use_featured_image'    => _x( 'Use as featured image', 'formation', 'underscores-bootstrap-portfolio' ),
				'filter_items_list'     => __( 'Filter Formations list', 'underscores-bootstrap-portfolio' ),
				'items_list_navigation' => __( 'Formations list navigation', 'underscores-bootstrap-portfolio' ),
				'items_list'            => __( 'Formations list', 'underscores-bootstrap-portfolio' ),
				'new_item'              => __( 'New Formation', 'underscores-bootstrap-portfolio' ),
				'add_new'               => __( 'Add New', 'underscores-bootstrap-portfolio' ),
				'add_new_item'          => __( 'Add New Formation', 'underscores-bootstrap-portfolio' ),
				'edit_item'             => __( 'Edit Formation', 'underscores-bootstrap-portfolio' ),
				'view_item'             => __( 'View Formation', 'underscores-bootstrap-portfolio' ),
				'view_items'            => __( 'View Formations', 'underscores-bootstrap-portfolio' ),
				'search_items'          => __( 'Search Formations', 'underscores-bootstrap-portfolio' ),
				'not_found'             => __( 'No Formations found', 'underscores-bootstrap-portfolio' ),
				'not_found_in_trash'    => __( 'No Formations found in trash', 'underscores-bootstrap-portfolio' ),
				'parent_item_colon'     => __( 'Parent Formation:', 'underscores-bootstrap-portfolio' ),
				'menu_name'             => __( 'Formations', 'underscores-bootstrap-portfolio' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-awards',
			'show_in_rest'          => true,
			'rest_base'             => 'formation',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'formation_init' );

/**
 * Sets the post updated messages for the `formation` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `formation` post type.
 */
function formation_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['formation'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Formation updated. <a target="_blank" href="%s">View Formation</a>', 'underscores-bootstrap-portfolio' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'underscores-bootstrap-portfolio' ),
		3  => __( 'Custom field deleted.', 'underscores-bootstrap-portfolio' ),
		4  => __( 'Formation updated.', 'underscores-bootstrap-portfolio' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Formation restored to revision from %s', 'underscores-bootstrap-portfolio' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Formation published. <a href="%s">View Formation</a>', 'underscores-bootstrap-portfolio' ), esc_url( $permalink ) ),
		7  => __( 'Formation saved.', 'underscores-bootstrap-portfolio' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Formation submitted. <a target="_blank" href="%s">Preview Formation</a>', 'underscores-bootstrap-portfolio' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Formation scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Formation</a>', 'underscores-bootstrap-portfolio' ), date_i18n( __( 'M j, Y @ G:i', 'underscores-bootstrap-portfolio' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Formation draft updated. <a target="_blank" href="%s">Preview Formation</a>', 'underscores-bootstrap-portfolio' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'formation_updated_messages' );

/**
 * Sets the bulk post updated messages for the `formation` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `formation` post type.
 */
function formation_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['formation'] = [
		/* translators: %s: Number of Formations. */
		'updated'   => _n( '%s Formation updated.', '%s Formations updated.', $bulk_counts['updated'], 'underscores-bootstrap-portfolio' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Formation not updated, somebody is editing it.', 'underscores-bootstrap-portfolio' ) :
						/* translators: %s: Number of Formations. */
						_n( '%s Formation not updated, somebody is editing it.', '%s Formations not updated, somebody is editing them.', $bulk_counts['locked'], 'underscores-bootstrap-portfolio' ),
		/* translators: %s: Number of Formations. */
		'deleted'   => _n( '%s Formation permanently deleted.', '%s Formations permanently deleted.', $bulk_counts['deleted'], 'underscores-bootstrap-portfolio' ),
		/* translators: %s: Number of Formations. */
		'trashed'   => _n( '%s Formation moved to the Trash.', '%s Formations moved to the Trash.', $bulk_counts['trashed'], 'underscores-bootstrap-portfolio' ),
		/* translators: %s: Number of Formations. */
		'untrashed' => _n( '%s Formation restored from the Trash.', '%s Formations restored from the Trash.', $bulk_counts['untrashed'], 'underscores-bootstrap-portfolio' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'formation_bulk_updated_messages', 10, 2 );
