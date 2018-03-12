<?php
/**
 * The template for displaying all pages.
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Paragon Themes
 * @subpackage Nexas
 */
$nexas_slider_section_option      = nexas_get_option('nexas_homepage_slider_option');

if ( $nexas_slider_section_option != 'hide' ) {

    $nexas_slider_section_cat_id = nexas_get_option('nexas_slider_cat_id');

    $nexas_get_started_text      = nexas_get_option('nexas_slider_get_started_txt');

    $nexas_get_started_text_link = nexas_get_option('nexas_slider_get_started_link');

    $nexas_slider_category       = get_category($nexas_slider_section_cat_id);
  
    if(!empty($nexas_slider_section_cat_id))
  
    {
      $count        = $nexas_slider_category->category_count;
      $no_of_slider = nexas_get_option('nexas_no_of_slider');
    
    if ($count > 0 && $no_of_slider > 0) {
    
        ?>
        <section id="slider" class="slider">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Carousel indicators -->
                <ol class="carousel-indicators">
                    <?php
                    if ($no_of_slider > 1) {

                        for ($i = 0; $i < $no_of_slider; $i++) {
                            ?>
                            <li data-target="#myCarousel" data-slide-to="<?php echo esc_attr($i); ?>"
                                class=" <?php if ($i == 0) {
                                    echo 'active';
                                } ?>">
                            </li>

                        <?php }
                    } ?>
                </ol>
                <!-- Wrapper for carousel items -->
                <div class="carousel-inner">
                    <!--1st item start-->
                    <?php
                    $i = 0;
                    if (!empty($nexas_slider_section_cat_id)) {
                        $nexas_home_slider_section = array('cat' => $nexas_slider_section_cat_id, 'posts_per_page'                      => $no_of_slider);
                        $nexas_home_slider_section_query         = new WP_Query($nexas_home_slider_section);
                        if ($nexas_home_slider_section_query->have_posts()) {

                            while ($nexas_home_slider_section_query->have_posts()) {
                          
                                $nexas_home_slider_section_query->the_post();
                          
                                ?>
                          
                                <div class="item <?php if ($i == 0) {
                                    echo "active";
                                } ?>">
                          
                                    <?php if ( has_post_thumbnail() ) {
                                     
                                        $image_id = get_post_thumbnail_id();
                                     
                                        $image_url = wp_get_attachment_image_src($image_id, 'full', true); ?>
                                     
                                        <img src="<?php echo esc_url($image_url[0]); ?>" class="img-responsive" alt="<?php the_title_attribute(); ?>">
                                    <?php } ?>
                                    
                                        <div class="carousel-caption">
                                            <div class="container">
                                            <h1 class="color-white effect-1-2"><?php echo esc_html( wp_trim_words( get_the_title(), 4) ); ?></h1>
                                            <h3 class="color-white effect-1-1"><?php echo esc_html( wp_trim_words( get_the_content(), 10) ); ?> </h3>
                                        
                                            <?php
                                        
                                            if (!empty( $nexas_get_started_text ) ) {
                                                ?>
                                                <div class="effect-1-3">
                                                    <a href="<?php echo esc_url($nexas_get_started_text_link); ?>" class="btn btn-primary">
                                                        <?php echo esc_html( $nexas_get_started_text ) ?>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="clouds"></div>
                                    <div class="over-bg"></div>
                                </div>
                                <?php
                                $i++;
                            }
                        }
                        wp_reset_postdata();
                    }
                    ?>

                    <!--1st item end-->
                </div>
                <!-- Carousel controls -->

                <?php
                if ( $count > 1 && $no_of_slider > 1 ) {
                    
                    ?>
                    
                    <a class="carousel-control left" href="#myCarousel" data-slide="prev">
                        <span class="carousel-arrow">
                            <i class="fa fa-angle-left fa-2x"></i>
                        </span>
                    </a>
                    
                    <a class="carousel-control right" href="#myCarousel" data-slide="next">
                        <span class="carousel-arrow">
                            <i class="fa fa-angle-right fa-2x"></i>
                        </span>
                    </a>

                <?php } ?>
            </div>
        </section>
    <?php } }
} ?>