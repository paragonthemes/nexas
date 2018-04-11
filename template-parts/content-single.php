<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Paragon Themes
 * @subpackage Nexas
 */
$hide_show_feature_image = nexas_get_option( 'nexas_show_feature_image_single_option' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
    <div class="section-14-box wow fadeInUp <?php if(!has_post_thumbnail() || $hide_show_feature_image=='hide') { echo'no-image'; }?>">
       
        <figure>
       
            <?php
            if( has_post_thumbnail() && $hide_show_feature_image=="show" ) {
            ?>
                <?php the_post_thumbnail( 'full' ); ?>

            <?php } ?>
       
        </figure>

        <div class="entry-box">
            <div class="date">
                <span><?php echo esc_html( get_the_date('M') ); ?></span>
                <span><?php echo esc_html( get_the_date('d') ); ?></span>
                <span><?php echo esc_html( get_the_date('Y') ); ?></span>
            </div>
            
            <div class="text-left author-post">
              <a href="<?php echo esc_url( get_author_posts_url(get_the_author_meta('ID')) ); ?> "><?php the_author(); ?></a>
            </div>
            
            <div class="post-des">
                <?php the_content();
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:','nexas' ),
                        'after'  => '</div>',
                      ) );
                ?>
            </div>
            
            <?php if ( get_edit_post_link() ) : ?>
                
                <footer class="entry-footer">
                  
                  <?php
                    edit_post_link(
                      sprintf(
                        /* translators: %s: Name of current post */
                        esc_html__( 'Edit %s','nexas'),
                        the_title( '<span class="screen-reader-text">"', '"</span>', false )
                      ),
                      '<span class="edit-link">',
                      '</span>'
                    );
                  ?>
            
                </footer><!-- .entry-footer -->
            
            <?php endif; ?>
        
        </div>
           
 </article><!-- #post-## -->         
          