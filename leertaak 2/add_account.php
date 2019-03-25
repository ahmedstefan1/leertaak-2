<?php
  include 'MenuBar.php';
  require 'functions.php';
$type ="";
if ($_SERVER["REQUEST_METHOD"]=="POST") {
  echo mysqli_real_escape_string($Connection,test_input($_POST['account_type']));
  if (empty(mysqli_real_escape_string($Connection,test_input($_POST['account_type'])))) {
    echo "vul de gegevens correct in";
  }
  else {
    $type=mysqli_real_escape_string($Connection,test_input($_POST['account_type']));
    if ($type == "1" || $type == "2") {
      $account_id= $_SESSION["ID"];
      // selects tha hash in the database and the salt used from the entry that has the username that the user put in the text field
      $query ="INSERT INTO account (account_id, user, value, type) VALUES (NULL, $account_id, 0, $type)" ;

      //the result of that query is put in the variable result
      $Result = mysqli_query($Connection, $query);
      header('location: myaccount.php');
    }
  }
}
 ?>
