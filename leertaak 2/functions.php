<?php

  //database info
  $Servername="localhost";
  $UsernameDB="root";
  $PasswordDB="";
  $DB="leertaak2";
  //creates the connection with the database
  $Connection = mysqli_connect($Servername, $UsernameDB, $PasswordDB, $DB) or die("unable to connect");

  function test_input($Input){
    //trims spaces from the outsides of the text
    $Input=trim($Input);
    //removes all the slashes
    $Input=stripcslashes($Input);
    //changes special variables to non harmfull text
    $Input=htmlspecialchars($Input);
    return $Input;
  }

  function hasher($Password){
    $options = ['cost' => 16,];
    //hashes the password
    $Hash = password_hash($Password,PASSWORD_BCRYPT, $options);
    //returns hashed password
    return $Hash;
  }

  //check if user is still logged in
  function LoggedIn(){
    $Check = 0;
    if (isset($_SESSION['ID'])) {
      $Check = 1;
    }
    return $Check;
  }


?>
