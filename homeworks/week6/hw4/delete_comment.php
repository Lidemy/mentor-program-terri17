<?php
	require_once('dbc.php');

	$delete = "DELETE FROM terri_message WHERE id=".$_POST['id'];
	$dbc->query($delete);
	
	mysqli_close($dbc);
	
	header('Location:board.php');
?>