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
	<?php elseif ( $text_color ):	?>
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
    'description' => __( 'Appears on the left side of posts and pages', 'themage' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
	) );

	register_sidebar( array(
		'name' => 'Right Sidebar',
		'id' => 'right-sidebar',
		'description' => __( 'Appears on the right side of posts and pages', 'themage' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
	) );

	register_sidebar( array(
		'name' => 'Header Region',
		'id' => 'header-region',
		'description' => __( 'Appears in the header', 'themage' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
	) );

	register_sidebar( array(
		'name' => 'Footer Region',
		'id' => 'footer-region',
		'description' => __( 'Appears in the footer', 'themage' ),
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
 * that I authored. Here is version 1.2
 *
 * To override, remove_filter( 'wp_nav_menu', 'themage_conditional_menu' );
 */
function themage_conditional_menu( $menu, $args ) {

  // Start output by removing the second-level menu
  $output = preg_replace( '/<ul class="[^"]*sub-menu[^"]*">.*?<\/ul>/s', '', $menu );

  // Remove endtag if exists
  $endtag = "</$args->container>";
  $endtag_exists = substr( $output, -strlen( $endtag ) ) == $endtag;
  if ( $endtag_exists )
    $output = substr( $output, 0, -strlen( $endtag ) );

	// Add second level menu
	global $post;
	global $wp_query;
	if ( $post ) {
		/* This menu-gathering code is from wp_nav_menu */
		// Get the nav menu based on the requested menu
		$menu = wp_get_nav_menu_object( $args->menu );

		// Get the nav menu based on the theme_location
		if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) )
			$menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );

		// get the first menu that has items if we still can't find a menu
		if ( ! $menu && !$args->theme_location ) {
			$menus = wp_get_nav_menus();
			foreach ( $menus as $menu_maybe ) {
				if ( $menu_items = wp_get_nav_menu_items( $menu_maybe->term_id, array( 'update_post_term_cache' => false ) ) ) {
					$menu = $menu_maybe;
					break;
				}
			}
		}

		// If the menu exists, get its items.
		if ( $menu && ! is_wp_error( $menu ) && !isset( $menu_items ) )
			$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );

		$second_level = "";
		if ( ! empty( $menu_items ) )
		{
			// First, find parent id, if it exists
			$parent_id = -1;
			$current_page_id = $wp_query->get_queried_object_ID();
			foreach ( $menu_items as $item ) {

				// Are we on the current page?
				if ( $item->object_id == $current_page_id ) {

					// Correctly set menu parent
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

	// Re-add ending tag
	if ( $endtag_exists )
		$output .= $endtag;

	return $output;
}
add_filter( 'wp_nav_menu', 'themage_conditional_menu', 10, 2 );

/**
 * Navigation below lists
 *
 * <- Older posts ... Newer posts ->
 */
function themage_content_nav() {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="nav-below" class="navigation" role="navigation">
			<div class="alignleft"><?php next_posts_link( __( '&larr; Older posts', 'themage' ) ); ?></div>
			<div class="alignright"><?php previous_posts_link( __( 'Newer posts &rarr;', 'themage' ) ); ?></div>
		</nav>
	<?php endif;
}
