<?php
	session_start();
?>
<html>
<head>
<title>Rhino Launch</title>
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
	
	<td style="text-align:center">
	<?php
		$id = $_GET['id'];
		
		if(!$id)
		{
			echo '<p style="text-align:center">This is not a proper user.</p>';
		}
		else
		{
			$id = addslashes(trim($id));
				
			@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
			
			if(!$db)
			{
				echo '<p style="text-align:center">Error: could not connect to the database.</p>';
			}
			else
			{
				mysql_select_db('rhino_launch');
					
				$query = "select UserName, Points from log_on2 where Points > 90 and ID = ".$id;
				$result = mysql_query($query);
				$num_results = mysql_num_rows($result);
				
				if($num_results)
				{
					$row = mysql_fetch_array($result);
					echo '<p style="text-align:center"><h3>'.$row['UserName'].'</h3></p></br>';
					echo '<p style="text-align:left">RhinoPoints: '.$row['Points'].'</p>';					
				}
				else
					echo '<p style="text-align:center">This is not a proper user.</p>';
			}
		}
	?>
	
		<object width="480" height="385" style="text-align:center">
			<param name="movie" value="http://www.youtube.com/v/DsCewLZ03CU?fs=1&amp%3Bhl=en_US"></param>
			<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
			<embed src="http://www.youtube.com/v/DsCewLZ03CU?fs=1&amp%3Bhl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385">
		</embed></object>
	
	</td>
	
</tr>
</table>

<?php
	include('footer.php');
?>

</body>
</html>