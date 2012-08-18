h/+<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
} 
?>
<head>
<title>Rhino Launch</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
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
			<table border="0" width="100%">
			<tr>
				<td width="200px" style="vertical-align:top">
				<?php
					include('login.php');
				?>
				</td>
				
				<td style="text-align:center">
					<form action="profilesearch.php" method=post>
						<h3>Search for filmmakers:</h3></br>
						<input type="text" name="Search" size="15" maxlength="30">
						<input type="submit" value="Search">
					</form>
					
					<?php
						if(!$_POST['Search'])
						{
							echo '<p style="text-align:center">You have not entered search results.</p>';
						}
						else
						{
							$Search = $_POST['Search'];
							$Search = addslashes(trim($Search));
							
							@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
							if(!$db)
							{
								echo '<p style="text-align:center">Error: could not connect to the database.</p>';
							}
							else
							{
								mysql_select_db('rhino_launch');
								
								$query = "select Uname, User_id, RPoints from user where RPoints > 90 and Uname like '%".$Search."%'";
								$result = mysql_query($query);
								$num_results = mysql_num_rows($result);
								
								echo '<p style="text-align:center">Number of results found '.$num_results.'</p></br>';
								
								for($i=0; $i < $num_results; $i++)
								{
									$row = mysql_fetch_array($result);
									echo '<p style="text-align:center"><strong>'.($i+1).'. Name: <a href="./profile.php?id='.htmlspecialchars(stripslashes($row['User_id'])).'">';
									echo htmlspecialchars(stripslashes($row['Uname'])).'</a>';
									echo '<br/>RPoints: </strong>';
									echo stripslashes($row['RPoints']);
									echo '</p>';
								}
								
							}
						}
					?>
					
				</td>
				
			</tr>
			</table>
		</div>
		<div class="push"></div>
	</div>
	<div class="footer">
				FOOTER WOOO!
	</div>
</body>
</html>