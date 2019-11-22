<?php
   session_start();

   if(session_destroy()) {
      header("Location: login.php");
   }
   // session_start();
   // unset($_SESSION['user_account']);
  //  // unset($_SESSION['password']);
  //  session_destroy()
  //  if (unset($_SESSION)){
  //  header("Location: login.php");
// }

?>
