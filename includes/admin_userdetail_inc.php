<div class="row">
  <div class="col-sm-12 ">
      <form id="detail" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <?php

      $selected = isset($_POST['detail']);
      $sel_username =mysqli_real_escape_string($db, $_POST['hidden_username']);
      global $sel_email;
      $sel_mail = mysqli_real_escape_string($db,$_POST['hidden_email']);


      $delete = $_POST['delete'];
      $edit =  $_POST['edit'];

      if($selected){

        echo "<table class='table table-striped'>
        <tr>
        <td><strong>Benutzername</strong></td>
        <td><strong>E-Mail-Adresse</strong></td>
        <td></td>
        </tr>";


        $query = "SELECT DISTINCT e.email, e.username FROM kkUserTest e JOIN kkUserTest m ON e.username='$sel_username'";   // EQUI  SELF JOIN
        $selMail = mysqli_query($db, $query);

        if(!$selMail){
          printf("Error: %s\n", mysqli_error($db));
          exit();
        }

        while ($row = mysqli_fetch_array($selMail)){ // displays selected account

          echo "<tr><td>";
          echo $row['username'];
          echo "</td><td>";
          echo $row['email'];
          echo '</td><td>';
          echo "<input type='hidden' name='selected_edit' value='$sel_username'/>";
          echo'<button type="submit" name="edit" value="'.$sel_username.'" class="btn btn-xs btn-info">Edit</button>
          <button type="submit" name="delete" value="'.$sel_username.'" class="btn btn-xs btn-danger">Delete</button>';
          echo "</td></tr>";
        };
      }
    echo "</table> ";

       ?>
       <input type="hidden" name="del" value="<?php echo htmlspecialchars($sel_username);?>">
        </form>
     </div>
 </div>

    <?php

      if(isset($_POST['delete'])){ // delete button pressed

        $del_username = mysqli_real_escape_string($db,$_POST['del']);
        $del = mysqli_query($db, "DELETE FROM kkUserTest WHERE username='$del_username'"); // deletes selected account from the DB
        if($del){
          echo "<meta http-equiv=refresh content=\"0; URL=admin_user.php\">"; //refresh the page
        }
      }
      if(isset($_POST['edit'])){
        echo '<script>
        $(function(){
          $( "#username" ).hide();
          });
        </script>';
      }

    ?>
