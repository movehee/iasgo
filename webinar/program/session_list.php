<?include $_SERVER['DOCUMENT_ROOT']."include/include.header.php"?>
<?
	$ex_sdate = explode("-",$_Webinar['sdate']);
?>
<script>
	$(function() {
		$(".all_chk").on("click", function() {
			$(this).closest("ul").find(":checkbox:not(.all_chk)").attr("checked", false);

			search();
		});

		$(":checkbox[name='_r[]'], :checkbox[name='_d[]'], :checkbox[name='_g[]'], :checkbox[name='_c[]'], :checkbox[name='_l[]']").on("click", function() {

			$(this).closest("ul").find(".all_chk").prop("checked", false);
			search();
			
		});

			$(".iframe_vod").colorbox({iframe:true, transition:"fade", width:"1220", height:"900", top:"50", speed:150,closeButton:false});
		
	});

	function search() {

		//초기화
		$("table.session").hide();
		$("#no_result").hide();

		$("table.session").attr("r_chk", "0");
		$("table.session").attr("d_chk", "0");
		$("table.session").attr("g_chk", "0");
		$("table.session").attr("c_chk", "0");
		$("table.session").attr("l_chk", "0");
		//초기화


		if($(":checkbox[name='_r[]']:checked").length) {
			$(":checkbox[name='_r[]']").each(function() {
				if($(this).is(":checked")) {
					$("table.session[r='"+ $(this).val() +"']").attr("r_chk", "1");
				}
			});
		} else { //전체
			$(":checkbox[name='_r[]']").closest("ul").find(".all_chk").prop("checked", true);			
			$("table.session").attr("r_chk", "1");
		}

		if($(":checkbox[name='_d[]']:checked").length) {
			$(":checkbox[name='_d[]']").each(function() {
				if($(this).is(":checked")) {
					$("table.session[d='"+ $(this).val() +"']").attr("d_chk", "1");
				}
			});
		} else { //전체
			$(":checkbox[name='_d[]']").closest("ul").find(".all_chk").prop("checked", true);			
			$("table.session").attr("d_chk", "1");
		}

		if($(":checkbox[name='_g[]']:checked").length) {
			$(":checkbox[name='_g[]']").each(function() {
				if($(this).is(":checked")) {
					$("table.session[g='"+ $(this).val() +"']").attr("g_chk", "1");
				}
			});
		} else { //전체
			$(":checkbox[name='_g[]']").closest("ul").find(".all_chk").prop("checked", true);			
			$("table.session").attr("g_chk", "1");
		}

		if($(":checkbox[name='_c[]']:checked").length) {
			$(":checkbox[name='_c[]']").each(function() {
				if($(this).is(":checked")) {
					console.log( "table.session[c='"+ $(this).val() +"']" )
					$("table.session[c='"+ $(this).val() +"']").attr("c_chk", "1");
				}
			});
		} else { //전체
			$(":checkbox[name='_c[]']").closest("ul").find(".all_chk").prop("checked", true);			
			$("table.session").attr("c_chk", "1");
		}

		if($(":checkbox[name='_l[]']:checked").length) {
			$(":checkbox[name='_l[]']").each(function() {
				if($(this).is(":checked")) {
					$("table.session[l='"+ $(this).val() +"']").attr("l_chk", "1");
				}
			});
		} else { //전체
			$(":checkbox[name='_l[]']").closest("ul").find(".all_chk").prop("checked", true);
			$("table.session").attr("l_chk", "1");
		}
		
		$("table.session[r_chk='1'][d_chk='1'][g_chk='1'][c_chk='1'][l_chk='1']").show();


		if(!$("table.session:visible").length) {
			$("#no_result").show();
		}
	}
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

<div class="contents">
	<div class="program">
		<ul class="subMenu">
			<li ><a href="index.php?program_day=<?=$day?>">Program at a Glance</a></li>
			<li class="on"><a href="session_list.php">Scientific Program (VOD)</a></li>
		</ul>
		
		<div class="searchArea">
			<?
//				$_r = $_GET['_r'] ? $_GET['_r'] : array();
//				$_d = $_GET['_d'] ? $_GET['_d'] : array();
//				$_g = $_GET['_g'] ? $_GET['_g'] : array();
//
//				$_l = $_GET['_l'] ? $_GET['_l'] : array();
			?>
			<form id="searchF" name="searchF" action="<?=$PHP_SELF?>">
				<div class="bg">
					<input type="text" name="keyword" id="keyword" value="<?=stripslashes($keyword)?>" placeholder="Session Title, Speaker..">
					<input type="submit" value="Search">
					<input type="reset" onclick="location.href='/program/session_list.php'" value="Clear Search">
				</div>

				<dl class="sort">
					<dt><a href="#" class="trigger">SELECT AND VIEW CATEGORY OF YOUR CHOICE!</a></dt>
					<dd class="toggleCon">
						<dl>
							<dt>Room</dt>
							<dd>
								<ul>
									<li><input type="checkbox" class="all_chk" id="all_chk_r" value="Y" checked><label for="all_chk_r">All</label></li>
									<?php foreach($_Day['room_subtitle'] as $key => $val): ?>									
									<li><input type="checkbox" name="_r[]" id="_r<?=$key?>" value="<?=$key?>" ><label for="_r<?=$key?>"><?=$_Day['room_title'][$key]?></label></li>
									<?php endforeach;?>
								</ul>
							</dd>
						</dl>
						<dl>
							<dt>Date</dt>
							<dd>
								<ul>
									<li><input type="checkbox" class="all_chk" id="all_chk_d" value="Y" checked><label for="all_chk_d">All day</label></li>
									<?php for($i=0; $i<=3; $i++): $ii=$i+1;
										$_dd = strtotime("+$i days", strtotime($_Webinar['sdate'] ));	
									?>
									<li><input type="checkbox" name="_d[]" id="_d<?=$i?>" value="<?=$ii?>" ><label for="_d<?=$i?>">Day <?=$ii?>. <?=Days_convert($_dd,"M D (w)","s")?></label></li>
									<?php endfor;?>
								</ul>
							</dd>

							<dt>Specialty</dt>
							<dd>
								<ul>
									<li><input type="checkbox" class="all_chk" id="all_chk_g" checked><label for="all_chk_g">All</label></li>
									<?php foreach($_PROGRAM['gubun_code'] as $key => $val): ?>									
									<li><input type="checkbox" class="all_chk_g" name="_g[]" id="_g<?=$key?>" value="<?=$key?>"><label for="_g<?=$key?>"><?=$val?></label></li>
									<?php endforeach;?>
								</ul>
							</dd>

							<dt>Type</dt>
							<dd>
								<ul>
									<li><input type="checkbox" class="all_chk" id="all_chk_c" checked><label for="all_chk_c">All</label></li>
									<?php foreach($_PROGRAM['code_title'] as $key => $val): ?>									
									<li><input type="checkbox" class="all_chk_c" name="_c[]" id="_c<?=$val?>" value="<?=$val?>"><label for="_c<?=$val?>"><?=$val?></label></li>
									<?php endforeach;?>
								</ul>
							</dd>

							<dt>Language</dt>
							<dd>
								<ul>
									<li><input type="checkbox" class="all_chk" id="all_chk_l" checked><label for="all_chk_l">All</label></li>
									<li><input type="checkbox" class="all_chk_r" name="_l[]" id="_le" value="E"><label for="_le">English</label></li>
									<li><input type="checkbox" class="all_chk_r" name="_l[]" id="_lk" value="K"><label for="_lk">Korean</label></li>
								</ul>
							</dd>
						</dl>
					</dd>
				</dl>
			</form>
		</div>


		<?php
			$where_gubun = "AND ifnull(t1.hiding,'')!='Y'";

			// if($_GET['_r']) {
			// 	$where_gubun .= " AND room in (".implode(',', $_GET['_r']).")";
			// }

			// if($_GET['_d']) {
			// 	$where_gubun .= " AND ev_date in (".implode(',', $_GET['_d']).")";
			// }

			// if($_GET['_l']) {
			// 	$where_gubun .= " AND lang in ('".implode("','", $_GET['_l'])."')";
			// }


			// if($_GET['_g']) {
			// 	$where_gubun .= " AND part in ('".implode("','", $_GET['_g'])."')";
			// }


			$cnt_query = "select count(*) from workshop_session_tbl as t1 where del='N'" . $where_gubun;
			
			if($room){
				$cnt_query .= " and room='$room'";
			}
			if($keyword){
				$cnt_query .= " and ((code_title like '%$keyword%' or chair like '%$keyword%' or chair2 like '%$keyword%' or chair3 like '%$keyword%' or part like '%$keyword%' or part2 like '%$keyword%'or title like '%$keyword%')";
				$cnt_query .= " or (select count(*) from workshop_session_detail_tbl where session_sid=t1.sid and (title like '%$keyword%' or author like '%$keyword%' or author2 like '%$keyword%' or author_position_co like '%$keyword%' or pre_num like '%$keyword%' or invited_num like '%$keyword%'))>0)";
			}
			
			$total_cnt = $conn->getOne($cnt_query);
			
			
			$query = "select * from workshop_session_tbl as t1 where del='N'" . $where_gubun;
			if($room){
				$query .= " and room='$room'";
			}
			if($keyword){
				$query .= " and ((code_title like '%$keyword%' or chair like '%$keyword%' or chair2 like '%$keyword%' or chair3 like '%$keyword%'or part like '%$keyword%' or part2 like '%$keyword%' or title like '%$keyword%')";
				$query .= " or (select count(*) from workshop_session_detail_tbl where session_sid=t1.sid and (title like '%$keyword%' or author like '%$keyword%' or author2 like '%$keyword%' or author_position_co like '%$keyword%' or pre_num like '%$keyword%' or invited_num like '%$keyword%'))>0)";
			}
			$query .= " order by ev_date, stime asc, sort_num asc, room asc";
		
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			
			if($total_cnt>0){

			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				
				unset($chair_arr);

				if($d['chair']) $chair_arr[] = stripslashes($d['chair']);
				if($d['chair2']) $chair_arr[] = stripslashes($d['chair2']);
				if($d['chair3']) $chair_arr[] = stripslashes($d['chair3']);
				if($d['chair4']) $chair_arr[] = stripslashes($d['chair4']);


				// $to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['ev_date']-1), $ex_sdate[0]));

				$to_date = date('Y-m-d', strtotime($_Webinar['sdate']. ' + '.($d['ev_date']-1).' days'));

				//$chairs_aff = explode("|",$d['chair_position']);

				$room_sub = $conn->getOne("select title_sub from workshop_session_category where sid='".$d['room']."'");

				unset($On_air);
				if($d['room']=='1' || $d['room']=='3' || $d['room']=='5' || $d['room']=='9'){
					if(strtotime($to_date." ".$d['stime'])<=$_Time['ing'] && strtotime($to_date." ".$d['etime'])>=$_Time['ing']){
						$On_air ="Y";
					}
				}
		?>
		<!-- Room1 : type1 / Room2 : type2 / Room3 : type3 / Room4 : type4 / Room5 : type5 / Room6 : type6 / Room7 : type7 / Room8 : type8 / Room9 : type9 -->
		<table class="session type<?=$d['room']?>" r="<?=$d['room']?>" d="<?=$d['ev_date']?>" g="<?=$d['part']?>" c="<?=$d['code_title']?>" l="<?=$d['lang']?>" r_chk="0" d_chk="0" g_chk="0" c_chk="0" l_chk="0" >
			<colgroup>
				<col style="width: 10%;">
				<col style="width: auto;">
			</colgroup>
			<tbody>
				<tr class="sessionTit" id="tr_<?=$d['sid']?>">
					<th>
						<span><?=Days_convert($to_date,"M.D(w)","s")?></span>
						<?=$d['stime']."-".$d['etime']?>
					</th>
					<td>
						<span class="room" pub-room=" "> <?=$_Day['room_title'][$d['room']]?>
					
						</span>
						<span class="tit">
							<?=str_replace($keyword,"<span class='fcRed'>$keyword</span>",stripslashes($d['code_title']))?> (<?=$d['code']?>)
							<span class="type">
								

								<span class="<?=$_PROGRAM['lang_class'][$d['lang']]?>"><?=$_PROGRAM['lang_code'][$d['lang']]?></span>
								<?if($d['part']){?><span class="ch"><?=$d['part']?></span><?}?>
								<?if($d['difficulty']){?><span class="<?=$_PROGRAM['difficulty_code'][$d['difficulty']]?>"><?=$_PROGRAM['difficulty'][$d['difficulty']]?></span><?}?>
							</span>
						</span>
						<?=str_replace("$keyword","<span class='fcRed'>$keyword</span>",stripslashes($d['title']))?>

						<span class="util">
							<?if($On_air == 'Y' && $d['sid']!="167" && $d['sid']!="174") {?>
							<a href="javascript:direct_room(<?=$d['room']?>)" class="onair">On-Air</a>
							<?}?>

							<?if($d['vod']){?>
								<a href="javascript:popup_call('vod','session_sid=<?=$d['sid']?>')" class="vod">VOD</a>
							<?}?>

							<?php if(!in_array($d['sid'], $_No_eval)):?>
							<a href="/load/session_evaluation.php?session_sid=<?=$d['sid']?>" class="eval Load_Base" Wsize="1000" Hsize="800" Tsize="50">Session Evaluation</a>
							<?php endif;?>
						</span>
					</td>
				</tr>

				<?if($chair_arr){?>
				<tr class="chairs">
					<th>Chair<?if(count($chair_arr)>1){?>s<?}?></th>
					<td>
						<?=implode(", ",str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",$chair_arr))?>

						<span class="util">
							<?
							$session_favor_chk = $conn->getOne("select count(sid) from session_favor_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='".$d['sid']."'");
							?>
							<a href="javascript:session_favor('<?=$d['sid']?>','<?=$session_favor_chk ? 'del' : 'add'?>')" id="favor_btn<?=$d['sid']?>" class="favor<?if($session_favor_chk){?> on<?}?>">Session Favorite</a>
						</span>
					</td>
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

				
				
				while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))) {
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

				<tr>
					<th>
						<?if($detail['time_skip']!='Y'){?>
						<?=date("H:i",strtotime($set_time))?>-<?=$set_start?>
						<?}?>
					</th>
					<td>
						<span class="tit"><?=str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",stripslashes($detail['title']))?></span>
						
						<?
							if($author_arr){
								foreach($author_arr as $tkey=>$tval){
									echo "<div>".str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",$tval)."</div>";
								}

								if(stristr($_SERVER['REMOTE_ADDR'], '218.235.94.')) {
									echo $detail['pre_num'];
								}
							}
						?>

						<span class="util">
							<?if($detail['linkurl']){?>
								<a href="javascript:popup_call('vod','session_sid=<?=$detail['sid']?>')" class="vod">VOD</a>
							<?}?>
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
								<a href="javascript:popup_call('Azure','kind=detail_abs&sid=<?=$detail['sid']?>')" class="abstract">Lecture Note</a>
							<?}else{?>
								<?
									$faculty_abs = $conn->getOne("select faculty_abs from faculty_tbl where sid='$faculty_sid'");
									if($faculty_abs){
										?>
										<a href="javascript:popup_call('Azure','kind=faculty_abs&faculty_sid=<?=$faculty_sid?>')" class="abstract">Lecture Note</a>
										<?
									}
								?>
							<?}?>
						</span>
					</td>
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

		<?}?>


		<ul class="eposterList" id="no_result" style="display:none;">
			<li style="text-align:center;font-size:32px;color:#CC0000;margin-top:55px;">
				Search results not found. 
			</li>
		</ul>

		

	</div>
	<!-- //program -->
</div>

<?include $_SERVER['DOCUMENT_ROOT']."include/include.footer.php"?>