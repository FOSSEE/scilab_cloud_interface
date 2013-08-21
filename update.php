<?php
	require_once('db-connect.php');
	$file = fopen("all_results.csv", "r") or exit("Unable to open file!");
	$count = 1;
	while(!feof($file)) {
		$line = fgets($file);
	    $rec = explode(";", $line);
	    if(count($rec) >= 8) {
	    	if($rec[6] == 'error') {
	    		$query = "update textbook_companion_example set cloud_err_status=1 where chapter_id=".trim($rec[2])." and number=".trim($rec[4]);
	    		mysql_query($query);
	    		echo $count++ . " " . $query . "<br>";
	    	}
	    }
	}
	fclose($file);
?>
