<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	
	$ave_day = $ev_date;
	
	$day_cnt = $conn->getOne("select count(*) from registration_tbl where login".$ave_day."='Y' and member_level!='M' and del='N'");

	$query = "select count(*) as Tcnt  ";
	$query .= " , sum(case when login_day".$ave_day.">0 then 1 else 0 end) as login_cnt";
	$query .= " , sum(case when room='1' then 1 else 0 end) as Room1";
	$query .= " , sum(case when room='2' then 1 else 0 end) as Room2";
	$query .= " , sum(case when room='3' then 1 else 0 end) as Room3";
	$query .= " , sum(case when room='4' then 1 else 0 end) as Room4";
	$query .= " , sum(case when room='5' then 1 else 0 end) as Room5";
	$query .= " , sum(case when room='6' then 1 else 0 end) as Room6";
	$query .= " , sum(case when room='7' then 1 else 0 end) as Room7";
	$query .= " , sum(case when room='8' then 1 else 0 end) as Room8";
	$query .= " , sum(case when room='H' then 1 else 0 end) as Hcnt";
	$query .= " , sum(case when room='S' then 1 else 0 end) as RS";
	$query .= " from registration_tbl where del='N' and member_level!='M'";
	$result = $conn->query($query);
	$result->fetchInto(&$cnt,DB_FETCHMODE_ASSOC);
	$result->free();
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

<br />
<div style="width:100%;">
	<table style="width:100%;" class="ac">
		<tr>
			<td>
				<div style="border:2px solid #6E7C87;height:100px;width:250px;">
					<div style="font-size:22px;text-align:left;padding:10px;"><span style='color:red;'>[LIVE]</span> <b>ROOM A</b></div>
					<div style="font-size:22px;text-align:left;padding-left:10px;">
						현재 <?=number_format($Room1)?>명 시청 중
					</div>
				</div>
			</td>
			<td class="lp30">
				<div style="border:2px solid #6E7C87;height:100px;width:250px;">
					<div style="font-size:22px;text-align:left;padding:10px;"><span style='color:red;'>[LIVE]</span> <b>ROOM B</b></div>
					<div style="font-size:22px;text-align:left;padding-left:10px;">
						현재 <?=number_format($Room2)?>명 시청 중
					</div>
				</div>
			</td>
			<td class="lp30">
				<div style="border:2px solid #6E7C87;height:100px;width:250px;">
					<div style="font-size:22px;text-align:left;padding:10px;"><span style='color:red;'>[LIVE]</span> <b>ROOM C</b></div>
					<div style="font-size:22px;text-align:left;padding-left:10px;">
						현재 <?=number_format($Room3)?>명 시청 중
					</div>
				</div>
			</td>
			<td class="lp30">
				<div style="border:2px solid #6E7C87;height:100px;width:250px;">
					<div style="font-size:22px;text-align:left;padding:10px;"><span style='color:red;'>[LIVE]</span> <b>ROOM D</b></div>
					<div style="font-size:22px;text-align:left;padding-left:10px;">
						현재 <?=number_format($Room4)?>명 시청 중
					</div>
				</div>
			</td>
		</tr>
		<tr><td height=50></td></tr>
		<tr >
			<td>
				<div style="border:2px solid #6E7C87;height:100px;width:250px;">
					<div style="font-size:22px;text-align:left;padding:10px;"><span style='color:red;'>[LIVE]</span> <b>ROOM E</b></div>
					<div style="font-size:22px;text-align:left;padding-left:10px;">
						현재 <?=number_format($Room5)?>명 시청 중
					</div>
				</div>
			</td>
			<td class="lp30">
				<div style="border:2px solid #6E7C87;height:100px;width:250px;">
					<div style="font-size:22px;text-align:left;padding:10px;"><span style='color:red;'>[LIVE]</span> <b>ROOM F</b></div>
					<div style="font-size:22px;text-align:left;padding-left:10px;">
						현재 <?=number_format($Room6)?>명 시청 중
					</div>
				</div>
			</td>
			<td class="lp30">
				<div style="border:2px solid #6E7C87;height:100px;width:250px;">
					<div style="font-size:22px;text-align:left;padding:10px;"><span style='color:red;'>[LIVE]</span> <b>ROOM G</b></div>
					<div style="font-size:22px;text-align:left;padding-left:10px;">
						현재 <?=number_format($Room7)?>명 시청 중
					</div>
				</div>
			</td>
			<td class="lp30">
				<div style="border:2px solid #6E7C87;height:100px;width:250px;">
					<div style="font-size:22px;text-align:left;padding:10px;"><span style='color:red;'>[LIVE]</span> <b>ROOM H</b></div>
					<div style="font-size:22px;text-align:left;padding-left:10px;color:">
						현재 <?=number_format($Room8)?>명 시청 중
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.footer.php';
?>