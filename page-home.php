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
                        echo '<h2 class="front-page-heading">' . esc_html($heading) . '</h2>';
                    }

                    // Display the subheading
                    if ($subheading) {
                        echo '<h3 class="front-page-subtitle gray">' . esc_html($subheading) . '</h3>';
                    }

                    // Display the content
                    if ($content) {
                        echo '<div class="home-page-about-section-description">' . wp_kses_post($content) . '</div>';
                    }

                    // Display the link
                    if ($link) {
                        $link_url = esc_url($link['url']); // URL
                        $link_title = esc_html($link['title']); // Link text
                        $link_target = $link['target'] ? ' target="' . esc_attr($link['target']) . '"' : ''; // Link target (e.g., _blank)

                        echo '<a href="' . $link_url . '"' . $link_target . ' class="ast-header-button-1 ast-custom-button white">' . $link_title . '</a>';
                    }
                endwhile;
            endif;
            ?>
            </div>
            </section>


            <section class="home-page-featured-post-section">
                <div class="section-header-block">
                    <h2 class="section-title">What's new</h2>
                <a href="<?php echo get_post_type_archive_link('news'); ?>" class="front-page__view-all-link">View Our New's</a>

                </div>
                

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
            $post_subtitle = get_field('subtitle', $post->ID); // Assuming 'subtitle' is a custom field
            $post_featured_image = get_the_post_thumbnail_url($post, 'large'); // Get featured image URL
            $post_permalink = get_permalink($post); // Get post link
            $post_type = get_field('post_type', $post->ID); // Assuming 'post_type' is a custom field
            $community_label = get_field('community_label', $post->ID); // Assuming 'community_label' is a custom field for "bios"

            // Display the post
            echo '<article class="featured-post-grid">';
            
            if ($post_featured_image) {
                echo '<a href="' . esc_url($post_permalink) . '" class="featured-post-image-wrapper">';
                echo '<img class="post-image" src="' . esc_url($post_featured_image) . '" alt="' . esc_attr($post_title) . '">';

                // Display the specific community label if the post type is "bios"
                if ($post_type === 'bios' && $community_label) {
                    echo '<span class="community-label">' . esc_html($community_label,) . '</span>';
                }
                echo '</a>';
            }
            
            echo '<div class="featured-post-meta-wrapper">';
            
            if ($post_title) {
                echo '<h2 class="featured-post-title"><a href="' . esc_url($post_permalink) . '">' . esc_html($post_title) . '</a></h2>';
            }
            if ($post_subtitle) {
                echo '<p class="featured-post-subtitle subtitle">' . esc_html($post_subtitle) . '</p>';
            }
            
            echo '</div>'; // .featured-post-meta-wrapper
            echo '</article>'; // .featured-post-grid
        endforeach;
        echo '</div>'; // .featured-posts-grid

        // Reset post data
        wp_reset_postdata();
    else :
        echo '<p>No featured posts found.</p>';
    endif;
    ?>

    <div class="related-posts-wrapper">
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

                // Get the 'front-label' terms for the post
                $front_labels = get_the_terms($post->ID, 'front-label');

                // Display the post
                echo '<article class="related-post">';
                if ($post_featured_image) {
                    echo '<div class="related-post-image-wrapper">';
                    echo '<a href="' . esc_url($post_permalink) . '">';
                    echo '<img class="related-post-image" src="' . esc_url($post_featured_image) . '" alt="' . esc_attr($post_title) . '">';
                    
                    // Display the first 'front-label' term if it exists
                    if ($front_labels && !is_wp_error($front_labels)) {
                        $first_label = $front_labels[0];
                        $label_link = get_term_link($first_label, 'front-label'); // Get the term archive link
                        if (!is_wp_error($label_link)) {
                        
                            echo '<a href="' . esc_url($label_link) . '"><span class="front-page-label">' . esc_html($first_label->name) . '</span></a>';
                        
                        }
                    }
                    echo '</a>';
                    echo '</div>';
                }
                if ($post_title) {
                    echo '<h3 class="related-post-title"><a href="' . esc_url($post_permalink) . '">' . esc_html($post_title) . '</a></h3>';
                }
                if ($post_subtitle) {
                    echo '<p class="subtitle">' . esc_html($post_subtitle) . '</p>';
                }
                echo '</article>'; // .related-post
            endforeach;
            echo '</div>'; // .related-posts-grid

            // Reset post data
            wp_reset_postdata();
        else :
            echo '<p>No related posts found.</p>';
        endif;
        ?>
    </div>
    </section>

    <section class="home-page-education-section">
        <div class="section-header-block">
            <h2 class="section-title">Education</h2>
                <a href="<?php echo get_post_type_archive_link('news'); ?>" class="front-page__view-all-link">View Education page</a>
        </div>
        <?php
        // Get ACF fields
        $education_title = get_field('education_section_title');
        $education_description = get_field('education_section_description');
        $education_link = get_field('education_section_link');
        $education_slider_shortcode = get_field('education_section_slider');
        
        echo '<div class="featured-post-grid">';
        // Display the slider using the shortcode
        if ($education_slider_shortcode) {
            echo '<div class="education-slider-wrapper">';
            echo do_shortcode($education_slider_shortcode); // Render the shortcode
            echo '</div>';
        }
        // Display the title
        echo '<div class="education-meta-wrapper">';

        if ($education_title) {
            echo '<h2 class="education-post-title">' . esc_html($education_title) . '</h2>';
        }

        // Display the description
        if ($education_description) {
            echo '<div class="education-description gray">' . wp_kses_post($education_description) . '</div>';
        }
        // Display the link as a button
        if ($education_link) {
            $link_url = esc_url($education_link['url']);
            $link_title = esc_html($education_link['title']);
            $link_target = $education_link['target'] ? ' target="' . esc_attr($education_link['target']) . '"' : '';

            echo '<a href="' . $link_url . '"' . $link_target . ' class="education-link-button">' . $link_title . '</a>';
        }
        echo '</div>'; // .featured-posts-grid
        
    
        echo '</div>'; // .featured-posts-grid
        
        ?>
    </section>

    <section class="home-page-production-section">
        <?php
        // Get ACF fields
        $production_title = get_field('production_section_title');
        $production_description = get_field('production_section_description');

        // Display the title
        if ($production_title) {
            echo '<div class="section-header-block"><h2 class="section-title">' . esc_html($production_title) . '</h2></div>';
        }

        // Display the description
        if ($production_description) {
            echo '<div class="production-description"><p>' . wp_kses_post($production_description) . '</p></div>';
        }

        // Get the top production item
        $top_production_item = get_field('top_production_item');

        if ($top_production_item) {
            $top_item_title = $top_production_item['production_item_title'];
            $top_item_description = $top_production_item['production_item_description'];
            $top_item_image = $top_production_item['production_item_image'];
            $top_item_link = $top_production_item['production_item_link'];

            echo '<div class="top-production-item-grid-wrapper">';
            echo '<article class="top-production-item-grid">';

            // Image Handling
            if ($top_item_image && isset($top_item_image['ID'])) {
                $top_item_image_id = $top_item_image['ID'];
                echo '<div class="top-production-item-image-wrapper">';
                if ($top_item_link) {
                    $top_item_link_url = esc_url($top_item_link['url']);
                    $top_item_link_target = $top_item_link['target'] ? ' target="' . esc_attr($top_item_link['target']) . '"' : '';
                    echo '<a href="' . $top_item_link_url . '"' . $top_item_link_target . ' class="production-item-image-link">';
                    echo wp_get_attachment_image($top_item_image_id, 'large', false, ['alt' => esc_attr($top_item_title)]);
                    echo '</a>';
                } else {
                    echo wp_get_attachment_image($top_item_image_id, 'large', false, ['alt' => esc_attr($top_item_title)]);
                }
                echo '</div>';
            }
            echo '<div class="top-production-item-post-meta-wrapper">';
            
            
            // Title
            if ($top_item_title) {
                echo '<h2 class="top-production-item-title"><a href="' . esc_url($top_item_link_url) . '">'. esc_html($top_item_title) . '</a></h2>';
            }

            // Description
            if ($top_item_description) {
                echo '<p class="top-production-item-description gray subtitle">' . esc_html($top_item_description) . '</p>';
            }
            echo '</div>';
            echo '</article>';
            echo '</div>'; // Close top-production-item-grid
        }

        // Display other production items
        $production_items = [
            get_field('production_item'), 
            get_field('production_item_second'), 
            get_field('production_item_third')
        ];

        echo '<div class="production-items-grid-wrapper">';
        foreach ($production_items as $production_item) {
            if ($production_item) {
                // Extract fields
                $production_item_title = $production_item['production_item_title'];
                $production_item_description = $production_item['production_item_description'];
                $production_item_image = $production_item['production_item_image'];
                $production_item_link = $production_item['production_item_link'];

                echo '<article class="production-item">';

                // Image Handling
                if ($production_item_image && isset($production_item_image['ID'])) {
                    $production_item_image_id = $production_item_image['ID'];
                    echo '<div class="production-item-image-wrapper">';
                    if ($production_item_link) {
                        $item_link_url = esc_url($production_item_link['url']);
                        $item_link_target = $production_item_link['target'] ? ' target="' . esc_attr($production_item_link['target']) . '"' : '';
                        echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="production-item-image-link">';
                        echo wp_get_attachment_image($production_item_image_id, 'large', false, ['alt' => esc_attr($production_item_title)]);
                        echo '</a>';
                    } else {
                        echo wp_get_attachment_image($production_item_image_id, 'large', false, ['alt' => esc_attr($production_item_title)]);
                    }
                    echo '</div>';
                }
                // echo '<h3 class="top-production-item-title"><a href="' . esc_url($top_item_link_url) . '">'. esc_html($top_item_title) . '</a></h3>';

                // Title
                if ($production_item_title) {
                    echo '<h3 class="production-item-title"><a href=" ' . esc_url($item_link_url) . '">'. esc_html($production_item_title) . '</a></h3>';
                }

                // Description
                if ($production_item_description) {
                    echo '<p class="production-item-description gray subtitle">' . esc_html($production_item_description) . '</p>';
                }

                echo '</article>';
            }
        }
        echo '</div>'; // Close production-items-grid-wrapper
        ?>
    </section>

    <div class="section-menu-wrapper">
        <!-- Production Section Menu -->
        <div class="section-menu">
            <?php
            // Get the production section menu group field
            $production_menu = get_field('production_section_menu');

            if ($production_menu) :
                // Join Community Link
                if ($production_menu['join_community_link']) {
                    $join_community_url = esc_url($production_menu['join_community_link']['url']);
                    $join_community_title = esc_html($production_menu['join_community_link']['title']);
                    $join_community_target = $production_menu['join_community_link']['target'] ? ' target="' . esc_attr($production_menu['join_community_link']['target']) . '"' : '';

                    echo '<a href="' . $join_community_url . '"' . $join_community_target . ' class="section-menu-link">' . $join_community_title . '</a>';
                }

                // Subscribe Link
                if ($production_menu['subscribe_link']) {
                    $subscribe_url = esc_url($production_menu['subscribe_link']['url']);
                    $subscribe_title = esc_html($production_menu['subscribe_link']['title']);
                    $subscribe_target = $production_menu['subscribe_link']['target'] ? ' target="' . esc_attr($production_menu['subscribe_link']['target']) . '"' : '';

                    echo '<a href="' . $subscribe_url . '"' . $subscribe_target . ' class="section-menu-link">' . $subscribe_title . '</a>';
                }
            endif;
            ?>
    

        <div class="section-menu-social-media-wrapper">
        <span>Follow us</span>
        <div class="section-menu-social-media">
        
        <?php
        $social_icons = array(
                'Facebook' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>',
                'Twitter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.4 151.7c0 2.4-.1 4.8-.4 7.2-8.6 37.1-28.5 68.5-54.2 91.4 1.3 29.9-4.1 59.7-14.8 85.5-9.7 25.7-24.7 49.5-44.5 70.1-19.7 20.6-43.5 37-69.6 50.2-26.1 13.3-54.4 24.1-83.5 33.2-29.1 9.1-58.3 17.2-88.4 24.3-15.3 3.5-30.8 6.7-46.4 9.5 8.1-29.9 3.5-63.7-13.2-90.4 17.5-4.4 34.2-9.8 49.5-16.2 11.5-3.6 22.8-7.6 33.8-11.7-21.3-16.1-35.8-41.5-39.4-69.2 7.9 4.7 16.7 7.3 25.8 8.3-20.9-14-33.4-39-33.4-66.7 0-14.8 3.9-28.7 10.9-40.9 37.4 45.9 93 76.2 155.5 79.6-1.3-5.9-2-12-2-18.1 0-43.6 35.3-78.6 78.8-78.6 22.7 0 43.3 9.4 57.8 24.7 18.1-3.5 34.6-10.1 49.8-19.3-6 18.5-18.6 34.1-35.2 44.2 16.3-1.9 32.4-6.2 47.1-12.6-11.7 16.6-26.4 31.2-43.2 42.4z"></path></svg>',
                'Linkedin' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path></svg>',
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
    </div>
    </div>
    </div>
    <section class="home-page-community-section">
        <?php
        // Get the ACF field for the Google Map shortcode
        $google_map_shortcode = get_field('google_map_short_code'); // ACF field for the Google Map shortcode
        $community_title = get_field('community_section_title');
        $community_description = get_field('community_section_description');
        $community_link = get_field('community_section_link');
        if ($community_title) {
            echo '<div class="section-header-block"><h2 class="section-title">' . esc_html($community_title) . '</h2></div>';
        }
        if ($community_description) {
            echo '<div class="community-description gray">' . wp_kses_post($community_description) . '</div>';
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

    <section class="home-page-archive-section">
        <?php
        // Get ACF fields
        $archive_title = get_field('archive_section_title');
        $archive_description = get_field('archive_section_description');
        $archive_link = get_field('archive_section_link');
        $archive_slider_shortcode = get_field('archive_section_slider');

        // Display the title
        if ($archive_title) {
            echo '<div class="section-header-block"><h2 class="section-title">' . esc_html($archive_title) . '</h2></div>';
        }

        echo '<div class="archive-grid-container">';

        // Display the slider using the shortcode
        if ($archive_slider_shortcode) {
            echo '<div class="archive-slider">';
            echo do_shortcode($archive_slider_shortcode); // Render the shortcode
            echo '</div>';
        }

        // Wrap the description and link in a single div
        if ($archive_description || $archive_link) {
            echo '<div class="archive-description-wrapper">';

            // Display the description
            if ($archive_description) {
                echo '<div class="archive-description">' . wp_kses_post($archive_description) . '</div>';
            }

            // Display the link as a button
            if ($archive_link) {
                $link_url = esc_url($archive_link['url']);
                $link_title = esc_html($archive_link['title']);
                $link_target = $archive_link['target'] ? ' target="' . esc_attr($archive_link['target']) . '"' : '';

                echo '<div class="archive-button-wrapper"><a href="' . $link_url . '"' . $link_target . ' class="ast-header-button-1 ast-custom-button white">' . $link_title . '</a></div>';
            }

            echo '</div>'; // Close archive-description-wrapper
        }

        echo '</div>'; // Close archive-grid-container
        ?>
    </section>



    <section class="home-page-shop-section">
        <?php
        // Get ACF fields
        $shop_title = get_field('shop_section_title');
        $shop_link = get_field('shop_link');

        // Display the title
        if ($shop_title) {
            echo '<div class="section-header-block"><h2 class="section-title">' . esc_html($shop_title) . '</h2></div>';
        }

        // Display the shop items
        $shop_items = [
            get_field('shop_item'), 
            get_field('shop_item_second'), 
            get_field('shop_item_third')
        ];

        echo '<div class="shop-items-grid-wrapper">';
        foreach ($shop_items as $shop_item) {
            if ($shop_item) {
                // Extract fields from each shop item group
                $shop_item_tag = $shop_item['shop_item_tag'];
                $shop_item_title = $shop_item['shop_item_title'];
                $shop_item_description = $shop_item['shop_item_description'];
                $shop_item_image = $shop_item['shop_item_image'];
                $shop_item_link = $shop_item['shop_item_link'];

                echo '<article class="shop-item">';
                
                // Display tag (if available)
                if ($shop_item_tag) {
                    echo '<span class="front-page-label">' . esc_html($shop_item_tag) . '</span>';
                }

                // Extract image ID
                $shop_item_image_id = $shop_item_image['ID']; // Ensure this is the correct key

                

                // Display image wrapped in a link (if available)
                if ($shop_item_image_id && $shop_item_link) {
                    $item_link_url = esc_url($shop_item_link['url']);
                    $item_link_target = $shop_item_link['target'] ? ' target="' . esc_attr($shop_item_link['target']) . '"' : '';

                    echo '<div class="shop-item-image-wrapper"><a href="' . $item_link_url . '"' . $item_link_target . ' class="shop-item-image-link">';
                    echo wp_get_attachment_image($shop_item_image_id, 'large', false, ['alt' => esc_attr($shop_item_title)]);
                    echo '</a></div>';
                } elseif ($shop_item_image_id) {
                    echo '<div class="shop-item-image">';
                    echo wp_get_attachment_image($shop_item_image_id, 'large', false, ['alt' => esc_attr($shop_item_title)]);
                    echo '</div>';
                } else {
                    // Fallback for missing image
                    echo '<div class="shop-item-image">';
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/path/to/placeholder-image.jpg') . '" alt="Placeholder Image">';
                    echo '</div>';
                }
                    

                // Display title (if available)
                if ($shop_item_title) {
                    echo '<h3 class="shop-item-title"><a href="' . esc_url($item_link_url) . '">'. esc_html($shop_item_title) . '</a></h3>';
                }

                // Display description (if available)
                if ($shop_item_description) {
                    echo '<p class="shop-item-description gray subtitle">' . esc_html($shop_item_description) . '</p>';
                }

                // Display link as a button (if available)
                if ($shop_item_link) {
                    $item_link_url = esc_url($shop_item_link['url']);
                    $item_link_title = esc_html($shop_item_link['title']);
                    $item_link_target = $shop_item_link['target'] ? ' target="' . esc_attr($shop_item_link['target']) . '"' : '';

                    echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="shop-item-button">' . $item_link_title . '</a>';
                }

                echo '</article>';
            }
        }
        echo '</div>';

        // Display the shop link as a button
        if ($shop_link) {
            $link_url = esc_url($shop_link['url']);
            $link_title = esc_html($shop_link['title']);
            $link_target = $shop_link['target'] ? ' target="' . esc_attr($shop_link['target']) . '"' : '';

            echo '<div class="shop-btn-wrapper"><a href="' . $link_url . '"' . $link_target . ' class="ast-header-button-1 ast-custom-button white">' . $link_title . '</a></div>';
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
            echo '<div class="section-header-block"><h2 class="section-title">' . esc_html($support_title) . '</h2></div>';
        }

        // Display the description
        if ($support_description) {
            echo '<div class="support-description gray">' . wp_kses_post($support_description) . '</div>';
        }

        
        // Display the link as a button
        if ($support_link) {
            $link_url = esc_url($support_link['url']);
            $link_title = esc_html($support_link['title']);
            $link_target = $support_link['target'] ? ' target="' . esc_attr($support_link['target']) . '"' : '';

            echo '<div class="support-section-btn-wrapper"><a href="' . $link_url . '"' . $link_target . ' class="ast-header-button-1 ast-custom-button white support-link-button">' . $link_title . '</a></div>';
        }
        ?>
    </section>

        </main><!-- #main -->
    </div><!-- #primary -->

    <?php

    get_footer(); // Include the footer
    ?>