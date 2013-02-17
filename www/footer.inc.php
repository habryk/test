<?php
	$footer = "SELECT COUNT(*) FROM users WHERE activation='1'";
    $footerres = mysql_query($footer); 
    $footerrow = mysql_fetch_array($footerres);
?>
<div class="footer">
<p><?=$items['forms']['users'],$footerrow[0]?></p>
</div>