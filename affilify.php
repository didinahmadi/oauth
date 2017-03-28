<?php 

require_once('GoingupApi.php');
require_once('config.php');


?>

<a href="<?php echo $api->getLoginUrl('code', 'cde', 'eticket', 'yes', '2', 'http://oauth.didin.click/affilify.php'); ?>">Login</a>

<?php 
$authCode = isset($_REQUEST['code']) ? $_REQUEST['code'] : null;
$refreshToken = isset($_REQUEST['refreshToken']) ? $_REQUEST['refreshToken'] : null;
$state = isset($_REQUEST['state']) ? $_REQUEST['state'] : null;
if ($authCode) {
?>

<h1>API REQUEST RESULT</h1>

<?php 

	$response = $api->getToken($authCode, $_REQUEST['state']);


	$r = json_decode($response);

	if (!isset($r->access_token)){
		var_dump($response);		
		die("error");
	} else {
		echo '<pre>';
		print_r($r);
		echo '</pre>';
		echo "I have an access token : ". $r->access_token . "<br />";
		echo '<a href="affilify_post_request.php?access_token='.$r->access_token.'&refresh_token='.$r->refresh_token.'&state='.$state.'">Make request</a>';
		die;
	}	




?>
<?php } ?>
