<?php
	require_once("dbc.php");

	$dbc->autocommit(FALSE);
	$dbc->begin_transaction();
	
	$item=$_POST["item"];
	
	$item_situation='';
	
	//檢查是否所有商品都有貨
	for($i=0; $i<count($item); $i++){
		$statement=$dbc->prepare("SELECT amount,item FROM terri_transaction where id=? for update");
		$statement->bind_param("i", $item[$i]);
		$statement->execute();
		$result=$statement->get_result();
		if ($result->num_rows>0){
			$row = $result->fetch_assoc();
			if($row["amount"]<=0){
				$item_situation.=$row["item"]." ";
			}
		}	
	}	

	//所有選購的商品都有貨，可以購買	
	if($item_situation===''){
		for($i=0; $i<count($item); $i++){
			$statement=$dbc->prepare("UPDATE terri_transaction SET amount=amount-1 where id=?");
			$statement->bind_param("i", $item[$i]);
				if($statement->execute()){
				// echo $item[$i]."購買成功";
			}
		}
		$arr = array ("result" => "success");		
	}
	else{
		// echo $item_situation."缺貨無法購買";
		$arr = array ("result" => "fail", "shortage" => $item_situation);		
	}

	echo json_encode($arr);	
	
	$dbc->commit();
	$dbc->close();
?>