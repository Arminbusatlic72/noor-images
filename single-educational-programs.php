<?php
// Get the header of the theme
get_header(); 

// Start the loop for the story post
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
?>
<main>
    <article class="single-educational-program">
        
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="single-educational-program-featured-image-wrapper">
                <?php 
                    the_post_thumbnail('full'); // or 'full', 'medium', etc.
                    $thumbnail_id = get_post_thumbnail_id();
                    $caption = wp_get_attachment_caption($thumbnail_id);
                    if ( $caption ) :
                ?>
                    
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <section class="section">
            <div class="post-type-header-wrapper">
                <h2 class="post-type-heading"><?php the_field('headline'); ?></h2>
                <h3 class="post-type-subheading gray"><?php the_field('subtitle'); ?></h3>
            </div>
            <div class="bio-description-wrapper">
                <p ><?php the_field('description'); ?></p>
            </div>
            <div class="bio-issues-of-focus">
        <p>Issue areas :</p>
         <!-- Country Labels -->
    <div>
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
    </div>
        </section>
        <?php
$slider_shortcode = get_field('educational_program_slider_short_code');
$title = get_field('title');
$content = get_field('content');

// Only display section if at least one of the fields has content
if ( $slider_shortcode || $headline || $content ) :
?>
<section class="section">
    <div class="bio-slider-section-wrapper">
        
        <div class="bio-slider-section-slider-wrapper">
            <?php
            if ( $slider_shortcode ) {
                echo do_shortcode( $slider_shortcode );
            }
            ?>
        </div>

        <div class="bio-slider-section-text-wrapper">
            <?php if ( $title ): ?>
                <h2 class="bio-headline"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $content ): ?>
                <p class="bio-content"><?php echo esc_html( $content ); ?></p>
            <?php endif; ?>

            <?php
         $educational_program_link = get_field('educational_program_see_more_link'); 
          if ($educational_program_link) {
            $link_url = esc_url($educational_program_link['url']);
            $link_title = esc_html($educational_program_link['title']);
            $link_target = $educational_program_link['target'] ? ' target="' . esc_attr($educational_program_link['target']) . '"' : '';
            echo '<div class="read-all-button-wrapper">
                    <div class="read-all-button">
                        <a href="' . $link_url . '"' . $link_target . ' class="read-all-link">
                        ' . $link_title . '
                        <span class="icon-wrapper">' . get_astra_svg_icon('arrow-right') . '</span>
                        </a>
                    </div>
                 </div>';
        }
        ?>
        </div>

    </div>
</section>
 <section class="section">
        <?php 
        $related_posts_type = get_field('related_post_types'); 
        if( $related_posts_type && !empty($related_posts_type) ): ?>
            <div class="bio-relation-wrapper">
                 <div class="section-header-block">
                    <h2 class="bios-section-title"><?php the_field('related_posts_title'); ?></h2>
                 </div>
       
                <ul class="bio-related-items-list">
                    <?php foreach( $related_posts_type as $post_type ): 
                        $subtitle = get_field('subtitle', $post_type->ID);?>
                        <li class="bio-related-item">
                            <a href="<?php echo get_permalink( $post_type->ID ); ?>" class="bio-related-item-link">
                                <div class="bio-related-item-thumbnail-wrapper">
                                    <?php echo get_the_post_thumbnail( $post_type->ID, 'full', array( 'class' => 'custom-thumbnail' ) ); ?>
                                  
                                </div>
                                <div class="movie-title">
                                    <h3>
										<?php echo esc_html( get_the_title( $post_type->ID ) ); ?>
									</h3>
                                    <?php if ($subtitle): ?>
                                	<p class="subtitle gray"><?php echo esc_html($subtitle); ?></p>
                            		<?php endif; ?>
                                   
                                    <!-- $post_subtitle = get_field('subtitle', $post->ID);  -->
                                </div>
                            </a>
                        </li>
                       
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </section>

    <section class="section">
        <?php 
        $related_posts_type = get_field('related_bios'); 
        if( $related_posts_type && !empty($related_posts_type) ): ?>
            <div class="bio-relation-wrapper">
               
                <div class="section-header-block">
                    <h2 class="bios-section-title"><?php the_field('related_bios_title'); ?></h2>
                </div>
                <div class="">
                    <p><?php the_field('related_bios_description'); ?></p>
                </div>
                <ul class="bio-related-items-list">
                    <?php foreach( $related_posts_type as $post_type ): ?>
                        <li class="bio-related-item">
                            <a href="<?php echo get_permalink( $post_type->ID ); ?>" class="bio-related-item-link">
                                <div class="square-image-wrapper">
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
                            </a>
                            <a href="<?php echo get_permalink( $post_type->ID ); ?>" class="bio-related-item-link">                           
                                <div class="movie-title">
                                   <h3> <?php echo esc_html( get_the_title( $post_type->ID ) ); ?> </h3>
                                </div>
                            </a>
                        </li>
                       
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

<?php
// Get the Text Area field value
$links = get_field('press_links');

if ($links) : 
    // Split the text area content into an array of links
    $links_array = array_filter(array_map('trim', explode("\n", $links))); // Clean up each line and remove empties

    if (!empty($links_array)) :
?>
<div class="press-links-section-wrapper">
    <section class="section">
        <div class="section-header-block">
            <h2 class="bios-section-title">On the press</h2>
        </div>
        <ul class="press-links-list">
            <?php foreach ($links_array as $link) : 
                if (strpos($link, '|') !== false) {
                    list($title, $url) = array_map('trim', explode('|', $link, 2));
                    if (!empty($title) && !empty($url)) :
            ?>
                <li>
                    <a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_html($title); ?></a>
                </li>
            <?php 
                    endif;
                }
            endforeach; 
            ?>
        </ul>
    </section>
</div>
<?php
    endif;
endif;
?>

    </article>
</main>
<?php 
    endwhile; 
endif;

// Get the footer of the theme
get_footer(); 
?>
