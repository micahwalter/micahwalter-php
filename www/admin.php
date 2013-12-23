<?php
	include("include/init.php");

	login_ensure_loggedin();
	
	### and that we are staff
	
	if ( ! auth_has_role('staff')){
		header("location: {$GLOBALS['cfg']['abs_root_url']}");
		exit;
	}


	#
	# output
	#

	$smarty->display("page_admin.txt");