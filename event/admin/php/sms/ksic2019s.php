<?php
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
//exit;
$code = "ksic2019s";

$org_content = 
"대한심혈관중재학회 제38차 하계국제학술대회(KSIC Summer Conference 2019)

-일시: 2019년 7월 5일(금)-6일(토)
-장소: 호텔인터불고대구

대한심혈관중재학회 제38차 하계국제학술대회 참여에 감사드립니다. 등록 및 평점 안내드리오니 확인하여 주시고 착오 없으시길 바랍니다.

네임카드 수령장소 : Registration(2F)

*의사협회 권고에 따라 네임카드 수령시 신분증을 지참하여 주시기 바랍니다.

성명: {이름}
소속: {소속}
면허번호: {면허번호}

>행사정보 보기

http://ezv.kr/php/guidance/?code=".$code."&number={sid}";

$org_content = 
"KSIC Conference APP을 설치하시면 대한심혈관중재학회 학술대회를 편리하게 확인하실 수 있습니다!

안드로이드 다운로드 : https://play.google.com/store/apps/details?id=com.m2comm.ksic2019summer
IOS 다운로드 : https://apps.apple.com/us/app/ksic-conferences/id1469499254?l=ko&amp;ls=1

[Application 기능]
- 프로그램, 강의록 보기
- Faculty 정보 및 스케줄
- Venue Floor Plan
- 실시간 Q&A
- 세션/강의 평가 (프로그램에 대한 나의 의견반영)";


$send_num = "02-582-8212";

$query="SELECT * FROM regist_tbl where code='$code' and ifnull(info6,'')!='' and info6!='-' and info6!='--'";
//$query.=" and (sid='1387' or sid='1388') ";
$result = mysqli_query($conn, $query);

while(is_array($d = mysqli_fetch_assoc($result))){
	
	$name = $d['info10']?$d['info10']:$d['info1'];
	$sosok = $d['info11']?$d['info11']:$d['info2'];
	$license_num = $d['info12']?$d['info12']:$d['info15'];

	$content = str_replace("{이름}", $name, $org_content);
	$content = str_replace("{소속}", $sosok, $content);
	$content = str_replace("{면허번호}", $license_num, $content);
	$content = str_replace("{sid}", $d['sid'], $content);

	$recieve_num = $d['info6'];
	
	$in = "insert into sms_tbl (code, content, recieve_num, send_num) values ('$code', '$content', '$recieve_num', '$send_num')";
	mysqli_query($conn, $in);
}