<?php
	//connect to the database so we can check, edit, or insert data to our users table
	$con = mysql_connect('localhost', 'userbasic', 'user8asic') or die(mysql_error());
	$db = mysql_select_db('rhino_launch', $con) or die(mysql_error());
	//include out functions file giving us access to the protect() function
	include "./functions.php";
	
	$username = protect($_GET['username']);
	$phone = $_GET['phone'];
	
	$arr = array();
	
	$arr['uname'] = "";
	$arr['phone'] = "";
	
	//username check
	if(strlen($username) > 40 || strlen($username) < 3){
		//if it is display error message
		$arr['uname'] = "Your username must be between 3 and 40 characters long!";
	}else{
		//if not continue checking
		//select all the rows from out users table where the posted username matches the username stored
		$res = mysql_query("SELECT * FROM `user` WHERE `Uname` = '".$username."'");
		$num = mysql_num_rows($res);
		//check if there's a match
		if($num == 1){
			//if yes the username is taken so display error message
			$arr['uname'] =  "The Username you have chosen is already taken!";
		}
	}
	
	//phone check
	$regex = "/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/";
	// use the following when submitting the phone to the db to make sure all phones have consistent formatting
	//var formattedPhoneNumber = subjectString.replace(regexObj, "($1) $2-$3");
	if (!preg_match($regex,$phone)) {
		$arr['phone'] = "Not a valid phone";
	}
	
	
	echo json_encode($arr);

?>