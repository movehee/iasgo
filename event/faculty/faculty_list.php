<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	
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

	$role_query = "select * from faculty_role_tbl order by sid asc";
	$role_result=$conn->query($role_query);
	if(DB::isError($role_result)) die($role_result->getMessage());
	while(is_array($role=$role_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$role_sid[] = $role['sid'];
		$role_title[$role['sid']] = $role['role_title'];
	}
	
?>
<script>
	function reset_session(fsid,dsid){
		if(confirm("선택하신 세션을 삭제하시겠습니까?")){
			$.ajax({
				type:"POST",
				url:"/popup/program/session_select_faculty_reg.php",
				data:"fsid="+fsid+"&dsid="+dsid+"&type=T",
				async:false,
				success:function(msg){
					if(msg=='Y'){
						//parent.$('.session_title_area_'+fsid+'_'+dsid).load("/load/faculty_session_load.php?sid="+dsid);
						//parent.$.colorbox.close();
						location.reload();
					}
				}
			});
		}
	}
</script>
<link rel="stylesheet" href="/script/pickout/dev/pickout.css">
<link rel="stylesheet" href="/script/pickout/dev/themes/pk-cricket.css">
<style>
.pk-modal{padding:0; margin:0;width:30%;}
.pk-form{width:500px;}
.pk-search{display:none !important;}
.main{padding:0;margin:0;}
.pk-field{width:100%;padding:3px;margin:0px;color:#FFFF00 !important}
.pk-arrow{display:none;}
</style>
<link rel="stylesheet" href="/script/fancybox/jquery.fancybox.min.css" />
<script src="/script/fancybox/jquery.fancybox.min.js"></script>
<div >
	<div class="btn" style="float:left;">
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=all" <?if($ev_date=='all'){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i>ALL</a></li>
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
</div>
<div style="clear:both;">
	<div class="btn tp10 bp10" style="float:left;">
		<a href="javascript:popup_call('excel/upload','kind=faculty_list')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Faculty 등록</a>
		<a href="javascript:common_delete('','faculty_all')" class="btnRed withIcon"><i class="fas fa-trash-alt" style="font-size:15px;padding-top:0px;"></i>전체삭제</a>
	</div>
	<div class="btn tp10 bp10" style="float:right;">
		<a href="<?=$_SERVER['PHP_SELF']?>?ev_date=all&unsel=Y" class="<?if($unsel=='Y'){?>btnRed<?}else{?>btnBdGrey<?}?>"><i class="fas fa-sign-in-alt"></i>미지정</a>
		<a href="<?=$_SERVER['PHP_SELF']?>?ev_date=<?=$ev_date?>" class="<?if(!$room && !$unsel){?>btnSky<?}else{?>btnBdGrey<?}?>"><i class="fas fa-sign-in-alt"></i>ALL</a>
		<?
		$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
		$room_result=$conn->query($room_query);
		if(DB::isError($room_result)) die($room_result->getMessage());
		while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>	
		<a href="<?=$_SERVER['PHP_SELF']?>?ev_date=<?=$ev_date?>&room=<?=$r['sid']?>" class="<?if($room==$r['sid']){?>btnSky<?}else{?>btnBdGrey<?}?>"><i class="fas fa-sign-in-alt"></i><?=$r['title']?></a>
		<?}?>
	</div>
</div>
<div style="clear:both;"></div>
<div class="searchArea">
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
	<input type="hidden" name="ev_date" value="<?=$ev_date?>">
	<input type="hidden" name="room" value="<?=$room?>">
	<input type="hidden" name="unsel" value="<?=$unsel?>">
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
						<th>세션명</th>
						<td class="al"><input type="text" name="title" id="title" value="<?=$title?>" style="width:95%;"></td>
						<th>세부세션명</th>
						<td class="al"><input type="text" name="detail_title" id="detail_title" value="<?=$detail_title?>" style="width:95%;"></td>
						<th>Role</th>
						<td class="al">
							<select name="faculty_kind">
								<option value="">선택</option>
								<?foreach($role_sid as $tkey=>$tval){?>
								<option value="<?=$tval?>"><?=$role_title[$tval]?></option>
								<?}?>
							</select>
						</td>
						<th>Faculty Name</th>
						<td class="al"><input type="text" name="faculty_name" id="faculty_name" value="<?=$faculty_name?>" style="width:95%;"></td>
						<th>Faculty 소속</th>
						<td class="al"><input type="text" name="faculty_aff" id="faculty_aff" value="<?=$faculty_aff?>" style="width:95%;"></td>
					</tr>
					<tr>
						<th>파일</th>
						<td class="al" colspan=9 style="font-size:17px;">
							<input type="checkbox" name="faculty_photo" id="faculty_photo" style="width:20px;height:20px;" value="Y" <?if($faculty_photo=='Y'){?>checked<?}?>><label for="faculty_photo">사진파일</label>
							<input type="checkbox" name="faculty_cv" id="faculty_cv" style="width:20px;height:20px;" value="Y"  <?if($faculty_cv=='Y'){?>checked<?}?>><label for="faculty_cv">CV파일</label>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="btn btnArea">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="검색초기화" class="btnGrey" onclick="location.href='<?=$PHP_SELF?>?ev_date=<?=$ev_date?>&room=<?=$room?>&unsel=<?=$unsel?>'">

				<!-- <input type="button" value="Booth Event Day 1" onclick="location.href='excel_booth_event.php?day=1'" class="btnMint initialism fade_open btn btn-success ex_btn">
				<input type="button" value="Booth Event Day 2" onclick="location.href='excel_booth_event.php?day=2'" class="btnMint initialism fade_open btn btn-success ex_btn"> -->
			</div>
		</fieldset>
	</form>
</div>
<?
	$search_sql = "";
	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code','ev_date','unsel','room','faculty_photo','faculty_cv','faculty_abs');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				$search_query[] = " $tkey like '%".$tval."%' ";
			}
		}
	}
	if($faculty_photo=='Y') $search_query[] = " (faculty_photo!='' and faculty_photo is not null)";
	if($faculty_cv=='Y') $search_query[] = " (faculty_cv!='' and faculty_cv is not null)";
	if($faculty_abs=='Y') $search_query[] = " (faculty_abs!='' and faculty_abs is not null)";

	if($search_query){
		$fsql = " where ".implode(" and ",$search_query) . " and fsid is not null";
	}else{
		$fsql = " where fsid is not null";
	}
	
	if($unsel=='Y'){
		$search_sql .= " and (ev_date='' or ev_date is null)";
	}else{
		if($ev_date!='all') $search_sql .= " and ev_date='$ev_date'";
		if($room) $search_sql .= " and room='$room'";
	}

	$cquery = "select * from faculty_category where del='N' and depth='1' order by sort_num asc ";
	$cresult=$conn->query($cquery);
	if(DB::isError($cresult)) die($cresult->getMessage());
	while(is_array($c=$cresult->fetchRow(DB_FETCHMODE_ASSOC))){
		$category_title_arr[$c['sid']] = $c['title'];
		$category_sid_arr[] = $c['sid'];
	}

	$cquery = "select * from faculty_category where del='N' and depth='2' order by psid asc,sort_num asc ";
	$cresult=$conn->query($cquery);
	if(DB::isError($cresult)) die($cresult->getMessage());
	while(is_array($c=$cresult->fetchRow(DB_FETCHMODE_ASSOC))){
		$category_title_sub_arr[$c['psid']][] = $c['title'];
		$category_sid_sub_arr[$c['psid']][] = $c['sid'];
	}

	//print_r($category_title_sub_arr[1]);

	

	$query = "select fsid,dsid,faculty_kind,category,category_sub,faculty_name,faculty_country,faculty_aff,faculty_photo,faculty_cv,faculty_abs,faculty_info,session_sid,session_detail_sid,ev_date,stime,etime,room,title,detail_time,detail_title,pre_num from (";
	$query .= "select t1.sid as fsid,t2.sid as dsid,t2.faculty_kind,t2.category,t2.category_sub,faculty_name,faculty_country,faculty_aff,faculty_photo,faculty_cv,faculty_abs,faculty_info,t2.session_sid,t2.session_detail_sid"; 
	$query .= ",t3.ev_date,t3.stime,t3.etime,t3.room,t3.title,t4.detail_time,t4.title as detail_title,t4.pre_num";
	$query .= " from faculty_tbl as t1 left join faculty_matching as t2 on t1.sid=t2.faculty_sid";
	$query .= " left join workshop_session_tbl as t3 on t3.sid=t2.session_sid";
	$query .= " left join workshop_session_detail_tbl as t4 on t4.sid=t2.session_detail_sid";
	$query .= ") A " .$fsql. $search_sql;
	$query .= " order by ev_date asc, room asc, stime asc, detail_time asc";
	//master_echo($query);

	if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
		echo $query;
	}
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<div>
	<div class="btn bp5" style="float:right;">
		<a href="javascript:popup_call('session/file_upload','code=faculty')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>사진 Upload</a>
		<a href="javascript:popup_call('session/file_upload','code=faculty_cv')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>CV Upload</a>
		<a href="javascript:popup_call('session/file_upload','code=faculty_abs')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Abstract Upload</a>
	</div>
</div>
<table class="tblDef">
	<colgroup>
		<col style="width: 7%;">
		<!-- <col style="width: 5%;">
		<col style="width: 8%;"> -->
		<col style="width: 5%;">
		<!-- <col style="width: 4%;">
		<col style="width: 4%;"> -->
		<col style="">
		<col style="width: 6%;">
		<col style="width: 24%;">

		<col style="width:60px;">
	</colgroup>
	<tbody>
		<tr>
			<th rowspan=2 style="background:#263238;color:#ffffff;">시간</th>
			<!-- <th style="background:#263238;color:#ffffff;">Specialty</th>
			<th style="background:#263238;color:#ffffff;">Specialty2</th> -->
			<th rowspan=2 style="background:#263238;color:#ffffff;">장소<br />(발표번호)</th>
			<!-- <th style="background:#263238;color:#ffffff;">코드</th>
			<th style="background:#263238;color:#ffffff;">언어</th> -->
			<th rowspan=2 style="background:#263238;color:#ffffff;">세션 / 세부세션</th>
			<th colspan=2 style="background:#263238;color:#ffffff;">Faculty 정보</th>
			<th rowspan=2 style="background:#263238;color:#ffffff;">관리</th>
		</tr>
		<tr>
			<th style="background:#263238;color:#ffffff;">사진</th>
			<th style="background:#263238;color:#ffffff;">Info</th>
		</tr>
		<?
			$ev_num = 0;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

				$start_time = $ex_sdate_arr[0]." ".$d['stime'];
				$end_time = $ex_sdate_arr[0]." ".$d['etime'];
				
				unset($stay_time);
				unset($ex_chair);
				unset($ex_chair2);
				if($d['stime'] && $d['etime']){
					$time = strtotime($end_time)-strtotime($start_time);
					$hh = ($time/60/60)%24;
					$mm = sprintf("%02d", ($time/60)%60);
					$stay_time = "";
					if($hh>0) $stay_time = $hh."시간 ";
					if($mm>0) $stay_time .= $mm."분";
				}

				$rowspan_cnt=1;
				
				$detail_cnt = $conn->getOne("select count(*) from workshop_session_detail_tbl where session_sid='".$d['sid']."' and del='N'");
				if($detail_cnt>0) $rowspan_cnt++;
				if($d['chair']){
					$ex_chair_position = explode("|",$d['chair_position']);
					$ex_chair = explode("|",$d['chair']);
				}
				if($d['chair2']){
					$ex_chair2_position = explode("|",$d['chair_position']);
					$ex_chair2 = explode("|",$d['chair2']);
				}
				if($d['session_file']){
					$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/session/" . $d["session_file"]) . "&filename=" . base64_encode($d["session_realfile"]);
				}
				
				if(file_exists($_SERVER['DOCUMENT_ROOT'].'upload/faculty/thumb/'.$d['faculty_photo'])){
					$fac_image = '/upload/faculty/thumb/'.$d['faculty_photo'];
				}else{
					$fac_image = '/upload/faculty/'.$d['faculty_photo'];
				}
				$Resize_img = imgResize($fac_image,82,82);

				$queryString_cv = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/faculty_cv/" . $d['faculty_cv']) . "&filename=" . base64_encode($d['faculty_cv']);
				$queryString_abs = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/faculty_abs/" . $d['faculty_abs']) . "&filename=" . base64_encode($d['faculty_abs']);

				if($d['faculty_kind']){
					$role_val = $role_title[$d['faculty_kind']];
				}else{
					$role_val = "None";
				}
				$category_val = "None";
				if($d['category']){
					$category_val = $category_title_arr[$d['category']];
				}
		?>
		<?
		if($ev_date=='all' && $d['ev_date']!=$ev_num){
			$ev_num++;
		?>
		<tr>
			<td colspan=10 class="al" style="background:#FF0000;height:26px;font-weight:bold;color:#ffffff;">
				<span style="font-size:13px;">▷</span><i style="font-size:15px;"> <?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['ev_date']-1), $ex_sdate[0]));?></i>
			</td>
		</tr>
		<?}?>
		<tr class="session_title_area_<?=$d['fsid'].'_'.$d['dsid']?>">
			<th style="background:#445964;color:yellow;" ><!-- <i class="far fa-id-card" style="font-size:50px;"></i> -->
				<?if($d['stime']){?><?=$d['stime']?> ~ <?=$d['etime']?><?}?>
				<?if($d['detail_time']){?><div style="font-size:12px;color:#ffffff;"><?=$d['detail_time']?></div><?}?>

				<?if($_SERVER['REMOTE_ADDR']=='218.235.94.225'){?>
				<br><Br><?=$d['dsid']?>
				<?}?>
			</th>
			<!-- <th style="background:#445964;color:#ffffff;" ><?=$d['part']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$d['part2']?></th> -->
			<th style="background:#445964;color:#ffffff;">
				<?=$room_name[$d['room']]?>
				<?if($d['pre_num']){?>
					<div style="font-size:14px;">(<?=$d['pre_num']?>)</div>
				<?}?>
			</th>
			<!-- <th style="background:#445964;color:#ffffff;"><?=$d['code']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$_PROGRAM['lang_code'][$d['lang']]?></th> -->
			<th style="text-align:left;background:#445964;color:#ffffff;font-size:17px;">
				<?if(!$d['session_sid'] && !$d['detail_sid']){?>
					<div style="font-size:13px;">선택된 세션이 존재하지 않습니다. 세션을 선택하시려면 
					<a href="/popup/program/session_select_faculty.php?fsid=<?=$d['fsid']?>&dsid=<?=$d['dsid']?>" class="iframe_session_fac"><u style="font-style:italic;color:#FFFF00;font-size:19px;font-weight:bold;">Click</u> </a>
					해주세요</div>
				<?}else{?>
					<?if($d['title']){?>
						<div style="color:yellow;"><?=stripslashes($d['title'])?></div>
					<?}?>
					<?if($d['detail_title']){?>
						<div style="font-size:14px;padding-left:20px;"><?=stripslashes($d['detail_title'])?></div>
					<?}?>
					<div style="float:right;"><span class="btnAdmin small darkPink" ><button type="button" onclick="reset_session(<?=$d['fsid']?>,<?=$d['dsid']?>)" style="width:100%;">Delete</button></span></div>
				<?}?>
			</th>
			<th style="background:#445964;color:#ffffff;margin:0px;padding:0px;" >
				<?if($d['faculty_photo']){?>
					<a id="fancyimg" href="/upload/faculty/<?=$d['faculty_photo']?>" data-fancybox="gallery"><?=$Resize_img?></a>
				<?}else{?>
					<i class="far fa-id-card" style="font-size:60px;"></i>
				<?}?>
			</td>
			<th style="background:#445964;color:#ffffff;font-size:11px;" valign="top">
				<div style="float:right;padding:0px;margin:0px;">
					<?if($d['faculty_cv']){?>
					<span class="btnAdmin small green" ><button type="button" onclick="location.href='/func/download.php?<?=$queryString_cv?>'">CV</button></span>
					<?}else{?>
					<span class="btnAdmin small empty darkGray" ><button type="button" onclick="popup_call('session/faculty','sid=<?=$d['fsid']?>')">CV</button></span>
					<?}?>
					<?if($d['faculty_abs']){?>
					<span class="btnAdmin small green" ><button type="button" onclick="location.href='/func/download.php?<?=$queryString_abs?>'">Abstract</button></span>
					<?}else{?>
					<span class="btnAdmin small empty darkGray" ><button type="button" onclick="popup_call('session/faculty','sid=<?=$d['fsid']?>')">Abstract</button></span>
					<?}?>
				</div>
				<div style="color:yellow;float:left;">
				<select name="fkind" id="fkind" class="fkind pickout" placeholder="<?=$role_val?>" >
					<option value=""><?=$role_val?></option>

					<?foreach($role_sid as $tkey=>$tval){?>
					<option value="<?=$tval?>|<?=$d['dsid']?>|<?=$d['fsid']?>" <?if($tval==$d['faculty_kind']){?>selected<?}?>>
						<?=$role_title[$tval]?>
					</option>	
					<?}?>
				
				</select>
				</div>

				<div style="float:left;clear:both;"><?=$d['faculty_name']?><?if($d['faculty_country']){?> (<?=$d['faculty_country']?>)<?}?></div>
				<div style="float:right;clear:both;"><i><?=$d['faculty_aff']?></i></div>
			</td>
			<th style="background:#445964;color:#ffffff;">
				<?if($d['dsid']){?>
				<div><span class="btnAdmin small lightBlue" style="width:97%;"><button type="button" onclick="popup_call('session/faculty','sid=<?=$d['fsid']?>&dsid=<?=$d['dsid']?>')" style="width:100%;">수정</button></span></div>
				<div style="padding-top:2px;"><span class="btnAdmin small  red" style="width:97%;"><button type="button" onclick="common_delete('<?=$d['dsid']?>','faculty_detail')" style="width:100%;">삭제</button></span></div>
				<?}?>
			</th>
		</tr>
		<?}?>
	</tbody>
</table>
<script src="/script/pickout.js"></script>
<script>
	// With Search
	pickout.to({
		el:'.pickout, .pickout_category, .pickout_category_sub',
		search: true,
		theme: 'cricket',
		txtBtnMultiple: 'CONFIRMAR SELECIONADAS'
	});
	pickout.updated('.fkind .fcategory_sub .fcategory_sub');
</script>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>