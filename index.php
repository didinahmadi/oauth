<?php

require_once('GoingupApi.php');

$params = 'response_type=code&client_id=08wbdENU&state=xyz&authorized=yes&scope=eticket&user_id=2';

$api = new GoingupApi('08wbdENU', '538fd4fe4b9c11f644a3db9325f419a1fb14d3b4');

?>
<a href="<?php echo $api->getLoginUrl('code', 'abc', 'eticket', 'yes', 2, 'https://client.oauth.didin/?callback'); ?>">Login Here</a>
<hr />
<pre>
<?php 
$authCode = isset($_REQUEST['code']) ? $_REQUEST['code'] : null;

if ($authCode) {
	$response = $api->getToken($authCode, $_REQUEST['state']);
	$r = json_decode($response);	
	$accessToken = $r->access_token;
	
	$result = $api->request('https://api.goingup.didin/v1/user/didinonpqcms@gmail.com', array(
		'access_token' => $accessToken
	));
	echo $result;
	echo '<hr />';
	$result = $api->request('https://api.goingup.didin/v1/user/didinonpqcms@gmail2.com', array(
		'access_token' => $accessToken
	));
	echo $result;
} else {
	$result = $api->request('https://api.goingup.didin/v1/user/didinonpqcms@gmail.com', array(
		'access_token' => '1234'
	));

	echo $result;
}


?>