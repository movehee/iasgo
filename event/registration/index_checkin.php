<?include $_SERVER['DOCUMENT_ROOT']."/include.header.php"?>
<?
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	

	$time_max_count=3; //총 세션의 갯수 정의
	
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = "   order by day desc, first_date asc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;

	$ev_date = isset($ev_date) ? (int)$ev_date : 1;
	if ($ev_date < 1 || !isset($_TIME['session'][$ev_date])) {
		$ev_date = 1;
	}
	$time_max_count = count($_TIME['session'][$ev_date]);

	$not_search_Arr = array();
	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code','ev_date');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	

	if(!$result_code) $result_code='1';

	$search_query = array();
	$day_query = array();
	$search_url = '';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='key'){
					$search_query[] = " usid = '".(int)$tval."' ";
				}else if($tkey=='program_day1'){
					$day_query[] = " day ='1'";
				}else if($tkey=='program_day2'){
					$day_query[] = " day ='2'";
				}else if($tkey=='program_day3'){
					$day_query[] = " day ='3'";
				}else if($tkey=='program_day4'){
					$day_query[] = " day ='4'";
				}else if (preg_match('/^s([0-9]+)_(sdate|edate)$/', $tkey, $sm) && (int)$sm[1] >= 1 && (int)$sm[1] <= $time_max_count) {
					if($tval=='Y'){
						$search_query[] = " ".$tkey.">0 ";
					}else if($tval=='N'){
						$search_query[] = " (".$tkey."='' or ".$tkey." is null) ";
					}
				}else if (preg_match('/^s([0-9]+)_(stime|etime)$/', $tkey, $sm) && (int)$sm[1] >= 1 && (int)$sm[1] <= $time_max_count) {
					if (!preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/', $tval)) {
						continue;
					}
					$sessionNo = (int)$sm[1];
					if ($sm[2] == 'stime') {
						$search_query[] = " s".$sessionNo."_sdate>=unix_timestamp(concat(substr(from_unixtime(s".$sessionNo."_sdate),1,10),' ".$tval."'))";
					} else {
						$search_query[] = " s".$sessionNo."_edate<=unix_timestamp(concat(substr(from_unixtime(s".$sessionNo."_edate),1,10),' ".$tval."'))";
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
	$search_url .= "&ev_date=".$ev_date;
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and day='$ev_date'";//and t2.member_level!='M'
	}else{
		$fsql = " where del='N' and day='$ev_date' ";//and t2.member_level!='M'
	}
	

	
	
	//$query = "select count(*) from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid " . $fsql;
	$session_field = array();
	for($s=1;$s<=$time_max_count;$s++){
		$session_field[] = "s".$s."_sdate, s".$s."_edate";
	}
	$scoreMaxHour = isset($_TIME['score_max_hour']) ? (int)$_TIME['score_max_hour'] : 6;
	$add_field = ",usid,day,del,first_date,last_date,group_key,name_kr,name_eng,license_number,id,aff_kor,aff_eng,email,classification,title,country,modify,member_level,chking,".getSessionStayTimeSql($ev_date);
	
	$query = "select count(usid) from (";
	$query .= "select ".implode(",",$session_field). $add_field." from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid";
	$query .= ") A" . $fsql;
	
	//$query .= " and t2.member_level!='M'";
	//$query .= " and t1.usid not in ($pass_sid_arr)";
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220' || $_SERVER['REMOTE_ADDR']=='218.235.94.2221' || $_SERVER['REMOTE_ADDR']=='218.235.94.20522'){
		//$query .= " and (t2.room='' or t2.room is null)";
		//$query .= " and chking!='Y' and day='1'";
		//$query .= " and member_level!='M' and classification not in ('M','X','Z')"; //and reg_kind in ('K','L','M','R','U')
	}
	if($_SERVER['REMOTE_ADDR']=='218.235.94.2204'){
		//$query .= " and first_date>unix_timestamp('2021-04-11 10:40:00')";
	}
	//master_echo($query);
	
	$totalRecord=$conn->getOne($query);

	$num_per_page = 50;
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();
	
	//$query = "select t1.*,t2.license_number,t2.name_kr,t2.sid as usid,t2.classification,t2.logout_day1,t2.logout_day2,t2.logout_day3,t2.logout_day4,t2.reg_kind,t2.gubun1,t2.gubun2 from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid " . $fsql;

	$query = "select ".implode(",",$session_field). $add_field.",sid from (";
	$query .= "select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid";
	$query .= ") A" . $fsql;

	//$query .= " and t1.day='2' and t1.score='4'";
	//$query .= " and t1.usid not in ($pass_sid_arr)";
	if($_SERVER['REMOTE_ADDR']=='218.235.94.2204'  || $_SERVER['REMOTE_ADDR']=='218.235.94.2221' || $_SERVER['REMOTE_ADDR']=='218.235.94.20522' ){
		//$query .= " and t1.usid in ($pass_sid_arr)";
		$query .= " and chking!='Y' and day='1'";
		//$query .= " and score='6'  and t1.day='1'";
		$query .= " and member_level!='M' and classification not in ('M','X','Z')"; //and reg_kind in ('K','L','M','R','U')
	}

	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		//$query .= " and first_date>unix_timestamp('2021-04-11 10:40:00')";
	}
	//$query .= " and t2.member_level!='M'";
	
	$query .= $sort_sql; //and t2.day='2' and t1.score='6' //id asc, t1.day asc, 
	
		
	if($_SERVER['REMOTE_ADDR']!='218.235.94.2204'){
		$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
	}
	
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
<div class="btn bp10" style="float:left;">
	<?for($date=1;$date<=$date_count;$date++){?>	
	<a href="<?=$PHP_SELF?>?ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
	<?}?>
</div>
<div class="searchArea" style="clear:both;">
	
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
	<input type="hidden" name="ev_date" value="<?=$ev_date?>">
		<fieldset>
			<legend>상세 검색</legend>
			<table class="tblDef inputTbl">
				<colgroup>
					<col style="width: 3%;">
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
						<th>성명(영문)</th>
						<td class="al"><input type="text" name="name_eng" id="name_eng" value="<?=$name_eng?>" style="width:95%;"></td>
						<th>면허번호</th>
						<td class="al"><input type="text" name="license_number" id="license_number" value="<?=$license_number?>" style="width:95%;"></td>
						<th>소속</th>
						<td class="al"><input type="text" name="aff_kor" id="aff_kor" value="<?=$aff_kor?>" style="width:95%;"></td>
					</tr>
					<tr>
						<th>등록구분</th>
						<td class="al">
							<select name="classification" style="height:30px;width:95%;">
								<option value="">선택</option>
								<?php foreach ($_REG['class_kind'] as $tkey => $tval): ?>
									<option value="<?=$tkey?>" <?=$classification==$tkey?'selected':''?>><?=$tval?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<th>카테고리</th>
						<td class="al">
							<select name="title" style="height:30px;width:95%;">
								<option value="">선택</option>
								<?php if (!empty($_ONSITE['fee_kor'])): ?>
									<optgroup label="국내">
										<?php foreach ($_ONSITE['fee_kor'] as $tkey => $tval): ?>
											<option value="<?=$tkey?>" <?=$title==$tkey?'selected':''?>><?=$tval['title']?></option>
										<?php endforeach; ?>
									</optgroup>
								<?php endif; ?>
								<?php if (!empty($_ONSITE['fee_eng'])): ?>
									<optgroup label="국외">
										<?php foreach ($_ONSITE['fee_eng'] as $tkey => $tval): ?>
											<option value="<?=$tkey?>" <?=$title==$tkey?'selected':''?>><?=$tval['title']?></option>
										<?php endforeach; ?>
									</optgroup>
								<?php endif; ?>
							</select>
						</td>
						<th>sid</th>
						<td class="al"><input type="text" name="key" id="key" value="<?=$key?>" style="width:100px;"></td>
						<td colspan="4"></td>
					</tr>
					
					<tr>
						<th>세션</th>
						<td class="al multi" colspan="9" style="padding:0px;margin:0px;border-bottom:0px;">
							<table cellpadding=0 cellspacing=0 style="padding:0px;margin:0px;width:100%;">
								<tr>
									<?for($i=1;$i<=$time_max_count;$i++){?>
									<th style="background:#F8F8F8;border-right:1px solid #DCDCDC;text-align:center;height:23px;width:50px;">Session<?=$i?></th>
									<td style="border-right:1px solid #DCDCDC;text-align:center;height:23px;width:100px;text-align:left;padding-left:5px;padding:10px;">
										<div class="bp5">
										입장 : 
										<input type="radio" name="s<?=$i?>_sdate" value="Y" id="S<?=$i?>Y" <?if(${'s'.$i.'_sdate'}=='Y'){?>checked<?}?>> <label for="S<?=$i?>Y" style="cursor:pointer;">있음</label> 
										<input type="radio" name="s<?=$i?>_sdate" value="N" id="S<?=$i?>N" <?if(${'s'.$i.'_sdate'}=='N'){?>checked<?}?>> <label for="S<?=$i?>N" style="cursor:pointer;">없음</label>
										</div>
										<div class="tp5">
										퇴장 : 
										<input type="radio" name="s<?=$i?>_edate" value="Y" id="E<?=$i?>Y" <?if(${'s'.$i.'_edate'}=='Y'){?>checked<?}?>> <label for="E<?=$i?>Y" style="cursor:pointer;">있음</label> 
										<input type="radio" name="s<?=$i?>_edate" value="N" id="E<?=$i?>N" <?if(${'s'.$i.'_edate'}=='N'){?>checked<?}?>> <label for="E<?=$i?>N" style="cursor:pointer;">없음</label> 
										</div>
									</td>
									<?}?>
								</tr>
								<tr>
									<?for($i=1;$i<=$time_max_count;$i++){?>
									<th style="background:#F8F8F8;border-right:1px solid #DCDCDC;border-top:1px solid #DCDCDC;text-align:center;height:23px;width:50px;">시간</th>
									<td style="border-right:1px solid #DCDCDC;border-top:1px solid #DCDCDC;padding:5px;">
										<input type="text" style="width:60px;" class="timepicker" name="s<?=$i?>_stime" id="s<?=$i?>_stime" value="<?=${'s'.$i.'_stime'}?>" -readonly> ~ 
										<input type="text" style="width:60px;" class="timepicker" name="s<?=$i?>_etime" id="s<?=$i?>_etime" value="<?=${'s'.$i.'_etime'}?>" -readonly>
									</td>
									<?}?>
								</tr>
							</table>
						</td>
					</tr>
					
					
				</tbody>
			</table>
			<div class="btn btnArea">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="검색초기화" class="btnGrey" onclick="location.href='<?=$PHP_SELF?>?ev_date=<?=$ev_date?>'">
				<input type="button" value="Excel Backup" onclick="location.href='excel_backup.php?<?=htmlspecialchars(ltrim($search_url, '&'), ENT_QUOTES, 'UTF-8')?>'" class="btnMint initialism fade_open btn btn-success ex_btn">
			</div>
		</fieldset>
	</form>
</div>
<br />
<div>
	<div class="btn bp5" style="float:right;">
		<a href="javascript:popup_call('registration/search')" class="btnYellow "><i class="fas fa-search"></i>회원검색</a>
		<a href="javascript:time_theorem()" class="btnGrey withIcon"><i class="far fa-clock"></i>로그 정리하기</a>
		<?if(stristr($_SERVER['REMOTE_ADDR'],'218.235.94')==true){?><?}?>
		<a href="/time/?ev_date=<?=$ev_date?>" class="btnRed withIcon"><i class="far fa-clock"></i>시간 조정하기</a>
		
	</div>
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
		<col style="width: 4%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 6%;">
		<col style="width: 5%;">
		<col style="width: 6%;">
		<col style="width: 5%;">
		<?for($i=1;$i<=$time_max_count;$i++){?>
		<col style="width: 5%;">
		<col style="width: 5%;">
		<?}?>
		<col style="width: 4.5%;">
		<col style="width: 4.5%;">
		<col style="width: 3%;">
		<col style="width: 3%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>행사일</th>
			<th>등록구분</th>
			<th>ID</th>
			<th>성명</th>
			<th>성명(영문)</th>
			<th>면허번호</th>
			<th>카테고리</th>
			<th><?=admin_orderby("강의실 입장","first_date",$sort_field,$orderby,$search_url)?></th>
			<?for($i=1;$i<=$time_max_count;$i++){?>
			<th><?=admin_orderby("S".$i."<br>입장","s".$i."_sdate",$sort_field,$orderby,$search_url)?></th>
			<th><?=admin_orderby("S".$i."<br>퇴장","s".$i."_edate",$sort_field,$orderby,$search_url)?></th>
			<?}?>
			<th>최종퇴장</th>
			<th>체류시간</th>
			<th>평점</th>
			<th>조정</th>
		</tr>
	</thead>
	<tbody>
		<?
			$n=1;
		
			while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$stayInfo = getSessionStayScore(isset($d['total_time']) ? $d['total_time'] : 0, $scoreMaxHour);
				$stay_hours = $stayInfo['stay_hours'];
				$stay_min = $stayInfo['stay_min'];
				$score = $stayInfo['score'];

		?>
		<?
				$feeLabel = $d['title'];
				$isDomestic = ($d['country'] == 'K');
				$isOverseas = ($d['country'] == 'F');
				if ($isDomestic && isset($_ONSITE['fee_kor'][$d['title']]['title'])) {
					$feeLabel = $_ONSITE['fee_kor'][$d['title']]['title'];
				} else if ($isOverseas && isset($_ONSITE['fee_eng'][$d['title']]['title'])) {
					$feeLabel = $_ONSITE['fee_eng'][$d['title']]['title'];
				} else if (isset($_ONSITE['fee_kor'][$d['title']]['title'])) {
					$feeLabel = $_ONSITE['fee_kor'][$d['title']]['title'];
				} else if (isset($_ONSITE['fee_eng'][$d['title']]['title'])) {
					$feeLabel = $_ONSITE['fee_eng'][$d['title']]['title'];
				}
				$classLabel = isset($_REG['class_kind'][$d['classification']]) ? $_REG['class_kind'][$d['classification']] : '';
		?>
		<tr <?if($d['modify']=='Y'){?>style="background:#EDEDED"<?}?>>
			<td><?=$virtualRecordNo?><?if($_SERVER['REMOTE_ADDR']=='218.235.94.2220'){?> / <?=$n?><?}?></td>
			<td><?=date("m.d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['day']-1), $ex_sdate[0]));?></td>
			<td><?=$classLabel?></td>
			<td><?=$d['id']?></td>
			<td><a href="javascript:popup_call('registration/postform','sid=<?=$d['usid']?>')"><?=$d['name_kr']?></a><?if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){?> / <?=$d['usid']?><?}?></td>
			<td><?=$d['name_eng']?></td>
			<td><?=$d['license_number']?></td>
			<td><?=$feeLabel?></td>
			<td style="background:#FCEBF1;"><?if($d['first_date']>0){?><?=date("H:i",$d['first_date'])?><?}?></td>
			
			<?for($i=1;$i<=$time_max_count;$i++){?>
			<td <?if($i%2==0){?>style="background:#FEFFE1;"<?}else{?>style="background:#ECF8F9;"<?}?>>
				<?if($d['s'.$i.'_sdate']>0){?>
					<a href="javascript:popup_call('registration/session_time','sid=<?=$d['sid']?>&day=<?=$d['day']?>&group_key=<?=$d['group_key']?>')"><?=date("H:i",$d['s'.$i.'_sdate'])?></a>
				<?}?>
			</td>
			<td <?if($i%2==0){?>style="background:#FEFFE1;"<?}else{?>style="background:#ECF8F9;"<?}?>>
				<?if($d['s'.$i.'_edate']>0){?>
					<a href="javascript:popup_call('registration/session_time','sid=<?=$d['sid']?>&day=<?=$d['day']?>&group_key=<?=$d['group_key']?>')"><?=date("H:i",$d['s'.$i.'_edate'])?></a>
				<?}?>
			</td>
			<?}?>

			<td style="background:#FCEBF1;">
			<?
				if($d['last_date']) echo date('H:i',$d['last_date']);
			?>
			</td>
			<td><?=$stay_hours !== '' ? $stay_hours.':'.$stay_min : ''?></td>
			<td><?=(int)$score?></td>
			<td><i class="far fa-clock" style="cursor:pointer;font-size:18px;" onclick="popup_call('registration/session_time','sid=<?=$d['sid']?>&day=<?=$d['day']?>&group_key=<?=$d['group_key']?>')"></i></td>
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
 