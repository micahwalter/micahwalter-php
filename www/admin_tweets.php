<?php
	include("include/init.php");
	loadlib('twitter_status');

	login_ensure_loggedin();
	
	### and that we are staff
	
	if ( ! auth_has_role('staff')){
		header("location: {$GLOBALS['cfg']['abs_root_url']}");
		exit;
	}
	
	#
	# update?
	#	
	$more = array();

    if ($page = get_int32("page")){
            $more['page'] = $page;
    }
			
	$tweets = twitter_status_get_statuses($more);

	#
	# output
	#

	$smarty->assign('tweets', $tweets['rows']);
	$pagination_url = "{$GLOBALS['cfg']['site_abs_root_url']}admin/tweets/";
	$GLOBALS['smarty']->assign("pagination_url", $pagination_url);
	$smarty->display("page_admin_tweets.txt");