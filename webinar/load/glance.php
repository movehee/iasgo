<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<?
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	if(!$program_day) $program_day = $day;
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	
	$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($program_day-1), $ex_sdate[0]));
	
	$live_sid = array();
	$query = "select * from workshop_session_tbl where ev_date='$program_day' and unix_timestamp(concat('$to_date',' ',stime))<'".$_Time['ing']."' and unix_timestamp(concat('$to_date',' ',etime))>'".$_Time['ing']."'";
	$query .= " and room in ('1','3','5','9')";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		if($d['ev_date'] == "1" && $d['room'] == "6") continue; //예외처리
		if($d['sid'] == "167" || $d['sid'] == "174") continue; //예외처리

		if($d['sid']){
			$live_sid[] = ".live_".$d['sid']."_".$d['room'];
		}
	}

	$category_sql = "select td_class from workshop_schedule_tbl where td_class is not null and td_class!='' and td_class!='time' group by td_class";// and bsid='$program_day'
	$category_result=$conn->query($category_sql);
	if(DB::isError($category_result)) die($category_result->getMessage());
	while(is_array($e=$category_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$td_class_arr[] = $e['td_class'];
	}
?>
<script>
	$(function(){
		<?
		foreach($live_sid as $tkey=>$tval){
		$ex_live = explode("_",$tval);
		?>
		//$("<?=$tval?>").html("<span class=\"live\" style='cursor:pointer;' onclick=\"direct_room(<?=$ex_live[2]?>)\">On-Air</span>");
		//$("<?=$tval?>").html("<span class=\"btn\" style=\"cursor:pointer;\" ><a href=\"javascript:direct_room(<?=$ex_live[2]?>)\" class=\"onAir\">On-air</a></span>");
		// $("<?=$tval?>").html("<a class=\"live\" style='cursor:pointer;' onclick=\"direct_room(<?=$ex_live[2]?>)\">On-air</a>");
		$("<?=$tval?>").html("<a class=\"onair\" style='cursor:pointer;' onclick=\"direct_room_openner(<?=$ex_live[2]?>)\">On-air</a>");
		<?}?>

		$(".program").on("click", ".viewPopup", function() {
			var link = $(this).attr("href");
			link = "/program/" + link;
			$(".viewPopup").colorbox({iframe:true, overlayClose:true, href:link, transition:"fade", width:"1130", height:"600", top:"12%", speed:150});
		});
	});
</script>
<div class="popupWrap" id="popupProgram">
	
	<h1>Program at a Glance</h1>
		<div class="popupCon">
			<ul class="subMenu col5ea">
				<?
				for($date=1;$date<=$date_count;$date++){
					$date_txt = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));
				?>	
				<li style="width: 20%;"<?if($program_day==$date){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?program_day=<?=$date?>"><span>Day <?=$date?>.</span>  <?=Days_convert($date_txt,"M D (w)", "s")?></a></li>
				<?}?>
			</ul>


			
			<div class="programNote">
				* Click “PDF Download” button to see full size image.
			<a  href="https://virtual.kcr4u.org/KCR 2023_PAG.pdf" target="_blank">PDF Download</a>
			</div>

			<div class="glance scrollArea">
				<table class="tblDef program day<?=$program_day?>">
					<colgroup>
				 	<col style="width: 0;">
					<?php if($program_day == '1'):?> 
						<col style="width: 7%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
 						<col style="width: 9%;">
						<?php elseif($program_day == '2'):?> 
							<col style="width: 8%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 9%;">
						<?php elseif($program_day == '3'):?> 
						<col style="width: 7%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
 						<col style="width: 9%;">
						<?php else :?> 
						<col style="width: 8%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 11%;">
						<col style="width: 9%;">
					<?php endif;?>
				</colgroup>
					
					<tbody class="program">
						<?include $_SERVER['DOCUMENT_ROOT']."load/days/program.day".$program_day.".php";?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="close"><a class="color_close"></a></div>

<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>