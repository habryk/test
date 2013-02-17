<?php
    session_start();
    session_unset();
    setcookie("login","");
    setcookie("password","");
    setcookie("auto","");
    echo "<html><head><meta http-equiv='Refresh' content='0; URL=index.php'></head></html>";
?>