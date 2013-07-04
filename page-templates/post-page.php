<?php
/**
 * Template Name: Post Page
 *
 * @package Kalervo
 * @subpackage Template
 * @since 0.1.0
 */
 
 /* For translating page template name. */
 __( 'Post Page', 'kalervo' ); 

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed" role="main">
	
		<?php get_sidebar( 'front-page' ); // Loads the sidebar-front-page.php template. ?>
		
		<?php
		/* Set custom query to show latest posts. */
		$kalervo_posts_args = apply_filters( 'kalervo_front_page_post_arguments', array(
			'post_type' => 'post',
			'posts_per_page' => 4,
			'ignore_sticky_posts' => 1,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array( 
						'post-format-aside',
						'post-format-audio',
						'post-format-chat',
						'post-format-link',
						'post-format-quote',
						'post-format-status',
					),
					'operator' => 'NOT IN'
				) 
			)
		) );
			
		$kalervo_posts = new WP_Query( $kalervo_posts_args );
		?>
	
		<?php $kalervo_latest_posts = esc_attr( apply_filters( 'kalervo_front_page_latest_posts', __( 'Latest articles', 'kalervo' ) ) ); ?>
			
		<h3 id="kalervo-latest-posts"><?php printf( __( '%1$s', 'kalervo' ), $kalervo_latest_posts ); ?></h3>
			
		<div class="kalervo-latest-wrap">
			
			<?php if ( $kalervo_posts->have_posts() ) : ?>

				<?php while ( $kalervo_posts->have_posts() ) : $kalervo_posts->the_post(); ?>
				
					<div class="kalervo-post">
				
						<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">
	
							<header class="entry-header">
								<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'kalervo-thumbnail-portfolio', 'image_class' => 'kalervo-portfolio-image', 'width' => 450, 'height' => 309, 'default_image' => trailingslashit( get_template_directory_uri() ) . 'images/archive_default.png' ) ); ?>
							</header><!-- .entry-header -->
		
							<div class="entry-summary">
								<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
							</div><!-- .entry-summary -->

						</article><!-- .hentry -->
					
					</div><!-- .kalervo-post -->

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

			<?php endif; wp_reset_query(); // reset query. ?>
							
		</div><!-- .kalervo-latest-wrap -->

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>