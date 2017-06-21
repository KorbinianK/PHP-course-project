<div class="row">
<div class="col-sm-12">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="window.location.reload()">

    <?php


    if (isset($_POST['refresh_db'])){ // check if refresh is pressed
      $imgdir = 'images/gallery/';
      $allowed_filetypes = array('png','jpg','jpeg');
      $folder = opendir($imgdir);
      while($file = readdir($folder)){  // gets all images from folder
        if( in_array(strtolower(substr($file,-3)),$allowed_filetypes) OR
        in_array(strtolower(substr($file,-4)),$allowed_filetypes) ){
          $img_array[] = $file;
        }
      }
      echo "<ul>";
      $allimg = count($img_array);
      $updated = 0;
      for($x=0; $x < $allimg; $x++){
        $check = mysqli_query($db,"SELECT filename FROM kkImageDB WHERE filename='$img_array[$x]'"); // checks if the found images are already in the DB
        if(mysqli_num_rows($check) > 0){
        }else{
          $update_img = "INSERT INTO kkImageDB (filename,active,upload_date) VALUES ('$img_array[$x]',0,now())";
          if($db->query($update_img) === TRUE){ //adds missing images to DB
            $updated++;
          } else{
            echo "Error. ". $sql . "<br/>" . $db->error;
          }
        }
      }
        echo "<meta http-equiv=refresh content=\"0; URL=admin_img.php\">"; // reloads the page
    }


    echo "<table id='images' class='table table-striped'>
    <tr>
    <td><strong>Vorschau</strong></td>
    <td><strong>Name</strong></td>
    <td><strong>Preis</strong></td>

    <td><strong>Upload Datum</strong></td>
    <td><strong>Freigegeben</strong></td>
    <td></td>
    </tr>";
    $images = mysqli_query($db, "SELECT * FROM kkImageDB"); // gets all images from DB
    if(!$images){
      printf("Error: %s\n", mysqli_error($db));
      exit();
    }
    $count_rows = 0;
    while ($img = mysqli_fetch_array($images)){ // displays all images
      $all_rows = $images->num_rows;
      $filename = $img['filename'];
      $price = $img['price'];
      global $found_images;
          echo "<tr class='details'>
          <td><img class='mini_img' src='images/gallery/".$img['filename']."'/></td>
          <td>";
          echo $img['filename'];
          echo "</td><td>";
          echo "<input class='form-control input-sm' name='price[$filename]' type='number' step='0.1' value='$price' >";
          echo "</td><td>";
          // echo $img['description'];
          // echo "</td><td>";
          echo $img['upload_date'];
          echo "</td><td>";
          if($img['active']){
            echo "<input type='checkbox' checked name='active[]' disabled value='$filename'/>";
          }else{
            echo "<input type='checkbox' name='active[]' disabled value='$filename'/>";
          }
          echo "<td>
          <input type='hidden' name='hiddenimg' value='$filename'>
          <button type='submit' name='refresh' value='$filename' class='btn btn-xs btn-warning'>Aktualisieren</button>
          <button type='submit' name='details' value='$filename' class='btn btn-xs btn-primary'>Details</button>
          ";
          if($img['active']){
            echo "<button type='submit' value='$filename' name='deactivate' class='btn btn-xs btn-danger'>Freigabe entfernen</button>";
          }else{
            echo "<button type='submit' value='$filename' name='activate' class='btn btn-xs btn-success'>Freigeben </button>";
          }
          echo"</td>";
          echo "</td></label>";
        $count_rows++;
        }

        echo "</tr></table>";

    if(isset($_POST['activate'])){ // activate button pressed
      $clicked = $_POST['activate'];
      $sql ="UPDATE kkImageDB SET active=1 WHERE filename='$clicked'"; // sets the image to active in DB
      if($db->query($sql)===TRUE){
        echo "<meta http-equiv=refresh content=\"0; URL=admin_img.php\">"; //reloads the page
        }else{
          echo "Fehler: ". $db->error;
        }
      }
    if(isset($_POST['deactivate'])){ // dectivate button pressed
      $clicked = $_POST['deactivate'];
       $sql ="UPDATE kkImageDB SET active=0 WHERE filename='$clicked'"; // sets the image to no active in DB
       if($db->query($sql)===TRUE){
        echo "<meta http-equiv=refresh content=\"0; URL=admin_img.php\">"; //reloads the page
         }else{
           echo "Fehler: ". $db->error;
         }

    }
    if(isset($_POST['refresh'])){ // refresh button pressed (prices)
      $selected = $_POST['refresh'];
      $newprice = $_POST["price"]["$selected"];
       $sql ="UPDATE kkImageDB SET price='$newprice' WHERE filename='$selected'"; // sets the new price for the image
       if($db->query($sql)===TRUE){
           echo "<meta http-equiv=refresh content=\"0; URL=admin_img.php\">"; //reloads the page
          }else{
           echo "Fehler: ". $db->error;
         }
    }
    // if(isset($_POST['details'])){
    //
    // }

  ?>
<button type="submit" name="refresh_db" class="btn btn-primary">Neue Bilder einlesen</button>
</form>
</div>
</div>
