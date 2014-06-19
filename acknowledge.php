<?php
    require_once('db-connect.php');
    $book_id = $_POST['book_id'];
    $output = "";

    $query = "select * from textbook_companion_preference where id = {$book_id}";
    $result = mysql_query($query);
    if (!$result) {
        echo 'Could not run query: ' . mysql_error();
        exit;
    }
    $preference =mysql_fetch_array($result);

    $query = "select * from textbook_companion_proposal where id = {$preference['proposal_id']}";
    $result = mysql_query($query);
    if (!$result) {
        echo 'Could not run query: ' . mysql_error();
        exit;
    }
    $proposal = mysql_fetch_array($result);

    $output .= "<div class='contributor'><b>Contributor:</b> {$proposal['full_name']} </div>";
    $output .= "<div class='teacher'><b>Mentor:</b> {$proposal['faculty']} </div>";
    $output .= "<div class='reviewer'><b>Book Reviewer:</b> {$proposal['reviewer']} </div>";
    $output .= "<div class='download'><b>College Name:</b> {$proposal['university']} </div>";
    echo $output;
?>
