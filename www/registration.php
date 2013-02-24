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
<title><?php print $items['menu']['registration'];?></title>
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
    echo $items['pages']['registration']['reg_error_r'];
}
else{
if (isset($_POST['form3'])){
        clearData($_POST["login"]);
        clearData($_POST["password1"]);
        clearData($_POST["password2"]);
        clearData($_POST["email"]);
        //clearData($_POST["icq"],"i");
       //проверка ведденых данных 
        if (empty($_POST["login"]) || empty($_POST["password1"]) || empty($_POST["email"])) echo $items['pages']['registration']['fields_error_r'];
    elseif (strlen($_POST["login"])<3 || strlen($_POST["login"])>15)   echo $items['pages']['registration']['length_log_r'];
    elseif (strlen($_POST["password1"])<3 || strlen($_POST["password1"])>15)   echo $items['pages']['registration']['length_pass_r'];  
    elseif ($_POST["password1"] != $_POST["password2"]) echo $items['pages']['registration']['confirm_pass_r'];
    elseif (preg_match("[^.+@.+\..+$]",$_POST["email"]) == 0) echo $items['pages']['registration']['email_error_r'];
    //elseif (!empty ($_POST["icq"]) && !is_numeric($_POST["icq"])) echo $items['pages']['registration']['icq_error'];
    else{
        $sql_L = "SELECT id FROM users WHERE login=?";
        $optionL = array($_POST['login']);
        $sql_E = "SELECT id FROM users WHERE email=?";
        $optionE = array($_POST['email']);
        $myrowL = sql_query($sql_L,$optionL);
        $myrowE = sql_query($sql_E,$optionE);
        if (isset($myrowL["id"])) echo $items['pages']['registration']['log_exist_r'];
        elseif (isset($myrowE["id"])) echo $items['pages']['registration']['email_exist_r'];      
        else{
        $password = md5($_POST["password1"]);//шифруем пароль.
        $date = time();
        $sql = "INSERT INTO users(login,password,email,date) VALUES (?,?,?,?)";
        $option = array($_POST['login'],$password,$_POST['email'],$date);
        $result2 = sql_query($sql,$option,true);
        if ($result2) {
            $sql1 = "SELECT id FROM users WHERE login=?";
            $option1 = array($_POST['login']);
            $result_count = sql_query($sql1,$option1,false,true);         
            if ($result_count > 0){
            $myrow_id = sql_query($sql1,$option1); 
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
            else echo $items['pages']['news']['update_error_r'];}
        }
        else echo mysql_error();
        }
    } 
}
else{	
?>
<form action="registration.php" method="POST">
<fieldset>
<legend><?php print $items['pages']['registration']['forms']['general_info_r'];?></legend>
    <label><?php print $items['pages']['registration']['forms']['login_r'];?><input type="text" name="login"></label>
    <label><?php print $items['pages']['registration']['forms']['password1_r'];?><input type="password" name="password1"></label>
    <label><?php print $items['pages']['registration']['forms']['password2_r'];?><input type="password" name="password2"></label>
    <label><?php print $items['pages']['registration']['forms']['email_r'];?><input type="text" name="email"></label>
</fieldset>
<input type="submit" value="<?php print $items['pages']['registration']['forms']['registration_r'];?>" name="form3">
</form>
<?php
}
}
?>
</div>
<?php
    include ("block/lang.block.php");
	include("footer.inc.php");
?>

</body>
</html>