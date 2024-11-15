<?php
/**
 * Template Name: Front Page
 */

get_header(); ?>

<!-- Slider Section -->
<section id="slider">
    <div class="slides">
        <div class="slide">
            <img src="<?php echo get_template_directory_uri(); ?>/images/slider1.jpg" alt="Slide 1">
        </div>
        <div class="slide">
            <img src="<?php echo get_template_directory_uri(); ?>/images/slider2.jpg" alt="Slide 2">
        </div>
        <div class="slide">
            <img src="<?php echo get_template_directory_uri(); ?>/images/slider3.jpg" alt="Slide 3">
        </div>
    </div>
    <div class="slider-controls">
        <span class="prev">&#10094;</span>
        <span class="next">&#10095;</span>
    </div>
</section>

<!-- About Us Section -->
<section id="about">
    <div class="container">
        <h2>About Us</h2>
        <p>
            Welcome to UBR Group, where we deliver excellence in transportation. Our fleet is equipped with the latest technology to ensure timely and safe deliveries across the nation.
        </p>
    </div>
</section>
<!-- Include Services Section -->
<?php get_template_part('section', 'services'); ?>
<!-- hero section -->
<section id="hero">
    <div class="hero-overlay">
        <div class="container-vertical">
            <h1>Reliable Trucking Services</h1>
            <p>We ensure safe and timely deliveries, every time.</p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="cta-button">Get a Free Quote</a>
        </div>
    </div>
</section>



<!-- Include Achievements Section -->
<?php get_template_part('section', 'achievements'); ?>

<!-- Testimonials Section -->
<section id="testimonials-carousel">
    <div class="container-vertical">
        <h2>What Our Clients Say</h2>
        <?php
        $args = array(
            'post_type'      => 'testimonial',
            'posts_per_page' => 10,
            'post_status'    => 'publish',
        );

        $testimonials = new WP_Query($args);

        if ($testimonials->have_posts()) : ?>
            <div class="carousel">
                <div class="carousel-inner">
                    <?php
                    $index = 0;
                    while ($testimonials->have_posts()) : $testimonials->the_post();
                        // Get the rating and username meta data
                        $rating = get_post_meta(get_the_ID(), 'testimonial_rating', true);
                        $username = get_post_meta(get_the_ID(), 'testimonial_username', true); // Retrieve the username
                        ?>
                        
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="testimonial-content">
                                <p class="review-text"><?php the_content(); ?></p>
                                
                                <!-- Display the title as the business name, and the username if available -->
                                <h4 class="business-name">- <?php the_title(); ?><?php echo $username ? ' (by ' . esc_html($username) . ')' : ''; ?></h4>
                                
                                <!-- Display the rating if it exists -->
                                <?php if ($rating) : ?>
                                    <div class="testimonial-rating">
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <span style="color: <?php echo $i <= $rating ? '#ffc107' : '#e4e5e9'; ?>">★</span>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                    <?php
                        $index++;
                    endwhile;
                    ?>
                </div>
                
                <!-- Carousel dots for navigation -->
                <div class="carousel-dots">
                    <?php for ($i = 0; $i < $index; $i++) : ?>
                        <span class="dot <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>"></span>
                    <?php endfor; ?>
                </div>
            </div>
        <?php else : ?>
            <p>No testimonials found.</p>
        <?php endif;
        
        // Reset the global post object
        wp_reset_postdata();
        ?>
    </div>
</section>

<?php get_footer(); ?>
