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
	
	/* Add the portfolio layout setting. */
	$wp_customize->add_setting(
		'portfolio_layout',
		array(
			'default'           => '3',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'absint',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the portfolio layout control. */
	$wp_customize->add_control(
		'portfolio-layout-control',
		array(
			'label'    => esc_html__( 'Portfolio Layout', 'kalervo' ),
			'section'  => 'layout',
			'settings' => 'portfolio_layout',
			'type'     => 'radio',
			'choices'  => array(
				'3' => esc_html__( 'Three Columns', 'kalervo' ),
				'4' => esc_html__( 'Four Columns', 'kalervo' )
			)
		)
	);
	
	/* == Show header image or Soliloque Slider == */
	
	/* Add setting do you want to show header image or Soliloque Slider. */
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
	
	/* Header image or Soliloque Slider control. */
	$wp_customize->add_control(
		'show-header-slider',
		array(
			'label'    => esc_html__( 'Choose whether to show Header Image or Soliloque Slider in Header?', 'kalervo' ),
			'section'  => 'layout',
			'settings' => 'show_header_slider',
			'type'     => 'radio',
			'priority' => 10,
			'choices'  => array(
				'header'     => esc_html__( 'Show Header image', 'kalervo' ),
				'slider'   => esc_html__( 'Show Slider', 'kalervo' )
			)
		)
	);
	
	/* Add the Soliloque Slider setting. */
	
	/* Get Slider choices. */
	$kalervo_soliloquy_slider_choices = kalervo_get_soliloquy_slider_choices();
	
	$wp_customize->add_setting(
		'soliloquy_slider',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'absint',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the Soliloque Slider control. */
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
		
	/* Add the social links section. */
	$wp_customize->add_section(
		'social-links',
		array(
			'title'      => esc_html__( 'Social Links', 'kalervo' ),
			'priority'   => 200,
			'capability' => 'edit_theme_options'
		)
	);
	
	/* Add the twitter link setting. */
	$wp_customize->add_setting(
		'twitter_link',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the twitter link control. */
	$wp_customize->add_control(
		'twitter-link',
		array(
			'label'    => esc_html__( 'Twitter URL', 'kalervo' ),
			'section'  => 'social-links',
			'settings' => 'twitter_link',
			'priority' => 10,
			'type'     => 'text'
		)
	);
	
	/* Add the facebook link setting. */
	$wp_customize->add_setting(
		'facebook_link',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the facebook link control. */
	$wp_customize->add_control(
		'facebook-link',
		array(
			'label'    => esc_html__( 'Facebook URL', 'kalervo' ),
			'section'  => 'social-links',
			'settings' => 'facebook_link',
			'priority' => 20,
			'type'     => 'text'
		)
	);
	
	/* Add the rss link setting. */
	$wp_customize->add_setting(
		'rss_link',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the rss link control. */
	$wp_customize->add_control(
		'rss-link',
		array(
			'label'    => esc_html__( 'RSS URL', 'kalervo' ),
			'section'  => 'social-links',
			'settings' => 'rss_link',
			'priority' => 30,
			'type'     => 'text'
		)
	);
	
	/* Add the linkedin link setting. */
	$wp_customize->add_setting(
		'linkedin_link',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the linkedin link control. */
	$wp_customize->add_control(
		'linkedin-link',
		array(
			'label'    => esc_html__( 'Linkedin URL', 'kalervo' ),
			'section'  => 'social-links',
			'settings' => 'linkedin_link',
			'priority' => 40,
			'type'     => 'text'
		)
	);
	
	/* Add the google plus link setting. */
	$wp_customize->add_setting(
		'google_plus_link',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the google plus link control. */
	$wp_customize->add_control(
		'google-plus-link',
		array(
			'label'    => esc_html__( 'Google Plus URL', 'kalervo' ),
			'section'  => 'social-links',
			'settings' => 'google_plus_link',
			'priority' => 50,
			'type'     => 'text'
		)
	);
	
	/* Add the github link setting. */
	$wp_customize->add_setting(
		'github_link',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the github link control. */
	$wp_customize->add_control(
		'github-link',
		array(
			'label'    => esc_html__( 'Github URL', 'kalervo' ),
			'section'  => 'social-links',
			'settings' => 'github_link',
			'priority' => 60,
			'type'     => 'text'
		)
	);
	
	/* Add the pinterest link setting. */
	$wp_customize->add_setting(
		'pinterest_link',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add the pinterest link control. */
	$wp_customize->add_control(
		'pinterest-link',
		array(
			'label'    => esc_html__( 'Pinterest URL', 'kalervo' ),
			'section'  => 'social-links',
			'settings' => 'pinterest_link',
			'priority' => 70,
			'type'     => 'text'
		)
	);
	
	/* Add icon size setting. */
	$wp_customize->add_setting(
		'icon_size',
		array(
			'default'           => 'icon-large',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_html_class',
			//'transport'         => 'postMessage'
		)
	);
	
	/* Add icon size control. */
	$wp_customize->add_control(
		'icon-size-control',
		array(
			'label'    => esc_html__( 'Choose icon size', 'kalervo' ),
			'section'  => 'social-links',
			'settings' => 'icon_size',
			'type'     => 'radio',
			'priority' => 80,
			'choices'  => array(
				'normal'     => esc_html__( 'Normal', 'kalervo' ),
				'icon-large' => esc_html__( 'Icon large', 'kalervo' ),
				'icon-2x'    => esc_html__( 'Icon 2x', 'kalervo' ),
				'icon-3x'    => esc_html__( 'Icon 3x', 'kalervo' ),
				'icon-4x'    => esc_html__( 'Icon 4x', 'kalervo' )
			)
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
* Return Soliloque Slider choices.
*
* @since 0.1.0
*/
function kalervo_get_soliloquy_slider_choices() {
	
	/* Set an array. */
	$kalervo_slider_data = array(
		'default' => __( 'Select Slider', 'kalervo' )
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

/**
* Return social links
*
* @since 0.1.0
*/
function kalervo_social_links() {

	/* Return if there is social links. */
	
	if ( get_theme_mod( 'twitter_link' ) || get_theme_mod( 'facebook_link' ) || get_theme_mod( 'rss_link' ) || get_theme_mod( 'linkedin_link' ) || get_theme_mod( 'google_plus_link' ) || get_theme_mod( 'github_link' ) || get_theme_mod( 'pinterest_link' ) ) {

		$kalervo_output_links = '';
		
		$kalervo_output_links .= '<div id="kalervo-social-links">';
		
		$kalervo_output_links .= '<ul id="kalervo-social-link-list">';

		if ( get_theme_mod( 'twitter_link' ) )
			$kalervo_output_links .= '<li class="kalervo-social-links"><a class="kalervo-social-link" href="' . esc_url( get_theme_mod( 'twitter_link' ) ) . '"><i class="' . esc_attr( apply_filters( 'kalervo_link_twitter', 'icon-twitter' ) ) . ' ' . get_theme_mod( 'icon_size' ) . '"></i></a></li>';
		
		if ( get_theme_mod( 'facebook_link' ) )
			$kalervo_output_links .= '<li class="kalervo-social-links"><a class="kalervo-social-link" href="' . esc_url( get_theme_mod( 'facebook_link' ) ) . '"><i class="' . esc_attr( apply_filters( 'kalervo_link_facebook', 'icon-facebook' ) ) . ' ' . get_theme_mod( 'icon_size' ) . '"></i></a></li>';
			
		if ( get_theme_mod( 'rss_link' ) )
			$kalervo_output_links .= '<li class="kalervo-social-links"><a class="kalervo-social-link" href="' . esc_url( get_theme_mod( 'rss_link' ) ) . '"><i class="' . esc_attr( apply_filters( 'kalervo_link_rss', 'icon-rss' ) ) . ' ' . get_theme_mod( 'icon_size' ) . '"></i></a></li>';
		
		if ( get_theme_mod( 'linkedin_link' ) )
			$kalervo_output_links .= '<li class="kalervo-social-links"><a class="kalervo-social-link" href="' . esc_url( get_theme_mod( 'linkedin_link' ) ) . '"><i class="' . esc_attr( apply_filters( 'kalervo_link_linkedin', 'icon-linkedin' ) ) . ' ' . get_theme_mod( 'icon_size' ) . '"></i></a></li>';

		if ( get_theme_mod( 'google_plus_link' ) )
			$kalervo_output_links .= '<li class="kalervo-social-links"><a class="kalervo-social-link" href="' . esc_url( get_theme_mod( 'google_plus_link' ) ) . '"><i class="' . esc_attr( apply_filters( 'kalervo_link_google_plus', 'icon-google-plus' ) ) . ' ' . get_theme_mod( 'icon_size' ) . '"></i></a></li>';

		if ( get_theme_mod( 'github_link' ) )
			$kalervo_output_links .= '<li class="kalervo-social-links"><a class="kalervo-social-link" href="' . esc_url( get_theme_mod( 'github_link' ) ) . '"><i class="' . esc_attr( apply_filters( 'kalervo_link_github', 'icon-github' ) ) . ' ' . get_theme_mod( 'icon_size' ) . '"></i></a></li>';
	
		if ( get_theme_mod( 'pinterest_link' ) )
			$kalervo_output_links .= '<li class="kalervo-social-links"><a class="kalervo-social-link" href="' . esc_url( get_theme_mod( 'pinterest_link' ) ) . '"><i class="' . esc_attr( apply_filters( 'kalervo_link_pinterest', 'icon-pinterest' ) ) . ' ' . get_theme_mod( 'icon_size' ) . '"></i></a></li>';
		
		$kalervo_output_links .= '</ul></div>';
		
	return $kalervo_output_links;
	
	}
	
}

?>