<?php
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
//exit;
$code = "ksic2020";

/*
$org_content = 
"The 16th KSIC International Conference in the Winter (KSIC 2020)

-일시: 2020년 01월 09(목)~11(토)
-장소: 서울신라호텔

대한심혈관중재학회 제16회 동계국제학술대회 참여에 감사드립니다. 등록 및 평점 안내드리오니 확인하여 주시고 착오 없으시길 바랍니다.

네임카드 수령장소 : Registration (본관1F)

*의사협회 권고에 따라 네임카드 수령시 신분증을 지참하여 주시기 바랍니다.

성명: {이름}
소속: {소속}
면허번호: {면허번호}

>행사정보 보기

http://ezv.kr/php/guidance/ksic2020w/index.php?number={sid}";

*/
$org_content = 
"KSIC Conference APP을 설치하시면 대한심혈관중재학회 학술대회정보를 편리하게 확인하실 수 있습니다!

안드로이드 다운로드 : http://ezv.kr/ksic/ksic2020_and.php

IOS 다운로드 : http://ezv.kr/ksic/ksic2020_ios.php

IOS 업데이트 방법안내 ▶ http://ezv.kr/ksic/iosUpdate.php


[Application 기능]

 - 프로그램, 강의록 보기

 - Faculty 정보 및 스케줄

 - Venue Floor Plan

 - 실시간 Q&A

 - 세션/강의 평가 (프로그램에 대한 나의 의견반영)";

$send_num = "02-582-8212";




$query="SELECT * FROM regist_tbl where code='$code' and ifnull(info2,'')!='' and info2!='-' and info2!='--'";
//$query.=" and (sid='1387' or sid='1388') ";
$result = mysqli_query($conn, $query);

while(is_array($d = mysqli_fetch_assoc($result))){
	
	$name = $sosok = "";
	//$name = $d['info10']?$d['info10']:$d['info1'];
	if($d['info11']) {
		$name = str_replace("&&", " ", $d['info11']);
	}
	
	//$sosok = $d['info11']?$d['info11']:$d['info2'];
	if($d['info3']) {
		$sosok = $d['info3'];
	}

	//$license_num = $d['info12']?$d['info12']:$d['info15'];
	if($d['info9']) {
		$license_num = $d['info9'];
	}

	$content = str_replace("{이름}", $name, $org_content);
	$content = str_replace("{소속}", $sosok, $content);
	$content = str_replace("{면허번호}", $license_num, $content);
	$content = str_replace("{sid}", $d['sid'], $content);

	$recieve_num = $d['info2'];
	
	$in = "insert into sms_tbl (code, content, recieve_num, send_num) values ('$code', '$content', '$recieve_num', '$send_num')";
	mysqli_query($conn, $in);
}


/*
$sample_list = array(
	array("name"=>"이광식", "sosok"=>"소속1", "license_num"=>"123456", "recieve_num"=>"01062360556", "sid"=>"1"),
	array("name"=>"박진현", "sosok"=>"소속2", "license_num"=>"654321", "recieve_num"=>"01082009329", "sid"=>"2")
);

foreach($sample_list as $key => $d) {

	$name = $d['name'];
	$sosok = $d['sosok'];
	$license_num = $d['license_num'];

	$content = str_replace("{이름}", $name, $org_content);
	$content = str_replace("{소속}", $sosok, $content);
	$content = str_replace("{면허번호}", $license_num, $content);
	$content = str_replace("{sid}", $d['sid'], $content);

	$recieve_num = $d['recieve_num'];
	
	$in = "insert into sms_tbl (code, content, recieve_num, send_num) values ('$code', '$content', '$recieve_num', '$send_num')";
	mysqli_query($conn, $in);
}
*/