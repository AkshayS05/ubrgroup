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
function ubrgroup_enqueue_assets() {
    // Debugging message
    echo '<!-- Styles and Scripts Enqueued Successfully -->';

    // Enqueue the main stylesheet
    wp_enqueue_style('ubrgroup-style', get_stylesheet_uri());

    // Enqueue Font Awesome for icons (if needed)
    wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css');

    // Enqueue custom JavaScript file (if you have one)
    wp_enqueue_script('ubrgroup-scripts', get_template_directory_uri() . '/js/script.js', array(), null, true);

    // Conditionally enqueue services.css only on Services Page template
    if (is_page('Services')) { // Assuming the page is called "Services"
        echo '<!-- Debug: services.css should be enqueued for Services page -->';
        wp_enqueue_style('services-style', get_template_directory_uri() . '/css/services.css', array(), null);
        echo '<script>console.log("Debug: services.css has been enqueued for Services page.");</script>';
    }
    

    // Conditionally enqueue about-us.css only on About Us Page template
    if (is_page_template('page-about-us.php')) {
        wp_enqueue_style('about-us-style', get_template_directory_uri() . '/css/about-us.css', array(), null);
    }
}
add_action('wp_enqueue_scripts', 'ubrgroup_enqueue_assets');





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
    $to = 'Dispatch@ubrgroup.ca'; // Replace with your email address
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


// Register navigation menus
function ubrgroup_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'trucking-company-theme'),
    ));
}
add_action('after_setup_theme', 'ubrgroup_theme_setup');

function ubrgroup_custom_login_logo() {
    ?>
    <style type="text/css">
        /* Set the overall background of the login page to black */
        body.login {
            background-color: #000 !important; /* Black background */
        }

        /* Customize the login form */
        .login form {
            position: relative;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('<?php echo get_stylesheet_directory_uri(); ?>/images/trucking_background.jpg') no-repeat center center !important; /* Darker overlay on truck image for better contrast */
            background-size: cover !important; /* Ensure the image fits perfectly inside the form */
            padding: 70px 60px !important; /* Increase padding for more space */
            border-radius: 25px !important; /* Smooth corners for a modern look */
            box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.9) !important; /* Stronger shadow for enhanced depth */
            width: 600px !important; /* Expanded form width */
            max-width: 90% !important; /* Ensure responsiveness */
        }

        /* Center the login form */
        .login {
            width: 100%;
            max-width: none;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            min-height: 100vh; /* Ensure full viewport height */
            padding: 20px; /* Add space from the edges */
        }

        /* Hide the default WordPress logo image */
        .login h1 a {
            background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/ubr_group_logo.png') !important; /* Path to your custom logo with higher priority */
            background-size: contain !important; /* Ensure the logo fits perfectly */
            background-repeat: no-repeat !important; /* Prevent tiling */
            width: 400px !important; /* Increased the width for larger size */
            height: 200px !important; /* Increased the height for larger size */
            display: block !important; /* Make sure the logo is displayed */
            text-indent: -9999px; /* Hide the text of the default WordPress logo */
            margin-bottom: 40px !important; /* Add more space between the logo and the form */
        }

        /* Add animation for the custom logo */
        .login h1 a {
            animation: fadeInScale 1.5s ease-in-out !important; /* Apply fade-in animation with higher priority */
        }
        .wp-core-ui .button.button-large {
            margin-right: 2rem;
        }
        /* Animation keyframes */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8); /* Start smaller */
            }
            to {
                opacity: 1;
                transform: scale(1); /* Final size */
            }
        }

        /* Style the input fields */
        .login form input[type="text"],
        .login form input[type="password"] {
            background-color: rgba(255, 255, 255, 1) !important; /* Make background solid for better readability */
            border: 2px solid #ca9a0a !important; /* Thicker border to match theme */
            padding: 15px !important; /* Increase padding for larger fields */
            font-size: 18px !important; /* Make text larger */
            color: #000 !important; /* Black text color for strong contrast */
            border-radius: 5px !important; /* Smooth corners */
            width: calc(100% - 30px) !important; /* Ensure responsiveness inside the form */
            margin-bottom: 20px !important; /* Space between input fields */
            box-sizing: border-box; /* Include border and padding in the element's width */
        }

        /* Style the placeholder text */
        .login form input[type="text"]::placeholder,
        .login form input[type="password"]::placeholder {
            color: #777 !important; /* Darker placeholder text */
            font-size: 18px !important; /* Make placeholder text larger */
        }

        /* Style the password visibility toggle icon */
        .login form .wp-hide-pw .dashicons {
            color: #ca9a0a !important; /* Match the theme color */
            font-size: 20px !important; /* Make it larger to match the input fields */
        }

        /* Style the login button */
        .login form .button-primary {
            background-color: #ca9a0a !important; /* Theme color for login button */
            border: none !important; /* Remove border */
            padding: 15px !important; /* Match padding with input fields */
            font-size: 18px !important; /* Larger font for better readability */
            border-radius: 8px !important; /* Smooth corners */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4) !important; /* Add shadow for a button pop effect */
            transition: background-color 0.3s ease, transform 0.3s ease !important; /* Transition for hover effect */
            width: calc(100% - 30px) !important; /* Match width with input fields */
            margin-bottom: 20px !important; /* Space below the button */
            box-sizing: border-box; /* Include border and padding in the element's width */
            cursor: pointer; /* Add pointer on hover for better UX */
        }

        .login form .button-primary:hover {
            background-color: #f1bc0e !important; /* Lighter hover color */
            transform: translateY(-2px) !important; /* Slight lift on hover */
        }

        /* Style for login links */
        #login #nav a,
        #login #backtoblog a {
            color: #ca9a0a !important; /* Match your theme color */
            text-decoration: none !important;
            font-weight: bold !important;
            transition: color 0.3s ease !important;
        }

        #login #nav a:hover,
        #login #backtoblog a:hover {
            color: #f1bc0e !important; /* Lighter hover color */
            text-decoration: underline !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            /* Form adjustments for tablets and smaller screens */
            .login form {
                width: 90% !important; /* Adjust form width for smaller screens */
                padding: 40px 30px !important; /* Reduce padding for smaller screens */
            }

            .login h1 a {
                width: 300px !important; /* Reduce logo size on smaller screens */
                height: 150px !important; /* Reduce logo height */
                margin-bottom: 20px !important; /* Reduce space below the logo */
            }

            /* Input fields and button on smaller screens */
            .login form input[type="text"],
            .login form input[type="password"] {
                padding: 10px !important; /* Reduce padding for smaller screens */
                font-size: 16px !important; /* Adjusted font size */
            }

            .login form .button-primary {
                padding: 12px !important; /* Smaller padding for buttons */
                font-size: 16px !important; /* Reduce button font size */
            }
        }

        @media (max-width: 480px) {
            /* Further adjustments for mobile screens */
            .login form {
                width: 100% !important; /* Full width for mobile */
                padding: 30px 20px !important; /* Less padding for smaller screens */
            }

            .login h1 a {
                width: 250px !important; /* Smaller logo for mobile */
                height: 125px !important;
            }

            .login form input[type="text"],
            .login form input[type="password"] {
                font-size: 15px !important; /* Adjust font size for readability */
            }

            .login form .button-primary {
                padding: 10px !important; /* More compact button */
                font-size: 15px !important; /* Smaller font */
            }
        }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'ubrgroup_custom_login_logo');



function ubrgroup_custom_login_favicon() {
    ?>
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/ubr_group_logo.png" type="image/png">
    <?php
}
add_action('login_head', 'ubrgroup_custom_login_favicon');


