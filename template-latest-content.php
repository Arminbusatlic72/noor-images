a<?php
/**
 * Template Name: Latest Content
 * Description: A custom template to display the latest Stories, Articles, and Announcements.
 */
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <!-- Latest Stories Section -->
        <section class="latest-stories__section">
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
                            'medium', 
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
        <section class="latest-articles__section">
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
                            'medium', 
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
         <div class="latest-announcements-section-wrapper">
        <section class="latest-announcements__section">
            <div class="front-page__header-block">
            <h2 class="front-page__title">Latest Announcements</h2>
             
    </div>
            <div class="latest-announcement-grid">
                <div class="latest-announcements-heading-wrapper">
                    <h6 class="latest-announcements__heading">Check our announcements</h6>
                    <a href="<?php echo get_post_type_archive_link('announcements'); ?>" class="latest-announcements__button">See all announcements</a>
                </div>
                <div class="latest-announcements-articles-wrapper">
                <?php
                $announcements_query = new WP_Query( array(
                    'post_type'      => 'announcements', // Replace with your custom post type slug
                    'posts_per_page' => 2,               // Number of announcements to display
                ) );

                if ( $announcements_query->have_posts() ) :
                    while ( $announcements_query->have_posts() ) : $announcements_query->the_post(); ?>
                        <article class="latest-announcements-article">
                            <div class="latest-announcements-article__content-wrapper">
                                <div class="latest-announcements-article__header-container">
                                
                                <!-- Display Announcement Time -->
                        <?php if ( have_rows('announcement_time') ) : ?>
                            <div class="latest-announcement-time-wrapper">
                                <?php while ( have_rows('announcement_time') ) : the_row(); 
                                    $start_date = get_sub_field('date_start');
                                    $start_time = get_sub_field('time_start');
                                    $end_date = get_sub_field('date_end');
                                    $end_time = get_sub_field('time_end');
                                ?>
                                    
                                        
                                        <span class="start-date"><?php echo esc_html($start_date); ?></span> - 
                                        <span class="start-time"><?php echo esc_html($start_time); ?></span>
                                
                                    <span class="separator"> - </span>
                                    
                                       
                                        <span class="end-date"><?php echo esc_html($end_date); ?></span> - 
                                        <span class="end-time"><?php echo esc_html($end_time); ?></span>
                                    
                                <?php endwhile; ?>
                            </div>
                        <?php else : ?>
                            <p>No announcement times found.</p>
                        <?php endif; ?>
                                <h3><?php the_title(); ?></h3>
                                 <p class="story-subtitle"><?php the_field('subtitle'); ?></p>
                                </div>
                            </div>
                            <div class="latest-announcements-article__button-wrapper">
                            <a class="latest-announcements-article__button"href="<?php the_permalink(); ?>">
                              Details
                                
                            </a>
                </div>
                        </article>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p>No announcements found.</p>
                <?php endif; ?>
                </div>
            </div>
        </section>
</div>
    </main><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>










