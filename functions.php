<?php
/**
 * The functions.php file is used to initialize everything in the theme. It controls how the theme is loaded and 
 * sets up the supported features, default actions, and default filters. If making customizations, users 
 * should create a child theme and make changes to its functions.php file (not this one).
 *
 * @package     Kalervo
 * @subpackage  Functions
 * @version     0.1.0
 * @author      Sami Keijonen <sami.keijonen@foxnet.fi>
 * @copyright   Copyright (c) 2012, Sami Keijonen
 * @link        https://foxnet-themes.fi
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
 
/* Load Hybrid Core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/* Theme setup function using 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'kalervo_theme_setup' );

/**
 * Theme setup function. This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 0.1.0
 */
function kalervo_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();
		
	/* Include theme customize. */
	require_once( trailingslashit( get_template_directory() ) . 'includes/theme-customize.php' );
	
	/* Include EDD functions. */
	require_once( trailingslashit( get_template_directory() ) . 'includes/edd-functions.php' );

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary', 'secondary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'header', 'primary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );
	add_theme_support( 'hybrid-core-scripts', array( 'comment-reply' ) );
	add_theme_support( 'hybrid-core-styles', array( 'parent', 'style' ) );
	add_theme_support( 'hybrid-core-template-hierarchy' );
	
	/* Add theme support for framework extensions. */
	add_theme_support( 'theme-layouts', array( '1c', '2c-l', '2c-r' ), array( 'default' => '1c' ) );
	add_theme_support( 'post-stylesheets' );
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-gallery' );
	add_theme_support( 'cleaner-caption' );
	add_theme_support( 'featured-header' );
	
	/* Add theme support for WordPress features. */
	
	/* Add support for auto-feed links. */
	add_theme_support( 'automatic-feed-links' );

	/* Add theme support for post formats. Note: rest of the post formats are handeld by Hybrid Core andd WordPress. */
	add_theme_support( 
		'structured-post-formats',
		array( 'audio', 'image', 'link', 'video' ) 
	);
	
	/* Add custom background feature. */
	add_theme_support( 
		'custom-background',
		array(
			'default-color' => 'f2f2f2' // Background default color
		)
	);
	
	/* Add support for flexible headers. @link http://make.wordpress.org/themes/2012/04/06/updating-custom-backgrounds-and-custom-headers-for-wordpress-3-4/ */
	
	$kalervo_header_args = array(
		'flex-height' => true,
		'height' => apply_filters( 'kalervo_header_height', 379 ),
		'flex-width' => true,
		'width' => apply_filters( 'kalervo_header_width', 1000 ),
		'default-image' => trailingslashit( get_template_directory_uri() ) . 'images/default_header.jpg',
		'header-text' => false,
		'admin-head-callback' => 'kalervo_admin_header_style',
		'admin-preview-callback' => 'kalervo_admin_header_image',
	);
	
	add_theme_support( 'custom-header', $kalervo_header_args );
	
	/* Set content width. */
	hybrid_set_content_width( 604 );
	add_filter( 'embed_defaults', 'kalervo_embed_defaults' );
	
	/* Add respond.js and  html5shiv.js for unsupported browsers. */
	add_action( 'wp_head', 'kalervo_respond_html5shiv' );
	
	/* Add custom image sizes. */
	add_action( 'init', 'kalervo_add_image_sizes' );
	
	/* Enqueue scripts. */
	add_action( 'wp_enqueue_scripts', 'kalervo_scripts_styles' );
	
	/* Disable primary sidebar widgets when layout is one column. */
	add_filter( 'sidebars_widgets', 'kalervo_disable_sidebars' );
	add_action( 'template_redirect', 'kalervo_one_column' );
	
	/* Add number of subsidiary and front page widgets to body_class. */
	add_filter( 'body_class', 'kalervo_subsidiary_classes' );
	add_filter( 'body_class', 'kalervo_front_page_classes' );
	
	/* Excerpt ending to ... */
	add_filter( 'excerpt_more', 'kalervo_excerpt_more' );
	
	/* Set customizer transport. */
	add_action( 'customize_register', 'kalervo_customize_register' );
	
	/* Add js to customize. */
	add_action( 'customize_preview_init', 'kalervo_customize_preview_js' );
	
	/* Add css to customize. */
	add_action( 'wp_enqueue_scripts', 'kalervo_customize_preview_css' );
	
	/* Use same taxonomy template. */
	add_filter( 'taxonomy_template', 'kalervo_taxonomy_template', 11 );
	
	/* Register additional sidebar to 'front page' page template. */
	add_action( 'widgets_init', 'kalervo_register_sidebars' );
	
	/* Add menu-item-parent class to parent menu items.  */
	add_filter( 'wp_nav_menu_objects', 'kalervo_add_menu_parent_class' );
	
	/* Add new body class if there is attachments. */
	add_filter( 'body_class', 'kalervo_add_body_attachments' );
	
	/* Add wrapper to porfolio and download archive. */
	add_action( 'kalervo_before_loop', 'kalervo_add_wrapper' );
	add_action( 'kalervo_after_loop', 'kalervo_end_wrapper' );
	
	/* Woocommerce stuff. @link http://docs.woothemes.com/document/third-party-custom-theme-compatibility/ */
	add_theme_support( 'woocommerce' );
	
	/* Remove not needed action hooks. */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	remove_action( 'woocommerce_sidebar' , 'woocommerce_get_sidebar', 10 );
	
	/* Add right wrappers fot the theme. */
	add_action( 'woocommerce_before_main_content', 'kalervo_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'kalervo_wrapper_end', 10 );
	
	/* Filter no_id string in soliloquy. */
	add_filter( 'tgmsp_strings', 'kalervo_soliloquy_no_id_string' );

}

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

/**
 * Overwrites the default widths for embeds. This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since  0.1.0
 * @param  array  $args
 * @return array
 */
function kalervo_embed_defaults( $args ) {

	if ( current_theme_supports( 'theme-layouts' ) && '1c' == get_theme_mod( 'theme_layout' ) )
		$args['width'] = 944;

	return $args;
}

/**
 * Function for help to unsupported browsers understand mediaqueries and html5.
 * @link: https://github.com/scottjehl/Respond
 * @link: http://code.google.com/p/html5shiv/
 * @since 0.1.0
 */
function kalervo_respond_html5shiv() {
	?>
	
	<!-- Enables media queries and html5 in some unsupported browsers. -->
	<!--[if (lt IE 9) & (!IEMobile)]>
	<script type="text/javascript" src="<?php echo trailingslashit( get_template_directory_uri() ); ?>js/respond/respond.min.js"></script>
	<script type="text/javascript" src="<?php echo trailingslashit( get_template_directory_uri() ); ?>js/html5shiv/html5shiv.js"></script>
	<![endif]-->
	
	<?php
}


/**
 *  Adds custom image sizes for thumbnail images.
 * 
 * @since 0.1.0
 */
function kalervo_add_image_sizes() {

	add_image_size( 'kalervo-thumbnail-portfolio', 450, 309, true );
	add_image_size( 'kalervo-portfolio', 764, 472, true );
	
}

/**
 * Enqueues scripts and styles.
 *
 * @since 0.1.0
 */
function kalervo_scripts_styles() {
	
		/* Enqueue FitVids. */
		wp_enqueue_script( 'kalervo-fitvids', trailingslashit( get_template_directory_uri() ) . 'js/fitvids/jquery.fitvids.min.js', array( 'jquery' ), '20130525', true );
		
		/* Enqueue Kalervo settings. */
		wp_enqueue_script( 'kalervo-settings', trailingslashit( get_template_directory_uri() ) . 'js/settings/kalervo-settings.js', array( 'jquery', 'kalervo-fitvids' ), '20130525', true );
	
		/* Add google font. */
		wp_enqueue_style( 'kalervo-fonts-1', 'http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700', false, '20130502', 'all' );
		
		/* Add flexslider js and css to singular portfolio page. */
		if ( is_singular( 'portfolio_item' ) ) {
			
			wp_enqueue_script( 'kalervo-flexslider',  trailingslashit( get_template_directory_uri() ) . 'js/flexslider/jquery.flexslider-min.js', array( 'jquery' ), '20130525', true );
			wp_enqueue_script( 'kalervo-flexslider-settings', trailingslashit( get_template_directory_uri() ) . 'js/flexslider/settings.flexslider.js', array( 'kalervo-flexslider' ), '20130525', true );
			wp_enqueue_style( 'kalervo-flexslider-styles', trailingslashit( get_template_directory_uri() ) . 'css/flexslider/flexslider.min.css', false, '20130525', 'all' );
	
		}
	
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 * @since 0.1.0
 * @param array $sidebars_widgets A multidimensional array of sidebars and widgets.
 * @return array $sidebars_widgets
 */
function kalervo_disable_sidebars( $sidebars_widgets ) {
	global $wp_customize;

	$customize = ( is_object( $wp_customize ) && $wp_customize->is_preview() ) ? true : false;

	if ( !is_admin() && !$customize && '1c' == get_theme_mod( 'theme_layout', '1c' ) )
		$sidebars_widgets['primary'] = false;
		
	return $sidebars_widgets;
}

/**
 * Function for deciding which pages should have a one-column layout.
 *
 * @since 0.1.0
 */
function kalervo_one_column() {

	if ( !is_active_sidebar( 'primary' ) )
		add_filter( 'theme_mod_theme_layout', 'kalervo_theme_layout_one_column' );
		
	elseif ( is_post_type_archive( 'portfolio_item' ) || is_post_type_archive( 'download' ) )
		add_filter( 'theme_mod_theme_layout', 'kalervo_theme_layout_one_column' );
		
	elseif ( is_tax( 'portfolio' ) || is_tax( 'download_tag' ) || is_tax( 'download_category' ) )
		add_filter( 'theme_mod_theme_layout', 'kalervo_theme_layout_one_column' );
	
	elseif ( is_attachment() && wp_attachment_is_image() && 'default' == get_post_layout( get_queried_object_id() ) )
		add_filter( 'theme_mod_theme_layout', 'kalervo_theme_layout_one_column' );

	elseif ( is_page_template( 'page-templates/front-page.php' ) )
		add_filter( 'theme_mod_theme_layout', 'kalervo_theme_layout_one_column' );
		
	elseif ( kalervo_check_attachments() )
		add_filter( 'theme_mod_theme_layout', 'kalervo_theme_layout_one_column' );
	
	elseif ( function_exists( 'woocommerce_list_pages' ) && ( is_shop() || is_product_category() || is_product_tag() ) )
		add_filter( 'theme_mod_theme_layout', 'kalervo_theme_layout_one_column' );
	
}


/**
 * Filters 'get_theme_layout' by returning 'layout-1c'.
 *
 * @since 0.1.0
 * @param string $layout The layout of the current page.
 * @return string
 */
function kalervo_theme_layout_one_column( $layout ) {
	return '1c';
}

/**
 * Counts widgets number in subsidiary sidebar and ads css class (.sidebar-subsidiary-$number) to body_class.
 * Used to increase / decrease widget size according to number of widgets.
 * Example: if there's one widget in subsidiary sidebar - widget width is 100%, if two widgets, 50% each...
 * @author Sinisa Nikolic
 * @copyright Copyright (c) 2012
 * @link http://themehybrid.com/themes/sukelius-magazine
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since 0.1.0
 */
function kalervo_subsidiary_classes( $classes ) {
    
	if ( is_active_sidebar( 'subsidiary' ) ) {
		
		$the_sidebars = wp_get_sidebars_widgets();
		$num = count( $the_sidebars['subsidiary'] );
		$classes[] = 'sidebar-subsidiary-' . $num;
		
    }
    
    return $classes;
	
}

/**
 * Counts widgets number in front-page sidebar and ads css class (.sidebar-front-page-$number) to body_class.
 * @author Sinisa Nikolic
 * @copyright Copyright (c) 2012
 * @link http://themehybrid.com/themes/sukelius-magazine
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since 0.1.0
 */
function kalervo_front_page_classes( $classes ) {
	
	if ( is_active_sidebar( 'front-page' ) && is_page_template( 'page-templates/front-page.php' ) ) {
		
		$the_sidebars = wp_get_sidebars_widgets();
		$num = count( $the_sidebars['front-page'] );
		$classes[] = 'sidebar-front-page-' . $num;
		
    }
    
    return $classes;
	
}

/**
 * Excerpt ending to '...'.
 *
 * @since  0.1.0
 */
function kalervo_excerpt_more( $more ) {

	return '...';
	
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 * @since 0.1.0
 * @note: credit goes to TwentyTwelwe theme.
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function kalervo_customize_register( $wp_customize ) {
	
	if ( ! get_theme_mod( 'logo_upload' ) )
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	
}

/**
 * This make Theme Customizer live preview reload changes asynchronously.
 * Used with blogname and blogdescription.
 * @note: credit goes to TwentyTwelwe theme.
 * @since 0.1.0
 */
function kalervo_customize_preview_js() {

	wp_enqueue_script( 'kalervo-customizer', trailingslashit( get_template_directory_uri() ) . 'js/customize/kalervo-customizer.js', array( 'customize-preview' ), '20130524', true );
	
}

/**
 * This make Theme Customizer live preview work with 1 column layout.
 * Used with Primary and Secondary sidebars.
 * 
 * @since 0.1.0
 */
function kalervo_customize_preview_css() {
	global $wp_customize;

	if ( is_object( $wp_customize ) )
		wp_enqueue_style( 'kalervo-customizer-stylesheet', trailingslashit( get_template_directory_uri() ) . 'css/customize/kalervo-customizer.css', false, '20130209', 'all' );
}

/**
 * Use template 'archive-portfolio_item.php' in taxonomy 'portfolio' so that we don't need to duplicate same template content.
 * 
 * @since 0.1.0
 */
function kalervo_taxonomy_template( $template  ) {

	if ( is_tax( 'portfolio' ) )
		$template = locate_template( array( 'archive-portfolio_item.php' ) );

	return $template;
	
}

/**
 * Register additional sidebar to 'front page' page template.
 * 
 * @since 0.1.0
 */
function kalervo_register_sidebars() {

	/* Register the 'front-page' sidebar. */
	register_sidebar(
		array(
			'id' => 'front-page',
			'name' => __( 'Front Page', 'kalervo' ),
			'description' => __( 'Front Page widget area.', 'kalervo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-wrap widget-inside">',
			'after_widget' => '</div></section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

}

/**
 * Add menu-item-parent class to parent menu items. Thanks to Chip Bennett.
 *
 * @since 0.1.2.3
 */
function kalervo_add_menu_parent_class( $items ) {

	$parents = array();

	foreach ( $items as $item ) {

		if ( $item->menu_item_parent && $item->menu_item_parent > 0 )
			$parents[] = $item->menu_item_parent;
		
	}

	foreach ( $items as $item ) {

		if ( in_array( $item->ID, $parents ) )
			$item->classes[] = 'menu-item-parent';

	}

	return $items;    

}

/**
 * Add start wrapper.
 *
 * @since  0.1.0
 */
function kalervo_wrapper_start() {
	echo '<div id="content" class="hfeed" role="main">';
}

/**
 * Add end wrapper.
 *
 * @since  0.1.0
 */
function kalervo_wrapper_end() {
	echo '</div>';
}

/**
 * Change no_id text in Soliloquy Slider.
 *
 * @since  0.1.0
 */
function kalervo_soliloquy_no_id_string( $strings ) {

	$strings['no_id'] = sprintf( __( 'No slider was selected. Please select a Slider under <a href="%s"> Appearance &gt; Customize &gt; Layout</a>.', 'kalervo' ), admin_url( 'customize.php' ) );

	return $strings;
}

/**
 * Returns the URL from the post.
 *
 * @uses get_the_post_format_url() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 * @note This idea is taken from Twenty Thirteen theme.
 * @author wordpressdotorg
 * @copyright Copyright (c) 2011, wordpressdotorg
 *
 * @since 0.1.0
 */
function kalervo_get_link_url() {

	$kalervo_url = get_the_post_format_url();

	return ( $kalervo_url ) ? $kalervo_url : apply_filters( 'the_permalink', get_permalink() );

}

/**
* Returns a link to the porfolio item URL if it has been set.
*
* @since  0.1.0
*/
function kalervo_get_portfolio_item_link() {

	$kalervo_portfolio_url = get_post_meta( get_the_ID(), 'portfolio_item_url', true );

	if ( !empty( $kalervo_portfolio_url ) )
		return '<span class="kalervo-project-url"><a class="kalervo-portfolio-item-link" href="' . esc_url( $kalervo_portfolio_url ) . '" title="' . the_title( '','', false ) . '">' . __( 'Visit site', 'kalervo' ) . '</a></span>';
	
}

/**
* Get attachment images in flexslider and show it in singular portfolio_item page.
*
* @since  0.1.0
*/
function kalervo_display_slides() {

	if ( is_singular( 'portfolio_item' ) ) {

			$defaults = array(
			'order'          => 'ASC',
			'post_type'      => 'attachment',
			'post_parent'    => get_the_ID(),
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => -1,
		);

		$attachments = get_posts( apply_filters( 'kalervo_slides_args', $defaults ) );
				
		$output = '';

		if ( $attachments ) {

			$output .= '<div class="flexslider">';
				$output .= '<ul class="slides">';
			
					foreach ( $attachments as $attachment ) {
					$output .= '<li>';
						$output .= wp_get_attachment_image( $attachment->ID, 'kalervo-portfolio', false, false );
					$output .= '</li>';
				}

				$output .= '</ul>';
			$output .= '</div><!-- .flexslider -->';

		}
		
	return $output;
	
	}

}

/**
* Add new body class if there is attachments in singular portfolio item.
*
* @since  0.1.0
*/
function kalervo_add_body_attachments( $classes ) {

	if ( kalervo_check_attachments() )
		$classes[] = 'kalervo-portfolio-1';

	return $classes;
	
}

/**
* Add wrapper to download and portfolio archive
*
* @since  0.1.0
*/
function kalervo_add_wrapper() { 

	if ( is_post_type_archive( 'portfolio_item' ) || is_post_type_archive( 'download' ) || is_tax( 'portfolio' ) || is_tax( 'download_tag' ) || is_tax( 'download_category' ) )
		echo '<div class="kalervo-grid-wrapper">';

}

/**
* Add wrapper to download and portfolio archive
*
* @since  0.1.0
*/
function kalervo_end_wrapper() {

	if ( is_post_type_archive( 'portfolio_item' ) || is_post_type_archive( 'download' ) || is_tax( 'portfolio' ) || is_tax( 'download_tag' ) || is_tax( 'download_category' ) )
		echo '</div>';

}

/**
* Check if there is attachment in portfolio item.
*
* @since  0.1.0
*/
function kalervo_check_attachments() {

	if ( is_singular( 'portfolio_item' ) ) {

		$args = array(
			'post_type'      => 'attachment',
			'post_parent'    => get_the_ID(),
			'post_mime_type' => 'image',
			'post_status'    => null
		);

		$attachments = get_posts( $args );

		if ( $attachments )
			return true;
		else
			return false;

	}
	
}

?>