<?php 
/*
Template Name: All Movies
*/
get_header(); 
?>
<div class="video-header">
    <video muted loop autoplay>
        <source src="https://assets.codepen.io/6093409/river.mp4" type="video/mp4">
      </video>
    <div class="video-overlay">
        <h1>All Movies</h1>
    </div>
</div>
<div class="movies-wrapper">
    

    <?php
    // Query for custom post type 'movies'
    $args = array(
        'post_type' => 'movies',
        'posts_per_page' => -1,  // Show all movies
    );
    $movies_query = new WP_Query($args);

    if ($movies_query->have_posts()) : ?>
        <ul class="movies-list">
            <?php while ($movies_query->have_posts()) : $movies_query->the_post(); ?>
                <li class="movie-item">
                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="movie-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
                        <?php echo esc_html( get_the_title() ); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>No movies found.</p>
    <?php endif;

    // Reset post data
    wp_reset_postdata();
    ?>
</div>

<?php get_footer(); ?>