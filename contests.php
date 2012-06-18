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
tabs.style.height = 560+'px';
//div.style.height = 340+'px';
}
else
{
tabs.style.height = 300+'px';
//div.style.height = 130+'px';
}
document.getElementById('tabs').innerHTML = xmlhttp.responseText;
}

}
</script>


<html>
<head>
<title>Rhino Launch -- Contests</title>
<link rel="stylesheet" href="images/RhinoStyle.css" type="text/css" />
</head>
<body>

<div class="wrapper">
<?php
//if the login session does not exist therefore meaning the user is not logged in
if(strcmp(@$_SESSION['valid_user'],"") == 0){
?>
<div id="header">
<img src="images/rhinolaunch_logo.png" alt="rhino" style="position:absolute; top:40px; left: 20%; border:none; height:50%;"/>
</div>

<div id="content">
<div class="tab-header" style="top:20px; font-size:25px;">
Would you kindly?
</div>
<div id="preferred-contest" style="top: 55px; height: 300px;">
<p class=\"error\" style=\"font-size: 40px\">You need to be logged in to use this feature!</p>
<form action="./login.php" method="post">
<div id="othbord">
<table class="auth" cellpadding="2" cellspacing="0" border="0">
<tr>
<td>Username:</td>
<td><input type="text" name="username" /></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" name="password" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="submit" value="Login" /></td>
</tr>
<tr>
<td align="center" colspan="2"><a href="register.php">Register</a> | <a href="forgot.php">Forgot Pass</a></td>
</tr>
</table>
</div>
</form>
</div>
</div>
<div id="push"></div>
<?php
}else{
//otherwise continue the page
//this is out update script which should be used in each page to update the users online time
$time = date('U')+50;
@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');
mysql_select_db('rhino_launch');
$update = mysql_query("UPDATE `user` SET `online` = '".$time."' WHERE `User_id` = '".$_SESSION['valid_user']."'");
?>
<!-- Actual Page content goes here -->
<?php
include('header.php');
?>
<div id="content">
<div style="position: relative; width: 100%; height: 200px; top:20px;">
<img src="images/Full_tab_header.png" style="position: absolute; width: 900px; height: 35px; top:0px; left: 0px">
<div id="preferred-contest" style="position: absolute; width: 900px; left: 0px; top: 35px;">
<?php
@ $db = mysql_pconnect('localhost', 'userbasic', 'user8asic');

if(!$db)
{
echo '<p style="text-align:center">Error: could not connect to the database.</p>';
}
else
{
mysql_select_db('rhino_launch');

$query = "select Summary, Name, EndDate, Contest_id, PrizeR from contest where Contest_id = 11";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

echo '<div style="height:100%; width:150px; position: absolute; left:0px; top: 15px;">';
echo '<img src="images/150px_thumbs/thumb4.png" class="no-border">';
echo '</div>';
echo '<div style="height:20px; position: absolute; left:160px; top: 10px; width: 69%;">';
echo '<strong> RhinoLaunch Presents: <a href="./contest.php?contestid='.htmlspecialchars(stripslashes($row['Contest_id'])).'">';
echo htmlspecialchars(stripslashes($row['Name'])).'</a></strong>';
echo '</div>';
echo '<div style="position: absolute; text-align: left; top: 45px; left:160px; width:67%;">';
if(strlen(htmlspecialchars(stripslashes($row['Summary']))) > 400)
echo substr(htmlspecialchars(stripslashes($row['Summary'])), 0, 400).'...';
else
echo htmlspecialchars(stripslashes($row['Summary']));
echo '</div>';
echo '<div style="position: absolute; top: 30px; right: 0%; width: 15%">';
echo 'Due Date: </br>'.htmlspecialchars(stripslashes($row['EndDate']));;
echo '</div>';
echo '<div style="position: absolute; top: 90px; right: 0%; width: 15%">';
echo 'Rhino Points: '.$row['PrizeR'];
echo '</div>';

}
?>
</div>
<?php
echo '<div id="sidetab">';
echo '<div style="position: absolute; top: 75px; left: 5px;">';
echo 'Like what you see?</br>';
echo 'Why don\'t you';
echo '<a href="./submitcontesttest.php"><img src="images/Submit_Contest_button_unpressed.png" style="border:none"></a>';
echo '</div>';
echo '</div>';
?>
</div>

<div id="tabs" style="top: 75px; height: 300px">
<div class="expandable-tab" id="1" style="top: 0px" >
<div class="expandable-tab-header-exp" onclick="loadurl('expand_tab.php', 1, 1, 'EndDate-PrizeR')">
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

$query = "select Summary, Name, EndDate, Contest_id, PrizeR, Icon from contest order by EndDate desc";
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
echo '<img src="images/thumb'.$row['Icon'].'.png" class="no-border">';
echo '</div>';
echo '<div style="height:20px; position: absolute; left:15%; width: 70%;">';
echo '<strong><a href="./contest.php?contestid='.htmlspecialchars(stripslashes($row['Contest_id'])).'">';
echo htmlspecialchars(stripslashes($row['Name'])).'</a></strong>';
echo '</div>';
echo '<div style="position: absolute; top: 20px; left:15%; width:70%;">';
if(strlen(htmlspecialchars(stripslashes($row['Summary']))) > 250)
echo substr(htmlspecialchars(stripslashes($row['Summary'])), 0, 250).'...';
else
echo htmlspecialchars(stripslashes($row['Summary']));
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
<div class="expandable-tab" id="2" style="top: 160px">
<div class="expandable-tab-header-exp" onclick="loadurl('expand_tab.php', 1, 2, 'EndDate-PrizeR')">
Highest Reward
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

$query = "select Summary, Name, EndDate, Contest_id, PrizeR, Icon from contest order by PrizeR desc";
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
echo '<img src="images/thumb'.$row['Icon'].'.png" class="no-border">';
echo '</div>';
echo '<div style="height:20px; position: absolute; left:15%; width: 70%;">';
echo '<strong><a href="./contest.php?contestid='.htmlspecialchars(stripslashes($row['Contest_id'])).'">';
echo htmlspecialchars(stripslashes($row['Name'])).'</a></strong>';
echo '</div>';
echo '<div style="position: absolute; top: 20px; left:15%; width:70%;">';
if(strlen(htmlspecialchars(stripslashes($row['Summary']))) > 250)
echo substr(htmlspecialchars(stripslashes($row['Summary'])), 0, 250).'...';
else
echo htmlspecialchars(stripslashes($row['Summary']));
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
<div class="push"></div>
<?php
}
?>

</div>

<?php
include('footer.php');
?>

</body>
</html>