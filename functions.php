<?php

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) 
  $content_width = 320;

/**
 * Make Theme Check happy
 */
function themage_setup() {
	$background_args = array(
		'default-color' => 'ffffff',
	);
  add_editor_style();
  add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-header' );
  add_theme_support( 'custom-background', $background_args );
  add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
	register_nav_menus( array( 'primary' => 'Primary Menu' ) );
}
add_action( 'after_setup_theme', 'themage_setup' );


/**
 * Registers our main widget area and the front page widget areas.
 */
function themage_widgets_init() {
  register_sidebar( array(
    'name' => 'Main Sidebar',
    'id' => 'sidebar-1',
    'description' => 'Appears on posts and pages',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h2 class="widget-title">',
    'after_title' => '</h2>',
  ) );
}
add_action( 'widgets_init', 'themage_widgets_init' );

/**
 * Remove link to #print which is a non-existent id
 */
function themage_print_fix( $content )
{
  $new_content = str_replace(
    '#print"',
    '#"',
    $content
  );  

  return $new_content;
}
add_filter( 'the_content', 'themage_print_fix', 100 );

/**
 * Enqueue scripts 
 */
function themage_enqueue()
{
  if ( is_singular() && comments_open() ) 
		wp_enqueue_script( 'comment-reply' );

	// Load fonts
	$open_sans = array( 'family' => 'Open+Sans:400italic,700italic,400,700' );
	$google = '//fonts.googleapis.com/css';

	wp_enqueue_style( 'open-sans', add_query_arg( $open_sans, $google ) );		
	wp_enqueue_style( 'myriad-pro', get_template_directory_uri() . '/myriad-pro-condensed.css' );		
}
add_action( 'wp_enqueue_scripts', 'themage_enqueue' );

