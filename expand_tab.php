<?php
		
		$item = $_GET['i'];
		$args = $_GET['args'];
		$arguments = explode("-", $args);
		
		function columnToText($c){
			switch($c){
				case 'EndDate': return 'Recent Contests';
				case 'PrizeR': return 'Highest Reward'; 
			}
		}
		
		
		for($j = 0; $j < count($arguments); $j++){
			
			if($item-1 < $j)
				echo '<div class="expandable-tab" id="'.($j+1).'" style="top: '.($j*160 + 240).'px">';
			else if($item-1 == $j)
				echo '<div class="expandable-tab" id="'.($j+1).'" style="top: '.($j*160).'px; height: 380px">';
			else
				echo '<div class="expandable-tab" id="'.($j+1).'" style="top: '.($j*160).'px">';
			
			if($item-1 == $j){
				echo '<div class="expandable-tab-header-col" onclick="loadurl(\'collapse_tab.php\', 0, '.($j+1).',\''.$args.'\')">';
				echo columnToText($arguments[$j]);
				echo '</div>';
			}
			else {
				echo '<div class="expandable-tab-header-exp" onclick="loadurl(\'expand_tab.php\', 1, '.($j+1).',\''.$args.'\')">';
				echo columnToText($arguments[$j]);
				echo '</div>';
			}
			
		
			
				@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
				
					if(!$db)
					{
						echo '<p style="text-align:center">Error: could not connect to the database.</p>';
					}
					else
					{
						mysql_select_db('rhino_launch');
					
						$query = "select Summary, Name, EndDate, Contest_id, PrizeR from contest order by ".$arguments[$j]." desc";
						$result = mysql_query($query);
						$num_results = mysql_num_rows($result);
					
					
					
						if($num_results > 0)
						{
							if($num_results > 3)
								$num_results = 3;
								
							
							
							
							for($i=0; $i < $num_results; $i++)
							{
							
								echo '<div class="expandable-tab-content" style="top:'.($i*105+35).'px">';
								$row = mysql_fetch_array($result);
								echo '<div style="height:100%; width:100px; position: absolute; left:0px;">';
								echo '<img src="images/thumb'.$row['Contest_id'].'.png" class="no-border">';
								echo '</div>';
								echo '<div style="height:20px; position: absolute; left:15%; width: 70%;">';
								echo '<strong><a href="./contest.php?contestid='.htmlspecialchars(stripslashes($row['Contest_id'])).'">';
								echo htmlspecialchars(stripslashes($row['Name'])).'</a></strong>';
								echo '</div>';
								echo '<div style="position: absolute; top: 20px; left:15%; width:70%;">';
								if(strlen(htmlspecialchars(stripslashes($row['Summary']))) > 250)
									echo substr(htmlspecialchars(stripslashes($row['Summary'])), 0, 250).'...';
								else
									echo htmlspecialchars(stripslashes($row['Summary']));
								echo '</div>';
								echo '<div style="position: absolute; top: 15px; right: 0%; width: 15%">';
								echo 'Due Date: </br>'.htmlspecialchars(stripslashes($row['EndDate']));;
								echo '</div>';
								echo '<div style="position: absolute; top: 60px; right: 0%; width: 15%">';
								echo 'Rhino Points: '.$row['PrizeR'];
								echo '</div>';
								echo '</div>';
							}
							
							echo '<div class="expandable-tab-footer" style="top: 350px">';
							//prepare to send query
							$query = urlencode($query);
							echo '<div style="position: absolute; right:30px"><a href="./list.php?query='.$query.'">See all</a></div>';
							echo '</div>';
						}
						else
							echo '<p style="text-align:center">No contests at this time:'.$item.',,,</p></br>';
							//print_r($arguments);
					}
			
			
		
			echo '</div>';
			
		}
	
	?>