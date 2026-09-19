<?php
/**
 * Tistory Style theme functions
 * Converted from a Tistory skin (style.css / skin.html) into a WordPress theme.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'TISTORY_STYLE_VERSION', '1.6.7' );

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */
function tistory_style_setup() {
	load_theme_textdomain( 'tistory-style', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Matches the ".thumbnail" list cards and the wide ".article-header" cover image.
	set_post_thumbnail_size( 700, 500, true );
	add_image_size( 'tistory-style-cover', 1440, 500, true );
	add_image_size( 'tistory-style-related', 600, 380, true );

	register_nav_menus(
		array(
			'primary' => __( '상단 카테고리 메뉴 (GNB)', 'tistory-style' ),
			'footer'  => __( '푸터 링크', 'tistory-style' ),
		)
	);
}
add_action( 'after_setup_theme', 'tistory_style_setup' );

/* -------------------------------------------------------------------------
 * Scripts & styles
 * ---------------------------------------------------------------------- */
function tistory_style_scripts() {
	wp_enqueue_style( 'xeicon', 'https://cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css', array(), '2.3.3' );
	wp_enqueue_style( 'tistory-style', get_stylesheet_uri(), array( 'xeicon' ), TISTORY_STYLE_VERSION );

	wp_enqueue_script( 'tistory-style-main', get_template_directory_uri() . '/js/theme.js', array(), TISTORY_STYLE_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tistory_style_scripts' );

/* -------------------------------------------------------------------------
 * Widgets (sidebar cards from the skin: profile, tags, recent, comments,
 * notice, archive, calendar, visitor count are handled as widget areas so
 * the site owner can arrange them from Appearance → Widgets)
 * ---------------------------------------------------------------------- */
function tistory_style_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( '사이드바', 'tistory-style' ),
			'id'            => 'sidebar-main',
			'description'   => __( '프로필, 태그, 최근글, 최근댓글, 공지, 보관함, 달력 등의 위젯을 올려놓으세요.', 'tistory-style' ),
			'before_widget' => '<div id="%1$s" class="box-sidebar %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="title-sidebar">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( '하단 위젯 영역', 'tistory-style' ),
			'id'            => 'bottom-widgets',
			'description'   => __( '푸터 위쪽에 표시되는 위젯 영역입니다. (최근댓글/방문자수 등)', 'tistory-style' ),
			'before_widget' => '<div id="%1$s" class="bottom-box %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'tistory_style_widgets_init' );

/* -------------------------------------------------------------------------
 * Nav walker: renders the 2-depth mega-menu markup the skin's CSS expects
 * (ul.category_list > li > a.link_item, sub ul.sub_category_list > li > a.link_sub_item)
 * ---------------------------------------------------------------------- */
require get_template_directory() . '/inc/class-tistory-style-nav-walker.php';

/* -------------------------------------------------------------------------
 * Body classes ~= Tistory's [##_body_id_##] / wrap-right / wrap-drawer hooks
 * ---------------------------------------------------------------------- */
function tistory_style_body_classes( $classes ) {
	$classes[] = 'use-menu-list-wrp';
	if ( is_active_sidebar( 'sidebar-main' ) ) {
		$classes[] = 'wrap-right';
	}
	return $classes;
}
add_filter( 'body_class', 'tistory_style_body_classes' );

/**
 * Tistory's skin.html hard-codes [##_body_id_##] (tt-body-page, tt-body-index,
 * tt-body-category, ...) and a large part of style.css keys its spacing off
 * that id — most importantly:
 *   #tt-body-page .main { padding-top: 470px; }
 * which reserves room for the absolutely-positioned 400px .article-header
 * banner. Without this id the banner has nothing pushing content down, so
 * it overlaps the title/body and the sticky .article-view-sidebar renders
 * far too high. Reproducing the id mapping here re-enables those existing
 * rules with no extra CSS needed.
 */
function tistory_style_body_id() {
	if ( is_singular() ) {
		return 'tt-body-page';
	} elseif ( is_category() ) {
		return 'tt-body-category';
	} elseif ( is_tag() ) {
		return 'tt-body-tag';
	} elseif ( is_search() ) {
		return 'tt-body-search';
	} elseif ( is_archive() ) {
		return 'tt-body-archive';
	}
	return 'tt-body-index';
}

/* -------------------------------------------------------------------------
 * Excerpt tuning (matches the "summary" line under list titles)
 * ---------------------------------------------------------------------- */
function tistory_style_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'tistory_style_excerpt_length' );

function tistory_style_excerpt_more( $more ) {
	return '…';
}
add_filter( 'excerpt_more', 'tistory_style_excerpt_more' );

/* -------------------------------------------------------------------------
 * Helpers used across templates
 * ---------------------------------------------------------------------- */

/**
 * Print a card-list <article> exactly like the skin's "article-type-common"
 * block (thumbnail + title + summary + category/date/comment meta).
 */
function tistory_style_render_card() {
	?>
	<article <?php post_class( 'article-type-common' ); ?>>
		<a href="<?php the_permalink(); ?>" class="link-article">
			<p class="thumbnail" style="background-image:url('<?php echo esc_url( tistory_style_get_thumbnail_url() ); ?>')"></p>
		</a>
		<div class="article-content">
			<a href="<?php the_permalink(); ?>" class="link-article">
				<strong class="title"><?php the_title(); ?></strong>
				<p class="summary"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
			</a>
			<div class="box-meta">
				<?php $cat = get_the_category(); ?>
				<?php if ( ! empty( $cat ) ) : ?>
					<a href="<?php echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>" class="link-category"><?php echo esc_html( $cat[0]->name ); ?></a>
				<?php endif; ?>
				<span class="date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
				<span class="reply"><?php echo (int) get_comments_number(); ?></span>
			</div>
		</div>
	</article>
	<?php
}

/**
 * Featured image URL with a graceful fallback (skin always renders a
 * background-image, even for text-only posts).
 */
function tistory_style_get_thumbnail_url( $size = 'tistory-style-cover' ) {
	if ( has_post_thumbnail() ) {
		$url = get_the_post_thumbnail_url( null, $size );
		if ( $url ) {
			return $url;
		}
		$fallbacks = array( 'medium_large', 'post-thumbnail', 'large', 'full' );
		foreach ( $fallbacks as $fallback ) {
			$url = get_the_post_thumbnail_url( null, $fallback );
			if ( $url ) {
				return $url;
			}
		}
	}
	return get_template_directory_uri() . '/images/no-image.svg';
}

/**
 * Category & sub-category sidebar list (skin: box-category box-category-2depth)
 */
function tistory_style_category_sidebar() {
	$categories = get_categories( array( 'hide_empty' => false, 'parent' => 0 ) );
	if ( empty( $categories ) ) {
		return;
	}
	echo '<ul class="category_list">';
	foreach ( $categories as $category ) {
		$children = get_categories(
			array(
				'hide_empty' => false,
				'parent'     => $category->term_id,
			)
		);
		echo '<li>';
		printf(
			'<a href="%s" class="link_item">%s <span class="c_cnt">(%d)</span></a>',
			esc_url( get_category_link( $category ) ),
			esc_html( $category->name ),
			(int) $category->count
		);
		if ( ! empty( $children ) ) {
			echo '<ul class="sub_category_list">';
			foreach ( $children as $child ) {
				printf(
					'<li><a href="%s" class="link_sub_item">%s <span class="c_cnt">(%d)</span></a></li>',
					esc_url( get_category_link( $child ) ),
					esc_html( $child->name ),
					(int) $child->count
				);
			}
			echo '</ul>';
		}
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Related posts (skin: article-related) — same-category posts, excluding current.
 */
function tistory_style_related_posts( $count = 3 ) {
	$categories = get_the_category();
	if ( empty( $categories ) ) {
		return;
	}
	$ids   = wp_list_pluck( $categories, 'term_id' );
	$query = new WP_Query(
		array(
			'category__in'        => $ids,
			'post__not_in'        => array( get_the_ID() ),
			'posts_per_page'      => $count,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);

	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		return;
	}
	?>
	<div class="article-related">
		<h3 class="title-footer"><?php esc_html_e( '관련글', 'tistory-style' ); ?></h3>
		<ul class="list-related">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<li class="item-related">
					<a href="<?php the_permalink(); ?>" class="link-related">
						<div class="thumbnail-wrap">
							<span class="thumnail" style="background-image:url('<?php echo esc_url( tistory_style_get_thumbnail_url( 'medium_large' ) ); ?>')"></span>
						</div>
						<div class="box_content">
							<strong class="title"><?php the_title(); ?></strong>
							<span class="date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
						</div>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
	<?php
	wp_reset_postdata();
}

/**
 * "이 카테고리의 최신글" side widget on the single post view.
 * The Tistory skin scraped this together on the client with JS/fetch; in
 * WordPress it's just a normal query, so no AJAX hack is needed.
 */
function tistory_style_category_rank_widget( $count = 10 ) {
	$categories = get_the_category();
	if ( empty( $categories ) ) {
		return;
	}
	$cat   = $categories[0];
	$query = new WP_Query(
		array(
			'cat'                 => $cat->term_id,
			'post__not_in'        => array( get_the_ID() ),
			'posts_per_page'      => $count,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	?>
	<div class="category-rank-widget">
		<div class="category-rank-header">
			<h3 class="category-rank-title">
				<span class="category-rank-cat"><?php echo esc_html( $cat->name ); ?></span> <?php esc_html_e( '최신글', 'tistory-style' ); ?>
			</h3>
		</div>
		<?php if ( $query->have_posts() ) : ?>
			<ol class="category-rank-list">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<li class="rank-item">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</li>
				<?php endwhile; ?>
			</ol>
		<?php else : ?>
			<p class="rank-empty"><?php esc_html_e( '이 카테고리의 다른 글이 없습니다.', 'tistory-style' ); ?></p>
		<?php endif; ?>
	</div>
	<?php
	wp_reset_postdata();
}

/* -------------------------------------------------------------------------
 * Custom search form (skin: input.searchInput, no submit button — enter to search)
 * ---------------------------------------------------------------------- */
function tistory_style_search_form( $form ) {
	$unique_id = wp_unique_id( 'search-form-' );
	return '<form role="search" method="get" class="search" action="' . esc_url( home_url( '/' ) ) . '">
		<label for="' . esc_attr( $unique_id ) . '" class="screen-reader-text">' . esc_html__( 'Search for:', 'tistory-style' ) . '</label>
		<input type="text" id="' . esc_attr( $unique_id ) . '" class="searchInput" name="s" value="' . get_search_query() . '" placeholder="Search..." />
	</form>';
}
add_filter( 'get_search_form', 'tistory_style_search_form' );

/* -------------------------------------------------------------------------
 * Comment template (skin: box-reply / list-sidebar card style, simplified)
 * ---------------------------------------------------------------------- */
function tistory_style_comment_callback( $comment, $args, $depth ) {
	?>
	<li <?php comment_class( 'item-comment' ); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment-body">
			<?php echo get_avatar( $comment, 44 ); ?>
			<div class="comment-content">
				<strong class="comment-author"><?php comment_author(); ?></strong>
				<span class="comment-date"><?php echo esc_html( get_comment_date( 'Y.m.d H:i' ) ); ?></span>
				<div class="comment-text"><?php comment_text(); ?></div>
				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
						)
					)
				);
				?>
			</div>
		</div>
	<?php
}

/* -------------------------------------------------------------------------
 * Fallback menu: if no "primary" menu is assigned, build one from categories
 * so the header still shows the category GNB out of the box.
 * ---------------------------------------------------------------------- */
function tistory_style_fallback_menu() {
	echo '<nav class="topnavmenu">';
	tistory_style_category_sidebar();
	echo '</nav>';
}

/* -------------------------------------------------------------------------
 * Archive posts per page: 3 rows x 4 columns = 12 posts per page
 * ---------------------------------------------------------------------- */
function tistory_style_archive_posts_per_page( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_archive() ) {
		$query->set( 'posts_per_page', 12 );
	}
}
add_action( 'pre_get_posts', 'tistory_style_archive_posts_per_page' );
