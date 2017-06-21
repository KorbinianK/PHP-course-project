<?php
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <style media="screen">
      .jumbotron{
        margin-left: 60px;
        margin-right: 60px;
      }
    </style>

    </head>

  <body>

    <?php
      include 'db.php';
      include 'includes/login_inc.php';
      $submit = $_POST['submit'];
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
            <li ><a href="images.php">Bestellen</a></li>
            <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 2) {
              echo '<li><a href="admin_user.php">Admin</a></li>';
            }?>
          </ul>

          <?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] < 2) {
            echo '  <ul class="nav navbar-nav navbar-right">
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Registrieren</a></li>
              </ul>';
            }
            else{
              echo '
              <ul class="nav navbar-nav navbar-right">
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> (';
              if(isset($_COOKIE['username'])) {
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
      <div class="jumbotron">
      <div class="container">
        <h2 class="text-info">Herzlich Willkommen!</h2>
        <h4>Foto-shop Regensburg</h4>
        <p >
          Qualitätsaufnahmen sofort digital bestellen.
        </p>
        <p>
          <a class="btn btn-primary btn-lg" href="images.php" role="button">Zu den Bildern</a>
        </p>
      </div>
    </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>
