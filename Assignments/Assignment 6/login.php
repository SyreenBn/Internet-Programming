
<?php
session_start();

//include("insertValues_HW6F17.php");
include("database_HW6F17.php");
//include("createTables_HW6F17.php");

error_reporting(E_ALL);
ini_set( 'display_errors','1');
$errormsg = "";
if (!empty($_POST)){
  $UR = trim($_POST['username']);
  $PW = trim ($_POST['password']);
  if ( $UR == "" && $PW == "") {
    $errormsg = "Please, enter a valid value for the Login field \n";
    echo $errormsg;
    echo "<br>";
    $errormsg = "\n Please, enter a valid value for the Password field";
    echo $errormsg;
  } elseif ($UR == "") {
    $errormsg = "Please, enter a valid value for the Login field \n";
    echo $errormsg;
    echo "<br>";
  } elseif ($PW == "") {
    $errormsg = "\n Please, enter a valid value for the Password field";
    echo $errormsg;
  } else {  $errormsg = "";
    if ($errormsg == ""){
      // $myusername = mysqli_real_escape_string($con,$_POST['username']);
      // $mypassword = mysqli_real_escape_string($con,$_POST['password']);
      //echo 1;
      $con= new mysqli('cse-curly.cse.umn.edu','F17CS4131U8','2286','F17CS4131U8','3306');
      // Check connection
      if($con->connect_error){
        echo"error connecting";
      }else{
      $sql = "SELECT * FROM tbl_accounts WHERE acc_login = '".$UR."';";
      $result = $con->query($sql);
      $row = mysqli_fetch_row($result);
      $count = mysqli_num_rows($result);
      if ($count > 0){
      $sql1 = "SELECT * FROM tbl_accounts WHERE acc_login = '".$UR."'"."AND acc_password ='".sha1($PW)."';";
      $result1 = $con->query($sql1);
      $row1 = mysqli_fetch_row($result1);
      $count1 = mysqli_num_rows($result1);
        if ($count1 == 1){
            $_SESSION['user_account'] = $UR;
            $_SESSION['password'] = $PW;
            header("location: MyCalendar.php");
        } else {
          $error = "Your Password is incorret, please check the password and try again";
          echo $error;
        }
      } else {
       $error = "Your Login Name or Password is invalid";
        echo $error;
      }

      // $sql1 = "SELECT acc_password FROM tbl_accounts WHERE acc_login = '".$UR."';";
      // $result1 = $con->query($sql);
      // echo $result1;
      // if ($row[7] == sha1($PW)){
      //   echo "hi";
      //   $_SESSION['user_account'] = $UR;
      //   $_SESSION['password'] = $PW;
      //   //header("location: MyCalendar.php");
      // } else {
      // //  $error = "Your Login Name or Password is invalid";
      //   $error = "Your Login Name or Password is invalid";
      //   echo $error;}

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

<title> Login Page</title>
</head>
<body>
<h1> Login Page </h1>

<div style="color:red"></div>
<div>
<form method = "post" action="login.php">
<table class="login">
<tr>
<td> Login</td>
<td><input type="text" name="username"></td>
</tr>
<tr>
<td>Password</td>
<td><input type="text" name="password"></td>
</tr>

<tr>
<td><input type="submit" name="Submit" value="Submit" method="post"></td>
</tr>
</table>
</form>
</div>
</body>
</html>
