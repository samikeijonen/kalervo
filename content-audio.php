<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

	<?php if ( is_singular( get_post_type() ) ) { ?>
	
		<?php if ( function_exists( 'the_remaining_content' ) ) { ?>
			<div class="entry-media">
				<div class="audio-content">
					<?php the_post_format_audio(); ?>
				</div><!-- .audio-content -->	
			</div><!-- .entry-media -->
		<?php } ?>

		<header class="entry-header">
			<h1 class="entry-title"><?php single_post_title(); ?></h1>
			<?php echo apply_atomic_shortcode( 'entry_byline', '<div class="entry-byline">' . __( '[post-format-link] file published on [entry-published] [entry-comments-link before=" | "] [entry-edit-link before="| "]', 'kalervo' ) . '</div>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php 
			if ( function_exists( 'the_remaining_content' ) ) 
				the_remaining_content();
			else
				the_content();
			?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'kalervo' ) . '</span>', 'after' => '</p>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-terms taxonomy="category" before="Posted in "] [entry-terms before="Tagged "]', 'kalervo' ) . '</div>' ); ?>
		</footer><!-- .entry-footer -->

	<?php } else { ?>
	
		<div class="entry-media">
			<div class="audio-content">
				<?php the_post_format_audio(); ?>
			</div><!-- .audio-content -->
		</div><!-- .entry-media -->

		<header class="entry-header">
			<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
		</header><!-- .entry-header -->

		<?php if ( has_excerpt() ) { ?>

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

		<?php } ?>

		<footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[post-format-link] file published on [entry-published] [entry-comments-link before="| "] [entry-edit-link before="| "]', 'kalervo' ) . '</div>' ); ?>
		</footer>

	<?php } ?>

</article><!-- .hentry -->