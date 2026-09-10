<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";

	$fchk = $conn->getOne("select finish from vod_result_tbl where vsid='$vsid' and usid='".$_COOKIE['wmember_sid']."'");

	if($fchk=='Y'){
		$query = "update vod_result_tbl set confirm='Y', confirm_date='".time()."' where vsid='$vsid' and usid='".$_COOKIE['wmember_sid']."'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		  die($result->getMessage());
		}

		echo "Y";
	}else{
		echo "N";
	}
?>