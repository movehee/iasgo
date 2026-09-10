
<?include "./../header.php";?>
<?

function replace_arr($s) {
	return $s;//(strtr($s, array('&' => '&amp;', '<' => ' &lt;', '>' => '&gt;', '\'' => '＇')));
}

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


$query = "select * from abstract_tbl WHERE sid = '".$sid."'";
$result = mysqli_query($conn, $query);
$abs_col = mysqli_fetch_array($result);



//$query = "select * from session_tbl WHERE abs_no = '".$subcol['abs_no']."'";
//echo $query;
//$result = mysqli_query($conn, $query);
//$abs_col = mysqli_fetch_array($result);

?>

<div class="wrapper">
	<!-- container -->
	<div id="containerWrap">
		
<div class="titArea">
	<h2><?=$setting_col['abstract_txt']?></h2>
	<p class="fixedBtn">
		<a onclick="javascript:history.back();" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		
	</p>
</div>

<?


$my_abstract="";
if($setting_col['abs_info1'] && $abs_col['info1'])
	$my_abstract .="<p>".$setting_col['abs_info1']." : ".addslashes(replace_arr(str_replace("\n","<br>",$abs_col['info1'])))."</p>";
if($setting_col['abs_info2'] && $abs_col['info2'])
	$my_abstract .="<p>".$setting_col['abs_info2']." : ".addslashes(replace_arr(str_replace("\n","<br>",$abs_col['info2'])))."</p>";
if($setting_col['abs_info3'] && $abs_col['info3'])
	$my_abstract .="<p>".$setting_col['abs_info3']." : ".addslashes(replace_arr(str_replace("\n","<br>",$abs_col['info3'])))."</p>";
if($setting_col['abs_info4'] && $abs_col['info4'])
	$my_abstract .="<p>".$setting_col['abs_info4']." : ".addslashes(replace_arr(str_replace("\n","<br>",$abs_col['info4'])))."</p>";
if($setting_col['abs_info1'] && $abs_col['info5'])
	$my_abstract .="<p>".$setting_col['abs_info5']." : ".addslashes(replace_arr(str_replace("\n","<br>",$abs_col['info5'])))."</p>";

$content='';
$contents .="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$content.='<!DOCTYPE article PUBLIC "-//NLM//DTD JATS (Z39.96) Journal Publishing DTD v1.0 20120330//EN" "JATS-journalpublishing1.dtd">';
$content.='<article article-type="research-article" dtd-version="1.0" xml:lang="ko" xmlns:mml="http://www.w3.org/1998/Math/MathML" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
$content.='<front>';
$content.='<journal-meta> <journal-id journal-id-type="publisher-id"></journal-id> <issn></issn> <publisher> <publisher-name></publisher-name> </publisher> </journal-meta>';
$content.='<article-meta>';
//$content.='<article-id pub-id-type="doi">'.$abs_date.'</article-id>';
$content.='<title-group>';
$content.='<article-title>'.replace_arr($abs_col['title']).'</article-title>';
$content.='</title-group>';
$content.='<contrib-group>';

$content.='<contrib contrib-type="author">';
	$content.='<name-alternatives>';

		$content.='<name name-style="western" xml:lang="en">';
			$content.='<given-names>'.$announcer_kr."\t".$announcer_en."<p></p>".$author_knames."\t".$author_enames.'</given-names>';
		$content.='</name>';
		$content.='<name name-style="eastern" xml:lang="ko">';
			$content.='<given-names>'.$author_khos."\t".$author_ehos.'</given-names>';
		$content.='</name>';
	
	$content.='</name-alternatives>';
	
	$content.='<xref ref-type="corresp" rid="c1-csd-19-3-307" />';
$content.='</contrib>';

$content.='</contrib-group>';
$content.='<pub-date>';
	$content.='<year></year>';
$content.='</pub-date>';
$content.='<volume></volume>';
$content.='<issue></issue>';
$content.='<abstract>';
$content.='<p>'. $my_abstract .'</p>';
$content.='</abstract>';

/*$content.='<kwd-group xml:lang="ko">';
$content.='<kwd>'.$keyword1.'</kwd>';
$content.='</kwd-group>';
if($keyword2){
$content.='<kwd-group xml:lang="en">';
$content.='<kwd>'.$keyword2.'</kwd>';
$content.='</kwd-group>';
}*/
$content.='</article-meta>';
$content.='</front>';
$content.='<body>';

	$content.='<sec sec-type="display-objects">';
	$content.='</sec>';
$content.='</body>';
$content.='</article>';



require_once $_SERVER['DOCUMENT_ROOT'].'/PubReader/class.pubreader.php';

$pub = new Pubreader();
$pub_data['xml_file'] = $content;

//$pub_data['db-number'] = $col['sid']; //  논문의 번호

//$pub_data['db-number'] = $sid; //  논문의 번호
//$pub_data['thumb-path'] = '/workshop/'.$code_arr[$abyear2].'/files/thumbnails/'; //섬네일 경로
//$pub_data['custom-abbr'] = $col['journal_abbr_title']; //저널 약어명
//$pub_data['journal-list-url'] = '/journals/list.php'; // sc에 등재된 저널 리스트 url
//$pub_data['journal-issues-url'] = '/journals/'.$col['journal_code']; // 해당 논문의 저널 url 홈페이지는 Archive
//$pub_data['journal-articles-url'] = '/issues/'.$col['issue_code']; // 해당 논문의 저널 url 홈페이지는 Archive
//$pub_data['article-url'] = '/articles/'.$col['scid'];
//$pub_data['table-ext'] = "test.png";//기본 테이블 이미지 확장명
//$pub_data['article-type'] = "journal";//기본 테이블 이미지 확장명

//$pub_data['ref-style'] = $ref_style; //science-central 용

//$pub_data['search-url-type'] = "1"; //science-central 용
//$pub_data['search-url'] = "/advanced/"; //science-central 용


$html = $pub->transform($pub_data);
$html = str_replace("\t","<br>",$html);
//$html = str_replace("purpose : ","<b>purpose : </b>",$html);
//$html = str_replace("methods : ","<b>methods : </b>",$html);
//$html = str_replace("results : ","<b>results : </b>",$html);
//$html = str_replace("conclusion : ","<b>conclusion : </b>",$html);
//$html = str_replace("<sup>"," ",$html);
//$html = str_replace("</sup>"," ",$html);



?>
<div class="contents">
<div id="pubReader">
	<?=$html?>
	
</div>
</div>


</body>
</html>

