<?php
// Enqueue parent theme styles
function astra_child_enqueue_styles() {
    wp_enqueue_style('astra-parent-style', get_template_directory_uri() . '/style.css');
	
    wp_enqueue_style('astra-child-style', get_stylesheet_directory_uri() . '/style.css', array('astra-parent-style'));
    // Enqueue front-page-specific CSS
    if ( is_front_page() ) {
        wp_enqueue_style('front-page-style', get_stylesheet_directory_uri() . '/assets/css/front-page.css', array('astra-child-style'));
         wp_enqueue_script('scroll-script', get_stylesheet_directory_uri() . '/assets/js/scroll.js', array(), null, true);
    }
    if (is_page('education')) {
        wp_enqueue_style('education-page-style', get_stylesheet_directory_uri() . '/assets/css/education-page.css', array('astra-child-style'));
    }
    if ( is_post_type_archive( 'stories' ) || is_tax( 'stories_category' ) ) {
        wp_enqueue_style('front-page-style', get_stylesheet_directory_uri() . '/assets/css/stories-archive.css', array('astra-child-style'));
    }
     if ( is_post_type_archive( 'announcements' ) || is_tax( 'announcements_category' ) ) {
        wp_enqueue_style('front-page-style', get_stylesheet_directory_uri() . '/assets/css/announcements-archive.css', array('astra-child-style'));
    }
    if ( is_post_type_archive( 'bios' ) || is_tax( 'bios_category' ) ) {
        wp_enqueue_style('front-page-style', get_stylesheet_directory_uri() . '/assets/css/bios-archive.css', array('astra-child-style'));
    }
    if ( is_post_type_archive( 'news' ) || is_tax( 'news_category' ) ) {
        wp_enqueue_style('front-page-style', get_stylesheet_directory_uri() . '/assets/css/news-archive.css', array('astra-child-style'));
    }
    if ( is_singular( 'bios' ) ) {
    wp_enqueue_style('single-bios-style', get_stylesheet_directory_uri() . '/assets/css/single-bios.css', array('astra-child-style'));
    }
    if ( is_singular( 'exhibitions' ) ) {
    wp_enqueue_style('single-exhibition-style', get_stylesheet_directory_uri() . '/assets/css/single-exhibition.css', array('astra-child-style'));
    }
     if ( is_singular( 'stories' ) ) {
    wp_enqueue_style('single-stories-style', get_stylesheet_directory_uri() . '/assets/css/single-story.css', array('astra-child-style'));
    }
    if ( is_singular( 'news' ) ) {
    wp_enqueue_style('single-news-style', get_stylesheet_directory_uri() . '/assets/css/single-news.css', array('astra-child-style'));
    }


	
    wp_enqueue_script('theme.js', get_stylesheet_directory_uri() . '/theme.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'astra_child_enqueue_styles');
function enqueue_toggle_grid_script() {
   
    if ( is_post_type_archive( 'stories' ) || is_post_type_archive( 'news' ) ) {
        wp_enqueue_script(
            'toggle-grid-view',
            get_stylesheet_directory_uri() . '/assets/js/toggle-grid.js',
            array(),
            '1.0',
            true // Load in the footer
        );
    }
}
add_action( 'wp_enqueue_scripts', 'enqueue_toggle_grid_script' );


function register_custom_post_type($singular, $plural, $slug, $menu_position = 5) {
    $labels = array(
        'name'                  => _x($plural, 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x($singular, 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __($plural, 'text_domain'),
        'name_admin_bar'        => __($singular, 'text_domain'),
        'archives'              => __("$singular Archives", 'text_domain'),
        'attributes'            => __("$singular Attributes", 'text_domain'),
        'parent_item_colon'     => __("Parent $singular:", 'text_domain'),
        'all_items'             => __("All $plural", 'text_domain'),
        'add_new_item'          => __("Add New $singular", 'text_domain'),
        'add_new'               => __('Add New', 'text_domain'),
        'new_item'              => __("New $singular", 'text_domain'),
        'edit_item'             => __("Edit $singular", 'text_domain'),
        'update_item'           => __("Update $singular", 'text_domain'),
        'view_item'             => __("View $singular", 'text_domain'),
        'view_items'            => __("View $plural", 'text_domain'),
        'search_items'          => __("Search $plural", 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Featured Image', 'text_domain'),
        'set_featured_image'    => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image'    => __('Use as featured image', 'text_domain'),
        'insert_into_item'      => __("Insert into $singular", 'text_domain'),
        'uploaded_to_this_item' => __("Uploaded to this $singular", 'text_domain'),
        'items_list'            => __("$plural list", 'text_domain'),
        'items_list_navigation' => __("$plural list navigation", 'text_domain'),
        'filter_items_list'     => __("Filter $plural list", 'text_domain'),
    );

    $args = array(
        'label'                 => __($singular, 'text_domain'),
        'description'           => __("A custom post type for $plural", 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => $menu_position,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'rewrite'               => array('slug' => $slug),
        'taxonomies'         => array( 'category', 'post_tag' ),
        'show_in_rest'          => true,
    );

    register_post_type($slug, $args);
}
add_action('init', function() {
    // register_custom_post_type('Article', 'Articles', 'articles', 5);
    register_custom_post_type('Bio', 'Bios', 'bios', 5);
    register_custom_post_type('Exhibition', 'Exhibitions', 'exhibitions', 6);
    register_custom_post_type('News', 'News', 'news', 7);
    // register_custom_post_type('Story', 'Stories', 'stories', 8);
    // register_custom_post_type('Announcement', 'Announcements', 'announcements', 9);


});



function add_social_share_buttons($content) {
    if (is_singular() && in_the_loop() && is_main_query()) { // Apply to any singular post type
        $url = esc_url(get_permalink());
        $title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));

        $social_networks = array(
            'Facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
            'Twitter' => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title,
            'LinkedIn' => 'https://www.linkedin.com/shareArticle?url=' . $url . '&title=' . $title,
            'Pinterest' => 'https://pinterest.com/pin/create/button/?url=' . $url . '&description=' . $title,
        );

        // SVG icons for social networks
        $social_icons = array(
            'Facebook' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>',
            'Twitter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.4 151.7c0 2.4-.1 4.8-.4 7.2-8.6 37.1-28.5 68.5-54.2 91.4 1.3 29.9-4.1 59.7-14.8 85.5-9.7 25.7-24.7 49.5-44.5 70.1-19.7 20.6-43.5 37-69.6 50.2-26.1 13.3-54.4 24.1-83.5 33.2-29.1 9.1-58.3 17.2-88.4 24.3-15.3 3.5-30.8 6.7-46.4 9.5 8.1-29.9 3.5-63.7-13.2-90.4 17.5-4.4 34.2-9.8 49.5-16.2 11.5-3.6 22.8-7.6 33.8-11.7-21.3-16.1-35.8-41.5-39.4-69.2 7.9 4.7 16.7 7.3 25.8 8.3-20.9-14-33.4-39-33.4-66.7 0-14.8 3.9-28.7 10.9-40.9 37.4 45.9 93 76.2 155.5 79.6-1.3-5.9-2-12-2-18.1 0-43.6 35.3-78.6 78.8-78.6 22.7 0 43.3 9.4 57.8 24.7 18.1-3.5 34.6-10.1 49.8-19.3-6 18.5-18.6 34.1-35.2 44.2 16.3-1.9 32.4-6.2 47.1-12.6-11.7 16.6-26.4 31.2-43.2 42.4z"></path></svg>',
            'LinkedIn' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path></svg>',
            'Pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg>'
        );

        // Start building the button HTML
        $output = '<div class="social-share-buttons">';

        foreach ($social_networks as $network => $link) {
            $icon = isset($social_icons[$network]) ? $social_icons[$network] : '';
            $output .= '<a href="' . esc_url($link) . '" target="_blank" class="social-share-button social-share-' . strtolower($network) . '" title="Share on ' . $network . '">
                            <span class="social-share-icon">' . $icon . '</span>
                            ' . esc_html($network) . '
                        </a>';
        }

        $output .= '</div>';

        return $content . $output;
    }

    return $content;
}
// add_filter('the_content', 'add_social_share_buttons');


function add_slider_before_header() {
    if ( is_front_page() ) { // Check if it's the homepage
        echo do_shortcode('[smartslider3 slider="2"]'); // Output the slider
    }
}
add_action('astra_header_after', 'add_slider_before_header');
// adding tags for bios
function register_custom_taxonomy($taxonomy_slug, $post_types, $taxonomy_name, $singular_name, $rewrite_slug, $is_hierarchical = false) {
    register_taxonomy(
        $taxonomy_slug, // Taxonomy slug
        $post_types, // Post types the taxonomy applies to
        [
            'labels' => [
                'name' => $taxonomy_name,
                'singular_name' => $singular_name,
                'search_items' => 'Search ' . $taxonomy_name,
                'all_items' => 'All ' . $taxonomy_name,
                'edit_item' => 'Edit ' . $singular_name,
                'update_item' => 'Update ' . $singular_name,
                'add_new_item' => 'Add New ' . $singular_name,
                'new_item_name' => 'New ' . $singular_name . ' Name',
                'menu_name' => $taxonomy_name,
            ],
            'hierarchical' => $is_hierarchical, // false for tags, true for categories
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => $rewrite_slug],
        ]
    );
}

// Hook into init
add_action('init', function() {
    // Register Community Labels
    register_custom_taxonomy(
        'community_label',      // Taxonomy slug
        ['bios'],               // Associated post types
        'Community Labels',     // Taxonomy name
        'Community Label',      // Singular name
        'community-label',      // Rewrite slug
        false                   // Is hierarchical
    );

    // Register Countries
    register_custom_taxonomy(
        'country',              // Taxonomy slug
        ['bios'],               // Associated post types
        'Countries',            // Taxonomy name
        'Country',              // Singular name
        'country',              // Rewrite slug
        false                   // Is hierarchical
    );

    // Register Continents
    register_custom_taxonomy(
        'continent',            // Taxonomy slug
        ['bios'],               // Associated post types
        'Continents',           // Taxonomy name
        'Continent',            // Singular name
        'continent',            // Rewrite slug
        false                   // Is hierarchical
    );
    // Register Continents
    register_custom_taxonomy(
        'issues_of_focus',            // Taxonomy slug
        ['bios','exhibitions','stories'],               // Associated post types
        'Issues of focus',           // Taxonomy name
        'Issue of focus',            // Singular name
        'issue of focus',            // Rewrite slug
        false                   // Is hierarchical
    );
});

function add_front_label_tag_to_news() {
    // Register the taxonomy (tag) for the 'news' custom post type
    register_taxonomy(
        'front-label', // Taxonomy name
        'news',        // Custom post type name
        array(
            'label' => __( 'Front Label' ), // Label for the taxonomy
            'rewrite' => array( 'slug' => 'front-label' ), // Slug for the taxonomy
            'hierarchical' => false, // Set to false for tag-like behavior
            'show_admin_column' => true, // Show the taxonomy in the admin column
            'show_in_rest' => true, // Enable in REST API
        )
    );
}
add_action( 'init', 'add_front_label_tag_to_news' );

function your_prefix_change_header_breakpoint() {
	return 3000; // Forces mobile header on almost all screen sizes
}
add_filter( 'astra_header_break_point', 'your_prefix_change_header_breakpoint' );

