<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# KavKaz Comment Callback
/*-----------------------------------------------------------------------------------*/
function kavkaz_comment_lists($comment, $args, $depth) {
?>
<li id="comment-<?php comment_ID(); ?>" class="comment">
   <article class="comment-body">
      <footer class="comment-meta">
         <div class="comment-author vcard">
            <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            <b class="fn"><?php printf( __( '%s' ), sprintf( '<li>%s</li>', get_comment_author_link() ) ); ?></b>
         </div>
         <div class="comment-metadata">
            <time><?php printf( _x( '%1$s at %2$s', '1: date, 2: time' ), get_comment_date(), get_comment_time() ); ?></time>
         </div>
      </footer>
      <div class="comment-content">
         <?php if ( '0' == $comment->comment_approved ) : ?>
         <p class="comment-awaiting-moderation"><?php _kavkaz('Rəyiniz moderator tərəfindən təsdiqlənəcək.'); ?></p>
         <?php endif; ?>
         <p><?php comment_text(); ?></p>
      </div>
         <?php
			comment_reply_link( array_merge( $args, array(
				'add_below' => $add_below,
				'depth'     => $depth,
				'max_depth' => $args['max_depth'],
				'before'    => '<div class="reply">',
				'after'     => '</div>'
			 ) ) );
            ?>
   </article>
</li>						
<?php
}

?>