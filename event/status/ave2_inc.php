<?
if($Days != date('Y-m-d')) {
	unset($cnt['Room1']);
	unset($cnt['Room2']);
	unset($cnt['Room3']);
	unset($cnt['Room4']);
	unset($cnt['Room5']);
	unset($cnt['Room6']);
	unset($cnt['Room7']);
	unset($cnt['Room8']);
	unset($cnt['Room9']);

	unset($cnt['RoomK1']);
	unset($cnt['RoomK2']);
	unset($cnt['RoomK3']);
	unset($cnt['RoomK4']);
	unset($cnt['RoomK5']);
	unset($cnt['RoomK6']);
	unset($cnt['RoomK7']);
	unset($cnt['RoomK8']);
	unset($cnt['RoomK9']);

	unset($cnt['RoomF1']);
	unset($cnt['RoomF2']);
	unset($cnt['RoomF3']);
	unset($cnt['RoomF4']);
	unset($cnt['RoomF5']);
	unset($cnt['RoomF6']);
	unset($cnt['RoomF7']);
	unset($cnt['RoomF8']);
	unset($cnt['RoomF9']);

	unset($cnt['login_Pcnt']);
	unset($cnt['login_Mcnt']);
}
?>
<span class="box">
	<div class="avatar" style="width:100%;height:60px;background:#E49F7E;left:-10px;">
		<table style="width:100%;height:57px;">
			<tr>
				<td class="ac" style="font-size:23px;font-weight:bold;width:30%;"><i>전체인원 <i> : <?=$cnt['Tcnt']?> 명</td>
				<td class="ac" style="font-size:23px;font-weight:bold;width:30%;"><i>강의장 입장가능 <i> : <?=$day_cnt?> 명</td>
				<td class="ac" style="font-size:23px;font-weight:bold;width:30%;"><i>현재시간 : <?=date("m월 d일 H시 i분",time())?></i></td>
			</tr>
		</table>
	</div>
</span>
<br />
<center>
<div style="border:2px solid #6E7C87;height:<? if($m2_ip) {?>140<?}else{?>100<?}?>px;width:98%;">
	<div class="ac" style="font-size:35px;text-align:left;padding:17px;">
		<div style="float:left;padding-left:80px;font-weight:bold;">LOGIN :  <?=number_format($cnt['login_cnt_K']+$cnt['login_cnt_F'])?>명 (국내:<?=number_format($cnt['login_cnt_K'])?>/국외:<?=number_format($cnt['login_cnt_F'])?>)
			<? if($m2_ip) {?>
				<br>전체로그인 : <?=$all_login?>
			<?}?>
		</div>

		<div style="float:right;padding-right:100px;font-weight:bold;">PC :  <?=number_format($cnt['login_Pcnt'])?>명 / 
		MOBILE :  <?=number_format($cnt['login_Mcnt'])?>명</div>
	</div>
</div>
<br />
<div style="width:98%;padding-top:10px;">
	<table style="width:100%;padding:0px;margin:0px;" class="ac" >
		<tr>
			<?foreach($_CONFIG['room'] as $tkey=>$tval){
				if($tkey!='1'  && $tkey!='3' && $tkey!='5' ) continue;?>
			<td>
				<center>
				<div style="border:2px solid #6E7C87;height:190px;width:400px;padding:30px;">
					<div style="font-size:40px;text-align:center;padding:10px;"><span style='color:red;'>[LIVE]</span> <?=$_Day['room_title'][$tkey]?></b></div>
					<div style="font-size:24px;text-align:center;padding-left:10px;color:#676767;font-weight:bold;">
						현재 <?=number_format($cnt['Room'.$tkey])?> 명 시청 중
						<br/><?=number_format($cnt['RoomK'.$tkey])?>/<?=number_format($cnt['RoomF'.$tkey])?>
					</div>
				</div>
				</center>
			</td>
			<?if($tval=='4') echo "</tr><tr><td height=50></td></tr><tr>";?>
			<?}?>
		</tr>
	</table>
</div>