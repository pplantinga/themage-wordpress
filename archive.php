<?php get_header(); ?>

<div id="content">
	<?php get_sidebar( 'left' ); ?>

	<main id="page-main" role="main">
		<h1 class="page-title"><?php if ( is_day() ):
			printf( __( 'Posts From %s', 'themage' ), get_the_date() );
		elseif ( is_month() ):
			printf( __( 'Posts From %s', 'themage' ), get_the_date( 'F Y' ) );
		elseif ( is_year() ):
			printf( __( 'Posts From %s', 'themage' ), get_the_date( 'Y' ) );
		elseif ( is_category() ):
			printf( __( 'Posts in Category &lsquo;%s&rsquo;', 'themage' ), single_cat_title( '', false ) );
		elseif ( is_tag() ):
			printf( __( 'Posts with Tag &lsquo;%s&rsquo;', 'themage' ), single_tag_title( '', false ) );
		elseif ( is_author() ):
			$curauth = get_query_var( 'author_name' )
				? get_user_by( 'slug', get_query_var( 'author_name' ) )
				: get_userdata( get_query_var( 'author' ) );
			printf( __( 'Posts by &lsquo;%s&rsquo;', 'themage' ), $curauth->nickname );
		else:
			_e( 'Archive', 'themage' );
		endif; ?></h1>

		<?php while ( have_posts() ): the_post();
			get_template_part( 'content', get_post_format() );
		endwhile; ?>
	
		<?php themage_content_nav(); ?>
	</main>

	<?php get_sidebar( 'right' ); ?>
</div><!-- #content -->

<?php get_footer(); ?>
