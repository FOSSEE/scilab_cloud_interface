<?php
require_once('db-connect.php');
$types = array(
  1 => "Blank Code / Incorrect code",
  2 => "Output error",
  3 => "Execution error",
  4 => "Missing example(s)",
  6 => "Blank output",
  7 => "Any other"
);
if (isset($_POST['type']) && isset($_POST['comment']))
 {
  $query = "insert into scilab_cloud_comment (type, comment, email,category,books,chapter,example) values(" . $_POST['type'] . ", '" . $_POST['comment'] . "', '" . $_POST['email'] . "', '" . $_POST['category'] . "', '" . $_POST['books'] . "', '" . $_POST['chapter'] . "', '" . $_POST['example'] . "')";
  if (mysql_query($query))
   {
    echo "<p>Thank you for your valuable feedback.</p>";
    $query_details = "SELECT tcp.book as book, tcp.author as author, tcp.publisher as publisher, 
                tcp.year as year,tcp.category as category, tce.chapter_id, tcc.number AS chapter_no, 
                tcc.name AS chapter_name, tce.number AS example_no, tce.caption AS example_caption 
                FROM textbook_companion_preference tcp 
                LEFT JOIN textbook_companion_chapter tcc ON  tcp.id  = tcc.preference_id 
                LEFT JOIN textbook_companion_example tce ON tce.chapter_id = tcc.id 
                WHERE tce.id = '" . $_POST['example'] . "'";
    $exmpale_id    = $_POST['example'];
    $result        = mysql_query($query_details);
    $row           = mysql_fetch_object($result);
    $category      = _tbc_list_of_category($row->category);
    $to            = "email@email.in";
    $subject       = "New Cloud Comment";
    $message       = "
                    A new comment has been posted. <br><br>

                     Type: {$types[$_POST['type']]} <br>
                     Book: {$row->book} <br>
                     Chapter: {$row->chapter_name} ({$row->chapter_no}) <br>
                     Example: <a href= 'http://cloud.scilab.in/index.php?eid={$exmpale_id}' target='_blank' >{$row->example_caption}</a> ({$row->example_no}) <br><br>

                     Comment: {$_POST['comment']} <br>

                    Link: http://scilab.in/cloud_comments
                ";
    $from          = "textbook@scilab.in";
    $headers       = "From: " . $from . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to, $subject, $message, $headers);
   }
  else
   {
    echo "<p>Sorry for the inconvience, please try again</p>";
   }
 }
else
 {
?>
<?php
 }
function _tbc_list_of_category($category_id)
 {
  $query              = "SELECT * FROM list_of_category WHERE category_id = " . $category_id;
  $category_list      = mysql_query($query);
  $category_list_data = mysql_fetch_object($category_list);
  $category           = $category_list_data->category_name;
  return $category;
 }
?>
