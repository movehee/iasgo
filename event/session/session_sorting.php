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
	
	$room_cnt = $conn->getOne("select * from workshop_session_category where kind='P' and del='N'");
	
	if($room_cnt>0){
		$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
		$room_result=$conn->query($room_query);
		if(DB::isError($room_result)) die($room_result->getMessage());
		while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
			$room_sid[] = $r['sid'];
			$room_name[$r['sid']] = $r['title'];
		}
	}
	
?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script>
	$(function(){
		$(".sort_table").tableDnD({ 
			//드래그 기능이 동작하는 동안 특정 CLASS를 드래그하는 TR에 적용해준다. 
			onDragStyle : 'dragRow2', 
			onDropStyle : 'dragRow2', 
			onDragClass: 'dragRow2',
			onDragStart: function(table, row){ 
				onDragClass: 'dragRow';
			},
			onDrop: function(table, row){ 
				var rows = table.tBodies[0].rows;
				var debugStr = "";
				var debugStr = new Array();
				for (var i=0; i<rows.length; i++) {
					//debugStr += rows[i].id + "||"; 
					debugStr[i] = rows[i].id; 
				}
				var join_sort = debugStr.join(",");
				
				$.ajax({
					type:"POST",
					url:"/session/session_sorting_reg.php",
					data:"sort_val="+join_sort,
					cache:false,
					async:false,
					success:function(msg){
						if(msg!='Y'){
							alert("Error.");
						}
					}
				});
			}
		});
	});
	function default_sort(chkday){
		if(confirm("룸 순서, 시간순으로 기본설정 하시겠습니까?")){
			$.ajax({
				type:"POST",
				url:"/session/session_sorting_reg.php",
				data:"chkday="+chkday,
				cache:false,
				async:false,
				success:function(msg){
					if(msg!='Y'){
						alert("Error.");
					}else{
						alert("기본셋팅 되었습니다.");
						location.reload();
					}
				}
			});
		}
	}
</script>
<style>
	.dragRow{border:2px solid red !important;}
	.dragRow2{background:#f1ff44 !important;}
	.dragRow3{background:#FFA042 !important;}
	.dragRow_role{border:2px solid red !important;}
	.dragRow2_role{background:#EA6C55 !important;color:#ffffff;}

	#product {
		counter-reset: rowNumber;
	}
	.numberic:after {
		counter-increment: rowNumber;
		content: counter(rowNumber);
	}
	td.iconMove {}
	td.iconMove:before {display: inline-block;font-size: 20px;font-family: "Font Awesome 5 Free" !important;font-weight: 900;content: "\f0b2";}
</style>
<div >
	<div class="btn" style="float:left;">
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=all" <?if($ev_date=='all'){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i>ALL</a></li>
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" class="<?if($ev_date==$date){?>btnRed<?}else{?>btnBdGrey<?}?>"><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>

	
</div>
<?
	/*$room_chk = $conn->getOne("select count(*) from workshop_session_category where kind='P' and del='N'");
	if($room_cnt>0){
		if(!$room){
			//$room = $conn->getOne("select t1.sid from workshop_session_category as t1 left join workshop_session_tbl as t2 on t1.sid=t2.room where t1.kind='P' and t1.del='N' and t2.del='N' and t2.ev_date='$ev_date' group by t2.room limit 0,1");
			$rquery = "select t1.sid from workshop_session_category as t1 left join workshop_session_tbl as t2 on t1.sid=t2.room where t1.kind='P' and t1.del='N' and t2.del='N'  ";
			if($ev_date!='all'){
				$rquery .= " and t2.ev_date='$ev_date'";
			}
			$rquery .= " group by t2.room limit 0,1";
			$room = $conn->getOne($rquery);
		}
	}*/
?>

<div class="ar">
	<div class="btn bp5" style="float:right;">
		<a href="index.php?ev_date=<?=$ev_date?>" class="btnSky withIcon"><i class="fa fa-backward" style="font-size:15px;padding-top:0px;"></i>리스트로 돌아가기</a>
	</div>
</div>

<div style="clear:both;">
	<div class="fcRed tp10 bp10" style="font-weight:bold;font-size:18px;">
		☆ 순서를 변경하시면 일자별 프로그램 리스트 페이지에 반영됩니다.
		<div class="btn bp5" style="float:right;">
			<a href="javascript:default_sort('<?=$ev_date?>')" class="btnPoint withIcon"><i class="fa fa-sort" style="font-size:15px;padding-top:0px;"></i>룸/시간순으로 기본셋팅</a>
		</div>
	</div>
	
</div>
<?
	
	$query = "select * from workshop_session_tbl where del='N' ";
	if($room) $query .= " and room='$room'";
	if($ev_date!='all'){
		$query .= " and ev_date='$ev_date'";
	}
	$query .= " order by sort_num asc, ev_date asc, room asc, stime asc";
	
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>

<table class="tblDef sort_table">
	<colgroup>
		<col style="width: 8%;">
		<col style="width: 14%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 4%;">
		<col style="width: 4%;">
		<col style="">
		<!-- <col style="width: 20%;"> -->
		<col style="width: 60px;">
	</colgroup>
	<thead>

		<tr>
			<th style="background:#263238;color:#ffffff;">시간</th>
			<th style="background:#263238;color:#ffffff;">구분</th>
			<th style="background:#263238;color:#ffffff;">상세구분</th>
			<th style="background:#263238;color:#ffffff;">장소</th>
			<th style="background:#263238;color:#ffffff;">코드</th>
			<th style="background:#263238;color:#ffffff;">언어</th>
			<th style="background:#263238;color:#ffffff;">세션 명</th>
			<!-- <th style="background:#263238;color:#ffffff;">좌장</th> -->
			<th style="background:#263238;color:#ffffff;">Sort</th>
		</tr>
	</thead>
	<tbody id="product">
		<?
		$ev_num = 0;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

			$start_time = $ex_sdate_arr[0]." ".$d['stime'];
			$end_time = $ex_sdate_arr[0]." ".$d['etime'];
			
			unset($stay_time);
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
			
			if($d['session_file']){
				$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/session/" . $d["session_file"]) . "&filename=" . base64_encode($d["session_realfile"]);
			}

			unset($chair_arr);
			if($d['chair']) $chair_arr[] = $d['chair'];
			if($d['chair2']) $chair_arr[] = $d['chair2'];
			if($d['chair3']) $chair_arr[] = $d['chair3'];
			if($d['chair4']) $chair_arr[] = $d['chair4'];
		?>
		<tr id="<?=$d['sid']?>" >
			<th style="background:#445964;color:#ffffff;" ><?=$d['stime']?> ~ <?=$d['etime']?></th>
			<th style="background:#445964;color:#ffffff;" ><?=$d['part']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$d['part2']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$room_name[$d['room']]?></th>
			<th style="background:#445964;color:#ffffff;"><?=$d['code']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$_PROGRAM['lang_code'][$d['lang']]?></th>
			<th style="text-align:left;background:#445964;color:#ffffff;font-size:13px;">
				<div style="float:left;">
				<?=stripslashes($d['title'])?>
				<?if($d['logo_file']){?><img src="/upload/session/<?=$d['logo_file']?>"><?}?>
				<?if($d['session_file']){?><img src="<?=IconType3($d['session_file'])?>" onclick="location.href='/func/download.php?<?=$queryString?>'"class="hand"><?}?>
				</div>
			</th>
			<!-- <th style="background:#445964;color:#ffffff;font-size:11px;" class="ar">
				<?
				if(count($chair_arr)>0){
					echo implode("<br />",$chair_arr);
				}
				?>
			</td> -->
			<td class="ac iconMove">
				<input type="hidden" name="que_number[]" class="que_number" value="<?=$i?>" style="width:20px;">
			</td>
		</tr>
		
		<?}?>
	</tbody>
</table>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>