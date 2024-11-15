<?php

function create_testimonial_post_type() {

$labels = array(
    'name'                  => _x( 'Testimonials', 'Post Type General Name', 'ubrgroup' ),
    'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'ubrgroup' ),
    'menu_name'             => __( 'Testimonials', 'ubrgroup' ),
    'name_admin_bar'        => __( 'Testimonial', 'ubrgroup' ),
    'archives'              => __( 'Testimonial Archives', 'ubrgroup' ),
    'attributes'            => __( 'Testimonial Attributes', 'ubrgroup' ),
    'parent_item_colon'     => __( 'Parent Testimonial:', 'ubrgroup' ),
    'all_items'             => __( 'All Testimonials', 'ubrgroup' ),
    'add_new_item'          => __( 'Add New Testimonial', 'ubrgroup' ),
    'add_new'               => __( 'Add New', 'ubrgroup' ),
    'new_item'              => __( 'New Testimonial', 'ubrgroup' ),
    'edit_item'             => __( 'Edit Testimonial', 'ubrgroup' ),
    'update_item'           => __( 'Update Testimonial', 'ubrgroup' ),
    'view_item'             => __( 'View Testimonial', 'ubrgroup' ),
    'view_items'            => __( 'View Testimonials', 'ubrgroup' ),
    'search_items'          => __( 'Search Testimonial', 'ubrgroup' ),
    'not_found'             => __( 'Not found', 'ubrgroup' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'ubrgroup' ),
    'featured_image'        => __( 'Featured Image', 'ubrgroup' ),
    'set_featured_image'    => __( 'Set featured image', 'ubrgroup' ),
    'remove_featured_image' => __( 'Remove featured image', 'ubrgroup' ),
    'use_featured_image'    => __( 'Use as featured image', 'ubrgroup' ),
    'insert_into_item'      => __( 'Insert into testimonial', 'ubrgroup' ),
    'uploaded_to_this_item' => __( 'Uploaded to this testimonial', 'ubrgroup' ),
    'items_list'            => __( 'Testimonials list', 'ubrgroup' ),
    'items_list_navigation' => __( 'Testimonials list navigation', 'ubrgroup' ),
    'filter_items_list'     => __( 'Filter testimonials list', 'ubrgroup' ),
);
$args = array(
    'label'                 => __( 'Testimonial', 'ubrgroup' ),
    'description'           => __( 'Client Testimonials', 'ubrgroup' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
    'taxonomies'            => array(),
    'hierarchical'          => false,
    'public'                => true, // Changed to true
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-testimonial',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => false, // Adjust based on preference
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
    'show_in_rest'          => true, 
);
register_post_type( 'testimonial', $args );

}
add_action( 'init', 'create_testimonial_post_type', 0 );
