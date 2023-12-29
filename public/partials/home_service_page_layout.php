<?php 
get_header();


do_action('mk_home_service_before_page');

do_shortcode( "[render_home_service_page]" );

do_action('mk_home_service_after_page');

get_footer();