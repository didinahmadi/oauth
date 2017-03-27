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

	$resutl = $api->post($endpoint, array(
		'access_token' => $accessToken
	));


	echo '<code>';
	echo 'curl -u '.$client_id.':'.$client_secret . ' ' . $endpoint . ' -d \'access_token='.$accessToken.'\'';
	echo '</code>';
	echo '<pre>';
	echo 'ENDPOINT => ';
	echo print_r($endpoint);
	echo '<hr />';
	var_dump($resutl);
	echo '<hr />';

	echo '<a href="affilify_post_with_refresh_token.php?refresh=true&refreshToken='.$refreshToken.'&state='. $state .'">Request by refresh token</a>';

	echo '<br />';

	echo '<a href="affilify.php">Back</a>';