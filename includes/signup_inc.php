<?php
include 'global_inc.php';


$submit = $_POST['submit'];
$errormsg = $emptyErr = $passErr = $emailErr = $passErrMissmatch= $userErr = '';
get_all($db);


function user_exists($db,$username) { //checks if username is taken
  $query = "SELECT username FROM kkUserTest WHERE username='$username'";
  $result = $db->query($query);
  return ($result->num_rows > 0);
}
function email_exists($db,$email) { // checks if email is taken
  $query = "SELECT email FROM kkUserTest WHERE email='$email'";
  $result = $db->query($query);
  return ($result->num_rows > 0);
}

function checkForms($db,$username,$password1,$password2,$email,$firstname,$lastname){ // checks form for validity
  global $errormsg;

    if(empty($username) || empty($password1) || empty($password2) || empty($email) || empty($firstname) || empty($lastname)){
      $errormsg = "empty";
       return errorMessage($errormsg);
    }
    elseif($password1 !== $password2){
      $errormsg = "missmatch";
      return errorMessage($errormsg);
    }
    elseif(email_exists($db,$email) > 0) {
      $errormsg = "mail";
      return errorMessage($errormsg);
    }
    elseif(user_exists($db,$username) > 0){
      $errormsg = "user";
      return errorMessage($errormsg);
    }
    // elseif(mysqli_real_escape_string($db,$username) !== $username ){
    elseif (!preg_match('/^[a-z_\-\d]+$/i', $username)) {// regex to check for potential injection problems
      $errormsg = "user2";
      return errorMessage($errormsg);
    }
    else{
      $errormsg = "none";
      return errorMessage($errormsg);
    }
  }

function errorMessage($errormsg){  // determines the error message
  switch ($errormsg) {
    case 'mail':
      global $emailErr;
      $emailErr = "Es gibt bereits einen Account mit dieser E-Mail-Adresse.";
      return false;
      break;
    case 'user':
      global $userErr;
      $userErr = "Dieser Benutzername ist bereits vergeben.";
      return false;
      break;
    case 'user2':
      global $userErr;
      $userErr = "Dieser Benutzername ist ungültig. Erlaubte Zeichen: 'A-Z' '0-9' '_' '-'.";
      return false;
      break;
    case 'missmatch':
      global $passErr;
      $passErr = "Die Passwörter stimmen nicht überein.";
      return false;
      break;
    case 'empty':
      global $emptyError;
      $emptyError = "Bitte alle Felder ausfüllen.";
      return false;
      break;
    default:
      return true;
      break;
  }
}
$status = isset($_POST['submit']);
$firstname = mysqli_real_escape_string($db,$_POST['firstname']);
$lastname = mysqli_real_escape_string($db,$_POST['lastname']);
$email = mysqli_real_escape_string($db,$_POST['email']);
$password1 = mysqli_real_escape_string($db,$_POST['password1']);
$password2 = mysqli_real_escape_string($db,$_POST['password2']);
$username = $_POST['username'];
if($status && checkForms($db,$username,$password1,$password2,$email,$firstname,$lastname)){
    $enc_pass = encrypt($password1,$username); // encrypt password
    $sql = "INSERT INTO kkUserTest (firstname,lastname,email,username,password,reg_date) VALUES ('$firstname','$lastname','$email','$username','$enc_pass',now())";
    if($db->query($sql) === TRUE){ // insert the user to the DB
        echo "<meta http-equiv=refresh content=\"0; URL=login.php\">"; //refresh website
    } else{
      echo "Error. ". $sql . "<br/>" . $db->error;
    }


}elseif($status){
  echo "Error:". $errormsg;

}
?>
