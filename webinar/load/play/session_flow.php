<?
include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
?>
<style>
.flicker {display: inline-block;animation-duration:1s;animation-name:flicker; animation-iteration-count: infinite;}
@keyframes flicker {
	0% {opacity:0;}
	50% {opacity:1;}
	100% {opacity:0;}
}
</style>
<dl class="programInfo " style="padding-top:0px;">
<?$session_yn="N";?>
<?
	if($room_sid) $room=$room_sid;

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$ev_date = $day;

	$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($ev_date-1), $ex_sdate[0]));
	$to_date_unixtime = strtotime($to_date);
	$week_s = date('w',$to_date_unixtime);

	$conference_month = $_PROGRAM['Month_eng'][$ex_sdate[1]];
	$conference_day = $ex_sdate[2]+$ev_date;
	$conference_week = $_PROGRAM['days_eng'][$week_s];
?>
<!-- <div style="font-size:17px;color:#ffffff;padding-bottom:10px;"> - <?=$room?>회의장</div> -->
<?foreach($_TIME['session'][$day][$room] as $tkey=>$tval){
	
	if(strtotime($tval[0])<=$_Time['ing'] && strtotime($tval[1])>=$_Time['ing']){
		$session = $tkey;
		$session_yn="Y";
	}else{
		if($tkey=='N'){
			//continue;
		}
	}

	$pre_time = trim(substr($tval[0],10,6))."~".trim(substr($tval[1],10,6));
?>
<dt style="padding-left:0px;border-top:1px solid #F6F6F6;padding-top:5px;padding-bottom:2px;">
	<span style="font-size:15px;color:#ffffff;width:190px;">
		<b style="font-weight:normal;color:<?if($session==$tkey){?>yellow;<?}else{?>#ffffff<?}?>;width:190px;">
		<?
			if($tkey=='S'){
				echo "필수교육 [".$pre_time."]";
			}else if($tkey=='N' || $tkey=='N2'){
				echo $tval[4]." [".$pre_time."]";
			}else{
				echo "세션 ".$tkey." [".$pre_time."]";
			}
			
		?>
		</b>
	</span>
	<?if(strtotime($tval[0])<=$_Time['ing'] && strtotime($tval[1])>=$_Time['ing']){?>
	<div style="padding-bottom:10px;padding-top:5px;">
	<?foreach($_TIME['session_detail'][$day][$room] as $skey=>$sval){?>
		<?
			//echo '<b style="color:#ffffff;">'.$tval[1].'='.$sval[0].'</b><br />';
			if(strtotime($tval[0])>strtotime($sval[0])) continue;
			if(strtotime($tval[1])<=strtotime($sval[0])) continue;
		?>
		<?if(strtotime($sval[0])<=$_Time['ing'] && strtotime($sval[1])>=$_Time['ing']){?>
			<div  style="clear:both;color:orange;font-size:12px;padding-bottom:5px;">
				<div>[<?=trim(substr($sval[0],10,6))."~".trim(substr($sval[1],10,6))?>]</div>
				<div style="padding-left:5px;">- <?=$skey?></div>
				<?if($sval[3]){?><div style="text-align:right;"><?=$sval[3]?></div><?}?>
			</div>
		<?}else{?>
			<div style="clear:both;color:#ffffff;font-size:12px;padding-bottom:5px;">
				<div>[<?=trim(substr($sval[0],10,6))."~".trim(substr($sval[1],10,6))?>]</div>
				<div style="padding-left:5px;">- <?=$skey?></div>
				<?if($sval[3]){?><div style="text-align:right;"><?=$sval[3]?></div><?}?>
			</div>
		<?}?>
	<?}?>
	</div>
	<?}?>
</dt>
<?
}
if($session_yn=='N'){
?>
<!-- <div style="clear:both;color:orange;font-size:13px;padding-bottom:5px;font-size:25px;text-align:center;"><i class="fas fa-arrow-up"></i><br /><b class="flicker" >세션 퇴장/입장을<br>클릭해주세요.</b></div> -->
<?
}
?>
</dl>