<?php /* Template Name: Register Page */ ?>
<?php get_header(); ?>
<section id="content">
	<div class="container_12">
		
		<?php if ( ! dynamic_sidebar( 'Alert' ) ) : ?>
			<!--Wigitized 'Alert' for the home page -->
		<?php endif ?>
		
	
		
		
		<div id="login-register-password">

	<?php global $user_ID, $user_identity; get_currentuserinfo(); if (!$user_ID) { ?>
	
	<div class="tab_container_login">
		<div id="tab1_login" class="tab_content_login fance grid_3">

			<?php $register = $_GET['register']; $reset = $_GET['reset']; if ($register == true) { ?>

			<h3><?php _e('Success!', 'mazine'); ?></h3>
			<p><?php _e('Check your email for the password and then return to log in.', 'mazine'); ?></p>

			<?php } elseif ($reset == true) { ?>

			<h3><?php _e('Success!', 'mazine'); ?></h3>
			<p><?php _e('Check your email to reset your password.', 'mazine'); ?></p>

			<?php } else { ?>

			<h3><?php _e('Have an account?', 'mazine'); ?></h3>
			<p><?php _e('Log in or sign up! It&rsquo;s fast &amp; <em>free!</em>', 'mazine'); ?></p>

			<?php } ?>

			<form method="post" action="<?php bloginfo('url') ?>/wp-login.php" class="wp-user-form">
				<div class="username">
					<label for="user_login"><?php _e('Username', 'mazine'); ?>: </label>
					<input type="text" name="log" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="23" id="user_login" tabindex="11" />
				</div>
				<div class="password">
					<label for="user_pass"><?php _e('Password', 'mazine'); ?>: </label>
					<input type="password" name="pwd" value="" size="23" id="user_pass" tabindex="12" />
				</div>
				<div class="login_fields">
					<div class="rememberme">
						<label for="rememberme">
							<input type="checkbox" name="rememberme" value="forever" checked="checked" id="rememberme" tabindex="13" /> Remember me
						</label>
					</div>
					<?php do_action('login_form'); ?>
					<button type="submit" name="user-submit" value="" tabindex="14" class="user-submit"><span><span><?php _e('Login', 'mazine'); ?></span></span></button>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>
		</div>
		<div id="tab2_login" class="tab_content_login fance grid_3">
			<h3><?php _e('Register for this site!', 'mazine'); ?></h3>
			<p><?php _e('Sign up now for the good stuff.', 'mazine'); ?></p>
			<form method="post" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="wp-user-form">
				<div class="username">
					<label for="user_login"><?php _e('Username', 'mazine'); ?>: </label>
					<input type="text" name="user_login" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="23" id="user_login" tabindex="101" />
				</div>
				<div class="password">
					<label for="user_email"><?php _e('Your Email', 'mazine'); ?>: </label>
					<input type="text" name="user_email" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="23" id="user_email" tabindex="102" />
				</div>
				<div class="login_fields">
					<?php do_action('register_form'); ?>
					<br/>
					<button value="" class="user-submit" tabindex="103" /><span><span><?php _e('Sign up!', 'mazine'); ?></span></span></button>
					<?php $register = $_GET['register']; if($register == true) { echo __('<p>Check your email for the password!</p>', 'mazine'); } ?>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>
		</div>
		<div id="tab3_login" class="tab_content_login fance grid_3">
			<h3><?php _e('Lose something?', 'mazine'); ?></h3>
			<p><?php _e('Enter your username or email to reset your password.', 'mazine'); ?></p>
			<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form">
				<div class="username">
					<label for="user_login" class="hide"><?php _e('Username or Email'); ?>: </label>
					<input type="text" name="user_login" value="" size="23" id="user_login" tabindex="1001" />
				</div>
				<div class="login_fields">
					<?php do_action('login_form', 'resetpass'); ?>
					<br/>
					<br style="margin-bottom:5px;" />
					<button class="user-submit" tabindex="1002"><span><span><?php _e('Reset my password','mazine'); ?></span></span></button>
					<?php $reset = $_GET['reset']; if($reset == true) { echo __('<p>A message will be sent to your email address.</p>', 'mazine'); } ?>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?reset=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>
		</div>
	</div>

	<?php } else { // is logged in ?>

	<div class="sidebox">
		<h3><?php _e('Welcome,', 'mazine'); ?> <?php echo $user_identity; ?></h3>
		<div class="usericon">
			<?php global $userdata; get_currentuserinfo(); echo get_avatar($userdata->ID, 60); ?>

		</div>
		<div class="userinfo">
			<p><?php _e('You&rsquo;re logged in as', 'mazine'); ?><strong><?php echo $user_identity; ?></strong></p>
			<p>
				<a href="<?php echo wp_logout_url('index.php'); ?>"><?php _e('Log out', 'mazine'); ?></a> | 
				<?php if (current_user_can('manage_options')) { 
					echo '<a href="' . admin_url() . '">' . __('Admin','mazine') . '</a>'; } else { 
					echo '<a href="' . admin_url() . 'profile.php">' . __('Profile', 'mazine') . '</a>'; } ?>

			</p>
		</div>
	</div>

	<?php } ?>

</div>

		
		
		<!--#content-->
		
	</div>	
</section>
<?php get_footer(); ?>
