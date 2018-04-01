<?php
/**
 * Class for adding Our Team Section Widget
 *
 * @package Paragon Themes
 * @subpackage Nexas
 * @since 1.0.0
 */
if ( ! class_exists( 'Nexas_Our_Team_Widget' ) ) {

	class Nexas_Our_Team_Widget extends WP_Widget {
		/*defaults values for fields*/
		private $defaults = array(
		
			'title'             => '',
			'sub_title'         => '',
			'nexas_page_items' => '',
			
		);

		function __construct() {
			parent::__construct(
			/*Base ID of your widget*/
				'nexas_our_team_widget',
				/*Widget name will appear in UI*/
				__( 'Nexas Team Section', 'nexas' ),
				/*Widget description*/
				array( 'description' => __( 'Nexas Our Team Section With Repeater.', 'nexas' ), )
			);
		}

		/*Widget Backend*/
		public function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );
			/*default values*/
			$title                  = esc_attr( $instance['title'] );
			$sub_title              = esc_attr( $instance['sub_title'] );
            $nexas_page_items      = $instance['nexas_page_items'];
		
			?>
           
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'nexas' ); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>"/>
            </p>

             <p>
                <label for="<?php echo $this->get_field_id( 'sub_title' ); ?>"><?php _e( 'Sub Title', 'nexas' ); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'sub_title' ); ?>" name="<?php echo $this->get_field_name( 'sub_title' ); ?>" type="text" value="<?php echo $sub_title; ?>"/>
            </p>

            <!--updated code-->
            <label><?php _e( 'Select Pages', 'nexas' ); ?>:</label>
            <br/>
            <small><?php _e( 'Add Page, Reorder and Remove. Please do not forget to add Icon and Excerpt  on selected pages.', 'nexas' ); ?></small>
            <div class="pt-repeater">
				<?php
				$total_repeater = 0;
				if  (count($nexas_page_items) > 0 && is_array($nexas_page_items) ){
					foreach ($nexas_page_items as $about){
						$repeater_id  = $this->get_field_id( 'nexas_page_items') .$total_repeater.'page_id';
						$repeater_name  = $this->get_field_name( 'nexas_page_items' ).'['.$total_repeater.']['.'page_id'.']';
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
				$repeater_id  = $this->get_field_id( 'nexas_page_items') .$coder_repeater_depth.'page_id';
				$repeater_name  = $this->get_field_name( 'nexas_page_items' ).'['.$coder_repeater_depth.']['.'page_id'.']';
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
           
			<?php
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
		public function update( $new_instance, $old_instance ) {
			$instance                  = $old_instance;
		
			$instance['title']         = sanitize_text_field( $new_instance['title'] );

			$instance['sub_title']         = sanitize_text_field( $new_instance['sub_title'] );

			/*updated code*/
			$page_ids = array();
			if( isset($new_instance['nexas_page_items'] )){
				$nexas_page_items    = $new_instance['nexas_page_items'];
				if  (count($nexas_page_items) > 0 && is_array($nexas_page_items) ){
					foreach ($nexas_page_items as $key=>$about ){
						$page_ids[$key]['page_id'] = absint( $about['page_id'] );
					}
				}
            }
			$instance['nexas_page_items'] = $page_ids;
			
			return $instance;
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
		public function widget( $args, $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );
			/*default values*/
			
			$title         = apply_filters( 'widget_title', ! empty( $instance['title'] ) ? $instance['title'] : '', $instance, $this->id_base );

			$sub_title         = apply_filters( 'widget_title', ! empty( $instance['sub_title'] ) ? $instance['sub_title'] : '', $instance, $this->id_base );
			
            $nexas_page_items    = $instance['nexas_page_items'];
           

            echo $args['before_widget'];
			?>

             <section id="section14" class="section-margine section14">
                    
                    <div class="container">
                    
                        <div class="row">
                    
                            <div class="col-md-12">
                    
                                <div class="section-title">
                    
                                    <?php
                    
                                    if ( !empty ( $title ) ) {
                                        
                                        ?>
                                        <h2><?php echo $args['before_title'] . $title . $args['after_title']; ?></h2>
                                        <hr>

                                    <?php }

                                    if ( !empty( $sub_title ) )
                                        
                                     {
                                        ?>
                                        <h6><?php echo $sub_title; ?></h6>
                                    
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    <div class="row">
                      <?php
						$post_in = array();
						if  (count($nexas_page_items) > 0 && is_array($nexas_page_items) ){
							foreach ( $nexas_page_items as $our_team ){
								if( isset( $our_team['page_id'] ) && !empty( $our_team['page_id'] ) ){
									$post_in[] = $our_team['page_id'];
								}
							}
						}
						if( !empty( $post_in )) :
                            $our_team_page_args = array(
                                    'post__in'         => $post_in,
                                    'orderby'             => 'post__in',
                                    'posts_per_page'      => count( $post_in ),
                                    'post_type'           => 'page',
                                    'no_found_rows'       => true,
                                    'post_status'         => 'publish'
                            );
							$our_team_query = new WP_Query( $our_team_page_args );

							/*The Loop*/
							if ( $our_team_query->have_posts() ):
								$i = 1;
								while ( $our_team_query->have_posts() ):$our_team_query->the_post();
									?>
	                            <div class="col-md-4">
	                                <div class="section-14-box blog-box wow fadeInUp <?php if ( !has_post_thumbnail() ) {
	                                    echo "no-image";
	                                } ?> " data-wow-delay="<?php echo esc_attr($i); ?>s">

	                                    <?php
	                                    
	                                    if (has_post_thumbnail()) {
	                                    
	                                        $image_id = get_post_thumbnail_id();
	                                    
	                                        $image_url = wp_get_attachment_image_src($image_id, 'full', true);
	                                        ?>
	                                        <img src="<?php echo esc_url($image_url[0]); ?>" class="img-responsive">
	                                    <?php }
	                                    ?>
	                                    <div class="entry-box">
	                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	                                      
	                                        <p><?php echo esc_html( wp_trim_words( get_the_content(), 20 ) ); ?></p>
	                                        <?php if(!empty($read_more)){ ?>
	                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
	                                            <?php echo esc_html($read_more); ?>
	                                        </a>
	                                        <?php } ?>
	                                    </div>
	                                </div>
	                            </div>
	                             <?php
	                            $i++;
	                              
                             	endwhile;
							endif;
							wp_reset_postdata();
						  endif;
                            ?>
                        </div>
                    </div>
             </section>


            
			<?php
			echo $args['after_widget'];
		}
	}
}


add_action( 'widgets_init', 'nexas_our_team_widget' );

function nexas_our_team_widget()
{
    register_widget( 'Nexas_Our_Team_Widget' );

}