	<?php if ( is_attachment() ) : ?>

		<div class="loop-nav">
			<?php previous_post_link( '%link', '<span class="previous">' . __( '<span class="meta-nav">&larr;</span> Return to entry', 'kalervo' ) . '</span>' ); ?>
		</div><!-- .loop-nav -->

	<?php elseif ( is_singular( apply_filters( 'kalervo_singular_loop_nav', array( 'post', 'portfolio_item', 'download' ) ) ) ) : ?>

		<div class="loop-nav">
			<?php previous_post_link( '%link', '<span class="previous">' . __( '<span class="meta-nav">&larr;</span> Previous', 'kalervo' ) . '</span>' ); ?>
			<?php next_post_link( '%link', '<span class="next">' . __( 'Next <span class="meta-nav">&rarr;</span>', 'kalervo' ) . '</span>' ); ?>
		</div><!-- .loop-nav -->

	<?php elseif ( !is_singular() && current_theme_supports( 'loop-pagination' ) ) : loop_pagination( array( 'prev_text' => __( '<span class="meta-nav">&larr;</span> Previous', 'kalervo' ), 'next_text' => __( 'Next <span class="meta-nav">&rarr;</span>', 'kalervo' ) ) ); ?>

	<?php elseif ( !is_singular() && $nav = get_posts_nav_link( array( 'sep' => '', 'prelabel' => '<span class="previous">' . __( '<span class="meta-nav">&larr;</span> Previous', 'kalervo' ) . '</span>', 'nxtlabel' => '<span class="next">' . __( 'Next <span class="meta-nav">&rarr;</span>', 'kalervo' ) . '</span>' ) ) ) : ?>

		<div class="loop-nav">
			<?php echo $nav; ?>
		</div><!-- .loop-nav -->

	<?php endif; ?>