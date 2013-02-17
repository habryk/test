<?php
    session_start();
    include ("db.php");
    include ("function.php");
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
<?php
if(!empty($_SESSION['id']) && !empty($_SESSION['login']) && !empty($_SESSION['password'])){
	if ($_SERVER['REQUEST_METHOD'] == "POST"){
	   if (is_uploaded_file($_FILES['avatar']['tmp_name']) && !isset($_POST['avatar'])){
	       if ($_FILES['userfileavatar']['size'] < upload_max_filesize){ 
	       $url = "images/avatars/".$_FILES['avatar']['name'];
        move_uploaded_file($_FILES['avatar']['tmp_name'],$url);
        $newurl = smallImage($url,150,150);
        $fileSql = "UPDATE users SET avatar='$newurl' WHERE id=$_SESSION[id]";
        $fileRes = mysql_query($fileSql) or die(mysql_query());
        if ($fileRes){
        echo $items['pages']['change']['fileSuccess'];
        }
       }
       else echo $items['pages']['change']['fileSize'];
       }
       if (!preg_match("[^.+@.+\..+$]",$_POST["email"]) && !empty($_POST["email"])){unset($_POST["email"]); echo $items['pages']['registration']['email_error'];}
       if (!empty($_POST['name']) || !empty($_POST['surname']) || !empty($_POST['skype']) || !empty($_POST['avatar']) || !empty($_POST['email'])){
	   clearData($_POST['name']);
       clearData($_POST['surname']);
       clearData($_POST['skype']);
       clearData($_POST['email']);
       foreach($_POST as $k => $v){
        if ($v !== "") {
            $update .= "$k='".$v."'," ;            
        }        
    }
    $update = substr_replace($update, " ", -1,1); 
     if ($update != " "){
        $sql = "UPDATE users SET $update WHERE id=$_SESSION[id]";
        $result = mysql_query($sql) or die(mysql_error());
         if ($result) echo $items['pages']['change']['success'];
     }
     else echo $items['pages']['change']['error'];
	}
    elseif (isset($url)){}
    else echo $items['pages']['change']['error'];
    }
    else{
        $sql = "SELECT name,surname,email,skype FROM users WHERE id=$_SESSION[id]";
        $result = mysql_query($sql) or die(mysql_error());
        $myrow = mysql_fetch_assoc($result);
?>
    <p>
        <form action="<?php print $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
        <label><?php print $items['forms']['avatar'];?><input type="file" name="avatar" accept= "image/*"></label>
        <label><input type="checkbox" name="avatar" value="images/avatars/default_avatar.png"><?php print $items['forms']['default_img'];?></label>
        <label><?php print $items['forms']['name'];?><input type="text" name="name" maxlength="100" value="<?php print $myrow['name'];?>"></label>
        <label><?php print $items['forms']['surname'];?><input type="text" name="surname" maxlength="100" value="<?php print $myrow['surname'];?>"></label>
        <label>E-mail: <input type="text" name="email" maxlength="100" value="<?php print $myrow['email'];?>"></label>
        <label>Skype: <input type="text" name="skype" maxlength="100" value="<?php print $myrow['skype'];?>"></label>
        <input type="submit" value="<?php print $items['button']['edit'];?>">
        </form>
    </p> 
    <?php
	}
    }
    else echo $items['pages']['user']['error'];
?>   
</div>
<?php
	include("footer.inc.php");
?>
</body>
</html>