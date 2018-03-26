<?php
if (!class_exists( 'Nexas_Welcome_Msg_Widget' ) ) {
    
    class Nexas_Welcome_Msg_Widget extends WP_Widget
    
    {
        private function defaults()
        {
            $defaults             = array(
                'page_id'         => 0,
                'character_limit' => 25
            );

            return $defaults;
        }

        public function __construct()
        {
            parent::__construct(
                'nexas-welcome-msg-widget',
                esc_html__( 'Nexas Welcome Message', 'nexas' ),
                array( 'description' => esc_html__( 'Nexas Welcome Message', 'nexas' ) )
            );
        }

        public function widget( $args, $instance )
        {

            if ( !empty( $instance ) ) {
                $instance        = wp_parse_args( (array )$instance, $this->defaults() );
                $page_id         = absint($instance['page_id']);
                $limit_character = absint( $instance['character_limit'] );
                echo $args['before_widget'];
                if ( !empty( $page_id ) ) {
                    $nexas_page_args     = array(
                        'page_id'        => $page_id,
                        'posts_per_page' => 1,
                        'post_type'      => 'page',
                        'no_found_rows'  => true,
                        'post_status'    => 'publish'
                    );

                  $welcome_query = new WP_Query( $nexas_page_args );
                    if ($welcome_query->have_posts()):
                        while ($welcome_query->have_posts()):$welcome_query->the_post(); ?>
                            <section id="section2">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="section-2-box-left section-margine">
                                                <div class="sec-title">
                                                    <h5><?php esc_html_e( 'About Nexas','nexas' ) ?></h5>
                                                    <h4><?php the_title(); ?></h4>
                                                    <div class="border left"></div>
                                                </div>
                                                <p><?php echo esc_html( wp_trim_words(get_the_content(), $limit_character)); ?></p>
                                                <a href="<?php echo get_permalink(); ?>" class="btn btn-primary">Read More</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="section-2-box-right text-center">
                                                <?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <?php
                        endwhile;
                    endif;
                    wp_reset_postdata();
                    echo $args['after_widget'];
                }
            }
        }

        public function update( $new_instance, $old_instance )
        {
            $instance                    = $old_instance;
            $instance['page_id']         = absint($new_instance['page_id']);
            $instance['character_limit'] = absint( $new_instance['character_limit'] );

            return $instance;
        }

        public function form( $instance )
        
        {
            $instance        = wp_parse_args((array )$instance, $this->defaults() );
            $page_id         = absint($instance['page_id']);
            $limit_character = absint( $instance['character_limit'] );
            ?>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('page_id')); ?>"><?php esc_html_e('Select Page', 'nexas'); ?></label><br/>

                <?php
                /* see more here https://codex.wordpress.org/Function_Reference/wp_dropdown_pages*/
                $args = array(
                    'selected'         => $page_id,
                    'name'             => esc_attr( $this->get_field_name('page_id') ),
                    'id'               => esc_attr( $this->get_field_id('page_id') ),
                    'class'            => 'widefat',
                    'show_option_none' => esc_html__( 'Select Page', 'nexas' ),
                );
                wp_dropdown_pages($args);
                ?>
            </p>
            <hr>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('character_limit')); ?>"><?php esc_html_e('Character Limit', 'nexas'); ?></label><br/>
                <input type="number" name="<?php echo esc_attr( $this->get_field_name('character_limit')); ?>" class="nexas-cons" id="<?php echo esc_attr($this->get_field_id('character_limit')); ?>" value="<?php echo $limit_character ?>">
            </p>
            <?php
        }
    }

}

add_action( 'widgets_init', 'nexas_welcome_msg_widget' );

function nexas_welcome_msg_widget()
{
    register_widget( 'Nexas_Welcome_Msg_Widget' );

}