<?php 
/**
 * Info Header Template
 *
 * Displays header image or slider and information at the top of the header image. Info can also be excerpt of a page.
 *
 * @package    Kalervo
 * @subpackage Template
 * @author     Sami Keijonen <sami.keijonen@foxnet.fi>
 * @since      0.1.0
 */

	/* Get heafer image. */
	$kalervo_header_image = get_header_image();
				
	/* Use Header Image/Slider in the front page and singular pages. */
	if ( is_front_page() || is_singular( 'page' ) ) { ?>
				
		<?php if ( function_exists( 'soliloquy_slider' ) && 'slider' == get_theme_mod( 'show_header_slider' ) ) { ?>
							
			<div id="kalervo-header-image">
				<?php soliloquy_slider( absint( get_theme_mod( 'soliloquy_slider', 'default' ) ) ); ?>
			</div><!-- #kalervo-header-image -->
							
		<?php }
		else {
						
			if ( ! empty( $kalervo_header_image )  && 'header' == get_theme_mod( 'show_header_slider', 'header' ) ) { ?>
				<div id="kalervo-header-image">
									
					<img src="<?php echo esc_url( $kalervo_header_image ); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
									
					<?php if ( is_page_template( 'page-templates/front-page.php' ) ) {
							/* Callout link in Front Page template. */
							if ( get_theme_mod( 'callout_url' ) && get_theme_mod( 'callout_url_text' ) || get_theme_mod( 'callout_text' ) )
								echo '<div id="kalervo-callout-url"><h2 id="kalervo-callout-text">' . esc_attr( get_theme_mod( 'callout_text' ) ) . '</h2><a class="kalervo-callout-button" href="' . esc_url( get_theme_mod( 'callout_url' ) ) . '">' . esc_attr( get_theme_mod( 'callout_url_text' ) ) . '</a></div>';
						} 
									
						/* Excerpt text in other singular pages. */
						if( has_excerpt() && is_singular( 'page' ) && !is_page_template( 'page-templates/front-page.php' ) ) { ?>
							<div id="kalervo-callout-url"><h2 id="kalervo-callout-text"><?php the_excerpt(); ?></h2></div>
						<?php } ?>
									
				</div><!-- #kalervo-header-image --> <?php
			}
		}
						
	}
?>