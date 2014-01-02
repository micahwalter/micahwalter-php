<?php
	include("include/init.php");
	loadlib('users_roles');
	
	login_ensure_loggedin();
		
	### and that we are staff
	
	if ( ! auth_has_role('staff')){
		header("location: {$GLOBALS['cfg']['abs_root_url']}");
		exit;
	}
	
	$id = get_int64('id');
	
	#
	# update?
	#
	$ok = 1;
	
	if (post_str('change')){
	
		### not sure why we have to do it this way, but...
		$roles_update = $_POST['roles'];
		
		
		### needs error checking...
		
		users_roles_update_users_roles($id, $roles_update);

		header("location: {$GLOBALS['cfg']['abs_root_url']}admin/users");
		exit;
		
		
	}
	
	$user = users_get_by_id($id);
	
	if (!$user){
		error_404();
	}
	
	$roles = roles_get_all();

	$roles_status = array();
	
	foreach($roles as $role){

		$has_role = users_roles_user_has_role($id, $role['id']);
		if ( $has_role == TRUE){
			$role['checked'] = 'yes';
		}
		$roles_status[] = $role;
	}
		
	#
	# output
	#

	$smarty->assign('user', $user);
	$smarty->assign('user_id', $id);
	$smarty->assign('roles', $roles_status);
	$smarty->display("page_admin_user.txt");