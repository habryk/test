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
<label><?php print $items['forms']['login'];?><input type="text" name="login"></label>
<label><?php print $items['forms']['password1'];?><input type="password" name="password"></label><br>
<input type="checkbox" name="auto" value="1"><?php print $items['forms']['auto'];?><br>
<input type="submit" value="<?php print $items['button']['login'];?>" name="form1">
</form>
<?php
	}
?>
</div>