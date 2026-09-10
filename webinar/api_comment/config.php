<?php
##코멘트 설정값(만들면서 생각함)
$_COMMENTCNF['ex_url'] = explode("/",$_SERVER['PHP_SELF']);
$_COMMENTCNF['ex_url'] = array_values(array_filter(array_map('trim',$_COMMENTCNF['ex_url'])));

$_COMMENTCNF['page_name'] = array();
foreach($_COMMENTCNF['ex_url'] as $ex_url_key=>$ex_url_val){
	$file_name=$ex_url_val;
	$file_name_arr=array();
	if(count($_COMMENTCNF['ex_url'])-1 == (int)$ex_url_key){
		##파일이라면
		$file_name_arr=explode('.', $ex_url_val);
		$file_name=$file_name_arr[0];
	}

	$_COMMENTCNF['page_name'][$ex_url_key] = $file_name;
}

if(!empty($_COMMENTCNF['page_code'])){
	$_COMMENTCNF['page_name']['page_code'] = $_COMMENTCNF['page_code'];
}

$_COMMENTCNF['page_name'] = implode('_',$_COMMENTCNF['page_name']);

##만들어질 코멘트파일 저장 경로
$_COMMENTCNF['comment_dir'] = $_SERVER['DOCUMENT_ROOT']."api_comment/comment/";

##검색 사용유무(제작 안함)
$_COMMENTCNF['ss'] = false;
$_COMMENTCNF['ss_key'] = array('name'=>'이름','id'=>'아이디','content'=>'내용');


##링크(이미지및 홈페이지 링크) 필터링 사용유무
$_COMMENTCNF['url_link'] = true;

$_COMMENTCNF['poster_sid'] = $sid;

##수정및 삭제를위한 쿠키 아이디&이름(홈페이지 환경에 맞게 변경해주세요.)
$_COMMENTCNF['cid'] = !empty($_COOKIE['wmember_sid'])?$_COOKIE['wmember_sid']:'';#$_COOKIE['member_id'];
$_COMMENTCNF['cname'] = !empty($_COOKIE['wmember_name'])?$_COOKIE['wmember_name']:'Guest';#$_COOKIE['member_name'];


if($_COOKIE['wmember_level'] == 'M') {
	$_COMMENTCNF['admin'] = true;
}


function url_auto_link($str = '', $popup = true){
    if (empty($str)) {
        return false;
    }
    $target = $popup ? 'target="_blank"' : '';
    $str = str_replace(
        array("&lt;", "&gt;", "&amp;", "&quot;", "&nbsp;", "&#039;"),
        array("\t_lt_\t", "\t_gt_\t", "&", "\"", "\t_nbsp_\t", "'"),
        $str
    );

    $str = preg_replace(
        "/([^(href=\"?'?)|(src=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[가-힣\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,\(\)]+)/i",
        "\\1<a href=\"\\2\" {$target}>\\2</A>",
        $str
    );
    $str = preg_replace(
        "/(^|[\"'\s(])(www\.[^\"'\s()]+)/i",
        "\\1<a href=\"http://\\2\" {$target}>\\2</A>",
        $str
    );
    $str = preg_replace(
        "/[0-9a-z_-]+@[a-z0-9._-]{4,}/i",
        "<a href=\"mailto:\\0\">\\0</a>",
        $str
    );
    $str = str_replace(
        array("\t_nbsp_\t", "\t_lt_\t", "\t_gt_\t", "'"),
        array("&nbsp;", "&lt;", "&gt;", "&#039;"),
        $str
    );
    return $str;
}


//$test_hp = "010-6236-0556";