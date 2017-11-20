<?php
$signup = array(
	'error' => 0,
	'signup' => 0
);
if(isset($_POST['submit'])){

	$login = $_POST['login'];
	$password = md5(md5(trim($_POST['password'])));
	$user = $db->query("SELECT * FROM `user` WHERE `login` = '".$db->esc($_POST['login'])."' AND `password` = '".$password."'");
	if($user->row){
		$_SESSION['user'] = array('login' => $user->row['login'], 'password' => $user->row['password']);
		header("Location: /");
		//print_r($_SESSION['user']);
		
	}else{
		$signup['error'] = 1;
		$signup['signup'] = 0;
	}
}
if($signup['signup'] == 0){
?>
	<div class="form">
		<div class="form-wrap <?php echo $signup['error'] == 1 ? 'error' : ''?>">
			<h1>Login</h1>
			<form method="post" action="/">
	    		<input type="text" name="login" placeholder="login" value="<?php echo $_POST['login'] ? $_POST['login'] : ''; ?>" required="required" />
	        	<input type="password" name="password" placeholder="password" required="required" />
	        	<button type="submit" class="submit button" name="submit">Submit</button>
	    	</form>
	    </div>
	</div>
<?php } ?>