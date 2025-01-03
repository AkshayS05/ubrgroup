<?php
/**
 * Plugin Name: React Review Form
 * Description: A React-based review form plugin for WordPress.
 * Version: 1.0.1
 * Author: Akshay Sharma
 */

function react_review_form_enqueue_assets() {
    if (is_page('review-form')) { // Load only on the review form page
        // Enqueue CSS
        $css_files = glob(plugin_dir_path(__FILE__) . 'review-app/build/static/css/main.*.css');
        if (!empty($css_files)) {
            wp_enqueue_style(
                'react-review-form-style',
                plugins_url('review-app/build/static/css/' . basename($css_files[0]), __FILE__)
            );
        }

        // Enqueue JS
        $js_files = glob(plugin_dir_path(__FILE__) . 'review-app/build/static/js/main.*.js');
        if (!empty($js_files)) {
            wp_enqueue_script(
                'react-review-app',
                plugins_url('review-app/build/static/js/' . basename($js_files[0]), __FILE__),
                array('wp-element'), // Ensure React dependency
                null,
                true
            );
        }

        // Localize script to pass data to React app
        wp_localize_script('react-review-app', 'ReactAppData', array(
            'nonce' => wp_create_nonce('wp_rest'),
            'user_logged_in' => is_user_logged_in(),
            'username' => is_user_logged_in() ? wp_get_current_user()->user_login : '',
        ));
    }
}
add_action('wp_enqueue_scripts', 'react_review_form_enqueue_assets');

// Shortcode to render the React app container
function render_review_form_shortcode() {
    return '<div id="react-review-form"></div>';
}
add_shortcode('react_review_form', 'render_review_form_shortcode');

// Register a custom REST API endpoint
add_action('rest_api_init', function () {
    register_rest_route('react-review-form/v1', '/submit', array(
        'methods' => 'POST',
        'callback' => 'handle_review_submission',
        'permission_callback' => function () {
            return is_user_logged_in(); // Only allow logged-in users
        },
    ));
});

function handle_review_submission($request) {
    // Verify the nonce
    if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
        return new WP_Error('invalid_nonce', 'Invalid nonce', array('status' => 403));
    }

    // Get parameters from the request
    $business_name = sanitize_text_field($request['business_name']);
    $review_content = sanitize_textarea_field($request['review']);
    $rating = intval($request['rating']);
    $username = sanitize_text_field($request['username']); // Retrieve username

    // Validate the data
    if (empty($business_name) || empty($review_content) || $rating < 1 || $rating > 5) {
        return new WP_Error('invalid_data', 'Please fill in all required fields correctly.', array('status' => 400));
    }

    // Create a new testimonial post
    $testimonial_post = array(
        'post_title'   => $business_name,
        'post_content' => $review_content,
        'post_status'  => 'publish', // Set to 'publish' to make it visible immediately
        'post_type'    => 'testimonial',
        'meta_input'   => array(
            'testimonial_rating' => $rating,
            'testimonial_user_id' => get_current_user_id(),
            'testimonial_username' => $username,
            'testimonial_business_name' => $business_name, // Added to fix missing meta
            'testimonial_review' => $review_content, // Added to fix missing meta
        ),
    );

    $post_id = wp_insert_post($testimonial_post);

    if ($post_id) {
        // Optionally send an email notification to admin
        wp_mail(get_option('admin_email'), 'New Testimonial Submission', 'A new testimonial has been submitted.');

        return array('success' => true, 'message' => 'Thank you for your review!');
    } else {
        return new WP_Error('insert_failed', 'Failed to submit your review.', array('status' => 500));
    }
}

// Testimonials Carousel
function display_testimonials_carousel() {
    ob_start(); // Capture output
    ?>
    <section id="testimonials-carousel">
        <div class="container-vertical">
            <h2>What Our Clients Say</h2>
            <div class="carousel">
                <div class="carousel-inner">
                    <?php
                    // Query to fetch testimonials
                    $args = array(
                        'post_type'      => 'testimonial',
                        'posts_per_page' => 10,
                        'post_status'    => 'publish',
                    );

                    $testimonials = new WP_Query($args);

                    if ($testimonials->have_posts()) :
                        $index = 0; // To track the first item
                        while ($testimonials->have_posts()) : $testimonials->the_post();
                            $business_name = get_post_meta(get_the_ID(), 'testimonial_business_name', true);
                            $rating = get_post_meta(get_the_ID(), 'testimonial_rating', true);
                            $review = get_the_content(); // Use post content for the review text

                            // Skip testimonials without a business name or review
                            if (empty($business_name) || empty($review)) {
                                continue;
                            }
                    ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'center' : ''; ?>">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <p class="review-text">"<?php echo esc_html($review); ?>"</p>
                                        <p class="business-name">- <?php echo esc_html($business_name); ?></p>
                                        <?php if ($rating) : ?>
                                            <div class="testimonial-rating">
                                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                    <span style="color: <?php echo $i <= $rating ? '#ffd700' : '#e4e5e9'; ?>">★</span>
                                                <?php endfor; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                    <?php
                            $index++;
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p>No testimonials found.</p>';
                    endif;
                    ?>
                </div>
                <!-- Navigation Buttons -->
                <div class="carousel-navigation">
                    <button class="prev"><i class="fas fa-chevron-left"></i></button>
                    <button class="next"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean(); // Return captured output
}
add_shortcode('testimonials_carousel', 'display_testimonials_carousel');
