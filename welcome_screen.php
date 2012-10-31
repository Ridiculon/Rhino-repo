	<?php
define('FACEBOOK_APP_ID', '380309888647642');
define('FACEBOOK_SECRET', '558e148b9e3c8cca671f103b4291137b');


//allow sessions to be passed so we can see if the user is logged in
session_start();
//connect to the database so we can check, edit, or insert data to our users table
$con = mysql_connect('localhost', 'userbasic', 'user8asic') or die(mysql_error());
$db = mysql_select_db('rhino_launch', $con) or die(mysql_error());
//include out functions file giving us access to the protect() function
include "./functions.php";

function parse_signed_request($signed_request, $secret) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}

function verify_fields($f,$sf) {
    $fields = json_encode($sf);
    return (strcmp($fields,$f) === 0);
}

?>
<html>
<head>
<title>Rhino Launch</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
<div class="wrapper">
		<div id="header">
			<a href="http://rhinolaunch.com/"><img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/></a>
			<!--<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
			<div id="header-content" style="background: none">	
				
			</div>-->
		</div>

		<div id="content">
				
			<div id="splash">
				
				

<?php
if ($_REQUEST) {
  //echo '<p>signed_request contents:</p>';
  $response = parse_signed_request($_REQUEST['signed_request'], FACEBOOK_SECRET);
    $metadata = array(
				array("name" => "name"),
				array("name" => "username", "description" => "Username", "type" => "text"),
				array("name" => "password"),
				array("name" => "email"),
				array("name" => "birthday"),
				array("name" => "phone", "description" => "Phone Number", "type" => "text"),
				array("name" => "captcha")
				);
	

 /* echo '<pre>';
  echo print_r($response);
  echo '</pre>';*/

	$username = protect($response['registration']['username']);
	$rname = protect($response['registration']['name']);
	$password = protect($response['registration']['password']);
	$email = protect($response['registration']['email']);
	//reformat the birthday to fit the database
	$birthday = protect(date_format(date_create($response['registration']['birthday']),'Y-m-d'));
	//use the following when submitting the phone to the db to make sure all phones have consistent formatting
	$phone = protect(preg_replace("/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/", "($1) $2-$3", $response['registration']['phone']));
	$uid = protect($response['user_id']);
	
	if ($response && isset($response["registration_metadata"]["fields"])) {
		//this line compares the metadata fields with the known fields after removing all whitespace and replacing " with '
        $verified = strcmp(preg_replace('/\s+/', '',str_replace('"', '\'', json_encode($metadata))), preg_replace('/\s+/', '', $response['registration_metadata']['fields']));

		if ($verified === 0) { // fields match!
		
			if(strlen($rname) > 40 || strlen($rname) < 3){
				//if it is display error message
				echo "<p class=\"error\">Your <b>Name</b> must be between 3 and 40 characters long!</p>";
			}else{
				//select all rows from our users table where the emails match
				$res1 = mysql_query("SELECT * FROM `user` WHERE `Email` = '".$email."'");
				$num1 = mysql_num_rows($res1);
				//if the number of matchs is 1
				if($num1 == 1){
					//the email address supplied is taken so display error message
					echo "<p class=\"error\">The <b>E-mail</b> address you supplied is already taken!</p>";
				}else{
					//finally, otherwise register there account
					//time of register (unix)
					//$registerTime = date('U');
					$registerTime = date("Y-m-d G:i:s");

					//insert the row into the database
					$res2 = mysql_query("INSERT INTO `user` (`Uname`, `Name`, `Psswrd`, `Email`, `Birthday`, `Phone`, `RegisterDate`, `Facebook_id`) VALUES ('".$username."','".$rname."','".$password."','".$email."','".$birthday."','".$phone."','".$registerTime."','".$uid."')");
					
					$query = "SELECT `Uname`, `RegisterDate` FROM `user` WHERE `Uname` = '".$username."'";
					$res3 = mysql_query($query);
					$row2 = mysql_fetch_array($res3);
					//make a code for our activation key
					//$code = md5($username).$row2['RegisterDate'];
					$code = md5($row2['Uname']).$row2['RegisterDate'];
					
					//send the email with an email containing the activation link to the supplied email address
					if (smtpmailer($email, 'Webmaster@rhinolaunch.com', 'The Rhino', 'RhinoLaunch Activation Email',
						'Congratulations on registering your RhinoLaunch Account!\n
						In order to finish registering, please follow this activation link. If the link doesn\'t work copy and paste it into your browser address bar.\n
						http://rhinolaunch.com/activate.php?code='.urlencode($code).'
						Now that you are signed-up, be sure to check out our contest page. Submit a unique video to a contest you like and start making money today!\n
						Be sure to tell your friends to join RhinoLaunch as well so they can vote for your submissions and increase your chances!\n
						Thanks and best of luck!

						- Team RhinoLaunch')) {
						//put stuff here
						echo "<p><h5>Thank you for creating a RhinoLaunch account.\nYou have been sent an email which contains the activation code for your account.</h5></p>";
					}
					if (!empty($error)) echo $error;

					//mail($email, @$INFO['chatName'].' registration confirmation', "Thank you for registering to us ".$username.",\n\nHere is your activation link. If the link doesn't work copy and paste it into your browser address bar.\n\nhttp://rhinolaunch.com/activate.php?code=".urlencode($code), 'From: cinco.braswell@rhinolaunch.com');
					//display the success message
					//echo "<p><h5>Thank you for creating a RhinoLaunch account.\nYou have been sent an email which contains the activation code for your account.</h5></p>";
					//echo "<p><h5>You have successfully registered, please click on the link below to activate your account!</h5></p>";
					//echo '<a href="activate.php?code='.urlencode($code).'">Activate account</a>';
				}
			}
		}else
		{
			echo 'There was a verification problem.';
		}
	}	
  
} else {
  echo 'No data was received. Please, try again.';
}
?>

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
