<?php
		
	@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
				
		if(!$db)
		{
			echo '<p style="text-align:center">Error: could not connect to the database.</p>';
		}
		else
		{
			mysql_select_db('rhino_launch');
			$query = "SELECT * FROM `contest` WHERE Summary LIKE '%".$_POST['search_query']."%' OR Name LIKE '%".$_POST['search_query']."%'";
			$result = mysql_query($query);
			$num_results = mysql_num_rows($result);
			
			if($num_results > 0)
			{
				
				if($num_results > 4)
					$num_results = 4;
				
				for($i=0; $i < $num_results; $i++)
				{
					$row = mysql_fetch_array($result);
					echo '<div class="search-element" style="top:'.($i*105).'px">';
					echo '<div style="height:100%; width:100px; position: absolute; left:0px;">';
					echo '<img src="images/thumb'.$row['Contest_id'].'.jpg" class="no-border">';
					echo '</div>';
					echo '<div style="height:20px; position: absolute; left:100px; width: 70%;">';
					echo '<strong><a href="./contest.php?contestid='.htmlspecialchars(stripslashes($row['Contest_id'])).'">';
					echo htmlspecialchars(stripslashes($row['Name'])).'</a></strong>';
					echo '</div>';
					echo '<div style="position: absolute; top: 20px; left:100px; width:70%;">';
					echo substr(htmlspecialchars(stripslashes($row['Summary'])), 0, 250);
					echo '</div>';
					echo '</div>';
				}
			}
			else
				echo '<p style="text-align:center">Your search did not match any contests.</p></br>';
		}
?>