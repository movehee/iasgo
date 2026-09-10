<?
##### 환경파일 include
include $DOCUMENT_ROOT ."/func/config.php";
include "config.php";
include_once $DOCUMENT_ROOT ."/func/include.function.php";
include $_SERVER['DOCUMENT_ROOT'] . "/func/class.Block.php";
include $_SERVER['DOCUMENT_ROOT'] . "/func/class.Page.php";
$_icon="default/icon";

procLoginChk();
?>
<HTML>
<HEAD>
<link type="text/css" rel="stylesheet" href="/admin/button_package/button.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<TITLE>::: 대한신경외과학회 ::: </TITLE>
<?=$_js_css?>
<style type="text/css">
	body, table, td, span, div{
		font-size:9pt;
	}
	.mail_tbl{
		width:451px;
		height:92px;
		border-top:2px solid #60c60b;
		border-bottom:2px solid #60c60b;
	}
	.mail_tbl .th{
		color:#60c60b;
		text-align:left;
		padding-left:10px;
		background:#f4f4f4;
		border-bottom:1px solid #e6e6e6;
	}
	.mail_tbl .td{
		padding-left:10px;
		border-bottom:1px solid #e6e6e6;
	}
	
	.de_tb{border-top:2px solid #2c66d4;border-right:1px solid #cdced2;}
	.de_td1{background:#f5f8ff;text-align:center;height:30px;color:#1b64ca;font-weight:bold;border-left:1px solid #cdced2;border-bottom:1px solid #cdced2;}
	.de_td2{background:#f0f0f0;text-align:center;height:30px;color:#2f2f2f;font-weight:bold;border-left:1px solid #cdced2;border-bottom:1px solid #cdced2;}
	.de_td3{background:#ffffff;text-align:center;height:30px;color:#2f2f2f;border-left:1px solid #cdced2;border-bottom:1px solid #cdced2;}
	.de_td4{background:#ffffff;text-align:left;padding-left:10px;height:30px;color:#2f2f2f;border-left:1px solid #cdced2;border-bottom:1px solid #cdced2;}
	.de_td5{background:#e9e8e7;text-align:left;height:30px;color:#2f2f2f;font-weight:bold;border-left:1px solid #cdced2;border-bottom:1px solid #cdced2;padding-left:10px;}

	
</style>

</HEAD>

<BODY topmargin="0" leftmargin="0">
<?
	$query = "select * from $mail_tbl where sid='${_GET['sid']}'";
	$result = $conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	$d = $result->fetchRow(DB_FETCHMODE_ASSOC);
?>
<div style="text-align:center;">
<center>
<?
require_once "./conf/class.Template.php";

$tpl = new Template("./templates/");
$tpl->set_file("mail","template.mail0${d['template']}.html");
if($d['btn_type'] == '1'){
	$link_btn = "<a href='http://".$d['btn_link']."' target='_blank'><img src='/image/pop/btn_detail.gif' alt=''/></a>";
}else if($d['btn_type'] == '2'){
	$link_btn = "<a href='http://".$d['btn_link']."' target='_blank'><img src='/image/pop/btn_detail.gif' alt=''/></a>";
}else{
	$link_btn = "";
}

$attach_text = "<br/><div style='text-align:left;margin-top:10px;line-height:150%;'>";


	for($i=1;$i<=10;$i++){
		if($d["file_name${i}"]){
			$attach_text .= "<span style='color:red;'>첨부파일</span> : <a href='http://".$HTTP_HOST."/upload/group_mail/".$d["read_name${i}"]."' target='_blank'>".$d["file_name${i}"]."</a><br/>";
		}
	}


$tpl->set_var(array(
        'url'=>'http://' . $HTTP_HOST,
        'subject_value'=>$d['subject'],
        'body_value'=>$d['content'],
        'link_btn'=>$link_btn,
		'site_name'=>$site_name,
		'site_addr'=>$site_addr,
		'site_tel'=>$site_tel,
		'site_fax'=>$site_fax,
		'site_email'=>$site_email,
		'footer2'=>$footer2,
        'date'=>date('Y-m-d'),
        'attach_file'=>$attach_text
));

$tpl->parse("mailcontents","mail");
$html = $tpl->get_var("mailcontents");

echo "<center>".$html."</center>";

if($keyfield && $keyword){
	if($keyfield=="all"){
		$fsql = " and (name like '%$keyword%' or email like '%$keyword%')";
	}else{
		$fsql = " and $keyfield like '%$keyword%'";
	}
}

$query="SELECT * FROM mail_list_tbl WHERE mail_sid='".$_GET['sid']."'" .$fsql;

$order_string = GET_field($_SERVER['QUERY_STRING'],'order');
$page_string = GET_field($_SERVER['QUERY_STRING'],'page');

$subject_arr = array('name'=>'이름↑↓','email'=>'이메일↑↓','senddate'=>'전송시간↑↓','readdate'=>'확인시간↑↓');
$subject = TBL_subject($subject_arr,$order_string,'/admin/mail/view.php','order',$_GET['order']);

$totalRecord = $conn->getOne(str_replace("*","COUNT(*)",$query));

$pageNav=new Page($page,$totalRecord,$num_per_page);
$totalPage = $pageNav->getTotalPage();
$firstRecord = $pageNav->getFirstRecordInPage();

$_GET['order'] = $_GET['order'] ? $_GET['order'] : "sid DESC";

$query .= " ORDER BY " . $_GET['order'] . " LIMIT " . $pageNav->getFirstRecordInPage().", $num_per_page";

//echo $query."<br/>";

$result=$conn->query($query);
if(DB::isError($result)) die($result->getMessage());

# 가상번호 입력
$virtualRecordNo=$pageNav->getVirtualRecordNoInPage($totalRecord);

# 블럭단위 계산
$blockNav = new Block("", $totalPage, $page_per_block);
$totalBlock = $blockNav->getTotalBlock();
$blockNav->setBlock($page);
$block = $blockNav->getBlock();
$firstPageInBlock = $blockNav->getFirstPageInBlock();
$lastPageInBlock = $blockNav->getLastPageInBlock();
if($block >= $totalBlock) $lastPageInBlock = $totalPage;
?>
</center>
<form name="searchF" id="searchF" method="post" value="<?=$PHP_SELF?>">
<input type="hidden" name="sid" value="<?=$sid?>">
<div>
	<table width="90%" cellpadding="0" cellspacing="0" border="0" class="de_tb" style="margin:20px auto;">
		<tr>
			<td class="de_td1" style="width:20%">검색</td>
			<td class="de_td3" style="text-align:left;padding-left:10px;">
				<select name="keyfield" id="keyfield" >
					<option value="">선택</option>
					<option value="name" <?if($keyfield=='name'){?>selected<?}?>>이름</option>
					<option value="email" <?if($keyfield=='email'){?>selected<?}?>>Email</option>
					<option value="all" <?if($keyfield=='all'){?>selected<?}?>>이름+Email</option>
				</select>
				<input type="text" name="keyword" id="keyword" >
			</td>
		</tr>
	</table>
</div>
</form>

<table width="90%" cellpadding="0" cellspacing="0" border="0" class="de_tb" style="margin:20px auto;">
<col><col><col><col><col>
<tr>
	<td class="de_td1">번호</td>
	<td class="de_td1"><?=$subject[0]?></td>
	<td class="de_td1"><?=$subject[1]?></td>
	<td class="de_td1"><?=$subject[2]?></td>
	<td class="de_td1"><?=$subject[3]?></td>
</tr>
<?while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){?>
<tr>
	<td class="de_td3"><?=$virtualRecordNo?></td>
	<td class="de_td3"><?=$d['name']?></td>
	<td class="de_td3"><?=$d['email']?></td>
	<td class="de_td3"><?=date("Y-m-d H:i:s",$d['senddate'])?></td>
	<td class="de_td3"><?=$d['readdate']?date("Y-m-d H:i:s",$d['readdate']):"-"?></td>
</tr>
<?$virtualRecordNo--;}?>
</table>

<p class="pages center">
	<?if($blockNav->loadPreviousBlock()):?>
		<a href="<?=$_SERVER['PHP_SELF']."?".$page_string?>&page=<?=$firstPageInBlock?>&keyfield=<?=$keyfield?>&keyword=<?=$keyword?>" class="hand"><?=printImg("/image/icon/block_prev.gif", "이전 ${page_per_block} 개 페이지를 불러들입니다.", false, ' align="middle"')?></a>
	<?else:?>
		<?=printImg("/image/icon/block_prev.gif", "이전 ${page_per_block} 개 페이지를 불러들입니다.", false, ' align="middle"')?>
	<?endif?>


	<?for($direct_page = $firstPageInBlock+1; $direct_page <= $lastPageInBlock; $direct_page++):?>
		<?if($page == $direct_page):?>
			<strong><?=$direct_page?></strong>
		<?else:?>
			<a href="<?=$_SERVER['PHP_SELF']."?".$page_string?>&page=<?=$direct_page?>&keyfield=<?=$keyfield?>&keyword=<?=$keyword?>" class="hand"><?=$direct_page?></a>
		<?endif?>
	<?endfor?>


	<?if($blockNav->loadNextBlock()):?>
		<a href="<?=$_SERVER['PHP_SELF']."?".$page_string?>&page=<?=$lastPageInBlock+1?>&keyfield=<?=$keyfield?>&keyword=<?=$keyword?>" class="hand"><?=printImg("/image/icon/block_next.gif", "다음 ${page_per_block} 개 페이지를 불러들입니다.", false, ' align="middle"')?></a>
	<?else:?>
		<?=printImg("/image/icon/block_next.gif", "다음 ${page_per_block} 개 페이지를 불러들입니다.", false, ' align="middle"')?>
	<?endif?>
</p>

</div><br/>
<p align="center">
	<span class="btnAdmin medium navy"><button type="button" onclick="self.close()">닫기</button></span>
</p>
</body>
</html>