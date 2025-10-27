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
                         <!-- style="background-image: url('<?php //echo esc_url($bg_image); ?>');" -->
                        <div style="background-image: url('<?php echo esc_url($bg_image); ?>');">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </div>

                        <div>
                            <?php
                                $terms = the_terms( get_the_ID(), 'preacher', 'Preacher: ', ', ' );
                                if ($terms && !is_wp_error($terms)) :
                                    foreach ($terms as $term) :
                                        // Output the term name (no link)
                                        echo '<a>' . $term->name . '</a>';
                                    endforeach;
                                endif;
                            ?>
                            <p><?php echo get_the_date('F j, Y'); ?></p> 
                        </div>   

                        <div>
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
