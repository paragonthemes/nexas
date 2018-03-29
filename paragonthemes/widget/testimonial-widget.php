<?php
/**
 * Class for adding Our Testimonials Section Widget
 *
 * @package Paragon Themes
 * @subpackage Nexas
 * @since 1.0.0
 */
if ( !class_exists( 'Nexas_Testimonial_Widget' ) ) {
class Nexas_Testimonial_Widget extends WP_Widget

{

private function defaults()

{

$defaults = array(
'testimonials_page_items' => '',
'bg_image' => '',
);

return $defaults;
}

public function __construct()

{
parent::__construct(
'nexas-testimonial-widget',
esc_html__( 'Nexas Testimonial Widget', 'nexas' ),
array('description' => esc_html__( 'Nexas Testimonial Section', 'nexas' ) )
);
}

public function widget($args, $instance)

{

if (!empty($instance)) {
$instance = wp_parse_args((array )$instance, $this->defaults());
$testimonials_page_items    = $instance['testimonials_page_items'];
$bg_image  = esc_url($instance['bg_image']);
echo $args['before_widget'];

    ?>
    <section id="section8" class="section-8 testimonials" style="background: url(<?php echo $bg_image; ?>) no-repeat center;">
        
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
                        if  (count($testimonials_page_items) > 0 && is_array($testimonials_page_items) ){
                            foreach ( $testimonials_page_items as $features ){
                                if( isset( $features['page_id'] ) && !empty( $features['page_id'] ) ){
                                    $post_in[] = $features['page_id'];
                                }
                            }
                        }
                        if( !empty( $post_in )) :
                            $testimonials_page_args = array(
                                    'post__in'         => $post_in,
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
                        if ($post_in > 1) {
                            ?>
                            <!-- Carousel Buttons Next/Prev -->
                            <div class="c-control-outer">
                                <div class="c-control">
                                    <a data-slide="prev" href="#quote-carousel" class="left carousel-control">
                                        <i class="fa fa-angle-left"></i></a>
                                    <a data-slide="next" href="#quote-carousel" class="right carousel-control">
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
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
$instance             = $old_instance;
$instance['bg_image'] = esc_url_raw($new_instance['bg_image']);

/*updated code*/
            $page_ids = array();
            if( isset($new_instance['testimonials_page_items'] )){
                $testimonials_page_items    = $new_instance['testimonials_page_items'];
                if  (count($testimonials_page_items) > 0 && is_array($testimonials_page_items) ){
                    foreach ($testimonials_page_items as $key=>$about ){
                        $page_ids[$key]['page_id'] = absint( $about['page_id'] );
                    }
                }
            }
            $instance['testimonials_page_items'] = $page_ids;
return $instance;
}

public function form( $instance )
{
$instance  = wp_parse_args( (array )$instance, $this->defaults() );
$testimonials_page_items      = $instance['testimonials_page_items'];
$bgimage   = esc_url( $instance['bg_image'] );
?>

<p>
<!--updated code-->
            <label><?php _e( 'Select Pages', 'nexas' ); ?>:</label>
            <br/>
            <small><?php _e( 'Add Page, Reorder and Remove. Please do not forget to add Icon and Excerpt  on selected pages.', 'nexas' ); ?></small>
            <div class="at-repeater">
                <?php
                $total_repeater = 0;
                if  (count($testimonials_page_items) > 0 && is_array($testimonials_page_items) ){
                    foreach ($testimonials_page_items as $about){
                        $repeater_id  = $this->get_field_id( 'testimonials_page_items') .$total_repeater.'page_id';
                        $repeater_name  = $this->get_field_name( 'testimonials_page_items' ).'['.$total_repeater.']['.'page_id'.']';
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
                $repeater_id  = $this->get_field_id( 'testimonials_page_items') .$coder_repeater_depth.'page_id';
                $repeater_name  = $this->get_field_name( 'testimonials_page_items' ).'['.$coder_repeater_depth.']['.'page_id'.']';
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