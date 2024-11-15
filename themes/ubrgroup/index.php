<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme,
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no front-page.php or home.php exists.
 *
 * @package UBR Group
 */

get_header(); // Load the header.php template
?>

<main id="main-content">
    <div class="container">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                    </header>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>

            <!-- Pagination for multiple posts -->
            <div class="pagination">
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => __( '← Previous', 'ubrgroup' ),
                    'next_text' => __( 'Next →', 'ubrgroup' ),
                ) );
                ?>
            </div>

        <?php else : ?>
            <article class="no-posts">
                <h2>No Content Found</h2>
                <p>Sorry, but nothing matched your search criteria. Please try again with different keywords.</p>
            </article>
        <?php endif; ?>
    </div>
</main>

<?php
get_sidebar(); // Optional: Load sidebar.php if it exists
get_footer(); // Load footer.php
?>
