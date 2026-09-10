<?
	include_once $_SERVER['DOCUMENT_ROOT']."lib.php";
	procAdminLoginChk();
	
	$program_day=$ev_date;
	
	$file = fopen($_SERVER['DOCUMENT_ROOT']."../webinar/load/days/program.day".$program_day.".php","w");

	$code = "webinar";
	$ev_date = number_format($ev_date);
	$query = "select tr,tr_class from workshop_schedule_tbl where code='$code' and bsid='$ev_date' group by tr order by tr asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());


	$content = "";
	while(is_array($tr=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		
		
		if($tr['tr_class']){
			$content .= "<tr class='".$tr['tr_class']."'>";
		}else{
			$content .= "<tr>";
		}

		//$query2 = "select * from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and tr='$tr[tr]' order by td asc";
		$query2 = "select t1.*,t2.difficulty,t2.lang,t2.room,t2.logo_file,t2.logo_link,t2.logo_link_target  ";
		$query2 .= " from workshop_schedule_tbl as t1 left outer join workshop_session_tbl as t2 on t1.code2=t2.sid where t1.code='$code' and t1.tr='".$tr['tr']."' and t1.bsid='$ev_date' order by t1.td asc";
		$result2=$conn->query($query2);
		if(DB::isError($result2)) die($result2->getMessage());
		$num=1;
		$tr_row = 1;
		while(is_array($td=$result2->fetchRow(DB_FETCHMODE_ASSOC))){
			unset($bottom_top_chk);
			unset($right_right_chk);
			unset($session_code1);
			unset($session_room);
			unset($session_lang);
			if($program_day=='2'){
				//$style_add = "font-size:11px;";
			}else{
				//$style_add = "font-size:14px;";
			}//font-size:14px;
			$style_add = "font-size:12px;";//margin: 0px !important;padding: 0px !important;
			if(!$td['content_position']) $td['content_position'] = "center";
			if($td['bg_color']) $style_add .= "background:".$td['bg_color'].";";
			if($td['font_color']) $style_add .= "color:".$td['font_color'].";";
			if($td['w_size']) $style_add .= "width:".$td['w_size']."px !important;";
			if($td['h_size']) $style_add .= "height:".$td['h_size']."px !important;";
			//if($td['bold']=="Y") $style_add .= "font-weight:bold !important;";
			if($td['bold']=="Y") $style_add .= "font-family:Roboto-Bold, NotoSansKR Bold, sans-serif !important;";
			
			if($td['italic']=="Y") $style_add .= "font-style:italic !important;";
			if($td['content_position']) $style_add .= "text-align:".$td['content_position']." !important;";
			if($td['border_top']=='Y') $style_add .= "border-top:1px solid #cccccc !important;";
			if($td['border_bottom']=='Y') $style_add .= "border-bottom:1px solid #cccccc !important;";
			if($td['border_left']=='Y'){
				$style_add .= "border-left:1px solid #cccccc !important;";
			}else{
				$style_add .= "border-left:0px !important;";
			}
			if($td['border_right']=='Y') $style_add .= "border-right:1px solid #cccccc !important;";

			$detail_cnt=0;
			// if($tr['tr']=='1') continue;

			if($td['code2']){ //연결된 세션이 존재할 때 세부 프로그램이 있는지 확인
				$detail_cnt = $conn->getOne("select count(*) from workshop_session_detail_tbl where session_sid='".$td['code2']."' and del='N'");
			}
			
			if($tr_row=='1'){
				$content .= "<td style='border:0px !important;'></td>";//border:0px !important;
			}

			if($tr['tr']=='1' || $tr['tr']=='2'){
				if($td['td']=='1'){
					//$content .= "<td style='".$style_add."vertical-align:bottom !important;padding-bottom:0px !important;' valign='bottom' colspan='".$td['colspan']."' rowspan='".$td['rowspan']."' class='".$td['td_class']."'>";
					$content .= "<td style='".$style_add.";' colspan='".$td['colspan']."' rowspan='".$td['rowspan']."' class='time ".$td['td_class']."'>";
				}else{
					$content .= "<td style='".$style_add.";' colspan='".$td['colspan']."' rowspan='".$td['rowspan']."' class='time ".$td['td_class']."'>";
				}
			}else{
				if($td['td']=='1'){
					$content .= "<td style='".$style_add."' colspan='".$td['colspan']."' rowspan='".$td['rowspan']."' class='time ".$td['td_class']."'>";
				}else if($td['td']=='2'){
					$content .= "<td style='".$style_add."' colspan='".$td['colspan']."' rowspan='".$td['rowspan']."' class='".$td['td_class']."'>";
					
				}else{
					$content .= "<td style='".$style_add."' colspan='".$td['colspan']."' rowspan='".$td['rowspan']."' class='".$td['td_class']."'>";
				}
				if($td['difficulty']){
					$content .= "<span class=\"type".$_PROGRAM['difficulty_code'][$td['difficulty']]."\">".$_PROGRAM['difficulty'][$td['difficulty']]."</span>";
				}
				
			}
			
			//$content .= "<span class=\"typeA\">All</span>";
			//$content .= "<span class=\"eng\">ENG</span>";
			
		
			if($td['linkurl']){
				$content .= '<a href="javascript:parent_link(\''.$td['linkurl'].'\')" style="text-decoration:none;color:inherit;">';//font-size:14px;
			}else{
				if($detail_cnt>0){
					// $content .= "<a href='session_list.php?program_day=".$td['bsid']."&session_sid=".$td['code2']."' class='viewPopup' key='".$td['code2']."' style='text-decoration:none;color:#000000;'>";//font-size:14px;
					$content .= "<a href='session_detail.php?program_day=".$td['bsid']."&session_sid=".$td['code2']."' class='viewPopup' key='".$td['code2']."' style='text-decoration:none;color:inherit;'>";//font-size:14px;
				}
			}
			
			if($td['content']){
				if($td['vertical_RL']=='Y'){
					$content .= "<span style=\"writing-mode: vertical-rl;\">";
				}
				$content .= stripslashes($td['content'])." ";
				if($td['vertical_RL']=='Y'){
					$content .= "</span>";
				}

				if($td['difficulty']){
					$content .= "<span class=\"type".$_PROGRAM['difficulty_code'][$td['difficulty']]."\">".$_PROGRAM['difficulty'][$td['difficulty']]."</span>";
				}

				if($td['lang']=='K'){
					// $content .= "<div class=\"lang\"><span class=\"icon_k\">K</span></div>";
					$content .= "<span class=\"kor\">KOR</span>";
				}else if($td['lang']=='E'){
					// $content .= "<div class=\"lang\"><span class=\"icon_e\">E</span></div>";
					$content .= "<span class=\"eng\">ENG</span>";
				}else if($td['lang']=='A'){
					// $content .= "<div class=\"lang\"><span class=\"icon_k\">K</span><span class=\"icon_e\">E</span></div>";
					$content .= "<span class=\"all\">ENG/KOR</span>";
				}
			}
			if($detail_cnt>0){
				$content .= "</a>";
			}
			if($td['logo_file']){
				if($td['logo_link']){
					$logo_link = trim($td['logo_link']);
				}
				
				$content .= "<div style='padding-top:5px;' >";
					if($logo_link) $content .= "<a href='".$logo_link."' target='".$td['logo_link_target']."'>";
					$content .= "<img src='".$_Azure['link']."/upload/session/".$td['logo_file']."'>";
					if($logo_link) $content .= "</a>";
				$content .= "</div>";
			}
			
			if($td['code2']){
				$content .= "<div style='padding-top:5px;' class='live_".$td['code2'].'_'.$td['room']."'></div>";
			}

			if($tr['tr']=='1'){
				$content .= "</td>";
			}else{
				$content .= "</td>";
			}
			$tr_row++;
		}
		$content .= "</tr>";

	}

	fwrite($file,$content);
	fclose($file);

	if($popup_yn!='Y'){
		PutLocation("/program/?ev_date=".number_format($ev_date));
	}
?>