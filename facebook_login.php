<?php
	//allow sessions to be passed so we can see if the user is logged in
	session_start();
	//connect to the database so we can check, edit, or insert data to our users table
	$con = mysql_connect('localhost', 'userbasic', 'user8asic') or die(mysql_error());
	$db = mysql_select_db('rhino_launch', $con) or die(mysql_error());
	
	define('FACEBOOK_APP_ID', '380309888647642');
	define('FACEBOOK_SECRET', '558e148b9e3c8cca671f103b4291137b');
	include "./php-sdk/src/facebook.php";
	include "./functions.php";
	 
	$facebook = new Facebook(array(
				'appId' => FACEBOOK_APP_ID,
				'secret' => FACEBOOK_SECRET,
				'cookie' => true,
			));
	
	$uid = protect($_GET['uid']);
	
	$query = "SELECT `User_id`, `Facebook_id` FROM `user` where `Facebook_id` = '".$uid."'";
	$result = mysql_query($query);
	
	$num_results = mysql_num_rows($result);
	
		if($num_results){
		$row = mysql_fetch_array($result);
		$id = stripslashes($row['User_id']);
		$next_url = 'http://rhinolaunch.com/profile.php?id='.$id;
	}
	else
		$next_url = 'http://rhinolaunch/register.php';
	
	/*
	if($num_results){
			
			$row = mysql_fetch_array($result);
			$id = stripslashes($row['User_id']);
	
			$params = array(
				'ok_session' => 'http://rhinolaunch.com/profile.php?id='.$id,
				'no_user' => 'http://rhinolaunch.com/register.php',
				'no_session' => 'http://rhinolaunch.com/no_session.html',
			);
	
			//$next_url = $facebook->getLoginStatusUrl($params);
			//$next_url = $facebook->getLoginUrl(array('display' => 'none'));
			$loginUrl = $facebook->getLoginUrl(array(
                                       'next' => 'http://rhonolaunch.com/profile.php?id='.$id,
                                       'cancel_url' => 'http://rhinolaunch.com' ));
	}
	else
		$next_url = 'http://rhinolaunch.com/register.php';*/
	
	$fbUser = $facebook->getUser();
	
	if($uid != $fbUser || $facebook->getUser()==0 || is_null($fbUser)){
		$next_url = 'http://rhinolaunch.com/error.html';
	}
	else{
		
		try {
			$fbProfile=$facebook->api('/me');
		} catch (FacebookApiException $e)
		{
			$fbUser=null;
		}

	}
	
	if(!is_null($fbUser)){
		//if they have log them in
		//set the login session storing there id - we use this to see if they are logged in or not
		$_SESSION['valid_user'] = $row['User_id'];
		//update the online field to 50 seconds into the future
		$time = date('U')+50;
		mysql_query("UPDATE `user` SET `online` = '".$time."' WHERE `User_id` = '".$_SESSION['valid_user']."'");
	}
	
	/*$pos = strpos($next_url, '&');
	
	if($pos !== 0)
		$next_url = substr($next_url, 0, $pos);*/
	
	header('Location: '.$next_url.'');
?>