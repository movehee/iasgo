<?
$cnt3=0;
$cnt2=0;
$btime="";
$btab="";
while(is_array($col = mysqli_fetch_array($result))){
	if(!$sub_view){
	$temp_result = mysqli_query($conn, "select count(*) cnt from session_favor_tbl WHERE session_sid='".$col['sid']."' and deviceid='".$deviceid."'");
	$temp_row = mysqli_fetch_array($temp_result);
	$fav = $temp_row['cnt'];

	$cnt3++;
	if($cnt3==1 && ($tab=="-2" || $tab=="-3" || $tab=="-5")){
	?>
	<!--
		<h3 class="subTitBg01">Program</h3>
	-->
	<?
	}
	if($setting_col['time_type']=="1" && !$glance){
		if($btab == $col['tab'] && $btime == $col['time']){
			
		}else {
			//$temp_result = mysqli_query($conn, "select time from session_time_tbl WHERE sid='".$col['time']."'");
			//$temp_row = mysqli_fetch_array($temp_result);
		?>
		<h3 class="dayInfo">
		<?if($tab=="-2" || $tab=="-3" || $tab=="-4" || $tab=="-5"){
			$temp_result = mysqli_query($conn, "select name from agenda_tbl WHERE sid='".$col['tab']."'");
			$temp_row = mysqli_fetch_array($temp_result);
		?>
			<?=$temp_row['name']?>
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
		<?if($col['language'] =="1"){?>
			<span class="bullet eng">E</span>
		<?}else if($col['language'] =="2"){?>
			<span class="bullet kor">K</span>
		<?}?>
		<?if($setting_col['category_view']=="1" || $setting_col['category_view']=="2"){?>

		<?if($temp_row['color'] !="#" && $setting_col['category_text_font']!="3"){?>
			<span class="bullet" style="background-color:<?=$temp_row['color']?>"><?=$temp_row['abb']?></span>
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
		<span class="sessionTit"><?=$col['theme']?>
		<?if($col['sub_theme'] && $setting_col['sub_theme']=="Y"){?>
		<font style="font-weight:500;"><?=$col['sub_theme']?></font>
		<?}?></span>
		<?}?>
		
		<?if($setting_col['program_view_type']=="1"){?>
		
			<?if($setting_col['chair']){?>
				<?if($setting_col['faculty_type']==1){?>
				<?
				$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='chair' and a.session_sid='".$col['sid']."' order by a.sid asc";
				$faculty_result=mysqli_query($conn, $faculty_query);
				$chair="";
				$i = 0;
				while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
					if($i!=0){
						$chair = $chair . ", ";
					}
					if($setting_col['faculty_style']==1){
						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= " (".$faculty_d['office'].")";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= " (".$faculty_d['office_en'].")";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= " (".$faculty_d['office_en'].")";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= " (".$faculty_d['office'].")";
							}
						}
					}else if($setting_col['faculty_style']==2){

						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
							}
						}

					}
					$i++;
				}
				if($chair){?>
					<span class="chairperson"><?=$setting_col['chair']?> : <?=$chair?></span>	
				<?}}else if($col['chair']){?>
					<span class="chairperson"><?=$setting_col['chair']?> : <?=$col['chair']?></span>

				<?}?>
				

				
			<?}?>


			<?if($setting_col['panel']){?>
				<?if($setting_col['faculty_type']==1){?>
				<?
				$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='panel' and a.session_sid='".$col['sid']."' order by a.sid asc";
				$faculty_result=mysqli_query($conn, $faculty_query);
				$chair="";
				$i = 0;
				while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
					if($i!=0){
						$chair = $chair . ", ";
					}

					if($setting_col['faculty_style']==1){
						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= " (".$faculty_d['office'].")";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= " (".$faculty_d['office_en'].")";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= " (".$faculty_d['office_en'].")";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= " (".$faculty_d['office'].")";
							}
						}
					}else if($setting_col['faculty_style']==2){

						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
							}
						}

					}
					$i++;
				}
				if($chair){?>
					<span class="chairperson"><?=$setting_col['panel']?> : <?=$chair?></span>	
				<?}}else if($col['chair']){?>
					<span class="chairperson"><?=$setting_col['panel']?> : <?=$col['panel']?></span>

				<?}?>
			<?}?>

			<?if($setting_col['etc_faculty']=="Y"){
				if($col['etc_faculty']){?>
				<span class="chairperson"><?=$col['etc_faculty']?></span>
			<?}}?>


			<?if($setting_col['discusser']){?>
			<?if($setting_col['faculty_type']==1){?>
				<?
				$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='discusser' and a.session_sid='".$col['sid']."' order by a.sid asc";
				$faculty_result=mysqli_query($conn, $faculty_query);
				$chair="";
				$i = 0;
				while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
					if($i!=0){
						$chair = $chair . ", ";
					}

					if($setting_col['faculty_style']==1){
						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= " (".$faculty_d['office'].")";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= " (".$faculty_d['office_en'].")";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= " (".$faculty_d['office_en'].")";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= " (".$faculty_d['office'].")";
							}
						}
					}else if($setting_col['faculty_style']==2){

						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
							}
						}

					}
					$i++;
				}
				if($chair){?>
					<span class="chairperson"><?=$setting_col['discusser']?> : <?=$chair?></span>	
				<?}}else if($col['chair']){?>
					<span class="chairperson"><?=$setting_col['discusser']?> : <?=$col['discusser']?></span>

				<?}?>
			<?}?>
		<?}?>


	</a>
	</p>
	<ul class="sessionInfo">
		<li>
		<a href="javascript:favor('<?=$col['sid']?>','<?=$deviceid?>','<?=$col['time_info']?>','<?=strip_tags($col['theme'])?>','<?=$col['tab']?>','<?=$tab?>')" title="즐겨찾기 추가됨" id="favor<?=$col['sid']?>" class="favorTxt <?if($fav){echo "on";}?>" ><i class="far fa-star"></i></a>

		</li>
		<li><i class="far fa-clock" title="Time"></i> <?=$col['time_info']?></li>
		<li class="border"><?if($col['room_photo']){?><a href="/upload/room/<?=$col['room_photo']?>"><?}?><i class="far fa-map" title="Venue"></i> <?=$col['room_info']?><?if($col['room_photo']){?></a><?}?></li>
	</ul>
	<div id="session<?=$col['sid']?>_sub" class="toggleCon" <?if($glance){?>style="display:block"<?}?>>


		<?if($setting_col['program_view_type']=="2"){
			$info_chk=true;
		?>
		

			<?if($setting_col['chair']){?>
				<?if($setting_col['faculty_type']==1){?>
				<?
				$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='chair' and a.session_sid='".$col['sid']."' order by a.sid asc";
				$faculty_result=mysqli_query($conn, $faculty_query);
				$chair="";
				$i = 0;
				while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
					if($i!=0){
						$chair = $chair . ", ";
					}
					if($setting_col['faculty_style']==1){
						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= " (".$faculty_d['office'].")";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= " (".$faculty_d['office_en'].")";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= " (".$faculty_d['office_en'].")";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= " (".$faculty_d['office'].")";
							}
						}
					}else if($setting_col['faculty_style']==2){

						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
							}
						}

					}
					$i++;
				}
				if($chair){
					$info_chk=false;
					?>
				<dl class="info">
					<dt class="chairs"><?=$setting_col['chair']?></dt>
					<dd><?=$chair?></dd>
				<?}}else if($col['chair']){
					$info_chk=false;
				?>
				<dl class="info">
					<dt class="chairs"><?=$setting_col['chair']?></dt>
					<dd><?=$col['chair']?></dd>
				<?}?>
			<?}?>




			<?if($setting_col['panel']){?>
				<?if($setting_col['faculty_type']==1){?>
				<?
				$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='panel' and a.session_sid='".$col['sid']."' order by a.sid asc";
				$faculty_result=mysqli_query($conn, $faculty_query);
				$chair="";
				$i = 0;
				while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
					if($i!=0){
						$chair = $chair . ", ";
					}

					if($setting_col['faculty_style']==1){
						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= " (".$faculty_d['office'].")";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= " (".$faculty_d['office_en'].")";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= " (".$faculty_d['office_en'].")";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= " (".$faculty_d['office'].")";
							}
						}
					}else if($setting_col['faculty_style']==2){

						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
							}
						}

					}
					$i++;
				}
				if($chair){?>
					<?if($info_chk){
						$info_chk=false;
					?>
						<dl class="info">
					<?}?>
					<dt class="chairs"><?=$setting_col['panel']?></dt>
					<dd><?=$chair?></dd>
				<?}}else if($col['panel']){?>
					<?if($info_chk){
						$info_chk=false;
					?>
						<dl class="info">
					<?}?>
					<dt class="chairs"><?=$setting_col['panel']?></dt>
					<dd><?=$col['panel']?></dd>
				<?}?>
			<?}?>

			<?if($setting_col['etc_faculty']=="Y"){
				if($col['etc_faculty']){?>
				<?if($info_chk){
					$info_chk=false;
				?>
					<dl class="info">
				<?}?>
				<dt class="chairs"><?=$col['etc_faculty']?></dt>
			<?}}?>


			<?if($setting_col['discusser']){?>
			<?if($setting_col['faculty_type']==1){?>
				<?
				$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='discusser' and a.session_sid='".$col['sid']."' order by a.sid asc";
				$faculty_result=mysqli_query($conn, $faculty_query);
				$chair="";
				$i = 0;
				while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
					if($i!=0){
						$chair = $chair . ", ";
					}

					if($setting_col['faculty_style']==1){
						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= " (".$faculty_d['office'].")";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= " (".$faculty_d['office_en'].")";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= " (".$faculty_d['office_en'].")";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= " (".$faculty_d['office'].")";
							}
						}
					}else if($setting_col['faculty_style']==2){

						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
							}
						}

					}
					$i++;
				}
				if($chair){?>
					<?if($info_chk){
						$info_chk=false;
					?>
						<dl class="info">
					<?}?>
					<dt class="chairs"><?=$setting_col['discusser']?></dt>
					<dd><?=$chair?></dd>
					
				<?}}else if($col['discusser']){?>
					<?if($info_chk){
						$info_chk=false;
					?>
						<dl class="info">
					<?}?>
					<dt class="chairs"><?=$setting_col['discusser']?></dt>
					<dd><?=$col['discusser']?></dd>

				<?}?>
			<?}?>
		<?if(!$info_chk){?>
			</dl>
		<?}?>
				
		<?}?>


		<?while(is_array($subcol = mysqli_fetch_array($subresult))){
			if($subcol['sub_session']=="1" || $subcol['sub_session']=="2"){?>
				<?if($setting_col['sub_theme_type']=="1"){?>
				<dl class="descript"<?if($subcol['sub_session']=="2"){?>style="background-color:#eeeeee;"<?}?>>
					<dt <?if($subcol['sub_session']=="2"){?>style="color:#282828"<?}?>><?=$subcol['title']?></dt>
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
				<span class="sessionCode2"><?=$subcol['abs_no']?></span>
			<?}?>

			<?if($setting_col['title']=="Y" && $subcol['title']){?>

				<span class="sessionTit"><?=$subcol['title']?></span>
			<?}?>

			<?if($subcol['time']){?>
				<span class="speaker"><?=$subcol['time']?></span>

			<?}?>

			<?if($setting_col['speaker']){?>
			<?if($setting_col['faculty_type']==1){?>
				<?
				$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='speaker' and a.session_sid='".$subcol['sid']."' order by a.sid asc";
				$faculty_result=mysqli_query($conn, $faculty_query);
				$chair="";
				$i = 0;
				while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
					if($i!=0){
						$chair = $chair . ", ";
					}

					if($setting_col['faculty_style']==1){
						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= " (".$faculty_d['office'].")";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= " (".$faculty_d['office_en'].")";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= " (".$faculty_d['office_en'].")";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= " (".$faculty_d['office'].")";
							}
						}
					}else if($setting_col['faculty_style']==2){

						if($setting_col['faculty_style2']==1){
							$chair .= $faculty_d['name'];
							$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==2){
							$chair .= $faculty_d['name_en'];
							$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
						}else if($setting_col['faculty_style2']==3){
							if($col['language']==1){
								$chair .= $faculty_d['name_en'];
								$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
							}else{
								$chair .= $faculty_d['name'];
								$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
							}
						}

					}
					$i++;
				}
				if($chair){?>
					<span class="speaker"><?=$setting_col['speaker']?> : <?=$chair?></span>	
				<?}}else if($subcol['speaker']){?>
					<span class="speaker"><?=$setting_col['speaker']?> : <?=$subcol['speaker']?></span>

				<?}?>
			<?}?>

			<?if($setting_col['etc_speaker']){?>
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
<?
if($tab=="-3" || $tab=="-5" || $tab=="-6"){
	if($tab=="-3"){
		if($search) {
			if($setting_col['faculty_type']==1){
				$query = "select a.* from session_tbl a, session_faculty_tbl b, faculty_tbl c  where a.sid=b.session_sid and b.faculty_sid=c.sid and a.code='".$code."' and a.type='2' ";
				$query .= " and (a.abs_no like '%".$search."%' or a.abs_sid like '".$search."' or c.name like '%".$search."%' or a.etc_speaker like '%".$search."%' or a.title like '%".$search."%')";
				$query .= "group by a.sid order by a.tab asc, a.orderby asc";

			}else{
				$query = "select a.* from session_tbl a where a.code='".$code."' and a.type='2' ";
				$query .= " and (a.abs_no like '%".$search."%' or a.abs_sid like '%".$search."%' or a.etc_speaker like '%".$search."%' or a.speaker like '%".$search."%' or a.title like '%".$search."%') order by a.tab asc, a.orderby asc";
			
			}
			$result = mysqli_query($conn, $query);
		}
	}else if ($tab=="-5"){
		$query = "select a.* from session_tbl a, session_faculty_tbl b where a.sid=b.session_sid and a.code='".$code."' and a.type='2' and a.viewYN='Y' ";
		$query .= " and b.faculty_sid = '".$sid."'";
		$query .= " order by a.tab asc, a.orderby asc";
		$result = mysqli_query($conn, $query);
		//echo $query;
	}else if ($tab=="-6"){
		$query = "select a.* from session_tbl a, session_memo_tbl b where a.sid=b.session_sid and a.code='".$code."' and a.type='2' and a.viewYN='Y' and b.deviceid='".$deviceid."'";
		$query .= " order by a.tab asc, a.orderby asc";
		$result = mysqli_query($conn, $query);
		//echo $query;
	}

?>
<div class="session" id="session<?=$col['sid']?>">




<ul class="sessionList <?if($tab=="-6"){?> memo<?}?>">
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
	<?if($setting_col['abs_no']=="Y" && $subcol['abs_no']){?>
		<span class="sessionCode2"><?=$subcol['abs_no']?></span>
	<?}?>

	<?if($setting_col['title']=="Y" && $subcol['title']){?>
	
		<span class="sessionTit"><?=$subcol['title']?></span>
	<?}?>

	<?if($subcol['time']){?>
		<span class="speaker"><?=$subcol['time']?></span>

	<?}?>

	<?if($setting_col['speaker']){?>
	<?if($setting_col['faculty_type']==1){?>
		<?
		$faculty_query="SELECT b.name,b.office,b.name_en,b.office_en FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='speaker' and a.session_sid='".$subcol['sid']."' order by a.sid asc";
		$faculty_result=mysqli_query($conn, $faculty_query);
		$chair="";
		$i = 0;
		while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
			if($i!=0){
				$chair = $chair . ", ";
			}
			if($setting_col['faculty_style']==1){
				if($setting_col['faculty_style2']==1){
					$chair .= $faculty_d['name'];
					$chair .= " (".$faculty_d['office'].")";
				}else if($setting_col['faculty_style2']==2){
					$chair .= $faculty_d['name_en'];
					$chair .= " (".$faculty_d['office_en'].")";
				}else if($setting_col['faculty_style2']==3){

					$col_temp_query = "select * from session_tbl WHERE sid = '".$subcol['link_session']."'";
					$col_temp_result = mysqli_query($conn, $col_temp_query);
					$col_temp_col = mysqli_fetch_array($col_temp_result);
					if($col_temp_col['language']==1){
						$chair .= $faculty_d['name_en'];
						$chair .= " (".$faculty_d['office_en'].")";
					}else{
						$chair .= $faculty_d['name'];
						$chair .= " (".$faculty_d['office'].")";
					}
				}
			}else if($setting_col['faculty_style']==2){

				if($setting_col['faculty_style2']==1){
					$chair .= $faculty_d['name'];
					$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
				}else if($setting_col['faculty_style2']==2){
					$chair .= $faculty_d['name_en'];
					$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
				}else if($setting_col['faculty_style2']==3){
					$col_temp_query = "select * from session_tbl WHERE sid = '".$subcol['link_session']."'";
					$col_temp_result = mysqli_query($conn, $col_temp_query);
					$col_temp_col = mysqli_fetch_array($col_temp_result);

					if($col_temp_col['language']==1){
						$chair .= $faculty_d['name_en'];
						$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
					}else{
						$chair .= $faculty_d['name'];
						$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
					}
				}

			}

			$i++;
		}
		if($chair){?>
			<span class="speaker"><?=$setting_col['speaker']?> : <?=$chair?></span>	
		<?}}else if($subcol['speaker']){?>
			<span class="speaker"><?=$setting_col['speaker']?> : <?=$subcol['speaker']?></span>

		<?}?>
	<?}?>

	<?if($setting_col['etc_speaker']){?>
		<?if($subcol['etc_speaker']){?>
			<span class="etc_speaker"><?=$subcol['etc_speaker']?></span>

		<?}?>

	<?}?>

	
	<?if($tab=="-6"){?>
		<a onclick="javascript:memo_click2('<?=$subcol['sid']?>','<?=$deviceid?>')" class="memo" id="memobtn"><i class="fas fa-pen-square"></i></a>
	<?}?>

	</a></li>
<?}?>

</ul>
</div>
<?}?>



<script>

	var alarm_sid;
	var alarm_tab;
	var alarm_time;
	var alarm_subject;

	function memo_click2(sid,deviceid)
	{

		$.ajax({
			type:"POST",
			url:"./get_memo.php",
			data:"session_sid="+sid+"&deviceid="+deviceid,
			success:function(msg){
				document.getElementById("memo_txt").innerHTML = msg;
			}
		});

	}


	function add_alarm() {
		
		location.href = "add_alarm.php?sid="+alarm_sid+"&tab="+alarm_tab+"&time="+alarm_time+"&subject="+encodeURIComponent(alarm_subject);
		$('#sessionAlarm').hide();
	}
	function hide_alarm() {
		$('#sessionAlarm').hide();
	}

	function favor(sid,deviceid,time,subject,tab,tab2){
		alarm_sid = sid;
		alarm_time = time;
		alarm_subject = subject;
		alarm_tab = tab;
		$.ajax({
			type:"POST",
			url:"./favor.php",
			data:"session_sid="+sid+"&deviceid="+deviceid,
			success:function(msg){
				//lert(msg);
				if(msg == "Y"){
					$('#favor'+sid).addClass("on");
					$('#sessionAlarm').show();
				}else{
					$('#favor'+sid).removeClass("on");
					$('#sessionAlarm').hide();
					if(tab2=="-2"){
						location.reload(true);
						//document.getElementById("session"+sid).style.display ="none";
					}
					if($("#set_alarm").val()=="Y"){
						//location.href = "remove_alarm.php?sid="+alarm_sid;
					}
					/*
					if ($("#sessionAlarm")>0 ) {
						alert(alarm_sid);
						location.href = "remove_alarm.php?sid="+alarm_sid;
					}else{
						alert("234");
					}*/

					//location.href = "remove_alarm.php?sid="+alarm_sid;
				}
				
			}
		});
	}

window.onload = function() {
		var array = document.location.href.split('#');
		
		document.getElementById(array[1]+"_sub").style.display ="block";
	}

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