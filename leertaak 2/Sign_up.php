<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <title>Weatherstation Coolerts</title>
</head>

<body id="login">

      <?php
      include 'MenuBar.php';
      require 'functions.php';


      //check if someone is already logged in
      if (isset($_SESSION['ID'])) {
        header('location: index.php');
        mysqli_close($connection);
      }



      //predefinded variables
      $UsernameErr=$PasswordErr="";
      $Usernametest=$Password="";

      //if the webpage refreshes with the request method POST it will check all the frields that should have been filled. if any are empty it will show errors. if only one is empty it will save all the other values and display them so the user only needs to enter one field
      if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $PasswordErr="passwoord is verplicht";

        //tests username
        if (empty(mysqli_real_escape_string($Connection, test_input($_POST['Username'])))) {
          $UsernameErr="username is verplicht";
        }
        else {
          $Usernametest=mysqli_real_escape_string($Connection, test_input($_POST['Username']));
          //check if username is already in use
          $testusername="SELECT user_id FROM users WHERE Username = '$Usernametest'" ;
          $result = mysqli_query($Connection, $testusername);

          if (mysqli_num_rows($result) > 0) {
            $UsernameErr="username already in use";
          }
          else {
            $Username=$Usernametest;
          }
        }
        //tests password
        if (empty(mysqli_real_escape_string($Connection, test_input($_POST['Password'])))) {
          $PasswordErr="Password is mandatory";
        }
        else {
          $passtest = mysqli_real_escape_string($Connection,test_input($_POST['Password']));
          if (strlen($passtest) >= 8) {
            $pattern1 = '/[a-z]/ ';
            $pattern2 = '/[\d]/ ';
            $pattern3 = '/[^\s]/ ';
            $pattern4 = '/[^a-zA-Z-0-9]/ ';
            $pattern5 = '/[A-Z]/ ';
            if (preg_match_all($pattern1,$passtest)) {
              if (preg_match_all($pattern2,$passtest)) {
                if (preg_match_all($pattern3,$passtest)) {
                  if (preg_match_all($pattern4,$passtest)) {
                    if (preg_match_all($pattern5,$passtest)) {
                      $Password = mysqli_real_escape_string($Connection,test_input($_POST['Password']));
                    }
                    else{
                      $PasswordErr="Password must have atleast one small letter, one capital letter, one number and a special character";
                    }
                  }
                  else{
                    $PasswordErr="Password must have atleast one small letter, one capital letter, one number and a special character";
                  }
                }
                else{
                  $PasswordErr="Password must have atleast one small letter, one capital letter, one number and a special character";
                }
              }
              else{
                $PasswordErr="Password must have atleast one small letter, one capital letter, one number and a special character";
              }
            }
            else {
              $PasswordErr="Password must have atleast one small letter, one capital letter, one number and a special character";
            }
          }
          else {
            $PasswordErr="Password must be atleast 8 characters";
          }
        }
      }

      ?>
      <div class="container">
          <div class="row">
              <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                  <div class="card card-signin my-5">
                      <div class="card-body">
                          <div class="logo-container">
                              <img src="img/logo.jpg" alt="Logo University">
                          </div>
                          <form class="form-signin" method="post" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                            username:<br>
                            <input id="Username" class="form-control" type="text" name="Username" required="" value="<?php echo $Usernametest;?>">
                            <span class="error">*<?php echo $UsernameErr;?></span><br>

                            password:<br>
                            <input id="Password" class="form-control" type="password" required="" name="Password">
                            <span class="error">* <?php echo $PasswordErr; ?></span><br>

                            <br>
                            <button class="btn login-button btn-lg btn-primary btn-block text-uppercase" type="submit">Register</button>
                        </form>
                      </div>
                  </div>
              </div>
          </div>

      <?php


      if ( ! empty($Username)
        and ! empty($Password)){


          //hashes the password and the salt
          $Hashed= hasher($Password);

          //sql Query die zal uitgevoerd worden
          $Query="INSERT INTO users (user_id, Username, Password)
          VALUES (NULL, '$Username', '$Hashed');";

          if(mysqli_query($Connection, $Query)){

            mysqli_close($DB);
            //redirects to login page
            header('location: login.php');
          }
          //if it doesnt run correctly
          else{
            //posts error message
            echo "ERROR: unable to sign you up</br>";
        }



      }



      ?>
  </body>
</html>
