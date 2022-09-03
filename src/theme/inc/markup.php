<?php

function mill_navigation_markup_template( $template, $class ) {
	if ( in_array( $class, ['pagination', 'comments-pagination'] ) ) {
		$template = '
			<nav class="%1$s d-flex justify-content-center flex-column" aria-label="%4$s">
				<h2 class="screen-reader-text">%2$s</h2>
				<div class="d-inline-flex flex-row justify-content-center gap-2">%3$s</div>
			</nav>';
	}

	if ( $class === 'post-navigation' ) {
		$template = '
			<nav class="%1$s justify-content-center flex-column" aria-label="%4$s">
				<h2 class="screen-reader-text">%2$s</h2>
				<div class="d-flex flex-row justify-content-between gap-2">%3$s</div>
			</nav>';
	}
		return $template;
}
add_filter( 'navigation_markup_template', 'mill_navigation_markup_template', 10, 2 );

function mill_paginate_links_output( $r, $args ) {
	if ( in_array( $args['class'], ['pagination', 'comments-pagination'] ) ) {
		$common_class = 'd-inline-flex justify-content-center align-items-center text-body rounded-4 bg-surface-primary shadow p-3';
		$r = str_replace( 'class="prev page-numbers"', 'class="prev page-numbers ' . $common_class . '"', $r );
		$r = str_replace( 'class="page-numbers current"', 'class="page-numbers current font-bolder ' . $common_class . '"', $r );
		$r = str_replace( 'class="page-numbers"', 'class="page-numbers ' . $common_class . '"', $r );
		$r = str_replace( 'class="page-numbers dots"', 'class="page-numbers dots ' . $common_class . '"', $r );
		$r = str_replace( 'class="next page-numbers"', 'class="next page-numbers ' . $common_class . '"', $r );
	}
	return $r;
}
add_filter( 'paginate_links_output', 'mill_paginate_links_output', 10, 2 );

function mill_wp_link_pages( $output, $args ) {
	$common_class = 'd-inline-flex justify-content-center align-items-center text-body rounded-4 bg-surface-primary shadow p-3';
	$output = str_replace( 'class="post-page-numbers current"', 'class="post-page-numbers current font-bolder ' . $common_class . '"', $output );
	$output = str_replace( 'class="post-page-numbers"', 'class="post-page-numbers ' . $common_class . '"', $output );
	return $output;
}
add_filter( 'wp_link_pages', 'mill_wp_link_pages', 10, 2 );

function mill_previous_post_link ( $output, $format, $link, $post, $adjacent ) {
	if ( 'previous' === $adjacent ) {
		$output = str_replace( 'class="nav-previous"', 'class="nav-previous overflow-hidden p-2 p-sm-6 bg-surface-primary rounded-4 shadow w-full"', $output );
		$output = str_replace( 'rel="prev"', 'class="link-dark opacity-60" rel="prev"', $output );
	}
	return $output;
}
add_filter( 'previous_post_link', 'mill_previous_post_link', 10, 5 );

function mill_next_post_link ( $output, $format, $link, $post, $adjacent ) {
	if ( 'next' === $adjacent ) {
		$output = str_replace( 'class="nav-next"', 'class="nav-next overflow-hidden p-2 p-sm-6 bg-surface-primary rounded-4 shadow w-full"', $output );
		$output = str_replace( 'rel="next"', 'class="link-dark opacity-60" rel="next"', $output );
	}
	return $output;
}
add_filter( 'next_post_link', 'mill_next_post_link', 10, 5 );

/**
 *
 *
 * @since Mill 1.0.0
 */
function mill_comment_form_defaults( $defaults ) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$required_attribute = ' required="required" aria-required="true"';
	$required_indicator = ' <span class="required text-danger" aria-hidden="true">*</span>';

	$required_text = sprintf(
		/* translators: %s: Asterisk symbol (*). */
		' <span class="required-field-message" aria-hidden="true">' . __( 'Required fields are marked %s' ) . '</span>',
		trim( $required_indicator )
	);

	$comment_notes_before = sprintf(
		'<p class="comment-notes">%s%s</p>',
		sprintf(
			'<span id="email-notes">%s</span>',
			__( 'Your email address will not be published.' )
		),
		$required_text
	);

	$author_field = sprintf(
		'<div class="comment-form-author my-2">%s%s</div>',
		sprintf(
			'<label class="form-label" for="author">%s%s</label>',
			__( 'Name' ),
			( $req ? $required_indicator : '' )
		),
		sprintf(
			'<input id="author" class="form-control" name="author" type="text" value="%s" size="30" maxlength="245"%s />',
			esc_attr( $commenter['comment_author'] ),
			( $req ? $required_attribute : '' )
		)
	);

	$email_field = sprintf(
		'<div class="comment-form-email my-2">%s%s</div>',
		sprintf(
			'<label class="form-label" for="email">%s%s</label>',
			__( 'Email' ),
			( $req ? $required_indicator : '' )
		),
		sprintf(
			'<input id="email" class="form-control" name="email" type="email" value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />',
			esc_attr( $commenter['comment_author_email'] ),
			( $req ? $required_attribute : '' )
		)
	);

	$url_field = sprintf(
		'<div class="comment-form-url my-2">%s%s</div>',
		sprintf(
			'<label class="form-label" for="url">%s</label>',
			__( 'Website' )
		),
		sprintf(
			'<input id="url" class="form-control" name="url" type="url" value="%s" size="30" maxlength="200" />',
			esc_attr( $commenter['comment_author_url'] )
		)
	);

	$comment_field = sprintf(
		'<div class="comment-form-comment my-2">%s%s</div>',
		sprintf(
			'<label class="form-label" for="comment">%s%s</label>',
			_x( 'Comment', 'noun' ),
			$required_indicator
		),
		'<textarea id="comment" class="form-control" name="comment" cols="45" rows="8" maxlength="65525"' . $required_attribute . '></textarea>'
	);

	$fields   =  [
		'author' => $author_field,
		'email'  => $email_field,
		'url'    => $url_field,
	];

	$defaults = [
		'comment_notes_before' => $comment_notes_before,
		'fields'        => $fields,
		'comment_field' => $comment_field,
		'class_submit'  => 'submit btn btn-primary',
	];

	return $defaults;
}
add_filter( 'comment_form_defaults', 'mill_comment_form_defaults' );

/**
 *
 *
 * @since Mill 1.0.0
 */
function mill_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	$comment_class = '';
	if ($depth !== 1) {
		$comment_class .= ' ps-sm-4';
	}
	if ( $args['has_children'] ) {
		$comment_class .= ' parent d-flex flex-column gap-4';
	}
?>
<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment_class, $comment ); ?>>
	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body d-flex flex-row gap-2">
		<div class="comment-author vcard flex-shrink-0">
			<?php if ( 0 != $args['avatar_size'] ) :
				echo get_avatar( $comment, $args['avatar_size'], '', '', [ 'class' => 'rounded-circle' ] );
			endif; ?>
		</div><!-- .comment-author -->
		<div class="flex-grow-1 p-2 p-sm-6 shadow bg-surface-primary rounded-4 min-w-0">
			<div class="comment-metadata d-flex gap-2 mb-4">
				<?php printf(
					'<b class="fn">%s</b><a class="text-body" href="%s"><time datetime="%s">%s</time></a>',
					get_comment_author( $comment ),
					esc_url( get_comment_link( $comment, $args ) ),
					get_comment_time( 'c' ),
					sprintf(
						__( '%1$s at %2$s' ),
						get_comment_date( '', $comment ),
						get_comment_time()
					)
				);
				edit_comment_link(); ?>
			</div><!-- .comment-metadata -->
			<div class="comment-content article mill-typography">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->
			<?php comment_reply_link( array_merge( $args, [
				'add_below' => 'div-comment',
				'depth'     => $depth,
				'max_depth' => $args['max_depth'],
				'before'    => '<div class="reply">',
				'after'     => '</div>'
			] ) ); ?>
		</div>
	</article><!-- .comment-body -->
<?php }

// wp_nav_menuのliにclass追加
function mill_add_additional_class_on_li( $classes, $item, $args ) {
  if ( isset( $args->mill_li_class ) ) {
    $classes[] = $args->mill_li_class;
  }
  return $classes;
}
add_filter( 'nav_menu_css_class', 'mill_add_additional_class_on_li', 10, 3 );

// wp_nav_menuのaにclass追加
function mill_add_additional_class_on_a( $atts, $item, $args ) {
	if ( isset( $args->mill_a_class ) ) {
		$atts['class'] = $args->mill_a_class;
		if ( $item->current ) {
			$atts['class'] = $atts['class'] . ' active';
		}
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'mill_add_additional_class_on_a', 10, 3 );

function mill_add_category_list_link_attributes ( $atts, $category, $depth, $args ) {
	if ( 'mill-badge'  === $args['style'] ) {
		$atts['class'] = 'btn btn-outline-primary btn-sm px-2 py-1';
		$atts['rel'] = 'category tag';
		return $atts;
	}
	return $atts;
}
add_filter( 'category_list_link_attributes', 'mill_add_category_list_link_attributes', 10, 4 );

function mill_wp_generate_tag_cloud_data ( $tags_data ) {
	$tags_data = array_map( function( $value ){
		if ( isset( $value['class'] ) ) {
			$value['class'] = $value['class'] . ' badge bg-soft-secondary text-xs text-body font-regular m-0';
		}
		return $value;
	}, $tags_data);
	return $tags_data;
}
add_filter( 'wp_generate_tag_cloud_data', 'mill_wp_generate_tag_cloud_data' );

function mill_the_category ( $thelist, $separator ) {
	if ( 'none' === $separator) {
		$thelist = str_replace( $separator, '', $thelist );
	}
	$thelist = str_replace( 'rel="category', 'class="link-dark opacity-60" rel="category', $thelist );
	return $thelist;
}
add_filter( 'the_category', 'mill_the_category', 10, 2 );

function mill_the_tags ( $tag_list ) {
	$tag_list = str_replace( 'rel="tag"', 'class="badge bg-soft-secondary text-body font-regular" rel="tag"', $tag_list );

	return $tag_list;
}
add_filter( 'the_tags', 'mill_the_tags' );
