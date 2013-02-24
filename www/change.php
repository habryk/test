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
<title><?php print $items['menu']['home']; ?></title>
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
        $fileSql = "UPDATE users SET avatar=? WHERE id=?";
        $file_opt = array($newurl,$_SESSION['id']);
        $fileRes = sql_query($fileSql,$file_opt,true);
        if ($fileRes){
        echo $items['pages']['change']['fileSuccess_c'];
        }
       }
       else echo $items['pages']['change']['fileSize_c'];
       }
       if (!preg_match("[^.+@.+\..+$]",$_POST["email"]) && !empty($_POST["email"])){unset($_POST["email"]); echo $items['pages']['registration']['email_error_c'];}
       clearData($_POST['name']);
       clearData($_POST['surname']);
       clearData($_POST['skype']);
       clearData($_POST['email']);
       if (!empty($_POST['name']) || !empty($_POST['surname']) || !empty($_POST['skype']) || !empty($_POST['avatar']) || !empty($_POST['email'])){	   
       foreach($_POST as $k => $v){
        if ($v !== "") {
            $update .= "$k='".$v."'," ;            
        }        
    }
    $update = substr_replace($update, " ", -1,1); 
     if ($update != " "){
        $sql = "UPDATE users SET $update WHERE id=?";
        $option = array($_SESSION['id']);
        $result = sql_query($sql,$option,true);
         if ($result) echo $items['pages']['change']['success_c'];
     }
     else echo $items['pages']['change']['error_c'];
	}
    elseif (isset($url)){}
    else echo $items['pages']['change']['error_c'];
    }
    else{
        $sql = "SELECT name,surname,email,skype FROM users WHERE id=?";
        $option = array($_SESSION['id']);
        $myrow = sql_query($sql,$option);
?>
    <p>
        <form action="<?php print $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
        <label><?php print $items['pages']['change']['forms']['avatar_c'];?><input type="file" name="avatar" accept= "image/*"></label>
        <label><input type="checkbox" name="avatar" value="images/avatars/default_avatar.png"><?php print $items['pages']['change']['forms']['default_img_c'];?></label>
        <label><?php print $items['pages']['change']['forms']['name_c'];?><input type="text" name="name" maxlength="100" value="<?php print $myrow['name'];?>"></label>
        <label><?php print $items['pages']['change']['forms']['surname_c'];?><input type="text" name="surname" maxlength="100" value="<?php print $myrow['surname'];?>"></label>
        <label><?php print $items['pages']['change']['forms']['email_c'];?><input type="text" name="email" maxlength="100" value="<?php print $myrow['email'];?>"></label>
        <label><?php print $items['pages']['change']['forms']['skype_c'];?><input type="text" name="skype" maxlength="100" value="<?php print $myrow['skype'];?>"></label>
        <input type="submit" value="<?php print $items['pages']['change']['forms']['edit_button_c'];?>">
        </form>
    </p> 
    <?php
	}
    }
    else echo $items['pages']['user']['error_c'];
?>   
</div>
<?php
    include ("block/lang.block.php");
	include("footer.inc.php");
?>
</body>
</html>