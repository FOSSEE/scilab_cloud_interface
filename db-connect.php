<?php
	require_once('../scilab_in_2015/sites/default/settings.php');
	$db_data = str_replace("mysql://", "", $db_url['default']);
	$tmp_db_data = explode(":", $db_data);
	$db_user = $tmp_db_data[0];
	$tmp_db_data = explode("@", $tmp_db_data[1]);
	$db_pass = $tmp_db_data[0];
	$tmp_db_data = explode("/", $tmp_db_data[1]);
	$db_host = $tmp_db_data[0];
	$db = $tmp_db_data[1];
	mysql_connect($db_host,$db_user,$db_pass) or die("Connection failed"); //open database
	mysql_select_db($db) or die("Not Connected to Database"); //select database
?>
