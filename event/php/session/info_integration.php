<?
	if(!$top_tab) $top_tab = 89;
?>
<ul class="tabMenu_agenda">
	<li class="<?if($top_tab==89){?> on<?}?>" style="width:33.3%"><a href="./list.php?code=<?=$code?>&tab=-2&deviceid=<?=$deviceid?>&top_tab=89">Oct. 17<sup>th</sup> Thu.</a></li>

	<li class="<?if($top_tab==90){?> on<?}?>" style="width:33.3%"><a href="./list.php?code=<?=$code?>&tab=-2&deviceid=<?=$deviceid?>&top_tab=90">Oct. 18<sup>th</sup> Fri.</a></li>

	<li class="<?if($top_tab==91){?> on<?}?>" style="width:33.3%"><a href="./list.php?code=<?=$code?>&tab=-2&deviceid=<?=$deviceid?>&top_tab=91">Oct. 19 <sup>th</sup> Sat.</a></li>
</ul>
<?php

$abs_query = "select * from abstract_favor_tbl where code='$code' and deviceid='$deviceid'";
$abs_result = mysqli_query($conn, $abs_query);
$abs_num = $abs_result->num_rows;

if($abs_num) {
	while(is_array($abs = mysqli_fetch_array($abs_result))){

		if($abs['session_sid']) $abs_session[] = $abs['session_sid'];
		if($abs['abstract_sid']) $abs_sid[] = $abs['abstract_sid'];

		$cnt_f++;
	}

	include_once $_SERVER['DOCUMENT_ROOT']."/php/abstract/$code/config.php";

	$abs_sids = implode(',', $abs_sid);

	$query = "SELECT * FROM abstract_tbl where sid in (".$abs_sids.")";
	$result=$local_conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	while(is_array($col=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
		$abs_info[$col['abs_no']]['sid'] = $col['sid'];
		//$abs_info[$col['sid']]['title'] = !empty($col['title_eng'])?$col['title_eng']:$col['title_kor'];

		$abs_info[$col['abs_no']]['title'] = !empty($col['title_eng'])?$col['title_eng']:$col['title_kor'];
	}
}



$query = "select * from ( ";
$query .= "SELECT 
'A' as fv_type, '' as link_sid, a.sid, a.tab, a.type, a.category1, a.language, 
a.theme, a.sub_theme, t.time time_info, '' as abs_no, '' as abs_sid, 
r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo 

FROM session_tbl a, session_favor_tbl b, session_room_tbl r, session_time_tbl t WHERE a.time=t.sid and a.room=r.sid and a.sid=b.session_sid and a.type='1' and a.code='".$code."' and a.viewYN='Y' and b.deviceid = '".$deviceid."'";

$query .= " UNION ALL ";

$query .= "select 
'B' as fv_type, a.sid as link_sid, p.sid, p.tab, a.type, '' as category1, '' as language, 
a.title as theme, '' as sub_theme, a.time as time_info, a.abs_no, a.abs_sid, 
r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo 

from session_tbl a, session_favor_tbl b, session_tbl p, session_room_tbl r where a.link_session=p.sid and p.room=r.sid and a.sid=b.session_sid and a.code='".$code."' and a.type='2' and a.viewYN='Y' and b.deviceid='".$deviceid."'";

if($abs_sids) {
	$abs_session_sids = implode(',', $abs_session);

$query .= " UNION ALL ";

$query .= "select 
'C' as fv_type, '' as link_sid, p.sid, p.tab, a.type, '' as category1, '' as language, 
a.title as theme, '' as sub_theme, a.time as time_info, a.abs_no, a.abs_sid, 
r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo 

from session_tbl a, session_tbl p, session_room_tbl r where a.link_session=p.sid and p.room=r.sid and a.code='".$code."' and a.type='2' and a.sid in (".$abs_session_sids.")";
}

$query .= " ) a where tab='$top_tab'";
//$query .= " ) a ";

$query .= " order by time_info";

$result = mysqli_query($conn, $query);
while(is_array($col = mysqli_fetch_array($result))){
?>

<div class="session" id="session<?=$col['sid']?>">
	<p class="sessionBrief">

	<?
		if($col['fv_type'] == 'A'){
			$subquery = "SELECT * FROM session_tbl ";	
			$subquery .= "  WHERE type = '2' ";
			$subquery .= " and link_session = '".$col['sid']."' ";
			$subquery .= " order by orderby asc ";		
			$subresult=mysqli_query($conn, $subquery);

			$totalquery = str_replace("SELECT * FROM", "SELECT count(*) cnt FROM", $subquery); 
			$totalresult=mysqli_query($conn, $totalquery);
			$totalcol = mysqli_fetch_array($totalresult);
		}
		else {
			$totalcol['cnt'] = 0;
		}
		
		

	?>	

	
	
	
	<?if($col['fv_type'] == 'C'){?>
	<a href="../abstract/view.php?code=<?=$code?>&deviceid=<?=$deviceid?>&sid=<?=$abs_info[$col['abs_no']]['sid']?>"><i class="fas fa-angle-right"></i>
		<?
		$p_author_query = "select * from abstract_author where asb_num='".$abs_info[$col['abs_no']]['sid']."' and FIND_IN_SET(1, type)";
		$p_author_result = $local_conn->query($p_author_query);
		if(DB::isError($p_author_result)) {
			die($p_author_result->getMessage().'author_query');
		}

		$p_author_col = $p_author_result->fetchRow(DB_FETCHMODE_ASSOC);
		$pname = $p_author_col['first_name'].' '.$p_author_col['last_name'];
		?>
		<?if($col['abs_no']){?>
			<span class="sessionCode2"><?=$col['abs_no']?></span>
		<?}?>
			<span class="sessionTit"><?=$abs_info[$col['abs_no']]['title']?></span>

			<span class="chairperson"><?=$pname?></span>
		</p>
		</a>
		
		<ul class="sessionInfo">

			<li><i class="far fa-clock" title="Time"></i> 

			<li><?=$agenda_array[$col['tab']]?>
			<?=$col['time_info']?>
			</li>

			<li class="view<?=$col['view_type']?>"><?if($col['room_photo']){?><a href="/upload/room/<?=$col['room_photo']?>"><?}?><i class="fas fa-map-marker-alt" title="Venue"></i> <?=$col['room_info']?><?if($col['room_photo']){?></a><?}?></li>

			<p class="btn btnDel"><a onclick="javascript:favor_del(this,'<?=$abs_info[$col['abs_no']]['sid']?>','<?=$deviceid?>','<?=$code?>','abstract')"><i class="far fa-trash-alt" title="Venue"></i></a></p>
		</ul>

	<?}else if($col['fv_type'] == 'A'){ $cnt2++; //세션 ?>

	<a href="#" class="trigger"><i class="fas fa-angle-down"></i>
		<?if(($setting_col['category1'] && $col['category1']) || ($setting_col['language'] && $col['language'] != 0)){
			$temp_result = mysqli_query($conn, "select * from session_category_tbl WHERE sid='".$col['category1']."'");
			$temp_row = mysqli_fetch_array($temp_result);
		?>
			<span class="category">
			
			<?
			$bullet_eng = $setting_col['bullet_txt_eng']?$setting_col['bullet_txt_eng']:"E";
			$bullet_kor = $setting_col['bullet_txt_kor']?$setting_col['bullet_txt_kor']:"K";
			?>

			<?if($col['language'] =="1"){?>
				<span class="bullet eng"><?=$bullet_eng?></span>
			<?}else if($col['language'] =="2"){?>
				<span class="bullet kor"><?=$bullet_kor?></span>
			<?}else if($col['language'] =="3"){?>
				<span class="bullet eng"><?=$bullet_eng?></span>
				<span class="bullet kor"><?=$bullet_kor?></span>
			<?}else if($col['language'] =="4"){?>
				<span class="bullet kor"><?=$bullet_kor?></span>
				<span class="bullet eng"><?=$bullet_eng?></span>
			<?}?>
			

			<?if($_SET['etc_info'] && $col['etc_info']){
				$etc_info_arr = explode("|", $col['etc_info']);
				foreach($_SET['etc_info'] as $etc_info_key => $etc_info_val){
					if(in_array($etc_info_key, $etc_info_arr)) {
			?>
				<span class="bullet" style="background-color:<?=$_SET['etc_info_bgcolor'][$etc_info_key]?>;color: <?=$_SET['etc_info_color'][$etc_info_key]?>;"><?=$etc_info_val?></span>
				<?}}?>
			<?}?>

			<?if($setting_col['category_view']=="1" || $setting_col['category_view']=="2"){?>

			<?if($temp_row['color'] !="#" && $setting_col['category_text_font']!="3"){?>
				<span class="bullet" style="background-color:<?=$temp_row['color']?>"><?=$temp_row['abb']?> 
				<?if($setting_col['category_text_font']=="4" && $setting_col['category_view']=="1"){?>
					 <?=$col['category2']?>
				<?}?>
				</span>
				<?}?>

				<?if($setting_col['category_text_font']!="3"){?>
				<?if($setting_col['category_text_font']=="2"){?><font style="color:<?=$temp_row['color']?>"><?}?>
				<?=$temp_row['info']?> <?if($setting_col['category_view']=="1"){?> <?=$col['category2']?><?}?>
				<?if($setting_col['category_text_font']=="2"){?></font><?}?>
				<?}?>
			
			<?}else if($setting_col['category_view']=="3"){?>
				<?=$col['category2']?>
			<?}?>
			</span>
		<?}?>

		<?if($col['theme'] && $setting_col['theme']=="Y"){?>
			

			<?if($setting_col['session_title_style']=='1'){?>
				<span class="sessionTit"><?=$col['theme']?>

				<?if($col['sub_theme'] && $setting_col['sub_theme']=="Y"){?>
				<font><?=$col['sub_theme']?></font>
				<?}?></span>

			<?}else if($setting_col['session_title_style']=='2'){
			
			$session_title_txt = $setting_col['session_title_txt'];
			$session_title_txt = str_replace("{theme}", $col['theme'], $session_title_txt);
			$session_title_txt = str_replace("{sub_theme}", $col['sub_theme'], $session_title_txt);

			?>
			<span class="sessionTit2"><?=$session_title_txt?></span>
			
				
			<?}?>
		<?}?>

		<?if($setting_col['program_view_type']=="1"){
			$faculty_session_sid=$col['sid'];
			$faculty_info="chair";
			$faculty_view_type=1;
			include "./speaker.php";
			$faculty_info="panel";
			include "./speaker.php";
			?>

			<?if($setting_col['etc_faculty']=="Y"){
				if($col['etc_faculty']){?>
				<span class="chairperson"><?=$col['etc_faculty']?></span>
			<?}}?>
			
			<?
			$faculty_info="discusser";
			include "./speaker.php";
			?>

		<?}?>

		</a>
		</p>



		<ul class="sessionInfo">

			<li><i class="far fa-clock" title="Time"></i> 

			<li><?=$agenda_array[$col['tab']]?>
			<?=$col['time_info']?>
			</li>

			<li class="view<?=$col['view_type']?>"><?if($col['room_photo']){?><a href="/upload/room/<?=$col['room_photo']?>"><?}?><i class="fas fa-map-marker-alt" title="Venue"></i> <?=$col['room_info']?><?if($col['room_photo']){?></a><?}?></li>

			<p class="btn btnDel"><a onclick="javascript:favor_del(this,'<?=$col['sid']?>','<?=$deviceid?>','<?=$code?>','session')"><i class="far fa-trash-alt" title="Venue"></i></a></p>
		</ul>

		<div id="session<?=$col['sid']?>_sub" class="toggleCon" <?if($glance){?>style="display:block"<?}?>>


			<?if($setting_col['program_view_type']=="2"){
				$info_chk=true;
			?>
			
				<?
					$faculty_session_sid=$col['sid'];
					$faculty_info="chair";
					$faculty_view_type=2;
					include "./speaker.php";
					$faculty_info="panel";
					include "./speaker.php";
				?>
		
				<?if($setting_col['etc_faculty']=="Y"){
					if($col['etc_faculty']){?>
					<?if($info_chk){
						$info_chk=false;
					?>
						<dl class="info">
					<?}?>
					<dt class="chairs"><?=$col['etc_faculty']?></dt>
				<?}}?>

				<?
					$faculty_info="discusser";
					include "./speaker.php";
				?>
			<?if(!$info_chk){?>
				</dl>
			<?}?>
					
			<?}?>
			


			<?while(is_array($subcol = mysqli_fetch_array($subresult))){
				if($subcol['sub_session']=="1" || $subcol['sub_session']=="2"){?>
					<?if($setting_col['sub_theme_type']=="1"){?>
					<dl class="descript<?if($subcol['sub_session']=="2"){?> type2<?}?>">
						<dt><?=$subcol['title']?></dt>
					</dl>
					<?}else if($setting_col['sub_theme_type']=="2"){?>

					<dl class="info">
						<dt class="descript">Session Description</dt>
						<dd><?=$subcol['title']?></dd>
					</dl>
					<?}?>
					
				<?}else{
			?>

				<ul class="sessionList">
				<li><a href="javascript:move_page('./view.php?sid=<?=$subcol['sid']?>&toptext=<?=$toptext?>&code=<?=$code?>&deviceid=<?=$deviceid?>&tab=<?=$tab?>&glanceYN=<?=$glanceYN?>','session<?=$col['sid']?>')"><i class="fas fa-angle-right"></i>
				<?if($setting_col['abs_sid']=="Y" && $subcol['abs_sid']){?>
					<span class="sessionCode"><?=$subcol['abs_sid']?></span>
				<?}?>
				<?if($setting_col['abs_no']=="Y" && $subcol['abs_no']){?>
					<?
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

				<?if($subcol['time']){?>
					<span class="speaker"><?=$subcol['time']?></span>

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

				</a></li>
				</ul>
			<?}}?>
			
		</div>

	<?}else if($col['fv_type'] == 'B'){ $cnt3++;?>
	<a href="javascript:move_page('./view.php?sid=<?=$col['link_sid']?>&toptext=<?=$toptext?>&code=<?=$code?>&deviceid=<?=$deviceid?>&tab=<?=$tab?>&glanceYN=<?=$glanceYN?>','session<?=$col['sid']?>')"><i class="fas fa-angle-right"></i>
		<?if($col['abs_sid']){?>
			<span class="sessionCode2"><?=$col['abs_sid']?></span>
		<?}?>
		<?if($col['abs_no']){?>
			<span class="sessionCode2"><?=$col['abs_no']?></span>
		<?}?>

		<?if($col['theme'] && $setting_col['theme']=="Y"){?>
			

			<?if($setting_col['session_title_style']=='1'){?>
				<span class="sessionTit"><?=$col['theme']?>

				<?if($col['sub_theme'] && $setting_col['sub_theme']=="Y"){?>
				<font><?=$col['sub_theme']?></font>
				<?}?></span>

			<?}else if($setting_col['session_title_style']=='2'){
			
			$session_title_txt = $setting_col['session_title_txt'];
			$session_title_txt = str_replace("{theme}", $col['theme'], $session_title_txt);
			$session_title_txt = str_replace("{sub_theme}", $col['sub_theme'], $session_title_txt);

			?>
			<span class="sessionTit2"><?=$session_title_txt?></span>
			
				
			<?}?>
		<?}?>
		<?

			$faculty_session_sid=$col['link_sid'];
			$faculty_info="speaker";
			$faculty_view_type=3;
			$session_sid=$col['link_sid'];

			include "./speaker.php";
			?>

			<?if($setting_col['etc_faculty']=="Y"){
				if($col['etc_faculty']){?>
				<span class="chairperson"><?=$col['etc_faculty']?></span>
			<?}}?>
			
			

			
		</p>

		</a>
		<ul class="sessionInfo">

			<li><i class="far fa-clock" title="Time"></i> 

			<li><?=$agenda_array[$col['tab']]?>
			<?=$col['time_info']?>
			</li>

			<li class="view<?=$col['view_type']?>"><?if($col['room_photo']){?><a href="/upload/room/<?=$col['room_photo']?>"><?}?><i class="fas fa-map-marker-alt" title="Venue"></i> <?=$col['room_info']?><?if($col['room_photo']){?></a><?}?></li>

			<p class="btn btnDel"><a onclick="javascript:favor_del(this,'<?=$col['link_sid']?>','<?=$deviceid?>','<?=$code?>','session')"><i class="far fa-trash-alt" title="Venue"></i></a></p>
		</ul>
	
	

	<?}?>

</div>
<?
}





?>

<script>

	function favor_del(obj, sid, deviceid, code, type) {

		if(confirm("<?=$string['confirm_delete']?>")) {
			
			$.ajax({
				type:"POST",
				url:"./favor_del.php",
				data:"sid="+sid+"&deviceid="+deviceid+"&code="+code+"&type="+type,
				success:function(msg){
					$(obj).closest("div.session").remove();
				}
			});
		}
		
	}

	function move_page(url, id) {
		if(id) {
			location.replace("#"+id);
		}
		location.href = url;
	}

</script>

<style>
div.session {position:relative}
div.session p.btnDel {z-index: 50;position: absolute;right: 0;bottom: 1px;}
div.session p.btnDel a {padding: 15px;font-size: 16px;color:#313238;border-color:#fff;background-color:#fff;}
</style>