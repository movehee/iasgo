<?
	$Day_set = date("Y-m-d",$_Time['ing']);
	$Time_set = date("H:i:s",$_Time['ing']);
?>
<form name="time_setF" id="time_setF" method="post" action="/base_setting/time_set_reg.php">
	<div style="font-weight:bold;color:red;">아래 시간조정을 하시면 현재 시간이 설정한 시간으로 고정됩니다.</div>
	<div style="font-weight:bold;color:red;font-size:22px;">실제 서비스를 진행할 경우 "반드시" 사용함 체크를 풀어야 합니다.</div>
	<div class="tp20 multi">
		일자 : <input type="text" class="date" name="set_day" style="width:100px;" value="<?=$Day_set?>">
		시간 : <input type="text" class="timepicker" name="set_time" style="width:60px;" value="<?=$Time_set?>">분 으로 설정
		<input type="checkbox" name="time_set_use" value="Y" style="width:22px;height:22px;" <?if($_Time['use']==true){?>checked<?}?>>사용함
	</div>
	<div class="ac tp10"><span class="btnAdmin medium lightBlue" ><button type="button" -onclick="alert('사용불가')" onclick="$('#time_setF').submit()">적용하기</button></span></div>
</form>