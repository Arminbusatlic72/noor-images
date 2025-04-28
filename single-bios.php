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
        <div class="bio-featured-image-wrapper">
            <?php 
            if ( has_post_thumbnail() ) : 
                $thumbnail_id = get_post_thumbnail_id(); // Get the ID of the featured image
                echo wp_get_attachment_image( $thumbnail_id, 'full' ); // Output the image only

                $caption = wp_get_attachment_caption( $thumbnail_id ); // Get the caption for the image
                if ( $caption ) : 
            ?>
                <figcaption class="bio-image-caption"><?php echo esc_html( $caption ); ?></figcaption>
            <?php 
                endif;
            endif;
            ?>
        </div>
<div class="bio-meta-content-wrapper">
        <!-- Display Title and Subtitle -->
         <div class="bio-heading-wrapper">
        <h2 class="bio-heading"><?php the_field('name_and_surname'); ?></h2>
        <h4 class="bio-subtitle gray"><?php the_field('subtitle'); ?></h4>
        </div>
         <!-- Community Labels -->
       <div class="bio-labels-wrapper">
       <?php
        $community_labels = get_the_terms(get_the_ID(), 'community_label');
        if ($community_labels && !is_wp_error($community_labels)) {
        echo '<div class="bio-community-labels"><ul>';
    
        $label_links = array(); 
        foreach ($community_labels as $label) {
        $label_links[] = '<a class="tag" href="' . esc_url(get_term_link($label)) . '"> ' . esc_html($label->name) . ' </a>';
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
        echo '<div class="bio-country-labels"><span>';

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
                'Twitter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg>',
                'Linkedin' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path></svg>',
                'Pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg>',
                'Instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>'
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
    <h2 class="bio-headline"><?php the_field('headline'); ?></h2>
    
    <p class="bio-content"><?php the_field('content'); ?></p>
    
    
    <?php
         $production_link = get_field('see_all_bios_link'); 
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
    </div>
    </div>
    </section>
    <!-- Related Post Types -->
    <div class="bio-related-section-wrapper">
    <section class="bio-related-section">
        <?php 
        $related_posts_type = get_field('single_bio_relation'); 
        if( $related_posts_type && !empty($related_posts_type) ): ?>
            <div class="bio-relation-wrapper">
                 <div class="section-header-block">
                    <h2 class="bios-section-title"><?php the_field('single_bio_relation_section_title'); ?></h2>
                 </div>
       
                <ul class="bio-related-items-list">
                    <?php foreach( $related_posts_type as $post_type ): 
                        $subtitle = get_field('subtitle', $post_type->ID);?>
                        <li class="bio-related-item">
                            <a href="<?php echo get_permalink( $post_type->ID ); ?>" class="bio-related-item-link">
                                <div class="bio-related-item-thumbnail-wrapper">
                                    <?php echo get_the_post_thumbnail( $post_type->ID, 'full', array( 'class' => 'custom-thumbnail' ) ); ?>
                                  
                                </div>
                                <div class="movie-title">
                                    <h3>
										<?php echo esc_html( get_the_title( $post_type->ID ) ); ?>
									</h3>
                                    <?php if ($subtitle): ?>
                                	<p class="subtitle gray"><?php echo esc_html($subtitle); ?></p>
                            		<?php endif; ?>
                                   
                                    <!-- $post_subtitle = get_field('subtitle', $post->ID);  -->
                                </div>
                            </a>
                        </li>
                       
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </section>
</div>
<?php
// Get the Text Area field value
$links = get_field('press_links');

if ($links) : 
    // Split the text area content into an array of links
    $links_array = array_filter(array_map('trim', explode("\n", $links))); // Clean up each line and remove empties

    if (!empty($links_array)) :
?>
<div class="press-links-section-wrapper">
    <section class="press-links-section">
        <div class="section-header-block">
            <h2 class="bios-section-title">On the press</h2>
        </div>
        <ul class="press-links-list">
            <?php foreach ($links_array as $link) : 
                if (strpos($link, '|') !== false) {
                    list($title, $url) = array_map('trim', explode('|', $link, 2));
                    if (!empty($title) && !empty($url)) :
            ?>
                <li>
                    <a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_html($title); ?></a>
                </li>
            <?php 
                    endif;
                }
            endforeach; 
            ?>
        </ul>
    </section>
</div>
<?php
    endif;
endif;
?>

</div>
                    
<?php 
    endwhile; 
endif;

// Get the footer of the theme
get_footer(); 
?>
