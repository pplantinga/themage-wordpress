<section id="comments">
	<?php if ( have_comments() ) : ?>
		<h2>
			<?php echo 'Comments on ' . get_the_title(); ?>
		</h2>

		<ol>
			<?php wp_list_comments(); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<div class="alignleft"><?php previous_comments_link( '&larr; Older Comments' ); ?></div>
			<div class="alignright"><?php next_comments_link( 'Newer Comments &rarr;' ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>
	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>
</section>
