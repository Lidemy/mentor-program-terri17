<?php
	//登出
	
	setcookie('username','',time()-3600);
	setcookie('password','',time()-3600);	
	
	session_start();
	session_unset();
	session_destroy();
	
	//頁面重新導向
	header('Location:login.php');
?>