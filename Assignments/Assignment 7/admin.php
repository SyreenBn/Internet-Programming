<!DOCTYPE html>

<!-- Fig. 19.16: database.php -->
<!-- Querying a database and displaying the results. -->


<?php
session_start();
if (!isset($_SESSION['user_account']) || !isset($_SESSION['password'])){
   header("location:login.php");
 }
include './Controller.php';

?>
<html>
   <head>
      <meta charset = "utf-8">
      <title>Search Results</title>
      <link rel="stylesheet" type="text/css" href="style.css">
   </head>
   <body>
     <?php
       echo " <h1> </h1> ";
        echo '<p>';
        echo "WELCOME  ".$_SESSION['user_account'] ;
        echo '<br>';
        ?>
     <form name="logout" method="post" action="logout.php">
       <label>
         <input name="logout" type="submit" id="logout" value="log out">
       </label>
     </form>

     <p>
     </p>

     <p> This page is protected from public, and you can see a list of all users defined in the database
     </p>

     <p>
     </p>

     <nav id="navmenu">
     <ul>
     <li><a href="MyCalendar.php">Calendar</a></li>
     <li><a href="MyForm.php">Input</a></li>
     <li><a href="admin.php">Admin</a></li>
     </ul>
     </nav>
      <br>
      <h1> List of User </h1>
      <br>
      <p>
      </p>
      <table>
        <tr>
          <th> User_Id </th>
          <th> User_Name </th>
          <th> User_Login </th>
          <th> User_New_Password </th>
          <th> Action </th>
        </tr>
         <?php
         echo recive_action($_POST['action'],
                            $_POST['deleteItem'],
                            $_POST['new_name'],$_POST['new_login'],$_POST['new_password'],
                            $_POST['name'],$_POST['login'],$_POST['password']).$msg;
          ?>
      </table>
      <br>
      <h1> Add New User </h1>
      <form method = "post" action="admin.php">
      <table class="form">
      <tr>
      <td>Name:</td>
      <td><input type="text" name="name"></td>
      </tr>
      <tr>
      <td>Login:</td>
      <td><input type="text" name="login"></td>
      </tr>
      <tr>
      <td>Password:</td>
      <td><input type="text" name="password"></td>
      </tr>
      <tr>
      <td><input type="submit" name="action" value="add"></td>
      </tr>
      </table>
      </form>
   </body>
</html>
