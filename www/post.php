<?php
	include("include/init.php");
	loadlib('posts');
	
	$id = get_int64("id");

    if (! $id){
            error_404();
    }
        
    $post = posts_get_by_id($id);
	
	### fix this stuff
    if (! $post['id']){
            error_404();
    }
		
	#
	# output
	#
	
	$smarty->assign('post', $post);
	$smarty->display("page_post.txt");
