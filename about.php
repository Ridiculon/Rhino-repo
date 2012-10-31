<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
} 
?>
<head>
<title>Rhino Launch</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>
	<div class="wrapper">
		<?php
		//if the login session does not exist therefore meaning the user is not logged in
		if(strcmp(@$_SESSION['valid_user'],"") == 0){
		?>
		<div id="header">
			<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
		</div>

		<div id="content">
			<div class="tab-header" style="top:20px; font-size:25px;">
				Would you kindly?
			</div>
			<div id="preferred-contest" style="top: 55px; height: 300px;">
				<p class=\"error\" style=\"font-size: 40px\">You need to be logged in to use this feature!</p>
				<form action="./login.php" method="post">
					<div id="othbord">
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
								<td colspan="2" align="center"><input type="submit" name="submit" value="Login" /></td>
							</tr>
							<tr>
								<td align="center" colspan="2"><a href="register.php">Register</a> | <a href="forgot.php">Forgot Pass</a></td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		</div>
		<div id="push"></div>
		<?php
		}else{
			//otherwise continue the page
			//this is out update script which should be used in each page to update the users online time
			$time = date('U')+50;
			@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
			mysql_select_db('rhino_launch');
			$update = mysql_query("UPDATE `user` SET `online` = '".$time."' WHERE `User_id` = '".$_SESSION['valid_user']."'");
			?>
			<!-- Actual Page content goes here -->
		<div id="header">
			<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
			<?php
				include('header.php');
			?>
		</div>

		<div id="content">

			<div id="splash">
				<div style="position: absolute; left: 50%; width: 45%; top: 0%;">
					</br>
					<h3 style="color:#FFFFFF"> What is this about? </h3>
					</br>
					<p> RhinoLaunch pits filmmakers against each other in competition as they work to create quality video advertisements for businesses in their area. 
					Businesses receive a multitude of affordable advertisements that have been voted on by the very people they are looking to attract to their business,
					while winning filmmakers receive a cash prize and recognition for their work. RhinoLaunch was founded in 2010 at San Antonio's first 3 Day Startup Event 
					and all six members of our team are students at Trinity University. </p>
				</div>
				
				<div style="position: absolute; left: 0%; width: 50%; top: 0%">
					</br>
					<img src="images/rhinoteam.jpg" alt="rhinoteam" style="width: 80%"/>
				</div>
				
			</div>

			<!-- <div id="preferred-contest">
					</br>
					<h3 style="color:#FFFFFF"> FAQ </h3>
					</br>
					<p>"Even now, though our victorious armies are surrounding Helium, the people of Zodanga are voicing their displeasure, 
					for the war is not a popular one, since it is not based on right or justice. Our forces took advantage of the absence of 
					the principal fleet of Helium on their search for the princess, and so we have been able easily to reduce the city to a sorry plight.
					It is said she will fall within the next few passages of the further moon."</p>

			</div> -->
		</div>
		<div id="push"></div>
		<?php
			//make sure you close the check if their online
			}
		?>
	</div>

	<?php
		include('footer.php');
	?>

</body>
</html>