			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<?php if ( is_singular() ): ?>
						<h1 class="post-title"><?php the_title(); ?></h1>
					<?php elseif ( is_front_page() ): ?>
						<h2 class="post-title"><?php the_title(); ?></h2>
					<?php else: ?>
						<h2 class="post-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>
				</header>
				<section>
					<?php if ( has_post_thumbnail() ) the_post_thumbnail(); ?>
					<?php if ( is_singular() ) the_content(); else the_excerpt(); ?>
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

