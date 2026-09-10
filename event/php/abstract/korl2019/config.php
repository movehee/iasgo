<?php
$hostName = "121.254.129.80";
$userName = "korl";
$userPassword = "dlqldls";
$dbName = "korl";

$local_conn = mysqli_connect($hostName, $userName, $userPassword, $dbName);

if ($local_conn->connect_errno) {
	die('Not connected : ' . mysqli_connect_error());
}

$local_conn->query("set names utf8");



/*By Topics*/
//일반 section_category
$section_category_name = array("1"=>"이과","2"=>"비과","3"=>"두경부","9"=>"후두음성언어 자유연제", "10"=>"기관식도 자유연제","91"=>"이과 포스터 전시","92"=>"비과 포스터 전시","93"=>"두경부 포스터 전시","94"=>"이과 포스터 발표","95"=>"비과 포스터 발표","96"=>"두경부 포스터 발표","청각사 자유연제","언어치료사 자유연제");

//초청연재 section_category
$section_sympo_name = array("1"=>"이과","2"=>"비과","3"=>"두경부","4"=>"korl","5"=>"청각","6"=>"기관식도","7"=>"후두음성","8"=>"안면성형","9"=>"소아이비인후과");
/*By Topics*/

$_abs_category[2] = $section_category_name + $section_sympo_name;

/*
$_abs_category[1] = array("101"=>"Plenary session",
"102"=>"해외연자특강",
"103"=>"Symposium",
"104"=>"Panel discussion",
"105"=>"Education course",
"1"=>"Oral presentation",
"107"=>"Satellite symposium",
"4"=>"Video session",
"2"=>"TPP",
"3"=>"Poster Exhibition",
"111"=>"위원회 session",
"112"=>"Education course");
*/

$_abs_category[1] = array("1"=>"이과 구연",
"2"=>"비과 구연",
"3"=>"두경부 구연",
"4"=>"이과 포스터발표 (TPP teaser poster presentation)",
"5"=>"비과 포스터발표 (TPP teaser poster presentation)",
"6"=>"두경부 포스터발표 (TPP teaser poster presentation)",
"7"=>"이과 포스터전시",
"8"=>"비과 포스터 전시",
"9"=>"두경부 포스터 전시",
"10"=>"대한이과학회 프로그램",
"11"=>"대한청각학회 프로그램",
"12"=>"대한비과학회 프로그램",
"13"=>"대한갑상선두경부외과학회 프로그램",
"14"=>"대한소아이비인후과학회 프로그램", 
"15"=>"대한안면성형재건학회 프로그램", 
"16"=>"공통프로그램", 
"17"=>"Video session");
