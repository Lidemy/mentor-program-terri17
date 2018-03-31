<?php
	// 連接到數據庫 

	$dbc=mysqli_connect($servename,$username, $password, $detabasename) or die('無法連接到MySQL!');	
	
	mysqli_set_charset($dbc, "utf8");
?>