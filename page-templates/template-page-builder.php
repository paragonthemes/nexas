<?php
/**
 * Template Name: Page Builder By Site Origin 
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package Paragon Themes
 * @subpackage Nexas
 */
get_header();

while ( have_posts() ) : the_post();

    the_content();

endwhile; // End of the loop.

get_footer();