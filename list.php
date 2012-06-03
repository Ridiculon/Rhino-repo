<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
} 
?>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>

<html>
<head>
<title>Rhino Launch</title>
</head>
<body>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />

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
			include('header.php');
		?>
		
		<div id="content">
			
		<?php	
			@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
			
			if(!$db)
			{	
				echo '<p style= "text-align: center"> Error: could not connect to the database. </p>';
			}
			else
			{		
	
						mysql_select_db('rhino_launch');
						$query = $_GET['query'];
						$result = mysql_query($query);
						$num_results = mysql_num_rows($result);
								
						if($num_results > 0)
						{
							echo '<div id="tabs" style="top: 20px; height: '.($num_results*105+35+30).'px">';
							echo '<div class="expandable-tab" id="1" style="top: 0px; height: '.($num_results*105+35+30).'px" >';
							echo '<div class="expandable-tab-header-exp" ></div>';
							
							for($i=0; $i < $num_results; $i++)
							{
										echo '<div class="expandable-tab-content" style="top:'.($i*105+35).'px">';
										$row = mysql_fetch_array($result);
										echo '<div style="height:100%; width:100px; position: absolute; left:0px;">';
										echo '<img src="images/thumb'.$row['Icon'].'.png" class="no-border">';
										echo '</div>';
										echo '<div style="height:20px; position: absolute; left:15%; width: 70%;">';
										echo '<strong><a href="./contest.php?contestid='.htmlspecialchars(stripslashes($row['Contest_id'])).'">';
										echo htmlspecialchars(stripslashes($row['Name'])).'</a></strong>';
										echo '</div>';
										echo '<div style="position: absolute; top: 20px; left:15%; width:70%;">';
										echo substr(htmlspecialchars(stripslashes($row['Summary'])), 0, 250);
										echo '</div>';
										echo '<div style="position: absolute; top: 15px; right: 0%; width: 15%">';
										echo 'Due Date: </br>'.htmlspecialchars(stripslashes($row['EndDate']));;
										echo '</div>';
										echo '<div style="position: absolute; top: 60px; right: 0%; width: 15%">';
										echo 'Rhino Points: '.$row['PrizeR'];
										echo '</div>';
										echo '</div>';
							}
							
							echo '<div class="expandable-tab-footer" style="top: '.($num_results*105+35).'px">';
							echo '</div>';
							
							echo '</div>';
						}
						else
							echo '<p style="text-align:center">No contests at this time.</p></br>';
							
						
				}
						
					
		?>
			
						

		</div>
		
		<div class="push"></div>
	<?php
		}
	?>
</div>

<?php
	include('footer.php');
?>

</body>
</html>