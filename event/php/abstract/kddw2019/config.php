<?php


##### 데이터베이스 연결인자
$DB['hostName'] = '121.254.129.98';
$DB['userName'] = 'kddw2017';
$DB['userPassword'] = 'kddw2017!@#$';
$DB['dbName'] = 'kddw2019';

if(!class_exists('DB')) { require_once 'DB.php'; }

##### 데이터베이스에 연결한다.
$dsn = "mysql://${DB[userName]}:${DB[userPassword]}@${DB[hostName]}/${DB[dbName]}";

$local_conn = DB::connect($dsn);
if(DB::isError($local_conn)) { die ($local_conn->getMessage()); }
$local_conn->query("set names utf8 ");
unset($DB);
unset($dsn);

$_cfg['degree'] = array('1'=>'M.D.','2'=>'Ph.D.','3'=>'M.D., Ph.D.','99'=>'Others');
