<!-- 프로젝트 변경 이력을 기록하는 문서 -->
# Changelog

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
