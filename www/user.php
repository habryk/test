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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<title><?php print $items['menu']['user'];?></title>
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
    if(!empty($_SESSION['id']) && !empty($_SESSION['login']) && !empty($_SESSION['password'])){
    if($_GET['action'] == "delete"){
    $sql = "DELETE FROM users WHERE id=?";
    $option = array($_SESSION['id']);
    $result = sql_query($sql,$option,true);
    if ($result){
        echo "<html><head><meta http-equiv='Refresh' content='0; URL=logout.php'></head></html>";
    }
    }
    else{
        $sql = "SELECT avatar,name,surname,email,skype,date,lastDate FROM users WHERE id=?";
        $option = array($_SESSION['id']);
        $myrow = sql_query($sql,$option);
        ?>
        <h4><?php print $myrow['surname']." ".$myrow['name'];?></h4>
        <img src="<?php print $myrow['avatar'];?>" >        
        <p><?php print $items['pages']['user']['forms']['email_u'].$myrow['email'];?></p>
        
       <?php
       if (!empty($myrow['skype'])){
	       print "<p>".$items['pages']['user']['forms']['skype_u'].$myrow['skype']."</p>";
           }
        ?>
        
        <p><?php print $items['pages']['user']['forms']['registration_u'].date("Y-m-d H:i:s",$myrow['date']);?></p>
        <p><?php print $items['pages']['user']['forms']['lastDate_u'].date("Y-m-d H:i:s",$myrow['lastDate']);?></p>
        <?php
    if(!empty($_SESSION['login']) && !empty($_SESSION['password']) && !empty($_SESSION['id'])){
        echo "<a href='change.php'>".$items['pages']['user']['forms']['edit_u']."</a> / <a href='".$_SERVER[PHP_SELF]."?action=delete'>".$items['pages']['user']['forms']['delete_u']."</a>";
    }
    }
    }
    else echo $items['pages']['user']['error_u'];
    ?>
    </p>    
</div>
<?php
    include ("block/lang.block.php");
	include("footer.inc.php");
?>
</body>
</html>