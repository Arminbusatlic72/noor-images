<?php
// Get the header of the theme
get_header(); 

// Start the loop for the story post
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
?>

<div class="bio-container">
    <section class="bio-header-section">
    <div class="bio-content-wrapper">
        <!-- Display Featured Image with Caption -->
        <div class="bio-featured-image-wrapper half-width">
            <?php 
            if ( has_post_thumbnail() ) : 
                $thumbnail_id = get_post_thumbnail_id(); // Get the ID of the featured image
                echo wp_get_attachment_image( $thumbnail_id, 'full' ); // Output the image only

                $caption = wp_get_attachment_caption( $thumbnail_id ); // Get the caption for the image
                if ( $caption ) : 
            ?>
                <figcaption class="story-image-caption"><?php echo esc_html( $caption ); ?></figcaption>
            <?php 
                endif;
            endif;
            ?>
        </div>
<div class="bio-text-wrapper half-width">
        <!-- Display Title and Subtitle -->
        <h2 class="bio-heading"><?php the_field('name_and_surname'); ?></h2>
        <h4 class="bio-subtitle"><?php the_field('subtitle'); ?></h4>
         <!-- Community Labels -->
    
       <?php
        $community_labels = get_the_terms(get_the_ID(), 'community_label');
        if ($community_labels && !is_wp_error($community_labels)) {
        echo '<div class="bio-community-labels"><h4>Community Label tags</h4><ul>';
    
        $label_links = array(); 
        foreach ($community_labels as $label) {
        $label_links[] = '<a href="' . esc_url(get_term_link($label)) . '"> ' . esc_html($label->name) . ' </a>';
    }
    
   
    echo '<li>' . implode(' / ', $label_links) . '</li>';
    
    echo '</ul></div>';
}
?>
 <!-- Country Labels -->
   
    <?php
    $country_labels = get_the_terms(get_the_ID(), 'country');
    $continent_labels = get_the_terms(get_the_ID(), 'continent');

    if ((!empty($country_labels) && !is_wp_error($country_labels)) || (!empty($continent_labels) && !is_wp_error($continent_labels))) {
        echo '<div class="community-labels"><span>';

        // Handle country labels
        if (!empty($country_labels) && !is_wp_error($country_labels)) {
            $country_links = array();
            foreach ($country_labels as $label) {
                $country_links[] = '<a href="' . esc_url(get_term_link($label)) . '">' . esc_html($label->name) . '</a>';
            }
            echo implode(' / ', $country_links);
        }

        // Add a separator if both country and continent labels exist
        if (!empty($country_labels) && !empty($continent_labels)) {
            echo ' / ';
        }

        // Handle continent labels
        if (!empty($continent_labels) && !is_wp_error($continent_labels)) {
            $continent_links = array();
            foreach ($continent_labels as $label) {
                $continent_links[] = '<a href="' . esc_url(get_term_link($label)) . '">' . esc_html($label->name) . '</a>';
            }
            echo implode(' / ', $continent_links);
        }

        echo '</span></div>';
    }
    ?>
 <!-- Personal Website Link -->
  <div class="bio-personal-website-link-wrapper">
    <?php 
    $link = get_field('personal_website_link');
    if( $link ): 
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self';
    ?>
        <a class="bio-personal-website-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
    <?php endif; ?>

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
    
    </div>
    </div>
     </section>



  <section class="bio-short-biography-section">
    <div class="bio-short-biography">
        <p class=""><?php the_field('short_biography'); ?></p>
    </div>
    <div class="bio-issues-of-focus">
        <p>Issues <?php the_field('name_and_surname'); ?> focuses on </p>
         <!-- Country Labels -->
    <div>
        <?php
        $issues_of_focus = get_the_terms(get_the_ID(), 'issues_of_focus');
        if ($issues_of_focus && !is_wp_error($issues_of_focus)) {
            echo '<ul>';
            foreach ($issues_of_focus as $label) {
                echo '<li class="bio-tag"><a href="' . esc_url(get_term_link($label)) . '">' . esc_html($label->name) . '</a></li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
    </div>
    </section>
   <section class="bio-slider-section">
    <div class="bio-slider-section-wrapper">
    <!-- Slider -->
    <div class="bio-slider-section-slider-wrapper">
        <?php
        $slider_shortcode = get_field('slider_shortcode');
        if( $slider_shortcode ):
            echo do_shortcode( $slider_shortcode );
        endif;
        ?>
    </div>
    <div class="bio-slider-section-text-wrapper">
    <h3 class=""><?php the_field('headline'); ?></h3>
    
    <p class=""><?php the_field('content'); ?></p>
    
    <a class="bio-button" href="<?php echo get_post_type_archive_link('bios'); ?>" class="bios-button">See all bios</a>
    </div>
    </div>
     </section>
    <!-- Related Post Types -->
    <div class="bio-related-section-wrapper">
    <section class="bio-related-section">
        <?php 
        $related_posts_type = get_field('related_post_types'); 
        if( $related_posts_type && !empty($related_posts_type) ): ?>
            <div class="bio-relation-wrapper">
                <div class="bio-header-block">
                <h4 class="bio-header-title">Stories & more</h4>
                </div>
                <ul class="bio-related-items-list">
                    <?php foreach( $related_posts_type as $post_type ): ?>
                        <li class="bio-related-item">
                            <a href="<?php echo get_permalink( $post_type->ID ); ?>" class="bio-related-item-link">
                                <div class="bio-related-item-thumbnail">
                                    <?php echo get_the_post_thumbnail( $post_type->ID, 'full', array( 'class' => 'custom-thumbnail' ) ); ?>
                                   <span class="bio-related-items-label">
                                    <?php 
                                    // Get the post type of the current related item
                                    $current_post_type = get_post_type( $post_type->ID );
                                    // Get the singular name of the post type
                                    $post_type_object = get_post_type_object( $current_post_type );
                                    if ( $post_type_object ) {
                                        echo esc_html( $post_type_object->labels->singular_name );
                                    }
                                    ?>
                                </span>
                                </div>
                                <div class="movie-title">
                                    <?php echo esc_html( get_the_title( $post_type->ID ) ); ?>
                                </div>
                            </a>
                        </li>
                       
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </section>
</div>
</div>
                    
<?php 
    endwhile; 
endif;

// Get the footer of the theme
get_footer(); 
?>
