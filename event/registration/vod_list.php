<?include $_SERVER['DOCUMENT_ROOT']."include.header.php"?>
<?
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';
	
	$num_per_page = 20;
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = " order by sid desc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;


	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	

	if(!$result_code) $result_code='1';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='s_sid'){
					$search_query[] = " society_sid = '".$tval."' ";
				}else if($tkey=='regist_gubunA' || $tkey=='regist_gubunB' || $tkey=='regist_gubunC' || $tkey=='regist_gubunD'){
					if($tkey=='regist_gubunA') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunB') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunC') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunD') $reg_gubun[] = $tval;
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

	if($reg_gubun){
		$search_query[] = " FIND_IN_SET(reg_kind,'".implode(",",$reg_gubun)."')";
	}
	
	if($li_page) $search_url .= "&li_page=".$li_page;
	$search_url .= "&result_code=".$result_code;
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and login2='Y' and login_day2>0 and member_level!='M' and classification not in ('M','X','Z')";	
	}else{
		$fsql = " where del='N' and login2='Y' and login_day2>0 and member_level!='M' and classification not in ('M','X','Z')";
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
	master_echo($query);
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
<div class="searchArea">
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
	<input type="hidden" name="result_code" value="<?=$result_code?>">
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
						<th>면허번호</th>
						<td class="al"><input type="text" name="license_number" id="license_number" value="<?=$license_number?>" style="width:95%;"></td>
					</tr>
					
					
				</tbody>
			</table>
			<div class="btn btnArea">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="검색초기화" class="btnGrey" onclick="location.href='<?=$PHP_SELF?>?result_code=<?=$exam_result?>'">
				<input type="button" value="Excel Backup" onclick="location.href='excel_backup_vod.php'" class="btnMint initialism fade_open btn btn-success ex_btn">
			</div>
		</fieldset>
	</form>
</div>
<div class="contents">
	<table class="tblDef">
		<colgroup>
			<col style="width: 4%;" />
			<col style="width: 10%;" />
			
			
			<col style="" />
			<col style="" />
			<col style="" />
			<col style="" />


		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>구분</th>
				<th>상세구분</th>
				<th><?=admin_orderby("성명","name_kr",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("면허번호","license_number",$sort_field,$orderby,$search_url)?></th>	
				<th>복부초음파</th>
				<th>갑상선초음파</th>
				<th>근골격계초음파</th>
				<th>심초음파</th>
			</tr>
		</thead>
		<tbody>
			<?
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td><?=$virtualRecordNo?></td>
				<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
				<td><?if($d['reg_kind']=='B'){?><?=$d['major_year']?>년차<?}else{?><?=$_REG['gubun1'][$d['gubun1']]?><?}?></td>
				<td><?=$d['name_kr']?></td>
				<td><?=$d['license_number']?></td>

				<?
				$vod_number = array('1','2','3','4');
					foreach($vod_number as $tkey=>$tval){
						$progress_query = "select * from vod_result_tbl where vsid='$tval' and usid='".$d['sid']."'";
						$progress_result = $conn->query($progress_query);
						$progress_result->fetchInto(&$p,DB_FETCHMODE_ASSOC);
						$progress_result->free();
						unset($progress);
						if($p['sid']){
							if($p['c_time']>0){
								$progress = round(($p['c_time']/$p['r_time'])*100);
							}
						}else{
							$progress = 0;
						}
				?>
				<td><?=number_format($progress)?>%</td>
				<?}?>

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

    
 