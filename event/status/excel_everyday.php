<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.225'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=everyday_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();


	$ex_sdate = explode('-', $_Webinar['sdate']);


	$date_sql = "SELECT * from vod_view_tbl group by signdate order by signdate asc";
	$date_result=$conn->query($date_sql);
	if(DB::isError($date_result)) die($date_result->getMessage());
	while(is_array($date=$date_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$_Day['date'][] = $date['signdate'];
	}
	
	
	$query = "select * from workshop_session_tbl where del='N' ";//and vod!=''
	if($ev_date!='all'){
		//$query .= " and ev_date='$ev_date'";
	}
	$query .= " order by ev_date asc, room asc, stime asc";
	
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table class="tblDef tp10" border=1>
	<tbody>

		
		<tr>
			<th style="background:#263238;color:#ffffff;">일자</th>
			<th style="background:#263238;color:#ffffff;">시간</th>
			<th style="background:#263238;color:#ffffff;">Specialty</th>
			<th style="background:#263238;color:#ffffff;">Specialty2</th>
			<th style="background:#263238;color:#ffffff;">장소</th>
			<th style="background:#263238;color:#ffffff;">코드</th>
			<th style="background:#263238;color:#ffffff;">언어</th>
			<th style="background:#263238;color:#ffffff;">세션 명</th>
			<th style="background:#263238;color:#ffffff;">좌장</th>
			<?foreach($_Day['date'] as $tkey=>$tval){?>
			<th style="background:#263238;color:#ffffff;"><?=$tval?></th>
			<?}?>
		</tr>
		<?
			$ev_num = 0;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

				$start_time = $ex_sdate_arr[0]." ".$d['stime'];
				$end_time = $ex_sdate_arr[0]." ".$d['etime'];
				
				unset($stay_time);
				unset($ex_chair);
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
					$rowspan_cnt++;
					$rowspan_cnt2 = 2;
				}
				if($d['session_file']){
					$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/session/" . $d["session_file"]) . "&filename=" . base64_encode($d["session_realfile"]);
				}

				
				
				
		?>
		<tr >
			<th style="background:#445964;color:#ffffff;mso-number-format:'\@';" ><?=date("m.d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['ev_date']-1), $ex_sdate[0]));?></th>
			<th style="background:#445964;color:#ffffff;" ><?=$d['stime']?> ~ <?=$d['etime']?></th>
			<th style="background:#445964;color:#ffffff;" ><?=$d['part']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$d['part2']?></th>
			<th style="background:#445964;color:#ffffff;">Room <?=$d['room']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$d['code']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$_PROGRAM['lang_code'][$d['lang']]?></th>
			<th style="font-weight:bold;text-align:left;background:#445964;color:#ffffff;">
				<div style="float:left;">
				<?=$d['title']?>
				<?if($d['session_file']){?><img src="<?=IconType3($d['session_file'])?>" onclick="location.href='/func/download.php?<?=$queryString?>'"class="hand"><?}?>
				</div>
			</th>
			<th style="background:#445964;color:#ffffff;" class="ar">
				<?if($ex_chair){?>
				<?foreach($ex_chair as $ckey=>$cval){?>
				<div><?=$cval?></div>
				<!-- <?if($ex_chair_position[$ckey]){?><div>(<?=$ex_chair_position[$ckey]?>)</div><?}?> -->
				<?}?>
				<?}?>
			</td>
			<?
			foreach($_Day['date'] as $tkey=>$tval){
			$vod_cnt = $conn->getOne("select count(*) from vod_view_tbl where session_sid='".$d['sid']."' and signdate='$tval'");
			?>
			<th style="background:#445964;color:#ffffff;font-size:18px;">
				<?=$vod_cnt?>
			</th>
			<?}?>
		</tr>

		<?
						
			$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$d['sid']."' and del='N' and time_skip!='Y' order by sort_num asc";
			$detail_query .= $sort_sql;
			$detail_result=$conn->query($detail_query);
			if(DB::isError($detail_result)) die($detail_result->getMessage());

			$set_time = $d['stime'];
			
			while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))){	
				unset($pt_total_time);
				if($detail['pt_time']){
					$ex_pt = explode("/",$detail['pt_time']);
					$pt_total_time = $ex_pt[0]+$ex_pt[1];
					$set_start = date("H:i",strtotime("+".$pt_total_time." minutes",strtotime($set_time)));
				}

				
				
				
		?>
		<tr id="<?=$detail['sid']?>" <?if($detail['bg_color']){?>style="background:<?=$detail['bg_color']?> !important;"<?}?>>
			<td style="background:#F8F8F8;"></td>
			<td style="background:#F8F8F8;">
				<?if($detail['time_skip']=='Y'){?>
					<?=$detail['detail_time']?>
				<?}else{?>
					<?if($detail['pt_time']){?><?=date("H:i",strtotime($set_time))?>-<?=$set_start?><?}?>
				<?}?>
			</td>
			<td class="al lp10" colspan=3></td>
			
			<td>
			<?
				unset($author_code_arr);
				if($detail['author_code']) $author_code_arr[] = $detail['author_code'];
				if($detail['author_code2']) $author_code_arr[] = $detail['author_code2'];
				
				if($detail['pre_num']) echo $detail['pre_num'];
				if(count($author_code_arr)>0){
					echo implode(",",$author_code_arr);
				}

			?>
			</td>
			<td><?=$detail['abs_num']?></td>
			<td class="al lp10"><?=stripslashes($detail['title'])?></td>
			<td style="text-align:right;font-size:11px;cursor:default;line-height:180%;">
			<?
				$faculty_cnt = $conn->getOne("select count(*) from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.session_sid='".$d['sid']."' and t1.session_detail_sid='".$detail['sid']."'");
				unset($faculty_name_arr);
				
				if($faculty_cnt>0){
					$fquery = "select t2.* from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.session_sid='".$d['sid']."' and t1.session_detail_sid='".$detail['sid']."'";
					$fresult=$conn->query($fquery);
					if(DB::isError($fresult)) die($fresult->getMessage());

					while(is_array($f=$fresult->fetchRow(DB_FETCHMODE_ASSOC))){
						$faculty_name = $f['faculty_name'];
						if($f['faculty_aff']){
							$faculty_name .= " (".$f['faculty_aff'];
							if($f['faculty_country']){
								$faculty_name .= ", ".$f['faculty_country'];
							}
							$faculty_name .= ")";
						}
						//$faculty_name .= "&nbsp;&nbsp;&nbsp;<i class=\"fas fa-link\" style=\"font-size:16px;color:#127DAB;\" onclick=\"popup_call('session/faculty','sid=".$f['sid']."')\"></i>";

						$faculty_name_arr[] = $faculty_name;
					}
				}else{
					$faculty_name_arr[] = $detail['author'].($detail['country']?" (".$detail['country'].")":"");
					if(trim($detail['author2'])) $faculty_name_arr[] = $detail['author2'].($detail['country2']?" (".$detail['country2'].")":"");
					if(trim($detail['author3'])) $faculty_name_arr[] = $detail['author3'].($detail['country3']?" (".$detail['country3'].")":"");
					if(trim($detail['author4'])) $faculty_name_arr[] = $detail['author4'].($detail['country4']?" (".$detail['country4'].")":"");
				}
				if(count($faculty_name_arr)>0){
					echo implode(",",$faculty_name_arr);
				}
			?>
			</td>
			<?
			foreach($_Day['date'] as $tkey=>$tval){
			$vod_detail_cnt = $conn->getOne("select count(*) from vod_view_tbl where session_sid='".$d['sid']."' and detail_sid='".$detail['sid']."' and signdate='$tval'");
			?>
			<td><?=$vod_detail_cnt?></td>
			<?}?>
		</tr>
		<?
			if($detail['pt_time']){
				$set_time = $set_start;
			}
		}?>
		<?}?>
	</tbody>
</table>