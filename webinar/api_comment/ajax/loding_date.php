<?
header("Content-Type: text/html; charset=UTF-8");

if(is_file($_SERVER['DOCUMENT_ROOT'] . "api_comment/config.php")) include $_SERVER['DOCUMENT_ROOT'] . "api_comment/config.php";
else{
	$return = false;
	$msg = "COMMENT 설정파일이 없습니다.";
	echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
	exit;
}
include $DOCUMENT_ROOT . "api_comment/YY.php";

##로드할 파일명이 명시되었는지 확인
if(empty($_GET['page_name'])){
	$result = array(
		'_false'			=> false,
		'msg'				=> '데이터 파일명이 명시되지 않았습니다.',
		'row'				=> array(),
		'Cnt'				=> 0,
		'timestamp'			=> time()
	);

	$json = json_encode($result);
	echo $json;
	exit;
}

set_time_limit(0);

##로드될 파일의 풀네임
$myfile = $_SERVER['DOCUMENT_ROOT']."api_comment/comment/".$_GET['page_name'].".xml";

if(!is_file($myfile)){
	##파일이 없을경우 오류 리턴
	$result = array(
		'_false'			=> false,
		'msg'				=> '파일이 없습니다.',
		'row'				=> array(),
		'Cnt'				=> 0,
		'timestamp'			=> time()
	);

	$json = json_encode($result);
	echo $json;
	exit;
}

##검색하여 리스트를 불러올 준비를 한다.
$myfile = realpath($myfile);
$doc = new DOMDocument('1.0');

$data_source_file = $save_dirLog.$_GET['roomsid'].'_'.$_GET['date'].'.text';
$time_i = 0;

while (true) {

	if($time_i == 300){
		$doc->load($myfile);
		$xpath = new DOMXpath($doc);

		##검색 조건
		$ss_q = array();
		if(!empty($_GET['_number'])){
			$ss_q['_number'] = '@number="'.$_GET['_number'].'"';
		}

		$query = 'USER_DATE'.(count($ss_q)>0?'['.implode(' and ', $ss_q).']':'');
		$date = $xpath->query($query);

		$row = array();

		if ($date->length>0) {
			$ii = 1;
			foreach ($date as $node) {
				if(!empty($_GET['ss'])){
					$node = $node ->parentNode;
				}
				$d['sid'] = $node->getAttribute("sid");
				$d['csid'] = $node->getAttribute("csid");
				$d['type'] = $node->getAttribute("type");
				foreach ($node->childNodes as $child){
					if($child->nodeName=='signdate'){
						$d[$child->nodeName] = date('Y. m. d. H:i', $child->nodeValue);
					}else if($child->nodeName=='content'){
						$d[$child->nodeName] = url_auto_link($child->nodeValue);
					}else{
						$d[$child->nodeName] = $child->nodeValue;
					}
				}
				
				array_push($row, $d);
				$ii++;
			}
		}

		$ss_q['type'] = '@type="C"';
		$query_Cnt = 'USER_DATE'.(count($ss_q)>0?'['.implode(' and ', $ss_q).']':'');
		$date_Cnt = $xpath->query($query_Cnt);

		$result = array(
			'_false'			=> true,
			'msg'				=> '',
			'row'				=> $row,
			'Cnt'				=> $date_Cnt->length,
			'timestamp'			=> time()
		);

		$json = json_encode($result);
		echo $json;
	}

    $last_ajax_call = isset($_GET['timestamp']) ? (int)$_GET['timestamp'] : null;
    clearstatcache();
    $last_change_in_data_file = filemtime($myfile);
    if ($last_ajax_call == null || $last_change_in_data_file > $last_ajax_call) {
		$doc->load($myfile);
		$xpath = new DOMXpath($doc);
		$row = array();

		##검색 조건
		$ss_q = array();
		if(!empty($_GET['_number'])){
			$ss_q['_number'] = '@number="'.$_GET['_number'].'"';
		}

		$query = 'USER_DATE'.(count($ss_q)>0?'['.implode(' and ', $ss_q).']':'');
		$date = $xpath->query($query);

		if ($date->length>0) {
			$ii = 1;
			foreach ($date as $node) {
				if(!empty($_GET['ss'])){
					$node = $node ->parentNode;
				}
				
				$d['key'] = $ii;
				$d['sid'] = $node->getAttribute("sid");
				$d['csid'] = $node->getAttribute("csid");
				$d['type'] = $node->getAttribute("type");
				foreach ($node->childNodes as $child){
					if($child->nodeName=='signdate'){
						$d[$child->nodeName] = date('Y. m. d. H:i', $child->nodeValue);
					}else if($child->nodeName=='content'){
						$d[$child->nodeName] = url_auto_link($child->nodeValue);
					}else{
						$d[$child->nodeName] = $child->nodeValue;
					}
				}
				
				array_push($row, $d);
				$ii++;
			}
		}

		$ss_q['type'] = '@type="C"';
		$query_Cnt = 'USER_DATE'.(count($ss_q)>0?'['.implode(' and ', $ss_q).']':'');
		$date_Cnt = $xpath->query($query_Cnt);

		$result = array(
			'_false'			=> true,
			'msg'				=> '',
			'row'				=> $row,
			'Cnt'				=> $date_Cnt->length,
			'timestamp'			=> time()
		);

		$json = json_encode($result);
		echo $json;
		break;
    } else {
		$time_i++;
        usleep(200000);
        continue;
    }

}