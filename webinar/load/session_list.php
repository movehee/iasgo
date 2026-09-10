<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<script>
	$(document).ready(function(){	
		//parent.$.colorbox.resize({width:948,height:497,top:100});
	});
</script>
<?
	if(!$program_day) $program_day = $day;

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($program_day-1), $ex_sdate[0]));
	
	$category_sql = "select td_class from workshop_schedule_tbl where td_class is not null and td_class!='' and bsid='$program_day' and td_class!='times' group by td_class";
	$category_result=$conn->query($category_sql);
	if(DB::isError($category_result)) die($category_result->getMessage());
	while(is_array($e=$category_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$td_class_arr[] = $e['td_class'];
	}
	
	

?>
<script>
	$(document).ready(function(){
		$('.p_category').on('click',function(){
			if($('.p_category').is(':checked')==false){
				$(".glance .program").find("td").removeClass('off');
			}else{
				$('#cate_allchk').prop('checked',false);	
				$(".glance .program").find("td").not($(".glance .program").find('.times')).not($(".glance .program tr td:first-child")).addClass('off');
				$('.p_category').each(function(pi,po){
					if($('.p_category').eq(pi).is(':checked')==true){
						$(".glance .program").find('.'+po.value).removeClass("off");
					}
				});
			}
		});
		$('#cate_allchk').on('click',function(){
			if($(this).is(':checked')==true){
				$('.p_category').prop('checked',false);
				$('.p_category').triggerHandler('click');
			}
		});
	});
</script>
<script>
var session_sid = "<?=$session_sid?>";
$(document).ready(function(){
	//$(".iframe").colorbox({iframe:true, width:"1100", height:"90%"});
	if(session_sid){
	var offset = $("#tr_"+session_sid).offset();
	$('html, body').animate({scrollTop : offset.top}, 400);
	}
});
</script>
<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet"> -->
<style>
table.program > * > tr > td {font-family: 'Noto Sans KR', sans-serif;font-weight: 300;font-size:14px;}
td p {margin: 0;}
td > br {display: none;}
</style>
<div class="popupWrap" id="popupProgram">
<h1>Program at a Glance</h1>
<div class="contents" style="width:98% !important;padding:10px;min-hieght:700px;">
	<div class="program">
		<!-- <ul class="subMenu">
			<li ><a href="index.php?program_day=<?=$day?>">Program at a Glance</a></li>
			<li class="on"><a href="session_list.php?program_day=<?=$day?>">Daily Program</a></li>
		</ul> -->
		
		<ul class="conMenu col3ea">
			<?
			for($date=1;$date<=$date_count;$date++){
				$date_txt = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));
			?>	
			<li <?if($program_day==$date){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?program_day=<?=$date?>">Day <?=$date?>, <?=Days_convert($date_txt,"M D (w), Y")?></a></li>
			<?}?>
		</ul>
		
		<div class="searchArea">
			<ul class="sort">
				<li <?if($room==""){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?program_day=<?=$program_day?>">All</a></li>
				<?
				$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
				$room_result=$conn->query($room_query);
				if(DB::isError($room_result)) die($room_result->getMessage());
				while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
				?>	
				<li <?if($room==$r['sid']){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?room=<?=$r['sid']?>&program_day=<?=$program_day?>" ><?=$r['title']?><span><?=$r['title_sub']?></span></a></li>
				<?}?>
				
			</ul>
			<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
			<input type="hidden" name="program_day" value="<?=$program_day?>">
			<input type="hidden" name="room" value="<?=$room?>">
				<fieldset>
					<legend>Search</legend>
					<input type="text" name="keyword" id="keyword" value="<?=$keyword?>" placeholder="Please enter a Name/ Lecture Title.">
					<input type="submit" value="Search">
				</fieldset>
			</form>
		</div>


		<?
			$cnt_query = "select count(*) from workshop_session_tbl as t1 where ev_date='$program_day' and del='N' ";
			if($room){
				$cnt_query .= " and room='$room'";
			}
			if($keyword){
				$cnt_query .= " and ((code_title like '%$keyword%' or chair like '%$keyword%' or chair2 like '%$keyword%' or chair3 like '%$keyword%' or part like '%$keyword%' or part2 like '%$keyword%'or title like '%$keyword%')";
				$cnt_query .= " or (select count(*) from workshop_session_detail_tbl where session_sid=t1.sid and (title like '%$keyword%' or author like '%$keyword%' or author2 like '%$keyword%' or author_position_co like '%$keyword%' or pre_num like '%$keyword%' or invited_num like '%$keyword%'))>0)";
			}
			$total_cnt = $conn->getOne($cnt_query);
			
			
			$query = "select * from workshop_session_tbl as t1 where ev_date='$program_day' and del='N' ";
			if($room){
				$query .= " and room='$room'";
			}
			if($keyword){
				$query .= " and ((code_title like '%$keyword%' or chair like '%$keyword%' or chair2 like '%$keyword%' or chair3 like '%$keyword%'or part like '%$keyword%' or part2 like '%$keyword%' or title like '%$keyword%')";
				$query .= " or (select count(*) from workshop_session_detail_tbl where session_sid=t1.sid and (title like '%$keyword%' or author like '%$keyword%' or author2 like '%$keyword%' or author_position_co like '%$keyword%' or pre_num like '%$keyword%' or invited_num like '%$keyword%'))>0)";
			}
			$query .= " order by stime asc, sort_num asc, room asc";
		
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			
			if($total_cnt>0){

			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				
				unset($chair_arr);

				if($d['chair']) $chair_arr[] = stripslashes($d['chair']);
				if($d['chair2']) $chair_arr[] = stripslashes($d['chair2']);
				if($d['chair3']) $chair_arr[] = stripslashes($d['chair3']);
				if($d['chair4']) $chair_arr[] = stripslashes($d['chair4']);

				//$chairs_aff = explode("|",$d['chair_position']);

				$room_sub = $conn->getOne("select title_sub from workshop_session_category where sid='".$d['room']."'");

				unset($On_air);
				if(strtotime($to_date." ".$d['stime'])<=$_Time['ing'] && strtotime($to_date." ".$d['etime'])>=$_Time['ing']){
					$On_air ="Y";
				}
		?>
		<table class="detail typeA">
			<colgroup>
				<col style="width: 8%;"> 
				<col style="*"> 
				<col style="width: 18%;"> 
			</colgroup>
			<tbody>

				<tr class="session" id="tr_<?=$d['sid']?>">
					<td colspan="3">
						<span class="tit">
							<?=str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",stripslashes($d['title']))?>
						</span>
						<span class="date"><?=Days_convert($to_date,"M.D (w)")?>, <?=$d['stime']."-".$d['etime']?></span>
						<span class="channel<?=$d['room']?>">
							<span>
								Channel <?=$d['room']?><br>
								(Vista Hall <?=$d['room']?>)
							</span>
						</span>
					</td>
				</tr>
				<?if($chair_arr){?>
				<tr class="sessionInfo">
					<td class="speaker">Chairperson<?if(count($chair_arr)>1){?>s<?}?></td>
					<td colspan="2"><?=implode(", ",str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",$chair_arr))?></td>
				</tr>
				<?}?>


				<?
				$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$d['sid']."' and del='N' ";
				if($keyword){
					$detail_query .= " and (title like '%$keyword%' or author like '%$keyword%' or author_position_co like '%$keyword%')";
				}
				$detail_query .= " order by sort_num asc";
				$detail_query .= $sort_sql;
				$detail_result=$conn->query($detail_query);
				if(DB::isError($detail_result)) die($detail_result->getMessage());

				$set_time = $ex_sdate_arr[0]." ".$d['stime'];


				
				while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))){	
					unset($author_arr);
					
					unset($pt_total_time);
					if($detail['pt_time']){
						$ex_pt = explode("/",$detail['pt_time']);
						$pt_total_time = $ex_pt[0]+$ex_pt[1];
						$set_start = date("H:i",strtotime("+".$pt_total_time." minutes",strtotime($set_time)));
					}

					$faculty_sid = $conn->getOne("select t2.sid from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.session_sid='".$d['sid']."' and t1.session_detail_sid='".$detail['sid']."'");

				
					$author_arr[] = $detail['author'].($detail['country']?" (".$detail['country'].")":"");
					if(trim($detail['author2'])) $author_arr[] = $detail['author2'].($detail['country2']?" (".$detail['country2'].")":"");
					if(trim($detail['author3'])) $author_arr[] = $detail['author3'].($detail['country3']?" (".$detail['country3'].")":"");
					if(trim($detail['author4'])) $author_arr[] = $detail['author4'].($detail['country4']?" (".$detail['country4'].")":"");
				?>
				<tr style="<?if($detail['bg_color']){?>background:<?=$detail['bg_color']?> !important;<?}?><?if($detail['font_color']){?>color:<?=$detail['font_color']?> !important;<?}?>">
					<td class="time">
					<?if($detail['time_skip']!='Y'){?>
					<?=date("H:i",strtotime($set_time))?>-<?=$set_start?>
					<?}?>
					</td>
					<td class="tit">
						<span class="tit"><?=str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",stripslashes($detail['title']))?></span>
						<?
							if($author_arr){
								foreach($author_arr as $tkey=>$tval){
									echo "<div>".str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",$tval)."</div>";
								}
							}
						?>

						<!-- <?if($detail['author']){?><?=str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",stripslashes($detail['author']))?><?}?>
						<?if($detail['country']){?> (<?=str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",stripslashes($detail['country']))?>)<?}?> -->
					</td>
					<td class="btn">
						<a href="javascript:alert('준비중')" class="lecture">Lecture Note</a>
						<a href="javascript:alert('준비중')" class="vod">VOD</a>
					</td>

					<!-- <td class="util">
						<?if($detail['cv_file']){?>
						<a href="javascript:popup_call('Azure','kind=detail_cv&sid=<?=$detail['sid']?>')" class="cv">CV</a>
						<?}else{?>
							<?
								$faculty_cv = $conn->getOne("select faculty_cv from faculty_tbl where sid='$faculty_sid'");
								if($faculty_cv){
									?>
									<a href="javascript:popup_call('Azure','kind=faculty_cv&faculty_sid=<?=$faculty_sid?>')" class="cv">CV</a>
									<?
								}
							?>
						<?}?>
						<?if($detail['abs_file']){?>
							<a href="javascript:popup_call('Azure','kind=detail_abs&sid=<?=$detail['sid']?>')" class="note">Lecture Syllabus</a>
						<?}else{?>
							<?
								$faculty_abs = $conn->getOne("select faculty_abs from faculty_tbl where sid='$faculty_sid'");
								if($faculty_abs){
									?>
									<a href="javascript:popup_call('Azure','kind=faculty_abs&faculty_sid=<?=$faculty_sid?>')" class="note">Abstract</a>
									<?
								}
							?>
						<?}?>
						<?if(stristr($_SERVER['REMOTE_ADDR'],'218.235.94')==true){?>
						<?if($detail['linkurl']){?>
							<a href="/load/play/vod.php?sid=<?=$detail['sid']?>" class="Load_Base cv"  Wsize='1220'  Hsize='820' Tsize='1%' >VOD</a>
						<?}?>
						<?}?>
					</td> -->

				</tr>
				<?
					if($detail['pt_time']){
						$set_time = $ex_sdate_arr[0]." ".$set_start;
					}
				}
				?>
				
			</tbody>
		</table>
		
		<?}?>
		<?}else{?>
		<ul class="eposterList">
			<li style="text-align:center;font-size:32px;color:#CC0000;margin-top:55px;">
				Search results not found. 
			</li>
		</ul>
		<?}?>

	</div>
	<!-- //program -->
	<div class="close"><a class="color_close"></a></div>
</div>
</div>

<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>