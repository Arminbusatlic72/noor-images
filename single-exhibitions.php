<?php
// Get the header of the theme
get_header(); 

// Start the loop for the story post
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
?>
<div class="exhibition-container">
<div class="full-with-slider-container">
     <!-- Slider -->
    <div class="bio-slider-section-slider-wrapper">
        <?php
        $slider_shortcode = get_field('slider_short_code');
        if( $slider_shortcode ):
            echo do_shortcode( $slider_shortcode );
        endif;
        ?>
    </div>
</div>
<section class="exhibition-header-section">
    <div class="exhibition-header-wrapper">
    <h2 class="bio-heading"><?php the_field('headline'); ?></h2>
    <div class="exhibition-time-wrapper">
        <?php
// Check if the ACF group and fields exist
if ( have_rows('announcement_time') ) :
    while ( have_rows('announcement_time') ) : the_row();
        // Get the field values
        $start_date = get_sub_field('date_start'); // Replace with your actual field name
        $start_time = get_sub_field('time_start');
        $end_date = get_sub_field('date_end'); // Replace with your actual field name
        $end_time = get_sub_field('time_end');
        $location = get_sub_field('location'); // Get the location subfield
        ?>
        <div class="exhibition-time-wrapper">
            <div class="time-details">
                <span class="start-date"><?php echo esc_html($start_date); ?></span> - 
                <span class="start-time"><?php echo esc_html($start_time); ?></span>
                <span class="separator"> - </span>
                <span class="end-date"><?php echo esc_html($end_date); ?></span> - 
                <span class="end-time"><?php echo esc_html($end_time); ?></span>
            </div>
            <?php if ( $location ) : ?>
                <div class="location">
                    <strong>Location:</strong> <?php echo esc_html($location); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    endwhile;
else :
    echo '<p>No exhibition times found.</p>';
endif;
?>

    </div>
    <div class="exhibition-description-wrapper">
    <p ><?php the_field('exhibition_description'); ?></p>
</div>

 <div class="bio-issues-of-focus">
        <p>Issues of focuses :</p>
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
</div>
</section>

<!-- Related Post Types -->
    <div class="bio-related-section-wrapper">
    <section class="bio-related-section">
        <?php 
        $related_posts_type = get_field('related_post_types'); 
        if( $related_posts_type && !empty($related_posts_type) ): ?>
            <div class="bio-relation-wrapper">
                
                <div class="section-header-block">
                <h2 class="section-title">Stories & more</h2>
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

<!-- Related Post Types -->
    <div class="bio-related-section-wrapper">
    <section class="bio-related-section">
        <?php 
        $related_posts_type = get_field('related_bios'); 
        if( $related_posts_type && !empty($related_posts_type) ): ?>
            <div class="bio-relation-wrapper">
                
            <div class="section-header-block">
                <h2 class="section-title">Visual Storytellers behind the Project</h2>
            </div>
                <div class="">
                    <p><?php the_field('related_bios_description'); ?></p>
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
    <div class="press-links-section-wrapper">
    <section class="press-links-section">
       <div class="section-header-block">
            <h2 class="section-title">On the press:</h2>
        </div>

        <?php
// Get the Text Area field value
$links = get_field('press_links');

if ($links) : 
    // Split the text area content into an array of links
    $links_array = explode("\n", $links);

    echo '<ul>';
    foreach ($links_array as $link) :
        $link = trim($link); // Trim whitespace
        if (!empty($link)) :
            // Split the line into title and URL
            list($title, $url) = explode('|', $link, 2);
            $title = trim($title); // Clean up title
            $url = trim($url); // Clean up URL
?>
            <li>
                <a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_html($title); ?></a>
            </li>
<?php
        endif;
    endforeach;
    echo '</ul>';
else :
    echo '<p>No publication links available.</p>';
endif;
?>

    </section>
</div>

</div>
<?php 
    endwhile; 
endif;

// Get the footer of the theme
get_footer(); 
?>