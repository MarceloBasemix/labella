<div id="comments">
	<!-- Prevents loading the file directly -->
	<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>
	    <?php die(__('Please do not load this page directly or we will hunt you down. Thanks and have a great day!','mazine')); ?>
	<?php endif; ?>
	<div class="smaller-title"><h3><?php comments_number(__('Nenhum comentário','mazine'), __('Um comentário','mazine'), __('% comments','mazine')); ?></h3></div>
	<!-- Password Required -->
	<?php if(!empty($post->post_password)) : ?>
	    <?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
	    <?php endif; ?>
	<?php endif; ?>
	
	<?php $i++; ?> <!-- variable for alternating comment styles -->
	<?php if($comments) : ?>
	    <ol>
	    <?php foreach($comments as $comment) : ?>
	    	<?php $comment_type = get_comment_type(); ?> <!-- checks for comment type -->
	    	<?php if($comment_type == 'comment') { ?> <!-- outputs only comments -->
		        <li id="comment-<?php comment_ID(); ?>" class="comment <?php if($i&1) { echo 'odd';} else {echo 'even';} ?> <?php $user_info = get_userdata(1); if ($user_info->ID == $comment->user_id) echo 'authorComment'; ?> <?php if ($comment->user_id > 0) echo 'user-comment'; ?>">
		        	<div class="comment-author vcard">
									<?php if(function_exists('get_avatar')) { echo '<figure>'; echo get_avatar($comment, '40'); echo '</figure>'; } ?>
									<div class="comment-title">
										<h5><?php comment_author_link(); ?></h5>
										<div class="comment-meta commentmetadata" style="display: block !important;">
											<?php comment_date(); ?> <?php echo __('at','mazine'); ?> <?php comment_time(); ?>
										</div>
									</div>	
								</div>
		            <?php if ($comment->comment_approved == '0') : ?> <!-- if comment is awaiting approval -->
		                <div class="comment-body" style="display: block !important;">
		                	<em><?php echo __('Your comment is awaiting approval.','mazine'); ?></em>
		                </div>
		            <?php endif; ?>
		            <div class="comment-body" style="display: block !important;">
			            <?php comment_text(); ?>
		            </div><!--.commentText-->
		         </li>
			<?php } else { $trackback = true; } ?>
	    <?php endforeach; ?>
	    </ol>
	    <?php if ($trackback == true) { ?><!-- checks for comment type: trackback -->
	    <h3><?php echo __('Trackbacks','mazine'); ?></h3>
		    <ol>
		    	<!-- outputs trackbacks -->
			    <?php foreach ($comments as $comment) : ?>
				    <?php $comment_type = get_comment_type(); ?>
				    <?php if($comment_type != 'comment') { ?>
					    <li><?php comment_author_link() ?></li>
				    <?php } ?>
			    <?php endforeach; ?>
		    </ol>
	    <?php } ?>
	<?php else : ?>
	    <p><?php __('No comments yet. You should be kind and add one!','mazine'); ?></p>
	<?php endif; ?>
	
	<div id="commentForm">
		<?php if(comments_open()) : ?>
			<div class="smaller-title"><h3><?php echo __('Deixe um comentário sobre este produto','mazine'); ?></h3></div>
		    <?php if(get_option('comment_registration') && !$user_ID) : ?>
		        <p><?php echo __('Our apologies, you must be','mazine'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php  _e('Entrar','mazine'); ?></a> <?php _e('para postar um comentário.','mazine') ?></p><?php else : ?>
		        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		            <?php if($user_ID) : ?>
		                <p><?php _e('Logado como','mazine'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','mazine') ?>"><?php _e('Sair &raquo;','mazine') ?></a></p>
		            <?php else : ?>
		           			<input type="text" name="author" id="author" onblur="if(this.value==''){this.value='Name:<?php if ($req) echo __("(required)",'mazine'); ?>'}" onfocus="if(this.value=='Name:<?php if ($req) echo __("(required)",'mazine'); ?>'){this.value=''}" value="<?php if ($comment_author) echo $comment_author; else { echo 'Name:'; if($req) echo __("(required)",'mazine'); } ?>" size="22" tabindex="1" class="text-input" />
		                	<input type="text" name="email" onblur="if(this.value==''){this.value='Mail (will not be published)<?php if ($req) echo __("(required)",'mazine') ?>'}" onfocus="if(this.value=='Mail (will not be published)<?php if($req) echo __("(required)",'mazine'); ?>'){this.value=''}" id="email" value="<?php if ($comment_author_email) echo $comment_author_email; else { echo __('Mail (will not be published)','mazine'); if ($req) echo __("(required)",'mazine'); } ?>" size="22" tabindex="2" class="text-input" />
		                	<input type="text" name="url" id="url" onblur="if(this.value==''){this.value='Website'}" onfocus="if(this.value=='Website'){this.value=''}" value="<?php if ($comment_author_url) echo $comment_author_url; else echo __('Website','mazine'); ?>" size="22" tabindex="3" class="text-input" />
		            <?php endif; ?>
		            	<textarea name="comment" id="comment" cols="21" rows="10" tabindex="4"></textarea>
		            	<button name="submit" type="submit" class="reverse" id="submit" style="float:right" tabindex="5"><span><span><?php   _e('Submit comment'); ?></span></span></button>
		            	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		            <?php do_action('comment_form', $post->ID); ?>
		        </form>
				<!--<p><small>By submitting a comment you grant <?php bloginfo('name'); ?> a perpetual license to reproduce your words and name/web site in attribution. Inappropriate and irrelevant comments will be removed at an admin’s discretion. Your email is used for verification purposes only, it will never be shared.</small></p>-->
		    <?php endif; ?>
		<?php else : ?>
		    <p><?php _e('The comments are closed.','mazine'); ?></p>
		<?php endif; ?>
	</div><!--#commentsForm-->
</div><!--#comments-->