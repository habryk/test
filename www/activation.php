<?php
    session_start();
    include ("db.php");
    include ("function.php");
    if($_COOKIE['auto'] == "yes"){
         $_SESSION['id'] = $_COOKIE['id'];
        $_SESSION['login'] = $_COOKIE['login'];
        $_SESSION['password'] = $_COOKIE['password'];
        $sessLog = "SELECT permission FROM users WHERE id=?";
        $sess_opt = array($_SESSION['id']);      
        $sessRow = sql_query($sessLog,$sess_opt);
        $_SESSION['permission'] = $sessRow[0];
    }    
    include ("lang.inc.php");
    if (isset($_GET['login']) && $_GET['code']){
	   $name = mysql_real_escape_string(base64_decode($_GET['login']));
	   $sql = "SELECT id, permission, password FROM users WHERE login=? AND activation=?";
       $option = array($name,0);
       $result_count = sql_query($sql,$option,false,true);
       if ($result_count > 0){
       $myrow = sql_query($sql,$option);
       $activation = md5($myrow['id']).strrev(md5($name));
       if ($activation == $_GET['code']){
            $sql1 = "UPDATE users SET activation=? WHERE id=? AND login=?";
            $option1 = array(1,$myrow['id'],$name);
            $result1 = sql_query($sql1,$option1,true);
            if ($result1 == true){
                $_SESSION['id'] = $myrow['id'];
                $_SESSION['login'] = $name;
                $_SESSION['password'] = $myrow['password'];
                $_SESSION['permission'] = $myrow['permission'];
                $time = time();
                $sql_date = "UPDATE users SET lastDate=? WHERE id=? AND login=?";
                $option_date = array($time,$_SESSION['id'],$_SESSION['login']);
                sql_query($sql_date,$option_date,true);
                echo "<html><head><meta http-equiv='Refresh' content='3; URL=index.php'></head>".$items['pages']['activation']['success']."</html>";
                }
       }
       else echo $items['pages']['activation']['confirm'];
       }
       else echo "Error";
	 }
     else echo $items['pages']['activation']['error'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<title><?=$items['menu']['activ']?></title>
</head>
<body>
<?php
include ("enter.inc.php");
include ("navigation.inc.php");
include ("block/login.block.php");
?>

<div class="content">
      <?php
      if(!empty($_SESSION['id']) && !empty($_SESSION['login']) && !empty($_SESSION['password'])) echo $items['pages']['activation']['exist'];	 
?>
</div>
<?php
	include("footer.inc.php");
?>
</body>
</html>