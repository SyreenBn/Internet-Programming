<?php
//$conn= new mysqli('cse-curly.cse.umn.edu','F17CS4131U8','2286','F17CS4131U8','3306');
$msg1 = Null;
$edit_id = Null;
function add_user($user_name, $user_login, $user_password){
  $conn= new mysqli('cse-curly.cse.umn.edu','F17CS4131U8','2286','F17CS4131U8','3306');
  $select_q = "SELECT * FROM tbl_accounts WHERE acc_login ='".$user_login."';";
  $r = $conn->query($select_q);
  $count = mysqli_num_rows($r);
  //echo $count."HHHHHHHHHHHHHIIII";
  if ($count > 0 ){
  $msg = "This login is used by another user";
//  echo "I aam in zero situation";
  return  0;
} else {
//  echo "I am in 1 sutation";
  $add_query ="INSERT INTO tbl_accounts (acc_name, acc_login, acc_password)
               VALUES ('".$user_name."', '".$user_login."', '". sha1($user_password)."');";
  if ($conn->query($add_query)){
    // $msg = "Account added Successfully";
     return  1;
  }
}
}

function edit($EditId){
  $edit_id = $EditId;
}

function update_user($update_id,$new_user_name, $new_user_login, $new_user_password){
  $conn= new mysqli('cse-curly.cse.umn.edu','F17CS4131U8','2286','F17CS4131U8','3306');
  $select_q1 = "SELECT * FROM tbl_accounts WHERE acc_login ='".$new_user_login."';";
  $r1 = $conn->query($select_q1);
  $count1 = mysqli_num_rows($r1);
  if ($count1 > 0 ){
  $msg1 = "This login is used by another user";
  return 0;
  } else {
  $update_query = "UPDATE tbl_accounts
                   SET acc_name='".$new_user_name."',
                       acc_login='".$new_user_login."',
                       acc_password='".sha1($new_user_password)."'
                   WHERE acc_id='".$update_id."';";
  if ($conn->query($update_query)){
     $msg = "Account updated Successfully";
     return 1;
  } else{
    $conn->connect_error;
  }
}
}

function delete_user($user_id){
  $conn= new mysqli('cse-curly.cse.umn.edu','F17CS4131U8','2286','F17CS4131U8','3306');
  $del_query ="DELETE FROM tbl_accounts WHERE acc_id ='".$user_id."';";
  $result = $conn->query($del_query);
  if ($result === True){
      $add_msg = "Account deleted Successfully";
  } else {
    echo $conn -> error;
  }
}

function list_of_rows($edit_id){
  $conn= new mysqli('cse-curly.cse.umn.edu','F17CS4131U8','2286','F17CS4131U8','3306');
  $all_rows = "";
  $squery = "SELECT acc_id, acc_name, acc_login FROM tbl_accounts";

  if ($conn->connect_error){
  echo  die("Could not connect to database </body></html>" );
  } else {
  $result = $conn->query($squery);
  }
  $row = mysqli_fetch_row( $result );
 while ( $row = mysqli_fetch_row( $result ) )
 {
   if ($edit_id == $row[0]){
     $all_rows =  $all_rows."<tr><form method = 'post' action='admin.php'>
               <td>".$row[0]."</td>
               <td> <label> <input name = 'new_name' type ='text' value = '".$row[1]."'></label></td>
               <td> <label> <input name = 'new_login' type ='text' value = '".$row[2]."'></label></td>
               <td> <label> <input name = 'new_password' type ='text' value = ''></label> </td>
               <td> <input value= 'update' name='action' type='submit' >
               <input  type='hidden' name='deleteItem' value='".$row['0']."' />
               <input value= 'cancel' name='action' type='submit'> </td>
               </form> </tr>";
   } else {
      $all_rows =  $all_rows."<tr><form method = 'post' action='admin.php'>
               <td>".$row[0]."</td>
               <td>".$row[1]."</td>
               <td>".$row[2]."</td>
               <td> </td>
               <td>
               <input value= 'edit' name='action' type='submit'>
               <input value= 'delete' name='action' type='submit' >
               <input  type='hidden' name='deleteItem' value='".$row['0']."' />  </td>
               </form> </tr>";
       }
 } // end while
 $conn->close();
return $all_rows;
}
 ?>
