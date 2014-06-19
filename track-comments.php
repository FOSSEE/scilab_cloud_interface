<html>
<head>
	<title>Comments | Scilab on Cloud</title>
	<style>
	  h3{ color: #4E3519; }
	  body{
	    background: url("http://scilab.in/sites/all/themes/scilab/images/content_line.png");
	  }
	  #comments-wrapper{
	    padding: 25px 100px;
	    background: #ffffff;
	    max-width: 800px;
	    margin: 0 auto;
	    -moz-box-shadow: 1px 1px 10px #cccccc;
	    -webkit-box-shadow: 1px 1px 10px #cccccc;
	    -o-box-shadow: 1px 1px 10px #cccccc;
	    box-shadow: 1px 1px 10px #cccccc;
	  }
	  .comment{
	    margin: 25px 0;
	    padding: 25px;
	    background: #f5f5f5;
	    border-left: 3px solid #4E3519;
	  }
	  .from, .type, .book, .chapter, .example, .category{
	    display: block;
	  }
	  .from{
	   font-weight: bolder; 
	   color: #424242;
	  }
	  .type{
	    color: #4E3519;
	  }
	  .comment p{
	    text-align: justify;
	  }
	  .comment p b{
	    color: #4E3519;
	  }
	</style>
</head>
<body>
<div id="comments-wrapper">
<h3 align="center"><u>Scilab on Cloud - Comments</u></h3>
<?php 
	require_once('db-connect.php');
	$query = "select * from scilab_cloud_comment";
	$result  = mysql_query($query);
	$types = array( 
		"None",
		"Blank Code / Incorrect code",
		"Output error",
		"Execution error",
		"Missing example(s)",
		"None",
		"Blank output",
		"Any other"
	);
	$categories = array(
		"Others",
		"Fluid Mechanics",
		"Control Theory &amp; Control Systems",
		"Chemical Engineering",
		"Thermodynamics",
		"Mechanical Engineering",
		"Signal Processing",
		"Digital Communications",
		"Electrical Technology",
		"Mathematics &amp; Pure Science",
		"Analog Electronics",
		"Digital Electronics",
		"Computer Programming",
		"Others"
	);
	while($row = mysql_fetch_array($result)){
		echo '<div class="comment">';
		echo '<span class="from">From: ' . $row["email"] . '</span>';
		echo '<span class="type">Issue type: ' . $types[$row["type"]] . '</span>';
		$book = mysql_result(mysql_query("select book from textbook_companion_preference where id=".$row["books"]), 0);
		echo '<span class="book">Book: ' . $book . '</span>';
		echo '<span class="category"> Category: ' . $categories[$row["category"]] . '</span>';
		$chapter = mysql_result(mysql_query("select name from textbook_companion_chapter where id=".$row["chapter"]), 0);
		echo '<span class="chapter"> Chapter: ' . $chapter . '</span>';
		$example = mysql_result(mysql_query("select caption from textbook_companion_example where id=".$row["example"]), 0);
		echo '<span class="example"> Example: <a href="http://cloud.scilab.in/index.php?eid=' . $row["example"] . '" target="_blank">' . $example . '</a>' . '</span>';
		echo '<p><b>Comment:</b> <br>' . $row["comment"] . '</p>';
		echo '<a class="reply" href="#">Reply</a>';
		echo '</div> <!-- /comment -->';
	}
	
	
?>
</div> <!-- /comments-wrapper -->
</body>
</html>
