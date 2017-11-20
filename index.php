<?php
ob_start();
ini_set("session.use_cookies", 1);
session_start();
//var_dump(extension_loaded('templates'));
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>mailer</title>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
  <link rel="stylesheet" href="style/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="js/main.js"></script>
</head>
<body class="body">
<?php
require_once('libs/config.php');
require_once('libs/Db.php');
$db = new Db;
if(file_exists("auth/register.php") && $db->query("SELECT COUNT(*) AS 'count' FROM `user`")->row['count'] == 1){
	require_once('auth/register.php');
}else{
	if(isset($_SESSION['user'])){
		require_once('auth/panel.php');
	}else{
		require_once('auth/login.php');
	}
}
?>
</body>
</html>
<?php ob_end_flush(); ?>

