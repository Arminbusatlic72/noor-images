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
                        echo '<h2 class="page-heading">' . esc_html($heading) . '</h2>';
                    }

                    // Display the subheading
                    if ($subheading) {
                        echo '<h3 class="page-subtitle">' . esc_html($subheading) . '</h3>';
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
                echo '<div class="featured-post-image-wrapper"><a href="' . esc_url($post_permalink) . '" class="featured-post-image-link">';
                echo '<img class="featured-post-image" src="' . esc_url($post_featured_image) . '" alt="' . esc_attr($post_title) . '">';

                // Display the specific community label if the post type is "bios"
                if ($post_type === 'bios' && $community_label) {
                    echo '<span class="community-label">' . esc_html($community_label,) . '</span>';
                }
                echo '</a></div>';
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
        $related_posts = get_field('related_post_types'); 

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
                   
                    echo '</a>';
                    echo '</div>';
                }
                 if ($front_labels && !is_wp_error($front_labels)) {
                        $first_label = $front_labels[0];
                        $label_link = get_term_link($first_label, 'front-label'); // Get the term archive link
                        if (!is_wp_error($label_link)) {
                        
                            echo '<a href="' . esc_url($label_link) . '"><span class="tag">' . esc_html($first_label->name) . '</span></a>';
                        
                        }
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
    <div class="read-all-button-wrapper">
        <div class="read-all-button">
            <a href="<?php echo get_post_type_archive_link('news'); ?>">View Our New's</a>
            <div class="icon-wrapper">
                <?php echo get_astra_svg_icon( 'arrow-right' ); ?>
            </div>
        </div>
    </div>
    </section>

    <section class="home-page-education-section">
        <div class="section-header-block">
            <h2 class="section-title">Education</h2>
                
        </div>
        <?php
        // Get ACF fields
        $education_title = get_field('education_section_title');
        $education_description = get_field('education_section_description');
        $education_link = get_field('education_section_link');
        $education_slider_shortcode = get_field('education_section_slider');
        $education_slider_caption = get_field('education_section_slider_caption');
        
        echo '<div class="featured-post-grid">';
        // Display the slider using the shortcode
        if ($education_slider_shortcode) {
            echo '<div class="education-slider-wrapper">';
            echo do_shortcode($education_slider_shortcode); // Render the shortcode
            if ($education_slider_caption) {
                echo '<div class="education-slider-caption">' . esc_html($education_slider_caption) . '</div>';
            }
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

            echo '<div class="archive-button-wrapper"><a href="' . $link_url . '"' . $link_target . ' class="ast-header-button-1 ast-custom-button white">' . $link_title . '</a></div>';
        }
        echo '</div>';

        echo '</div>';


        // Display other production items
        $education_items = [
            get_field('education_item'), 
            get_field('education_item_second'), 
            get_field('education_item_third')
        ];

        echo '<div class="education-items-grid">';
        foreach ($education_items as $education_item) {
            if ($education_item) {
                // Extract fields
                $education_item_title = $education_item['education_item_title'];
                $education_item_description = $education_item['education_item_description'];
                $education_item_image = $education_item['education_item_image'];
                $education_item_link = $education_item['education_item_link'];

                echo '<article class="education-item">';

                // Image Handling
                if ($education_item_image && isset($education_item_image['ID'])) {
                    $education_item_image_id = $education_item_image['ID'];
                    echo '<div class="education-item-image-wrapper">';
                    if ($education_item_link) {
                        $item_link_url = esc_url($education_item_link['url']);
                        $item_link_target = $education_item_link['target'] ? ' target="' . esc_attr($education_item_link['target']) . '"' : '';
                        echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="education-item-image-link">';
                        echo wp_get_attachment_image($education_item_image_id, 'large', false, ['alt' => esc_attr($education_item_title)]);
                        echo '</a>';
                    } else {
                        echo wp_get_attachment_image($education_item_image_id, 'large', false, ['alt' => esc_attr($education_item_title)]);
                    }
                    echo '</div>';
                }
                // echo '<h3 class="top-production-item-title"><a href="' . esc_url($top_item_link_url) . '">'. esc_html($top_item_title) . '</a></h3>';

                // Title
                if ($education_item_title) {
                    echo '<h3 class="education-item-title"><a href=" ' . esc_url($item_link_url) . '">'. esc_html($education_item_title) . '</a></h3>';
                }

                // Description
                if ($education_item_description) {
                    echo '<p class="education-item-description gray subtitle">' . esc_html($education_item_description) . '</p>';
                }

                echo '</article>';
            }
        }
        echo '</div>'; // Close education-items-grid-wrapper
        
        
        ?>
        <div class="read-all-button-wrapper">
        <div class="read-all-button">
            <a href="<?php echo get_post_type_archive_link('news'); ?>">View Education Page</a>
            <div class="icon-wrapper">
                <?php echo get_astra_svg_icon( 'arrow-right' ); ?>
            </div>
        </div>
    </div>
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
            $top_item_image_caption = $top_production_item['production_item_image_caption'];
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
                    if ($top_item_image_caption) {
                    echo '<div class="image-caption">' . esc_html($top_item_image_caption) . '</div>';
                }
                echo '</div>';
               
            }
                    
                } else {
                    echo wp_get_attachment_image($top_item_image_id, 'large', false, ['alt' => esc_attr($top_item_title)]);
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
       
        
        // Check if the Google Map shortcode is available
        echo '<div class="community-grid-container">';
        
        $community_image = get_field('community_section_image');
        if ($community_image) {
            $image_url = esc_url($community_image['url']);
            $image_alt = $community_image['alt'] ? esc_attr($community_image['alt']) : esc_attr('Community section image');
            $image_caption = get_field('community_section_image_caption');
            echo '<div class="community-image-wrapper">';
            echo '<img src="' . $image_url . '" alt="' . $image_alt . '">';
            if ($image_caption) {
        echo '<div class="image-caption">' . esc_html($image_caption) . '</div>';
    }
            echo '</div>';
           
        } else {
            echo '<p class="no-image-message">Community image is not available at the moment.</p>';
        }

        echo '<div class="community-content-container">';
        if ($community_description) {
            echo '<div class="community-description-wrapper">';
            echo '<div class="community-description gray">' . wp_kses_post($community_description) . '</div>';
        }
        
        // Display the link as a button
        if ($community_link) {
            $link_url = esc_url($community_link['url']);
            $link_title = esc_html($community_link['title']);
            $link_target = $community_link['target'] ? ' target="' . esc_attr($community_link['target']) . '"' : '';
            
            echo '<div class="community-btn-wrapper"><a href="' . $link_url . '"' . $link_target . ' class="ast-header-button-1 ast-custom-button white">' . $link_title . '</a></div>';
            echo '</div>';
        }
        echo '</div>'; // Close community-content-container
        echo '</div>'; // Close community-grid-container

        // Display community items
        $community_items = [
            get_field('community_section_item'),
            get_field('community_section_item_second'), 
            get_field('community_section_item_third')
        ];

        echo '<div class="community-items-grid">';
        foreach ($community_items as $community_item) {
            if ($community_item) {
                // Extract fields
                $community_item_title = $community_item['community_item_name'];
                $community_item_description = $community_item['community_item_description'];
                $community_item_image = $community_item['community_item_image'];
                $community_item_link = $community_item['community_item_link'];

                echo '<article class="community-item">';

                // Image Handling
                if ($community_item_image && isset($community_item_image['ID'])) {
                    $community_item_image_id = $community_item_image['ID'];
                    echo '<div class="community-item-image-wrapper">';
                    if ($community_item_link) {
                        $item_link_url = esc_url($community_item_link['url']);
                        $item_link_target = $community_item_link['target'] ? ' target="' . esc_attr($community_item_link['target']) . '"' : '';
                        echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="community-item-image-link">';
                        echo wp_get_attachment_image($community_item_image_id, 'large', false, ['alt' => esc_attr($community_item_title)]);
                        echo '</a>';
                    } else {
                        echo wp_get_attachment_image($community_item_image_id, 'large', false, ['alt' => esc_attr($community_item_title)]);
                    }
                    echo '</div>';
                }

                // Title
                if ($community_item_title) {
                    echo '<h3 class="community-item-title"><a href="' . esc_url($item_link_url) . '">' . esc_html($community_item_title) . '</a></h3>';
                }

                // Description
                if ($community_item_description) {
                    echo '<p class="community-item-description gray subtitle">' . esc_html($community_item_description) . '</p>';
                }

                echo '</article>';
            }
        }
        echo '</div>'; // Close community-items-grid
        ?>
    </section>

    <section class="home-page-archive-section">
        <?php
        // Get ACF fields
        $archive_title = get_field('archive_section_title');
        $archive_description = get_field('archive_section_description');
        $archive_link = get_field('archive_section_link');
        $archive_slider_shortcode = get_field('archive_section_slider');
        $archive_slider_caption = get_field('archive_section_slider_caption');

        // Display the title
        if ($archive_title) {
            echo '<div class="section-header-block"><h2 class="section-title">' . esc_html($archive_title) . '</h2></div>';
        }

        echo '<div class="archive-grid-container">';

        // Display the slider using the shortcode
        if ($archive_slider_shortcode) {
            echo '<div class="archive-slider">';
            echo do_shortcode($archive_slider_shortcode); // Render the shortcode
            if ($archive_slider_caption) {
                echo '<div class="archive-slider-caption">' . esc_html($archive_slider_caption) . '</div>';
            }
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

        // Display archive items
        $archive_items = [
            get_field('archive_item'), 
            get_field('archive_item_second'), 
            get_field('archive_item_third')
        ];

        echo '<div class="archive-items-grid">';
        foreach ($archive_items as $archive_item) {
            if ($archive_item) {
                // Extract fields
                $archive_item_title = $archive_item['archive_item_title'];
                $archive_item_description = $archive_item['archive_item_description'];
                $archive_item_image = $archive_item['archive_item_image'];
                $archive_item_link = $archive_item['archive_item_link'];

                echo '<article class="archive-item">';

                // Image Handling
                if ($archive_item_image && isset($archive_item_image['ID'])) {
                    $archive_item_image_id = $archive_item_image['ID'];
                    echo '<div class="archive-item-image-wrapper">';
                    if ($archive_item_link) {
                        $item_link_url = esc_url($archive_item_link['url']);
                        $item_link_target = $archive_item_link['target'] ? ' target="' . esc_attr($archive_item_link['target']) . '"' : '';
                        echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="archive-item-image-link">';
                        echo wp_get_attachment_image($archive_item_image_id, 'large', false, ['alt' => esc_attr($archive_item_title)]);
                        echo '</a>';
                    } else {
                        echo wp_get_attachment_image($archive_item_image_id, 'large', false, ['alt' => esc_attr($archive_item_title)]);
                    }
                    echo '</div>';
                }

                // Title
                if ($archive_item_title) {
                    echo '<h3 class="archive-item-title"><a href="' . esc_url($item_link_url) . '">'. esc_html($archive_item_title) . '</a></h3>';
                }

                // Description
                if ($archive_item_description) {
                    echo '<p class="archive-item-description gray subtitle">' . esc_html($archive_item_description) . '</p>';
                }

                echo '</article>';
            }
        }
        echo '</div>'; // Close archive-items-grid
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
                    
                // Display tag (if available)
                if ($shop_item_tag) {
                    echo '<span class="tag">' . esc_html($shop_item_tag) . '</span>';
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


     <div class="section-menu-wrapper-transparent">
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
                    'Twitter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg>',
                'Linkedin' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path></svg>',
                'Pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg>',
                'Instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>'
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

        </main><!-- #main -->
    </div><!-- #primary -->

    <?php

    get_footer(); // Include the footer
    ?>