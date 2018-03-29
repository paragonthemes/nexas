<?php
/**
 * Class for adding Our Features Section Widget
 *
 * @package Paragon Themes
 * @subpackage Nexas
 * @since 1.0.0
 */
if( !class_exists( 'Nexas_Feature_Widget') ){

    class Nexas_Feature_Widget extends WP_Widget
    {
        private function defaults()
        {
            /*defaults values for fields*/
            $defaults = array(
                 'features_page_items' => '',
                 'features_title' => esc_html__('CORE FEATURES', 'nexas'),
                 'features_background' => ''
            );
            return $defaults;
        }

        public function __construct()
        
        {
            parent::__construct(
                /*Base ID of your widget*/
                'nexas-feature-widget',
                /*Widget name will appear in UI*/
                 esc_html__('Nexas Feature Widget', 'nexas'),
                 /*Widget description*/
                 array('description' => esc_html__('Nexas Feature Section', 'nexas'))
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
            if ( !empty( $instance ) ) 
             {
                $instance = wp_parse_args( (array) $instance, $this->defaults() );
                /*default values*/
             
                $features_title = apply_filters( 'widget_title', !empty( $instance['features_title'] ) ? esc_html( $instance['features_title'] ) : '', $instance, $this->id_base);
                $features_page_items    = $instance['features_page_items'];
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
                                            <div class="border left"></div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                                          <?php
                        $post_in = array();
                        if  (count($features_page_items) > 0 && is_array($features_page_items) ){
                            foreach ( $features_page_items as $features ){
                                if( isset( $features['page_id'] ) && !empty( $features['page_id'] ) ){
                                    $post_in[] = $features['page_id'];
                                }
                            }
                        }
                        if( !empty( $post_in )) :
                            $features_page_args = array(
                                    'post__in'         => $post_in,
                                    'orderby'             => 'post__in',
                                    'posts_per_page'      => count( $post_in ),
                                    'post_type'           => 'page',
                                    'no_found_rows'       => true,
                                    'post_status'         => 'publish'
                            );
                            $features_query = new WP_Query( $features_page_args );

                            /*The Loop*/
                            if ( $features_query->have_posts() ):
                                $i = 1;
                                while ( $features_query->have_posts() ):$features_query->the_post();
                                                
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
        public function update( $new_instance, $old_instance )
         {
            $instance           = $old_instance;
            
            $instance['features_title'] = (isset($new_instance['features_title'])) ? sanitize_text_field( $new_instance['features_title'] ) : '';
            $instance['features_background'] = esc_url_raw($new_instance['features_background']);

            /*updated code*/
            $page_ids = array();
            if( isset($new_instance['features_page_items'] )){
                $features_page_items    = $new_instance['features_page_items'];
                if  (count($features_page_items) > 0 && is_array($features_page_items) ){
                    foreach ($features_page_items as $key=>$about ){
                        $page_ids[$key]['page_id'] = absint( $about['page_id'] );
                    }
                }
            }
            $instance['features_page_items'] = $page_ids;

            return $instance;

        }
        /*Widget Backend*/
        public function form( $instance )
        {
            $instance           = wp_parse_args( (array) $instance, $this->defaults() );
            /*default values*/
             $features_page_items      = $instance['features_page_items'];
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
                <!--updated code-->
            <label><?php _e( 'Select Pages', 'nexas' ); ?>:</label>
            <br/>
            <small><?php _e( 'Add Page, Reorder and Remove. Please do not forget to add Icon and Excerpt  on selected pages.', 'nexas' ); ?></small>
            <div class="at-repeater">
                <?php
                $total_repeater = 0;
                if  (count($features_page_items) > 0 && is_array($features_page_items) ){
                    foreach ($features_page_items as $about){
                        $repeater_id  = $this->get_field_id( 'features_page_items') .$total_repeater.'page_id';
                        $repeater_name  = $this->get_field_name( 'features_page_items' ).'['.$total_repeater.']['.'page_id'.']';
                        ?>
                        <div class="repeater-table">
                            <div class="at-repeater-top">
                                <div class="at-repeater-title-action">
                                    <button type="button" class="at-repeater-action">
                                        <span class="at-toggle-indicator" aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="at-repeater-title">
                                    <h3><?php _e( 'Select Item', 'nexas' )?><span class="in-at-repeater-title"></span></h3>
                                </div>
                            </div>
                            <div class='at-repeater-inside hidden'>
                                <?php
                                /* see more here https://codex.wordpress.org/Function_Reference/wp_dropdown_pages*/
                                $args = array(
                                    'selected'         => $about['page_id'],
                                    'name'             => $repeater_name,
                                    'id'               => $repeater_id,
                                    'class'            => 'widefat at-select',
                                    'show_option_none' => __( 'Select Page', 'nexas'),
                                    'option_none_value'     => 0 // string
                                );
                                wp_dropdown_pages( $args );
                                ?>
                                <div class="at-repeater-control-actions">
                                    <button type="button" class="button-link button-link-delete at-repeater-remove"><?php _e('Remove','nexas');?></button> |
                                    <button type="button" class="button-link at-repeater-close"><?php _e('Close','nexas');?></button>
                                    <?php
                                    if( get_edit_post_link( $about['page_id'] ) ){
                                        ?>
                                        <a class="button button-link at-postid alignright" target="_blank" href="<?php echo esc_url( get_edit_post_link( $about['page_id'] ) ); ?>">
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
                $repeater_id  = $this->get_field_id( 'features_page_items') .$coder_repeater_depth.'page_id';
                $repeater_name  = $this->get_field_name( 'features_page_items' ).'['.$coder_repeater_depth.']['.'page_id'.']';
                ?>
                <script type="text/html" class="at-code-for-repeater">
                    <div class="repeater-table">
                        <div class="at-repeater-top">
                            <div class="at-repeater-title-action">
                                <button type="button" class="at-repeater-action">
                                    <span class="at-toggle-indicator" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="at-repeater-title">
                                <h3><?php _e( 'Select Item', 'nexas' )?><span class="in-at-repeater-title"></span></h3>
                            </div>
                        </div>
                        <div class='at-repeater-inside hidden'>
                            <?php
                            /* see more here https://codex.wordpress.org/Function_Reference/wp_dropdown_pages*/
                            $args = array(
                                'selected'         => '',
                                'name'             => $repeater_name,
                                'id'               => $repeater_id,
                                'class'            => 'widefat at-select',
                                'show_option_none' => __( 'Select Page', 'nexas'),
                                'option_none_value'     => 0 // string
                            );
                            wp_dropdown_pages( $args );
                            ?>
                            <div class="at-repeater-control-actions">
                                <button type="button" class="button-link button-link-delete at-repeater-remove"><?php _e('Remove','nexas');?></button> |
                                <button type="button" class="button-link at-repeater-close"><?php _e('Close','nexas');?></button>
                            </div>
                        </div>
                    </div>

                </script>
                <?php
                /*most imp for repeater*/
                echo '<input class="at-total-repeater" type="hidden" value="'.$total_repeater.'">';
                $add_field = __('Add Item', 'nexas');
                echo '<span class="button-primary at-add-repeater" id="'.$coder_repeater_depth.'">'.$add_field.'</span><br/>';
                ?>
            </div>
            <!--updated code-->
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










