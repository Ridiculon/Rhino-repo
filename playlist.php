<?php
	$query = $_GET['query'];
	$slide = $_GET['s'];
	
	@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
	
	mysql_select_db('rhino_launch');
	
	//$query = "SELECT * from video WHERE Contest_id = '".$contestid."' order by Date_Added desc";
	$result = mysql_query($query);
	$num_results = mysql_num_rows($result);
	
	//echo 'sup  '.$contestid.'  '.$slide;
	
	for($i = $slide*4; $i < ($slide+1)*4 ; $i++){
		if( $i < $num_results){
		//if($i > $slide*4 && $i < $num_results){
			//$row = mysql_fetch_array($result);
			mysql_data_seek($result, $i);
			$row = mysql_fetch_assoc($result);
			
			$vid = stripslashes($row['Link']); 
			$string = $vid; 
			$url = parse_url($string); 
			parse_str($url['query']);
			$video_thumbnail = 'http://img.youtube.com/vi/'.$v.'/0.jpg';
			
			if($i%4!=3)										
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
	


?>