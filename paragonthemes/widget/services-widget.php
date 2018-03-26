<?php
if( !class_exists( 'Nexas_Services_Widget' ) ){
    
    class Nexas_Services_Widget extends WP_Widget
    
    {

        private function defaults()
        {

            $defaults    = array(
                'cat_id' => 0,
                'title'     => esc_html__('Our Services','nexas'),
                'sub_title' => esc_html__('Check Our All Services','nexas')
            );
            return $defaults;
        }

        public function __construct()
        
        {
            parent::__construct(
                'nexas-service-widget',
                esc_html__( 'Nexas Service Widget', 'nexas' ),
                array( 'description' => esc_html__( 'Nexas Service Section', 'nexas' ) )
            );
        }

        public function widget( $args, $instance )
        {

            if (!empty( $instance ) ) {
                $instance = wp_parse_args( (array ) $instance, $this->defaults ());
                echo $args['before_widget'];
                $title        = apply_filters('widget_title', !empty($instance['title']) ? esc_html( $instance['title']): '', $instance, $this->id_base);
                $subtitle     =  esc_html( $instance['sub_title'] );
                $catid        = absint( $instance['cat_id'] );
                ?>
           
                <section id="section4" class="section-margine section-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 text-center">
                                <div class="section-title">                               
                                    <?php
                                
                                    if ( !empty ( $title ) ) {
                                        
                                        ?>
                                        <h2><?php echo $args['before_title'] . $title . $args['after_title']; ?></h2>
                                        <hr>

                                    <?php }

                                    if ( !empty( $subtitle ) )
                                        
                                     {
                                        ?>
                                        <h6><?php echo $subtitle; ?></h6>
                                    
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <?php
                                    
                                    $idvalue = array();
                                    
                                    if ( !empty( $catid ) ) {
                                        $i      = 0;
                                        $sticky = get_option( 'sticky_posts' );
                                        $home_services_section = array(
                                            'cat'                 => $catid,
                                            'posts_per_page'      => 6,
                                            'ignore_sticky_posts' => true,
                                            'post__not_in'        => $sticky,
                                            'order'               => 'ASC'
                                        );
                                        $home_services_section_query = new WP_Query( $home_services_section );
                                       
                                        if ( $home_services_section_query->have_posts() ) {
                                           
                                            while ($home_services_section_query->have_posts() ) {

                                                $home_services_section_query->the_post();
                                                
                                                $icon = get_post_meta( get_the_ID(), 'nexas_icon', true );
                                                
                                                $idvalue[] = get_the_ID();
                                                
                                                ?>

                                                <div class="col-md-4">
                                                    <div class="section-4-box wow fadeIn"
                                                         data-wow-delay=".<?php echo esc_attr($i); ?>s">
                                                        <div class="section-4-box-icon-cont">
                                                            <i class="fa <?php echo esc_attr($icon); ?> fa-3x"></i>
                                                        </div>
                                                        <div class="section-4-box-text-cont">
                                                            <a href="<?php the_permalink();?>"><h5><?php the_title(); ?></h5></a>
                                                            <p><?php echo esc_html( wp_trim_words( get_the_content(), 16) ); ?></p>
                                                        </div>
                                                    </div>
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

        public function update($new_instance, $old_instance)
        {
            $instance           = $old_instance;
            $instance['title'] = ( isset( $new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
            $instance['sub_title'] = ( isset( $new_instance['sub_title'])) ? sanitize_text_field($new_instance['sub_title']) : '';
            $instance['cat_id'] = ( isset( $new_instance['cat_id'])) ? absint($new_instance['cat_id']) : '';
            return $instance;

        }

        public function form($instance)
        {
            $instance = wp_parse_args( (array ) $instance, $this->defaults() );
            $title = esc_attr( $instance['title'] );
            $subtitle =  esc_attr( $instance['sub_title'] );
            $catid    = absint( $instance['cat_id'] );
            ?>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php esc_html_e('Title', 'nexas'); ?>
                </label><br/>
                <input type="text" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title') ); ?>" value="<?php echo $title; ?>">
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('sub_title') ); ?>">
                    <?php esc_html_e( 'Sub Title', 'nexas'); ?>
                </label><br/>
                <input type="text" name="<?php echo esc_attr($this->get_field_name('sub_title')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('sub_title')); ?>" value="<?php echo $subtitle; ?>">
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('cat_id') ); ?>">
                    <?php esc_html_e( 'Select Category', 'nexas'); ?>
                </label><br />
                <?php
                $nexas_dropown_cat = array(
                    'show_option_none' => esc_html__('Select Category', 'nexas'),
                    'orderby'          => 'name',
                    'order'            => 'asc',
                    'show_count'       => 1,
                    'hide_empty'       => 1,
                    'echo'             => 1,
                    'selected'         => $catid,
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
            <?php
        }
    }
}


add_action( 'widgets_init', 'nexas_service_widget' );

function nexas_service_widget() {
    
    register_widget( 'Nexas_Services_Widget' );
}