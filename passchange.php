<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
?>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>
<html>
<head>
<title>Rhino Launch -- Password Change</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css"/>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
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
		<?php
			include('header.php');?>
		
		<div id="content" style="height: 455px">
		
			<div id="splash">
			
			<?php
				$pass = $_POST['curpass'];
				$newpass = $_POST['newpass'];
				$newpassconf = $_POST['newpassconf'];
				
				//echo 'lolwtf '.$pass.'  '.$newpass.'  '.$newpassconf;
				

				$newpass2 = addslashes(trim($newpass));
				
				@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
				mysql_select_db('rhino_launch');
				$query = "select Psswrd from user where User_id = ".$_SESSION['valid_user'];
				$result = mysql_query($query);
				$row = mysql_fetch_array($result);
				
				if(strlen($newpass) < 5 || strlen($newpass) > 40){
					//if it is display error message
					echo "<p>Your <b>Password</b> must be between 5 and 40 characters long!</p>";
				}else{
					//else continue checking
					//check if the password and confirm password match
					if($newpass != $newpassconf){
						//if not display error message
						echo "<p>The <b>Password</b> you supplied did not match the confirmation password!</p>";
					}
					else{
						
						if($pass != $row['Psswrd']){
							echo  "<p>You did not input your old password correctly</p>";
						}
						else
						{
							$query = "update user SET Psswrd = '".$newpass2."' where User_id = ".$_SESSION['valid_user'];
							$result = mysql_query($query);
							if($result){
								echo "<p>The password change was successful</p>";
							}
							else
								echo "<p>There was a problem with the database. Please try again later.</p>";
						
						}
						
					}
				}
			
				
			
					
				
			?>
			</div>
			

		
		</div>
		<div class="push"></div>
		<?php
			//make sure you close the check if their online
			}
		?>
</div>

<?php
	include('footer.php');
?>

</body>