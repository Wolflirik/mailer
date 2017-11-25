<?php 
if(isset($_SESSION['user'])){ 
	$query = $db->query("SELECT * FROM `delivery`");
	$results = $query->rows;
	$query = $db->query("SELECT `email_server`, `email_login`, `email_password`, `email_port` FROM `user` WHERE `user`.`password` = '".$db->esc($_SESSION['user']['password'])."'");
	$smtp = $query->row;
?>
<header class="header">
	<div class="container">
		<span class="user">Вы вошли как: <?php echo $_SESSION['user']['login']; ?></span>
		<a href="/exit.php" class="right exit button">Выход</a>
		<button class="button right check">Проверка служб доставки</button>
		<button class="button right check-up">Тест</button>
		<button class="button right check-vars">Переменные</button>
	</div>
</header>
<div class="container">
	<div class="phanel">
		<div class="group smtp">
			<input class="server" placeholder="ssl://smtp.gmail.com" value="<?php echo $smtp['email_server']; ?>">
			<input class="login" placeholder="your email" value="<?php echo $smtp['email_login']; ?>">
			<input class="password" placeholder="email password" value="<?php echo $smtp['email_password']; ?>">
			<input class="port" placeholder="465" value="<?php echo $smtp['email_port']; ?>">
			<button class="button set-smtp">Установить</button>
		</div>
		<?php foreach($results as $r){ ?>
		<?php if($r['id'] == 0){?>
		<div class="group lock">
			<h3 class="heading-title"><?php echo $r['name']; ?><button class="button unlock" style="float:right;background-color:#c3c3c3;margin-left:10px;">Разблокировать</button><button class="button set" id="<?php echo $r['id']; ?>">Установить шаблон</button></h3>
			<div class="text-box">
				<label>Шапка</label>
				<textarea class="text" rows="8" disabled="disabled"><?php echo $r['text']; ?></textarea>
			</div>
			<div class="text-box">
				<label>Подвал</label>
				<textarea class="text_courier" rows="8" disabled="disabled"><?php echo $r['text_courier']; ?></textarea>
			</div>
		</div>
		<?php }else{ ?>
		<div class="group">
			<h3 class="heading-title"><?php echo $r['name']; ?><button class="button set" id="<?php echo $r['id']; ?>">Установить шаблон</button></h3>
			<div class="text-box">
				<label>Письмо с пунктом выдачи</label>
				<div class="text" contenteditable="true"><?php echo $r['text']; ?></div>
			</div>
			<div class="text-box">
				<label>Письмо с курьерской доставкой</label>
				<div class="text_courier" contenteditable="true"><?php echo $r['text_courier']; ?></div>
			</div>
		</div>
		<?php } ?>
		<?php } ?>
	</div>
</div>
<div class="popap-vars">
	<button class="close">+</button>
	<div class="popap-body">
		<?php foreach($vars as $var){?>
		<div class="row">
			<span class="name"><?php echo $var['name']?></span>
			<span class="desc"><?php echo $var['desc']?></span>
		</div>
		<?php } ?>
	</div>
</div>
<script><!--
$('document').ready(function(){
	$('.set').on('click', function(){
		var id = $(this).attr('id'),
			ts = $(this).parent().parent(),
			text = ts.find('.text').val()?ts.find('.text').val():ts.find('.text').html(),
			textCourier = ts.find('.text_courier').val()?ts.find('.text_courier').val():ts.find('.text_courier').html();

		$.ajax({
			url: "/ajax.php",
			type: 'post',
			dataType: 'json',
			data: 'id='+encodeURIComponent(id)+'&text='+encodeURIComponent(text)+'&text_courier='+encodeURIComponent(textCourier)+'&action=set_delivery_text&hash=<?php echo $_SESSION['user']['password']; ?>',
		  	success: function(data){
		    	if(data){
		    		ts.addClass('ok');
		    	}else{
		    		ts.addClass('error');
		    	}
		    	setTimeout(function(){ts.hasClass('ok')?ts.removeClass('ok'):ts.removeClass('error')},600);
		  	}
		});
	});

	$('.set-smtp').on('click', function(){
		var ts = $(this).parent(),
			server = ts.find('.server').val(),
			login = ts.find('.login').val(),
			password = ts.find('.password').val(),
			port = ts.find('.port').val();

		$.ajax({
			url: "/ajax.php",
			type: 'post',
			dataType: 'json',
			data: 'server='+encodeURIComponent(server)+'&login='+encodeURIComponent(login)+'&password='+encodeURIComponent(password)+'&port='+encodeURIComponent(port)+'&action=set_smtp&hash=<?php echo $_SESSION['user']['password']; ?>',
		  	success: function(data){
		    	if(data){
		    		ts.addClass('ok');
		    	}else{
		    		ts.addClass('error');
		    	}
		    	setTimeout(function(){ts.hasClass('ok')?ts.removeClass('ok'):ts.removeClass('error')},600);
		  	}
		});
	});

	$('.check').on('click', function(){
		$.ajax({
			url: "/ajax.php",
			type: 'post',
			dataType: 'json',
			data: 'action=get_delivery&hash=<?php echo $_SESSION['user']['password']; ?>',
		  	success: function(data){
		    	if(data){
		    		location.reload();
		    	}else{
		    		alert("error");
		    	}
		  	}
		});
	});

	$('.check-up').on('click', function(){
		$.ajax({
			url: "/ajax.php",
			type: 'post',
			dataType: 'json',
			data: 'action=get_user_id&hash=<?php echo $_SESSION['user']['password']; ?>',
		  	success: function(data){
		    	if(data){
		    		//location.reload();
		    	}else{
		    		alert("error");
		    	}
		  	}
		});
	});
});    
--></script>
<?php 
}else{header("Location: /");} ?>