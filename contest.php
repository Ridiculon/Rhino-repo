<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
?>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<script type="text/javascript">

	var i;
	var s = 0;
	var num;
	
	function prev(query, num_slides){
		num = num_slides;
		i = query;
		if(s - 1 > -1){
			s = s - 1;
			
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
			xmlhttp.open("GET", "playlist.php?query="+i+"&s="+s); 
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
	}
	
	function next(query, num_slides){
		i = query;
		num = num_slides;
		if(s + 1 < num_slides){
			s = s + 1;
			
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
			xmlhttp.open("GET", "playlist.php?query="+i+"&s="+s); 
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
		
	}
	
	function triggered() { 
	// if the readyState code is 4 (Completed) 
	// and http status is 200 (OK) we go ahead and get the responseText 
	// other readyState codes: 
	// 0=Uninitialised 1=Loading 2=Loaded 3=Interactive 
		if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 

			document.getElementById('slide').innerHTML = xmlhttp.responseText;
			
			if(s == 0)
				document.getElementById('prev_button').src = "images/playlist/previous_vid_button_disabled.jpg";
			else
				document.getElementById('prev_button').src = "images/playlist/previous_vid_button_enabled.jpg";

			if(s+1 >= num)
				document.getElementById('next_button').src = "images/playlist/next_vid_button_disabled.jpg";
			else
				document.getElementById('next_button').src = "images/playlist/next_vid_button_enabled.jpg";
			
			
		} 

	} 

</script>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>
<html>
<head>
<title>Rhino Launch -- Contest</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css"/>
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
		
		<div id="content" style="height: 655px">
			
			<?php
				$contestid = $_GET['contestid'];
			
				if(!$contestid)
				{
					echo '<p style="text-align:center">This is not a proper contest.</p>';
				}
				else
				{
					$contestid = addslashes(trim($contestid));
					
					@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
					
					if(!$db)
					{
						echo '<p style="text-align:center">Error: could not connect to the database.</p>';
					}
					else
					{
						mysql_select_db('rhino_launch');
						
						$query = "SELECT * from contest WHERE Contest_id = ".$contestid;
						$result = mysql_query($query);
						$num_results = mysql_num_rows($result);
					
						if($num_results)
						{
							$row = mysql_fetch_array($result);
			
							echo '<img src="images/Full_tab_header.png" style="position: absolute; width: 900px; height: 35px; top:20px; left: 0px;">';
							echo '<div id="preferred-contest" style="width: 900px; position: absolute; left: 0%; top: 55px; height: 630px">';
			
			
			
							echo '<div style="height:100px; width: 100%; ">';
							echo '<div style="height:100%; width:100px; position: absolute; left:0px;">';
							echo '<img src="images/thumb'.$row['Icon'].'.png" class="no-border">';
							echo '</div>';
							echo '<div style="position: absolute; left:100px; width: 80%; font-size: x-large">';
							echo '<p style="text-align:center"><h1>'.$row['Name'].'</h1></p></br>';
							echo '</div>';
							//echo '<div style="position: absolute; right:0%">';
							echo '<div style="position: absolute; width: 20%; right: 0%; border-left: dashed 3px #8a8a8a; border-bottom: dashed 3px #8a8a8a">';
							echo '</br><p style="text-align:left"><h4>RhinoPoints: '.$row['PrizeR'].'</h4></p>';	
							echo '</br><p style="text-align:left"><h4>Due Date: '.$row['EndDate'].'</h4></p></br>';
							echo '<a href="./submitvideo.php?id='.$contestid.'"><img src="images/Submit_button_unpressed.png" style="border:none"></a>';
							echo '</div>';
							echo '</div>';
							echo '<div style="position: absolute; width: 100%; top: 130px; height: 150px">';
							echo '<div style="width:100%; text-align: left"><h3>Description:</h3></div></br>';
							echo '<div style="width:100%; text-align: left">'.htmlspecialchars(stripslashes($row['Summary'])).'</div></br>';
							echo '</div>';
							echo '<div style="position: absolute; width: 100%; top: 280px; height: 150px">';
							echo '<div style="width:100%; text-align: left"><h3>Business Summary:</h3></div></br>';
							echo '<div style="width:100%; text-align: left">'.htmlspecialchars(stripslashes($row['BizSummary'])).'</div></br>';
							echo '<div style="width:100%; text-align: left">';
							echo '</div>';
							echo '</div>';
							
							//Playlist
							$query = "SELECT * from `video` WHERE `Contest_id` = ".$contestid." ORDER BY `Date_Added` desc";
							$result = mysql_query($query);
							$num_results = mysql_num_rows($result);
							
							$query = urlencode($query);
							
							echo '<div style="position: absolute; width: 100%; top: 430px; height: 200px">';
							echo '<div style="width:100%; text-align: left"><h3>Recent Contest Submissions:</h3></div></br>';
							
							if(!$num_results){
								echo '<div style="position: absolute; left: 0%; width:10%; height: 150px; top: 30px;"><img id="prev_button" style="position: absolute; right: 0px; top:60px; width:28px; height:29"/></div>';
								echo '<div id="slide" style="position: absolute; left: 10%; width: 80%; height: 150px; top: 30px; background: #676767; z-index=-5;">';
								echo '<p>There are no contests submissions at this time</p>';
								echo '</div>';
								echo '</div>';
							}
							else{
								
							
								$num_slides = $num_results/4;

								echo '<div style="position: absolute; left: 0%; width:10%; height: 150px; top: 30px;"><img id="prev_button" style="position: absolute; right: 0px; top:60px; width:28px; height:29" src="images/playlist/previous_vid_button_disabled.jpg" onclick="prev(\''.$query.'\', '.$num_slides.')" alt="prev"/></div>';
								echo '<div id="slide" style="position: absolute; left: 10%; width: 80%; height: 150px; top: 30px; background: #676767; z-index=-5;">';
								
								if($num_results <= 4) {
									for($i = 0; $i < $num_results; $i++){
									
										$row = mysql_fetch_array($result);
									
										$vid = stripslashes($row['Link']); 
										$string = $vid; 
										$url = parse_url($string); 
										parse_str($url['query']);
										$video_thumbnail = 'http://img.youtube.com/vi/'.$v.'/0.jpg';
										
										if($i!=3)										
											echo '<div style="position: absolute; left: '.(25*($i%4)).'%; width: 25%; height: 100%; background-image: url(images/gray_box/Vertical_dotted.png); background-position: top right; background-repeat: repeat-y;">';
										else
											echo '<div style="position: absolute; left: '.(25*($i%4)).'%; width: 25%; height: 100%">';
										
										echo '<a href="./video.php?videoid='.$row['Video_id'].'"><img src="'.$video_thumbnail.'" alt="thumbnail" style="position: absolute; height: 75px; width: 100px; top: 15px; left: 40px;" /></a>';
										echo '<div style="position: absolute; height: 50px; top: 95px; width: 180; text-align: center">';
										echo substr(htmlspecialchars(stripslashes($row['Title'])), 0, 25);
										echo '</br>';
										echo substr(htmlspecialchars(stripslashes($row['Date_Added'])),0, 10);
										echo '</div>';
										echo '</div>';
									}
								}
								else {
									for($i = 0; $i < 4; $i++){
									
										$row = mysql_fetch_array($result);
									
										$vid = stripslashes($row['Link']); 
										$string = $vid; 
										$url = parse_url($string); 
										parse_str($url['query']);
										$video_thumbnail = 'http://img.youtube.com/vi/'.$v.'/0.jpg';
										
										if($i!=3)										
											echo '<div style="position: absolute; left: '.(25*($i%4)).'%; width: 25%; height: 100%; background-image: url(images/gray_box/Vertical_dotted.png); background-position: top right; background-repeat: repeat-y;">';
										else
											echo '<div style="position: absolute; left: '.(25*($i%4)).'%; width: 25%; height: 100%">';
										
										echo '<a href="./video.php?videoid='.$row['Video_id'].'"><img src="'.$video_thumbnail.'" alt="thumbnail" style="position: absolute; height: 75px; width: 100px; top: 15px; left: 40px;" /></a>';
										echo '<div style="position: absolute; height: 50px; top: 95px; width: 180; text-align: center">';
										echo substr(htmlspecialchars(stripslashes($row['Title'])), 0, 25);
										echo '</br>';
										echo substr(htmlspecialchars(stripslashes($row['Date_Added'])),0, 10);
										echo '</div>';
										echo '</div>';
									}
								}

								echo '</div>';
								
								if($num_results > 4)
									echo '<div style="position: absolute; width:10%; right: 0%; height: 150px; top: 30px;" ><img id="next_button" style="position: absolute; left: 0px; top:60px; width:28px; height:29" src="images/playlist/next_vid_button_enabled.jpg" onclick="next(\''.$query.'\', '.$num_slides.')" alt="next"/></div>';
								else
									echo '<div style="position: absolute; width:10%; right: 0%; height: 150px; top: 30px;"><img id="next_button" style="position: absolute; left: 0px; top:60px; width:28px; height:29" src="images/playlist/next_vid_button_disabled.jpg" onclick="next(\''.$query.'\', '.$num_slides.')" alt="next"/></div>';
									

									
									
									
								echo '</div>';
								
								
							}
							
							
							echo '</div>';
							
							//Top videos
							$query = "SELECT * from video WHERE Contest_id = ".$contestid." order by Rating desc";
							$result = mysql_query($query);
							$num_results = mysql_num_rows($result);
							
							echo '<div id="sidetab" style="top: 20px; height: 500px">';
							echo '<div style="position: absolute; width:100%; top: 5px; color:#FFFFFF">Top rated videos:</div>';
							
							if(!$num_results){
								echo '<div style="position: absolute; top: 60px">No contest submissions at this time</div>';
							}
							else{
								if($num_results > 3)
									$num_results = 3;
									
								for($i = 0; $i < $num_results; $i++){
									$row = mysql_fetch_array($result);
								
									if($i == 2)
										echo '<div style="position: absolute; height: 150px; left: 2%; width: 96%; top: '.($i*150+35).'px">';
									else
										echo '<div style="position: absolute; height: 150px; left: 2%; width: 96%; top: '.($i*150+35).'px; background-image: url(images/gray_box/Horizontal_dotted.png); background-position: bottom center; background-repeat: repeat-x;">';
									
									$vid = stripslashes($row['Link']); 
									$string = $vid; 
									$url = parse_url($string); 
									parse_str($url['query']);
									$video_thumbnail = 'http://img.youtube.com/vi/'.$v.'/0.jpg';
									
									echo '<a href="./video.php?videoid='.$row['Video_id'].'"><img src="'.$video_thumbnail.'" alt="thumbnail" style="position: absolute; height: 75px; width: 100px; top: 15px; left: 40px;" /></a>';
									echo '<div style="position: absolute; height: 50px; top: 95px; width: 180; text-align: center">';
									echo substr(htmlspecialchars(stripslashes($row['Title'])), 0, 25);
									echo '</br>';
									echo 'Votes: '.substr(htmlspecialchars(stripslashes($row['Rating'])),0, 10);
									echo '</div>';
									
									
									echo '</div>';
								}
								
							}
							
							echo '</div>';
							
						}
						else
							echo '<p style="text-align:center">This is not a proper contest.</p>';
						}
					}
			?>
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