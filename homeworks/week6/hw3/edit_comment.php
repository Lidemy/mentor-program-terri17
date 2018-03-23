<?php
	require_once('dbc.php');
	$content=$_POST['edit_comment_content'];
	$id=$_POST['edit_comment_id'];
	
	$edit="UPDATE terri_message SET content='$content' WHERE id='$id'";
	$dbc->query($edit); 
	
	mysqli_close($dbc);

	header("Location:board.php");
?>
