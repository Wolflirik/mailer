<?php

class Http{
	private $curl;
	private $http = 'https://delivery.yandex.ru/api/last/';
	private $clientId;
	private $senderId;
	private $secretKey;
	private $keys;
	private $response;

	public function __construct($keys, $client_id, $sender_id){
		if(!$this->curl = curl_init()){
			die("error http");
		}
		$this->keys = $keys;
		$this->clientId = $client_id;
		$this->senderId = $sender_id;
	}

	public function query($method, $params){
		if(!empty($keys[$method])) die('method error');
		else $key = $this->keys[$method];
		
		$paramsHash = $params;
		$paramsHash['client_id'] = $this->clientId;
		$paramsHash['sender_id'] = $this->senderId;
		$post_values = new PostValues;
		$hash = md5($post_values->getPostValues($paramsHash) . $key);
		$this->secretKey = $hash;
		return $this->request($this->http.$method, $params);
	}

	private function request($url, $params){
		$request = '';
		foreach($params as $key => $val)
			$request .= '&'.$key.'='.$val;
		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($this->curl, CURLOPT_HEADER, false);
	    curl_setopt($this->curl, CURLOPT_POST, true);
	    curl_setopt($this->curl, CURLOPT_POSTFIELDS, 'secret_key='.$this->secretKey.'&client_id='.$this->clientId.'&sender_id='.$this->senderId.$request);
	    return curl_exec($this->curl);
	}

	public function __destruct(){
		curl_close($this->curl);
	}
}

class PostValues{
	public function getPostValues($data){    
		if (!is_array($data)) return $data;    
		ksort($data);    
		return join('', array_map(function($k){
			$post_values = new PostValues;
			return $post_values->getPostValues($k);
		}, $data));
	}
}