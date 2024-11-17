<section id="detailed-services">
    <div class="container">
        <h2 class="vertical-heading">Our Comprehensive Services</h2>
        <div class="service-detailed-cards">
            <?php
            // Query to fetch all services
            $services_args = array(
                'post_type'      => 'service',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            );
            $services_query = new WP_Query($services_args);

            if ($services_query->have_posts()) :
                while ($services_query->have_posts()) : $services_query->the_post();
                    // Retrieve icon class (stored in a custom meta field)
                    $icon_class = get_post_meta(get_the_ID(), 'service_icon', true);
                    // Retrieve additional custom fields if needed (e.g., short description)
                    $short_description = get_post_meta(get_the_ID(), 'service_short_description', true);
            ?>
                <div class="service-detailed-card">
                    <!-- Icon Section -->
                    <div class="service-icon">
                        <?php if ($icon_class) : ?>
                            <i class="<?php echo esc_attr($icon_class); ?>"></i>
                        <?php else : ?>
                            <i class="fas fa-cogs"></i> <!-- Default icon if none provided -->
                        <?php endif; ?>
                    </div>
                    
                    <!-- Title and Description -->
                    <h3><?php the_title(); ?></h3>
                    <?php if ($short_description) : ?>
                        <p><?php echo esc_html($short_description); ?></p>
                    <?php endif; ?>
                    <p><?php the_content(); ?></p>

                    <!-- Get a Quote Button -->
                    <a href="<?php echo site_url('/contact'); ?>" class="btn get-quote-btn">Get a Quote</a>
                </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            else : ?>
                <p>No services available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
