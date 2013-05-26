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
			
			<?php get_template_part( 'info', 'header' ); // Loads the info-header.php template. ?>

			</div><!-- .wrap -->
		
		</header><!-- #header -->

		<div id="main">

			<div class="wrap">
			
				<?php if ( current_theme_supports( 'breadcrumb-trail' ) ) breadcrumb_trail( array( 'container' => 'nav', 'separator'  => __( '&#8764;', 'kalervo' ), 'show_on_front' => false ) ); ?>