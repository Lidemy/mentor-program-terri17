<?php
	require_once('dbc.php');
	
	//清空錯誤訊息
	$error='';
	
		//如果有cookie且cookie正確
		if(isset($_COOKIE['session_id'])){
			$cookie_passid ="SELECT * FROM terri_cookie";
			$cookie_result = mysqli_query($dbc,$cookie_passid);
			while($row=mysqli_fetch_array($cookie_result)){
				if($row['session_id'] === $_COOKIE['session_id']){
					header("board.php");
					exit();
				}
			}
			//如果有cookie，但cookie錯誤，清空cookie					
			setcookie('session_id','',time()-3600);
		}
		
		// 如果沒有cookie
		if (!isset($_COOKIE['session_id'])){

			//如果有submit
			if(isset($_POST['submit'])){
	 
				// 擷取表單資料 
				$username=$_POST['username'];
				$password=$_POST['password'];
				
				// 確認帳號密碼都有輸入
				if (!empty($username) && !empty($password)){

					//抓取會員帳號，防止SQL injection
					$stmt = $dbc->prepare("SELECT * FROM terri_member where username=?");
					$stmt->bind_param('s',$username);
					$stmt->execute();	
					$result = $stmt->get_result();
					
/*舊版				$sql="SELECT * FROM terri_member where username= '$username'";
					$result = mysqli_query($dbc,$sql) or die('無法抓到會員資料');*/
					$row= mysqli_fetch_array($result);
					
					//檢查該會員帳號的密碼，password_verify
						if (password_verify($password,$row['password'])==true) {

							//設置通行證，並寫入
							$session_id=uniqid('',TRUE);
							//$put_session_id="INSERT INTO terri_cookie VALUES('$session_id','$username')";
							$put_session_id="UPDATE terri_cookie SET session_id='$session_id' where username='$username'";
							mysqli_query($dbc,$put_session_id);

							//設cookie
							setcookie('session_id',$session_id, time()+3600*24);
							header("refresh:3,url=board.php");
							echo "登入成功，網頁將轉至留言版";
						}
						else{
							$error="帳號或密碼錯誤，請重新輸入";
						}
				}
				else {
					$error= "請輸入完整的帳號與密碼";
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
			if(empty($_COOKIE['session_id'])){
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
?>
	</body>
</html>		