<?php // 메인 화면(front-page) 레이아웃 및 인터랙티브 모니터 카테고리 링크 템플릿
/**
 * Template Name: 프론트 페이지 (인터랙티브 데스크)
 *
 * The template for displaying the front page.
 *
 * Displays the interactive desk hero section with clickable monitors
 * leading to Life Log, Travel, and Book Review categories, followed by
 * featured and recent posts.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

/**
 * 카테고리 슬러그 또는 이름을 기준으로 카테고리 링크 및 정보를 찾는 헬퍼 함수
 */
if ( ! function_exists( 'wisdom_desk_find_category' ) ) {
	function wisdom_desk_find_category( $candidates, $default_slug, $default_name ) {
		foreach ( (array) $candidates as $candidate ) {
			// 1. 슬러그로 찾기
			$cat = get_category_by_slug( $candidate );
			if ( $cat && ! is_wp_error( $cat ) ) {
				return array(
					'url'   => get_category_link( $cat->term_id ),
					'name'  => $cat->name,
					'count' => $cat->count,
					'found' => true,
				);
			}
			// 2. 카테고리 이름으로 찾기
			$cat_id = get_cat_ID( $candidate );
			if ( $cat_id ) {
				$cat = get_category( $cat_id );
				if ( $cat && ! is_wp_error( $cat ) ) {
					return array(
						'url'   => get_category_link( $cat->term_id ),
						'name'  => $cat->name,
						'count' => $cat->count,
						'found' => true,
					);
				}
			}
		}

		// 일치하는 카테고리가 없는 경우 fallback URL 생성
		return array(
			'url'   => home_url( '/category/' . $default_slug . '/' ),
			'name'  => $default_name,
			'count' => 0,
			'found' => false,
		);
	}
}

// 3개 모니터에 매핑할 카테고리 데이터 조회
$cat_lifelog = wisdom_desk_find_category( array( 'lifelog', 'life-log', 'life', '일상', '라이프로그' ), 'lifelog', '라이프로그' );
$cat_travel  = wisdom_desk_find_category( array( 'travel', 'trip', '여행' ), 'travel', '여행' );
$cat_book    = wisdom_desk_find_category( array( 'book-review', 'book', 'books', '독서', '북리뷰' ), 'book-review', '북리뷰' );

$desk_image_url = get_stylesheet_directory_uri() . '/images/frontpage.webp';
?>

<!-- =======================================================================
     FRONT PAGE INTERACTIVE DESK HERO
     ======================================================================= -->
<section class="frontpage-hero" aria-label="메인 데스크 카테고리 내비게이션">
	<div class="frontpage-hero-container">
		<div class="desk-interactive-wrapper">
			<!-- 메인 배경 일러스트 -->
			<img
				src="<?php echo esc_url( $desk_image_url ); ?>"
				alt="Wisdom Desk - 모니터를 클릭하여 카테고리로 이동하세요"
				class="desk-main-img"
				width="1536"
				height="1024"
				loading="eager"
			/>

			<!-- 반응형 인터랙티브 모니터 링크 SVG 오버레이 -->
			<svg
				class="desk-interactive-svg"
				viewBox="0 0 1536 1024"
				preserveAspectRatio="xMidYMid meet"
				xmlns="http://www.w3.org/2000/svg"
				xmlns:xlink="http://www.w3.org/1999/xlink"
				aria-label="화면 속 모니터를 클릭하면 해당 카테고리로 이동합니다."
			>
				<defs>
					<filter id="monitor-glow-blue" x="-20%" y="-20%" width="140%" height="140%">
						<feGaussianBlur stdDeviation="6" result="blur" />
						<feComposite in="SourceGraphic" in2="blur" operator="over" />
					</filter>
				</defs>

				<!-- 1. 왼쪽 모니터: 라이프로그 (Lifelog) -->
				<a
					href="<?php echo esc_url( $cat_lifelog['url'] ); ?>"
					class="monitor-link monitor-link-lifelog"
					aria-label="<?php echo esc_attr( $cat_lifelog['name'] ); ?> 카테고리로 이동"
				>
					<title><?php echo esc_attr( $cat_lifelog['name'] ); ?> 카테고리로 이동</title>
					<polygon
						class="monitor-screen-poly"
						points="218,252 565,185 568,412 228,473"
					/>
				</a>

				<!-- 2. 가운데 모니터: 여행 (Travel) -->
				<a
					href="<?php echo esc_url( $cat_travel['url'] ); ?>"
					class="monitor-link monitor-link-travel"
					aria-label="<?php echo esc_attr( $cat_travel['name'] ); ?> 카테고리로 이동"
				>
					<title><?php echo esc_attr( $cat_travel['name'] ); ?> 카테고리로 이동</title>
					<polygon
						class="monitor-screen-poly"
						points="579,175 1004,175 1004,423 579,423"
					/>
				</a>

				<!-- 3. 오른쪽 모니터: 북리뷰 (Book Review) -->
				<a
					href="<?php echo esc_url( $cat_book['url'] ); ?>"
					class="monitor-link monitor-link-book"
					aria-label="<?php echo esc_attr( $cat_book['name'] ); ?> 카테고리로 이동"
				>
					<title><?php echo esc_attr( $cat_book['name'] ); ?> 카테고리로 이동</title>
					<polygon
						class="monitor-screen-poly"
						points="1014,192 1376,266 1360,545 1014,442"
					/>
				</a>
			</svg>
		</div>

		<!-- 모바일 및 접근성 보조 카테고리 내비게이션 바 -->
		<nav class="desk-quick-nav" aria-label="주요 카테고리 바로가기">
			<a href="<?php echo esc_url( $cat_lifelog['url'] ); ?>" class="desk-quick-btn desk-quick-lifelog">
				<span class="desk-quick-indicator"></span>
				<span class="desk-quick-title">라이프로그</span>
				<span class="desk-quick-sub">Lifelog</span>
			</a>
			<a href="<?php echo esc_url( $cat_travel['url'] ); ?>" class="desk-quick-btn desk-quick-travel">
				<span class="desk-quick-indicator"></span>
				<span class="desk-quick-title">여행</span>
				<span class="desk-quick-sub">Travel</span>
			</a>
			<a href="<?php echo esc_url( $cat_book['url'] ); ?>" class="desk-quick-btn desk-quick-book">
				<span class="desk-quick-indicator"></span>
				<span class="desk-quick-title">북리뷰</span>
				<span class="desk-quick-sub">Book Review</span>
			</a>
		</nav>
	</div>
</section>

<!-- =======================================================================
     RECENT & CATEGORY POSTS SECTION
     ======================================================================= -->
<?php
$home_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 7,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	)
);
$home_posts = $home_query->posts;
?>

<div class="home-layout">
	<section class="home-primary" aria-label="최신 글">
		<?php if ( ! empty( $home_posts ) ) : ?>
			<?php $featured = $home_posts[0]; $GLOBALS['post'] = $featured; setup_postdata( $featured ); ?>
			<article class="home-featured">
				<a class="home-featured-thumb" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
					<img src="<?php echo esc_url( tistory_style_get_thumbnail_url( 'tistory-style-cover' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="eager" />
				</a>
				<div class="home-featured-content">
					<a href="<?php the_permalink(); ?>" class="home-post-link">
						<h2><?php the_title(); ?></h2>
						<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 48, '…' ) ); ?></p>
					</a>
					<div class="home-meta">
						<?php $cat = get_the_category(); ?>
						<?php if ( ! empty( $cat ) ) : ?>
							<a href="<?php echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>"><?php echo esc_html( $cat[0]->name ); ?></a>
						<?php endif; ?>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
					</div>
				</div>
			</article>

			<?php if ( count( $home_posts ) > 1 ) : ?>
				<div class="home-secondary-grid">
					<?php for ( $i = 1; $i <= 2 && $i < count( $home_posts ); $i++ ) : ?>
						<?php $post = $home_posts[ $i ]; setup_postdata( $post ); ?>
						<article class="home-secondary">
							<a class="home-secondary-thumb" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
								<img src="<?php echo esc_url( tistory_style_get_thumbnail_url( 'tistory-style-related' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
							</a>
							<div class="home-secondary-content">
								<a href="<?php the_permalink(); ?>" class="home-post-link">
									<h3><?php the_title(); ?></h3>
									<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 15, '…' ) ); ?></p>
								</a>
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
							</div>
						</article>
					<?php endfor; ?>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<div class="home-empty">표시할 글이 없습니다.</div>
		<?php endif; ?>
	</section>

	<aside class="home-sidebar" aria-label="추천 글">
		<?php for ( $i = 3; $i <= 4 && $i < count( $home_posts ); $i++ ) : ?>
			<?php $post = $home_posts[ $i ]; setup_postdata( $post ); ?>
			<article class="home-sidebar-card">
				<a class="home-sidebar-thumb" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
					<img src="<?php echo esc_url( tistory_style_get_thumbnail_url( 'tistory-style-cover' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
				</a>
				<div class="home-sidebar-content">
					<a href="<?php the_permalink(); ?>" class="home-post-link">
						<h3><?php the_title(); ?></h3>
					</a>
					<div class="home-meta">
						<?php $cat = get_the_category(); ?>
						<?php if ( ! empty( $cat ) ) : ?>
							<a href="<?php echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>"><?php echo esc_html( $cat[0]->name ); ?></a>
						<?php endif; ?>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
					</div>
				</div>
			</article>
		<?php endfor; ?>
	</aside>
</div>

<?php
/* -------------------------------------------------------------------------
 * Category sections
 * ---------------------------------------------------------------------- */
$home_categories = get_categories(
	array(
		'taxonomy'   => 'category',
		'parent'     => 0,
		'hide_empty' => true,
		'orderby'    => 'term_order',
		'order'      => 'ASC',
	)
);
?>

<?php if ( ! empty( $home_categories ) ) : ?>
	<section class="home-category-sections" aria-label="카테고리별 최신 글">
		<?php foreach ( $home_categories as $home_category ) : ?>
			<?php
			$category_query = new WP_Query(
				array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'cat'                 => $home_category->term_id,
					'posts_per_page'      => 3,
					'ignore_sticky_posts' => true,
					'orderby'             => 'date',
					'order'               => 'DESC',
					'no_found_rows'       => true,
				)
			);
			?>

			<?php if ( $category_query->have_posts() ) : ?>
				<section class="home-category-section">
					<div class="home-category-heading">
						<h2><?php echo esc_html( $home_category->name ); ?></h2>
						<a href="<?php echo esc_url( get_category_link( $home_category->term_id ) ); ?>" class="home-category-more">더보기 <span aria-hidden="true">→</span></a>
					</div>

					<div class="home-category-grid">
						<?php while ( $category_query->have_posts() ) : $category_query->the_post(); ?>
							<article class="home-category-card">
								<a class="home-category-card-thumb" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
									<img src="<?php echo esc_url( tistory_style_get_thumbnail_url( 'tistory-style-cover' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
								</a>
								<div class="home-category-card-content">
									<a href="<?php the_permalink(); ?>" class="home-post-link">
										<h3><?php the_title(); ?></h3>
									</a>
									<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 20, '…' ) ); ?></p>
									<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
								</div>
							</article>
						<?php endwhile; ?>
					</div>
				</section>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>
		<?php endforeach; ?>
	</section>
<?php endif; ?>

<?php
wp_reset_postdata();
wp_reset_query();
get_footer();
