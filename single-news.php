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
        $slider_shortcode = get_field('top_slider_short_code');
        if( $slider_shortcode ):
            echo do_shortcode( $slider_shortcode );
        endif;
        ?>
    </div>
</div>
<section class="exhibition-header-section">
    < class="exhibition-header-wrapper">
    <h2 class="bio-heading"><?php the_field('headline'); ?></h2>
    <h3><?php the_field('subtitle'); ?></h3>
    <div class="exhibition-description-wrapper">
    <p ><?php the_field('story_description'); ?></p>
    </div>

 <div class="bio-issues-of-focus">
        <span>Issue areas :</span>
         <!-- Country Labels -->
    
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

</section>

<section class="top-related-item-section">
   
    <article class="content-sidebar-grid">
        <!-- Slider or Featured Image -->
        <div class="top-related-item-wrapper">
            <?php 
            // Get the related post types
            $related_posts_type = get_field('related_post_types'); 
            
            // Check if related posts exist
            if( $related_posts_type && !empty($related_posts_type) ):
                // Get the latest related post (first item in the array)
                $latest_post = $related_posts_type[0];
                
                // Display the featured image of the latest post with a link
                $latest_post_permalink = get_permalink( $latest_post->ID );
                $latest_post_thumbnail = get_the_post_thumbnail( $latest_post->ID, 'large', array( 'class' => 'img-cover' ) );
                
                echo '<a href="' . esc_url( $latest_post_permalink ) . '" class="bio-latest-post-link">';
                 echo '<div class="aspect-3-2">';
                echo $latest_post_thumbnail;
                echo '</div>';
                echo '</a>';
            endif;
            ?>
        </div>
        <div class="top-related-item-meta-wrapper">
            <?php 
            if ( isset($latest_post) ):
                // Display the title of the latest post
                echo '<h2 class="bio-latest-title"><a href="'. esc_url($post_permalink) . '">' . esc_html( get_the_title( $latest_post->ID ) ) . '</a></h2>';
            endif;
            ?>
        </div>
    </article>
</section>


<!-- Related Post Types -->
<div class="bio-related-section-wrapper">
    <div class="section-header-block">
                    <h2 class="section-title">Stories and more</h2>
                </div>
    <section class="section">
        <?php 
        if( $related_posts_type && !empty($related_posts_type) ): ?>
            <div class="bio-relation-wrapper">
                
                <ul class="bio-related-items-list">
                    <?php 
                    foreach( $related_posts_type as $index => $post_type ): 
                        // Skip the first post since it's already displayed in the slider section
                        if ( $index === 0 ) {
                            continue;
                        }
                    ?>
                        <li class="bio-related-item">
                            <a href="<?php echo get_permalink( $post_type->ID ); ?>" class="bio-related-item-link">
                                <div class="aspect-3-2">
                                    
                                    <?php echo get_the_post_thumbnail( $post_type->ID, 'full', array( 'class' => 'img-cover' ) ); ?>
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
    <section class="section">
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
                                <div class="square-image-wrapper bio-related-item-thumbnail">
                                    <?php echo get_the_post_thumbnail( $post_type->ID, 'medium_large', array( 'class' => 'img-cover' ) ); ?>
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