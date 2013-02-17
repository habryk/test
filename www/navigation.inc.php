<div class="navigation">
<ul>
<li><a href="index.php"><?php print $items['menu']['home'];?></a></li>
<li><a href="news.php"><?php print $items['menu']['news'];?></a></li>
<?php
if(!empty($_SESSION['login']) && !empty($_SESSION['password']) && !empty($_SESSION['id'])){
?>
    <li><a href="user.php"><?php print $items['menu']['user'];?></a></li>
<?php
if ($_SESSION['permission'] == 1){
?>
    <li><a href="permissions.php"><?php print $items['menu']['permission'];?></a></li>
<?php
}	
}
?>
</ul>
</div>