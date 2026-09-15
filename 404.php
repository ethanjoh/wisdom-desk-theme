<?php
/**
 * 404 template, styled with the skin's "box-no-search" empty state.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div class="area-common area-list">
	<h2 class="title-search title-border"><b class="archives">404</b></h2>
	<div class="box-no-search type-search">
		<span><?php esc_html_e( '페이지를 찾을 수 없습니다.', 'tistory-style' ); ?></span>
		<span><?php esc_html_e( '주소가 정확한지 확인하시거나, 검색 기능을 활용해 보세요.', 'tistory-style' ); ?></span>
	</div>
	<?php get_search_form(); ?>
</div>

<?php
get_footer();
