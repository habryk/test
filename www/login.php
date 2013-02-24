<?php
    session_start();
    include ("lang.inc.php");
    include ("db.php");	
    include ("function.php");
    if (isset($_POST['form1'])){
            clearData($_POST['login']);
            clearData($_POST['password']);
            if (empty($_POST['login']) || empty($_POST['password'])) echo $items['pages']['login']['all_fields_l'];
            else{
                $password = md5($_POST['password']);//шифруем пароль
                $sql = "SELECT id,permission FROM users WHERE login=? AND password=? AND activation=?";
                $option = array($_POST['login'],$password,'1');
                $myrow = sql_query($sql,$option);          
                if (isset($myrow['id']) && isset($myrow['permission'])){
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
                    $sql = "UPDATE users SET lastDate=? WHERE id=? AND login=?";
                    $option = array($time,$_SESSION['id'],$_SESSION['login']);
                    sql_query($sql,$option,true);
                    echo "<html><head><meta http-equiv='Refresh' content='0; URL=index.php'></head></html>";
                }
                else echo $items['pages']['login']['blocked_l'];
                }
                else echo $items['pages']['login']['pass_error_l'];
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
    echo $items['pages']['login']['enter_error_l'];
}
else{   
?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
<label><?php print $items['pages']['login']['forms']['login_l'];?><input type="text" name="login"></label>
<label><?php print $items['pages']['login']['forms']['password_l'];?><input type="password" name="password"></label>
<input type="checkbox" name="auto" value="1"><?php print $items['pages']['login']['forms']['avto_l'];?><br>
<input type="submit" value="<?php print $items['pages']['login']['forms']['enter_l'];?>" name="form1">
</form>
<?php
	}
?>
</div>
<?php
    include ("block/lang.block.php");
	include("footer.inc.php");
?>
</body>
</html>