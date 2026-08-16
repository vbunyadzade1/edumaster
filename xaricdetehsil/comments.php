<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
 
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
    return;
?>
<div class="comments-area">
   <h3 class="comments-title"><?php comments_number('', '1 Rəy', '% Rəylər' ); ?></h3>
   <?php if ( have_comments() ) : ?>
   <?php if ( get_comment_pages_count() >= 1 ) : ?>	
   <ol class="comment-list">
      <?php
         wp_list_comments( array(
             'style'       => 'ol',
             'short_ping'  => true,
             'avatar_size' => 74,
         ) );
         ?>
   </ol>
   <?php endif; ?>
   <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
   <nav class="navigation comment-navigation" role="navigation">
      <h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'KavKaz' ); ?></h1>
      <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'KavKaz' ) ); ?></div>
      <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'KavKaz' ) ); ?></div>
   </nav>
   <?php endif; ?>
   <?php if ( ! comments_open() && get_comments_number() ) : ?>
   <p class="no-comments"><?php _e( 'Rəylər bağlandı.' , 'KavKaz' ); ?></p>
   <?php endif; ?>
   <?php endif;?>	
   <?php if ( comments_open() ) : ?>
   <div class="comment-respond">
      <h3 class="comment-reply-title"><?php _kavkaz('Mövzu haqqında fikir bildir.'); ?></h3>
      <form class="comment-form" action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="POST" id="commentform">
         <p class="comment-notes">
            <span id="email-notes"><?php _kavkaz('Məqalə haqqında sual və təkliflərinizi qeyd edin. (Mail ünvanı görünməyəcək)'); ?></span>
            <span class="required">*</span>
         </p>
         <?php if ( !is_user_logged_in() ): ?>		  
         <p class="comment-form-author">
            <label>Name <span class="required">*</span></label>
            <input type="text" id="author" placeholder="Ad Soyad*" name="author" required="required">
         </p>
         <p class="comment-form-email">
            <label>Email <span class="required">*</span></label>
            <input type="email" id="email" placeholder="Email*" name="email" required="required">
         </p>
         <?php endif; ?> 
         <p class="comment-form-comment">
            <label>Rəy</label>
            <textarea name="comment" id="comment" cols="45" placeholder="Rəy bildir..." rows="5" maxlength="65525" required="required"></textarea>
         </p>
         <p class="comment-form-cookies-consent">
            <?php 
               if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
                  $consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
               
                  $fields['cookies'] = sprintf(
                     '<p class="comment-form-cookies-consent">%s %s</p>',
                     sprintf(
                        '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />',
                        $consent
                     ),
                     sprintf(
                        '<label for="wp-comment-cookies-consent">%s</label>',
                        __kavkaztext( 'Növbəti rəy yazmaq üçün mənim məlumatlarımı bu brauzerdə saxla.' )
                     )
                  );
               
                  // Ensure that the passed fields include cookies consent.
                  if ( isset( $args['fields'] ) && ! isset( $args['fields']['cookies'] ) ) {
                     $args['fields']['cookies'] = $fields['cookies'];
                  }
               }
               
               ?>
         </p>
         <p class="form-submit">
            <input type="submit" name="submit" id="submit" class="submit" value="Göndər">
            <?php comment_id_fields(); ?>
         </p>
      </form>
   </div>
   <?php endif; ?>
</div>