<?php
/**
 * UBR Group Theme functions and definitions
 *
 * @package Trucking_Company_Theme
 */



if ( ! function_exists( 'ubrgroup_theme_setup' ) ) :
function ubrgroup_theme_setup() {
    // Add support for dynamic title tag
    add_theme_support( 'title-tag' );

    // Add support for featured images
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'trucking-company-theme' ),
    ) );
}
endif;
add_action( 'after_setup_theme', 'ubrgroup_theme_setup' );

// Enqueue custom styles and scripts for specific templates
if ( ! function_exists( 'ubrgroup_enqueue_assets' ) ) {
    function ubrgroup_enqueue_assets() {
        // Enqueue the main stylesheet
        wp_enqueue_style( 'ubrgroup-style', get_stylesheet_uri() );

        // Enqueue Font Awesome for icons (if needed)
        wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css' );

        // Enqueue custom JavaScript file (if you have one)
        wp_enqueue_script( 'ubrgroup-scripts', get_template_directory_uri() . '/js/script.js', array(), null, true );

        // Conditionally enqueue services.css only on Services Page template
        if ( is_page_template( 'services-page.php' ) ) {
            wp_enqueue_style(
                'services-style',
                get_template_directory_uri() . '/css/services.css',
                array(),
                null
            );
        }

        // Conditionally enqueue about-us.css only on About Us Page template
        if ( is_page_template( 'page-about-us.php' ) ) {
            wp_enqueue_style(
                'about-us-style',
                get_template_directory_uri() . '/css/about-us.css',
                array(),
                null
            );
        }
    }
    add_action( 'wp_enqueue_scripts', 'ubrgroup_enqueue_assets' );
}




// Redirect subscribers to the frontend.
add_action('admin_init', 'redirect_subs_to_frontend');

function redirect_subs_to_frontend() {
    $currentUser = wp_get_current_user();

    if (count($currentUser->roles) == 1 && $currentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

// Disable the admin bar for subscribers.
add_action('wp_loaded', 'disable_admin_bar_for_subs');

function disable_admin_bar_for_subs() {
    $currentUser = wp_get_current_user();

    if (count($currentUser->roles) == 1 && $currentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

//customizing login screen
add_filter('login_headerurl','headerUrl');

function headerUrl(){
    return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'loginCSS');

function loginCSS() {
    wp_enqueue_style(
        'ubrgroup-login-style',
        get_template_directory_uri() . '/custom-login.css', 
        array(),
        null
    );
}
add_action('login_enqueue_scripts', 'loginCSS');

// Enqueue Custom Register CSS
function ubr_custom_register_css() {
    if (isset($_GET['action']) && $_GET['action'] === 'register') {
        wp_enqueue_style(
            'ubrgroup-register-style',
            get_template_directory_uri() . '/custom-register.css',
            array(),
            null
        );
    }
}
add_action('login_enqueue_scripts', 'ubr_custom_register_css');


//contact form
add_action('rest_api_init', function () {
    register_rest_route('contact-api/v1', '/submit', array(
        'methods' => 'POST',
        'callback' => 'handle_contact_form_submission',
        'permission_callback' => '__return_true', // Adjust if authentication is needed
    ));
});

function handle_contact_form_submission($request) {
    // Sanitize input data to prevent SQL injection or XSS attacks
    $name = sanitize_text_field($request['name']);
    $email = sanitize_email($request['email']);
    $message = sanitize_textarea_field($request['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        return new WP_Error('missing_fields', 'Please fill in all required fields', array('status' => 400));
    }

    // Prepare and send the email
    $to = 'your-email@example.com'; // Replace with your email address
    $subject = 'New Contact Form Submission';
    $body = "Name: $name\nEmail: $email\nMessage: $message";
    $headers = array('Content-Type: text/plain; charset=UTF-8');

    // Send the email
    if (!wp_mail($to, $subject, $body, $headers)) {
        return new WP_Error('email_failed', 'Failed to send email', array('status' => 500));
    }

    // Optional: Save the data in the database (uncomment to use)
    /*
    global $wpdb;
    $wpdb->insert(
        $wpdb->prefix . 'contact_submissions',
        array(
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'submitted_at' => current_time('mysql'),
        )
    );
    */

    return rest_ensure_response(array('message' => 'Your message was sent successfully!'));
}


// Register Service CPT
function ubrgroup_register_service_cpt() {
    $labels = array(
        'name' => 'Services',
        'singular_name' => 'Service',
        'add_new_item' => 'Add New Service',
        'edit_item' => 'Edit Service',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-hammer', // Choose an icon for the menu
    );
    register_post_type('service', $args);
}
add_action('init', 'ubrgroup_register_service_cpt');

// Register Achievement CPT
function ubrgroup_register_achievement_cpt() {
    $labels = array(
        'name' => 'Achievements',
        'singular_name' => 'Achievement',
        'add_new_item' => 'Add New Achievement',
        'edit_item' => 'Edit Achievement',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'supports' => array('title', 'thumbnail'),
        'menu_icon' => 'dashicons-awards',
    );
    register_post_type('achievement', $args);
}
add_action('init', 'ubrgroup_register_achievement_cpt');

// Add custom meta box for target number in achievements
function ubrgroup_add_achievement_meta_box() {
    add_meta_box(
        'achievement_target',
        'Achievement Target',
        'ubrgroup_achievement_target_callback',
        'achievement'
    );
}
add_action('add_meta_boxes', 'ubrgroup_add_achievement_meta_box');

function ubrgroup_achievement_target_callback($post) {
    $value = get_post_meta($post->ID, 'achievement_target', true);
    echo '<label for="achievement_target">Target Number:</label>';
    echo '<input type="number" id="achievement_target" name="achievement_target" value="' . esc_attr($value) . '" />';
}

function ubrgroup_save_achievement_meta($post_id) {
    if (array_key_exists('achievement_target', $_POST)) {
        update_post_meta($post_id, 'achievement_target', intval($_POST['achievement_target']));
    }
}
add_action('save_post', 'ubrgroup_save_achievement_meta');

//About us page type
// Register Custom Post Type for About Us
function register_about_us_post_type() {
    $labels = array(
        'name'               => 'About Us',
        'singular_name'      => 'About Us',
        'menu_name'          => 'About Us',
        'name_admin_bar'     => 'About Us',
        'add_new'            => 'Add New Section',
        'add_new_item'       => 'Add New About Us Section',
        'new_item'           => 'New Section',
        'edit_item'          => 'Edit Section',
        'view_item'          => 'View Section',
        'all_items'          => 'All Sections',
        'search_items'       => 'Search Sections',
        'not_found'          => 'No sections found.',
        'not_found_in_trash' => 'No sections found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'description'        => 'Sections for the About Us page',
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'has_archive'        => false,
        'exclude_from_search'=> true,
        'publicly_queryable' => false,
        'capability_type'    => 'post',
    );

    register_post_type( 'about_us', $args );
}
add_action( 'init', 'register_about_us_post_type' );
