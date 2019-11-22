

<?php

session_start();
if (!isset($_SESSION['user_account']) || !isset($_SESSION['password'])){
    header("location:login.php");
 } else {

class event{
public $eventname="";
public $starttime="";
public $endtime="";
public $location="";
public $BuildingPic="";
}

function eventsort($e1, $e2){
	$ev1 = strtotime($e1 -> starttime);
	$ev2 = strtotime($e2 -> starttime);
	if ($ev1 > $ev2){
		return 1;
	} else if ($ev1 < $ev2) {
		return -1;
	} else {
		return 0;
	}
	}

$errormsg = "";
if (!empty($_POST)){
	if(isset($_POST['Clear'])){
	unlink('calendar.txt');
	header('location:MyCalendar.php');
	$myfile = fopen("calendar.txt", "w");
	//wb
	fclose($myfile);
} else {
	// do all error //*********************************************************************
	if ($_POST['eventname'] == ""){
		$errormsg = "Event Name is empty, please re-enter the event again";
		echo $errormsg;
	} elseif ($_POST['starttime'] == ""){
		$errormsg = "Start Time is empty, please re-enter the event again";
		echo $errormsg;
	} elseif ($_POST['endtime'] == ""){
		$errormsg = "End Time is empty, please re-enter the event again";
		echo $errormsg;
	} elseif ($_POST['location'] == ""){
		$errormsg = "Location is empty, please re-enter the event again";
		echo $errormsg;
	} elseif ($_POST['$BuildingPic'] == ""){
		$errormsg = "Building Picture name is empty, please re-enter the event again";
		echo $errormsg;
	} else {
		$errormsg = "";

	if ($errormsg == ""){
	$filename = "calendar.txt";
	$myfile = fopen($filename,"r");
	$events = file_get_contents ('calendar.txt');
	//echo $events;
	$events = json_decode($events, true);
	if (!isset($events)){
	$events = array();
}
	if(!isset($events[$_POST['day']])){
	$events[$_POST['day']] = array();
	}
	$newevent = new Event;
	$newevent -> eventname = $_POST['eventname'];
	$newevent -> starttime = $_POST['starttime'];
	$newevent -> endtime = $_POST['endtime'];
	$newevent -> location = $_POST['location'];
	$newevent -> BuildingPic = $_POST['$BuildingPic'];
	$events[$_POST['day']][]= $newevent;
	asort($events[$_POST['day']], "eventsort"); // "compare"
	$events = json_encode($events);
	fclose($myfile);
	$filename = "calendar.txt";
	// to make the file weitable, I have to change the mod
	// chmod a+w calenar.txt
	if (is_writable($filename)) {
	$myfile = fopen($filename, "w");
	fwrite($myfile, $events);
	fclose($myfile);
  header('location:MyCalendar.php');
	exit();
}
else{
echo "the file is not writable";
}
}
}
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">

<title>Calendar Input</title>
</head>
<body>
<h1>Calendar Input</h1>
<?php
echo '<p>';
echo "WELCOME  ".$_SESSION['user_account'] ;
echo '<br>';

echo '<form name="logout" method="post" action="logout.php">';
  echo '<label>';
    echo '<input name="logout" type="submit" id="logout" value="log out">';
  echo '</label>';
echo '</form>';

echo '</p>';
?>

<nav id="navmenu">
<ul>
<li><a href="MyCalendar.php">Calendar</a></li>
<li><a href="MyForm.php">Input</a></li>
<li><a href="admin.php">Admin</a></li>
</ul>
</nav>
<div style="color:red"></div>
<div>
<form method = "post" action="MyForm.php">
<table class="form">
<tr>
<td>Event Name</td>
<td><input type="text" name="eventname"></td>
</tr>
<tr>
<td>Start Time</td>
<td><input type="time" name="starttime"></td>
</tr>
<tr>
<td>End Time</td>
<td><input type="time" name="endtime"></td>
</tr>
<tr>
<td>Location</td>
<td><input type="text" name="location"></td>
</tr>
<tr>
<td>Day of the week</td>
<td>
<select name="day">
<option value="Mon">Mon</option>
<option value="Tue">Tue</option>
<option value="Wed">Wed</option>
<option value="Thur">Thur</option>
<option value="Fri">Fri</option>
</select>
</td>
</tr>
<tr>
<td> Building Picture Name</td>
<td><input type="text" name="$BuildingPic"></td>
</tr>
<tr>
<td><input type="submit" name="Clear" value="Clear"></td>
<td><input type="submit" name="Submit" value="Submit"></td>
</tr>
</table>
</form>
</div>
</html>
