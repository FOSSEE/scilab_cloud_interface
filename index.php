<?php
	/*if(!$_GET['v'])
		echo '<script type="text/javascript"> window.location="under-maintenance.html"; </script>';*/
?>
<html>
	<head>
		<title>Home | Scilab cloud</title>
		<link href="cloud.css" rel="stylesheet">
		<link href="fancybox/source/jquery.fancybox.css" rel="stylesheet">
		<script  src="fancybox/lib/jquery.js" type="text/javascript"></script>
		<script src="fancybox/source/jquery.fancybox.js"></script>
		<script>
			$(document).ready(function(){
				
				var webroot = "http://cloud.scilab.in/";
				var imgdata = '<img src="images/ajax-loader.gif">';
				$("#single_image").fancybox();
				$('.fancymenu').fancybox({title: ""});
				//$("a#comment").fancybox();
				$("#graph-dwnld").hide();
				
				$("#categories").live("change", function(){
					id = $("#categories").val();
					if(id == "") {
						$('#lb').html('');
						$('#b').html('');
						$('#lc').html('');
						$('#c').html('');
						$('#le').html('');
						$('#e').html('');
						$('#input').val('');
						$('#output').val('');

					}else {
						$.ajax({
							type: "POST",
							url: webroot + "getdata.php",
							data:{
								'catid': id
							},
							beforeSend: function(){
								$('#lb').html('');
								$('#b').html(imgdata);
							},
							success: function(output) {
								/*output = JSON.parse(output);*/
								console.log(output);
								if(output){
									$('#lb').html('Book');
									$('#b').html(output);
									$('#lc').html('');
									$('#c').html('');
									$('#le').html('');
									$('#e').html('');
									$('#input').val('');
									$('#output').val('');
								}else {
									alert('There is no book in this category');
								}
							}
						});
					}
				});
				
				$("#books").live("change", function(){
					id = $("#books").val();
					if(id == "") {
						$("#c").html('');
						$("#lc").html('');
						$('#le').html('');
						$('#e').html('');
						$('#input').val('');
						$('#output').val('');
					}else {
						$.ajax({
							type: 'POST',
							url: webroot + "getdata.php",
							data:{
								'bid': id
							},
							beforeSend: function(){
                                                                $('#lc').html('');
                                                                $('#c').html(imgdata);
                                                        },
							success: function(output) {
								output = JSON.parse(output);
								if(output) {
									$("#c").html(output);
									$("#lc").html("Chapter");
									$('#le').html('');
									$('#e').html('');
									$('#input').val('');
									$('#output').val('');
								}else {
									alert('Somthing wrong, Please refresh page');
								}
							}
						});
					}
				});

				$("#chapter").live("change", function(){
					id = $("#chapter").val();
					if(id == "") {
						$('#le').html('');
						$('#e').html('');
						$('#input').val('');
						$('#output').val('');
					}else {
						$.ajax({
							type: "POST",
							url: webroot + "getdata.php",
							data:{
								'cid': id
							},
							beforeSend: function(){
                                                                $('#le').html('');
                                                                $('#e').html(imgdata);
                                                        },
							success: function(output) {
								output = JSON.parse(output);
								if(output) {
									$("#e").html(output);
									$("#le").html("Example");
									$('#output').val('');
									$('#input').val('');
								}else {
									alert('Somthing wrong, Please refresh page');
								}
							}
						});
					}
				});

				$("#example").live("change", function(){
					id = $("#example").val();
					folder = $("#books").val();
					if(id == "") {
						$('#input').val('');
						$('#output').val('');
					}else {
						$.ajax({
							type: "POST",
							url: webroot + "getcode.php",
							data:{
								'eid': id
							},
							success: function(output) {
								$("#input").val(output);
								$('#output').val('');
							}
						});
					}
				});				
				
				
				$("#submit").live("click",function(){
					if ($('#graphicsmode').is(':checked')) {
						val =1;
					}else {
						val='';
					}
					$('.cls-body').addClass('loading-cls');
					$("#submit").html("Executing...");
					$('#submit').addClass('loading-cls');
					$('#input').addClass('loading-cls');
					$('#output').addClass('loading-cls');
					// $("#submit").attr("disabled","disabled");	
					$.ajax({
						type: "POST",
						url: "submit.php",
						data:{code:$("#input").val(),graphicsmode:val},
						dataType: "json",
						success: function(resp ) {
							msg = resp["response"];

							// $("#submit").attr("disabled","");	
							$("#submit").html("Execute");
							$('.cls-body').removeClass('loading-cls');
							$('#submit').removeClass('loading-cls');
							$('#input').removeClass('loading-cls');
							$('#output').removeClass('loading-cls');
							$("#output").val(msg["output"].replace(/^\s+|\s+$/g, ''));
							if (msg["graph_exists"]=="1") {
								$("#image").attr("src","http://scilab-test.garudaindia.in/cloud/graphs/"+msg["user_id"]+"/"+msg["graph"]+".png");
								$("#sdwn").attr("href","http://scilab-test.garudaindia.in/cloud/graphs/"+msg["user_id"]+"/"+msg["graph"]+".png");
								$("#single_image").trigger("click");
							}
						}
					});
				});
			});
		</script>
		<script type="text/javascript">
			//Ajax form submission
			function commentSubmit() {		
				//fetching all form values
				error_type = document.comment_form.error_type.value;
				comment = document.comment_form.comment.value;			
				email = document.comment_form.email.value;
				
				//retrive the precise details
				category = document.getElementById("categories").value; 
				books = document.getElementById("books");
				if(books) {
					books = books.value;
				}else {
					books = "null";
				}
				
				chapter = document.getElementById("chapter");
				if(chapter) {
					chapter = chapter.value;
				}else {
					chapter = "null";
				}
				
				example = document.getElementById("example");
				if(example) {
					example = example.value;
				}else {
					example = "null";	
				}
					
				var xmlhttp;
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}else {
					// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById("comment_form").style.display="none";
						document.getElementById("myDiv").innerHTML="Thanks for your comment.";
					}
				}
				request_string = "type="+error_type+"&comment="+comment+"&email="+email+"&category="+category+"&books="+books+"&chapter="+chapter+"&example="+example;
				xmlhttp.open("POST","http://cloud.scilab.in/comment.php",true);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xmlhttp.send(request_string);
			}
			
			function showEmail() {
				checkbox = document.comment_form.notify;
				emailDiv = document.getElementById("email-notify");
				if(checkbox.checked){
					emailDiv.style.display = "block";
				}
				else{
					emailDiv.style.display = "none";
				}
			}
		</script>
	</head>
	<body background="images/body-bg.png" class="cls-body">
		<div class="banner">
			<a href="http://cloud.scilab.in" class="home-link" title="Home-Scilab on Cloud"><img src="images/scilab-logo.png" class="logo" alt="Home"></a>

			<div class="site-name">Scilab on Cloud</div>

			<div id="banner-tabs">
				<a class="fancymenu" title="Scilab on GARUDA Cloud" href="#abuot1" >About</a>

				<div id="abuot1" style="width:400px; display: none; padding: 5px; font-size: 0.8em; color: black;">
					<b>About Scilab on GARUDA Cloud.</b>

					<p style="text-align: justify; ">Scilab on Cloud facilitates execution of the codes for particular example(s) online. The results can then be verified with the solved example(s) from the textbook. It is also possible to change the values of the variables and in fact, the code itself, and execute it. In addition to the given examples, one can also copy and paste (or) write a new code in the input box provided and execute the same. <a href="http://scilab.in/scilab-on-cloud">Read more.. </a>
					</p>
				</div>

				<a id="invitation" class="fancymenu" title="Textbook Companion Project" href="#invitation1">Invitation</a>

				<div id="invitation1" style="width:400px; display: none; padding: 5px; font-size: 0.8em; color: black;">
					<b>Contribute to Scilab Textbook Companion Project / Scilab on GARUDA Cloud. </b>

					<p style="text-align: justify; ">The FOSSEE team has created a submission portal that allows the code for each example to be uploaded individually. The Textbook Companion Project aims to port solved examples from standard textbooks using an open source software system, such as Scilab. <a href="http://scilab.in/Textbook_Companion_Project">Read more..</a>
					</p>
				</div>
				
				<a id="contact-us" class="fancymenu" title="Contact Scilab on Cloud" href="#contact-us1">Contact us</a>

				<div id="contact-us1" style="width:400px; display: none; padding: 5px; font-size: 0.8em; color: black;">
					<b>Send us your valuable suggestions and feedback that shall enable us to enhance our work.</b>

					<p style="text-align: justify; ">If you wish to contribute to our activities such as <b>Lab Migration, Textbook Companion, SciLinks, Scilab on Cloud, Scilab on Aakash,</b> please write to <a href="mailto: contact@scilab.in">contact@scilab.in</a>.	For feedback on Lab Migration (or) Textbook Companion, <a href="http://scilab.in/feedbacks">click here</a>.
					</p>
				</div>
			</div>

			<a href="http://scilab.in" title="Scilab.in"><img id="scilab-logo" src="images/scilab_logo.png" /></a>
		</div>
		
		<a id="single_image" href="#simage" style="display: none;">test</a>

		<div id="simage" style="display: none; width 50%">
			<img id="image" href="" style="width:100%; height:75%;" /><br><b style="font-size:23px;">&darr;</b>
			<a id="sdwn" href="" target="_blank" download="result.png">Download</a>
		</div>
		
		<div id="abuot1" style="width:400px; display: none; padding: 5px; font-size: 0.8em; color: black;">
			<b>About Scilab on GARUDA Cloud.</b>

			<p style="text-align: justify; ">Scilab on Cloud facilitates execution of the codes for particular example(s) online. The results can then be verified with the solved example(s) from the textbook. It is also possible to change the values of the variables and in fact, the code itself, and execute it. In addition to the given examples, one can also copy and paste (or) write a new code in the input box provided and execute the same. <a href="http://scilab.in/scilab-on-cloud">Read more.. </a>
			</p>
		</div>

		<table align="center" cellpadding="6" cellspacing="0" width="100%">
			<tr>
				<td colspan="2">
					<div class="lalg">Category</div>
					<select id="categories" name="categories">
						<option value="">-- Select category --</option>
						<option value="10">Analog Electronics</option>
						<option value="3">Chemical Engineering</option>
						<option value="12">Computer Programming</option>
						<option value="2">Control Theory &amp; Control Systems</option>
						<option value="7">Digital Communications</option>
						<option value="11">Digital Electronics</option>
						<option value="8">Electrical Technology</option>
						<option value="1">Fluid Mechanics</option>
						<option value="9">Mathematics &amp; Pure Science</option>
						<option value="5">Mechanical Engineering</option>
						<option value="6">Signal Processing</option>
						<option value="4">Thermodynamics</option>
						<option value="13">Others</option>
					</select>
					<span id="contrib"> <a class="fancymenu" href="#acknowledge">+ Contributor</a></span>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<div id="lb" class="lalg"></div>
					<div id="b"></div>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<div id="lc" class="lalg"></div>
					<div id="c"></div>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<div id="le" class="lalg"></div>
					<div id="e"></div>
				</td>
			</tr>
			
			<tr class="bclr">
				<td class="white-text">Scilab Code</td>
				<td class="white-text">Output</td>
			</tr>
			
			<tr class="bclr">
				<td>
					<textarea name="code" id="input" rows="20" cols="40" placeholder="Write a new code or select existing from above category..."><?php
							if(isset($_GET['eid']) && $_GET['eid'] != '') {
								require_once('db-connect.php');
								$extensions = array('sce', 'sci');
								$data = "";
								$query = "select filepath from textbook_companion_dependency_files where id in (select dependency_id from textbook_companion_example_dependency where example_id=".$_REQUEST['eid'].")";
								$result = mysql_query($query);
								if($result) {
									while($row = mysql_fetch_array($result)) {
										if(in_array(end(explode('.', $row['filepath'])), $extensions)) {
											$file = file_get_contents('../scilab_in/uploads/'.$row['filepath'], true);
											$data .= $file;
										}
									}
									$query = "select filepath from textbook_companion_example_files where example_id=".$_REQUEST['eid'];
									$result = mysql_query($query);
									while($row = mysql_fetch_array($result)) {
										if(in_array(end(explode('.', $row['filepath'])), $extensions)) {
											$file = file_get_contents('../scilab_in/uploads/'.$row['filepath'], true);
											$data .= $file;
										}
									}
									echo $data;
								}
							}
						?></textarea>
				</td>

				<td><textarea name="code" id="output" rows="20" cols="40" readonly="readonly"></textarea></td>
			</tr>

			<tr class="bclr">
				<td>
					<a href="#" id="submit" class="execute-button">Execute</a>
				</td>

				<td>
					<a id="commentBtn" class="fancymenu" href="#lightbox-form"> Report bug / Give feedback</a>
					
					<div id="lightbox-form" style="display:none">
						<div id="myDiv"></div>

						<form name="comment_form" id="comment_form">
							<p>Please fill the details.</p>

							<select name="error_type">
								<option>-- Select Type of issue --</option>
								<option value=1> Blank Code / Incorrect code</option>
								<option value=2>Output error</option>
								<option value=3>Execution error</option>
								<option value=4>Missing example(s)</option>
								<option value=6>Blank output</option>
								<option value=7>Any other</option>
							</select>
							<br><br>

							<label>Description:</label><br>
							<textarea name="comment" rows="6" cols="50" placeholder="Please tell us more..."></textarea> <br><br>
							<input name="notify" type="checkbox" onclick="showEmail();"> I want to be notified. <br> <br>
			
							<div id="email-notify">
								<label>Email (optional):</label><br>
								<input type="text" name='email'> <br><br>
							</div>
							
							<input id="submitButtonId" type="button" value="Submit" onclick="commentSubmit();">
						</form>
					</div>
				</td>
			</tr>
		</table>
		<div id="acknowledge" style="display:none;"></div>
		<div class="footer white-text">
			<p class="test-footer" style="font-size: 10px;color: lightgoldenrodyellow;text-align: center;margin: 0px 0px 0px 0px;">Disclaimer: Scilab is a trademark of <a href="http://www.inria.fr/en/" target="_blank" class="ext" style="color:#FFFFFF;">Inria</a><span class="ext"></span> (registered at the INPI for France and the rest of the World) and <a href="http://www.scilab-enterprises.com/" target="_blank" class="ext" style="color:#FFFFFF;">Scilab Enterprises</a><span class="ext"></span> is granted exclusive rights for Scilab Trademark.
			</p>
			<h3 style="margin:3px 0px 0px 0px;">Copyright &copy; IIT Bombay</h3>
		</div>

	<script src="acknowledge.js"></script>
	</body>
</html>
