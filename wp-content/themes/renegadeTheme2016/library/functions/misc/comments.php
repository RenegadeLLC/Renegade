<?php
//Callback functions for comment output

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard clearfloat">
         <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
			
			<div class="commentmetadata">
        <?php printf(__('<cite class="fn">%s</cite>','Mimbo'), get_comment_author_link()) ?>
		 
		 
	 <div class="comment-date"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
	  <?php printf(__('%1$s &bull; %2$s'), get_comment_date(),  get_comment_time()) ?></a>
	  <?php edit_comment_link(__('(Edit)','Mimbo')) ?>
	  </div>
	  </div>
	  
      </div><!--END COMMENT-AUTHOR-->
	  
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.','Mimbo') ?></em>
         <br />
      <?php endif; ?>

      <?php comment_text() ?>

      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
     </div>
<?php
        }
		
		
// add a microid to all the comments
function comment_add_microid($classes) {
	$c_email=get_comment_author_email();
	$c_url=get_comment_author_url();
	if (!empty($c_email) && !empty($c_url)) {
		$microid = 'microid-mailto+http:sha1:' . sha1(sha1('mailto:'.$c_email).sha1($c_url));
		$classes[] = $microid;
	}
	return $classes;	
}
add_filter('comment_class','comment_add_microid');
?>