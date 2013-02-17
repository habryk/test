<?php
define ("DEFAULT_LANG","ru");
if ($_COOKIE['lang'] == "en") {$render = "Select language: "; $en="selected"; $value = "Select"; include ("lang/en.php");}
if ($_COOKIE['lang'] == DEFAULT_LANG){ $render = "Выберите язык: "; $ru="selected"; $value = "Выбрать"; include ("lang/ru.php");}
if ($_COOKIE['lang'] == "ua"){ $render = "Виберіть мову: "; $ua="selected"; $value = "Обрати"; include ("lang/ua.php");}
if (!isset($_POST['lang']) && !isset($_COOKIE['lang'])) {setcookie("lang",DEFAULT_LANG); header ('Location: '.$_SERVER['PHP_SELF']);}
if ($_POST['langid'] == 1){
if (isset($_POST['lang'])){ setcookie("lang",$_POST['lang']); header ('Location: '.$_SERVER['PHP_SELF']);}
}

?>
