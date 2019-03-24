<?php
$string1 = "tesT123@";
$pattern1 = '/[a-z][A-Z]/ ';
$pattern2 = '/[\d]/ ';
$pattern3 = '/[^\s]/ ';
$pattern4 = '/[^a-zA-Z-0-9]/ ';
$pattern5 = '/[A-Z]/ ';
if (preg_match_all($pattern1,$string1)) {
  if (preg_match_all($pattern2,$string1)) {
    if (preg_match_all($pattern3,$string1)) {
      if (preg_match_all($pattern4,$string1)) {
        if (preg_match_all($pattern5,$string1)) {
          echo "yay";
        }
        else{
          $PasswordErr="Password must have atleast one small letter, one capital letter and a special character.";
        }
      }
      else{
        $PasswordErr="Password must have atleast one small letter, one capital letter and a special character.";
      }
    }
    else{
      $PasswordErr="Password must have atleast one small letter, one capital letter and a special character.";
    }
  }
  else{
    $PasswordErr="Password must have atleast one small letter, one capital letter and a special character.";
  }
}
else {
  $PasswordErr="Password must have atleast one small letter, one capital letter and a special character.";
}




 ?>
