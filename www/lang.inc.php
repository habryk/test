<?php
define ("DEFAULT_LANG","ua");
if ($_SESSION['lang'] == "en") {$value = "Select"; include ("lang/en.php");}
//if ($_COOKIE['lang'] == DEFAULT_LANG){$value = "Выбрать"; include ("lang/ru.php");}
if ($_SESSION['lang'] == "ua"){$value = "Обрати"; include ("lang/ua.php");}
if (isset($_GET['lang'])){ $_SESSION['lang'] = $_GET['lang']; header ('Location: '.$_SERVER['REQUEST_URI']);}
if (!isset($_SESSION['lang'])) {$_SESSION['lang'] = DEFAULT_LANG; header ('Location: '.$_SERVER['REQUEST_URI']);}


?>
