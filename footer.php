<?php
/**
 * The footer for the theme, converted from the Tistory skin's aside/footer block.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
			</div>
			<!-- // area-main -->

			<aside class="area-aside">
					<button type="button" class="btn-aside-close" aria-label="<?php esc_attr_e( '사이드바 닫기', 'tistory-style' ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<line x1="18" y1="6" x2="6" y2="18"></line>
							<line x1="6" y1="6" x2="18" y2="18"></line>
						</svg>
					</button>

					<?php get_sidebar(); ?>

					<div class="util use-sidebar">
						<?php get_search_form(); ?>
					</div>
				</aside>
				<!-- // aside -->

		</main>
		<!-- // main -->
	</div>
	<!-- // container -->

	<?php if ( is_active_sidebar( 'bottom-widgets' ) ) : ?>
		<div class="bottom-widget-area">
			<div class="inner-bottom-widget">
				<?php dynamic_sidebar( 'bottom-widgets' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<footer id="footer">
		<div class="inner-footer">
			<div class="box-policy">
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'link_before'    => '<span class="link-footer">',
							'link_after'     => '</span>',
						)
					);
				}
				?>
			</div>
			<div>
				<p class="text-info">&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
			</div>
		</div>
	</footer>
	<!-- // footer -->

</div>
<!-- // wrap -->

<?php wp_footer(); ?>
</body>
</html>
