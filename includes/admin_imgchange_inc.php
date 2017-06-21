<div class="row">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="col-sm-8">
      <div class="" id="username">

           <input type='hidden' name="hiddenemail" value="<?php echo htmlspecialchars($sel_img); ?>">
           <input type="text" class="form-control" placeholder="New username" name="newusername" value=<?php echo $sel_username; ?>>
      </div>
    </div>
     <div class="form-group">
       <div class="col-sm-2">
         <button type="submit" name="change" class="btn btn-primary">Change</button>
       </div>
     </div>
   </form>
 </div>
   <?php

   $changed = isset($_POST['change_img']); // change button pressed
   if($changed){
    //  echo $sel_username;
    //  echo $sel_email;
     $mail = $_POST['hiddenemail'];
     $new_username = $_POST['newusername'];
    //  echo $new_username;
     $sql = "UPDATE kkUserTest SET username='$new_username' WHERE email='$mail'"; //updates username in DB
     if($db->query($sql) === TRUE){
       echo '<script>
          window.location.href = "admin.php";
       </script>';

     } else{
       echo "Error. ". $sql . "<br/>" . $db->error;
     }

   }
    ?>
