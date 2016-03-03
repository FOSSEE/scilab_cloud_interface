<?php
$to = "rush2jrp@gmail.com, rush2jrp@gmail.com";
$subject = "New Cloud Comment";
$message = "A new comment has been posted. <br> http://scilab.in/cloud_comments";
$from = "textbook@scilab.in";

$headers = "From: " . $from . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?> 
