<?php
session_start(); 
?>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>
<link type="text/css" href="jquery/css/rhinostyle/jquery-ui-1.8.19.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="jquery/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-ui-1.8.24.custom.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<script type="text/javascript" src="jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="jquery/development-bundle/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="jquery/development-bundle/ui/jquery.ui.progressbar.js"></script>
<script type="text/javascript">
	
	var expand;
	var id;
	var u;
	
	//AJAX test
	function loadurl(dest, exp, i, n, user, q) {
	//list of queries:
	var queries = new Array();
	queries[0] = "select Summary, Name, EndDate, Contest_id, PrizeR, User_id, ContestID from contest, video where User_id = '"+user+"' AND Contest_id = ContestID order by EndDate desc";
	queries[0] = encodeURIComponent(queries[0]);
	
	var query = q.replace("#", ")");
	u = user;
	expand = exp;
	id = i;
	var s ="i="+i+"&n="+n+"&user="+user+query;
	/*for(var k = 0; k < n; k++){
		s = "&query"+k+"="+queries[k];
	}*/
	
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
	xmlhttp.open("GET", dest+"?"+s); 
	//xmlhttp.open("POST", dest, true);
	


	// send the request. if this is a POST request we would have 
	// sent post variables: send("name=aleem&gender=male) 
	// Moz is fine with just send(); but 
	// IE expects a value here, hence we do send(null); 
	//xmlhttp.send("i="+i+"&args="+args); 

		/*http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.setRequestHeader("Content-length", s.length);
		http.setRequestHeader("Connection", "close");*/
		xmlhttp.send(null);
	} 
 
	function triggered() { 
		// if the readyState code is 4 (Completed) 
		// and http status is 200 (OK) we go ahead and get the responseText 
		// other readyState codes: 
		// 0=Uninitialised 1=Loading 2=Loaded 3=Interactive 
		if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 

			tabs = document.getElementById('tabs');
			if(expand == 1){
				tabs.style.height = 380+'px';
				//div.style.height = 340+'px';
			}
			else
			{
				tabs.style.height = 140+'px';
				//div.style.height = 130+'px';
			}
			document.getElementById('tabs').innerHTML = xmlhttp.responseText; 
			document.getElementById('header1').innerHTML = "Recent Contests Entered by "+u;
			
		} 

	} 
	
/*	$(function() {
		$( "#progressbar" ).progressbar({
			value: 37
		});
	});*/
</script>


<html>
<head>
<title>Rhino Launch</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>

<div class="wrapper">
	<?php
	//if the login session does not exist therefore meaning the user is not logged in
	if(strcmp(@$_SESSION['valid_user'],"") == 0){
		//display and error message
		//echo "<p class=\"error\" style=\"font-size: 40px\">You need to be logged in to use this feature!</p>";
	?>
	<div id="header">
		<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
	</div>

	<div id="content">
		<div class="tab-header" style="top:20px; font-size:25px;">
			Would you kindly?
		</div>
		<div id="preferred-contest" style="top: 55px; height: 300px;">
			<p class="error" style="font-size: 40px">You need to be logged in to use this feature!</p>
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
			<img src="images/Full_tab_header.png" style="position: absolute; width: 100%; height: 35px; top:20px; left: 0px;">
			<div id="vidContainer" style="top: 55px; min-height: 250px">
				
				<?php
					
					$profileid = $_GET['id'];
					
					/*for($k = 0; k < 1; k++){
					s = "&query"+k+"="+queries[k];
					}*/
					//List of queries
					$queries = array();
					$queries[0] = "select Summary, Name, EndDate, contest.Contest_id, video.Contest_id, PrizeR, User_id, Icon from contest, video where User_id = '".$profileid."' AND contest.Contest_id = video.Contest_id order by EndDate desc";
					$q = "";
					
					for($i = 0; $i < count($queries); $i++){
						$temp = "&query".$i."=".urlencode($queries[$i]);
						$temp = str_replace(")", "#", $temp);
						$q = $q.$temp;
					}
					

					
					
					if(!$profileid)
					{		
						echo '<p style="text-align:center">This is not a proper profile id.</p>';
					}
					else
					{
						$profileid = addslashes(trim($profileid));
							
						$con = mysql_connect('localhost', 'userbasic', 'user8asic') or die(mysql_error());
						$db = mysql_select_db('rhino_launch', $con) or die(mysql_error());
						
						if(!$db)
						{
							echo '<p style="text-align:center">Error: could not connect to the database.</p>';
						}
						else
						{
							$query = "SELECT `Uname`, `Name`, `Birthday`, `Picture`, `Email`, `RPoints` FROM `user` WHERE `User_id` = '".$profileid."'";
							$result = mysql_query($query);
							$num_results = mysql_num_rows($result);
							
							if($num_results)
							{
								$row = mysql_fetch_array($result);
								
								$uname = $row['Uname'];
								$picture = $row['Picture'];
								$rpoints = $row['RPoints'];
								
								echo '<div style="position: absolute; width:100%; height: 100px; background-image: url(images/gray_box/Horizontal_solid_bold.jpg); background-position: bottom right; background-repeat: repeat-x">';
								if($picture == NULL)
									echo '<img src="images/Rhino_blank_avatar.jpg" style="position: absolute; width: 67px; top: 10px; left: 300px; border-color: #262626; border-style: solid; border-width: 5px;">';
								else
									echo '<img src="images/users/'.$picture.'.jpg" style="position: absolute; width: 67px; top: 10px; left: 300px; border-color: #262626; border-style: solid; border-width: 5px;">';
									
								echo '<div style="position: absolute; left: 450px; top: 10px;"><h5>'.$uname.'</h5></div>';
								
								
								
								echo '<script>';
								echo '	$(function() {';
								echo '		$( "#progressbar" ).progressbar({';
								echo '			value:'.$rpoints/100;
								echo '		});';
								echo '	});';
								echo '</script>';
								
								
								
								
								echo '<div style="position: absolute; right: 0px; width: 30%; height: 100%; background-image: url(images/gray_box/T_intersection.jpg), url(images/gray_box/Vertical_solid_bold.png); background-position: bottom left, top left; background-repeat: no-repeat, repeat-y">';
								echo '<img src="images/Trophy.jpg" style="position: absolute; left: 6px; top: 10px">';
								echo '<div style="position: absolute; left: 40px; top: 10px;"><h4>Rhino Points:</h4></div>';
								echo '<div style="position: absolute; left: 40px; top: 30px;">'.$rpoints.'</div>';
								echo '<div style="position: absolute; left: 6px; top: 55px; width: 80%; height: 30px"><div style="height: 30px;"id="progressbar"></div></div>';
								echo '</div>';
								echo '</div>';
								
								//Number of videos submitted
								$query = "select Video_id from video where User_id = '".$profileid."'";
								$result = mysql_query($query);
								$num_results = mysql_num_rows($result);
								
								echo '<div style="position: absolute; right:50%; width: 50%; height:125px; top: 125px; background-image: url(images/gray_box/Vertical_dotted.png); background-position: top right; background-repeat: repeat-y">';
								echo '<div style="position: absolute; right: 25%;top: 20px;">Videos submitted:</br>'.$num_results.'</div>';
								echo '</div>';
								
								
								//Number of medals won
								$query = "select Video_id from video where User_id= '".$profileid."' AND (Medal = 1 OR Medal = 2 OR Medal = 3)";
								$result = mysql_query($query);
								$num_results = mysql_num_rows($result);
								
								echo '<div style="position: absolute; left:50%; width: 50%; height:150px; top: 125px;">';
								echo '<div style="position: absolute; left: 25%; top: 20px;">Contests Won:</br>'.$num_results.'</div>';				
								echo '</div>';
								
								
								
								echo '</div>'; //end of vidContainer
								
								//Recently entered contest tab
								echo '<div id="tabs" style="top: 75px; height: 140px">';
									echo '<div class="expandable-tab" id="1" style="top: 0px" >';

										
										$query = "select Summary, Name, EndDate, contest.Contest_id, video.Contest_id, PrizeR, User_id, Icon from contest, video where User_id = '".$profileid."' AND contest.Contest_id = video.Contest_id order by EndDate desc";
										$result = mysql_query($query);
										$num_results = mysql_num_rows($result);		
									
										if($num_results > 0)
										{
											echo '<div class="expandable-tab-header-exp" id="header1" onclick="loadurl(\'expand_tab_custom.php\', 1, 1, 1, \''.$uname.'\', \''.$q.'\')">';
											echo 'Recent Contests Entered by '.$uname;
											echo '</div>';
										
											if($num_results > 3)
												$num_results = 3;
											
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
											
										}
										else {
												echo '<div class="expandable-tab-header-exp" id="header1">';
												echo 'Recent Contests Entered by '.$uname;
												echo '</div>';
												echo '<div class="expandable-tab-content" style="top: 35px">';
												echo '<p>This user hasn\'t entered in any contests yet</p>';
												echo '</div>';
										}
										
									echo '</div>';
								echo '</div>';
							}
							else
								echo '<p style="text-align:center">Error: could not retrieve info from database</p>';
								
						}
					}
				
				?>
				
			
		</div>
		
		<div class="push"></div>
	</div>
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