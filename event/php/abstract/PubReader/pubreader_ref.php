<?
##### 사용자정의 함수 스크립트 가져오기
include $DOCUMENT_ROOT . "func/include.function.php";

include_once $DOCUMENT_ROOT . "func/include.connect.php";

// 레퍼런스 값 가져옴
$res = mysql_query("SELECT t2.scid, t1.ref_doi FROM journal_reference_tbl t1 LEFT OUTER JOIN journal_tbl t2 ON (t1.ref_title=t2.title AND t1.ref_year=t2.publisher_year AND t1.ref_vol=t2.volume AND t1.ref_fpage=t2.firstpage AND t1.ref_lpage=t2.lastpage) WHERE number='$number' ORDER BY t1.sort_num asc");


$index = 0;
$array = array();
while($row = mysql_fetch_assoc($res)) {
	$reficon = "";
	$reftext = "";
	foreach ($row as $key => $value) 
	{
		if($value) 
		{
			switch($key) { // 각 레퍼런스에 맞는 아이콘 및 주소 생성
				case "ref_doi":
					$value = "http://dx.doi.org/$value";
					$img = "bnr_ref_cross";
					$ref_link_text = "[CrossRef]";
					break;
				case"scid":
					$value = "http://e-sciencecentral.org/articles/$value";
					$img = "scid";
					$ref_link_text = "[ScienceCentral]";
					break;
				
			}
			$reficon .= "<a href='$value' target='_blank'><img src='/image/$img.gif' width='55px' alt='crossref' border='0'/></a> ";
			$reftext .= "<a href='$value' target='_blank'>$ref_link_text</a> ";
		}
	}
	// 레퍼런스 번호에 맞는 위치에서 개행되는 부분을 찾아서 레퍼런스값 삽입
	$array[] = array("id" => $id[$index], "text" => $reftext);
	$index++;
	
}


echo json_encode($array);

?>