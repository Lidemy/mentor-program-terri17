<?php
$content=$_POST['edit_comment_content'];
$id=$_POST['edit_comment_id'];

require_once('dbc.php');
$edit="UPDATE terri_week5hw2 SET content='$content' WHERE id='$id'";
$dbc->query($edit); 

header("Location:board.php");

?>
