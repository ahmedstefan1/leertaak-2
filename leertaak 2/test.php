<?php
$testemail = "ahgf.stest@st.hanze.nl";
$patternemail = "/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
if(preg_match($patternemail,$testemail)){
  echo "yes";
}
else {
  echo $testemail." dat is geen geldig email";
}



 ?>
