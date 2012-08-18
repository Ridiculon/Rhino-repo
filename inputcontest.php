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
				
				$user = $_SESSION['valid_user'];
				$name = $_POST['name'];
				$summary = $_POST['summary'];
				$start_date = $_POST['start_date'];
				$category = $_POST['category'];
				$biz_name = $_POST['biz_name'];
				$biz_summary = $_POST['biz_summary'];
				$motto = $_POST['motto'];
				$phone = $_POST['phone'];
				$email = $_POST['email'];
				$length = $_POST['length'];
				$location  = $_POST['location'];
				$deals = $_POST['deals'];
				
					$name = addslashes(trim($name));
					$summary = addslashes(trim($summary));
					$start_date = addslashes(trim($start_date));
					$category = addslashes(trim($category));
					$biz_name = addslashes(trim($biz_name));
					$biz_summary = addslashes(trim($biz_summary));
					$motto = addslashes(trim($motto));
					$phone = addslashes(trim($phone));
					$email = addslashes(trim($email));
					$length = addslashes(trim($length));
					$location = addslashes(trim($location));
					$deals = addslashes(trim($deals));
					
					@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
					
					if(isset($_POST['agree']) &&  $_POST['agree'] == 'Yes'){
					
						mysql_select_db('rhino_launch');
							
						$query = "INSERT INTO proposed_contests (Name, Summary, StartDate, Category, BizSummary, BizMoto, PhoneNumber, Email, Length, SpecialDeal, BizName, Location) VALUES ('".$name."','".$summary."','".$start_date."','".$category."','".$biz_summary."', '".$motto."', '".$phone."', '".$email."', '".$length."', '".$deals."', '".$biz_name."', '".$location."')";
						$result = mysql_query($query);
						
						if($result){
							echo '<p style="text-align:center">Congratulations. You successfuly submitted this contest proposal. We will contact you shortly </p>';
						}
						else{
							echo '<p style="text-align:center">There was an error. Please try again later.</p>';
						}
						
						
						
					}
					else{
						echo '<p style="text-align:center">You need to agree to the Terms and Conditions</p>';
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