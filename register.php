<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript"> 
function validate_async(form, cb) {
  
  $.getJSON('./registration_validation.php?username=' + form.username + '&phone=' + form.phone,
    function(response) {
	  if(response.uname != "" || response.phone != ""){
			cb({username: response.uname, phone: response.phone});
	  }
	    // Username isn't taken and phone works, let the form submit
        cb();
  });
  
}
</script> 

<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
<title>Rhino Launch</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
<div class="wrapper">
		<div id="header">
			<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
			<!--<div id="header-content" style="background: none">	
				
			</div>-->
		</div>

		<div id="content">
				
			<div id="splash" style="height: 450px; padding-top:10px">
				<div id="fb-root"></div>
				<script src="http://connect.facebook.net/en_US/all.js#appId=380309888647642&xfbml=1"></script>

				<fb:registration 
				  fields="[
				 {'name':'name'},
				 {'name':'username',	'description':'Username',	 'type':'text'},
				 {'name':'password'},
				 {'name':'email'},
				 {'name':'birthday'},
				 {'name':'phone',      'description':'Phone Number',             'type':'text'},
				 {'name':'captcha'}
				]" 
				  redirect-uri="http://rhinolaunch.com/welcome_screen.php"
				  width="530"
				  onvalidate="validate_async"
				>
				</fb:registration>
				
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
