<?php
	include("include/init.php");
	loadlib("profile");
	loadlib("posts");
	loadlib('gravatar');

	$user_name = get_str("user_name");

    if (! $user_name){
            error_404();
    }
        
    $profile = profile_get_by_username($user_name);

    if (! $profile){
            error_404();
    }

	$posts = posts_get_by_user_id($profile['profile']['user_id']);
		
	#
	# output
	#

	$grav = get_gravatar($profile['user']['email']);
	
	$smarty->assign('gravatar', $grav);
	
	$smarty->assign('posts', $posts);
	$smarty->assign('profile', $profile);
	$smarty->display("page_profile.txt");
