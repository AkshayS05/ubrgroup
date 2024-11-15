<?php
// section-services.php
?>
<section id="services">
    <div class="container">
        <h2 class="vertical-heading">Our Services</h2>
        <div class="service-cards">
            <?php
            $services_args = array(
                'post_type' => 'service',
                'posts_per_page' => -1,
                'post_status' => 'publish',
            );
            $services_query = new WP_Query($services_args);

            if ($services_query->have_posts()) :
                while ($services_query->have_posts()) : $services_query->the_post();
                    $icon_class = get_post_meta(get_the_ID(), 'service_icon', true); // Retrieve the icon class
            ?>
                <div class="service-card">
                    <?php if ($icon_class) : ?>
                        <i class="<?php echo esc_attr($icon_class); ?>"></i> <!-- Display the icon -->
                    <?php endif; ?>
                    <h3><?php the_title(); ?></h3>
                    <p><?php the_content(); ?></p>
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
