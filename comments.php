<section id="comments">
	<?php if ( have_comments() ): ?>
		<h2><?php _e( 'Comments', 'themage' ); ?></h2>
		<ul><?php wp_list_comments(); ?></ul>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ): ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<div class="alignleft"><?php previous_comments_link( __( '&larr; Older Comments', 'themage' ) ); ?></div>
			<div class="alignright"><?php next_comments_link( __( 'Newer Comments &rarr;', 'themage' ) ); ?></div>
		</nav>
		<?php endif; ?>
	<?php endif; ?>

	<?php comment_form(); ?>
</section>
