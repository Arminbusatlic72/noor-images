<?php
// Get the header of the theme
get_header(); 

// Start the loop for the story post
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
?>
<div class="exhibition-container">
    <h2 class="exhibition-heading"><?php the_field('headline'); ?></h2>

</div>
<?php 
    endwhile; 
endif;

// Get the footer of the theme
get_footer(); 
?>