<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<title><?php wp_title( '| ', TRUE, 'right' ); bloginfo( 'name' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri() . "/style.css"; ?>" />
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/html5.js" type="text/javascript"></script>
		<![endif]-->
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="page">
			<header id="page-header">
				<div id="skip-link-container">
					<a id="skip-link" href="#content" class="invisible focusable aligncenter">Skip to Content</a>
				</div>

				<div id="header-container">
					<div class="header-search">
						<form method="get" id="searchform" action="/">
							<label for="s" class="search-label">Search:</label> 
							<input type="text" class="field" name="s" id="s" />
							<input type="submit" class="submit" name="submit" id="searchsubmit" value="Go" />
						</form>
					</div>

					<a id="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php $header_image = get_header_image();
							if ( ! empty( $header_image ) ) : ?>
								<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" alt=""
									width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" />
						<?php endif; ?>
						<?php if ( is_front_page() ): ?>
							<h1 class="site-name"><?php bloginfo( 'name' ); ?></h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php else: ?>
							<span class="site-name"><?php bloginfo( 'name' ); ?></span>
							<span class="site-description"><?php bloginfo( 'description' ); ?></span>
						<?php endif; ?>
					</a>

					<nav>
						<?php wp_nav_menu( array( 'theme-location' => 'primary' ) ); ?>
					</nav>
				</div>
			</header>
