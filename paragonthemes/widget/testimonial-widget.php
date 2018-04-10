<?php
/**
* Class for adding Our Testimonials Section Widget
*
* @package Paragon Themes
* @subpackage Nexas
* @since 1.0.0
*/
if ( !class_exists( 'Nexas_Testimonial_Widget' ) ) 
{
    class Nexas_Testimonial_Widget extends WP_Widget

    {

        private function defaults()

        {

            $defaults = array(
            'bg_image' => '',
            'features'   =>'',
            );

            return $defaults;
        }

    public function __construct()

        {
            parent::__construct(
            'nexas_testimonial_widget',
            esc_html__( 'Nexas Testimonial Widget', 'nexas' ),
            array('description' => esc_html__( 'Nexas Testimonial Section', 'nexas' ) )
            );
        }

  
    public function widget($args, $instance)

        {

            if (!empty($instance)) 
            {
                $instance  = wp_parse_args((array )$instance, $this->defaults());

                $bg_image  = esc_url($instance['bg_image']);

                $features  = ( ! empty( $instance['features'] ) ) ? $instance['features'] : array();

                echo $args['before_widget'];

                ?>
                <section id="section8" class="section-8 testimonials" style="background: url(<?php echo $bg_image; ?>) no-repeat center;">
                    <?php if (isset($features) && !empty($features['main'])) : ?>    
                        <div class="overley section-margine">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-sm-offset-1">
                                        <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                                        <!-- Carousel Slides / Quotes -->
                                            <div class="carousel-inner">
                                            <!-- Quote 1 -->
                                            <?php
                                            $post_in = array();

                                            if  (count($features) > 0 && is_array($features) )
                                            {

                                                $post_in[0] = $features['main'];

                                                foreach ( $features as $our_testimonial )
                                                {

                                                    if( isset( $our_testimonial['page_ids'] ) && !empty( $our_testimonial['page_ids'] ) )
                                                    {

                                                      $post_in[] = $our_testimonial['page_ids'];

                                                    }
                                                }


                                            }

                                            if( !empty( $post_in )) :
                                            $testimonials_page_args = array(
                                            'post__in'            => $post_in,
                                            'orderby'             => 'post__in',
                                            'posts_per_page'      => count( $post_in ),
                                            'post_type'           => 'page',
                                            'no_found_rows'       => true,
                                            'post_status'         => 'publish'
                                            );
                                            $testimonials_query = new WP_Query( $testimonials_page_args );
                                            /*The Loop*/
                                            if ( $testimonials_query->have_posts() ):
                                                while ( $testimonials_query->have_posts() ):$testimonials_query->the_post(); ?>
                                                        <div class="item content text-center>">
                                                            <blockquote>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="avatar">
                                                                        <?php if (has_post_thumbnail()) {

                                                                                $image_id = get_post_thumbnail_id();

                                                                                $image_url = wp_get_attachment_image_src($image_id, 'full', true);
                                                                            ?>

                                                                                    <img class="img-responsive " src="<?php echo esc_url($image_url[0]); ?>" />
                                                                        <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 ">
                                                                        <div class="text">
                                                                             <?php the_excerpt(); ?>
                                                                        </div>
                                                                          <div class="author-name"><?php the_title(); ?></div>
                                                                            <ul class="rating">
                                                                                <li><i class="fa fa-star"></i></li>
                                                                                <li><i class="fa fa-star"></i></li>
                                                                                <li><i class="fa fa-star"></i></li>
                                                                                <li><i class="fa fa-star"></i></li>
                                                                                <li><i class="fa fa-star"></i></li>
                                                                            </ul>
                                                                    </div>
                                                                </div>
                                                            </blockquote>
                                                        </div>
                                                <?php
                                                endwhile;
                                            endif;
                                            wp_reset_postdata();
                                            endif;
                                            ?>
                                            </div>
                                        <?php
                                        if ($post_in > 1)
                                         {
                                        ?>
                                            <!-- Carousel Buttons Next/Prev -->
                                            <div class="c-control-outer">
                                                <div class="c-control">
                                                    <a data-slide="prev" href="#quote-carousel" class="left carousel-control">
                                                        <i class="fa fa-angle-left"></i>
                                                    </a>
                                                    <a data-slide="next" href="#quote-carousel" class="right carousel-control">
                                                    <i class="fa fa-angle-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php 
                                        } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>           
                </section>
                <?php
                echo $args['after_widget'];
            }
        }

    public function update( $new_instance, $old_instance )
    {
    $instance             = $old_instance;
    $instance['bg_image'] = esc_url_raw($new_instance['bg_image']);

    if (isset($new_instance['features']))

    {
        foreach($new_instance['features'] as $feature)
        {

         $feature['page_ids'] = absint($feature['page_ids']);
        
        }

         $instance['features'] = $new_instance['features'];
    }

    return $instance;

    }

    public function form( $instance )
    {
        $instance  = wp_parse_args( (array )$instance, $this->defaults() );
        $bgimage   = esc_url( $instance['bg_image'] );
        $features     = ( ! empty( $instance['features'] ) ) ? $instance['features'] : array(); 

        ?>
        <span class="pt-nexas-additional">

            <!--updated code-->
            <label><?php _e( 'Select Pages', 'nexas' ); ?>:</label>
            <br/>
            <small><?php _e( 'Add Page, Reorder and Remove. Please do not forget to add Icon and Excerpt  on selected pages.', 'nexas' ); ?></small>
            <?php

            if  ( count( $features ) >=  1 && is_array( $features ) )
            {

              $selected = $features['main'];

            }

            else
            {
                 $selected = "";
            }

            $repeater_id   = $this->get_field_id( 'features' ).'-main';
            $repeater_name = $this->get_field_name( 'features'). '[main]';

            $args = array(
            'selected'          => $selected,
            'name'              => $repeater_name,
            'id'                => $repeater_id,
            'class'             => 'widefat pt-select',
            'show_option_none'  => __( 'Select Page', 'nexas'),
            'option_none_value' => 0 // string
            );
            wp_dropdown_pages( $args );
           
            $counter = 0;
            if ( count( $features ) > 0 ) 
            {
                foreach( $features as $feature ) 
                {

                    if ( isset( $feature['page_ids'] ) ) 
                        { ?>
                            <div class="pt-nexas-sec">
                                <?php
                                $repeater_id     = $this->get_field_id( 'features' ) .'-'. $counter.'-page_ids';
                                $repeater_name   = $this->get_field_name( 'features' ) . '['.$counter.'][page_ids]';
                                $args = array(
                                'selected'          => $feature['page_ids'],
                                'name'              => $repeater_name,
                                'id'                => $repeater_id,
                                'class'             => 'widefat pt-select',
                                'show_option_none'  => __( 'Select Page', 'nexas'),
                                'option_none_value' => 0 // string
                                );
                                wp_dropdown_pages( $args );
                                ?>
                                <a class="pt-nexas-remove delete"><?php esc_html_e('Remove Section','nexas') ?></a>
                            </div>
                            <?php
                            $counter++;
                        }
                }
            }

            ?>

        </span>
        <a class="pt-nexas-add button"><?php _e('Add New Section'); ?></a>   
        <hr>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'bg_image' ) ); ?>">
            <?php esc_html_e( 'Background Image', 'nexas' ); ?>
            </label>
            <br/>
            <?php
            if (!empty($bgimage)) :
             echo '<img class="custom_media_image widefat" src="' . $bgimage . '"/><br />';
            endif;
            ?>
            <input type="text" class="widefat custom_media_url" name="<?php echo esc_attr($this->get_field_name('bg_image')); ?>" id="<?php echo esc_attr($this->get_field_id('bg_image')); ?>" value="<?php echo $bgimage; ?>"/>
            <input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo esc_attr($this->get_field_name('bg_image')); ?>" value="<?php esc_attr_e('Upload Image', 'nexas') ?>"/>
        </p>

        <?php
        }
        }

}

add_action( 'widgets_init', 'nexas_testimonial_widget' );

function nexas_testimonial_widget()
{
  register_widget( 'Nexas_Testimonial_Widget' );
}