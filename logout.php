<?php
//allow sessions to be passed so we can see if the user is logged in
session_start();
//connect to the database so we can check, edit, or insert data to our users table
$con = mysql_connect('localhost', 'userbasic', 'user8asic') or die(mysql_error());
$db = mysql_select_db('rhino_launch', $con) or die(mysql_error());
//include out functions file giving us access to the protect() function made earlier
include "./functions.php";
?>
<html>
	<head>
		<title>Rhino Launch</title>
		<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
	</head>
		<body>
			<div class="wrapper">
				<div id="header">
					<a href="http://rhinolaunch.com/"><img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/></a>
				</div>

				<div id="content">
					<div id="splash">
						<?php
						//check if the login session does no exist
						if(strcmp(@$_SESSION['valid_user'],"") == 0){
							//if it doesn't display an error message
							echo "<p class=\"error\" style=\"font-size: 40px\">You need to be logged in to log out!</p>";
						}else{
							//if it does continue checking
							//update to set this users online field to the current time
							mysql_query("UPDATE `user` SET `online` = '".date('U')."' WHERE `User_id` = '".$_SESSION['valid_user']."'");
							//destroy all sessions canceling the login session
							session_destroy();
							//display success message
							echo "<p class=\"error\" style=\"font-size: 40px\">You have successfully logged out!</p>";
						}
						?>
					</div>
				</div>
				<div class="push"></div>
			</div>
			<?php
				include('footer.php');
			?>
		</body>
</html>


