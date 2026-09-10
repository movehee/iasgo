<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
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
				</colgroup>
				<tbody>
					<tr>
						<th>Faculty Name</th>
						<td class="al"><input type="text" name="faculty_name" id="faculty_name" value="<?=$faculty_name?>" style="width:95%;"></td>
						<th>Faculty 소속</th>
						<td class="al"><input type="text" name="faculty_aff" id="faculty_aff" value="<?=$faculty_aff?>" style="width:95%;"></td>
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
	$role_query = "select * from faculty_role_tbl order by sid asc";
	$role_result=$conn->query($role_query);
	if(DB::isError($role_result)) die($role_result->getMessage());
	while(is_array($role=$role_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$role_sid[] = $role['sid'];
		$role_title[$role['sid']] = $role['role_title'];
	}



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
		$fsql = " where ".implode(" and ",$search_query) . " and sid is not null";
	}else{
		$fsql = " where sid is not null";
	}

	$query = "select * from faculty_tbl" .$fsql;
	if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
		echo $query;
	}
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<div>
	<div class="btn bp5" style="float:left;">
		<a href="javascript:popup_call('faculty/reg_connect','code=faculty')" class="btnSky withIcon"><i class="fas fa-link" style="font-size:15px;padding-top:0px;"></i>회원연결</a>
		<a href="sort_list.php" class="btnSky withIcon"><i class="fa fa-sort" style="font-size:15px;padding-top:0px;"></i>노출 순서변경</a>
		<a -href="award.php" class="btnYellow withIcon"><i class="fa fa-trophy" style="font-size:15px;padding-top:0px;"></i>Award</a>
	</div>
	<div class="btn bp5" style="float:right;">
		<a href="javascript:popup_call('session/file_upload','code=faculty')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>사진 Upload</a>
		<a href="javascript:popup_call('session/file_upload','code=faculty_cv')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>CV Upload</a>
		<a href="javascript:popup_call('session/file_upload','code=faculty_abs')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Abstract Upload</a>
	</div>
</div>
<table class="tblDef">
	<colgroup>
		<col style="width: 7%;">
		<col style="">
		<col style="width:80px;">
		<col style="width:100px;">
		<col style="width:65px;">
		<col style="width:65px;">
		<col style="width: 17%;">
		<col style="width:70px;">
	</colgroup>
	<tbody>
		<tr>
			<th style="background:#263238;color:#ffffff;">사진</i></th>
			<th style="background:#263238;color:#ffffff;">세션 / 세부세션</th>
			<th style="background:#263238;color:#ffffff;">회원</th>
			<th style="background:#263238;color:#ffffff;">Flag</th>
			<th style="background:#263238;color:#ffffff;">Award</th>
			<th style="background:#263238;color:#ffffff;">No Faculty</th>
			<th style="background:#263238;color:#ffffff;">Faculty 정보</th>
			<th style="background:#263238;color:#ffffff;">관리</th>
		</tr>
		<?
			$ev_num = 0;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				if(file_exists($_SERVER['DOCUMENT_ROOT'].'upload/faculty/thumb/'.$d['faculty_photo'])){
					$fac_image = '/upload/faculty/thumb/'.$d['faculty_photo'];
				}else{
					$fac_image = '/upload/faculty/'.$d['faculty_photo'];
				}
				$Resize_img = imgResize($fac_image,82,82);
				$queryString_cv = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/faculty_cv/" . $d['faculty_cv']) . "&filename=" . base64_encode($d['faculty_cv']);
				$queryString_abs = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/faculty_abs/" . $d['faculty_abs']) . "&filename=" . base64_encode($d['faculty_abs']);


		?>
		<tr class="session_title_area_<?=$d['fsid'].'_'.$d['dsid']?>">
			<th style="background:#445964;color:#ffffff;margin:0px;padding:5px;" >
				<?if($d['faculty_photo']){?>
					<a id="fancyimg" href="/upload/faculty/<?=$d['faculty_photo']?>" data-fancybox="gallery"><?=$Resize_img?></a>
				<?}else{?>
					<i class="far fa-id-card" style="font-size:60px;"></i>
				<?}?>
			</td>
			<th style="background:#445964;color:#ffffff;" class="al">
				<?
					$role_query = "select * from faculty_matching as t1 inner join workshop_session_tbl as t2 on t1.session_sid=t2.sid where faculty_sid='".$d['sid']."'";
					$role_result=$conn->query($role_query);
					if(DB::isError($role_result)) die($role_result->getMessage());

					while(is_array($role=$role_result->fetchRow(DB_FETCHMODE_ASSOC))){
						echo "<div style='font-size:14px;color:yellow;'>[".$role['stime']."~".$role['etime']."] ".stripslashes(strip_tags($role['title']))."</div>";
						echo "<span style='font-size:10px;'>".$role_title[$role['faculty_kind']]."</span>";
						if($role['session_detail_sid']>0){
							$detail_title = $conn->getOne("select title from workshop_session_detail_tbl where sid='".$role['session_detail_sid']."'");
							if($detail_title){
								echo "<div style='padding-left:20px;font-size:12px;'>- ".stripslashes(strip_tags($detail_title))."</div>";
							}
						}
					}
				?>
			</th>
			<th style="background:#445964;color:#ffffff;font-size:11px;">
				<span id="Conn_<?=$d['sid']?>" class="btnAdmin small <?if(!$d['usid']){?>empty darkGray<?}else{?>lightBlue<?}?>" >
					<button type="button" href="/load/faculty/reg_connect.php?sid=<?=$d['sid']?>" class="iframe_session">회원 연결</button>
				</span>
			</th>

			<th style="background:#445964;color:#ffffff;"><?if($_Flag['country'][$d['faculty_country']]){?><img src="/upload/flag/thumb/<?=$_Flag['country'][$d['faculty_country']]?>.png" ><?}?></th>
			<th style="background:#445964;color:#ffffff;font-size:11px;">
				<input type="checkbox" style="width:30px;height:30px;margin:0px;padding:0px;" key="<?=$d['sid']?>" kind="faculty_award" class="check_value" <?if($d['award']=='Y'){?>checked<?}?>>
			</th>
			<th style="background:#445964;color:#ffffff;font-size:11px;">
				<input type="checkbox" style="width:30px;height:30px;margin:0px;padding:0px;" key="<?=$d['sid']?>" kind="faculty_none" class="check_value" <?if($d['faculty_none']=='Y'){?>checked<?}?>>
			</th>
			<th style="background:#445964;color:#ffffff;font-size:11px;" valign="top">
				<div style="float:right;padding:0px;margin:0px;">
					<!-- <span class="btnAdmin small empty darkGray" ><button type="button" onclick="">Abstract</button></span> -->
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
				<div style="float:left;clear:both;"><?=$d['faculty_name']?><?if($d['faculty_country']){?> (<?=$d['faculty_country']?>)<?}?></div>
				<div style="float:right;clear:both;"><i class="fas fa-h-square" style="font-size:15px;top:2px;position:relative;"></i> <i><?=$d['faculty_aff']?></i></div>
				
				<div style="float:right;clear:both;padding-top:5px;font-size:12px;color:#F9DF79;">
					<i class="fas fa-envelope" style="font-size:15px;top:2px;position:relative;"></i> <i><a href="mailto:<?=$d['faculty_email']?>"><?=$d['faculty_email']?></a></i>
				</div>

				
				
			</th>
			<th style="background:#445964;color:#ffffff;">
				<div><span class="btnAdmin small lightBlue" style="width:97%;"><button type="button" onclick="popup_call('session/faculty','sid=<?=$d['sid']?>')" style="width:100%;">수정</button></span></div>
				<div style="padding-top:2px;"><span class="btnAdmin small  red" style="width:97%;"><button type="button" onclick="common_delete('<?=$d['sid']?>','faculty')" style="width:100%;">삭제</button></span></div>
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