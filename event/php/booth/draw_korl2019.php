<?
header('Content-Type: text/html; charset=UTF-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
	//$mode = "test";
}
$code = "korl2019";



/////셋팅

/* 조건
1. Booth Event는 Booth 방문개수가 전체 부스의
50-70%, 70-90%, 90-100%로 sorting해서 관리자가 목록을 볼 수 있게 해주시면 좋겠습니다.

2. 설문조사 참여자
*/

//부스갯수 70개 일 경우 > 구간 조건 바뀔경우 직접 수정 : 숫자 겹치지 않게
//1: 66이상 (1명 추첨)‬
$_arr['1']['start'] = 66;
$_arr['1']['end'] = 100; //넉넉하게

//2: 41 ~ 65 (2명 추첨)
$_arr['2']['start'] = 41;
$_arr['2']['end'] = 65;

//3: 1 ~ 40 (5명 추첨)
$_arr['3']['start'] = 1;
$_arr['3']['end'] = 40;

/////셋팅



//추첨 설정 ( 구간을 모두 주석처리 할경우 참여숫자 여부와 관계 없이 추첨)
$gugan = 1; //1구간 (1명 추첨)
//$gugan = 2; //2구간 (2명 추첨)
//$gugan = 3; //3구간 (5명 추첨)



$feedback = 'Y'; //피드백 참여자 추첨 ( 미사용시 주석 )


$query = "select * from (
select count(a.user_sid) cnt, a.user_sid, b.sid as gift_sid, f.sid as feedback_sid , t.deviceID, t.name, t.office 
from booth_event_tbl a 
JOIN login_tbl t ON a.user_sid=t.sid and t.code='$code' 
LEFT JOIN booth_event_gift_tbl b ON a.user_sid=b.user_sid and b.code='$code' 
LEFT JOIN feedback_result_tbl f ON f.deviceid=t.deviceID and f.code='$code' 
where a.code='$code' and (booth_sid>=337 and booth_sid<=577) group by a.user_sid) c where ";

$query .= " c.gift_sid IS null ";


if($gugan) {
	$query .= " AND c.cnt>='".$_arr[$gugan]['start']."' and c.cnt<='".$_arr[$gugan]['end']."' ";
}

if($feedback == 'Y') {
	$query .= " AND ifnull(feedback_sid,'')!=''";
}
$query .= " order by rand();";
$result = mysqli_query($conn, $query);

/*
if($mode == "test") {
	
	while($row_test = mysqli_fetch_array($result)) {
		echo ++$test_num;
		echo " . ";
		echo $row_test['name']." // ";
		echo $row_test['user_sid']." // ";
		echo $row_test['office']." // ";
		echo $row_test['deviceID']." // ";
		echo $row_test['cnt']."회";
		echo "<br>";
	}
	exit;
	mysqli_data_seek($result,0); 
}
*/


$row = mysqli_fetch_array($result);

$arr = array("office"=>$row['office'], "name"=>$row['name']);

echo json_encode($arr);

$query = "INSERT INTO booth_event_gift_tbl SET ";
$query .= "code='".$code."'";
$query .= ",gift_info='$gugan'";
$query .= ",user_sid='".$row['user_sid']."'";
$query .= ",signdate='".time()."'";

$result = mysqli_query($conn, $query);

?>
