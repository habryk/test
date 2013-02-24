<?php
	 if(!empty($_SESSION['login']) && !empty($_SESSION['password']) && $_SESSION['permission'] == 1 && isset($_GET['change'])){
?>
<div class="lang_change">
    <form class="lang" action="<?php echo $_SERVER['REQUEST_URI']?>" method="POST">
    <fieldset>
    <legend>Навигация</legend>
        <?php
	       foreach($items['menu'] as $key => $value){
	          echo $items['menu'][$key]."<br>";
              echo "<input type='text' value='".$items['menu'][$key]."' name='".$key."'><br>";
	       }
        ?>
        </fieldset>
        <?php
           	$length = strlen($_SERVER['PHP_SELF']) - 5;
            $page = substr($_SERVER['PHP_SELF'],1,$length);
            if (is_array($items['pages'][$page])){
        ?>
        <fieldset>
    <legend>Cодержимое страницы</legend>
        <?php
	             foreach($items['pages'][$page]['forms'] as $key1 => $value1){
	               echo $value1."<br>";
                    echo "<input type='text' value='".$value1."' name='".$key1."'><br>";
	             }
        ?>
        </fieldset>
        <fieldset>
    <legend>Вывод сообщений</legend>
        <?php           
	             foreach($items['pages'][$page] as $key2 => $value2){
	               if (!is_array($value2)){
	               echo $value2."<br>";
                    echo "<input type='text' value='".$value2."' name='".$key2."'><br>";
                    }
	             }     
           }
        ?>
        </fieldset>
        <input type="submit" name="change_lang" value="Изменить">
    </form>
    <?php
	if (isset($_POST['change_lang'])){
	   foreach($items['menu'] as $k => $v){
	           $items['menu'][$k] = $_POST[$k];
	       }
        $length = strlen($_SERVER['PHP_SELF']) - 5;
        $page = substr($_SERVER['PHP_SELF'],1,$length);
        if (is_array($items['pages'][$page])){
            foreach($items['pages'][$page]['forms'] as $key => $value){
                    $items['pages'][$page]['forms'][$key] = $_POST[$key];
	             }
             foreach($items['pages'][$page] as $key_p => $val){
	               if (!is_array($val)){
                    $items['pages'][$page][$key_p] = $_POST[$key_p];
                    }
	             }  
        }
        $change_items = serialize($items);
        file_put_contents("lang/".$_SESSION['lang'].".php",$change_items);
        echo $items['menu']['change_success'];
	}
?>
</div>
<?php
	}
?>