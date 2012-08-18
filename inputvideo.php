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
				$title = $_POST['title'];
				$description = $_POST['description'];
				$link = $_POST['video'];
			
				if(!$contestid)
				{
					echo '<p style="text-align:center">This is not a proper contest.</p>';
				}
				else
				{
					$contestid = addslashes(trim($contestid));
					$title = addslashes(trim($title));
					$description = addslashes(trim($description));
					$link = addslashes(trim($link));
					
					@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
					
					if(isset($_POST['agree']) &&  $_POST['agree'] == 'Yes'){
					
						mysql_select_db('rhino_launch');
						
						$query = "SELECT * FROM video WHERE User_id = ".$_SESSION['valid_user']." AND Contest_id = ".$contestid;
						$result = mysql_query($query);
						
						if(mysql_num_rows($result) < 4){
							$query = "INSERT INTO `video` (`Title`, `Link`, `Description`, `User_id`, `Contest_id`) VALUES ('".$title."','".$link."','".$description."','".$_SESSION['valid_user']."','".$contestid."')";
							$result = mysql_query($query);
							
							if($result){
								$query = "SELECT * FROM `video` WHERE `User_id` = ".$_SESSION['valid_user']." AND `Contest_id` = ".$contestid." ORDER BY `Date_Added` desc";
								$result = mysql_query($query);
								$num_results = mysql_num_rows($result);
								
								if($num_results)
								{	
									$row = mysql_fetch_array($result);
								
									echo '<p style="text-align:center">Congratulations. You successfuly submitted this video. </p>';
									echo '<a href="./video.php?videoid='.$row['Video_id'].'">You can look at it here</a>';
								}
								else
									echo '<p style="text-align:center">There was an error. Please try again later. </p>';
							}
							else{
								echo '<p style="text-align:center">There was an error. Please try again later. </p>';
							}
						}
						else
							echo '<p style="text-align:center">You have already submitted several videos to this contest</p>';
						
						
					}
					else{
						echo '<p style="text-align:center">You need to verify your age and agree to the Terms and Conditions</p>';
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
</html>