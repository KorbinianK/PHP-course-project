<?php $to_change = $_POST['selected_edit'] ?>

<div class="row">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="col-sm-8">
      <div class="" id="username">
        <h4>Benutzernamen von <strong><?php echo $to_change; ?> </strong>ändern:</h4>
           <input type='hidden' name="username" value="<?php echo htmlspecialchars($to_change); ?>">
           <input type="text" class="form-control" placeholder="New username" name="newusername" value=<?php echo $to_change; ?>>
      </div>
    </div>
     <div class="form-group">
       <div class="col-sm-2">
         <button type="submit" name="change" class="btn btn-primary">Ändern</button>
       </div>
     </div>
   </form>
 </div><br>
   <?php

   $changed = isset($_POST['change']);  //change button pressed
   if($changed){

     $username = $_POST['username'];
     $new_username =  mysqli_real_escape_string($db,$_POST['newusername']);

     $sql = "UPDATE kkUserTest SET username='$new_username' WHERE username='$username'"; //updates the username in the DB
     if($db->query($sql) === TRUE){
      //  echo '<script>
      //     window.location.href = "admin_user.php"; // go back to the overview
      //  </script>';

     } else{
       echo "Error. ". $sql . "<br/>" . $db->error;
     }

   }
    ?>
