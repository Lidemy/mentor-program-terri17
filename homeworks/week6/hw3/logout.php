<?php
	//登出
	
	setcookie('id','',time()-3600);
	
	//頁面重新導向
	header('Location:login.php');
?>