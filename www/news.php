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
    include ("function.php");
    include ("lang.inc.php");	
    if (isset($_POST['form2'])) {
        if (!empty($_POST['title']) && !empty($_POST['text'])){
        clearData($_POST['title']);
        clearData($_POST['text']);
        $date = time();
        $sql = "INSERT INTO news(title,author,text,date) VALUES ('$_POST[title]','$_SESSION[id]','$_POST[text]','$date')";
        $result = mysql_query($sql);
        if ($result) header("Location: news.php");
        else echo(mysql_error());
        }
        else echo $items['pages']['news']['fields_error'];
    }
    if (isset($_POST['form3'])) {
         if (!empty($_POST['title']) && !empty($_POST['text'])){
            clearData($_POST['text']);
            clearData($_POST['title']);
            $date = time();
            $sql = "UPDATE news SET title='$_POST[title]',text='$_POST[text]',date='$date' WHERE id=$_POST[id]";
            $result = mysql_query($sql);
            if ($result){
            echo "<html><head><meta http-equiv='Refresh' content='3; URL=news.php?id=".$_POST['id']."'></head>".$items['pages']['news']['success_edit']."</html>";
            }
            else echo $items['pages']['news']['update_error'];
         }
         else echo $items['pages']['news']['fields_error'];
    }
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<title><?php print $items['menu']['news'];?></title>
</head>
<body>
<?php
include ("enter.inc.php");
include ("navigation.inc.php");
include ("block/login.block.php");
?>
<div class="content">
<?php
if ($_GET['action'] == "add"){
?>
    <form action="news.php" method="POST">
    <label><?php print $items['forms']['title'];?><input type="text" name="title" maxlength="50" ></label><br>
    <label><?php print $items['forms']['text'];?><textarea name="text"></textarea></label>
    <input type="submit" value="<?php print $items['button']['addnew'];?>" name="form2">
    </form>
<?php
}
elseif($_GET['action'] == "edit" && isset($_GET['new'])){
    $sql = "SELECT title,author,text FROM news WHERE id=$_GET[new]";
    $result = mysql_query($sql);
    $myrow = mysql_fetch_array($result);
    if ($_SESSION['id'] == $myrow['author'] || $_SESSION['permission'] == 1){
?>
    <form action="news.php" method="POST">
    <label><?php print $items['forms']['title'];?><input type="text" name="title" value="<?php print $myrow['title'];?>"></label><br>
    <label><?php print $items['forms']['text'];?><textarea name="text"><?php print $myrow['text'];?></textarea></label>
    <input type="hidden" name="id" value="<?php print $_GET["new"];?>">
    <input type="submit" value='<?php print $items['button']['editnew'];?>' name='form3'>
    </form>
<?php
}
else echo $items['pages']['news']['permission_error'];
}
elseif (isset($_GET['id'])){
    if (!is_numeric($_GET['id'])) echo $items['pages']['news']['url_error'];
    else{
        $sql = "SELECT n.title,n.author,u.login,n.text,n.date FROM news n INNER JOIN users u ON n.author=u.id WHERE n.id = '$_GET[id]'";
        $result = mysql_query($sql);
        $myrow = mysql_fetch_assoc($result);
        $date = date("Y-m-d H:i:s",$myrow['date']);
?>
        <h1><?php print $myrow['title'];?></h1>
        <h3><?php print $items['forms']['author'].$myrow['login'];?></h3>
        <p><?php print $myrow['text'];?></p>
        <span><?php print $items['forms']['date'].$date;?></span><br>
        
<?php  
if(!empty($_SESSION['login']) && !empty($_SESSION['password']) && $_SESSION['permission'] == 1 ||  $_SESSION['id'] == $myrow['author'] && $_SESSION['permission'] == 2) echo "<a href='news.php?action=edit&new=".$_GET['id']."'>".$items['menu']['editnew']."</a>/<a href='news.php?action=del&new=".$_GET['id']."'>".$items['menu']['delete']."</a>";   
    }
}
elseif($_GET['action'] == "del" && isset($_GET['new'])){
    $sql = "DELETE FROM news WHERE id='$_GET[new]'";
    $result = mysql_query($sql) or die (mysql_error());
    if ($result){
        echo $items['pages']['news']['success_delete'];
    }
}
	else{
	   $sql = "SELECT id,title,text FROM news";
       $result = mysql_query($sql);
       $myrow = mysql_fetch_array($result);
       echo "<ul>";
       if(mysql_num_rows($result) > 0){      
       do{
        $text = stingcut($myrow['text'],150);
         printf("<li><h2><a href='news.php?id=%s'>%s</a></h2><p>%s</p><a href='news.php?id=%s'>%s</a></li>",$myrow['id'],$myrow['title'],$text,$myrow['id'],$items['menu']['more']);
       }
       while($myrow = mysql_fetch_array($result));
      
       echo "</ul>";
       }
       else{
        echo $items['pages']['news']['news_error'];
       }
       
       
       if(!empty($_SESSION['login']) && !empty($_SESSION['password']) && $_SESSION['permission'] == 1 || $_SESSION['permission'] == 2) echo "<a href='news.php?action=add'>".$items['menu']['addnew']."</a>";
       }

?>
</div>
<?php
	include("footer.inc.php");
?>
</body>
</html>