

<?php
include "./db.php";
include 'includes/global_inc.php';

function chash_equals($fetched ,$password,$username){
  $result = encrypt($password,$username);
  if($result === $fetched){
    return true;
  }
  return false;
}


if(isset($_POST['login'])){ //login button pressed
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $result = mysqli_query($db, "SELECT password FROM kkUserTest WHERE username = '$username'  ");
    echo "<table class='table table-striped'>";
    if ($result->num_rows > 0) {
      while($row = $result->fetch_array()) { // checks if user exists
          $fetched = $row['password'];
          if(chash_equals($fetched,$password,$username)){
            session_start();
            $fetch_role = mysqli_query($db, "SELECT role FROM kkUserTest WHERE username = '$username'  "); // gets the role of the user
              while($row2 = $fetch_role->fetch_array()) {
                $role = $row2['role'];
                if ($role == 0){
                  $_SESSION['auth'] = 1;
                }elseif($role  == 2){
                  $_SESSION['auth'] = 2;
                }
                setcookie("username", $username, time()+(84600*30)); // cookie for the session
                header('Location: images.php');  //redirect page
                exit();
              }

          }
          else{
            echo "Passwort oder Benutzername falsch";
          }
      }
    } else {
        echo "Passwort oder Benutzername falsch";
    }
    echo "</table>";


  }
 ?>
