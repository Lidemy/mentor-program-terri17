<?php
	require_once('dbc.php');
	
	//防止XSS
	$content=htmlspecialchars($_POST['edit_comment_content'], ENT_QUOTES, 'utf-8');
	$id=htmlspecialchars($_POST['edit_comment_id'], ENT_QUOTES, 'utf-8');
	
	//防止SQL injection
	$stmt= $dbc->prepare("UPDATE terri_week5hw2 SET content=? WHERE id=?");
	$stmt->bind_param('ss',$content,$id);
	$stmt->execute();	

	/*	$edit="UPDATE terri_week5hw2 SET content='$content' WHERE id='$id'";
	$dbc->query($edit); */
	
	mysqli_close($dbc);

	header("Location:board.php");
?>
