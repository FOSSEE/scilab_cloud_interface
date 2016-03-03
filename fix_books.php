<?php
	require_once('db-connect.php');
	
	$query = "select id from textbook_companion_chapter where cloud_chapter_err_status=0 and preference_id in (select id from textbook_companion_preference where approval_status=1 and proposal_id in (select id from textbook_companion_proposal where proposal_status=3))";
	$result = mysql_query($query);
	while($row = mysql_fetch_object($result)) {
		$query = "select count(id) as cid from textbook_companion_example where chapter_id=".$row->id." and cloud_err_status=0";
		$res = mysql_query($query);
		$rec = mysql_fetch_object($res);
		$cid = (int)($rec->cid);
		if($cid == 0) {
			$query = "update textbook_companion_chapter set cloud_chapter_err_status=1 where id=".$row->id;
			mysql_query($query);
		}
	}
	$query = "select id from textbook_companion_preference where approval_status=1 and proposal_id in (select id from textbook_companion_proposal where proposal_status=3)";
	$result = mysql_query($query);
	while($row = mysql_fetch_object($result)) {
		$query = "select count(id) as cid from textbook_companion_chapter where cloud_chapter_err_status=0 and preference_id=".$row->id;
		$res = mysql_query($query);
		$rec = mysql_fetch_object($res);
		$cid = (int)($rec->cid);
		if($cid == 0) {
			$query = "update textbook_companion_preference set cloud_pref_err_status=1 where id=".$row->id;
			mysql_query($query);
		}
	}
?>
