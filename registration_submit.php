<html>
<head>
<title>Rhino Launch -- Register</title>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>

<?php
	include('header.php');
?>

<table border="0" width="100%">
<tr>
	<td width="200px" style="vertical-align:top">

	</td>
	<td style="text-align:center">
	<?php
		$username = $_POST["username"];
		$password = $_POST["password"];
		$passwordconfirm = $_POST["passwordconfirm"];
		$email = $_POST["email"];
		$address = $_POST["address"];
		$phone = $_POST["phone"];
	
	
		if(!($username && $password && $passwordconfirm && $email && $address && $phone))
		{
			$problems = true;
			
			echo '<p style="text-align:center"> You have not entered all the required information </p>';
		
		}
		else
		{
			$username = addslashes(trim($username));
			$password = addslashes(trim($password));
			$passwordconfirm = addslashes(trim($passwordconfirm));
			$email = addslashes(trim($email));
			$address = addslashes(trim($address));
			$phone = addslashes(trim($phone));
			
			@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
			
			if(!$db)
			{
				echo '<p style="text-align:center">Error: could not connect to the database.</p>';
			}
			else
			{
				mysql_select_db('rhino_launch');
				
				$query = "select UserName from log_on2 where UserName = '".$username."'";
				$result = mysql_query($query);
				$num_results = mysql_num_rows($result);
				
				if($num_results > 0)
				{
					$problems = true;
					echo '<p style="text-align:center"> This username is already taken</p>';
				}
			}
			
			
		}
		
		if($problems)
		{
			//form from register.php here
			//move it to it's own file and include it in here and register.php
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