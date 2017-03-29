<?php	
	error_reporting(E_ALL);

	$client_id     = '56vszWAF';
	$client_secret = 'd08e1ff3d6d3ff345021c2d603dcbd82f374c842';
	// $client_id = 'testclient';
	// $client_secret = 'testpass';

	$api = new GoingupApi($client_id,$client_secret);

	if ($_SERVER['SERVER_NAME'] == 'client.oauth.didin') {
		$api->apiBaseUrl = 'https://affilify.didin/api';
	} else {
		$api->apiBaseUrl = 'https://affilify.net/api';				
	}
	

?>