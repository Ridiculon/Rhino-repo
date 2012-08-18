<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
?>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>
<html>
<head>
<title>Rhino Launch -- Submit Video</title>
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
		
		<div id="content" style="height: 1100px">
		
			<div id="splash" style="height: 1100px">
			
				<form action="inputcontest.php" method=post>

					<div style="width: 100%; height: 950px; position: absolute; top: 20px; background-image: url(images/gray_box/Vertical_dotted.png); background-position: top center; background-repeat: repeat-y">
						<div style="width: 100%; height: 50px; position: absolute; top:0%;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Contest Name:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<input type="text" name="name" style="width: 300px" maxlength="50">
							</div>
						</div>
						
						<div style="width: 100%; height: 150px; position: absolute; top:50px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Contest Summary:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<textarea name= "summary" style="width: 300px; height:125px"></textarea>
							</div>
						</div>
						
						
						<div style="width: 100%; height: 50px; position: absolute; top:200px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Preferred Start Date:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<input type="text" name="start_date" style="width: 300px" maxlength="50">
							</div>
						</div>
						
						<div style="width: 100%; height: 50px; position: absolute; top:250px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Category:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<input type="text" name="category" style="width: 300px" maxlength="50">
							</div>
						</div>
						
						<div style="width: 100%; height: 50px; position: absolute; top:300px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Name of Your Business:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<input type="text" name="biz_name" style="width: 300px" maxlength="50">
							</div>
						</div>
						
						<div style="width: 100%; height: 200px; position: absolute; top:350px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Summary of Your Business:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<textarea name="biz_summary" style="height:125px; width: 300px"></textarea>
							</div>
						</div>
						
						<div style="width: 100%; height: 150px; position: absolute; top:500px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Logo / Motto:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<textarea name="motto" style="height:125px; width: 300px"></textarea>
							</div>
						</div>
						
						<div style="width: 100%; height: 50px; position: absolute; top:650px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Phone Number:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<input type="text" name="phone" style="width: 300px" maxlength="30">
							</div>
						</div>

						<div style="width: 100%; height: 50px; position: absolute; top:700px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								E-mail address:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<input type="text" name="email" style="width: 300px" maxlength="40">
							</div>
						</div>
						
						<div style="width: 100%; height: 50px; position: absolute; top:750px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Preferred Length:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<input type="text" name="length" style="width: 300px" maxlength="30">
							</div>
						</div>
						
						<div style="width: 100%; height: 50px; position: absolute; top:800px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Location Availability:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<input type="text" name="location" style="width: 300px" maxlength="40">
							</div>
						</div>
						
						<div style="width: 100%; height: 150px; position: absolute; top:850px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Special Deals:
							</div>
						
							<div style="text-align:left; width:49%; position: absolute; left:51%; top:5%">
								<textarea name="deals" style="height:125px; width: 300px"></textarea>
							</div>
						</div>
					</div>
					
						<div style="text-align: center; position: absolute; top: 1020px; width: 100%">
							<input type="checkbox" name="agree" value="Yes"/> I have read and agree to the Terms & Conditions <br/>
						</div>

						<div style="text-align:center; position: absolute; top: 1050px; width: 95%">
							<input type="submit" value="Submit">
						</div>
					</form>
			
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
</html>