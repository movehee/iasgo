<div class="tabCon scrollArea">
	<table class="program">
		<colgroup>
			<col style="width: 7%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
		</colgroup>
		<tbody>
		<?
			$code = "ksels2020";
			$ev_date = 0;
			$query = "select tr from workshop_schedule_tbl where code='$code' and bsid='$ev_date' group by tr order by tr asc";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			while(is_array($tr=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
			<tr>
				<?	
					$query2 = "select * from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and tr='$tr[tr]' order by td asc";
					$result2=$conn->query($query2);
					if(DB::isError($result2)) die($result2->getMessage());
					$num=1;
					while(is_array($td=$result2->fetchRow(DB_FETCHMODE_ASSOC))){
						unset($bottom_top_chk);
						unset($right_right_chk);
						unset($session_code1);
						unset($session_lang);

						$style_add = "font-size:14px;";
						if($td['bg_color']) $style_add .= "background:".$td['bg_color'].";";
						if($td['font_color']) $style_add .= "color:".$td['font_color'].";";
						if($td['w_size']) $style_add .= "width:".$td['w_size']."px !important;";
						if($td['h_size']) $style_add .= "height:".$td['h_size']."px !important;";
						if($td['bold']=="Y") $style_add .= "font-weight:bold !important;";
						if($td['italic']=="Y") $style_add .= "font-style:italic !important;";

						$detail_cnt=0;

						if($td['code2']){
							$session_code1 = $conn->getOne("select title from workshop_session_tbl where sid='$td[code2]'");
							$detail_cnt = $conn->getOne("select count(*) from workshop_session_detail_tbl where session_sid='".$td['code2']."' and del='N'");
							$session_lang = $conn->getOne("select lang from workshop_session_tbl where sid='$td[code2]'");
						}
		
						

				?>
				<?if($tr['tr']=='1'){?>
				<th style="<?=$style_add?>" colspan="<?=$td['colspan']?>" rowspan="<?=$td['rowspan']?>">
				<?}else{?>
				<td <?if($td['td']=='1'){?>class="time"<?}?> style="<?=$style_add?>" colspan="<?=$td['colspan']?>" rowspan="<?=$td['rowspan']?>">
				<?}?>
				<?if($td['sid']=='2719'){?>
				<span style="writing-mode: vertical-rl; ">
				<?}?>
					<?if($session_lang=="K"){?>
						<img src="http://conference.kscvi.org/39th/image/sub/langBl_kor.png" alt="KOR" class="lang">
					<?}else if($session_lang=="E"){?>
						<img src="http://conference.kscvi.org/39th/image/sub/langBl_eng.png" alt="ENG" class="lang">
					<?}?>
					
					<?if($detail_cnt>0){?><a href="program_glance_detail.php?session_sid=<?=$td['code2']?>" class="viewPopup" key="<?=$td['code2']?>" style="text-decoration:none;color:#000000;font-size:14px;"><?}?>
					
					<?if($td['content']){?>
						<div style="clear:both"></div>
						<div style="float:<?=$td['content_position']?>;text-align:<?=$td['content_position']?>;"><?=(stripslashes($td['content']))?></div>
					<?}else{?>
						<div style="clear:both"></div>
						<div style="float:<?=$td['content_position']?>;text-align:<?=$td['content_position']?>;"><?if($session_code1){?><?=stripslashes($session_code1)?><?}?></div>
					<?}?>
					<?if($td['content2']){?>
						<div style="clear:both"></div>
						<div style="float:<?=$td['content2_position']?>;text-align:<?=$td['content2_position']?>;" ><?=nl2br(stripslashes($td['content2']))?></div>
					<?}?>
					<?if($td['sid']=='2429'){?>
					</span>
					<?}?>
				<?if($tr['tr']=='1'){?>
				</th>
				<?}else{?>
				</td>
				<?}?>
				<?
					}
				?>
				<!-- <td></td> -->
			</tr>
		<!-- <?if($tr['tr']=='1'){?></thead><?}?> -->
		<?
			}
		?>
		</tbody>
	</table>
</div>

<div class="tabCon scrollArea">
	<table class="program">
		<colgroup>
			<col style="width: 7%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
		</colgroup>
		<tbody>
		<?
			if(!$ev_date) $ev_date=1;
			$code = "ksels2020";
			$ev_date = 1;
			$query = "select tr from workshop_schedule_tbl where code='$code' and bsid='$ev_date' group by tr order by tr asc";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			while(is_array($tr=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
			<tr>
				<?	
					$query2 = "select * from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and tr='$tr[tr]' order by td asc";
					$result2=$conn->query($query2);
					if(DB::isError($result2)) die($result2->getMessage());
					$num=1;
					while(is_array($td=$result2->fetchRow(DB_FETCHMODE_ASSOC))){
						unset($bottom_top_chk);
						unset($right_right_chk);
						unset($session_code1);
						unset($session_lang);

						$style_add = "font-size:14px;";
						if($td['bg_color']) $style_add .= "background:".$td['bg_color'].";";
						if($td['font_color']) $style_add .= "color:".$td['font_color'].";";
						if($td['w_size']) $style_add .= "width:".$td['w_size']."px !important;";
						if($td['h_size']) $style_add .= "height:".$td['h_size']."px !important;";
						if($td['bold']=="Y") $style_add .= "font-weight:bold !important;";
						if($td['italic']=="Y") $style_add .= "font-style:italic !important;";

						$detail_cnt=0;

						if($td['code2']){
							$session_code1 = $conn->getOne("select title from workshop_session_tbl where sid='$td[code2]'");
							$detail_cnt = $conn->getOne("select count(*) from workshop_session_detail_tbl where session_sid='".$td['code2']."' and del='N'");
							$session_lang = $conn->getOne("select lang from workshop_session_tbl where sid='$td[code2]'");
						}
		
						

				?>
				<?if($tr['tr']=='1'){?>
				<th style="<?=$style_add?>" colspan="<?=$td['colspan']?>" rowspan="<?=$td['rowspan']?>">
				<?}else{?>
				<td <?if($td['td']=='1'){?>class="time"<?}?> style="<?=$style_add?>" colspan="<?=$td['colspan']?>" rowspan="<?=$td['rowspan']?>">
				<?}?>
				
				<?if($td['sid']=='1830'){?>
				<span style="writing-mode: vertical-rl; ">
				<?}?>
					<?if($session_lang=="K"){?>
						<img src="http://conference.kscvi.org/39th/image/sub/langBl_kor.png" alt="KOR" class="lang">
					<?}else if($session_lang=="E"){?>
						<img src="http://conference.kscvi.org/39th/image/sub/langBl_eng.png" alt="ENG" class="lang">
					<?}?>
					
					<?if($detail_cnt>0){?><a href="program_glance_detail.php?session_sid=<?=$td['code2']?>" class="viewPopup" key="<?=$td['code2']?>" style="text-decoration:none;color:#000000;font-size:14px;"><?}?>
					
					<?if($td['content']){?>
						<div style="clear:both"></div>
						<div style="float:<?=$td['content_position']?>;text-align:<?=$td['content_position']?>;"><?=(stripslashes($td['content']))?></div>
					<?}else{?>
						<div style="clear:both"></div>
						<div style="float:<?=$td['content_position']?>;text-align:<?=$td['content_position']?>;"><?if($session_code1){?><?=stripslashes($session_code1)?><?}?></div>
					<?}?>
					<?if($td['content2']){?>
						<div style="clear:both"></div>
						<div style="float:<?=$td['content2_position']?>;text-align:<?=$td['content2_position']?>;" ><?=(stripslashes($td['content2']))?></div>
					<?}?>
					<?if($td['sid']=='1830'){?>
					</span>
					<?}?>
				<?if($tr['tr']=='1'){?>
				</th>
				<?}else{?>
				</td>
				<?}?>
				<?
					}
				?>
			</tr>
		<?
			}
		?>
		</tbody>
	</table>
</div>

<div class="tabCon scrollArea">
	<table class="program">
		<colgroup>
			<col style="width: 7%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
		</colgroup>
		<tbody>
		<?
			$code = "ksels2020";
			$ev_date = 2;
			$query = "select tr from workshop_schedule_tbl where code='$code' and bsid='$ev_date' group by tr order by tr asc";
			
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			while(is_array($tr=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
			<tr>
				<?	
					$query2 = "select * from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and tr='$tr[tr]' order by td asc";
					$result2=$conn->query($query2);
					if(DB::isError($result2)) die($result2->getMessage());
					$num=1;
					while(is_array($td=$result2->fetchRow(DB_FETCHMODE_ASSOC))){
						unset($bottom_top_chk);
						unset($right_right_chk);
						unset($session_code1);
						unset($session_lang);

						$style_add = "font-size:14px;";
						if($td['bg_color']) $style_add .= "background:".$td['bg_color'].";";
						if($td['font_color']) $style_add .= "color:".$td['font_color'].";";
						if($td['w_size']) $style_add .= "width:".$td['w_size']."px !important;";
						if($td['h_size']) $style_add .= "height:".$td['h_size']."px !important;";
						if($td['bold']=="Y") $style_add .= "font-weight:bold !important;";
						if($td['italic']=="Y") $style_add .= "font-style:italic !important;";

						$detail_cnt=0;

						if($td['code2']){
							$session_code1 = $conn->getOne("select title from workshop_session_tbl where sid='$td[code2]'");
							$detail_cnt = $conn->getOne("select count(*) from workshop_session_detail_tbl where session_sid='".$td['code2']."' and del='N'");
							$session_lang = $conn->getOne("select lang from workshop_session_tbl where sid='$td[code2]'");
						}
		
						

				?>
				<?if($tr['tr']=='1'){?>
				<th style="<?=$style_add?>" colspan="<?=$td['colspan']?>" rowspan="<?=$td['rowspan']?>">
				<?}else{?>
				<td <?if($td['td']=='1'){?>class="time"<?}?> style="<?=$style_add?>" colspan="<?=$td['colspan']?>" rowspan="<?=$td['rowspan']?>">
				<?}?>
				<?if($td['sid']=='2142'){?>
				<span style="writing-mode: vertical-rl; ">
				<?}?>
					<?if($session_lang=="K"){?>
						<img src="http://conference.kscvi.org/39th/image/sub/langBl_kor.png" alt="KOR" class="lang">
					<?}else if($session_lang=="E"){?>
						<img src="http://conference.kscvi.org/39th/image/sub/langBl_eng.png" alt="ENG" class="lang">
					<?}?>
					
					<?if($detail_cnt>0){?><a href="program_glance_detail.php?session_sid=<?=$td['code2']?>" class="viewPopup" key="<?=$td['code2']?>" style="text-decoration:none;color:#000000;font-size:14px;"><?}?>
					
					<?if($td['content']){?>
						<div style="clear:both"></div>
						<div style="float:<?=$td['content_position']?>;text-align:<?=$td['content_position']?>;"><?=nl2br(stripslashes($td['content']))?></div>
					<?}else{?>
						<div style="clear:both"></div>
						<div style="float:<?=$td['content_position']?>;text-align:<?=$td['content_position']?>;"><?if($session_code1){?><?=stripslashes($session_code1)?><?}?></div>
					<?}?>
					<?if($td['content2']){?>
						<div style="clear:both"></div>
						<div style="float:<?=$td['content2_position']?>;text-align:<?=$td['content2_position']?>;" ><?=nl2br(stripslashes($td['content2']))?></div>
					<?}?>
					<?if($td['sid']=='2142'){?>
					</span>
					<?}?>
				<?if($tr['tr']=='1'){?>
				</th>
				<?}else{?>
				</td>
				<?}?>
				<?
					}
				?>
				<!-- <td></td> -->
			</tr>
		<!-- <?if($tr['tr']=='1'){?></thead><?}?> -->
		<?
			}
		?>
		</tbody>
	</table>
</div>