<?php

/*

	Extension for wordpress-newsletter plugin. Enables Ajax newsketter sign up

*/

function ti_wpnewsletter_opt_in() {
	global $wpdb;
	$table_users = $wpdb->prefix . "newsletter_users";

	//trim the email
	if (empty($_POST['wpnewsletter_email'])) {

		if (!empty($_GET['kei'])) {
			wpnewsletter_optin_confirm();
		}
		else {
			$_POST['wpnewsletter_email'] = trim($_POST['wpnewsletter_email']);
			wpnewsletter_show_optin_form();
		}
		
	} 
	else {
	
		$name = stripslashes($_POST['wpnewsletter_name']);
		$name  = checkValid($name );

		$email = stripslashes($_POST['wpnewsletter_email']);
		$email = checkValid($email);

		//replace name		
		$find = array('/Š/','/š/','/Ÿ/','/§/','/€/','/…/','/†/','/ /','/[:;]/');

		$replace = array('ae','oe','ue','ss','Ae','Oe','Ue','_','');

		$name = preg_replace ($find , $replace, strtolower($name));


		if($name == "" || $email == "")
			return;
		
		$wpnewsletter_custom_flds = "";
		if (!preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $email)) {
				    header( "Content-Type: application/json" );
					echo json_encode(array('error'=>"Email format is incorrect"));
				 	exit;
		}
		else {
			

				$email_from = stripslashes(get_option('wpnewsletter_email_from'));

				$subject = stripslashes(get_option('wpnewsletter_email_subject'));
				
				$message = stripslashes(get_option('wpnewsletter_email_message'));
				
				//create activation link
				$url = get_bloginfo('wpurl') .'/wp-content/plugins/wordpress-newsletter/newsletter.php?';
			
				$wpnewsletter_ip = wpnewsletter_getip();
				
				$url .= "kei=".md5($email.$name);

				$message = str_replace('*link*', $url, $message);
					
				$blogname = get_option('blogname');
		$header = "From: $email_from\n"
			. "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
				$selectqry = "SELECT * FROM " . $table_users . " WHERE `email` = '" . $email ."'";
				if ($wpdb->query($selectqry)) {
					 header( "Content-Type: application/json" );
					echo json_encode(array('error' => stripslashes(get_option('wpnewsletter_msg_dup'))));
					exit;
				}
				else {
					if (mail($email,$subject,$message, $header)) {

							$query = "INSERT INTO " . $table_users . " 
								(joindate, ip, email, joinstatus, name) 
								VALUES (
								now(),
								'" . $wpnewsletter_ip . "',
								'" . $email . "',0,
								'" . $name . "'	)";
						 	$result = $wpdb->query($query);
							//echo($query);
						
						echo json_encode(array('success' => stripslashes(get_option('wpnewsletter_msg_sent'))));
						exit;
						//ob_start();					
						//$_COOKIE["newslettername"] = $name;

						//ob_end_flush();
					} 
					else {
						 header( "Content-Type: application/json" );
						echo json_encode(array('error'=> stripslashes(get_option('wpnewsletter_msg_fail'))));
						exit;
					}
				}
				//	unset($_SESSION['security_code']);
			//	return 0;
			
		}
	}
}


function ti_widget_newsletter_init() {
    function ti_widget_newsletter($args) {
        $options = get_option('newsletter');
		extract($args);		

		

        $optionsw = get_option('ti_newsletter_widget');
        $title = $optionsw['title'];
        $text = $optionsw['text'];
        $form = $optionsw['form'];

        echo $before_widget . $before_title . $title . $after_title;
		
		if (!empty($_POST['wpnewsletter_email'])) {
			ti_wpnewsletter_opt_in();
		} else {
		
		echo $optionsw['text'];
		$out = '<form action="javascript:nlaction()" method="post" id="nl-action">';
		
		$out .= '<input type="hidden" name="wpnewsletter_name" id="wpnewsletter_name" value="guest"/>';
		$out .= '<div class="fi_l"><div class="fi_r"><input type="text" name="wpnewsletter_email" id="news-letter"/></div></div>';
		$out .= '<button><span><span>subscribe</span></span></button>';	
		$out .= '</form>';
	
		echo $out;
    	echo '<div id="nl-text"></div>'; 
		
        }

        echo $after_widget;
    }

    function ti_widget_newsletter_control() {
    // Get our options and see if we're handling a form submission.
        $options = get_option('ti_newsletter_widget');
        if (!is_array($options)) {
            $options = array('title'=>'Newsletter subscription');
            $options = array('text'=>'');
        }

        if ( $_POST['newsletter-submit'] ) {
        // Remember to sanitize and format use input appropriately.
            $options['title'] = strip_tags(stripslashes($_POST['newsletter-title']));
            $options['text'] = stripslashes($_POST['newsletter-text']);
            $options['form'] = stripslashes($_POST['newsletter-form']);
            update_option('ti_newsletter_widget', $options);
        }

        // Be sure you format your options to be valid HTML attributes.
        $title = htmlspecialchars($options['title'], ENT_QUOTES);
        $text = htmlspecialchars($options['text'], ENT_QUOTES);
        $form = htmlspecialchars($options['form'], ENT_QUOTES);

        // Here is our little form segment. Notice that we don't need a
        // complete form. This will be embedded into the existing form.
        echo 'Title<br /><input id="newsletter-title" name="newsletter-title" type="text" value="'.$title.'" />';
        echo '<br /><br />';
        echo 'Introduction<br /><textarea style="width: 350px;" id="newsletter-text" name="newsletter-text">'.$text.'</textarea>';
      
        echo '<input type="hidden" id="newsletter-submit" name="newsletter-submit" value="1" />';
    }

   
    register_widget_control('Newsletter', 'ti_widget_newsletter_control', 370, 200);
     register_sidebar_widget('Newsletter', 'ti_widget_newsletter');
}


	
add_action("widgets_init", "ti_widget_newsletter_init");
add_action('wp_head', 'newsletter_ajax_call' );
add_action('wp_ajax_nl_ajax_action', 'ti_wpnewsletter_opt_in');
add_action('wp_ajax_nopriv_nl_ajax_action', 'ti_wpnewsletter_opt_in');
function newsletter_ajax_call() 
{
 ?>
<script type="text/javascript">
//<![CDATA[
function nlaction(){$.post("<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php", { action : "nl_ajax_action" ,  wpnewsletter_name : $('#wpnewsletter_name').val(),   wpnewsletter_email : $('#news-letter').val() }, function(data){	if(data.error != undefined){if ($('#nl-text').html() != ''){$('#nl-text').fadeOut('fast', function(){$('#nl-text').html('<div class="nl_error">'+data.error+'</div>');})}else {$('#nl-text').html('<div class="nl_error">'+data.error+'</div>');}}else {if ($('#nl-text').html() != ''){$('#nl-text').fadeOut('fast', function(){$('#nl-text').html('<div class="nl_success">'+data.success+'</div>');})}else {$('#nl-text').html('<div class="nl_success">'+data.success+'</div>');}
}$('#nl-text').fadeIn('slow',function(){$('#nl-text').delay(3000).fadeOut('slow', function(){$('#nl-text').html('');})})},"json");}
 //]]>
</script>
<?php
} 

?>