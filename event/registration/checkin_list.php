<?include $_SERVER['DOCUMENT_ROOT']."/include.header.php"?>
<?
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
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
			}
		}
	}

	if($li_page) $search_url .= "&li_page=".$li_page;
	$search_url .= "&result_code=".$result_code;
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N'";
	}else{
		$fsql = " where del='N'";
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
						<td class="al"><input type="text" name="affiliation_kor" id="affiliation_kor" value="<?=$affiliation_kor?>" style="width:95%;"></td>
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
				<!-- <input type="button" value="Excel Backup" class="btnMint initialism fade_open btn btn-success ex_btn"> -->
			</div>
		</fieldset>
	</form>
</div>
<div>
	<div class="btn bp5" style="float:right;">
		<a href="javascript:popup_call('registration/postform','')" class="btnGrey withIcon"><i class="fas fa-edit"></i>임의 등록</a>
	</div>
</div>
<div class="contents">
	<table class="tblDef">
		<colgroup>
			<col style="width: 5%;" />
			<col style="width: 7%;" />
			<col style="width: 10%;" />
			<col style="width: 10%;" />
			<col style="width: " />
			<col style="width: 20%;" />
			<col style="width: 10%;" />
			<col style="width: 4%;" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th><?=admin_orderby("구분","country",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("ID","id",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("성명","name_kr",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("소속","aff_kor",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("E-mail","email",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("면허번호","license_number",$sort_field,$orderby,$search_url)?></th>	
				<th>관리</th>
			</tr>
		</thead>
		<tbody>
			<?
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

					$chk_query = "select * from checkin_tbl where usid='$d[sid]' and day='1'";
					$chk_result = $conn->query($chk_query);
					$chk_result->fetchInto(&$time,DB_FETCHMODE_ASSOC);
					$chk_result->free();
			?>
			<tr>
				<td><?=$virtualRecordNo?></td>
				<td><?=$d['country']?></td>
				<td><?=$d['id']?></td>
				<td>
				<?
					echo $d['first_name']." ".$d['last_name'];
					if($d['name_kr']) echo '<br />'.$d['name_kr'];
				?>
				</td>
				<td>
				<?
					if($time['log_arr']){
						$session_time_arr = json_decode($time['log_arr'], true);
						foreach($session_time_arr as $tkey=>$tval){
							//echo print_r($tval[1])."<br>";
							//echo print_r($tval).'<br>';
							foreach($tval as $skey=>$sval){
								foreach($sval as $dkey=>$dval){
									
								}
								echo $skey.'세션<br>';
							}
						}
						echo "<br><br>";
						//print_r($session_time_arr);
						echo $time['log_arr'];
					}
				?>
				</td>
				<td><?=$d['email']?></td>
				<td><?=$d['license_number']?></td>
				<td>
					<img src="/image/icon_modify.png" alt="삭제" class="hand" onclick="popup_call('registration/postform','sid=<?=$d['sid']?>')">
					<img src="/image/icon_del.png" alt="삭제" class="hand" onclick="common_delete('<?=$d['sid']?>','registration')">
				</td>
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

    
 