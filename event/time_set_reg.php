<?
	$file = fopen($_SERVER['DOCUMENT_ROOT']."../webinar/func/config_time_ing.php","w");
	$file2 = fopen($_SERVER['DOCUMENT_ROOT']."../mobile/func/config_time_ing.php","w");
	$file3 = fopen($_SERVER['DOCUMENT_ROOT']."/func/config_time_ing.php","w");

	$content = "<?\n";
	if($time_set_use=='Y'){
		$content .= "\$_Time['use'] = true;\n";
		$set_time = strtotime($set_day." ".$set_time);
		$content .= "\$_Time['ing'] = \"$set_time\";\n"; 
	}else{
		$content .= "\$_Time['use'] = false;\n";
		$content .= "\$_Time['ing'] = time();\n"; 
	}
	$content .= "?>";
	fwrite($file,$content);
	fclose($file);

	fwrite($file2,$content);
	fclose($file2);

	fwrite($file3,$content);
	fclose($file3);
?>
<script>location.href="/";</script>