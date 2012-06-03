<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
} 
?>
<link type="text/css" href="jquery/css/rhinostyle/jquery-ui-1.8.19.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="jquery/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-ui-1.8.19.custom.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>
<script type="text/javascript">
	var i;
	var s = 0;
	var num;
	
	function show_alert()
	{	
	alert("I am an alert box!");
	}
	
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
<head>
<title>Rhino Launch</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
</head>
<body>
	<div class="wrapper">
		<div id="header">
			<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
			<?php
				include('header.php');
			?>
		</div>

		<div id="content">
				<img src="images/Full_tab_header.png" style="position: absolute; width: 100%; height: 35px; top:20px; left: 0px;">
				<div id="vidContainer" style="position: relative; top: 55px; min-height: 100px; width: 100%">
				
					<?php				
						
						if(!$_GET['Search'])
						{
							echo '<p style="text-align:center">You have not entered search results.</p>';
						}
						else
						{
							$Search = $_GET['Search'];
							$Search = addslashes(trim($Search));
							
							@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
							
							if(!$db)
							{
								echo '<p style="text-align:center">Error: could not connect to the database.</p>';
							}
							else
							{
								mysql_select_db('rhino_launch');
								
								$query_c = "SELECT `Contest_id`, `Summary`, `Name`, `Prize$`, `PrizeR`, `StartDate`, `EndDate`, `Category`, `Icon` FROM `contest` WHERE `Summary` LIKE '%".$Search."%' OR `Name` LIKE '%".$Search."%'";
								$result_c = mysql_query($query_c);
								$num_results_c = mysql_num_rows($result_c);
								
								$query_u = "SELECT `Uname`, `Name`, `Picture`, `User_id` FROM `user` WHERE `Uname` LIKE '%".$Search."%' OR `Name` LIKE '%".$Search."%'";
								$result_u = mysql_query($query_u);
								$num_results_u = mysql_num_rows($result_u);
								
								$query_v = "SELECT `Title`, `Description`, `Rank`, `Date_Added`, `Video_id`, `Link` FROM `video` WHERE `Title` LIKE '%".$Search."%' OR `Description` LIKE '%".$Search."%'";
								$result_v = mysql_query($query_v);
								$num_results_v = mysql_num_rows($result_v);
								
								echo '<p style="text-align:center">Number of results found: '.($num_results_c+$num_results_u+$num_results_v).'</p></br>';
								
								//end of vidContainer
								echo '</div>';
								
								?>
								
								<div id="tabs" style="position: relative; width: 100%; top: 70px; padding: 0px; margin-left: -2px; margin-right: -2px">
									<ul>
										<li><a href="#tabs-1">Contests</a></li>
										<li><a href="#tabs-2">Videos</a></li>
										<li><a href="#tabs-3">Users</a></li>
									</ul>
									
								<?php
									
									//Contests
									if($num_results_c > 0)
									{
										
										
										if($num_results_c > 3)
											$num_results_c = 3;
											
										echo '<div id="tabs-1" style="padding: 0px; height: '.(105*$num_results_c+35).'px">';
										
										for($i=0; $i < $num_results_c; $i++)
										{
										
											echo '<div class="expandable-tab-content" style="top:'.($i*105+35).'px">';
											$row = mysql_fetch_array($result_c);
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
										
										echo '<div class="expandable-tab-footer" style="top: '.(105*$num_results_c+35).'px">';
										//prepare to send query
										$query_c = urlencode($query_c);
										echo '<div style="position: absolute; right:30px"><a href="./list.php?query='.$query_c.'">See all</a></div>';
										echo '</div>';
									}
									else{
										echo '<div id="tabs-1" style="height: 35px">';
										echo '<p style="text-align:center">Your search did not match any contests</p></br>';
									}
									//end of tab-1 div
									echo '</div>';
									
									//Videos
									
									
									if(!$num_results_v){
										echo '<div id="tabs-2" style="height: 35px">';
										echo '<p>There are no videos that match your search</p>';
									}
									else{
										echo '<div id="tabs-2" style="padding: 0px; height: 200px">';
										
										$result_v = mysql_query($query_v);
										$query_v = urlencode($query_v);
									
										$num_slides = $num_results_v/4;
										
										echo '<div style="position: absolute; left: 0%; width:10%; height: 150px; top: 35px;"><img id="prev_button" style="position: absolute; right: 0px; top:60px; width:28px; height:29" src="images/playlist/previous_vid_button_disabled.jpg" onclick="prev(\''.$query_v.'\', '.$num_slides.')" alt="prev"/></div>';
										echo '<div id="slide" style="position: absolute; left: 10%; width: 80%; height: 150px; top: 35px; background: #676767; z-index=-5;">';
										
										for($i = 0; $i < 4; $i++){
											
												$row = mysql_fetch_array($result_v);
											
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
										
										echo '</div>';
										
										if($num_results_v > 4)
											echo '<div style="position: absolute; width:10%; right: 0%; height: 150px; top: 35px;" ><img id="next_button" style="position: absolute; left: 0px; top:60px; width:28px; height:29" src="images/playlist/next_vid_button_enabled.jpg" onclick="next(\''.$query_v.'\', '.$num_slides.')" alt="next"/></div>';
										else
											echo '<div style="position: absolute; width:10%; right: 0%; height: 150px; top: 35px;"><img id="next_button" style="position: absolute; left: 0px; top:60px; width:28px; height:29" src="images/playlist/next_vid_button_disabled.jpg" onclick="next(\''.$query_v.'\', '.$num_slides.')" alt="next"/></div>';
				
									}
										echo '</div>';
										
									//Users
									if($num_results_u > 0)
									{
										if($num_results_u > 3)
											$num_results_u = 3;
											
										
										echo '<div id="tabs-3" style="padding: 0px; height: '.(105*$num_results_u+35).'px">';
										
										for($i=0; $i < $num_results_u; $i++)
										{
												echo '<div class="expandable-tab-content" style="top:'.($i*105+35).'px">';
												$row = mysql_fetch_array($result_u);
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
										
										echo '<div class="expandable-tab-footer" style="top: '.($num_results_u*105+35).'px">';
										$query_u = urlencode($query_u);
										//echo '<div style="position: absolute; right:30px"><a href="./list.php">See all</a></div>';
										echo '</div>';
									}
									else{
										echo '<div id="tabs-3" style="height: 35px">';
										echo '<p style="text-align:center">No users match your search</p></br>';
									}
									//end of tab-3 div
									echo '</div>';
									
								
								
								/*echo '<div id="tabs" style="top: 75px; height: 300px">';
								echo '<div class="expandable-tab" id="1" style="top: 0px" >';

								
									if($num_results_c > 0)
									{
										echo '<div class="expandable-tab-header-exp" id="header1" onclick="loadurl(\'expand_tab_custom.php\', 1, 1, 2, \'0\', \''.$q.'\')">';
										echo 'Contests';
										echo '</div>';
									
										if($num_results_c > 3)
											$num_results_c = 3;
										
										for($i=0; $i < $num_results_c; $i++)
										{
										
											echo '<div class="expandable-tab-content" style="top:'.($i*105+35).'px">';
											$row = mysql_fetch_array($result_c);
											echo '<div style="height:100%; width:100px; position: absolute; left:0px;">';
											echo '<img src="images/thumb'.$row['Contest_id'].'.png" class="no-border">';
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
											echo 'Contests';
											echo '</div>';
											echo '<div class="expandable-tab-content" style="top: 35px">';
											echo '<p>There weren\'t any contests that match your query</p>';
											echo '</div>';
									}
									
									if($num_results_u > 0){
										echo '<div class="expandable-tab-header-exp" id="header2" onclick="loadurl(\'expand_tab_custom.php\', 1, 2, 2, \'0\', \''.$q.'\')">';
										echo 'Users';
										echo '</div>';
									
										if($num_results_u > 3)
											$num_results_u = 3;
										
										for($i=0; $i < $num_results_u; $i++)
										{
											echo '<div class="expandable-tab-content" style="top:'.($i*105+35).'px">';
											$row = mysql_fetch_array($result_u);
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
									else{
											echo '<div class="expandable-tab-header-exp" id="header2">';
											echo 'Users';
											echo '</div>';
											echo '<div class="expandable-tab-content" style="top: 35px">';
											echo '<p>There weren\'t any users that match your query</p>';
											echo '</div>';
									}
									
								echo '</div>';
							echo '</div>';
								*/
								/*
								echo '<ol>';
								for($i=0; $i < $num_results; $i++)
								{
									$row = mysql_fetch_array($result);
									//echo '<li><p style="text-align:left"><strong>'.($i+1).'. Name: <a href="./contest.php?contestid='.htmlspecialchars(stripslashes($row['Contest_id'])).'">';
									echo '<li class="srchRes"><p style="text-align:left"><strong> Name: <a href="./contest.php?contestid='.htmlspecialchars(stripslashes($row['Contest_id'])).'">';
									echo htmlspecialchars(stripslashes($row['Name'])).'</a>';
									echo '<br/>Summary: </strong>';
									echo substr(htmlspecialchars(stripslashes($row['Summary'])), 0, 50)."...";
									echo '<br/><strong>End Date: </strong>';
									echo htmlspecialchars(stripslashes($row['EndDate']));
									echo '</p></li>';
								}
								echo '</ol>';*/
							}
						}
					?>
				</div>
		</div>
		<div class="push"></div>
	</div>
	<?php
		include('footer.php');
	?>
</body>
</html>