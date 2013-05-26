<?php if ( is_singular( get_post_type() ) ) { ?>
	
	<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

		<header class="entry-header">
			<h1 class="entry-title"><?php single_post_title(); ?></h1>
			<?php echo apply_atomic_shortcode( 
				'entry_byline', 
				'<div class="entry-byline">' . 
					hybrid_entry_terms_shortcode( array( 'taxonomy' => 'portfolio', 'before' => __( 'Work:', 'kalervo' ) . ' ' ) ) . 
				'</div>'
			); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'kalervo' ) . '</span>', 'after' => '</p>' ) ); ?>
			<?php echo kalervo_get_portfolio_item_link(); // echo portfolio link ?>
		</div><!-- .entry-content -->
	
	</article><!-- .hentry -->

	<?php } else { ?>
		
		<div class="kalervo-portfolio">
		
			<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">
		
				<header class="entry-header">
					<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'kalervo-thumbnail-portfolio', 'image_class' => 'kalervo-portfolio-image', 'width' => 450, 'height' => 309, 'default_image' => trailingslashit( get_template_directory_uri() ) . 'images/archive_default.png' ) ); ?>
				</header><!-- .entry-header -->

				<div class="entry-summary">
					<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
					<p class="kalervo-portfolio-item"><?php echo hybrid_entry_terms_shortcode( array( 'taxonomy' => 'portfolio', 'before' => __( 'Work:', 'kalervo' ) . ' ' ) ); ?></p>
				</div><!-- .entry-summary -->
				
			</article><!-- .hentry -->
			
		</div><!-- .kalervo-portfolio -->

<?php } ?>