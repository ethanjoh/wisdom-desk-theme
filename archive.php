<?php
/**
 * Archive template.
 *
 * The archive keeps the current query intact (category/tag/date/archive),
 * but presents the first result as a featured latest post and the remaining
 * results as cards below it.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
$description = is_category() ? category_description() : '';
?>

<main class="archive-modern-list">

	<div class="archive-heading">
		<h2 class="title-search title-border">
			<b class="archives"><?php the_archive_title(); ?></b>
			<span><?php printf( esc_html__( '%d개의 글', 'tistory-style' ), (int) $wp_query->found_posts ); ?></span>
		</h2>
	</div>

	<?php if ( have_posts() ) : ?>
		<?php $archive_index = 0; ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ( 0 === $archive_index ) : ?>
				<article <?php post_class( 'archive-featured' ); ?>>
					<a class="archive-featured-thumb" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
						<img src="<?php echo esc_url( tistory_style_get_thumbnail_url( 'tistory-style-cover' ) ); ?>" alt="<?php the_title_attribute(); ?>" />
					</a>
					<div class="archive-featured-content">
						<a href="<?php the_permalink(); ?>" class="archive-post-link">
							<h2><?php the_title(); ?></h2>
							<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 55, '…' ) ); ?></p>
						</a>
						<div class="archive-meta">
							<?php $cat = get_the_category(); ?>
							<?php if ( ! empty( $cat ) ) : ?>
								<a href="<?php echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>"><?php echo esc_html( $cat[0]->name ); ?></a>
							<?php endif; ?>
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
						</div>
					</div>
				</article>

				<div class="archive-card-grid">
			<?php else : ?>
				<?php tistory_style_render_card(); ?>
			<?php endif; ?>
			<?php $archive_index++; ?>
		<?php endwhile; ?>
		</div>

		<div class="area-paging archive-paging">
			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => __( '이전', 'tistory-style' ),
					'next_text' => __( '다음', 'tistory-style' ),
				)
			);
			?>
		</div>
	<?php else : ?>
		<div class="box-no-search type-category">
			<span><?php esc_html_e( '선택하신 조건에 해당하는 글이 없습니다.', 'tistory-style' ); ?></span>
			<span><?php esc_html_e( '다른 카테고리를 선택하시거나, 검색 기능을 활용해 보세요.', 'tistory-style' ); ?></span>
		</div>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
