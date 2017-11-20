<?php
require_once('libs/config.php');
require_once('libs/Http.php');
require_once('libs/Db.php');
class Ajax{
	private $db;
	private $http;

	public function __construct($hash, $keys){
		$this->db = new Db;
		if($this->db->query("SELECT `password` FROM `user` WHERE `user`.`password` ='".$this->db->esc($hash)."'")->row['password'] != $hash){
			return false;
			exit();
		}
		$this->http = new Http($keys, CLIENT_ID, SENDER_ID);
	}

	public function set_delivery_text(){
		$query = $this->db->query("UPDATE `delivery` SET `text` = '".$this->db->esc($_REQUEST['text'])."', `text_courier` = '".$this->db->esc($_REQUEST['text_courier'])."' WHERE `delivery`.`id` =".$this->db->esc($_REQUEST['id']));
		echo json_encode($query);
	}

	public function set_smtp(){
		$query = $this->db->query("UPDATE `user` SET `email_server` = '".$this->db->esc($_REQUEST['server'])."', `email_login` = '".$this->db->esc($_REQUEST['login'])."', `email_password` = '".$this->db->esc($_REQUEST['password'])."', `email_port` = '".$this->db->esc($_REQUEST['port'])."' WHERE `user`.`password` = '".$this->db->esc($_REQUEST['hash'])."'");
		echo json_encode($query);
	}

	public function get_delivery(){
		$results = json_decode($this->http->query('getDeliveries', array(
			'type' => 'delivery'
		)));
		if($results->status == 'error'){
			echo false;
			die();
		}
		foreach($results->data->deliveries as $delivery){
			if($this->db->query("SELECT COUNT(id) AS 'count' FROM `delivery` WHERE `id` = '".$this->db->esc($delivery->id)."'")->row['count'] == 0)
				print_r($this->db->query("INSERT INTO `delivery` (`id`, `name`, `unique_name`, `text`, `text_courier`, `time`) VALUES (
					'".$this->db->esc($delivery->id)."', 
					'".$this->db->esc(mb_substr($delivery->name, 2))."', 
					'".$this->db->esc($delivery->unique_name)."', 
					'', 
					'', 
					NOW())"));
			else
				print_r($this->db->query("UPDATE `delivery` SET `time` = NOW(), `unique_name` = '".$this->db->esc($delivery->unique_name)."', `name` = '".$this->db->esc(mb_substr($delivery->name, 2))."' WHERE `delivery`.`id` = '".$this->db->esc($delivery->id)."'"));
		}
		$result = $this->db->query("SELECT `time` FROM `delivery` WHERE `delivery`.`id` = ".$this->db->esc($results->data->deliveries[0]->id));
		$this->db->query("DELETE FROM `delivery` WHERE `delivery`.`time` < '".$result->row['time']."' AND `unique_name` != 'default'");
		echo true;
	}

	public function get_user_id(){
		require_once("mailer.php");
	}
}
//echo 'ok ';
if(!empty($_REQUEST)){
	//echo 'before Ajax init ';
	$ajax = new Ajax($_REQUEST['hash'], $KEYS);
	//echo 'after Ajax init ';
	if($ajax != false){
		//echo 'ok ajax true ';
		if(method_exists($ajax, $_REQUEST['action'])){
			$func = (string)$_REQUEST['action'];
			//echo 'method exists'. $func;
			$ajax->$func();
		}
	}else{
		echo 'error access';
	}
	die();
}

?>
