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
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
			get_template_part( 'content', get_post_format() );
		endwhile; else: ?>
			<p><?php _e( 'Sorry, no posts matched your criteria.', 'themage' ); ?></p>
		<?php endif; ?>

		<?php themage_content_nav() ?>
		
	</main>
	
	<?php get_sidebar( 'right' ); ?>
</div><!-- #content -->

<?php get_footer(); ?>
