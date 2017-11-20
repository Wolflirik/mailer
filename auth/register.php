<?php

if(isset($_POST['submit'])){
	$errors = array();

	if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
		$error[] = "Login может соберажать только цифры и буквы латинского алфавита!";
	if(strlen($_POST['login']) < 3 || strlen($_POST['login']) > 30)
		$error[] = "Login должен содердать не менее 3-х и не более 30-ти символов!";

	$result = $db->query("SELECT COUNT(id) AS 'count' FROM `user` WHERE `login` = '".$db->esc($_POST['login'])."'");
	if($result->row['count'] > 0)
		$error[] = "Такой пользователь существует!";

	if(count($error) == 0){
		$login = $_POST['login'];
		$password = md5(md5(trim($_POST['password'])));

		if($db->query("INSERT INTO `user` SET `login` = '".$db->esc($login)."', `password` = '".$db->esc($password)."'")){
			exit();
		}else{
			echo "Ошибка добавления нового пользователя";
		}
	}else{
		$text = '<div class="error">';
		$text .= '<ul>';

		foreach($error as $err)
			$text .= '<li>'.$err.'</li>';

		$text .= '</div>';
		echo $text;
	}
}else{
?>

  	<div class="form">
		<div class="form-wrap">
			<h1>Register</h1>
			<form method="post" action="/">
	    		<input type="text" name="login" placeholder="login" value="<?php echo $_POST['login'] ? $_POST['login'] : ''; ?>" required="required" />
	        	<input type="password" name="password" placeholder="password" required="required" />
	        	<button type="submit" class="submit button" name="submit">Submit</button>
	    	</form>
	    </div>
	</div>

<?php } ?>
