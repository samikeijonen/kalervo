<?php
/**
 * Template Name: Download Page
 *
 * @package Kalervo
 * @subpackage Template
 * @since 0.1.0
 */
 
/* For translating page template name. */
__( 'Download Page', 'kalervo' ); 

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed" role="main">
	
	<?php get_sidebar( 'front-page' ); // Loads the sidebar-front-page.php template.
	
		/* Set custom query to show download items. */
		$kalervo_download_args = apply_filters( 'kalervo_front_page_download_arguments', array(
			'post_type' => 'download',
			'posts_per_page' => 4
		) );
			
		$kalervo_downloads = new WP_Query( $kalervo_download_args );
	
		$kalervo_latest_download = esc_attr( apply_filters( 'kalervo_front_page_latest_downloads', __( 'Latest Downloads', 'kalervo' ) ) ); ?>
			
		<h3 id="kalervo-latest-download"><?php printf( __( '%1$s', 'kalervo' ), $kalervo_latest_download ); ?></h3>
		
		<div class="kalervo-latest-wrap">
	
			<?php if ( $kalervo_downloads->have_posts() ) : ?>

				<?php while ( $kalervo_downloads->have_posts() ) : $kalervo_downloads->the_post(); ?>
			
					<div class="kalervo-download">

						<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">
				
							<header class="entry-header">
								<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'kalervo-thumbnail-portfolio', 'image_class' => 'kalervo-portfolio-image', 'width' => 450, 'height' => 309, 'default_image' => trailingslashit( get_template_directory_uri() ) . 'images/archive_default.png' ) ); ?>
							</header><!-- .entry-header -->

							<div class="entry-summary">
								<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
								<?php kalervo_download_price(); // echo download price. ?>
							</div><!-- .entry-summary -->

						</article><!-- .hentry -->
				
					</div><!-- .kalervo-download -->

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

			<?php endif; wp_reset_query(); // reset query ?>
		
		</div><!-- .kalervo-latest-wrap -->

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>