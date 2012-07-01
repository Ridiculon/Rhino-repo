<?php

	$item = $_GET['i'];
	$n = $_GET['n'];
	$user = $_GET['user'];

	$queries = array();

	for($i = 0; $i < $n; $i++){
		$queries[$i] = $_GET['query'.$i];
	}

	$q = "";

	for($i = 0; $i < count($queries); $i++){
		$temp = "&query".$i."=".urlencode($queries[$i]);
		$temp = str_replace(")", "#", $temp);
		$q = $q.$temp;
	}

	for($j = 0; $j < $n; $j++){	
		echo '<div class="expandable-tab" id="'.($j+1).'" style="top: '.($j*160).'px">';
		echo '<div class="expandable-tab-header-exp" id="header'.($j+1).'" onclick="loadurl(\'expand_tab_custom.php\', 1, '.($j+1).', '.$n.' ,\''.$user.'\', \''.$q.'\')">';

		echo '</div>';



				@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');

					if(!$db)
					{
						echo '<p style="text-align:center">Error: could not connect to the database.</p>';
					}
					else
					{
						mysql_select_db('rhino_launch');

						$query = $queries[$j];
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
								echo '<img src="images/thumb'.$row['Icon'].'.png" class="no-border">';
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

						}
						else
							echo '<p style="text-align:center">No contests at this time.</p></br>';
					}



		echo '</div>';
	}


?>