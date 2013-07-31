<?php
	require_once('db-connect.php');
	if(isset($_POST['catid'])) {
		$query = "SELECT pre.id, pre.book, author FROM textbook_companion_preference pre WHERE pre.approval_status=1 AND pre.category=".$_POST['catid']." AND cloud_pref_err_status=0 and pre.proposal_id IN (SELECT id from textbook_companion_proposal where proposal_status=3) ORDER BY pre.book ASC";
		$result = mysql_query($query);
		$data = '<select id="books" name="books">';
		$data .= '<option value="">-- Select book --</option>';
		$counter = 1;
		while($row = mysql_fetch_object($result)){
			$counter_str = '';
			if($counter < 10) {
				$counter_str = '&nbsp;&nbsp;&nbsp;'.$counter.'.&nbsp;&nbsp;';
			}elseif($counter < 100) {
				$counter_str = '&nbsp;'.$counter.'.&nbsp;&nbsp;';
			}else {
				$counter_str = $counter.'.&nbsp;&nbsp;';
			}
			$data .= '<option value="' . $row->id . '">' . $counter_str . $row->book . ' (' . $row->author . ')</option>';
			$counter++;
		}
		$data .= '</select>';
		echo $data;
		exit;
	}elseif(isset($_POST['bid'])) {
		$query = "select id, name, number from textbook_companion_chapter where cloud_chapter_err_status=0 and preference_id=".$_POST['bid']." order by number ASC";
		$result = mysql_query($query);
		$data = '<select name="chapter" id="chapter">';
		$data .= '<option value="">-- Select chapter --</option>';
		while($row = mysql_fetch_object($result)){
			$data .= '<option value="' . $row->id . '">' . $row->number . ' &nbsp;-&nbsp; ' . $row->name . '</option>';
		}
		$data .= '</select>';
		echo json_encode($data);
		exit;
	}elseif(isset($_POST['cid'])) {
		$query = "select id, caption, number from textbook_companion_example where cloud_err_status=0 and chapter_id=".$_POST['cid'];
		$result = mysql_query($query);
		$data = '<select name="example" id="example">';
		$data .= '<option value="">-- Select an example --</option>';
		while($row = mysql_fetch_object($result)) {
			$data .= '<option value="' . $row->id . '">' . $row->number . ' &nbsp;-&nbsp; ' . $row->caption . '</option>';
		}
		$data .= '</select>';
		echo json_encode($data);
		exit;
	}
?>
