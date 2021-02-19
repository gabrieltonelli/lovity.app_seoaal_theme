<?php

/**

 * The template for displaying comments

 *

 */

if ( post_password_required() ) {

	return;

}

?>

<div class="post-comments" id="comments">

	

	<?php 

		if ( comments_open() ) :

		echo '<div class="post-box"><h4 class="post-box-title">';

		comments_number( '', esc_html__('Comment (1)','seoaal'), esc_html__('Comments (%)','seoaal') );

		echo '</h4></div>';

		endif;

		echo "<ul class='comments'>";

		

			wp_list_comments( array(

				'style'			=> 'ul',

				'max_depth'		=> 5,

				'type'  		=> 'all',

				'callback'		=> 'seoaalPostComments',

				'avatar_size'	=> 80,

			) );

		echo "</ul>";

		echo "<div id='comments_pagination'>";

			paginate_comments_links(array('prev_text' => '&laquo;', 'next_text' => '&raquo;'));

		echo "</div>";

				

		$commenter = wp_get_current_commenter();

		$req = get_option( 'require_name_email' );

		$aria_req = ( $req ? " aria-required='true'" : '' );

		

		$fields =  array(

		

		  'author' =>

			'<div class="row"><div class="comment-form-author col-md-6"><input id="author" class="form-control" placeholder="'. esc_attr__('Your Name', 'seoaal') .' *"  name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .

			'" size="30"' . $aria_req . ' /></div>',

		

		  'email' =>

			'<div class="comment-form-email col-md-6"><input class="form-control" id="email" placeholder="'. esc_attr__('Your Email', 'seoaal') .' *" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .	'" size="30"' . $aria_req . ' /></div></div>',

		

		  'url' =>

			'<div class="row"><div class="comment-form-url col-md-12">' . '<input class="form-control" id="url" name="url" placeholder="'. esc_attr__('Website Url', 'seoaal') .' *" type="text" value="' . esc_url( $commenter['comment_author_url'] ) .

			'" size="30" /></div></div>',

		);

		

		$allowed_html = array(

			'a' => array(

				'href' => array(),

				'title' => array()

			)

		);

		

		$args = array(

		  'id_form'           => 'commentform',

		  'class_form'      => 'comment-form',

		  'id_submit'         => 'submit',

		  'class_submit'      => 'submit btn btn-default',

		  'name_submit'       => 'submit',

		  'title_reply'       => esc_html__( 'Leave Your Comment', 'seoaal' ),

		  'title_reply_to'    => esc_html__( 'Leave a Reply to %s', 'seoaal' ),

		  'title_reply_before'	=> '<h4 id="reply-title" class="comment-reply-title">',

		  'title_reply_after'	=> '</h4>',

		  'cancel_reply_link' => esc_html__( 'Cancel Reply', 'seoaal' ),

		  'label_submit'      => esc_html__( 'Submit', 'seoaal' ),

		  'format'            => 'xhtml',

		  'fields' => apply_filters( 'comment_form_default_fields', $fields ),

		

		 'comment_field' =>  '<div class="row"><div class="comment-form-comment col-md-12"><textarea placeholder="'. esc_attr__('Your Comment', 'seoaal') .'" class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .

			'</textarea></div></div>',

		

		'must_log_in' => '<p class="must-log-in">' .

		sprintf(

		  wp_kses( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'seoaal' ), $allowed_html ),

		  wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )

		) . '</p>',

	

	  'logged_in_as' => '<p class="logged-in-as">' .

		sprintf(

		wp_kses( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'seoaal' ), $allowed_html ),

		  esc_url( admin_url( 'profile.php' ) ),

		  esc_html( $user_identity ),

		  esc_url( wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) )

		) . '</p>',

	

	  'comment_notes_before' => '<p class="comment-notes">' .

		esc_html__( 'Your email address will not be published.', 'seoaal' ) . ( $req ? '*' : '' ) .

		'</p>',

	  

		);

				

		comment_form($args);

	 ?>

</div> <!-- end comments div -->