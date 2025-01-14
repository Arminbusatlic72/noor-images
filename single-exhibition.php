<?php
// Get the header of the theme
get_header(); 

// Start the loop for the story post
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
?>
<div class="exhibition-container">
    <h2 class="exhibition-heading"><?php the_field('headline'); ?></h2>



    <div class="press-links-section-wrapper">
    <section>
        <h4 class="press-links">On the press:</h4>

        <?php
// Get the Text Area field value
$links = get_field('press_links');

if ($links) : 
    // Split the text area content into an array of links
    $links_array = explode("\n", $links);

    echo '<ul>';
    foreach ($links_array as $link) :
        $link = trim($link); // Trim whitespace
        if (!empty($link)) :
            // Split the line into title and URL
            list($title, $url) = explode('|', $link, 2);
            $title = trim($title); // Clean up title
            $url = trim($url); // Clean up URL
?>
            <li>
                <a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_html($title); ?></a>
            </li>
<?php
        endif;
    endforeach;
    echo '</ul>';
else :
    echo '<p>No publication links available.</p>';
endif;
?>

    </section>
</div>

</div>
<?php 
    endwhile; 
endif;

// Get the footer of the theme
get_footer(); 
?>