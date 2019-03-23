<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="Stylesheet.css">
    <title>Sign up</title>
  </head>

  <body>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1">

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
                      $PasswordErr="Password must have atleast one capital letter";
                    }
                  }
                  else{
                    $PasswordErr="Password must have atleast one special character";
                  }
                }
                else{
                  $PasswordErr="Password shouldnt have a whitespace";
                }
              }
              else{
                $PasswordErr="Password must have atleast one number";
              }
            }
            else {
              $PasswordErr="Password must have atleast one small letter";
            }
          }
          else {
            $PasswordErr="Password must be atleast 8 characters";
          }
        }
      }

      ?>

      <form method="post" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

          <div class="form-label-group">
              <input type="text" name="Username" id="Username" class="form-control" placeholder="Username" required autofocus>
              <label for="Username">Username</label>
          </div>

          <div class="form-label-group">
              <input type="password" name="Password" id="Password" class="form-control" placeholder="Password" required>
              <label for="Password">Password</label>
          </div>

          <button class="btn login-button btn-lg btn-primary btn-block text-uppercase" type="submit">Register</button>
          <a class="btn back-button btn-lg btn-primary btn-block text-uppercase" href="javascript:history.back()">Back</a>

      </form>

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
