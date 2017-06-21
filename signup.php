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
      .text-danger{
        font-weight: bold;
      }
    </style>

    </head>

  <body>

    <?php
      include 'db.php';
      include 'includes/signup_inc.php';
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
              echo '<li class="active"><a href="admin_user.php">Admin</a></li>';
            }?>
          </ul>
          <?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] < 2) {
            echo '  <ul class="nav navbar-nav navbar-right">
                <li><a href="login.php">Login</a></li>
                <li class="active"><a href="#">Registrieren</a></li>
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
      <h1>Signup Form</h1>
      <div class="col-md-offset-2 col-md-8">
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="form-group">
            <label for="inputFirstname" class="col-sm-4 control-label">Vorname</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname?>"placeholder="Vorname">
            </div>
          </div>
          <div class="form-group">
            <label for="inputLastname" class="col-sm-4 control-label">Nachname</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname?>"placeholder="Nachname">
            </div>
          </div>
          <div class="form-group">

            <label for="inputEmail" class="col-sm-4 control-label">E-Mail</label>
            <div class="col-sm-8">
              <span class="text-danger"><?php echo $emailErr;?></span>
              <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo $email?>"placeholder="E-Mail">
            </div>
          </div>
          <div class="form-group">

            <label for="inputUsername" class="col-sm-4 control-label">Benutzername</label>
            <div class="col-sm-8">
              <span class="text-danger"><?php echo $userErr;?></span>
              <input type="text" class="form-control" id="inputUsername" name="username" value="<?php echo $username?>"placeholder="Benutzername">
            </div>
          </div>
          <div class="form-group">

            <label for="inputPassword1" class="col-sm-4 control-label" value="<?php echo $password1?>">Passwort</label>
            <div class="col-sm-8">
              <span class="text-danger"><?php echo $passErr;?></span>
              <input type="password" class="form-control" id="inputPassword1" name="password1" value="<?php echo $password1?>"placeholder="Passwort ">
            </div>

          </div>
          <div class="form-group">

            <label for="inputPassword2" class="col-sm-4 control-label">Passwort wiederholen</label>
            <div class="col-sm-8">
              <span class="text-danger"><?php echo $passErrMissmatch;?></span>
              <input type="password" class="form-control" id="inputPassword2" name="password2" value="<?php echo $password2?>"placeholder="Passwort wiederholen">
            </div>

          </div>
        <div class="row">
          <div class="form-group">
            <div class="col-sm-10">
              <button type="submit" name="submit" class="btn btn-primary">Registrieren</button>
              <button type="reset" class="btn btn-danger">Reset</button>
            </div>
          </div>
        </div>

        </form>

      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>
