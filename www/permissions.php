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
<title><?=$items['menu']['permission']?></title>
</head>
<body>
<?php
include ("enter.inc.php");
include ("navigation.inc.php");
include ("block/login.block.php");
?>

<div class="content">
    <?php
    if(!empty($_SESSION['id']) && !empty($_SESSION['login']) && !empty($_SESSION['password']) && $_SESSION['permission'] == 1){
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        if ($_GET['action'] == "del"){
            $sql = "DELETE FROM users WHERE id=?";
            $option = array($_GET['id']);
            $result = sql_query($sql,$option,true);
            if($result){
                echo "<html><head><meta http-equiv='Refresh' content='3; URL=permissions.php'></head>".$items['pages']['permissions']['delSuccess']."</html>";
            }
        }
        else{
        $sql = "SELECT id,permission FROM permission";
        $myrow = sql_query($sql); 
        ?>
        <form action='permissions.php?action=edit' method='POST'>
        <p><?php print $items['pages']['permissions']['choice'];?></p>
        <select name="permission">
        <?php              
          try{     
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );
                $obj = $db->prepare($sql);
                $obj->execute();
                if ($obj->rowCount() > 0){
                while($myrow = $obj->fetch()){
                   printf("<option value='%s'>%s</option>",$myrow['id'],$myrow['permission']);              
                }
                }
                
            }
        catch(PDOException $e){
        $result = "Извините произошла ошибка в строке ";
                $result .= $e->getLine();
                $result .= " в файле ";
                $result .= $e->getFile();
                echo $result;
                file_put_contents('PDOErrors.txt', $result."\n", FILE_APPEND);
        }
        ?>
        </select><br>
        <input type="hidden" name="id" value="<?php print $_GET['id'];?>">
        <input type='submit' value='<?php print $items['button']['edit'];?>'>
        </form>
        <a href="<?php print $_SERVER['REQUEST_URI']."&action=del";?>"><?php print $items['menu']['delUser'];?></a>
    <?php
    }
    }
    elseif ($_SERVER['REQUEST_METHOD'] == "POST"){
        $sql = "UPDATE users SET permission=? WHERE id=?";
        $option = array($_POST['permission'],$_POST['id']);
        $result = sql_query($sql,$option,true);
        if ($result){
            echo "<html><head><meta http-equiv='Refresh' content='3; URL=permissions.php'></head>".$items['pages']['permissions']['editSuccess']."</html>";
        }
    }
    else{
    echo "<table>";
	$sql = "SELECT u.id,u.login,p.permission FROM users u INNER JOIN permission p ON u.permission=p.id ORDER BY u.date";
    $i = 1;
    try{     
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );
                $obj = $db->prepare($sql);
                $obj->execute();
                if ($obj->rowCount() > 0){
                $myrow = $obj->fetch();
                while($myrow = $obj->fetch()){
                    ?>
                   <tr><td class="first"><?php print $i.".";?></td><td><?php print $myrow['login']."</td><td>".$myrow['permission']."</td>";?><td><a href="<?php print $_SERVER['PHP_SELF']."?id=$myrow[id]";?>"><?php print $items['menu']['editUser'];?></a></td></tr>
                    <?php
                    $i++;              
                }
                }
                
            }
        catch(PDOException $e){
        $result = "Извините произошла ошибка в строке ";
                $result .= $e->getLine();
                $result .= " в файле ";
                $result .= $e->getFile();
                echo $result;
                file_put_contents('PDOErrors.txt', $result."\n", FILE_APPEND);
        }
    echo "</table>";
    }
    }   
    else echo $items['pages']['permisiions']['error'];
?>   
</div>
<?php
	include("footer.inc.php");
?>
</body>
</html>