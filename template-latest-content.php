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
        
        <!-- Bios Section -->
    <div class="bios-section-wrapper">
        <section class="bios-section">
            <div class="front-page__header-block border-white">
            <h2 class="front-page__title text-white">Bios</h2>
             <a href="<?php echo get_post_type_archive_link('bios'); ?>" class="front-page__view-all-link text-white">View All Bios</a>
    </div>
            <div class="bios-grid">


            <?php
                $articles_query = new WP_Query( array(
                    'post_type'  => 'bios', // Replace with your category slug
                    'posts_per_page' => 3,          // Number of articles to display
                ) );

                if ( $articles_query->have_posts() ) :
                    while ( $articles_query->have_posts() ) : $articles_query->the_post(); ?>
                        <article class="bios-item">
                            <a class="bios-link" href="<?php the_permalink(); ?>">
                               <?php 
                        echo get_the_post_thumbnail(
                            get_the_ID(), 
                            'full', 
                            array( 'class' => 'custom-thumbnail' ) // Add your custom class here
                        ); 
                        ?>
                        <div class="bios-details-wrapper">
                                <h3 class="bios-details-details-title text-white"><?php the_field('name_and_surname'); ?></h3>
                                <h6 class="bios-details-details-title text-white"><?php the_field('subtitle'); ?></h6>

                        </div>

                         <div class="bios-social-media-archive">
    <?php
    $social_icons = array(
        'Facebook' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>',
        'Twitter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.4 151.7c0 2.4-.1 4.8-.4 7.2-8.6 37.1-28.5 68.5-54.2 91.4 1.3 29.9-4.1 59.7-14.8 85.5-9.7 25.7-24.7 49.5-44.5 70.1-19.7 20.6-43.5 37-69.6 50.2-26.1 13.3-54.4 24.1-83.5 33.2-29.1 9.1-58.3 17.2-88.4 24.3-15.3 3.5-30.8 6.7-46.4 9.5 8.1-29.9 3.5-63.7-13.2-90.4 17.5-4.4 34.2-9.8 49.5-16.2 11.5-3.6 22.8-7.6 33.8-11.7-21.3-16.1-35.8-41.5-39.4-69.2 7.9 4.7 16.7 7.3 25.8 8.3-20.9-14-33.4-39-33.4-66.7 0-14.8 3.9-28.7 10.9-40.9 37.4 45.9 93 76.2 155.5 79.6-1.3-5.9-2-12-2-18.1 0-43.6 35.3-78.6 78.8-78.6 22.7 0 43.3 9.4 57.8 24.7 18.1-3.5 34.6-10.1 49.8-19.3-6 18.5-18.6 34.1-35.2 44.2 16.3-1.9 32.4-6.2 47.1-12.6-11.7 16.6-26.4 31.2-43.2 42.4z"></path></svg>', 
        'Instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 202.66A53.34 53.34 0 1 0 277.34 256 53.38 53.38 0 0 0 224 202.66zm124.71-41a53.46 53.46 0 1 1 53.46-53.46A53.52 53.52 0 0 1 348.71 161.66zm-71.42 214.63a140.88 140.88 0 1 1 140.88-140.88A140.9 140.9 0 0 1 277.29 376.29z"></path></svg>',
        'Pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg>'
    );

    // Get the social media group field
    $social_media = get_field('social_media_platforms_links');

    // Check if the group field has data
    if ($social_media):
        foreach ($social_media as $platform => $details):
            if (!empty($details['url'])):
                $title = esc_html($details['title']);
                $url = esc_url($details['url']);
                $svg = isset($social_icons[$title]) ? $social_icons[$title] : '';
                echo '<a href="' . $url . '" target="_blank"><span class="social-icon">' . $svg . '</span></a><br>';
            endif;
        endforeach;
    endif;
    ?>
</div>
                            </a>
                        </article>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p>No bios found.</p>
                <?php endif; ?> 

            </div>

        </section>
    </div>

        <!-- Latest Announcements Section -->
         <div class="latest-announcements-section-wrapper">
        <section class="latest-announcements__section">
            <div class="front-page__header-block">
            <h2 class="front-page__title">Latest Announcements</h2>
             
    </div>
            <div class="latest-announcement-grid">
                <div class="latest-announcements-heading-wrapper">
                    <h4 class="latest-announcements__heading">Check our announcements</h4>
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

<?php
// Get the menu assigned to the "primary" menu location
$menu_name = 'primary'; // Update this to match your menu location
$menu_locations = get_nav_menu_locations();
$menu_id = isset($menu_locations[$menu_name]) ? $menu_locations[$menu_name] : false;

if ($menu_id) {
    // Fetch all menu items for the assigned menu
    $menu_items = wp_get_nav_menu_items($menu_id);

    // Debug output to check the structure of menu items
    // echo '<pre>';
    // print_r($menu_items); // Uncomment to inspect menu items
    // echo '</pre>';

    // Get the current page ID
    $current_page_id = get_the_ID();
    // echo '<p>Current Page ID: ' . $current_page_id . '</p>'; // Display current page ID for debugging

    // Find the menu item corresponding to the current page (Home page in this case)
    $current_page_menu_id = null;
    foreach ($menu_items as $item) {
        // If the item corresponds to the current page, save its menu item ID
        if ((int)$item->object_id === $current_page_id) {
            $current_page_menu_id = $item->ID;
            break;
        }
    }

    // Debugging the menu item ID for current page
    echo '<p>Current Page Menu Item ID: ' . $current_page_menu_id . '</p>';

    if ($current_page_menu_id) {
        // Filter menu items to find children (submenu items) of the current page menu item
        $submenu_items = array_filter($menu_items, function ($item) use ($current_page_menu_id) {
            return (int)$item->menu_item_parent === $current_page_menu_id;
        });

        if (!empty($submenu_items)) {
            echo '<ul class="submenu-items">';
            foreach ($submenu_items as $submenu_item) {
                echo '<li>';
                echo '<a href="' . esc_url($submenu_item->url) . '">' . esc_html($submenu_item->title) . '</a>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No submenu items found for this page.</p>';
        }
    } else {
        echo '<p>No menu item found for the current page.</p>';
    }
} else {
    echo '<p>Menu not found or no menu assigned to this location.</p>';
}
?>


    </main><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>










