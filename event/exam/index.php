<?include $_SERVER['DOCUMENT_ROOT']."include.header.php"?>
<?
	//include_once $_SERVER['DOCUMENT_ROOT'] . "func/config.exam.php";

	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';
	

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	
	if(!$ev_date) $ev_date = 1;


	$num_per_page = 50;
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = " order by exam_num asc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;
	
	if($_Activation['category']){
		if(!$category) $category="A";
	}
	

	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code','chkday','ev_date');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	if(!$kind) $kind="A";
	if(!$chkday) $chkday=1;	
	
	
	if(!$result_code) $result_code='1';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='s_sid'){
					$search_query[] = " society_sid = '".$tval."' ";
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
				
			}
			$search_url .= "&$tkey=".$tval;
		}
	}

	if($reg_gubun){
		$search_query[] = " FIND_IN_SET(reg_kind,'".implode(",",$reg_gubun)."')";
	}
	
	if($li_page) $search_url .= "&li_page=".$li_page;
	$search_url .= "&result_code=".$result_code;
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and day='$chkday'"; //and kind='$kind' and day='$chkday'
	}else{
		$fsql = " where del='N' and day='$chkday'"; //and kind='$kind' and day='$chkday'
	}
	if($_Activation['category']){
		$fsql .= " and category='$category'";
	}
	
	$query = "select count(*) from exam_tbl" .$fsql;
	master_echo($query);
	$totalRecord=$conn->getOne($query);
	
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();
	
	$query = "select * from exam_tbl " .$fsql;
	$query .= $sort_sql;
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

	if($_Activation['category']){
		if(!$category) $category=key($_Exam['category']);
	}

?>
<div class="tp20"></div>


<div >
	<div class="btn" style="float:left;">
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&chkday=<?=$date?>" <?if($chkday==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
	<div class="btn" style="float:right;">
		<a href="javascript:popup_call('exam/postform','kind=<?=$kind?>&chkday=<?=$chkday?>&category=<?=$category?>')" class="btnGrey withIcon"><i class="fas fa-edit"></i>문제 등록</a>
		<a href="javascript:popup_call('excel/upload','kind=exam&chkkind=<?=$kind?>&chkday=<?=$chkday?>&category=<?=$category?>')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Excel Upload</a>
	</div>
</div>

<div style="clear:both;padding-top:10px;">
	
	<?if($_Activation['category']){?>
	<div class="btn" style="float:left;">
		<?foreach($_Exam['category'] as $tkey=>$tval){?>
		<a href="<?=$PHP_SELF?>?category=<?=$tkey?>&chkday=<?=$chkday?>" <?if($category==$tkey){?>class="btnRed"<?}?>><?=$tval?></a></li>
		<?}?>
	</div>
	<?}?>
	<!-- <div class="btn" style="float:right;margin-top:7px;">
		<a href="javascript:popup_call('exam/postform','kind=<?=$kind?>&chkday=<?=$chkday?>')" class="btnGrey withIcon"><i class="fas fa-edit"></i>문제 등록</a>
		<a -href="javascript:popup_call('excel/upload','kind=exam&chkkind=<?=$kind?>&chkday=<?=$chkday?>')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Excel Upload</a>
	</div> -->
</div>
<div style="clear:both;padding-bottom:10px;"></div>

<?
	$equery = "select * from exam_manager_tbl where day='$chkday' and category='$category'";
	$eresult = $conn->query($equery);
	$eresult->fetchInto(&$e,DB_FETCHMODE_ASSOC);
	$eresult->free();

	if($e['sid']){
		$ex_exam_sdate = explode(" ",$e['sdate']);
		$ex_exam_edate = explode(" ",$e['edate']);
	}
?>

<div>
	<form name="exam_termF" id="exam_termF" method="post">
	<input type="hidden" name="chkday" value="<?=$chkday?>">
	<input type="hidden" name="category" value="<?=$category?>">
	<table class="tblDef">
		<tr>
			<th style="width:140px;">기간설정</th>
			<td class="al">	
				<div style="float:left;">
					<input type="hidden" name="sdate" id="sdate" value="<?=date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($chkday-1), $ex_sdate[0]));?>" class="date" style="width:120px;" readonly>
					<input type="text" name="stime" id="stime" value="<?=$ex_exam_sdate[1]?>" class="timepicker" style="width:60px;" readonly> ~
					<input type="text" name="etime" id="etime" value="<?=$ex_exam_edate[1]?>" class="timepicker" style="width:60px;" readonly>
				</div>
				<?if($category=='B'){?>
				<div style="float:left;padding-left:10px;font-size:15px;"> 
					<div class="fcRed tp5 lp10" style="float:left;">
					<input type="checkbox" name="time_set" id="time_set" value="Y" <?if($e['time_set']=='Y'){?>checked<?}?> style="width:20px;height:20px;">
					</div>
					문제당 
					<input type="text" name="time_limit" id="time_limit" style="width:50px;" <?if($e['time_set']!='Y'){?>disabled<?}?> value="<?=$e['time_limit']?>" numberOnly="true">
					초 시간설정을 합니다.
					
				</div>
				<?}?>
				<div class="btn" style="float:right;padding-left:10px;"> 
					<a href="javascript:exam_term_chk('<?=$chkday?>')" class="btnGreen2 withIcon"><i class="far fa-save" style="font-size:18px;padding-top:0px;"></i>저장하기</a>
					
					<div class="fcRed tp5 lp10" style="float:right;font-size:15px;">
						<input type="checkbox" name="term_reset" id="term_reset" value="Y" style="width:20px;height:20px;"> <label for="term_reset">삭제 (설정한 값이 없는경우 해당 일자에 상시 오픈됩니다.)</label>
					</div>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>

<div class="contents tp10">
	<table class="tblDef">
		<colgroup>
			<col style="width: 7%;" />
			<col style="" />

			<col style="width: 30%;" />
			<col style="width: 5%;" />
			<col style="width: 5%;" />
			<col style="width: 5%;" />
		</colgroup>
		<thead>
			<tr>
				<th><?=admin_orderby("문제번호","exam_num",$sort_field,$orderby,$search_url)?></th>
				<th>문제</th>
				<th>해설</th>
				<th>답</th>
				<th>점수</th>
				<th>관리</th>
			</tr>
		</thead>
		<tbody>
			<?
				$n=1;
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td><?=$d['exam_num']?></td>
				<td class="al"><?=strip_tags($d['question'])?></td>
				<td class="al"><?=strip_tags($d['commentary'])?></td>
				
				

				<td><?=$d['answer']?></td>
				<td><?=$d['score']?></td>
				<td>
					<img src="/image/icon_modify.png" alt="삭제" class="hand" onclick="popup_call('exam/postform','sid=<?=$d['sid']?>')">
					<img src="/image/icon_del.png" alt="삭제" class="hand" onclick="common_delete('<?=$d['sid']?>','exam')">
				</td>
			</tr>
			<?$n++;$virtualRecordNo--;}?>
		</tbody>
	</table>
	<?
		if($add_search2) $search_url .= $add_search2;
		if($sort_field) $search_url .= "&sort_field=".$sort_field;
		if($orderby) $search_url .= "&orderby=".$orderby;

		$excel_kind = "exam_result"; //엑셀백업 구분값
	?>
	<div class="btnArea posRel">
		<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.page.php"?>						
	</div>
</div> 
<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.footer.php"?>		

    
 