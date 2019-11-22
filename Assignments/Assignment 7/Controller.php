<?php

include './Model.php';

$add_msg = "";
$add_error = "";
$edit_id = Null;

function recive_action($post_acion,
                       $post_deleteItem,
                       $post_new_name,$post_new_login,$post_new_password,
                       $post_name,$post_login,$post_password){
 if(isset($post_acion)){
   $action = $post_acion;
 } else {
   $action = "list_of_rows";
 }
 if($action =='delete'){
   $id = $post_deleteItem;
   delete_user($id);
   $msg = "Account delteted successfully";
   echo list_of_rows($edit_id)."<br><p>".$msg."</p><br>";
 } else if($action =='edit'){
   $edit_id = $post_deleteItem;
   edit($edit_id);
   echo list_of_rows($edit_id);
 } else if($action =='add'){
    $user_name = $post_name;
    $user_login = $post_login;
    $user_password = $post_password;
  //  echo add_user($user_name, $user_login, $user_password);
    if ( add_user($user_name, $user_login, $user_password) == 1){
      $msg = "Account added successfully";
      echo list_of_rows($edit_id)."<br><p>".$msg."</p><br>";
    } else {
    $msg = "This login is used by another user";
    echo list_of_rows($edit_id)."<br><p>".$msg."</p><br>";
  }

 } else if ($action =='update'){
    $update_id = $post_deleteItem;
    $edit_id = Null;
    $new_user_name = $post_new_name;
    $new_user_login = $post_new_login;
    $new_user_password = $post_new_password;
    if (update_user($update_id,$new_user_name, $new_user_login, $new_user_password) == 1){
    $msg = "Account updated successfully";
    echo list_of_rows($edit_id)."<br><p>".$msg."</p><br>";
  } else {
    $msg = "This login is used by another user";
    echo list_of_rows($edit_id)."<br><p>".$msg."</p><br>";
  }
 } else if ($action =='list_of_rows'){
   echo list_of_rows($edit_id)."<br><p>".$msg."</p><br>";
 }
}

?>
