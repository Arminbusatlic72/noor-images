<?php get_header(); ?>

<main class="archive-announcements-container">
    <header class="archive-header">
       <div class="stories-archive__header-block">
            <h2 class="stories-archive__title">See upcoming announcements</h2>            
     </div>
       
    </header>

    <?php if (have_posts()) : ?>
        <div class="announcements-grid">
            <div class="announcements-filter-wrapper">
                <h3 class="announcements-filter__title">What's on</h3>
                <p class="announcements-filter__text">Looking for a particular announcement?</p>
                <p class="announcements-filter__text">See all announcements</p>
                <form class="announcements-search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
        <input
            type="text"
            name="s"
            class="announcements-search-input"
            placeholder="Search announcements..."
            value="<?php echo get_search_query(); ?>"
            aria-label="Search announcements"
        />
        <input
            type="hidden"
            name="post_type"
            value="announcements"
        />
    </form>
</div>

            <div class="announcements-content-wrapper">
                <div class="announcements-filter_list">
            <?php while (have_posts()) : the_post(); ?>
                <article  class="announcements-item" id="post-<?php the_ID(); ?>" <?php post_class('announcement-item'); ?>>
                   
                       
                        <div class="announcement-content">
                            <div class="announcement-time-wrapper">
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
                            </div>
                            <h2 class="announcement-title"><?php the_title(); ?></h2>
                            <p class="announcement-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        </div>
                        <div class="announcement-button">
                             <a href="<?php the_permalink(); ?>" class="announcement-link">
                            Details
                             </a>
                        </div>
                         <?php if (has_post_thumbnail()) : ?>
                            <div class="announcement-thumbnail-wrapper">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>
                   
                </article>
            <?php endwhile; ?>
            </div>
            </div>
        </div>

        <div class="pagination">
            <?php
            // Display pagination links
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('&laquo; Previous', 'textdomain'),
                'next_text' => __('Next &raquo;', 'textdomain'),
            ));
            ?>
        </div>
    <?php else : ?>
        <p>No announcements found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
