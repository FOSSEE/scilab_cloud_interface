	<html>
	<head>
		<title>Home | Scilab cloud</title>
		<script  src="jquery.js" type="text/javascript"></script>
		
		
	</head>
	<body>
		<?php 
			require_once('db-connect.php');
			//var_dump($_POST);
			//die;
			if(isset($_POST['type']) && isset($_POST['comment'])){
				$query = "insert into scilab_cloud_comment (type, comment, email,category,books,chapter,example) values(".$_POST['type'].", '".$_POST['comment']."', '".$_POST['email']."', '".$_POST['category']."', '".$_POST['books']."', '".$_POST['chapter']."', '".$_POST['example']."')";
				if(mysql_query($query)){
	
			 	echo "<p>Thank you for your valuable feedback.</p>";
				}else{
					echo "<p>Sorry for the inconvience, please try again</p>";
				}
			}else{ ?>
	</body>
</html>
<?php } ?>
