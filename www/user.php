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
<title><?=$items['menu']['user']?></title>
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
    $sql = "DELETE FROM users WHERE id=$_SESSION[id]";
    $result = mysql_query($sql) or die(mysql_error());
    if ($result){
        echo "<html><head><meta http-equiv='Refresh' content='0; URL=logout.php'></head></html>";
    }
    }
    else{
        $sql = "SELECT avatar,name,surname,email,skype,date,lastDate FROM users WHERE id=$_SESSION[id]";
        $result = mysql_query($sql) or die(mysql_error());
        $myrow = mysql_fetch_assoc($result);
        ?>
        <h4><?php print $myrow['surname']." ".$myrow['name'];?></h4>
        <img src="<?php print $myrow['avatar'];?>" >        
        <p>E-mail: <?php print $myrow['email'];?></p>
        
       <?php
       if (!empty($myrow['skype'])){
	       print "<p>Skype: ".$myrow['skype']."</p>";
           }
        ?>
        
        <p><?php print $items['pages']['user']['registration'].date("Y-m-d H:i:s",$myrow['date']);?></p>
        <p><?php print $items['pages']['user']['lastDate'].date("Y-m-d H:i:s",$myrow['lastDate']);?></p>
        <?php
    if(!empty($_SESSION['login']) && !empty($_SESSION['password']) && !empty($_SESSION['id'])){
        echo "<a href='change.php'>".$items['pages']['user']['edit']."</a> / <a href='".$_SERVER[PHP_SELF]."?action=delete'>".$items['pages']['user']['delete']."</a>";
    }
    }
    }
    else echo $items['pages']['user']['error'];
    ?>
    </p>    
</div>
<?php
	include("footer.inc.php");
?>
</body>
</html>