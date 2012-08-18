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
				<a href="./index.php"><img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/></a>
			</div>

			<div id="content">
				<div id="splash">
					<?php
					//echo md5('other');
					//get the code that is being checked and protect it before assigning it to a variable
					@$code = protect($_GET['code']);
					//$code = trim($_GET['code']);
					//echo $code.'</br>';
					//echo urlencode($code).'</br>';
					//check if there was no code found
					if(!$code){
						//if not display error message
						echo "<p class=\"error\" style=\"font-size: 40px\"><b>Unfortunately you encountered an error!</b></p>";
					}else{
						//other wise continue the check
						//select all the rows where the accounts are not active
						$res = mysql_query("SELECT * FROM user WHERE active = '0'");
						//loop through this script for each row found not active
						//$found = false;
						while($row = mysql_fetch_assoc($res)){
							//check if the code from the row in the database matches the one from the user
							$check = md5($row['Uname']).$row['RegisterDate'];
							//echo $check.'</br>';
							if(strcmp($code, $check) == 0){
								//if it does then activate there account and display success message
								$res1 = mysql_query("UPDATE `user` SET `active` = '1' WHERE `User_id` = '".$row['User_id']."'");
								echo "<p><h5>You have successfully activated your account!</h5></p>";
							//	$found = true;
							}
						}
						//if(!$found) {
						//	echo "<p class=\"error\" style=\"font-size: 40px\"><b>Unfortunately, this is not the code you are looking for.</b></p>";
						//}
					}
					?>
				</div>
			</div>
		</div>
		<?php
			include('footer.php');
		?>
	</body>
</html>
