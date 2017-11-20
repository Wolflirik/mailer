<?php

class Db{
	private $_connect;

	public function __construct(){
		$this->_connect = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if($this->_connect->connect_errno){
			die('Error #'.$this->_connect->connect_errno.' MySQL connect error: '.$this->_connect->connect_error);
		}
		$this->_connect->set_charset('utf8');
	}

	public function query($sql){
		$query = $this->_connect->query($sql);

		if(!$this->_connect->errno){
			if($query instanceof \mysqli_result){
				$data = array();

				while($row = $query->fetch_assoc()){
					$data[] = $row;
				}
				$result = new \stdClass();
				$result->num_rows = $query->num_rows;
				$result->row = isset($data[0]) ? $data[0] : array();
				$result->rows = $data;

				$query->close();

				return $result;
			}else{
				return true;
			}
		}else{
			die('Error #'.$this->_connect->connect_errno.' MySQL connect error: '.$this->_connect->connect_error);
		}
	}

	public function esc($str){
		return $this->_connect->real_escape_string($str);
	}

	public function connected() {
		return $this->_connect->ping();
	}

	public function __destruct(){
		$this->_connect->close();
	}
}