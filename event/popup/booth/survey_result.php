<?
	include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php';
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Block.php';

	
	$query = "select * from survey_tbl where booth_sid='$sid'";
	$query .= " order by sort_num asc, sid asc";
	
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		$survey_sid[] = $d['sid'];
		$survey_title[] = $d['survey_title'];
		$survey_type[$d['sid']] = $d['type'];
		$survey_ans[$d['sid']][1] = $d['ans1'];
		$survey_ans[$d['sid']][2] = $d['ans2'];
		$survey_ans[$d['sid']][3] = $d['ans3'];
		$survey_ans[$d['sid']][4] = $d['ans4'];
		$survey_ans[$d['sid']][5] = $d['ans5'];
	}

?>
<link rel="stylesheet" href="/script/colorbox/example1/colorbox.css" />
<script src="/script/colorbox/jquery.colorbox.js"></script>
<script style="text/javascript">
	$(function(){
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,900);
	});
	function modify_survey(str){
		window.open("survey_modify.php?sid="+str,"","width=700,height=800,scrollbars=yes");
	}
</script>
<script>
$(document).ready(function(){
	$(".ajax").colorbox();
	$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
	$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
	$(".iframe").colorbox({iframe:true, width:"1345", height:"815"});
	$(".inline").colorbox({inline:true, width:"50%"});
	$(".callbacks").colorbox({
		onOpen:function(){ alert('onOpen: colorbox is about to open'); },
		onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
		onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
		onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
		onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
	});
});
</script>

<div class="popupCon" id="" style="width:1800px;padding:20px;background:#ffffff;">

<div class="ar tp10 bp10">
	<span class="rBtnAdmin medium green"><button type="button" onclick="location.href='excel_survey_booth.php?sid=<?=$sid?>'">Excel Backup</button></span>
</div>

<table class="tblDef tblList">
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 8%;">
		<col style="width: 8%;">
		<col style="width: 10%;">
		<col style="width: 10%;">
		<col style="width: 20%;">
		<col style="width: 20%;">
		<col style="width: 10%;">
	</colgroup>
	<tbody>
		<tr>
			<th>No</th>
			<th>이름</th>
			<th>E-mail</th>
			<?foreach($survey_title as $tkey=>$tval){?>
			<th><?=$tval?></th>
			<?}?>
		</tr>
		<?
			$query = "select count(cnt) from (select count(*) as cnt from survey_result_tbl where booth_sid='$sid' group by usid, booth_sid) as cnts" ;
			$totalRecord=$conn->getOne($query);

			if(DB::isError($totalRecord)) die($totalRecord->getMessage());
			$pageNav=new Page($page,$totalRecord,$num_per_page);
			$totalPage = $pageNav->getTotalPage();
			$firstRecord = $pageNav->getFirstRecordInPage();

			$query = "select * from survey_result_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.booth_sid='$sid' group by t1.usid, t1.booth_sid order by t1.sid desc";
			$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());


			$virtualRecordNo=$pageNav->getVirtualRecordNoInPage($totalRecord);
			
			# 블럭단위 계산
			$blockNav = new Block("", $totalPage, $page_per_block);
			$totalBlock = $blockNav->getTotalBlock();
			$blockNav->setBlock($page);
			$block = $blockNav->getBlock();
			$firstPageInBlock = $blockNav->getFirstPageInBlock();
			$lastPageInBlock = $blockNav->getLastPageInBlock();
			if($block >= $totalBlock) $lastPageInBlock = $totalPage;

			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
		<tr>
			<td><?=$virtualRecordNo?></td>
			<td><?=$d['name_kr']?></td>
			<td><?=$d['email']?></td>
			<?
			foreach($survey_sid as $tkey=>$tval){
				$answer = $conn->getOne("select user_ans from survey_result_tbl where survey_sid='$tval' and usid='".$d['usid']."'");
				if($survey_type[$tval]=='2'){
					$answer = $survey_ans[$tval][$answer];
				}
			?>
			<td><?=$answer?></td>
			<?}?>
		</tr>
		<?$virtualRecordNo--;}?>
	</tbody>
</table>
<?
	$search_url .= "&sid=".$sid;
?>
<div class="btnArea posRel tp0">
	<?include $_SERVER['DOCUMENT_ROOT']."include.page.php"?>						
</div>
</div>