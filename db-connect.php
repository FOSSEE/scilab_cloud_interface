<?php
	require_once('../scilab_in_2015/sites/default/settings.php');

        $db = $databases['default']['default']['database'];
	$db_host = $databases['default']['default']['host'];
	$db_user = $databases['default']['default']['username'];
	$db_pass = $databases['default']['default']['password'];
	mysql_connect($db_host,$db_user,$db_pass) or die("Connection failed"); //open database
	mysql_select_db($db) or die("Not Connected to Database"); //select database
?>
