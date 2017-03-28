<?php

class GoingupApi {

	protected $appId;
	protected $secret;
	protected $callback_uri;
	protected $token;


	protected $ch;

	public $version = '1';

	public $apiBaseUrl = 'https://api.goingup.didin';
	const EP_AUTHORIZE = '/auth/authorize';
	const EP_TOKEN     = '/auth/token';

	const EP_API_EMAIL_EXISTS = '/user/{email}/exist';

	public function __construct($appId, $secret)
	{
		$this->appId = $appId;
		$this->secret = $secret;
		
	}

	public function setToken($token)
	{
		$this->token = $token;
	}

	public function getToken($authCode, $state)
	{
		$endPoint = $this->apiBaseUrl . self::EP_TOKEN;
		
		return $this->request($endPoint, array(
			'grant_type' => 'authorization_code',
			'code' => $authCode,
			'state' => $state
		), 'POST');
	}

	public function refreshToken($refreshToken, $state)
	{
		$endPoint = $this->apiBaseUrl . self::EP_TOKEN;
		return $this->request($endPoint, array(
			'grant_type' => 'refresh_token',
			'refresh_token' => $refreshToken,
			'state' => $state
		), 'POST');
	}




	public function getLoginUrl($responseType, $state = null, $scope = null, $authorized = false, $user_id = null, $callback_uri = null)
	{
		$endPoint = $this->apiBaseUrl . self::EP_AUTHORIZE;
		$endPoint.= '?';
		$endPoint.= http_build_query(array_filter(array(
			'response_type' => $responseType,
			'client_id' => $this->appId,
			'state' => $state,
			'scope' => $scope,
			'authorized' => $authorized,
			'user_id' => $user_id,
			'redirect_uri' => $callback_uri
		)), '', '&');
		return $endPoint;
	}

	public function checkEmailExists($email)
	{
		$endPoint = $this->apiBaseUrl . '/v'.$this->version . self::EP_API_EMAIL_EXISTS;
		$endPoint = str_replace('{email}', $email, $endPoint);

		return $this->request($endPoint, array(
			'access_token' => $this->token
		));
	}


	public function post($url, $params = array())
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_URL, $url);
		$headers =  [];

		//foreach ($params as $k => $v)
			// /$headers[] = $k . ': ' . $v;

		$headers[] = 'client_id: '. $this->appId;
		$headers[] = 'client_secret: '. $this->secret;
		//$headers[] = 'Content-type: application/x-www-form-urlencoded';
		// /$headers['client_id'] = $this->appId;
		// $headers['client_secret'] = $this->secret;
		//$headers['Content-type'] = 'application/x-www-form-urlencoded';
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($params));	
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);	
		// if ($_SERVER['REQUEST_SCHEME']=='https') {
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);	
		// }
		curl_setopt($this->ch, CURLOPT_POST, 1);		
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
		// curl_setopt($this->ch, CURLOPT_USERPWD, $this->appId.":".$this->secret);
		// curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		$result = curl_exec($this->ch);
		
		if (false==$result) {
			$result = curl_error($this->ch);
			var_dump($result);
		}
		curl_close($this->ch);
		return $result;
	}


	public function request($url, $params = array(), $method = 'GET')
	{
		$this->ch = curl_init();
		switch ($method) {
			case 'POST':
				curl_setopt($this->ch, CURLOPT_POST, 1);
				break;
			default:
				curl_setopt($this->ch, CURLOPT_HTTPGET, 1);				
				break;
		}		
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);

		if (count($params)>0) {
			$query = http_build_query($params, '', '&');
			if ($method == 'POST') {
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, $query);
				curl_setopt($this->ch, CURLOPT_USERPWD, $this->appId.":".$this->secret);
				curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				  $headers[] = 'Accept: application/json';
				  if(isset($params['access_token']))
				    $headers[] = 'Authorization: Bearer ' . $params['access_token'];
				  curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);				
			} elseif ($method == 'GET') {
				$url .= '?' . http_build_query($params, '', '&');
			}
		}

		// if ($_SERVER['REQUEST_SCHEME']=='https') {
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		// }

		curl_setopt($this->ch, CURLOPT_URL, $url); 	
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec($this->ch);
		
		if (false==$result) {
			$result = "ERROR : ".curl_error($this->ch);
		}
		curl_close($this->ch);
		return $result;
	}


}