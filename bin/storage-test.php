<?php

	$root = dirname(dirname(__FILE__));
	ini_set("include_path", "{$root}/www:{$root}/www/include");

	set_time_limit(0);

	include("include/init.php");

	loadlib("cli");
	loadlib("http");

	loadlib("storage");
	loadlib("storage_utils");
	loadlib("storage_s3");
	
	storage_s3_init();
	
	$bytes = storage_utils_path_to_bytes('test.jpg');
	
	$more = array(
				'http_timeout' => 30
	);

	$rsp = storage_put_file('tmp/test.jpg', $bytes, $more);
	
	var_dump($rsp);
	

	echo "done\n";
	exit();

?>