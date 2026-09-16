<!-- 프로젝트 변경 이력을 기록하는 문서 -->
# Changelog

## [1.5.3] - 2026-09-16

### 변경 날짜
- 2026-09-16

### 변경 목적
- 메인 화면(`index.php`) 카테고리별 글 조회 쿼리 최적화 및 썸네일 URL 취득 방식 개선

### 주요 결정 사항
- `index.php`:
  - 메인 최신 글 쿼리(`$home_query`)의 페이지당 글 수를 7개에서 5개로 조정하고 `no_found_rows => true` 적용으로 불필요한 전체 카운트 쿼리 방지
  - 카테고리별 섹션에서 카테고리마다 반복 실행되던 개별 `WP_Query`를 단일 풀 쿼리(`category__in`)로 통합하여 DB 부하 대폭 감소
- `functions.php`:
  - `tistory_style_get_thumbnail_url()` 함수에서 `wp_get_attachment_image_src( get_post_thumbnail_id(), ... )` 대신 코어 헬퍼 `get_the_post_thumbnail_url()`을 사용하여 썸네일 URL 취득 로직 간소화
  - 테마 버전을 `1.5.3`으로 상향
- `style.css`: 테마 헤더 버전을 `1.5.3`으로 상향

### 수정한 파일
- index.php
- functions.php
- style.css
- CHANGELOG.md

### 테스트 결과
- `php -l index.php` 및 `php -l functions.php` 문법 검사 통과
- 단일 쿼리 기반 카테고리별 최신 글 분배 로직 및 썸네일 URL 렌더링 정상 확인

## [1.5.2] - 2026-09-16

### 변경 날짜
- 2026-09-16

### 변경 목적
- 시간대에 따라 메인 화면 데스크 일러스트를 동적으로 교체하여 주간(오전 7시 ~ 오후 6시)에는 `frontpage2.webp`, 야간 및 나머지 시간대에는 `frontpage.webp`가 표시되도록 구현

### 주요 결정 사항
- `front-page.php`:
  - 워드프레스 타임존 기준 현재 시간(`(int) current_time( 'G' )`)을 확인하여 오전 7시부터 오후 6시 미만(`$hour >= 7 && $hour < 18`) 조건 분기 처리
  - 조건에 따라 `frontpage2.webp`(주간) 또는 `frontpage.webp`(야간/기타)를 초기 렌더링 이미지로 설정
  - 브라우저 정적 HTML 캐싱 환경에 대응하기 위해 `desk-main-hero-img`에 `data-day-src` 및 `data-night-src` 속성 추가
  - 클라이언트 측 경량 즉시 실행 인라인 스크립트를 추가하여 방문자 로컬 브라우저 시각을 확인하고 캐시된 이미지와 불일치 시 즉각 교체 보정
- `functions.php`: 테마 버전을 `1.5.2`로 상향
- `style.css`: 테마 헤더 버전을 `1.5.2`로 상향
- `README.md`: 주간/야간 일러스트 파일 설명 추가

### 수정한 파일
- front-page.php
- style.css
- functions.php
- README.md
- CHANGELOG.md

### 테스트 결과
- `php -l front-page.php` 및 `php -l functions.php` 문법 검사 통과
- 시간대 조건 분기(`7 <= hour < 18`) 및 클라이언트 캐시 보정 스크립트 정상 동작 확인

## [1.5.1] - 2026-09-16

### 변경 날짜
- 2026-09-16

### 변경 목적
- 프론트페이지 하단 카테고리 퀵 버튼의 인디케이터 점을 해당 카테고리에 신규 글이 있을 때만 빨간색으로 표시되도록 개선

### 주요 결정 사항
- `front-page.php`:
  - 특정 카테고리에 지정된 일수(기본 7일) 이내 발행된 신규 글이 있는지 확인하는 헬퍼 함수 `wisdom_desk_category_has_new_post()` 추가
  - `apply_filters( 'wisdom_desk_new_post_days', $days, $cat_id )` 지원으로 신규 글 판단 기간 유연화
  - 카테고리 조회 헬퍼 `wisdom_desk_find_category()` 결과에 `has_new` 플래그 추가
  - 퀵 내비게이션 점 태그에 신규 글 존재 시 `is-new` 클래스 및 웹 접근성용 `title="새 글"` 속성 부여
- `style.css`:
  - 기존 카테고리별 상시 고정 색상(파란색, 주황색) 제거
  - 신규 글이 없을 때는 `visibility: hidden; opacity: 0;`로 점을 숨기되, 카드의 텍스트 정렬 및 여백 유지를 위해 크기(8px)와 마진 유지
  - 신규 글이 있을 때(`is-new`)만 선명한 빨간색 점(`background-color: #ef4444;`, `box-shadow: 0 0 6px rgba(239, 68, 68, 0.7);`) 표시
- `functions.php`: 테마 버전을 `1.5.1`로 상향하여 브라우저 CSS 캐시 버스팅 적용

### 수정한 파일
- front-page.php
- style.css
- functions.php
- CHANGELOG.md

### 테스트 결과
- `php -l front-page.php` 및 `php -l functions.php` 문법 검사 통과
- 신규 글 유무에 따른 `is-new` 클래스 동적 부여 및 CSS 렌더링 동작 확인

## [1.5.0] - 2026-09-16

### 변경 날짜
- 2026-09-16

### 변경 목적
- 메인 화면(`front-page.php`) 데스크 일러스트 속 커피 잔에 모락모락 피어오르는 커피 김(스팀) 애니메이션 추가

### 주요 결정 사항
- `front-page.php`: 기존 반응형 SVG 오버레이(`viewBox="0 0 1536 1024"`) 내부에 커피 스팀 전용 그룹(`<g class="coffee-steam-wrap">`) 및 부드러운 스팀 블러 필터(`feGaussianBlur stdDeviation="3.5"`) 추가
- 머그컵 입구 위치(중심 X: 521, Y: 507)에 맞추어 따뜻한 온기 베이스 타원(`.steam-glow-base`)과 3가닥의 곡선 스팀 줄기(`.steam-path-1`, `.steam-path-2`, `.steam-path-3`) 배치
- `style.css`: 순수 CSS GPU 가속 기반 `@keyframes coffeeSteamRise` 및 `@keyframes coffeeBaseGlow` 애니메이션 정의
- 각 스팀 줄기에 서로 다른 주기(3.8s, 4.5s, 4.9s)와 딜레이(0s, 1.4s, 2.6s)를 적용하여 기계적이지 않고 자연스럽고 은은한 연기 연출
- 모던 브라우저 및 반응형 환경에서 SVG 좌표계 기준으로 정확히 동작하도록 `transform-box: view-box` 및 `pointer-events: none` 설정
- 테마 버전을 `1.5.0`으로 상향하여 브라우저 캐시 버스팅 적용

### 수정한 파일
- front-page.php
- style.css
- functions.php
- CHANGELOG.md

### 테스트 결과
- `php -l front-page.php` 및 `php -l functions.php` 문법 검사 통과
- 반응형 SVG viewBox 기반으로 해상도 및 창 크기 변경 시 머그컵 위치에 정확히 고정되어 부드럽게 작동 확인

## [1.4.9] - 2026-09-16

### 변경 날짜
- 2026-09-16

### 변경 목적
- 모바일 서랍 메뉴 타이틀 영역 배경에 메인 배너 썸네일 적용 및 카테고리 글 수 괄호 `( )` 표기

### 주요 결정 사항
- `style.css`: 모바일 서랍 메뉴(`.area-aside .box-profile`)의 기본 회색 테두리 사각 박스를 제거하고 메인 배너(`images/main-banner.jpg`)를 배경으로 적용 (`center / cover no-repeat`, 어두운 오버레이 레이어, 라운드 코너 12px, 은은한 텍스트 그림자 및 흰색 텍스트)
- `style.css`: 사이드바 카테고리 글 수(`.area-aside .box-category .c_cnt`) 전용 폰트 스타일(크기 13px, 색상 #888, 굵기 normal, 왼쪽 여백 4px)을 추가하여 카테고리 타이틀과 조화롭게 구분
- `functions.php`: `tistory_style_category_sidebar()` 함수에서 대분류 및 소분류 카테고리 글 수를 `<span class="c_cnt">(%d)</span>` 형태로 괄호 표기 확정
- 테마 버전을 `1.4.9`로 상향하여 브라우저 CSS/JS 캐시 버스팅 적용

### 수정한 파일
- style.css
- functions.php
- CHANGELOG.md

### 테스트 결과
- `php -l functions.php` 문법 검사 통과
- `style.css` 모바일 미디어 쿼리 내 배너 배경 및 카테고리 글 수 괄호 스타일 반영 확인

## [1.4.8] - 2026-09-16

### 변경 날짜
- 2026-09-16

### 변경 목적
- 프론트 페이지(`front-page.php`)에서 상단 슬로건(`area-slogun`: "Traces | 기억이 머문 자리 / Somewhere between memory and record") 및 홈 히어로 배너(`home-hero`) 문구 제거

### 주요 결정 사항
- 데스크 일러스트 칠판에 이미 "Somewhere between memory and record"가 픽셀 아트로 포함되어 있어 상단 텍스트 중복 및 시선 분산을 해소하기 위해 슬로건과 배너를 프론트 페이지에서 출력 제외
- `header.php`에서 `is_front_page()`일 때 `.area-slogun` 및 `.home-hero` 배너가 렌더링되지 않도록 조건 분기 처리
- `style.css`에서 `body:has(.frontpage-hero)` 셀렉터로 슬로건 및 배너 숨김 처리 및 헤더 하단 여백 슬림화
- `functions.php` 및 `style.css` 버전을 `1.4.8`로 일치시켜 브라우저 캐시 버스팅 적용

### 수정한 파일
- header.php
- style.css
- functions.php
- CHANGELOG.md

### 테스트 결과
- `php -l` 문법 검사 통과 및 프론트 페이지 헤더 간결화 검증

## [1.4.7] - 2026-09-16

### 변경 날짜
- 2026-09-16

### 변경 목적
- 프론트 페이지(`front-page.php`) 상단 카테고리 네비게이션 바(GNB) 숨김 및 하단 최신 글/카테고리 글 섹션 제거하여 독립형 일러스트 랜딩 페이지로 전환

### 주요 결정 사항
- `front-page.php`에서 최신 글 루프(`.home-layout`) 및 카테고리별 글 섹션(`.home-category-sections`) 코드 블록 완전 삭제
- `style.css`에서 `body:has(.frontpage-hero) .header .area-gnb`를 숨김 처리(`display: none !important`)하여 화면 시선을 데스크 일러스트에 집중
- `.area-main` 및 `.main` 너비를 1480px 단일 중앙 정렬로 최적화하여 2열 그리드 종속 탈피 및 균형 잡힌 랜딩 페이지 레이아웃 구축
- `functions.php` 및 `style.css` 버전을 `1.4.7`로 일치시켜 브라우저 캐시 버스팅 적용

### 수정한 파일
- front-page.php
- style.css
- functions.php
- CHANGELOG.md

### 테스트 결과
- `php -l` 문법 검사 통과 및 템플릿/스타일 반영 확인

## [1.4.6] - 2026-09-16

### 변경 날짜
- 2026-09-16

### 변경 목적
- `images/frontpage.webp` 데스크 일러스트를 활용한 인터랙티브 프론트 페이지(`front-page.php`) 구현 및 모니터 카테고리 링크(라이프로그, 여행, 북리뷰) 연결

### 주요 결정 사항
- `front-page.php` 템플릿 신규 생성하여 워드프레스 루트 접속 시 최우선 렌더링되도록 구현
  - 페이지 편집 화면에서 직접 지정할 수 있도록 `Template Name: 프론트 페이지 (인터랙티브 데스크)` 템플릿 메타 선언 추가
  - 이미지 참조 경로를 `get_stylesheet_directory_uri()`로 통일하고 함수 중복 정의 방지 처리
- `functions.php`의 `TISTORY_STYLE_VERSION`을 `1.4.6`으로 동기화하여 `style.css` 브라우저 캐시 버스팅 적용
- 일러스트 내 원근감이 적용된 3개 모니터 화면에 1:1 반응형 SVG 다각형 오버레이(`<polygon>`) 링크 매핑
  - 왼쪽 모니터: 라이프로그 (Lifelog)
  - 가운데 모니터: 여행 (Travel)
  - 오른쪽 모니터: 북리뷰 (Book Review)
- 마우스 호버 시 모니터 테두리 발광(Glow) 및 반투명 틴트 애니메이션 효과 적용
- 스마트폰 및 소형 화면 디바이스를 위한 3개 카테고리 퀵 바로가기 버튼 UI 추가
- 워드프레스 카테고리 슬러그/이름 자동 탐색 헬퍼 함수(`wisdom_desk_find_category`) 적용

### 수정한 파일
- front-page.php (신규 생성)
- functions.php
- style.css
- CHANGELOG.md

### 테스트 결과
- `php -l front-page.php` 문법 오류 검사 통과
- 로컬 웹서버 및 브라우저 환경에서 3개 모니터 호버 글로우 효과 및 클릭 시 카테고리 링크 이동 동작 검증 완료

## [1.4.5] - 2026-09-16

### 변경 날짜
- 2026-09-16

### 변경 목적
- 메가메뉴 상단 이격 간격 조정 및 글 상세 페이지 메가메뉴 폭 일치

### 주요 결정 사항
- 네비게이션 바 버튼과 메가메뉴가 너무 붙어있던 문제를 해결하기 위해 메가메뉴 패널 및 서브메뉴 상단 위치를 `top: calc(100% + 14px)`로 이격
- 마우스가 버튼에서 메가메뉴로 이동할 때 호버가 끊기지 않도록 투명 호버 브릿지(`.category_list:after`) 구현
- 글보기 페이지(`body:has(.article-view-wrap)`, `#tt-body-page`)의 헤더 및 GNB 너비를 900px로 일치시켜, 글보기 화면에서도 메가메뉴 폭이 메인 화면과 100% 동일하게 표시되도록 통일

### 수정한 파일
- style.css

### 테스트 결과
- 메가메뉴 상단 간격(14px), 호버 지속성, 글보기 상세 화면에서의 메가메뉴 폭 일치 검증 완료

## [1.4.4] - 2026-09-15

### 변경 날짜
- 2026-09-15

### 변경 목적
- 글 상세 페이지 배너(`.article-header`)의 높이를 메인 배너와 동일한 높이(158px / 모바일 130px)로 조정

### 주요 결정 사항
- `.article-header` 높이를 기존 400px에서 메인 배너와 동일한 `158px` (모바일 `130px`)로 축소
- `.article-header .inner-header`를 `display: flex; align-items: center;`로 구성하여 배너 내 카테고리/제목/작성자 정보가 컴팩트하게 수직 중앙 정렬되도록 개선
- 절대 위치(`position: absolute; bottom: 56px`) 제거 및 제목 폰트 크기/여백 슬림화

### 수정한 파일
- style.css

### 테스트 결과
- PC/모바일 환경에서 글 상세 배너 높이 및 메타 텍스트 수직 중앙 정렬 검증 완료

## [1.4.3] - 2026-09-15

### 변경 날짜
- 2026-09-15

### 변경 목적
- 메인 및 카테고리 페이지의 네비게이션 바(GNB) 버튼 크기/스타일을 글 상세 페이지와 동일하게 통일

### 주요 결정 사항
- 메인(`home-layout`) 및 카테고리(`archive-modern-list`)의 축소형 GNB 버튼 스타일을 글 상세 페이지의 15px 볼드, 10px 라운드, 패딩(10px 14px), 3D 입체 섀도우 및 호버 효과 스타일(`min-width: 135px`)과 동일하게 통합
- 모든 페이지(메인, 카테고리, 글 상세)에서 동일한 크기와 완성도 높은 디자인의 GNB 버튼 제공

### 수정한 파일
- style.css

### 테스트 결과
- CSS 스타일 규칙 통합 및 전 페이지 GNB 버튼 규격 검증 완료

## [1.4.2] - 2026-09-15

### 변경 날짜
- 2026-09-15

### 변경 목적
- 서브카테고리/아카이브 페이지 상단 배너 이미지 표시 및 일관된 모던 헤더 레이아웃 적용

### 주요 결정 사항
- `header.php`에서 카테고리/아카이브/태그/검색 등 서브 페이지에서도 상단 배너 이미지(`.home-hero.sub-hero`)가 렌더링되도록 구현 (카테고리 설명/타이틀 자동 반영)
- `style.css`에서 모던 헤더(900px 정렬, 로고/검색/GNB 버튼/슬로건 숨김) 스타일을 `body:has(.archive-modern-list)`로 확장하여 홈 화면과 동일한 일관된 디자인 제공
- `archive.php`의 중복 배너 마크업 정리

### 수정한 파일
- header.php
- archive.php
- style.css

### 테스트 결과
- 템플릿 마크업 렌더링 및 CSS 선택자 확장 검증 완료

## [1.4.1] - 2026-09-15

### 변경 날짜
- 2026-09-15

### 변경 목적
- 네비게이션 바(GNB) 카테고리 버튼 텍스트의 수직 중앙 정렬 개선

### 주요 결정 사항
- PC 기본 스타일의 상단 패딩(`padding: 10px`) 및 `display: block`에 의한 텍스트 하단 쏠림 충돌 해결
- `.header .area-gnb .category_list>li>a.link_item`에 `inline-flex` 및 `align-items: center`, `justify-content: center`, `line-height: 1`을 명시하여 완벽한 수직/가로 중앙 정렬 보장
- 홈 레이아웃 GNB 버튼의 `min-width`, `height`, `padding`, `margin` 오버라이드 충돌 방지

### 수정한 파일
- style.css

### 테스트 결과
- CSS 스타일 규칙 적용 및 flex 중앙 정렬 문법 검증 완료

## [1.4.0] - 2026-09-15

### 변경 날짜
- 2026-09-15

### 변경 목적
- 워드프레스 테마 메타데이터 헤더 개선 (GitHub 테마 자동 업데이트 호환 지원)

### 주요 결정 사항
- `style.css` 테마 헤더에 `GitHub Theme URI` 필드 지정 및 메타데이터 정렬

### 수정한 파일
- style.css

### 테스트 결과
- 워드프레스 테마 헤더 파싱 및 문법 검증 완료

## [1.0.1] - 2026-09-15

### 변경 날짜
- 2026-09-15

### 변경 목적
- 글 상세 페이지 배너 이미지 위 카테고리 링크 텍스트 가독성 개선

### 주요 결정 사항
- 배너 헤더 영역(`.article-header .box-meta .category a`)의 링크 색상을 어두운 배경 위에서 선명하게 보이도록 흰색(`#ffffff`)으로 지정
- 기본 파란색 밑줄 제거 및 마우스 호버 시 인터랙션 효과(투명도 0.8, 밑줄) 추가

### 수정한 파일
- style.css

### 테스트 결과
- CSS 스타일 규칙 검증 완료 (.article-header .box-meta .category a / hover)


## [1.0.0] - 2026-09-15

### 변경 날짜
- 2026-09-15

### 변경 목적
- GitHub 원격 저장소(https://github.com/ethanjoh/wisdom-desk-theme) 동기화 및 프로젝트 초기화

### 주요 결정 사항
- Git 저장소 초기화 (git init) 및 원격 저장소(origin) 연결
- 파일명 인코딩이 비정상적이던 파일명을 README.md로 정리
- 기본 브랜치를 main으로 설정하고 원격 저장소 동기화 진행

### 수정한 파일
- README.md (이름 변경)
- CHANGELOG.md (신규 생성)

### 테스트 결과
- Git 상태 확인 및 원격 브랜치 푸시 검증
