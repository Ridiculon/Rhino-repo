<?php
	session_start();
	//check if the login session does not exist
	if(strcmp(@$_SESSION['valid_user'],"") != 0){
		header('Location: ./profile.php?id='.htmlspecialchars(stripslashes($_SESSION['valid_user'])).'');
	}
?>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT" SRC="scripts.js"></SCRIPT>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
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

		tabs = document.getElementById('tabs');
		if(expand == 1){
			tabs.style.height = 350+'px';
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
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
</head>
<body>
<div class="wrapper">
		<div id="header">
			<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
			<!--<div id="header-content" style="background: none">	
				
			</div>-->
			<div style="position: absolute; left:65%; top: 20%">
				<a href="./login.php">
				<img border="0" src="images/Login_button.png" alt="login" style="border:none; width:126px; height:47px" />
				</a>
			</div>
		</div>
	
	
		<div id="content">
		
			<div id="splash">
			
				<img src="images/Sitting_Rhino_no_background_right.png" alt="rhino" style="position:absolute; left: 15%; top:15%; width: 15%; border:none;">
		
				<div style="width:45%; position: absolute; left:50%; top:10%;">
					</br>
					<img src="images/What-we-do.png">
					</br>
					</br>
					<p> RhinoLaunch pits filmmakers against each other in competition as they work to create quality video advertisements for businesses in their area. 
				Businesses receive a multitude of affordable advertisements that have been voted on by the very people they are looking to attract to their business,
				while winning filmmakers receive a cash prize and recognition for their work. </p>
			
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