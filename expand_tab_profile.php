<?php
		
		$item = $_GET['i'];
		$args = $_GET['args'];
		$arguments = explode("-", $args);
		
		function columnToText($c){
			switch($c){
				case 'RPoints': return 'Top Users';
				case 'RegisterDate': return 'New Users'; 
			}
		}
		
		for($j = 0; $j < count($arguments); $j++){
			
			if($item-1 < $j)
				echo '<div class="expandable-tab" id="'.($j+1).'" style="top: '.($j*160 + 450).'px">';
			else if($item-1 == $j)
				echo '<div class="expandable-tab" id="'.($j+1).'" style="top: '.($j*160).'px; height: 590px">';
			else
				echo '<div class="expandable-tab" id="'.($j+1).'" style="top: '.($j*160).'px">';
			
			if($item-1 == $j){
				echo '<div class="expandable-tab-header-col" onclick="loadurl(\'collapse_tab_profile.php\', 0, '.($j+1).',\''.$args.'\')">';
				echo columnToText($arguments[$j]);
				echo '</div>';
			}
			else {
				echo '<div class="expandable-tab-header-exp" onclick="loadurl(\'expand_tab_profile.php\', 1, '.($j+1).',\''.$args.'\')">';
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
					
						$query = "select User_id, Uname, Name, RPoints, Picture from user order by ".$arguments[$j]." desc";
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
						
							echo '<div class="expandable-tab-footer" style="top: 560px">';
							//echo '<div style="position: absolute; right:30px"><a href="./list.php">See all</a></div>';
							echo '</div>';
						}
						else
							echo '<p style="text-align:center">No contests at this time:'.$item.',,,</p></br>';
							print_r($arguments);
					}
			
			
		
			echo '</div>';
			
		}
	
	?>