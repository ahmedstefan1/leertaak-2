<?php
  include 'MenuBar.php';
  require 'functions.php';

if ($_SERVER["REQUEST_METHOD"]=="POST") {
  if (empty(mysqli_real_escape_string($Connection,test_input($_POST['Username'])))) {
    echo "vul de gegevens correct in";
  }
  else {
    if ($_SESSION["Username"] == mysqli_real_escape_string($Connection,test_input($_POST['Username']))) {
      //gets text that is in the field and runs it through the test_iunput function
      $Username=mysqli_real_escape_string($Connection,test_input($_POST['Username']));
    }
  }
  if (empty(mysqli_real_escape_string($Connection,test_input($_POST['Password'])))) {
    echo "vul de gegevens correct in";
  }
  else {
    $Password=mysqli_real_escape_string($Connection,test_input($_POST['Password']));
  }
  if (empty(mysqli_real_escape_string($Connection,test_input($_POST['stort'])))) {
    echo "vul de gegevens correct in";
  }
  else {
    $stort=mysqli_real_escape_string($Connection,test_input($_POST['stort']));
  }
  if ( ! empty($Username) and ! empty($Password) and ! empty($stort)){
    // selects tha hash in the database and the salt used from the entry that has the username that the user put in the text field
    $query ="SELECT password FROM users WHERE username = '$Username'" ;

    //the result of that query is put in the variable result
    $Result = mysqli_query($Connection, $query);
    if (mysqli_num_rows($Result) == 1) {
      //makes sure we can use the attributes to put data into variables
      $User = mysqli_fetch_assoc($Result);

      //puts the hash that is in the database into the variable hash
      $hash = $User['password'];

      //if the variable user_input is the same as the hash from the database
      if (password_verify($Password,$hash)) {
        echo "yes";
        //TODO check if the stort account is of the same user en daarna stort het
      }
      else {

      }
    }
    else {
      echo "vul de gegevens correct in";
    }
  }
}
 ?>
