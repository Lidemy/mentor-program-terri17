<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>	
<?php
	require_once('dbc.php');
	
	// 如果送出表單，抓取form裡面的資料
	if (isset($_POST['submit'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$nickname = $_POST['nickname'];
	
		// 確認表單內每個選項都有填寫
		if (!empty($username) && !empty($password) && !empty($nickname)){
			
			//密碼加工
			$password = password_hash("$password", PASSWORD_DEFAULT);
			
			//確認帳號沒有重複			
			$sql = "SELECT * FROM terri_week5hw3 WHERE username =".$username;
			$result_sql=mysqli_query($dbc,$sql);
			if (mysqli_num_rows($result_sql) ==0){

				//確認暱稱沒有重複後
				$name = "SELECT * FROM terri_week5hw3 WHERE nickname =".$nickname;
				$result_name=mysqli_query($dbc,$name);
				if (mysqli_num_rows($result_name) ==0){

				//加入表單中
				$put="INSERT INTO terri_week5hw3 (username,password,nickname) VALUES ('$username','$password','$nickname')";
				mysqli_query($dbc,$put);
				
				//header("refresh:2;url=login.php");
				echo "已成功建立帳號，請登入。網頁將自動轉向登入頁面。";

				mysqli_close($dbc);
				exit();				
				
				}	
				else{
					echo "此暱稱已被使用，請選擇其他暱稱。<a href=register.php></a>";
				}
			}
			else{
				echo "此帳號已被使用，請選擇其他帳號。<a href=register.php></a>";
			}
		}
		else{
			echo "請填滿所有欄位。<a href=register.php></a>";
		}
	}
	mysqli_close($dbc);  
?>
	
		<form method="post" action="register.php">
			<p>Registration Info</p>
			username:
			<input type="text" id=username name="username"/><br/> <!--value=<?php if (!empty($username)) echo $username; ?>-->
			Password:
			<input type="password" id=password name="password"/><br/>
			Nickname:
			<input type="text" id=nickname name="nickname"/><br/>
			<input type="submit" name="submit" />
		</form>
	</body> 	

</html>