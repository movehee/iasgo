<?if($setting_col[$faculty_info] || $faculty_info=="speaker"){?>
	<?if($setting_col['faculty_type']==1){?>
	<?
	$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='".$faculty_info."' and a.session_sid='".$faculty_session_sid."' order by a.sid asc";
	$faculty_result=mysqli_query($conn, $faculty_query);
	$chair="";
	$i = 0;
	while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
		$speaker_sid = $faculty_d['sid'];
		if($i!=0){

			if($faculty_info == "speaker" && $setting_col['faculty_style_speaker_gubun']) {
				$chair = $chair . $setting_col['faculty_style_speaker_gubun'];
			} else {
				$chair = $chair . ", ";
			}
		}

		if($faculty_info=="speaker"){
			$faculty_style = $setting_col['faculty_style_speaker'];
		}else{
			$faculty_style = $setting_col['faculty_style_chair'];
		}


		if($setting_col['faculty_style2']==1){

			$faculty_style = str_replace("{이름}", $faculty_d['name'], $faculty_style);
			$faculty_style = str_replace("{소속}", $faculty_d['office'], $faculty_style);
			$faculty_style = str_replace("{국가}", $faculty_d['country'], $faculty_style);
		}else if($setting_col['faculty_style2']==2){
			$faculty_style = str_replace("{이름}", $faculty_d['name_en'], $faculty_style);
			$faculty_style = str_replace("{소속}", $faculty_d['office_en'], $faculty_style);
			
			//예외처리 나중에는 외국 한국 나눠서 설정하도록 바꾸자
			if(!$faculty_d['country']) {
				$faculty_style = str_replace(", {국가}", $faculty_d['country'], $faculty_style);
			}
			else {
				$faculty_style = str_replace("{국가}", $faculty_d['country'], $faculty_style);
			}

			
		}else if($setting_col['faculty_style2']==3){
			if($col['language']==1){
				$faculty_style = str_replace("{이름}", $faculty_d['name_en'], $faculty_style);
				$faculty_style = str_replace("{소속}", $faculty_d['office_en'], $faculty_style);
				$faculty_style = str_replace("{국가}", $faculty_d['country'], $faculty_style);
			}else{
				$faculty_style = str_replace("{이름}", $faculty_d['name'], $faculty_style);
				$faculty_style = str_replace("{소속}", $faculty_d['office'], $faculty_style);
				$faculty_style = str_replace("{국가}", $faculty_d['country'], $faculty_style);
			}
		}
		$chair .= $faculty_style;

		

		/*

		if($faculty_style==1){
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
		}else if($faculty_style==2){

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

		}else if($faculty_style==3){

			if($setting_col['faculty_style2']==1){
				$chair .= $faculty_d['name'];
				$chair .= "(".$faculty_d['office'].", ".$faculty_d['country'].")";
			}else if($setting_col['faculty_style2']==2){
				$chair .= $faculty_d['name_en'];
				$chair .= "(".$faculty_d['office_en'].", ".$faculty_d['country'].")";
			}else if($setting_col['faculty_style2']==3){
				if($col['language']==1){
					$chair .= $faculty_d['name_en'];
					$chair .= "(".$faculty_d['office_en'].", ".$faculty_d['country'].")";
				}else{
					$chair .= $faculty_d['name'];
					$chair .= "(".$faculty_d['office'].", ".$faculty_d['country'].")";
				}
			}

		}else if($faculty_style==4){

			if($setting_col['faculty_style2']==1){
				$chair .= $faculty_d['name'];
				$chair .= " / ".$faculty_d['office'];
			}else if($setting_col['faculty_style2']==2){
				$chair .= $faculty_d['name_en'];
				$chair .= " / ".$faculty_d['office_en'];
			}else if($setting_col['faculty_style2']==3){
				if($col['language']==1){
					$chair .= $faculty_d['name_en'];
					$chair .= " / ".$faculty_d['office_en'];
				}else{
					$chair .= $faculty_d['name'];
					$chair .= " / ".$faculty_d['office'];
				}
			}

		}else if($faculty_style==5){

			if($setting_col['faculty_style2']==1){
				$chair .= $faculty_d['name'];
			}else if($setting_col['faculty_style2']==2){
				$chair .= $faculty_d['name_en'];
			}else if($setting_col['faculty_style2']==3){
				if($col['language']==1){
					$chair .= $faculty_d['name_en'];
				}else{
					$chair .= $faculty_d['name'];
				}
			}

		}
		*/
		$i++;
	}

	
	
	if($faculty_view_type==1){
		if($chair){
			
			
			$faculty_txt1="";

			if($code == "ksc2019" && $faculty_info=="panel") {
				if(in_array($col['sid'], $examiner_session)) {
					$faculty_txt1 = "Examiner";
				}
			}

			if(!$faculty_txt1) {
				$faculty_txt1 = $setting_col[$faculty_info];
				if($i>1 && $faculty_info=="chair") { $faculty_txt1 = $faculty_txt1.$setting_col['chair2']; }
			}


			
			
			?>
			<span class="chairperson"><b><?=$faculty_txt1?></b> : <?=$chair?></span>	
		<?}
	}else if($faculty_view_type==2){
		if($chair){?>

		<?if($info_chk){
			$info_chk=false;
		?>
			<dl class="info">
		<?}?>
			<dt class="chairs"><b><?=$setting_col[$faculty_info]?></b></dt>
			<dd><?=$chair?></dd>
		<?}

	}else if($faculty_view_type==3){
		if($chair){?>
			<span class="speaker"><?if($setting_col[$faculty_info]){?><b><?=$setting_col[$faculty_info]?><?if($i>1 && $faculty_info=="chair"){?><?=$setting_col['chair2']?><?}?></b> : <?}?><?=$chair?></span>	
		<?}
	}
	
	}else if($col[$faculty_info]){
		if($faculty_view_type==1){?>
		<span class="chairperson"><b><?=$setting_col[$faculty_info]?></b> : <?=$col[$faculty_info]?></span>

	<?}else if($faculty_view_type==2){
			$info_chk=false;?>
			<dl class="info">
				<dt class="chairs"><b><?=$setting_col[$faculty_info]?></b></dt>
				<dd><?=$col[$faculty_info]?></dd>

		<?}
	}else if($faculty_view_type==3 && $subcol[$faculty_info]){?>
		<span class="speaker"><?if($setting_col[$faculty_info]){?><b><?=$setting_col[$faculty_info]?></b> : <?}?><?=$subcol[$faculty_info]?></span>
	<?}

	
}?>