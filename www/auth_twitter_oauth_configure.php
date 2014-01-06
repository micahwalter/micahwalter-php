<?php

	include("include/init.php");
	loadlib("twitter_users");
	
	
	login_ensure_loggedin();
	
	$screen_name = get_str("screen_name");

    if (! $screen_name){
            error_404();
    }
			
	$twitter_user = twitter_users_get_by_screen_name($screen_name);
	
    if (! $twitter_user){
            error_404();
    }
	
	#
	# output
	#
	
	$smarty->assign("twitter", $twitter_user);
	$smarty->display("page_auth_twitter_oauth_configure.txt");
	