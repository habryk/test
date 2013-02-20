<?php
define ("DB_HOST","localhost");
define ("DB_NAME","test");
define ("DB_USER","habryk");
define ("DB_PASS","120493");
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME."", DB_USER, DB_PASS);
?>