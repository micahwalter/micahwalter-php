<?php
	include("include/init.php");
	loadlib('twitter_status');
	
	$id = get_int64("id");

    if (! $id){
            error_404();
    }
        
    $tweet = twitter_status_get_by_id($id);
	
	### fix this stuff
    if (! $tweet['id']){
            error_404();
    }
		
	#
	# output
	#
	
	$smarty->assign('tweet', $tweet);
	$smarty->display("page_tweet.txt");