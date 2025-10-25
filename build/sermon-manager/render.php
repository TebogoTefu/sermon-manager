<?php

$args = array(
    'post_type'      => 'sermon', // Custom post type 'sermon'
    'posts_per_page' => -1, // Get all posts (or adjust this number as needed)
    'meta_query'     => array(
        array(
            'key'     => 'youtube_sermon_link', // The custom field key
            'value'   => '', // You can check if it's not empty
            'compare' => '!=', // Ensures the field is not empty
        ),
    ),
);

$query = new WP_Query($args);

if ($query->have_posts()) :
    ?>
    <div class="sermons-container alignfull">
        <div class="sermon-posts-inner">
            <?php
                while ($query->have_posts()) : $query->the_post();
                $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    ?>
                    <div class="sermon-post">
                        <div  style="background-image: url('<?php echo esc_url($bg_image); ?>');">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <!-- Thumbnail -->
                            <?php
                                // if ( has_post_thumbnail() ) { // Check if a featured image exists
                                //     the_post_thumbnail( 'medium' ); // Display featured image with 'medium' size
                                //     // You can also use 'thumbnail', 'large', 'full', or a custom size array (e.g., array(200, 200))
                                //     }
                            ?>
                         
                        </div>
                        <?php
                            $terms = the_terms( get_the_ID(), 'preacher', 'Preacher: ', ', ' );
                            if ($terms && !is_wp_error($terms)) :
                                foreach ($terms as $term) :
                                    // Output the term name (no link)
                                    echo '<h3><a>' . $term->name . '</a></h3>';
                                endforeach;
                            endif;
                        ?>
                        <p><?php echo get_the_date('F j, Y'); ?></p> 
                    
                        <div class="media-links">
                            <a href="<?php the_permalink(); ?>"><i class="hgi hgi-stroke hgi-video-01"></i></a>
                            <a href="<?php the_permalink(); ?>"><i class="hgi hgi-stroke hgi-music-note-square-02"></i></a>
                        </div>  
                    </div>
                    
                    <?php
                endwhile;
            ?>
        </div>
    </div>

<?php
else :
    echo 'No sermons found with YouTube links.';
endif;

wp_reset_postdata();
?>
