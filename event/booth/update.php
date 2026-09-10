<?
	ini_set('memory_limit','-1');
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	include $_SERVER['DOCUMENT_ROOT'] . "func/func.thumb.php";

	$query = "select * from booth_file where kind='8'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		$thumbfile = $_SERVER['DOCUMENT_ROOT'] . "upload/booth/thumb/" . $d['filename'];
		thumbnail($_SERVER['DOCUMENT_ROOT'] . "upload/booth/" . $d['filename'],$thumbfile, 500);
	}
?>