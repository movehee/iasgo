<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$case_path = $_SERVER['DOCUMENT_ROOT'].'upload/booth/';
	
	$delfile = $conn->getOne("select $kind from booth_company where booth_sid='$booth_sid'");

	@unlink($case_path.$delfile);

	$query = "update booth_company set ".$kind."='' where booth_sid='$booth_sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}

	echo "Y";
	exit;
?>