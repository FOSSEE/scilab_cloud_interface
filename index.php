<html>
	<head>
		<title>Home | Scilab cloud</title>
		<script  src="jquery.js" type="text/javascript"></script>
		<script>
			$(document).ready(function(){
				
				var webroot = "http://cloud.scilab.in/";
				var imgdata = '<img src="/images/ajax-loader.gif">';
				$("a#single_image").fancybox();
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
					$("#submit").attr("value","Executing...");
					// $("#submit").attr("disabled","disabled");	
					$.ajax({
						type: "POST",
						url: "submit.php",
						data:{code:$("#input").val(),graphicsmode:val},
						dataType: "json",
						success: function(resp ) {
							msg = resp["response"];

							// $("#submit").attr("disabled","");	
							$("#submit").attr("value","Execute");
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
    </style>
	</head>
	<body background="images/body-bg.png">
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
				<td><textarea name="code" id="input" rows="20" cols="40"></textarea></td>
				<td><textarea name="code" id="output" rows="20" cols="40" readonly="readonly"></textarea></td>
			</tr>
			<tr class="bclr">
				<td colspan="2">
					&nbsp;&nbsp;<input type="button" id="submit" name="submit" value="Execute"><!--
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="graphicsmode" ><span class="white-text">&nbsp;Enable Graphics</span>-->
				</td>
			</tr>
		</table>
		<div class="footer white-text"><p class="test-footer" style="font-size: 10px;color: lightgoldenrodyellow;text-align: center;margin: 0px 0px 0px 0px;">Disclaimer: Scilab is a trademark of <a href="http://www.inria.fr/en/" target="_blank" class="ext" style="color:#FFFFFF;">Inria</a><span class="ext"></span> (registered at the INPI for France and the rest of the World) and <a href="http://www.scilab-enterprises.com/" target="_blank" class="ext" style="color:#FFFFFF;">Scilab Enterprises</a><span class="ext"></span> is granted exclusive rights for Scilab Trademark.</p>
<h3 style="margin:3px 0px 0px 0px;">Copyright © IIT Bombay</h3></div>
	</body>
</html>
