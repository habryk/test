<?php
	$footer = "SELECT id FROM users WHERE activation=?";
    $footer_opt = array(1);
    $footerrow = sql_query($footer,$footer_opt,false,true);
?>
<div class="footer">
<p><?php print $items['menu']['users'].$footerrow;?></p>
</div>