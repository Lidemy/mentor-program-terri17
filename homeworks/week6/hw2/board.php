<?php
	session_start();	//務必在開頭就使用
?>
<!doctype html>
<html>
	<head>
		<meta charset='utf-8'/>
		<title>留言板</title>
		<link rel=stylesheet type="text/css" href="style.css">
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
		<div class=log>
			<div>您登入的帳號為：<?php echo $_SESSION["username"]; ?></div>
			<div><a href="logout.php">登出</a></div>
		</div>
		
	<!--找暱稱-->
<?php   
	require_once('dbc.php');
	
	$nic = "SELECT * FROM terri_week5hw3 where username=".$_SESSION["username"];  
	$find = mysqli_query($dbc,$nic); 	
	$find_nic=mysqli_fetch_assoc($find); 	//取得結果
?>		
		
		<!--主留言-->
		<div class=newMessage>
			<form method="POST" action=addcomment.php>
				<p>暱稱：<?php echo $find_nic["nickname"] ?></p>
				<input type="hidden" class=nickname name=nickname value="<?php echo $find_nic["nickname"] ?>">
				<input type="textarea" class=comment name=comment placeholder="請輸入留言"></br>
				<input type="hidden" class=parent_id name=parent_id  value="0"/>
				<input type="submit" value="新增留言">
			</form>
		</div>

		<div class=listen>

		<!--印出舊的主留言-->
<?php   

	$sql = "SELECT * FROM terri_week5hw2 where parent_id=0 ORDER BY id DESC";  
	$result = mysqli_query($dbc,$sql) or die('抓不到主留言資料');	
	  
	if (mysqli_num_rows($result) > 0) { 			//取得總數
		while ($row=mysqli_fetch_assoc($result)) { 	//取得結果
?>		
				<div class=oldMessage>
					<div class=oldMessage_nickname><?php echo $row["nickname"]?></div>
					<div class=oldMessage_created_at><?php echo $row["created_at"]?></div>
					<div class=oldMessage_content><?php echo $row["content"]?></div>

<?php		if ($_SESSION['username']===$row["nickname"]){					
?>					<div class=edit_comment>
						<input type="submit" class=edit_comment_input value="修改留言"/>
						<form method="POST" action=edit_comment.php>
							<textarea name=edit_comment_content><?php echo $row["content"]?></textarea>
							<input type="hidden" name=edit_comment_id value="<?php echo $row["id"]?>">
							<input type="submit" value="送出">
						</form>
					</div>
					<form method="POST" action=delete_comment.php>
						<input type="submit" value="刪除留言"/>					
						<input type="hidden" name=id value="<?php echo $row["id"]; ?>"/>
					</form>
<?php		}
?>			

				</div>

			<!--印出舊的子留言-->
<?php		
			$sql_child ="SELECT * FROM terri_week5hw2 where parent_id =".$row["id"] ;  // ."ORDER BY id" 順序!!!
			$result_child = mysqli_query($dbc,$sql_child) or die ('抓不到子留言資料');	
			
			if (mysqli_num_rows($result_child) > 0){ 					//取得總數
				while ($row_child=mysqli_fetch_assoc($result_child)){	//取得結果			
?>			
					<div class=repliedOldMessage
<?php		if($row["nickname"]===$row_child["nickname"]){?>	
				style="background-color:pink"
<?php		}?>				
												>
						<div class=oldMessage_nickname><?php echo $row_child["nickname"]?></div>
						<div class=oldMessage_created_at><?php echo $row_child["created_at"]?></div>
						<div class=oldMessage_content><?php echo $row_child["content"]?></div>

<?php
			if ($_SESSION['username']===$row_child["nickname"]){
?>						<input type="submit" class=edit_comment value="修改留言"/>
							<form method="POST" action=edit_comment.php>
								<textarea name=edit_comment_content><?php echo $row_child["content"]?></textarea>
								<input type="hidden" name=edit_comment_id value="<?php echo $row_child["id"]?>">
								<input type="submit" value="送出">
							</form>
						
						<form method="POST" action=delete_comment.php>
							<input type="submit" value="刪除留言"/>
							<input type="hidden" name=id value="<?php echo $row_child["id"]; ?>"/>
						</form>
<?php			}
?>			
						
					</div>
<?php
				}
			}				
?>
				<!--新增子留言-->
				<div class=replyOldMessage>
					<div type="button" class=replyOldMessage_new>新增留言▶</div>
					<form class=replyOldMessage_form method="POST" action=addcomment.php>
						<p>暱稱：<?php echo $find_nic["nickname"] ?></p>
						<input type="hidden" class=nickname name=nickname value="<?php echo $find_nic["nickname"] ?>"/>
						<input type="textarea" class=comment name=comment placeholder="請輸入留言"></br>
						<input type="hidden" class=parent_id name=parent_id  value="<?php echo $row["id"]; ?>"/>
						<input type="submit" value="新增子留言"/>
					</form>
					</div>	


<?php

		}
	}
	mysqli_close($dbc);
?>



		</div>
	</body>
</html>