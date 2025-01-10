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



	
<div  class="bios-archive-grid">
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
					<div class="bio-image">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail('large'); ?>
						<?php endif; ?>
						<span class="bio-label"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>


								<div class="bio-social-media">
    <?php
    $social_icons = array(
        'Facebook' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>',
        'Twitter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.4 151.7c0 2.4-.1 4.8-.4 7.2-8.6 37.1-28.5 68.5-54.2 91.4 1.3 29.9-4.1 59.7-14.8 85.5-9.7 25.7-24.7 49.5-44.5 70.1-19.7 20.6-43.5 37-69.6 50.2-26.1 13.3-54.4 24.1-83.5 33.2-29.1 9.1-58.3 17.2-88.4 24.3-15.3 3.5-30.8 6.7-46.4 9.5 8.1-29.9 3.5-63.7-13.2-90.4 17.5-4.4 34.2-9.8 49.5-16.2 11.5-3.6 22.8-7.6 33.8-11.7-21.3-16.1-35.8-41.5-39.4-69.2 7.9 4.7 16.7 7.3 25.8 8.3-20.9-14-33.4-39-33.4-66.7 0-14.8 3.9-28.7 10.9-40.9 37.4 45.9 93 76.2 155.5 79.6-1.3-5.9-2-12-2-18.1 0-43.6 35.3-78.6 78.8-78.6 22.7 0 43.3 9.4 57.8 24.7 18.1-3.5 34.6-10.1 49.8-19.3-6 18.5-18.6 34.1-35.2 44.2 16.3-1.9 32.4-6.2 47.1-12.6-11.7 16.6-26.4 31.2-43.2 42.4z"></path></svg>', 
        'Instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 202.66A53.34 53.34 0 1 0 277.34 256 53.38 53.38 0 0 0 224 202.66zm124.71-41a53.46 53.46 0 1 1 53.46-53.46A53.52 53.52 0 0 1 348.71 161.66zm-71.42 214.63a140.88 140.88 0 1 1 140.88-140.88A140.9 140.9 0 0 1 277.29 376.29z"></path></svg>',
        'Pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg>'
    );

    // Get the social media group field
    $social_media = get_field('social_media_platforms_links');

    // Check if the group field has data
    if ($social_media):
        foreach ($social_media as $platform => $details):
            if (!empty($details['url'])):
                $title = esc_html($details['title']);
                $url = esc_url($details['url']);
                $svg = isset($social_icons[$title]) ? $social_icons[$title] : '';
                echo '<a href="' . $url . '" target="_blank"><span class="social-icon">' . $svg . '</span></a><br>';
            endif;
        endforeach;
    endif;
    ?>
</div>
					</div>

			
    

				</a>
                <!-- Display Tags -->
					
			</div>
		<?php endwhile; ?>
		<?php astra_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No stories found.', 'text_domain' ); ?></p>
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
