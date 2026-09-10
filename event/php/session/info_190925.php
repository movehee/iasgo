<?
$cnt3=0;
$cnt2=0;
$cnt_f=0;
$btime="";
$btab="";
while(is_array($col = mysqli_fetch_array($result))){

	$temp_result = mysqli_query($conn, "select count(*) cnt from session_favor_tbl WHERE session_sid='".$col['sid']."' and deviceid='".$deviceid."'");
	$temp_row = mysqli_fetch_array($temp_result);
	$fav = $temp_row['cnt'];
	if(!$sub_view){
	

	$cnt3++;
	if($cnt3==1 && ($tab=="-2" || $tab=="-3" || $tab=="-5")){
		if($tab=="-3" && $result->num_rows){
	?>
		<h3 class="dayInfo2">Session</h3>
	<?
		}
	}
	if($setting_col['time_type']=="1" && !$glance){
		if($btab == $col['tab'] && $btime == $col['time']){
			
		}else {
			//$temp_result = mysqli_query($conn, "select time from session_time_tbl WHERE sid='".$col['time']."'");
			//$temp_row = mysqli_fetch_array($temp_result);
		?>
		<h3 class="dayInfo">
		<?if($tab<-1){?>
			<?=$agenda_array[$col['tab']]?>
		<?}?>
			<?=$col['time_info']?>
		</h3>
			
		<?}
		$btab = $col['tab'];
		$btime = $col['time'];
	}?>
	<?}?>

<div class="session" id="session<?=$col['sid']?>">


	<p class="sessionBrief">
	<?
		
		$subquery = "SELECT * FROM session_tbl ";	
		$subquery .= "  WHERE type = '2' ";
		if($col['link_session']){
			$subquery .= " and link_session = '".$col['link_session']."' ";
		}else{
			$subquery .= " and link_session = '".$col['sid']."' ";
		}

		if($tab=="-7"){
			$subquery .= " and (abs_no not in('') or lecture_file not in(''))";
		}
		$subquery .= " order by orderby asc ";		
		$subresult=mysqli_query($conn, $subquery);

		$totalquery = str_replace("SELECT * FROM", "SELECT count(*) cnt FROM", $subquery); 
		$totalresult=mysqli_query($conn, $totalquery);
		$totalcol = mysqli_fetch_array($totalresult);

	?>	
	
	<a <?if($totalcol['cnt']>0){?> href="#" class="trigger"<?}?>><?if($totalcol['cnt']>0){?> <i class="fas fa-angle-down"></i><?}?>
	

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
	<?if($tab != "-7"){?>
		<li>
		<a href="javascript:favor('<?=$col['sid']?>','<?=$deviceid?>','<?=$col['time_info']?>','<?=strip_tags($col['theme'])?>','<?=$col['tab']?>','<?=$tab?>')" title="즐겨찾기 추가됨" id="favor<?=$col['sid']?>" class="favorTxt <?if($fav){echo "on";}?>" ><i class="far fa-star"></i></a>

		</li>
		<li><i class="far fa-clock" title="Time"></i> <?if($tab<-1){?>
			<?=$agenda_array[$col['tab']]?>
		<?}?> <?=$col['time_info']?></li>
		<?if($col['room_view']=="Y"){?>
		<li class="view<?=$col['view_type']?>"><?if($col['room_photo']){?><a href="/upload/room/<?=$col['room_photo']?>"><?}?><i class="fas fa-map-marker-alt" title="Venue"></i> <?=$col['room_info']?><?if($col['room_photo']){?></a><?}?></li><br/>
		<?}?>
		<?}?>

		<?if($setting_col['session_evaluation']=='Y' && $col['sc_viewYN']=='Y'){?>
		<li style="margin-top:10px; padding-left:0;clear: both;"><a class="btnEvaluation2" style="margin-top:-15px" onclick="javascript:session_evaluation('<?=$col['sid']?>','<?=$deviceid?>','<?=$code?>')"><i class="fas fa-star"></i><?=$setting_col['session_evaluation_txt']?></a></li>
	
		<?}?>

		<?if($setting_col['session_question']=="1" && $col['qna_viewYN']=='Y'){?>
		<li style="margin-top:10px;float:right;"><a href="app_question.php?sid=<?=$col['sid']?>" class="btnQuestion" style="margin-top:-15px;<?if($code=='kses190818'){?>font-size:19px !important;<?}?>"><?=$setting_col['question_icon_txt']?></a></li>
	
		<?}?>




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
</div>


<?}?>


<script>



	function move_page(url, id) {
		if(id) {
			location.replace("#"+id);
		}
		location.href = url;
	}

	function move(id) {
		if(id) {
			location.replace("#"+id);
		}
	}
</script>