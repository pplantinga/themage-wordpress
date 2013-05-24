<?php

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) 
  $content_width = 1000;

/**
 * Make Theme Check happy
 */
function themage_setup() {
	$background_args = array(
		'default-color' => '666666',
		'default-image' => get_template_directory_uri() . '/background.svg',
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
    'name' => 'Left Sidebar',
    'id' => 'left-sidebar',
    'description' => 'Appears on the left side of posts and pages',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
	) );

	register_sidebar( array(
		'name' => 'Right Sidebar',
		'id' => 'right-sidebar',
		'description' => 'Appears on the right side of posts and pages',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widet' => '</aside>',
	) );

	register_sidebar( array(
		'name' => 'Header Region',
		'id' => 'header-region',
		'description' => 'Appears in the header',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widet' => '</aside>',
	) );

	register_sidebar( array(
		'name' => 'Footer Region',
		'id' => 'footer-region',
		'description' => 'Appears in the footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widet' => '</aside>',
	) );
}
add_action( 'widgets_init', 'themage_widgets_init' );

/**
 * Enqueue scripts 
 */
function themage_enqueue()
{
	// Load main stylesheet
	wp_enqueue_style( 'themage-style', get_stylesheet_uri() );

  if ( is_singular() && comments_open() ) 
		wp_enqueue_script( 'comment-reply' );

	// Load font. To remove, add `wp_dequeue_style( 'Lobster' );`
	wp_enqueue_style( 'Lobster', add_query_arg( 'family', 'Lobster', '//fonts.googleapis.com/css' ) );
}
add_action( 'wp_enqueue_scripts', 'themage_enqueue' );

/**
 * Add body classes
 */
function themage_body_class( $classes )
{
	if ( is_active_sidebar( 'left-sidebar' ) && is_active_sidebar( 'right-sidebar' ) )
		$classes[] = 'two-sidebars';
	else if ( is_active_sidebar( 'left-sidebar' ) || is_active_sidebar( 'right-sidebar' ) )
		$classes[] = 'one-sidebar';
	else
		$classes[] = 'no-sidebars';

	return $classes;
}
add_filter( 'body_class', 'themage_body_class' );

