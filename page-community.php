<?php
/**
 * Template Name: Community Page
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>
    <?php get_sidebar(); ?>
<?php endif ?>

<main id="primary" <?php astra_primary_class(); ?>>

    <?php
    // Display the Google Map if shortcode exists
    $map_shortcode = get_field('google_map_short_code');
    if ($map_shortcode) {
        echo '<div class="community-map">';
        echo do_shortcode($map_shortcode);
        echo '</div>';
    }
    ?>
    <div class="community-page-wrapper">
       
        <?php
        // Get ACF fields
        $community_title = get_field('community_page_title');
        $community_subtitle = get_field('community_page_subtitle'); 
        $community_description = get_field('community_page_description');
        echo '<header class="community-page-top-content-section">';
        echo '<div class="community-page-content-container">';
        
        // Display the title
        if ($community_title) {
            echo '<h1 class="page-heading">' . esc_html($community_title) . '</h1>';
        }

        // Display the subtitle
        if ($community_subtitle) {
            echo '<h2 class="page-subtitle">' . esc_html($community_subtitle) . '</h2>';
        }

        // Display the description
        if ($community_description) {
            echo '<div class="community-page-description">' . wp_kses_post($community_description) . '</div>';
        }

        echo '</div>'; 
        echo '</header>'; // .community-page-content
        // .community-page-content
        ?>
        <?php
// Get ACF fields
$join_community_hero_image = get_field('join_community_hero_image');
$join_community_section_title = get_field('join_community_section_title');
$join_community_section_content = get_field('join_community_section_content');

echo '<section class="join-community-section section">';


// Display hero image if available
if ($join_community_hero_image) {
    $image_url = esc_url($join_community_hero_image['url']);
    $image_alt = esc_attr($join_community_hero_image['alt']);
    echo '<div class="join-community-hero">';
    echo '<img src="' . $image_url . '" alt="' . $image_alt . '" class="img-cover">';
    echo '</div>';
}
echo '<div class="join-community-container">';
// Display the section title
if ($join_community_section_title) {
    
    echo '<h2 class="section-title">' . esc_html($join_community_section_title) . '</h2>';
   
}

// Display the section content
if ($join_community_section_content) {
    echo '<div class="join-community-content">' . wp_kses_post($join_community_section_content) . '</div>';
}

echo '</div>'; 
echo '</section>'; // .join-community-section
?>
<?php
// Get ACF fields
$subscribe_hero_image = get_field('subscribe_hero_image');
$subscribe_section_title = get_field('subscribe_section_title');
$subscribe_section_subtitle = get_field('subscribe_section_subtitle');
$subscribe_section_content = get_field('subscribe_section_content');

$subscribe_section_item = get_field('subscribe_section_item');
$subscribe_section_item_second = get_field('subscribe_section_item_second');
$subscribe_section_button = get_field('subscribe_section_button'); // Get button field

echo '<section class="subscribe-section section">';


// Display hero image if available
if ($subscribe_hero_image) {
    $image_url = esc_url($subscribe_hero_image['url']);
    $image_alt = esc_attr($subscribe_hero_image['alt']);
    echo '<div class="subscribe-hero">';
    echo '<img src="' . $image_url . '" alt="' . $image_alt . '" class="img-cover">';
    echo '</div>';
}
echo '<div class="subscribe-container">';
// Display the section title
if ($subscribe_section_title) {
  
    echo '<h2 class="section-title">' . esc_html($subscribe_section_title) . '</h2>';

}

// Display the section subtitle
if ($subscribe_section_subtitle) {
    echo '<h3 class="subscribe-subtitle gray">' . esc_html($subscribe_section_subtitle) . '</h3>';
}

// Display the section content
if ($subscribe_section_content) {
    echo '<div class="subscribe-content">' . wp_kses_post($subscribe_section_content) . '</div>';
}

// Wrapper for Subscribe Items
echo '<div class="subscribe-items-wrapper">';

// Array of items to loop through
$subscribe_items = [$subscribe_section_item, $subscribe_section_item_second];

foreach ($subscribe_items as $subscribe_item) {
    if ($subscribe_item) {
        $subscribe_item_image = isset($subscribe_item['subscribe_item_image']) ? $subscribe_item['subscribe_item_image'] : null;
        $subscribe_item_link = isset($subscribe_item['subscribe_item_link']) ? $subscribe_item['subscribe_item_link'] : null;
        $subscribe_item_tag = isset($subscribe_item['subscribe_item_tag']) ? $subscribe_item['subscribe_item_tag'] : null;
        $subscribe_item_title = isset($subscribe_item['subscribe_item_title']) ? $subscribe_item['subscribe_item_title'] : null;
        $subscribe_item_description = isset($subscribe_item['subscribe_item_description']) ? $subscribe_item['subscribe_item_description'] : null;

        echo '<article class="subscribe-item">';

        // Image wrapped in link
        if ($subscribe_item_image && $subscribe_item_link) {
            $item_link_url = isset($subscribe_item_link['url']) ? esc_url($subscribe_item_link['url']) : '';
            $item_link_target = isset($subscribe_item_link['target']) ? ' target="' . esc_attr($subscribe_item_link['target']) . '"' : '';
            $image_url = esc_url($subscribe_item_image['url']);
            $image_alt = esc_attr($subscribe_item_image['alt']);

            echo '<div class="aspect-3-2">';
            echo '<a href="' . $item_link_url . '"' . $item_link_target . ' class="subscribe-item-link">';
            echo '<img src="' . $image_url . '" alt="' . $image_alt . '" class="img-cover">';
            echo '</a>';
            echo '</div>';
        }

        // Tag
        if ($subscribe_item_tag) {
            echo '<span class="subscribe-item-tag tag">' . esc_html($subscribe_item_tag) . '</span>';
        }

        // Title
        if ($subscribe_item_title) {
            echo '<h3 class="subscribe-item-title">' . esc_html($subscribe_item_title) . '</h3>';
        }

        // Description
        if ($subscribe_item_description) {
            echo '<p class="subscribe-item-description">' . esc_html($subscribe_item_description) . '</p>';
        }

        echo '</article>'; // .subscribe-item
    }
}

echo '</div>'; // .subscribe-items-wrapper


// Display the subscribe link as a button
if ($subscribe_section_button) {
    $button_url = isset($subscribe_section_button['url']) ? esc_url($subscribe_section_button['url']) : '';
    $button_target = isset($subscribe_section_button['target']) ? ' target="' . esc_attr($subscribe_section_button['target']) . '"' : '';
    $button_label = isset($subscribe_section_button['title']) ? esc_html($subscribe_section_button['title']) : 'Subscribe'; // Default text


            echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $button_url . '"' . $button_target . ' class="read-all-link">
                        ' . $button_label . '
                            <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
echo '</div>'; // .subscribe-container
echo '</section>'; // .subscribe-section
?>
<?php
// Get ACF fields
$press_section_title = get_field('press_section_title');
$press_section_description = get_field('press_section_description');
$press_section_link = get_field('press_section_link');

echo '<section class="press-section section">';
echo '<div class="press-container">';

// Display the section title
if ($press_section_title) {
    echo '<div class="section-header-block">';
    echo '<h2 class="section-title">' . esc_html($press_section_title) . '</h2>';
    echo '</div>';
}

// Display the section description
if ($press_section_description) {
    echo '<div class="press-description">' . wp_kses_post($press_section_description) . '</div>';
}


// Display the press link as a button
if ($press_section_link) {
    $button_url = isset($press_section_link['url']) ? esc_url($press_section_link['url']) : '';
    $button_target = isset($press_section_link['target']) ? ' target="' . esc_attr($press_section_link['target']) . '"' : '';
    $button_label = isset($press_section_link['title']) ? esc_html($press_section_link['title']) : 'Subscribe'; // Default text

            echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $button_url . '"' . $button_target . ' class="read-all-link">
                        ' . $button_label . '
                            <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
echo '</div>'; // .press-container
echo '</section>'; // .press-section
?>


<section class="section">
        <div class="section-header-block">
            <h2 class="section-title">Bios</h2>
        </div>
        <?php
        // Get ACF fields for bios section
        $community_bios_content = get_field('community_bios_content');
        $community_bios_filter = get_field('community_bios_filter_instructions');

        // Display bios content
        if ($community_bios_content) {
            echo '<div class="community-bios-content"><strong>' . wp_kses_post($community_bios_content) . '</strong></div>';
        }

        // Display filter instructions
        if ($community_bios_filter) {
            echo '<div class="community-bios-filter"><strong>' . wp_kses_post($community_bios_filter) . '</strong></div>';
        }

        // Get all community labels
        $community_labels = get_terms([
            'taxonomy' => 'community_label',
            'hide_empty' => true,
        ]);

        if (!empty($community_labels) && !is_wp_error($community_labels)) {
            echo '<nav class="community-label-filters">';
            echo '<a class="filter-button active" data-filter="all" href="#">All</a>';
            foreach ($community_labels as $label) {
                echo '<a class="filter-button" data-filter="' . esc_attr($label->slug) . '" href="#">' 
                    . esc_html($label->name) . '</a>';
            }
            echo '</nav>';


            ?>
            
            <?php
        }

        // Query for bio posts
        $args = array(
            'post_type' => 'bios',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );

        $bio_query = new WP_Query($args);

        if ($bio_query->have_posts()) :
            echo '<div class="community-page-bios-grid">';
            
            while ($bio_query->have_posts()) : $bio_query->the_post();
                echo '<article class="community-page-bio-item">';
                
                // Bio Image
                if (has_post_thumbnail()) {
                    echo '<div class="square-image-wrapper">';
                    echo '<a href="' . get_permalink() . '">';
                    the_post_thumbnail('large',['class' => 'img-cover']);
                    
                    // Add community label
                    $community_labels = get_the_terms(get_the_ID(), 'community_label');
                    if ($community_labels && !is_wp_error($community_labels)) {
                        echo '<span class="label">';
                        echo esc_html($community_labels[0]->name);
                        echo '</span>';
                    }
                    
                    echo '</a>';
                    echo '</div>';
                }

                // Name and Surname
                $name_surname = get_field('name_and_surname');
                if ($name_surname) {
                    echo '<h3 class="community-page-bio-title">' . esc_html($name_surname) . '</h3>';
                }

                // Subtitle
                $subtitle = get_field('subtitle');
                if ($subtitle) {
                    echo '<p class="community-page-bio-subtitle subtitle gray">' . esc_html($subtitle) . '</p>';
                }

                // Social Media Links
                $social_icons = array(
                    'Facebook' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>',
                    'Twitter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg>',
                    'Pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg>',
                    'Instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>'
                );

                echo '<div class="community-page-bio-social-links">';
                $social_media_platforms = get_field('social_media_platforms_links');
                if ($social_media_platforms) {
                    foreach ($social_media_platforms as $platform => $details) {
                        if (!empty($details['url'])) {
                            $title = esc_html($details['title']); 
                            $url = esc_url($details['url']);
                            $svg = isset($social_icons[$title]) ? $social_icons[$title] : '';
                            echo '<a href="' . $url . '" target="_blank" class="social-link">' . $svg . '</a>';
                        }
                    }
                }
                echo '</div>';

                echo '</article>';
            endwhile;

            echo '</div>'; // .bios-grid

            wp_reset_postdata();
        else :
            echo '<p>No bios found.</p>';
        endif;
        ?>
    </section>
    <?php
// Get ACF fields
$support_section_title = get_field('support_section_title');
$support_section_description = get_field('support_section_description');
$support_section_link = get_field('support_section_link');

echo '<section class="section section--last">';
echo '<div class="support-us-container">';

// Display the section title
if ($support_section_title) {
    echo '<div class="section-header-block">';
    echo '<h2 class="section-title">' . esc_html($support_section_title) . '</h2>';
    echo '</div>';
}

// Display the section description
if ($support_section_description) {
    echo '<div class="support-us-description">' . wp_kses_post($support_section_description) . '</div>';
}
 // Display the support as a button
        if ($support_section_link) {
            $button_url = isset($support_section_link['url']) ? esc_url($support_section_link['url']) : '';
            $button_target = isset($support_section_link['target']) ? ' target="' . esc_attr($support_section_link['target']) . '"' : '';
            $button_label = isset($support_section_link['title']) ? esc_html($support_section_link['title']) : 'Support Us'; // Default text

            echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $button_url . '"' . $button_target . ' class="read-all-link">
                        ' . $button_label . '
                            <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
echo '</div>'; // .support-us-container
echo '</section>'; // .support-us-section
?>

    </div>
    
</main><!-- .community-page-main-wrapper -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>
    <?php get_sidebar(); ?>
<?php endif; ?>

<?php get_footer(); ?>
