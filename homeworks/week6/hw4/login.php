<?php
	require_once('dbc.php');
	
	//清空錯誤訊息
	$error='';
	
		// 如果沒有設cookie
		if (!isset($_COOKIE['id'])){

			//如果有submit
			if(isset($_POST['submit'])){

	 
				// 擷取表單資料 
				$username=$_POST['username'];
				$password=$_POST['password'];
				
				// 確認帳號密碼都有輸入
				if (!empty($username) && !empty($password)){

					//抓取會員帳號，防止SQL injection
					$stmt = $dbc->prepare("SELECT * FROM terri_week5hw3 where username=?");
					$stmt->bind_param('s',$username);
					$stmt->execute();	
					$result = $stmt->get_result();
					
/*舊版				$sql="SELECT * FROM terri_week5hw3 where username= '$username'";
					$result = mysqli_query($dbc,$sql) or die('無法抓到會員資料');*/
					$row= mysqli_fetch_array($result);
					
					//檢查該會員帳號的密碼，password_verify
						if (password_verify($password,$row['password'])==true) {

							//設置通行證，並寫入
							$pass_id=uniqid('',TRUE);
							$put_pass_id="UPDATE terri_week6hw3 SET id='$pass_id' where username='$username'";
							mysqli_query($dbc,$put_pass_id);

							//設cookie
							setcookie('id',$pass_id,time()+3600*24);
							header("refresh:3,url=board.php");
							echo "登入成功，網頁將轉至留言版"; //在同一個頁面
						}
						else{
							$error="帳號或密碼錯誤，請重新輸入";
							//header('Location:./login.php');
						}
				}
				else {
					$error= "請輸入完整的帳號與密碼";
					// header('Location:'message.php);
				}	
			}
		 				
?>

<html>
	<head>
		<meta charset="utf-8"/>
		<title>登入會員</title>
	</head>
	<body>
<?php
			//當cookie是空的，沒有登入
			//顯示登入的表單與錯誤訊息(如果有的話)
			if(empty($_COOKIE['id'])){
				echo '<p class="error">'.$error.'</p>';
		
?>	
		<form method="post" action="login.php">
			<p>Log In</p>
			username:
			<input type="text" name="username"/><br/> 
			Password:
			<input type="password" name="password"/><br/> 		
			<input type="submit" value="Log In" name="submit"/>
		</form>
			
		<div class=none> 
			<a href="register.php">尚未註冊會員</a>
		</div>
	
<?php
			}
		}

		// 如果有cookie
		if(isset($_COOKIE['id'])){		
			$cookie_passid ="SELECT * FROM terri_week6hw3";
			$cookie_result = mysqli_query($dbc,$cookie_passid);
			$cookie_row = mysqli_fetch_array($cookie_result);
			// cookie 正確
			if ($cookie_row['id'] === $_COOKIE['id']) {
				header("refresh:3;url=board.php");
				echo "您已登入，登入帳號為".$cookie_row["username"]."，網頁將轉至留言版"; 
			}
			// cookie 錯誤
			else{
				setcookie('id','',time()-3600);
				header("login.php");				
			}
		}
		
?>
	</body>
</html>		