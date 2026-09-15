<?php
/**
 * Sidebar. The front page uses a compact visual recommendation rail;
 * inner pages keep the original profile/category/widget sidebar.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="box-profile">
	<div class="inner-box">
		<?php if ( has_custom_logo() ) : ?>
			<?php the_custom_logo(); ?>
		<?php endif; ?>
		<p class="tit-g"><?php bloginfo( 'name' ); ?></p>
		<p class="text-profile"><?php bloginfo( 'description' ); ?></p>
	</div>
</div>

<div class="box-category box-category-2depth">
	<nav>
		<?php tistory_style_category_sidebar(); ?>
	</nav>
</div>

<?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
	<?php dynamic_sidebar( 'sidebar-main' ); ?>
<?php else : ?>
	<div class="box-recent">
		<h3 class="title-sidebar"><?php esc_html_e( '최근글', 'tistory-style' ); ?></h3>
		<ul class="list-recent">
			<?php
			$recent = new WP_Query( array( 'posts_per_page' => 5, 'ignore_sticky_posts' => true, 'no_found_rows' => true ) );
			while ( $recent->have_posts() ) : $recent->the_post();
				?>
				<li>
					<a href="<?php the_permalink(); ?>" class="link-recent">
						<p class="thumbnail" style="background-image:url('<?php echo esc_url( tistory_style_get_thumbnail_url( 'tistory-style-related' ) ); ?>')"></p>
						<div class="box-recent">
							<strong><?php the_title(); ?></strong>
							<span><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
						</div>
					</a>
				</li>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</ul>
	</div>
<?php endif; ?>
