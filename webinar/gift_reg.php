<?
include $_SERVER['DOCUMENT_ROOT']."lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

$kind = "B";

$gift_num = rand(1,4);
if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
	//echo $gift_num.'<br>';
}
if($gift_num==1){
	$gift_num = rand(1,50);
}else if($gift_num==2){
	$gift_num = rand(1,10);
}


$query = "select * from registration_tbl where etc_field2='".trim($regist_number)."'";
$result = $conn->query($query);
$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
$result->free();

if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
	//echo $gift_num;
	//exit;
}

if(!$d['sid']){
	PutLocation("/gift.php?gift_num=X");
	//PutMessageLocation("You are not a participant in the 2nd event","/gift.php?gift_num=X");
	exit;
}

$country = $d['country'];


$gchk = $conn->getOne("select count(sid) from gift_tbl where usid='".$d['sid']."' and kind='A'"); //후원사 참여내역 확인
if($gchk==0){
	PutLocation("/gift.php?gift_num=R");
	//PutMessageLocation("Please start by participating in the sponsor booth event.","/gift.php");
	exit;
}
$get_gift = $_Gift['gift_'.$country][$gift_num]['title'];
$get_cnt = $_Gift['gift_'.$country][$gift_num]['cnt'];

$join_chk = $conn->getOne("select count(sid) from gift_tbl where usid='".$d['sid']."' and kind='B'");


if($join_chk>0){
	PutLocation("/gift.php?gift_num=A");
	//PutMessageLocation("You have already participated.","/gift.php?gift_num=N");
}else{
	if($_Gift['gift_'.$country][$gift_num]){
		
		$gift_chk = $conn->getOne("select count(sid) from gift_tbl where gift='".$gift_num."' ");
		if($gift_chk>=$get_cnt){
			$gift_num = "N";	
		}
	}else{
		$gift_num = "N";
	}
	$query = "insert into gift_tbl set kind='".$kind."'";
	$query .= ", usid='".$d['sid']."'";
	$query .= ", gift='".$gift_num."'";
	$query .= ", signdate='".time()."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();

}

if($gift_num=='N'){
	PutLocation("/gift.php?gift_num=N");
}else{
	PutLocation("/gift.php?gift_num=".$gift_num);
}


exit;
PutLocation("/mypage/index.php?kind=booth_event");
/*echo json_encode(array(
	'gift_num'=>$gift_num,
	'get_gift'=>$get_gift
));*/
?>