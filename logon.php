<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
} 
?>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>

<script type="text/javascript">
	
	var expand;
	var id;
	
	//AJAX test
	function loadurl(dest, exp, i, args) { 
	expand = exp;
	id = i;
	try { 
        // Moz supports XMLHttpRequest. IE uses ActiveX. 
        // browser detction is bad. object detection works for any browser 
        xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} catch (e) { 
        // browser doesn't support ajax. handle however you want 
	} 
 
	// the xmlhttp object triggers an event everytime the status changes 
	// triggered() function handles the events 
	xmlhttp.onreadystatechange = triggered; 
 
	// open takes in the HTTP method and url. 
	xmlhttp.open("GET", dest+"?i="+i+"&args="+args); 
	//xmlhttp.open("POST", dest, true);
	
	/*
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", 2);
	xmlhttp.setRequestHeader("Connection", "close");
	*/
	
	/*xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
		if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
        // xmlhttp.responseText object contains the response. 
			//div = document.getElementById(id);
			tabs = document.getElementById('tabs');
			if(expand == 1){
			tabs.style.height = 340+'px';
			//div.style.height = 340+'px';
			}
			else
			{
			tabs.style.height = 130+'px';
			//div.style.height = 130+'px';
			}
			document.getElementById("tabs").innerHTML = xmlhttp.responseText; 
		}
	} */
	

	// send the request. if this is a POST request we would have 
	// sent post variables: send("name=aleem&gender=male) 
	// Moz is fine with just send(); but 
	// IE expects a value here, hence we do send(null); 
	//xmlhttp.send("i="+i+"&args="+args); 
	xmlhttp.send(null);
	} 
 
	function triggered() { 
	// if the readyState code is 4 (Completed) 
	// and http status is 200 (OK) we go ahead and get the responseText 
	// other readyState codes: 
	// 0=Uninitialised 1=Loading 2=Loaded 3=Interactive 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
        // xmlhttp.responseText object contains the response. 
		//div = document.getElementById(id);
		tabs = document.getElementById('tabs');
		if(expand == 1){
			tabs.style.height = 245+'px';
			//div.style.height = 340+'px';
		}
		else
		{
			tabs.style.height = 140+'px';
			//div.style.height = 130+'px';
		}
        document.getElementById('tabs').innerHTML = xmlhttp.responseText; 
		
	} 

	} 
</script>

<html>
<head>
<title>Rhino Launch</title>
</head>
<body>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css"/>


<div class="wrapper">
	<?php
		include('headerOLD.php');
	?>


	<div id="content">
		<div id="splash" style="height:200px">
	
			<div style="width:45%; position: absolute; left:0%; top: 10%">
			<?php
				if(!isset($_SESSION)) 
				{ 
					session_start(); 
				} 
				$username = addslashes(trim($_POST['username']));
				$password = addslashes(trim($_POST['password']));
		
				if(!$username || !$password)
					echo "Enter user details:";
				else
				{
					if(!isset($_SESSION['valid_user']) && $username && $password)
					{
						@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
				
						if(!$db)
						{
							echo "<p style=\"text-align:center\">Database down. Please try later.</p>";
						}
						else
						{
							mysql_select_db('rhino_launch', $db);
							$query = "select Uname, Psswrd from user where Uname = '".$username."' and Psswrd = '".$password."'";
							$result = mysql_query($query);

							$num_results = mysql_num_rows($result);

							if($num_results > 0)
							{
								$_SESSION['valid_user'] = $username;
							}
							else
								echo "Invalid username or password. Try again.";
													
						}
					}
				}
		
			include('login.php');
		?>
		</div>
	
		<div style="width:45%; position: absolute; left:50%; height:100px">

		<?php
			if(!isset($_SESSION))
			{
				session_start();
			} 
		
			$valid_user = $_SESSION['valid_user'];
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
		
			if($username && $password)
			{
				if(isset($valid_user))
				{
						@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
						mysql_select_db('rhino_launch', $db);
						$query = "select Uname, RPoints from user where Uname = '".$username."' and Psswrd = '".$password."'";
						$result = mysql_query($query);

						$num_results = mysql_num_rows($result);
	
						if($num_results > 0)
						{
							$row = mysql_fetch_array($result);
						
							echo '<div style="position:absolute; width:100%; left: 0px; top: 0px; text-alignment:center"><h1 style="color: #FFFFFF">'.$row['Uname'].'</h1></div>';
							echo '<div style="position:absolute; top:20%">RhinoPoints: '.$row['RPoints'];
							echo '</br><h4>Your contests:</h4>';
							echo '</br><h4>Your videos:</h4></div>';
						}
						else
							echo "Invalid username or password. Try again.";
				}
				else
				{
					echo "<p style=\"text-align:center\">You should sign-up!</p>";
				}
			}
			else
				echo '<p style="text-align:center">You have not entered user details.</p>';
		
		?>
		</div>
		
		</div>
		
		<div id="tabs" style="top: 40px; height: 140px">
			<div class="expandable-tab" id="1" style="top: 0px">
			<div class="expandable-tab-header-exp" onclick="loadurl('expand_tab.php', 1, 1, 'EndDate')">
				Recent Contests
			</div>
			
				
			
				<?php
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
								
									echo '<div class="expandable-tab-content" style="top:'.($i*105+35).'px">';
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
				
				?>
			
			</div>
			</div>
		</div>
	
	<div class="push">
		</div>
	
</div>
<?php
	include('footer.php');
?>

</body>
</html>
