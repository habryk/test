<?php
    session_start();
    include ("lang.inc.php");
    include ("db.php");	
    include ("function.php");   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<title><?=$items['menu']['registration']?></title>
</head>
<body>
<?php
include ("enter.inc.php");
include ("navigation.inc.php");
include ("block/login.block.php");
?>
<div class="content">
<?php
if (!empty($_SESSION['login']) && !empty($_SESSION['password'])){
    echo $items['pages']['registration']['reg_error'];
}
else{
if (isset($_POST['form3'])){
        clearData($_POST["login"]);
        clearData($_POST["password1"]);
        clearData($_POST["password2"]);
        clearData($_POST["email"]);
        echo $_POST["login"];
        //clearData($_POST["icq"],"i");
       //проверка ведденых данных 
        if (empty($_POST["login"]) || empty($_POST["password1"]) || empty($_POST["email"])) echo $items['pages']['registration']['fields_error'];
    elseif (strlen($_POST["login"])<3 || strlen($_POST["login"])>15)   echo $items['pages']['registration']['length_log'];
    elseif (strlen($_POST["password1"])<3 || strlen($_POST["password1"])>15)   echo $items['pages']['registration']['length_pass'];  
    elseif ($_POST["password1"] != $_POST["password2"]) echo $items['pages']['registration']['confirm_pass'];
    elseif (preg_match("[^.+@.+\..+$]",$_POST["email"]) == 0) echo $items['pages']['registration']['email_error'];
    //elseif (!empty ($_POST["icq"]) && !is_numeric($_POST["icq"])) echo $items['pages']['registration']['icq_error'];
    else{
        $resultL = mysql_query("SELECT id FROM users WHERE login='$_POST[login]'");
        $resultE = mysql_query("SELECT id FROM users WHERE email='$_POST[email]'");
        $myrowL = mysql_fetch_array($resultL);
        $myrowE = mysql_fetch_array($resultE);
        if (!empty($myrowL["id"])) echo $items['pages']['registration']['log_exist'];
        elseif (!empty($myrowE["id"])) echo $items['pages']['registration']['email_exist'];      
        else{
        $password = md5($_POST["password1"]);//шифруем пароль.
        $date = time();
        $sql = "INSERT INTO users(login,password,email,date) VALUES ('$_POST[login]','$password','$_POST[email]','$date')";
        $result2 = mysql_query($sql);
        if ($result2) {
            $sql1 = "SELECT id FROM users WHERE login='$_POST[login]'";
            $result_id = mysql_query($sql1);         
        if (mysql_num_rows($result_id) > 0){
        $myrow_id = mysql_fetch_array($result_id); 
        $activation = md5($myrow_id['id']).strrev(md5($_POST["login"]));
        $name = base64_encode($_POST["login"]);
        $url = "http://test/activation.php?login=".$name."&code=".$activation;
        $to = $_POST["email"];
        $subject = $items['mail']['subject'];
        $message =  $items['mail']['message'].$url;
        
        $success = mail($to,$subject,$message);
        if ($success) {echo $items['mail']['success'];
        echo "<html><head><meta http-equiv='Refresh' content='3; URL=index.php'></head></html>";
        }
        else echo $items['pages']['news']['update_error'];}
        }
        else echo mysql_error();
        }
    } 
}
else{	
?>
<form action="registration.php" method="POST">
<fieldset>
<legend><?=$items['forms']['general_info']?></legend>
    <label><?=$items['forms']['login']?><input type="text" name="login"></label>
    <label><?=$items['forms']['password1']?><input type="password" name="password1"></label>
    <label><?=$items['forms']['password2']?><input type="password" name="password2"></label>
    <label>E-mail:<input type="text" name="email"></label>
</fieldset>
<input type="submit" value="<?=$items['button']['registration']?>" name="form3">
</form>
<?php
}
}
?>
</div>
<?php
	include("footer.inc.php");
?>

</body>
</html>