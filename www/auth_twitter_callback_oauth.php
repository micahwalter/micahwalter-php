<?php

	include("include/init.php");
	loadlib("twitter_oauth");
	loadlib("twitter_users");
	
	#loadlib("random");

	# Some basic sanity checking like are you logged in?

	login_ensure_loggedin();
	
	# See the notes in signin_oauth.php about cookies and request
	# tokens.

	if (! $GLOBALS['cfg']['crypto_oauth_cookie_secret']){
		$GLOBALS['error']['oauth_missing_secret'] = 1;
		$GLOBALS['smarty']->display("page_auth_callback_twitter_oauth.txt");
		exit();
	}

	# Make sure that we've got the minimum set of parameters
	# we expect Twitter to send back.

	$verifier = get_str('oauth_verifier');
	$token = get_str('oauth_token');

	if ((! $verifier) || (! $token)){
		$GLOBALS['error']['oauth_missing_args'] = 1;
		$GLOBALS['smarty']->display("page_auth_callback_twitter_oauth.txt");
		exit();
	}

	# Now we exchange the request token/secret for a more permanent set
	# of OAuth credentials. In plain old Twitter auth language this is
	# where we exchange the frob (the oauth_verifier) for an auth token.
	# The only difference is that we sign the request using both the app's
	# signing secret and the user's (temporary) request secret.

	$user_keys = array(
		'oauth_token' => $request[0],
		'oauth_secret' => $request[1],
	);

	$args = array(
		'oauth_verifier' => $verifier,
		'oauth_token' => $token,
	);

	$rsp = twitter_oauth_get_access_token($args, $user_keys);

	if (! $rsp['ok']){
		$GLOBALS['error']['oauth_access_token'] = 1;
		$GLOBALS['smarty']->display("page_auth_callback_twitter_oauth.txt");
		exit();
	}

	# Hey look! If we've gotten this far then that means we've been able
	# to use the Twitter API to validate the user and we've got an OAuth
	# key/secret pair.

	$data = $rsp['data'];

	$twitter_id = $data['user_id'];
	$screen_name = $data['screen_name'];

	# The first thing we do is check to see if we already have an account
	# matching that user's Twitter ID.
	
	$twitter_user = twitter_users_get_by_twitter_id($twitter_id);
	
	if ($user_id = $twitter_user['user_id']){
		## all we have to do here is return something about us already connecting this account...
	}

	else { 

		$twitter_user = twitter_users_create_user(array(
			'user_id' => $GLOBALS['cfg']['user']['id'],
			'twitter_id' => $twitter_id,
			'screen_name' => $screen_name,
			'oauth_token' => $data['oauth_token'],
			'oauth_secret' => $data['oauth_token_secret'],
		));

		if (! $twitter_user){
			$GLOBALS['error']['dberr_twitteruser'] = 1;
			$GLOBALS['smarty']->display("page_auth_callback_twitter_oauth.txt");
			exit();
		}
	}

	header("location: {$GLOBALS['cfg']['abs_root_url']}account/");
	exit;
