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
	$header_args = array(
		'default-text-color' => 'cccccc',
		'flexible-width' => TRUE,
		'flexible-height' => TRUE,
		'wp-head-callback' => 'themage_header',
	);
	$background_args = array(
		'default-color' => '42698f',
		'default-image' => get_template_directory_uri() . '/background.svg',
	);
  add_editor_style();
  add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-header', $header_args );
  add_theme_support( 'custom-background', $background_args );
  add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
	register_nav_menus( array( 'primary' => 'Primary Menu' ) );
}
add_action( 'after_setup_theme', 'themage_setup' );

function themage_header() {
	$text_color = get_header_textcolor();
	?>
	<style type="text/css">
	<?php if ( ! display_header_text() ) : ?>
		.site-name,
		.site-description {
			display: none;
		}
	<?php else:	?>
		.site-name {
			color: #<?php echo $text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}

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
		'after_widget' => '</aside>',
	) );

	register_sidebar( array(
		'name' => 'Header Region',
		'id' => 'header-region',
		'description' => 'Appears in the header',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
	) );

	register_sidebar( array(
		'name' => 'Footer Region',
		'id' => 'footer-region',
		'description' => 'Appears in the footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
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

/**
 * This function copied from the "two level conditional menu" plugin
 * that I authored. Here is version 1.1
 *
 * To override, remove_filter( 'two_level_nav_menu' );
 */
function two_level_nav_menu( $menu ) {
	$end_div = substr( $menu, -6 ) == '</div>';

	// Remove the second-level menus
	$menu = preg_replace( '/<ul class="[^"]*sub-menu[^"]*">.*?<\/ul>/s', '', $menu );

	// Trim ending </div>
	$output = preg_replace( '/<\/div>$/', '', $menu );

	// Add second level menu
	global $post;
	if ( $post ) {

		// Gather current menu items
		$locations = get_nav_menu_locations();
		$menu_items = wp_get_nav_menu_items( $locations[ 'primary' ] );

		$second_level = "";
		if ( ! empty( $menu_items ) ) {

			// First, find parent id, if it exists
			$parent_id = -1;
			$current_page_id = is_home() ? get_option( 'page_for_posts' ) : get_the_ID();
			foreach ( $menu_items as $item ) {
				if ( $item->object_id == $current_page_id ) {
					if ( $item->menu_item_parent == 0 ) {
						$parent_id = $item->ID;
					} else {
						$parent_id = $item->menu_item_parent;
					}
					break;
				}
			}

			// Now add menu items
			foreach ( $menu_items as $item ) {

				// Figure out if we're on the current page
				$class = '';
				if ( $item->object_id == $current_page_id )
					$class = ' class="current-menu-item"';
				
				// add menu item
				if ( $item->menu_item_parent == $parent_id )
					$second_level .= "<li$class><a href='$item->url'>$item->title</a></li>";
			}
		}

		if ( ! empty( $second_level ) )
			$output .= "<ul class='second-level menu'>$second_level</ul>";
	}

	// Re-add ending div
	if ( $end_div )
		$output .= "</div>";

	return $output;
}
add_filter( 'wp_nav_menu', 'two_level_nav_menu' );

