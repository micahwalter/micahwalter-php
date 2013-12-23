<?php
	include("include/init.php");
	loadlib("profile");
	loadlib("posts");

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
	
	$smarty->assign('posts', $posts);
	$smarty->assign('profile', $profile);
	$smarty->display("page_profile.txt");
