<?php
/**
 * Template Name: Portfolio Page
 *
 * @package Kalervo
 * @subpackage Template
 * @since 0.1.0
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed" role="main">
	
	<?php get_sidebar( 'front-page' ); // Loads the sidebar-front-page.php template.
	
		/* Set custom query to show portfolio items. */
		$kalervo_portfolio_args = apply_filters( 'kalervo_front_page_portfolio_arguments', array(
			'post_type' => 'portfolio_item',
			'posts_per_page' => 4
		) );
			
		$kalervo_portfolios = new WP_Query( $kalervo_portfolio_args );
	
		$kalervo_latest_portfolio = esc_attr( apply_filters( 'kalervo_front_page_latest_portfolios', __( 'Latest Portfolios', 'kalervo' ) ) ); ?>
			
		<h3 id="kalervo-latest-portfolio"><?php printf( __( '%1$s', 'kalervo' ), $kalervo_latest_portfolio ); ?></h3>
		
		<div class="kalervo-latest-wrap">
	
			<?php if ( $kalervo_portfolios->have_posts() ) : ?>

				<?php while ( $kalervo_portfolios->have_posts() ) : $kalervo_portfolios->the_post(); ?>
			
					<div class="kalervo-portfolio">

						<article <?php hybrid_post_attributes(); ?>>
				
							<header class="entry-header">
								<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'kalervo-thumbnail-portfolio', 'image_class' => 'kalervo-portfolio-image', 'width' => 450, 'height' => 309, 'default_image' => trailingslashit( get_template_directory_uri() ) . 'images/archive_default.png' ) ); ?>
							</header><!-- .entry-header -->

							<div class="entry-summary">
								<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
								<p class="kalervo-portfolio-item"><?php echo hybrid_entry_terms_shortcode( array( 'taxonomy' => 'portfolio', 'before' => __( 'Work:', 'kalervo' ) . ' ' ) ); ?></p>
							</div><!-- .entry-summary -->

						</article><!-- .hentry -->
				
					</div><!-- .kalervo-portfolio -->

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

			<?php endif; wp_reset_query(); // reset query ?>
		
		</div><!-- .kalervo-latest-wrap -->

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>