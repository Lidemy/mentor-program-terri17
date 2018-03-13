<?php

	//登出
	//if(isset($cookie['username'])){
		setcookie('username','',time()-3600);
		setcookie('password','',time()-3600);	
		echo "已經順利登出";
	//}
	//頁面重新導向
	
	header('Location:login.php');

?>