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
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>

<script type="text/javascript">
	
	var expand;
	var id;
	
	//AJAX test
	function upvote(i) { 

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
	document.getElementById('Likeuga').src="images/Like_pressed.png";
	document.getElementById('Likeuga').onclick=undefined;
 
	// open takes in the HTTP method and url. 
	xmlhttp.open("GET", "./upvote.php?i="+i); 
	//xmlhttp.open("POST", dest, true);

	// send the request. if this is a POST request we would have 
	// sent post variables: send("name=aleem&gender=male) 
	// Moz is fine with just send(); but 
	// IE expects a value here, hence we do send(null); 
	//xmlhttp.send("i="+i+"&args="+args); 
	xmlhttp.send(null);
	} 
	
	function flag(i, form){
		
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
		document.getElementById('Flaguga').src="images/Flag_pressed.png";
		document.getElementById('Flaguga').onclick=undefined;
	 
		//var id = form.select.value;
		//var description = encodeURI(form.textarea.value);
	 
		var e = document.getElementById("select");
		var id = e.selectedIndex;
		var description = document.getElementById("textarea").value;
		
		alert("Oh god why:" + id + "  " + description);
	 
		// open takes in the HTTP method and url. 
		xmlhttp.open("GET", "./flag.php?i="+i+"&id="+id+"&desc="+description); 
		//xmlhttp.open("POST", dest, true);

		// send the request. if this is a POST request we would have 
		// sent post variables: send("name=aleem&gender=male) 
		// Moz is fine with just send(); but 
		// IE expects a value here, hence we do send(null); 
		//xmlhttp.send("i="+i+"&args="+args); 
		xmlhttp.send(null);
		
		$("#dialog").dialog('close');
	}

 
	function triggered() { 
	// if the readyState code is 4 (Completed) 
	// and http status is 200 (OK) we go ahead and get the responseText 
	// other readyState codes: 
	// 0=Uninitialised 1=Loading 2=Loaded 3=Interactive 
		if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
        // xmlhttp.responseText object contains the response. 
		//div = document.getElementById(id);
		vid = document.getElementById('vidInfo');
        document.getElementById('vidInfo').innerHTML = xmlhttp.responseText; 
		
		} 
	
	} 
	
	function loaddialog(){
		$("#dialog").dialog('open');
	}
	
</script>
	
</script>

<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
<title>Rhino Launch Video</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">
	$(function() {
		$( "#dialog" ).dialog({ autoOpen: false });
	});
</script>

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
			<div id="header">
				<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
				<?php
					include('header.php');
				?>
			</div>

			<div id="content">
				<img src="images/Full_tab_header.png" style="position: absolute; width: 100%; height: 35px; top:20px; left:0px">
				<div id="vidContainer" style="top:55px">
					<?php
						include('youtube.php');
						$videoid = $_GET['videoid'];
						
						if(!$videoid)
						{		
							echo '<p style="text-align:center">This is not a proper video.</p>';
						}
						else
						{
							$videoid = addslashes(trim($videoid));
								
							$con = mysql_connect('localhost', 'userbasic', 'user8asic') or die(mysql_error());
							$db = mysql_select_db('rhino_launch', $con) or die(mysql_error());
							
							if(!$db)
							{
								echo '<p style="text-align:center">Error: could not connect to the database.</p>';
							}
							else
							{
									$query = "SELECT `Title`, `Link`, `Rating`, `Rank`, `Date_Added`, `Description`, `User_id`, `Contest_id` FROM `video` where `Video_id` = '".$videoid."'";
									$result = mysql_query($query);
									$num_results = mysql_num_rows($result);
												
								if($num_results)
								{
									$row = mysql_fetch_array($result);
									
									$vid = stripslashes($row['Link']); 
									$string = $vid; 
									$url = parse_url($string); 
									parse_str($url['query']); 
									
									// set video data feed URL 
									$feedURL = 'http://gdata.youtube.com/feeds/api/videos/'. $v; 

									// read feed into SimpleXML object 
									$entry = simplexml_load_file($feedURL); 
						
									// parse video entry 
									$video = parseVideoEntry($entry); 
									
									//video variables
									$embed = '<object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/'.$v.'&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$v.'&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>';
									$views = $video->viewCount;
									
									echo '<div id="vid">';
										echo '<p><h5>'.$row['Title'].'</h5></p><br/>';
										echo '<p>'.$embed.'</p>';

										$upvoted = "SELECT `User_id`, `Video_id` FROM `upvotes` WHERE `User_id` = '".$_SESSION['valid_user']."'  AND `Video_id` = '".$videoid."'";
										$quer = mysql_query($upvoted);
										$res =  mysql_num_rows($quer);
													
										if($res)
										{
											echo '<p><img src="images/Like_pressed.png" style="border:none" alt="UpVoted"/> &nbsp; &nbsp;&nbsp; &nbsp;';
										}
										else {
											echo '<p><img onclick="upvote('.$videoid.');" id="Likeuga" src="images/Like_unpressed.png" style="border:none"/> &nbsp; &nbsp;&nbsp; &nbsp;';
										}

										$flagged = "SELECT `User_id`, 'Video_id' FROM `flags` WHERE `User_id`='".$_SESSION['valid_user']."' AND `Video_id` = '".$videoid."'";
										$quer2 = mysql_query($flagged);
										$res2 =  mysql_num_rows($quer2);
													
										if($res2)
										{
											echo '<img src="images/Flag_pressed.png" style="border:none" alt="Flagged"/> &nbsp; &nbsp;&nbsp; &nbsp;';
										}
										else {
											echo '<img onclick="loaddialog();" id="Flaguga" src="images/Flag_unpressed.png" style="border:none;"></p>';
											echo '<div id="dialog" title="Flag">';
											echo '<form name="flagform">';
											echo '<select id="select">';
											echo '<option>Inappropriate</option>';
											echo '<option>Copyrighted/Unoriginal</option>';
											echo '<option>Not relevant to contest</option>';
											echo '<option>Other</option>';
											echo '</select><br><br>';
											echo '<textarea id="textarea"></textarea><br>';
											echo '<a href="javascript: flag('.$videoid.', this.form)">Submit</a>';
											echo '</form>';
											echo '</div>';
										}
										

									echo '</div>';
									
										echo '<div class="vidInfo" id="vidInfo">';
										echo '<p><h5>Video Info</h5></p><br/>';
										echo '<p><strong>Created By: <a href="./profile.php?id='.htmlspecialchars(stripslashes($row['User_id'])).'">';
											
										$query2 = "select Uname from user where User_id = ".$row['User_id'];
										$result2 = mysql_query($query2);
										$row2 = mysql_fetch_array($result2);
										
										echo htmlspecialchars(stripslashes($row2['Uname'])).'</a></strong>';
										echo '</p><br/>';
										echo '<p><strong>Post Date:</strong> '.$row['Date_Added'].'</p><br/>';
										echo '<p><strong>Rating:</strong> '.$row['Rating'].'</p><br/>';
										echo '<p><strong>Place:</strong> '.$row['Rank'].'</p><br/>';
										echo '<p><strong>Views:</strong> '.$views.'</p><br/>';
										// will add Share It section here
										echo '<p><strong>Description:</strong><br/> '.$row['Description'].'</p><br/>';
									echo '</div>';
												
								}
								else
									echo '<p class="error">There was an error</p>';
							}
						}
					?>
				</div>
				
				<div>
				<?php
					echo '<fb:comments href="/localhost/rhinolaunch/video.php?videoid='.$_GET['videoid'].'" num_posts="2" width="1100" colorscheme="dark"></fb:comments>';
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