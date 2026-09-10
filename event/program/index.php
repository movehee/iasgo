<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	

	if(stristr($_SERVER['REMOTE_ADDR'],'218.235.94')==false){
		//PutMessageBack("접근이 불가능합니다.");
		//exit;
	}
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	
	$code = "webinar";

	$room_query = "select count(sid) from (select t1.sid from workshop_session_category as t1 inner join workshop_session_tbl as t2 on t1.sid=t2.room  ";
	$room_query .= " where t2.ev_date='".$ev_date."' and t1.del='N' and t1.kind='P' group by t1.sid) A";
	$room_cnt = $conn->getOne($room_query);

	

?>
<style>
td p {margin: 0;}
td > br {display: none;}

</style>
<script type="text/javascript">
	var code = "<?=$code?>";
	var td = $('#td').val();
	var tr = $('#tr').val();
	var tb_sid = "<?=$ev_date?>";
	
	function tbl_merge(type,sid){
		$("#table_area").load("/program/table_create.php?code="+code+"&sid="+sid+"&tb_sid="+tb_sid+"&mode="+type);
	}
	$(function(){
		$('.table_allchk').on('click',function(){
			if($(this).is(':checked')==true){
				$('.chk_sid').prop('checked',true);
			}else{
				$('.chk_sid').prop('checked',false);
			}
			
		});
		$('.td_allchk').on('click',function(){
			var key = $(this).attr('key')
			if($(this).is(':checked')==true){
				$('.td_'+key).prop('checked',true);
			}else{
				$('.td_'+key).prop('checked',false);
			}
			
		});
		$('.tr_allchk').on('click',function(){
			var key = $(this).attr('key')
			if($(this).is(':checked')==true){
				$('.tr_'+key).prop('checked',true);
			}else{
				$('.tr_'+key).prop('checked',false);
			}
			
		});
	});
	
</script>
<div class="tp20"></div>

<div >
	<div class="btn" style="float:left;">
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
	<div class="btn" style="float:right;">
		<a href="javascript:popup_call('TableGender/TableGender_excel','code=webinar&ev_date=<?=$ev_date?>')" class="btnGrey withIcon"><i class="fas fa-edit"></i>Program 등록</a>
	</div>
</div>

<div style="clear:both;"></div>
	<div class="btn tp10 bp5" style="float:left;">
		<a href="javascript:select_change('<?=$ev_date?>')" class="btnDef withIcon"><i class="far fa-check-square" style="font-size:15px;"></i>선택 프로그램 일괄변경</a>
		<a href="javascript:program_backup('<?=$ev_date?>')" class="btnLGrey withIcon"><i class="far fa-copy" style="font-size:15px;"></i>Backup</a>
		<span class="fcRed">주기적으로 백업을 해주세요.</span>
		
	</div>
	<div class="btn tp10 bp5" style="float:right;">
		<a href="javascript:program_delete('<?=$ev_date?>')" class="btnRed withIcon"><i class="far fa-calendar-times" style="font-size:15px;"></i></i></i>전체삭제</a>
		<a -href="javascript:alert('사용불가')" href="javascript:program_html('<?=$ev_date?>')" class="btnBdLGrey withIcon"><i class="fas fa-code" ></i>HTML 생성</a>
	</div>
<br />
<form name="programF" id="programF" method="post">
<div id="table_area">
<?
	$td_max_count = $conn->getOne("select max(td) from workshop_schedule_tbl where code='$code' and bsid='$ev_date'");
	$tr_max_count = $conn->getOne("select max(tr) from workshop_schedule_tbl where code='$code' and bsid='$ev_date'");

	//echo $td_max_count."<br>";
	//echo $tr_max_count;
?>
<table class="tblDef ac programTbl" style="width:100%;">
	<colgroup>
		<col style="width: 0.2%;">
	</colgroup>
	<tr>
		<th ><input type="checkbox" class="table_allchk" style="width:15px;height:15px;padding:0px;margin:0px;"></th>
		<?for($i=1;$i<=$td_max_count;$i++){?>
		<?
			$add_left = $conn->getOne("select count(*) from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and colspan='1' and td='".($i-1)."'");
			$add_right = $conn->getOne("select sum(rowspan) from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and td='".($i+1)."'");
		?>
		<th style="padding:0px;margin:0px;">
			<?if($add_left==$tr_max_count){?>
			<div style="float:left;font-size:18px;padding:3px;" onclick="program_add('<?=$i?>','left')"><i class="fas fa-arrow-circle-left" style="cursor:pointer;"></i></div>
			<?}?>
			<?=$i?> 
			<i class="far fa-trash-alt" style="color:#B70606;cursor:pointer;" onclick="program_add('<?=$i?>','del_cols')"></i>
			<?if($add_right==0 || $add_right==$tr_max_count){?>
			<div style="float:right;font-size:18px;padding:3px;" onclick="program_add('<?=$i?>','right')"><i class="fas fa-arrow-circle-right" style="cursor:pointer;"></i></div>
			<?}?>

			<input type="checkbox" class="td_allchk" key="<?=$i?>" style="width:16px;height:16px;">

		</th>
		<?}?>
	</tr>
	<?
		$query = "select tr from workshop_schedule_tbl where code='$code' and bsid='$ev_date' group by tr order by tr asc";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		$rnum=1;
		while(is_array($tr=$result->fetchRow(DB_FETCHMODE_ASSOC))){
	?>
	<tr>
		<!-- <td style="width:30px !important;"><?=$tr['tr']?></td> -->
		<?
			$query2 = "select * from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and tr='$tr[tr]' order by td asc";
			$result2=$conn->query($query2);
			if(DB::isError($result2)) die($result2->getMessage());
			$num=1;
			$tr_row = 1;
			while(is_array($td=$result2->fetchRow(DB_FETCHMODE_ASSOC))){
				
				unset($bottom_top_chk);
				unset($right_right_chk);
				unset($session_code1);

				$style_add = "font-size:11px;";
				if($td['bg_color']) $style_add .= "background:".$td['bg_color'].";";
				if($td['font_color']) $style_add .= "color:".$td['font_color'].";";
				if($td['h_size']){
					$style_add .= "height:".$td['h_size']."px !important;";
				}

				if($td['code2']){
					$session_code1 = $conn->getOne("select sid from workshop_session_tbl where sid='$td[code2]'");
				}

				$next_query = "select colspan,rowspan,sid from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and tr='$td[tr]' and td=$td[td]+$td[colspan] order by td asc limit 0,1";
				$next_result = $conn->query($next_query);
				$next_result->fetchInto(&$next,DB_FETCHMODE_ASSOC);
				$next_result->free();


				
				if($next['colspan']>1 || $next['rowspan']>1 || !$next['sid']){
					$right_right_chk="N";
				}
				
				$down_query = "select colspan,rowspan,sid from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and td='$td[td]' and tr=$td[tr]+$td[rowspan] order by tr asc limit 0,1";
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
		<?
		
		if($tr_row=='1'){
			$add_up = $conn->getOne("select count(*) from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and rowspan='1' and tr='".$td['tr']."'");
			$add_down = $conn->getOne("select sum(colspan) from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and tr='".($td['tr']+1)."'");
		?>
			<td style="padding:30px 0 50px 0;margin:0px;background:#F8F8F8;">
				<input type="checkbox" class="tr_allchk" key="<?=$td['tr']?>" style="width:15px;height:15px;margin:0px;padding:0px;">
				<?if($add_up==$td_max_count){?>
				<div class="posTL" style="vertical-align:top;font-size:18px;color:green;width:23px;padding-top:3px;"><i class="fas fa-arrow-circle-up" onclick="program_add('<?=$td['tr']?>','up')" style="cursor:pointer;"></i></div>
				<?}?>
				<?=$td['tr']?>
				<div style="width:23px;"><i class="far fa-trash-alt" style="color:#B70606;cursor:pointer;" onclick="program_add('<?=$td['tr']?>','del_rows')"></i></div>
				<?if($add_down==$td_max_count || $add_down==0){?>
				<div class="posBL" style="vertical-align:bottom;font-size:18px;color:green;width:23px;padding-bottom:3px;"><i class="fas fa-arrow-circle-down" onclick="program_add('<?=$td['tr']?>','down')" style="cursor:pointer;"></i></div>
				<?}?>
			</td>
		<?}?>
		<td style="<?=$style_add?>" colspan="<?=$td['colspan']?>" rowspan="<?=$td['rowspan']?>" ><!-- style="writing-mode: vertical-rl;" -->
			<div class="check posTL" style="padding-left:10px;clear:both;">
				<input type="checkbox" name="chk_sid[]" class="chk_sid tr_<?=$td['tr']?> td_<?=$td['td']?>" value="<?=$td['sid']?>" style="width:100%;">
			</div>
			<?if($td['vertical_RL']=='Y'){?><span style="writing-mode: vertical-rl;"><?}?>
			<?if($td['content']){?><?=nl2br(stripslashes($td['content']))?><?}?>
			<?if($td['vertical_RL']=='Y'){?></span><?}?>
			<div class="upload posBL lp5">
				<i class="far fa-edit" style="font-size:18px;cursor:pointer;" onclick="popup_call('TableGender/postform','sid=<?=$td['sid']?>&code=webinar')" ></i>
			</div>
			<div class="upload posBR" style="padding-right:2px;padding-bottom:1px;">
				<a href="/popup/program/session_select.php?sid=<?=$td['sid']?>" class="iframe_session"><i class="fas fa-link" style="font-size:16px;<?if($session_code1){?>color:#FF0080;<?}?>" id="link_icon<?=$td['sid']?>"></i></a>
			</div>

			<div class="rowDown">
				<?if($bottom_top_chk!="N"){?><a href="javascript:tbl_merge('BB',<?=$td['sid']?>,<?=$ev_date?>)" title="아래줄과 합치기"><img src="/image/icon/BB.png" alt="" width=15/></a><?}?>
				<?if($td['rowspan']>1){?><a href="javascript:tbl_merge('BT',<?=$td['sid']?>,<?=$ev_date?>)" title="아래줄과 분리하기"><img src="/image/icon/BT.png" alt="" width=15/></a><?}?>
			</div>

			
			<div class="colRight" style="z-index:9999px !important;">
				<?if($right_right_chk!="N"){?>
				
				<a href="javascript:tbl_merge('RR',<?=$td['sid']?>,<?=$ev_date?>)"><img src="/image/icon/RR.png" alt="" width=10 /></a>
				<?}?>
				<?if($td['colspan']>1){?>
				<a href="javascript:tbl_merge('RL',<?=$td['sid']?>,<?=$ev_date?>)" ><img src="/image/icon/RL.png" alt="" width=10 /></a>
				<?}?>
			</div>
			
		</td>
		<?
			$tr_row++;
			}
		?>
	</tr>
	<?
		}
	?>
</table>
</div>
</form>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>