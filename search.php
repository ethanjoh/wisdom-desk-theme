<?php
/**
 * Search results template. Matches skin's "type-search" empty state.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div class="area-common area-list">
	<h2 class="title-search title-border">
		<b class="archives"><?php printf( esc_html__( '\'%s\' 검색결과', 'tistory-style' ), esc_html( get_search_query() ) ); ?></b>
		<span><?php printf( esc_html__( '%d개의 글', 'tistory-style' ), (int) $wp_query->found_posts ); ?></span>
	</h2>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php tistory_style_render_card(); ?>
		<?php endwhile; ?>

		<div class="area-paging">
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
		<div class="box-no-search type-search">
			<span><?php esc_html_e( '입력하신 단어의 철자가 정확한지 확인해 보세요.', 'tistory-style' ); ?></span>
			<span><?php esc_html_e( '검색어의 단어 수를 줄이거나, 보다 일반적인 단어로 검색해 보세요.', 'tistory-style' ); ?></span>
			<span><?php esc_html_e( '두 단어 이상의 키워드로 검색 하신 경우, 정확하게 띄어쓰기를 한 후 검색해 보세요.', 'tistory-style' ); ?></span>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
