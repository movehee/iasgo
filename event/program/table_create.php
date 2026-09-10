<?	
	include $_SERVER['DOCUMENT_ROOT']."lib.php";

	if($mode=="new_table"){ //테이블 생성시
		if(!$td || !$tr){
			echo "No Data";
			exit;
		}

		$del_query = "delete from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and td>$td"; //넘어온 행 값보다 작은 행들은 삭제한다.
		$del_result = $conn->query($del_query);
		if(DB::isError($del_result)) {
			die($del_result->getMessage());
		}
		
		//master_echo($del_query);
		$del_query = "delete from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and tr>$tr"; //넘어온 열 값보다 작은 열들은 삭제한다.
		$del_result = $conn->query($del_query);
		if(DB::isError($del_result)) {
		   die($del_result->getMessage());
		}
		
		//master_echo($del_query);

		for($a=1;$a<=$tr;$a++){
		
			for($b=1;$b<=$td;$b++){
				
				$chk = GetOne("select count(*) from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and tr='$a' and td='$b'");
				if(!$chk){
					$query = "insert into workshop_schedule_tbl set code='$code', bsid='$tb_sid', tr='$a', td='$b'";
					$result = $conn->query($query);
					if(DB::isError($result)) {
					   die($result->getMessage());
					}
				}
		
			}
		
		}
	}else{
		//공통

		
		$query = "select * from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		  die($result->getMessage());
		}
		$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
		$result->free();

		
		
		$now_tr = $d['tr']; //현재 데이터의 TR값
		$now_td = $d['td']; //현재 데이터의 TD값

		

		if($mode=="RR"){
		
			//같은 TR안에서 현재 TD보다 값이 큰 TD가 있으면 하나만 가져온다
			$remove_td = $conn->getOne("select td from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and tr='$now_tr' and td>$now_td order by td asc limit 1");
			
			$plus_tr = $d['tr']+($d['rowspan']-1);
			for($i=$now_tr;$i<=$plus_tr;$i++){
				$remove_tr[] = "tr='$i'";
			}
			
			if($remove_td){ //없어져야 할 TD가 있을 때만 
				
				$del_tr = implode(" or ",$remove_tr);

				$query = "delete from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and ($del_tr) and td='$remove_td'";
				$result = $conn->query($query);
				if(!$result) {die($conn->error);}

				$query = "update workshop_schedule_tbl set colspan=colspan+1 where sid='$sid'";
				$result = $conn->query($query);
				if(!$result) {die($conn->error);}
			}
			
		}else if($mode=="RL"){
			
			$add_td = $d['td']+($d['colspan']-1);
			
			$loop_tr = $now_tr+($d['rowspan']-1);
			for($i=$now_tr;$i<=$loop_tr;$i++){
				$query = "insert into workshop_schedule_tbl set code='$code', bsid='$tb_sid', tr='$i', td='$add_td'";
				$result = $conn->query($query);
				if(!$result) {die($conn->error);}
			}
			
			$query = "update workshop_schedule_tbl set colspan=colspan-1 where sid='$sid'";
			$result = $conn->query($query);
			if(!$result) {die($conn->error);}
		
		
		}else if($mode=="BB"){
			
			//같은 TD안에서 현재 TR보다 값이 큰 TR을 하나만 가져온다.
			$remove_tr = $conn->getOne("select tr from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and td='$now_td' and tr>$now_tr order by tr asc limit 1");
			
			$plus_td = $d['td']+($d['colspan']-1);

			


			for($i=$d['td'];$i<=$plus_td;$i++){
				$remove_td[] = "td='$i'";
			}
			


			if($remove_tr){ //없어져야 할 TR이 있을 때만 
				
				$del_td = implode(" or ",$remove_td);

				$query = "delete from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and ($del_td) and tr='$remove_tr'";
				$result = $conn->query($query);
				if(!$result) {die($conn->error);}

				$query = "update workshop_schedule_tbl set rowspan=rowspan+1 where sid='$sid'";
				$result = $conn->query($query);
				if(!$result) {die($conn->error);}

			}
		}else if($mode=="BT"){
		
			$add_tr = $d['tr']+($d['rowspan']-1);
			$loop_td = $now_td+($d['colspan']-1);

			for($i=$now_td;$i<=$loop_td;$i++){
				$query = "insert into workshop_schedule_tbl set code='$code', bsid='$tb_sid', td='$i', tr='$add_tr'";
				$result = $conn->query($query);
				if(!$result) {die($conn->error);}
			}
			
		
			$query = "update workshop_schedule_tbl set rowspan=rowspan-1 where sid='$sid'";
			$result = $conn->query($query);
			if(!$result) {die($conn->error);}

		}else if($mode=="DEL"){
			
			$query = "delete from workshop_schedule_tbl where code='$code' and bsid='$tb_sid'";
			$result = $conn->query($query);
			if(!$result) {die($conn->error);}
		}
	
	}
	
?>

<?
	$td_max_count = $conn->getOne("select max(td) from workshop_schedule_tbl where code='$code' and bsid='$tb_sid'");
?>
<script>
$(document).ready(function(){
	if($(".iframe_session").length>0){//헤더에 공지사항이 항상 있기때문에 이거 하나만 조건으로 넣어둠.
		$(".iframe_session").colorbox({iframe:true, width:"800", height:"786", top:"70"});
	}
});
</script>
<div id="table_area">
<table class="tblDef ac programTbl" style="width:100%;">
	
	<?
		$query = "select tr from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' group by tr order by tr asc";
		$result = $conn->query($query);
		if(!$result) {die($conn->error);}
		
		$rnum=1;
		while(is_array($tr=$result->fetchRow(DB_FETCHMODE_ASSOC))){
	?>
	<tr>
		<?
			$query2 = "select * from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and tr='$tr[tr]' order by td asc";
			$result2=$conn->query($query2);
			if(DB::isError($result2)) die($result2->getMessage());
			$num=1;

			while(is_array($td=$result2->fetchRow(DB_FETCHMODE_ASSOC))){
				
				unset($bottom_top_chk);
				unset($right_right_chk);
				unset($session_code1);

				$style_add = "font-size:11px;";
				if($td['bg_color']) $style_add .= "background:".$td['bg_color'].";";
				if($td['font_color']) $style_add .= "color:".$td['font_color'].";";
				if($td['h_size']){
					$style_add .= "height:".$td['h_size']."px !important;";
				}else{
					$style_add .= "height:40px;";
				}

				if($td['code2']){
					$session_code1 = $conn->getOne("select title from session_tbl where sid='$td[code2]'");
				}

				$next_query = "select colspan,rowspan,sid from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and tr='$td[tr]' and td=$td[td]+$td[colspan] order by td asc limit 0,1";
				$next_result = $conn->query($next_query);
				$next_result->fetchInto(&$next,DB_FETCHMODE_ASSOC);
				$next_result->free();


				
				if($next['colspan']>1 || $next['rowspan']>1 || !$next['sid']){
					$right_right_chk="N";
				}
				
				$down_query = "select colspan,rowspan,sid from workshop_schedule_tbl where code='$code' and bsid='$tb_sid' and td='$td[td]' and tr=$td[tr]+$td[rowspan] order by tr asc limit 0,1";
				$down_result = $conn->query($down_query);
				$down_result->fetchInto(&$down,DB_FETCHMODE_ASSOC);
				$down_result->free();

				
				if($down['colspan']>1 || $down['rowspan']>1 || !$down['sid']){
					$bottom_top_chk="N";
				}
				if($td_max_count>10){
					$style_add .= "padding:30px;";
				}else{
					$style_add .= "padding:20px;";
				}
		?>
		<td style="<?=$style_add?>" colspan="<?=$td['colspan']?>" rowspan="<?=$td['rowspan']?>" >
			<div class="check posTL" style="padding-left:10px;clear:both;">
				<input type="checkbox" name="chk_sid[]" class="chk_sid" value="<?=$td['sid']?>" style="width:100%;">
			</div>
			<?if($td['content']){?><?=nl2br(stripslashes($td['content']))?><?}?>
			<div class="upload posBL lp5">
				<i class="far fa-edit" style="font-size:20px;cursor:pointer;" onclick="popup_call('TableGender/postform','sid=<?=$td['sid']?>&code=webinar')" ></i>
			</div>
			<div class="upload posBR rp5">
				<a href="/popup/program/session_select.php?code1=<?=$td['code1']?>&code2=<?=$td['code2']?>" class="iframe_session"><i class="fas fa-link" style="font-size:18px;<?if($session_code1){?>color:#019BFF;<?}?>" ></i></a>
			</div>
			<div class="rowDown">
				<?if($bottom_top_chk!="N"){?><a href="javascript:tbl_merge('BB',<?=$td['sid']?>,<?=$tb_sid?>)" title="아래줄과 합치기"><img src="/image/icon/BB.png" alt="" width=15/></a><?}?>
				<?if($td['rowspan']>1){?><a href="javascript:tbl_merge('BT',<?=$td['sid']?>,<?=$tb_sid?>)" title="아래줄과 분리하기"><img src="/image/icon/BT.png" alt="" width=15/></a><?}?>
			</div>

			
			<div class="colRight" style="z-index:9999px !important;">
				
				<?if($right_right_chk!="N"){?>
				<a href="javascript:tbl_merge('RR',<?=$td['sid']?>,<?=$tb_sid?>)"><img src="/image/icon/RR.png" alt="" width=10 /></a>
				<?}?>
				<?if($td['colspan']>1){?>
				<a href="javascript:tbl_merge('RL',<?=$td['sid']?>,<?=$tb_sid?>)" ><img src="/image/icon/RL.png" alt="" width=10 /></a>
				<?}?>
			</div>
			
		</td>
		<?
			}
		?>
	</tr>
	<?
		}
	?>
</table>
</div>