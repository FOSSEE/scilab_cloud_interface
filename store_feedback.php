<?php
require_once('db-connect.php');
if($_POST['type'] && $_POST['comment']){
	$query = "insert into scilab_cloud_comment (type, comment, email) values(".$_POST['type'].", '".$_POST['comment']."', '".$_POST['email']."')";
	if(mysql_query($query)){
	
		echo "<p>Thank you for your valuable feedback.</p>";
	}else{
		echo "<p>Sorry for the inconvience, please try again</p>";
	}
}else{
	echo "<p>Sorry for the inconvience, please try again</p>";
}
?>
