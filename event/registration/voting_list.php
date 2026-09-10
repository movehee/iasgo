<?include $_SERVER['DOCUMENT_ROOT']."include.header.php"?>
<?
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;


	$v_code = "day".$ev_date;
	
	$room_cnt = $conn->getOne("select * from workshop_session_category where kind='P' and del='N'");
	if($room_cnt>0){
		$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
		$room_result=$conn->query($room_query);
		if(DB::isError($room_result)) die($room_result->getMessage());
		while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
			$room_sid[] = $r['sid'];
			$room_name[$r['sid']] = $r['title'];
		}
	}


	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';
	
	$num_per_page = 50;
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = " order by sid desc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;


	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','ev_date','result_code','v_code');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	

	if(!$result_code) $result_code='1';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='s_sid'){
					$search_query[] = " society_sid = '".$tval."' ";
				}else if($tkey=='program_day1'){
					$search_query[] = " login1 like '%".$tval."%' ";
				}else if($tkey=='program_day2'){
					$search_query[] = " login2 like '%".$tval."%' ";
				}else if($tkey=='program_day3'){
					$search_query[] = " login3 like '%".$tval."%' ";
				}else if($tkey=='program_day4'){
					$search_query[] = " login4 like '%".$tval."%' ";
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
				
			}
			$search_url .= "&$tkey=".$tval;
		}
	}
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and member_level!='M' and login1='Y'";
	}else{
		$fsql = " where del='N' and member_level!='M' and login1='Y'";
	}


	$lecture_query = "select * from lecture_tbl where del='N' and code='$v_code' order by sid asc";
	$lecture_result=$conn->query($lecture_query);
	if(DB::isError($lecture_result)) die($lecture_result->getMessage());
	while ($lec = $lecture_result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$lecture_sid[] = $lec['sid'];
		$lecture_title[] = $lec['name'];
		$Vcnt[] = $conn->getOne("select count(*) from voting_tbl where del='N' and status>0 and lecture='".$lec['sid']."'");
		

		$voting_cnt = $conn->getOne("select count(*) from voting_tbl where del='N' and status>0 and lecture='".$lec['sid']."'");
		
		if($voting_cnt){
			$voting_query = "select * from voting_tbl where del='N' and status>0 and lecture='".$lec['sid']."' order by sid asc";
			$voting_result=$conn->query($voting_query);
			if(DB::isError($voting_result)) die($voting_result->getMessage());

			while ($vt = $voting_result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$voting_sid[] = $vt['sid'];
				$voting_order[] = $vt['orderby'];
			}
		}else{
			$voting_sid[] = "";
			$voting_order[] = "-";
		}
	}
?>

<div >
	<div class="btn" style="float:left;">
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" class="<?if($ev_date==$date){?>btnRed<?}else{?>btnBdGrey<?}?>"><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>

	
</div>
<div style="clear:both;padding-bottom:20px;"></div>

<div class="searchArea">
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
	<input type="hidden" name="v_code" value="<?=$v_code?>">
	<input type="hidden" name="ev_date" value="<?=$ev_date?>">
		<fieldset>
			<legend>상세 검색</legend>
			<table class="tblDef inputTbl">
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
				</colgroup>
				<tbody>
					<tr>
						<th>성명</th>
						<td class="al"><input type="text" name="name_kr" id="name_kr" value="<?=$name_kr?>" style="width:95%;"></td>
					
						<th>면허번호</th>
						<td class="al"><input type="text" name="license_number" id="license_number" value="<?=$license_number?>" style="width:95%;"></td>
					</tr>
				</tbody>
			</table>
			<div class="btn btnArea">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="검색초기화" class="btnGrey" onclick="location.href='<?=$PHP_SELF?>?result_code=<?=$exam_result?>&ev_date=<?=$ev_date?>'">
				<input type="button" value="Excel Backup" class="btnMint initialism fade_open btn btn-success ex_btn" onclick="location.href='voting_excel.php?v_code=<?=$v_code?>'">
			</div>
		</fieldset>
	</form>
</div>
<div class="contents">
	<table class="tblDef">
		<colgroup>
			<col style="width: 3%;" />
			<col style="width: 10%;" />
			<!-- <col style="width: 10%;" />
			<col style="width: 10%;" />
			<col style="width: 10%;" /> -->
			<col style="width: 10%;" />
		</colgroup>
		<thead>
			<tr>
				<th rowspan=2>No</th>
				<th rowspan=2>회원구분</th>
				<th rowspan=2><?=$_REG['gubun1_title']?></th>
				<th rowspan=2><?=admin_orderby("성명","name_kr",$sort_field,$orderby,$search_url)?></th>
				<th rowspan=2><?=admin_orderby("면허번호","license_number",$sort_field,$orderby,$search_url)?></th>	
				<?foreach($lecture_title as $tkey=>$tval){?>
				<th colspan="<?=$Vcnt[$tkey]?>"><?=$tval?>(<?=$Vcnt[$tkey]?>건)</th>
				<?}?>
			</tr>
			<tr>
				<?if($voting_sid){?>
				<?foreach($voting_sid as $tkey=>$tval){?>
				<th ><?if($voting_order[$tkey]>0){?><?=$voting_order[$tkey]?>번<?}else{?>-<?}?></th>
				<?}?>
				<?}?>
			</tr>
		</thead>
		<tbody>
			<?
				$query = "select count(*) from registration_tbl " .$fsql;
				if($v_code=='day1'){
					$query .= " and login1='Y' ";
				}else if($v_code=='day2'){
					$query .= " and login2='Y' ";
				}
				$totalRecord=$conn->getOne($query);
				
				if(DB::isError($totalRecord)) die($totalRecord->getMessage());
				$pageNav=new Page($page,$totalRecord,$num_per_page);
				$totalPage = $pageNav->getTotalPage();
				$firstRecord = $pageNav->getFirstRecordInPage();

				$query = "select * from registration_tbl ".$fsql;
				if($v_code=='day1'){
					$query .= " and login1='Y' ";
				}else if($v_code=='day2'){
					$query .= " and login2='Y' ";
				}
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

					$v_result_query = "select count(*) ";
					if($voting_sid){
					foreach($voting_sid as $tkey=>$tval){
						$v_result_query .= ", sum(case when deviceid='".$d['sid']."' and voting_sid='$tval' then val else '' end) as V_val".$tval;
					}
					}
					if($ev_date=='1'){
						$v_result_query .= " from voting_result_tbl where deviceid='".$d['sid']."'";
					}else{
						$v_result_query .= " from voting_result_tbl where deviceid='".$d['sid']."'";
					}
					$v_result = $conn->query($v_result_query);

					$v_result->fetchInto(&$vc,DB_FETCHMODE_ASSOC);
					$v_result->free();
			?>
			<tr>
				<td><?=$virtualRecordNo?></td>
				<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
				<td><?if($d['reg_kind']=='B'){?><?=$d['major_year']?>년차<?}else{?><?=$_REG['gubun1'][$d['gubun1']]?><?}?></td>
				<td><?=$d['name_kr']?></td>
				<td><?=$d['license_number']?></td>
				<?if($voting_sid){?>
				<?foreach($voting_sid as $tkey=>$tval){?>
				<td><?if($vc['V_val'.$tval]>0){?><?=$vc['V_val'.$tval]?><?}?></td>
				<?}?>
				<?}?>
			</tr>
			<?$virtualRecordNo--;}?>
		</tbody>
	</table>
	<?
		if($add_search2) $search_url .= $add_search2;
		if($sort_field) $search_url .= "&sort_field=".$sort_field;
		if($orderby) $search_url .= "&orderby=".$orderby;
		if($ev_date) $search_url .= "&ev_date=".$ev_date;

		$excel_kind = "exam_result"; //엑셀백업 구분값
	?>
	<div class="btnArea posRel">
		<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.page.php"?>						
	</div>
</div> 
<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.footer.php"?>		

    
 