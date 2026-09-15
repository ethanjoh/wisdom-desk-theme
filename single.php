<?php
/**
 * Single post template, converted from the skin's s_article_rep block.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) :
	the_post();
	$categories = get_the_category();
	?>

	<article <?php post_class(); ?>>

		<div class="article-header" style="background-image:url('<?php echo esc_url( tistory_style_get_thumbnail_url() ); ?>')">
			<div class="inner-header">
				<div class="box-meta">
					<?php if ( ! empty( $categories ) ) : ?>
						<p class="category"><a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>"><?php echo esc_html( $categories[0]->name ); ?></a></p>
					<?php endif; ?>
					<h2 class="title-article"><?php the_title(); ?></h2>
					<div class="box-info">
						<span class="writer"><?php the_author(); ?></span>
						<span class="date"><?php echo esc_html( get_the_date( 'Y.m.d H:i' ) ); ?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="article-view-wrap">
			<div class="article-view-main">
				<div class="article-view" id="article-view">
					<?php the_content(); ?>
					<?php
					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( '페이지:', 'tistory-style' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>
			</div>

			<?php if ( ! empty( $categories ) ) : ?>
				<aside class="article-view-sidebar">
					<?php tistory_style_category_rank_widget(); ?>
				</aside>
			<?php endif; ?>
		</div>

		<div class="article-footer">
			<?php $tags = get_the_tags(); ?>
			<?php if ( $tags ) : ?>
				<div class="article-tag">
					<h3 class="title-footer">Tag</h3>
					<div class="box-tag">
						<?php foreach ( $tags as $tag ) : ?>
							<a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>">#<?php echo esc_html( $tag->name ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php tistory_style_related_posts(); ?>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<div class="article-reply">
					<div class="area-reply">
						<?php comments_template(); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>

	</article>

	<?php
endwhile;

get_footer();
