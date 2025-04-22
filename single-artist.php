<?php 
get_header(); 
?>

<div class="artist-page-wrapper">
    <div class="artist-left">
        <!-- Featured Image Section -->
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="artist-featured-image">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>

        <!-- Artist Content Section -->
        <div class="artist-content">
            <?php 
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>

    <div class="artist-right">
        <!-- Related Movies Section -->
        <?php 
        $related_movies = get_field('related_movies'); 
        if( $related_movies && !empty($related_movies) ): ?>
            <div class="artist-related-movies">
                <h2>Movies by this Artist</h2>
                <ul class="movie-list">
                    <?php foreach( $related_movies as $movie ): ?>
                        <li class="movie-item">
                            <a href="<?php echo get_permalink( $movie->ID ); ?>" class="movie-link">
                                <?php echo get_the_title( $movie->ID ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Related Exhibitions Section -->
        <?php 
        $related_exhibitions = get_field('related_exhibitions'); 
        if( $related_exhibitions && !empty($related_exhibitions) ): ?>
            <div class="artist-related-exhibitions">
                <h2>Exhibitions by this Artist</h2>
                <ul class="exhibition-list">
                    <?php foreach( $related_exhibitions as $exhibition ): ?>
                        <li class="exhibition-item">
                            <a href="<?php echo get_permalink( $exhibition->ID ); ?>" class="exhibition-link">
                                <?php echo get_the_title( $exhibition->ID ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
