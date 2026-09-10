<?php 
##특정데이터 로드
header("Content-Type: text/html; charset=UTF-8");

##로드할 파일명이 명시되었는지 확인
if(empty($_GET['file_name'])){
	echo "불러올 파일설정이 되지 않았습니다.";
	exit;
}

##로드될 파일의 풀네임
$myfile = $_SERVER['DOCUMENT_ROOT']."api_comment/comment/".$_GET['file_name'].".xml";

if(!is_file($myfile)){
	##파일이 없을경우 오류 리턴
	echo "파일이 없습니다.";
	exit;
}

##검색하여 리스트를 불러올 준비를 한다.
$myfile = realpath($myfile);
$doc = new DOMDocument('1.0');
$doc->load($myfile);

$xpath = new DOMXpath($doc);


##검색 조건
$ss_q = array();
$ss_q['type'] = '@type="C"';
if(!empty($_GET['_sid'])){
	$ss_q['_sid'] = '@sid="'.$_GET['_sid'].'"';
}

if(!empty($_GET['_csid'])){
	$ss_q['_csid'] = '@csid="'.$_GET['_csid'].'"';
	$ss_q['type'] = '@type="CC"';
}

if(!empty($_GET['_number'])){
	$ss_q['_number'] = '@number="'.$_GET['_number'].'"';
}

$query = 'USER_DATE'.(count($ss_q)>0?'['.implode(' and ', $ss_q).']':'').(!empty($_GET['ss'])?"/".(!empty($_GET['name'])?$_GET['name']:'name')."[contains(text(),'".$_GET['ss']."')]":"");

$date = $xpath->query($query);



if ($date->length>0) {
	foreach ($date as $node) {
		if(!empty($_GET['ss'])){
			$node = $node ->parentNode;
		}

		foreach ($node->childNodes as $child) {
		
			 echo "[".$child->nodeName.":".$child->nodeValue."]", PHP_EOL;
		}
		echo "<Br />";
	}
}else{
	##불러온 데이터가 0개 일경우
	echo "데이터가 없습니다.";
	exit;
}