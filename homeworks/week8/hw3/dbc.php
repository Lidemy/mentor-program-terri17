<?php
	// 連接到數據庫 
	$servename="localhost";
	$username="root";
	$password="root";
	$detabasename="mentor_program_db";

	$dbc=mysqli_connect($servename,$username, $password, $detabasename) or die('無法連接到MySQL!');	
	
	mysqli_set_charset($dbc, "utf8");
?>