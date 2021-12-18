<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 1001 );
function theme_enqueue_styles() {
	etheme_child_styles();
}

add_action( 'wp_enqueue_scripts', 'enqueue_load_fa' );
function enqueue_load_fa() {
wp_enqueue_style( 'load-fa', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css' );
}

// Incluir Bootstrap CSS
function bootstrap_css() {
 wp_enqueue_style( 'bootstrap_css', 
       get_stylesheet_directory_uri() . '/css/bootstrap.min.css', 
       array(), 
       '4.1.3'
       ); 
}
add_action( 'wp_enqueue_scripts', 'bootstrap_css');

// Incluir Bootstrap JS
function bootstrap_js() {
 wp_enqueue_script( 'bootstrap_js', 
       get_stylesheet_directory_uri() . '/js/bootstrap.min.js', 
       array('jquery'), 
       '4.1.3', 
       true); 
}
add_action( 'wp_enqueue_scripts', 'bootstrap_js');



