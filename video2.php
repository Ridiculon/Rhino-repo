<?php
	session_start();
?>
<html>
<head>
<title>Rhino Launch -- Video</title>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>

<?php
	include('header.php');
?>

<table border="0" width="100%">
<tr>
	<td width="200px" style="vertical-align:top">
	<?php
		include('login.php');
	?>
	</td>
	
	<td>
	<?php
	
		$videoid = $_GET['videoid'];
			
		if(!$videoid)
		{		
			echo '<p style="text-align:center">This is not a proper video.</p>';
		}
		else
		{
			$videoid = addslashes(trim($videoid));
				
			@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
			
			if(!$db)
			{
				echo '<p style="text-align:center">Error: could not connect to the database.</p>';
			}
			else
			{
					$query = "select VidDescription, Name, Link, Contest_Rank, ID from video2 where Contest_ID = '".$videoid."'";
					$result = mysql_query($query);
					$num_results = mysql_num_rows($result);
								
				if($num_results)
				{
					$row = mysql_fetch_array($result);
					echo '<p style="text-align:center"><h3>'.$row['Name'].'</h3></p></br>';
					echo '<object width="480" height="385" style="text-align:center">';
					echo '<param name="movie" value="'.htmlspecialchars(stripslashes($row['Link'])).'"></param>';
					echo '<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>';
					echo '<embed src="'.htmlspecialchars(stripslashes($row['Link'])).'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385">';
					echo '</embed></object></br>';
					echo '<p style="text-align:left"><strong>Created By: <a href="./profile.php?id='.htmlspecialchars(stripslashes($row['ID'])).'">';
					
					$query2 = "select UserName from log_on2 where ID = '".$row['ID'];
					$result2 = mysql_query($query2);
					$row2 = mysql_fetch_array($result2);
					
					echo htmlspecialchars(stripslashes($row2['UserName'])).'</a></strong></td>';
					echo '</p>';
					echo '<p style="text-align:left">Votes: '.$row['Contest_Rank'].'</p></br>';
					echo '<p style="text-align:left">Description: '.$row['VidDescription'].'</p></br>';
							
				}
				else
					echo '<p style="text-align:center">This is not a proper user.</p>';
			}
		}
	?>
	</td>
	
</tr>
</table>

<?php
	include('footer.php');
?>

</body>
</html>