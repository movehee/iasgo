<?
header('Content-Type: text/html; charset=UTF-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$code = "ksoug2019";

if($type == 1) { //일반회원

	if($name && $office) {

		$query = "select * from login_tbl where code='$code' and type='$type' and name='$name' and office='$office'";
		$result = mysqli_query($conn, $query);
		if(!$result->num_rows) {
			$in = "insert into login_tbl (name, office, deviceid, code, signdate, type) values ('$name', '$office', '$deviceid', '$code', '".time()."', '1')";
			mysqli_query($conn, $in);


			$query = "select * from login_tbl where code='$code' and type='$type' and name='$name' and office='$office'";
			$result = mysqli_query($conn, $query);
		}
		

		$row = mysqli_fetch_array($result);
		$param  = array(
			'regist_sid'=>$row['sid'],
			'name'=>$row['name'],
			'office'=>$row['office'],
			'judge'=>'N'

		);
		
		$json  = array('rows'=>'1', 'data'=>$param);

	}
	else {

		$json  = array('rows'=>'0');
	}

	


}
else if($type == 2) { //심사위원
	$query = "select * from login_tbl where code='$code' and type='$type' and name='$name' and passwd='$passwd'";
	$result = mysqli_query($conn, $query);
	$rows = $result->num_rows;

	if($rows) {

		$row = mysqli_fetch_array($result);

		if(!$row['deviceID']) {

			$update = "update login_tbl set deviceid='$deviceid', signdate='".time()."' where sid = '$row[sid]'";
			mysqli_query($conn, $update);
		}

		$param  = array(
			'regist_sid'=>$row['sid'],
			'name'=>$row['name'],
			'office'=>$row['office'],
			'judge'=>'Y'
		);
		
		$json  = array('rows'=>$rows, 'data'=>$param);

	}
	else {
		$json  = array('rows'=>$rows);
	}
}



/*
	-로그인

	1. 일반
	http://ezv.kr/php/login/ksoug2019.php?type=1&name=이름&office=소속
	요청 param: type(고정값: 1) ,name ,office, deviceid
	반환 param: rows, regist_sid, name, office, judge(고정값: N)

	특이사항 : rows 값이 0 일경우는 이름이나 소속 근무처값이 없을경우


	2. 심사위원
	http://ezv.kr/php/login/ksoug2019.php?type=2&name=산초심사1&passwd=1234
	요청 param: type(고정값: 2) ,name ,passwd, deviceid
	반환 param: rows, regist_sid, name, office(값 없음), judge(고정값: Y)

	특이사항 : 없음

	공통특이사항 : 피드백, 보팅, 설문시 regist_sid 값을 넘겨주세요.

*/

//print_r($json);
echo json_encode($json);