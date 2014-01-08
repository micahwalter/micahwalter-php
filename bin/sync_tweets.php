<?php

	$root = dirname(dirname(__FILE__));
	ini_set("include_path", "{$root}/www:{$root}/www/include");
	
	include("include/init.php");
	loadlib("backfill");
	loadlib("twitter_oauth");
	loadlib("twitter_status");
		
	function sync_user($twitter_user, $more=array()){

		echo "syncing tweets for '{$twitter_user['screen_name']}'\n";
		
		$rsp = twitter_status_get_users_latest_status($twitter_user['twitter_id']);

		$since_id = $rsp['twitter_id'];

		$method = 'statuses/user_timeline';
					
		$args = array(
			'method' => $method,
			'user_id' => $twitter_user['twitter_id'],
			'count' => 200,
			'since_id' => $since_id,
		);
		
		$user_keys = array(
			'oauth_token' => $twitter_user[0]['oauth_token'],
			'oauth_secret' => $twitter_user[0]['oauth_secret'],
		);
		
		$rsp = twitter_oauth_api_get_call($args, $user_keys);
		
		$json = json_decode($rsp['body'], 'as a hash');
		
		foreach($json as $tweet){
			echo "Archiving tweet: " . $tweet['id'] . "\n";
			
			$rsp = twitter_status_create_status(array(
				'twitter_id' => $tweet['id'],
				'twitter_user_id' => $twitter_user['twitter_id'],
				'in_reply_to_status_id' => $tweet['in_reply_to_status_id'],
				'in_reply_to_user_id' => $tweet['in_reply_to_user_id'],
				'in_reply_to_screen_name' => $tweet['in_reply_to_screen_name'],
				'latitude' => $tweet['geo']['coordinates'][0],
				'longitude'	=> $tweet['geo']['coordinates'][1],
				'text' => $tweet['text'],
				'created_at' => $tweet['created_at'],
				'source' => $tweet['source'],
			));
		}
		
		
	}
			
    $sql = "SELECT * FROM TwitterUsers";
    backfill_db_users($sql, "sync_user");

    exit();
?>