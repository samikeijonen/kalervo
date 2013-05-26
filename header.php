<!DOCTYPE html>
<!--[if IE 7 ]> <html class="ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]> <html class="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>

<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<title><?php hybrid_document_title(); ?></title>
<meta name="viewport" content="width=device-width,initial-scale=1" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); // wp_head ?>

</head>

<body class="<?php hybrid_body_class(); ?>">

	<div id="container">

		<div id="site-description-social-wrap">
			<div class="wrap">
			
				<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
				<?php get_template_part( 'menu', 'secondary' ); // Loads the menu-secondary.php template. ?>
				
			</div><!-- .wrap -->
		</div><!-- #site-description-social-wrap -->

		<header id="header">

			<div class="wrap">
			
			<?php if ( get_theme_mod( 'logo_upload') ) { // Use logo if is set. Else use bloginfo name. ?>	
					<h1 id="site-title">
						<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							<img class="kalervo-logo" src="<?php echo esc_url( get_theme_mod( 'logo_upload' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
						</a>
					</h1>
			<?php } else { ?>
				<h1 id="site-title"><a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<?php } ?>
			
			<?php get_sidebar( 'header' ); // Loads the sidebar-subsidiary.php template. ?>
				
			<?php get_template_part( 'menu', 'primary' ); // Loads the menu-primary.php template. ?>
			
			<?php $kalervo_header_image = get_header_image(); ?>
				
				<?php /* Use Header Image/Slider in the front page and singular pages. */
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
									
									} ?>
									
								</div><!-- #kalervo-header-image -->
							<?php }
						}
						
					} ?>

			</div><!-- .wrap -->
		
		</header><!-- #header -->

		<div id="main">

			<div class="wrap">
			
				<?php if ( current_theme_supports( 'breadcrumb-trail' ) ) breadcrumb_trail( array( 'container' => 'nav', 'separator'  => __( '&#8764;', 'kalervo' ), 'show_on_front' => false ) ); ?>