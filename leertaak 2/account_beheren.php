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

    <title>Onzebank</title>
</head>

<body id="login">

  <?php
  include 'MenuBar.php';
  require 'functions.php';


  //check if someone is already logged in
  if (LoggedIn() == 0) {
    header('location: login.php');
    mysqli_close($connection);
  }
  if (!empty(mysqli_real_escape_string($Connection, test_input($_GET['account_id'])))) {
    $account_id=mysqli_real_escape_string($Connection, test_input($_GET['account_id']));
  }
  else{
    header('location: myaccount.php');
  }

  $id = $_SESSION["ID"];
  // selects tha hash in the database and the salt used from the entry that has the username that the user put in the text field
  $query ="SELECT account_id, value, type FROM account WHERE user = '$id' AND account_id = '$account_id'" ;

  //the result of that query is put in the variable result
  $Result = mysqli_query($Connection, $query);
  if (mysqli_num_rows($Result) == 1) {
    //makes sure we can use the attributes to put data into variables
    while($account = mysqli_fetch_assoc($Result)){

      //puts ID into variable
      $account_id_query = $account['account_id'];
      $value = $account['value'];
      $type = $account['type'];

      echo "rekeningnummer : $account_id_query ";
      echo "waarde: $value ";
      if ($type == 0) {
        echo "type: particulier<br>";
      }
      else {
        echo "type: zakelijk<br>";
      }

    }
  }
  else {
    header('location: myaccount.php');
  }
      ?>

      <div class="container">
          <div class="row">
              <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                  <div class="card card-signin my-5">
                      <div class="card-body">
                          <div class="logo-container">
                          </div>
                          <form class="form-signin" method="post" action ="<?php echo htmlspecialchars("remove_account.php");?>">
                            stort naar:<br>
                            <select name="stort">
                              <?php
                              $query_account ="SELECT account_id FROM account WHERE user = '$id' AND NOT account_id = '$account_id'" ;

                              //the result of that query is put in the variable result
                              $Result = mysqli_query($Connection, $query_account);
                              if (mysqli_num_rows($Result) > 0) {
                                //makes sure we can use the attributes to put data into variables
                                while($account = mysqli_fetch_assoc($Result)){
                                  //puts ID into variable
                                  $account_id_query = $account['account_id'];
                                  ?>
                                  <option value="<?php echo $account_id_query;?>"><?php echo $account_id_query;?></option>
                                  <?php
                                }
                              }
                              ?>
                            </select><br>
                            username:<br>
                            <input id="Username" class="form-control" type="text" name="Username" required="" value="">
                            password:<br>
                            <input id="Password" class="form-control" type="password" required="" name="Password">
                            <br>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">verwijder rekening</button>
                        </form>
                      </div>
                  </div>
              </div>
          </div>

          <?php

           ?>

  </body>
</html>
