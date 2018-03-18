<?php
	require_once('dbc.php');
	
	//防止XSS
	$id=htmlspecialchars($_POST['id'], ENT_QUOTES, 'utf-8');
	
	//防止SQL injection
	$stmt= $dbc->prepare("DELETE FROM terri_week5hw2 WHERE id=?");
	$stmt->bind_param('s',$id);
	$stmt->execute();		
	$stmt->get_result();

/*舊版
	$delete = "DELETE FROM terri_week5hw2 WHERE id=".$_POST['id'];
	$dbc->query($delete);
*/	
	mysqli_close($dbc);
	
	header('Location:board.php');
?>