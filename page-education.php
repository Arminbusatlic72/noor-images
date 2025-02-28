<?php
/*
Template Name: Home Page
*/
get_header(); // Include the header
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="full-with-slider-container">
        <!-- Slider -->
            <div class="bio-slider-section-slider-wrapper">
            <?php
                $slider_shortcode = get_field('education_section_header_slider');
                if( $slider_shortcode ):
                echo do_shortcode( $slider_shortcode );
                endif;
                ?>
            </div>
        </div>
        <section class="education-page-header-section"> 
            <div class="front-page__header-block">
             <h2 class="front-page__title"><?php the_field('education_page_headline'); ?></h2>
               </div>
             <?php 
            // Display the subtext field if it exists
            $subtext = get_field('education_page_header_subtext');
            if ($subtext) : ?>
                <p class="education-page-subtext gray"><?php echo esc_html($subtext); ?></p>
            <?php endif; ?>

            <?php 
            // Display the content field if it exists
            $content = get_field('education_page_content');
            if ($content) : ?>
                <div class="education-page-content">
                    <?php echo wp_kses_post($content); ?>
                </div>
            <?php endif; ?>

        </section>
        <section class="education-page-thematic-workshops-section">
    <?php
    // Get section title and description
    $workshops_title = get_field('thematic_workshops_section_heading');
    $workshops_description = get_field('thematic_workshops_section_content');

    // Display title
    if ($workshops_title) {
        echo '<div class="front-page__header-block"><h2 class="front-page__title">' . esc_html($workshops_title) . '</h2></div>';
    }

    // Display description
    if ($workshops_description) {
        echo '<div class="workshops-description gray"><p>' . wp_kses_post($workshops_description) . '</p></div>';
    }

    // Thematic workshops items
    $workshop_items = [
        get_field('thematic_workshop_item'),
        get_field('thematic_workshop_item_second'),
        get_field('thematic_workshop_item_third'),
        get_field('thematic_workshop_item_fourth')
    ];

    echo '<div class="workshops-items-grid-wrapper">';
    foreach ($workshop_items as $workshop_item) {
        if ($workshop_item) {
            // Extract fields
            $workshop_tag = $workshop_item['thematic_workshop_item_tag'];
            $workshop_title = $workshop_item['thematic_workshop_item_title'];
            $workshop_description = $workshop_item['thematic_workshop_item_description'];
            $workshop_image = $workshop_item['thematic_workshop_item_image'];
            $workshop_link = $workshop_item['thematic_workshop_item_link'];
            $workshop_time = $workshop_item['thematic_workshop_item_time'];
            $workshop_location = $workshop_item['thematic_workshop_item_location'];

            echo '<article class="workshop-item">';

            // Image with link (if available)
           
            $workshop_image_id = $workshop_image ? $workshop_image['ID'] : null;
            if ($workshop_image_id && $workshop_link) {
                $workshop_link_url = esc_url($workshop_link['url']);
                $workshop_link_target = $workshop_link['target'] ? ' target="' . esc_attr($workshop_link['target']) . '"' : '';
                echo '<a href="' . $workshop_link_url . '"' . $workshop_link_target . ' class="workshop-item-image-link">';
                echo wp_get_attachment_image($workshop_image_id, 'large', false, ['alt' => esc_attr($workshop_title)]);
                echo '</a>';
            } elseif ($workshop_image_id) {
                echo '<div class="workshop-item-image">';
                echo wp_get_attachment_image($workshop_image_id, 'large', false, ['alt' => esc_attr($workshop_title)]);
                echo '</div>';
            } else {
                // Placeholder image
                echo '<div class="workshop-item-image">';
                echo '<img src="' . esc_url(get_template_directory_uri() . '/path/to/placeholder-image.jpg') . '" alt="Placeholder Image">';
                echo '</div>';
            }

            // Display tag
            if ($workshop_tag) {
                echo '<span class="workshop-item-tag">' . esc_html($workshop_tag) . '</span>';
            }

            // Display title
            if ($workshop_title) {
                echo '<h3 class="workshop-item-title">' . esc_html($workshop_title) . '</h3>';
            }

            // Display description
            if ($workshop_description) {
                echo '<p class="workshop-item-description gray">' . esc_html($workshop_description) . '</p>';
            }

            // Display time & location
            if ($workshop_time || $workshop_location) {
                echo '<div class="workshop-item-meta">';
                if ($workshop_time) {
                    echo '<p class="workshop-item-time"><strong>Time:</strong> ' . esc_html($workshop_time) . '</p>';
                }
                if ($workshop_location) {
                    echo '<p class="workshop-item-location"><strong>Location:</strong> ' . esc_html($workshop_location) . '</p>';
                }
                echo '</div>';
            }

            echo '</article>';
        }
    }
    echo '</div>';
    ?>
</section>
<section class="education-page-other-workshops-section">
    <?php
    // Get section heading and content
    $other_workshops_title = get_field('other_workshops_section_heading');
    $other_workshops_description = get_field('other_workshops_section_content');

    // Display the section title
    if ($other_workshops_title) {
        echo '<div class="front-page__header-block"><h2 class="front-page__title">' . esc_html($other_workshops_title) . '</h2></div>';
    }

    // Display the section description
    if ($other_workshops_description) {
        echo '<div class="other-workshops-description"><p>' . wp_kses_post($other_workshops_description) . '</p></div>';
    }

    // Other workshops items
    $other_workshop_items = [
        get_field('other_workshops_item'),
        get_field('other_workshop_item_second')
    ];

    echo '<div class="other-workshops-items-grid-wrapper">';
    foreach ($other_workshop_items as $workshop_item) {
        if ($workshop_item) {
            // Extract fields
            $workshop_tag = $workshop_item['other_workshop_item_tag'] ?? '';
            $workshop_title = $workshop_item['other_workshop_item_title'] ?? '';
            $workshop_description = $workshop_item['other_workshop_item_description'] ?? '';
            $workshop_image = $workshop_item['other_workshop_item_image'] ?? null;
            $workshop_link = $workshop_item['other_workshop_item_link'] ?? null;

            echo '<article class="other-workshop-item">';

            // Check if image exists before trying to get ID
            $workshop_image_id = $workshop_image ? $workshop_image['ID'] : null;

            // Display image with link (if available)
            if ($workshop_image_id && $workshop_link) {
                $workshop_link_url = esc_url($workshop_link['url']);
                $workshop_link_target = $workshop_link['target'] ? ' target="' . esc_attr($workshop_link['target']) . '"' : '';
                echo '<div class="other-workshop-item-image-wrapper"><a href="' . $workshop_link_url . '"' . $workshop_link_target . ' class="other-workshop-item-image-link">';
                echo wp_get_attachment_image($workshop_image_id, 'large', false, ['alt' => esc_attr($workshop_title)]);
                echo '</a></div>';
            } elseif ($workshop_image_id) {
                echo '<div class="other-workshop-item-image">';
                echo wp_get_attachment_image($workshop_image_id, 'large', false, ['alt' => esc_attr($workshop_title)]);
                echo '</div>';
            } else {
                // Placeholder image to prevent errors
                echo '<div class="other-workshop-item-image">';
                echo '<img src="' . esc_url(get_template_directory_uri() . '/path/to/placeholder-image.jpg') . '" alt="Placeholder Image">';
                echo '</div>';
            }

            // Display tag
            if ($workshop_tag) {
                echo '<span class="other-workshop-item-tag">' . esc_html($workshop_tag) . '</span>';
            }

            // Display title
            if ($workshop_title) {
                echo '<h3 class="other-workshop-item-title">' . esc_html($workshop_title) . '</h3>';
            }

            // Display description
            if ($workshop_description) {
                echo '<p class="other-workshop-item-description gray">' . esc_html($workshop_description) . '</p>';
            }

            echo '</article>';
        }
    }
    echo '</div>';
    ?>
</section>

<section class="education-page-fellowships-grants-section">
    <?php
  
    // Get ACF fields for the section heading and content
    $fellowships_and_grants_section_heading = get_field('fellowships_and_grants_section_heading');
    $fellowships_and_grants_section_content = get_field('fellowships_and_grants_section_content');

    // Display the section heading
    if ($fellowships_and_grants_section_heading) {
        echo '<div class="front-page__header-block"><h2 class="front-page__title">' . esc_html($fellowships_and_grants_section_heading) . '</h2></div>';
    }

    // Display the section content
    if ($fellowships_and_grants_section_content) {
        echo '<div class="fellowships-and-grants-section-content"><p>' . wp_kses_post($fellowships_and_grants_section_content) . '</p></div>';
    }

    // Display the grid of fellowships and grants items
    $fellowships_and_grants_items = [
        get_field('fellowships_and_grants_item'),
        get_field('fellowships_and_grants_item_second'),
        get_field('fellowships_and_grants_item_third')
    ];

    echo '<div class="fellowships-and-grants-grid-wrapper">';
    foreach ($fellowships_and_grants_items as $fellowship_grant_item) {
        if ($fellowship_grant_item) {
            // Extract fields from each fellowship/grant item
            $fellowship_grant_item_title = isset($fellowship_grant_item['fellowships_and_grants_item_title']) ? $fellowship_grant_item['fellowships_and_grants_item_title'] : '';
            $fellowship_grant_item_description = isset($fellowship_grant_item['fellowships_and_grants_item_description']) ? $fellowship_grant_item['fellowships_and_grants_item_description'] : '';
            $fellowship_grant_item_link = isset($fellowship_grant_item['fellowships_and_grants_item_link']) ? $fellowship_grant_item['fellowships_and_grants_item_link'] : '';
            $fellowship_grant_item_image = isset($fellowship_grant_item['fellowships_and_grants_image']) ? $fellowship_grant_item['fellowships_and_grants_image'] : '';

            echo '<div class="fellowship-grant-item">';
            
            // Display the image if available
            if ($fellowship_grant_item_image) {
                // If the image is an array (usually returned by ACF), get the URL
                $image_url = isset($fellowship_grant_item_image['url']) ? esc_url($fellowship_grant_item_image['url']) : '';
                $image_alt = isset($fellowship_grant_item_image['alt']) ? esc_attr($fellowship_grant_item_image['alt']) : 'Fellowship Grant Image';
                $image_title = isset($fellowship_grant_item_image['title']) ? esc_html($fellowship_grant_item_image['title']) : '';
                
                if ($image_url) {
                    echo '<div class="fellowship-grant-item-image-wrapper"><img src="' . $image_url . '" alt="' . $image_alt . '" title="' . $image_title . '" class="fellowship-grant-item-image"></div>';
                }
            }

            // Display the title (if available)
            if ($fellowship_grant_item_title) {
                echo '<h3 class="fellowship-grant-item-title">' . esc_html($fellowship_grant_item_title) . '</h3>';
            }

            // Display the description (if available)
            if ($fellowship_grant_item_description) {
                echo '<p class="fellowship-grant-item-description gray">' . esc_html($fellowship_grant_item_description) . '</p>';
            }

            // Display the link (if available)
            if ($fellowship_grant_item_link) {
                $item_link_url = esc_url($fellowship_grant_item_link['url']);
                $item_link_target = $fellowship_grant_item_link['target'] ? ' target="' . esc_attr($fellowship_grant_item_link['target']) . '"' : '';
                echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="fellowship-grant-item-link">Learn More</a>';
            }

            echo '</div>'; // Close individual fellowship/grant item
        }
    }
    echo '</div>'; // Close the grid wrapper

    ?>
</section>

<section class="education-page-visual-media-literacy-section">
    <?php
    // Get ACF fields for the section heading and content
    $visual_media_literacy_section_headline = get_field('visual_&_media_literacy_section_headline');
    $visual_media_literacy_section_content = get_field('visual_&_media_literacy_section_content');

    // Display the section heading
    if ($visual_media_literacy_section_headline) {
        echo '<div class="front-page__header-block"><h2 class="front-page__title">' . esc_html($visual_media_literacy_section_headline) . '</h2></div>';
    }

    // Display the section content
    if ($visual_media_literacy_section_content) {
        echo '<div class="visual-media-literacy-section-content"><p>' . wp_kses_post($visual_media_literacy_section_content) . '</p></div>';
    }

    // Container for the left slider and right subheading/content
    echo '<div class="visual-media-literacy-container">';
    
    // Left side: Slider (visual_media_section_slider) - Display as shortcode
    $visual_media_section_slider = get_field('visual_media_section_slider');
    if ($visual_media_section_slider) {
        echo '<div class="visual-media-section-slider">';
        echo do_shortcode($visual_media_section_slider); // Output the slider shortcode
        echo '</div>'; // Close the slider
    }

    // Right side: Subheading and Subcontent
    echo '<div class="visual-media-section-right">';
    
    // Subheading: visual_media_section_subheading
    $visual_media_section_subheading = get_field('visual_media_section_subheading');
    if ($visual_media_section_subheading) {
        echo '<h3 class="visual-media-section-subheading">' . esc_html($visual_media_section_subheading) . '</h3>';
    }

    // Subcontent: visual_&_media_literacy_section_subcontent
    $visual_media_literacy_section_subcontent = get_field('visual_&_media_literacy_section_subcontent');
    if ($visual_media_literacy_section_subcontent) {
        echo '<div class="visual-media-literacy-section-subcontent"><p>' . wp_kses_post($visual_media_literacy_section_subcontent) . '</p></div>';
    }

    echo '</div>'; // Close the right side container
    echo '</div>'; // Close the main container
    ?>
</section>
<section class="education-page-past-programmes-section">
    <?php
    // Get ACF fields for the section heading and content
    $past_programmes_section_heading = get_field('past_programmes_section_heading');
    $past_programmes_section_content = get_field('past_programmes_section_content');

    // Display the section heading and content
    if ($past_programmes_section_heading) {
        echo '<div class="front-page__header-block"><h2 class="front-page__title">' . esc_html($past_programmes_section_heading) . '</h2></div>';
    }

    if ($past_programmes_section_content) {
        echo '<div class="section-content"><p>' . wp_kses_post($past_programmes_section_content) . '</p></div>';
    }

    // Get the Past Programmes items
    $past_programmes_items = [
        get_field('past_programmes_item'),
        get_field('past_programmes_item_second'),
        get_field('past_programmes_item_third'),
        get_field('past_programmes_item_fourth'),
    ];

    echo '<div class="past-programmes-grid-wrapper">';
    foreach ($past_programmes_items as $past_programmes_item) {
        if ($past_programmes_item) {
            // Extract fields for each item
            $past_programmes_item_tag = isset($past_programmes_item['past_programmes_item_tag']) ? $past_programmes_item['past_programmes_item_tag'] : null;
            $past_programmes_item_title = isset($past_programmes_item['past_programmes_item_title']) ? $past_programmes_item['past_programmes_item_title'] : null;
            $past_programmes_item_description = isset($past_programmes_item['past_programmes_item_description']) ? $past_programmes_item['past_programmes_item_description'] : null;
            $past_programmes_item_image = isset($past_programmes_item['past_programmes_item_image']) ? $past_programmes_item['past_programmes_item_image'] : null;
            $past_programmes_item_link = isset($past_programmes_item['past_programmes_item_link']) ? $past_programmes_item['past_programmes_item_link'] : null;

            echo '<div class="past-programmes-item">';

            // Check if there is an image
            if ($past_programmes_item_image) {
                $past_programmes_item_image_id = isset($past_programmes_item_image['ID']) ? $past_programmes_item_image['ID'] : null;
                $item_link_url = isset($past_programmes_item_link['url']) ? esc_url($past_programmes_item_link['url']) : null;
                $item_link_target = isset($past_programmes_item_link['target']) ? ' target="' . esc_attr($past_programmes_item_link['target']) . '"' : '';

                // Display link and image only if both are available
                if ($item_link_url) {
                    echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="item-link">';
                }

                if ($past_programmes_item_image_id) {
                    echo '<div class="past-programmes-item-image-wrapper">';
                    echo wp_get_attachment_image($past_programmes_item_image_id, 'large', false, ['alt' => esc_attr($past_programmes_item_title)]);
                    echo '</div>';
                } else {
                    echo '<div class="past-programmes-item-image">null</div>';
                }

                if ($item_link_url) {
                    echo '</a>';
                }

                if ($past_programmes_item_title) {
                    echo '<h3 class="past-programmes-item-title">' . esc_html($past_programmes_item_title) . '</h3>';
                }
            } else {
                // If no image, display null
                echo '<div class="past-programmes-item-image">null</div>';
            }

            // Display description
            if ($past_programmes_item_description) {
                echo '<p class="past-programmes-item-description gray">' . esc_html($past_programmes_item_description) . '</p>';
            }

            echo '</div>';
        }
    }
    echo '</div>';
    ?>
</section>


<section class="education-page-support-section">
    <?php
    // Get ACF fields
    $support_title = get_field('support_section_title');
    $support_description = get_field('support_section_description');
    $support_link = get_field('support_section_link');
    

    // Display the title
    if ($support_title) {
        echo '<div class="front-page__header-block"><h2 class="front-page__title">' . esc_html($support_title) . '</h2></div>';
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










    </main>
</div>

<?php

get_footer(); // Include the footer
?>