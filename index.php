<?php
/**
 * Front page layout styled after the supplied reference image.
 *
 * - Large featured article on the left
 * - Two compact secondary articles below it
 * - Two visual recent articles in the right rail
 * - Archives/search remain handled by their own templates
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

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
 * Category sections: show the 3 newest posts from every top-level category.
 * Each category is rendered independently so the same post can appear in
 * different category sections when WordPress assigns multiple categories.
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
