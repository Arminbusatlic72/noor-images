<?php
/**
 * Template Name: Latest Content
 * Description: A custom template to display the latest Stories, Articles, and Announcements.
 */
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <!-- Latest Stories Section -->
        <section class="latest-stories">
            <div class="front-page__header-block">
            <h2 class="front-page__title">Latest Stories</h2>
            <a href="<?php echo get_post_type_archive_link('stories'); ?>" class="front-page__view-all-link">View All Stories</a>
            </div>
        

            <div class="latest-stories-grid">
    <?php
    $stories_query = new WP_Query( array(
        'post_type'      => 'stories', // Replace with your custom post type slug
        'posts_per_page' => 6,        // Number of stories to display
    ) );

    if ( $stories_query->have_posts() ) :
        while ( $stories_query->have_posts() ) : $stories_query->the_post(); ?>
            <article class="latest-stories-item">
                
                    <a class="latest-stories__link" href="<?php the_permalink(); ?>">
                       
                        <?php 
                        echo get_the_post_thumbnail(
                            get_the_ID(), 
                            'full', 
                            array( 'class' => 'custom-thumbnail' ) // Add your custom class here
                        ); 
                        ?>
                        <div class="latest-stories__details-wrapper">
                        <h3 class="latest-stories__details-title"><?php the_title(); ?></h3>
                        </div>
                    </a>
                
            </article>
        <?php endwhile;
        wp_reset_postdata();
    else : ?>
        <p>No stories found.</p>
    <?php endif; ?>
</div>

        </section>

        <!-- Latest Articles Section -->
        <section class="latest-articles">
             <div class="front-page__header-block">
            <h2 class="front-page__title">Latest Articles</h2>
             <a href="<?php echo get_post_type_archive_link('articles'); ?>" class="front-page__view-all-link">View All Articles</a>
    </div>
            <div class="latest-articles-grid">
                <?php
                $articles_query = new WP_Query( array(
                    'post_type'  => 'articles', // Replace with your category slug
                    'posts_per_page' => 6,          // Number of articles to display
                ) );

                if ( $articles_query->have_posts() ) :
                    while ( $articles_query->have_posts() ) : $articles_query->the_post(); ?>
                        <article class="latest-articles-item">
                            <a class="latest-articles__link" href="<?php the_permalink(); ?>">
                               <?php 
                        echo get_the_post_thumbnail(
                            get_the_ID(), 
                            'full', 
                            array( 'class' => 'custom-thumbnail' ) // Add your custom class here
                        ); 
                        ?>
                        <div class="latest-articles__details-wrapper">
                                <h3 class="latest-articles__details-title"><?php the_title(); ?></h3>
                                </div>
                            </a>
                        </article>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p>No articles found.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Latest Announcements Section -->
        <section class="latest-announcements">
            <h2>Latest Announcements</h2>
            <div class="announcement-grid">
                <?php
                $announcements_query = new WP_Query( array(
                    'post_type'      => 'announcements', // Replace with your custom post type slug
                    'posts_per_page' => 3,               // Number of announcements to display
                ) );

                if ( $announcements_query->have_posts() ) :
                    while ( $announcements_query->have_posts() ) : $announcements_query->the_post(); ?>
                        <article class="announcement-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                                <h3><?php the_title(); ?></h3>
                            </a>
                        </article>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p>No announcements found.</p>
                <?php endif; ?>
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>










