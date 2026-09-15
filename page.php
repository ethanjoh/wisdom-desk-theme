<?php
/**
 * Static page template, converted from the skin's s_page_rep block.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class(); ?>>

		<div class="article-header" style="background-image:url('<?php echo esc_url( tistory_style_get_thumbnail_url() ); ?>')">
			<div class="inner-header">
				<div class="box-meta">
					<p class="category"><?php esc_html_e( '페이지', 'tistory-style' ); ?></p>
					<h2 class="title-article"><?php the_title(); ?></h2>
				</div>
			</div>
		</div>

		<div class="article-view" id="article-view">
			<?php the_content(); ?>
		</div>

		<?php if ( comments_open() || get_comments_number() ) : ?>
			<div class="article-reply">
				<div class="area-reply">
					<?php comments_template(); ?>
				</div>
			</div>
		<?php endif; ?>

	</article>
	<?php
endwhile;

get_footer();
