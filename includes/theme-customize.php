<?php
/**
 * Add logo upload, portfolio layout and social links in theme customizer screen.
 *
 * @package Tampereen sahko
 * @subpackage Includes
 * @since 0.1.0
 */

/* Add logo upload, portfolio layout and social links in theme customizer screen. */
add_action( 'customize_register', 'kalervo_customize_register_logo' );

/* Print font size in header. */
add_action( 'wp_head', 'kalervo_print_font_size' ) ;

/* Print some of the color palette styles separately so that we can use media queries around them. */
//add_action( 'wp_head', 'kalervo_print_extra_palette', 99 );

/* Delete the cached data for font size feature. And also for extra palette */
add_action( 'update_option_theme_mods_' . get_stylesheet(), 'kalervo_font_size_cache_delete' );

/* Delete the cached data for extra color palette. */
//add_action( 'update_option_theme_mods_' . get_stylesheet(), 'kalervo_color_palette_cache_delete' );


/**
 * Add logo upload, portfolio layout and social links in theme customizer screen
 *
 * @since 0.1.0
 */
function kalervo_customize_register_logo( $wp_customize ) {

	/* Add the logo upload section. */
	$wp_customize->add_section(
		'logo-upload',
		array(
			'title'      => esc_html__( 'Logo Upload', 'kalervo' ),
			'priority'   => 60,
			'capability' => 'edit_theme_options'
		)
	);
	
	/* Add the 'logo' setting. */
	$wp_customize->add_setting(
		'logo_upload',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add custom logo control. */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'logo_image',
				array(
					'label'    => esc_html__( 'Upload custom logo. Recommended max width is 300px.', 'kalervo' ),
					'section'  => 'logo-upload',
					'settings' => 'logo_upload',
			) 
		) 
	);
	
/* == Font size == */
	
	/* Add font size setting. */
	$wp_customize->add_setting(
		'font_size',
		array(
			'default'           => '14',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'absint',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add font size control. */
	$wp_customize->add_control(
		'font-size-control',
		array(
			'label'    => esc_html__( 'Choose Body Font Size (pixels)', 'kalervo' ),
			'section'  => 'fonts',
			'settings' => 'font_size',
			'type'     => 'select',
			'choices'  => array(
				'13'       => esc_html__( '13', 'kalervo' ),
				'14'       => esc_html__( '14', 'kalervo' ),
				'15'       => esc_html__( '15', 'kalervo' ),
				'16'       => esc_html__( '16', 'kalervo' ),
				'17'       => esc_html__( '17', 'kalervo' ),
				'18'       => esc_html__( '18', 'kalervo' ),
				'19'       => esc_html__( '19', 'kalervo' ),
			)
		)
	);
	
	/* == Show header image or Soliloquy Slider == */
	
	/* Add setting do you want to show header image or Soliloquy Slider. */
	$wp_customize->add_setting(
		'show_header_slider',
		array(
			'default'           => 'header',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_html_class',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Header image or Soliloquy Slider control. */
	
	if ( post_type_exists( 'soliloquy' ) ) {
		$kalervo_show_header_slider_label = esc_html__( 'Choose whether to show Header Image or Soliloquy Slider in Header?', 'kalervo' );
	} else {
		$kalervo_show_header_slider_label = esc_html__( 'Choose whether to show Header Image or Soliloquy Slider in Header? Note! You need to install and activate Soliloquy Slider Plugin first.', 'kalervo' );
	}
	
	$wp_customize->add_control(
		'show-header-slider',
		array(
			'label'    => $kalervo_show_header_slider_label,
			'section'  => 'layout',
			'settings' => 'show_header_slider',
			'type'     => 'radio',
			'priority' => 10,
			'choices'  => array(
				'header'     => esc_html__( 'Show Header image', 'kalervo' ),
				'slider'   => esc_html__( 'Show Soliloquy Slider', 'kalervo' )
			)
		)
	);
	
	/* Add the Soliloquy Slider setting. */
	
	/* Get Slider choices if Soliloquy plugin is activated. */
	if ( post_type_exists( 'soliloquy' ) ) {
	
		$kalervo_soliloquy_slider_choices = kalervo_get_soliloquy_slider_choices();
	
		$wp_customize->add_setting(
			'soliloquy_slider',
			array(
				'default'           => 0,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
				//'transport'         => 'postMessage'
			)
		);
	
		/* Add the Soliloquy Slider control. */
		$wp_customize->add_control(
			'soliloquy-slider-control',
			array(
				'label'    => esc_html__( 'Select Soliloquy Slider', 'kalervo' ),
				'section'  => 'layout',
				'settings' => 'soliloquy_slider',
				'type'     => 'select',
				'choices'  => $kalervo_soliloquy_slider_choices
			)
		);
	
		/* Add front page callout section. */
		$wp_customize->add_section(
			'front-page-callout',
			array(
				'title'      => esc_html__( 'Front Page Callout', 'kalervo' ),
				'priority'   => 210,
				'capability' => 'edit_theme_options'
			)
		);
	}
	
	/* Add the callout text setting. */
	$wp_customize->add_setting(
		'callout_text',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the callout text control. */
	$wp_customize->add_control(
		'callout-text',
		array(
			'label'    => esc_html__( 'Callout text', 'kalervo' ),
			'section'  => 'front-page-callout',
			'settings' => 'callout_text',
			'priority' => 10,
			'type'     => 'text'
		)
	);
	
	/* Add the callout link setting. */
	$wp_customize->add_setting(
		'callout_url',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the callout link control. */
	$wp_customize->add_control(
		'callout-url',
		array(
			'label'    => esc_html__( 'Callout URL', 'kalervo' ),
			'section'  => 'front-page-callout',
			'settings' => 'callout_url',
			'priority' => 20,
			'type'     => 'text'
		)
	);
	
	/* Add the callout url text setting. */
	$wp_customize->add_setting(
		'callout_url_text',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the callout url text control. */
	$wp_customize->add_control(
		'callout-url-text',
		array(
			'label'    => esc_html__( 'Callout URL text', 'kalervo' ),
			'section'  => 'front-page-callout',
			'settings' => 'callout_url_text',
			'priority' => 30,
			'type'     => 'text'
		)
	);

}

/**
* Print font size in header.
*
* @since 0.1.0
*/
function kalervo_print_font_size() {

	if ( get_theme_mod( 'font_size' ) ) {
	
		/* Get the cached font size. */
		$kalervo_cached_font_size = wp_cache_get( 'kalervo_font_size_cache' );

		/* If the style is available, output it and return. */
		if ( !empty( $kalervo_cached_font_size ) ) {
			echo $kalervo_cached_font_size;
			return;
		}
		
		/* Get font size. */
		$kalervo_font_size_px = absint( get_theme_mod( 'font_size', 16 ) );
		
		/* Calculate as % value. Base is 16px. Round in 8 decimals. */
		$kalervo_font_size_procent = round( $kalervo_font_size_px / 16 * 100, 8 );
		
		$kalervo_font_size = " html { font-size: {$kalervo_font_size_procent}%; } ";
		
		/* Add some extra for large screens. */
		$kalervo_font_size_procent_4 = $kalervo_font_size_procent + 4;
		$kalervo_font_size_procent_8 = $kalervo_font_size_procent + 10;
		
		/* Minimum width of 1512 pixels. */
		$kalervo_font_size .= " @media screen and (min-width: 108em) { html { font-size: {$kalervo_font_size_procent_4}%; } } ";
		
		/* Minimum width of 1952 pixels. */
		$kalervo_font_size .= " @media screen and (min-width: 122em) { html { font-size: {$kalervo_font_size_procent_8}%; } } ";
		
		$kalervo_font_size_echo = "\n" . '<style type="text/css" id="font-size-css">' . trim( $kalervo_font_size ) . '</style>' . "\n";
		
		/* Cache the font size, so we don't have to process this on each page load. */
		wp_cache_set( 'kalervo_font_size_cache', $kalervo_font_size_echo );

		/* Output the custom style. */
		echo $kalervo_font_size_echo;
	
	}

}

/**
* Print color palette so we can use media queries.
*
* @since 0.1.0
*/
function kalervo_print_extra_palette() {

	if ( get_theme_mod( 'color_palette_menu_primary' ) ) {
	
		/* Get the cached font size. */
		$kalervo_cached_color_palette = wp_cache_get( 'kalervo_color_palette_cache' );

		/* If the style is available, output it and return. */
		if ( !empty( $kalervo_cached_color_palette ) ) {
			echo $kalervo_cached_color_palette;
			return;
		}
		
		/* Get primary menu color. */
		$kalervo_color_primary_menu = get_theme_mod( 'color_palette_menu_primary', 303030 );
		
		/* Minimum width of 49em. */
		$kalervo_color_primary_menu_media = " @media screen and (min-width: 49em) { #menu-primary, #menu-primary ul li:hover li a, #menu-primary ul li.iehover li a, #menu-primary ul li:hover li:hover li a, #menu-primary ul li.iehover li.iehover li a, #menu-primary ul li:hover li:hover li:hover li a, #menu-primary ul li.iehover li.iehover li.iehover li a { background-color: #{$kalervo_color_primary_menu}; } } ";
		
		$kalervo_color_primary_menu_media_echo = "\n" . '<style type="text/css" id="kalervo-primary-menu">' . trim( $kalervo_color_primary_menu_media ) . '</style>' . "\n";
		
		/* Cache the colors, so we don't have to process this on each page load. */
		wp_cache_set( 'kalervo_color_palette_cache', $kalervo_color_primary_menu_media_echo );

		/* Output the custom style. */
		echo $kalervo_color_primary_menu_media_echo;
		
	}

}

/**
* Delete cache for font size.
*
* @since 0.1.0
*/
function kalervo_font_size_cache_delete() {

	wp_cache_delete( 'kalervo_font_size_cache' );
	
}

/**
* Delete cache for extra color palette.
*
* @since 0.1.0
*/
function kalervo_color_palette_cache_delete() {

	wp_cache_delete( 'kalervo_color_palette_cache' );
	
}

/**
 * Registers custom fonts for the Theme Fonts extension.
 *
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2013, Justin Tadlock
 * @since  0.1.0
 * @access public
 * @param  object  $theme_fonts
 * @return void
 */
function kalervo_register_headlines_fonts( $theme_fonts ) {

	/* Add the 'body' font setting. */
	$theme_fonts->add_setting(
		array(
			'id'        => 'body',
			'label'     => __( 'Body Font', 'kalervo' ),
			'default'   => 'helvetica-font-stack',
			'selectors' => 'body',
		)
	);
	
	/* Add the 'headlines' font setting. */
	$theme_fonts->add_setting(
		array(
			'id'        => 'headlines',
			'label'     => __( 'Headline Font', 'kalervo' ),
			'default'   => 'roboto-condensed',
			'selectors' => 'h1, h2, h3, h4, h5, h6',
		)
	);

	/* Add fonts that users can select for this theme. */

	$theme_fonts->add_font(
		array(
			'handle' => 'trebuchet-font-stack',
			'label'  => __( 'Trebuchet (font stack)', 'kalervo' ),
			'stack'  => '"Segoe UI", Candara, "Bitstream Vera Sans", "DejaVu Sans", "Bitstream Vera Sans", "Trebuchet MS", Verdana, "Verdana Ref", sans-serif'
		)
	);
	
	$theme_fonts->add_font(
		array(
			'handle' => 'arial',
			'label'  => __( 'Arial (font stack)', 'kalervo' ),
			'stack'  => 'Arial, Helvetica, sans-serif'
		)
	);
	
	$theme_fonts->add_font(
		array(
			'handle' => 'lucida-sans-unicode',
			'label'  => __( 'Lucida Sans Unicode (font stack)', 'kalervo' ),
			'stack'  => '"Lucida Sans Unicode", "Lucida Grande", sans-serif'
		)
	);
	
	$theme_fonts->add_font(
		array(
			'handle' => 'georgia-font-stack',
			'label'  => __( 'Georgia (font stack)', 'kalervo' ),
			'stack'  => 'Georgia, Palatino, "Palatino Linotype", "Book Antiqua", serif',
		)
	);
	
	$theme_fonts->add_font(
		array(
			'handle' => 'helvetica-font-stack',
			'label'  => __( 'Helvetica (font stack)', 'kalervo' ),
			'stack'  => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		)
	);
	
	$theme_fonts->add_font(
		array(
			'handle' => 'merriweather-sans',
			'label'  => __( 'Merriweather Sans', 'kalervo' ),
			'family' => 'Merriweather Sans',
			'stack'  => "'Merriweather Sans', sans-serif",
			'type'   => 'google'
		)
	);
	
	$theme_fonts->add_font(
		array(
			'handle' => 'roboto-condensed',
			'label'  => __( 'Roboto Condensed', 'kalervo' ),
			'family' => 'Roboto Condensed',
			'stack'  => "'Roboto Condensed', sans-serif",
			'type'   => 'google'
		)
	);

	$theme_fonts->add_font(
		array(
			'handle' => 'arvo',
			'label'  => __( 'Arvo', 'kalervo' ),
			'family' => 'Arvo',
			'stack'  => 'Arvo, serif',
			'type'   => 'google'
		)
	);
	
	$theme_fonts->add_font(
		array(
			'handle' => 'muli',
			'label'  => __( 'Muli', 'kalervo' ),
			'family' => 'Muli',
			'stack'  => "Muli, sans-serif",
			'type'   => 'google'
		)
	);
	
	$theme_fonts->add_font(
		array(
			'handle' => 'open-sans',
			'label'  => __( 'Open Sans', 'kalervo' ),
			'family' => 'Open Sans',
			'stack'  => "'Open Sans', sans-serif",
			'type'   => 'google'
		)
	);
	
	$theme_fonts->add_font(
		array(
			'handle' => 'open-sans-condensed-700',
			'label'  => __( 'Open Sans Condensed (700)', 'kalervo' ),
			'family' => 'Open Sans Condensed',
			'weight' => '700',
			'stack'  => "'Open Sans Condensed', sans-serif",
			'type'   => 'google'
		)
	);
	
}

/**
 * Registers colors for the Color Palette extension.
 *
 * @since  0.1.0
 * @access public
 * @param  object  $color_palette
 * @return void
 */
function kalervo_register_colors( $color_palette ) {

	/* Add custom colors. */
	
	/* Body. */
	$color_palette->add_color(
		array( 'id' => 'body', 'label' => __( 'Body color', 'kalervo' ), 'default' => '303030' )
	);
	
	/* Container. */
	$color_palette->add_color(
		array( 'id' => 'container', 'label' => __( 'Container color', 'kalervo' ), 'default' => 'fff' )
	);
	
	/* Primary menu. */
	$color_palette->add_color(
		array( 'id' => 'menu_primary', 'label' => __( 'Primary menu color', 'kalervo' ), 'default' => '303030' )
	);
	
	$color_palette->add_color(
		array( 'id' => 'menu_primary_hover', 'label' => __( 'Primary menu hover color', 'kalervo' ), 'default' => '121212' )
	);
	
	$color_palette->add_color(
		array( 'id' => 'menu_primary_link', 'label' => __( 'Primary menu link color', 'kalervo' ), 'default' => 'fff' )
	);
	
	/* Links. */
	$color_palette->add_color(
		array( 'id' => 'link', 'label' => __( 'Link color', 'kalervo' ), 'default' => 'cc071e' )
	);
	
	$color_palette->add_color(
		array( 'id' => 'link_hover', 'label' => __( 'Link color hover', 'kalervo' ), 'default' => '191919' )
	);
	
	/* Buttons etc. */
	$color_palette->add_color(
		array( 'id' => 'button', 'label' => __( 'Buttons color', 'kalervo' ), 'default' => '191919' )
	);
	
	$color_palette->add_color(
		array( 'id' => 'button_hover', 'label' => __( 'Buttons color hover', 'kalervo' ), 'default' => 'cc071e' )
	);
	
	/* Callout Button. */
	$color_palette->add_color(
		array( 'id' => 'callout_button', 'label' => __( 'Callout button color', 'kalervo' ), 'default' => 'fff' )
	);
	
	$color_palette->add_color(
		array( 'id' => 'callout_button_bg', 'label' => __( 'Callout button background color', 'kalervo' ), 'default' => 'cc071e' )
	);
	
	$color_palette->add_color(
		array( 'id' => 'callout_button_hover', 'label' => __( 'Callout button background color hover', 'kalervo' ), 'default' => '303030' )
	);
	
	/* Titles. */
	$color_palette->add_color(
		array( 'id' => 'title', 'label' => __( 'Site title and entry title color', 'kalervo' ), 'default' => '191919' )
	);
	
	$color_palette->add_color(
		array( 'id' => 'widget_title', 'label' => __( 'Widget title and forms text color', 'kalervo' ), 'default' => '555' )
	);
	
	/* Entrys. */
	$color_palette->add_color(
		array( 'id' => 'entry', 'label' => __( 'Byline, meta, widget, secondary/subsidiary menu links etc. color', 'kalervo' ), 'default' => '777' )
	);

	/* Add rule sets. */
		
	$color_palette->add_rule_set(
		'body',
		array(
			'color'               => 'body'
		)
	);
	
	$color_palette->add_rule_set(
		'container',
		array(
			'background-color'    => '#container, .widget-search input[type="text"]:focus, input[type="text"]:focus, input[type="password"]:focus, input[type="email"]:focus, input[type="tel"]:focus, input[type="url"]:focus, textarea:focus, body #edd_checkout_form_wrap input[type="text"]:focus, body #edd_checkout_form_wrap input[type="email"]:focus, body #edd_checkout_form_wrap input[type="password"]:focus, #respond input[type="text"]:focus, #respond textarea:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=text]:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=email]:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=tel]:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=url]:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=number]:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=password]:focus, body .gform_wrapper .gform_body .gform_fields .gfield textarea:focus, table, th'
		)
	);

	$color_palette->add_rule_set(
		'menu_primary',
		array(
			'background-color'    => '#menu-primary, #menu-primary ul li:hover li a, #menu-primary ul li.iehover li a, #menu-primary ul li:hover li:hover li a, #menu-primary ul li.iehover li.iehover li a, #menu-primary ul li:hover li:hover li:hover li a, #menu-primary ul li.iehover li.iehover li.iehover li a, .loop-nav a, .pagination .page-numbers, .page-links a, a.more-link, a.kalervo-portfolio-item-link, a.kalervo-portfolio-item-link:visited, a.kalervo-button, .edd-submit.button.kalervo-theme-color'
		)
	);
	
	$color_palette->add_rule_set(
		'menu_primary_hover',
		array(
			'background-color'    => '#menu-primary ul a:hover, #menu-primary ul li:hover a, #menu-primary li.current-menu-item a, #menu-primary ul li.iehover a, #menu-primary ul.sub-menu li.current-menu-item a, #menu-primary ul li.iehover li.current-menu-item a, #menu-primary ul li:hover li a:hover, #menu-primary ul li:hover li:hover a, #menu-primary ul li.iehover li a:hover, #menu-primary ul li.iehover li.iehover a, #menu-primary ul li:hover li:hover li.current-menu-item a, #menu-primary ul li.iehover li.iehover li.current-menu-item a, #menu-primary ul li:hover li:hover li a:hover, #menu-primary ul li:hover li:hover li:hover a, #menu-primary ul li.iehover li.iehover li a:hover, #menu-primary ul li.iehover li.iehover li.iehover a, #menu-primary ul li:hover li:hover li:hover li.current-menu-item a, #menu-primary ul li.iehover li.iehover li.iehover li.current-menu-item a, #menu-primary ul li:hover li:hover li:hover li a:hover, #menu-primary ul li.iehover li.iehover li.iehover li a:hover'
		)
	);
	
	$color_palette->add_rule_set(
		'menu_primary_link',
		array(
			'color'               => '#kalervo-header-image #kalervo-header-title, #kalervo-header-title a.kalervo-button, .menu-toggle, input[type="submit"], #respond #submit, .loop-nav a, .loop-nav a:visited, .pagination .page-numbers, .page-links a, .page-links a:visited, a.more-link, a.kalervo-portfolio-item-link, a.kalervo-button, .edd-submit.button.kalervo-theme-color, .pagination .current, body .gform_wrapper .gform_body .gform_page_footer .gform_next_button, body .gform_wrapper .gform_body .gform_page_footer .gform_previous_button, #menu-primary ul a, #menu-primary ul a:hover, #menu-primary ul li:hover a, #menu-primary li.current-menu-item a, #menu-primary ul li.iehover a, #menu-primary ul li:hover li a, #menu-primary ul li.iehover li a, #menu-primary ul.sub-menu li.current-menu-item a, #menu-primary ul li.iehover li.current-menu-item a, #menu-primary ul li:hover li a:hover, #menu-primary ul li:hover li:hover a, #menu-primary ul li.iehover li a:hover, #menu-primary ul li.iehover li.iehover a, #menu-primary ul li:hover li:hover li a,#menu-primary ul li.iehover li.iehover li a, #menu-primary ul li:hover li:hover li.current-menu-item a, #menu-primary ul li.iehover li.iehover li.current-menu-item a, #menu-primary ul li:hover li:hover li a:hover, #menu-primary ul li:hover li:hover li:hover a, #menu-primary ul li.iehover li.iehover li a:hover, #menu-primary ul li.iehover li.iehover li.iehover a, #menu-primary ul li:hover li:hover li:hover li a, #menu-primary ul li.iehover li.iehover li.iehover li a, #menu-primary ul li:hover li:hover li:hover li.current-menu-item a, #menu-primary ul li.iehover li.iehover li.iehover li.current-menu-item a, #menu-primary ul li:hover li:hover li:hover li a:hover, #menu-primary ul li.iehover li.iehover li.iehover li a:hover',
		)
	);
	
	
	$color_palette->add_rule_set(
		'link',
		array(
			'color'               => 'a, a:visited'
		)
	);

	$color_palette->add_rule_set(
		'link_hover',
		array(
			'color'               => 'a:focus, a:active, a:hover, #footer a:focus, #footer a:active, #footer a:hover'
		)
	);
	
	$color_palette->add_rule_set(
		'button',
		array(
			'color'               => '#menu-secondary li a:hover, #menu-subsidiary li a:hover, #menu-secondary li.current-menu-item a, #menu-subsidiary li.current-menu-item a',
			'background-color'    => '.menu-toggle, input[type="submit"], #respond #submit, body .gform_wrapper .gform_body .gform_page_footer .gform_next_button, body .gform_wrapper .gform_body .gform_page_footer .gform_previous_button, #kalervo-header-image',
			'border-color'        => '.widget-search input[type="text"]:focus, input[type="text"]:focus, input[type="password"]:focus, input[type="email"]:focus, input[type="tel"]:focus, input[type="url"]:focus, textarea:focus, body #edd_checkout_form_wrap input[type="text"]:focus, body #edd_checkout_form_wrap input[type="email"]:focus, body #edd_checkout_form_wrap input[type="password"]:focus, #respond input[type="text"]:focus, #respond textarea:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=text]:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=email]:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=tel]:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=url]:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=number]:focus, body .gform_wrapper .gform_body .gform_fields .gfield input[type=password]:focus, body .gform_wrapper .gform_body .gform_fields .gfield textarea:focus',
			'border-left-color'   => 'blockquote'
		)
	);
	
	$color_palette->add_rule_set(
		'button_hover',
		array(
			'background-color'    => '.menu-toggle:hover, input[type="submit"]:hover, #respond #submit:hover, .menu-toggle:active, .menu-toggle.toggled-on, input[type="submit"]:active, input[type="submit"].toggled-on, .loop-nav a:hover, .page-links a:hover, .pagination  a.page-numbers:hover, a.more-link:hover, a.kalervo-portfolio-item-link:hover, .pagination .current, body .gform_wrapper .gform_body .gform_page_footer .gform_next_button:hover, body .gform_wrapper .gform_body .gform_page_footer .gform_previous_button:hover, .edd-submit.button.kalervo-theme-color:hover'
		)
	);
	
	$color_palette->add_rule_set(
		'callout_button',
		array(
			'color'    => '#kalervo-callout-url #kalervo-callout-text, #kalervo-callout-url .kalervo-callout-button'
		)
	);
	
	$color_palette->add_rule_set(
		'callout_button_bg',
		array(
			'background-color'    => '#kalervo-callout-url .kalervo-callout-button'
		)
	);

	$color_palette->add_rule_set(
		'callout_button_hover',
		array(
			'background-color'    => '#kalervo-callout-url .kalervo-callout-button:hover, #kalervo-callout-url .kalervo-callout-button:focus'
		)
	);
	
	$color_palette->add_rule_set(
		'title',
		array(
			'color'               => '#site-title a, .entry-title a, .entry-title'
		)
	);
	
	$color_palette->add_rule_set(
		'widget_title',
		array(
			'color'               => 'code, pre, .wp-caption-text, .widget-title, .comment-meta, .comment-text .moderation, #respond input[type="text"], #respond textarea, .widget-search input[type="text"], input[type="text"], input[type="password"], input[type="email"], input[type="tel"], input[type="url"], textarea, body #edd_checkout_form_wrap input[type="text"], body #edd_checkout_form_wrap input[type="email"], body #edd_checkout_form_wrap input[type="password"], body .gform_wrapper .gform_body .gform_fields .gfield .gfield_description, body .gform_wrapper .gform_body .gform_fields .gsection .gsection_description, body .gform_wrapper .gform_body .gform_fields .gfield .ginput_complex label, body .gform_wrapper .instruction, body .gform_wrapper .gform_body .gform_fields .gfield input[type=text], body .gform_wrapper .gform_body .gform_fields .gfield input[type=email], body .gform_wrapper .gform_body .gform_fields .gfield input[type=tel], body .gform_wrapper .gform_body .gform_fields .gfield input[type=url], body .gform_wrapper .gform_body .gform_fields .gfield input[type=number], body .gform_wrapper .gform_body .gform_fields .gfield input[type=password], body .gform_wrapper .gform_body .gform_fields .gfield textarea, body .gform_wrapper .gform_body .gform_fields .gfield input.medium'
		)
	);
	
	$color_palette->add_rule_set(
		'entry',
		array(
			'color'               => '#site-description, .breadcrumbs .trail-end, .entry-byline, .entry-meta, .loop-meta .loop-description, .format-gallery .kalervo-image-count, #sidebar-header .widget, #sidebar-primary .widget, #sidebar-subsidiary .widget, #sidebar-front-page .widget, .gallery-caption, .comments-closed, dl dd, blockquote, #menu-secondary li a, #menu-subsidiary li a, .woocommerce-pagination a, #menu-secondary li a:visited, #menu-subsidiary li a:visited, .woocommerce-pagination a:visited'
		)
	);

}

/**
* Return Soliloquy Slider choices.
*
* @since 0.1.0
*/
function kalervo_get_soliloquy_slider_choices() {
	
	/* Set an array. */
	$kalervo_slider_data = array(
		0 => __( 'Select Slider', 'kalervo' )
	);
	
	/* Get Soliloquy Sliders. */
	$kalervo_soliloquy_args = array(
		'post_type' 		=> 'soliloquy',
		'posts_per_page' 	=> -1
	);
	
	$kalervo_sliders = get_posts( $kalervo_soliloquy_args );
	
	/* Loop sliders data. */
	foreach ( $kalervo_sliders as $kalervo_slider ) {
		$kalervo_slider_data[$kalervo_slider->ID] = $kalervo_slider->post_title;
	}
	
	/* Return array. */
	return $kalervo_slider_data;
	
}

?>