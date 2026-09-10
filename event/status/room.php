<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	
	$ave_day = $ev_date;
	
	$day_cnt = $conn->getOne("select count(*) from registration_tbl where login".$ave_day."='Y' and del='N' and member_level!='M' and classification not in ('C','M','Y')");
	
	

	$query = "select count(*) as Tcnt  ";
	$query .= " , sum(case when login_day".$ave_day.">0 and country='K' then 1 else 0 end) as login_cnt_K";
	$query .= " , sum(case when login_day".$ave_day.">0 and country='F' then 1 else 0 end) as login_cnt_F";
	$query .= " , sum(case when login_day".$ave_day.">0 and login_kind='P'  then 1 else 0 end) as login_Pcnt";
	$query .= " , sum(case when login_day".$ave_day.">0 and login_kind='M'  then 1 else 0 end) as login_Mcnt";
	foreach($_CONFIG['room'] as $tkey=>$tval){
		$query .= " , sum(case when room='$tkey' then 1 else 0 end) as Room".$tkey;

		$query .= " , sum(case when room='$tkey' and country='K' then 1 else 0 end) as RoomK".$tkey;
		$query .= " , sum(case when room='$tkey' and country='F' then 1 else 0 end) as RoomF".$tkey;
	}
	$query .= " , sum(case when room='H' then 1 else 0 end) as Hcnt";
	$query .= " , sum(case when room='S' then 1 else 0 end) as RS";
	$query .= " from registration_tbl where del='N' and member_level!='M' and classification not in ('C','M','Y')"; //
	$result = $conn->query($query);
	$result->fetchInto(&$cnt,DB_FETCHMODE_ASSOC);
	$result->free();


	$Days = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($ave_day-1), $ex_sdate[0]));
	
	
	if(stristr($_SERVER['REMOTE_ADDR'], '218.235.94.')) {
		$all_login = $conn->getOne("select count(sid) from registration_tbl where del='N' and login_day".$ave_day.">0");
		$m2_ip = true;
	}
?>
<link rel='stylesheet' type='text/css' href='/css/tree.css'/>
<script>
$(document).ready(function(){
	var reload = setInterval( function () {
		location.reload();
		
	}, 60000);
});
</script>
<div >
	<div class="btn" style="float:left;">
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
</div>
<div style="clear:both;"></div>
<div class="btn tp5" style="float:left;">
	<a href="/status/room.php?ev_date=<?=$ev_date?>" class="btnSky">ROOM 현황</a></li>
	<a href="/status/login_list.php?ev_date=<?=$ev_date?>" class="">Login 현황</a></li>
	<a href="/status/country_list.php?ev_date=<?=$ev_date?>" class="">국가별 현황</a></li>
</div>
<div style="clear:both;"></div>
<br />
<div>
	<?include "ave".$ev_date."_inc.php"?>
</div>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.footer.php';
?>