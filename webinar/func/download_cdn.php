<?
	header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=".$url.";");
	header("Content-Length: ".filesize($url));
	file_get_contents($url);
	exit();
?>