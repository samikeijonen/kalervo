<?php
/**
 * Set up the WordPress core custom header arguments and settings.
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 * @uses twentythirteen_header_style() to style front-end.
 * @uses twentythirteen_admin_header_style() to style wp-admin form.
 * @uses twentythirteen_admin_header_image() to add custom markup to wp-admin form.
 * @uses register_default_headers() to set up the bundled header images.
 *
 * @since Kalervo 0.1.0
 */
function kalervo_custom_header_setup() {

	$kalervo_header_args = array(
		'flex-height' => true,
		'height' => apply_filters( 'kalervo_header_height', 379 ),
		'flex-width' => true,
		'width' => apply_filters( 'kalervo_header_width', 1000 ),
		'default-image' => '%s/images/default_header.jpg',
		'header-text' => false,
		'admin-head-callback' => 'kalervo_admin_header_style',
		'admin-preview-callback' => 'kalervo_admin_header_image',
	);
	
	add_theme_support( 'custom-header', $kalervo_header_args );
	
	/*
	 * Default custom headers packaged with the theme.
	 * %s is a placeholder for the theme template directory URI.
	 */
	register_default_headers( array(
		'computer' => array(
			'url'           => '%s/images/default_header.jpg',
			'thumbnail_url' => '%s/images/default_header_thumbnail.jpg',
			'description'   => _x( 'Default header', 'header image description', 'kalervo' )
		)
	) );
}
add_action( 'after_setup_theme', 'kalervo_custom_header_setup', 15 );

/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since  0.1.0
 */
function kalervo_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
		max-width: 100%;
	}
	#headimg img {
		max-width: 90%;
		height: auto;
	}
	</style>
<?php
}

/**
 * Outputs markup to be displayed on the Appearance > Header admin panel.
 * This callback overrides the default markup displayed there.
 *
 * @since  0.1.0
 */
function kalervo_admin_header_image() {
	?>
	<div id="headimg">
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }