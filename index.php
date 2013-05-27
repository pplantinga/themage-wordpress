<?php get_header(); ?>

<div id="content">
	<?php get_sidebar( 'left' ); ?>

	<main id="page-main" role="main">
		<?php if ( isset( $wp_query->query['s'] ) ): ?>
			<h1><?php printf( __( 'Search Results For &lsquo;%s&rsquo;:', 'themage' ), the_search_query() ); ?></h1>
			<?php if ( empty( $s ) ) $wp_query->post_count = 0; ?>
		<?php elseif ( is_home() && get_option( 'page_for_posts' )  ): ?>
			<h1><?php echo get_the_title( get_option( 'page_for_posts' ) ); ?></h1>
		<?php endif; ?>
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<?php if ( is_search() || is_home() ): ?>
						<h2 class="post-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php elseif ( is_front_page() ): ?>
						<h2 class="post-title"><?php the_title(); ?></h2>
					<?php else: ?>
						<h1 class="post-title"><?php the_title(); ?></h1>
					<?php endif; ?>
				</header>
				<section>
					<?php if ( has_post_thumbnail() ) the_post_thumbnail(); ?>
					<?php if ( is_search() ) the_excerpt(); else the_content(); ?>
					<?php wp_link_pages(); ?>
				</section>
				<footer>
					<?php if ( get_post_type() == 'post' ): ?>
						<p><?php printf( __( '%1$s posted this in %2$s%3$s.', 'themage' ),
							get_the_author(),
							get_the_category_list(', '),
							get_the_tag_list( __( ' and tagged it ', 'themage' ), ', ' ) ); ?>
						</p>
						<?php comments_template(); ?>
					<?php endif; ?>
				</footer>
			</article>
		<?php endwhile; else: ?>
			<p><?php _e( 'Sorry, no posts matched your criteria.', 'themage' ); ?></p>
		<?php endif; ?>

		<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav id="nav-below" class="navigation" role="navigation">
				<div class="alignleft"><?php next_posts_link( __( '&larr; Older posts', 'themage' ) ); ?></div>
				<div class="alignright"><?php previous_posts_link( __( 'Newer posts &rarr;', 'themage' ) ); ?></div>
			</nav>
		<?php endif; ?>
	</main>
	
	<?php get_sidebar( 'right' ); ?>
</div><!-- #content -->

<?php get_footer(); ?>
