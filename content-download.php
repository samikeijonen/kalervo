<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

	<?php if ( is_singular( get_post_type() ) ) { ?>

		<header class="entry-header">
			<h1 class="entry-title"><?php single_post_title(); ?></h1>
			<?php echo apply_atomic_shortcode( 'entry_byline', '<div class="entry-byline">' . __( 'Price:', 'kalervo' ) . ' ' . kalervo_edd_the_price( get_the_ID() ) . '</div>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'kalervo' ) . '</span>', 'after' => '</p>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-terms before="Posted in " taxonomy="category"] [entry-terms before="| Tagged "]', 'kalervo' ) . '</div>' ); ?>
		</footer><!-- .entry-footer -->

	<?php } else { ?>

		<header class="entry-header">
			<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'kalervo-thumbnail-download', 'image_class' => 'kalervo-download', 'width' => 330, 'height' => 330, 'default_image' => trailingslashit( get_template_directory_uri() ) . 'images/archive_default.png' ) ); ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
			<?php the_excerpt(); ?>
			<p class="kalervo-download"><?php  echo __( 'Price:', 'kalervo' ) . ' ' . kalervo_edd_the_price( get_the_ID() ) ?></p>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'kalervo' ) . '</span>', 'after' => '</p>' ) ); ?>
		</div><!-- .entry-summary -->

	<?php } ?>

</article><!-- .hentry -->