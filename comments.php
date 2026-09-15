<?php
/**
 * Comments template, converted from the skin's box-reply list markup.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="box-reply">

	<?php if ( have_comments() ) : ?>
		<h3 class="title-footer">
			<?php
			printf(
				/* translators: %d: comment count */
				esc_html( _n( '댓글 %d개', '댓글 %d개', get_comments_number(), 'tistory-style' ) ),
				(int) get_comments_number()
			);
			?>
		</h3>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'    => 'ol',
					'callback' => 'tistory_style_comment_callback',
				)
			);
			?>
		</ol>

		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php esc_html_e( '댓글이 닫혔습니다.', 'tistory-style' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'         => __( '댓글 남기기', 'tistory-style' ),
			'class_submit'        => 'btn-primary',
			'comment_notes_after' => '',
		)
	);
	?>
</div>
