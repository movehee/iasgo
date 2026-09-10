<?include $_SERVER['DOCUMENT_ROOT']."include/include.header.php"?>

<?
	if(!$program_day) $program_day = $day;
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	
	$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($program_day-1), $ex_sdate[0]));
	
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		//echo date("Y-m-d H:i",$_Time['ing']);
	}
		
	$query = "select * from workshop_session_tbl where ev_date='$program_day' and unix_timestamp(concat('$to_date',' ',stime))<'".$_Time['ing']."' and unix_timestamp(concat('$to_date',' ',etime))>'".$_Time['ing']."'";
	$query .= " and room in ('1','3','5','9')";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

		//if($d['ev_date'] == "1" && $d['room'] == "6") continue; //예외처리
		//if($d['sid'] == "167" || $d['sid'] == "174") continue; //예외처리

		if($d['sid']){
			$live_sid[] = ".live_".$d['sid']."_".$d['room'];
		}
	}
	$category_sql = "select td_class from workshop_schedule_tbl where td_class is not null and td_class!='' and td_class!='time' and bsid='".$program_day."' group by td_class";
	$category_result=$conn->query($category_sql);
	if(DB::isError($category_result)) die($category_result->getMessage());
	while(is_array($e=$category_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$td_class_arr[] = $e['td_class'];
	}
	
?>
<script>

	


	$(document).ready(function(){

		// var tds = $(".glance .program").find("td:not(.time)");
		// tds.attr("lang_sel", 0);
		// tds.attr("cate_sel", 0);

		

		$('.p_category, .c_category').on('click',function(){

			var p = false, c = false;
			
			if($('.p_category').is(':checked')==false){
				$('#cate_allchk').prop('checked',true);
				// $(".glance .program").find("td").removeClass('off');			
				p = true;	
			}else{
				
				$('#cate_allchk').prop('checked',false);	
				$(".glance .program").find("td").not($(".glance .program").find('.time')).addClass('off');
				$('.p_category').each(function(pi,po){
					if($('.p_category').eq(pi).is(':checked')==true){
						td_class = po.value.replace(/\(/g,'');
						td_class = td_class.replace(/\)/g,'');
						td_class = td_class.replace(/\&/g,'');
						td_class = td_class.replace(/\s/g,'');
						$(".glance .program").find('.'+td_class).removeClass("off");
					}
				});
			}

			if($('.c_category').is(':checked')==false){

				$('#cate_allchk2').prop('checked',true);
				// $(".glance .program").find("td").removeClass('off');
				c = true;

			} else {

				$('#cate_allchk2').prop('checked',false);	
				$(".glance .program").find("td").not($(".glance .program").find('.time')).addClass('off');
				$('.c_category').each(function(pi,po){
					if($('.c_category').eq(pi).is(':checked')==true){
						td_class = po.value.replace(/\(/g,'');
						td_class = td_class.replace(/\)/g,'');
						td_class = td_class.replace(/\&/g,'');
						td_class = td_class.replace(/\s/g,'');
						$(".glance .program").find('.'+td_class).closest("td").removeClass("off");
					}
				});


			}

			if( p && c ) {
				$(".glance .program").find("td").removeClass('off');
			}

			// if($('.p_category').is(':checked')==false){
			// 	tds.attr("cate_sel", 1);
			// }else{
				
			// 	$('#cate_allchk').prop('checked',false);	

			// 	var cate = $(this).val();
			// 	var n = $(this).is(":checked") ? "1" : "0";
				
			// 	tds.each(function() {
			// 		if($(this).hasClass(cate)) {
			// 			$(this).attr("cate_sel", n);
			// 		}
			// 	});
			// }

			// g_dis();	
		});

		$('.c_category').on('click',function() {
		
			// if($('.c_category').is(':checked')==false){
			// 	tds.attr("lang_sel", 1);
			// } else {

			// 	$('#cate_allchk2').prop('checked',false);

			// 	var lang = $(this).val();
			// 	var n = $(this).is(":checked") ? "1" : "0";
				
			// 	tds.each(function() {
			// 		if($(this).find("." + lang).length) {						
			// 			$(this).attr("lang_sel", n);
			// 		}
			// 	});

				
			// }
			

			// $('.p_category').triggerHandler('click');

		});

		$('#cate_allchk').on('click',function(){
			if($(this).is(':checked')==true){
				$('.p_category').prop('checked',false);
				$('.p_category').triggerHandler('click');
			}
		});

		$('#cate_allchk2').on('click',function(){
			if($(this).is(':checked')==true){
				$('.c_category').prop('checked',false);
				$('.c_category').triggerHandler('click');
			}
		});
	});

	function g_dis() {
		var tds = $(".glance .program").find("td:not(.time)");
		tds.addClass('off');
		$(".glance .program td[cate_sel='1']").removeClass('off');
		$(".glance .program td[lang_sel='1']").removeClass('off');
	}

	function vod_play(sid){
		window.open("/play/index_vod.php?sid="+sid,"VOD","width=100%,height=700px;");
	}
	var live_session = "<?=$live_session?>";
	
</script>
<script>
	$(function(){
		<?
		if($live_sid) {
			foreach($live_sid as $tkey=>$tval){
			$ex_live = explode("_",$tval);
		?>
		
			$("<?=$tval?>").html("<a class=\"onair\" style='cursor:pointer;' onclick=\"direct_room(<?=$ex_live[2]?>)\">On-air</a>");
			<?}?>
		<?}?>
	});
	
</script>

<div class="contents">
	<div class="program">
		<ul class="subMenu">
			<li class="on"><a href="#">Program at a Glance</a></li>
			<li><a href="session_list.php">Scientific Program (VOD)</a></li>
		</ul>
		<ul class="conMenu">
			<?
			for($date=1;$date<=$date_count;$date++){
				$date_txt = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));
			?>	
			<li <?if($program_day==$date){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?program_day=<?=$date?>"><span>Day <?=$date?>.</span> <?=Days_convert($date_txt,"M D","s")?> (<?=Days_convert($date_txt,"w")?>)</a></li>
			<?}?>
		</ul>

		<div class="programNote">
			* Click “PDF Download” button to see full size image.
			<a  href="https://virtual.kcr4u.org/KCR 2023_PAG.pdf" target="_blank">PDF Download</a>
		</div>

		<div class="searchArea">
			<form id="" name="" action="" method="post">
				<fieldset>
					<legend>Sort</legend>

					<dl class="sort">
					<?if(count($td_class_arr)>0){?>
						<dt>SELECT AND VIEW CATEGORY OF YOUR CHOICE!</dt>
						<dd>
							<ul>
								<li><input type="checkbox" name="cate_allchk" id="cate_allchk" checked><label for="cate_allchk">ALL</label></li>
								<?foreach($td_class_arr as $tkey=>$tval){?>
								<li><input type="checkbox" name="<?=$tval?>" value="<?=$tval?>" id="<?=$tval?>" class="p_category"><label for="<?=$tval?>"><?=($tval=="HeadandNeck"?"Head and Neck":$tval)?></label></li>
								<?}?>
							</ul>
						</dd>
					<?}?>
					
						

						<dt>SELECT AND VIEW Session Language OF YOUR CHOICE!</dt>
						<dd>
							<ul>
								<li><input type="checkbox" name="cate_allchk2" id="cate_allchk2" checked><label for="cate_allchk2">ALL</label></li>
								<li><input type="checkbox" value="eng" id="c_category1" class="c_category"><label for="c_category1">English</label></li>
								<li><input type="checkbox" value="kor" id="c_category2" class="c_category"><label for="c_category2">Korean</label></li>
							</ul>
						</dd>
					</dl>
				</fieldset>
			</form>
		</div>
		<div class="glance">
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
				<thead>
				</thead>
				<tbody class="program">
					<?include $_SERVER['DOCUMENT_ROOT']."load/days/program.day".$program_day.".php";?>
				</tbody>
			</table>
			<ul class="abbreviation">
				<li><span class="fcRed">Interactive</span> : Interactive Sessions</li>
				<li><span>MDT</span>: Multidisciplinary Team Sessions</li> 
				<li><span>LS</span>: Luncheon Symposia</li>
				<li><span>MC</span>: Multisession Courses</li>
				<li><span>ISP</span>: Informal Scientific Presentations</li>
				<li><span>RC</span>: Refresher Courses</li>
				<li><span>SF</span> : Special Focus Sessions</li>
				<li><span>SS</span>: Scientific Sessions</li>
				<li><span>CBR</span>: Case-based Review</li>
			</ul>
		</div>
		<!-- //glance -->
	</div>
	<!-- //program -->
</div>
<script>
	$(".program").on("click", ".viewPopup", function() {
		$(".viewPopup").colorbox({iframe:true, overlayClose:true, transition:"fade", width:"1200", height:"600", top:"12%", speed:150});
	});
</script>
<?include $_SERVER['DOCUMENT_ROOT']."include/include.footer.php"?>