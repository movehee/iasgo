<?include $_SERVER['DOCUMENT_ROOT']."/include.header.php"?>
<?
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	

	$time_max_count=3; //총 세션의 갯수 정의

	if(!$ev_date) $ev_date = 1;
	
	
	$num_per_page = 10;
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = "   order by day desc, first_date asc";
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
				if($tkey=='key'){
					$search_query[] = " usid = '".$tval."' ";
				}else if($tkey=='program_day1'){
					$day_query[] = " day ='1'";
				}else if($tkey=='program_day2'){
					$day_query[] = " day ='2'";
				}else if($tkey=='program_day3'){
					$day_query[] = " day ='3'";
				}else if($tkey=='program_day4'){
					$day_query[] = " day ='4'";
				}else if($tkey=='s1_sdate' || $tkey=='s1_edate' || $tkey=='s2_sdate' || $tkey=='s2_edate' || $tkey=='s3_sdate' || $tkey=='s3_edate' || $tkey=='s4_sdate' || $tkey=='s4_edate'){
					if($tval=='Y'){
						$search_query[] = " $tkey>0 ";
					}else if($tval=='N'){
						$search_query[] = " ($tkey='' or $tkey is null) ";
					}
				}else if($tkey=='s1_stime' || $tkey=='s2_stime' || $tkey=='s3_stime' || $tkey=='s4_stime' || $tkey=='s1_etime' || $tkey=='s2_etime' || $tkey=='s3_etime' || $tkey=='s4_etime'){
					if($tkey=='s1_stime' || $tkey=='s2_stime' || $tkey=='s3_stime' || $tkey=='s4_stime'){
						$search_query[] = " ".str_replace("_stime","_sdate",$tkey).">=unix_timestamp(concat(substr(from_unixtime(".str_replace("_stime","_sdate",$tkey)."),1,10),' ".$tval."'))";
					}else if($tkey=='s1_etime' || $tkey=='s2_etime' || $tkey=='s3_etime' || $tkey=='s4_etime'){
						$search_query[] = " ".str_replace("_etime","_edate",$tkey)."<=unix_timestamp(concat(substr(from_unixtime(".str_replace("_etime","_edate",$tkey)."),1,10),' ".$tval."'))";
					}
				}else if($tkey=='id'){
					$day_query[] = " $tkey like '%".$tval."%' ";
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
			}
			$search_url .= "&$tkey=".$tval;
		}
	}
	if($day_query){
		$search_query[] = " (".implode(" or ",$day_query).")";
	}
	if($inout_query){
		$search_query[] = " (".implode(" and ",$inout_query).")";
	}

	if($li_page) $search_url .= "&li_page=".$li_page;
	//$search_url .= "&result_code=".$result_code;
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' group by usid";//and t2.member_level!='M'
		$fsql_count = " where ".implode($search_type,$search_query) . " and del='N' ";//and t2.member_level!='M'
	}else{
		$fsql = " where del='N'  group by usid";//and t2.member_level!='M'
		$fsql_count = " where del='N' ";//and t2.member_level!='M'
	}
	

	
	
	//$query = "select count(*) from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid " . $fsql;
	for($s=1;$s<=$time_max_count;$s++){
		$session_field[] = "s".$s."_sdate, s".$s."_edate";
	}
	$add_field = ",usid,day,del,first_date,last_date,group_key,name_kr,license_number,id,aff_kor,email,classification,modify,member_level,chking,reg_kind,gubun1,gubun2";
	
	$query = "select count(distinct(usid)) from (";
	$query .= "(select ".implode(",",$session_field). $add_field." from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	foreach($_CONFIG['Gkey'] as $tkey=>$tval){
		$query .= "union all ";
		$query .= "(select ".implode(",",$session_field). $add_field." from checkin_tbl_".$tval." as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	}
	$query .= ") A" . $fsql_count;
	$query .= " and member_level!='M' and classification not in ('Y','M','X','Z')";

	//$query .= " and t2.member_level!='M'";
	//$query .= " and t1.usid not in ($pass_sid_arr)";

	if($_SERVER['REMOTE_ADDR']=='218.235.94.2202' || $_SERVER['REMOTE_ADDR']=='218.235.94.221' || $_SERVER['REMOTE_ADDR']=='218.235.94.20522'){
		//$query .= " and chking!='Y' and day='2'";
		//$query .= " and member_level!='M' and classification not in ('Y','M','X','Z')"; //and reg_kind in ('K','L','M','R','U')
	}
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		//$query .= " and first_date>unix_timestamp('2021-04-11 10:40:00')";
	}

	
	
	$totalRecord=$conn->getOne($query);

	$num_per_page = 50;
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();
	
	//$query = "select t1.*,t2.license_number,t2.name_kr,t2.sid as usid,t2.classification,t2.logout_day1,t2.logout_day2,t2.logout_day3,t2.logout_day4,t2.reg_kind,t2.gubun1,t2.gubun2 from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid " . $fsql;

	$query = "select ".implode(",",$session_field). $add_field.",sid from (";
	$query .= "(select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	foreach($_CONFIG['Gkey'] as $tkey=>$tval){
		$query .= "union all ";
		$query .= "(select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl_".$tval." as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	}
	$query .= ") A" . $fsql;

	//$query .= " and t1.day='2' and t1.score='4'";
	//$query .= " and t1.usid not in ($pass_sid_arr)";
	if($_SERVER['REMOTE_ADDR']=='218.235.94.22'  || $_SERVER['REMOTE_ADDR']=='218.235.94.221' || $_SERVER['REMOTE_ADDR']=='218.235.94.20522' ){
		//$query .= " and t1.usid in ($pass_sid_arr)";
		$query .= " and chking!='Y' and day='2'";
		//$query .= " and score='6'  and t1.day='1'";
		$query .= " and member_level!='M' and classification not in ('M','X','Z')"; //and reg_kind in ('K','L','M','R','U')
	}
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		//$query .= " and first_date>unix_timestamp('2021-04-11 10:40:00')";
	}
	//$query .= " and t2.member_level!='M'";

	$query .= $sort_sql; //and t2.day='2' and t1.score='6' //id asc, t1.day asc, 
	
		
	if($_SERVER['REMOTE_ADDR']!='218.235.94.22'){
		$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
	}
	//master_echo($query);
	//echo ($query);
	
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
				<input type="button" value="Excel Backup" onclick="location.href='excel_backup_cert.php'" class="btnMint initialism fade_open btn btn-success ex_btn">
			</div>
		</fieldset>
	</form>
</div>
<div style="clear:both;">
	<!-- <div style="float:left;">
		<span class="rBtnAdmin medium white"><button type="button" onclick="location.href='index.php'">사전등록 명단</button></span>
		<span class="rBtnAdmin medium blue"><button type="button" onclick="location.href='index_checkin.php'">입 출 확 인</button></span>
	</div> -->
	<!-- <div style="float:right;">
		<span class="rBtnAdmin large darkPink <?if($day!='1'){?>empty<?}?>"><button type="button" onclick="location.href='<?=$PHP_SELF?>?day=1'">17 일</button></span>
		<span class="rBtnAdmin large darkPink <?if($day!='2'){?>empty<?}?>"><button type="button" onclick="location.href='<?=$PHP_SELF?>?day=2'">18 일</button></span>
		<span class="rBtnAdmin large darkPink <?if($day!='2'){?>empty<?}?>"><button type="button" onclick="location.href='<?=$PHP_SELF?>?day=2'">19 일</button></span>
	</div> -->
</div>
<div class="bp10"  style="clear:both;"></div>
<script>
	function change_paystat(str,sid,kind){
		$.ajax({
			type:"POST",
			url:"/registration/stat_change.php",
			data:"str="+str+"&sid="+sid+"&kind="+kind,
			success:function(msg){
			}
		});
	}
</script>
<table class="tblDef">
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>회원구분</th>
			<th>전문의구분</th>
			<th>근무부서</th>
			<th>성명</th>
			<th>면허번호 </th>
			
		</tr>
	</thead>
	<tbody>
		<?
			$n=1;
		
			while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				
				

		?>
		<tr >
			<td><?=$virtualRecordNo?></td>
			<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
			<td><?=$_REG['gubun1'][$d['gubun1']]?></td>
			<td><?=$_REG['gubun2'][$d['gubun2']]?></td>
			<td><a href="javascript:popup_call('registration/postform','sid=<?=$d['usid']?>')"><?=$d['name_kr']?></a><?if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){?> / <?=$d['usid']?><?}?></td>
			
			<td><?=$d['license_number']?></td>
			
		</tr>
		<?$n++;?>
		<?$virtualRecordNo--;}?>

		<!-- <?=$n?> -->
	</tbody>
</table>
<?
	if($add_search2) $search_url .= $add_search2;
	if($sort_field) $search_url .= "&sort_field=".$sort_field;
	if($orderby) $search_url .= "&orderby=".$orderby;
?>
<div class="btnArea posRel tp0">
	<?include $_SERVER['DOCUMENT_ROOT']."/include.page.php"?>						
</div>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>
 