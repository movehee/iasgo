<?php

$dbName = "lungkorea_katrdic";
$userName = "new_lungkorea";
$userPassword = "rufgor123";
$hostName = "121.254.129.95";

##### including board class files.
include_once "DB.php";

##### 데이터베이스에 연결한다.
$dsn = "mysql://$userName:$userPassword@$hostName/$dbName";
$local_conn = DB::connect($dsn);
if(DB::isError($local_conn)) {
   die ($local_conn->getMessage());
}
$local_conn->query("set names utf8 ");



$_abs_category = array(
"1"=>"Asthma",
"2"=>"Critical Care",
"3"=>"COPD",
"4"=>"DILD",
"5"=>"Lung Cancer",
"6"=>"Pulmonary Vascular diseases",
"7"=>"Pleura and Mediastinum",
"8"=>"Mycobacterial Diseases",
"9"=>"Pulmonary Infection",
"10"=>"Sleep",
"11"=>"Surgery",
"12"=>"Diagnostics",
"13"=>"PFT",
"14"=>"Bronchoscopy",
"15"=>"Smoking",
"16"=>"Environmental Lung Disease",
"17"=>"Miscellaneous"
);
