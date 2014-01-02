<?php
	include("include/init.php");
	loadlib("twitter_users");

	login_ensure_loggedin();
	
	### get any connected account details
	$twitter_accounts = twitter_users_get_by_user_id($GLOBALS['cfg']['user']['id']);	
	
	#
	# output
	#

	$smarty->assign("twitter_accounts", $twitter_accounts);
	
	$smarty->display("page_account.txt");
