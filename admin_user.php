<?php
// check if user is admin
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] < 2) {
   header('Location: login.php');
   exit();
} ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" media="screen" charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    </head>

  <body>

    <?php
      include 'db.php';
      $sel_mail = $_POST['accounts'];
      $username = $_POST['username'];
      $hidden = true;
      $hiddenemail = $_POST['hiddenemail'];
    ?>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">PHP</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="images.php">Bestellen</a></li>
            <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 2) {  // display admin link if user is admin
              echo '<li class="active"><a href="admin_user.php">Admin</a></li>';
            }?>
          </ul>

          <?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] < 1) { //check if user is logged in
            echo '  <ul class="nav navbar-nav navbar-right">
                <li ><a href="login.php">Login</a></li>
                <li ><a href="signup.php">Registrieren</a></li>
              </ul>';
            }
            else{
              echo '
              <ul class="nav navbar-nav navbar-right">
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> (';
              if(isset($_COOKIE['username'])) {  // display logout info if user is logged in
                  echo $_COOKIE['username'];
              }
              echo ') Logout</a></li>
              </ul>';
            }
          ?>
        </div>
      </div>
    </nav>
  <div class="container">
    <div class="row">
      <div class="col-s-12">
          <h1>Admin Interface</h1>
          <ul class="nav nav-tabs nav-justified">
            <li role="presentation" class="active" ><a href="admin_user.php">Benutzer</a></li>
            <li role="presentation"><a href="admin_img.php">Bilder</a></li>
            <li role="presentation"><a href="admin_order.php">Bestellungen</a></li>
          </ul>
      </div>
    </div>
  </div>
  <div class="container" id="main">

        <div id="user_include">

          <?php if(!isset($_POST['detail']) && !isset($_POST['edit']) && !isset($_POST['change'])){ // default include
              include('includes/admin_user_inc.php');
            }
            if(isset($_POST['detail']) || isset($_POST['delete']) && !isset($_POST['edit'])){ // include detail section if detail button is pressed
              include('includes/admin_userdetail_inc.php');
            }
            if(isset($_POST['edit']) || isset($_POST['change'])){ // include if edit button is clicked
               include('includes/admin_userchange_inc.php');
             }
             ?>
          </div>
    <div class="row">
      <div class="col-md-2">
        <?php
          if(isset($_POST['select']) || isset($_POST['detail']) || isset($_POST['edit']) ){ // display cancel button if user is at least on layer deep
            echo '<form id="detail" action="'.$_SERVER['PHP_SELF'].'" method="post">';
            echo '<button type="submit" name="reset" class="btn btn-danger">Cancel</button>
                  </form>';

            }if(isset($_POST['reset'])){ // reload window if cancel is clicked
              echo '<script>
                 window.location.href = "admin_user.php";
              </script>';
          }
         ?>

      </div>
    </div>
  </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>
