<?php

	# This uses lib_oauth for all the signing and building
	# URL crap but uses Flamework's lib_http for actually
	# talking to the network.
	
	loadlib("oauth");
	loadlib("http");

	#################################################################

	$GLOBALS['cfg']['twitter_api_endpoint'] = 'https://api.twitter.com/1.1/';
	$GLOBALS['cfg']['twitter_oauth_endpoint'] = 'https://api.twitter.com/oauth/';

	#################################################################

	function twitter_oauth_get_request_token($args=array()){

		$keys = array(
			'oauth_key' => $GLOBALS['cfg']['twitter_oauth_key'],
			'oauth_secret' => $GLOBALS['cfg']['twitter_oauth_secret'],
		);

		$url = $GLOBALS['cfg']['twitter_oauth_endpoint'] . 'request_token/';

		$url = oauth_sign_get($keys, $url, $args, 'GET');
		$rsp = http_get($url);

		if (! $rsp['ok']){
			return $rsp;
		}

		$data = twitter_oauth_rsp_to_hash($rsp['body']);

		return array(
			'ok' => 1,
			'data' => $data,
		);
	}

	#################################################################

	function twitter_oauth_get_auth_url(&$args, &$user_keys){

		$keys = array(
			'oauth_key' => $GLOBALS['cfg']['twitter_oauth_key'],
			'oauth_secret' => $GLOBALS['cfg']['twitter_oauth_secret'],
			'user_key' => $user_keys['oauth_token'],
			'user_secret' => $user_keys['oauth_secret'],
		);

		$url = $GLOBALS['cfg']['twitter_oauth_endpoint'] . 'authorize/';
		$url = oauth_sign_get($keys, $url, $args, 'GET');

		return $url;
	}

	#################################################################

	function twitter_oauth_get_access_token(&$args, &$user_keys){

		$keys = array(
			'oauth_key' => $GLOBALS['cfg']['twitter_oauth_key'],
			'oauth_secret' => $GLOBALS['cfg']['twitter_oauth_secret'],
			'user_key' => $user_keys['oauth_token'],
			'user_secret' => $user_keys['oauth_secret'],
		);

		$url = $GLOBALS['cfg']['twitter_oauth_endpoint'] . 'access_token/';

		$url = oauth_sign_get($keys, $url, $args, 'GET');
		$rsp = http_get($url);

		if (! $rsp['ok']){
			return $rsp;
		}

		$data = twitter_oauth_rsp_to_hash($rsp['body']);

		return array(
			'ok' => 1,
			'data' => $data,
		);
	}
	
    #################################################################
    
    function twitter_oauth_api_get_call(&$args, &$user_keys){
                            
            $keys = array(
                    'oauth_key' => $GLOBALS['cfg']['twitter_oauth_key'],
                    'oauth_secret' => $GLOBALS['cfg']['twitter_oauth_secret'],
                    'user_key' => $user_keys['oauth_token'],
                    'user_secret' => $user_keys['oauth_secret'],        
            );
            
            $url = $GLOBALS['cfg']['twitter_api_endpoint'] . $args['method'] . '.json';

            $url = oauth_sign_get($keys, $url, $args, 'GET');
            $rsp = http_get($url);
                                            
            return $rsp;
            
    }

	#################################################################

	function twitter_oauth_api_call($method, $args, $more=array()){

		$keys = array(
			'oauth_key' => $GLOBALS['cfg']['twitter_oauth_key'],
			'oauth_secret' => $GLOBALS['cfg']['twitter_oauth_secret'],
		);

		if (isset($more['oauth_token'])){
			$keys['user_key'] = $more['oauth_token'];
			$keys['user_secret'] = $more['oauth_secret'];
		}

		$args['method'] = $method;
		$args['format'] = 'json';
		$args['nojsoncallback'] = 1;

		# Just keep things simple and assume we're always doing POSTs

		$url = oauth_sign_get($keys, $GLOBALS['cfg']['twitter_api_endpoint'], $args, 'POST');
		dumper($url);

		list($url, $postdata) = explode('?', $url, 2);

		$rsp = http_post($url, $postdata);

		if (! $rsp['ok']){
			return $rsp;
		}

		$json = json_decode($rsp['body'], 'as a hash');

		if (! $json){
			return array( 'ok' => 0, 'error' => 'failed to parse response' );
		}

		if ($json['stat'] != 'ok'){
			return array( 'ok' => 0, 'error' => $json['message']);
		}

		unset($json['stat']);
		return array( 'ok' => 1, 'data' => $json );
	}

	#################################################################

	function twitter_oauth_rsp_to_hash($rsp){

		$data = array();

		foreach (explode("&", $rsp) as $bit){
			list($k, $v) = explode('=', $bit, 2);
			$data[urldecode($k)] = urldecode($v);
		}

		return $data;
	}

	#################################################################
?>
