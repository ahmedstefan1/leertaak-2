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
    <div id="container">


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
                            <input type="text" id="Username" class="form-control" name="Username" required="" value="<?php echo $Username;?>"><span class="error">*<?php echo $UsernameErr;?></span><br>

                            Password:<br>
                            <input type="password" id="Password" class="form-control" name="Password" required=""><span class="error">*<?php echo $PasswordErr;?></span><br>

                            <button class="btn login-button btn-lg btn-primary btn-block text-uppercase" type="submit">Login</button>

                          </form>
                        </div>
                    </div>
                </div>
            </div>

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
