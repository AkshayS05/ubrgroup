<?php
/* Template Name: Review Form */
get_header();
?>

<div class="content-container">
    
    <div class="content">
        <?php echo do_shortcode('[react_review_form]'); ?>
    </div>
</div>
<!-- Include Achievements Section -->
<?php get_template_part('section', 'achievements'); ?>


<?php get_footer(); ?>
