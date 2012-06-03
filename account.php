<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
include "./functions.php";
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>

<script type="text/javascript">
	
	var expand;
	var id;
	
	//AJAX test
	function loadurl(dest, exp, i, args) { 
	expand = exp;
	id = i;
	try { 
        // Moz supports XMLHttpRequest. IE uses ActiveX. 
        // browser detction is bad. object detection works for any browser 
        xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} catch (e) { 
        // browser doesn't support ajax. handle however you want 
	} 
 
	// the xmlhttp object triggers an event everytime the status changes 
	// triggered() function handles the events 
	xmlhttp.onreadystatechange = triggered; 
 
	// open takes in the HTTP method and url. 
	xmlhttp.open("GET", dest+"?i="+i+"&args="+args); 


	// send the request. if this is a POST request we would have 
	// sent post variables: send("name=aleem&gender=male) 
	// Moz is fine with just send(); but 
	// IE expects a value here, hence we do send(null); 
	//xmlhttp.send("i="+i+"&args="+args); 
	xmlhttp.send(null);
	} 
 
	function triggered() { 
	// if the readyState code is 4 (Completed) 
	// and http status is 200 (OK) we go ahead and get the responseText 
	// other readyState codes: 
	// 0=Uninitialised 1=Loading 2=Loaded 3=Interactive 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
        // xmlhttp.responseText object contains the response. 
		//div = document.getElementById(id);
		tabs = document.getElementById('tabs');
		if(expand == 1){
			tabs.style.height = 450+'px';
			//div.style.height = 340+'px';
		}
		else
		{
			tabs.style.height = 300+'px';
			//div.style.height = 130+'px';
		}
        document.getElementById('tabs').innerHTML = xmlhttp.responseText; 
		
	} 

	} 
</script>


<html>
<head>
<title>Rhino Launch -- Account</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
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
			include('header.php');
		?>
		<div id="content">
			<div class="tab-header" style="top:20px; font-size:25px;">
				Account Settings
			</div>
			<div id="preferred-contest" style="top: 55px; height: 250px">
				<?php
					echo '<a href="./profile.php?id='.htmlspecialchars(stripslashes($_SESSION['valid_user'])).'">Visit Your Profile?</a>';
				?>
				<form action="passchange.php" method=post style="position: absolute; top: 20px; width: 100%; height: 200px">
					
						Password Change:
						
						<div style="position: absolute; top: 20px; height: 150px; width: 100%; background-image: url(images/gray_box/Vertical_dotted.png); background-position: top center; background-repeat: repeat-y">
							<div style="width: 100%; height: 50px; position: absolute; top:0%;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								Current Password:
							</div>
			
							<div style="text-align:left; width:49%; position: absolute; left:52%; top:5%">
								<input type="password" name="curpass" size="20" maxlength="40">
							</div>
							</div>
			
							<div style="width: 100%; height: 50px; position: absolute; top:50px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%;">
								New Password:
							</div>
				
							<div style="text-align:left; width:49%; position: absolute; left:52%; top:5%">
								<input type="password" name="newpass" size="20" maxlength="150">
							</div>
							</div>
					
							<div style="width: 100%; height: 50px; position: absolute; top:100px;">
							<div style="text-align:right; width: 49%; height: 90%; position: absolute; left:0%; top:5%; ">
								Confirm New Password:
							</div>
				
							<div style="text-align:left; width:49%; position: absolute; left:52%; top:5%">
								<input type="password" name="newpassconf" size="20" maxlength="150">
							</div>
							</div>
						</div>
						<div style="position: absolute; top: 170px; width: 100%">
							<input type="submit" value="Submit"  />
						</div>
				</form>
			</div>

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