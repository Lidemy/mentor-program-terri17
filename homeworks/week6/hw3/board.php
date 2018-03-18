<?php
	require_once('dbc.php');
	
	// 如果有cookie 
	if(isset($_COOKIE['id'])){	
		// cookie正確性
		// 通行證表格和會員資料表格拼接，取得username與nickname，由於id有重複，因此改通行證id的名
		$cookie_passid ="SELECT terri_week6hw3.id as pass_id, terri_week6hw3.username, terri_week5hw3.* ";
		$cookie_passid.="FROM terri_week5hw3 LEFT JOIN terri_week6hw3 ";
		$cookie_passid.="ON terri_week6hw3.username = terri_week5hw3.username";
		$cookie_result = mysqli_query($dbc,$cookie_passid);
		$cookie_row = mysqli_fetch_assoc($cookie_result);
		
		if ($cookie_row['pass_id'] === $_COOKIE['id']) {
		
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
			<div>您登入的帳號為：<?php echo $cookie_row['username']; ?></div>
			<div><a href="logout.php">登出</a></div>
		</div>
		
		<!--找暱稱-->
<?php   
			$nic = "SELECT * FROM terri_week5hw3 where username=".$cookie_row["username"];  
			$find = mysqli_query($dbc,$nic); 	
			$find_nic=mysqli_fetch_assoc($find); 	//取得結果
?>		
		
		<!--主留言-->
		<div class=newMessage>
			<form method="POST" action=addcomment.php>
				<p>暱稱：<?php echo htmlspecialchars($find_nic["nickname"], ENT_QUOTES, 'utf-8') ?></p>
				<input type="hidden" class=nickname name=nickname value="<?php echo htmlspecialchars($find_nic["nickname"], ENT_QUOTES, 'utf-8'); ?>">
				<textarea class=comment name=comment placeholder="請輸入留言"></textarea></br>
				<input type="hidden" class=parent_id name=parent_id  value="0"/>
				<input type="submit" class=button value="新增留言">
			</form>
		</div>

		<div class=listen>

		<!--印出舊的主留言-->
<?php   
			// 看主流言總數，計算頁數
			$sql_num = "SELECT * FROM terri_week5hw2 where parent_id=0 ORDER BY id DESC";  
			$result_num=$dbc->query($sql_num);
			$num = mysqli_num_rows($result_num);
			
			//查詢目前的頁數
			//如果沒有設GET，頁數為1
			if(!isset($_GET['page'])){
				$_GET['page']=1;
			}
			
			$page = $_GET['page'];
			$page10=$page*10-9;	
			
			$stmt= $dbc->prepare("SELECT * FROM terri_week5hw2 where parent_id=0 ORDER BY id DESC LIMIT 10 OFFSET ?");
			$stmt->bind_param('i',$page10);
			$stmt->execute();
			$result=$stmt->get_result();

			if (mysqli_num_rows($result) > 0) { 			//取得總數
				while ($row=mysqli_fetch_assoc($result)) { 	//取得結果
?>		
				<div class=oldMessage>
					<div class=oldMessage_nickname><?php echo $row["nickname"]?></div>
					<div class=oldMessage_created_at><?php echo $row["created_at"]?></div>
					<div class=oldMessage_content><?php echo $row["content"]?></div>

<?php				if ($cookie_row['username']===$row["nickname"]){					
?>					
					<div class=delete_comment>	
						<form method="POST" action=delete_comment.php>
							<input type="submit" class=button value="刪除留言"/>					
							<input type="hidden" name=id value="<?php echo $row["id"]; ?>"/>
						</form>
					</div>	

					<div class=edit_comment>
						<div type="button" class=edit_comment_input>修改留言▶</div>
						<form method="POST" action=edit_comment.php>
							<textarea name=edit_comment_content><?php echo $row["content"]?></textarea>
							<input type="hidden" name=edit_comment_id value="<?php echo $row["id"]?>"></br>
							<input type="submit" class=button value="送出">
						</form>
					</div>
					
<?php				}
?>			

				

			<!--印出舊的子留言-->
<?php		
					$sql_child ="SELECT * FROM terri_week5hw2 where parent_id =".$row["id"] ;  // ."ORDER BY id" 順序!!!
					$result_child = mysqli_query($dbc,$sql_child) or die ('抓不到子留言資料');	
			
					if (mysqli_num_rows($result_child) > 0){ 					//取得總數
						while ($row_child=mysqli_fetch_assoc($result_child)){	//取得結果			
?>			
					<div class=repliedOldMessage
<?php						if($row["nickname"]===$row_child["nickname"]){?>	
								style="background-color:pink"
<?php						}?>				
												>
						<div class=oldMessage_nickname><?php echo $row_child["nickname"]?></div>
						<div class=oldMessage_created_at><?php echo $row_child["created_at"]?></div>
						<div class=oldMessage_content><?php echo $row_child["content"]?></div>

<?php
							if ($cookie_row['username']===$row_child["nickname"]){
?>	
								<div class=delete_comment>	
									<form method="POST" action=delete_comment.php>
										<input type="submit" class=button value="刪除留言"/>
										<input type="hidden" name=id value="<?php echo $row_child["id"]; ?>"/>
									</form>
								</div>
								
								<div class=edit_comment>
									<div type="button" class=edit_comment_input>修改留言▶</div>
									<form method="POST" action=edit_comment.php>
										<textarea name=edit_comment_content><?php echo $row["content"]?></textarea>
										<input type="hidden" name=edit_comment_id value="<?php echo $row["id"]?>"></br>
										<input type="submit" value="送出">
									</form>
								</div>
						
<!--						
						
						<input type="submit" class=edit_comment value="修改留言"/>
							<form method="POST" action=edit_comment.php>
								<textarea name=edit_comment_content><?php echo $row_child["content"]?></textarea>
								<input type="hidden" name=edit_comment_id value="<?php echo $row_child["id"]?>">
								<input type="submit" value="送出">
							</form>

-->

<?php						}
?>			
						
					</div>
<?php
						}
					}				
?>
				<!--新增子留言-->
				<div class=replyOldMessage>
					<div type="button" class="replyOldMessage_new">新增留言▶</div>
					<form class=replyOldMessage_form method="POST" action=addcomment.php>
						<p>暱稱：<?php echo htmlspecialchars($find_nic["nickname"], ENT_QUOTES, 'utf-8') ?></p>
						<input type="hidden" class=nickname name=nickname value="<?php echo htmlspecialchars($find_nic["nickname"], ENT_QUOTES, 'utf-8') ?>"/>
						<textarea class=comment name=comment placeholder="請輸入留言"></textarea></br>
						<input type="hidden" class=parent_id name=parent_id  value="<?php echo $row["id"]; ?>"/>
						<input type="submit" class=button value="新增子留言"/>
					</form>
					</div>	
				</div>
<?php
				}
			}

			//印出之後頁數的連結
			/*
			$num;		//總留言數
			$page_num;	//總頁數
			$page		//當前的頁數
			$page10		//顯示要印出的第一筆留言為第n筆
			*/

			echo "<div id=page>";
			$page_plus=1;
			
			while($num>0){
				if($page_plus==$page){
					echo "<a>$page_plus</a>"."  ";
				}
				else{
					echo "<a href=board.php?page=$page_plus>$page_plus</a>"."  ";					
				}			
				$num-=10;
				$page_plus++;
			}
			echo "</div>";	
			
		}

		// cookie 錯誤
		else{
			setcookie('id','',time()-3600);
			header("refresh:3;url=login.php");
			echo "請先登入您的帳號"; 				
		}
		
	}
	mysqli_close($dbc);
?>

		</div>
	</body>
</html>