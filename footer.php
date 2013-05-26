			<?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>
			
			</div><!-- .wrap -->

		</div><!-- #main -->

		<?php get_sidebar( 'subsidiary' ); // Loads the sidebar-subsidiary.php template. ?>

		<footer id="footer" role="contentinfo">

			<div class="wrap<?php if ( has_nav_menu( 'subsidiary' ) ) echo ' kalervo-subsidiary-menu-active'; ?>">

				<div class="footer-content">
					<?php hybrid_footer_content(); ?>
				</div><!-- .footer-content -->
				
			<?php get_template_part( 'menu', 'subsidiary' ); // Loads the menu-subsidiary.php template. ?>

			</div><!-- .wrap -->

		</footer><!-- #footer -->

	</div><!-- #container -->

	<?php wp_footer(); // wp_footer ?>

</body>
</html>