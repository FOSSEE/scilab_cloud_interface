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
			if(isset($_POST['type']) && isset($_POST['comment'])){
				$query = "insert into scilab_cloud_comment (type, comment, email,category,books,chapter,example) values(".$_POST['type'].", '".$_POST['comment']."', '".$_POST['email']."', '".$_POST['category']."', '".$_POST['books']."', '".$_POST['chapter']."', '".$_POST['example']."')";
				if(mysql_query($query)){

			 	echo "<p>Thank you for your valuable feedback.</p>";

				$to = "rush2jrp@gmail.com, mukulrkulkarni@gmail.com, lavitha89@gmail.com, kannan@iitb.ac.in, kiran@fossee.in, manasdas17@gmail.com";
				// $to = "rush2jrp@gmail.com, jayaram@iitb.ac.in";
				$subject = "New Cloud Comment";
				$message = "
                    A new comment has been posted. <br> 
                    Type: {$types[$_POST['type']]} <br>
                    Comment: {$_POST['comment']} <br>
                    Link: http://scilab.in/cloud_comments
                ";
				$from = "textbook@scilab.in";

				$headers = "From: " . $from . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				mail($to,$subject,$message,$headers);


				}else{
					echo "<p>Sorry for the inconvience, please try again</p>";
				}
			}else{ ?>
<?php } ?>
