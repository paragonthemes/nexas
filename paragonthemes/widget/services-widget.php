<?php
/**
 * Class for adding Our Services Section Widget
 *
 * @package Paragon Themes
 * @subpackage Nexas
 * @since 1.0.0
 */
if( !class_exists( 'Nexas_Services_Widget' ) ){
    
    class Nexas_Services_Widget extends WP_Widget
    
    {

        private function defaults()
        {
            /*defaults values for fields*/
            $defaults    = array(
                'services_page_items' => '',
                'title'               => esc_html__('Our Services','nexas'),
                'sub_title'           => esc_html__('Check Our All Services','nexas')
            );
            return $defaults;
        }

        public function __construct()
        
        {
            parent::__construct(
                /*Base ID of your widget*/
                'nexas-service-widget',
                /*Widget name will appear in UI*/
                esc_html__( 'Nexas Service Widget', 'nexas' ),
                /*Widget description*/
                array( 'description' => esc_html__( 'Nexas Service Section', 'nexas' ) )
            );
        }
        /**
         * Function to Creating widget front-end. This is where the action happens
         *
         * @access public
         * @since 1.0
         *
         * @param array $args widget setting
         * @param array $instance saved values
         *
         * @return void
         *
         */
        public function widget( $args, $instance )
        {

            if (!empty( $instance ) ) {
                $instance = wp_parse_args( (array ) $instance, $this->defaults ());
                $title        = apply_filters('widget_title', !empty($instance['title']) ? esc_html( $instance['title']): '', $instance, $this->id_base);
                $subtitle     =  esc_html( $instance['sub_title'] );
                $services_page_items    = $instance['services_page_items'];   

                echo $args['before_widget'];
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
                        $post_in = array();
                        if  (count($services_page_items) > 0 && is_array($services_page_items) ){
                            foreach ( $services_page_items as $features ){
                                if( isset( $features['page_id'] ) && !empty( $features['page_id'] ) ){
                                    $post_in[] = $features['page_id'];
                                }
                            }
                        }
                        if( !empty( $post_in )) :
                            $services_page_args = array(
                                    'post__in'         => $post_in,
                                    'orderby'             => 'post__in',
                                    'posts_per_page'      => count( $post_in ),
                                    'post_type'           => 'page',
                                    'no_found_rows'       => true,
                                    'post_status'         => 'publish'
                            );
                            $services_query = new WP_Query( $services_page_args );

                            /*The Loop*/
                            if ( $services_query->have_posts() ):
                                $i = 1;
                                while ( $services_query->have_posts() ):$services_query->the_post();
                                                
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
                                                    endwhile;
                                                endif;
                                                wp_reset_postdata();
                                              endif;
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
        /**
         * Function to Updating widget replacing old instances with new
         *
         * @access public
         * @since 1.0
         *
         * @param array $new_instance new arrays value
         * @param array $old_instance old arrays value
         *
         * @return array
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance              = $old_instance;
            $instance['title']     = ( isset( $new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
            $instance['sub_title'] = ( isset( $new_instance['sub_title'])) ? sanitize_text_field($new_instance['sub_title']) : '';
            
            /*updates the widget repeater value*/
            $page_ids = array();
            if( isset($new_instance['services_page_items'] )){
                $services_page_items    = $new_instance['services_page_items'];
                if  (count($services_page_items) > 0 && is_array($services_page_items) ){
                    foreach ($services_page_items as $key=>$about ){
                        $page_ids[$key]['page_id'] = absint( $about['page_id'] );
                    }
                }
            }
            $instance['services_page_items'] = $page_ids;

            return $instance;

        }

        public function form($instance)
        {
            $instance            = wp_parse_args( (array ) $instance, $this->defaults() );
            $title               = esc_attr( $instance['title'] );
            $subtitle            = esc_attr( $instance['sub_title'] );
            $services_page_items = $instance['services_page_items'];
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
                <!--updated code-->
            <label><?php _e( 'Select Pages', 'nexas' ); ?>:</label>
            <br/>
            <small><?php _e( 'Add Page, Reorder and Remove. Please do not forget to add Icon and Excerpt  on selected pages.', 'nexas' ); ?></small>
            <div class="pt-repeater">
                <?php
                $total_repeater = 0;
                if  (count($services_page_items) > 0 && is_array($services_page_items) ){
                    foreach ($services_page_items as $about){
                        $repeater_id   = $this->get_field_id( 'services_page_items') .$total_repeater.'page_id';
                        $repeater_name = $this->get_field_name( 'services_page_items' ).'['.$total_repeater.']['.'page_id'.']';
                        ?>
                        <div class="repeater-table">
                            <div class="pt-repeater-top">
                                <div class="pt-repeater-title-action">
                                    <button type="button" class="pt-repeater-action">
                                        <span class="pt-toggle-indicator" aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="pt-repeater-title">
                                    <h3><?php _e( 'Select Item', 'nexas' )?><span class="in-pt-repeater-title"></span></h3>
                                </div>
                            </div>
                            <div class='pt-repeater-inside hidden'>
                                <?php
                                /* see more here https://codex.wordpress.org/Function_Reference/wp_dropdown_pages*/
                                $args = array(
                                    'selected'         => $about['page_id'],
                                    'name'             => $repeater_name,
                                    'id'               => $repeater_id,
                                    'class'            => 'widefat pt-select',
                                    'show_option_none' => __( 'Select Page', 'nexas'),
                                    'option_none_value'     => 0 // string
                                );
                                wp_dropdown_pages( $args );
                                ?>
                                <div class="pt-repeater-control-actions">
                                    <button type="button" class="button-link button-link-delete pt-repeater-remove"><?php _e('Remove','nexas');?></button> |
                                    <button type="button" class="button-link pt-repeater-close"><?php _e('Close','nexas');?></button>
                                    <?php
                                    if( get_edit_post_link( $about['page_id'] ) ){
                                        ?>
                                        <a class="button button-link pt-postid alignright" target="_blank" href="<?php echo esc_url( get_edit_post_link( $about['page_id'] ) ); ?>">
                                            <?php _e('Full Edit','nexas');?>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $total_repeater = $total_repeater + 1;
                    }
                }
                $coder_repeater_depth = 'coderRepeaterDepth_'.'0';
                $repeater_id  = $this->get_field_id( 'services_page_items') .$coder_repeater_depth.'page_id';
                $repeater_name  = $this->get_field_name( 'services_page_items' ).'['.$coder_repeater_depth.']['.'page_id'.']';
                ?>
                <script type="text/html" class="pt-code-for-repeater">
                    <div class="repeater-table">
                        <div class="pt-repeater-top">
                            <div class="pt-repeater-title-action">
                                <button type="button" class="pt-repeater-action">
                                    <span class="pt-toggle-indicator" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="pt-repeater-title">
                                <h3><?php _e( 'Select Item', 'nexas' )?><span class="in-pt-repeater-title"></span></h3>
                            </div>
                        </div>
                        <div class='pt-repeater-inside hidden'>
                            <?php
                            /* see more here https://codex.wordpress.org/Function_Reference/wp_dropdown_pages*/
                            $args = array(
                                'selected'         => '',
                                'name'             => $repeater_name,
                                'id'               => $repeater_id,
                                'class'            => 'widefat pt-select',
                                'show_option_none' => __( 'Select Page', 'nexas'),
                                'option_none_value'     => 0 // string
                            );
                            wp_dropdown_pages( $args );
                            ?>
                            <div class="pt-repeater-control-actions">
                                <button type="button" class="button-link button-link-delete pt-repeater-remove"><?php _e('Remove','nexas');?></button> |
                                <button type="button" class="button-link pt-repeater-close"><?php _e('Close','nexas');?></button>
                            </div>
                        </div>
                    </div>

                </script>
                <?php
                /*most imp for repeater*/
                echo '<input class="pt-total-repeater" type="hidden" value="'.$total_repeater.'">';
                $add_field = __('Add Item', 'nexas');
                echo '<span class="button-primary pt-add-repeater" id="'.$coder_repeater_depth.'">'.$add_field.'</span><br/>';
                ?>
            </div>
            <!--updated code-->
            </p>
            <?php
        }
    }
}


add_action( 'widgets_init', 'nexas_service_widget' );

function nexas_service_widget() {
    
    register_widget( 'Nexas_Services_Widget' );
}