<?php
$http_host = $_SERVER['HTTP_HOST'];
$relative_path = preg_replace("`\/[^/]*\.php$`i", "/", $_SERVER['PHP_SELF']);

if($code && $number) {
	echo "<meta http-equiv='refresh' content='0;url=http://".$http_host."/".$relative_path."/".$code."?number=".$number."'>";
}