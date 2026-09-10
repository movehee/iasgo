<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procLoginChk();
	
	if($_Time['ing']>strtotime('2021-04-24 18:00')){
		RefreshURL('room_vod.php');
	}

	if($_COOKIE['wmember_level']!='M'){
		if($_Day['room_start'][$day]>time()){
			PutMessageClose(date("Y-m-d H:i",$_Day['room_start'][$day])."부터 입장이 가능합니다.");
			exit;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>대한내과학회</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/player.css">
<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/player.js"></script>
<script type="text/javascript" src="/script/webinar.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
});
//]]>
</script>
<script>
$(document).ready(function(){
	var width = screen.width;
	var height = screen.height;
	window.resizeTo(width,height);
});
</script>
</head>
<body>
<div class="wrapper">
<?
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$ev_date = $day;

	$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($ev_date-1), $ex_sdate[0]));
	$to_date_unixtime = strtotime($to_date);
	$week_s = date('w',$to_date_unixtime);

	$conference_month = $_PROGRAM['Month_kor'][$ex_sdate[1]];
	$conference_day = $ex_sdate[2]+$ev_date;
	$conference_week = $_PROGRAM['days_kor'][$week_s];
	
	
	
?>

<div class="layerPopup" id="popupRoom" style="display: block;">

	<div class="koreaTime">
		<?=date("H:i",$_Time['ing'])?>
	</div>

	<div class="popupCon">
		<input type="hidden" id="befor_room" value="<?=$befor_room?>">
		<h1>2021년 대한내과학회 춘계학술대회</h1>
		<?if($_Time['ing']>strtotime("2021-04-24 17:00")){?>
			<p>세션이 종료되었습니다. 잠시뒤인 18시 부터는 초음파세션으로 변경되오니 세션종료를 하지 못하신 분들은 재입장하시어 세션종료 버튼을 클릭바랍니다.</p>
		<?}else{?>
			<?if($_Time['ing']<strtotime("2021-04-24 12:00")){?>
			<p>수련책임자 간담회는 지정된 회원만 접근가능합니다.</p>
			<p class="fcRed ac" style="font-size:22px;">보험정책단 아카데미 / Hospital Medicine 세션은 평점인정 참석시간에 포함되지 않습니다.</p>
			<?}else{?>
			<p>입장하실 강의실을 선택해주세요.</p>
			<?}?>
		<?}?>
		
		<div class="room">
			<?
			$ready_time = strtotime(date("Y-m-d H:i:s",$_Time['ing'])."+ 35 minutes");

			$room_chk = $conn->getOne("select count(*) from workshop_session_category where kind='P' and del='N'");

			if($room_chk>0){
				
				if(!$room) $room = $conn->getOne("select t1.sid from workshop_session_category as t1 left join workshop_session_tbl as t2 on t1.sid=t2.room where t1.kind='P' and t1.del='N' and t2.del='N' and t2.ev_date='$ev_date' group by t2.room limit 0,1");
			
				$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
				//echo $room_query;

				$room_result=$conn->query($room_query);
				if(DB::isError($room_result)) die($room_result->getMessage());
				while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
					//if($r['sid']==8) continue;
					$next_session = $conn->getOne("select count(*) from workshop_session_tbl where room='".$r['sid']."' and del='N' and ev_date='$ev_date' and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']."");
					
					$session_query = "select * from workshop_session_tbl where room='".$r['sid']."' and del='N' and ev_date='$ev_date'  ";
					if($next_session==0){// 미지막 세션일 경우
						$stand_time = strtotime(date("Y-m-d H:i:s",$_Time['ing'])."- 59 minutes");
						$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$stand_time." order by stime asc limit 0,1 ";
					}else{
						if($_COOKIE['wmember_level']=='M'){
							if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
								$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']." and unix_timestamp(concat('$to_date',' ',stime))<=".$ready_time." order by stime asc limit 0,1 ";
							}else{
								//$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']." order by stime asc limit 0,1 ";
								$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']." and unix_timestamp(concat('$to_date',' ',stime))<=".$ready_time." order by stime asc limit 0,1 ";
							}
							
						}else{
							$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']." and unix_timestamp(concat('$to_date',' ',stime))<=".$ready_time." order by stime asc limit 0,1 ";
							//$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']." order by stime asc limit 0,1 ";
						}
						
					}
					
					$session_result = $conn->query($session_query);
					$session_result->fetchInto(&$session,DB_FETCHMODE_ASSOC);
					$session_result->free();

					$ex_chair = explode('/',$session['chair']);

					$difficulty = $session['difficulty'];

					if(!$session['title']) continue;

					$start_time = $ex_sdate_arr[0]." ".$session['stime'];
					$end_time = $ex_sdate_arr[0]." ".$session['etime'];
					if($r['sid']=='5' || $r['sid']=='6'){
						//continue;
					}
			?>

			<div class="roomInfo <?if($befor_room==$r['sid']){?>active<?}?>">
				<h3>
					제<?=$r['title']?>
					<a href="index.php?room_sid=<?=$r['sid']?>">입장하기</a>
				</h3>


				<div class="bg">
					<dl>
						<dt>
							<span><?=stripslashes($session['title'])?></span>
							<!-- <?=date('m월 d일',$to_date_unixtime)?>(<?=$conference_week?>), <?=$session['stime']?>-<?=$session['etime']?><br> -->
							<?
								unset($chair_arr);
								if($ex_chair){
									//echo "좌장:";
									foreach($ex_chair as $tkey=>$tval){
										$chair_arr[] = $tval;
									}
									if($chair_arr) echo implode(", ",$chair_arr);
								}
							?>
						</dt>
						<dd>
							<ul>	
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
								?>
								<li>
									<span class="time"><?if($detail['pt_time']){?><?=date("H:i",strtotime($set_time))?> ~ <?=$set_start?><?}?></span>
									<span -class="tit" style="font-size:14px;"><?=stripslashes($detail['title'])?></span>
									<span -class="speaker"><?=$detail['author']?><?if($detail['author_co']){?> (<?=$detail['author_co']?>)<?}?></span>
								</li>
								<?
									if($detail['pt_time']){
										$set_time = $ex_sdate_arr[0]." ".$set_start;
									}
								}
								?>
							</ul>
						</dd>
					</dl>
				</div>
			</div>
			<?}?>
		</div>
		<?}?>

	</div>	
	<!-- //popupRoom -->


</div>	
</body>

</html>