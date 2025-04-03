<?php
/**
 * Template Name: Boxed Content
 * Description: A custom template to display content in boxed format.
 */
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        // Start the loop
        while (have_posts()) : the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('boxed-content'); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content boxed-content-container">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->

               
            </article><!-- #post-## -->
        <?php
        endwhile; // End of the loop.
        ?>
    </main><!-- #main -->
</div><!-- #primary -->



<?php get_footer(); ?>