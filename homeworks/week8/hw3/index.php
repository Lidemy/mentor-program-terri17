<!--
php抓出可以購買的品項
點擊送出，計算勾選的項目，ajax傳送到後端
檢查所有的品項都可以購買，db扣除
response傳送結果，以alert顯示
-->

<html>
	<head>
		<meta charset="utf=8"/>
		<style>
			form{
				width:200px;
				margin:auto;
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	
	<body>
		<form>購買品項
			</br>
<?php	

	require_once("dbc.php");		

	$statement=$dbc->prepare("SELECT item,id FROM terri_transaction");
	$statement->execute();
	$result=$statement->get_result();

	if ($row_num=$result->num_rows>0){ 				
		while ($row = $result->fetch_assoc()){				
			echo "<input type='checkbox' value=".$row["id"].">".$row["item"]."</br>";
		}
	}
	
	$dbc->close();
?>
			<input type="submit"/>
		</form> 

		<script>
			$(document).ready(function(){
				
				$(document).on("submit",function(e){
					e.preventDefault();
					
					var total_item=[];		
					$("input").each(function(){
						if ($(this).is(":checked")){
							console.log($(this).val());
							total_item.push($(this).val());
						}
					})


					$.ajax({
						type: "POST",
						url: "transaction.php",
						data: {item:total_item},
						success:function(resp){
							var resp=JSON.parse(resp);							
							if(resp.result==="success"){
								alert("購買成功");								
							}
							if(resp.result==="fail"){
								alert(resp.shortage +"缺貨無法購買");
							}
						}
					});
					
				})
			})
			
		</script>
	</body>
</html>