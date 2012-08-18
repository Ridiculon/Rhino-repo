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
				<a href="http://localhost/rhinolaunch/"><img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/></a>
			</div>

			<div id="content">
				<div class="tab-header" style="top:20px; font-size:25px;">
					Would you kindly?
				</div>
				<div id="preferred-contest" style="top: 55px; height: 300px;">
					<?php
					/*
					//Check to see if the forms submitted
					if(@$_POST['submit']){
						//if it is continue checks
						//store the posted /email to variable after protection
						$email = protect($_POST['email']);
						//check if the email box was not filled in
						if(!$email){
							//if it wasn't display error message
							echo "<p class=\"error\">You need to fill in your <b>E-mail</b> address!</p>";
						}else{
							//else continue checking
							//set the format to check the email against
							$checkemail = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
							//check if the email doesnt match the required format
							if(!preg_match($checkemail, $email)){
								//if not then display error message
								echo "<p class=\"error\"><b>E-mail</b> is not valid, must be name@server.tld!</p>";
							}else{
								//otherwise continue checking
								//select all rows from the database where the emails match
								$res = mysql_query("SELECT * FROM `user` WHERE `Email` = '".$email."'");
								$num = mysql_num_rows($res);
								//check if the number of row matched is equal to 0
								if($num == 0){
									//if it is display error message
									echo "<p class=\"error\">The <b>E-mail</b> you supplied does not exist in our database!</p>";
								}else{
									//otherwise complete forgot pass function
									//split the row into an associative array
									$row = mysql_fetch_assoc($res);
									//send email containing their password to their email address
									mail($email, 'Forgotten Password', "Here is your password: ".$row['Psswrd']."\n\nPlease try not to lose it again!", 'From: noreply@rhionolaunch.com');
									//display success message
									echo "<p><h5>An email has been sent to your email address containing your password!</h5></p>";
								}
							}
						}
					} else {?>
						<form id="register" style="top: 35px; position: relative;" action="forgot.php" method="post">
							<table id="register" cellpadding="2" cellspacing="0" border="0">
								<tr>
									<td>Email: </td>
									<td><input type="text" name="email" /></td>
								</tr>
								<tr>
									<td colspan="2" align="center"><input type="submit" name="submit" value="Send" /></td>
								</tr>
							</table>
						</form>
					<?php }*/ ?>
					We have not yet implemented this functionality. If you have problems with your password you should talk to one of the members of the RhinoLaunch team!
				</div>
			</div>
		</div>
		<?php
			include('footer.php');
		?>
	</body>
</html>