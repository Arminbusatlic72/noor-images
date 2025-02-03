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
<div class="bios-archive-section-wrapper">
<section class="bios-archive-section">
	 <div class="stories-archive__header-block">
            <h2 class="stories-archive__title">See Stories</h2>
            <a id="toggle-large" class="toggle-view active">Large</a>
    		<a id="toggle-small" class="toggle-view">Small</a>
     </div>

<div class="bios-archive-grid">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="bios-archive-item">
				<div class="story-post__name-category-wrapper"> 
				<div class="bios-details-wrapper">
                                <h3 class="bios-details-details-title"><?php the_field('name_and_surname'); ?></h3>
                                <h6 class="bios-details-details-title"><?php the_field('subtitle'); ?></h6>
                        </div>
</div>

				<a href="<?php the_permalink(); ?>" class="story-link">
					<div class="bio-image-wrapper">
						<div class="bio-image">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail('large'); ?>
							<?php endif; ?>
                            <?php 
                         $community_labels = get_the_terms(get_the_ID(), 'community_label');
                         if ($community_labels && !is_wp_error($community_labels)) : 
                         ?>
                         <span class="bio-label">
                            <?php echo esc_html($community_labels[0]->name); ?>
                         </span>
                         <?php endif; ?>
						</div>
						
					</div>
				</a>
			</div>
		<?php endwhile; ?>
		<?php astra_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No bios found.', 'text_domain' ); ?></p>
	<?php endif; ?>
</div>

	<?php astra_primary_content_bottom(); ?>
</section> 	
</div>
</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
