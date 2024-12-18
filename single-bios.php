<?php
// Get the header of the theme
get_header(); 

// Start the loop for the story post
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
?>

<div class="bio-container">
  <div class="bio-content-wrapper half-width">

  <!-- Display Title and Subtitle -->
    <h2 class="bio-heading"><?php the_title(); ?></h2>
    <h4 class="bio-subtitle"><?php the_field('subtitle'); ?></h4>
   
    <!-- Display Tags -->
    <div class="story-tags">
        <?php 
        // Display tags
        the_tags( '<span class="tag">', '</span><span class="tag">', '</span>' );
        ?>
    </div>

   <?php
// Check if the ACF group and fields exist
if ( have_rows('bio_time') ) :
    while ( have_rows('bio_time') ) : the_row();
        // Get the field values
        $start_date = get_sub_field('date_start'); // Replace 'start_time' with your actual field name
        $start_time = get_sub_field('time_start');
         $end_date = get_sub_field('date_end'); // Replace 'start_time' with your actual field name
        $end_time = get_sub_field('time_end');     // Replace 'end_time' with your actual field name
        ?>
        <div class="bio-time-wrapper">
           
            <span class="start-date"><?php echo esc_html($start_date); ?></span> - 
            <span class="start-time"><?php echo esc_html($start_time); ?></span>
        <span class="separator"> - </span>
         
            
            <span class="start-date"><?php echo esc_html($end_date); ?></span> - 
            <span class="start-time"><?php echo esc_html($end_time); ?></span>
        
        <?php
    endwhile;
else :
    echo '<p>No bio times found.</p>';
endif;
?>
 
</div>
<div class="bio-relation">
        <!-- Related Movies Section -->
        <?php 
        $related_posts_type = get_field('related_post_types'); 
        if( $related_posts_type && !empty($related_posts_type) ): ?>
            <div class="bio-related-movies">
                <h4 class="front-page__title">Stories & more</h4>
                <ul class="bio-related-items-list">
    <?php foreach( $related_posts_type as $post_type ): ?>
        <li class="bio-related-item">
            <a href="<?php echo get_permalink( $post_type->ID ); ?>" class="movie-link">
                <div class="movie-thumbnail">
                    <?php echo get_the_post_thumbnail( $post_type->ID, 'medium', array( 'class' => 'custom-thumbnail' ) ); ?>
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

        
    </div>
                    <a href="<?php echo get_post_type_archive_link('bios'); ?>" class="bios__button">See all bios</a>

</div>

    <!-- Display Featured Image with Caption -->
<div class="bio-featured-image-wrapper half-width">
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

 
   

<?php 
    endwhile; 
endif;

// Get the footer of the theme
get_footer(); 
?>
