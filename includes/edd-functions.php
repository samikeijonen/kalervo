<?php

/* Add own button style to EDD Plugin (Settings >> Style). */
add_filter( 'edd_button_colors', 'kalervo_add_button_color' );

/**
 * Add button style to EDD Plugin.
 * 
 * @since 0.1.0
 */
function kalervo_add_button_color( $button_style  ) {
	
	if ( function_exists( 'edd_get_button_colors' ) ) {
		$button_style['kalervo-theme-color'] = array( 
			'label' => __( 'Kalervo Theme Color', 'kalervo' ),
			'hex'   => ''
		);
	}

	return $button_style;
	
}

/**
 * Get the Price of download.
 *
 * @since     0.1.0
*/
function kalervo_download_price() { ?>

	<div itemprop="price" class="kalervo-price">
		<?php if ( edd_has_variable_prices( get_the_ID() ) ) _e( 'From:', 'kalervo' ); ?> <?php edd_price( get_the_ID() ); ?>
	</div>
	
	<?php

}
?>