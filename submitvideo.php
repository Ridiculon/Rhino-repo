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
		
		<div id="content" style="height: 455px">
		
			<div id="splash">
			
			<?php
				$contestid = $_GET['id'];
			
				if(!$contestid)
				{
					echo '<p style="text-align:center">This is not a proper contest.</p>';
				}
				else
				{
					$contestid = addslashes(trim($contestid));
					
				
			
				echo '<form action="inputvideo.php?id='.$contestid.'" method=post>';
			?>
				<div style="width: 100%; height: 65%; position: absolute; top: 5%; background-image: url(images/gray_box/Vertical_dotted.png); background-position: top center; background-repeat: repeat-y">
					<div style="width: 100%; height: 25%; position: absolute; top:0%;">
					<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
						Video Title:
					</div>
		
					<div style="text-align:left; width:49%; position: absolute; left:52%; top:5%">
						<input type="text" name="title" size="20" maxlength="40">
					</div>
					</div>
		
					<div style="width: 100%; height: 25%; position: absolute; top:25%;">
					<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
						Description:
					</div>
		
					<div style="text-align:left; width:49%; position: absolute; left:52%; top:5%">
						<input type="text" name="description" size="20" maxlength="150">
					</div>
					</div>
			
					<div style="width: 100%; height: 25%; position: absolute; top:50%;">
					<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%; ">
						Link to youtube video:
					</div>
		
					<div style="text-align:left; width:49%; position: absolute; left:52%; top:5%">
						<input type="text" name="video" size="20" maxlength="150">
					</div>
					</div>
					
				</div>
				
				<div style="text-align: center; position: absolute; top: 75%; width: 100%">
					<input type="checkbox" name="agree" value="Yes"/> I am over 18 years old and agree to the Terms & Conditions <br/>
				</div>
				
				<div style="text-align:center; position: absolute; top: 370px; width: 100%">
					<input type="submit" value="Submit">
				</div>
				</form>
					
			<?php
					
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
</html>