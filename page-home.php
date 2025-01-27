<?php
/*
Template Name: Home Page
*/
get_header(); // Include the header
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <section class="home-page-about-section">
            <div class="home-page-about-section-container">
            
        <?php
        // Check if the page is being displayed
        if (have_posts()) :
            while (have_posts()) : the_post();
                // Get ACF fields
                $heading = get_field('title'); // Text field
                $subheading = get_field('subtitle'); // Text field
                $content = get_field('description'); // WYSIWYG or text area field
                $link = get_field('find_out_more'); // Link field

                // Display the heading
                if ($heading) {
                    echo '<h2>' . esc_html($heading) . '</h2>';
                }

                // Display the subheading
                if ($subheading) {
                    echo '<h3>' . esc_html($subheading) . '</h3>';
                }

                // Display the content
                if ($content) {
                    echo '<div class="description">' . wp_kses_post($content) . '</div>';
                }

                // Display the link
                if ($link) {
                    $link_url = esc_url($link['url']); // URL
                    $link_title = esc_html($link['title']); // Link text
                    $link_target = $link['target'] ? ' target="' . esc_attr($link['target']) . '"' : ''; // Link target (e.g., _blank)

                    echo '<a href="' . $link_url . '"' . $link_target . ' class="find-out-more-link">' . $link_title . '</a>';
                }
            endwhile;
        endif;
        ?>
        </div>
        </section>


        <section class="home-page-featured-posts-section">
    <?php
    // Get the relationship field
    $featured_posts = get_field('featured_post_type');

    if ($featured_posts) :
        echo '<div class="featured-posts-grid">';
        foreach ($featured_posts as $post) :
            // Setup post data
            setup_postdata($post);

            // Get post data
            $post_title = get_the_title($post);
            $post_subtitle = get_field('subtitle', $post->ID); // Assuming 'subtitle' is a custom field in the related post
            $post_featured_image = get_the_post_thumbnail_url($post, 'large'); // Get featured image URL
            $post_permalink = get_permalink($post); // Get post link

            // Display the post
            echo '<div class="featured-post">';
            if ($post_featured_image) {
                echo '<a href="' . esc_url($post_permalink) . '">';
                echo '<img src="' . esc_url($post_featured_image) . '" alt="' . esc_attr($post_title) . '">';
                echo '</a>';
            }
            if ($post_title) {
                echo '<h3><a href="' . esc_url($post_permalink) . '">' . esc_html($post_title) . '</a></h3>';
            }
            if ($post_subtitle) {
                echo '<p>' . esc_html($post_subtitle) . '</p>';
            }
            echo '</div>'; // .featured-post
        endforeach;
        echo '</div>'; // .featured-posts-grid

        // Reset post data
        wp_reset_postdata();
    else :
        echo '<p>No featured posts found.</p>';
    endif;
    ?>
</section>


<section class="home-page-related-posts-section">
    <?php
    // Get the relationship field
    $related_posts = get_field('related_post_types'); // Replace 'related_post_types' with your ACF field name

    if ($related_posts) :
        echo '<div class="related-posts-grid">';
        foreach ($related_posts as $post) :
            // Setup post data
            setup_postdata($post);

            // Get post data
            $post_title = get_the_title($post);
            $post_subtitle = get_field('subtitle', $post->ID); // Assuming 'subtitle' is a custom field in the related post
            $post_featured_image = get_the_post_thumbnail_url($post, 'large'); // Get featured image URL
            $post_permalink = get_permalink($post); // Get post link

            // Display the post
            echo '<div class="related-post">';
            if ($post_featured_image) {
                echo '<a href="' . esc_url($post_permalink) . '">';
                echo '<img src="' . esc_url($post_featured_image) . '" alt="' . esc_attr($post_title) . '">';
                echo '</a>';
            }
            if ($post_title) {
                echo '<h3><a href="' . esc_url($post_permalink) . '">' . esc_html($post_title) . '</a></h3>';
            }
            if ($post_subtitle) {
                echo '<p>' . esc_html($post_subtitle) . '</p>';
            }
            echo '</div>'; // .related-post
        endforeach;
        echo '</div>'; // .related-posts-grid

        // Reset post data
        wp_reset_postdata();
    else :
        echo '<p>No related posts found.</p>';
    endif;
    ?>
</section>

<section class="home-page-education-section">
    <?php
    // Get ACF fields
    $education_title = get_field('education_section_title');
    $education_description = get_field('education_section_description');
    $education_link = get_field('education_section_link');
    $education_slider_shortcode = get_field('education_section_slider');

    // Display the title
    if ($education_title) {
        echo '<h2 class="education-title">' . esc_html($education_title) . '</h2>';
    }

    // Display the description
    if ($education_description) {
        echo '<div class="education-description">' . wp_kses_post($education_description) . '</div>';
    }

    // Display the slider using the shortcode
    if ($education_slider_shortcode) {
        echo '<div class="education-slider">';
        echo do_shortcode($education_slider_shortcode); // Render the shortcode
        echo '</div>';
    }
    
       
    

    // Display the link as a button
    if ($education_link) {
        $link_url = esc_url($education_link['url']);
        $link_title = esc_html($education_link['title']);
        $link_target = $education_link['target'] ? ' target="' . esc_attr($education_link['target']) . '"' : '';

        echo '<a href="' . $link_url . '"' . $link_target . ' class="education-link-button">' . $link_title . '</a>';
    }
    ?>
</section>

   <section class="home-page-production-section">
    <?php
    // Get ACF fields
    $production_title = get_field('production_section_title');
    $production_description = get_field('production_section_description');

    // Display the title
    if ($production_title) {
        echo '<h2 class="production-title">' . esc_html($production_title) . '</h2>';
    }

    // Display the description
    if ($production_description) {
        echo '<div class="production-description">' . wp_kses_post($production_description) . '</div>';
    }
    ?>

    <!-- Production Section Menu -->
    <div class="production-section-menu">
        <?php
        // Get the production section menu group field
        $production_menu = get_field('production_section_menu');

        if ($production_menu) :
            // Join Community Link
            if ($production_menu['join_community_link']) {
                $join_community_url = esc_url($production_menu['join_community_link']['url']);
                $join_community_title = esc_html($production_menu['join_community_link']['title']);
                $join_community_target = $production_menu['join_community_link']['target'] ? ' target="' . esc_attr($production_menu['join_community_link']['target']) . '"' : '';

                echo '<a href="' . $join_community_url . '"' . $join_community_target . ' class="join-community-link">' . $join_community_title . '</a>';
            }

            // Subscribe Link
            if ($production_menu['subscribe_link']) {
                $subscribe_url = esc_url($production_menu['subscribe_link']['url']);
                $subscribe_title = esc_html($production_menu['subscribe_link']['title']);
                $subscribe_target = $production_menu['subscribe_link']['target'] ? ' target="' . esc_attr($production_menu['subscribe_link']['target']) . '"' : '';

                echo '<a href="' . $subscribe_url . '"' . $subscribe_target . ' class="subscribe-link">' . $subscribe_title . '</a>';
            }
        endif;
        ?>
    </div>

    <div class="bio-social-media">
    <?php
    $social_icons = array(
        'Facebook' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>',
        'Twitter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.4 151.7c0 2.4-.1 4.8-.4 7.2-8.6 37.1-28.5 68.5-54.2 91.4 1.3 29.9-4.1 59.7-14.8 85.5-9.7 25.7-24.7 49.5-44.5 70.1-19.7 20.6-43.5 37-69.6 50.2-26.1 13.3-54.4 24.1-83.5 33.2-29.1 9.1-58.3 17.2-88.4 24.3-15.3 3.5-30.8 6.7-46.4 9.5 8.1-29.9 3.5-63.7-13.2-90.4 17.5-4.4 34.2-9.8 49.5-16.2 11.5-3.6 22.8-7.6 33.8-11.7-21.3-16.1-35.8-41.5-39.4-69.2 7.9 4.7 16.7 7.3 25.8 8.3-20.9-14-33.4-39-33.4-66.7 0-14.8 3.9-28.7 10.9-40.9 37.4 45.9 93 76.2 155.5 79.6-1.3-5.9-2-12-2-18.1 0-43.6 35.3-78.6 78.8-78.6 22.7 0 43.3 9.4 57.8 24.7 18.1-3.5 34.6-10.1 49.8-19.3-6 18.5-18.6 34.1-35.2 44.2 16.3-1.9 32.4-6.2 47.1-12.6-11.7 16.6-26.4 31.2-43.2 42.4z"></path></svg>', 
        'Instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 202.66A53.34 53.34 0 1 0 277.34 256 53.38 53.38 0 0 0 224 202.66zm124.71-41a53.46 53.46 0 1 1 53.46-53.46A53.52 53.52 0 0 1 348.71 161.66zm-71.42 214.63a140.88 140.88 0 1 1 140.88-140.88A140.9 140.9 0 0 1 277.29 376.29z"></path></svg>',
        'Pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg>'
    );

    // Get the social media group field
    $social_media = get_field('production_section_social_media_menu');

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
</section>

<section class="home-page-education-section">
    <?php
    // Get ACF fields
    $archive_title = get_field('archive_section_title');
    $archive_description = get_field('archive_section_description');
    $archive_link = get_field('archive_section_link');
    $archive_slider_shortcode = get_field('archive_section_slider');

    // Display the title
    if ($archive_title) {
        echo '<h2 class="archive-title">' . esc_html($archive_title) . '</h2>';
    }

    // Display the description
    if ($archive_description) {
        echo '<div class="archive-description">' . wp_kses_post($archive_description) . '</div>';
    }

    // Display the slider using the shortcode
    if ($archive_slider_shortcode) {
        echo '<div class="archive-slider">';
        echo do_shortcode($archive_slider_shortcode); // Render the shortcode
        echo '</div>';
    }
    
       
    

    // Display the link as a button
    if ($archive_link) {
        $link_url = esc_url($archive_link['url']);
        $link_title = esc_html($archive_link['title']);
        $link_target = $archive_link['target'] ? ' target="' . esc_attr($archive_link['target']) . '"' : '';

        echo '<a href="' . $link_url . '"' . $link_target . ' class="archive-link-button">' . $link_title . '</a>';
    }
    ?>
</section>
<section class="home-page-community-section">
    <?php
    // Get the ACF field for the Google Map shortcode
    $google_map_shortcode = get_field('google_map_short_code'); // ACF field for the Google Map shortcode
    $community_title = get_field('community_section_title');
    $community_description = get_field('community_section_description');
    $community_link = get_field('community_section_link');
    if ($community_title) {
        echo '<h2 class="community-title">' . esc_html($community_title) . '</h2>';
    }
    if ($community_description) {
        echo '<div class="community-description">' . wp_kses_post($community_description) . '</div>';
    }
    // Display the link as a button
    if ($community_link) {
        $link_url = esc_url($community_link['url']);
        $link_title = esc_html($community_link['title']);
        $link_target = $community_link['target'] ? ' target="' . esc_attr($community_link['target']) . '"' : '';

        echo '<a href="' . $link_url . '"' . $link_target . ' class="community-link-button">' . $link_title . '</a>';
    }
    // Check if the Google Map shortcode is available
    if ($google_map_shortcode) {
        echo '<div class="google-map-container">';
        echo do_shortcode($google_map_shortcode); // Render the Google Map shortcode
        echo '</div>';
    } else {
        echo '<p class="no-map-message">Google Map is not available at the moment.</p>';
    }
    ?>
</section>


<section class="home-page-shop-section">
    <?php
    // Get ACF fields
    $shop_title = get_field('shop_section_title');
    $shop_link = get_field('shop_link');

    // Display the title
    if ($shop_title) {
        echo '<h2 class="shop-title">' . esc_html($shop_title) . '</h2>';
    }

    // Display the shop items
    $shop_items = [
        get_field('shop_item'), 
        get_field('shop_item_second'), 
        get_field('shop_item_third')
    ];

    echo '<div class="shop-items-wrapper">';
    foreach ($shop_items as $shop_item) {
        if ($shop_item) {
            // Extract fields from each shop item group
            $shop_item_tag = $shop_item['shop_item_tag'];
            $shop_item_title = $shop_item['shop_item_title'];
            $shop_item_description = $shop_item['shop_item_description'];
            $shop_item_image = $shop_item['shop_item_image'];
            $shop_item_link = $shop_item['shop_item_link'];

            echo '<div class="shop-item">';
            
            // Display tag (if available)
            if ($shop_item_tag) {
                echo '<span class="shop-item-tag">' . esc_html($shop_item_tag) . '</span>';
            }

            // Extract image ID
            $shop_item_image_id = $shop_item_image['ID']; // Ensure this is the correct key

            // Debug: Check image data
            var_dump($shop_item_image_id);

            // Display image wrapped in a link (if available)
            if ($shop_item_image_id && $shop_item_link) {
                $item_link_url = esc_url($shop_item_link['url']);
                $item_link_target = $shop_item_link['target'] ? ' target="' . esc_attr($shop_item_link['target']) . '"' : '';

                echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="shop-item-image-link">';
                echo wp_get_attachment_image($shop_item_image_id, 'medium', false, ['alt' => esc_attr($shop_item_title)]);
                echo '</a>';
            } elseif ($shop_item_image_id) {
                echo '<div class="shop-item-image">';
                echo wp_get_attachment_image($shop_item_image_id, 'medium', false, ['alt' => esc_attr($shop_item_title)]);
                echo '</div>';
            } else {
                // Fallback for missing image
                echo '<div class="shop-item-image">';
                echo '<img src="' . esc_url(get_template_directory_uri() . '/path/to/placeholder-image.jpg') . '" alt="Placeholder Image">';
                echo '</div>';
            }

            // Display title (if available)
            if ($shop_item_title) {
                echo '<h3 class="shop-item-title">' . esc_html($shop_item_title) . '</h3>';
            }

            // Display description (if available)
            if ($shop_item_description) {
                echo '<p class="shop-item-description">' . esc_html($shop_item_description) . '</p>';
            }

            // Display link as a button (if available)
            if ($shop_item_link) {
                $item_link_url = esc_url($shop_item_link['url']);
                $item_link_title = esc_html($shop_item_link['title']);
                $item_link_target = $shop_item_link['target'] ? ' target="' . esc_attr($shop_item_link['target']) . '"' : '';

                echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="shop-item-button">' . $item_link_title . '</a>';
            }

            echo '</div>';
        }
    }
    echo '</div>';

    // Display the shop link as a button
    if ($shop_link) {
        $link_url = esc_url($shop_link['url']);
        $link_title = esc_html($shop_link['title']);
        $link_target = $shop_link['target'] ? ' target="' . esc_attr($shop_link['target']) . '"' : '';

        echo '<a href="' . $link_url . '"' . $link_target . ' class="shop-link-button">' . $link_title . '</a>';
    }
    ?>
</section>


<section class="home-page-support-section">
    <?php
    // Get ACF fields
    $support_title = get_field('support_section_title');
    $support_description = get_field('support_section_description');
    $support_link = get_field('support_section_link');
    

    // Display the title
    if ($support_title) {
        echo '<h2 class="support-title">' . esc_html($support_title) . '</h2>';
    }

    // Display the description
    if ($support_description) {
        echo '<div class="support-description">' . wp_kses_post($support_description) . '</div>';
    }

    
    // Display the link as a button
    if ($support_link) {
        $link_url = esc_url($support_link['url']);
        $link_title = esc_html($support_link['title']);
        $link_target = $support_link['target'] ? ' target="' . esc_attr($support_link['target']) . '"' : '';

        echo '<a href="' . $link_url . '"' . $link_target . ' class="support-link-button">' . $link_title . '</a>';
    }
    ?>
</section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php

get_footer(); // Include the footer
?>