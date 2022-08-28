<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */

if ( post_password_required() ) {
	return;
}

if ( have_comments() ) : ?>
	<div id="comments">
		<h2 class="comments-title mb-2">
			<?php esc_html_e( 'Comments' ); ?>
		</h2>
		<?php if ( wp_list_comments( [ 'type' => 'comment', 'echo' => false, ] ) ) : ?>
			<div class="comment-list d-flex flex-column gap-4">
				<?php wp_list_comments( [
					'type'     => 'comment',
					'style'    => 'div',
					'callback' => 'mill_comment',
				] );
				if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
					the_comments_pagination();
				endif; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif;

// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<div class="no-comments-area p-2 p-sm-6 shadow bg-surface-primary rounded-4 min-w-0">
		<p class="no-comments">
			<?php esc_html_e( 'Comments are closed.' ); ?>
		</p>
	</div>
<?php endif;

if ( comments_open() ) : ?>
	<div class="p-2 p-sm-6 shadow bg-surface-primary rounded-4 min-w-0">
		<?php comment_form(); ?>
	</div>
<?php endif;
