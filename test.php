

<?php
		
		/*	echo '<div class="expandable-tab-header" onclick="loadurl(\'test.php\')">';
			echo '<a href="javascript:expand_tab(\'1\');">Collapse</a>  ---- Recent Contests';
			echo '</div>';
			
		
			
				@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
				
					if(!$db)
					{
						echo '<p style="text-align:center">Error: could not connect to the database.</p>';
					}
					else
					{
						mysql_select_db('rhino_launch');
					
						$query = "select Summary, Name, EndDate, Contest_id, PrizeR from contest order by EndDate desc";
						$result = mysql_query($query);
						$num_results = mysql_num_rows($result);
					
					
					
						if($num_results > 0)
						{
							if($num_results > 3)
								$num_results = 3;
								
							
							
							
							for($i=0; $i < $num_results; $i++)
							{
							
								echo '<div class="expandable-tab-content" style="top:'.($i*105+25).'px">';
								$row = mysql_fetch_array($result);
								echo '<div style="height:100%; width:100px; position: absolute; left:0px;">';
								echo '<img src="images/thumb'.$row['Contest_id'].'.jpg" class="no-border">';
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
						else
							echo '<p style="text-align:center">No contests at this time.</p></br>';
					}
			
			
		
	echo '</div>';*/
	?>
	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>jQuery UI Progressbar - Default functionality</title>
	<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"/>
	<link type="text/css" href="jquery/css/rhinostyle/jquery-ui-1.8.19.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="jquery/js/jquery-1.8.2.min.js"></script>
	<!--<script type="text/javascript" src="jquery/js/jquery-ui-1.8.24.custom.min.js"></script>-->
	<script type="text/javascript" src="jquery/development-bundle/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="jquery/development-bundle/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="jquery/development-bundle/ui/jquery.ui.progressbar.js"></script>
	<script>
		$(function() {
			$( "#progressbar" ).progressbar({
				value: 37
			});
		});
	</script>
</head>
<body>

<div style="height: 50px; padding: 12px">

	<div id="progressbar" style="height:100%; padding: 12px; font-size: 1px"></div>

</div><!-- End demo -->

</body>
</html>