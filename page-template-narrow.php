<?php
/**
 * Template Name: Narrow Page Template
 * Template Post Type: page
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        while ( have_posts() ) :
            the_post();

            // Display the featured image full-width above the container
            if ( has_post_thumbnail() ) :
                echo '<div class="featured-image-full-width">';
                the_post_thumbnail('full');

                // Optional caption
                $thumbnail_id = get_post_thumbnail_id();
                $caption = wp_get_attachment_caption($thumbnail_id);
                if ( $caption ) :
                    echo '<p class="wp-caption-text">' . esc_html($caption) . '</p>';
                endif;

                echo '</div>';
            endif;
        ?>

        <div class="ast-container ast-narrow-container">
            
                   
              
            <?php
                // Display the content (Block Editor compatible)
                echo '<div class="entry-content">';
                echo '<header class="entry-header">';
                echo ' <h1 class="entry-title">';
                the_title();
                echo '</h1>';
                echo '</header>';
                the_content();
                echo '</div>';
            ?>
        </div>

        <?php endwhile; ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
