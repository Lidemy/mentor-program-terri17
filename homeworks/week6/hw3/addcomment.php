<?php 
/*發布留言 add_comments.php
利用表單 POST，讀取 content, nickname 跟 parent_id
可以利用 <input type=’hidden’ /> 帶 parent_id
新增到資料庫，導回 index.php*/

		require_once('dbc.php');
		$parent_id=$_POST['parent_id'];
		$nickname=$_POST['nickname'];
		$comment=$_POST['comment'];
		
		$sql="INSERT INTO terri_message (`parent_id`, `nickname`, `content`, `created_at`) VALUES ('".$parent_id."','".$nickname."','".$comment."',now())";
		mysqli_query($dbc,$sql) or die ("無法加入留言");
		
		mysqli_close($dbc);
		//echo "已經成功新增留言";
		header('Location:board.php');
?>