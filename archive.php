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

	<div class="archive-heading archive-heading-wrap">
		<h2 class="title-search title-border">
			<b class="archives"><?php the_archive_title(); ?></b>
			<span class="archive-post-total"><?php printf( esc_html__( '%d개의 글', 'tistory-style' ), (int) $wp_query->found_posts ); ?></span>
		</h2>

		<div class="archive-view-toggle" role="group" aria-label="<?php esc_attr_e( '목록 보기 방식', 'tistory-style' ); ?>">
			<button type="button" class="btn-view-toggle is-active" data-view="card" aria-pressed="true">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
				<span><?php esc_html_e( '카드형', 'tistory-style' ); ?></span>
			</button>
			<button type="button" class="btn-view-toggle" data-view="timeline" aria-pressed="false">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
				<span><?php esc_html_e( '연도별', 'tistory-style' ); ?></span>
			</button>
		</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<!-- 1. 기본 카드 그리드 뷰 -->
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

		<!-- 2. 연도별 타임라인 뷰 -->
		<?php
		$queried_obj = get_queried_object();
		$timeline_args = array(
			'posts_per_page'      => -1,
			'post_status'         => 'publish',
			'orderby'             => 'date',
			'order'               => 'DESC',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
		);

		if ( is_category() && ! empty( $queried_obj->term_id ) ) {
			$timeline_args['cat'] = $queried_obj->term_id;
		} elseif ( is_tag() && ! empty( $queried_obj->term_id ) ) {
			$timeline_args['tag_id'] = $queried_obj->term_id;
		}

		$timeline_query = new WP_Query( $timeline_args );
		$timeline_by_year = array();

		if ( $timeline_query->have_posts() ) {
			while ( $timeline_query->have_posts() ) {
				$timeline_query->the_post();
				$year = get_the_date( 'Y' );
				$timeline_by_year[ $year ][] = array(
					'id'        => get_the_ID(),
					'title'     => get_the_title(),
					'permalink' => get_permalink(),
					'date_md'   => get_the_date( 'm.d' ),
					'date_full' => get_the_date( 'Y.m.d' ),
					'comments'  => (int) get_comments_number(),
					'thumb'     => tistory_style_get_thumbnail_url( 'tistory-style-related' ),
				);
			}
			wp_reset_postdata();
		}
		?>

		<div class="archive-timeline-view" style="display: none;" aria-hidden="true">
			<?php if ( ! empty( $timeline_by_year ) ) : ?>
				<!-- 연도 퀵점프 칩 네비게이션 -->
				<div class="timeline-year-chips" role="navigation" aria-label="<?php esc_attr_e( '연도별 빠른 이동', 'tistory-style' ); ?>">
					<button type="button" class="chip-year is-active" data-target-year="all">
						<?php esc_html_e( '전체', 'tistory-style' ); ?>
						<span class="chip-count"><?php echo (int) $wp_query->found_posts; ?></span>
					</button>
					<?php foreach ( $timeline_by_year as $yr => $posts_in_yr ) : ?>
						<button type="button" class="chip-year" data-target-year="<?php echo esc_attr( $yr ); ?>">
							<?php echo esc_html( $yr ); ?>
							<span class="chip-count"><?php echo count( $posts_in_yr ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>

				<!-- 연도별 타임라인 그룹 -->
				<div class="timeline-tree-wrap">
					<?php foreach ( $timeline_by_year as $yr => $posts_in_yr ) : ?>
						<section class="timeline-year-group" id="year-group-<?php echo esc_attr( $yr ); ?>" data-year="<?php echo esc_attr( $yr ); ?>">
							<div class="timeline-year-badge-wrap">
								<span class="timeline-year-badge"><?php echo esc_html( $yr ); ?></span>
								<span class="timeline-year-count"><?php printf( esc_html__( '%d개의 기록', 'tistory-style' ), count( $posts_in_yr ) ); ?></span>
							</div>

							<ul class="timeline-item-list">
								<?php foreach ( $posts_in_yr as $item ) : ?>
									<li class="timeline-item">
										<span class="timeline-node" aria-hidden="true"></span>
										<time class="timeline-date" datetime="<?php echo esc_attr( $item['date_full'] ); ?>"><?php echo esc_html( $item['date_md'] ); ?></time>
										<div class="timeline-content">
											<a href="<?php echo esc_url( $item['permalink'] ); ?>" class="timeline-title-link">
												<strong class="timeline-title"><?php echo esc_html( $item['title'] ); ?></strong>
											</a>
											<?php if ( $item['comments'] > 0 ) : ?>
												<span class="timeline-comments" title="<?php esc_attr_e( '댓글', 'tistory-style' ); ?>">
													<i class="xi-comment-o" aria-hidden="true"></i> <?php echo $item['comments']; ?>
												</span>
											<?php endif; ?>
										</div>
										<a href="<?php echo esc_url( $item['permalink'] ); ?>" class="timeline-thumb-link" tabindex="-1" aria-hidden="true">
											<span class="timeline-thumb" style="background-image: url('<?php echo esc_url( $item['thumb'] ); ?>');"></span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</section>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

	<?php else : ?>
		<div class="box-no-search type-category">
			<span><?php esc_html_e( '선택하신 조건에 해당하는 글이 없습니다.', 'tistory-style' ); ?></span>
			<span><?php esc_html_e( '다른 카테고리를 선택하시거나, 검색 기능을 활용해 보세요.', 'tistory-style' ); ?></span>
		</div>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
