<?php
include('libs/config.php');
require_once('libs/Http.php');
require_once("libs/Db.php");
require_once("libs/libmail.php");

class Mailer{
	private $http;
	private $db;

	public function __construct($keys){
		$this->db = new Db;
		$this->db->query("UPDATE `user` SET `count_mails` = `count_mails` + 1");
		$this->http = new Http($keys, CLIENT_ID, SENDER_ID);
	}

	private function get_orders(){
		$results = json_decode($this->http->query('getSenderOrders', array(
			'statuses' => 'DELIVERY_LOADED'
		)));
		return $results->data;
	}

	private function get_order($order_id){
		$result = json_decode($this->http->query('getOrderInfo', array(
			'order_id' => $order_id
		)));
		return $result->data;
	}

	private function add_to_db(){
		$results = $this->get_orders();
		if($results){
			for($i=0;$i<20;$i++){
				$query = $this->db->query("SELECT COUNT(order_id) AS 'count' FROM `orders` WHERE `order_id` = '".$this->db->esc($results->orders[$i]->order_id)."'");
				if($query->row['count'] == 0 && isset($results->orders[$i]->order_id)){
					$order = $this->get_order($results->orders[$i]->order_id);
					$this->db->query("INSERT INTO `orders` (`order_id`, `email`, `status`, `delivery_id`, `full_name`, `track`, `date_created`, `user_phone`, `address_string`, `delivery_method`, `first_name`, `text_map`) VALUES (
						'".$this->db->esc($order->id)."', 
						'".$this->db->esc($order->recipient->email)."', 
						'".$this->db->esc($order->status)."', 
						'".$this->db->esc($order->delivery_id)."', 
						'".$this->db->esc($order->recipient->full_name)."', 
						'".$this->db->esc($order->delivery_num)."', 
						'".$this->db->esc($order->created)."', 
						'".$this->db->esc($order->recipient->phone)."', 
						'".$this->db->esc($order->delivery_method == 'PICKUP' || $order->delivery_method == 'POST' ? $order->recipient->pickuppoint->full_address : $order->recipient->full_address)."', 
						'".$this->db->esc($order->delivery_method)."',
						'".$this->db->esc($order->recipient->first_name)."',
						'".$this->db->esc(isset($order->recipient->pickuppoint->address->comment)?$order->recipient->pickuppoint->address->comment:'')."'
					)");
				}
			}
		}
	}

	public function mail_send(){
		$this->add_to_db();
		$results = $this->db->query("SELECT * FROM `orders` WHERE `email_status` = '0'");
		$default = $this->db->query("SELECT * FROM `delivery` WHERE `id` = '0'")->row;
		$smtp = $this->db->query("SELECT `email_server`, `email_login`, `email_password`, `email_port` FROM `user` WHERE `user`.`id` = 1")->row;
		foreach($results->rows as $row){
			$delivery = $this->db->query("SELECT * FROM `delivery` WHERE `id` = '".$row['delivery_id']."'")->row;
			$replacements = array(
				$delivery['name']=='default'?'':$delivery['name'],
				$row['track'],
				$row['full_name'],
				$row['user_phone'],
				$row['address_string'],
				$row['first_name'],
				$row['text_map'],
				'<div style="color:#000;"',
				'<p style="color:#000;"'
			);
			$search = array(
			    '%delivery_name%',
			    '%track%',
			    '%full_name%',
			    '%user_phone%',
			    '%address_string%',
			    '%first_name%',
				'%text_map%',
				'<div',
				'<p'
			);
			if($row['delivery_method'] != 'TODOOR')
				$body = str_replace($search, $replacements, $default['text'].$delivery['text'].$default['text_courier']);
			else
				$body = str_replace($search, $replacements, $default['text'].$delivery['text_courier'].$default['text_courier']);
			if(isset($row['email']) && $row['email'] == 'kiryawolfgo@gmail.com'){
				$mail = new Mail;
				$mail->From($smtp['email_login']);
				$mail->To($row['email']);
				$mail->Subject('Посылка отправлена!');
				$mail->body($body, "html");
				$mail->Priority(1);
				$mail->smtp_on($smtp['email_server'], $smtp['email_login'], $smtp['email_password'], (int)$smtp['email_port']);
				$mail->Send();
				$this->db->query("UPDATE `orders` SET `email_status` = '1' WHERE `orders`.`id` = '".$row['id']."'");
			}
		}
	}
}
$mailer = new Mailer($KEYS);
$mailer->mail_send();