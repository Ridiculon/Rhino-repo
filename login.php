<?php
//allow sessions to be passed so we can see if the user is logged in
session_start();
ob_start();
//connect to the database so we can check, edit, or insert data to our users table
$con = mysql_connect('localhost', 'userbasic', 'user8asic') or die(mysql_error());
$db = mysql_select_db('rhino_launch', $con) or die(mysql_error());
//include out functions file giving us access to the protect() function made earlier
include "./functions.php";
?>

<link type="text/css" href="jquery/css/rhinostyle/jquery-ui-1.8.19.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="jquery/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-ui-1.8.19.custom.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(function() {
		$( "#dialog" ).dialog();
	});
</script>

<html xmlns:fb="http://ogp.me/ns/fb#">
	<head>
		<title>Rhino Launch</title>
		<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
	</head>
		<body>
		<div id="fb-root"></div>
		
		<script>
		window.fbAsyncInit = function() {
			FB.init({
			  appId      : '380309888647642', // App ID
			  status     : true, // check login status
			  cookie     : true, // enable cookies to allow the server to access the session
			  oauth      : true, // enable OAuth 2.0
			  xfbml      : true  // parse XFBML
			});
			
			  FB.getLoginStatus(function(response) {
				  if (response.status === 'connected') {
					// the user is logged in and has authenticated your
					// app, and response.authResponse supplies
					// the user's ID, a valid access token, a signed
					// request, and the time the access token 
					// and signed request each expire
					var uid = response.authResponse.userID;
					var accessToken = response.authResponse.accessToken;
					
					//get rhinolaunch user id using uid
					//get result using ajax
					//redirect to profilepage
					self.location = "http://rhinolaunch.com/facebook_login.php?uid="+uid;
				  } else if (response.status === 'not_authorized') {
					// the user is logged in to Facebook, 
					// but has not authenticated your app
					//document.getElementById("fb-div-reg").innerHTML = "";
			
					//document.getElementById("fb-div-reg").style.height = "0";
					self.location = "http://rhinolaunch.com/register.php";
				  } else {
					// the user isn't logged in to Facebook.
					//document.getElementById("fb-div-auth").innerHTML = "";
					
					//document.getElementById("fb-div-auth").style.height = "0";
				  }
			  });
		};
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=380309888647642";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		
		function login() {
			FB.login(function(response) {
				if (response.authResponse) {
					var uid = response.authResponse.userID;
					var accessToken = response.authResponse.accessToken;

					self.location = "http://rhinolaunch.com/facebook_login.php?uid="+uid;
				} else {
					// cancelled
				}
			});
		}
		
		/*
		  // Load the SDK's source Asynchronously
		(function(d){
			var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement('script'); js.id = id; js.async = true;
			js.src = "//connect.facebook.net/en_US/all.js";
			ref.parentNode.insertBefore(js, ref);
		}(document));
		*/
		
		function show_alert(msg)
		{
		   alert(msg);
		}
		</script>
		
			<div class="wrapper">
				<div id="header">
					<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
				</div>
				
				<div id="content">
					<div id="splash" style="height: 350px">
						<?php
						//If the user has submitted the form
						if($_POST['submit']){
							//protect the posted value then store them to variables
							$username = protect($_POST['username']);
							$password = protect($_POST['password']);
							//Check if the username or password boxes were not filled in
							if(!$username || !$password){
								//if not display an error message
								echo "<div id=\"dialog\" title=\"Error\">";
								echo "<p>You need to fill in a <b>Username</b> and a <b>Password</b>!</p>";
								echo "</div>";
							}else{
								//if the were continue checking
								//select all rows from the table where the username matches the one entered by the user
								$res = mysql_query("SELECT * FROM `user` WHERE `Uname` = '".$username."'");
								$num = mysql_num_rows($res);
								//check if there was not a match
								if($num == 0){
									//if not display an error message
									echo "<div id=\"dialog\" title=\"Error\">";
									echo "<p>The <b>Username</b> you supplied does not exist!</p>";
									echo "</div>";
								}else{
									//if there was a match continue checking
									//select all rows where the username and password match the ones submitted by the user
									$res = mysql_query("SELECT * FROM `user` WHERE `Uname` = '".$username."' AND `Psswrd` = '".$password."'");
									$num = mysql_num_rows($res);
									//check if there was not a match
									if($num == 0){
										//if not display error message
										echo "<div id=\"dialog\" title=\"Error\">";
										echo "<p>The <b>Password</b> you supplied does not match the one for that username!</p>";
										echo "</div>";
									}else{
										//if there was continue checking
										//split all fields fom the correct row into an associative array
										$row = mysql_fetch_assoc($res);
										//check to see if the user has not activated their account yet
										if($row['active'] != 1){
											//if not display error message
											echo "<div id=\"dialog\" title=\"Error\">";
											echo "<p>You have not yet <b>Activated</b> your account!</p>";
											echo "</div>";
										}else{
											//if they have log them in
											//set the login session storing there id - we use this to see if they are logged in or not
											$_SESSION['valid_user'] = $row['User_id'];
											//show message
											echo "<p class=\"error\">You have successfully logged in!</p>";
											//update the online field to 50 seconds into the future
											$time = date('U')+50;
											mysql_query("UPDATE `user` SET `online` = '".$time."' WHERE `User_id` = '".$_SESSION['valid_user']."'");
											//redirect them to the said individual's main page
											header('Location: ./profile.php?id='.htmlspecialchars(stripslashes($row['User_id'])).'');
										}
									}
								}
							}
						}
						?>
						<div style="position: absolute; width: 100%; height:60%; top:0px;  background-image: url('images/gray_box/Horizontal_solid_bold.jpg'); background-position: center bottom; background-repeat: repeat-x; background-size: 800px 5px">
							<form action="./login.php" method="post">
								<div id="othbord" style="position: absolute; width: 40%; left: 30%; top: 5%">
									<table class="auth" cellpadding="2" cellspacing="0" border="0">
										<tr>
											<td>Username:</td>
											<td><input type="text" name="username" /></td>
										</tr>
										<tr>
											<td>Password:</td>
											<td><input type="password" name="password" /></td>
										</tr>
										<tr>
											<td></br></td>
										</tr>
										<tr>
											<td colspan="2" align="center"><input type="submit" name="submit" value="Login" /></td>
										</tr>
										<tr>
											<td></br></td>
										</tr>
										<tr>
											<td align="center" colspan="2"><a href="http://rhinolaunch.com/register.php">Register</a> | <a href="http://rhinolaunch.com/forgot.php">Forgot Password?</a></td>
										</tr>
									</table>
								</div>
							</form>
						</div>
						
						<div id="fb-div" style="position: absolute; width: 100%; height:30%; top:70%;">
							<form action="JavaScript:login()">	
								<input type="image" src="images/facebook_signin_normal.png" onmousedown="this.src='images/facebook_signin_pressed.png'" onmouseup="this.src='images/facebook_signin_normal.png'">
							</form>
						</div>

					</div>
				</div>
			<div class="push"></div>
		</div>
		<?php
			include('footer.php');
		?>
	</body>
</html>
<?
ob_end_flush();
?>
