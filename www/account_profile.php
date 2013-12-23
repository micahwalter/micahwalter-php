<?php
	include("include/init.php");
	loadlib('profile');

	login_ensure_loggedin();
		

	#
	# update?
	#

	if (post_str('change')){
		$full_name	= trim(post_str('full_name'));
		$bio	= post_str('bio');
		
		$profile = array(
			'full_name' => $full_name,
			'bio' => $bio
		);
		
		if (! profile_update_profile($GLOBALS['cfg']['user'], $profile)){

			$smarty->assign('error_fail', 1);
			$ok = 0;
		}
		
		if ($ok){
			# refresh the page ?
		}
	}
	
	$profile = profile_get_by_username($GLOBALS['cfg']['user']['username']);
	
	#
	# output
	#

	$smarty->assign('profile', $profile);
	$smarty->display("page_account_profile.txt");