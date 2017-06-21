<div class="row">
  <div class="col-sm-12">

      <?php

      $all_accounts = mysqli_query($db, "SELECT * FROM kkUserTest"); //gets all accounts from DB
      if(!$all_accounts){
        printf("Error: %s\n", mysqli_error($db));
        exit();
      }
      $count_rows = 0;
      echo "<table id='accounts' class='table table-striped'>
      <tr>
      <td><strong>Benutzername</strong></td>
      <td><strong>Vorname</strong></td>
      <td><strong>Nachname</strong></td>
      <td><strong>E-Mail-Adresse</strong></td>
      <td></td>
      </tr>";
      while ($accounts = mysqli_fetch_array($all_accounts)){ //displays all accounts in table
        $all_rows = $all_accounts->num_rows;
        global $found_accounts;
          if($accounts['role']==0){
            $mail = mysqli_real_escape_string($db,$accounts['email']);
            $user = mysqli_real_escape_string($db,$accounts['username']);
            echo '<form id="" action="'.$_SERVER['PHP_SELF'].'" method="post">';
            echo "<tr class='details'>";
            echo '<form id="" action="'.$_SERVER['PHP_SELF'].'" method="post">';
            echo "<input type='hidden' name='hidden_email' value='".$mail."'>
            <input type='hidden' name='hidden_username' value='".$user."'>";
            echo"

            <td>";
            echo $user;
            echo "</td><td>";
            echo mysqli_real_escape_string($db,$accounts['firstname']);
            echo "</td><td>";
            echo mysqli_real_escape_string($db,$accounts['lastname']);
            echo "</td><td>";
            echo $mail;
            echo "</td>
            <td>  <button type='submit' name='detail' class='btn btn-xs btn-primary' >Details</button></td> </form></tr>";
          $count_rows++;
          }
        }
          echo "</table>";
       if($count_rows >= 1){
        //  echo '<div class="form-group">
        //    <div class="col-sm-10">
        //      <button type="submit" name="select" class="btn btn-primary">Select</button>
        //    </div>
        //  </div>';
       }

        ?>

  </div>
</div>
