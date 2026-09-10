<?php

/*
$local_conn = mysqli_connect(
  '121.254.129.98',
  'koa2016',
  'koa2016!@#',
  'koa2019');
mysqli_set_charset($local_conn, 'utf8');
*/

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
$local_conn = DB::connect($dsn);
if(DB::isError($local_conn)) {
   die ($local_conn->getMessage());
}
$local_conn->query("set names utf8");

unset($dsn);





$_abs_category = array("1"=>"Knee",
"2"=>"Tumor",
"3"=>"Hip",
"4"=>"Shoulder and Elbow",
"5"=>"Spine",
"6"=>"Foot and Ankle",
"7"=>"Fracture",
"8"=>"Paediatrics",
"9"=>"Hand",
"10"=>"Basic Researches",
"11"=>"Microsurgery",
);


$abs_config['department_type'] = array('1'=>'Orthopaedic','2'=>'Others');