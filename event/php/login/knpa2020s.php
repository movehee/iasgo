<?php
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$code = "knpa2020s";
/*
$name = $_POST['name'];
$license_number = $_POST['license_number'];
*/

$query = "SELECT * FROM regist_tbl where del='N' and code='".$code."'";
$query .= "and info1='".$name."'";
$query .= "and info2='".$license_number."'";

$result = mysqli_query($conn, $query);
$rows = $result->num_rows;
if($rows) {

	$row = mysqli_fetch_array($result);

	$param  = array(
		'regist_sid'=>$row['sid'],
		'name'=>$row['info1']
	);


	$login_query_in = "insert into login_tbl (code, deviceID, name, license_number, signdate) values ('$code', '$deviceid', '$name', '$license_number', '".time()."')";
	mysqli_query($conn, $login_query_in);

	$json  = array('rows'=>$rows, 'data'=>$param);

}
else {

	$json  = array('rows'=>$rows);
}


echo json_encode($json);


/*
	1.url : http://ezv.kr/php/login/knpa2019f.php?name=이름&license_number=면허번호

	2. method : post

	3. return

	성공 : [{"rows":"1","data":[{"regist_sid":"2486","name":"\uc774\uad11\uc2dd"}]}]
	실패 : [{"rows":"0"}]

	4. 특이사항
	regist_sid 값을 피드백 및 강의평가 작성시 table 에 insert 할 예정입니다.
*/
