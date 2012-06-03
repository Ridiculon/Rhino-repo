<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
} 
		include('youtube.php');
		$videoid = $_GET['i'];
	
		if($videoid){
			$videoid = addslashes(trim($videoid));
				
			$con = mysql_connect('localhost', 'userbasic', 'user8asic') or die(mysql_error());
			$db = mysql_select_db('rhino_launch', $con) or die(mysql_error());
			
			if($db){
				mysql_select_db('rhino_launch');
				$query = "UPDATE `video` SET Rating=Rating+1 WHERE `Video_id`=".$videoid;
				$insertupvote = mysql_query("INSERT INTO `upvotes` (User_id, Video_id) VALUES('".$_SESSION['valid_user']."','".$videoid."')");
				$result = mysql_query($query);
			}
				
		}
		
		$con = mysql_connect('localhost', 'userbasic', 'user8asic') or die(mysql_error());
		$db = mysql_select_db('rhino_launch', $con) or die(mysql_error());
		
		$query = "SELECT `Title`, `Link`, `Rating`, `Rank`, `Date_Added`, `Description`, `User_id`, `Contest_id` FROM `video` where `Video_id` = '".$videoid."'";
		$result = mysql_query($query);
		$num_results = mysql_num_rows($result);
		
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
		
		echo '<p><h5>Video Info</h5></p><br/>';
		echo '<p><strong>Created By: <a href="./profile.php?id='.htmlspecialchars(stripslashes($row['User_id'])).'">';
					
		$query2 = "SELECT `Uname` FROM `user` WHERE `User_id` = ".$row['User_id'];
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
		


?>