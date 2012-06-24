<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
} 
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
	//xmlhttp.open("POST", dest, true);
	
	/*
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", 2);
	xmlhttp.setRequestHeader("Connection", "close");
	*/
	
	/*xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
		if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
        // xmlhttp.responseText object contains the response. 
			//div = document.getElementById(id);
			tabs = document.getElementById('tabs');
			if(expand == 1){
			tabs.style.height = 340+'px';
			//div.style.height = 340+'px';
			}
			else
			{
			tabs.style.height = 130+'px';
			//div.style.height = 130+'px';
			}
			document.getElementById("tabs").innerHTML = xmlhttp.responseText; 
		}
	} */
	

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
			tabs.style.height = 750+'px';
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
<title>Rhino Launch -- Profiles</title>
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
			<img src="images/Full_tab_header.png" style="position: absolute; width: 100%; height: 35px; top:20px; left:0px;">
			<div id="preferred-contest" style="top: 55px">
						<?php
							@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');

								if(!$db)
								{
									echo '<p style="text-align:center">Error: could not connect to the database.</p>';
								}
								else
								{
									mysql_select_db('rhino_launch');

									$query = "select Uname, Name, RPoints, Picture, User_id from user where User_id = 126";
									$result = mysql_query($query);
									$row = mysql_fetch_array($result);

									$picture = $row['Picture'];
									$rpoints = $row['RPoints'];

									echo '<div style="height:100%; width:150px; position: absolute; left:0px; top: 0px;">';
									echo '<img src="images/Sitting_Rhino_no_background.png" class="no-border">';
									echo '</div>';
									echo '<div style="height:20px; position: absolute; left:160px; top: 20px; width: 69%;">';
									echo '<strong>User of the Week: <a href="./profile.php?id='.htmlspecialchars(stripslashes($row['User_id'])).'">';
									echo htmlspecialchars(stripslashes($row['Uname'])).'</a></strong>';
									echo '</div>';
									echo '<div style="position: absolute; text-align: left; top: 50px; left:200px; width:69%;">';
									echo 'Name: '.substr(htmlspecialchars(stripslashes($row['Name'])), 0, 500);
									echo '</div>';

									$query = "select Summary, Name, EndDate, contest.Contest_id, video.Contest_id, PrizeR, User_id from contest, video where User_id = '126' AND contest.Contest_id = video.Contest_id order by EndDate desc";
									$result = mysql_query($query);
									$num_results = mysql_num_rows($result);

									echo '<div style="position: absolute; text-align: left; top: 70px; left:200px; width:69%;">';
									if($num_results > 0){
										$row = mysql_fetch_array($result);
										echo 'Recently entered the <a href="./contest.php?contestid='.htmlspecialchars(stripslashes($row['Contest_id'])).'">'.$row['Name'].'</a> contest.';
									}
									else{
										echo 'This user hasn\'t entered any contests';
									}
									echo '</div>';

									echo '<div style="position: absolute; top: 90px; right: 0%; width: 15%">';
									echo 'Rhino Points: '.$rpoints;
									echo '</div>';

								}
						?>
			</div>

			<div id="tabs" style="top: 75px; height: 300px">
				
				<div class="expandable-tab" id="1" style="top: 0px" >
					<div class="expandable-tab-header-exp"  onclick="loadurl('expand_tab_profile.php', 1, 1, 'RPoints-RegisterDate')">
						Top Users
					</div>
					
					
					<?php
						@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');

							if(!$db)
							{
								echo '<p style="text-align:center">Error: could not connect to the database.</p>';
							}
							else
							{
								mysql_select_db('rhino_launch');



								$query = "select User_id, Uname, Name, RPoints, Picture from user order by RPoints desc";
								$result = mysql_query($query);
								$num_results = mysql_num_rows($result);

								if($num_results > 0)
								{


									if($num_results > 5)
										$num_results = 5;


									for($i=0; $i < $num_results; $i++)
									{
											echo '<div class="expandable-tab-content" style="top:'.($i*105+35).'px">';
											$row = mysql_fetch_array($result);
											echo '<div style="height:100%; width:100px; position: absolute; left:0px;">';
											//Profile Pic here
											echo '<img src="images/Red_rhino_coin.png" class="no-border" style="position: absolute; top: 15%; left: 0%">';
											echo '</div>';
											echo '<div style="height:20px; position: absolute; left:15%; width: 70%;">';
											echo '<strong><a href="./profile.php?id='.htmlspecialchars(stripslashes($row['User_id'])).'">';
											echo htmlspecialchars(stripslashes($row['Uname'])).'</a></strong>';
											echo '</div>';
											echo '<div style="position: absolute; top: 20px; left:15%; width:70%;">';
											echo 'Name :'.substr(htmlspecialchars(stripslashes($row['Name'])), 0, 250);
											echo '</div>';
											echo '<div style="position: absolute; top: 60px; right: 0%; width: 15%">';
											echo 'Rhino Points: '.$row['RPoints'];
											echo '</div>';
											echo '</div>';
									}
								}
								else
									echo '<p style="text-align:center">No profiles at this time.</p></br>';


								echo '</div>';

								echo '<div class="expandable-tab" id="2" style="top: 160px" >';
								echo '<div class="expandable-tab-header-exp"  onclick="loadurl(\'expand_tab_profile.php\', 1, 2, \'RPoints-RegisterDate\')">';
								echo 'New Users';
								echo '</div>';

								$query = "select User_id, Uname, Name, RPoints, Picture from user order by RegisterDate desc";
								$result = mysql_query($query);
								$num_results = mysql_num_rows($result);

								if($num_results > 0)
								{


									if($num_results > 5)
										$num_results = 5;


									for($i=0; $i < $num_results; $i++)
									{
											echo '<div class="expandable-tab-content" style="top:'.($i*105+35).'px">';
											$row = mysql_fetch_array($result);
											echo '<div style="height:100%; width:100px; position: absolute; left:0px;">';
											//Profile Pic here
											echo '<img src="images/Red_rhino_coin.png" class="no-border" style="position: absolute; top: 15%; left: 0%">';
											echo '</div>';
											echo '<div style="height:20px; position: absolute; left:15%; width: 70%;">';
											echo '<strong><a href="./profile.php?id='.htmlspecialchars(stripslashes($row['User_id'])).'">';
											echo htmlspecialchars(stripslashes($row['Uname'])).'</a></strong>';
											echo '</div>';
											echo '<div style="position: absolute; top: 20px; left:15%; width:70%;">';
											echo 'Name :'.substr(htmlspecialchars(stripslashes($row['Name'])), 0, 250);
											echo '</div>';
											echo '<div style="position: absolute; top: 60px; right: 0%; width: 15%">';
											echo 'Rhino Points: '.$row['RPoints'];
											echo '</div>';
											echo '</div>';
									}
								}
								else
									echo '<p style="text-align:center">No profiles at this time.</p></br>';

								echo '</div>';


							}

					?>
						
			</div>

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