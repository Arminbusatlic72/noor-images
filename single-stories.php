<?php
// Get the header of the theme
get_header(); 

// Start the loop for the story post
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
?>

<div class="story-container">
  
    <!-- Display Tags -->
    <div class="story-tags">
        <?php 
        // Display tags
        the_tags( '<span class="tag">', '</span><span class="tag">', '</span>' );
        ?>
    </div>

    <!-- Display Title and Subtitle -->
    <h1 class="story-heading"><?php the_title(); ?></h1>
    <p class="story-subtitle"><?php the_field('subtitle'); ?></p>

    <!-- Display Featured Image with Caption -->
<div class="story-featured-image">
    <?php 
    if ( has_post_thumbnail() ) : 
        $thumbnail_id = get_post_thumbnail_id(); // Get the ID of the featured image
        echo wp_get_attachment_image( $thumbnail_id, 'large' ); // Output the image only

        $caption = wp_get_attachment_caption( $thumbnail_id ); // Get the caption for the image
        if ( $caption ) : 
    ?>
        <figcaption class="story-image-caption"><?php echo esc_html( $caption ); ?></figcaption>
    <?php 
        endif;
    endif;
    ?>
</div>
<?php if (is_singular()) : ?>
    <div class="social-share">
        <?php echo add_social_share_buttons(''); ?>
    </div>
<?php endif; ?>

    <!-- Display Content from the Classic Editor -->
    <div class="story-content">
        <?php the_content(); ?>
    </div>
<div class="story-navigation-wrapper"> 
            <div class="prev-story">
                <?php
                $prev_post = get_previous_post();
                if ($prev_post) :
                    ?>
                    <a href="<?php echo get_permalink($prev_post->ID); ?>">&laquo; Previous Story: <?php echo esc_html($prev_post->post_title); ?></a>
                <?php endif; ?>
            </div>
            <div class="next-story">
                <?php
                $next_post = get_next_post();
                if ($next_post) :
                    ?>
                    <a href="<?php echo get_permalink($next_post->ID); ?>">Next Story: <?php echo esc_html($next_post->post_title); ?> &raquo;</a>
                <?php endif; ?>
            </div>
        </div>
</div>
				

<?php 
    endwhile; 
endif;

// Get the footer of the theme
get_footer(); 
?>
