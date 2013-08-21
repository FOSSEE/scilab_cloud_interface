<html>
	<head>
		<title>Home | Scilab cloud</title>
		<script  src="jquery.js" type="text/javascript"></script>
		<script src="jquery.lightbox_me.js"></script>
		<script>
			$(document).ready(function(){
				
				var webroot = "http://cloud.scilab.in/";
				var imgdata = '<img src="/images/ajax-loader.gif">';
				$("a#single_image").fancybox();
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
							if (msg["graph"]!=""){
								$("#single_image").attr("href","http://scilab-test.garudaindia.in/cloud/graphs/"+msg["user_id"]+"/"+msg["graph"]+".png");
								$("#image").attr("src","http://scilab-test.garudaindia.in/cloud/graphs/"+msg["user_id"]+"/"+msg["graph"]+".png");
								$("#download").attr("href","http://scilab-test.garudaindia.in/cloud/download/"+msg["graph"]);
								$("#graph-dwnld").show();
								$("#single_image").trigger("click");
							}
						}
					});
				});
				
				// collect book details
				
			});
		</script>
    <script src="fancybox.js"></script>
    <link href="fancybox.css" rel="stylesheet">
    <style type="text/css">
    	div.lalg {
    		float: left;
    		width: 100px;
    		font-weight: bold;
    	}
    	#input {
    		width: 100%;
		height: 320px;
    		resize: none;
    		background-color: #fffcfc;
    		color: black;
		font-family: courier;
    		-moz-border-radius: 5px;
			border-radius: 5px;
			border: 0px;
    	}
    	#output {
    		width: 100%;
		height: 320px;
    		resize: none;
		font-family: courier;
    		background-color: #fffcfc;
    		color: blue;
    		-moz-border-radius: 5px;
			border-radius: 5px;
			border: 0px;
    	}
    	.bclr {
    		background: #7f7f7f;
    	}
    	.banner {
			margin-bottom: 10px;
			height: 45px;
			width: 100%;
			background-color: #4E3419;
			border-bottom: 0 solid #2E2E2E;
			border-top: 0 solid #2E2E2E;
			box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.7);
    	}
    	.logo {
    		height: 31px;
    		margin: 8px 0 0 10px;
    		float: left;
    	}
    	.site-name {
    		width: auto;
    		font: 32px Arial;
    		color: white;
    		padding: 6px 0 0 60px;
    	}
    	.footer {
    		margin-top: 10px;
			width: 100%;
			background-color: #4E3419;
			border-bottom: 0 solid #2E2E2E;
			border-top: 0 solid #2E2E2E;
			box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.7);
			text-align: center;
			padding-top: 12px;
			padding-bottom: 12px;
    	}
    	.white-text {
    		color: white;
    		font: 14px Arial;
    		font-weight: bold;
    	}
    	#commentBtn {
		background: #efefef;
		text-decoration: none;
		/*font-weight: bold;*/
		color: black;
		padding: 4px;
		float: right;
		border: 2px solid;
		margin-right: 5px;
	}
	.execute-button {
                background: #efefef;
                text-decoration: none;
                /*font-weight: bold;*/
                color: black;
                padding: 4px;
                border: 2px solid;
                margin-left: 5px;
        }
    	#lightbox-form{
    		background: #FFFFFF;
    		padding: 15px;
    		-moz-border-radius: 5px;
    		-webkit-border-radius: 5px;
    		-o-border-radius: 5px;
    		border-radius: 5px;
    		position: relative;
    	}
    	#lightbox-close{
    		position: absolute;
    		top: -12;
    		right: -12	;
    	}
	.loading-cls{
		cursor:wait;
	}
    </style>
	</head>
	<body background="images/body-bg.png" class="cls-body">
		<div class="banner">
			<a href="http://scilab.in" class="home-link" title="scilab.in"><img src="images/scilab-logo.png" class="logo" alt="Home"></a>
			<div class="site-name">Scilab on Cloud</div>
		</div>
		<div id ="image" style="display:none"><a id="single_image" href=""><img id="image" src=""></a></div>
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
				<td><textarea name="code" id="input" rows="20" cols="40">Write a new code or select existing from above category...</textarea></td>
				<td><textarea name="code" id="output" rows="20" cols="40" readonly="readonly"></textarea></td>
			</tr>
			<tr class="bclr">
				<td>
					<!-- &nbsp;&nbsp;<input type="button" id="submit" name="submit" value="Execute"> -->
					<a href="#" id="submit" class="execute-button">Execute</a>
					<!-- <input type="checkbox" id="graphicsmode" ><span class="white-text">&nbsp;Enable Graphics</span> -->
				</td>
				<td>
					<a id="commentBtn" href="#" onclick="tester();"> Comment</a>
				</td>
			</tr>
		</table>
		<div class="footer white-text"><p class="test-footer" style="font-size: 10px;color: lightgoldenrodyellow;text-align: center;margin: 0px 0px 0px 0px;">Disclaimer: Scilab is a trademark of <a href="http://www.inria.fr/en/" target="_blank" class="ext" style="color:#FFFFFF;">Inria</a><span class="ext"></span> (registered at the INPI for France and the rest of the World) and <a href="http://www.scilab-enterprises.com/" target="_blank" class="ext" style="color:#FFFFFF;">Scilab Enterprises</a><span class="ext"></span> is granted exclusive rights for Scilab Trademark.</p>
<h3 style="margin:3px 0px 0px 0px;">Copyright &copy; IIT Bombay</h3></div>

	<!-- lightbox form -->
	<div id="lightbox-form" style="display:none">
		<a href="#" id="lightbox-close" onclick='$("#lightbox-form").trigger("close");'><img src="images/close.png" width="30px"></a>
		<div id="myDiv"></div>
		<form name="comment_form" id="comment_form">
							<p>Please fill the details.</p>
							<select name="error_type">
								<option>-- Select Type of issue --</option>
								<option value=1> Blank Code / Incorrect code</option>
								<option value=2>Output error</option>
								<option value=3>Executed but Incorrect output</option>
								<option value=4>Missing example(s)</option>
								<option value=6>Blank output</option>
								<option value=7>Any other</option>
							</select> <br><br>
							
							<label>Description:</label><br>
							<textarea name="comment" rows="6" cols="50" placeholder="Please tell us more..."></textarea> <br><br>
							<label>Email (optional):</label><br>
							<input type="text" name='email'> <br><br>

					<input id="submitButtonId" type="button" value="Submit" onclick="commentSubmit();">
		</form>

	</div> <!-- / lightbox-form -->
	<script type="text/javascript">
			// LightBox
			$('#commentBtn').click(function(e) {
					document.getElementById("comment_form").style.display = "block";
                                        document.getElementById("myDiv").innerHTML="";
					$('#lightbox-form').lightbox_me({
						  centered: true, 
						  onLoad: function() { 
						      $('#lightbox-form').find('input:first').focus()
						      }
						  });
					e.preventDefault();
				});
				
				//Ajax form submission
				function commentSubmit()
				{		
						//fetching all form values
						error_type = document.comment_form.error_type.value;
						comment = document.comment_form.comment.value;			
						email = document.comment_form.email.value;
						
						
						//retrive the precise details
						category = document.getElementById("categories").value; 
						books = document.getElementById("books");
						if(books){
							books = books.value;
						}
						else{
							books = "null";
						}
						
						chapter = document.getElementById("chapter");
						if(chapter){
							chapter = chapter.value;
						}
						else{
							chapter = "null";
						}
						
						example = document.getElementById("example");
						if(example){
							example = example.value;
						}else{
							example = "null";	
						}
						
					var xmlhttp;
					if (window.XMLHttpRequest)
						{// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
						}
					else
						{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
					xmlhttp.onreadystatechange=function()
						{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
							{
							document.getElementById("comment_form").style.display="none";
							document.getElementById("myDiv").innerHTML="Thanks for your comment.";
							}
						}
					request_string = "type="+error_type+"&comment="+comment+"&email="+email+"&category="+category+"&books="+books+"&chapter="+chapter+"&example="+example;
					xmlhttp.open("POST","http://cloud.scilab.in/comment.php",true);
					xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
					xmlhttp.send(request_string);
				}
		</script>
	</body>
</html>
