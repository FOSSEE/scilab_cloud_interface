<?php
	require_once('db-connect.php');
	if(isset($_REQUEST['eid'])) {
		$extensions = array('sce', 'sci');
		$data = "";
		$query = "select filepath from textbook_companion_dependency_files where id in (select dependency_id from textbook_companion_example_dependency where example_id=".$_REQUEST['eid'].")";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)) {
			if(in_array(end(explode('.', $row['filepath'])), $extensions)) {
				$file = file_get_contents('../uploads/'.$row['filepath'], true);
				$data .= $file;
			}
		}
		$query = "select filepath from textbook_companion_example_files where example_id=".$_REQUEST['eid'];
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)) {
			if(in_array(end(explode('.', $row['filepath'])), $extensions)) {
				$file = file_get_contents('../scilab_in/uploads/'.$row['filepath'], true);
				$data .= $file;
			}
		}
		echo $data;
		exit;
	}else {
		echo "Invalid request!";
		exit;
	}
?>
