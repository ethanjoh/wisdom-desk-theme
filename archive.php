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
		<div class="archive-card-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php tistory_style_render_card(); ?>
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
