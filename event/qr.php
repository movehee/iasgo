<?
	include_once $_SERVER['DOCUMENT_ROOT']."/script/phpqrcode/qrlib.php";
	ob_start("colback");
	if(!$qr_number) $qr_number = "TEST";
	$debugLog = ob_get_contents();
	ob_end_clean(); 
	QRcode::png($qr_number,$_SERVER['DOCUMENT_ROOT']."/upload/qr/".$qr_number.".png",0,5,2);
?>