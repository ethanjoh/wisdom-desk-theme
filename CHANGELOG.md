<!-- 프로젝트 변경 이력을 기록하는 문서 -->
# Changelog

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
