<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="Stylesheet.css">
    <title>login</title>

  </head>

  <body>
    <div id="container">
      <header>
        <h1>login</h1>
      </header>


      <?php

      include 'MenuBar.php';
      require 'functions.php';


      //check if someone is already logged in
      if (LoggedIn() == 1) {
        header('location: index.php');
        mysqli_close($connection);
      }



        $UsernameErr=$PasswordErr="";
        $Username="";

        if ($_SERVER["REQUEST_METHOD"]=="POST") {
          if (empty(mysqli_real_escape_string($Connection,test_input($_POST['Username'])))) {
            $UsernameErr="username is verplicht";
          }
          else {
            //gets text that is in the field and runs it through the test_iunput function
            $Username=mysqli_real_escape_string($Connection,test_input($_POST['Username']));
          }
          if (empty(mysqli_real_escape_string($Connection,test_input($_POST['Password'])))) {
            $PasswordErr="passwoord is verplicht";
          }
          else {
            $Password=mysqli_real_escape_string($Connection,test_input($_POST['Password']));
          }
        }


      ?>


      <form method="post" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-label-group">
              <input type="text" id="Username" name="Username" class="form-control" placeholder="Username" required autofocus>
              <label for="Username">Username</label>
          </div>

          <div class="form-label-group">
              <input type="password" id="Password" name="Password" class="form-control" placeholder="Password" required>
              <label for="Password">Password</label>
          </div>

          <button class="btn login-button btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>

      <?php
        //if the fields arent empty
        if ( ! empty($Username) and ! empty($Password)){

          // selects tha hash in the database and the salt used from the entry that has the username that the user put in the text field
          $query ="SELECT user_id, password FROM users WHERE username = '$Username'" ;

          //the result of that query is put in the variable result
          $Result = mysqli_query($Connection, $query);
          if (mysqli_num_rows($Result) == 1) {
            //makes sure we can use the attributes to put data into variables
            $User = mysqli_fetch_assoc($Result);

            //puts ID into variable
            $ID = $User['user_id'];
            //puts the hash that is in the database into the variable hash
            $hash = $User['password'];

            $permission = 0;


            //if the variable user_input is the same as the hash from the database
            if (password_verify($Password,$hash)) {
              //stores the ID and the username of the user into the session variables
              $_SESSION["ID"] = "$ID";
              $_SESSION["Username"] = "$Username";
              if ($permission == 1) {
                $_SESSION["Permission"] = 1;
              }
              else {
                $_SESSION["Permission"] = 0;
              }
              mysqli_free_result($Result);
              mysqli_close($Connection);
              header('location: index.php');


            }
            //if it isnt it will write the the username or password is incorrect to the screen
            else {
              echo "the username or password is incorrect";

            }
          }
          else {
            echo "the username or password is incorrect";

          }
        }


      ?>
    </div>
  </body>
</html>
