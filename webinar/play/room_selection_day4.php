<div style="color:#fff;text-align:center;padding-bottom:20px;">
시스템 오류 발생 시 문의처 : 02-2190-7342, live@m2community.co.kr (성명, 휴대폰번호 및 문의사항 기재 후 발송)
<br /><b style="font-size:20px;color:#FDFEC2">※오늘 추계학술대회(VOD) 프로그램은 오늘 자정까지 수강을 완료하면 평점(참석)이 인정되니 교육이수에 참고하시기 바랍니다.</b>
</div>

<?
	
?>
<div class="room tp0">
	<?
		
		if($_COOKIE['wmember_sid']!='5288'){
			if($_COOKIE['wmember_level']!="M"){
				if(strtotime("2020-10-26 00:00")<time()){
					PutMessageClose("행사가 종료되었습니다.");
					exit;
				}
			}
		}
		$session_query = "select * from workshop_session_tbl where room='1' and del='N' and ev_date='3' and sid='51'";
		$session_result = $conn->query($session_query);
		$session_result->fetchInto(&$session,DB_FETCHMODE_ASSOC);
		$session_result->free();

		$ex_chair = explode('/',$session['chair']);
	?>
	<div class="vodInfo" style="height:700px;">
		<dl class="brief">
			<dt style="width:500px;">
				<?=$session['title']?></span><br>
				<?
				unset($chair_arr);
				if($ex_chair){
					echo "좌장:";
					foreach($ex_chair as $tkey=>$tval){
						$chair_arr[] = $tval;
					}
					if($chair_arr) echo implode(", ",$chair_arr);
				}
				?>
			</dt>
			
		</dl>

		<div class="bg">
			<?
				$set_time = $ex_sdate_arr[0]." ".$session['stime'];
				$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$session['sid']."' and del='N' order by sort_num asc";
				//$detail_query .= $sort_sql;
				$detail_result=$conn->query($detail_query);
				if(DB::isError($detail_result)) die($detail_result->getMessage());

				while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))){

					unset($pt_total_time);
					if($detail['pt_time']){
						$ex_pt = explode("/",$detail['pt_time']);
						$pt_total_time = $ex_pt[0]+$ex_pt[1];
						$set_start = date("H:i",strtotime("+".$pt_total_time." minutes",strtotime($set_time)));
					}
					
					$progress_query = "select * from vod_result_tbl where vsid='$detail[sid]' and usid='".$_COOKIE['wmember_sid']."'";
					$progress_result = $conn->query($progress_query);
					$progress_result->fetchInto(&$p,DB_FETCHMODE_ASSOC);
					$progress_result->free();
					unset($progress);
					if($p['sid']){
						if($p['c_time']>0){
							$progress = round(($p['c_time']/$p['r_time'])*100);
						}
					}else{
						$progress = 0;
					}
			?>
			<dl style="padding-top:0px;">
				<dt>
					<span class="tit"><?=$detail['title']?></span>
					<span class="speaker"><?=$detail['author']?><?if($detail['position']){?> (<?=$detail['position']?>)<?}?></span>
				</dt>
				<dd>
					<div class="graph" data-num="<?=$progress?>%">
						<div class="graphBar" style="width: <?=$progress?>%;"></div>
					</div>
					<dd class="btn ar tp5">
						<a href="index_vod.php?vsid=<?=$detail['sid']?>" class="btnDef" style="padding:5px;">입장하기</a>
					</dd>
				</dd>
			</dl>
			<?}?>
		</div>
		<!-- //bg -->
	</div>


	<?
		
		$session_query = "select * from workshop_session_tbl where room='1' and del='N' and ev_date='3' and sid='52'";
		$session_result = $conn->query($session_query);
		$session_result->fetchInto(&$session,DB_FETCHMODE_ASSOC);
		$session_result->free();

		$ex_chair = explode('/',$session['chair']);
	?>
	<div class="vodInfo" style="height:700px;">
		<dl class="brief">
			<dt>
				<?=$session['title']?></span><br>
				<?
				unset($chair_arr);
				if($ex_chair){
					echo "&nbsp;";
					foreach($ex_chair as $tkey=>$tval){
						$chair_arr[] = $tval;
					}
					if($chair_arr) echo implode(", ",$chair_arr);
				}
				?>
			</dt>
		</dl>

		<div class="bg">
			<?
				$set_time = $ex_sdate_arr[0]." ".$session['stime'];
				$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$session['sid']."' and del='N' order by sort_num asc";
				//$detail_query .= $sort_sql;
				$detail_result=$conn->query($detail_query);
				if(DB::isError($detail_result)) die($detail_result->getMessage());

				while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))){

					unset($pt_total_time);
					if($detail['pt_time']){
						$ex_pt = explode("/",$detail['pt_time']);
						$pt_total_time = $ex_pt[0]+$ex_pt[1];
						$set_start = date("H:i",strtotime("+".$pt_total_time." minutes",strtotime($set_time)));
					}

					$progress_query = "select * from vod_result_tbl where vsid='$detail[sid]' and usid='".$_COOKIE['wmember_sid']."'";
					$progress_result = $conn->query($progress_query);
					$progress_result->fetchInto(&$p,DB_FETCHMODE_ASSOC);
					$progress_result->free();
					unset($progress);
					if($p['sid']){
						if($p['c_time']>0){
							$progress = round(($p['c_time']/$p['r_time'])*100);
						}
					}else{
						$progress = 0;
					}
			?>
			<dl style="padding-top:0px;">
				<dt>
					<span class="tit"><?=$detail['title']?> (각 1시간)</span>
					<span class="speaker"><?=$detail['author']?><?if($detail['position']){?> (<?=$detail['position']?>)<?}?></span>
				</dt>
				<dd>
					<div class="graph" data-num="<?=$progress?>%">
						<div class="graphBar" style="width: <?=$progress?>%;"></div>
					</div>
					<dd class="btn ar tp5">
						<a href="index_vod.php?vsid=<?=$detail['sid']?>" class="btnDef" style="padding:5px;">입장하기</a>
					</dd>
				</dd>
			</dl>
			<?}?>
		</div>
		<!-- //bg -->
	</div>

</div>