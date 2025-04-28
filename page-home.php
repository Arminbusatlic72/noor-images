    <?php
    /*
    Template Name: Home Page
    */
    get_header(); // Include the header
    ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <section class="section">
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


            <section class="section">
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
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $image_caption = wp_get_attachment_caption($thumbnail_id);

    echo '<figure class="aspect-3-2">';
    echo '<a href="' . esc_url($post_permalink) . '" class="featured-post-image-link">';
    echo '<img class="img-cover" src="' . esc_url($post_featured_image) . '" alt="' . esc_attr($post_title) . '">';
    echo '</a>';

    // Properly placed figcaption
    if ($image_caption) {
        echo '<figcaption class="featured-post-image-caption">' . esc_html($image_caption) . '</figcaption>';
    }

    echo '</figure>';
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
            echo '<div class="responsive-grid-3col">';
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
                    echo '<div class="aspect-3-2">';
                    echo '<a href="' . esc_url($post_permalink) . '">';
                    echo '<img class="img-cover" src="' . esc_url($post_featured_image) . '" alt="' . esc_attr($post_title) . '">';
                    
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
        // Display the link as a button
         $news_link = get_field('read_all_link'); 
          if ($news_link) {
            $link_url = esc_url($news_link['url']);
            $link_title = esc_html($news_link['title']);
            $link_target = $news_link['target'] ? ' target="' . esc_attr($news_link['target']) . '"' : '';
            echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $link_url . '"' . $link_target . ' class="read-all-link">
                        ' . $link_title . '
                            <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
        ?>
    </div>
    
    </section>

    <section class="section">
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
        
        echo '<div class="content-sidebar-grid">';
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
       
        echo '</div>';

        echo '</div>';


        // Display other production items
        $education_items = [
            get_field('education_item'), 
            get_field('education_item_second'), 
            get_field('education_item_third')
        ];

        echo '<div class="responsive-grid-3col">';
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
                    echo '<div class="aspect-3-2">';
                    if ($education_item_link) {
                        $item_link_url = esc_url($education_item_link['url']);
                        $item_link_target = $education_item_link['target'] ? ' target="' . esc_attr($education_item_link['target']) . '"' : '';
                        echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="education-item-image-link">';
                        echo wp_get_attachment_image($education_item_image_id, 'large', false, ['alt' => esc_attr($education_item_title),'class' => 'img-cover']);
                        echo '</a>';
                    } else {
                        echo wp_get_attachment_image($education_item_image_id, 'large', false, ['alt' => esc_attr($education_item_title)]);
                    }
                    echo '</div>';
                }

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
        
        
        
          // Display the link as a button
          if ($education_link) {
            $link_url = esc_url($education_link['url']);
            $link_title = esc_html($education_link['title']);
            $link_target = $education_link['target'] ? ' target="' . esc_attr($education_link['target']) . '"' : '';
            echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $link_url . '"' . $link_target . ' class="read-all-link">
                        ' . $link_title . '
                            <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
        ?>
        
    </section>

    <section class="section">
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
            echo '<article class="content-sidebar-grid">';

            // Image Handling
            if ($top_item_image && isset($top_item_image['ID'])) {
                $top_item_image_id = $top_item_image['ID'];
                echo '<div class="aspect-3-2">';
                if ($top_item_link) {
                    $top_item_link_url = esc_url($top_item_link['url']);
                    $top_item_link_target = $top_item_link['target'] ? ' target="' . esc_attr($top_item_link['target']) . '"' : '';
                    echo '<a href="' . $top_item_link_url . '"' . $top_item_link_target . ' class="production-item-image-link">';
                    echo wp_get_attachment_image($top_item_image_id, 'large', false, ['alt' => esc_attr($top_item_title),'class' => 'img-cover']);
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

        echo '<div class="responsive-grid-3col">';
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
                    echo '<div class="aspect-3-2">';
                    if ($production_item_link) {
                        $item_link_url = esc_url($production_item_link['url']);
                        $item_link_target = $production_item_link['target'] ? ' target="' . esc_attr($production_item_link['target']) . '"' : '';
                        echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="production-item-image-link">';
                        echo wp_get_attachment_image($production_item_image_id, 'large', false, ['alt' => esc_attr($production_item_title),'class' => 'img-cover']);
                        echo '</a>';
                    } else {
                        echo wp_get_attachment_image($production_item_image_id, 'large', false, ['alt' => esc_attr($production_item_title)]);
                    }
                    echo '</div>';
                }
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
        // Display the link as a button
         $production_link = get_field('production_section_read_all_link'); 
          if ($production_link) {
            $link_url = esc_url($production_link['url']);
            $link_title = esc_html($production_link['title']);
            $link_target = $production_link['target'] ? ' target="' . esc_attr($production_link['target']) . '"' : '';
            echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $link_url . '"' . $link_target . ' class="read-all-link">
                        ' . $link_title . '
                            <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
        ?>
        
    </section>

   



    <section class="section">
        <?php
        // Get the ACF field for the Google Map shortcode
        $community_title = get_field('community_section_title');
        $community_description = get_field('community_section_description');
        $community_link = get_field('community_section_link');
        if ($community_title) {
            echo '<div class="section-header-block"><h2 class="section-title">' . esc_html($community_title) . '</h2></div>';
        }
             
        // Check if the Google Map shortcode is available
        echo '<div class="content-sidebar-grid">';
        
        $community_image = get_field('community_section_image');
        if ($community_image) {
            $image_url = esc_url($community_image['url']);
            $image_alt = $community_image['alt'] ? esc_attr($community_image['alt']) : esc_attr('Community section image');
            $image_caption = get_field('community_section_image_caption');
            echo '<div class="aspect-3-2">';
            echo '<img src="' . $image_url . '" alt="' . $image_alt . '" class="img-cover">';
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
        
            echo '</div>';
        
        echo '</div>'; // Close community-content-container
        echo '</div>'; // Close community-grid-container

        // Display community items
        $community_items = [
            get_field('community_section_item'),
            get_field('community_section_item_second'), 
            get_field('community_section_item_third')
        ];

        echo '<div class="responsive-grid-3col">';
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
                    echo '<div class="aspect-3-2">';
                    if ($community_item_link) {
                        $item_link_url = esc_url($community_item_link['url']);
                        $item_link_target = $community_item_link['target'] ? ' target="' . esc_attr($community_item_link['target']) . '"' : '';
                        echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="community-item-image-link">';
                        echo wp_get_attachment_image($community_item_image_id, 'large', false, ['alt' => esc_attr($community_item_title),'class' => 'img-cover']);
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
        
          // Display the link as a button
         if ($community_link) {
            $link_url = esc_url($community_link['url']);
            $link_title = esc_html($community_link['title']);
            $link_target = $community_link['target'] ? ' target="' . esc_attr($community_link['target']) . '"' : '';
            
            echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $link_url . '"' . $link_target . ' class="read-all-link">
                        ' . $link_title . '
                            <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
        ?>
    </section>

    <section class="section">
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

        echo '<div class="content-sidebar-grid">';

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

            

            echo '</div>'; // Close archive-description-wrapper
        }

        echo '</div>'; // Close archive-grid-container

        // Display archive items
        $archive_items = [
            get_field('archive_item'), 
            get_field('archive_item_second'), 
            get_field('archive_item_third')
        ];

        echo '<div class="responsive-grid-3col">';
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
                    echo '<div class="aspect-3-2">';
                    if ($archive_item_link) {
                        $item_link_url = esc_url($archive_item_link['url']);
                        $item_link_target = $archive_item_link['target'] ? ' target="' . esc_attr($archive_item_link['target']) . '"' : '';
                        echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="archive-item-image-link">';
                        echo wp_get_attachment_image($archive_item_image_id, 'large', false, ['alt' => esc_attr($archive_item_title),'class' => 'img-cover']);
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

    
         // Display the link as a button
        if ($archive_link) {
                $link_url = esc_url($archive_link['url']);
                $link_title = esc_html($archive_link['title']);
                $link_target = $archive_link['target'] ? ' target="' . esc_attr($archive_link['target']) . '"' : '';

            echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $link_url . '"' . $link_target . ' class="read-all-link">
                        ' . $link_title . '
                            <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
        ?>
       
    </section>



    <section class="section">
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

        echo '<div class="responsive-grid-3col">';
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

                    echo '<div class="aspect-3-2"><a href="' . $item_link_url . '"' . $item_link_target . ' class="shop-item-image-link">';
                    echo wp_get_attachment_image($shop_item_image_id, 'large', false, ['alt' => esc_attr($shop_item_title),'class' => 'img-cover']);
                    echo '</a></div>';
                } elseif ($shop_item_image_id) {
                   
                    echo wp_get_attachment_image($shop_item_image_id, 'large', false, ['alt' => esc_attr($shop_item_title),'class' => 'img-cover']);
                   
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

           echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $link_url . '"' . $link_target . ' class="read-all-link">
                        ' . $link_title . '
                            <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
        ?>
    </section>


    <section class="section section--last">
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

            echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $link_url . '"' . $link_target . ' class="read-all-link">
                        ' . $link_title . '
                            <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
        ?>
    </section>


    
    </div>
    </div>
    </div>

        </main><!-- #main -->
    </div><!-- #primary -->

    <?php

    get_footer(); // Include the footer
    ?>