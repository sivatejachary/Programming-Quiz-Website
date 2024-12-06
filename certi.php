<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Certificate Generator</title>
  </head>
  <body>
    <center>
      <br>
      <form method="POST">
        <div class="form-group col-sm-6">
          <label for="name">Full Name</label>
          <input type="text" class="form-control" id="name" name="name">
        </div>
        <br><br>
        <button type="submit" class="btn btn-primary" name="generate">Generate Certificate</button>
      </form>
      <br><br>
      <?php
      if (isset($_POST['generate'])) {
        $name = strtoupper($_POST['name']);
        $name_len = strlen($_POST['name']);

        if ($name == "") {
          echo 
          "
          <div class='alert alert-danger col-sm-6' role='alert'>
              Ensure you fill all the fields!
          </div>
          ";
        } else {
          //designed certificate picture
          $image = "p1.png";
          $createimage = imagecreatefrompng($image);

          //then we make use of the imagecolorallocate inbuilt php function which i used to set color to the text we are displaying on the image in RGB format
          $white = imagecolorallocate($createimage, 205, 245, 255);
          $black = imagecolorallocate($createimage, 0, 0, 0);

          //Then we make use of the angle since we will also make use of it when calling the imagettftext function below
          $rotation = 0;

          //we then set the x and y axis to fix the position of our text name
          $origin_x = 60;
          $origin_y=260;

          //we then set the x and y axis to fix the position of our text occupation
          $origin1_x = 120;
          $origin1_y=90;

          //we then set the different size range based on the length of the text which we have declared when we called values from the form
          if($name_len<=7){
            $font_size = 25;
            $origin_x = 190;
            }
            elseif($name_len<=12){
            $font_size = 30;
            }
            elseif($name_len<=15){
            $font_size = 26;
            }
            elseif($name_len<=20){
            $font_size = 18;
            }
            elseif($name_len<=22){
            $font_size = 15;
            }
            elseif($name_len<=33){
            $font_size=11;
            }
            else {
            $font_size =10;
            }
            $certificate_text = $name;

            //font directory for name
            $drFont = dirname(__FILE__)."/developer.ttf";
      
            //function to display name on certificate picture
            $text1 = imagettftext($createimage, $font_size, $rotation, $origin_x, $origin_y, $black,$drFont, $certificate_text);
      
            // create a unique filename for the generated certificate
            $output = uniqid() . ".png";
      
            // save the generated certificate to the server
            imagepng($createimage, $output);
      
            // free up memory
            imagedestroy($createimage);
      
            // set the response headers
            header("Content-type: image/png");
            header("Content-Disposition: attachment; filename=".$output);
            header("Content-length: " . filesize($output));
      
            // send the generated certificate to the browser
            readfile($output);
      
            // delete the generated certificate from the server
            unlink($output);
      
            // exit the script
            exit();
          }
        }
        ?>
        <h2>Certificate Generator</h2>
        <br>
        <div class="col-sm-6">
          <form method="post" action="">
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Enter your name">
            </div>
            <button type="submit" name="generate" class="btn btn-primary">Generate Certificate</button>
          </form>
        </div>
      </center>
      
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blEBoxPpkrngeNfnw5NZ9+OGpCmaJEK9WnG1qlD/6OV69X+PittoNQa" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmIaQ5F5Gh8W6O3U8j9" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
  <html>      
