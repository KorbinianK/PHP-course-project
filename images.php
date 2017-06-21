<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] < 1) {
  header('Location: login.php'); // check if user is logged in
   exit();
} ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" media="screen" charset="utf-8">
    </head>
  <body>

    <?php include 'db.php'; ?>

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
          <li class="active"><a href="#">Bestellen</a></li>
          <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 2) {
            echo '<li><a href="admin_user.php">Admin</a></li>';
          }?>
        </ul>

        <?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] < 1) {
          echo '  <ul class="nav navbar-nav navbar-right">
              <li ><a href="login.php">Login</a></li>
              <li ><a href="signup.php">Registrieren</a></li>
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
      <h1>Bilder auswählen</h1>
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="row">
          <?php

            $dirname = "images/gallery/";
            $images = glob($dirname."*.jpg");
            $counter = 0;
            $query = mysqli_query($db,'SELECT * FROM kkImageDB WHERE active="1"');
            $dir = "images/gallery/";
            $sel = $_POST['sel'];

            while ($images = mysqli_fetch_array($query)){
              $current_img = $dir.$images['filename'];
              $filename =$images['filename'];
              $price = $images["price"];
              echo '<div class="col-sm-3">';
                echo '<div class="thumbnail">';
                  echo '<label class="image-cont" >';
                  echo "<input type='hidden' name='price[$filename]' value='$price'/>";
                    echo '<input type="checkbox" name="sel[]" id="selected_'.$counter.'" value="'.$filename.'"/>';
                    echo '<img src="'.$current_img.'" />';
                    echo ' <div class="after"><img src="images/tick.png"/></div>';
                  echo "</label>";
                  echo '<div class="caption">
                  <p><strong>€ '.$images["price"].'</strong></p>';
                    if($images["description"] != NULL){
                      echo '<p><small>'.$images["description"].'</small></p>';
                    }
                    echo '<p><small>'.$images["filename"].'</small></p>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
              $counter++;
            }
            ?>

          </div>

          <div class="row">
            <div class="col-sm-12">
              <?php
              if($counter >0){
                echo '<button class="btn btn-info" type="submit" name="submit"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>Bestellen</button>';
              } else{
                echo 'Keine Bilder verfügbar :(';
              }
              ?>        </div>


          </div>

          <div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" id="image-card" aria-labelledby="image-card">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Warenkorb</h4>
              </div>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <div class="modal-body">

                <?php
                  
                   $sum=0;
                  if(sizeof($sel)>0){

                    echo '<table class="table table-condensed">
                      <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Preis</strong></td>

                      </tr>';
                   foreach($_POST['sel'] as $selected) {
                          $sum+=$_POST["price"]["$selected"];
                            echo '
                            <tr>
                                <td>'.$selected.'</td>
                                <td>€'.$_POST["price"]["$selected"].'</td></tr>';
                    }
                    $data=serialize($_POST['sel']);
                    $encoded=htmlentities($data);
                    echo '<input type="hidden" name="sel_send" value="'.$encoded.'">';
                    echo '<input type="hidden" name="sel_sum" value="'.$sum.'">';
                  }else{
                    echo "<p>Keine Bilder ausgewählt.</p>";
                  }
                  echo '<td></td><td class=""> <strong>Gesamt: €'.$sum.'</strong></td></table>';
                ?>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                <button type="submit" name="order" class="btn btn-primary">Bestellen</button>
              </div>
            </form>
            </div>
           </div>
         </div>

          <?php

          if(isset($_POST['order'])){
            $arr = unserialize($_POST['sel_send']);
            $current_user = $_COOKIE['username'];
            $sum = $_POST['sel_sum'];
            $sqls = "SELECT user_id FROM kkUserTest WHERE username='$current_user'";
            $get_userid = $db->query($sqls);

            if($get_userid){
              while($row = mysqli_fetch_array($get_userid)){
                $current_id = $row['user_id'];
              }

            foreach($arr as $order) {
              $values[] = mysqli_real_escape_string($db,"$order");
              }
              $value = implode(",", $values);

              $create_order = "INSERT INTO kkOrdersDB (user_id,images,order_date,price) VALUES ('$current_id','$value',now(),$sum)";
              if($db->query($create_order)===TRUE){
                $last_id = $db->insert_id;
                echo   $last_id."added";
              } else{
                echo "Error. ". $sql . "<br/>" . $db->error;
              }

              echo $order_id;
            } else{
              echo "Error. ". $sql . "<br/>" . $db->error;
            }

          }
              if(isset($_POST['submit'])){
              echo "<script>
                     $('#image-card').modal('toggle');
                   </script>";

            } ?>

       </form>
      </div>
    <!-- </div> -->

  </body>
</html>
