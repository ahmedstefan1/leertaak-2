<link rel="stylesheet" type="text/css" href="Stylesheet.css">

<ul id="Top-Bar">
  <li><a id="Link-Left" href="index.php">Home</a></li>

<?php

  session_start();

  if (isset($_SESSION["Username"])) {
    ?>
      <li><a id="Link-Right" href="Log_off.php">sign off</a></li>
      <li><a id="Link-Right" href="overschrijven.php">overschrijven</a></li>
      <li><a id="Link-Right" href="myaccount.php"><?php echo $_SESSION["Username"]; ?></a></li>
    </ul>
    <?php
  }
  else {
    ?>
    <li><a id="Link-Right" href="sign_up.php">sign up</a></li>
    <li><a id="Link-Right" href="login.php">login</a></li>
  </ul>
    <?php

  }


 ?>
