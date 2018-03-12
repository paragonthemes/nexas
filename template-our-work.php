<?php
/**
 * The template for displaying all pages
 * Template Name: Our Work
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Paragon Themes
 * @subpackage Nexas
 */
get_header();

$nexas_breadcrump_option = nexas_get_option('nexas_breadcrumb_setting_option')?>

<section id="inner-title" class="inner-title"  <?php echo $header_style; ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-8"><h2><?php the_title(); ?></h2>
            </div>
              <?php do_action('breadcrumb_setting_option'); ?>
        </div>
    </div>
</section>

<?php

if ( is_active_sidebar('nexas-our-work-page' ) ) {
    
    dynamic_sidebar('nexas-our-work-page');
}

get_footer();
