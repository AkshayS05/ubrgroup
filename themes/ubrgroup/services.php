<?php
/**
 * Template Name: Services Page
 */
get_header(); ?>

<!-- Hero Section for Services Page -->
<section id="hero">
    <div class="hero-overlay">
        <div class="container-vertical">
            <h1>Our Comprehensive Services</h1>
            <p>From freight transport to secure warehousing, UBR Group provides reliable solutions tailored for your business.</p>
        </div>
    </div>
</section>

<!-- Include Services Section -->
<?php get_template_part('section', 'services'); ?>

<!-- Include Achievements Section -->
<?php get_template_part('section', 'achievements'); ?>

<?php get_footer(); ?>
