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

	<?php astra_primary_content_top(); ?>

	<?php astra_archive_header(); ?>

	
<div class="articles-grid">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="articles-item">
				<!-- <div class="story-post__name-category-wrapper">
					<span class="shared-story-title story-post__name"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->name ); ?></span>/
					<span class="shared-story-title story-post__category">
						<?php 
						$categories = get_the_category();
						if ( ! empty( $categories ) ) {
							echo esc_html( $categories[0]->name );
						} else {
							echo ' Uncategorized';
						}
						?>
					</span>
				</div> -->
				<a href="<?php the_permalink(); ?>" class="articles-link">
					<div class="articles-image">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail('large'); ?>
						<?php endif; ?>
						<span class="article-label"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
					</div>
					<h2 class="article-title"><?php the_title(); ?></h2>
				</a>
				<div class="story-tags">
					<?php the_tags( '<span class="tag">', '</span><span class="tag">', '</span>' ); ?>
				</div>
			</div>
		<?php endwhile; ?>
		<?php astra_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No stories found.', 'text_domain' ); ?></p>
	<?php endif; ?>
</div>


<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
