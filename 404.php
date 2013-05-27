<?php get_header(); ?>
	<div id="content">
	<?php get_sidebar( 'left' ); ?>
		<main id="page-main">
			<article id="post-0">
				<header>
					<h1 class="post-title"><?php _e( 'Page Not Found', 'themage' ); ?></h1>
				</header>
				<section>
					<p><?php _e( 'We couldn&rsquo;t find that page. Perhaps searching can help.', 'themage' ); ?></p>
					<?php get_search_form(); ?>
				</section>
			</article>
		</main>
	<?php get_sidebar( 'right' ); ?>
	</div>
<?php get_footer(); ?>
