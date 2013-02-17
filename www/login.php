<?php
    session_start();
    include ("lang.inc.php");
    include ("db.php");	
    include ("function.php");
    if (isset($_POST['form1'])){
            clearData($_POST['login']);
            clearData($_POST['password']);
            if (empty($_POST['login']) || empty($_POST['password'])) echo $items['pages']['login']['all_fields'];
            else{
                $password = md5($_POST['password']);//шифруем пароль
                $sql = "SELECT id,permission FROM users WHERE login='$_POST[login]' AND password='$password' AND activation='1'";
                $result = mysql_query($sql);
                $myrow = mysql_fetch_array($result);            
                if (mysql_num_rows($result) > 0){
                    if ((int)$myrow['permission'] !== 4){
                    $_SESSION['id'] = $myrow['id'];
                    $_SESSION['login'] = $_POST['login'];
                    $_SESSION['password'] = $password;
                    $_SESSION['permission'] = $myrow['permission'];              
                    if ($_POST['auto'] == 1){
                    setcookie("id",$myrow['id'], time()+99999);   
                    setcookie("login",$_POST['login'], time()+99999);
                    setcookie("password",$password, time()+99999);
                    setcookie("auto", "yes", time()+99999);
                    }
                    $time = time();
                    mysql_query("UPDATE users SET lastDate='$time' WHERE id='$_SESSION[id]' AND login='$_SESSION[login]'") or die(mysql_error());
                    echo "<html><head><meta http-equiv='Refresh' content='0; URL=index.php'></head></html>";
                }
                else echo $items['pages']['login']['blocked'];
                }
                else echo $items['pages']['login']['pass_error'];
            }
        }
    	  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<title><?php print $items['menu']['login'];?></title>
</head>
<body>
<style>
.login{
    display:none;   
}
.content,.footer,.navigation,.enter{
    width: 94%;
    margin-left:3%;
}
</style>
<?php
include ("enter.inc.php");
include ("navigation.inc.php");
include ("block/login.block.php");
?>
<div class="content">
<?php
	if (!empty($_SESSION['login']) && !empty($_SESSION['password'])){
    echo $items['pages']['login']['enter_error'];
}
else{   
?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
<label><?php print $items['forms']['login'];?><input type="text" name="login"></label>
<label><?php print $items['forms']['password1'];?><input type="password" name="password"></label>
<input type="checkbox" name="auto" value="1"><?php print $items['forms']['auto'];?><br>
<input type="submit" value="<?php print $items['button']['login'];?>" name="form1">
</form>
<?php
	}
?>
</div>
<?php
	include("footer.inc.php");
?>
</body>
</html>