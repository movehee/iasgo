<?
if($tab=="-3" || $tab=="-5" || $tab=="-6" || $tab=="-2"){
	if($tab=="-3"){
		if($search) {
			if($setting_col['faculty_type']==1){
				$query = "select a.*, p.tab ptab, r.photo room_photo, r.name room_info, r.view_type from session_tbl a, session_faculty_tbl b, faculty_tbl c, session_tbl p, session_room_tbl r  where a.link_session=p.sid and p.room=r.sid and a.sid=b.session_sid and b.faculty_sid=c.sid and a.code='".$code."' and a.type='2' ";
				$query .= " and (a.abs_no like '%".$search."%' or a.abs_sid like '".$search."' or c.name like '%".$search."%' or c.name_en like '%".$search."%' or a.etc_speaker like '%".$search."%' or a.title like '%".$search."%')";
				$query .= "group by a.sid order by a.tab asc, a.orderby asc";

			}else{
				$query = "select a.*, p.tab ptab, r.photo room_photo, r.name room_info, r.view_type from session_tbl a, session_tbl p, session_room_tbl r where a.link_session=p.sid and p.room=r.sid and a.code='".$code."' and a.type='2' ";
				$query .= " and (a.abs_no like '%".$search."%' or a.abs_sid like '%".$search."%' or a.etc_speaker like '%".$search."%' or a.speaker like '%".$search."%' or a.title like '%".$search."%') order by a.tab asc, a.orderby asc";
			
			}
			$result = mysqli_query($conn, $query);
		}
	}else if ($tab=="-5"){
		if($setting_col['faculty_session_type']==1){
		$query = "select a.*, p.tab ptab, r.photo room_photo, r.name room_info, r.view_type from session_tbl a, session_faculty_tbl b, session_tbl p, session_room_tbl r where a.link_session=p.sid and p.room=r.sid and a.sid=b.session_sid and a.code='".$code."' and a.type='2' and a.viewYN='Y' ";
		$query .= " and b.faculty_sid = '".$sid."'";
		$query .= " order by p.tab asc, a.orderby asc";
		$result = mysqli_query($conn, $query);
		}
		//echo $query;
	}else if ($tab=="-6"){
		$query = "select a.*, p.tab ptab, r.photo room_photo, r.name room_info, r.view_type from session_tbl a, session_memo_tbl b, session_tbl p, session_room_tbl r where a.link_session=p.sid and p.room=r.sid and a.sid=b.session_sid and a.code='".$code."' and a.type='2' and a.viewYN='Y' and b.deviceid='".$deviceid."'";
		$query .= " order by a.tab asc, a.orderby asc";
		$result = mysqli_query($conn, $query);
		//echo $query;
	}else if($tab=="-2"){
		$query = "select a.*, p.tab ptab, r.photo room_photo, r.name room_info, r.view_type from session_tbl a, session_favor_tbl b, session_tbl p, session_room_tbl r where a.link_session=p.sid and p.room=r.sid and a.sid=b.session_sid and a.code='".$code."' and a.type='2' and a.viewYN='Y' and b.deviceid='".$deviceid."'";
		//$query .= " order by a.tab asc, a.orderby asc";
		$query .= " order by a.tab asc, a.time asc, a.orderby asc";
		$result = mysqli_query($conn, $query);
	}

	if($_SERVER['REMOTE_ADDR']=='218.235.94.225'){
		//echo $query;
	}

?>

<div class="session">

<?if( ($tab=="-3" && $search && $result->num_rows) || ($tab=="-2" && $result->num_rows) ){?>
<h3 class="dayInfo2">Lecture</h3>
<?}?>

<ul class="sessionList <?if($tab=="-6" || $tab=="-2" || $tab=="-3" || $tab=="-5"){?> memo<?}?>">
<?while(is_array($subcol = mysqli_fetch_array($result))){
	$cnt2++;
?>
	<li><a href="javascript:move_page('./view.php?sid=<?=$subcol['sid']?>&toptext=<?=$toptext?>&code=<?=$code?>&deviceid=<?=$deviceid?>&tab=<?=$tab?>&glanceYN=<?=$glanceYN?>','session<?=$col['sid']?>')">
	<?if($tab!="-6"){?>
	<i class="fas fa-angle-right"></i>
	<?}?>
	<?if($setting_col['abs_sid']=="Y" && $subcol['abs_sid']){?>
		<span class="sessionCode"><?=$subcol['abs_sid']?></span>
	<?}?>
	<?if($setting_col['abs_no']=="Y" && $subcol['abs_no']){
	
		if($code == "ksc2019"){
			$abs_no_arr = explode('||', $subcol['abs_no']);
			$subcol['abs_no'] = $abs_no_arr['2'];
		}
	?>
		<span class="sessionCode2"><?=$subcol['abs_no']?></span>
	<?}?>

	<?if($setting_col['title']=="Y" && $subcol['title']){?>
	
		<span class="sessionTit"><?=$subcol['title']?></span>
	<?}?>

	<?
		$faculty_session_sid=$subcol['sid'];
		$faculty_info="speaker";
		$faculty_view_type=3;
		$session_sid=$subcol['sid'];
		include "./speaker.php";
	?>

	<?if($setting_col['etc_speaker'] == 'Y'){?>
		<?if($subcol['etc_speaker']){?>
			<span class="etc_speaker"><?=$subcol['etc_speaker']?></span>

		<?}?>

	<?}?>

	<ul class="sessionInfo2">
	
		<li><i class="far fa-clock" title="Time"></i> <?=$agenda_array[$subcol['ptab']]?> <?=$subcol['time']?></li>
		<li <?if($subcol['view_type']=='1'){?>class="border"<?}?> ><a <?if($subcol['room_photo']){?> href="/upload/room/<?=$subcol['room_photo']?>"<?}?>><i class="fas fa-map-marker-alt" title="Venue"></i> <?=$subcol['room_info']?></li>
	</ul>

	<?if($tab=="-6"){?>
		<a onclick="javascript:memo_click('<?=$subcol['sid']?>','<?=$deviceid?>')" class="memo" id="memobtn"><i class="fas fa-pen-square"></i></a>
	<?}?>

	</a></li>
<?}?>

</ul>



<?
if($tab=="-2" && $abs_setting_col['abs_favor']=='Y') { //초록 즐겨찾기 

	if($abs_setting_col['abs_sync']=='Y') { //연동
		$abs_fav_query = "select * from abstract_favor_tbl where code='$code' and deviceid='$deviceid'";

		$abs_fav_result = mysqli_query($conn, $abs_fav_query);
		$abstract_sid_arr = array();
		while (is_array($col = mysqli_fetch_array($abs_fav_result))) {
			$abstract_sid_arr[] = $col['abstract_sid'];
		}
		$abstract_num = sizeof($abstract_sid_arr);
		
		include_once $_SERVER['DOCUMENT_ROOT']."/php/abstract/$code/favor_list.php";
	}
	else {

		$abs_fav_query = "select a.sid as abs_fav_sid, b.* from abstract_favor_tbl a, abstract_tbl b where a.abstract_sid=b.sid and a.code='$code' and a.deviceid='$deviceid'";
		$abs_fav_result = mysqli_query($conn, $abs_fav_query);

		if($abs_fav_result->num_rows) {
?>
		<h3 class="dayInfo2"><?=$abs_setting_col['abstract_txt']?></h3><ul class="subjectList">
<?
		while (is_array($abs_col = mysqli_fetch_array($abs_fav_result))) {
		$cnt_f++;
?>
		
		<li class="mySchedule favor_row">
			<a href="./../abstract/view.php?code=<?=$code?>&deviceid=<?=$deviceid?>&sid=<?=$abs_col['sid']?>">

			<span class="sessionCode">[<?=$abs_col['abs_no']?>]</span>
			<span class="sessionTit"><?=$abs_col['title']?></span>
			<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$abs_col['speaker']?></span>
			</a>

			<p class="btn btnDel"><a onclick="javascript:favor_del(this,'<?=$abs_col['sid']?>','<?=$deviceid?>','<?=$code?>','abstract')"><i class="far fa-trash-alt" title="Trash"></i></a></p>
			
		</li>
		<?
			}
		echo "</ul>";
		}
	}
?>


<?}?>




<?
if($tab=="-3" && $search && $abs_setting_col['abs_sync']=='N'){
	$query = "SELECT * FROM abstract_tbl where code='".$code."' and ( title like '%".$search."%' ";

	for($ano=1; $ano<=16; $ano++) {
		if($abs_setting_col['abs_info'.$ano] && $col['info'.$ano] && $abs_setting_col['abs_info'.$ano.'_chk']=="Y"){
			$query .= " or info".$ano." like '%".$search."%'";
		}
	}
	/*
	if($abs_setting_col['abs_info1'] && $col['info1'] && $abs_setting_col['abs_info1_chk']=="Y"){
		$query .= " or info1 like '%".$search."%'";
	}
	if($abs_setting_col['abs_info2'] && $col['info2'] && $abs_setting_col['abs_info1_chk']=="Y"){
		$query .= " or info2 like '%".$search."%'";
	}
	if($abs_setting_col['abs_info3'] && $col['info1'] && $abs_setting_col['abs_info3_chk']=="Y"){
		$query .= " or info3 like '%".$search."%'";
	}
	if($abs_setting_col['abs_info4'] && $col['info4'] && $abs_setting_col['abs_info4_chk']=="Y"){
		$query .= " or info4 like '%".$search."%'";
	}
	if($abs_setting_col['abs_info5'] && $col['info5'] && $abs_setting_col['abs_info5_chk']=="Y"){
		$query .= " or info5 like '%".$search."%'";
	}
	if($abs_setting_col['abs_info6'] && $col['info6'] && $abs_setting_col['abs_info6_chk']=="Y"){
		$query .= " or info6 like '%".$search."%'";
	}
	if($abs_setting_col['abs_info7'] && $col['info7'] && $abs_setting_col['abs_info7_chk']=="Y"){
		$query .= " or info7 like '%".$search."%'";
	}
	*/
	$query .= ")";
	$result = mysqli_query($conn, $query);
	?>
<ul class="subjectList">

<?
	while (is_array($col = mysqli_fetch_array($result))) {
	$cnt2++;?>
	
		<li><a href="./../abstract/view.php?code=<?=$code?>&sid=<?=$col['sid']?>">
		<?if($col['abs_no']){?>
			<span style="font-size:11px;">[<?=$col['abs_no']?>]</span><br>
		<?}?>

		<b><?=$col['title']?></b>
		
		<?for($ano=1; $ano<=16; $ano++) {?>

			<?if($abs_setting_col['abs_info'.$ano] && $col['info'.$ano] && $abs_setting_col['abs_info'.$ano.'_chk']=="Y"){?>
				<br><?=$col['info'.$ano]?>
			<?}?>

		<?}?>



		
		
		</a></li>
<?}?>
</ul>

<?}?>



</div>
<?}?>

