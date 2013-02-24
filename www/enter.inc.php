<div class="enter">
<?php
	if (preg_match("[.+\..+$]",$_SERVER['REQUEST_URI'])){
	   if (preg_match("[.+\..+\?.+$]",$_SERVER['REQUEST_URI'])){
	       $lang = "&lang=";
           $change = "&change";
	   }
       else{
        $lang = "?lang=";
        $change = "?change";
       }
	}
?>
<p>
<a href="<?php print $_SERVER['REQUEST_URI'].$lang."en";?>"><img src="images/eng.png" alt="english"></a>
<a href="<?php print $_SERVER['REQUEST_URI'].$lang."ua";?>"><img src="images/ukr.png" alt="ukraine"></a>
</p>
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
    if(!empty($_SESSION['login']) && !empty($_SESSION['password']) && $_SESSION['permission'] == 1){
        ?>
        
       <br><a href="<?php print $_SERVER['REQUEST_URI'].$change;?>"><?php print $items['menu']['change']; ?></a>
    <?php 
    }
?>
</div>