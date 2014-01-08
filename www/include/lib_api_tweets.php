<?php

	loadlib('twitter_status');
	
	#################################################################

	function api_tweets_getInfo(){
		
		$id = request_int64("id");
		
		if ( !$id ){
			$twitter_id = request_int64("twitter_id");
			$tweet = twitter_status_get_by_twitter_id($twitter_id);
		} else {
			$tweet = twitter_status_get_by_id($id);
		}
		
				
		$out = array(
		    'tweet' => $tweet
		);

		api_output_ok($out);
	}

	# the end
