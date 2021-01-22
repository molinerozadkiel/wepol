<?php

require_once 'inc/custom_posts.php';
require_once 'inc/form_handler.php';
require_once 'inc/new_ajax.php';

if(!is_admin()){
  require_once 'inc/multi_cards.php';
}

function lattte_setup(){
  wp_enqueue_style('style', get_stylesheet_uri(), NULL, microtime(), 'all');
	wp_enqueue_script('modules', get_theme_file_uri('/js/modules.js'), NULL, microtime(), true);



  // register our main script but do not enqueue it yet
  wp_register_script( 'main', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), NULL, microtime(), true );
  // now the most interesting part
  // we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
  // you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
  wp_localize_script( 'main', 'lt_data', array(
    'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
    'homeurl' => site_url(),
    'front_page' => is_front_page(),
  ) );

  wp_enqueue_script( 'main' );
}
add_action('wp_enqueue_scripts', 'lattte_setup');

// Adding Theme Support

function gp_init() {
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');
  add_theme_support('html5',
    array('comment-list', 'comment-form', 'search-form')
  );
  // add_theme_support( 'woocommerce' );
  // add_theme_support( 'wc-product-gallery-zoom' );
  // add_theme_support( 'wc-product-gallery-lightbox' );
  // add_theme_support( 'wc-product-gallery-slider' );
}
add_action('after_setup_theme', 'gp_init');


function standard_svg($id, $class) {
  $html='
  <svg class="' . $class . ' aria-hidden="true" focusable="false" role="img" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 50 50">
    <use xlink:href="#' . $id . '"></use>
  </svg>
  ';
  return $html;
}
















// this removes the "Archive" word from the archive title in the archive page
add_filter('get_the_archive_title',function($title){
  if(is_category()){$title=single_cat_title('',false);
  }elseif(is_tag()){$title=single_tag_title('',false);
  }elseif(is_author()){$title='<span class="vcard">'.get_the_author().'</span>';
  }return $title;
});






function excerpt($charNumber){
  if(!$charNumber){$charNumber=1000000;}
  $excerpt = get_the_excerpt();
  if(strlen($excerpt)<=$charNumber){return $excerpt;}else{
    $excerpt = substr($excerpt, 0, $charNumber);
    $result  = substr($excerpt, 0, strrpos($excerpt, ' '));
    // $result .= $result . '(...)';
    // return var_dump($excerpt);
    return $result;
  }
}









 function register_menus() {
   register_nav_menu('nav_bar',__( 'Header' ));
   // register_nav_menu('navBarMobile',__( 'Header Mobile' ));
   // register_nav_menu('contactMenu',__( 'Contact Menu' ));
   register_nav_menu('footer_info',__( 'Footer More Info' ));
   register_nav_menu('footer_support',__( 'Footer Support' ));
   // add_post_type_support( 'page', 'excerpt' );
 }
 add_action( 'init', 'register_menus' );
















//Second solution : two or more files.
//If you're using a child theme you could use:
// get_stylesheet_directory_uri() instead of get_template_directory_uri()
add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
function load_admin_styles() {
  // wp_enqueue_style( 'admin_css_foo', get_template_directory_uri() . '/css/backoffice.css', false, '1.0.0' );
}


















//estimated reading time
function reading_time() {
  $content = get_post_field( 'post_content', $post->ID );
  $word_count = str_word_count( strip_tags( $content ) );
  $words_per_minute = 200;
  $readingtime = ceil($word_count / $words_per_minute);
  return $readingtime;
}
