<?php
	
	require_once('dbc.php');
	
	//清空錯誤訊息
	$error=''; 
		
		//如果沒有cookie
		if(!isset($_cookie['username'])){	

			//如果有sibmit
			if(isset($_POST['submit'])){

				// 擷取表單資料 
				$username=$_POST['username'];
				$password=$_POST['password'];
				
				// 確認帳號密碼都有輸入
				if (!empty($username) && !empty($password)){
				
					//檢查是否輸入正確  注意單雙引號的應用
					$sql = "SELECT * FROM terri_week5hw3 where username= '".$username."' and password= '".$password."' ";		
					$result = mysqli_query($dbc,$sql) or die('無法抓到會員資料');
					
					//如果有抓到會員資料 
						if (mysqli_num_rows($result) > 0){
							$row= mysqli_fetch_array($result) or die('無法抓到單筆的帳號與密碼');
							setcookie('username',$row['username'],time()+3600*24);
							setcookie('password',$row['password'],time()+3600*24);
							
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
			if(empty($cookie['username'])){
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

		//如果有cookie，直接登入
		else {
			header("refresh:3;url=board.php");
			echo "您已登入，登入帳號為".$_COOKIE["username"]."，網頁將轉至留言版"; 
			
		}
?>
	</body>
</html>		


