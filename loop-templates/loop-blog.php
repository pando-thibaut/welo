<?php
/**
 * Template Name: Blog
 */
?>
<?php if ( have_posts() ) : ?>

    <?php /* Start the Loop */ ?>
    <?php while ( have_posts() ) : the_post(); ?>

         <?php
            $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            if(empty($feat_image))
            {
                $feat_image = "/wp-content/uploads/2016/03/bv_archive.jpg";
            }
        ?>

        <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">

            <?php $post_type = get_post_type_object( get_post_type($post) ); ?>
            <div class="actualite-item">
                <a href="<?php the_permalink(); ?>">
                    <div class="actualite-item-image" style="background-image: url('<?php echo $feat_image; ?>');">
                        
                    </div>
                </a>
                <div class="actualite-item-content">
                    <div class="actualite-item-category">
                        <?php echo get_the_category()[0]->name; ?>
                    </div>
                    <h4>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h4>

                    <?php if ( has_excerpt( $post->ID ) ) { the_excerpt(); } else { echo wp_trim_words( do_shortcode(get_the_content()), $num_words = 30, $more = null ); } ?>
                    <div class="list-actualite-item-date">
                        <img src="/wp-content/uploads/2019/06/ic-time.png" alt=""><?php echo get_the_date("j F, Y",$post->ID ); ?>
                    </div>
                </div>
            </div>

        </div>

    <?php endwhile; ?>

    <div class="pagination-container">
        <?php
        global $wp_query;

        $big = 999999999; // need an unlikely integer

        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'before_page_number' => '<span class="search-number">',
            'after_page_number' => '</span>',
            'prev_text'          => __('<span class="search-arrow left"><img src="/wp-content/uploads/2016/08/ic_actualite_arrow_left.png" alt=""></span> Précédent'),
            'next_text'          => __('Suivant <span class="search-arrow right"><img src="/wp-content/uploads/2016/08/ic_actualite_arrow_right.png" alt=""></span>'),
        ) );
        ?>
    </div>


<?php else : ?>

    <?php get_template_part( 'no-results', 'index' ); ?>

<?php endif; ?>