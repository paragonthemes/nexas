<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Paragon Themes
 * @subpackage Nexas
 */
$copyright = nexas_get_option('nexas_copyright');
if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) {

        $count = 0;
      
        for ( $i = 1; $i <= 4; $i++ )
            {
              if ( is_active_sidebar( 'footer-' . $i ) )
                    {
                        $count++;
                    }
            }
       
        $column = 3;
       
        if( $count == 4 ) 
        {
            $column = 3;  
       
        }

        elseif( $count == 3)
        {
                $column = 4;
        }
        
        elseif( $count == 2) 
        {
                $column = 6;
        }
        
        elseif( $count == 1) 
        {
                $column = 12;
        }

    ?>

    <section id="footer-top" class="footer-top">
        <div class="container">
            <div class="row">
                <?php
                    for ( $i = 1; $i <= 4 ; $i++ )
                    {
                        
                        if ( is_active_sidebar( 'footer-' . $i ) )
                        {

                ?>
                            <div class="col-md-3">
                                <div class="footer-top-box wow fadeInUp">
                                    <?php dynamic_sidebar( 'footer-' . $i ); ?>
                                </div>

                            </div>
                    <?php  }
                     
                     }       
                     
                     ?>
              
                
               
            </div>
        </div>
    </section>

<?php } ?>

<section id="footer-bottom" class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="copyright">
                  <?php echo wp_kses_post($copyright); ?>
                   <span> <?php echo wp_kses_post( get_theme_mod('nexas_powerby_text','<a href="https://wordpress.org/">Proudly powered by WordPress</a>')); ?></span>  
                   <?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'nexas' ), 'Nexas', '<a href="https://paragonthemes.com" rel="designer">Paragon Themes</a>' ); ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php wp_footer(); ?>

</body>
</html>
