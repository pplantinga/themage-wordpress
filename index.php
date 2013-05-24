<?php get_header(); ?>
<div id="content">
	<main id="page-main" role="main">
		<?php if ( is_search() ): ?>
			<h1>Search Results For &lsquo;<?php the_search_query() ?>&rsquo;:</h1>
		<?php elseif ( is_home() ): ?>
			<h1>News</h1>
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
						<p><?php the_author(); ?> posted this in <?php the_category(', '); the_tags(' and tagged it '); ?>.</p>
						<?php comments_template(); ?>
					<?php endif; ?>
				</footer>
			</article>
		<?php endwhile; else: ?>
			<p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>

		<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav id="nav-below" class="navigation" role="navigation">
				<div class="alignleft"><?php next_posts_link( '&larr; Older posts' ); ?></div>
				<div class="alignright"><?php previous_posts_link( 'Newer posts &rarr;' ); ?></div>
			</nav>
		<?php endif; ?>
	</main>
</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
