<?php
    session_start();
    include ("db.php");
    if($_COOKIE['auto'] == "yes"){        
        $_SESSION['id'] = $_COOKIE['id'];
        $_SESSION['login'] = $_COOKIE['login'];
        $_SESSION['password'] = $_COOKIE['password'];
        $sessLog = "SELECT permission FROM users WHERE id=$_SESSION[id]";
        $session = mysql_query($sessLog) or die(mysql_error());
        $sessRow = mysql_fetch_row($session);
        $_SESSION['permission'] = $sessRow[0];
        }    
    include ("lang.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<title><?=$items['menu']['home']?></title>
</head>
<body>
<?php
include ("enter.inc.php");
include ("navigation.inc.php");
include ("block/login.block.php");
?>

<div class="content">
    <p>
    <?php
	$sql = "SELECT text FROM pages WHERE lang='$_COOKIE[lang]'";
    $result = mysql_query($sql);
    $myrow = mysql_fetch_array($result);
    echo $myrow['text'];
?>
    </p>    
</div>
<?php
	include("footer.inc.php");
?>
</body>
</html>