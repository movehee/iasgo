<?include $_SERVER['DOCUMENT_ROOT']."include.header.php"?>
<?
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;

	$num_per_page = 50;
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = " order by sid desc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;


	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code','ev_date');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	

	if(!$result_code) $result_code='1';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='s_sid'){
					$search_query[] = " society_sid = '".$tval."' ";
				}else if($tkey=='regist_gubunA' || $tkey=='regist_gubunB' || $tkey=='regist_gubunC' || $tkey=='regist_gubunD' || $tkey=='regist_gubunE' || $tkey=='regist_gubunP' || $tkey=='regist_gubunG'  || $tkey=='regist_gubunZ'){
					if($tkey=='regist_gubunA') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunP') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunB') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunD') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunE') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunG') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunZ') $reg_gubun[] = $tval;
				}else if($tkey=='program_day1'){
					$search_query[] = " login1 like '%".$tval."%' ";
				}else if($tkey=='program_day2'){
					$search_query[] = " login2 like '%".$tval."%' ";
				}else if($tkey=='program_day3'){
					$search_query[] = " login3 like '%".$tval."%' ";
				}else if($tkey=='program_day4'){
					$search_query[] = " login4 like '%".$tval."%' ";
				}else if($tkey=='regist_kind'){
					$search_query[] = " reg_kind='".$tval."' ";
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
	$search_url .= "&result_code=".$result_code."&ev_date=".$ev_date;
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and login".$ev_date."='Y' and login_day".$ev_date." is null and member_level!='M' and classification not in ('Y','M')";
	}else{
		$fsql = " where del='N' and login".$ev_date."='Y' and login_day".$ev_date." is null and member_level!='M' and classification not in ('Y','M')";
	}
	
	$query = "select count(*) from registration_tbl" .$fsql;

	$totalRecord=$conn->getOne($query);
	
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();
	
	$query = "select * from registration_tbl " .$fsql;
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

?>
<script>
	function sssss(){
		window.open('/popup/registration/login_none.php','SMS','width=700,height=600');
	}
</script>
<div class="searchArea">
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
	<input type="hidden" name="result_code" value="<?=$result_code?>">
	<input type="hidden" name="ev_date" value="<?=$ev_date?>">
		<fieldset>
			<legend>상세 검색</legend>
			<table class="tblDef inputTbl">
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
				</colgroup>
				<tbody>
					<tr>
						<th>ID</th>
						<td class="al"><input type="text" name="id" id="id" value="<?=$id?>" style="width:95%;"></td>
						<th>성명</th>
						<td class="al"><input type="text" name="name_kr" id="name_kr" value="<?=$name_kr?>" style="width:95%;"></td>
						<th>소속</th>
						<td class="al"><input type="text" name="aff_kor" id="aff_kor" value="<?=$aff_kor?>" style="width:95%;"></td>
						<th>E-mail</th>
						<td class="al"><input type="text" name="email" id="email" value="<?=$email?>" style="width:95%;"></td>
						<th>비밀번호</th>
						<td class="al"><input type="text" name="license_number" id="license_number" value="<?=$license_number?>" style="width:95%;"></td>
					</tr>
					<tr>
						<th>등록종류</th>
						<td class="al">
							<select name="classification" style="height:30px;width:80%;">
								<option value="">선택</option>
								<?foreach($_REG['class_kind'] as $tkey=>$tval){?>
								<option value="<?=$tkey?>" <?if($classification==$tkey){?>selected<?}?>><?=$tval?></option>
								<?}?>
							</select>
						</td>
						<th>등록구분</th>
						<td class="al" colspan="7">
							<select name="regist_kind" style="height:30px;">
								<option value="">선택</option>
								<?foreach($_REG['reg_kind'] as $tkey=>$tval){?>
								<option value="<?=$tkey?>" <?if($regist_kind==$tkey){?>selected<?}?>><?=$tval?></option>
								<?}?>
							</select>
							<!-- <select name="gubun1" style="height:30px;">
								<option value="">선택</option>
								<?foreach($_REG['gubun1'] as $tkey=>$tval){?>
								<option value="<?=$tkey?>" <?if($gubun1==$tkey){?>selected<?}?>><?=$tval?></option>
								<?}?>
							</select>
							<select name="gubun2" style="height:30px;">
								<option value="">선택</option>
								<?foreach($_REG['gubun2'] as $tkey=>$tval){?>
								<option value="<?=$tkey?>" <?if($gubun2==$tkey){?>selected<?}?>><?=$tval?></option>
								<?}?>
							</select> -->
						</td>
					</tr>
					
				</tbody>
			</table>
			<div class="btn btnArea">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="검색초기화" class="btnGrey" onclick="location.href='<?=$PHP_SELF?>?ev_date=<?=$ev_date?>'">
				<input type="button" value="Excel Backup" onclick="location.href='excel_backup_none.php?<?=$search_url?>&ev_date=<?=$ev_date?>'" class="btnGreen2 initialism fade_open btn btn-success ex_btn">

				<!-- <input type="button" value="Booth Event Day 1" onclick="location.href='excel_booth_event.php?day=1'" class="btnMint initialism fade_open btn btn-success ex_btn">
				<input type="button" value="Booth Event Day 2" onclick="location.href='excel_booth_event.php?day=2'" class="btnMint initialism fade_open btn btn-success ex_btn"> -->
			</div>
		</fieldset>
	</form>
</div>
<div >
	<div class="btn bp5" style="float:left;">
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
</div>

<div class="contents">
	<table class="tblDef">
		<colgroup>
			<col style="width: 4%;" />
			<col style="width: 5%;" />
			<col style="width: 6%;" />
			<col style="width: 6%;" />
			<col style="width: 5%;" />
			<col style="width: 5%;" />
			<?for($date=1;$date<=$date_count;$date++){?>
			<col style="width: 5%;" />
			<?}?>
			<col style="width: 15%;" />
			<col style="width:" />
			<col style="width: 12%;" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>등록종류</th>
				<th><?=admin_orderby("ID","id",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("성명","name_kr",$sort_field,$orderby,$search_url)?></th>
				<th>비밀번호</th>
				<th><?=admin_orderby("면허번호","license_number",$sort_field,$orderby,$search_url)?></th>	
				<?for($date=1;$date<=$date_count;$date++){?>	
					<th><?=date("m.d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></th>
				<?}?>
				
				<!-- <th>평의원회</th>
				<th>평점</th>
				<th>이벤트</th> -->
				<th><?=admin_orderby("소속","aff_kor",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("E-mail","email",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("연락처","cell",$sort_field,$orderby,$search_url)?></th>
				<!-- <th>관리</th> -->
			</tr>
		</thead>
		<tbody>
			<?
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td><?=$virtualRecordNo?></td>
				<td><?=$_REG['class_kind'][$d['classification']]?></td>
				<td><?=$d['id']?></td>
				<td><?=$d['name_kr']?></td>
				<td><?=$d['passwd']?></td>
				
				<td><?=$d['license_number']?></td>
				
				<?for($date=1;$date<=$date_count;$date++){?>	
					<td style="color:<?=$_REG['enter_color'][$d['login'.$date]]?>"><?=$_REG['enter'][$d['login'.$date]]?></td>
				<?}?>
				<td><?=$d['aff_kor']?></td>
				<td><?=$d['email']?></td>
				<td><?=$d['cell']?></td>
			</tr>
			<?$virtualRecordNo--;}?>
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

    
 