<?include $_SERVER['DOCUMENT_ROOT']."/include.header.php"?>
<?
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	
	

	$scoreMaxHour = isset($_TIME['score_max_hour']) ? (int)$_TIME['score_max_hour'] : 6;

	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}

	
	$num_per_page = 50;
	$ev_date = isset($ev_date) ? (int)$ev_date : 1;
	if ($ev_date < 1) $ev_date = 1;
	if (!isset($_TIME['session'][$ev_date])) $ev_date = 1;
	$time_max_count=count($_TIME['session'][$ev_date]); //해당일자의 세션 갯수
	
	$chking_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($ev_date-1), $ex_sdate[0]));

	$skind = '';
	$skey = 0;
	if($search_kind){
		if (preg_match('/^([SO])([0-9]+)_time2?$/', $search_kind, $kindMatch)) {
			$skind = $kindMatch[1];
			$skey = (int)$kindMatch[2];
			if ($skey < 1 || $skey > $time_max_count) {
				$search_kind = '';
				$skind = '';
				$skey = 0;
			}
		} else {
			$search_kind = '';
		}
	}

	$sort_sql = "";
	$allowedSort = array('first_date', 'last_time', 'total_time');
	for($s=1;$s<=$time_max_count;$s++){
		$allowedSort[] = "s".$s."_sdate";
		$allowedSort[] = "s".$s."_edate";
		if($search_kind=='S'.$s.'_time' || $search_kind=='S'.$s.'_time2'){
			$sort_sql = " order by s".$s."_sdate asc";
		}
		if($search_kind=='O'.$s.'_time'){
			$sort_sql = " order by s".$s."_edate asc";
		}
	}
	if($sort_field && in_array($sort_field, $allowedSort)) {
		$sort_sql = " order by ".$sort_field;
		if ($orderby == 'desc') {
			$sort_sql .= " desc";
		} else {
			$sort_sql .= " asc";
		}
	}
	
	$time_null = "";
	if($exist_yn=='Y' && $skey > 0){
		if($skind=='S'){
			$time_null = " and s".$skey."_sdate is not null and s".$skey."_sdate!=''";
		}else if($skind=='O'){
			$time_null = " and s".$skey."_edate is not null and s".$skey."_edate!=''";
		}
	}
	if($exist_yn2=='Y' && $skey > 0){
		if($skind=='S'){
			$time_null = " and (s".$skey."_sdate is null or s".$skey."_sdate='')";
		}else if($skind=='O'){
			$time_null = " and (s".$skey."_edate is null or s".$skey."_edate='')";
		}
	}
	$next_sql = "";
	if($next_session=='Y' && $skey > 0 && $skey < $time_max_count){
		$next_sql = " and s".($skey+1)."_sdate>0";
	}
	$pre_sql = "";
	if($pre_session=='Y' && $skey > 1){
		$pre_sql = " and s".($skey-1)."_sdate>0";
	}
	
	$time_detail_query = "";
	$time_detail = isset($time_detail) ? (int)$time_detail : 0;
	if($time_detail > 0 && $skey > 0 && isset($_TIME['session'][$ev_date][$skey])){
		if($skind=='S'){
			$time_detail_query = " and s".$skey."_sdate>='".strtotime($_TIME['session'][$ev_date][$skey][0])."' and s".$skey."_sdate<='".strtotime($_TIME['session'][$ev_date][$skey][0]."+ ".$time_detail." minutes")."'"; 
		}else if($skind=='O'){
			$time_detail_query = " and s".$skey."_edate<'".strtotime($_TIME['session'][$ev_date][$skey][1])."' and s".$skey."_edate>='".strtotime($_TIME['session'][$ev_date][$skey][1]."- ".$time_detail." minutes")."'"; 
		}
	}
	$max_sql = "";
	if($max_time){
		$max_sql = " and (floor(max_time/60)>floor(total_time/60) and floor(total_time/60)<".$scoreMaxHour.")";
	}
	
	
	


	$excep_score_sql = "";
	for ($j = $scoreMaxHour; $j >= 0; $j--) {
		if (${'excep_score'.$j} != 'Y') {
			continue;
		}
		if ($j == $scoreMaxHour) {
			$excep_score_sql .= " and total_time<".($j * 60);
		} else if ($j == 0) {
			$excep_score_sql .= " and total_time>59";
		} else {
			$excep_score_sql .= " and total_time not between ".($j * 60)." and ".(($j * 60) + 59);
		}
	}
	
	//and total_time not between 180 and 239
	
	for($s=1;$s<=$time_max_count;$s++){
		$_CONFIG['chking_session'.$s][] = array("key"=>"S".$s."_time","title"=>"[세션".$s."] 입장시간이 없거나, 부족한 경우");
		$_CONFIG['chking_session'.$s][] = array("key"=>"O".$s."_time","title"=>"[세션".$s."] 퇴장시간이 없거나, 부족한 경우");
	}
	if($search_kind){
		for($s=1;$s<=$time_max_count;$s++){
			if($search_kind=='S'.$s.'_time'){
				$fsql = " where (s".$s."_sdate is null or s".$s."_sdate='' or s".$s."_sdate>'".strtotime($_TIME['session'][$ev_date][$s][0].':59')."')";
				$fsql .= " and day='$ev_date' and first_date<'".strtotime($_TIME['session'][$ev_date][$s][1])."' and (substr(from_unixtime(first_date),1,16)!=substr(from_unixtime(s".$s."_sdate),1,16) or s".$s."_sdate is null)";
			}
			if($search_kind=='O'.$s.'_time'){
				$fsql = " where s".$s."_sdate>0 and (s".$s."_edate<'".strtotime($_TIME['session'][$ev_date][$s][1])."' or s".$s."_edate is null or s".$s."_edate='')";
				$fsql .= " and day='$ev_date' and first_date<'".strtotime($_TIME['session'][$ev_date][$s][1])."'"; 
			}
		}
	}else{
		$fsql = " where day='$ev_date' ";
	}
	$fsql .= " and (onsite".$ev_date." is null or onsite".$ev_date."='') ";

	if($id) $fsql .= " and id like '%$id%'";
	if($name_kr) $fsql .= " and name_kr like '%$name_kr%'";
	if($name_eng) $fsql .= " and name_eng like '%$name_eng%'";
	if($license_number) $fsql .= " and license_number like '%$license_number%'";
	if($aff_kor) $fsql .= " and (aff_kor like '%$aff_kor%' or aff_eng like '%$aff_kor%')";
	if($classification) $fsql .= " and classification = '$classification'";
	if($title) $fsql .= " and title = '$title'";

	if($stay_stime){
		$ex_stay_stime = explode(":",$stay_stime);
		$uptime =  ($ex_stay_stime[0]*60)+$ex_stay_stime[1];
		$fsql .= " and total_time>='$uptime'";
	}
	if($stay_etime){
		$ex_stay_etime = explode(":",$stay_etime);
		$downtime =  ($ex_stay_etime[0]*60)+$ex_stay_etime[1];
		$fsql .= " and total_time<'$downtime'";
	}

	if($final_time){
		$ftime = $chking_date." ".$final_time;
		$fsql .= " and last_date>unix_timestamp('$ftime')";
	}
	

	$fsql .= $time_null;
	$fsql .= $excep_score_sql;
	$fsql .= $time_detail_query;
	$fsql .= $next_sql;
	$fsql .= $pre_sql;
	
	//$fsql .= " and classification not in ('M','Y')";
	
	$session_field = array();
	for($s=1;$s<=$time_max_count;$s++){
		$session_field[] = "s".$s."_sdate, s".$s."_edate";
	}
	$times_field = getSessionStayTimeSql($ev_date);
	

	$time_sql2 = array();
	for($s=1;$s<=$time_max_count;$s++){
		$session_times2 = "ifnull(TIMESTAMPDIFF(MINUTE ";	
		$session_times2 .= ", if(unix_timestamp('".$_TIME['session'][$ev_date][$s][0]."')>first_date";
		$session_times2 .= ", '".$_TIME['session'][$ev_date][$s][0]."', if(unix_timestamp('".$_TIME['session'][$ev_date][$s][1]."')>first_date";
		//$session_times2 .= ", from_unixtime(first_date),null))";

		$session_times2 .= ", concat('$chking_date',' ',substr(from_unixtime(first_date),11,6)),null))";

		$session_times2 .= ", if(unix_timestamp('".$_TIME['session'][$ev_date][$s][1]."')>first_date"; //세션 종료가 입장시간보다 크면
		$session_times2 .= ", '".$_TIME['session'][$ev_date][$s][1]."',null)";
		$session_times2 .= "),0)";
		$time_sql2[] = $session_times2;

	}
	$times_field2 = ", (".implode("+",$time_sql2).") as max_time";

	for($date=1;$date<=$date_count;$date++){
		$session_field[] = "logout_day".$date;
	}


	
	//print_r($session_field);
	$add_field = ",usid,day,del,first_date,last_date,group_key,name_kr,name_eng,license_number,id,aff_kor,aff_eng,email,classification,title,modify,member_level,country,chking,onsite1,onsite2,onsite3,onsite4,onsite5,".$times_field .$times_field2;
	$add_field .= ", if(ifnull(last_date,0)>ifnull(logout_day".$ev_date.",0),last_date,logout_day".$ev_date.") as last_time";

	
	$query = "select ".implode(",",$session_field). $add_field.",sid,floor(total_time/60) as ing_hour,floor(max_time/60) as max_hour from (";
	$query .= "select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid AND t2.del='N'";
	$query .= ") A ";
	$editSidSafe = array();
	if ($edit_complete=='Y' && isset($edit_sid) && is_array($edit_sid)) {
		foreach ($edit_sid as $oneSid) {
			$oneSid = (int)$oneSid;
			if ($oneSid > 0) {
				$editSidSafe[] = $oneSid;
			}
		}
	}
	if($edit_complete=='Y'){
		if (count($editSidSafe) < 1) {
			$query .= " where 1=0 ";
		} else {
			$query .= " where day='".(int)$ev_date."' and usid in (".implode(",", $editSidSafe).") ";
		}
	}else{
		$query .= $fsql;
	}

	// 평점 대상 기본 필터. include_staff=Y 이면 관계자/마스터도 표시(테스트용)
	$includeStaff = (isset($_REQUEST['include_staff']) && $_REQUEST['include_staff'] == 'Y');
	if (!$includeStaff) {
		$query .= " and IFNULL(member_level,'')!='M' and IFNULL(country,'')!='F' and IFNULL(classification,'') not in ('M','X','Z','Y','C')";
	}
	if ($max_sql) {
		$query .= $max_sql;
	}
	//$query .= " and country!='F'";
	
	$count_query = "select count(*) from (".$query.") as Tb";
	
	$totalRecord=$conn->getOne($count_query);
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();
	
	$query .= $sort_sql;
	if(!$search_kind){
		$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
	}
	
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());


	$virtualRecordNo=$pageNav->getVirtualRecordNoInPage($totalRecord);
	$blockNav = new Block("", $totalPage, $page_per_block);
	$totalBlock = $blockNav->getTotalBlock();
	$blockNav->setBlock($page);
	$block = $blockNav->getBlock();
	$firstPageInBlock = $blockNav->getFirstPageInBlock();
	$lastPageInBlock = $blockNav->getLastPageInBlock();
	if($block >= $totalBlock) $lastPageInBlock = $totalPage;

	

	$search_url = "&search_kind=".urlencode($search_kind)."&ev_date=".(int)$ev_date;
	for($j=0;$j<=$scoreMaxHour;$j++){
		if(${'excep_score'.$j}) $search_url.= "&excep_score".$j."=".${'excep_score'.$j};
	}
	if($pre_session) $search_url.= "&pre_session=".$pre_session;
	if($next_session) $search_url.= "&next_session=".$next_session;
	if($stay_stime) $search_url.= "&stay_stime=".$stay_stime;
	if($stay_etime) $search_url.= "&stay_etime=".$stay_etime;
	if($exist_yn) $search_url.= "&exist_yn=".$exist_yn;
	if($exist_yn2) $search_url.= "&exist_yn2=".$exist_yn2;
	if($final_time) $search_url.= "&final_time=".$final_time;
	
	if($time_detail) $search_url.= "&time_detail=".$time_detail;
	if($log_yn) $search_url.= "&log_yn=".$log_yn;
	if($max_time) $search_url.= "&max_time=".$max_time;
	if($id) $search_url.= "&id=".urlencode($id);
	if($name_kr) $search_url.= "&name_kr=".urlencode($name_kr);
	if($name_eng) $search_url.= "&name_eng=".urlencode($name_eng);
	if($license_number) $search_url.= "&license_number=".urlencode($license_number);
	if($aff_kor) $search_url.= "&aff_kor=".urlencode($aff_kor);
	if($classification) $search_url.= "&classification=".urlencode($classification);
	if($title) $search_url.= "&title=".urlencode($title);
	if($includeStaff) $search_url.= "&include_staff=Y";
?>
<style>
	.main{padding:0;margin:0;}
	.pk-field{width:30%;}
	.FCEBF1{background:#FCEBF1;}
</style>
<link rel="stylesheet" href="/script/pickout/dev/pickout.css">
<link rel="stylesheet" href="/script/pickout/dev/themes/pk-cricket.css">
<style>
.pk-modal{padding:0; margin:0;width:30%;}
.pk-option-group{color:#ffffff!important;font-size:16px;background:#9398A6;}
.pk-form{width:500px;}
.pk-search{display:none !important;}
</style>
<script>
	var search_url = <?=json_encode($search_url)?>;
	function rechk_confirm(str){
		$('#update_kind').val(str)
		if($('.chksid').is(':checked')==false){
			alert("선택하신 데이터가 없습니다.");
			return false;
		}
		$('#time_rechkF').submit();
	}
</script>
<div >
	<div class="btn" style="float:left;">
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>

	<div style="float:right;">
		<div class="pk-form">
			<select name="session_chking" id="session_chking" class="session_chking pickout" placeholder="일괄적으로 입출기록의 수정을 원하시면 세션을 선택해주세요" >
				<option value="">일괄적으로 입출기록의 수정을 원하시면 세션을 선택해주세요</option>
				<?for($s=1;$s<=$time_max_count;$s++){?>			
				<optgroup label="SESSION&nbsp;<?=$s?>">
					<!-- <?if($s=='1'){?>
					<option value="fir|<?=$ev_date?>" <?if($search_kind=='fir'){?>selected<?}?>>
						최초입장이 세션1종료 이전에 들어온 사람들 중 , 세션1시작 시간보다 입장을 늦게 찍은 사람과 세션1 입장이 없는 경우
					</option>
					<?}?> -->
					<?foreach($_CONFIG['chking_session'.$s] as $tkey=>$tval){?>
					<option value="<?=$tval['key']?>|<?=$ev_date?>" <?if($tval['key']==$search_kind){?>selected<?}?>>
						<?=$tval['title']?>
					</option>	
					<?}?>
				</optgroup>
				<?}?>
			</select>
		</div>
	</div>
</div>

<div class="bp10"  style="clear:both;"></div>
<div class="searchArea">
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
	<input type="hidden" name="search_kind" value="<?=htmlspecialchars($search_kind, ENT_QUOTES, 'UTF-8')?>">
	<input type="hidden" name="ev_date" value="<?=(int)$ev_date?>">
	
		<fieldset>
			<legend>상세 검색</legend>
			<table class="tblDef inputTbl" >
				<colgroup>
					<col style="width: 8%;">
					<col style="width: 12%;">
					<col style="width: 8%;">
					<col style="width: 12%;">
					<col style="width: 8%;">
					<col style="width: 12%;">
					<col style="width: 8%;">
					<col style="width: 12%;">
					<col style="width: 8%;">
					<col style="width: 12%;">
				</colgroup>
				<tbody >
					<tr>	
						<th style="font-size:15px;">ID</th>
						<td class="al"><input type="text" style="width:90%;" name="id" value="<?=htmlspecialchars($id, ENT_QUOTES, 'UTF-8')?>"></td>
						<th style="font-size:15px;">성명</th>
						<td class="al"><input type="text" style="width:90%;" name="name_kr" value="<?=htmlspecialchars($name_kr, ENT_QUOTES, 'UTF-8')?>"></td>
						<th style="font-size:15px;">성명(영문)</th>
						<td class="al"><input type="text" style="width:90%;" name="name_eng" value="<?=htmlspecialchars($name_eng, ENT_QUOTES, 'UTF-8')?>"></td>
						<th style="font-size:15px;">면허번호</th>
						<td class="al"><input type="text" style="width:90%;" name="license_number" value="<?=htmlspecialchars($license_number, ENT_QUOTES, 'UTF-8')?>"></td>
						<th style="font-size:15px;">소속</th>
						<td class="al"><input type="text" style="width:90%;" name="aff_kor" value="<?=htmlspecialchars($aff_kor, ENT_QUOTES, 'UTF-8')?>"></td>
					</tr>
					<tr>
						<th style="font-size:15px;">등록구분</th>
						<td class="al">
							<select name="classification" style="height:30px;width:95%;">
								<option value="">선택</option>
								<?php foreach ($_REG['class_kind'] as $tkey => $tval): ?>
									<option value="<?=$tkey?>" <?=$classification==$tkey?'selected':''?>><?=$tval?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<th style="font-size:15px;">카테고리</th>
						<td class="al" colspan="3">
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
						<th style="font-size:15px;">체류 시간</th>
						<td class="al" colspan="3" style="font-size:15px;">
							<input type="text" class="timepicker" style="width:70px;" name="stay_stime" value="<?=$stay_stime?>" readonly> 이상 
							<input type="text" class="timepicker" style="width:70px;" name="stay_etime" value="<?=$stay_etime?>" readonly> 미만
						</td>
					</tr>
					<tr>	
						<th style="font-size:15px;">평점</th>
						<td class="al" colspan="9">
							<?for($j=$scoreMaxHour;$j>=0;$j--){?>
							<input type="checkbox" class="excep_score<?=$j?>" id="excep_score<?=$j?>" name="excep_score<?=$j?>" <?if(${'excep_score'.$j}=='Y'){?>checked<?}?> style="width:17px;height:20px;" value="Y"> <label for="excep_score<?=$j?>" style="font-size:18px;"><?=$j?>점 제외</label>
							<?}?>
						</td>
					</tr>
					
					<?if($search_kind){?>
					<tr>
						<th style="font-size:15px;">이전세션 있음</th>
						<td class="ac"><input type="checkbox" class="pre_session" name="pre_session" value="Y" <?if($pre_session=='Y'){?>checked<?}?> style="width:20px;height:20px;" ></td>
						<th style="font-size:15px;">다음세션 있음</th>
						<td class="ac"><input type="checkbox" class="next_session" name="next_session" value="Y" <?if($next_session=='Y'){?>checked<?}?> style="width:20px;height:20px;"></td>
						<th style="font-size:15px;">세션 시간</th>
						<td class="al" colspan="5" style="font-size:15px;">
							<?if($skind=='S'){?>
								세션 <?=$skey?> 입장을  <?=substr($_TIME['session'][$ev_date][$skey][0],10,6)?> 이후로 한 데이터 중 
								입장을 <input type="text"  style="width:70px;" name="time_detail" value="<?=htmlspecialchars($time_detail, ENT_QUOTES, 'UTF-8')?>"> 분 이내로 한 기록만 보기 
							<?}else{?>
								세션 <?=$skey?> 퇴장을 <?=substr($_TIME['session'][$ev_date][$skey][1],10,6)?> 보다 
								<input type="text" style="width:70px;" name="time_detail" value="<?=htmlspecialchars($time_detail, ENT_QUOTES, 'UTF-8')?>"> 분 빠르게 퇴장한 기록만 보기 
							<?}?>
						</td>
					</tr>
					<tr>
						<th style="font-size:15px;">데이터 유무</th>
						<td class="al" colspan="7">
							<input type="checkbox" id="exist_yn" name="exist_yn" value="Y" <?if($exist_yn=='Y'){?>checked<?}?> style="width:20px;height:20px;" > <label for="exist_yn" style="font-size:15px;">출결기록이 있는 데이터만 확인</label>
							
							<input type="checkbox" id="exist_yn2" name="exist_yn2" value="Y" <?if($exist_yn2=='Y'){?>checked<?}?> style="width:20px;height:20px;" > <label for="exist_yn2" style="font-size:15px;">출결기록이 없는 데이터만 확인</label>

							<input type="checkbox" id="log_yn" name="log_yn" value="Y" <?if($log_yn=='Y'){?>checked<?}?> style="width:20px;height:20px;" > <label for="log_yn" style="font-size:15px;">로그있는것만 확인</label>
						</td>
						<th style="font-size:15px;">최종퇴장시간</th>
						<td class="al"><input type="text" class="timepicker" style="width:70px;" name="final_time" value="<?=$final_time?>" readonly> 이후 </td>
					</tr>
					<?}?>
					<tr>	
						<th style="font-size:15px;">이수시간</th>
						<td class="al" colspan="9" style="font-size:15px;">
							<input type="checkbox" name="max_time" id="max_time" style="width:20px;height:20px;" value="Y" <?if($max_time=='Y'){?>checked<?}?>> 
							<label for="max_time">입장시간을 기준으로 이미 받을수있는 최대평점을 받은 기록은 제외합니다.</label>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="btn btnArea tp10">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="초기화" class="btnGrey" onclick="location.href='<?=htmlspecialchars($PHP_SELF, ENT_QUOTES, 'UTF-8')?>?search_kind=<?=htmlspecialchars($search_kind, ENT_QUOTES, 'UTF-8')?>&ev_date=<?=(int)$ev_date?>'" >
			</div>
		</fieldset>
	</form>
</div>

<div style="float:left;">
	<div class="fcRed bp5 tp0" style="font-weight:bold;">※ 체크하지 않은 데이터는 업데이트 되지 않습니다. <span style="color:blue;">(<span id="Tnum"><?=$totalRecord?></span>건의 데이터를 변경 할 수 있습니다.)</span></div>
</div>
<div style="float:right;">
	<div class="bp5 tp0" style="">※ 입/퇴장 시간영역안의 <span class="fcRed">붉은색 시간은 세션시간에 맞춘시간</span>이며, <span style="color:blue;">푸른색은 로그에 있는 시간</span>입니다.</div>
</div>

<form name="time_rechkF" id="time_rechkF" action="time_rechk_reg.php" method="post">
<input type="hidden" name="search_kind" value="<?=htmlspecialchars($search_kind, ENT_QUOTES, 'UTF-8')?>">
<input type="hidden" name="ev_date" value="<?=(int)$ev_date?>">
<input type="hidden" name="pre_session" value="<?=htmlspecialchars($pre_session, ENT_QUOTES, 'UTF-8')?>">
<input type="hidden" name="next_session" value="<?=htmlspecialchars($next_session, ENT_QUOTES, 'UTF-8')?>">
<?for($j=0;$j<=$scoreMaxHour;$j++){?>
<input type="hidden" name="excep_score<?=$j?>" value="<?=htmlspecialchars(${'excep_score'.$j}, ENT_QUOTES, 'UTF-8')?>">
<?}?>
<input type="hidden" name="update_kind" id="update_kind" value="">
<table class="tblDef" >
	<colgroup>
		<?if($edit_complete!='Y'){?><col style="width: 3%;"><?}?>
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
		<col style="width: %;">
		<col style="width: %;">
		<?}?>
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 40px;">
		<col style="width: 40px;">
	</colgroup>
	<thead>
		<tr>
			<?if($edit_complete!='Y'){?><th ><input type="checkbox" class="allchk" style="padding:0px;margin:0px;width:20px;height:20px;"></th><?}?>
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
			<th><?=admin_orderby("S".$i." 입장","s".$i."_sdate",$sort_field,$orderby,$search_url)?></th>
			<th><?=admin_orderby("S".$i." 퇴장","s".$i."_edate",$sort_field,$orderby,$search_url)?></th>
			<?}?>
			<th><?=admin_orderby("최종퇴장","last_time",$sort_field,$orderby,$search_url)?></th>
			<th><?=admin_orderby("체류시간","total_time",$sort_field,$orderby,$search_url)?></th>
			<th>평점</th>
			<th>조정</th>
		</tr>
	</thead>
	<tbody>
		<?
			$n=1;
			$checkinList = array();
			$usidList = array();
			while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$checkinList[] = $d;
				$rowUsid = (int)$d['usid'];
				if ($rowUsid > 0) {
					$usidList[$rowUsid] = $rowUsid;
				}
			}

			$realTimeByUsid = array();
			if ($search_kind && $skey > 0 && count($usidList) > 0) {
				$usidIn = implode(',', $usidList);
				$sessionNo = (int)$skey;
				$dayNo = (int)$ev_date;
				if ($skind == 'S') {
					$realSql = "SELECT usid, MIN(min_t) AS real_t FROM ((";
					$realSql .= "SELECT usid, MIN(check_in) AS min_t FROM checkin_detail_tbl_history WHERE session_in='".$sessionNo."' AND day='".$dayNo."' AND usid IN (".$usidIn.") GROUP BY usid";
					$realSql .= ") UNION ALL (";
					$realSql .= "SELECT usid, MIN(check_in) AS min_t FROM checkin_detail_tbl WHERE session_in='".$sessionNo."' AND day='".$dayNo."' AND usid IN (".$usidIn.") GROUP BY usid";
					$realSql .= ")) A GROUP BY usid";
				} else if ($skind == 'O') {
					$realSql = "SELECT usid, MAX(max_t) AS real_t FROM ((";
					$realSql .= "SELECT usid, MAX(check_in) AS max_t FROM checkin_detail_tbl_history WHERE session_in='".$sessionNo."' AND day='".$dayNo."' AND usid IN (".$usidIn.") GROUP BY usid";
					$realSql .= ") UNION ALL (";
					$realSql .= "SELECT usid, MAX(check_in) AS max_t FROM checkin_detail_tbl WHERE session_in='".$sessionNo."' AND day='".$dayNo."' AND usid IN (".$usidIn.") GROUP BY usid";
					$realSql .= ")) A GROUP BY usid";
				}
				if (isset($realSql)) {
					$realResult = $conn->query($realSql);
					if (!DB::isError($realResult)) {
						while ($realRow = $realResult->fetchRow(DB_FETCHMODE_ASSOC)) {
							$realTimeByUsid[(int)$realRow['usid']] = $realRow['real_t'];
						}
					}
				}
			}

			foreach ($checkinList as $d) {
				
				$Gkey = $d['group_key'];

				unset($hour_time);
				unset($min_time);
				unset($score);
				$mark_session = 0;

				for($s=1;$s<=$time_max_count;$s++){
					unset(${'modify_s'.$s.'_sdate'});
					unset(${'modify_s'.$s.'_edate'});
					unset(${'modify_s'.$s.'_sdate_real'});
					unset(${'modify_s'.$s.'_edate_real'});
					
					if($search_kind=='S'.$s.'_time'){
						${'modify_s'.$s.'_sdate'} = $_TIME['session'][$ev_date][$s][0];

						$min_real_time = isset($realTimeByUsid[(int)$d['usid']]) ? $realTimeByUsid[(int)$d['usid']] : '';
						
						if($min_real_time){
							${'modify_s'.$s.'_sdate_real'} = date("Y-m-d H:i",$min_real_time);
						}
						
						if($d['first_date']>strtotime($_TIME['session'][$ev_date][$s][0])){
							${'modify_s'.$s.'_sdate'} = date("Y-m-d H:i",$d['first_date']);
						}

						$mark_session = $s;

					}
					
					if($search_kind=='O'.$s.'_time'){
						${'modify_s'.$s.'_edate'} = $_TIME['session'][$ev_date][$s][1];

						$max_real_time = isset($realTimeByUsid[(int)$d['usid']]) ? $realTimeByUsid[(int)$d['usid']] : '';
						
						
						if($max_real_time){
							${'modify_s'.$s.'_edate_real'} = date("Y-m-d H:i",$max_real_time);
						}
						if($time_max_count==$s){ //세션마지막 시간종료일때
							if($max_real_time<$d['last_time']){
								${'modify_s'.$s.'_edate_real'} = date("Y-m-d H:i",$d['last_time']);
							}
						}
						$mark_session = $s;

						
					}
				}

				if($pre_session=='Y'){
					if($mark_session!='1'){
						if(!$d['s'.($mark_session-1).'_sdate']) continue;
					}
				}
				if($next_session=='Y'){
					if(!$d['s'.($mark_session+1).'_sdate']) continue;
				}
				
				
				$stayInfo = getSessionStayScore(isset($d['total_time']) ? $d['total_time'] : 0, $scoreMaxHour);
				$hour_time = $stayInfo['stay_hours'];
				$min_time = $stayInfo['stay_min'];
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
		<tr>
			<?if($edit_complete!='Y'){?><td><input type="checkbox" name="chksid[]" class="chksid" value="<?=(int)$d['usid']?>" style="padding:0px;margin:0px;width:20px;height:20px;"></td><?}?>
			<td><?=$virtualRecordNo?></td>
			<td><?=date("m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['day']-1), $ex_sdate[0]));?></td>
			<td><?=$classLabel?></td>
			<td><?=$d['id']?></td>
			<td><?=$d['name_kr']?></td>
			<td><?=$d['name_eng']?></td>
			<td><?=$d['license_number']?></td>
			<td><?=$feeLabel?></td>
			<td class="FCEBF1"><?if($d['first_date']>0){?><?=date("H:i",$d['first_date'])?><?}?></td>
			<?for($i=1;$i<=$time_max_count;$i++){?>
			<td <?if(${'modify_s'.$i.'_sdate'} || ${'modify_s'.$i.'_sdate_real'}){?>style="background:#ECF8F9;"<?}?>>
				<?if($d['s'.$i.'_sdate']>0){?>
					<a href="javascript:popup_call('registration/session_time','sid=<?=$d['sid']?>&day=<?=$d['day']?>&group_key=<?=$d['group_key']?>')"><?=date("H:i",$d['s'.$i.'_sdate'])?></a>
				<?}?>
				<?if($edit_complete!='Y'){?>
				<?if(${'modify_s'.$i.'_sdate'}){?>
					<div style="color:red;"><?=substr(${'modify_s'.$i.'_sdate'},10,6)?></div>
				<?}?>
				<?if(strtotime(${'modify_s'.$i.'_sdate_real'})>$d['s'.$i.'_sdate']){?>
					<div style="color:blue;"><?=substr(${'modify_s'.$i.'_sdate_real'},10,6)?></div>
				<?}?>
				<?}?>
			</td>

			<td <?if(${'modify_s'.$i.'_edate'} || ${'modify_s'.$i.'_edate_real'}){?>style="background:#ECF8F9;"<?}?>>
				<?if($d['s'.$i.'_edate']>0){?>
					<a href="javascript:popup_call('registration/session_time','sid=<?=$d['sid']?>&day=<?=$d['day']?>&group_key=<?=$d['group_key']?>')"><?=date("H:i",$d['s'.$i.'_edate'])?></a>
				<?}?>
				<?if($edit_complete!='Y'){?>
				<?if(${'modify_s'.$i.'_edate'}){?>
					<!-- <div style="color:red;"><?=substr(${'modify_s'.$i.'_edate'},10,6)?></div> -->
				<?}?>
				<?if(${'modify_s'.$i.'_edate_real'}){?>
				
					<div style="color:blue;"><?=substr(${'modify_s'.$i.'_edate_real'},10,6)?><?if($d['s'.$i.'_edate']>${'modify_s'.$i.'_edate_real'}){?>!!!<?}?></div>
				<?}?>
				<?}?>
			</td>
			<?}?>
			<td class="FCEBF1"><?if($d['last_time']>0){?><?=date("H:i",$d['last_time'])?><?}?></td>
			<td><?=$hour_time !== '' ? $hour_time.':'.$min_time : ''?></td>
			<td ><?=number_format($score)?></td>
			<td><i class="far fa-clock" style="cursor:pointer;font-size:18px;" onclick="popup_call('registration/session_time','sid=<?=$d['sid']?>&day=<?=$d['day']?>&group_key=<?=$d['group_key']?>')"></i>
			<!-- <br><?=$d['total_time']."//".$d['ing_hour']?>
			<br><?=$d['max_time']."//".$d['max_hour']?> -->
			</td>
			<!-- <td><span class="rBtnAdmin small darkPink"><button type="button" onclick="popup_call('registration/checkin_list','sid=<?=$d['usid']?>&day=<?=$day?>')">View</button></span></td> -->
		</tr>
		<?$n++;?>
		<?$virtualRecordNo--;}?>
	</tbody>
</table>
</form>
<?if($search_kind){?>
<div class="btn ac tp20" >
	<?if($edit_complete=='Y'){?>
		<a href="<?=$PHP_SELF?>?<?=$search_url?>" class="btnGrey withIcon " style="padding:10px;"><i class="far fa-clock"></i>업데이트가 완료되었습니다.</a>
	<?}else{?>
		<a href="javascript:rechk_confirm('A')" class="btnGreen withIcon " style="padding:10px;"><i class="far fa-clock"></i>선택한 데이터 시간 업데이트하기(세션 기준)</a>
		<!-- <a href="javascript:rechk_confirm('B')" class="btnSky withIcon " style="padding:10px;"><i class="far fa-clock"></i>선택한 데이터 시간 업데이트하기(로그 기준)</a> -->
	<?}?>
</div>
<?
}else{
	if($sort_field) $search_url .= "&sort_field=".$sort_field;
	if($orderby) $search_url .= "&orderby=".$orderby;
?>
<div class="btnArea posRel">
	<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.page.php"?>						
</div>
<?}?>
<script src="/script/pickout.js"></script>
<script>
	// With Search
	pickout.to({
		el:'.pickout',
		search: true,
		theme: 'cricket',
		txtBtnMultiple: 'CONFIRMAR SELECIONADAS'
	});
	pickout.updated('.session_chking');
</script>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>
 