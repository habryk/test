<div class="login">
<?php
	if (!empty($_SESSION["login"]) && !empty($_SESSION["password"])){
print <<<HERE
<style>
.login{
    display:none;   
}
.content,.footer,.navigation,.enter{
    width: 94%;
    margin-left:3%;
}
</style>
HERE;
	}
    else{
?>
<h3><?php print $items['menu']['login'];?></h3>
<form action="login.php" method="POST">
<label><?php print $items['pages']['login']['forms']['login_l'];?><input type="text" name="login"></label>
<label><?php print $items['pages']['login']['forms']['password_l'];?><input type="password" name="password"></label>
<input type="checkbox" name="auto" value="1"><?php print $items['pages']['login']['forms']['avto_l'];?><br>
<input type="submit" value="<?php print $items['pages']['login']['forms']['enter_l'];?>" name="form1">
</form>
<?php
	}
?>
</div>