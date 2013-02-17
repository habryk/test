<div class="enter">
<form action="<?php print $_SERVER['PHP_SELF']?>" method="POST">
<?php print $render;?>
<select name="lang" >
  <option  value="en">en</option>
  <option  value="ru">ru</option>
  <option  value="ua">ua</option>
</select>
<input type="hidden" name="langid" value="1">
<input type="submit" value="<?php print $value?>" >
</form>
<?php
	if(!empty($_SESSION['login']) && !empty($_SESSION['password'])) echo $items['greeting'].", ".$_SESSION['login']."! <a href='logout.php'>(".$items['menu']['logout'].")</a>";
    else{
?>
<ul>
<li><a href="login.php"><?php print $items['menu']['login'];?></a></li>|
<li><a href="registration.php"><?php print $items['menu']['registration'];?></a></li>
</ul>
<?php
    }
?>
</div>