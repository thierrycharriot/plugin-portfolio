<?php

/**
 * Registers the `realisation` post type.
 */
function realisation_init() {
	register_post_type(
		'realisation',
		[
			'labels'                => [
				'name'                  => __( 'Réalisations', 'underscores-bootstrap-portfolio' ),
				'singular_name'         => __( 'Réalisation', 'underscores-bootstrap-portfolio' ),
				'all_items'             => __( 'All Réalisations', 'underscores-bootstrap-portfolio' ),
				'archives'              => __( 'Réalisation Archives', 'underscores-bootstrap-portfolio' ),
				'attributes'            => __( 'Réalisation Attributes', 'underscores-bootstrap-portfolio' ),
				'insert_into_item'      => __( 'Insert into Réalisation', 'underscores-bootstrap-portfolio' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Réalisation', 'underscores-bootstrap-portfolio' ),
				'featured_image'        => __( 'Featured Image', 'realisation', 'underscores-bootstrap-portfolio' ),
				'set_featured_image'    => __( 'Set featured image', 'realisation', 'underscores-bootstrap-portfolio' ),
				'remove_featured_image' => __( 'Remove featured image', 'realisation', 'underscores-bootstrap-portfolio' ),
				'use_featured_image'    => __( 'Use as featured image', 'realisation', 'underscores-bootstrap-portfolio' ),
				'filter_items_list'     => __( 'Filter Réalisations list', 'underscores-bootstrap-portfolio' ),
				'items_list_navigation' => __( 'Réalisations list navigation', 'underscores-bootstrap-portfolio' ),
				'items_list'            => __( 'Réalisations list', 'underscores-bootstrap-portfolio' ),
				'new_item'              => __( 'New Réalisation', 'underscores-bootstrap-portfolio' ),
				'add_new'               => __( 'Add New', 'underscores-bootstrap-portfolio' ),
				'add_new_item'          => __( 'Add New Réalisation', 'underscores-bootstrap-portfolio' ),
				'edit_item'             => __( 'Edit Réalisation', 'underscores-bootstrap-portfolio' ),
				'view_item'             => __( 'View Réalisation', 'underscores-bootstrap-portfolio' ),
				'view_items'            => __( 'View Réalisations', 'underscores-bootstrap-portfolio' ),
				'search_items'          => __( 'Search Réalisations', 'underscores-bootstrap-portfolio' ),
				'not_found'             => __( 'No Réalisations found', 'underscores-bootstrap-portfolio' ),
				'not_found_in_trash'    => __( 'No Réalisations found in trash', 'underscores-bootstrap-portfolio' ),
				'parent_item_colon'     => __( 'Parent Réalisation:', 'underscores-bootstrap-portfolio' ),
				'menu_name'             => __( 'Réalisations', 'underscores-bootstrap-portfolio' ),
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
			'menu_icon'             => 'dashicons-portfolio',
			'show_in_rest'          => true,
			'rest_base'             => 'realisation',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'realisation_init' );

/**
 * Sets the post updated messages for the `realisation` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `realisation` post type.
 */
function realisation_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['realisation'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Réalisation updated. <a target="_blank" href="%s">View Réalisation</a>', 'underscores-bootstrap-portfolio' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'underscores-bootstrap-portfolio' ),
		3  => __( 'Custom field deleted.', 'underscores-bootstrap-portfolio' ),
		4  => __( 'Réalisation updated.', 'underscores-bootstrap-portfolio' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Réalisation restored to revision from %s', 'underscores-bootstrap-portfolio' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Réalisation published. <a href="%s">View Réalisation</a>', 'underscores-bootstrap-portfolio' ), esc_url( $permalink ) ),
		7  => __( 'Réalisation saved.', 'underscores-bootstrap-portfolio' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Réalisation submitted. <a target="_blank" href="%s">Preview Réalisation</a>', 'underscores-bootstrap-portfolio' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Réalisation scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Réalisation</a>', 'underscores-bootstrap-portfolio' ), date_i18n( __( 'M j, Y @ G:i', 'underscores-bootstrap-portfolio' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Réalisation draft updated. <a target="_blank" href="%s">Preview Réalisation</a>', 'underscores-bootstrap-portfolio' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'realisation_updated_messages' );

/**
 * Sets the bulk post updated messages for the `realisation` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `realisation` post type.
 */
function realisation_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['realisation'] = [
		/* translators: %s: Number of Réalisations. */
		'updated'   => _n( '%s Réalisation updated.', '%s Réalisations updated.', $bulk_counts['updated'], 'underscores-bootstrap-portfolio' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Réalisation not updated, somebody is editing it.', 'underscores-bootstrap-portfolio' ) :
						/* translators: %s: Number of Réalisations. */
						_n( '%s Réalisation not updated, somebody is editing it.', '%s Réalisations not updated, somebody is editing them.', $bulk_counts['locked'], 'underscores-bootstrap-portfolio' ),
		/* translators: %s: Number of Réalisations. */
		'deleted'   => _n( '%s Réalisation permanently deleted.', '%s Réalisations permanently deleted.', $bulk_counts['deleted'], 'underscores-bootstrap-portfolio' ),
		/* translators: %s: Number of Réalisations. */
		'trashed'   => _n( '%s Réalisation moved to the Trash.', '%s Réalisations moved to the Trash.', $bulk_counts['trashed'], 'underscores-bootstrap-portfolio' ),
		/* translators: %s: Number of Réalisations. */
		'untrashed' => _n( '%s Réalisation restored from the Trash.', '%s Réalisations restored from the Trash.', $bulk_counts['untrashed'], 'underscores-bootstrap-portfolio' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'realisation_bulk_updated_messages', 10, 2 );
