<?php
require_once('GoingupApi.php');
require_once('config.php');


	$accessToken = $_REQUEST['access_token'] ? $_REQUEST['access_token'] : null;
	$refreshToken = $_REQUEST['refresh_token'] ? $_REQUEST['refresh_token'] : null;
	$state = $_REQUEST['state'] ? $_REQUEST['state'] : null;

	// $endpoint = $api->apiBaseUrl.'/v1/affilify/affiliates/create';
	// $endpoint = $api->apiBaseUrl . '/v1/affiliates';
	$endpoint = $api->apiBaseUrl . '/v1/affiliates';
	// $resutl = $api->request(
	// 	$endpoint,
	// 	array(
	// 		'access_token' => $accessToken
	// 	),
	// 	'POST'
	// );

	$postresult = $api->post($endpoint, array(
		'access_token' => $accessToken
	));

	


	echo '<code>';
	echo "<h3>CURL COMMAND POST</h3>";
	echo 'curl -u '.$client_id.':'.$client_secret . ' ' . $endpoint . ' -d \'access_token='.$accessToken.'\'';
	echo '</code>';
	echo '<pre>';
	
	echo '<hr />';
	echo '<h3>API RESULT IN JSON FORMAT POST REQUEST</h3>';
	echo '<code>';
	print_r($postresult);
	echo '</code>';
	echo '<hr />';

	$getresult = $api->request($endpoint, array(
		'access_token' => $accessToken
	));

	echo '<h3>API RESULT IN JSON FORMAT GET REQUEST</h3>';
	echo '<h3>List affiliates</h3>';
	echo '<code>';
	print_r($getresult);
	echo '</code>';
	echo '<hr />';

	echo '<a href="affilify_post_with_refresh_token.php?refresh=true&refreshToken='.$refreshToken.'&state='. $state .'">Request by refresh token</a>';

	echo '<br />';

	echo '<a href="affilify.php">Back</a>';