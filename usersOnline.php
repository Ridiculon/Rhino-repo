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
	</head>
	<body>
		<div class="wrapper">
			<div id="header">
				<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
			</div>

			<div id="content">
				<div class="tab-header" style="top:20px; font-size:25px;">
					Would you kindly?
				</div>
				<div id="preferred-contest" style="top: 55px; height: 300px;">
					<?php
					//if the login session does not exist therefore meaning the user is not logged in
					if(strcmp(@$_SESSION['valid_user'],"") == 0){
						//display and error message
						echo "<p class=\"error\" style=\"font-size: 40px\">You need to be logged in to use this feature!</p>";
					?>
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
					<?php
					}else{
						//otherwise continue the page
						//this is out update script which should be used in each page to update the users online time
						$time = date('U')+50;
						$update = mysql_query("UPDATE `user` SET `online` = '".$time."' WHERE `User_id` = '".$_SESSION['valid_user']."'");
						?>
						<table id="register" cellpadding="2" cellspacing="0" border="0" width="100%">
							<tr>
								<td><b>Users Online:</b></td>
								<td>
								<?php
								//select all rows where there online time is more than the current time
								$res = mysql_query("SELECT * FROM `user` WHERE `online` > '".date('U')."'");
								//loop for each row
								while($row = mysql_fetch_assoc($res)){
									//echo  each username found to be online with a dash to split them
									echo $row['Uname']." - ";
								}
								?>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center"><a href="logout.php">Logout</a></td>
							</tr>
						</table>
						<?php
					//make sure you close the check if their online
					}
					?>
				</div>
			</div>
			<div id="push"></div>
		</div>
		<?php
			include('footer.php');
		?>
	</body>
</html>