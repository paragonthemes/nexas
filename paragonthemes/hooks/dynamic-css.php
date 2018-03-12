<?php
/**
 * Dynamic css
 *
 * @package Paragon Themes
 * @subpackage Nexas
 *
 * @param null
 * @return void
 *
 */

if ( !function_exists('nexas_dynamic_css') ):
    function nexas_dynamic_css(){

    $nexas_top_header_color    = esc_attr( nexas_get_option('nexas_top_header_background_color') );

    $nexas_top_footer_color    = esc_attr( nexas_get_option('nexas_top_footer_background_color') );

    $nexas_bottom_footer_color = esc_attr( nexas_get_option('nexas_bottom_footer_background_color') );

    $nexas_primary_color       = esc_attr( nexas_get_option('nexas_primary_color') );


    $custom_css                = '';


    /*====================Dynamic Css =====================*/
    
    $custom_css .= ".top-header{
         background-color: " . $nexas_top_header_color . ";}
    ";

    $custom_css .= ".footer-top{
         background-color: " . $nexas_top_footer_color . ";}
    ";

    $custom_css .= ".footer-bottom{
         background-color: " . $nexas_bottom_footer_color . ";}
    ";

    $custom_css .= ".section-0-background,
     .btn-primary,
     .section-1-box-icon-background,
     #quote-carousel a.carousel-control,
     .section-10-background,
     .footer-top .submit-bgcolor,
     .nav-links .nav-previous a, 
     .nav-links .nav-next a,
     .comments-area .submit,
     .inner-title,.woocommerce span.onsale,
     .woocommerce nav.woocommerce-pagination ul li a:focus,
     .woocommerce nav.woocommerce-pagination ul li a:hover,
     .woocommerce nav.woocommerce-pagination ul li span.current,
     .woocommerce a.button, .woocommerce #respond input#submit.alt, 
     .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt
      {
       background-color: " . $nexas_primary_color . ";}
    ";

    $custom_css .= ".section-4-box-icon-cont i,
    .btn-seconday,
    a:visited,
    .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > .active > a:hover

    {
        color: " . $nexas_primary_color . ";}
    ";

    $custom_css .= ".section-14-box .underline,
   .item blockquote img,
   .widget .widget-title,
   .btn-primary,
   #quote-carousel .carousel-control.left, 
   #quote-carousel .carousel-control.right,
   .woocommerce nav.woocommerce-pagination ul li a:focus,
   .woocommerce nav.woocommerce-pagination ul li a:hover,
   .woocommerce nav.woocommerce-pagination ul li span.current
   .woocommerce a.button, .woocommerce #respond input#submit.alt, 
   .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt
   {
       border-color: " . $nexas_primary_color . ";}
    ";
    /*------------------------------------------------------------------------------------------------- */

    /*custom css*/

    wp_add_inline_style('nexas-style', $custom_css);

}
endif;
//add_action('wp_enqueue_scripts', 'nexas_dynamic_css', 99);