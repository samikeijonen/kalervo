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
 * @copyright   Copyright (c) 2014, Sami Keijonen
 * @link        https://foxnet-themes.fi
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
 
/* Load Hybrid Core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/* Add support for a custom header image. */
require trailingslashit( get_template_directory() ) . 'includes/custom-header.php';

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
	
	/* Add theme settings. */
	if ( is_admin() )
	    require_once( trailingslashit ( get_template_directory() ) . 'admin/functions-admin.php' );
		
	/* Include theme customize. */
	require_once( trailingslashit( get_template_directory() ) . 'includes/theme-customize.php' );
	
	/* Include EDD functions. */
	require_once( trailingslashit( get_template_directory() ) . 'includes/edd-functions.php' );

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary', 'secondary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );
	add_theme_support( 'hybrid-core-scripts', array( 'comment-reply' ) );
	add_theme_support( 'hybrid-core-styles', array( 'parent', 'style' ) );
	add_theme_support( 'hybrid-core-template-hierarchy' );
	
	/* Add theme support for framework extensions. */
	add_theme_support( 'theme-layouts', array( '1c', '2c-l', '2c-r' ), array( 'default' => '1c', 'customizer' => true ) );
	add_theme_support( 'post-stylesheets' );
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-gallery' );
	add_theme_support( 'cleaner-caption' );
	add_theme_support( 'featured-header' );
	
	/* Add theme support for theme fonts. */
	add_theme_support( 'theme-fonts', array( 'callback' => 'kalervo_register_headlines_fonts', 'customizer' => true ) );
	
	/* Add theme support for theme color palette. */
	add_theme_support( 'color-palette', array( 'callback' => 'kalervo_register_colors' ) );
	
	/* Add theme support for WordPress features. */
	
	/* Add support for auto-feed links. */
	add_theme_support( 'automatic-feed-links' );

	/* Post formats. */
	add_theme_support( 
		'post-formats',
		array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) 
	);
	
	/* Add custom background feature. */
	add_theme_support( 
		'custom-background',
		array(
			'default-color' => 'ececec', // Background default color
			'wp-head-callback' => 'kalervo_custom_background_callback'
		)
	);
	
	/* Set up Licence key for this theme. URL: https://easydigitaldownloads.com/docs/activating-license-keys-in-wp-plugins-and-themes */
 
	/* This is the URL our updater / license checker pings. This should be the URL of the site with EDD installed. */
	define( 'KALERVO_SL_STORE_URL', 'http://foxnet-themes.fi' ); // use your own unique prefix to prevent conflicts

	/* The name of your product. This should match the download name in EDD exactly. */
	define( 'KALERVO_SL_THEME_NAME', 'Kalervo' ); // use your own unique prefix to prevent conflicts
	
	/* Define current version of kalervo. Get it from parent theme style.css. */
	$kalervo_theme = wp_get_theme( 'kalervo' );
	if ( $kalervo_theme->exists() ) {
		define( 'KALERVO_VERSION', $kalervo_theme->Version ); // Get parent theme kalervo version
	}
	
	/* Setup updater. */
	add_action( 'admin_init', 'kalervo_theme_updater' );
	
	/* Set content width. */
	hybrid_set_content_width( 604 );
	add_filter( 'embed_defaults', 'kalervo_embed_defaults' );
	
	/* Add respond.js and  html5shiv.js for unsupported browsers. */
	add_action( 'wp_head', 'kalervo_respond_html5shiv' );
	
	/* Add custom image sizes. */
	add_action( 'init', 'kalervo_add_image_sizes' );
	
	/* Add custom names for custom image sizes. */
	add_filter( 'image_size_names_choose', 'kalervo_custom_name_image_sizes' );
	
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
	
	/* Register sidebars. */
	add_action( 'widgets_init', 'kalervo_register_sidebars' );
	
	/* Remove the "Theme Settings" submenu. */
	add_action( 'admin_menu', 'kalervo_remove_theme_settings_submenu', 11 );
	
	/* Add menu-item-parent class to parent menu items.  */
	add_filter( 'wp_nav_menu_objects', 'kalervo_add_menu_parent_class' );
	
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
	
	/* Add right wrappers for the theme. */
	add_action( 'woocommerce_before_main_content', 'kalervo_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'kalervo_wrapper_end', 10 );
	
	/* Filter no_id string in soliloquy. */
	add_filter( 'tgmsp_strings', 'kalervo_soliloquy_no_id_string' );

}

/**
 * Setup theme updater. @link https://gist.github.com/pippinsplugins/3ab7c0a01d5a9d8005ed
 *
 * @since  0.1.0
 */
function kalervo_theme_updater() {

	/* If there is no valid license key status, don't let updates. */
	if( get_option( 'kalervo_theme_license_key_status' ) != 'valid' )
		return;

	/* Load our custom theme updater. */
	if( !class_exists( 'EDD_SL_Theme_Updater' ) )
		require_once( trailingslashit( get_template_directory() ) . 'includes/EDD_SL_Theme_Updater.php' );
	
	/* Get license key from database. */
	$kalervo_license = trim( get_option( 'kalervo_theme_license_key' ) );

	$edd_updater = new EDD_SL_Theme_Updater( array( 
		'remote_api_url' 	=> KALERVO_SL_STORE_URL, 	// our store URL that is running EDD
		'version' 			=> KALERVO_VERSION, 		// the current theme version we are running
		'license' 			=> $kalervo_license, 		// the license key (used get_option above to retrieve from DB)
		'item_name' 		=> KALERVO_SL_THEME_NAME,	// the name of this theme
		'author'			=> 'Sami Keijonen'	        // the author's name
		)
	);

}

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What 
 * happens is the theme's background image hides the user-selected background color.  If a user selects a 
 * background image, we'll just use the WordPress custom background callback.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2013, Justin Tadlock
 * @since  0.1.0
 * @access public
 * @link http://core.trac.wordpress.org/ticket/16919
 * @return void
 */
function kalervo_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) )
		return;

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

?>
<style type="text/css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php

}

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
	
}

/**
 * Adds custom names for custom image sizes.
 *
 * @since 0.1.0
 */
function kalervo_custom_name_image_sizes( $sizes ) {

    $sizes['kalervo-thumbnail-portfolio'] = __( 'Portfolio Thumbnail', 'kalervo' );
	
    return $sizes;
}

/**
 * Enqueues scripts and styles.
 *
 * @since 0.1.0
 */
function kalervo_scripts_styles() {
	
		/* Enqueue FitVids. */
		wp_enqueue_script( 'kalervo-fitvids', trailingslashit( get_template_directory_uri() ) . 'js/fitvids/jquery.fitvids.min.js', array( 'jquery' ), '20130707', true );
		
		/* Enqueue Kalervo settings. */
		wp_enqueue_script( 'kalervo-settings', trailingslashit( get_template_directory_uri() ) . 'js/settings/kalervo-settings.js', array( 'jquery', 'kalervo-fitvids' ), '20130707', true );
	
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

	elseif ( is_page_template( 'page-templates/front-page.php' ) || is_page_template( 'page-templates/post-page.php' ) || is_page_template( 'page-templates/download-page.php' ) || is_page_template( 'page-templates/portfolio-page.php' ) || is_page_template( 'page-templates/slider-page.php' ) )
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
	
	if ( is_active_sidebar( 'front-page' ) && ( is_page_template( 'page-templates/front-page.php' ) || is_page_template( 'page-templates/post-page.php' ) || is_page_template( 'page-templates/download-page.php' ) || is_page_template( 'page-templates/portfolio-page.php' ) || is_page_template( 'page-templates/slider-page.php' ) ) ) {
		
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

	wp_enqueue_script( 'kalervo-customizer', trailingslashit( get_template_directory_uri() ) . 'js/customize/kalervo-customizer.js', array( 'customize-preview' ), '20130707', true );
	
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
		wp_enqueue_style( 'kalervo-customizer-stylesheet', trailingslashit( get_template_directory_uri() ) . 'css/customize/kalervo-customizer.css', false, '20130707', 'all' );
}

/**
 * Register additional sidebar to 'front page' page template.
 * 
 * @since 0.1.0
 */
function kalervo_register_sidebars() {

	/* Register sidebars. */
	$sidebar_header_args = array(
		'id'            => 'header',
		'name'          => _x( 'Header', 'sidebar', 'kalervo' ),
		'description'   => __( 'A sidebar located in the top of the site.', 'kalervo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	);
	$sidebar_primary_args = array(
		'id'            => 'primary',
		'name'          => _x( 'Primary', 'sidebar', 'kalervo' ),
		'description'   => __( 'The main sidebar. It is displayed on either the left or right side of the page based on the chosen layout.', 'kalervo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
		
	);
	$sidebar_subsidiary_args = array(
		'id'            => 'subsidiary',
		'name'          => _x( 'Subsidiary', 'sidebar', 'kalervo' ),
		'description'   => __( 'A sidebar located in the footer of the site.', 'kalervo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	);
	$sidebar_front_page_args = array(
		'id'            => 'front-page',
		'name'          => _x( 'Front Page Widget', 'sidebar', 'kalervo' ),
		'description'   => __( 'Front Page widget area.', 'kalervo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap widget-inside">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	);
	
	register_sidebar( $sidebar_header_args );
	register_sidebar( $sidebar_primary_args );
	register_sidebar( $sidebar_subsidiary_args );
	register_sidebar( $sidebar_front_page_args );

}

/**
 * Remove the "Theme Settings" submenu.
 *
 * @since 0.1.0
 */
function kalervo_remove_theme_settings_submenu() {

	/* Remove the Theme Settings settings page. */
	remove_submenu_page( 'themes.php', 'theme-settings' );
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

	$kalervo_current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	$strings['no_id'] = sprintf( __( 'No slider was selected. Please select a Slider under <a href="%s"> Appearance &gt; Customize &gt; Layout</a>.', 'kalervo' ), add_query_arg( 'url', urlencode( $kalervo_current_url ), wp_customize_url() ) );

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

	$kalervo_content = get_the_content();

	$kalervo_url = get_url_in_content( $kalervo_content );

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

?>