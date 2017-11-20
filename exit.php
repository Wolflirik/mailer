<?php 
ob_start();
ini_set("session.use_cookies", 1);
session_start();
if(isset($_SESSION['user'])){
	unset($_SESSION['user']); 
	header("Location: /");
}
ob_end_flush();
?>