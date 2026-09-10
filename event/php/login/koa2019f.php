<?php
	header('Content-Type: text/html; charset=UTF-8');
##### 데이터베이스 연결설정 인자 (서버명, 사용자명, 비밀번호, 작업대상 데이터베이스명)
$hostName = "121.254.129.98";
$userName = "koa2016";
$userPassword = "koa2016!@#";
$dbName = "koa2019";

##### 데이터베이스에 연결한다.
if(!class_exists("DB")) {
   include "DB.php";
}

##### 데이터베이스에 연결한다.
$dsn = "mysql://$userName:$userPassword@$hostName/$dbName";
$conn = DB::connect($dsn);
if(DB::isError($conn)) {
   die ($conn->getMessage());
}
$conn->query("set names utf8");

unset($dsn);

mysql_query("set session character_set_connection=utf8;");
mysql_query("set session character_set_results=utf8;");
mysql_query("set session character_set_client=utf8;");



$query = "SELECT * FROM user_binfo where del_app='N' and del='N' and join_type='Y' and kor_name='$name' and license_num='$license'";
$result = $conn->query($query);
$rows = $result->numRows();


if($rows){

	$result->fetchInto(&$d, DB_FETCHMODE_ASSOC);

	$booth="N";
	if($d['title']=="1" || $d['title']=="2" ){
		$booth="Y";
	}
	
	if ( $license == "0000" ) $booth = "N";
	
	$json = array('sid'=>$d['sid'],
		'name'=>$d['kor_name'],
		'gubun'=>$d['gubun'],
		'license'=>$d['license_num'],
		'booth'=>$booth,
		'office'=>$d['hospital_kor']
		);
	echo json_encode($json);
}else{
	echo "성함, 면허번호를 확인해주세요";
}


/*
if($rows) {

	$result->fetchInto(&$row, DB_FETCHMODE_ASSOC);

	$param  = array(
		'regist_sid'=>$row['sid'],
		'name'=>$row['kor_name']
	);
	
	$json  = array('rows'=>$rows, 'data'=>$param);
	
}
else {

	$json  = array('rows'=>$rows);
}


echo json_encode($json);

*/
/*
	1.url : http://ezv.kr/php/login/koa2019f.php?name=이름&license_num=면허번호
	ex ) http://ezv.kr/php/login/koa2019f.php?name=정형&license_num=12344

	2. method : x

	3. return

	성공 : {"rows":1,"data":{"regist_sid":"41","name":"\uc815\ud615"}}
	실패 : {"rows":0}

	4. 특이사항
	regist_sid 가지고 다니기
*/