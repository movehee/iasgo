<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$query = "update booth set bg_color='$bg_color', font_color='$font_color' where sid='$sid'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	$conn->disconnect();
		
	PutLocation("booth_image.php?sid=".$sid);
?>