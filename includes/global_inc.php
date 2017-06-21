<?php
// takes password and encrypts it
  function encrypt($password,$salt){
    $hashed = hash('sha256', $password . $salt);
    return $hashed ;
  }
 ?>
