<?php
if( !class_exists( 'Nexas_Feature_Widget') ){

    class Nexas_Feature_Widget extends WP_Widget
    {
        private function defaults()
        {
            $defaults = array(
                 'cat_id' => -1,
                 'features_title' => esc_html__('CORE FEATURES', 'nexas'),
                 'features_background' => ''
            );
            return $defaults;
        }

        public function __construct()
        
        {
            parent::__construct(
                'nexas-feature-widget',
                 esc_html__('Nexas Feature Widget', 'nexas'),
                 array('description' => esc_html__('Nexas Feature Section', 'nexas'))
            );
        }

        public function widget( $args, $instance )
        {
            if ( !empty( $instance ) ) 
             {
                $instance = wp_parse_args( (array) $instance, $this->defaults() );
                /*default values*/
             
                $features_title = apply_filters( 'widget_title', !empty( $instance['features_title'] ) ? esc_html( $instance['features_title'] ) : '', $instance, $this->id_base);
                $catid = absint( $instance[ 'cat_id' ] );
                $features_background  = esc_url($instance['features_background']);

                echo $args['before_widget'];
             
                ?>
                <section id="section1" class="section1">
                    <div class="container-fulid">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-xs-12">
                                <div class="item-holder" style="background: url(<?php echo $features_background; ?>);"> </div>                                        
                            </div>
                            <div class="col-lg-6 col-md-12 col-xs-12">
                                <div class="section-margine">
                                    <?php if(!empty($features_title)) { ?>
                                    <div class="feature-title">
                                        <div class="sec-title two">
                                            <h2><?php echo esc_html($features_title);?></h2>
                                            <hr>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if ( !empty( $catid ) ) {
                                        $i = 0;
                                        $sticky               = get_option( 'sticky_posts' );
                                        $home_feature_section = array(
                                            'ignore_sticky_posts' => true,
                                            'post__not_in'        => $sticky,
                                            'cat'                 => $catid,
                                            'posts_per_page'      => 3
                                        );
                                        $home_feature_section_query = new WP_Query( $home_feature_section );
                                        if ( $home_feature_section_query->have_posts() ) {

                                            while ($home_feature_section_query->have_posts())
                                             {
                                                
                                                $home_feature_section_query->the_post();
                                                
                                                $icon = get_post_meta( get_the_ID(), 'nexas_icon', true );
                                                
                                                ?>
                                                <div class="section-1-box" data-wow-delay=".<?php echo esc_attr($i); ?>">
                                                    <?php
                                                    if(!empty($icon))
                                                    {
                                                    ?>
                                                        <div class="section-1-box-icon-background">
                                                            <i class="fa <?php echo esc_attr($icon); ?>"></i>
                                                        </div>
                                                    <?php } ?>
                                              
                                                    <h4><?php the_title() ?></h4>
                                              
                                                    <p><?php echo esc_html( wp_trim_words( get_the_content(), 8) ); ?></p>
                                                </div>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        wp_reset_postdata();
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
                echo $args['after_widget'];
            }
        }

        public function update( $new_instance, $old_instance )
         {
            $instance           = $old_instance;
            $instance['cat_id'] = (isset($new_instance['cat_id'])) ? absint( $new_instance['cat_id'] ) : '';
            $instance['features_title'] = (isset($new_instance['features_title'])) ? sanitize_text_field( $new_instance['features_title'] ) : '';
            $instance['features_background'] = esc_url_raw($new_instance['features_background']);

            return $instance;

        }

        public function form( $instance )
        {
            $instance           = wp_parse_args( (array) $instance, $this->defaults() );
            /*default values*/
            $nexas_selected_cat = absint( $instance[ 'cat_id' ] );
            $nexas_features_title = esc_attr( $instance[ 'features_title' ] );
            $features_background   = esc_attr( $instance['features_background'] );
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('features_title')); ?>">
                    <?php esc_html_e('Title', 'nexas'); ?>
                </label><br/>
                <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'features_title') ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'features_title' ) ); ?>" value="<?php echo $nexas_features_title?>">
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'cat_id' ) ); ?>">
                    <?php esc_html_e( 'Select Category', 'nexas' ); ?>
                </label><br/>
                <?php

                $nexas_dropown_cat = array(
                    'show_option_none' => esc_html__('Select Category', 'nexas'),
                    'orderby'          => 'name',
                    'order'            => 'asc',
                    'show_count'       => 1,
                    'hide_empty'       => 1,
                    'echo'             => 1,
                    'selected'         => $nexas_selected_cat,
                    'hierarchical'     => 1,
                    'name'             => esc_attr( $this->get_field_name('cat_id') ),
                    'id'               => esc_attr( $this->get_field_name('cat_id') ),
                    'class'            => 'widefat',
                    'taxonomy'         => 'category',
                    'hide_if_empty'    => false,
                );
                wp_dropdown_categories( $nexas_dropown_cat );
                ?>
            </p>

            <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'features_background' ) ); ?>">
                <?php esc_html_e( 'Background Image', 'nexas' ); ?>
            </label>
            <br/>
            <?php
            if (!empty($features_background)) :
                echo '<img class="custom_media_image widefat" src="' . esc_url($features_background) . '"/><br />';
            endif;
            ?>
            <input type="text" class="widefat custom_media_url" name="<?php echo esc_attr($this->get_field_name('features_background')); ?>" id="<?php echo esc_attr($this->get_field_id('features_background')); ?>" value="<?php echo $features_background; ?>"/>
            <input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo esc_attr($this->get_field_name('features_background')); ?>" value="<?php esc_attr_e('Upload Image', 'nexas') ?>"/>
            </p>
            <?php
        }
    }
}

add_action( 'widgets_init', 'nexas_feature_widget' );
function nexas_feature_widget()
{
    register_widget( 'Nexas_Feature_Widget' );
}










