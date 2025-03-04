<?php
/**
 * The template for displaying the archive for Stories custom post type.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

<div id="primary" <?php astra_primary_class(); ?>>

<section class="news-archive__section">
	 <div class="front-page__header-block">
            <h2 class="front-page__title">See News</h2>
            <div class="toggle-wrapper">
            <a id="toggle-large" class="toggle-view active">Large</a>
    		<a id="toggle-small" class="toggle-view">Small</a>
            </div>

     </div>



	
<div id="news-archive-grid" class="news-archive-grid large-view">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="news-archive-item">
				<div class="news-post__name-category-wrapper">
    <span class="shared-news-title news-post__name">
        <?php echo esc_html( get_post_type_object( get_post_type() )->labels->name ); ?>
    </span>/
    <span class="shared-news-title news-post__category">
        <?php 
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            $category = $categories[0]; // Get the first category
            $category_link = get_category_link( $category->term_id ); // Get the category URL
            ?>
            <a href="<?php echo esc_url( $category_link ); ?>" class="category-link">
                <?php echo esc_html( $category->name ); // Display the category name ?>
            </a>
        <?php 
        } else {
            echo 'Uncategorized'; // Fallback text if no categories assigned
        }
        ?>
    </span>
</div>

  <a href="<?php the_permalink(); ?>" class="news-link">
    <div class="news-image">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail('large'); ?>
        <?php endif; ?>
        
        <?php
        // Get the terms (tags) from the 'front-label' taxonomy
        $front_labels = get_the_terms( get_the_ID(), 'front-label' );
        if ( $front_labels && ! is_wp_error( $front_labels ) ) {
            // Display the first term (tag) from the 'front-label' taxonomy
            $first_label = $front_labels[0];
            $label_link = get_term_link( $first_label, 'front-label' ); // Get the term archive link
            if ( ! is_wp_error( $label_link ) ) {
                echo '<a href="' . esc_url( $label_link ) . '" class="news-label">' . esc_html( $first_label->name ) . '</a>';
            }
        } else {
            // Fallback to the post type label if no 'front-label' terms are found
            echo '<span class="news-label">' . esc_html( get_post_type_object( get_post_type() )->labels->singular_name ) . '</span>';
        }
        ?>
    </div>
    <h2 class="news-title"><?php the_title(); ?></h2>
</a>
                <!-- Display Tags -->
					<div class="news-tags">
						<?php the_tags( '<span class="tag">', '</span><span class="tag">', '</span>' ); ?>
					</div>
			</div>
		<?php endwhile; ?>
		<?php astra_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No news found.', 'text_domain' ); ?></p>
	<?php endif; ?>
</div>

	<?php astra_primary_content_bottom(); ?>
</section>	
</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
