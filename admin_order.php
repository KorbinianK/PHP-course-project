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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>

  <body>

    <?php
      include 'db.php';
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
            <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 2) { // display admin link if user is admin
              echo '<li class="active"><a href="admin_user.php">Admin</a></li>';
            }?>
          </ul>

          <?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] < 1) {  //check if user is logged in
            echo '  <ul class="nav navbar-nav navbar-right">
                <li ><a href="login.php">Login</a></li>
                <li ><a href="signup.php">Registrieren</a></li>
              </ul>';
            }
            else{
              echo '
              <ul class="nav navbar-nav navbar-right">
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> (';
              if(isset($_COOKIE['username'])) { // display logout info if user is logged in
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
            <li role="presentation"><a href="admin_user.php">Benutzer</a></li>
            <li role="presentation"><a href="admin_img.php">Bilder</a></li>
            <li role="presentation" class="active"><a href="#">Bestellungen</a></li>
          </ul>
      </div>
    </div>
  </div>
  <div class="container" id="main">
    <div id="order_include">
      <?php
        $sql = "SELECT * FROM kkOrdersDB o JOIN kkUserTest u ON o.user_id = u.user_id";
        $get_orders = $db->query($sql); // get all orders from DB

        if($get_orders && mysqli_num_rows($get_orders) > 0){ // if orders exist, display them
          // echo '<form id="" action="'.$_SERVER['PHP_SELF'].'" method="post">';
          echo "<table id='orders' class='table table-striped'>
            <tr class='firstrow'>
            <td><strong>#</strong></td>
            <td><strong>Gesamtpreis</strong></td>
            <td><strong>Benutzername</strong></td>
            <td><strong>Vorname</strong></td>
            <td><strong>Nachname</strong></td>
            <td><strong>E-Mail-Adresse</strong></td>
            <td><strong>Bilder</strong></td>
            <td></td>
            </tr>";
          while($row = mysqli_fetch_array($get_orders) ){
            echo '<form id="" action="'.$_SERVER['PHP_SELF'].'" method="post">';

              echo"<tr><td>";
              echo $row['order_id'];
              echo "</td><td>";
              echo "€ ".$row['price'];
              echo "</td><td>";
              echo $row['username'];
              echo "</td><td>";
              echo $row['firstname'];
              echo "</td><td>";
              echo $row['lastname'];
              echo "</td><td>";
              echo $row['email'];
              echo "</td><td>";
              foreach (explode(",",$row['images']) as $key ) { // list the ordered images
              echo $key."<br/>";
              }
              echo "</td><td>";
              echo "<input type='hidden' name='hidden' value='".$row['order_id']."'/>";
              echo "<input type='hidden' name='paid' value='".$row['paid']."'/>";

              echo "<button type='submit' name='delete_btn' class='btn btn-xs btn-primary'>Löschen</button><br>";

              if($row['paid']){
                echo "<button type='submit' name='unpaid_btn' class='btn btn-xs btn-danger'>Bezahlt</button>";
              }else{
                echo "<button type='submit' name='paid_btn' class='btn btn-xs btn-success'>Nicht bezahlt </button>";
              }

              echo "</td></tr></form>";
          }
        }
        elseif($get_orders){ // if no orders exist
          echo "Keine Bestellungen.";
        }else{
          echo "Error. ". $sql . "<br/>" . $db->error;
        }
       ?>
     </table>
   </div>
  </div>
  <div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" id="warning-modal" aria-labelledby="image-card">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Warenkorb</h4>
      </div>
      <div class="modal-body">
        <p>Du kannst keine unbezahlten Bestellungen löschen!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
      </div>
    </div>
   </div>
 </div>

  <div class="container" id="cancel_div">
    <div class="row">
      <div class="col-md-2">
        <?php
          if(isset($_POST['select']) || isset($_POST['edit'])){   // display cancel button if user is at least on layer deep
            echo '<form id="detail" action="'.$_SERVER['PHP_SELF'].'" method="post">';
            echo '<button type="submit" name="reset" class="btn btn-danger">Cancel</button>
                  </form>';
            if(isset($_POST['reset'])){ // reload window if cancel is clicked
              echo '<script>
                 window.location.href = "admin_order.php";
              </script>';
            }
          }
          if(isset($_POST['delete_btn']) ){ // delete button pressed
            $clicked = $_POST['hidden'];
            if($_POST['paid']){
              echo "paid";
              $sql ="DELETE FROM kkOrdersDB WHERE order_id='$clicked'"; // deletes the order from  DB
              if($db->query($sql)===TRUE){
                echo "Fehler: ";
                echo "<meta http-equiv=refresh content=\"0; URL=admin_order.php\">"; //reloads the page
                }else{
                  echo "Fehler: ". $db->error;
                }
            }else{

              echo "<script>
                     $('#warning-modal').modal('toggle');
                   </script>";
            }
            }
          if(isset($_POST['paid_btn'])){ // paid button pressed
            $clicked = $_POST['hidden'];

            $sql ="UPDATE kkOrdersDB SET paid=1 WHERE order_id='$clicked'"; // sets the paid state to paid in DB
            if($db->query($sql)===TRUE){
              echo "<meta http-equiv=refresh content=\"0; URL=admin_order.php\">"; //reloads the page
              }else{
                echo "Fehler: ". $db->error;
              }
            }
          if(isset($_POST['unpaid_btn'])){ // unpaid button pressed
              $clicked = $_POST['hidden'];

             $sql ="UPDATE kkOrdersDB SET paid=0 WHERE order_id='$clicked'"; // sets the paid state to unpaid in DB
             if($db->query($sql)===TRUE){
              echo "<meta http-equiv=refresh content=\"0; URL=admin_order.php\">"; //reloads the page
               }else{
                 echo "Fehler: ". $db->error;
               }
             }
         ?>
      </div>
    </div>
  </div>
  </body>
</html>
