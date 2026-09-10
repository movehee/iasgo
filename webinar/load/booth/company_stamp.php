<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";

	$stamp_chk = $conn->getOne("select count(sid) from booth_stamp_ind where usid='".$_COOKIE['wmember_sid']."' and booth_sid='".$booth_sid."' and kind='vod'");
	if($stamp_chk==0){
		$stamp_query = "insert into booth_stamp_ind set usid='".$_COOKIE['wmember_sid']."', booth_sid='".$booth_sid."', kind='vod', signdate='".time()."'";
		$stamp_result=$conn->query($stamp_query);
		if(DB::isError($stamp_result)) die($stamp_result->getMessage());
	}
	echo json_encode(array('result'=>'Y'));
	exit;
?>