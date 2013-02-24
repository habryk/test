<?php
define ("DEFAULT_LANG","ua");
if ($_SESSION['lang'] == "en") {$items = file_get_contents("lang/en.php"); $items = unserialize($items);}
//if ($_COOKIE['lang'] == DEFAULT_LANG){$value = "Выбрать"; include ("lang/ru.php");}
if ($_SESSION['lang'] == "ua"){$items = file_get_contents("lang/ua.php"); $items = unserialize($items);}
if (isset($_GET['lang'])){ $_SESSION['lang'] = $_GET['lang']; header ('Location: '.$_SERVER['REQUEST_URI']);}
if (!isset($_SESSION['lang'])) {$_SESSION['lang'] = DEFAULT_LANG; header ('Location: '.$_SERVER['REQUEST_URI']);}


?>
