<?php
	include("include/init.php");
	loadlib("profile");

	$user_name = get_str("user_name");

    if (! $user_name){
            error_404();
    }
        
    $profile = profile_get_by_username($user_name);

    if (! $profile){
            error_404();
    }
		
	#
	# output
	#
	
	$smarty->assign('profile', $profile);
	$smarty->display("page_profile.txt");
