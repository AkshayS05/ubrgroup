<?php
/*
Template Name: About Us
*/

get_header(); ?>

<section id="about-us">
    <div class="container">
        <?php
        // Query to get all About Us posts
        $args = array(
            'post_type'      => 'about_us',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        );
        $about_query = new WP_Query( $args );
        $counter = 0;

        if ( $about_query->have_posts() ) :
            while ( $about_query->have_posts() ) : $about_query->the_post();
                $counter++;
                $reverse_class = ( $counter % 2 == 0 ) ? ' reverse' : '';
        ?>
                <div class="about-section<?php echo $reverse_class; ?>">
                    <div class="about-image">
                        <?php if ( has_post_thumbnail() ) {
                            $alt_text = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
                            the_post_thumbnail( 'full', array( 'alt' => esc_attr( $alt_text ) ) );
                        } ?>
                    </div>
                    <div class="about-text">
                        <h2><?php the_title(); ?></h2>
                        <?php the_content(); ?>
                        <a href="<?php echo site_url('/contact'); ?>" class="btn">Learn More</a>
                    </div>
                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>No About Us sections found.</p>';
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
