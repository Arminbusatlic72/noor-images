<?php
/*
Template Name: Join The Community Page
*/
get_header(); // Include the header
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        // Get the hero image field
        $hero_image = get_field('hero_image');
        
        // Check if hero image exists and display it
        if($hero_image): ?>
            <div class="full-width-hero">
                <img src="<?php echo esc_url($hero_image['url']); ?>" 
                     alt="<?php echo esc_attr($hero_image['alt']); ?>"
                     class="hero-image">
            </div>
        <?php endif; ?>
        <section class="join-the-community-section">
            <?php
            // Check if the page is being displayed
            if (have_posts()) :
                while (have_posts()) : the_post();
                    // Get ACF fields
                    $heading = get_field('title');
                   
                    $content = get_field('description');

                    // Display the heading
                    if ($heading) {
                        echo '<h2 class="page-heading">' . esc_html($heading) . '</h2>';
                    }

                    // Display the content
                    if ($content) {
                        echo '<div class="page-description">' . wp_kses_post($content) . '</div>';
                    }

                endwhile;
            endif;
            ?>
        </section>
    </main>
</div>

<?php
get_footer(); // Include the footer
?>
