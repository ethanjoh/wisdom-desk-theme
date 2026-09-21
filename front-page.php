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
 * 특정 카테고리에 지정된 일수(기본 7일) 이내에 발행된 신규 글이 있는지 확인하는 헬퍼 함수
 */
if ( ! function_exists( 'wisdom_desk_category_has_new_post' ) ) {
	function wisdom_desk_category_has_new_post( $cat_id, $days = 7 ) {
		if ( ! $cat_id ) {
			return false;
		}
		$days = apply_filters( 'wisdom_desk_new_post_days', $days, $cat_id );
		$recent_posts = get_posts( array(
			'cat'            => (int) $cat_id,
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'date_query'     => array(
				array(
					'after' => $days . ' days ago',
				),
			),
			'fields'         => 'ids',
			'no_found_rows'  => true,
		) );
		return ! empty( $recent_posts );
	}
}

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
					'term_id' => $cat->term_id,
					'url'     => get_category_link( $cat->term_id ),
					'name'    => $cat->name,
					'count'   => $cat->count,
					'has_new' => wisdom_desk_category_has_new_post( $cat->term_id ),
					'found'   => true,
				);
			}
			// 2. 카테고리 이름으로 찾기
			$cat_id = get_cat_ID( $candidate );
			if ( $cat_id ) {
				$cat = get_category( $cat_id );
				if ( $cat && ! is_wp_error( $cat ) ) {
					return array(
						'term_id' => $cat->term_id,
						'url'     => get_category_link( $cat->term_id ),
						'name'    => $cat->name,
						'count'   => $cat->count,
						'has_new' => wisdom_desk_category_has_new_post( $cat->term_id ),
						'found'   => true,
					);
				}
			}
		}

		// 일치하는 카테고리가 없는 경우 fallback URL 생성
		return array(
			'term_id' => 0,
			'url'     => home_url( '/category/' . $default_slug . '/' ),
			'name'    => $default_name,
			'count'   => 0,
			'has_new' => false,
			'found'   => false,
		);
	}
}

// 3개 모니터에 매핑할 카테고리 데이터 조회
$cat_lifelog = wisdom_desk_find_category( array( 'lifelog', 'life-log', 'life', '일상', '라이프로그' ), 'lifelog', '라이프로그' );
$cat_travel  = wisdom_desk_find_category( array( 'travel', 'trip', '여행' ), 'travel', '여행' );
$cat_book    = wisdom_desk_find_category( array( 'book-review', 'book', 'books', '독서', '북리뷰' ), 'book-review', '북리뷰' );

// 데스크 일러스트 이미지 경로 (기본 주간: frontpage2.webp, 야간: frontpage.webp)
$theme_uri        = get_stylesheet_directory_uri();
$desk_image_day   = $theme_uri . '/images/frontpage2.webp';
$desk_image_night = $theme_uri . '/images/frontpage.webp';
$desk_image_url   = $desk_image_day;
?>

<!-- =======================================================================
     FRONT PAGE INTERACTIVE DESK HERO
     ======================================================================= -->
<section class="frontpage-hero" aria-label="메인 데스크 카테고리 내비게이션">
	<div class="frontpage-hero-container">
		<?php $desk_tagline = get_bloginfo( 'description' ); ?>
		<?php if ( ! empty( $desk_tagline ) ) : ?>
			<div class="desk-tagline-wrap">
				<p class="desk-tagline"><?php echo esc_html( $desk_tagline ); ?></p>
			</div>
		<?php endif; ?>

		<div class="desk-interactive-wrapper">
			<!-- 메인 배경 일러스트 (주간/야간 수동 전환 지원) -->
			<img
				id="desk-main-hero-img"
				src="<?php echo esc_url( $desk_image_url ); ?>"
				data-day-src="<?php echo esc_url( $desk_image_day ); ?>"
				data-night-src="<?php echo esc_url( $desk_image_night ); ?>"
				alt="Wisdom Desk - 모니터를 클릭하여 카테고리로 이동하세요"
				class="desk-main-img"
				width="1536"
				height="1024"
				loading="eager"
			/>

			<!-- =======================================================
			     2.5D 픽셀아트 오프닝 인트로 오버레이
			     ======================================================= -->
			<div id="pixel-intro-overlay" class="pixel-intro-overlay" aria-label="Wisdom Desk 오프닝 인트로">
				<div class="intro-scene-wrapper">
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/concept_intro_room_2.jpg' ); ?>"
						alt="Wisdom Desk 서재로 들어가는 캐릭터"
						class="intro-scene-img"
					/>
					<div class="intro-door-light" aria-hidden="true"></div>
				</div>

				<!-- 인트로 조작 버튼 (SKIP) -->
				<button type="button" id="intro-skip-btn" class="intro-skip-btn" aria-label="인트로 건너뛰기">
					<span>SKIP</span>
					<svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" aria-hidden="true">
						<path d="M5 4v16l11-8zm11 0v16h2V4z"/>
					</svg>
				</button>
			</div>

			<!-- 상단 보조 컨트롤: 인트로 다시 보기 버튼 -->
			<button
				type="button"
				id="desk-intro-replay"
				class="desk-intro-replay"
				aria-label="오프닝 인트로 다시 보기"
				title="오프닝 인트로 다시 보기"
			>
				<svg class="replay-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<polygon points="5 3 19 12 5 21 5 3"></polygon>
				</svg>
			</button>

			<!-- 주간/야간 모드 수동 토글 버튼 (우측 상단) -->
			<button
				type="button"
				id="desk-theme-toggle"
				class="desk-theme-toggle"
				aria-label="주간/야간 일러스트 모드 전환"
				title="주간/야간 일러스트 모드 전환"
			>
				<!-- 달 아이콘 (주간일 때 표시되어 클릭 시 야간으로 전환) -->
				<svg class="theme-icon theme-icon-moon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
				</svg>
				<!-- 해 아이콘 (야간일 때 표시되어 클릭 시 주간으로 전환) -->
				<svg class="theme-icon theme-icon-sun" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<circle cx="12" cy="12" r="5"></circle>
					<line x1="12" y1="1" x2="12" y2="3"></line>
					<line x1="12" y1="21" x2="12" y2="23"></line>
					<line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
					<line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
					<line x1="1" y1="12" x2="3" y2="12"></line>
					<line x1="21" y1="12" x2="23" y2="12"></line>
					<line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
					<line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
				</svg>
			</button>

			<script>
			(function() {
				var STORAGE_KEY = 'wisdom_desk_theme_mode';
				var heroImg = document.getElementById('desk-main-hero-img');
				var toggleBtn = document.getElementById('desk-theme-toggle');
				if (!heroImg || !toggleBtn) return;

				var daySrc = heroImg.getAttribute('data-day-src');
				var nightSrc = heroImg.getAttribute('data-night-src');

				function applyMode(mode, save) {
					if (mode === 'night') {
						if (nightSrc && heroImg.src !== nightSrc) heroImg.src = nightSrc;
						toggleBtn.setAttribute('data-mode', 'night');
						toggleBtn.setAttribute('aria-label', '주간 모드로 전환');
						toggleBtn.setAttribute('title', '주간 모드로 전환');
					} else {
						if (daySrc && heroImg.src !== daySrc) heroImg.src = daySrc;
						toggleBtn.setAttribute('data-mode', 'day');
						toggleBtn.setAttribute('aria-label', '야간 모드로 전환');
						toggleBtn.setAttribute('title', '야간 모드로 전환');
					}
					if (save) {
						try {
							localStorage.setItem(STORAGE_KEY, mode);
						} catch (e) {}
					}
				}

				// 저장된 설정 불러오기 (기본값: day)
				var savedMode = 'day';
				try {
					var stored = localStorage.getItem(STORAGE_KEY);
					if (stored === 'day' || stored === 'night') {
						savedMode = stored;
					}
				} catch (e) {}
				applyMode(savedMode, false);

				// 버튼 클릭 시 토글
				toggleBtn.addEventListener('click', function(e) {
					e.preventDefault();
					var currentMode = toggleBtn.getAttribute('data-mode') || 'day';
					var nextMode = (currentMode === 'day') ? 'night' : 'day';
					applyMode(nextMode, true);
				});
			})();

			/* 2.5D 픽셀아트 인트로 오버레이 애니메이션 & 세션 제어 */
			(function() {
				var INTRO_KEY = 'wisdom_desk_intro_played';
				var overlay = document.getElementById('pixel-intro-overlay');
				var skipBtn = document.getElementById('intro-skip-btn');
				var replayBtn = document.getElementById('desk-intro-replay');
				if (!overlay) return;

				var zoomTimer = null;
				var finishTimer = null;

				function finishIntro(fast) {
					clearTimeout(zoomTimer);
					clearTimeout(finishTimer);
					if (fast) {
						overlay.classList.add('is-hidden');
						overlay.classList.remove('is-active', 'is-zooming', 'is-fading');
					} else {
						overlay.classList.add('is-fading');
						finishTimer = setTimeout(function() {
							overlay.classList.add('is-hidden');
							overlay.classList.remove('is-active', 'is-zooming', 'is-fading');
						}, 600);
					}
					try {
						sessionStorage.setItem(INTRO_KEY, '1');
					} catch (e) {}
				}

				function playIntro() {
					clearTimeout(zoomTimer);
					clearTimeout(finishTimer);
					overlay.classList.remove('is-hidden', 'is-fading', 'is-zooming');
					overlay.classList.add('is-active');

					// 0.8초 후 문 안쪽(오른쪽 데스크 78% 48%)으로 줌인 시작
					zoomTimer = setTimeout(function() {
						overlay.classList.add('is-zooming');

						// 줌인 1.6초 지속 후 메인 일러스트로 페이드아웃 전환
						finishTimer = setTimeout(function() {
							finishIntro(false);
						}, 1600);
					}, 800);
				}

				// 첫 접속 여부 확인 (동일 브라우저 탭 세션 동안 1회만 자동 재생)
				var hasPlayed = false;
				try {
					hasPlayed = sessionStorage.getItem(INTRO_KEY) === '1';
				} catch (e) {}

				if (!hasPlayed) {
					playIntro();
				} else {
					overlay.classList.add('is-hidden');
				}

				if (skipBtn) {
					skipBtn.addEventListener('click', function(e) {
						e.preventDefault();
						finishIntro(true);
					});
				}

				if (replayBtn) {
					replayBtn.addEventListener('click', function(e) {
						e.preventDefault();
						playIntro();
					});
				}
			})();
			</script>

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
					<filter id="steam-soft-blur" x="-40%" y="-40%" width="180%" height="180%">
						<feGaussianBlur stdDeviation="3.5" result="blur" />
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

				<!-- 4. 커피 잔 따뜻한 김(Steam) 애니메이션 -->
				<g class="coffee-steam-wrap" aria-hidden="true">
					<!-- 커피 표면 은은한 온기 베이스 -->
					<ellipse class="steam-glow-base" cx="521" cy="507" rx="16" ry="6" />
					<!-- 피어오르는 김 줄기들 -->
					<path class="steam-path steam-path-1" d="M 521,504 C 515,475 528,446 519,416 C 511,386 525,356 517,318" />
					<path class="steam-path steam-path-2" d="M 512,506 C 504,478 518,449 507,419 C 497,389 513,359 503,326" />
					<path class="steam-path steam-path-3" d="M 530,505 C 538,477 523,447 535,417 C 545,387 531,357 539,322" />
				</g>
			</svg>
		</div>

		<!-- 모바일 및 접근성 보조 카테고리 내비게이션 바 -->
		<nav class="desk-quick-nav" aria-label="주요 카테고리 바로가기">
			<a href="<?php echo esc_url( $cat_lifelog['url'] ); ?>" class="desk-quick-btn desk-quick-lifelog">
				<span class="desk-quick-indicator<?php echo ! empty( $cat_lifelog['has_new'] ) ? ' is-new' : ''; ?>"<?php echo ! empty( $cat_lifelog['has_new'] ) ? ' title="새 글"' : ''; ?>></span>
				<span class="desk-quick-title">라이프로그</span>
				<span class="desk-quick-sub">Lifelog</span>
			</a>
			<a href="<?php echo esc_url( $cat_travel['url'] ); ?>" class="desk-quick-btn desk-quick-travel">
				<span class="desk-quick-indicator<?php echo ! empty( $cat_travel['has_new'] ) ? ' is-new' : ''; ?>"<?php echo ! empty( $cat_travel['has_new'] ) ? ' title="새 글"' : ''; ?>></span>
				<span class="desk-quick-title">여행</span>
				<span class="desk-quick-sub">Travel</span>
			</a>
			<a href="<?php echo esc_url( $cat_book['url'] ); ?>" class="desk-quick-btn desk-quick-book">
				<span class="desk-quick-indicator<?php echo ! empty( $cat_book['has_new'] ) ? ' is-new' : ''; ?>"<?php echo ! empty( $cat_book['has_new'] ) ? ' title="새 글"' : ''; ?>></span>
				<span class="desk-quick-title">북리뷰</span>
				<span class="desk-quick-sub">Book Review</span>
			</a>
		</nav>
	</div>
</section>

<?php
get_footer();

